<?php
    $bond = $args['bond'];
    if ($bond) {
        ?>
            <div id="rating_tab" class="tab_content">
                <div class="stock_details_box ratings_box">
                    <div class="stock_chart_header align_center">
                        <h2 class="heading">Ratings</h2>      
                        <?php
                            $date = new DateTime($bond->ratingDate);
                            $ratingDate = $date->format('d M \'y');
                        ?>
                        <p>Rated on <?php echo $ratingDate; ?> by <?php echo $bond->ratingAgency; ?></p>
                    </div>
                    <div class="separator_line"></div>
                    <div class="ratings_wrap">
                        <?php
                            $validRatings = ['a', 'a+', 'a-', 'aa', 'aa+', 'aa-', 'aaa', 'bb', 'bbb', 'bbb+', 'bbb-'];
                            $rating = strtolower($bond->rating);
                            $imageFile = in_array($rating, $validRatings) ? "ratings-{$rating}.png" : "ratings-aa.png";
                            echo '<img src="' . get_stylesheet_directory_uri() . '/assets/images/ratings/' . $imageFile . '" alt="">';
                        ?>
                    </div>
                    <div class="separator_line"></div>
                    <div class="learn_more_btn">
                        <a href="<?php echo $bond->ratingRationalUrl; ?>" target="_blank">Learn more about the rating <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        <?php
    }
?>