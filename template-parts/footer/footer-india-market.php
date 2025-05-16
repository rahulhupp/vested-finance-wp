<footer>
    <div class="container">
        <div class="footer_wrap">
            <div class="footer_above">
                <div class="footer_above_wrap">
                    <div class="site_info_col">
                        <div class="site_info_wrap">
                            <h2>
                                <a href="<?php echo site_url() ?>">
                                    <?php
                                    $image = get_field('site_logo_in', 'option');
                                    if (!empty($image)): ?>
                                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"/>
                                    <?php endif; ?>
                                </a>
                            </h2>
                            <div class="footer_address">
                                <?php the_field('site_address_in', 'option'); ?>
                            </div>
                            <div class="footer_app_block">
                                <div class="app_wrap">
                                    <div class="single_app">
                                        <a href="<?php the_field('google_play_url_in', 'option'); ?>" target="_blank">
                                            <?php
                                            $image = get_field('google_play_icon_in', 'option');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"/>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="single_app">
                                        <a href="<?php the_field('apple_app_store_url_in', 'option'); ?>" target="_blank">
                                            <?php
                                            $image = get_field('apple_app_store_icon_in', 'option');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"/>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                </div>
                                <?php if (have_rows('social_media_links_in', 'option')) : ?>
                                    <div class="footer_social_wrap">
                                        <?php while (have_rows('social_media_links_in', 'option')) : the_row(); ?>
                                            <a href="<?php the_sub_field('social_media_url_in'); ?>" class="footer_icon" target="_blank">
                                                <?php
                                                $image = get_sub_field('social_media_icon_in');
                                                if (!empty($image)): ?>
                                                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"/>
                                                <?php endif; ?>
                                            </a>
                                        <?php endwhile; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="site_links_col">
                        <?php if (have_rows('footer_links_in', 'option')) : ?>
                            <div class="site_link_wrap">
                                <?php while (have_rows('footer_links_in', 'option')) : the_row(); ?>
                                    <div class="company_links <?php if (get_sub_field('footer_link_heading_in', 'option') === 'Explore Products') : ?> last <?php endif; ?>">
                                        <h3 class="footer_col_title"><?php the_sub_field('footer_link_heading_in'); ?></h3>
                                        <?php if (have_rows('footer_links_list_in', 'option')) : ?>
                                            <ul class="footer_links">
                                                <?php while (have_rows('footer_links_list_in', 'option')) : the_row();
                                                    $footer_link = get_sub_field('footer_link_in', 'option');
                                                    if ($footer_link) :
                                                        $footer_link_url = $footer_link['url'];
                                                        $footer_link_title = $footer_link['title'];
                                                        $footer_link_target = $footer_link['target'] ? $footer_link['target'] : '_self';
                                                ?>
                                                        <li>
                                                            <a href="<?php echo $footer_link_url; ?>" target="<?php echo $footer_link_target; ?>"><?php echo $footer_link_title; ?></a>
                                                        </li>
                                                <?php endif;
                                                endwhile; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="footer_middle">
                <div class="footer_middle_wrap">
                    <h3 class="popular_heading"><?php the_field('popular_heading_in', 'option'); ?></h3>
                    <?php if (have_rows('popular_list_in', 'option')) : ?>
                        <div class="footer_stocks_tabs">
                            <div class="footer_tabs_wrap">
                                <?php while (have_rows('popular_list_in', 'option')) : the_row(); ?>
                                    <div class="single_tab_wrap">
                                        <div class="single_tab_heading">
                                            <h4><?php the_sub_field('popular_category_name_in'); ?>
                                                <?php if (get_sub_field('name_condition_in', 'option')) : ?>
                                                    <sup><?php echo get_row_index(); ?></sup>
                                                <?php endif; ?>
                                            </h4>
                                        </div>
                                        <div class="single_tab_content">
                                            <?php if (have_rows('popular_category_list_in', 'option')) : ?>
                                                <div class="tab_links_wrap">
                                                    <?php while (have_rows('popular_category_list_in', 'option')) : the_row(); ?>
                                                        <a href="<?php the_sub_field('popular_url_in'); ?>" class="single_tab_link" target="_blank"><?php the_sub_field('popular_name_in'); ?></a>
                                                    <?php endwhile; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endwhile; ?>

                            </div>
                        </div>
                    <?php endif; ?>
                    <?php
                        $args = array(
                            'post_type'      => 'collections',
                            'posts_per_page' => -1, // Get all posts
                            'post_status'    => 'publish',
                        );

                        $collections = get_posts($args);

                        if ($collections) { ?>
                            <div class="other_link_block popular_themes">
                                <h4>Popular US Stock themes</h4>
                                <div class="others_links_wrap">
                                    <?php foreach ($collections as $collection) {
                                            $post_name = get_the_title($collection->ID);
                                            $post_link = get_permalink($collection->ID); ?>        
                                        <a href="<?php echo $post_link; ?>"><?php echo $post_name; ?></a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php
                        } else {
                            echo 'No collections found.';
                        }
                    ?>
                    <?php if (have_rows('other_link_list_in', 'option')) : ?>
                        <div class="other_link_block">

                            <?php while (have_rows('other_link_list_in', 'option')) : the_row(); ?>
                                <h4><?php the_sub_field('others_heading_in'); ?></h4>
                                <?php if (have_rows('others_links_in', 'option')) : ?>
                                    <div class="others_links_wrap">
                                        <?php while (have_rows('others_links_in', 'option')) : the_row(); ?>
                                            <?php
                                            $other_link = get_sub_field('others_link_in', 'option');
                                            if ($other_link) :
                                                $other_link_url = $other_link['url'];
                                                $other_link_title = $other_link['title'];
                                                $other_link_target = $other_link['target'] ? $other_link['target'] : '_self';
                                            ?>
                                                <a href="<?php echo $other_link_url; ?>" target="<?php echo $other_link_target; ?>"><?php echo $other_link_title; ?></a>
                                            <?php endif; ?>
                                        <?php endwhile; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (have_rows('popular_list_in', 'option')) : ?>
                        <div class="tabs_conditions">
                            <ul>
                                <?php while (have_rows('popular_list_in', 'option')) : the_row(); ?>
                                    <?php if (get_sub_field('name_condition_in', 'option')) : ?>
                                        <li><sup><?php echo get_row_index(); ?></sup><?php the_sub_field('name_condition_in'); ?></li>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="footer_bottom">
                <?php if (have_rows('risk_disclosure_list_in', 'option')) : ?>
                    <div class="disclosure_block">
                        <?php while (have_rows('risk_disclosure_list_in', 'option')) : the_row(); ?>
                            <div class="single_disclosure_wrap">

                                <div class="disclosure_heading">
                                    <h3><?php the_sub_field('disclosure_name_in'); ?></h3>
                                    
                                    <?php
                            $image = get_sub_field('country_icon_in');
                          if (!empty($image)): ?>
                              <img src="<?php echo esc_url($image['url']); ?>"
                                  alt="<?php echo esc_attr($image['alt']); ?>"/>
                          <?php endif; ?>
                                </div>

                                <div class="disclosure_content">
                                    <?php the_sub_field('disclosure_content_in'); ?>

                                </div>
                                <span class="read_more_link">Read more</span>

                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
                <?php if (get_field('footer_note_in', 'option')) : ?>
                    <div class="footer_note">
                        <?php the_field('footer_note_in', 'option'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>