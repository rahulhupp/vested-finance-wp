<?php
$overview_data = $args['overview_data'];
$price_chart_data = $args['price_chart_data'];
$get_path = $args['get_path'];
if ($overview_data) {
    if (isset($overview_data->price, $overview_data->change, $overview_data->previousClose, $overview_data->changePercent)) {
        $summary = $overview_data->summary;
        $summaryMapping = preprocessSummary($summary);
        $marketCapValue = getValueByLabel($summaryMapping, "Market Cap");
        $expenseRatioValue = getValueByLabel($summaryMapping, "Expense Ratio");
        $peRatio = getValueByLabel($summaryMapping, "P/E Ratio");
        $volumeValue = getValueByLabel($summaryMapping, "Volume");
        $avgVolumeValue = getValueByLabel($summaryMapping, "Avg Volume");
        $betaValue = getValueByLabel($summaryMapping, "Beta");
        $dividendYieldValue = getValueByLabel($summaryMapping, "Dividend Yield");
        $rangeItem = isset($summaryMapping["52-Week Range"]) ? $summaryMapping["52-Week Range"] : null;
        $lowRange = isset($rangeItem['low']) ? $rangeItem['low'] : '';
        $highRange = isset($rangeItem['high']) ? $rangeItem['high'] : '';
        $price = $overview_data->price;
        $isValidValues = false;

        if (strlen($lowRange) === 0) {
            $lowRange = 1;
            $isValidValues = true;
        }
        if (strlen($highRange) === 0) {
            $highRange = 1;
            $isValidValues = true;
        }
        if ($highRange == $lowRange) {
            $rangePercentage = 1;
            $isValidValues = true;
        } else {
            $rangePercentage = (($price - $lowRange) / ($highRange - $lowRange)) * 100;
            $isValidValues = false;
        }

        if (is_infinite($rangePercentage)) {
            $rangePercentage = 1;
        }
        if (strlen($overview_data->name) > 0) {
            $aboutTitle = 'About ' . $overview_data->name . ', ' . $overview_data->type;
        }
        $limitedDescription = substr($overview_data->description, 0, 250); // Assuming 100 characters limit
        $aboutTagsHTML = '';
        foreach ($overview_data->tags as $tag) {
            $aboutTagsHTML .= '<span>' . $tag->label . ': ' . $tag->value . '</span>';
        }
?>
        <div id="overview_tab" class="tab_content">
            <?php if ($price_chart_data) { ?>
                <div class="stock_details_box stock_chart_container">
                    <div class="stock_chart_header">
                        <h2 class="heading">Price Chart</h2>
                        <div class="stock_chart_buttons">
                            <button onclick="callChartApi('1D', '')">1D</button>
                            <button onclick="callChartApi('1W', '')">1W</button>
                            <button onclick="callChartApi('1M', '')">1M</button>
                            <button onclick="callChartApi('6M', 'daily')">6M</button>
                            <button class="active" onclick="callChartApi('1Y', 'daily')">1Y</button>
                            <button onclick="callChartApi('5Y', 'daily')">5Y</button>
                            <button onclick="openACModal('advanced_chart')">Advanced Chart</button>
                        </div>
                    </div>
                    <div class="separator_line"></div>
                    <div class="chart_container">
                        <canvas id="stocksLineChart" width="400" height="200"></canvas>
                        <div id="verticalLine"></div>
                        <div id="customTooltip"></div>
                        <div id="chart_loader_container" class="chart_loader_container">
                            <span class="chart_loader"></span>
                        </div>
                        <div class="svg_skeleton" id="price_chart_skeleton">
                            <svg width="724" height="327" viewBox="0 0 724 327" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1_2)">
                                    <mask id="mask0_1_2" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="724"
                                        height="327">
                                        <path d="M724 0H0V327H724V0Z" fill="white" />
                                    </mask>
                                    <g mask="url(#mask0_1_2)">
                                        <mask id="mask1_1_2" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="724"
                                            height="327">
                                            <path d="M724 0H0V327H724V0Z" fill="white" />
                                        </mask>
                                        <g mask="url(#mask1_1_2)">
                                            <path d="M-2 278H711" stroke="#DDDDDD" stroke-width="2" />
                                            <path
                                                d="M46 226.636L48.0587 221.697C48.0998 221.599 48.1714 221.516 48.263 221.461L51.8697 219.298C52.1313 219.141 52.4711 219.252 52.5884 219.534L54.3596 223.783C54.4372 223.97 54.6193 224.091 54.8211 224.091H58.7317H62.9756H65.0976H69.0082C69.21 224.091 69.392 223.97 69.4697 223.783L71.3352 219.308C71.4128 219.121 71.5949 219 71.7967 219H75.7073H79.9512H81.839C81.9874 219 82.1281 219.066 82.2231 219.18L86.2628 224.026C86.2987 224.069 86.3416 224.106 86.3897 224.134L90.4422 226.565C90.5199 226.612 90.6088 226.636 90.6994 226.636H92.5445C92.6351 226.636 92.724 226.661 92.8017 226.708L96.4307 228.884C96.6922 229.041 97.0321 228.929 97.1494 228.648L98.9855 224.243C99.0266 224.144 99.0982 224.061 99.1898 224.006L102.926 221.766C103.137 221.639 103.409 221.685 103.567 221.874L107.008 226.003C107.249 226.291 107.709 226.222 107.854 225.875L109.595 221.697C109.636 221.599 109.708 221.516 109.8 221.461L113.902 219L118.028 216.526C118.105 216.479 118.194 216.455 118.285 216.455H120.13C120.22 216.455 120.309 216.479 120.387 216.526L124.393 218.929C124.471 218.975 124.56 219 124.651 219H126.496C126.586 219 126.675 218.975 126.753 218.929L130.759 216.526C130.837 216.479 130.926 216.455 131.016 216.455H134.888C135.036 216.455 135.177 216.52 135.272 216.634L137.19 218.935C137.226 218.978 137.268 219.015 137.317 219.044L141.121 221.325C141.332 221.452 141.604 221.406 141.762 221.217L143.46 219.18C143.555 219.066 143.696 219 143.844 219H147.854H151.718C151.942 219 152.139 219.15 152.199 219.366L154.044 226.004C154.132 226.322 154.499 226.469 154.783 226.299L158.096 224.311C158.308 224.184 158.58 224.23 158.738 224.42L162.557 229.002C162.652 229.116 162.793 229.182 162.941 229.182H164.829H168.74C168.942 229.182 169.124 229.303 169.201 229.489L170.973 233.739C171.09 234.02 171.43 234.132 171.691 233.975L175.182 231.882C175.34 231.787 175.538 231.787 175.696 231.882L179.61 234.229C179.658 234.258 179.701 234.295 179.737 234.338L181.531 236.489C181.689 236.679 181.961 236.725 182.172 236.598L186.049 234.273L189.926 231.947C190.137 231.821 190.409 231.867 190.567 232.056L192.265 234.093C192.36 234.207 192.5 234.273 192.649 234.273H196.659H198.642C198.733 234.273 198.822 234.248 198.899 234.202L202.767 231.882C202.926 231.787 203.123 231.787 203.282 231.882L206.901 234.053C207.112 234.179 207.385 234.133 207.542 233.944L209.39 231.727L213.634 226.636L217.494 222.006C217.694 221.766 218.062 221.766 218.262 222.006L219.946 224.026C219.982 224.069 220.025 224.106 220.073 224.134L223.877 226.416C224.088 226.543 224.36 226.497 224.518 226.308L225.982 224.552C226.182 224.312 226.55 224.312 226.75 224.552L230.336 228.853C230.493 229.042 230.766 229.088 230.977 228.962L234.224 227.014C234.526 226.833 234.916 227.013 234.974 227.361L236.69 237.649C236.772 238.144 237.451 238.222 237.644 237.759L241.19 229.252C241.21 229.205 241.236 229.162 241.268 229.124L243.067 226.965C243.225 226.776 243.497 226.73 243.709 226.857L247.328 229.028C247.486 229.123 247.684 229.123 247.843 229.028L251.757 226.68C251.805 226.651 251.848 226.614 251.884 226.571L253.897 224.156C253.933 224.113 253.976 224.076 254.024 224.047L258.076 221.617C258.154 221.57 258.243 221.545 258.334 221.545H262.439H264.561H268.571C268.719 221.545 268.86 221.611 268.955 221.725L270.873 224.026C270.908 224.069 270.951 224.106 270.999 224.134L275.052 226.565C275.13 226.612 275.219 226.636 275.309 226.636H279.415H281.398C281.489 226.636 281.578 226.661 281.655 226.708L285.662 229.111C285.739 229.157 285.828 229.182 285.919 229.182H289.79C289.939 229.182 290.079 229.248 290.174 229.362L291.872 231.398C292.03 231.588 292.302 231.634 292.513 231.507L296.272 229.253C296.349 229.206 296.438 229.182 296.529 229.182H298.374C298.464 229.182 298.553 229.206 298.631 229.253L302.637 231.656C302.715 231.703 302.804 231.727 302.895 231.727H306.766C306.914 231.727 307.055 231.661 307.15 231.547L309.068 229.247C309.104 229.204 309.147 229.167 309.195 229.138L313.293 226.68C313.341 226.651 313.384 226.614 313.42 226.571L317.61 221.545L319.458 219.329C319.615 219.14 319.888 219.093 320.099 219.22L323.804 221.443C323.914 221.509 323.995 221.614 324.029 221.738L325.922 228.549C326.01 228.867 326.377 229.014 326.661 228.844L330.223 226.708C330.3 226.661 330.389 226.636 330.48 226.636H334.351C334.5 226.636 334.64 226.702 334.735 226.816L336.557 229.002C336.652 229.116 336.793 229.182 336.941 229.182H340.951H342.935C343.025 229.182 343.114 229.206 343.192 229.253L347.06 231.573C347.218 231.668 347.416 231.668 347.574 231.573L351.488 229.225C351.536 229.197 351.579 229.16 351.615 229.117L353.533 226.816C353.628 226.702 353.769 226.636 353.917 226.636H357.927H361.937C362.085 226.636 362.226 226.57 362.321 226.457L364.143 224.271C364.238 224.157 364.378 224.091 364.527 224.091H368.302C368.451 224.091 368.592 224.025 368.687 223.911L370.384 221.874C370.542 221.685 370.814 221.639 371.026 221.766L374.784 224.02C374.861 224.066 374.95 224.091 375.041 224.091H378.912C379.061 224.091 379.201 224.025 379.296 223.911L381.208 221.618C381.248 221.57 381.278 221.515 381.298 221.456L385.315 209.409C385.416 209.106 385.772 208.974 386.047 209.139L389.615 211.279C389.707 211.334 389.778 211.417 389.819 211.515L391.561 215.693C391.705 216.04 392.166 216.109 392.406 215.821L395.972 211.543C396.067 211.43 396.208 211.364 396.356 211.364H398.105C398.196 211.364 398.285 211.388 398.363 211.435L402.045 213.643C402.287 213.789 402.602 213.704 402.739 213.457L406.589 206.53C406.677 206.371 406.844 206.273 407.026 206.273H408.854H413.098H417.107C417.256 206.273 417.396 206.339 417.491 206.453L419.313 208.638C419.408 208.752 419.549 208.818 419.698 208.818H423.473C423.622 208.818 423.762 208.884 423.857 208.998L425.555 211.035C425.713 211.224 425.985 211.27 426.196 211.143L429.954 208.889C430.032 208.843 430.121 208.818 430.212 208.818H434.083C434.231 208.818 434.372 208.884 434.467 208.998L436.055 210.903C436.255 211.143 436.623 211.143 436.823 210.903L440.299 206.733C440.499 206.494 440.867 206.494 441.067 206.733L442.655 208.638C442.75 208.752 442.891 208.818 443.039 208.818H446.715C446.917 208.818 447.099 208.94 447.177 209.126L450.975 218.239C451.12 218.585 451.58 218.655 451.821 218.366L453.415 216.455L457.384 211.692C457.542 211.503 457.814 211.457 458.026 211.584L461.203 213.49C461.523 213.682 461.933 213.468 461.959 213.095L463.938 184.605C463.969 184.155 464.533 183.973 464.821 184.319L467.884 187.994C468.084 188.234 468.452 188.234 468.652 187.994L470.39 185.909L474.36 181.147C474.518 180.958 474.79 180.912 475.001 181.038L478.759 183.292C478.837 183.339 478.926 183.364 479.016 183.364H480.766C480.914 183.364 481.055 183.298 481.15 183.184L485.196 178.331C485.228 178.292 485.254 178.249 485.273 178.203L489.459 168.161C489.478 168.114 489.504 168.071 489.536 168.033L491.336 165.874C491.493 165.685 491.766 165.639 491.977 165.766L495.487 167.871C495.698 167.997 495.97 167.951 496.128 167.762L497.592 166.006C497.791 165.766 498.16 165.766 498.36 166.006L501.835 170.176C502.035 170.415 502.404 170.415 502.604 170.176L506.463 165.545L508.201 163.461C508.401 163.221 508.77 163.221 508.969 163.461L512.746 167.99C512.8 168.056 512.837 168.135 512.853 168.22L516.767 189.347C516.857 189.836 517.529 189.907 517.72 189.448L518.734 187.016C518.905 186.606 519.486 186.606 519.657 187.016L523.439 196.091L525.545 201.145C525.556 201.169 525.564 201.195 525.57 201.221L529.399 217.295C529.515 217.784 530.2 217.814 530.359 217.337L534.036 206.31C534.045 206.285 534.051 206.26 534.055 206.234L535.991 194.621C536.062 194.199 536.595 194.054 536.869 194.383L540.415 198.636L542.488 201.124C542.52 201.162 542.546 201.205 542.566 201.252L546.78 211.364L550.379 224.314C550.524 224.837 551.281 224.786 551.356 224.249L553.042 212.112C553.092 211.758 553.487 211.568 553.795 211.753L557.203 213.797C557.322 213.868 557.406 213.987 557.435 214.123L561.305 232.691C561.405 233.173 562.066 233.235 562.256 232.782L563.164 230.601C563.351 230.154 564 230.207 564.112 230.678L567.32 244.146C567.451 244.694 568.246 244.642 568.304 244.082L570.041 227.417C570.079 227.053 570.481 226.852 570.795 227.04L573.803 228.844C574.086 229.014 574.453 228.867 574.542 228.549L578.61 213.909L580.325 203.621C580.415 203.083 581.178 203.057 581.305 203.587L584.457 216.821C584.58 217.341 585.324 217.33 585.433 216.807L588.89 200.218C588.99 199.737 589.652 199.674 589.841 200.127L591.278 203.575C591.319 203.674 591.391 203.757 591.483 203.812L595.089 205.975C595.351 206.132 595.691 206.02 595.808 205.739L597.485 201.716C597.602 201.434 597.942 201.323 598.203 201.479L601.508 203.461C601.75 203.607 602.065 203.523 602.202 203.276L605.694 196.993C605.897 196.628 606.431 196.658 606.592 197.044L608.288 201.112C608.307 201.158 608.333 201.201 608.365 201.24L612.287 205.944C612.445 206.133 612.717 206.179 612.928 206.053L616.732 203.771C616.78 203.742 616.823 203.705 616.859 203.662L618.866 201.254C618.906 201.206 618.937 201.151 618.957 201.092L623.057 188.796C623.125 188.592 623.316 188.455 623.531 188.455H625.059C625.207 188.455 625.348 188.389 625.443 188.275L629.387 183.543C629.482 183.43 629.622 183.364 629.771 183.364H633.325C633.583 183.364 633.799 183.167 633.823 182.91L635.895 160.53C635.9 160.48 635.912 160.431 635.932 160.384L640.124 150.326C640.139 150.291 640.15 150.254 640.156 150.216L642.246 137.679C642.261 137.592 642.298 137.51 642.355 137.441L646.458 132.52C646.494 132.477 646.537 132.44 646.585 132.411L650.615 129.994C650.707 129.939 650.778 129.856 650.819 129.757L652.481 125.771C652.642 125.385 653.177 125.355 653.379 125.72L656.768 131.817C656.938 132.124 657.364 132.164 657.589 131.894L661.366 127.364L663.434 124.883C663.47 124.84 663.512 124.803 663.56 124.775L667.129 122.635C667.424 122.458 667.805 122.624 667.875 122.961L669.838 132.38C669.848 132.429 669.866 132.477 669.891 132.521L673.505 139.025C673.722 139.416 674.304 139.347 674.424 138.916L677.738 126.992C677.881 126.476 678.624 126.516 678.712 127.043L680.457 137.507C680.461 137.533 680.468 137.558 680.476 137.583L684.233 148.85C684.385 149.306 685.03 149.306 685.182 148.85L688.667 138.397C688.791 138.025 689.275 137.934 689.526 138.235L690.606 139.531C690.831 139.801 691.257 139.761 691.427 139.454L695.174 132.712C695.262 132.553 695.43 132.455 695.611 132.455H697.439H701.449C701.597 132.455 701.738 132.389 701.833 132.275L705.399 127.997C705.639 127.709 706.1 127.778 706.244 128.125L707.986 132.303C708.027 132.401 708.098 132.484 708.19 132.539L712.036 134.846C712.194 134.941 712.392 134.941 712.55 134.846L716.396 132.539C716.487 132.484 716.559 132.401 716.6 132.303L718.595 127.515C718.636 127.417 718.708 127.334 718.8 127.279L722.731 124.921C722.841 124.855 722.922 124.749 722.956 124.626L724.996 117.285C725.015 117.217 725.048 117.154 725.093 117.099L728.801 112.651C729.026 112.381 729.452 112.421 729.623 112.728L733.369 119.47C733.457 119.629 733.625 119.727 733.806 119.727H735.34C735.522 119.727 735.689 119.826 735.777 119.984L739.855 127.323C739.87 127.35 739.888 127.376 739.908 127.4L741.616 129.448C741.816 129.688 742.184 129.688 742.384 129.448L746.244 124.818L750.488 119.727L752.46 117.362C752.555 117.248 752.696 117.182 752.844 117.182H756.854H760.764C760.966 117.182 761.148 117.303 761.226 117.489L762.758 121.165C762.929 121.576 763.51 121.576 763.681 121.165L767.463 112.091L769.57 107.037C769.58 107.012 769.588 106.987 769.595 106.961L773.531 90.4339C773.637 89.9901 774.233 89.9081 774.455 90.3068L777.93 96.5611C778.018 96.7198 778.186 96.8182 778.367 96.8182H779.835C780.05 96.8182 780.241 96.9559 780.309 97.16L783.921 107.993C784.077 108.461 784.745 108.444 784.877 107.968L788.683 94.2727L790.677 89.4895C790.754 89.3032 790.936 89.1818 791.138 89.1818H794.715C794.917 89.1818 795.099 89.0605 795.177 88.8742L797.043 84.3985C797.12 84.2123 797.302 84.0909 797.504 84.0909H801.12C801.302 84.0909 801.469 83.9925 801.558 83.8338L805.63 76.5064C805.649 76.472 805.664 76.4354 805.674 76.3974L807.454 69.993C807.574 69.5622 808.156 69.4931 808.373 69.884L811.587 75.6681C811.778 76.011 812.271 76.011 812.461 75.6681L815.542 70.1254C815.775 69.7058 816.408 69.824 816.474 70.2995L818.33 83.6597C818.365 83.9069 818.576 84.0909 818.826 84.0909H822.211C822.455 84.0909 822.664 83.9142 822.704 83.6731L824.756 71.3636L828.959 48.6763C828.985 48.5353 829.07 48.4123 829.193 48.3386L833.03 46.0376C833.165 45.9567 833.254 45.817 833.27 45.6606L835.243 26.7238C835.289 26.2839 835.841 26.1157 836.124 26.4554L838.886 29.7682C839.164 30.1016 839.706 29.9468 839.765 29.5168L841.723 15.4276C841.729 15.3851 841.74 15.3436 841.757 15.304L845.976 5.18182L849.43 -3.10624C849.632 -3.58964 850.346 -3.47731 850.39 -2.95541L852.32 20.1991C852.334 20.3595 852.423 20.5036 852.561 20.5864L856.414 22.8974C856.524 22.9633 856.605 23.0688 856.639 23.1923L860.442 36.8798C860.569 37.3373 861.203 37.3766 861.385 36.9383L862.729 33.7158C862.846 33.4343 863.186 33.3225 863.447 33.4794L866.485 35.3012C866.807 35.4947 867.22 35.2758 867.241 34.9001L869.127 0.972149C869.159 0.396459 869.979 0.323153 870.112 0.884042L873.534 15.2495C873.552 15.3246 873.587 15.3945 873.636 15.4538L877.704 20.3333C877.77 20.4122 877.809 20.5095 877.818 20.6119L879.641 42.4805C879.689 43.0553 880.511 43.1056 880.629 42.541L884.088 25.9434C884.136 25.7116 884.34 25.5455 884.577 25.5455H888.081C888.283 25.5455 888.465 25.6668 888.543 25.8531L890.473 30.4845C890.514 30.5832 890.586 30.666 890.678 30.721L894.073 32.7576C894.395 32.9507 894.807 32.7333 894.83 32.3585L896.774 -0.295609C896.805 -0.824798 897.531 -0.947578 897.734 -0.458256L901.146 7.72727L904.929 16.8018C905.1 17.212 905.681 17.212 905.852 16.8018L907.512 12.8182L911.733 5.22295C911.748 5.19559 911.766 5.16972 911.786 5.14567L916 0.0909178"
                                                stroke="#DDDDDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M656.618 -26.8747H656.295V263.597H656.618V-26.8747Z" stroke="#DDDDDD"
                                                stroke-width="0.322799" stroke-dasharray="3.06 12.24" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M656.133 137.799C661.125 137.799 665.171 133.752 665.171 128.761C665.171 123.769 661.125 119.722 656.133 119.722C651.141 119.722 647.095 123.769 647.095 128.761C647.095 133.752 651.141 137.799 656.133 137.799Z"
                                                fill="#5E5E5E" fill-opacity="0.12" />
                                            <g filter="url(#filter0_d_1_2)">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M656.134 133.925C658.986 133.925 661.298 131.613 661.298 128.761C661.298 125.908 658.986 123.596 656.134 123.596C653.281 123.596 650.969 125.908 650.969 128.761C650.969 131.613 653.281 133.925 656.134 133.925Z"
                                                    fill="#959595" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M656.166 130.589C657.241 130.589 658.112 129.718 658.112 128.643C658.112 127.568 657.241 126.697 656.166 126.697C655.091 126.697 654.219 127.568 654.219 128.643C654.219 129.718 655.091 130.589 656.166 130.589Z"
                                                    fill="white" />
                                            </g>
                                        </g>
                                        <path d="M38 233H8V248H38V233Z" fill="#D9D9D9" />
                                        <path d="M38 156H8V171H38V156Z" fill="#D9D9D9" />
                                        <path d="M38 85H8V100H38V85Z" fill="#D9D9D9" />
                                        <path d="M96 289H66V304H96V289Z" fill="#D9D9D9" />
                                        <path d="M212 289H182V304H212V289Z" fill="#D9D9D9" />
                                        <path d="M328 289H298V304H328V289Z" fill="#D9D9D9" />
                                        <path d="M444 289H414V304H444V289Z" fill="#D9D9D9" />
                                        <path d="M560 289H530V304H560V289Z" fill="#D9D9D9" />
                                        <path d="M676 289H646V304H676V289Z" fill="#D9D9D9" />
                                        <path d="M44.5 1.5V278.5" stroke="#DDDDDD" stroke-width="2" />
                                    </g>
                                </g>
                                <defs>
                                    <filter id="filter0_d_1_2" x="645.779" y="120.352" width="20.7095" height="20.7095"
                                        filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                            result="hardAlpha" />
                                        <feOffset dy="1.94635" />
                                        <feGaussianBlur stdDeviation="2.59513" />
                                        <feColorMatrix type="matrix" values="0 0 0 0 0.439216 0 0 0 0 0.470588 0 0 0 0 0.529412 0 0 0 0.24 0" />
                                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1_2" />
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1_2" result="shape" />
                                    </filter>
                                    <clipPath id="clip0_1_2">
                                        <rect width="724" height="327" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="stock_details_box stock_metrics_container">
                <h2 class="heading">Key Metrics</h2>
                <div class="separator_line"></div>
                <div class="stock_metrics_wrapper">
                    <div class="stock_metrics_keyvalue">
                        <div class="stock_summary">

                            <?php
                            if ($get_path[2] == 'etf') {
                            ?>
                                <div class="stock_summary_item">
                                    <span>
                                        Expense Ratio
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                        <div class="info_text">The expense ratio is how much you pay a mutual fund or ETF per year, expressed as a percent of your investments. It is a measure of the fund's operating costs relative to assets.</div>
                                    </span>
                                    <strong><?php echo $expenseRatioValue ? $expenseRatioValue : "0"; ?></strong>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="stock_summary_item">
                                    <span>
                                        Market Cap
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                        <div class="info_text">This is a company’s total value as determined by the stock market. It is calculated by multiplying the total number of a company's outstanding shares by the current market price of one share.</div>
                                    </span>
                                    <strong><?php echo $marketCapValue ? $marketCapValue : "$0"; ?></strong>
                                </div>
                                <div class="stock_summary_item">
                                    <span>
                                        P/E Ratio
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                        <div class="info_text">This is the ratio of a security’s current share price to its earnings per share. This ratio determines the relative value of a company’s share.</div>
                                    </span>
                                    <strong><?php echo $peRatio ? $peRatio : "0"; ?></strong>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="stock_summary_item">
                                <span>
                                    Volume
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                    <div class="info_text">This is the total number of shares traded during the most recent trading day.</div>
                                </span>
                                <strong><?php echo $volumeValue ? $volumeValue : "0"; ?></strong>
                            </div>
                            <div class="stock_summary_item">
                                <span>
                                    Avg Volume
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                    <div class="info_text">This is the average number of shares traded during the most recent 30 days.</div>
                                </span>
                                <strong><?php echo $avgVolumeValue ? $avgVolumeValue : "0"; ?></strong>
                            </div>
                            <div class="stock_summary_item">
                                <span>
                                    Dividend Yield
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                    <div class="info_text">This ratio shows how much income you earn in dividend payouts per year for every dollar invested in the stock (or the stock’s annual dividend payment expressed as a percentage of its current price).</div>
                                </span>
                                <strong><?php echo $dividendYieldValue ? $dividendYieldValue : "0.00%"; ?></strong>
                            </div>
                            <div class="stock_summary_item">
                                <span>
                                    Beta
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                    <div class="info_text">This measures the expected move in a stock’s price relative to movements in the overall market. The market, such as the S&P 500 Index, has a beta of 1.0. If a stock has a Beta greater (or lower) than 1.0, it suggests that the stock is more (or less) volatile than the broader market.</div>
                                </span>
                                <strong><?php echo $betaValue ? $betaValue : "0"; ?></strong>
                            </div>
                        </div>
                    </div>
                    <?php if (!$isValidValues): ?>
                    <div class="stock_metrics_range <?php if ($isValidValues): echo 'hidden';
                                                    endif; ?>">
                        <h6>
                            <span>52-week Range</span>
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                            <div class="info_text">This shows the range of the stock’s price between the 52-week high (the highest price of the stock for the past 52 weeks) and the 52-week low (the lowest price of the stock for the past 52 weeks).</div>
                        </h6>
                        <div class="range_container">
                            <div class="range_item range_low">
                                <span><?php echo '$' . $lowRange; ?></span>
                                <strong>L</strong>
                            </div>
                            <div class="range_item range_high">
                                <span><?php echo '$' . $highRange; ?></span>
                                <strong>H</strong>
                            </div>
                            <div class="float_range_item">
                                <div class="float_range" style="left: calc(<?php echo $rangePercentage; ?>% - 28px);">
                                    <span><?php echo '$' . $price; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="stock_details_box stock_about_container">
                <h2 class="heading"><?php echo $aboutTitle; ?></h2>
                <div class="separator_line"></div>
                <div class="stock_about_wrapper">
                    <p class="stock_about_description">
                        <span id="stock_about_description"><?php echo $overview_data->description; ?></span>
                        <span id="show_more">more</span>
                    </p>
                </div>
                <div class="stock_tags"><?php echo $aboutTagsHTML; ?></div>
            </div>
        </div>

    <?php
    } else {
    ?>
        <div id="overview_tab" class="tab_content">
            <div class="stock_details_box stock_chart_container">
                <p>Price related data not available</p>
            </div>
        </div>
<?php
    }
} else {
    echo "Error retrieving data"; // Handle error
}
?>