<?php
/*
Template name: Page - Calculators
*/
get_header(); ?>

<section>
    <div class="container">
        <div class="cal_banner_warraper">
            <h2><?php the_field('banner_heading'); ?></h2>
            <p><?php the_field('banner_description'); ?></p>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="cal_card_warap">
            <?php if (have_rows('cal_card')): ?>
                <?php
                while (have_rows('cal_card')):
                    the_row();
                    ?>
                    <div class="card_content">
                        <div class="card_img">
                            <?php
                            $image = get_sub_field('cal_crads_image');
                            if (!empty($image)): ?>
                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                            <?php endif; ?>
                        </div>
                        <div class="card_description">
                            <h2><?php the_sub_field('cal_cards_heading'); ?></h2>
                            <p><?php the_sub_field('cal_card_description') ?></p>

                            <?php if (get_sub_field('calculation')): ?>
                                <div class="card_calculate_btn">
                                     <a href="<?php the_sub_field('button_link'); ?>" > <?php the_sub_field('calculation'); ?></a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (get_sub_field('comming_soon')): ?>
                                <h4><?php the_sub_field('comming_soon'); ?></h4>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>

        </div>
    </div>
</section>
<?php get_footer(); ?>