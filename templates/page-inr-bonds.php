<?php
/*
Template name: Page - INR Bonds
*/
get_header(); ?>
<?php $inr_bonds_data = fetch_inr_bonds_api_data(); ?>
	<div id="content" role="main" class="inr-bonds-page">
		<section class="bonds_banner_section">
			<div class="container">
				<div class="bonds_banner_wrapper">
					<div class="bonds_banner_content">
						<div class="sub_heading">
							<?php if ($image = get_field('banner_sub_heading_icon')): ?>
								<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
							<?php endif; ?>
							<span><?php the_field('banner_sub_heading'); ?></span>
						</div>
						<h1><?php the_field('banner_heading'); ?></h1>
						<?php if (have_rows('banner_bonds_list')): ?>
							<ul class="banner_list">
								<?php while (have_rows('banner_bonds_list')):
									the_row(); ?>
									<li><?php the_sub_field('banner_single_bond_list') ?></li>
								<?php endwhile; ?>
							</ul>
						<?php endif; ?>
						<div class="banner_buttons">
							<a href="<?php the_field('banner_button_one_url'); ?>" class="btn_dark" target="_blank">
								<?php the_field('banner_button_one_text'); ?>
							</a>
							<?php if ($button_text = get_field('banner_button_two_text')): ?>
								<a href="<?php the_field('banner_button_two_url'); ?>" class="btn_link">
									<?php echo $button_text; ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
					<div class="bonds_banner_image">
						<?php if ($image = get_field('banner_banner_image')): ?>
							<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>

		<section class="explore_bonds_section">
			<div class="container">
				<div class="explore_bonds_wrapper">
					<div class="explore_bonds_image mobile_hide">
						<?php if ($image = get_field('explore_bonds_image')): ?>
							<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
						<?php endif; ?>
					</div>
					<div class="explore_bonds_content">
						<h2 class="mobile_hide"><?php the_field('explore_bonds_heading'); ?></h2>
						<h2 class="desktop_hide"><?php the_field('explore_bonds_heading_mobile'); ?></h2>
						<?php if ($image = get_field('explore_bonds_image')): ?>
							<img src="<?= esc_url($image['url']); ?>" alt="<?= esc_attr($image['alt']); ?>" class="desktop_hide" />
						<?php endif; ?>
						<?php if (have_rows('explore_corporate_bonds_list')): ?>
							<div class="explore_bonds_list mobile_hide">
								<?php while (have_rows('explore_corporate_bonds_list')): the_row(); ?>
									<div class="single_bond_list">
										<div class="single_bond_icon">
											<?php if ($image = get_sub_field('corporate_bonds_list_icon')): ?>
												<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
											<?php endif; ?>
										</div>
										<p><?php the_sub_field('corporate_bonds_list_text'); ?></p>
									</div>
								<?php endwhile; ?>
							</div>
						<?php endif; ?>
						<?php if (have_rows('explore_corporate_bonds_list_mobile')): ?>
							<div class="explore_bonds_list desktop_hide">
								<?php while (have_rows('explore_corporate_bonds_list_mobile')): the_row(); ?>
									<div class="single_bond_list">
										<div class="single_bond_icon">
											<?php $image = get_sub_field('corporate_bonds_list_icon_mobile'); ?>
											<?php if (!empty($image)): ?>
												<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
											<?php endif; ?>
										</div>
										<p><?php the_sub_field('corporate_bonds_list_text_mobile'); ?></p>
									</div>
								<?php endwhile; ?>
							</div>
						<?php endif; ?>
						<div class="explore_bonds_buttons">
							<a href="<?php the_field('explore_bonds_button_one_url'); ?>" class="btn_dark" target="_blank">
								<?php the_field('explore_bonds_button_one_text'); ?>
							</a>
						</div>
					</div>
				</div>
			</div>				
		</section>

		<section class="bonds_list_section">
			<div class="container">
				<div class="bonds_list_wrapper">
					<h2><?php the_field('diversify_heading'); ?></h2>
					<div class="bonds_tabs_container">
						<div class="bonds_tabs_buttons">
							<button class="bonds_tab_button active" onclick="openTab('corporate_bonds')">Corporate Bonds</button>
							<!-- <button class="bonds_tab_button" onclick="openTab('gold_bonds')">SGBs</button> -->
							<button class="bonds_tab_button" onclick="openTab('government_bonds')">Gsecs</button>
						</div>
						<div class="bonds_tabs_content">
							<div id="corporate_bonds" class="bonds_tab_content active">
								<div class="bonds_tab_content_wrappr">
									<button id="cb_modal_button">What are corporate bonds?</button>
									<div class="bonds_slider_container">
										<div class="bonds_slider" id="corporate_bonds_slider">
											<?php foreach ($inr_bonds_data as $bond): ?>
												<?php if ($bond['bondCategory'] == 'CORPORATE' ): ?>
													<div class="bonds_slider_item">
														<div class="bonds_slider_item_wrapper">
															<div class="bonds_slider_item_head">
																<div class="bond_image">
																	<img src="<?php echo $bond['logo']; ?>" />
																</div>
																<div class="bond_rating" style="background-color: <?php echo explode(",",$bond['ratingColorCode'])[0]; ?>">
																	<span style="color: <?php echo explode(",",$bond['ratingColorCode'])[1]; ?>"><?php echo $bond['rating']; ?></span>
																</div>
															</div>
															<h3><?php echo $bond['displayName']; ?></h3>
															<div class="bond_details_list">
																<div class="bond_detail_item">
																	<span>Min investment</span>
																	<strong>
																		<?php
																			$minimumInvestment = number_format($bond['minimumInvestment'], 0, '.', ',');
																			echo '₹' . $minimumInvestment;
																		?>
																	</strong>
																</div>
																<div class="bond_detail_item">
																	<span>Yield</span>
																	<strong><?php echo number_format($bond['yield'], 2); ?>%</strong>
																</div>
																<div class="bond_detail_item">
																	<span>Matures in</span>
																	<strong>
																		<?php
																			$months = $bond['maturityInMonths'];
																			$years = floor($months / 12);
																			$remainingMonths = $months % 12;
																			if ($years > 0 && $remainingMonths > 0) {
																				$formattedString = $years . ' year' . ($years > 1 ? 's' : '') . ' ' . $remainingMonths . ' month' . ($remainingMonths > 1 ? 's' : '');
																			} elseif ($years > 0) {
																				$formattedString = $years . ' year' . ($years > 1 ? 's' : '');
																			} else {
																				$formattedString = $months . ' month' . ($months > 1 ? 's' : '');
																			}
																			echo $formattedString;
																		?>
																	</strong>
																</div>
																<div class="bond_detail_item">
																	<span>Payment Frequency</span>
																	<strong><?php echo ucwords(strtolower($bond['interestPayFreq'])); ?></strong>
																</div>
															</div>
															<a href="https://app.vestedfinance.com/signup" class="btn_dark" target="_blank">
																<span>Explore Now</span>
																<i class="fa fa-chevron-right"></i>
															</a>
														</div>
													</div>
												<?php endif; ?>
											<?php endforeach; ?>
										</div>
									</div>		
								</div>			
							</div>
							<!-- <div id="gold_bonds" class="bonds_tab_content">Sovereign Gold Bond Schemes</div> -->
							<div id="government_bonds" class="bonds_tab_content">
								<div class="bonds_tab_content_wrappr">
									<button id="gb_modal_button">What are government bonds?</button>
									<div class="bonds_slider_container">
										<div class="bonds_slider" id="government_bonds_slider">
											<?php foreach ($inr_bonds_data as $bond): ?>
												<?php if ($bond['bondCategory'] == 'GOVT' ): ?>
													<div class="bonds_slider_item">
														<div class="bonds_slider_item_wrapper">
															<div class="bonds_slider_item_head">
																<div class="bond_image">
																	<img src="<?php echo $bond['logo']; ?>" />
																</div>
																<div class="bond_rating" style="background-color: <?php echo explode(",",$bond['ratingColorCode'])[0]; ?>">
																	<span style="color: <?php echo explode(",",$bond['ratingColorCode'])[1]; ?>"><?php echo $bond['rating']; ?></span>
																</div>
															</div>
															<h3><?php echo $bond['displayName']; ?></h3>
															<div class="bond_details_list">
																<div class="bond_detail_item">
																	<span>Min investment</span>
																	<strong>
																		<?php
																			$minimumInvestment = number_format($bond['minimumInvestment'], 0, '.', ',');
																			echo '₹' . $minimumInvestment;
																		?>
																	</strong>
																</div>
																<div class="bond_detail_item">
																	<span>Yield</span>
																	<strong><?php echo number_format($bond['yield'], 2); ?>%</strong>
																</div>
																<div class="bond_detail_item">
																	<span>Matures in</span>
																	<strong>
																		<?php
																			$months = $bond['maturityInMonths'];
																			$years = floor($months / 12);
																			$remainingMonths = $months % 12;
																			if ($years > 0 && $remainingMonths > 0) {
																				$formattedString = $years . ' year' . ($years > 1 ? 's' : '') . ' ' . $remainingMonths . ' month' . ($remainingMonths > 1 ? 's' : '');
																			} elseif ($years > 0) {
																				$formattedString = $years . ' year' . ($years > 1 ? 's' : '');
																			} else {
																				$formattedString = $months . ' month' . ($months > 1 ? 's' : '');
																			}
																			echo $formattedString;
																		?>
																	</strong>
																</div>
																<div class="bond_detail_item">
																	<span>Payment Frequency</span>
																	<strong><?php echo ucwords(strtolower($bond['interestPayFreq'])); ?></strong>
																</div>
															</div>
															<a href="https://app.vestedfinance.com/signup" class="btn_dark" target="_blank">
																<span>Explore Now</span>
																<i class="fa fa-chevron-right"></i>
															</a>
														</div>
													</div>
												<?php endif; ?>
											<?php endforeach; ?>
										</div>
									</div>		
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>


		<div id="cb_modal" class="modal">
			<div class="modal-content">
				<h2><?php the_field('bonds_heading'); ?></h2>
				<p><?php the_field('bonds_description'); ?></p>
				<button class="close"><?php the_field('bond_button_text'); ?></button>
			</div>
		</div>

		<div id="gb_modal" class="modal">
			<div class="modal-content">
				<h2><?php the_field('gov_bond_heading'); ?></h2>
				<p><?php the_field('gov_bond_description'); ?></p>
				<button class="close"><?php the_field('gov_button_text'); ?></button>
			</div>
		</div>
		
		<?php get_template_part('template-parts/inr-bonds-calculator', null, array('inr_bonds_data' => $inr_bonds_data)); ?>
		
		<section class="features_section">
			<div class="features_section_inner">
				<div class="container">
					<div class="features_wrapper">
						<h2><?php the_field('edge_heading'); ?></h2>
						<div class="features_list">
							<?php while (have_rows('edge_list')):
								the_row(); ?>
								<div class="feature_item">
									<div class="feature_item_icon">
										<?php if ($image = get_sub_field('edge_list_icon')): ?>
											<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
										<?php endif; ?>
									</div>
									<span><?php the_sub_field('edge_list_description') ?></span>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
					
				</div>
			</div>
		</section>

		<?php if (have_rows('portfolio_slider')): ?>
			<section class="portfolio_slider_sec steps_slides">
				<div class="container">
					<h2 class="portfolio_title">
						<?php the_field('portfolio_heading'); ?>
					</h2>
					<div class="portfolio_slider_wrap">
						<div class="portfolio_slider slider single-item">
							<?php while (have_rows('portfolio_slider')):
								the_row(); ?>
								<div class="single_portfolio_slider">
									<?php
									$image = get_sub_field('slider_image');
									if (!empty($image)): ?>
										<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
									<?php endif; ?>

								</div>
							<?php endwhile; ?>
						</div>
						<?php if (have_rows('portfolio_slider')): ?>
							<div class="portfolio_slider_content">
								<?php while (have_rows('portfolio_slider')):
									the_row(); ?>
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

		<?php if (have_rows('learning_list')): ?>
			<section class="invest_wisely_section">
				<div class="container">
					<div class="invest_wisely_wrapper">
						<h2><?php the_field('invest_wisely_heading'); ?></h2>
						<div class="invest_wisely_list">
							<?php while (have_rows('learning_list')):
							the_row(); ?>
								<div class="invest_wisely_item">
									<div class="invest_wisely_image">
										<img src="<?php the_sub_field('learning_image') ?>" alt="<?php the_sub_field('learning_title') ?>">
									</div>
									<div class="invest_wisely_content">
										<h3><?php the_sub_field('learning_title') ?></h3>
										<p><?php the_sub_field('learning_description') ?></p>
										<a href="<?php the_sub_field('learning_cta_url') ?>" class="btn_dark">
											<?php the_sub_field('learning_cta_text') ?>
										</a>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php if (have_rows('faq_list')): ?>
			<section class="faqs_section">
				<div class="container">
					<div class="faqs_wrapper">
						<h2><?php the_field('faqs_heading'); ?></h2>
						<div class="faqs_list">
							<?php while (have_rows('faq_list')):
							the_row(); ?>
								<div class="faq_item">
									<div class="faq_question">
										<span><?php the_sub_field('faq_question') ?></span>
										<div class="faq_icon">
											<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1 1L7 7L13 1" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</div>
									</div>
									<div class="faq_answer">
										<?php the_sub_field('faq_answer') ?>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
			</section>
		<?php endif; ?>
	</div>
<?php get_footer(); ?>