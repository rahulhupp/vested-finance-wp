<?php get_header(); ?>

<?php
       $category = get_queried_object();
       
       // Check if it's a parent category
       $child_categories = get_term_children($category->term_id, $category->taxonomy);

       if (empty($child_categories)) {
           // It's a parent category
           ?>
		   <div class="custom_breadcrumb">
				<div class="container">
					<ul>
						<li><a href="<?php echo get_home_url(); ?>/blog">Blog</a></li>
						<?php 
							$cat = get_queried_object(); 
							if ($cat->category_parent) {
								$parent_category = get_term($cat->category_parent, 'category'); 
								$parent_category_link = get_category_link($parent_category); 
								echo '<li><a href="' . esc_url($parent_category_link) . '">' . $parent_category->name . '</a></li>'; 
							}
						?>						
						<?php
							$cat = get_queried_object(); 

							if ($cat) {
								$subcategory_link = get_category_link($cat); 
								echo '<li class="active"><a href="' . esc_url($subcategory_link) . '">' . $cat->name . '</a></li>'; 
							}
						?>
						
					</ul>
				</div>
		   </div>
		   <div id="content" role="main" class="sub-category-page">
				<section>
					<div class="container">
						<?php 
						$category_id = get_query_var('cat'); // Get the category ID
						$args = array(
							'cat' => $category_id, // Use the category ID to query posts from the specific category
							'posts_per_page' => -1, // -1 to display all posts
						);
						$custom_query = new WP_Query($args);
						?>
						<?php if ($custom_query->have_posts()) : ?>
							<header class="page-header">
								<div class="heading">
									<h1 class="page-title"><?php single_cat_title(); ?></h1>
									<?php if (category_description()) : ?>
										<div class="category-description"><?php echo category_description(); ?></div>
									<?php endif; ?>
								</div>
								<div class="search">
									<?php // get_search_form(); ?>
									<?php echo do_shortcode('[ivory-search id="4325" title="Sub Category AJAX Search"]'); ?>
								</div>
							</header>
							<div class="post-item">
								<?php while ($custom_query->have_posts()) :  $custom_query->the_post(); ?>
									<div id="post-<?php the_ID(); ?>" class="post-card">
										<div class="featured-image">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail('full'); // You can specify the image size here ?>
											</a>
										</div>
										<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
										<div class="meta-info">
											<span class="post-author"><?php the_author(); ?></span>
											<span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
										</div>
									</div>
								<?php endwhile; ?>
								
							</div>
							<?php
						else :
							// Display a message for no posts
							?>
							<?php
						endif;
						?>	
						<div class="load-more-btn">
							<a href="#" id="loadMore">Load More</a>
						</div>				
					</div>
				</section>
				<section class="main-category">
					<div class="container">
						<div class="head-part">
							<h2>Learn More With Vested</h2>
							<p>Two stock deep-dives every month, published every other Wednesday</p>
						</div>
						<ul>
							<?php
								// Get the current taxonomy term
								$term = get_queried_object();

								// Check if the term has Repeater field data
								if (have_rows('select_categroy', 'term_' . $term->term_id)) {
									while (have_rows('select_categroy', 'term_' . $term->term_id)) {
										the_row();
										$field1 = get_sub_field('item');
										$category = get_term($field1, 'category');
										?>
										<li>
											<div class="box">
												<div class="image">
													<img src="<?php echo the_field('category_image', $category); ?>" />
												</div>
												<a href="<?php echo get_category_link($category) ?>"><?php echo $category->name ?> ></a>
												<div class="description"><?php echo $category->description ?></div>
											</div>
										</li>
										<?php
									}
								}
							?>							
						</ul>
					</div>
				</section>
				<section class="newsletter-section category">
					<?php get_template_part('template-parts/newsletter'); ?>
				</section>
			</div>
		   <?php 
       } else {
			$category = get_queried_object();
			?>
			<section class="blog-info">
				<div class="container">
					<div class="inner">
						<h1><?php echo the_field('blog_title', 'category_' . $category->term_id) ?></h1>
						<p><?php echo the_field('blog_content', 'category_' . $category->term_id) ?></p>
					</div>
				</div>
			</section>

			<section class="filter-tab">
				<div class="container">
					<div class="inner-row">
						<div class="category-tab">
							<?php if( have_rows('filter_list', 'category_' . $category->term_id) ): ?>
								<ul>
									<li class="active"><a href="#">All</a></li>
									<?php while( have_rows('filter_list', 'category_' . $category->term_id) ): the_row(); 
									?>
									<li>
										<a href="<?php the_sub_field('link', 'category_' . $category->term_id); ?>"><?php the_sub_field('label', 'category_' . $category->term_id); ?></a>
									</li>
									<?php endwhile; ?>
								</ul>
							<?php endif; ?>
						</div>
						<div class="search">
							<?php // get_search_form(); ?>
							<?php echo do_shortcode('[ivory-search id="4323" title="AJAX Search Form"]'); ?>
						</div>
					</div>
				</div>
			</section>

			<section class="first-blog">
				<div class="container">
					<div class="inner-row">
						<div class="single-blog">
							<?php
								$single_post = get_field('single_post' , 'category_' . $category->term_id);

								if ($single_post) {
									$single_image = get_the_post_thumbnail($single_post->ID, 'full'); 
									$single_title = esc_html($single_post->post_title);
									$single_content = esc_html($single_post->post_title);
									$post_content = apply_filters('the_content', $single_post->post_content);
									$author_name = get_the_author($single_post->ID);
									$publication_date = get_the_date('M j, Y', $single_post->ID);
									$post_excerpt = get_the_excerpt($single_post);
									echo '<a href="' . get_permalink($single_post->ID) . '">' . $single_image . '</a>';
									echo '<div class="content">';
									echo '<h3><a href="' . esc_url(get_permalink($single_post->ID)) . '">' . $single_title . '</a></h3>';
									echo '<p>' . $post_excerpt . '</p>';
									echo '<div class="meta-info">';
									echo '<span>' . $author_name . '</span>';
									echo '<span>' . $publication_date . '</span>';
									echo '</div>';
									echo '</div>';

								}
							?>
						</div>
						<div class="featured-article">
							<div class="title">
								<h2><?php the_field('featured_title', 'category_' . $category->term_id); ?></h2>
							</div>
							<?php if( have_rows('featured_articles', 'category_' . $category->term_id) ): ?>
								<ul>
									<?php while( have_rows('featured_articles', 'category_' . $category->term_id) ): the_row(); ?>
										<?php $post_object = get_sub_field('item', 'category_' . $category->term_id); ?>
										<?php if( $post_object ): ?>
											<?php // override $post
											$post = $post_object;
											setup_postdata( $post );
											?>
											<li>
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												<div class="meta-info">
													<span class="post-author"><?php the_author(); ?></span>
													<span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
												</div>
											</li>
											<?php wp_reset_postdata(); ?>
										<?php endif; ?>
									<?php endwhile; ?>
								</ul>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="container">
					<ul class="blog-list">
						<?php while( have_rows('blog_list', 'category_' . $category->term_id) ): the_row(); ?>
							<?php $post_object = get_sub_field('item', 'category_' . $category->term_id); ?>
							<?php if( $post_object ): ?>
								<?php // override $post
								$post = $post_object;
								setup_postdata( $post );
								?>
								<li>
									<?php if (has_post_thumbnail()) : ?>
										<div class="featured-image">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail('full'); // You can specify the image size here ?>
											</a>
										</div>
									<?php endif; ?>
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									<?php the_excerpt(); ?>
									<div class="meta-info">
										<span class="post-author"><?php the_author(); ?></span>
										<span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
									</div>
								</li>
								<?php wp_reset_postdata(); ?>
							<?php endif; ?>
						<?php endwhile; ?>                   
					</ul>
				</div>
			</section>
			
			<section class="parent-categroy us-stock-list">
				<div class="container">
					<div class="head-part">
						<div class="left-part">
							<div class="stock-label">                  
								<?php the_field('us_stock_title', 'category_' . $category->term_id); ?>
							</div>
						</div>          
						<!-- <a href="<?php the_field('view_all_link', 'category_' . $category->term_id); ?> "><?php the_field('view_all_text', 'category_' . $category->term_id); ?></a>                      -->
					</div>
					<div class="inner-row">
						<div class="blog-list">
							<ul>
								<?php while( have_rows('us-stock-blog', 'category_' . $category->term_id) ): the_row(); ?>
									<?php $post_object = get_sub_field('item', 'category_' . $category->term_id); ?>
									<?php if( $post_object ): ?>
										<?php // override $post
										$post = $post_object;
										setup_postdata( $post );
										?>
										<li>
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											<?php the_excerpt(); ?>
											<div class="meta-info">
												<span class="post-author"><?php the_author(); ?></span>
												<span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
											</div>
										</li>
										<?php wp_reset_postdata(); ?>
									<?php endif; ?>
								<?php endwhile; ?>                   
							</ul>
						</div>
						<!-- <div class="mobile-view-all-btn">
							<a href="<?php the_field('view_all_link', 'category_' . $category->term_id); ?> "><?php the_field('view_all_text', 'category_' . $category->term_id); ?></a>   
						</div> -->
						<div class="subscriber-blog">
							<div class="inner">
								<h3><?php the_field('subscriber_heading', 'category_' . $category->term_id); ?></h3>
								<div class="image">
									<img src="<?php the_field('subscriber_image', 'category_' . $category->term_id); ?>" />
								</div>
								<div class="newsletter-form">
									<?php echo do_shortcode('[moengage_newsletter name="newsletter-subscriber" message="Thank You! You have been added to the waitlist." button_text="Subscribe"]'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<section class="vested-shots-blog">
				<div class="container">
					<div class="head-part">
						<div class="heading-icon">
							<img src="<?php the_field('vested_shorts_icon', 'category_' . $category->term_id); ?>" />
						</div>
						<div class="heading">
							<div class="title">
								<h2><?php the_field('vested_shorts_heading', 'category_' . $category->term_id); ?></h2>
								<a href="<?php the_field('vested_shorts_view_all_button_link', 'category_' . $category->term_id); ?>"><?php the_field('vested_shorts_view_all_button', 'category_' . $category->term_id); ?></a>
							</div>
							<span><?php the_field('vested_shorts_sub_heading', 'category_' . $category->term_id); ?></span>
						</div>
					</div>
					<div class="post-list">
						<ul>
							<?php
								$args = array(
									'category_name' => 'p2p-lending/vested-shorts/', // Use the slug of the subcategory
									'posts_per_page' => -5, // Set the number of posts you want to display, -1 to show all
								);

								$custom_query = new WP_Query($args);

								if ($custom_query->have_posts()) :
									while ($custom_query->have_posts()) : $custom_query->the_post();
										// Display post content here
										?>
										<li>
											<div class="featured-image">
												<?php if (has_post_thumbnail()) : ?> 
													<a href="<?php the_permalink(); ?>">                                      
														<?php the_post_thumbnail('full'); // You can specify the image size here ?>
													</a>
												<?php endif; ?>
											</div>
											<div class="content">
												<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
												<?php the_excerpt(); ?>
												<div class="meta-info">
													<span class="post-author"><?php the_author(); ?></span>
													<span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
												</div>
											</div>
										</li>
										<?php
									endwhile;
									wp_reset_postdata(); // Restore the global post data
								else :
									echo 'No posts found';
								endif;
							?>
						</ul>
					</div>
				</div>
			</section>

			<section class="spot-light">
				<div class="container">
					<div class="head-part">
						<div class="heading-icon">
							<img src="<?php the_field('heading_icon', 'category_' . $category->term_id); ?>" />
						</div>
						<div class="heading">
							<div class="title"><h2><?php the_field('sport_light_heading', 'category_' . $category->term_id); ?></h2></div>
							<span><?php the_field('sport_light_sub_heading', 'category_' . $category->term_id); ?></span>
						</div>
					</div>
					<div class="inner-row">
						<div class="single-blog">
							<?php
								$single_post = get_field('sport_light_single_post', 'category_' . $category->term_id);

								if ($single_post) {
									$single_image = get_the_post_thumbnail($single_post->ID, 'full'); 
									$single_title = esc_html($single_post->post_title);
									$single_content = esc_html($single_post->post_title);
									$post_content = apply_filters('the_content', $single_post->post_content);
									$author_name = get_the_author($single_post->ID);
									$publication_date = get_the_date('M j, Y', $single_post->ID);
									$post_excerpt = get_the_excerpt($single_post);
									echo '<a href="' . get_permalink($single_post->ID) . '">' . $single_image . '</a>';
									echo '<div class="content">';
									echo '<div class="inner">';
									echo '<h3><a href="' . esc_url(get_permalink($single_post->ID)) . '">' . $single_title . '</a></h3>';
									echo '<p>'. $post_excerpt .'</p>';
									echo '<div class="meta-info">';
									echo '<span>' . $author_name . '</span>';
									echo '<span>' . $publication_date . '</span>';
									echo '</div>';
									echo '</div>';
									echo '</div>';

								}
							?>
						</div>
						<div class="blog-list">
							<?php if( have_rows('sport_light_list_post', 'category_' . $category->term_id) ): ?>
								<ul>
									<?php while( have_rows('sport_light_list_post', 'category_' . $category->term_id) ): the_row(); ?>
										<?php $post_object = get_sub_field('item', 'category_' . $category->term_id); ?>
										<?php if( $post_object ): ?>
											<?php // override $post
											$post = $post_object;
											setup_postdata( $post );
											?>
											<li>
												<div class="featured-image">
												<?php if (has_post_thumbnail()) : ?>      
													<a href="<?php the_permalink(); ?>">                                 
														<?php the_post_thumbnail('full'); // You can specify the image size here ?>
													</a>	
												<?php endif; ?>
												</div>
												<div class="content">
													<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
													<?php the_excerpt(); ?>
													<div class="meta-info">
														<span class="post-author"><?php the_author(); ?></span>
														<span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
													</div>
												</div>
											</li>
											<?php wp_reset_postdata(); ?>
										<?php endif; ?>
									<?php endwhile; ?>
								</ul>
							<?php endif; ?>
						</div>
					<div>
				</div>
			</section>

			<section class="parent-category vested-edge-blog">
				<div class="container">
					<div class="head-part">
						<div class="vested-label">
							<div class="label">
								<!-- <img src="<?php the_field('vested_edge_icon', 'category_' . $category->term_id); ?>" /> -->
								<h2><?php the_field('vested_edge_heading', 'category_' . $category->term_id); ?></h2>
							</div>
						</div>
					</div>
					<div class="inner-row">
						<?php if( have_rows('vested_edge_post', 'category_' . $category->term_id) ): ?>
							<ul>
								<?php while( have_rows('vested_edge_post', 'category_' . $category->term_id) ): the_row(); ?>
									<?php $post_object = get_sub_field('item', 'category_' . $category->term_id); ?>
									<?php if( $post_object ): ?>
										<?php // override $post
										$post = $post_object;
										setup_postdata( $post );
										?>
										<li>
											<div class="featured-image">
											<?php if (has_post_thumbnail()) : ?>    
												<a href="<?php the_permalink(); ?>">                                   
													<?php the_post_thumbnail('full'); // You can specify the image size here ?>
												</a>
											<?php endif; ?>
											</div>
											<div class="content">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												<?php the_excerpt(); ?>
												<div class="meta-info">
													<span class="post-author"><?php the_author(); ?></span>
													<span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
												</div>
											</div>
										</li>
										<?php wp_reset_postdata(); ?>
									<?php endif; ?>
								<?php endwhile; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</section>

			<section class="newsletter-section">
				<?php get_template_part('template-parts/newsletter'); ?>
			</section>				

			<?php
       }
       ?>
<script>
	jQuery(document).ready(function ($) {
		$(".main-category ul").slick({
			dots: false,
			infinite: false,
			speed: 300,
			slidesToShow: 4,
			slidesToScroll: 1,
			arrows: true,
			responsive: [
				{
				breakpoint: 1200,
					settings: {
						slidesToShow: 3,
					}
				},
				{
				breakpoint: 768,
					settings: {
						slidesToShow: 2,
					}
				},
				{
				breakpoint: 576,
					settings: {
						slidesToShow: 1,
					}
				}
			]
		});
		$(function () {
			var getLength = jQuery('.post-card').length;
			if (getLength <= 8) {
				$(".load-more-btn").remove();
			}
			$(".post-card").slice(0, 8).addClass('display');
			$("#loadMore").on('click', function (e) {
				e.preventDefault();
				$(".post-card:hidden").slice(0, 8).addClass('display');
				if ($(".post-card:hidden").length == 0) {
				$(".load-more-btn").remove();
				} else {
					// $('html,body').animate({
					// 	scrollTop: $(this).offset().top
					// }, 1500);
				}
			});
		});
	});  
</script>
<script>
	window.onload = function() {
		// Get the input element by its ID
		var myInput = document.querySelector('.search-field');

		// Set the placeholder attribute
		myInput.placeholder = 'Search all blogs';
	};
</script>

<?php get_footer(); ?>
