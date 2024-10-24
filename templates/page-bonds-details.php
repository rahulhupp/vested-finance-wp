<?php

$bond_name_slug = get_query_var('bond_company');
$bond_isin = get_query_var('securityId');

// echo strtoupper($bond_isin);

if ($bond_isin) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bonds_list';
    $bond = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE securityId = %s", strtoupper($bond_isin)));

    function checkImageURL($url)
    {
        if (empty($url)) {
            return false;
        }
    
        $headers = @get_headers($url);
        if ($headers === false) {
            return false;
        }
    
        $statusCode = substr($headers[0], 9, 3);
        return in_array($statusCode, ['200']) ? true : false;
    }
    
    $bondImageURL = $bond->logo;
    
    if ($bond->bondCategory === 'CORPORATE') {
        $defaultURL = get_stylesheet_directory_uri() . '/assets/images/Corporate-Bonds.png';
    } else {
        $defaultURL = 'https://d13dxy5z8now6z.cloudfront.net/img/GOVT-default.svg';
    }
    
    $isImageAccessible = checkImageURL($bondImageURL);
    
    if (!$isImageAccessible) {
        $bondImageURL = $defaultURL;
    }
    

    $bondName = capitalizeString($bond->issuerName);
    $bondCouponRate = $bond->couponRate;
    $isinCode = $bond->securityId;
    $maturityDate = $bond->redemptionDate;
    $formattedDate = date('d-F-Y', strtotime($maturityDate));
    set_query_var('custom_bond_title_value', "$bondName");
    set_query_var('custom_bond_coupon_rate', "$bondCouponRate");
    set_query_var('custom_bond_security_id', "$isinCode");
    set_query_var('custom_bond_description', "Invest in $bondName coupon rate $bondCouponRate%, Maturity date - $formattedDate, INE No - $isinCode , Explore its issue size, credit rating and more.");

    if ($bond) {
        get_header();
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
        <div class="bond_details_main">
            <div class="container">
                <div class="bond_details_breadcrumb">
                    <a href="<?php echo home_url(); ?>">Vested > </a>
                    <a href="<?php echo home_url('/in/inr-bonds/'); ?>">INR Bonds ></a>
                    <span><?php echo $bond->displayName; ?></span>
                </div>
                <div class="bond_details_wrapper">
                    <div class="bond_details_left_column">
                        <div class="bonds_search_container">
                            <?php get_template_part('template-parts/bond-details/bond-search-link'); ?>
                        </div>
                        <div class="stock_details_box stock_info_container">
                            <div class="stock_info_icons">
                                <div class="stock_img">
                                    <img src="<?php echo $bondImageURL ?>" alt="Bond Logo" />
                                </div>
                                <h1 class="desktop_hide"><?php echo $bond->displayName; ?></h1>
                                <div class="share_icon mobile_hide" onclick="copyLink()">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/share-icon.svg" alt="share-icon" />
                                </div>
                            </div>
                            <h1 class="mobile_hide"><?php echo $bond->displayName; ?></h1>
                            <!-- <h2><?php // echo $bond->issuerName; ?></h2> -->
                            <h6>ISIN: <?php echo $bond->securityId; ?></h6>
                            <div class="bonds_info_box">
                                <div class="bond_details_box">
                                    <div class="bond_detail_col">
                                        <div class="bond_single_detail">
                                            <p class="detail_info">Yield</p>
                                            <h4 class="highlighted"><?php echo number_format($bond->yield, 2); ?>%</h4>
                                        </div>
                                        <div class="bond_single_detail">
                                            <p class="detail_info">Matures in</p>
                                            <h4>
                                                <?php
                                                $years = intdiv($bond->maturityInMonths, 12);
                                                $months = $bond->maturityInMonths % 12;
                                                if ($years > 0) {
                                                    echo "{$years}y" . ($months > 0 ? " {$months}m" : '');
                                                } elseif ($months > 0) {
                                                    echo "{$months}m";
                                                } else {
                                                    echo '';
                                                }
                                                ?>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="bond_detail_col">
                                        <div class="bond_single_detail">
                                            <p class="detail_info">Min. Investment</p>
                                            <h4 class="highlighted">
                                                <?php echo formatIndianCurrency($bond->minimumInvestment); ?>
                                            </h4>
                                        </div>
                                        <div class="bond_single_detail">
                                            <p class="detail_info">Interest Payment</p>
                                            <h4><?php echo ucfirst(strtolower($bond->interestPayFreq)); ?></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="stock_tags">
                                </div>
                            </div>
                            <div class="stock_share_buttons">
                                <?php
                                if ($bond->isSoldOut == 1) {
                                ?>
                                    <a href="#" class="sold_out_bond_button">
                                        <button class="primary_button">
                                            Sold out
                                        </button>
                                    </a>
                                <?php
                                } else {
                                ?>
                                    <a href="#">
                                        <button class="primary_button">
                                            Invest now
                                        </button>
                                    </a>
                                <?php
                                }

                                ?>

                                <div class="share_icon desktop_hide" onclick="copyLink()">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/share-icon.svg" alt="share-icon" />
                                </div>
                            </div>
                            <div class="bond_certificate desktop_hide">
                                <span id="certificate_rating">-</span>
                                <div class="certificate_bg">
                                    <svg width="50" height="29" viewBox="0 0 50 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M56 4C56 1.79086 54.2091 0 52 0H13.1316C11.5345 0 10.0905 0.950035 9.45833 2.41668L0.406601 23.4167C-0.731503 26.0571 1.20466 29 4.0799 29H52C54.2091 29 56 27.2091 56 25V4Z" fill="#4ADE80" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bond_details_right_column">
                        <div class="stock_tabs_menu_position"></div>
                        <div class="stock_tabs_menu">
                            <div class="stock_tabs_menu_wrapper">
                                <a class="tab_button active" href="#returns_tab">Returns</a>
                                <a class="tab_button" href="#rating_tab">Rating</a>
                                <a class="tab_button mobile_hide" href="#metrics_tab">Key Metrics</a>
                                <a class="tab_button desktop_hide" href="#metrics_tab">Metrics</a>
                                <?php if ($bond->issuerDescription) :?>
                                <a class="tab_button mobile_hide" href="#about_tab">About Issuer</a>
                                <a class="tab_button desktop_hide" href="#about_tab">About</a>
                                <?php endif; ?>
                                <!-- <a class="tab_button" href="#compare_tab">Compare</a> -->
                                <a class="tab_button" href="#faqs_tab">FAQs</a>
                            </div>
                        </div>

                        <!-- <?php get_template_part('template-parts/bond-details/returns-new', null, array('bond' => $bond)); ?> -->

                        <?php get_template_part('template-parts/bond-details/returns'); ?>
                        <div class="ratings_tab_wrap">
                            <div class="ratings_tab" id="ratings_tab_wrap">
                                <?php get_template_part('template-parts/bond-details/ratings', null, array('bond' => $bond)); ?>
                            </div>
                            <div class="ratings_tab" id="metrics_tab_wrap">
                                <?php get_template_part('template-parts/bond-details/metrics', null, array('bond' => $bond)); ?>
                            </div>
                        </div>
                        <?php if ($bond->issuerDescription) :?>
                            <div id="about_tab" class="tab_content">
                                <div class="stock_details_box stock_metrics_container">
                                    <h2 class="heading">About <span><?php echo $bond->issuerName; ?></span></h2>
                                    <div class="separator_line"></div>
                                    <div class="about_ntpc">
                                        <p><?php echo $bond->issuerDescription; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php get_template_part('template-parts/bond-details/fixed-income-products'); ?>

                        <?php get_template_part('template-parts/bond-details/faqs', null, array('bond' => $bond)); ?>
                    </div>
                </div>
            </div>
            <div class="pdf_modal">
                <span class="close">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/close.png" alt="close">
                </span>
                <embed src="<?php echo get_stylesheet_directory_uri();?>/assets/7e4a754b-cc12-49d1-9951-a92e47540633.pdf" type="application/pdf" width="70%" height="800px" id="pdf_embed">
            </div>
        </div>
<?php
    }
}

function capitalizeString($string) {
    $lowercaseString = strtolower($string);
    $capitalizedString = ucwords($lowercaseString);
    return $capitalizedString;
}

?>
<div id="bond-loader">
    <div class="bond_loader"></div>
</div>
<div id="copy_link_message">
    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/checkmark.png" />
    <span>Link copied</span>
</div>
<?php get_template_part('template-parts/bond-details/js/bond-details-api'); ?>
<?php get_template_part('template-parts/bond-details/js/general-js'); ?>
<script type="application/ld+json">
    <?php
        $breadcrumb = [
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                [
                    "@type" => "ListItem",
                    "position" => 1,
                    "name" => "Vested",
                    "item" => home_url()
                ],
                [
                    "@type" => "ListItem",
                    "position" => 2,
                    "name" => "INR Bonds",
                    "item" => home_url('/in/inr-bonds/')
                ],
                [
                    "@type" => "ListItem",
                    "position" => 3,
                    "name" => $bond->displayName,
                    "item" => get_permalink()
                ]
            ]
        ];
        echo json_encode($breadcrumb, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    ?>
</script>
<?php get_footer(); ?>