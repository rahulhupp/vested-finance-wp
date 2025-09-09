<?php
/*
Template name: Page - SIP/Lumpsum Calculator
*/
get_header(); ?>
<?php if( get_field('sip_info_title') ): ?>
    <?php get_template_part('template-parts/sip-calculator'); ?>
<?php endif; ?>

<?php if( get_field('lumpsum_info_title') ): ?>
    <?php get_template_part('template-parts/lumpsum-calculator'); ?>
<?php endif; ?>
<?php if( get_field('sip_info_title') ): ?>
    <section class="sip_calculator_content">
        <div class="container">
            <div class="sip_calculator_content_wrapper">
                <div class="sip_calculator_info">
                    <h2><?php the_field('sip_info_title'); ?></h2>
                    <?php the_field('sip_info_content'); ?>
                </div>
            </div>
        </div>
    </section>

    <?php if (have_rows('sip_faqs_list')) : ?>
        <section class="sip_calculator_faqs">
            <div class="container">
                <div class="sip_calculator_faqs_wrapper">
                    <h2><?php the_field('sip_faqs_title'); ?></h2>
                    <div class="sip_calculator_faqs_list">
                        <?php while (have_rows('sip_faqs_list')) : the_row(); ?>
                            <div class="sip_calculator_faqs_item">
                                <h4 class="faq_question">
                                    <?php the_sub_field('sip_faqs_list_question') ?>
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chevron-down.webp" alt="faq_icon" class="faq_icon" />
                                </h4>
                                <div class="faq_answer">
                                    <?php the_sub_field('sip_faqs_list_answer') ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (have_rows('sip_faqs_list')) : ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        <?php $rowCount = 0; ?>
        <?php while (have_rows('sip_faqs_list')) : the_row(); ?>
            {
                "@type": "Question",
                "name": <?php echo json_encode(get_sub_field('sip_faqs_list_question')); ?>,
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": <?php echo json_encode(get_sub_field('sip_faqs_list_answer')); ?>
                }
            }<?php echo (++$rowCount === count(get_field('sip_faqs_list'))) ? '' : ','; ?>
        <?php endwhile; ?>
    ]
}
</script>
<?php endif; ?>

    <script>
        jQuery(function ($) {
            $(".faq_question").click(function (j) {
                var dropDown = $(this).closest(".sip_calculator_faqs_item").find(".faq_answer");
                $(this)
                    .closest(".sip_calculator_faqs_list")
                    .find(".faq_answer")
                    .not(dropDown)
                    .slideUp();
                if ($(this).hasClass("active")) {
                    $(this).removeClass("active");
                } else {
                    $(this)
                        .closest(".sip_calculator_faqs_list")
                        .find(".faq_question.active")
                        .removeClass("active");
                    $(this).addClass("active");
                }
                dropDown.stop(false, true).slideToggle();
                j.preventDefault();
            });
        });

    </script>
<?php endif; ?>

<?php if( get_field('lumpsum_info_title') ): ?>
    <section class="lumpsum_calculator_content">
        <div class="container">
            <div class="lumpsum_calculator_content_wrapper">
                <div class="lumpsum_calculator_info">
                    <h2><?php the_field('lumpsum_info_title'); ?></h2>
                    <?php the_field('lumpsum_info_content'); ?>
                </div>
            </div>
        </div>
    </section>

    <?php if (have_rows('lumpsum_faqs_list')) : ?>
        <section class="lumpsum_calculator_faqs">
            <div class="container">
                <div class="lumpsum_calculator_faqs_wrapper">
                    <h2><?php the_field('lumpsum_faqs_title'); ?></h2>
                    <div class="lumpsum_calculator_faqs_list">
                        <?php while (have_rows('lumpsum_faqs_list')) : the_row(); ?>
                            <div class="lumpsum_calculator_faqs_item">
                                <h4 class="faq_question">
                                    <?php the_sub_field('lumpsum_faqs_list_question') ?>
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chevron-down.webp" alt="faq_icon" class="faq_icon" />
                                </h4>
                                <div class="faq_answer">
                                    <?php the_sub_field('lumpsum_faqs_list_answer') ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

<?php if (have_rows('lumpsum_faqs_list')) : ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        <?php $rowCount = 0; ?>
        <?php while (have_rows('lumpsum_faqs_list')) : the_row(); ?>
            {
                "@type": "Question",
                "name": <?php echo json_encode(get_sub_field('lumpsum_faqs_list_question')); ?>,
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": <?php echo json_encode(get_sub_field('lumpsum_faqs_list_answer')); ?>
                }
            }<?php echo (++$rowCount === count(get_field('lumpsum_faqs_list'))) ? '' : ','; ?>
        <?php endwhile; ?>
    ]
}
</script>
<?php endif; ?>

    <script>
        jQuery(function ($) {
            $(".faq_question").click(function (j) {
                var dropDown = $(this).closest(".lumpsum_calculator_faqs_item").find(".faq_answer");
                $(this)
                    .closest(".lumpsum_calculator_faqs_list")
                    .find(".faq_answer")
                    .not(dropDown)
                    .slideUp();
                if ($(this).hasClass("active")) {
                    $(this).removeClass("active");
                } else {
                    $(this)
                        .closest(".lumpsum_calculator_faqs_list")
                        .find(".faq_question.active")
                        .removeClass("active");
                    $(this).addClass("active");
                }
                dropDown.stop(false, true).slideToggle();
                j.preventDefault();
            });
        });

    </script>
<?php endif; ?>


<?php get_footer(); ?>