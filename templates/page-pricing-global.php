<?php
/*
Template name: Page - Pricing Global
*/
get_header(); ?>
<div id="content" role="main" class="pricing-page">

<div class="pricing-sticky">
  <div class="container">
    <div class="row">
      <div class="sticky-tab">
        <?php if( have_rows('pricing_tab') ): ?>
            <ul class="pricing-tabs">
            <?php $index = 0; while( have_rows('pricing_tab') ): the_row(); 
                ?>
                <li>
                    <a href="#tab<?php echo $index + 1; ?>"><?php the_sub_field('tab_title'); ?></a>
                </li>
            <?php $index++; endwhile; ?>
            </ul>
        <?php endif; ?>
      </div>
      <div class="sticky-plan">
        <div class="plan first">
          <h3><?php the_field('basic_plan_heading'); ?></h3>
          <span><?php the_field('basic_plan_price'); ?></span>
        </div>
        <div class="plan second">
          <h3><?php the_field('premium_plan_heading'); ?></h3>
          <span class="annual"><?php the_field('premium_plan_price'); ?></span>
          <span class="quarterly"><?php the_field('premium_plan_price_quarterly'); ?></span>
        </div>
      </div>
    </div>
  </div>    
</div>

<section class="pricing-info">
    <div class="container">
        <div class="row">
            <div class="content">
                <h2><?php the_field('pricing_info_title'); ?></h2>
                <?php the_field('pricing_info_content'); ?>
            </div>
            <div class="mobile-tab">
                <p id="basic_show_btn" class="active">Basic</p>
                <p id="premium_show_btn">Premium</p>
            </div>
            <div class="plan-box">
                <div class="box basic-plan">
                    <h2><?php the_field('basic_plan_heading'); ?></h2>
                    <span><?php the_field('basic_plan_price'); ?></span>
                    <div class="basic-plan-selection">
                        <label for="pay-once">Pay Once</label>
                    </div>
                    <a href="<?php the_field('basic_plan_button_link'); ?>"><?php the_field('basic_plan_button_label'); ?></a>
                </div>
                <div class="box premium-plan">
                    <div class="recommended">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/star.svg" alt="Star"/>
                        <?php the_field('recommended_label'); ?>
                    </div>
                    <h2><?php the_field('premium_plan_heading'); ?></h2>
                    <span class="annual"><?php the_field('premium_plan_price'); ?></span>
                    <span class="quarterly"><?php the_field('premium_plan_price_quarterly'); ?></span>
                    <div class="plan-selection">
                        <div class="single-plan-button">
                            <input type="radio" name="plan-selection" id="annual-plan" value="" checked>
                            <label for="annual-plan">Annual</label>
                            <div class="save">Save 10%</div>
                        </div>
                        <div class="single-plan-button">
                            <input type="radio" name="plan-selection" id="quarterly-plan" value="" >
                            <label for="quarterly-plan">Quarterly</label>
                        </div>
                    </div>
                    <a href="<?php the_field('premium_plan_button_link'); ?>"><?php the_field('premium_plan_button_label'); ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pricing-table">
  <div class="container">
    <?php if( have_rows('pricing_tab') ): ?>
        <ul id="tabs-nav" class="pricing-tabs">
        <?php $index = 0; while( have_rows('pricing_tab') ): the_row(); 
            ?>
            <li>
                <a href="#tab<?php echo $index + 1; ?>"><?php the_sub_field('tab_title'); ?></a>
            </li>
        <?php $index++; endwhile; ?>
        </ul>
    <?php endif; ?>
    <div id="tabs-content" class="pricing-tabs-content">
      <?php if (have_rows('pricing_tab')) : ?>
        <?php $index = 0; // Initialize the index counter ?>
        <?php while (have_rows('pricing_tab')) : the_row(); ?>
          <div id="tab<?php echo $index + 1; ?>" class="tab-content pricing-tab-content">
            <div class="head-part">
              <div class="inner">
                <div class="stock">
                   <?php
                                            $image = get_sub_field('stock_icon');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                                            <?php endif; ?>   
                  <strong><?php the_sub_field('stock_title'); ?></strong> 
                </div>
                <div class="currency">
             
                  <?php
                                            $image = get_sub_field('currency_icon');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                                            <?php endif; ?>     
                  <span><?php the_sub_field('currency_text'); ?></span>
                </div>
              </div>
              <div class="empty-space">
                <div class="empty first"></div>
                <div class="empty second"></div>
              </div>
            </div>
            
            <?php while (have_rows('pricing_list')) : the_row(); ?>
              <div class="item">
                <div class="heading">
                  <div class="inner">
                    <div class="icon">
                    
                      <?php
                                            $image = get_sub_field('icon');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                                            <?php endif; ?>  
                    </div>
                    <div class="inside">
                      <h3><?php the_sub_field('heading'); ?></h3>
                      <?php $tooltipContent = get_sub_field('tooltip'); ?>
                      <?php 
                        if ($tooltipContent) {
                          ?>
                          <div class="tooltip">
                            <img class="info-icon" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/toolkit.svg" alt="info"/>
                            <div class="overlay"></div>
                            <div class="tooltip-content">
                            <div class="line"></div>
                              <?php the_sub_field('tooltip'); ?>
                              <button class="ok-btn">Okay, got it</button>
                            </div>
                          </div>
                          <?php
                        }
                      ?>                    
                    </div>
                  </div>
                </div>
                <div class="price-detail">
                  <!-- Annual -->
                  <div class="info first annual">
                    <div class="inner">
                      <div>
                        <?php $firstHeading = get_sub_field('first_heading'); ?>
                        <?php 
                          if ($firstHeading == 'check') {
                            ?>
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/tick_new_one.svg" alt="right_click"/>
                            <?php
                          }
                          else {
                            ?>
                            <p><?php the_sub_field('first_heading'); ?></p>
                            <?php
                          }
                        ?>
                        <span><?php the_sub_field('first_sub_heading'); ?></span>
                      </div>
                    </div>
                  </div>
                  <div class="info second annual">
                    <div class="inner">
                      <div>
                        <?php $secondHeading = get_sub_field('second_heading'); ?>
                        <?php 
                            if ($secondHeading == 'check') {
                              ?>
                              <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/tick_new_one.svg" alt="right_click"/>
                              <?php
                            }
                            else {
                              ?>
                              <p><?php the_sub_field('second_heading'); ?></p>
                              <?php
                            }
                          ?>
                        <span><?php the_sub_field('second_sub_heading'); ?></span>
                      </div>      
                    </div>
                  </div>
                  <!-- Quarterly -->
                  <div class="info first quarterly">
                    <div class="inner">
                      <div>
                        <?php $firstHeadingQuarterly = get_sub_field('first_heading_quarterly'); ?>
                        <?php 
                          if ($firstHeadingQuarterly == 'check') {
                            ?>
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/tick_new_one.svg" alt="right_click" />
                            <?php
                          }
                          else {
                            ?>
                            <p><?php the_sub_field('first_heading_quarterly'); ?></p>
                            <?php
                          }
                        ?>
                        <span><?php the_sub_field('first_sub_heading_quarterly'); ?></span>
                      </div>
                    </div>  
                  </div>
                  <div class="info second quarterly">
                    <div class="inner">
                      <div>
                        <?php $secondHeadingQuarterly = get_sub_field('second_heading_quarterly'); ?>
                        <?php 
                            if ($secondHeadingQuarterly == 'check') {
                              ?>
                              <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/tick_new_one.svg" alt="right_click" />
                              <?php
                            }
                            else {
                              ?>
                              <p><?php the_sub_field('second_heading_quarterly'); ?></p>
                              <?php
                            }
                          ?>
                        <span><?php the_sub_field('second_sub_heading_quarterly'); ?></span>
                      </div>      
                    </div>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        <?php $index++; // Increment the index counter ?>  
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php if (have_rows('faq_list')) : ?>
  <section class="pricing_page_faqs">
      <div class="container">
          <h2 class="section_title"><span><?php the_field('faqs_heading'); ?></span></h2>

          <div class="pricing_page_faq_wrap">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        getUserLocationByIP();
    });

    function getUserLocationByIP() {
        // Make a request to the ipinfo.io API to get user location based on IP
        fetch('https://ipinfo.io/json')
            .then(response => response.json())
            .then(data => {
            // Process the location information
            console.log('User location based on IP:', data);
            var globalBanner = document.querySelector(".geolocation_banner");
            if (globalBanner) {
                globalBanner.style.display = "flex"; 
                if (data.country === "IN") {
                    globalBanner.innerHTML = "<div class='content'><p>You're on our Global website. Visit the India website to explore our pricing for Indian users.</p></div><a href='<?php home_url() ?>/in/pricing'><img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/india.webp'>India</a>";
                    console.log('show geolocation_banner');
                } else {
                    globalBanner.innerHTML = "<div class='content'><p>Discover the new face of Vested! Read our latest update to know more.</p></div><a href='<?php home_url(); ?>/blog/vested-updates/welcome-to-a-better-and-improved-vested/' target='_blank' class='learn_more_btn'>Learn more</a>";
                    console.log('hide geolocation_banner');
                }
            }
            })
            .catch(error => {
                console.error('Error getting user location based on IP:', error);
            });
    }
</script>
<?php get_footer(); ?>