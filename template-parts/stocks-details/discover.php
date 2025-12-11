<?php $get_path = $args['get_path']; ?>
<div id="discover_tab" class="tab_content">
    <div class="stock_details_box">
        <h2 class="heading">Discover more</h2>
        <div class="separator_line"></div>
        <?php
            if ($get_path[2] == 'etf') {
                ?>
                    <div class="explore_stocks">
                        <div class="box_warrp" data-symbol="spy">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/etf/spy/sp-500-etf-trust-spdr-share-price/">
                                <div class="stocks_img">
                                    <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/SPY.png" alt="spy-img" />
                                </div>
                                <div class="stocks_details">
                                    <div class="stock_name">SPDR S&P 500 ETF Trust</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="qqq">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/etf/qqq/invesco-qqq-trust-series-1-share-price/">
                                <div class="stocks_img">
                                    <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/QQQ.png" alt="qqq-img" />
                                </div>
                                <div class="stocks_details">
                                    <div class="stock_name">Invesco QQQ Trust</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="vti">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/etf/vti/us-total-stock-market-index-vanguard-share-price/">
                                <div class="stocks_img">
                                    <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/VTI.png" alt="vti-img" />
                                </div>
                                <div class="stocks_details">
                                    <div class="stock_name">Vanguard Total Stock Market Index Fund ETF Shares</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="iefa">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/etf/iefa/core-msci-eafe-ishares-share-price/">
                                <div class="stocks_img">
                                    <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/IEFA.png" alt="iefa-img" />
                                </div>
                                <div class="stocks_details">
                                    <div class="stock_name">iShares Core MSCI EAFE ETF</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="bnd">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/etf/bnd/us-total-bond-market-index-etf-vanguard-share-price/">
                                <div class="stocks_img">
                                    <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/BND.png" alt="bnd-img" />
                                </div>
                                <div class="stocks_details">
                                    <div class="stock_name">Vanguard Total Bond Market Index Fund ETF Shares</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="ibit">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/etf/ibit/ishares-bitcoin-trust-share-price/">
                                <div class="stocks_img">
                                    <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/IBIT.png" alt="ibit-img" />
                                </div>
                                <div class="stocks_details">
                                    <div class="stock_name">iShares Bitcoin Trust</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="vug">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/etf/vug/growth-etf-vanguard-share-price/">
                                <div class="stocks_img">
                                    <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/VUG.png" alt="vug-img" />
                                </div>
                                <div class="stocks_details">
                                    <div class="stock_name">Vanguard Growth Index Fund ETF Shares</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="gld">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/etf/gld/gold-shares-spdr-share-price/">
                                <div class="stocks_img">
                                    <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/GLD.png" alt="gld-img" />
                                </div>
                                <div class="stocks_details">
                                    <div class="stock_name">SPDR® Gold Shares</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="tlt">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/etf/tlt/20-year-treasury-bond-ishares-share-price/">
                                <div class="stocks_img" id="stock_img">
                                <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/TLT.png" alt="tlt-img" />
                                </div>
                                <div class="stocks_details">
                                    <div class="stock_name">iShares 20+ Year Treasury Bond ETF</div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php
            } else {
                ?>
                    <div class="explore_stocks">
                        <div class="box_warrp" data-symbol="tsal">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/tsla/tesla-inc-share-price">
                                <div class="stocks_img">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/tesla_logo.svg" alt="Tsla">
                                </div>
                                <div class="stocks_details">
                                <div class="stock_name">Tesla, Inc.</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="aapl">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/aapl/apple-inc-share-price">
                                <div class="stocks_img" id="stock_img">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/apple_logo.svg" alt="aaple">
                                </div>
                                <div class="stocks_details">
                                <div class="stock_name">Apple, Inc.</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="googl">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/googl/alphabet-inc-class-a-share-price">
                                <div class="stocks_img">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/google_logo.svg" alt="GOOGL">
                                </div>
                                <div class="stocks_details">
                                <div class="stock_name">Alphabet Inc. - Class A Shares</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="meta">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/meta/meta-platforms-inc-share-price">
                                <div class="stocks_img">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/meta_logo.svg" alt="META">
                                </div>
                                <div class="stocks_details">
                                <div class="stock_name">Meta Platforms Inc</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="amzn">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/amzn/amazoncom-inc-share-price">
                                <div class="stocks_img">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/amazon_logo.svg" alt="AMZN">
                                </div>
                                <div class="stocks_details">
                                <div class="stock_name">Amazon.com Inc.</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="msft">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/msft/microsoft-corporation-share-price">
                                <div class="stocks_img">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/microsoft_logo.svg" alt="Microsoft">
                                </div>
                                <div class="stocks_details">
                                <div class="stock_name">Microsoft Corporation</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="nvda">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/nvda/nvidia-corporation-share-price">
                                <div class="stocks_img">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/navida_logo.svg" alt="NVDA">
                                </div>
                                <div class="stocks_details">
                                <div class="stock_name">NVIDIA Corporation</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="brk.b">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/brk.b/berkshire-hathaway-inc-share-price">
                                <div class="stocks_img brk_stocks_img">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/BRK.B.png"
                                    alt="BRK">
                                </div>
                                <div class="stocks_details">
                                <div class="stock_name">Berkshire Hathaway Inc. Hld B</div>
                                </div>
                            </a>
                        </div>
                        <div class="box_warrp" data-symbol="lly">
                            <a href="<?php echo get_site_url(); ?>/us-stocks/lly/eli-lilly-and-company-share-price">
                                <div class="stocks_img">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/lilly_logo.svg" alt="LLY">
                                </div>
                                <div class="stocks_details">
                                <div class="stock_name">Eli Lilly and Company</div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php
            }
            
        ?>
    </div>
</div>