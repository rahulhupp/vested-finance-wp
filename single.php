<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); 
while (have_posts()) :
    the_post();
    $featured_image_url = get_the_post_thumbnail_url();
    $author_id = get_the_author_meta('ID');
    $date_created = get_the_date();
    $reading_time = calculate_reading_time(get_the_content());

    $previous_post = get_previous_post(true, '', 'modules');
    $next_post = get_next_post(true, '', 'modules');
?>
<div id="progress-container">
    <div id="progress-bar"></div>
</div>
<div class="social-overlay"></div>
<div id="main-content" class="main-content">
	<div class="single_module_main">
		<div class="single_module_content">
			<div class="container">
				<div class="module_heading_content">
					<div class="single_module_breadcrumb">
						<?php
						$site_name = get_bloginfo('name');
						$terms = get_the_terms(get_the_ID(), 'modules');
						?>
						<ul>
							<li>
								<a href="<?php echo home_url('in'); ?>"><?php echo $site_name; ?></a>
							</li>
							<li>
								<a href="<?php echo home_url(); ?>/blog/">Blog</a>
							</li>
							<?php
								$post_id = get_the_ID();
								$terms = get_the_terms($post_id, 'master_categories'); 

								if ($terms && !is_wp_error($terms)) {
									?>
									<li>
									<?php
									foreach ($terms as $term) {
										// Check if the term has a parent
										$parent_id = $term->parent;
										if (0 === $parent_id) { // 0 means it's a parent term
											$taxonomy_name = $term->name;
											$taxonomy_url = get_term_link($term);
											echo '<a href="' . esc_url($taxonomy_url) . '">' . esc_html($taxonomy_name) . '</a>';
											// Break the loop after finding the first parent term, if you only want to display one
											break;
										}
									}
									?>
									</li>
									<?php
								}
							?>
							<li>
								<span><?php the_title(); ?></span>
							</li>
						</ul>
					</div>
					<h1 class="single_module_title"><?php the_title(); ?></h1>
					<div class="single_module_meta">
					<div class="module_single_meta_wrap">
							<div class="single_module_meta_item">
								<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M12 15.75V14.25C12 13.4544 11.6839 12.6913 11.1213 12.1287C10.5587 11.5661 9.79565 11.25 9 11.25H4.5C3.70435 11.25 2.94129 11.5661 2.37868 12.1287C1.81607 12.6913 1.5 13.4544 1.5 14.25V15.75" stroke="#3D5272" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M6.75 8.25C8.40685 8.25 9.75 6.90685 9.75 5.25C9.75 3.59315 8.40685 2.25 6.75 2.25C5.09315 2.25 3.75 3.59315 3.75 5.25C3.75 6.90685 5.09315 8.25 6.75 8.25Z" stroke="#3D5272" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M16.5 15.75V14.25C16.4995 13.5853 16.2783 12.9396 15.871 12.4142C15.4638 11.8889 14.8936 11.5136 14.25 11.3475" stroke="#3D5272" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M12 2.34747C12.6453 2.5127 13.2173 2.888 13.6257 3.41421C14.0342 3.94041 14.2559 4.5876 14.2559 5.25372C14.2559 5.91985 14.0342 6.56703 13.6257 7.09324C13.2173 7.61945 12.6453 7.99475 12 8.15997" stroke="#3D5272" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
								<span>by <?php echo get_the_author(); ?></span>
							</div>
							<div class="single_module_meta_item">
								<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M14.25 3H3.75C2.92157 3 2.25 3.67157 2.25 4.5V15C2.25 15.8284 2.92157 16.5 3.75 16.5H14.25C15.0784 16.5 15.75 15.8284 15.75 15V4.5C15.75 3.67157 15.0784 3 14.25 3Z" stroke="#3D5272" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M12 1.5V4.5" stroke="#3D5272" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M6 1.5V4.5" stroke="#3D5272" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M2.25 7.5H15.75" stroke="#3D5272" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
								<span><?php echo $date_created; ?></span>
							</div>
							<div class="single_module_meta_item">
								<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
									<g clip-path="url(#clip0_1759_6166)">
										<path d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85786 13.1421 1.5 9 1.5C4.85786 1.5 1.5 4.85786 1.5 9C1.5 13.1421 4.85786 16.5 9 16.5Z" stroke="#3D5272" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
										<path d="M9 4.5V9L12 10.5" stroke="#3D5272" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
									</g>
									<defs>
										<clipPath id="clip0_1759_6166">
											<rect width="18" height="18" fill="white" />
										</clipPath>
									</defs>
								</svg>
								<span><?php echo $reading_time; ?> min read</span>
							</div>
						</div>
						<div class="single_module_info_item last">
							<div class="social-share-block">
								<button class="sharing-icon">
									<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/share-icon.webp" alt="link" />
								</button>
								<button class="share-btn"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/share-icon.webp" alt="Share Icon" /><span>Share</span></button>
								<ul>
									<?php
									$current_page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
									?>

									<li>
										<a id="copyLink" href="">
											<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/link.webp" alt="link" />
											<span>Copy link</span>
										</a>
									</li>
									<li class="share_whatsapp">
										<a href="javascript:void(0);" target="_blank">
											<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/whatsapp.webp" alt="whatsapp" />
											<span>Share on Whatsapp</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="single_module_feature_image">
						<img src="<?php echo $featured_image_url; ?>" alt="<?php the_title(); ?>">
					</div>
				</div>
				
				<?php if (!has_tag('premium')) { ?>
					<div class="single_module_content_wrapper">
						<!-- The Modal -->
						<div id="modal" class="modal">
							<span id="modal-close" class="modal-close">&times;</span>
							<img id="modal-content" class="modal-content">
							<div id="modal-caption" class="modal-caption"></div>
						</div>

						<div class="single_module_post_content pb-0">
							<div class="single_module_table_content">
								<div class="single_module_table_wrap">
									<?php echo do_shortcode('[ez-toc]') ?>
								</div>
							</div>
							<div class="content">
								<div class="inner_content">
									<?php if (get_field('heading_notes')) : ?>
										<div class="heading_note">
											<?php the_field('heading_notes'); ?>
										</div>
									<?php endif; ?>
									<?php the_content(); ?>
									<?php if (get_field('takeaways')) : ?>
										<div class="takeways">
											<h2>Key Takeaways </h2>
											<?php the_field('takeaways'); ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="single_module_post_content pt-0">
							<div class="single_module_table_content"></div>
							<div class="content">
								<div class="single_module_comments">
									<?php
									if (comments_open() || get_comments_number()) {
										comments_template();
									}
									?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php if (has_tag('premium')) { ?>
					<div class="premium_box">
						<div class="premium_box_content">
							<img src="http://wordpress-testing.vestedfinance.com/wp-content/uploads/2023/12/permium-logo.svg" alt="premium_tag" class="premium_tag" />
							<h2>Continue reading on app</h2>
							<p>The content you are trying to access is available exclusively to Vested Premium subscribers. If you are an existing Premium subscriber, you can access this content on our mobile app.</p>
							<div class="premium_box_buttons">
								<a href="https://play.google.com/store/apps/details?id=com.vested.investing.android&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1" target="_blank">
									<img src="http://wordpress-testing.vestedfinance.com/wp-content/uploads/2023/12/Google_Play_Store_badge.svg" alt="Google_Play_Store" />
								</a>
								<a href="https://apps.apple.com/us/app/vested-us-stocks-investing/id1478145933?ls=1" target="_blank">
									<img src="http://wordpress-testing.vestedfinance.com/wp-content/uploads/2023/12/Apple_Badge.svg" alt="app_store" />
								</a>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>	
		</div>
	</div>
	<div class="chapter_cta">
            <div class="container">
                <div class="chapter_cta_wrap">
                    <div class="chapter_cta_content">
                        <div class="vested_logo">
							<img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/Vested_logo.svg" alt="Vested Finance">
                        </div>
                        <?php
                        $single_cta_heading = get_field('single_chapter_cta_heading');
                        $single_cta_button_url = get_field('single_chapter_cta_button_url');
                        $single_cta_button_text = get_field('single_chapter_cta_button_text');
                        $default_cta_heading = get_field('chapter_cta_heading', 'option');
                        $default_cta_button_url = get_field('chapter_cta_button_url', 'option');
                        $default_cta_button_text = get_field('chapter_cta_button_text', 'option');

                        if ($single_cta_heading) :
                        ?>
                            <h3><?php echo esc_html($single_cta_heading); ?></h3>
                        <?php else : ?>
                            <h3><?php echo esc_html($default_cta_heading); ?></h3>
                        <?php endif; ?>
                    </div>
                    <div class="chapter_cta_btn">
                        <?php
                        if ($single_cta_button_url) :
                        ?>
                            <a href="<?php echo esc_html($single_cta_button_url); ?>">
                                <?php echo esc_html($single_cta_button_text); ?>
                                <i class="fa fa-chevron-right"></i>
                            </a>
                        <?php else : ?>
                            <a href="<?php echo esc_html($default_cta_button_url); ?>">
                                <?php echo esc_html($default_cta_button_text); ?>
                                <i class="fa fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                echo '<a href="' . esc_url(get_term_link($term)) . '" class="chapter_back_btn" title="Back to Chapters"><i class="fa fa-chevron-left"></i></a>';
            }
        }
        ?>
</div>
<?php
$post_id = get_the_ID();
?>
<script>
	const targetElement = document.querySelector('.single_module_post_content');
	const triggerElement = document.querySelector('.single_module_table_content');

	window.addEventListener('scroll', () => {
			const scrollTop = window.scrollY;
			const scrollDistance = 0;
			if (scrollTop > scrollDistance) {
				triggerElement.classList.add('scrolledd');
			} else {
				triggerElement.classList.remove('scrolledd');
			}

			const mainContent = document.querySelector('#main-content');
			const mainContentHeight = mainContent.clientHeight - window.innerHeight;
			const progress = (scrollTop / mainContentHeight) * 100;

			document.getElementById('progress-bar').style.width = `${progress}%`;

			if (progress >= 90) {
				triggerElement.classList.add('module_completed');
			} else {
				triggerElement.classList.remove('module_completed');
			}

		});
	const tocElement = document.getElementById('ez-toc-container');
	const tocNav = document.querySelector('.ez-toc-list');
	const tocInsideNav = document.querySelector('#ez-toc-container a');
	const tocTitle = document.querySelector('.ez-toc-title');
	const titleContainers = document.querySelector('.ez-toc-title-container');
	const mainBody = document.querySelector('html');

	function handleTOCsmallerScreen() {
		if (window.innerWidth < 1201 && tocElement) {
			tocElement.classList.add('toc_close');
			tocNav.style.display = 'none';
			tocInsideNav.addEventListener('click', function(event) {
				if (event.target === this) {
					tocNav.style.display = 'none';
					mainBody.classList.remove('has-off-canvas-right', 'has-off-canvas');
				}
			});
			const tocItems = document.querySelectorAll('.ez-toc-list a');
			tocItems.forEach((item) => {
				item.addEventListener('click', function() {
					tocNav.style.display = 'none';
					mainBody.classList.remove('has-off-canvas-right', 'has-off-canvas');
				});
			});
			titleContainers.addEventListener('click', function() {
				if (tocNav.style.display === "none" || tocNav.style.display === "") {
					tocNav.style.display = "block";
					mainBody.classList.add('has-off-canvas-right', 'has-off-canvas');
				} else {
					tocNav.style.display = "none";
					mainBody.classList.remove('has-off-canvas-right', 'has-off-canvas');
				}
			});
		}

	}
	handleTOCsmallerScreen();
	window.addEventListener('resize', handleTOCsmallerScreen);

	const headingsToProcess = document.querySelectorAll('.single_module_post_content .content h2, .single_module_post_content .content h3, .single_module_post_content .content h4, .single_module_post_content .content h5, .single_module_post_content .content h6');

	headingsToProcess.forEach((heading) => {
		const spanElement = document.createElement('span');

		let headingText = heading.textContent.replace(/\s+/g, '_').replace(/[.\[\]{}()?;:\u00A0]/g, '');

		headingText = headingText.replace(/_+$/, '');

		spanElement.className = 'ez-toc-section';
		spanElement.id = headingText;
		spanElement.setAttribute('ez-toc-data-id', `#${headingText}`);

		heading.insertBefore(spanElement, heading.firstChild);

		const endSpan = document.createElement('span');
		endSpan.className = 'ez-toc-section-end';


		heading.appendChild(endSpan);
	});
	document.addEventListener("DOMContentLoaded", function() {
		var current_text = document.querySelector(".single_module_title").textContent;

		// document.querySelector(".share_twitter").addEventListener("click", function() {
		//     ga('send', 'event', 'Social Sharing on Academy', 'Click', 'Twitter');
		//     var current_page_url = window.location.href;
		//     window.open('http://twitter.com/share?text=' + encodeURIComponent(current_text) + '&url=' + encodeURIComponent(current_page_url) + '&utm-medium=social&utm-source=Twitter&utm-campaign=Academy', "", "width=600,height=400");
		// });

		// document.querySelector(".share_facebook").addEventListener("click", function() {
		//     ga('send', 'event', 'Social Sharing on Academy', 'Click', 'Facebook');
		//     var current_page_url = window.location.href;
		//     window.open('https://www.facebook.com/sharer.php?text=' + encodeURIComponent(current_text) + '&u=' + encodeURIComponent(current_page_url) + '&utm-medium=social&utm-source=Facebook&utm-campaign=Academy', "", "width=600,height=400");
		// });

		document.querySelector(".share_whatsapp").addEventListener("click", function() {
			// ga('send', 'event', 'Social Sharing on Academy', 'Click', 'WhatsApp');
			var current_page_url = window.location.href;
			window.open('https://wa.me/?text=' + encodeURIComponent(current_text + " , " + current_page_url) + '&utm-medium=social&utm-source=WhatsApp&utm-campaign=Academy', "_blank");
		});
	});

	function addAttributesToExternalLinks() {
		var dynamicContent = document.getElementById('main');
		if (dynamicContent) {
			var anchorTags = dynamicContent.querySelectorAll('a');

			anchorTags.forEach(function(anchorTag) {
				var href = anchorTag.getAttribute('href');
				var isExternal = /^https?:\/\//.test(href) && !href.includes('vestedfinance.com/');

				if (isExternal) {
					anchorTag.setAttribute('target', '_blank');
					anchorTag.setAttribute('rel', 'noindex, nofollow');
				}
			});
		}
	}


	addAttributesToExternalLinks();

	if (document.querySelector('.takeways')) {
		var newLi = document.createElement('li');
		newLi.className = 'ez-toc-page-1 ez-toc-heading-level-2';
		var newLink = document.createElement('a');
		newLink.className = 'ez-toc-link ez-toc-heading-2';
		newLink.href = '#Key_Takeaways';
		newLink.title = 'Key Takeaways';
		newLink.textContent = 'Key Takeaways';
		newLi.appendChild(newLink);
		var ul = document.querySelector('.ez-toc-list');
		ul.appendChild(newLi);
	}
</script>
<?php endwhile; ?>
<script>
    var elements = document.querySelectorAll('.single_module_content_wrapper img');

    // Loop through the elements and add the class 'modal-target' to each of them
    elements.forEach(function(element) {
        element.classList.add('modal-target');
    });
    // Modal Setup
    var modal = document.getElementById('modal');

    var modalClose = document.getElementById('modal-close');
    modalClose.addEventListener('click', function() {
        modal.style.display = "none";
        document.querySelector('html').classList.remove('open-image-modal');
    });
    modal.addEventListener('click', function() {
        modal.style.display = "none";
        document.querySelector('html').classList.remove('open-image-modal');
    });

    // global handler
    document.addEventListener('click', function(e) {
        if (e.target.className.indexOf('modal-target') !== -1) {
            var img = e.target;
            var modalImg = document.getElementById("modal-content");
            var captionText = document.getElementById("modal-caption");
            modal.style.display = "block";
            modalImg.src = img.src;
            captionText.innerHTML = img.alt;
            document.querySelector('html').classList.add('open-image-modal');
        }
    });
    var shareButton = document.querySelector(".share-btn");
    var shareOverlay = document.querySelector(".social-overlay");

    shareButton.addEventListener("click", function() {
        shareButton.classList.add("show");
        document.querySelector('html').classList.add('social-open');
    });

    shareOverlay.addEventListener("click", function() {
        shareButton.classList.remove("show");
        document.querySelector('html').classList.remove('social-open');
    });

    // var currentURL = window.location.href;
    // console.log(currentURL);

    document.addEventListener("DOMContentLoaded", function() {
        var copyButton = document.getElementById("copyLink");
        var spanElement = document.querySelector("#copyLink span");

        copyButton.addEventListener("click", function(event) {
            event.preventDefault();
            // Get the current URL
            var currentURL = window.location.href;

            // Create a temporary input element to copy the URL to the clipboard
            var tempInput = document.createElement("input");
            tempInput.value = currentURL;
            document.body.appendChild(tempInput);

            // Select and copy the text
            tempInput.select();
            document.execCommand("copy");

            // Remove the temporary input element
            document.body.removeChild(tempInput);

            // Provide feedback to the user (e.g., alert or change button text)
            spanElement.innerHTML = "Copied";
            setTimeout(function() {
                document.querySelector('html').classList.remove('social-open');
                spanElement.innerHTML = "Copy link";
            }, 1000); // 4-second delay
        });
    });
    window.onscroll = function() {
        // Code to execute when the user scrolls
        document.querySelector('html').classList.remove('social-open');
    };
    // 

    const BlogData = {
       title: '<?php the_title();?>',
       url: '<?php the_permalink(); ?>',
    }
   
     const btn = document.querySelector('.sharing-icon');
   
     // Share must be triggered by "user activation"
     btn.addEventListener('click', async () => {
       try {
         if(navigator.canShare 
             && typeof navigator.canShare === 'function' 
             && navigator.canShare(BlogData)){
           let result = await navigator.share(BlogData);
           document.getElementById("status").innerText = result || '';
         } else {
           document.getElementById("status").innerText = "Sharing selected data not supported.";
         }
       } catch(err) {
         document.getElementById("status").innerText = "Share not complete";
       }
     });
</script>
<?php get_footer(); ?>
