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
    $hero_bg_image = get_field('hero_bg_image');
    $hero_title_before = get_field('hero_title_before');
    $hero_title_image = get_field('hero_title_image');
    $hero_title_after = get_field('hero_title_after');
    $hero_description = get_field('hero_description');
    $primary_button_text = get_field('primary_button_text');
    $primary_button_link = get_field('primary_button_link');
    $secondary_button_text = get_field('secondary_button_text');
    ?>
    <section class="hero-banner" style="--bg-img: url('<?php echo esc_url($hero_bg_image['url']); ?>');">
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
                        <a href="<?php echo esc_url($primary_button_link); ?>" class="primaryBtn">
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
            <div class="testimonials-slider">
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
                    <a href="<?php echo esc_url($cta_button_url) ?>" class="secondaryBtn">
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
    $blog_posts_section_button_text = get_field('blog_posts_section_button_text');
    $blog_posts_section_button_url = get_field('blog_posts_section_button_url');
    ?>
    <section class="post-type-list">
        <div class="container">
            <div class="text_center">
                <h2><?php echo esc_html($blog_posts_section_title); ?></h2>
            </div>
            <div class="post-list">
                <?php
                $selected_posts = get_field('select_posts');
                if (is_array($selected_posts) && !empty($selected_posts)) {
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 3,
                        'post__in' => $selected_posts,
                        'orderby' => 'post__in',
                    );
                } else {
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 3,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'master_categories',
                                'field' => 'slug',
                                'terms' => array('us-stocks'),
                            ),
                        ),
                    );
                }
                $custom_query = new WP_Query($args);
                if ($custom_query->have_posts()):
                    while ($custom_query->have_posts()):
                        $custom_query->the_post(); ?>
                        <div class="post">
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="post-thumbnail">
                                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>"
                                    alt="<?php echo esc_attr(get_the_title()); ?>" class="img-full" loading="lazy">
                            </a>
                            <div class="post-info">
                                <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
                                <div class="post-by">by <?php the_author(); ?></div>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata();
                else:
                    echo '<p>No posts found.</p>';
                endif;
                ?>
            </div>
            <a href="<?php echo esc_url($blog_posts_section_button_url) ?>"
                class="mx_auto primaryBtn"><?php echo esc_html($blog_posts_section_button_text); ?></a>
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
</div>

<?php get_footer() ?>