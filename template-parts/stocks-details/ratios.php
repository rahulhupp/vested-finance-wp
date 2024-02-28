<?php $ratios_data = $args['ratios_data']; ?>

<div id="ratios_tab" class="tab_content">
    <div class="stock_details_box">
        <h2 class="heading">Ratios</h2>
        <div class="separator_line"></div>
        <div id="ratios_content">
            <?php foreach ($ratios_data['ratios'] as $ratios): ?>
                <?php
                    if ($ratios['data']['current']['value']) {
                        ?>
                            <div class="ratios_section">
                                <h2><?php echo $ratios['section']; ?></h2>
                                <p><?php echo $ratios['description']; ?></p>
                                <div class="stock_details_table_container">
                                    <div class="stock_details_table_wrapper">
                                        <div class="stock_details_table ratios_table">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th><?php echo $ratios['data']['current']['label']; ?></th>
                                                        <?php if (isset($ratios['data']['peers'])): ?>
                                                            <th><?php echo $ratios['data']['peers']['label']; ?></th>
                                                        <?php endif; ?>
                                                        <?php if (isset($ratios['data']['reference'])): ?>
                                                            <th><?php echo $ratios['data']['reference']['label']; ?><button onclick="openModalAddTicker('ratios_compare')" class="ticker_button"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/repeat.svg">Ticker</button></th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($ratios['data']['ratios']['value'] as $ratio): ?>
                                                        <tr>
                                                            <td><?php echo $ratio['label'] . (isset($ratio['subtext']) ? ' <span>' . $ratio['subtext'] . '</span>' : ''); ?></td>
                                                            <td><?php echo $ratios['data']['current']['value'][$ratio['key']]['value']; ?></td>
                                                            <?php if (isset($ratios['data']['peers'])): ?>
                                                                <td><?php echo $ratios['data']['peers']['value'][$ratio['key']]['value']; ?></td>
                                                            <?php endif; ?>
                                                            <?php if (isset($ratios['data']['reference'])): ?>
                                                                <td><?php echo $ratios['data']['reference']['value'][$ratio['key']]['value']; ?></td>
                                                            <?php endif; ?>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button class="stock_details_table_button" onclick="openModalAddTicker('ratios_compare')"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/plus-icon.svg" alt="plus-icon" /><span>Add ticker to compare</span></button>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>