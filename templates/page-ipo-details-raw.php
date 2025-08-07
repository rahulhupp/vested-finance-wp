<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow" />
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/templates/css-ipo-details-params.css" type="text/css" media="all" />
</head>
<body <?php body_class(); ?>>

<?php
$ipo_id = get_query_var('ipo_id');
$ipo_name = get_query_var('ipo_name');

// Helper function to format dates in "April 22nd, 2025" format
function format_date_with_ordinal($date_string) {
    if (empty($date_string) || $date_string === 'N/A') {
        return 'N/A';
    }
    
    $timestamp = strtotime($date_string);
    if ($timestamp === false) {
        return $date_string;
    }
    
    $day = date('j', $timestamp);
    $month = date('F', $timestamp);
    $year = date('Y', $timestamp);
    
    // Add ordinal suffix to day
    $ordinal = '';
    if ($day >= 11 && $day <= 13) {
        $ordinal = 'th';
    } else {
        switch ($day % 10) {
            case 1: $ordinal = 'st'; break;
            case 2: $ordinal = 'nd'; break;
            case 3: $ordinal = 'rd'; break;
            default: $ordinal = 'th'; break;
        }
    }
    
    return $month . ' ' . $day . $ordinal . ', ' . $year;
}

// Helper function to render funding rounds content
function render_funding_rounds($funding_rounds_data) {
    if ($funding_rounds_data && !empty($funding_rounds_data['items'])) {
        foreach ($funding_rounds_data['items'] as $round) {
            $round_name = esc_html($round['roundName']);
            $issued_at = '';
            $issue_price = '';

            // Find the maximum issue price and the corresponding issuedAt in shareDetails
            if (!empty($round['shareDetails']) && is_array($round['shareDetails'])) {
                $max_issue_price = null;
                $max_issued_at = '';
                foreach ($round['shareDetails'] as $share) {
                    if (isset($share['issuePrice']) && (is_null($max_issue_price) || $share['issuePrice'] > $max_issue_price)) {
                        $max_issue_price = $share['issuePrice'];
                        $max_issued_at = !empty($share['issuedAt']) ? $share['issuedAt'] : $max_issued_at;
                    }
                }
                if (!is_null($max_issue_price)) {
                    $issue_price = '$' . number_format($max_issue_price, 2);
                }
                if (!empty($max_issued_at)) {
                    $issued_at = format_date_with_ordinal($max_issued_at);
                }
            }

            // Fallback to round-level data if share details not available
            if (empty($issue_price) && !empty($round['issuePrice'])) {
                $issue_price = '$' . number_format($round['issuePrice'], 2);
            }
            if (empty($issued_at) && !empty($round['issuedAt'])) {
                $issued_at = format_date_with_ordinal($round['issuedAt']);
            }
            ?>
            <div class="funding_round">
                <div class="funding_round_info">
                    <h4><?php echo $round_name; ?></h4>
                </div>
                <div class="funding_amount">
                    <strong><?php echo $issue_price ?: '0'; ?></strong>
                    <span class="funding_date"><?php echo $issued_at ?: ''; ?></span>
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="funding_round">
            <div class="funding_round_info">
                <h4>No funding rounds data available</h4>
            </div>
        </div>
        <?php
    }
}

global $wpdb;
$table_name = $wpdb->prefix . 'ipo_list';
$ipo = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE ipo_id = %s", $ipo_id));

// Get key information from database instead of API calls
$api_valuation = 'N/A';
$api_management_fee = 'N/A';
$api_funding_deadline = 'N/A';
$api_min_commitment = 'N/A';
$api_notable_investors = array();
$api_share_type = 'N/A';
$api_share_class = 'N/A';
$api_price_per_share = 'N/A';
$api_transaction_type = 'N/A';
$api_investor_price_per_share = 'N/A';
$api_investor_fee_per_share = 'N/A';
$api_all_in_price_per_share = 'N/A';

// Use database values if available
if ($ipo) {
    if (!empty($ipo->api_valuation)) {
        $api_valuation = $ipo->api_valuation;
    }
    if (!empty($ipo->api_management_fee)) {
        $api_management_fee = $ipo->api_management_fee;
    }
    if (!empty($ipo->api_funding_deadline)) {
        $api_funding_deadline = $ipo->api_funding_deadline;
    }
    if (!empty($ipo->api_min_commitment)) {
        $api_min_commitment = $ipo->api_min_commitment;
    }
    if (!empty($ipo->api_notable_investors)) {
        $api_notable_investors = json_decode($ipo->api_notable_investors, true);
    }
    if (!empty($ipo->api_share_type)) {
        $api_share_type = $ipo->api_share_type;
    }
    if (!empty($ipo->api_share_class)) {
        $api_share_class = $ipo->api_share_class;
    }
    if (!empty($ipo->api_price_per_share)) {
        $api_price_per_share = $ipo->api_price_per_share;
    }
    if (!empty($ipo->api_transaction_type)) {
        $api_transaction_type = $ipo->api_transaction_type;
    }
    if (!empty($ipo->api_investor_price_per_share)) {
        $api_investor_price_per_share = $ipo->api_investor_price_per_share;
    }
    if (!empty($ipo->api_investor_fee_per_share)) {
        $api_investor_fee_per_share = $ipo->api_investor_fee_per_share;
    }
    if (!empty($ipo->api_all_in_price_per_share)) {
        $api_all_in_price_per_share = $ipo->api_all_in_price_per_share;
    }
}

// Fetch funding rounds data from database
$funding_rounds_data = null;
if ($ipo && !empty($ipo->api_funding_rounds_data)) {
    $funding_rounds_data = json_decode($ipo->api_funding_rounds_data, true);
}

// Get dynamic data from database instead of API calls
$news_data = null;
$research_data = null;
$documents_data = null;

if ($ipo) {
    // Get news data from database
    if (!empty($ipo->api_news_data)) {
        $news_data = json_decode($ipo->api_news_data, true);
    }
    
    // Get research data from database
    if (!empty($ipo->api_research_data)) {
        $research_data = json_decode($ipo->api_research_data, true);
    }
    
    // Get documents data from database
    if (!empty($ipo->api_documents_data)) {
        $documents_data = json_decode($ipo->api_documents_data, true);
    }
}

// Check if we have investors data for investment functionality
$has_investors_data = !empty($api_notable_investors) || $api_valuation !== 'N/A' || $api_min_commitment !== 'N/A';

$request_callback_url = "https://api.whatsapp.com/send?phone=919321712688&text=I%20want%20to%20learn%20more%20about%20investing%20in%20Pre-IPO%20companies.%20Please%20give%20me%20a%20callback";
?>
<div class="ipo_main">
	<div class="container">
		<div class="ipo_main_wrapper">
			<div class="ipo_content">
				<div class="ipo_header">
					<?php if (!empty($ipo->logo_url)): ?>
					<div class="ipo_logo">
						<div class="ipo_logo_wrapper">
								<img src="<?php echo esc_url($ipo->logo_url); ?>" alt="<?php echo esc_attr($ipo->name ?? 'IPO'); ?>" />
							</div>
						</div>
					<?php endif; ?>
					<div class="ipo_header_content">
						<div class="ipo_meta">
							<h1><?php echo esc_attr($ipo->name ?? 'IPO'); ?></h1>
							<div class="ipo_meta_list">
								<div class="ipo_meta_item">
									<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M13.3327 6.66683C13.3327 10.6668 7.99935 14.6668 7.99935 14.6668C7.99935 14.6668 2.66602 10.6668 2.66602 6.66683C2.66602 5.25234 3.22792 3.89579 4.22811 2.89559C5.22831 1.8954 6.58486 1.3335 7.99935 1.3335C9.41384 1.3335 10.7704 1.8954 11.7706 2.89559C12.7708 3.89579 13.3327 5.25234 13.3327 6.66683Z" stroke="#737373" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M8 8.6665C9.10457 8.6665 10 7.77107 10 6.6665C10 5.56193 9.10457 4.6665 8 4.6665C6.89543 4.6665 6 5.56193 6 6.6665C6 7.77107 6.89543 8.6665 8 8.6665Z" stroke="#737373" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
									<span><?php echo esc_attr($ipo->country ?? 'Country'); ?></span>
								</div>
								<!-- <div class="ipo_meta_item">
									<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.33398 1.3335V4.00016" stroke="#737373" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M10.666 1.3335V4.00016" stroke="#737373" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M12.6667 2.6665H3.33333C2.59695 2.6665 2 3.26346 2 3.99984V13.3332C2 14.0696 2.59695 14.6665 3.33333 14.6665H12.6667C13.403 14.6665 14 14.0696 14 13.3332V3.99984C14 3.26346 13.403 2.6665 12.6667 2.6665Z" stroke="#737373" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M2 6.6665H14" stroke="#737373" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
									<span>
										<?php
											$year = !empty($ipo->year_est) ? date('Y', strtotime($ipo->year_est)) : 'year_est';
											echo esc_html('Est. ' . $year);
										?>
									</span>
								</div> -->
							</div>
						</div>
						<!-- <button class="ipo_share" onclick="copyLink()">
							<svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5.44257 10.1325L10.5651 13.1175M10.5576 4.88251L5.44257 7.86751M14.75 3.75C14.75 4.99264 13.7426 6 12.5 6C11.2574 6 10.25 4.99264 10.25 3.75C10.25 2.50736 11.2574 1.5 12.5 1.5C13.7426 1.5 14.75 2.50736 14.75 3.75ZM5.75 9C5.75 10.2426 4.74264 11.25 3.5 11.25C2.25736 11.25 1.25 10.2426 1.25 9C1.25 7.75736 2.25736 6.75 3.5 6.75C4.74264 6.75 5.75 7.75736 5.75 9ZM14.75 14.25C14.75 15.4926 13.7426 16.5 12.5 16.5C11.2574 16.5 10.25 15.4926 10.25 14.25C10.25 13.0074 11.2574 12 12.5 12C13.7426 12 14.75 13.0074 14.75 14.25Z" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<span>Share</span>
						</button> -->
					</div>
				</div>
				<div class="ipo_tabs">
									<?php if ($has_investors_data): ?>
					<button class="ipo_tab active" data-target="#ipo-overview">Overview</button>
					<?php endif; ?>
					<?php if (!empty($ipo->description) && trim($ipo->description) !== 'description'): ?>
					<button class="ipo_tab" data-target="#ipo-about">About</button>
					<?php endif; ?>
					<?php if (!empty($api_notable_investors)): ?>
					<button class="ipo_tab" data-target="#ipo-investors">Investors</button>
					<?php endif; ?>
					<?php if ($news_data && !empty($news_data['items'])): ?>
					<button class="ipo_tab" data-target="#ipo-news">News</button>
					<?php endif; ?>
					<?php if ($research_data && !empty($research_data['items'])): ?>
					<button class="ipo_tab" data-target="#ipo-research">Research Reports</button>
					<?php endif; ?>
				</div>

				<?php if ($has_investors_data): ?>
				<div class="ipo_content_box" id="ipo-overview">
					<div class="ipo_content_box_header">
						<h2>Key Information</h2>
					</div>
					<div class="ipo_key_information">
						<div class="ipo_ki_metrics">
							<?php if ($api_investor_price_per_share !== 'N/A'): ?>
							<div class="ip_ki_metric">
									<h4>$<?php echo number_format($api_investor_price_per_share, 2); ?></h4>
								<span>Price without fees</span>
							</div>
							<?php endif; ?>
							<?php if ($api_min_commitment !== 'N/A'): ?>
							<div class="ip_ki_metric">
									<h4>$<?php echo $api_min_commitment; ?></h4>
								<span>Minimum Investment</span>
							</div>
							<?php endif; ?>
							<?php if ($api_valuation !== 'N/A'): ?>
							<div class="ip_ki_metric">
								<?php if ($ipo->ipo_id == 'c6e9306c-c9e9-4b6f-a86c-21ae62b8dd03'): ?>
									<h4>$21B</h4>
								<?php else: ?>
									<h4>$<?php echo $api_valuation; ?></h4>
								<?php endif; ?>
								<span>Company Valuation</span>
							</div>
							<?php endif; ?>
						</div>
						<div class="ipo_ki_meta_container">
							<div class="ipo_ki_meta_box">
								<?php if ($api_share_type !== 'N/A'): ?>
								<div class="ipo_ki_meta">
									<span>Share Type</span>
										<strong><?php echo $api_share_type; ?></strong>
								</div>
								<?php endif; ?>
								<?php if ($api_management_fee !== 'N/A'): ?>
								<div class="ipo_ki_meta">
									<span>Management fee (one-time)</span>
										<strong><?php echo $api_management_fee; ?>%</strong>
								</div>
								<?php endif; ?>
								<div class="ipo_ki_meta">
									<span>All-in price per share</span>
										<strong>$<?php echo $api_all_in_price_per_share !== 'N/A' ? number_format($api_all_in_price_per_share, 2) : 'TBD'; ?></strong>
								</div>
								<!-- <div class="ipo_ki_meta">
									<span>Fees per share</span>
										<strong>$<?php // echo number_format($api_investor_fee_per_share, 2); ?></strong>
								</div> -->
								<?php if ($api_funding_deadline !== 'N/A'): ?>
								<div class="ipo_ki_meta">
									<span>Close Date</span>
										<strong><?php echo format_date_with_ordinal($api_funding_deadline); ?></strong>
								</div>
								<?php endif; ?>
							</div>
							<div class="ipo_ki_meta_box">
								<?php if ($api_share_class !== 'N/A'): ?>
								<div class="ipo_ki_meta">
									<span>Share Class</span>
										<strong><?php echo $api_share_class; ?></strong>
								</div>
								<?php endif; ?>
								<?php if ($api_transaction_type !== 'N/A'): ?>
								<div class="ipo_ki_meta">
									<span>Transaction Type</span>
										<strong><?php echo $api_transaction_type; ?></strong>
								</div>
								<?php endif; ?>
								<div class="ipo_ki_meta">
									<span>Fund History</span>
									<button onclick="openFundingRoundsPopup()">Funding Rounds</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>

				<?php if (!empty($ipo->description) && trim($ipo->description) !== 'description'): ?>
				<div class="ipo_content_box" id="ipo-about">
					<div class="ipo_content_box_header">
						<h2>About <?php echo esc_attr($ipo->name ?? 'IPO'); ?></h2>
					</div>
					<div class="ipo_about_content">
						<?php
							$desc = esc_html($ipo->description);
						$paragraphs = explode("\n\n", $desc);
						foreach ($paragraphs as $para) {
							echo '<p>' . nl2br(trim($para)) . '</p>';
						}
						?>
					</div>
				</div>
				<?php endif; ?>


				<?php if (!empty($api_notable_investors)): ?>
				<div class="ipo_content_box" id="ipo-investors">
					<div class="ipo_content_box_header">
						<h2>Notable Investors</h2>
					</div>
						<div class="ipo_notable_investors">
							<?php foreach ($api_notable_investors as $investor_name): ?>
								<div class="ipo_notable_investor"><?php echo esc_html($investor_name); ?></div>
							<?php endforeach; ?>
						</div>
				</div>
				<?php endif; ?>

				<?php if ($news_data && !empty($news_data['items'])): ?>
				<div class="ipo_content_box" id="ipo-news">
					<div class="ipo_content_box_header">
						<h2>News</h2>
					</div>
						<?php
						// Sort news data by releaseDate (newest first)
						$sorted_news = $news_data['items'];
						usort($sorted_news, function($a, $b) {
							$a_date = isset($a['releaseDate']) ? strtotime($a['releaseDate']) : 0;
							$b_date = isset($b['releaseDate']) ? strtotime($b['releaseDate']) : 0;
							
							return $b_date - $a_date; // Newest first
						});
						
						$total_news = count($sorted_news);
						echo '<div class="ipo_news_list" data-total="' . $total_news . '">';
						foreach ($sorted_news as $index => $news) {
							$headline = esc_html($news['headline']);
							$description = esc_html($news['description']);
							$link = esc_url($news['link']);
							
							// Format release date
							$release_date = '';
							if (!empty($news['releaseDate'])) {
								$release_date = format_date_with_ordinal($news['releaseDate']);
							}
							
							// Add hidden class for items beyond first 3
							$hidden_class = ($index >= 3) ? ' ipo_news_item_hidden' : '';
							?>
							<div class="ipo_news_item<?php echo $hidden_class; ?>">
								<a href="<?php echo $link; ?>" target="_blank" class="ipo_news_link">
									<div class="ipo_news_content">
										<?php if ($release_date): ?>
											<span class="ipo_news_date"><?php echo $release_date; ?></span>
										<?php endif; ?>
										<h3 class="ipo_news_headline"><?php echo $headline; ?></h3>
										<p class="ipo_news_description"><?php echo $description; ?></p>
									</div>
								</a>
								<?php if (!empty($news['articles']) && is_array($news['articles'])): ?>
								<div class="ipo_news_related_articles">
									<span>Related Articles:</span>
									<?php foreach ($news['articles'] as $article): ?>
										<?php if (!empty($article['publication']) && !empty($article['link'])): ?>
										<a href="<?php echo esc_url($article['link']); ?>" target="_blank" class="ipo_news_publication_link">
											<?php echo esc_html($article['publication']); ?>
										</a>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
								<?php endif; ?>
							</div>
							<?php
						}
						echo '</div>';
						
						// Show "View More" button if there are more than 3 news items
						if ($total_news > 3) {
							echo '<div class="ipo_news_view_more_wrapper">';
							echo '<button class="ipo_news_view_more_btn" data-shown="3" data-total="' . $total_news . '">View More</button>';
							echo '</div>';
						}
						?>
					</div>
				<?php endif; ?>

				<?php if ($research_data && !empty($research_data['items'])): ?>
				<div class="ipo_content_box" id="ipo-research">
					<div class="ipo_content_box_header">
						<h2>Research Reports</h2>
						</div>
						<?php
						// Sort research data by relation (SUBJECT first) and publishedDate (newest first)
						$sorted_research = $research_data['items'];
						usort($sorted_research, function($a, $b) {
							$a_relation = isset($a['relation']) ? $a['relation'] : '';
							$b_relation = isset($b['relation']) ? $b['relation'] : '';
							
							// SUBJECT should come first
							if ($a_relation === 'SUBJECT' && $b_relation !== 'SUBJECT') {
								return -1;
							}
							if ($b_relation === 'SUBJECT' && $a_relation !== 'SUBJECT') {
								return 1;
							}
							
							// If both have same relation or neither is SUBJECT, sort by publishedDate (newest first)
							$a_date = isset($a['publishedDate']) ? strtotime($a['publishedDate']) : 0;
							$b_date = isset($b['publishedDate']) ? strtotime($b['publishedDate']) : 0;
							
							return $b_date - $a_date; // Newest first
						});
						
						$total_research = count($sorted_research);
						echo '<div class="ipo_research_list" data-total="' . $total_research . '">';
						foreach ($sorted_research as $index => $research) {
							$title = esc_html($research['title']);
							$link = esc_url($research['link']);
							
							// Add hidden class for items beyond first 5
							$hidden_class = ($index >= 5) ? ' ipo_research_item_hidden' : '';
							?>
							<div class="ipo_research_item<?php echo $hidden_class; ?>">
								<div class="ipo_research_content">
									<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.99935 1.3335H3.99935C3.64573 1.3335 3.30659 1.47397 3.05654 1.72402C2.80649 1.97407 2.66602 2.31321 2.66602 2.66683V13.3335C2.66602 13.6871 2.80649 14.0263 3.05654 14.2763C3.30659 14.5264 3.64573 14.6668 3.99935 14.6668H11.9993C12.353 14.6668 12.6921 14.5264 12.9422 14.2763C13.1922 14.0263 13.3327 13.6871 13.3327 13.3335V4.66683L9.99935 1.3335Z" stroke="#002852" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M9.33398 1.3335V4.00016C9.33398 4.35378 9.47446 4.69292 9.72451 4.94297C9.97456 5.19302 10.3137 5.3335 10.6673 5.3335H13.334" stroke="#002852" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M6.66732 6H5.33398" stroke="#002852" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M10.6673 8.6665H5.33398" stroke="#002852" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M10.6673 11.3335H5.33398" stroke="#002852" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
									<h3 class="ipo_research_title"><?php echo $title; ?></h3>
								</div>
								<div class="ipo_research_link">
									<a href="<?php echo $link; ?>" target="_blank">
										<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M10 2H14V6" stroke="#2563EB" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M6.66602 9.33333L13.9993 2" stroke="#2563EB" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M12 8.66667V12.6667C12 13.0203 11.8595 13.3594 11.6095 13.6095C11.3594 13.8595 11.0203 14 10.6667 14H3.33333C2.97971 14 2.64057 13.8595 2.39052 13.6095C2.14048 13.3594 2 13.0203 2 12.6667V5.33333C2 4.97971 2.14048 4.64057 2.39052 4.39052C2.64057 4.14048 2.97971 4 3.33333 4H7.33333" stroke="#2563EB" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
										<span>View Document</span>
									</a>
					</div>
				</div>
							<?php
						}
						echo '</div>';
						
						// Show "View More" button if there are more than 5 research items
						if ($total_research > 5) {
							echo '<div class="ipo_research_view_more_wrapper">';
							echo '<button class="ipo_research_view_more_btn" data-shown="5" data-total="' . $total_research . '">View More</button>';
							echo '</div>';
						}
						?>
					</div>
				<?php endif; ?>

				<div class="ipo_content_box">
					<div class="ipo_content_box_header">
						<h2>Frequently Asked Questions</h2>
					</div>
					<?php
					$total_faq = $has_investors_data ? 12 : 7; // Total number of FAQ items (12 for SPV pages, 7 for company pages)
					echo '<div class="ipo_faq_container" data-total="' . $total_faq . '">';
					?>
						<?php if ($has_investors_data): ?>
						<div class="ipo_faq_item">
							<div class="ipo_faq_question">
								<span>What is this investment opportunity in <?php echo esc_html($ipo->name ?? 'this company'); ?>?</span>
								<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L7 7L13 1" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="ipo_faq_answer">
								<p>This is an opportunity to invest in <?php echo esc_html($ipo->name ?? 'this company'); ?> through a Special Purpose Vehicle (SPV) fund structure. It allows fractional ownership with a low minimum investment and gives access to Private markets shares typically unavailable to individual investors.</p>	
							</div>
						</div>
						<?php endif; ?>
						<div class="ipo_faq_item">
							<div class="ipo_faq_question">
								<span><?php echo $has_investors_data ? 'How is the investment structured?' : 'How would the investment be structured?'; ?></span>
								<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L7 7L13 1" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="ipo_faq_answer">
								<?php if ($has_investors_data): ?>
								<p>You'll be investing via a US-based, bankruptcy-remote Delaware SPV. As an investor, you'll become a limited partner in a fund that indirectly holds shares of <?php echo esc_html($ipo->name ?? 'this company'); ?>.</p>
								<?php else: ?>
								<p>When investment opportunities become available for <?php echo esc_html($ipo->name ?? 'this company'); ?>, they would typically be structured through US-based, bankruptcy-remote Delaware SPVs. As an investor, you would become a limited partner in a fund that indirectly holds shares of the company. This page is for expressing interest in future opportunities, not for making actual investments.</p>
								<?php endif; ?>
							</div>
						</div>
						<div class="ipo_faq_item">
							<div class="ipo_faq_question">
								<span>Why can't I invest in <?php echo esc_html($ipo->name ?? 'this company'); ?> directly?</span>
								<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L7 7L13 1" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="ipo_faq_answer">
								<p>Direct investment into high-demand private companies like <?php echo esc_html($ipo->name ?? 'this company'); ?> often requires $50M+ in capital. Our SPV structure gives you access at lower minimums by pooling capital and investing through intermediaries that already hold equity.</p>
							</div>
						</div>
						<div class="ipo_faq_item">
							<div class="ipo_faq_question">
								<span>What is the minimum investment amount?</span>
								<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L7 7L13 1" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="ipo_faq_answer">
								<p>The minimum investment typically starts from $10,000, though it may vary depending on the deal size and available allocations.</p>
							</div>
						</div>
						<?php if ($has_investors_data): ?>
						<div class="ipo_faq_item ipo_faq_item_hidden">
							<div class="ipo_faq_question">
								<span>What is the price per share and valuation?</span>
								<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L7 7L13 1" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="ipo_faq_answer">
								<p>The offering is priced at $<?php echo $api_price_per_share !== 'N/A' ? $api_price_per_share : 'TBD'; ?>/share, implying a valuation of approximately $<?php echo $api_valuation !== 'N/A' ? $api_valuation : 'TBD'; ?>. This includes a one-time management fee and expense reserve. There are no ongoing fees or carry.</p>
							</div>
						</div>
						<?php endif; ?>
						<?php if ($has_investors_data): ?>
						<div class="ipo_faq_item ipo_faq_item_hidden">
							<div class="ipo_faq_question">
								<span>What are the dates for the investment window?</span>
								<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L7 7L13 1" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="ipo_faq_answer">
								<?php if($ipo->ipo_id == 'c6e9306c-c9e9-4b6f-a86c-21ae62b8dd03'): ?>
									<p>The offering for <?php echo esc_html($ipo->name ?? 'this company'); ?> opens on August 6th, 2025 and closes on <?php echo $api_funding_deadline !== 'N/A' ? format_date_with_ordinal($api_funding_deadline) : 'TBD'; ?>. Once closed, the opportunity will no longer be available for subscription.</p>
								<?php else: ?>
									<p>The offering for <?php echo esc_html($ipo->name ?? 'this company'); ?> opens on <?php echo !empty($ipo->year_est) ? date('F j, Y', strtotime($ipo->year_est)) : 'TBD'; ?> and closes on <?php echo $api_funding_deadline !== 'N/A' ? format_date_with_ordinal($api_funding_deadline) : 'TBD'; ?>. Once closed, the opportunity will no longer be available for subscription.</p>
								<?php endif; ?>
							</div>
						</div>
						<?php endif; ?>
						<div class="ipo_faq_item ipo_faq_item_hidden">
							<div class="ipo_faq_question">
								<span>When will I receive units for my investment?</span>
								<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L7 7L13 1" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="ipo_faq_answer">
								<p>Once the SPV is fully funded and the shares are secured, units will be allocated to your account and you'll be notified. This typically takes 2–3 weeks post close date.</p>
							</div>
						</div>
						<?php if ($has_investors_data): ?>
						<div class="ipo_faq_item ipo_faq_item_hidden">
							<div class="ipo_faq_question">
								<span>How do I invest in <?php echo esc_html($ipo->name ?? 'this company'); ?>?</span>
								<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L7 7L13 1" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="ipo_faq_answer">
								<p>Once you click "Invest" and enter the amount or number of shares, you'll be able to review and sign the subscription documents in-app. The investment will then be initiated, and funds will be deducted from your existing DriveWealth buying power. No additional account setup is required.</p>
							</div>
						</div>
						<div class="ipo_faq_item ipo_faq_item_hidden">
							<div class="ipo_faq_question">
								<span>How do I transfer funds to make the investment?</span>
								<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L7 7L13 1" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="ipo_faq_answer">
								<p>Investment funds will be deducted from your existing buying power. You can top up your Vested account via HDFC, Axis, or other supported banks through the "Transfer" section in the app.</p>
							</div>
						</div>
						<?php endif; ?>
						<div class="ipo_faq_item ipo_faq_item_hidden">
							<div class="ipo_faq_question">
								<span>What are the exit options or liquidity paths?</span>
								<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L7 7L13 1" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="ipo_faq_answer">
								<p>Liquidity is not guaranteed. However, exits may occur through the following avenues:<br>
								(a) resale through our partner's Alternative Trading System (ATS) after a holding period,<br>
								(b) secondary market transactions,<br>
								(c) a future IPO of <?php echo esc_html($ipo->name ?? 'this company'); ?> or its subsidiaries, or<br>
								(d) an acquisition of the company.</p>
							</div>
						</div>
						<div class="ipo_faq_item ipo_faq_item_hidden">
							<div class="ipo_faq_question">
								<span>What are the risks of investing in <?php echo esc_html($ipo->name ?? 'this company'); ?>?</span>
								<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L7 7L13 1" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="ipo_faq_answer">
								<p>Key risks include equity risk (share value decline) and liquidity risk (limited tradability of private shares). As with any private market investment, capital loss is possible.</p>
							</div>
						</div>
						<div class="ipo_faq_item ipo_faq_item_hidden">
							<div class="ipo_faq_question">
								<span>What are the tax implications?</span>
								<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L7 7L13 1" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="ipo_faq_answer">
								<p>Taxation is treated the same as investing in US-listed stocks. Long-term capital gains (after 24 months) are taxed at 12.5%. Short-term gains are taxed as per your income tax slab.</p>
							</div>
						</div>
						<div class="ipo_faq_item ipo_faq_item_hidden">
							<div class="ipo_faq_question">
								<span>Under which regulatory framework does this investment fall?</span>
								<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L7 7L13 1" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="ipo_faq_answer">
								<p>All investments are made through SEC-compliant SPVs under Regulation S. The structure is similar to those used by leading US platforms like EquityZen and Forge.</p>
							</div>
						</div>
						<?php if ($has_investors_data): ?>
						<div class="ipo_faq_item ipo_faq_item_hidden">
							<div class="ipo_faq_question">
								<span>Who manages the investment and SPV?</span>
								<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L7 7L13 1" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="ipo_faq_answer">
								<p>The SPV is co-managed by Vested Finance Inc. and Monark Capital Management. Monark Capital Management oversees fund structuring, operations, and coordination with underlying counterparties.</p>
							</div>
						</div>
						<?php endif; ?>
						<?php if ($has_investors_data): ?>
						<div class="ipo_faq_item ipo_faq_item_hidden">
							<div class="ipo_faq_question">
								<span>What happens if Vested or its partners go bankrupt?</span>
								<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1L7 7L13 1" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="ipo_faq_answer">
								<p>Each SPV is bankruptcy-remote and legally ringfenced. Your ownership in the SPV remains unaffected even if Vested or its partners face insolvency.</p>
							</div>
						</div>
						<?php endif; ?>						
					</div>
					<?php
					// Show "View More" button if there are more than 4 FAQ items
					if ($total_faq > 4) {
						echo '<div class="ipo_faq_view_more_wrapper">';
						echo '<button class="ipo_faq_view_more_btn" data-shown="4" data-total="' . $total_faq . '">View More</button>';
						echo '</div>';
					}
					?>
				</div>

				<div class="ipo_content_box more_info_cta">
					<div class="ipo_need_more_info">
						<div class="ipo_need_more_info_content">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12 16V12M12 8H12.01M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<h3>Need More Information?</h3>
							<p>Have additional questions about this investment opportunity? Our team is here to help.</p>
							<a href="<?php echo $request_callback_url; ?>" class="ipo_button" target="_blank">Request Callback</a>
						</div>
					</div>
				</div>

			</div>
			<div class="ipo_sidebar">
				<div class="ipo_sidebar_box quick_actions">
					<h2>Quick Actions</h2>
					<div class="ipo_quick_actions <?php echo ($has_investors_data && !empty($ipo->api_deal_memo_url)) ? 'with_deal_memo' : ''; ?>">
						<?php if ($has_investors_data): ?>
							<?php 
								$csrf_param = isset($_GET['csrf']) ? $_GET['csrf'] : '';
								$token_param = isset($_GET['token']) ? $_GET['token'] : '';
								
								// Get SPV ID from database or fallback to API if needed
								$spv_id = '';
								// For now, we'll need to fetch SPV ID via API if needed for investment
								$investors_data = get_ipo_investors($ipo_id);
								if (!empty($investors_data['items'][0]['id'])) {
									$spv_id = $investors_data['items'][0]['id'];
								}
								
								// $invest_url = "https://app.vestedfinance.com?csrf={$csrf_param}&token={$token_param}&redirect_uri=/en/global/pre-ipo";
								$invest_url = "https://app.vestedfinance.com/en/global/pre-ipo";
                                if (!empty($spv_id)) {
									$invest_url .= "?productId={$spv_id}";
								}
							?>
							<a href="<?php echo esc_url($invest_url); ?>" class="ipo_primary_button">Invest</a>
						<?php else: ?>
							<?php
								$typoform_link = get_typoform_link_by_ipo_id($ipo_id);
								if ($typoform_link) {
									?>
									<a href="<?php echo esc_url($typoform_link); ?>" class="ipo_primary_button">
										<?php
											if ($ipo->ipo_id == 'd90dce47-4768-47a0-821f-9afe71b77888') {
												echo 'Invest Now';
											} else {
												echo 'Express Interest';
											}
										?>
									</a>
									<?php
								} else {
									?>
										<a href="https://vestedfinance.typeform.com/to/NBg1K5gi" class="ipo_primary_button">
											<?php
												if ($ipo->ipo_id == 'd90dce47-4768-47a0-821f-9afe71b77888') {
													echo 'Invest Now';
												} else {
													echo 'Express Interest';
												}
											?>
										</a>
									<?php
								}
							?>
						<?php endif; ?>
						<?php if ($has_investors_data && !empty($ipo->api_deal_memo_url)): ?>
						<a href="<?php echo esc_url($ipo->api_deal_memo_url); ?>" class="ipo_button deal_memo_btn" target="_blank">Download Deal Memo</a>
						<?php endif; ?>
						<a href="<?php echo $request_callback_url; ?>" class="ipo_button" target="_blank">Request Callback</a>
					</div>
				</div>
				<?php if ($documents_data && !empty($documents_data['items'])): ?>
				<div class="ipo_sidebar_box">
					<h2>Documents</h2>
						<div class="ipo_documents_list">
							<?php foreach ($documents_data['items'] as $document): 
								$document_name = esc_html($document['name']);
								$document_url = esc_url($document['url']);
								$document_description = !empty($document['description']) ? esc_html($document['description']) : '';
							?>
								<div class="ipo_document_item">
									<a href="<?php echo esc_url($document_url); ?>" target="_blank" class="ipo_document_link">
									<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g clip-path="url(#clip0_18939_63119)">
											<path d="M9.99935 1.3335H3.99935C3.64573 1.3335 3.30659 1.47397 3.05654 1.72402C2.80649 1.97407 2.66602 2.31321 2.66602 2.66683V13.3335C2.66602 13.6871 2.80649 14.0263 3.05654 14.2763C3.30659 14.5264 3.64573 14.6668 3.99935 14.6668H11.9993C12.353 14.6668 12.6921 14.5264 12.9422 14.2763C13.1922 14.0263 13.3327 13.6871 13.3327 13.3335V4.66683L9.99935 1.3335Z" stroke="#002852" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M9.33398 1.3335V4.00016C9.33398 4.35378 9.47446 4.69292 9.72451 4.94297C9.97456 5.19302 10.3137 5.3335 10.6673 5.3335H13.334" stroke="#002852" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M6.66732 6H5.33398" stroke="#002852" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M10.6673 8.6665H5.33398" stroke="#002852" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M10.6673 11.3335H5.33398" stroke="#002852" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
										</g>
										<defs>
											<clipPath id="clip0_18939_63119">
												<rect width="16" height="16" fill="white"/>
											</clipPath>
										</defs>
									</svg>
									<span><?php echo esc_html($document_name); ?></span>
									</a>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php else: ?>
					<?php if ($funding_rounds_data && !empty($funding_rounds_data['items']) && empty($investors_data['items'])): ?>
						<div class="ipo_sidebar_box">
							<h2>Funding Rounds</h2>
							<div class="funding_rounds_list">
								<?php
									if ($ipo->ipo_id == 'c6e9306c-c9e9-4b6f-a86c-21ae62b8dd03') {
										?>
										<div class="funding_round">
											<div class="funding_round_info">
												<h4>Series E extension</h4>
											</div>
											<div class="funding_amount">
												<strong>$697</strong>
												<span class="funding_date">Ongoing</span>
											</div>
										</div>
										<?php
									}
								?>
								<?php render_funding_rounds($funding_rounds_data); ?>
							</div>
				</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<div id="copy_link_message">
    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/checkmark.png" alt="checkmark" />
    <span>Link copied</span>
</div>

<!-- Funding Rounds Popup -->
<div id="funding_rounds_popup" class="funding_rounds_popup">
    <div class="funding_rounds_popup_overlay" onclick="closeFundingRoundsPopup()"></div>
    <div class="funding_rounds_popup_content">
        <div class="funding_rounds_popup_header">
            <h3>Funding Rounds</h3>
        </div>
        <div class="funding_rounds_popup_body">
			<?php
				if ($ipo->ipo_id == 'c6e9306c-c9e9-4b6f-a86c-21ae62b8dd03') {
					?>
					<div class="funding_round">
						<div class="funding_round_info">
							<h4>Series E extension</h4>
						</div>
						<div class="funding_amount">
							<strong>$697</strong>
							<span class="funding_date">Ongoing</span>
						</div>
					</div>
					<?php
				}
			?>
            <?php render_funding_rounds($funding_rounds_data); ?>
        </div>
        <div class="funding_rounds_popup_footer">
            <button class="funding_rounds_close_btn" onclick="closeFundingRoundsPopup()">Done</button>
        </div>
    </div>
</div>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/templates/js-ipo-details.js"></script>

<script>
// Detect if page is loaded in iframe and get parent URL
(function() {
    try {
        // Check if the page is loaded in an iframe
        if (window.self !== window.top) {
            console.log('Page is loaded in an iframe');
            console.log('Current window URL:', window.location.href);
            console.log('Parent window URL:', window.top.location.href);
            console.log('Parent window origin:', window.top.location.origin);
        } else {
            console.log('Page is loaded in main window (not in iframe)');
            console.log('Current window URL:', window.location.href);
        }
        
        // Alternative method to detect iframe
        if (window.parent !== window) {
            console.log('Alternative detection: Page is in iframe');
            console.log('Parent window URL (alternative):', window.parent.location.href);
        }
        
    } catch (error) {
        console.log('Error accessing parent window (likely due to same-origin policy):', error.message);
        console.log('Current window URL:', window.location.href);
    }
})();
</script>
</body>
</html>