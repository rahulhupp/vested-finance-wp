<?php
/*
Template name: Page - US Stock India Copy
*/
get_header(); ?>

<header
    class="site-header header-main-layout-1 ast-primary-menu-enabled ast-logo-title-inline ast-hide-custom-menu-mobile ast-builder-menu-toggle-icon ast-mobile-header-inline"
    id="masthead" itemtype="https://schema.org/WPHeader" itemscope="itemscope" itemid="#masthead">
    <div id="ast-desktop-header" data-toggle-type="dropdown">
        <div class="inner-header ast-main-header-wrap main-header-bar-wrap ">
            <div class="ast-primary-header-bar ast-primary-header main-header-bar site-header-focus-item"
                data-section="section-primary-header-builder">
                <div class="site-primary-header-wrap ast-builder-grid-row-container site-header-focus-item ast-container"
                    data-section="section-primary-header-builder">
                    <div
                        class="logo-menu ast-builder-grid-row ast-builder-grid-row-has-sides ast-builder-grid-row-no-center">
                        <div
                            class="logo site-header-primary-section-left site-header-section ast-flex site-header-section-left">
                            <div class="ast-builder-layout-element ast-flex site-header-focus-item"
                                data-section="title_tagline">
                                <div class="site-branding ast-site-identity" itemtype="https://schema.org/Organization"
                                    itemscope="itemscope">
                                    <span class="site-logo-img">
                                        <?php
                                            $logo_id = get_theme_mod('custom_logo'); // Gets the logo ID from Astra theme settings
                                            $logo_url = wp_get_attachment_image_url($logo_id, 'full'); // Get the full image URL

                                            if ($logo_url) {
                                                echo '<img src="' . esc_url($logo_url) . '" alt="' . get_bloginfo('name') . '">';
                                            } else {
                                                echo '<h1>' . get_bloginfo('name') . '</h1>'; // Fallback to site title if logo not set
                                            }
                                        ?>
                                    </span>
                                </div>
                                <!-- .site-branding -->
                            </div>
                        </div>
                        <div class="menu-overlay"></div>
                        <div
                            class="main-menu site-header-primary-section-right site-header-section ast-flex ast-grid-right-section">
                            <div class="ast-builder-menu-1 ast-builder-menu ast-flex ast-builder-menu-1-focus-item ast-builder-layout-element site-header-focus-item"
                                data-section="section-hb-menu-1">
                                
                            </div>
                            <div class="mobile right-button">
                                <div class="account-menu">
                                    <ul class="menu-wrapper">
                                        <li id="menu-item-1152"
                                            class="login-btn menu-item menu-item-type-custom menu-item-object-custom menu-item-1152">
                                            <a href="https://app.vestedfinance.com/login" class="menu-link">Log in</a>
                                        </li>
                                        <li id="menu-item-1153"
                                            class="primary-btn menu-item menu-item-type-custom menu-item-object-custom menu-item-1153">
                                            <a href="https://app.vestedfinance.com/signup" class="menu-link">Sign up</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right-button">
                        <div class="account-menu">
                            <ul class="menu-wrapper">
                                <li
                                    class="login-btn menu-item menu-item-type-custom menu-item-object-custom menu-item-1152">
                                    <a href="https://app.vestedfinance.com/login" class="menu-link">Log in</a></li>
                                <li
                                    class="primary-btn menu-item menu-item-type-custom menu-item-object-custom menu-item-1153">
                                    <a href="https://app.vestedfinance.com/signup" class="menu-link">Sign up</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<div id="content" role="main" class="calc-page">
    <section class="stock-info">
        <div class="container">
            <div class="stock-row">
                <div class="stock-content">
                    <?php the_field('stock_content'); ?>
                    <div class="bottom">
                        <b><?php the_field('nri_text'); ?></b>
                        <div id="coupon-section" class="coupon">
                            <div class="coupon-header">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ticket.svg" alt="ticket-icon" />
                                <h3><?php the_field('coupon_title'); ?></h3>
                            </div>
                            <input type="text" id="coupon-code" placeholder="Enter code">
                            <p id="coupon-message"></p>
                        </div>
                        <div class="buttons">
                            <a class="btn_dark" id="applyCoupon"><?php the_field('start_investing_label'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="stock-image">
                    <?php
                    $image = get_field('stock_image');
                    if (!empty($image)): ?>
                        <img src="<?php echo esc_url($image['url']); ?>"
                            alt="<?php echo esc_attr($image['alt']); ?>" />
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="banner_popup_overlay">
            <div class="banner_popup">
                <div class="close_btn"><i class="fa fa-times"></i></div>
                <p>This page contains information on investing in US Stocks and ETFs via Vested. Securities mentioned on this page are offered through VF Securities, Inc. (member FINRA/SIPC). Alternative investment options outside of US Stocks and ETFs, that are offered on other sections of the website are not FINRA regulated and not protected by the SIPC. Stocks displayed are a representative sample of the watchlist feature and is not intended as a recommendation.</p>
            </div>
        </div>
    </section>

    <section class="explore-stock">
        <div class="container">
            <div class="head">
                <h2>Explore US Stocks</h2>
                <p>Discover the world of 10,000+ US Stocks and ETFs</p>
                <!-- <p class="desktop_hide">Issued by top rated companies with high <br>CRISIL ratings</p> -->
            </div>
            <div class="explore-image">
                <ul>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/apple.webp"
                                        alt="Apple" width="47" height="57">
                                </div>
                                <span>Apple</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/google.webp"
                                        alt="Google" width="58" height="71">
                                </div>
                                <span>Google</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/invesco.webp"
                                        alt="Invesco" width="54" height="44">
                                </div>
                                <span>Invesco</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/microsoft.webp"
                                        alt="Microsoft" width="58" height="57">
                                </div>
                                <span>Microsoft</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/tesla.webp"
                                        alt="Tesla" width="58" height="57">
                                </div>
                                <span>Tesla</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/meta.webp"
                                        alt="Meta" width="57" height="33">
                                </div>
                                <span>Meta</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/netflix.webp"
                                        alt="Netflix" width="71" height="47">
                                </div>
                                <span>Netflix</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/spdr.webp"
                                        alt="Spdr" width="78" height="44">
                                </div>
                                <span>SPDR</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/amazon.webp"
                                        alt="Amazon" width="58" height="57">
                                </div>
                                <span>Amazon</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/spotify.webp"
                                        alt="Spotify" width="46" height="47">
                                </div>
                                <span>Spotify</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bottom-content text-center">
                <p>Disclosure: This list is representative of stocks available but is not intended to recommend any
                    investment.</p>
            </div>
        </div>
    </section>

    <section class="build-foundation">
        <div class="container">
            <div class="explore_vest_head">
                <h2>Build a solid foundation with Vests</h2>
                <p class="explore_vest_desc">Vests are expert-built investment baskets built with a specific purpose. Each
                    basket contains curated US Stocks and ETFs, built to target specific goals.</p>

                <div class="explore_vest_about_content">
                    <p class="vest_about_content" style="display: none;">
                        If you want to invest but don't have the time to research individual stocks, Vests offer a solution.
                        They come in various categories, each focusing on a different investment objective. For instance, a
                        Vest might aim for growth potential while another prioritizes stability. Vests can also cater to
                        specific interests. Let's say you're passionate about renewable energy. You could choose a Vest that
                        concentrates on companies in that sector. Explore Vests below.
                    </p>
                    <div id="vest_read_more">Read <span>More</span> <i class="fa fa-chevron-down"></i></div>
                </div>
            </div>
            <div class="foundation-list">
                <div class="skeleton_main" style="display: none;">
                    <div class="skeleton_wrapper">
                        <div class="skeleton_wrapper_figure">
                            <span class="skeleton-box" style="width:100px;height:80px;"></span>
                        </div>
                        <div class="skeleton_wrapper_body">
                            <div class="skeleton_main">
                                <h3> <span class="skeleton-box" style="width:55%;"></span> </h3>
                                <span class="skeleton-box" style="width:80%;"></span>
                                <span class="skeleton-box" style="width:90%;"></span>
                                <span class="skeleton-box" style="width:83%;"></span>
                                <span class="skeleton-box" style="width:80%;"></span>
                                <div class="blog-post__meta">
                                    <span class="skeleton-box" style="width:70px;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="vests_list_conatiner" style="display: flex;">
                    <ul id="vestsResultsList">
                        <li>
                            <a class="inner">
                                <div class="top">
                                    <div class="vest_img">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/e4e460f6-8ba4-4965-9a3f-dd7d45de9c32.svg"
                                            alt="solid-foundations">
                                    </div>
                                    <strong>Bitcoin Vest</strong>
                                </div>
                                <div class="middle">
                                    <div class="left">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest-risk/grey/5.svg"
                                            alt="progress bar">
                                        <strong>Aggressive</strong>
                                    </div>
                                    <div class="right">
                                        <div class="per-value">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="5" viewBox="0 0 6 5"
                                                fill="none">
                                                <path d="M3 0L5.59808 4.5H0.401924L3 0Z" fill="#0CC786" alt="green-up">
                                                </path>
                                            </svg>
                                            <span class="green">118.57%</span>
                                        </div>
                                        <span class="past-year">Past Year</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <span>Recommended for</span>
                                    <p>Investors who want to track the performance of Bitcoin.</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="inner">
                                <div class="top">
                                    <div class="vest_img">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/9aa14eb6-f887-477b-854d-ad091ff13c77.svg"
                                            alt="solid-foundations">
                                    </div>
                                    <strong>Moat</strong>
                                </div>
                                <div class="middle">
                                    <div class="left">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest-risk/grey/5.svg"
                                            alt="progress bar">
                                        <strong>Aggressive</strong>
                                    </div>
                                    <div class="right">
                                        <div class="per-value">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="5" viewBox="0 0 6 5"
                                                fill="none">
                                                <path d="M3 0L5.59808 4.5H0.401924L3 0Z" fill="#0CC786" alt="green-up">
                                                </path>
                                            </svg>
                                            <span class="green">27.38%</span>
                                        </div>
                                        <span class="past-year">Past Year</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <span>Recommended for</span>
                                    <p>You believe businesses with sustainable competitive advantages will generate higher
                                        returns.</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="inner">
                                <div class="top">
                                    <div class="vest_img">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/5f0318f6-a593-4652-8c93-d281bef895bc.svg"
                                            alt="solid-foundations">
                                    </div>
                                    <strong>Deglobalization Vest</strong>
                                </div>
                                <div class="middle">
                                    <div class="left">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest-risk/grey/5.svg"
                                            alt="progress bar">
                                        <strong>Aggressive</strong>
                                    </div>
                                    <div class="right">
                                        <div class="per-value">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="5" viewBox="0 0 6 5"
                                                fill="none">
                                                <path d="M3 0L5.59808 4.5H0.401924L3 0Z" fill="#0CC786" alt="green-up">
                                                </path>
                                            </svg>
                                            <span class="green">16.34%</span>
                                        </div>
                                        <span class="past-year">Past Year</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <span>Recommended for</span>
                                    <p>This Vest consists of stocks and ETFs that provide exposure to trends of
                                        deglobalization.</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="inner">
                                <div class="top">
                                    <div class="vest_img">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/ba726e04-051c-4536-8a4d-6b5da0965c39.svg"
                                            alt="solid-foundations">
                                    </div>
                                    <strong>Digital Cash</strong>
                                </div>
                                <div class="middle">
                                    <div class="left">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest-risk/grey/5.svg"
                                            alt="progress bar">
                                        <strong>Aggressive</strong>
                                    </div>
                                    <div class="right">
                                        <div class="per-value">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="5" viewBox="0 0 6 5"
                                                fill="none">
                                                <path d="M3 0L5.59808 4.5H0.401924L3 0Z" fill="#0CC786" alt="green-up">
                                                </path>
                                            </svg>
                                            <span class="green">15.19%</span>
                                        </div>
                                        <span class="past-year">Past Year</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <span>Recommended for</span>
                                    <p>You believe that digital payment is the way of the future and you desire to invest in
                                        this segment.</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="inner">
                                <div class="top">
                                    <div class="vest_img">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/cc19fc6d-883e-42c8-a2ca-479a528e8b8e.svg"
                                            alt="solid-foundations">
                                    </div>
                                    <strong>Cloud Computing</strong>
                                </div>
                                <div class="middle">
                                    <div class="left">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest-risk/grey/5.svg"
                                            alt="progress bar">
                                        <strong>Aggressive</strong>
                                    </div>
                                    <div class="right">
                                        <div class="per-value">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="5" viewBox="0 0 6 5"
                                                fill="none">
                                                <path d="M3 0L5.59808 4.5H0.401924L3 0Z" fill="#0CC786" alt="green-up">
                                                </path>
                                            </svg>
                                            <span class="green">11.56%</span>
                                        </div>
                                        <span class="past-year">Past Year</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <span>Recommended for</span>
                                    <p>You believe software as a service companies will generate higher returns.</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="inner">
                                <div class="top">
                                    <div class="vest_img">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/b3fed130-4ce1-4ede-88a8-bab161cfa476.svg"
                                            alt="solid-foundations">
                                    </div>
                                    <strong>Aging Vest</strong>
                                </div>
                                <div class="middle">
                                    <div class="left">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest-risk/grey/4.svg"
                                            alt="progress bar">
                                        <strong>Aggressive</strong>
                                    </div>
                                    <div class="right">
                                        <div class="per-value">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="5" viewBox="0 0 6 5"
                                                fill="none">
                                                <path d="M3 0L5.59808 4.5H0.401924L3 0Z" fill="#0CC786" alt="green-up">
                                                </path>
                                            </svg>
                                            <span class="green">11.44%</span>
                                        </div>
                                        <span class="past-year">Past Year</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <span>Recommended for</span>
                                    <p>For investors who believe that the aging population will have an economic impact and
                                        want to increase investment exposures toward sectors that include: an increase in
                                        healthcare spending, an increase in elderly-focused real estate, and an increase in
                                        levels of automation.</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="inner">
                                <div class="top">
                                    <div class="vest_img">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/e9321be4-dac7-4b9b-aa4c-71bdf38da657.svg"
                                            alt="solid-foundations">
                                    </div>
                                    <strong>BlackRock Smart Beta</strong>
                                </div>
                                <div class="middle">
                                    <div class="left">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest-risk/grey/4.svg"
                                            alt="progress bar">
                                        <strong>Aggressive</strong>
                                    </div>
                                    <div class="right">
                                        <div class="per-value">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="5" viewBox="0 0 6 5"
                                                fill="none">
                                                <path d="M3 0L5.59808 4.5H0.401924L3 0Z" fill="#0CC786" alt="green-up">
                                                </path>
                                            </svg>
                                            <span class="green">9.09%</span>
                                        </div>
                                        <span class="past-year">Past Year</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <span>Recommended for</span>
                                    <p>You want to employ a long term investment that takes advantage of smart beta
                                        strategies.</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="inner">
                                <div class="top">
                                    <div class="vest_img">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/8f35449c-6497-4f90-8569-4408bf388386.svg"
                                            alt="solid-foundations">
                                    </div>
                                    <strong>Multi-Asset Class - Moderate</strong>
                                </div>
                                <div class="middle">
                                    <div class="left">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest-risk/grey/3.svg"
                                            alt="progress bar">
                                        <strong>Moderate</strong>
                                    </div>
                                    <div class="right">
                                        <div class="per-value">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="5" viewBox="0 0 6 5"
                                                fill="none">
                                                <path d="M3 0L5.59808 4.5H0.401924L3 0Z" fill="#0CC786" alt="green-up">
                                                </path>
                                            </svg>
                                            <span class="green">8.96%</span>
                                        </div>
                                        <span class="past-year">Past Year</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <span>Recommended for</span>
                                    <p>Optimized for balanced growth while minimizing volatility.</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="inner">
                                <div class="top">
                                    <div class="vest_img">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/5299078d-6895-4266-87f8-d407802fa719.svg"
                                            alt="solid-foundations">
                                    </div>
                                    <strong>Multi-Asset Class - Aggressive</strong>
                                </div>
                                <div class="middle">
                                    <div class="left">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest-risk/grey/5.svg"
                                            alt="progress bar">
                                        <strong>Aggressive</strong>
                                    </div>
                                    <div class="right">
                                        <div class="per-value">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="5" viewBox="0 0 6 5"
                                                fill="none">
                                                <path d="M3 0L5.59808 4.5H0.401924L3 0Z" fill="#0CC786" alt="green-up">
                                                </path>
                                            </svg>
                                            <span class="green">8.78%</span>
                                        </div>
                                        <span class="past-year">Past Year</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <span>Recommended for</span>
                                    <p>Optimized for more aggressive growth while maintaining portfolio efficiency.</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="inner">
                                <div class="top">
                                    <div class="vest_img">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/41a70cef-7781-4c3d-85a7-4c1f1e6a27df.svg"
                                            alt="solid-foundations">
                                    </div>
                                    <strong>99rises ZeroCarbon</strong>
                                </div>
                                <div class="middle">
                                    <div class="left">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest-risk/grey/5.svg"
                                            alt="progress bar">
                                        <strong>Aggressive</strong>
                                    </div>
                                    <div class="right">
                                        <div class="per-value">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="5" viewBox="0 0 6 5"
                                                fill="none">
                                                <path d="M3 0L5.59808 4.5H0.401924L3 0Z" fill="#0CC786" alt="green-up">
                                                </path>
                                            </svg>
                                            <span class="green">8.27%</span>
                                        </div>
                                        <span class="past-year">Past Year</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <span>Recommended for</span>
                                    <p>High-risk US equities portfolio focusing on renewable energy sector</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="inner">
                                <div class="top">
                                    <div class="vest_img">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/7d3d7ec1-27b3-4e21-9d56-6b8df7a62622.svg"
                                            alt="solid-foundations">
                                    </div>
                                    <strong>Multi-Asset Class - Conservative</strong>
                                </div>
                                <div class="middle">
                                    <div class="left">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest-risk/grey/1.svg"
                                            alt="progress bar">
                                        <strong>Conservative</strong>
                                    </div>
                                    <div class="right">
                                        <div class="per-value">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="5" viewBox="0 0 6 5"
                                                fill="none">
                                                <path d="M3 0L5.59808 4.5H0.401924L3 0Z" fill="#0CC786" alt="green-up">
                                                </path>
                                            </svg>
                                            <span class="green">7.8%</span>
                                        </div>
                                        <span class="past-year">Past Year</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <span>Recommended for</span>
                                    <p>Optimized for capital preservation.</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="inner">
                                <div class="top">
                                    <div class="vest_img">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/9fccae3e-364e-4008-8803-25a4f5e51297.svg"
                                            alt="solid-foundations">
                                    </div>
                                    <strong>Swensen Portfolio</strong>
                                </div>
                                <div class="middle">
                                    <div class="left">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest-risk/grey/2.svg"
                                            alt="progress bar">
                                        <strong>Conservative</strong>
                                    </div>
                                    <div class="right">
                                        <div class="per-value">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="5" viewBox="0 0 6 5"
                                                fill="none">
                                                <path d="M3 0L5.59808 4.5H0.401924L3 0Z" fill="#0CC786" alt="green-up">
                                                </path>
                                            </svg>
                                            <span class="green">7.41%</span>
                                        </div>
                                        <span class="past-year">Past Year</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <span>Recommended for</span>
                                    <p>You want to enjoy equity growth gains while maintaining downside protection by
                                        diversifying.</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="inner">
                                <div class="top">
                                    <div class="vest_img">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/0aef7869-1f01-47cf-bc97-676996a62632.svg"
                                            alt="solid-foundations">
                                    </div>
                                    <strong>99rises Fixed Income</strong>
                                </div>
                                <div class="middle">
                                    <div class="left">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest-risk/grey/3.svg"
                                            alt="progress bar">
                                        <strong>Moderate</strong>
                                    </div>
                                    <div class="right">
                                        <div class="per-value">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="5" viewBox="0 0 6 5"
                                                fill="none">
                                                <path d="M3 0L5.59808 4.5H0.401924L3 0Z" fill="#0CC786" alt="green-up">
                                                </path>
                                            </svg>
                                            <span class="green">5.39%</span>
                                        </div>
                                        <span class="past-year">Past Year</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <span>Recommended for</span>
                                    <p>This Vest follows a fixed-income ETF (Exchange-Traded Fund) based investment
                                        strategy. Fixed-income ETFs provide exposure to various fixed-income securities with
                                        varying maturities, credit ratings, and yields, allowing investors to manage risk
                                        and generate income.</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="inner">
                                <div class="top">
                                    <div class="vest_img">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/d6708276-c205-4cf0-b6e6-bedb4f831b92.svg"
                                            alt="solid-foundations">
                                    </div>
                                    <strong>All Weather</strong>
                                </div>
                                <div class="middle">
                                    <div class="left">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest-risk/grey/2.svg"
                                            alt="progress bar">
                                        <strong>Conservative</strong>
                                    </div>
                                    <div class="right">
                                        <div class="per-value">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="5" viewBox="0 0 6 5"
                                                fill="none">
                                                <path d="M3 0L5.59808 4.5H0.401924L3 0Z" fill="#0CC786" alt="green-up">
                                                </path>
                                            </svg>
                                            <span class="green">5.2%</span>
                                        </div>
                                        <span class="past-year">Past Year</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <span>Recommended for</span>
                                    <p>You prefer lower volatility and want to minimize potential large drawdowns during
                                        periods of recessions.</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="tab-section">
        <div class="container">
            <div class="tabs">
                <div class="head">
                    <h2><?php the_field('tab_heading'); ?></h2>
                    <?php if (have_rows('tab_item')) : $index = 1; ?>
                        <div class="nav_tabs_container">
                            <ul id="tabs-nav">
                                <?php while (have_rows('tab_item')) : the_row();
                                ?>
                                    <li>
                                        <a href="#tab<?php echo $index; ?>"><?php the_sub_field('title'); ?></a>
                                    </li>
                                    <?php $index++; ?>
                                <?php endwhile; ?>
                            </ul>

                            <ul id="mob-tabs">
                                <?php $mobIndex = 1;
                                while (have_rows('tab_item')) : the_row();
                                ?>
                                    <li><a href="#tab<?php echo $mobIndex; ?>"></a></li>
                                    <?php $mobIndex++; ?>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                </div>
                <div id="tabs-content" class="main-tabs">
                    <?php if (have_rows('tab_item')) : $index = 1; ?>
                        <?php while (have_rows('tab_item')) : the_row();
                        ?>
                            <div id="tab<?php echo $index; ?>" class="tab-content">
                                <div class="inner">
                                    <div class="content">
                                        <?php the_sub_field('content'); ?>
                                    </div>
                                    <div class="image">
                                        <?php if (get_sub_field('mobile_image')) { ?>
                                            <?php
                                            $image = get_sub_field('image');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" class="mobile_hide" />
                                            <?php endif; ?>

                                            <?php
                                            $image = get_sub_field('mobile_image');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" class="desktop_hide" />
                                            <?php endif; ?>
                                        <?php } else { ?>
                                            <?php
                                            $image = get_sub_field('image');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                                            <?php endif; ?>
                                        <?php } ?>
                                        <?php if ($index === 3) : ?><p class="img_source">Source: Bloomberg and CNBC<?php endif; ?></p>
                                    </div>
                                    <?php if ($index === 1) : ?><p class="img_source mt-0">Source: Bloomberg and CNBC<?php endif; ?></p>
                                </div>
                            </div>
                            <?php $index++; ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
            <p class="desc">Disclosure: Returns shown are based on historical performance. Past Performance does not guarantee future results.</p>
        </div>
    </section>

    <?php if (have_rows('stocks_slider')) : ?>
        <section class="stocks_slider_sec">
            <div class="container">
                <h2 class="section_title desktop_hide">
                    <span><?php the_field('stocks_slider_heading'); ?></span>
                </h2>
                <div class="stocks_slider_wrap">

                    <div class="stocks_slider_inner">
                        <h2 class="section_title align_left mobile_hide">
                            <span><?php the_field('stocks_slider_heading'); ?></span>
                        </h2>
                        <div class="stocks_slider_content">

                            <?php $currentIndexNo = 0;
                            while (have_rows('stocks_slider')) : the_row();

                            ?>
                                <div class="single_portfolio_slider_content" data-curent-slide="<?php echo $currentIndexNo; ?>">
                                    <div class="portfolio_slider_content_inner">
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBar"></span>
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBarMob"></span>
                                        <div class="portfolio_slider_inner_content">
                                            <span class="slider_index">0<?php echo get_row_index(); ?></span>
                                            <h3><?php the_sub_field('stocks_slider_slider_title') ?></h3>
                                            <p class="single_slider_desc">
                                                <?php the_sub_field('stocks_slider_slider_description') ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php $currentIndexNo++;
                            endwhile; ?>
                        </div>
                    </div>
                    <div class="us_stocks_slider stock-single-item">
                        <?php while (have_rows('stocks_slider')) : the_row(); ?>
                            <div class="single_portfolio_slider">
                                <?php
                                $image = get_sub_field('stocks_slider_image');
                                if (!empty($image)): ?>
                                    <img src="<?php echo esc_url($image['url']); ?>"
                                        alt="<?php echo esc_attr($image['alt']); ?>" />
                                <?php endif; ?>

                            </div>
                        <?php endwhile; ?>
                    </div>

                </div>
                <?php the_field('slider_disclaimer'); ?>
            </div>
        </section>
    <?php endif; ?>
    <section class="stock_chart_sec tmp_us_stocks_calculator">
        <?php
        $chart = 'true';
        ?>
        <?php get_template_part('template-parts/stocks-calculator-india'); ?>
    </section>
    <?php if (have_rows('portfolio_slider')) : ?>
        <section class="portfolio_slider_sec">
            <div class="container">
                <h2 class="section_title">
                    <span><?php the_field('portfolio_heading'); ?></span>
                </h2>
                <div class="portfolio_slider_wrap">
                    <div class="portfolio_slider slider single-item">
                        <?php while (have_rows('portfolio_slider')) : the_row(); ?>
                            <div class="single_portfolio_slider">

                                <?php
                                $image = get_sub_field('slider_image');
                                if (!empty($image)): ?>
                                    <img src="<?php echo esc_url($image['url']); ?>"
                                        alt="<?php echo esc_attr($image['alt']); ?>" />
                                <?php endif; ?>
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


    <?php get_template_part('template-parts/investors-slider'); ?>

    
    <section class="partners">
        <div class="container">
            <h2 class="section_title"><?php the_field('partners_heading'); ?></h2>
            <p class="sub_heading"><?php the_field('partners_sub_heading'); ?></p>
            <?php if (have_rows('partners_list')) : ?>
                <div class="partners_wrap">
                    <?php while (have_rows('partners_list')) : the_row(); ?>
                        <div class="single_partner_block">
                            <?php
                            $image = get_sub_field('partner_logo');
                            if (!empty($image)): ?>
                                <img src="<?php echo esc_url($image['url']); ?>"
                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <section class="eft_stock_info">
        <div class="container">
            <h2 class="section_title"><?php the_field('stock_eft_section_title'); ?></h2>
            <?php $eftContent = get_field('stock_eft_description');
            if ($eftContent) :
            ?>
                <?php echo $eftContent; ?>
            <?php endif; ?>
        </div>
    </section>
    <?php if (have_rows('faq_list')) : ?>
        <section class="home_page_faqs">
            <div class="container">
                <h2 class="section_title"><span><?php the_field('faqs_heading'); ?></span></h2>

                <div class="home_page_faq_wrap">
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

<script>
    localStorage.setItem("vests", true);
</script>
<style>
    .tmp_us_stocks_calculator .cta_btn {
        display: none;
    }
    .build-foundation .foundation-list ul {
        width: 100%;
        /* margin: 0; */
    }

    .build-foundation .foundation-list ul li {
        padding-right: 2px;
    }

    @media (max-width: 991px) {
        header .inner-header .site-primary-header-wrap .logo-menu {
            width: auto;
        }

        header .inner-header .site-primary-header-wrap {
            flex-direction: row;
        }

        .account-menu {
            width: 100px;
        }

        .account-menu .login-btn {
            display: none;
        }

        header .inner-header .site-primary-header-wrap .right-button .account-menu ul li {
            width: 100%;
        }
    }
</style>

<?php get_footer(); ?>