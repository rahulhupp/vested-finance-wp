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
                            if($bond->bondCategory != 'GOVT') {
                        ?>
                        <p>Rated on <?php echo $ratingDate; ?> by <?php echo $bond->ratingAgency; ?></p>
                        <?php
                            } else { ?>
                        <p class="govt_highlighted">Highly safe, backed by Gov of India</p>
                            <?php }
                        ?>
                    </div>
                    <div class="separator_line"></div>
                    <div class="ratings_wrap">
                        <?php
                            $validRatings = ['a', 'a+', 'a-', 'aa', 'aa+', 'aa-', 'aaa', 'bb', 'bbb', 'bbb+', 'bbb-'];
                            $rating = strtolower($bond->rating);
                            $imageFile = in_array($rating, $validRatings) ? "ratings-{$rating}.png" : "ratings-aa.png";
                            if($bond->bondCategory === 'GOVT') {
                                echo '<img src="' . get_stylesheet_directory_uri() . '/assets/images/ratings/sovereign-ratings.png" alt="">';    
                            }
                            else {
                                echo '<img src="' . get_stylesheet_directory_uri() . '/assets/images/ratings/' . $imageFile . '" alt="">';
                            }
                        ?>
                    </div>
                    <div class="separator_line"></div>
                    <div class="learn_more_btn">
                        <a href="<?php echo $bond->ratingRationalUrl; ?>" target="_blank" class="pdf_viewer">Learn more about the rating <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        <?php
    }
?>