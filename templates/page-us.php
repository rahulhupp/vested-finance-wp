<?php
/*
Template name: Page - US Page
*/
get_header(); ?>

<div class="gi-joe-page-container">
    <?php
    $header_logo = get_field('header_logo');
    $header_menu = get_field('header_menu');
    ?>
    <div class="custom-header">
        <div class="container flex align_center justify_between">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="siite-logo flex">
                <?php if ($header_logo): ?>
                    <img src="<?php echo esc_url($header_logo['url']); ?>"
                        alt="<?php echo esc_attr($header_logo['alt']); ?>" class="img-full">
                <?php endif; ?>
            </a>
            <nav>
                <ul class="flex align_center justify_end">
                    <?php if (have_rows('header_menu')): ?>
                        <?php while (have_rows('header_menu')):
                            the_row();
                            $menu_item_label = get_sub_field('navigation_label');
                            $menu_item_url = get_sub_field('navigation_url');
                        ?>
                            <li><a href="<?php echo esc_url($menu_item_url); ?>"><?php echo esc_html($menu_item_label); ?></a>
                            </li>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <?php
    $hero_title_before = get_field('hero_title_before');
    $hero_title_image = get_field('hero_title_image');
    $hero_title_after = get_field('hero_title_after');
    $hero_description = get_field('hero_description');
    $primary_button_text = get_field('primary_button_text');
    $primary_button_link = get_field('primary_button_link');
    $secondary_button_text = get_field('secondary_button_text');
    ?>
    <section class="hero-banner">
        <div class="container flex flex_col align_center text_center">
            <div class="inner-box text_center">
                <h1>
                    <span><?php echo esc_html($hero_title_before); ?></span>
                    <?php if ($hero_title_image): ?>
                        <img src="<?php echo esc_url($hero_title_image['url']); ?>"
                            alt="<?php echo esc_attr($hero_title_image['alt']); ?>">
                    <?php endif; ?>
                    <span><?php echo esc_html($hero_title_after); ?></span>
                </h1>
                <p><?php echo esc_html($hero_description); ?></p>
                <div class="cta-buttons flex flex_col align_center">
                    <?php if ($primary_button_text && $primary_button_link): ?>
                        <a href="<?php echo esc_url($primary_button_link); ?>" class="primaryBtn" target="_blank"
                            rel="noopener noreferrer">
                            <span><?php echo esc_html($primary_button_text); ?></span>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 17.5L17 7.5" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M7 7.5H17V17.5" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php if ($secondary_button_text): ?>
                        <a href="javascript:void(0)" class="linkBtn" id="accredited-investors-btn">
                            <span><?php echo esc_html($secondary_button_text); ?></span>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 16.5V12.5M12 8.5H12.01M22 12.5C22 18.0228 17.5228 22.5 12 22.5C6.47715 22.5 2 18.0228 2 12.5C2 6.97715 6.47715 2.5 12 2.5C17.5228 2.5 22 6.97715 22 12.5Z"
                                    stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="bg-animation">
            <svg class="svg-full" width="1440" height="816" viewBox="0 0 1440 816" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <line x1="146" y1="649" x2="146" y2="816" stroke="url(#paint0_linear_233_2363)" />
                <line x1="260" y1="665" x2="260" y2="816" stroke="url(#paint1_linear_233_2363)" />
                <line x1="375" y1="629" x2="375" y2="816" stroke="url(#paint2_linear_233_2363)" />
                <line x1="490" y1="642.003" x2="489" y2="816.003" stroke="url(#paint3_linear_233_2363)" />
                <line x1="604" y1="607" x2="604" y2="816" stroke="url(#paint4_linear_233_2363)" />
                <line x1="718" y1="616" x2="718" y2="816" stroke="url(#paint5_linear_233_2363)" />
                <line x1="832" y1="589" x2="832" y2="816" stroke="url(#paint6_linear_233_2363)" />
                <line x1="947" y1="526" x2="947" y2="816" stroke="url(#paint7_linear_233_2363)" />
                <line x1="1061" y1="509" x2="1061" y2="816" stroke="url(#paint8_linear_233_2363)" />
                <line x1="1176" y1="443" x2="1176" y2="815" stroke="url(#paint9_linear_233_2363)" />
                <line x1="1290" y1="413" x2="1290" y2="816" stroke="url(#paint10_linear_233_2363)" />
                <path id="animationPath"
                    d="M0 678L146 649.5L260 664.5L375 629L489 642L604 606.5L718 616.5L832 588.5L947 526L1061 509L1176 443L1290 413L1439.5 366"
                    stroke="url(#paint11_linear_233_2363)" />
                <circle id="circle1" cx="0" cy="0" r="4" fill="#0AD1FE" />
                <circle id="circle2" cx="0" cy="0" r="4" fill="#0AD1FE" />
                <line opacity="0.1" x1="146.5" y1="746" x2="146.5" y2="2.16373e-08" stroke="#595959" />
                <line opacity="0.1" x1="260.5" y1="746" x2="260.5" y2="2.16373e-08" stroke="#595959" />
                <line opacity="0.1" x1="375.5" y1="746" x2="375.5" y2="2.16373e-08" stroke="#595959" />
                <line opacity="0.1" x1="489.5" y1="746" x2="489.5" y2="2.16373e-08" stroke="#595959" />
                <line opacity="0.1" x1="604.5" y1="746" x2="604.5" y2="2.16373e-08" stroke="#595959" />
                <line opacity="0.1" x1="718.5" y1="746" x2="718.5" y2="2.04572e-08" stroke="#595959" />
                <line opacity="0.1" x1="832.5" y1="746" x2="832.5" y2="2.16373e-08" stroke="#595959" />
                <line opacity="0.1" x1="947.5" y1="746" x2="947.5" y2="2.16373e-08" stroke="#595959" />
                <line opacity="0.1" x1="1061.5" y1="746" x2="1061.5" y2="2.16373e-08" stroke="#595959" />
                <line opacity="0.1" x1="1176.5" y1="746" x2="1176.5" y2="2.16373e-08" stroke="#595959" />
                <line opacity="0.1" x1="1290.5" y1="746" x2="1290.5" y2="2.16373e-08" stroke="#595959" />
                <g opacity="0.6" filter="url(#filter0_f_233_2363)">
                    <ellipse cx="720" cy="245" rx="441" ry="240" fill="white" />
                </g>
                <defs>
                    <filter id="filter0_f_233_2363" x="247.5" y="-26.5" width="945" height="543"
                        filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                        <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape" />
                        <feGaussianBlur stdDeviation="15.75" result="effect1_foregroundBlur_233_2363" />
                    </filter>
                    <linearGradient id="paint0_linear_233_2363" x1="145" y1="649" x2="145" y2="816"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#57B1FF" />
                        <stop offset="1" stop-color="#57B1FF" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="paint1_linear_233_2363" x1="259" y1="665" x2="259" y2="816"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#57B1FF" />
                        <stop offset="1" stop-color="#57B1FF" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="paint2_linear_233_2363" x1="374" y1="629" x2="374" y2="816"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#57B1FF" />
                        <stop offset="1" stop-color="#57B1FF" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="paint3_linear_233_2363" x1="489" y1="641.997" x2="488" y2="815.997"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#57B1FF" />
                        <stop offset="1" stop-color="#57B1FF" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="paint4_linear_233_2363" x1="603" y1="607" x2="603" y2="816"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#57B1FF" />
                        <stop offset="1" stop-color="#57B1FF" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="paint5_linear_233_2363" x1="717" y1="616" x2="717" y2="816"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#57B1FF" />
                        <stop offset="1" stop-color="#57B1FF" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="paint6_linear_233_2363" x1="831" y1="589" x2="831" y2="816"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#57B1FF" />
                        <stop offset="1" stop-color="#57B1FF" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="paint7_linear_233_2363" x1="946" y1="526" x2="946" y2="816"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#57B1FF" />
                        <stop offset="1" stop-color="#57B1FF" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="paint8_linear_233_2363" x1="1060" y1="509" x2="1060" y2="816"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#57B1FF" />
                        <stop offset="1" stop-color="#57B1FF" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="paint9_linear_233_2363" x1="1175" y1="443" x2="1175" y2="815"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#57B1FF" />
                        <stop offset="1" stop-color="#57B1FF" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="paint10_linear_233_2363" x1="1289" y1="413" x2="1289" y2="816"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#57B1FF" />
                        <stop offset="1" stop-color="#57B1FF" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="paint11_linear_233_2363" x1="0" y1="522" x2="1439.5" y2="522"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="white" stop-opacity="0" />
                        <stop offset="0.101833" stop-color="#4F9FE5" />
                        <stop offset="0.898173" stop-color="#4F9FE5" />
                        <stop offset="1" stop-color="white" stop-opacity="0" />
                    </linearGradient>
                </defs>
            </svg>
        </div>
    </section>

    <?php
    $testimonials_title = get_field('testimonials_title');
    $testimonials = get_field('testimonial_slides');
    ?>
    <section class="testimonials">
        <div class="text_center container">
            <h2><?php echo esc_html($testimonials_title); ?></h2>
        </div>
        <?php if ($testimonials): ?>
            <div class="us-testimonials-slider">
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="testimonial-card">
                        <div class="description">
                            <p><?php echo esc_html($testimonial['leaders_description']); ?></p>
                        </div>
                        <div class="leaders-info">
                            <figure class="profile">
                                <img src="<?php echo esc_url($testimonial['leaders_profile_image']['url']); ?>"
                                    alt="<?php echo esc_attr($testimonial['leaders_profile_image']); ?>">
                            </figure>
                            <h3><?php echo esc_html($testimonial['leaders_name']); ?></h3>
                            <p><?php echo esc_html($testimonial['leaders_info']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <?php
    $county_info_section_title = get_field('county_info_section_title');
    $information_cards = get_field('information_cards');
    $india_in_numbers_card_title = get_field('india_in_numbers_card_title');
    $numbers_cards = get_field('numbers_cards');
    ?>
    <section class="county-info">
        <div class="container">
            <div class="text_center">
                <h2><?php echo esc_html($county_info_section_title); ?></h2>
            </div>
            <?php if ($information_cards): ?>
                <div class="chart-grid flex justify_between">
                    <?php foreach ($information_cards as $card): ?>
                        <div class="card col_2">
                            <div class="card-info">
                                <h3><?php echo esc_html($card['card_title']); ?></h3>
                                <p><?php echo esc_html($card['card_description']); ?></p>
                            </div>
                            <?php if (!empty($card['card_image'])): ?>
                                <div class="chart">
                                    <img src="<?php echo esc_url($card['card_image']['url']); ?>"
                                        alt="<?php echo esc_attr($card['card_title']); ?>" class="img-full" loading="lazy">
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    <div class="card col_2 numbers">
                        <div class="card-info">
                            <h3><?php echo esc_html($india_in_numbers_card_title); ?></h3>
                        </div>
                        <?php if ($numbers_cards): ?>
                            <div class="icon-cards">
                                <?php foreach ($numbers_cards as $innerCard): ?>
                                    <div class="card">
                                        <figure>
                                            <img src="<?php echo esc_url($innerCard['numbers_card_icon']['url']); ?>" alt="Icon"
                                                lass="img-full" loading="lazy">
                                        </figure>
                                        <div class="description">
                                            <p><?php echo wp_kses_post($innerCard['numbers_card_description']); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php
    $why_choose_us_title = get_field('why_choose_us_title');
    $why_choose_us_cards = get_field('why_choose_us_cards');
    ?>
    <section class="why-choose-us">
        <div class="container ">
            <div class="text_center">
                <h2><?php echo esc_html($why_choose_us_title); ?></h2>
            </div>
            <?php if ($why_choose_us_cards): ?>
                <div class="icon-cards text_center">
                    <?php foreach ($why_choose_us_cards as $card): ?>
                        <div class="card">
                            <figure>
                                <img src="<?php echo esc_url($card['why_choose_us_card_icon']['url']); ?>" alt="Icon"
                                    lass="img-full" loading="lazy">
                            </figure>
                            <div class="description">
                                <p><?php echo wp_kses_post($card['why_choose_us_card_info']); ?></p>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php
    $join_the_waitlist_bg_image = get_field('join_the_waitlist_bg_image');
    $join_the_waitlist_title = get_field('join_the_waitlist_title');
    $join_the_waitlist_description = get_field('join_the_waitlist_description');
    $cta_button_text = get_field('cta_button_text');
    $cta_button_url = get_field('cta_button_url');
    ?>
    <section class="waitlist">
        <div class="container">
            <div class="inner-box" style="--bg-img: url('<?php echo esc_url($join_the_waitlist_bg_image['url']); ?>');">
                <div class="col_2">
                    <h2><?php echo esc_html($join_the_waitlist_title); ?></h2>
                    <p><?php echo esc_html($join_the_waitlist_description); ?></p>
                    <a href="<?php echo esc_url($cta_button_url) ?>" class="secondaryBtn" target="_blank"
                        rel="noopener noreferrer">
                        <span><?php echo esc_html($cta_button_text); ?></span>
                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 17.5L17 7.5" stroke="#002852" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M7 7.5H17V17.5" stroke="#002852" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php
    $blog_posts_section_title = get_field('blog_posts_section_title');
    $blog_posts = get_field('blog_posts');
    ?>
    <section class="post-type-list">
        <div class="container">
            <?php if (!empty($blog_posts_section_title)): ?>
                <div class="text_center">
                    <h2><?php echo esc_html($blog_posts_section_title); ?></h2>
                </div>
            <?php endif; ?>
            <?php if (!empty($blog_posts)): ?>
                <div class="post-list">
                    <?php foreach ($blog_posts as $index => $card): ?>
                        <div class="post <?php echo $index >= 4 ? 'hidden' : ''; ?>">
                            <?php if (!empty($card['blog_post_image']['url'])): ?>
                                <a href="<?php echo esc_url($card['blog_post_link']) ?>" class="post-thumbnail" target="_blank"
                                    rel="noopener noreferrer">
                                    <img src="<?php echo esc_url($card['blog_post_image']['url']); ?>"
                                        alt="<?php echo esc_attr($card['blog_post_title'] ?? 'Post image'); ?>" class="img-full"
                                        loading="lazy">
                                </a>
                            <?php endif; ?>
                            <div class="post-info">
                                <h3>
                                    <a href="<?php echo esc_url($card['blog_post_link']) ?>" target="_blank"
                                        rel="noopener noreferrer">
                                        <?php echo esc_html($card['blog_post_title'] ?? 'Untitled Post'); ?>
                                    </a>
                                </h3>
                                <?php if (!empty($card['blog_post_author_name'])): ?>
                                    <div class="post-by">by <?php echo esc_html($card['blog_post_author_name']); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (count($blog_posts) > 4): ?>
                <a href="javascript:void(0)" class="mx_auto primaryBtn" id="loadMorePost">View All</a>
            <?php endif; ?>
        </div>
    </section>

    <?php
    $popover_title = get_field('popover_title');
    $popover_title_description = get_field('popover_title_description');
    ?>
    <div class="popover-wrapper" id="accredited-investors-popover">
        <div class="overly"></div>
        <div class="popover-inner-box">
            <a href="javascript:void(0)" class="close ml_auto flex popover-close-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="#002852" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>
            <h2><?php echo esc_html($popover_title) ?></h2>
            <?php echo wp_kses_post($popover_title_description); ?>
        </div>
    </div>
    <div class="custom-footer">
        <div class="container">
            <div class="footer_above">
                <a href="<?php echo site_url() ?>">
                    <?php
                    $image = get_field('site_logo', 'option');
                    if (!empty($image)): ?>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                    <?php endif; ?>
                </a>
                <p class="footer_address"><?php echo esc_html(get_field('custom_footer_address')); ?></p>
                <a href="<?php echo esc_url(get_field('custom__contact_us_url')); ?>" class="btn_url"
                    target="_blank">Contact
                    us</a>
            </div>
            <div class="footer_bottom">
                <div class="disclosure_heading">
                    <h3><?php echo esc_html(get_field('custom_footer_disclosure_title')); ?></h3>
                    <?php
                    $icon = get_field('custom_footer_disclosure_icon');
                    if (!empty($icon)): ?>
                        <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>"
                            width="27" height="27">
                    <?php endif; ?>
                </div>
                <div class="disclosure_content">
                    <?php echo wp_kses_post(get_field('custom_footer_disclosure_content')); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>
<script src="https://unpkg.com/gsap@3/dist/MotionPathPlugin.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        getUserLocationByIP();
    });

    function getUserLocationByIP() {
        fetch('https://ipinfo.io/json')
            .then(response => response.json())
            .then(data => {
                console.log('User location based on IP:', data);
                var globalBanner = document.querySelector(".geolocation_banner");
                if (globalBanner) {
                    globalBanner.style.display = "flex";
                    if (data.country === "IN") {
                        globalBanner.innerHTML = "<div class='content'><p>You're on our USA website. Visit the India website to explore our India-specific products.</p></div><a href='<?php echo home_url('/in') ?>'><img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/india.png'>India</a>";
                    } else if (data.country === "US") {
                        globalBanner.innerHTML = "<div class='content'><p>Looking for our US stocks offering? </p></div><a href='<?php echo site_url(); ?>'>Visit here</a>";
                        console.log('hide geolocation_banner');
                    } else {
                        globalBanner.innerHTML = "<div class='content'><p>You're on our USA website. Visit the Global website to explore our US Stocks offering.</p></div><a href='<?php echo home_url('/') ?>'><img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/global.png'>Visit</a>";
                    }
                }
            })
            .catch(error => {
                console.error('Error getting user location based on IP:', error);
            });
    }
</script>
<?php get_footer() ?>