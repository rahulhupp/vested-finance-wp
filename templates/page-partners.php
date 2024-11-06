<?php
/*
Template name: Page- Partners
*/

get_header();
?>

<section class="banner">
    <div class="container">
        <div class="banner_wrap">
            <div class="banner_content_col">
                <h2 class="banner_subheadings">
                    <?php the_field('banner_sub_headings'); ?>
                    <img src="<?php the_field('banner_sub_heading_icon'); ?>" alt="Unlock icon">
                </h2>
                <h1 class="banner_heading"><?php the_field('banner_heading'); ?></h1>
                <div class="banner_desktop_desc">
                    <p class="banner_desc"><?php the_field('banner_description'); ?></p>

                    <a href="<?php the_field('banner_button_link'); ?>" class="btn banner_button"><?php the_field('banner_button_text'); ?></a>
                </div>
            </div>
            <div class="banner_img_col">
                <div class="banner_img_wrap">
                    <div class="banner_img">
                        <img src="<?php the_field('banner_image'); ?>" alt="Become a partner">
                    </div>
                    <div class="banner_mobile_desc">
                        <p class="banner_desc"><?php the_field('banner_description'); ?></p>

                        <a href="<?php the_field('banner_button_link'); ?>" class="btn banner_button"><?php the_field('banner_button_text'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="unique_assets">
    <div class="container">
        <h2 class="section_title"><?php the_field('unique_asset_sec_heading'); ?></h2>
        <?php if (have_rows('unique_assets_list')): ?>
        <div class="unique_assets_wrap">
        <?php while (have_rows('unique_assets_list')): the_row(); ?>
            <div class="single_unique_asset">
                <div class="asset_icon">
                    <img src="<?php the_sub_field('asset_icon'); ?>" alt="<?php the_sub_field('asset_title'); ?>">
                </div>
                <div class="asset_meta">
                    <h4 class="asset_title"><?php the_sub_field('asset_title'); ?></h4>
                    <p class="asset_desc"><?php the_sub_field('asset_description'); ?></p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="partners_sec">

    <div class="container">
        <h2 class="section_title"><?php the_field('benefits_heading'); ?></h2>
        <p class="partner_benefit_desc"><?php the_field('partner_sec_description'); ?></p>
        <?php if (have_rows('benefits_list')): ?>
            <div class="partners_wrap">
                <div class="partners_col">
                    <?php while (have_rows('benefits_list')): the_row();
                        $row_index = get_row_index();
                        if ($row_index <= 2) { ?>
                            <div class="single_partner" data-col="<?php echo $row_index; ?>">
                                <div class="single_partner_wrap">
                                    <div class="partner_icon">
                                        <img src="<?php the_sub_field('benefit_icon'); ?>" alt="<?php the_sub_field('benefit_title'); ?>">
                                    </div>
                                    <div class="partner_meta">
                                        <h3 class="partner_title"><?php the_sub_field('benefit_title'); ?></h3>
                                        <p class="partner_desc"><?php the_sub_field('benefit_description'); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php endwhile; ?>
                </div>

                <div class="partners_col">
                    <?php while (have_rows('benefits_list')): the_row();
                        $row_index = get_row_index();
                        if ($row_index > 2) { ?>
                            <div class="single_partner" data-col="<?php echo $row_index; ?>">
                                <div class="single_partner_wrap">
                                    <div class="partner_icon">
                                        <img src="<?php the_sub_field('benefit_icon'); ?>" alt="<?php the_sub_field('benefit_title'); ?>">
                                    </div>
                                    <div class="partner_meta">
                                        <h3 class="partner_title"><?php the_sub_field('benefit_title'); ?></h3>
                                        <p class="partner_desc"><?php the_sub_field('benefit_description'); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>

</section>

<section class="vested_partners">
        <div class="container">
            <h2 class="section_title"><?php the_field('who_become_heading');?></h2>
            <?php if (have_rows('partner_list')): ?>
            <div class="vested_partners_wrap">
            <?php while (have_rows('partner_list')): the_row(); ?>
                <div class="single_vested_partner">
                    <div class="single_vested_partner_wrap">
                        <div class="vested_partner_img">
                            <img src="<?php the_sub_field('partner_image'); ?>" alt="<?php the_sub_field('partner_title'); ?>">
                        </div>
                        <div class="vested_partner_meta">
                            <h3 class="vested_partner_title"><?php the_sub_field('partner_title'); ?></h3>
                            <p class="vested_partner_desc"><?php the_sub_field('partner_description'); ?></p>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>
            <div class="partner_cta">
                <a href="<?php the_field('partners_button_url'); ?>" class="btn partner_cta_btn"><?php the_field('partners_button_text'); ?></a>
            </div>
        </div>
</section>

<section class="process_sec">
    <div class="container">
        <h2 class="section_title"><?php the_field('process_sec_heading');?></h2>
        <?php if (have_rows('process_list')): ?>
        <div class="process_wrap">
        <?php while (have_rows('process_list')): the_row(); ?>
            <div class="single_process">
                <div class="process_icon">
                    <img src="<?php the_sub_field('process_icon'); ?>" alt="<?php the_sub_field('process_title'); ?>">
                </div>
                <div class="process_meta">
                    <h3><?php the_sub_field('process_title'); ?></h3>
                    <p><?php the_sub_field('process_description'); ?></p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="cta">
    <div class="container">
        <div class="cta_wrap">
            <div class="cta_query_col">
                <h3 class="query_que"><?php the_field('cta_heading');?></h3>
                <h2 class="query_main_que"><?php the_field('cta_description');?></h2>
            </div>
            <div class="cta_btn_col">
                <a href="<?php the_field('cta_button_url');?>" class="btn btn_light"><?php the_field('cta_button_text');?></a>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
