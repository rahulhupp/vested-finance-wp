<?php
/*
Template name: Page - Calculators
*/
get_header(); ?>

<section>
    <div class="container">
        <div class="cal_banner_warraper">
            <h2>
                <?php the_field('banner_heading'); ?>
            </h2>
            <p>
                <?php the_field('banner_description'); ?>
            </p>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="cal_card_warap">
            <?php if (have_rows('cal_card')): ?>
                <?php
                $counter = 0;
                while (have_rows('cal_card')):
                    the_row();
                    $counter++;
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
                            <?php
                            $calcardItem = get_sub_field('cal_cards_heading');
                            $calcardItem = str_replace('?', '₹', $calcardItem);
                            $calcarddes = get_sub_field('cal_card_description');
                            $calcarddes = str_replace('?', '₹', $calcarddes);
                            $calcardbtn = get_sub_field('calculation');
                            $calcardbtn = str_replace('?', '₹', $calcardbtn);
                            $calcarcommingsoon = get_sub_field('comming_soon');
                            $calcarcommingsoon = str_replace('?', '₹', $calcarcommingsoon);
                            ?>
                            <h2>
                                <?php echo $calcardItem; ?>
                            </h2>
                            <p>
                                <?php echo $calcarddes; ?>
                            </p>

                            <div class="card_calculate_btn">
                                <a href="<?php echo $calcardbtn; ?>">
                                    <?php echo $calcardbtn; ?>
                                    <?php
                                    $image = get_sub_field('calculation_arrow');
                                    if (!empty($image)): ?>
                                        <img src="<?php echo esc_url($image['url']); ?>"
                                            alt="<?php echo esc_attr($image['alt']); ?>" />
                                    <?php endif; ?>
                                </a>
                            </div>
                            <?php if ($counter > 3): ?>
                                <h4>
                                    <?php echo $calcarcommingsoon; ?>
                                </h4>
                            <?php endif; ?>
                        </div>



                    </div>

                <?php endwhile; ?>
            <?php endif; ?>

        </div>
    </div>
</section>

<section>
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

    // post//

    document.addEventListener('DOMContentLoaded', function () {
        var cardContents = document.querySelectorAll('.card_content');

        cardContents.forEach(function (cardContent, index) {
            var comingSoonElement = cardContent.querySelector('.card_calculate_btn');
            var h4Element = cardContent.querySelector('h4');

            if (h4Element && index > 2) {

                comingSoonElement.style.display = 'none';
            }
        });
    });
</script>

<?php get_footer(); ?>