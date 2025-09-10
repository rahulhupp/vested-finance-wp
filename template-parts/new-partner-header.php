
<?php $partner_landing_v3 = is_page_template('templates/page-partner-landing-v3.php'); ?>
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
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"class="custom-logo-link" rel="home nofollow">
                                            <?php
                                                $logo_id = get_theme_mod('custom_logo'); // Gets the logo ID from Astra theme settings
                                                $logo_url = wp_get_attachment_image_url($logo_id, 'full'); // Get the full image URL

                                                if ($logo_url) {
                                                    echo '<img src="' . esc_url($logo_url) . '" alt="' . get_bloginfo('name') . '" class="custom-logo">';
                                                } else {
                                                    echo '<h1>' . get_bloginfo('name') . '</h1>'; // Fallback to site title if logo not set
                                                }
                                            ?>
                                        </a>
                                    </span>
                                </div>
                                <!-- .site-branding -->
                            </div>
                        </div>
                        <div class="humburger">
                            <div class="inner">
                                <div class="icon"></div>
                            </div>
                        </div>
                        <div class="menu-overlay"></div>
                        <div
                            class="main-menu site-header-primary-section-right site-header-section ast-flex ast-grid-right-section">
                            <div class="ast-builder-menu-1 ast-builder-menu ast-flex ast-builder-menu-1-focus-item ast-builder-layout-element site-header-focus-item"
                                data-section="section-hb-menu-1">
                                <div class="ast-main-header-bar-alignment">
                                    <div id="mega-menu-wrap-primary" class="mega-menu-wrap">
                                        <div class="mega-menu-toggle">
                                            <div class="mega-toggle-blocks-left"></div>
                                            <div class="mega-toggle-blocks-center"></div>
                                            <div class="mega-toggle-blocks-right">
                                                <div class="mega-toggle-block mega-menu-toggle-animated-block mega-toggle-block-0"
                                                    id="mega-toggle-block-0"><button aria-label="Toggle Menu"
                                                        class="mega-toggle-animated mega-toggle-animated-slider"
                                                        type="button" aria-expanded="false">
                                                        <span class="mega-toggle-animated-box">
                                                            <span class="mega-toggle-animated-inner"></span>
                                                        </span>
                                                    </button></div>
                                            </div>
                                        </div>
                                        <ul id="mega-menu-primary" class="mega-menu max-mega-menu mega-menu-horizontal"
                                            data-event="hover_intent" data-effect="fade_up" data-effect-speed="200"
                                            data-effect-mobile="slide" data-effect-speed-mobile="200"
                                            data-mobile-force-width="false" data-second-click="go"
                                            data-document-click="collapse" data-vertical-behaviour="accordion"
                                            data-breakpoint="991" data-unbind="true" data-mobile-state="collapse_all"
                                            data-hover-intent-timeout="300" data-hover-intent-interval="100">
                                            <li class="mega-menu-item mega-menu-item-type-custom mega-menu-item-object-custom mega-align-bottom-left mega-menu-flyout">
                                                <a class="mega-menu-link" href="#whyusstocks" tabindex="0" rel="nofollow">Why US Stocks</a>
                                            </li>
                                            <li class="mega-menu-item mega-menu-item-type-custom mega-menu-item-object-custom mega-align-bottom-left mega-menu-flyout">
                                                <a class="mega-menu-link" href="#whyvested" tabindex="0" rel="nofollow">Why Vested</a>
                                            </li>
                                            <li class="mega-menu-item mega-menu-item-type-custom mega-menu-item-object-custom mega-align-bottom-left mega-menu-flyout">
                                                <a class="mega-menu-link" href="#safetysecurity" tabindex="0" rel="nofollow">Safety & Security</a>
                                            </li>
                                            <li class="mega-menu-item mega-menu-item-type-custom mega-menu-item-object-custom mega-align-bottom-left mega-menu-flyout">
                                                <a class="mega-menu-link" href="#pricing" tabindex="0" rel="nofollow">Pricing</a>
                                            </li>
                                            <li class="mega-menu-item mega-menu-item-type-custom mega-menu-item-object-custom mega-align-bottom-left mega-menu-flyout">
                                                <a class="mega-menu-link" href="#stepstoinvest" tabindex="0" rel="nofollow">Steps to Invest</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mobile right-button">
                                <div class="account-menu">
                                    <ul class="menu-wrapper">
                                        <li id="menu-item-1153" class="primary-btn menu-item menu-item-type-custom menu-item-object-custom menu-item-1153">
                                            <?php if (have_rows('banner_button')) : ?>
                                                <?php while (have_rows('banner_button')): the_row(); ?>
                                                    <?php if($partner_landing_v3) : ?>
                                                        <a class="menu-link openInvestPopoverBtn"><?php the_sub_field('banner_button_text'); ?></a>
                                                    <?php else : ?>
                                                        <a href="<?php the_sub_field('banner_button_link'); ?>" class="menu-link"><?php the_sub_field('banner_button_text'); ?></a>
                                                    <?php endif; ?>    
                                                <?php endwhile; ?>
                                            <?php endif; ?>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="desktop right-button">
                        <div class="account-menu">
                            <ul class="menu-wrapper">
                                <li class="primary-btn menu-item menu-item-type-custom menu-item-object-custom menu-item-1153">
                                    <?php if (have_rows('banner_button')) : ?>
                                        <?php while (have_rows('banner_button')): the_row(); ?>
                                            <?php if($partner_landing_v3) : ?>
                                                <a class="menu-link openInvestPopoverBtn"><?php the_sub_field('banner_button_text'); ?></a>
                                            <?php else : ?>
                                                <a href="<?php the_sub_field('banner_button_link'); ?>" class="menu-link"><?php the_sub_field('banner_button_text'); ?></a>
                                            <?php endif; ?>  
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if (strpos(home_url(add_query_arg([], $wp->request)), 'weekend-investing') !== false) {
                ?>
                <div class="partner_top_banner">
                    <div class="container">
                        <div class="partner_top_banner_wrapper">
                            Already a Vested user? <a href='https://vestedfinance.typeform.com/ustop10'>Click here to access this Vest.</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        ?>
        <div class="ast-desktop-header-content content-align-flex-start " style="display: none;">
        </div>
    </div>
</header>