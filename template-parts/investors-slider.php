<?php if (have_rows('investors_reviews', 'option')) : ?>
    <section class="investors_sec">
        <div class="container">
            <h2 class="section_title"><span><?php the_field('investors_title', 'option'); ?></span></h2>
            <p class="investor_subtitle"><?php the_field('investors_sub_title', 'option'); ?></p>
            <div class="investors_slider_wrap">
                <div class="investors_slider">
                    <?php while (have_rows('investors_reviews', 'option')) : the_row(); ?>
                        <div class="single_investor_slide">
                            <div class="investor_slide_inner">
                                <div class="investor_details">
                                    <div class="investor_info">
                                        <div class="investor_img">
                                            <img src="<?php the_sub_field('investor_image') ?>" alt="<?php the_sub_field('investor_name') ?>">
                                        </div>
                                        <div class="investor_detail">
                                            <h4 class="invesetor_name">
                                                <?php the_sub_field('investor_name') ?>
                                            </h4>
                                            <p class="investor_designation">
                                                <?php the_sub_field('investor_designation') ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="platform_icon">
                                        <a href="<?php the_sub_field('investor_link') ?>" target="_blank">
                                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/linkedin-icon.webp" alt="Review Platform">
                                        </a>
                                    </div>
                                </div>
                                <div class="investor_review">
                                    <?php the_sub_field('investor_review') ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="investor_slider_nav">
                    <div class="investor_prev">
                        <svg width="28" height="20" viewBox="0 0 28 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27.1035 10.0566H1.74131M1.74131 10.0566L10.9639 0.833984M1.74131 10.0566L10.9639 19.2792" stroke="#002852" stroke-opacity="0.6" stroke-width="1.7" />
                        </svg>
                    </div>
                    <div class="investor_next">
                        <svg width="27" height="20" viewBox="0 0 27 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.283203 10.0566H25.6454M25.6454 10.0566L16.4228 0.833984M25.6454 10.0566L16.4228 19.2792" stroke="#002852" stroke-opacity="0.6" stroke-width="1.7" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="investor_desclaimer">
                <?php the_field('investors_disclaimer', 'option'); ?>
            </div>
        </div>

    </section>
<?php endif; ?>


<style>
		
	.investors_sec .container {
		max-width: 1230px;
	}
	.investors_sec h2.section_title {
	    margin: 0 0 10px 0;
	}

	.investors_slider_wrap,
	.investor_desclaimer {
		padding: 0 24px;
	}

	.investor_desclaimer {
		user-select: none;
	}

	.investors_sec {
		padding: 60px 0;
		background: #eef5fc;
	}

	.investor_subtitle {
		color: rgba(33, 37, 41, 0.6);
		text-align: center;
		font-family: "Inter", sans-serif;
		font-size: 18px !important;
		font-style: normal;
		font-weight: 400;
		line-height: 130%;
	}

	.investor_subtitle span {
		background: #0cc786;
		color: #fff;
		font-weight: 700;
		transform: skew(-15deg);
		display: inline-block;
		padding: 0 4px;
	}

	.single_investor_slide {
		background-color: transparent !important;
		padding: 0 !important;
		height: auto !important;
	}

	.investors_slider .slick-track {
		display: flex;
	}

	.investor_slide_inner {
		padding: 34px 18px 44px;
		background: #f9f9f9;
		border-radius: 10px;
		border: 1px solid rgba(0, 0, 0, 0.1);
		display: flex;
		flex-direction: column;
		min-height: 386px;
		height: 100%;
	}

	.investor_details {
		display: flex;
		justify-content: space-between;
		flex-wrap: wrap;
		min-height: 80px;
	}

	.investor_info {
		display: flex;
		width: calc(100% - 41px);
	}

	.investor_img {
		width: 52px;
		height: 52px;
		overflow: hidden;
		border-radius: 5px;
		margin-right: 10px;
	}

	.investor_img img {
		height: 100%;
		object-fit: cover;
		object-position: center;
	}

	.invesetor_name {
		color: rgba(33, 37, 41, 0.7);
		font-family: Inter;
		font-size: 14px;
		font-style: normal;
		font-weight: 700;
		line-height: 130%;
		letter-spacing: -0.28px;
		margin-top: 1px;
		margin-bottom: 3px;
	}

	.invesetor_name a {
		color: rgba(33, 37, 41, 0.7);
		font-family: Inter;
		font-size: 14px;
		font-style: normal;
		font-weight: 700;
		line-height: 130%;
		letter-spacing: -0.28px;
		margin-top: 1px;
		margin-bottom: 3px;
		transition: 0.3s all;
	}

	.invesetor_name a:hover {
		color: #002852;
	}

	.investor_designation {
		color: rgba(33, 37, 41, 0.7);
		font-family: Inter;
		font-size: 10px !important;
		font-style: normal;
		font-weight: 400;
		line-height: 130%;
		letter-spacing: -0.2px;
		margin-bottom: 0;
	}

	.investor_detail {
		width: calc(100% - 62px);
	}

	.platform_icon {
		width: 28px;
		height: 28px;
		overflow: hidden;
	}

	.investor_slider_nav {
		display: flex;
		align-items: center;
		justify-content: center;
		margin-bottom: 32px;
	}

	.investors_slider {
		margin-top: 50px;
		margin-bottom: 40px;
	}

	.investor_prev {
		border-radius: 30px;
		border: 1.7px solid rgba(0, 40, 82, 0.6);
		background: rgba(255, 255, 255, 0);
		width: 85px;
		height: 45px;
		display: flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
		margin-right: 12px;
	}

	.investor_next {
		border-radius: 30px;
		border: 1.7px solid rgba(0, 40, 82, 0.6);
		background: rgba(255, 255, 255, 0);
		width: 85px;
		height: 45px;
		display: flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
	}

	.investor_review {
		margin-top: 23px;
	}

	.investor_review p {
		color: rgba(33, 37, 41, 0.7);
		font-family: Inter;
		font-size: 14px !important;
		font-style: normal;
		font-weight: 400;
		line-height: 130%;
		letter-spacing: -0.24px;
		margin-bottom: 0;
	}

	.investor_desclaimer p {
		color: rgba(33, 37, 41, 0.7);
		font-family: Inter;
		font-size: 16px;
		font-style: normal;
		font-weight: 400;
		line-height: normal;
		margin-bottom: 0;
	}

	.investors_slider .slick-list {
		margin: 0 -6px;
	}

	.investors_slider .slick-list .single_investor_slide {
		margin: 0 6px;
	}

	@media (max-width: 1220px) {
		.investor_slide_inner {
			min-height: 380px;
		}
	}

	@media (max-width: 850px) {
		.investor_slide_inner {
			min-height: 400px;
		}
	}


	@media (max-width: 767px) {
		.investors_slider {
			margin-top: 30px;
			padding: 0 30px;
		}

		.investor_subtitle {
			font-size: 14px !important;
		}

		.investor_desclaimer p {
			font-size: 10px !important;
		}
		.investor_slide_inner {
			min-height: 360px;
		}

		.investors_slider_wrap,
		.investor_desclaimer {
			padding: 0;
		}
		.investors_slider_wrap {
			padding: 0 24px;
		}
		.investor_slider_nav {
		    margin-bottom: 45px;
		}
	}


	@media (max-width: 600px) {
		.investor_slide_inner {
			min-height: 350px;
		}

		.investors_slider_wrap {
			padding: 0;
		}
	}

</style>