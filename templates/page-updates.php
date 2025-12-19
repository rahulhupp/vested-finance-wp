<?php
/*
Template name: Page - Updates
*/
get_header(); ?>

<div id="content" role="main" class="announcements-page">
    <section class="announcements-banner">
        <div class="container">
            <h1>Updates</h1>
            <p>What’s new at Vested and across global investing, in one place.</p>
        </div>
    </section>
    <section class="announcements-list-container">
        <div class="container">
            <?php
            // Get all terms from the updates_category taxonomy
            $categories = get_terms( array(
                'taxonomy'   => 'updates_category',
                'hide_empty' => true,
            ) );

            if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                foreach ( $categories as $category ) {
                    // Get all announcements for this category
                    $announcements = new WP_Query( array(
                        'post_type'      => 'updates',
                        'posts_per_page' => -1,
                        'post_status'    => 'publish',
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'updates_category',
                                'field'    => 'term_id',
                                'terms'    => $category->term_id,
                            ),
                        ),
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    ) );

                    if ( $announcements->have_posts() ) {
                        ?>
                        <div class="announcements-list-wrapper">
                            <div class="announcements-list-header">
                                <h3><?php echo esc_html( $category->name ); ?></h3>
                            </div>
                            <div class="announcements-list">
                                <?php
                                while ( $announcements->have_posts() ) {
                                    $announcements->the_post();
                                    ?>
                                    <a href="<?php echo esc_url( get_permalink() ); ?>" class="announcements-list-item">
                                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo esc_html( get_the_title() ); ?>">
                                        <h4><?php echo esc_html( get_the_title() ); ?></h4>
                                        <p><?php echo wp_trim_words( get_the_content(), 20 ); ?></p>
                                        <div class="meta-info">
                                            <span class="post-author"><?php the_author(); ?></span>
                                            <span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
                                        </div>
                                    </a>
                                    <?php
                                }
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                }
            } else {
                ?>
                <div class="announcements-list-wrapper">
                    <p><?php esc_html_e( 'No announcements found.', 'vested-finance-wp' ); ?></p>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
</div>

<?php get_footer(); ?>