<?php
/*
Template name: Page - Solar
*/
get_header(); ?>
<div id="content" role="main" class="solar-page">

<section class="solar_banner">
    <div class="container">
        <div class="banner_wrapper">
            <div class="banner_content">
                <div class="inner_content">
                  <div class="sub_heading">
                      <div class="sub_heading_icon">
                          <img src="<?php the_field('banner_sub_heading_icon'); ?>" alt="<?php the_field('banner_sub_heading'); ?>" alt="vested solar logo">
                      </div>
                      <h3><?php the_field('banner_sub_heading'); ?></h3>
                  </div>
                  <h1><?php the_field('banner_heading'); ?></h1>
                  <?php if (have_rows('banner_solar_list')) : ?>
                      <ul class="banner_list">
                          <?php while (have_rows('banner_solar_list')) : the_row(); ?>
                              <?php
                                  $solorSingleItem = get_sub_field('solar_single_item');
                                  $solorSingleItem = str_replace('?', '₹', $solorSingleItem);
                              ?>
                              <li><?php echo $solorSingleItem; ?></li>
                          <?php endwhile; ?>
                      </ul>
                  <?php endif; ?>
                  <div class="banner_buttons">
                      <div class="btn">
                          <a href="<?php the_field('banner_button_url'); ?>" class="btn_dark" target="_blank"><?php the_field('banner_button_text'); ?></a>
                      </div>
                  </div>
                </div>
            </div>
            <div class="banner_img">
                <img src="<?php the_field('banner_image'); ?>" alt="Banner" alt="P2P lending returns">
            </div>
        </div>
    </div>
</section>

<?php if (have_rows('solar_slider')) : ?>
  <section class="solar_slider_sec">
      <div class="container">
          <div class="wrapper">
            <h2>
                <span><?php the_field('solar_slider_heading'); ?></span>
            </h2>
            <div class="solar_slider_wrap">
                <div class="solar_slider_inner">
                    <div class="solar_slider_content">
                        <?php while (have_rows('solar_slider')) : the_row(); ?>
                            <div class="single_portfolio_slider_content">
                                <div class="portfolio_slider_content_inner">
                                    <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBar"></span>
                                    <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBarMob"></span>
                                    <div class="portfolio_slider_inner_content">
                                        <span class="slider_index">0<?php echo get_row_index(); ?></span>
                                        <h3><?php the_sub_field('solor_slider_title') ?></h3>
                                        <p class="single_slider_desc">
                                            <?php the_sub_field('solar_slider_description') ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="solar_slider_image solar-single-item">
                    <?php while (have_rows('solar_slider')) : the_row(); ?>
                        <div class="single_portfolio_slider">
                            <img src="<?php the_sub_field('solar_slider_image') ?>" alt="Portfolio" />
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
          </div>
      </div>
  </section>
<?php endif; ?>


<section class="solar_tabs">
<div class="container">
  <div class="wrapper">
    <h2><?php the_field('work_heading'); ?></h2>
    <div class="tabs">
      <ul id="tabs-nav">
          <?php while (have_rows('work_tab')) : the_row(); ?>
              <?php $index = get_row_index(); ?>
              <li><a href="#tab<?php echo $index; ?>"><?php the_sub_field('work_title') ?></a></li>
          <?php endwhile; ?>
      </ul>
      <div id="tabs-content">
        <?php while (have_rows('work_tab')) : the_row(); ?>
            <?php $index = get_row_index(); ?>
            <div id="tab<?php echo $index; ?>" class="tab-content">
              <a class="toggle" href=#><span><?php the_sub_field('work_title') ?></span><div class="arrow"></div></a>
             <div class="content_wrap">
              <div class="content">
                <?php the_sub_field('work_content') ?>
              </div>
              <div class="image">
                <img class="desktop" src="<?php the_sub_field('work_image') ?>">
                <img class="mobile" src="<?php the_sub_field('work_image_mobile') ?>">
              </div>
             </div>
            </div>
        <?php endwhile; ?>
      </div>
    </div> 
  </div>
</div>
</section>

<section class="solar_project">
  <div class="container">
    <div class="wrapper">
      <h2><?php the_field('project_heading'); ?></h2>
      <div class="blur_image">
        <img src="<?php the_field('project_image'); ?>" />
        <div class="btn">
            <a href="<?php the_field('project_button_url'); ?>" class="btn_dark" target="_blank"><?php the_field('project_button_text'); ?></a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="solar_invest">
  <div class="container">
    <div class="wrapper">
      <h2>
          <span><?php the_field('Invest_heading'); ?></span>
      </h2>
      <div class="invest_grid">
          <?php while (have_rows('Invest_item')) : the_row(); ?>
            <div class="item" style="background: <?php the_sub_field('Invest_background_color') ?>">
              <img src="<?php the_sub_field('Invest_icon') ?>" />
              <h3 style="color: <?php the_sub_field('Invest_text_color') ?>"><?php the_sub_field('Invest_title') ?></h3>
              <p style="color: <?php the_sub_field('Invest_text_color') ?>"><?php the_sub_field('Invest_content') ?></p>
            </div>
          <?php endwhile; ?>
      </div>
    </div>
  </div>
</section>

<?php if (have_rows('portfolio_slider')) : ?>
    <section class="portfolio_slider_sec">
        <div class="container">
            <h2>
                <span><?php the_field('portfolio_heading'); ?></span>
            </h2>
            <div class="portfolio_slider_wrap">
                <div class="portfolio_slider slider single-item">
                    <?php while (have_rows('portfolio_slider')) : the_row(); ?>
                        <div class="single_portfolio_slider">
                            <img src="<?php the_sub_field('slider_image') ?>" alt="Portfolio" />
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

<?php if (have_rows('faq_list')) : ?>
    <section class="solar_page_faqs">
        <div class="container">
            <h2><span><?php the_field('faqs_heading'); ?></span></h2>
            <div class="solar_page_faq_wrap">
                <?php while (have_rows('faq_list')) : the_row(); ?>
                    <div class="single_faq">
                        <div class="faq_que">
                            <h4>
                                <?php the_sub_field('faq_question') ?>
                            </h4>
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


<?php get_footer(); ?>