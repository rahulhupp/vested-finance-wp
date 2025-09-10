<?php get_header(); ?>
<div id="content" role="main" class="benefits-page">
    <section class="benefits_banner">
        <div class="container">
            <div class="benefits_banner_wrapper">
                <div class="benefits_banner_content">
                    <h1>Global Investing for <?php the_field('benefits_name'); ?> India</h1>
                    <p>Exclusive benefits for <?php the_field('benefits_name'); ?> India employees to build a robust Global portfolio</p>
                    <a class="btn btn-primary openInvestPopoverBtn">Start Investing</a>
                </div>
                <div class="benefits_banner_image">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/exclusive-benefits/banner.svg" alt="Exclusive Benefits">
                </div>
            </div>
        </div>
    </section>
    <section class="benefits_metrics">
        <div class="container">
            <div class="benefits_metrics_wrapper">
                <div class="benefits_metrics_list">
                    <div class="benefits_metrics_item">
                        <h3>$70M+</h3>
                        <p>ESOP/RSUs Transferred</p>
                    </div>
                    <div class="benefits_metrics_item">
                        <h3>3,00,000+</h3>
                        <p>Global Portfolios Launched</p>
                    </div>
                    <div class="benefits_metrics_item">
                        <h3>$15,000</h3>
                        <p>Average Portfolio Value</p>
                    </div>
                    <div class="benefits_metrics_item">
                        <h3>$750M+</h3>
                        <p>Assets Under Administration</p>
                    </div>
                </div>
                <span>All numbers displayed are as of July 2025</span>
            </div>
        </div>
    </section>

    <section class="benefits_employees">
        <div class="container">
            <div class="benefits_employees_wrapper">
                <h2>Exclusive Benefits for <?php the_field('benefits_name'); ?> employees</h2>
                <div class="benefits_employees_list">
                    <div class="benefits_employees_item">
                        <h3><?php the_field('benefits_name'); ?></h3>

                        <?php if (have_rows('company_benefits')): ?>
                            <?php while (have_rows('company_benefits')): the_row(); ?>
                                <div class="benefits_employees_item_content">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/exclusive-benefits/check-icon.svg" alt="check-icon" />

                                    <?php if (get_sub_field('company_benefit_text')): ?>
                                        <p><?php the_sub_field('company_benefit_text'); ?></p>
                                    <?php endif; ?>

                                    <?php if (have_rows('company_sub_points')): ?>
                                        <ul>
                                            <?php while (have_rows('company_sub_points')): the_row(); ?>
                                                <li><?php the_sub_field('company_point_text'); ?></li>
                                            <?php endwhile; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <?php if (get_sub_field('company_optional_link_url')): ?>
                                        <a href="<?php the_sub_field('company_optional_link_url'); ?>" 
                                        target="_blank" 
                                        rel="noopener noreferrer">
                                        <?php the_sub_field('company_optional_link_text'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>

                    <div class="benefits_employees_item">
                        <h3>Vested Premium Benefits</h3>
                        <?php if (have_rows('vested_premium_benefits')): ?>
                            <?php while (have_rows('vested_premium_benefits')): the_row(); ?>
                                <div class="benefits_employees_item_content">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/exclusive-benefits/check-icon.svg" alt="check-icon" />

                                    <?php if (get_sub_field('vested_benefit_text')): ?>
                                        <p><?php the_sub_field('vested_benefit_text'); ?></p>
                                    <?php endif; ?>

                                    <?php if (have_rows('vested_sub_points')): ?>
                                        <ul>
                                            <?php while (have_rows('vested_sub_points')): the_row(); ?>
                                                <li><?php the_sub_field('vested_point_text'); ?></li>
                                            <?php endwhile; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <?php if (get_sub_field('vested_optional_link_url')): ?>
                                        <a href="<?php the_sub_field('vested_optional_link_url'); ?>" 
                                        target="_blank" 
                                        rel="noopener noreferrer">
                                        <?php the_sub_field('vested_optional_link_text'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="benefits_transform">
        <div class="container">
            <div class="benefits_transform_wrapper">
                <div class="benefits_transform_content">
                    <h2>Transform Your ESOP/RSUs into Global Wealth</h2>
                    <p>Vested gives you both liquidity and flexibility to manage your ESOP/RSUs–on your terms.</p>
                    <ul>
                        <li>
                            <strong>Share Transfers:</strong> Move your ESOP/RSUs directly from platforms like E-Trade, Morgan Stanley, Fidelity, etc. No fees. No forced selling. Hold or sell as you choose.
                        </li>
                        <li>
                            <strong>Fund Transfers:</strong> Already sold your equity? Transfer USD directly to your Vested account. Transferring USD directly from your ESOP/RSU account to your Vested brokerage account prevents FX fees and TCS. Funds transferred via this route also don’t get counted against your LRS $250,000 annual remittance limit.
                        </li>
                        <li>
                            <strong>Global Diversification:</strong> Get access to global investing opportunities - US Stocks, ETFs, Mutual Funds and more.
                        </li>
                        <li>
                            <strong>Strategic Selling:</strong> You are in control of your portfolio. Offload a portion, set up a SIP or cash out during peak valuations.
                        </li>
                    </ul>
                    <div class="benefits_transform_disclosure">Securities offered through VF Securities Inc.</div>
                </div>
                <div class="benefits_transform_image">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/exclusive-benefits/transform.svg" alt="Transform">
                </div>
            </div>
        </div>
    </section>

    <section class="benefits_why_us">
        <div class="container">
            <div class="benefits_why_us_wrapper">
                <div class="benefits_why_us_content">
                    <h2>Why US Markets Deserve a Place in Your Portfolio</h2>
                    <p>US markets offer more than just iconic brands — they provide long-term growth, global diversification, and a strong currency advantage. Here’s why millions of investors are going global.</p>
                    <div class="benefits_why_us_tabs_buttons">
                        <button class="benefits_why_us_tabs_button active" data-label="Diversification">Diversification</button>
                        <button class="benefits_why_us_tabs_button" data-label="Higher returns">Higher returns</button>
                        <button class="benefits_why_us_tabs_button" data-label="Currency Hedge">Currency Hedge</button>
                    </div>
                </div>
                <div class="benefits_why_us_tabs_content">
                    <div class="benefits_why_us_tabs_content_item active">
                        <div class="benefits_why_us_tabs_content_item_content">
                            <p>Investing in US Stock Markets can give your portfolio the global exposure it needs. US Securities Market lists the largestgest companies globally such as Tesla, Apple, NVIDIA, Amazon, Meta and more. Easily diversify your portfolio by doing SIP in US Stocks or investing in lump-sum and get exposure to global economies and industries.</p>
                        </div>
                        <div class="benefits_why_us_tabs_content_item_image">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/exclusive-benefits/diversification.png" alt="Diversification">
                            <span>Source: Bloomberg and CNBC</span>
                        </div>
                    </div>
                    <div class="benefits_why_us_tabs_content_item">
                        <div class="benefits_why_us_tabs_content_item_content">
                            <p>The strength of the dollar can be an investor’s ally. In the period 2010 to 2024, the US Stock Markets have given 83% higher returns compared to the Indian Stock markets.</p>
                            <p>Aside from the stock market gains, there’s potential for better returns from currency(USD) appreciation against INR.
                            <br />Read more: <a href="#" target="_blank" rel="noopener noreferrer">Why Investing in the US has given superior returns</a></p>
                        </div>
                        <div class="benefits_why_us_tabs_content_item_image">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/exclusive-benefits/higher-returns.png" alt="Higher Returns">
                            <span>Source: Bloomberg and CNBC</span>
                        </div>
                    </div>
                    <div class="benefits_why_us_tabs_content_item">
                        <div class="benefits_why_us_tabs_content_item_content">
                            <p>Investing directly in USD acts as a natural hedge against the INR (Indian Rupee). This can help eliminate single-currency risk from your portfolio and make it more diversified.</p>
                        </div>
                        <div class="benefits_why_us_tabs_content_item_image">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/exclusive-benefits/currency-hedge.png" alt="Currency Hedge">
                            <span>Source: Bloomberg and CNBC</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="benefits_why_us_disclosure">Disclosure: Returns shown are based on historical performance. Past Performance does not guarantee future results.</div>
        </div>
    </section>

    <section class="benefits_features">
        <div class="container">
            <div class="benefits_features_wrapper">
                <h2>Explore Global Investment Opportunities</h2>
                <p>Choose from a wide range of asset classes designed to help you build a diversified global portfolio — whether you're starting small or aiming big.</p>
                <div class="benefits_features_list">
                    <div class="benefits_features_item">
                        <div class="benefits_features_item_image">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-home/home-feature-1.png" alt="US Stocks">
                        </div>
                        <h3><a href="<?php echo home_url('/in/us-stocks/'); ?>">US Stocks & ETFs</a></h3>
                        <!-- <p>A VF Securities Inc. product</p> -->
                        <a href="<?php echo home_url('/in/us-stocks/'); ?>" class="learn_more_btn">
                            <span>Learn More</span>
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.75 13.5L11.25 9L6.75 4.5" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                    <div class="benefits_features_item">
                        <div class="benefits_features_item_image">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-home/home-feature-3.png" alt="Private Markets">
                        </div>
                        <div class="benefits_features_item_content">
                            <h3><a href="https://lp.vestedfinance.com/pre-ipo-1/" target="_blank" rel="noopener noreferrer">Private Markets</a></h3>
                            <label>Private Beta</label>
                        </div>
                        <!-- <p>A Vested Finance, Inc product</p> -->
                        <a href="https://lp.vestedfinance.com/pre-ipo-1/" target="_blank" rel="noopener noreferrer" class="learn_more_btn">
                            <span>Learn More</span>
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.75 13.5L11.25 9L6.75 4.5" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                    <div class="benefits_features_item">
                        <div class="benefits_features_item_image">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-home/home-feature-4.png" alt="Global Mutual Funds">
                        </div>
                        <div class="benefits_features_item_content">
                            <h3><a href="<?php echo home_url('/in/global-mutual-funds/'); ?>">Global Mutual Funds</a></h3>
                            <label>Join Waitlist</label>
                        </div>
                        <!-- <p>A VF Securities Inc. product</p> -->
                        <a href="<?php echo home_url('/in/global-mutual-funds/'); ?>" class="learn_more_btn">
                            <span>Learn More</span>
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.75 13.5L11.25 9L6.75 4.5" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>

                    <div class="benefits_features_item">
                        <div class="benefits_features_item_image">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-home/home-feature-2.png" alt="Managed Portfolios">
                        </div>
                        <div class="benefits_features_item_content">
                            <h3><a href="<?php echo home_url('/in/managed-portfolios/'); ?>">Managed Portfolios</a></h3>
                            <p>Previously Vests, by 
                                <svg width="80" height="22" viewBox="0 0 80 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect y="0.606323" width="20.7874" height="20.7874" rx="2.0773" fill="#002852"/>
                                    <path d="M5.23486 6.02314H7.7915C8.36553 6.02314 8.83056 6.48819 8.83057 7.06221C8.83057 7.63623 8.36553 8.10127 7.7915 8.10127H7.09814L11.1187 14.3776C11.4283 14.861 11.2875 15.5035 10.8042 15.8132C10.3209 16.1228 9.67831 15.9821 9.36865 15.4987L4.32275 7.62275C4.32207 7.62168 4.32148 7.61992 4.3208 7.61885C4.23187 7.47917 4.17409 7.31766 4.16064 7.14326C4.15996 7.13449 4.16013 7.12567 4.15967 7.11689C4.15873 7.09878 4.15771 7.08056 4.15771 7.06221C4.15772 6.84659 4.22304 6.64622 4.33545 6.48017C4.37008 6.42878 4.41036 6.38082 4.45459 6.33564C4.45733 6.33285 4.45963 6.32962 4.4624 6.32685L4.47217 6.31709C4.48124 6.30827 4.49105 6.30022 4.50049 6.2917C4.51502 6.27856 4.52917 6.26495 4.54443 6.25264C4.55167 6.24681 4.55947 6.24169 4.56689 6.23603C4.58763 6.2202 4.60846 6.2044 4.63037 6.19014C4.63242 6.1888 4.63514 6.18755 4.63721 6.18623C4.6456 6.18086 4.65411 6.17571 4.6626 6.1706C4.67895 6.16079 4.69548 6.15121 4.7124 6.14228C4.72818 6.13394 4.74422 6.1263 4.76025 6.11885C4.77663 6.11126 4.79324 6.10411 4.81006 6.09736C4.82906 6.0897 4.84842 6.08332 4.86768 6.07685C4.87713 6.0737 4.88642 6.06998 4.896 6.06709C4.91892 6.06013 4.94216 6.05482 4.96533 6.04951C4.9767 6.04692 4.988 6.04391 4.99951 6.0417C5.02224 6.03729 5.04502 6.03381 5.06787 6.03096C5.07858 6.02963 5.08929 6.02805 5.1001 6.02705C5.14504 6.02286 5.19004 6.02149 5.23486 6.02314ZM15.5522 6.02314C15.5967 6.0215 15.6414 6.02293 15.686 6.02705C15.6968 6.02803 15.7076 6.02964 15.7183 6.03096C15.7407 6.03374 15.7633 6.03644 15.7856 6.04072C15.7998 6.04341 15.8137 6.04723 15.8276 6.05049C15.8473 6.05511 15.8668 6.06031 15.8862 6.06611C15.8908 6.06746 15.8954 6.06861 15.8999 6.07002L15.9624 6.0915C15.9657 6.09276 15.9689 6.09411 15.9722 6.09541C15.9941 6.10406 16.0155 6.11366 16.0366 6.12373C16.0471 6.12874 16.0575 6.13396 16.0679 6.13935C16.09 6.1508 16.1112 6.16352 16.1323 6.17646C16.138 6.17996 16.1442 6.18261 16.1499 6.18623C16.1514 6.18719 16.1533 6.18819 16.1548 6.18916C16.1771 6.20363 16.1981 6.21994 16.2192 6.23603C16.225 6.24042 16.2312 6.24424 16.2368 6.24873L16.2515 6.26045C16.4825 6.45108 16.6304 6.73932 16.6304 7.06221C16.6304 7.11605 16.6246 7.16877 16.6167 7.22041C16.6155 7.22824 16.6142 7.23603 16.6128 7.24385C16.6021 7.30455 16.5857 7.36305 16.5649 7.41963C16.5621 7.42745 16.5592 7.43528 16.5562 7.44307C16.5267 7.5176 16.4898 7.58808 16.4448 7.65303L12.8618 13.2448L11.6274 11.3181L13.689 8.10127H12.9956C12.4217 8.10113 11.9565 7.63615 11.9565 7.06221C11.9566 6.48827 12.4217 6.02328 12.9956 6.02314H15.5522Z" fill="white"/>
                                    <path d="M27.2771 15.5H25.5055L28.7311 6.33751H30.7802L34.0103 15.5H32.2387L29.7914 8.21654H29.7199L27.2771 15.5ZM27.3353 11.9075H32.1671V13.2407H27.3353V11.9075ZM37.4865 15.6208C36.9467 15.6208 36.4635 15.4821 36.037 15.2047C35.6105 14.9273 35.2734 14.5247 35.0259 13.9968C34.7783 13.4689 34.6545 12.8276 34.6545 12.073C34.6545 11.3095 34.7798 10.6652 35.0303 10.1403C35.2839 9.61238 35.6254 9.21421 36.0549 8.94578C36.4844 8.67436 36.9631 8.53865 37.491 8.53865C37.8936 8.53865 38.2247 8.60725 38.4842 8.74445C38.7437 8.87867 38.9495 9.04122 39.1016 9.2321C39.2537 9.42001 39.3715 9.59747 39.455 9.7645H39.5221V6.33751H41.1461V15.5H39.5534V14.4173H39.455C39.3715 14.5843 39.2507 14.7618 39.0926 14.9497C38.9345 15.1346 38.7258 15.2927 38.4663 15.4239C38.2068 15.5552 37.8802 15.6208 37.4865 15.6208ZM37.9384 14.2921C38.2814 14.2921 38.5737 14.1996 38.8152 14.0147C39.0568 13.8268 39.2403 13.5658 39.3655 13.2317C39.4908 12.8977 39.5534 12.5085 39.5534 12.0641C39.5534 11.6197 39.4908 11.2334 39.3655 10.9053C39.2432 10.5772 39.0613 10.3222 38.8197 10.1403C38.5811 9.95836 38.2873 9.86739 37.9384 9.86739C37.5775 9.86739 37.2762 9.96135 37.0346 10.1492C36.7931 10.3372 36.6111 10.5966 36.4888 10.9277C36.3665 11.2588 36.3054 11.6376 36.3054 12.0641C36.3054 12.4936 36.3665 12.8768 36.4888 13.2139C36.6141 13.5479 36.7975 13.8119 37.0391 14.0057C37.2837 14.1966 37.5834 14.2921 37.9384 14.2921ZM49.0101 8.62813L46.5629 15.5H44.7733L42.3261 8.62813H44.053L45.6323 13.7328H45.7039L47.2876 8.62813H49.0101ZM50.1308 15.5V8.62813H51.7503V15.5H50.1308ZM50.945 7.65283C50.6885 7.65283 50.4678 7.56782 50.2829 7.39782C50.098 7.22483 50.0055 7.01754 50.0055 6.77595C50.0055 6.53138 50.098 6.32409 50.2829 6.15408C50.4678 5.98109 50.6885 5.8946 50.945 5.8946C51.2045 5.8946 51.4252 5.98109 51.6072 6.15408C51.7921 6.32409 51.8845 6.53138 51.8845 6.77595C51.8845 7.01754 51.7921 7.22483 51.6072 7.39782C51.4252 7.56782 51.2045 7.65283 50.945 7.65283ZM58.847 10.4445L57.3706 10.6056C57.3289 10.4565 57.2558 10.3163 57.1514 10.185C57.05 10.0538 56.9128 9.94792 56.7398 9.86739C56.5668 9.78686 56.3551 9.7466 56.1045 9.7466C55.7675 9.7466 55.4841 9.81967 55.2545 9.96582C55.0278 10.112 54.916 10.3014 54.9189 10.534C54.916 10.7338 54.989 10.8964 55.1382 11.0217C55.2903 11.1469 55.5408 11.2498 55.8898 11.3304L57.0619 11.5809C57.7121 11.7211 58.1953 11.9433 58.5115 12.2475C58.8306 12.5517 58.9917 12.9499 58.9946 13.442C58.9917 13.8745 58.8649 14.2563 58.6144 14.5873C58.3668 14.9154 58.0223 15.1719 57.5809 15.3568C57.1395 15.5418 56.6324 15.6342 56.0598 15.6342C55.2187 15.6342 54.5417 15.4582 54.0286 15.1063C53.5156 14.7514 53.2099 14.2578 53.1115 13.6254L54.6908 13.4733C54.7624 13.7835 54.9145 14.0177 55.1471 14.1757C55.3798 14.3338 55.6825 14.4128 56.0553 14.4128C56.4401 14.4128 56.7488 14.3338 56.9814 14.1757C57.217 14.0177 57.3348 13.8223 57.3348 13.5897C57.3348 13.3928 57.2588 13.2303 57.1067 13.102C56.9575 12.9738 56.7249 12.8753 56.4087 12.8067L55.2366 12.5607C54.5774 12.4235 54.0898 12.1923 53.7736 11.8672C53.4575 11.5391 53.3009 11.1246 53.3039 10.6235C53.3009 10.2 53.4157 9.83309 53.6484 9.52291C53.884 9.20974 54.2106 8.96815 54.6281 8.79814C55.0487 8.62515 55.5334 8.53865 56.0822 8.53865C56.8875 8.53865 57.5213 8.71015 57.9836 9.05315C58.4488 9.39615 58.7367 9.85994 58.847 10.4445ZM63.3276 15.6342C62.6565 15.6342 62.0749 15.4866 61.5828 15.1913C61.0907 14.896 60.7089 14.4829 60.4375 13.952C60.169 13.4211 60.0348 12.8008 60.0348 12.0909C60.0348 11.3811 60.169 10.7592 60.4375 10.2253C60.7089 9.69142 61.0907 9.27684 61.5828 8.98157C62.0749 8.68629 62.6565 8.53865 63.3276 8.53865C63.9987 8.53865 64.5803 8.68629 65.0724 8.98157C65.5645 9.27684 65.9448 9.69142 66.2132 10.2253C66.4847 10.7592 66.6204 11.3811 66.6204 12.0909C66.6204 12.8008 66.4847 13.4211 66.2132 13.952C65.9448 14.4829 65.5645 14.896 65.0724 15.1913C64.5803 15.4866 63.9987 15.6342 63.3276 15.6342ZM63.3365 14.3368C63.7004 14.3368 64.0046 14.2369 64.2492 14.037C64.4938 13.8342 64.6757 13.5628 64.795 13.2228C64.9173 12.8828 64.9785 12.504 64.9785 12.0864C64.9785 11.6659 64.9173 11.2856 64.795 10.9456C64.6757 10.6026 64.4938 10.3297 64.2492 10.1269C64.0046 9.92406 63.7004 9.82266 63.3365 9.82266C62.9637 9.82266 62.6535 9.92406 62.406 10.1269C62.1614 10.3297 61.978 10.6026 61.8557 10.9456C61.7364 11.2856 61.6767 11.6659 61.6767 12.0864C61.6767 12.504 61.7364 12.8828 61.8557 13.2228C61.978 13.5628 62.1614 13.8342 62.406 14.037C62.6535 14.2369 62.9637 14.3368 63.3365 14.3368ZM67.995 15.5V8.62813H69.5653V9.77344H69.6369C69.7621 9.37676 69.9769 9.07105 70.2811 8.8563C70.5883 8.63857 70.9388 8.52971 71.3325 8.52971C71.4219 8.52971 71.5219 8.53418 71.6322 8.54313C71.7456 8.54909 71.8395 8.55953 71.9141 8.57445V10.0642C71.8455 10.0404 71.7366 10.0195 71.5875 10.0016C71.4413 9.98073 71.2997 9.97029 71.1625 9.97029C70.8672 9.97029 70.6017 10.0344 70.3661 10.1627C70.1335 10.2879 69.95 10.4624 69.8158 10.6861C69.6816 10.9098 69.6145 11.1678 69.6145 11.4601V15.5H67.995ZM74.2058 18.077C73.9851 18.077 73.7808 18.0591 73.5929 18.0233C73.408 17.9905 73.2603 17.9517 73.15 17.9069L73.5258 16.6453C73.7614 16.7139 73.9717 16.7467 74.1566 16.7437C74.3415 16.7408 74.5041 16.6826 74.6443 16.5693C74.7874 16.4589 74.9082 16.274 75.0066 16.0145L75.1453 15.6432L72.6534 8.62813H74.3713L75.9551 13.8178H76.0267L77.6149 8.62813H79.3373L76.5859 16.3321C76.4577 16.696 76.2877 17.0077 76.0759 17.2672C75.8641 17.5296 75.6046 17.7295 75.2974 17.8667C74.9932 18.0069 74.6293 18.077 74.2058 18.077Z" fill="#002852"/>
                                </svg>
                            </p>
                        </div>
                        <a href="<?php echo home_url('/in/managed-portfolios/'); ?>" class="learn_more_btn">
                            <span>Learn More</span>
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.75 13.5L11.25 9L6.75 4.5" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="benefits_features_disclosure">
                    US Stocks & ETFs and Global Mutual Funds are offered by VF Securities, Inc. Managed Portfolios and Private Markets are offered by Vested Finance, Inc. 
                </div>
            </div>
        </div>
    </section>

    <section class="benefits_services">
        <div class="container">
            <div class="cards-section">
                <div class="benefits_services_wrapper cards">
                    <div class="benefits_service_item card">
                        <div class="benefits_service_content">
                            <div class="benefits_service_labels">
                                <span>US Stocks & ETFs</span>
                            </div>
                            <h3>Access the US Stock Market at Your Fingertips</h3>
                            <ul>
                                <li>Invest in 10,000+ US Stocks and ETFs</li>
                                <li>Seamless & low cost INR<>USD FX transfers</li>
                                <li>Buy fractional shares starting $0.01</li>
                            </ul>
                            <div class="benefits_service_footer">
                                <a href="<?php echo home_url('/in/us-stocks/'); ?>" class="btn btn-primary">Explore US Stocks</a>
                                <p class="desktop_disclosure">Offered by VF Securities Inc. Stock symbols shown here are representative of our offerings and are not meant to be a recommendation</p>
                            </div>
                        </div>
                        <div class="benefits_service_image">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-home/home-service-1.png" alt="US Stocks & ETFs">
                            <p class="mobile_disclosure">Offered by VF Securities Inc. Stock symbols shown here are representative of our offerings and are not meant to be a recommendation</p>
                        </div>
                    </div>
                    <div class="benefits_service_item card">
                        <div class="benefits_service_content">
                            <div class="benefits_service_labels">
                                <span>
                                    Managed Portfolios by
                                    <svg width="80" height="22" viewBox="0 0 80 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect y="0.606201" width="20.7874" height="20.7874" rx="2.0773" fill="#002852"/>
                                        <path d="M7.7915 6.02222C8.36553 6.02222 8.83154 6.48823 8.83154 7.06226C8.83143 7.63619 8.36546 8.10132 7.7915 8.10132H7.09814L11.1187 14.3777C11.4282 14.861 11.2875 15.5036 10.8042 15.8132C10.3209 16.1228 9.67832 15.982 9.36865 15.4988L4.34229 7.65308C4.32093 7.62224 4.3007 7.5905 4.28271 7.55737L4.26904 7.53003C4.26549 7.523 4.26266 7.51562 4.25928 7.50854C4.2495 7.48805 4.24038 7.46725 4.23193 7.44604C4.2273 7.43444 4.22343 7.42259 4.21924 7.41089C4.21447 7.39753 4.20882 7.38446 4.20459 7.37085L4.19482 7.33667C4.19235 7.32767 4.19119 7.31836 4.18896 7.30933C4.17578 7.25538 4.16504 7.20019 4.16064 7.14331C4.15996 7.13454 4.16013 7.12572 4.15967 7.11694C4.15872 7.09882 4.15772 7.08061 4.15771 7.06226C4.15771 6.84673 4.22313 6.64623 4.33545 6.48022C4.37008 6.42882 4.41036 6.38088 4.45459 6.33569C4.45733 6.33289 4.45963 6.32967 4.4624 6.3269L4.47217 6.31714C4.4873 6.30243 4.50288 6.28806 4.51904 6.27417C4.52517 6.26889 4.53135 6.26368 4.5376 6.25854C4.55243 6.24639 4.56785 6.23483 4.5835 6.22339C4.59857 6.21235 4.61372 6.2014 4.62939 6.19116C4.63186 6.18955 4.63473 6.18787 4.63721 6.18628C4.64561 6.1809 4.65411 6.17576 4.6626 6.17065C4.67895 6.16083 4.69548 6.15127 4.7124 6.14233C4.72818 6.13398 4.74422 6.12636 4.76025 6.1189C4.77728 6.111 4.7945 6.10342 4.81201 6.09644C4.82361 6.09179 4.83547 6.08794 4.84717 6.08374C4.86717 6.07659 4.88717 6.06917 4.90771 6.06323C4.92422 6.05843 4.94089 6.05448 4.95752 6.05054C4.9714 6.04726 4.98542 6.04446 4.99951 6.04175C5.02224 6.03734 5.04502 6.03386 5.06787 6.03101C5.07922 6.0296 5.09059 6.02814 5.10205 6.0271C5.12387 6.0251 5.14566 6.0238 5.16748 6.02319C5.17721 6.02292 5.18698 6.02222 5.19678 6.02222H7.7915ZM15.6187 6.02319C15.6405 6.02378 15.6623 6.02513 15.6841 6.0271C15.6955 6.02812 15.7069 6.02962 15.7183 6.03101C15.7407 6.03379 15.7633 6.03649 15.7856 6.04077C15.8031 6.04408 15.8203 6.04832 15.8374 6.05249C15.8505 6.05571 15.8634 6.05949 15.8765 6.06323C15.8842 6.06545 15.8922 6.0667 15.8999 6.06909L15.9624 6.09058C15.9684 6.09287 15.974 6.09597 15.98 6.09839C15.9956 6.10469 16.0107 6.11188 16.0259 6.1189C16.04 6.12543 16.054 6.13218 16.0679 6.1394C16.09 6.15085 16.1112 6.16357 16.1323 6.17651C16.138 6.18001 16.1442 6.18266 16.1499 6.18628C16.1518 6.18752 16.1538 6.18893 16.1558 6.19019C16.1719 6.20063 16.1872 6.21209 16.2026 6.22339C16.2183 6.23483 16.2337 6.24638 16.2485 6.25854C16.4811 6.44916 16.6304 6.73812 16.6304 7.06226C16.6303 7.28368 16.5599 7.48839 16.4419 7.65698L12.8618 13.2449L11.6274 11.3191L13.689 8.10132H12.9956C12.4218 8.10112 11.9567 7.63606 11.9565 7.06226C11.9565 6.48835 12.4218 6.02242 12.9956 6.02222H15.5903C15.5997 6.02222 15.6094 6.02295 15.6187 6.02319Z" fill="white"/>
                                        <path d="M27.2771 15.5H25.5055L28.7311 6.33751H30.7802L34.0103 15.5H32.2387L29.7914 8.21654H29.7199L27.2771 15.5ZM27.3353 11.9075H32.1671V13.2407H27.3353V11.9075ZM37.4865 15.6208C36.9467 15.6208 36.4635 15.4821 36.037 15.2047C35.6105 14.9273 35.2734 14.5247 35.0259 13.9968C34.7783 13.4689 34.6545 12.8276 34.6545 12.073C34.6545 11.3095 34.7798 10.6652 35.0303 10.1403C35.2839 9.61238 35.6254 9.21421 36.0549 8.94578C36.4844 8.67436 36.9631 8.53865 37.491 8.53865C37.8936 8.53865 38.2247 8.60725 38.4842 8.74445C38.7437 8.87867 38.9495 9.04122 39.1016 9.2321C39.2537 9.42001 39.3715 9.59747 39.455 9.7645H39.5221V6.33751H41.1461V15.5H39.5534V14.4173H39.455C39.3715 14.5843 39.2507 14.7618 39.0926 14.9497C38.9345 15.1346 38.7258 15.2927 38.4663 15.4239C38.2068 15.5552 37.8802 15.6208 37.4865 15.6208ZM37.9384 14.2921C38.2814 14.2921 38.5737 14.1996 38.8152 14.0147C39.0568 13.8268 39.2403 13.5658 39.3655 13.2317C39.4908 12.8977 39.5534 12.5085 39.5534 12.0641C39.5534 11.6197 39.4908 11.2334 39.3655 10.9053C39.2432 10.5772 39.0613 10.3222 38.8197 10.1403C38.5811 9.95836 38.2873 9.86739 37.9384 9.86739C37.5775 9.86739 37.2762 9.96135 37.0346 10.1492C36.7931 10.3372 36.6111 10.5966 36.4888 10.9277C36.3665 11.2588 36.3054 11.6376 36.3054 12.0641C36.3054 12.4936 36.3665 12.8768 36.4888 13.2139C36.6141 13.5479 36.7975 13.8119 37.0391 14.0057C37.2837 14.1966 37.5834 14.2921 37.9384 14.2921ZM49.0101 8.62813L46.5629 15.5H44.7733L42.3261 8.62813H44.053L45.6323 13.7328H45.7039L47.2876 8.62813H49.0101ZM50.1308 15.5V8.62813H51.7503V15.5H50.1308ZM50.945 7.65283C50.6885 7.65283 50.4678 7.56782 50.2829 7.39782C50.098 7.22483 50.0055 7.01754 50.0055 6.77595C50.0055 6.53138 50.098 6.32409 50.2829 6.15408C50.4678 5.98109 50.6885 5.8946 50.945 5.8946C51.2045 5.8946 51.4252 5.98109 51.6072 6.15408C51.7921 6.32409 51.8845 6.53138 51.8845 6.77595C51.8845 7.01754 51.7921 7.22483 51.6072 7.39782C51.4252 7.56782 51.2045 7.65283 50.945 7.65283ZM58.847 10.4445L57.3706 10.6056C57.3289 10.4565 57.2558 10.3163 57.1514 10.185C57.05 10.0538 56.9128 9.94792 56.7398 9.86739C56.5668 9.78686 56.3551 9.7466 56.1045 9.7466C55.7675 9.7466 55.4841 9.81967 55.2545 9.96582C55.0278 10.112 54.916 10.3014 54.9189 10.534C54.916 10.7338 54.989 10.8964 55.1382 11.0217C55.2903 11.1469 55.5408 11.2498 55.8898 11.3304L57.0619 11.5809C57.7121 11.7211 58.1953 11.9433 58.5115 12.2475C58.8306 12.5517 58.9917 12.9499 58.9946 13.442C58.9917 13.8745 58.8649 14.2563 58.6144 14.5873C58.3668 14.9154 58.0223 15.1719 57.5809 15.3568C57.1395 15.5418 56.6324 15.6342 56.0598 15.6342C55.2187 15.6342 54.5417 15.4582 54.0286 15.1063C53.5156 14.7514 53.2099 14.2578 53.1115 13.6254L54.6908 13.4733C54.7624 13.7835 54.9145 14.0177 55.1471 14.1757C55.3798 14.3338 55.6825 14.4128 56.0553 14.4128C56.4401 14.4128 56.7488 14.3338 56.9814 14.1757C57.217 14.0177 57.3348 13.8223 57.3348 13.5897C57.3348 13.3928 57.2588 13.2303 57.1067 13.102C56.9575 12.9738 56.7249 12.8753 56.4087 12.8067L55.2366 12.5607C54.5774 12.4235 54.0898 12.1923 53.7736 11.8672C53.4575 11.5391 53.3009 11.1246 53.3039 10.6235C53.3009 10.2 53.4157 9.83309 53.6484 9.52291C53.884 9.20974 54.2106 8.96815 54.6281 8.79814C55.0487 8.62515 55.5334 8.53865 56.0822 8.53865C56.8875 8.53865 57.5213 8.71015 57.9836 9.05315C58.4488 9.39615 58.7367 9.85994 58.847 10.4445ZM63.3276 15.6342C62.6565 15.6342 62.0749 15.4866 61.5828 15.1913C61.0907 14.896 60.7089 14.4829 60.4375 13.952C60.169 13.4211 60.0348 12.8008 60.0348 12.0909C60.0348 11.3811 60.169 10.7592 60.4375 10.2253C60.7089 9.69142 61.0907 9.27684 61.5828 8.98157C62.0749 8.68629 62.6565 8.53865 63.3276 8.53865C63.9987 8.53865 64.5803 8.68629 65.0724 8.98157C65.5645 9.27684 65.9448 9.69142 66.2132 10.2253C66.4847 10.7592 66.6204 11.3811 66.6204 12.0909C66.6204 12.8008 66.4847 13.4211 66.2132 13.952C65.9448 14.4829 65.5645 14.896 65.0724 15.1913C64.5803 15.4866 63.9987 15.6342 63.3276 15.6342ZM63.3365 14.3368C63.7004 14.3368 64.0046 14.2369 64.2492 14.037C64.4938 13.8342 64.6757 13.5628 64.795 13.2228C64.9173 12.8828 64.9785 12.504 64.9785 12.0864C64.9785 11.6659 64.9173 11.2856 64.795 10.9456C64.6757 10.6026 64.4938 10.3297 64.2492 10.1269C64.0046 9.92406 63.7004 9.82266 63.3365 9.82266C62.9637 9.82266 62.6535 9.92406 62.406 10.1269C62.1614 10.3297 61.978 10.6026 61.8557 10.9456C61.7364 11.2856 61.6767 11.6659 61.6767 12.0864C61.6767 12.504 61.7364 12.8828 61.8557 13.2228C61.978 13.5628 62.1614 13.8342 62.406 14.037C62.6535 14.2369 62.9637 14.3368 63.3365 14.3368ZM67.995 15.5V8.62813H69.5653V9.77344H69.6369C69.7621 9.37676 69.9769 9.07105 70.2811 8.8563C70.5883 8.63857 70.9388 8.52971 71.3325 8.52971C71.4219 8.52971 71.5219 8.53418 71.6322 8.54313C71.7456 8.54909 71.8395 8.55953 71.9141 8.57445V10.0642C71.8455 10.0404 71.7366 10.0195 71.5875 10.0016C71.4413 9.98073 71.2997 9.97029 71.1625 9.97029C70.8672 9.97029 70.6017 10.0344 70.3661 10.1627C70.1335 10.2879 69.95 10.4624 69.8158 10.6861C69.6816 10.9098 69.6145 11.1678 69.6145 11.4601V15.5H67.995ZM74.2058 18.077C73.9851 18.077 73.7808 18.0591 73.5929 18.0233C73.408 17.9905 73.2603 17.9517 73.15 17.9069L73.5258 16.6453C73.7614 16.7139 73.9717 16.7467 74.1566 16.7437C74.3415 16.7408 74.5041 16.6826 74.6443 16.5693C74.7874 16.4589 74.9082 16.274 75.0066 16.0145L75.1453 15.6432L72.6534 8.62813H74.3713L75.9551 13.8178H76.0267L77.6149 8.62813H79.3373L76.5859 16.3321C76.4577 16.696 76.2877 17.0077 76.0759 17.2672C75.8641 17.5296 75.6046 17.7295 75.2974 17.8667C74.9932 18.0069 74.6293 18.077 74.2058 18.077Z" fill="#002852"/>
                                    </svg>
                                </span>
                            </div>
                            <h3>Smart Investing Made Effortless</h3>
                            <ul>
                                <li>Each Portfolio is constructed by Vested’s in-house research team</li>
                                <li>Get instant one-click exposure to themes and sectors - no need to pick and track individual stocks or ETFs</li>
                                <li>Minimum investments starting $1. Simple AUM-based pricing</li>
                            </ul>
                            <div class="benefits_service_footer">
                                <a href="<?php echo home_url('/in/managed-portfolios/'); ?>" class="btn btn-primary">Explore Managed Portfolios</a>
                                <p class="desktop_disclosure">Offered by Vested Finance, Inc</p>
                            </div>
                        </div>
                        <div class="benefits_service_image">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-home/home-service-2.png" alt="Managed Portfolios">
                            <p class="mobile_disclosure">Offered by Vested Finance, Inc</p>
                        </div>
                    </div>
                    <div class="benefits_service_item card">
                        <div class="benefits_service_content">
                            <div class="benefits_service_labels">
                                <span>Private Markets</span>
                                <span class="active">Private Beta</span>
                            </div>
                            <h3>Get Early Access to Tomorrow’s Giants</h3>
                            <ul>
                                <li>Invest before the IPO buzz. Access companies still in their growth phase-before they get listed</li>
                                <li>Curated and vetted opportunities such as Open AI, SpaceX, Stripe and more</li>
                                <li>Limited-time deals with minimum investments starting at $10,000</li>
                            </ul>
                            <div class="benefits_service_footer">
                                <a href="https://lp.vestedfinance.com/pre-ipo-1/" target="_blank" rel="noopener noreferrer" class="btn btn-primary">Explore Pre-IPOs</a>
                                <p class="desktop_disclosure">Offered by Vested Finance, Inc</p>
                            </div>
                        </div>
                        <div class="benefits_service_image">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-home/home-service-3.png" alt="Pre-IPO">
                            <p class="mobile_disclosure">Offered by Vested Finance, Inc</p>
                        </div>
                    </div>
                    <div class="benefits_service_item card">
                        <div class="benefits_service_content">
                            <div class="benefits_service_labels">
                                <span>Global Mutual Funds</span>
                                <span class="active">Waitlist</span>
                            </div>
                            <h3>Invest Globally with the World’s Top Fund Managers</h3>
                            <ul>
                                <li>Invest in 50+ countries with Global Mutual Funds managed by global asset managers</li>
                                <li>Avoid U.S. inheritance tax, which applies to non-US residents directly holding more than $60,000 in US assets</li>
                                <li>No entry/exit load + Simplified taxes. Start investing with $1</li>
                            </ul>
                            <div class="benefits_service_footer">
                                <a href="<?php echo home_url('/in/global-mutual-funds/'); ?>" class="btn btn-primary">Join Waitlist</a>
                                <p class="desktop_disclosure">Offered by VF Securities, Inc</p>
                            </div>
                        </div>
                        <div class="benefits_service_image">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-home/home-service-4.png" alt="Global Mutual Funds">
                            <p class="mobile_disclosure">Offered by VF Securities, Inc</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="benefits_steps">
        <div class="container">
            <div class="benefits_steps_wrapper">
                <h2>Take your portfolio global in 3 simple steps</h2>
                <div class="benefits_steps_list">
                    <div class="step_item">
                        <div class="step_content">
                            <h3>Create your Vested Account</h3>
                            <p>Sign up and complete your 100% Digital KYC in less than 5 minutes</p>
                        </div>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-home/home-step-1.png" alt="Step 1">
                    </div>
                    <div class="step_item">
                        <div class="step_content">
                            <h3>Add Funds</h3>
                            <p>Easily transfer funds via ESOP/RSUs, partner banks like HDFC Bank, Axis Bank or any Indian bank with guided instructions</p>
                        </div>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-home/home-step-2.png" alt="Step 2">
                    </div>
                    <div class="step_item">
                        <div class="step_content">
                            <h3>Start Investing!</h3>
                            <p>Build your global portfolio with US Stocks, ETFs or Managed Portfolios starting at $1</p>
                        </div>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-home/home-step-3.png" alt="Step 3">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if (have_rows('investors_reviews', 'option')) : ?>
    <section class="benefits_investors_slider_section">
        <div class="container">
            <div class="benefits_investors_slider_wrapper">
                <h2>Why Investors Choose Vested</h2>
                <p>Read about experiences of those who have taken their portfolio global</p>
                <div class="benefits_investors_slider">
                    <?php while (have_rows('investors_reviews', 'option')) : the_row(); ?>
                    <div class="benefits_investors_slide">
                        <div class="benefits_investors_slide_details">
                            <div class="benefits_investors_slide_details_info">
                                <div class="benefits_investors_slide_details_info_img">
                                    <img src="<?php the_sub_field('investor_image'); ?>" alt="<?php the_sub_field('investor_name'); ?>">
                                </div>
                                <div class="benefits_investors_slide_details_info_content">
                                    <h3><?php the_sub_field('investor_name'); ?></h3>
                                    <p><?php the_sub_field('investor_designation'); ?></p>
                                </div>
                            </div>
                            <div class="benefits_investors_slide_details_review">
                                <?php the_sub_field('investor_review'); ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <div class="benefits_investors_slider_controls">
                    <button class="benefits_investor_prev">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="-0.85" y="0.85" width="46.3" height="46.3" rx="23.15" transform="matrix(-1 0 0 1 46.3 0)" stroke="#8E9DAD" stroke-width="1.7"/>
                            <path d="M28 15L18.7774 24.2226L28 33.4452" stroke="#8E9DAD" stroke-width="1.7"/>
                        </svg>
                    </button>
                    <button class="benefits_investor_next">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.85" y="0.85" width="46.3" height="46.3" rx="23.15" stroke="#8E9DAD" stroke-width="1.7"/>
                            <path d="M19 15L28.2226 24.2226L19 33.4452" stroke="#8E9DAD" stroke-width="1.7"/>
                        </svg>
                    </button>
                </div>
                <div class="benefits_investors_disclosure">
                    These customers were not paid for their testimonials and may not be representative of the experience of other customers. These testimonials are no guarantee of future performance or success.
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="benefits_peers">
        <div class="container">
            <div class="benefits_peers_wrapper">
                <h2>Your Peers Already Have Access</h2>
                <p>We've launched exclusive benefits for leading US-listed companies to bring exclusive ESOP/RSU features to their teams. Because top talent deserves top tools.</p>
                <div class="benefits_peers_list">
                    <div class="benefits_peers_item">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/exclusive-benefits/peers/peers1.svg" alt="Peers 1">
                    </div>
                    <div class="benefits_peers_item">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/exclusive-benefits/peers/peers2.svg" alt="Peers 2">
                    </div>
                    <div class="benefits_peers_item">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/exclusive-benefits/peers/peers3.svg" alt="Peers 3">
                    </div>
                    <div class="benefits_peers_item">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/exclusive-benefits/peers/peers4.svg" alt="Peers 4">
                    </div>
                    <div class="benefits_peers_item">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/exclusive-benefits/peers/peers5.svg" alt="Peers 5">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="invest_overlay" id="investPopoverOverlay">
        <div class="invest_popover" id="investPopoverBox">
            <h2>How do you want to get started?</h2>
            <p class="subtitle">Let's help you access exclusive benefits for <?php the_field('benefits_name'); ?> India.</p>

            <div class="invest_options">
                <div class="invest_option" data-value="new" onclick="selectOption(this)">
                    <div class="invest_option_content">
                        <span class="invest_option_title">I'm new to Vested</span>
                        <span class="invest_option_desc">Sign up and build your global portfolio.</span>
                    </div>
                    <span class="invest_option_checkmark">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 6L9 17L4 12" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </div>
                <!-- disabled -->
                <div class="invest_option" data-value="existing" onclick="selectOption(this)">
                    <div class="invest_option_content">
                        <span class="invest_option_title">I'm already a Vested user</span>
                        <span class="invest_option_desc">Unlock special benefits for your account.</span>
                    </div>
                    <span class="invest_option_checkmark">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 6L9 17L4 12" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="invest_popover_actions">
                <button class="btn cancel" onclick="closePopover()">Cancel</button>
                <button class="btn continue" onclick="handleSubmit()">Continue</button>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>