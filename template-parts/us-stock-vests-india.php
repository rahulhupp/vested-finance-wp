<section class="build-foundation">
    <div class="container">
        <div class="explore_vest_head">
            <h2>Build a solid foundation with Vests</h2>
            <p class="explore_vest_desc">Vests are expert-built investment baskets built with a specific purpose. Each basket contains curated US Stocks and ETFs, built to target specific goals.</p>

            <div class="explore_vest_about_content">
                <p class="vest_about_content">
                    If you want to invest but don't have the time to research individual stocks, Vests offer a solution. They come in various categories, each focusing on a different investment objective. For instance, a Vest might aim for growth potential while another prioritizes stability. Vests can also cater to specific interests. Let's say you're passionate about renewable energy. You could choose a Vest that concentrates on companies in that sector. Explore <a href="https://vestedfinance.com/in/managed-portfolios/" target="_blank">Vests</a> here.
                </p>
                <div id="vest_read_more">Read <span>More</span> <i class="fa fa-chevron-down"></i></div>
            </div>
        </div>
        <div class="foundation-list">
            <div class="skeleton_main">
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
            <div class="vests_list_conatiner">
                <ul id="vestsResultsList"></ul>
                <div class="defult_vest">
                    <a href="https://app.vestedfinance.com/diy-vests" target="_blank" class="inner">
                        <div class="plus-icon">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/plus-icon.webp" alt="plus-icon" />
                        </div>
                        <div class="content">
                            <strong>Create Your Own </strong>
                            <p>Create a DIY Vest with stocks of your choice. Invest immediately or save it for later.</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="btn">
                <a class="btn_dark" href="https://vestedfinance.com/in/managed-portfolios/" target="_blank">Explore All Vests</a>
            </div>
        </div>
        <!-- <div class="bottom-content">
            <p>Disclosure: Vests are powered by Vested Finance, Inc. an SEC registered Investment Advisor.</p>
        </div> -->
</section>
<script>
    console.log('include vests');
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            callVestsTokenApi();
        }, 2000); // 2000 milliseconds (2 seconds) delay
    });

    function callVestsTokenApi() {
        const firstApiUrl = 'https://vested-api-prod.vestedfinance.com/get-partner-token'; // Replace with the actual URL of the first API
        const headers = {
            'partner-id': '7bcc5a97-3a00-45f0-bb7d-2df254a467c4',
            'partner-key': '4b766258-6495-40ed-8fa0-83182eda63c9',
            'vest-list-access': true,
        };
        fetch(firstApiUrl, {
                method: 'GET',
                headers: headers
            })
            .then(response => response.text())
            .then(token => {
                callVestsApi(token);
            })
            .catch(error => console.error('Error:', error));
    }

    function callVestsApi(token) {
        const vestsApiUrl = 'https://vested-api-prod.vestedfinance.com/v1/partner/vests-list';

        const headers = {
            'partner-authentication-token': token,
            'partner-key': '4b766258-6495-40ed-8fa0-83182eda63c9',
        };

        fetch(vestsApiUrl, {
                method: 'GET',
                headers: headers
            })
            .then(response => response.json())
            .then(data => {
                getVestsList(data.vests);
            })
            .catch(error => console.error('Error:', error));
    }


    function getVestsList(vests) {
        function getRiskText(risk) {
            if (risk >= 0 && risk <= 2) {
                return "Conservative";
            } else if (risk == 3) {
                return "Moderate";
            } else {
                return "Aggressive";
            }
        }

        var vestsResultsList = document.getElementById("vestsResultsList");
        var vestsListContainer = document.getElementsByClassName("vests_list_conatiner")[0]
        var skeletonMainElement = document.getElementsByClassName('skeleton_main')[0];
        vestsListContainer.style.display = "flex";
        skeletonMainElement.style.display = "none";
        localStorage.setItem("vests", true);

        // Convert the "vests" object into an array of vests
        const vestsArray = Object.values(vests);

        // Sort the vests based on their oneYearReturn in descending order
        vestsArray.sort((a, b) => {
            if (a.oneYearReturn === "NaN%") {
                return 1; // Move vests with "NaN%" to the end
            } else if (b.oneYearReturn === "NaN%") {
                return -1; // Move vests with "NaN%" to the end
            } else {
                return parseFloat(b.oneYearReturn) - parseFloat(a.oneYearReturn);
            }
        });

        // Display only the top 3 vests with the highest oneYearReturn
        for (let i = 0; i < vestsArray.length; i++) {
            const vest = vestsArray[i];
            const li = document.createElement("li");

            li.innerHTML = `
                <a href="https://app.vestedfinance.com/vest-details?vestId=${vest.vestId}" target="_blank" class="inner">
                    <div class="top">
                        <div class="vest_img">
                            <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/${vest.vestId}.svg" alt="solid-foundations" />
                        </div>
                        <strong>${vest.name}</strong>
                    </div>
                    <div class="middle">
                        <div class="left">
                            <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest-risk/grey/${vest.risk}.svg" alt="progress bar"  />
                            <strong>${getRiskText(vest.risk)}</strong>
                        </div>
                        <div class="right">
                            <div class="per-value">
                                <svg xmlns="http://www.w3.org/2000/svg" width="6" height="5" viewBox="0 0 6 5" fill="none">
                                    <path d="M3 0L5.59808 4.5H0.401924L3 0Z" fill="#0CC786"  alt="green-up"/>
                                </svg>
                                <span class="green">${vest.oneYearReturn}</span>
                            </div>
                            <span class="past-year">Past Year</span>
                        </div>
                    </div>
                    <div class="bottom">
                        <span>Recommended for</span>
                        <p>${vest.shortBlurb || vest.blurb}</p>
                    </div>
                </a>
            `;

            // vestsResultsList.insertBefore(li, vestsResultsList.querySelector(".box"));
            vestsResultsList.appendChild(li);
        }

        // const defaultBox = document.createElement("li");
        // defaultBox.className = "box";
        // defaultBox.innerHTML = `
        //     `;

        // vestsResultsList.appendChild(defaultBox);

        const buildFoundationImages = document.querySelectorAll("img");
        buildFoundationImages.forEach((img) => {
            const setDimensions = () => {
            if (!img.hasAttribute("width") && !img.hasAttribute("height")) {
                const naturalWidth = img.naturalWidth;
                const naturalHeight = img.naturalHeight;
                if (naturalWidth && naturalHeight) {
                img.setAttribute("width", naturalWidth);
                img.setAttribute("height", naturalHeight);
                }
            }
            };
            if (img.complete) {
            setDimensions();
            } else {
            img.addEventListener("load", setDimensions);
            }
            if (!img.hasAttribute("alt") || img.getAttribute("alt").trim() === "") {
            const src = img.getAttribute("src");
            if (src) {
                const filename = src.split("/").pop().split(".")[0];
                img.setAttribute("alt", filename.replace(/[-_]/g, " "));
            }
            }
        });
    }
</script>