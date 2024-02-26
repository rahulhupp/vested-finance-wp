<?php $news_data = $args['news_data']; ?>

<div id="news_tab" class="tab_content">
    <div class="stock_details_box">
        <h2 class="heading">News</h2>
        <div class="separator_line"></div>
        <div id="news_content">
            <div class="news_list">
                <?php
                    foreach ($news_data as $news) {
                        ?>
                            <div class="news_item">
                                <div class="news_item_image">
                                    <a href="<?php echo $news['url']; ?>" target="_blank" rel="nofollow">
                                        <img src="<?php echo $news['image']; ?>" alt="">
                                    </a>
                                </div>
                                <div class="news_item_content">
                                    <h2>
                                        <a href="<?php echo $news['url']; ?>" target="_blank" rel="nofollow"><?php echo $news['headline']; ?></a>
                                    </h2>
                                    <p><?php echo $news['summary']; ?></p>
                                    <div class="news_item_info">
                                        <span>
                                            <?php 
                                                $timestamp = $news['datetime'] / 1000;
                                                $date = date("j M, Y \a\t g:i a", $timestamp);
                                                echo $date;
                                            ?>
                                        </span>
                                        <span><?php echo $news['source']; ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                ?>
            </div>
            <button id="load_more_btn">More</button>
        </div>
    </div>
</div>