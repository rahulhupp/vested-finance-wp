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
    $modified_date = get_the_modified_time('F j, Y');
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
								<a href="<?php echo home_url(); ?>"><?php echo $site_name; ?></a>
							</li>
							<li>
								<a href="<?php echo home_url(); ?>/blog/">Blog</a>
							</li>
							<!-- <li>
								<?php
								if ($terms && !is_wp_error($terms)) {
									foreach ($terms as $term) {
								?>
										<a href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo esc_html($term->name); ?></a>
								<?php
									}
								}
								?>
							</li> -->
							<li>
								<span><?php the_title(); ?></span>
							</li>
						</ul>
					</div>
					<h1 class="single_module_title"><?php the_title(); ?></h1>
					<div class="single_module_meta">
						<div class="single_module_info_item last">
							<div class="social-share-block">
								<button class="sharing-icon">
									<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/share-icon.png" alt="link" />
								</button>
								<button class="share-btn"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/share-icon.png" alt="Share Icon" /><span>Share</span></button>
								<ul>
									<?php
									$current_page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
									?>

									<li>
										<a id="copyLink" href="">
											<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/link.png" alt="link" />
											<span>Copy link</span>
										</a>
									</li>
									<li class="share_whatsapp">
										<a href="javascript:void(0);" target="_blank">
											<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/whatsapp.png" alt="whatsapp" />
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
			</div>	
		</div>
	</div>
	<div class="chapter_cta">
            <div class="container">
                <div class="chapter_cta_wrap">
                    <div class="chapter_cta_content">
                        <div class="vested_logo">
                            <img src="https://vestedfinance.com/wp-content/uploads/2020/09/Vested_logo-2.svg" alt="Vested Finance">
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
$taxonomy = 'modules';

$terms = wp_get_post_terms($post_id, $taxonomy);

if (!is_wp_error($terms) && !empty($terms)) {
	$term_slug = $terms[0]->slug;
}
?>
<script>
	const targetElement = document.querySelector('.single_module_post_content');
	const triggerElement = document.querySelector('.single_module_table_content');

	window.addEventListener('scroll', () => {
		const rect = targetElement.getBoundingClientRect();
		if (rect.top <= 0) {
			triggerElement.classList.add('scrolledd');
		} else {
			triggerElement.classList.remove('scrolledd');
		}

		const scrollTop = window.scrollY;
		const mainContent = document.querySelector('#main-content');
		const mainContentHeight = mainContent.clientHeight - window.innerHeight;
		const progress = (scrollTop / mainContentHeight) * 100;

		const currentId = <?php echo $post_id ?>;

		const storedResumeIds = localStorage.getItem(`visited-module-<?php echo $term_slug; ?>-resume`);
		const storedOverIds = localStorage.getItem(`visited-module-<?php echo $term_slug; ?>-over`);
		const resumeIdArray = storedResumeIds ? JSON.parse(storedResumeIds) : [];
		const overIdArray = storedOverIds ? JSON.parse(storedOverIds) : [];

		if (!resumeIdArray.includes(currentId) && !overIdArray.includes(currentId)) {
			if (progress > 70) {
				resumeIdArray.push(currentId);
				localStorage.setItem(`visited-module-<?php echo $term_slug; ?>-resume`, JSON.stringify(resumeIdArray));
			}
		}

		if (progress > 90 && !overIdArray.includes(currentId)) {
			triggerElement.classList.remove('scrolled');
			const index = resumeIdArray.indexOf(currentId);
			if (index !== -1) {
				resumeIdArray.splice(index, 1);
				overIdArray.push(currentId);
				localStorage.setItem(`visited-module-<?php echo $term_slug; ?>-over`, JSON.stringify(overIdArray));
				localStorage.setItem(`visited-module-<?php echo $term_slug; ?>-resume`, JSON.stringify(resumeIdArray));
			}
		}

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

    const shareIcon = document.querySelector('.sharing-icon');
	shareIcon.addEventListener("click", (e) => { 
	if (navigator.share) {
		navigator.share({
			title: 'Web Share API Draft',
			text: 'Take a look at this spec!',
			url: 'https://wicg.github.io/web-share/#share-method',
		})
		.then(() => console.log('Successful share'))
		.catch((error) => console.log('Error sharing', error));
	} else {
		console.log('Share not supported on this browser, do it the old way.');
	}
	});
</script>
<?php get_footer(); ?>
