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

<section class="faqs_sec">
    <div>
        <?php if (have_rows('calculators_faq_list')): ?>
            <section class="calculators_faqs">
                <div class="container">
                    <h2 class="section_title"><span>
                            <?php the_field('faqs_heading'); ?>
                        </span></h2>
                    <div class="calculators_faq_wrap">
                        <?php while (have_rows('calculators_faq_list')):
                            the_row(); ?>
                            <div class="single_faq">
                                <div class="faq_que">
                                    <h3>
                                        <?php the_sub_field('faq_question') ?>
                                    </h3>
                                </div>
                                <div class="faq_content">
                                    <?php the_sub_field('faq_ans') ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </div>
</section>


<script>

    // faqs//
    jQuery(function ($) {
        $('.faq_que').click(function (j) {
            var dropDown = $(this).closest('.single_faq').find('.faq_content');
            var allOtherContents = $(this).closest('.calculators_faq_wrap').find('.faq_content').not(dropDown);
            
            allOtherContents.slideUp();

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                $(this).closest('.calculators_faq_wrap').find('.faq_que.active').removeClass('active');
                $(this).addClass('active');
            }
            dropDown.stop(false, true).slideToggle();
            j.preventDefault();
        });
    });
</script>

<?php get_footer(); ?>