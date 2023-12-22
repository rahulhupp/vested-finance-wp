<?php
/*
    Template name: Edge Page Template
*/
get_header(); ?>
<div id="content" role="main" class="edge-page">
    <section class="edge_banner">
        <div class="container">
            <div class="banner_wrapper">
                <div class="banner_content">
                    <div class="sub_heading">
                        <div class="sub_heading_icon">
                            <?php
                             $image = get_field('banner_sub_heading_icon');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                                            <?php endif; ?>
                        </div>
                        <h3><?php the_field('banner_sub_heading'); ?></h3>
                    </div>
                    <h1><?php the_field('banner_heading'); ?></h1>
                    <?php if (have_rows('banner_edge_list')) : ?>
                        <ul class="banner_list">
                            <?php while (have_rows('banner_edge_list')) : the_row(); ?>
                                <?php
                                    $edgeSingleItem = get_sub_field('edge_single_item');
                                    $edgeSingleItem = str_replace('?', '₹', $edgeSingleItem);
                                ?>
                                <li><?php echo $edgeSingleItem; ?></li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                    <div class="banner_buttons">
                        <div class="btn">
                            <a href="<?php the_field('banner_button_one_url'); ?>" class="btn_dark"><?php the_field('banner_button_one_text'); ?></a>
                        </div>
                    </div>

                </div>
                <div class="banner_img">
                <?php
                 $image = get_field('banner_image');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                                            <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="smart_diversification">
        <div class="container">
            <div class="smart_diversification_content">
                <h2 class="section_title align_left"><span><?php the_field('smart_heading'); ?></span></h2>
                <p class="smart_desc"><?php the_field('description'); ?></p>
            </div>
            <div class="smart_diversification_img">
                 <?php
                 $image = get_field('smart_image');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" class="mobile_hide" />
                                            <?php endif; ?>

                                            <?php
                 $image = get_field('smart_image_mob');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" class="desktop_hide" />
                                            <?php endif; ?>
            </div>


        </div>
    </section>
    <section class="interest_rates_sec">
        <div class="container">
            <div class="interest_block">
                 <?php
                 $image = get_field('return_image');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" class="mobile_hide" />
                                            <?php endif; ?>

                                            <?php
                 $image = get_field('return_image_mob');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" class="desktop_hide" />
                                            <?php endif; ?>
            </div>
        </div>
    </section>
    <?php if (have_rows('investment_plans')) : ?>
        <section class="money_plans">
            <div class="container">
                <div class="money_plans_content">
                    <h2 class="section_title"><span><?php the_field('investment_heading'); ?></span></h2>
                    <p class="smart_desc align_center"><?php the_field('investment_sub_heading'); ?></p>

                    <div class="plans_wrap">
                        <?php while (have_rows('investment_plans')) : the_row(); ?>
                            <div class="single_plan">
                                <div class="plan_head">
                                    <div class="plan_icon">
                                         <?php
                                        $image = get_sub_field('plan_icon');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                                            <?php endif; ?>

                                    </div>
                                    <div class="return_rates">
                                        <div>
                                            <h5><?php the_sub_field('returns_pa') ?>%</h5>
                                            <p><?php the_sub_field('returns_duration') ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="plan_detail">
                                    <h3 class="plan_title"><?php the_sub_field('investment_plan_title') ?></h3>
                                    <?php if (!empty(get_sub_field('offer_label'))) { 
                                        ?>
                                        <div class="offer_label">
                                            <div class="image_label">
                                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/balance.webp" />
                                                <span><?php the_sub_field('offer_label') ?></span>
                                            </div>
                                        </div>
                                        <?php 
                                    } ?>
                                    <?php if (have_rows('plan_detail_list')) : ?>
                                        <ul class="plans_list">
                                            <?php while (have_rows('plan_detail_list')) : the_row(); ?>
                                                <li><?php the_sub_field('plan_single_list') ?></li>
                                            <?php endwhile; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <div class="investment_value_row">
                                        <h4 class="investment_val_name">Min investment</h4>
                                        <h5 class="investment_val"> &#8377; <?php the_sub_field('min_investment_value') ?></h5>
                                    </div>
                                    <div class="investment_value_row">
                                        <h4 class="investment_val_name">Lock-in</h4>
                                        <h5 class="investment_val"><?php the_sub_field('lock-in_period') ?></h5>
                                    </div>
                                    <div class="add_invest_btn">
                                        <a href="<?php the_sub_field('investment_button_url') ?>"><?php the_sub_field('investment_button_text') ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>

                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <section class="fd_calc_sec">
        <div class="container">
            <div class="fd_calc_content">
                <h2 class="section_title align_left"><span><?php the_field('interest_calc_heading'); ?></span></h2>
                <div class="fd_calc_wrap">
                    <div class="fd_calc_col">
                        <div class="fd_calc">
                            <h4 class="calc_heading">Investment amount</h4>
                            <form class="fd_calc_form" onsubmit="return false;">
                                <div class="fd_calc_slide">
                                    <input type="text" id="investment_amt" value="50000">
                                    <input type="range" id="investment_range" value="50000" min="20000" max="5000000" oninput="investment_amt.value = '₹' + investment_range.value">
                                </div>
                                <div class="fd_plan_select">
                                    <h4>Select Plan</h4>
                                    <div class="plan_selection">
                                        <div class="single_plan_button">
                                            <input type="radio" name="plan-selection" id="liquid-plan" value="9">
                                            <label for="liquid-plan">Liquid</label>
                                        </div>
                                        <div class="single_plan_button">
                                            <input type="radio" name="plan-selection" id="fixed-term" value="12" checked>
                                            <label for="fixed-term">Fixed Term</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="fd_plan_select">
                                    <h4>Select Tenure</h4>
                                    <div class="plan_selection">
                                        <div class="single_tenure_button">
                                            <input type="radio" name="tenure-selection" id="three-month" value="3">
                                            <label for="three-month">3M</label>
                                        </div>
                                        <div class="single_tenure_button">
                                            <input type="radio" name="tenure-selection" id="six-month" value="6">
                                            <label for="six-month">6M</label>
                                        </div>
                                        <div class="single_tenure_button">
                                            <input type="radio" name="tenure-selection" id="one-year" value="12" checked>
                                            <label for="one-year">1Y</label>
                                        </div>
                                        <div class="single_tenure_button">
                                            <input type="radio" name="tenure-selection" id="two-year" value="24">
                                            <label for="two-year">2Y</label>
                                        </div>
                                        <div class="single_tenure_button">
                                            <input type="radio" name="tenure-selection" id="three-year" value="36">
                                            <label for="three-year">3Y</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="fd_result_col">
                    <div class="fd_result" id="fd_results">
                            <div class="result_row">
                            <div class="result_interest_val">
                                <h3><span>&#8377;</span> <span class="extra_interest">&nbsp;3,000</span></h3>
                                <p>Extra Interest</p>
                            </div>
                            <div class="other_result_wrap">
                                <div class="other_result_val">
                                    <div class="other_result_single">
                                        <h3><span>&#8377;</span> <span class="other_interest fd_interest">&nbsp;6,000</span></h3>
                                        <p>Interest on FD <br>@6%</p>
                                    </div>
                                </div>
                                <div class="other_result_val">
                                    <div class="other_result_single">
                                        <h3><span>&#8377;</span> <span class="other_interest liquid_interest">&nbsp;9,000</span></h3>
                                        <p>Interest from Edge <br>@<span id="plan-selected"></span>%</p>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if (have_rows('edge_list')) : ?>
        <section class="vested_edge_list">
            <div class="container">
                <div class="edge_list_row">
                    <h2 class="section_title light"><?php the_field('edge_heading'); ?></h2>
                    <div class="edge_list_content">
                        <div class="edge_list_wrap">
                            <?php while (have_rows('edge_list')) : the_row(); ?>
                                <div class="single_edge_list">
                                    <div class="edge_list_icon">
                                        <?php
                                        $image = get_sub_field('edge_list_icon');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                                            <?php endif; ?>
                                    </div>
                                    <p class="edge_content">
                                        <?php the_sub_field('edge_list_description') ?>
                                    </p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    <?php endif; ?>
    <?php if (have_rows('portfolio_slider')) : ?>
        <section class="portfolio_slider_sec">
            <div class="container">
                <h2 class="section_title">
                    <span><?php the_field('portfolio_heading'); ?></span>
                </h2>
                <div class="portfolio_slider_wrap">
                    <div class="portfolio_slider slider single-item">
                        <?php while (have_rows('portfolio_slider')) : the_row(); ?>
                            <div class="single_portfolio_slider">
                                 <?php
                                        $image = get_sub_field('slider_image');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                                            <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <?php if (have_rows('portfolio_slider')) : ?>
                        <div class="portfolio_slider_content">
                            <?php while (have_rows('portfolio_slider')) : the_row(); ?>
                                <div class="single_portfolio_slider_content">
                                    <div class="portfolio_slider_content_inner">
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBar"></span>
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBarMob"></span>
                                        <div class="portfolio_slider_inner_content">
                                            <span class="slider_index">0<?php echo get_row_index(); ?></span>
                                            <h3><?php the_sub_field('slider_title') ?></h3>
                                            <p class="single_slider_desc">
                                                <?php the_sub_field('slider_description') ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
     <?php /*                       
    <section class="invest_wisely_sec">
        <div class="container">
            <h2 class="section_title"><span><?php the_field('invest_wisely_heading'); ?></span></h2>
            <?php if (have_rows('learning_list')) : ?>
                <div class="invest_wisely_wrap">
                    <?php while (have_rows('learning_list')) : the_row(); ?>
                        <div class="single_wisely_list">
                            <div class="single_wisely_img">
                                <img src="<?php the_sub_field('learning_image') ?>" alt="<?php the_sub_field('learning_title') ?>">
                            </div>
                            <div class="single_wisely_content">
                                <h3><?php the_sub_field('learning_title') ?></h3>
                                <p><?php the_sub_field('learning_description') ?></p>
                                <a href="<?php the_sub_field('learning_cta_url') ?>" class="btn_dark"><?php the_sub_field('learning_cta_text') ?></a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="invest_module_sec">
            <div class="container">
                <?php
                // Get the current term
                $term = 'peer-to-peer-lending';

                // Create a custom query to retrieve posts from the "module" post type with the current term
                $args = array(
                    'post_type' => 'module',
                    'posts_per_page' => 3,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'modules_category',
                            'field'    => 'slug', // Use 'slug' or 'id' depending on your preference
                            'terms'    => $term, // Use $term->term_id if you have the ID instead of slug
                        ),
                    ),
                );

                $query = new WP_Query($args);

                if ($query->have_posts()) : ?>
                    <div class="invest_wisely_wrap module_chapter_list">
                        <?php while ($query->have_posts()) :
                            $query->the_post();
                            $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $author_image_url = get_avatar_url(get_the_author_meta('user_email'));
                            $reading_time = calculate_reading_time(get_the_content());
                            $post_date = get_the_date();
                        ?>
                            <div class="single_module_list">
                                <div class="single_module_img">
                                    <img src="<?php echo $featured_image_url; ?>" alt="">
                                </div>
                                <div class="single_module_content">
                                    <div class="module_date">
                                        <span><?php echo $post_date; ?></span>
                                    </div>
                                    <h4><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <div class="author_info">
                                        <div class="reading_time">
                                            <h5><?php echo $reading_time; ?> mins read</h5>
                                        </div>
                                        <div class="author_meta">
                                            <div class="author_img">
                                                <img src="<?php echo $author_image_url; ?>" alt="Author">
                                            </div>
                                            <p class="author_name"><?php the_author(); ?></p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <?php endwhile;
                        wp_reset_postdata(); // Reset the post data 
                        ?>
                    </div>
                <?php else :
                    echo 'No posts found.';
                endif;
                ?>
            </div>
        </div>
        </div>
    </section> */ ?>
<?php if (have_rows('faq_list')) : ?>
    <section class="home_page_faqs">
        <div class="container">
            <h2 class="section_title"><span><?php the_field('faqs_heading'); ?></span></h2>

            <div class="home_page_faq_wrap">
                <?php while (have_rows('faq_list')) : the_row(); ?>
                    <div class="single_faq">
                        <div class="faq_que">
                            <h3>
                                <?php the_sub_field('faq_question') ?>
                            </h3>
                        </div>
                        <div class="faq_content">
                            <?php the_sub_field('faq_answer') ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
</div>
<script type="application/ld+json">
{
  "@context": "https://schema.org/", 
  "@type": "BreadcrumbList", 
  "itemListElement": [{
    "@type": "ListItem", 
    "position": 1, 
    "name": "Vested Finance",
    "item": "https://vestedfinance.com/in/"  
  },{
    "@type": "ListItem", 
    "position": 2, 
    "name": "Vested Edge P2P lending",
    "item": "https://vestedfinance.com/in/vested-edge-p2p-lending/"  
  }]
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "P2P lending - Invest in peer to peer lending in India with Vested Finance",
    "description": "Invest in P2P Lending from India with Vested Finance. Explore How P2P lending works and returns and minimum investments.",
    "publisher": {
        "@type": "Organization",
        "name": "Vested Finance"
    }
},
</script>
<?php if (have_rows('faq_list')) : ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        <?php $rowCount = 0; ?>
        <?php while (have_rows('faq_list')) : the_row(); ?>
            {
                "@type": "Question",
                "name": "<?php the_sub_field('faq_question') ?>",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": '
                        <?php the_sub_field('faq_answer') ?>
                    '
                }
            }<?php echo (++$rowCount === count(get_field('faq_list'))) ? '' : ','; ?>
        <?php endwhile; ?>
    ]
}
</script>
<?php endif; ?>
<?php get_footer(); ?>