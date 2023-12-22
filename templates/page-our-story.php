<?php
/*
Template name: Page - Our Story
*/
get_header(); ?>
<div id="content" role="main" class="our-story-page">

<section class="our-story-banner">
  <div class="image">
   
    <?php
$image = get_field('image_desktop');
                          if (!empty($image)): ?>
                              <img src="<?php echo esc_url($image['url']); ?>"
                                  alt="<?php echo esc_attr($image['alt']); ?>"  class="desktop" />
                          <?php endif; ?>
                          <?php
$image = get_field('image_mobile');
                          if (!empty($image)): ?>
                              <img src="<?php echo esc_url($image['url']); ?>"
                                  alt="<?php echo esc_attr($image['alt']); ?>" class="mobile"/>
                          <?php endif; ?>
  
  </div>
  <div class="content">
    <div class="inner">
      <span><?php the_field('short_title'); ?></span>
      <h2><?php the_field('banner_heading'); ?><h2>
    </div>
  </div>
</section>

<section class="our-story-info">
  <div class="container">
    <div class="row">
      <div class="left-part">
        <h2><?php the_field('info_heading'); ?></h2>
        <p><?php the_field('short_description'); ?></p>
      </div>
      <div class="right-part">
        <?php the_field('info_content'); ?>
      </div>
    </div>
  </div>
</section>

<section class="leadership">
  <div class="container">
    <h2><?php the_field('leadership_heading'); ?></h2>
    <div class="row">
    <?php if( have_rows('leadership_list') ): ?>
        <ul class="list">
        <?php while( have_rows('leadership_list') ): the_row(); ?>
            <li>
               
                <?php
$image = get_sub_field('image');
                          if (!empty($image)): ?>
                              <img src="<?php echo esc_url($image['url']); ?>"
                                  alt="<?php echo esc_attr($image['alt']); ?>"/>
                          <?php endif; ?>
                <div class="content">
                  <h3><?php the_sub_field('title'); ?></h3>
                  <span><?php the_sub_field('designation'); ?></span>
                  <div class="bio">
                    <div class="label">
                      <?php the_sub_field('bio'); ?>
                      <img class="info" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/leader-info.webp" alt="info">
                    </div>
                    <div class="social">
                      <a href="<?php the_sub_field('linkedin_link'); ?>" target="_blank">
                        <img class="linkedin" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/linkedin.webp" alt="linkdin" />
                      </a>
                    </div>
                  </div>
                </div>
                <div class="modal">
                  <div class="modal-overlay"></div>
                  <div class="modal-content">
                    <div class="head-part">
                      <h3><?php the_sub_field('bio'); ?></h3>
                      <img class="close" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/close.webp">
                    </div>
                    <div class="content-area">
                      <?php the_sub_field('bio_content'); ?>
                    </div>
                  </div>
                </div>
            </li>
        <?php endwhile; ?>
        </ul>
    <?php endif; ?>
    </div>
  </div>
</section>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  getUserLocationByIP();
});

function getUserLocationByIP() {
  // Make a request to the GeoJS API to get user location based on IP
  const apiUrl = 'https://get.geojs.io/v1/ip/geo.js';

  // Add a script element to the document to load the GeoJS API
  const scriptElement = document.createElement('script');
  scriptElement.src = apiUrl;
  document.head.appendChild(scriptElement);

  // Callback function to process the location information
  window.geoip_callback = function(data) {
    // Remove the script element after executing the callback
    document.head.removeChild(scriptElement);

    // Process the location information
    console.log('User location based on IP:', data);
    // You can extract relevant information from the 'data' object
    alert('Your approximate location: ' + data.city + ', ' + data.region);
  };
}
</script>
<?php get_footer(); ?>