<?php
/*
Template Name: Page - Partner Program FAQs
*/

get_header();
?>

<div class="faqs_sec partner_program_faqs">
    <div class="container">
        <h1 class="section_title">Getting Started with the Vested Partner Program - FAQs</h1>
        <?php if (have_rows('faq_list')): ?>
        <div class="faqs_wrap">
        <?php while (have_rows('faq_list')): the_row(); ?>
            <div class="single_faq">
                <div class="faq_que">
                    <h4><?php the_sub_field('faq_question'); ?></h4>
                </div>
                <div class="faq_content">
                    <?php the_sub_field('faq_answer'); ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();