<style>
    .ac_modal_container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        align-items: center;
        justify-content: center;
        z-index: 99;
        padding: 0 10px;
        display: none;
    }

    .ac_modal_content {
        max-width: 539px;
        width: 100%;
        border-radius: 10px;
        background: #002852;
        padding: 32px;
        position: relative;
        z-index: 1;
    }

    .ac_modal_content .close_button {
        position: absolute;
        top: 32px;
        right: 32px;
        padding: 0;
        background-color: transparent;
    }

    .ac_modal_content h2 {
        color: #FFFFFF;
        font-size: 20px;
        font-weight: 600;
        line-height: 30px; /* 150% */
        max-width: 327px;
    }

    .ac_modal_text {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 30px 0;
    }

    .ac_modal_list {
        max-width: 280px;
        margin: 0;
        padding: 0 0 0 17px;
    }

    .ac_modal_list li {
        color: rgba(255, 255, 255, 0.60);
        font-size: 16px;
        font-weight: 500;
        line-height: 22.4px; /* 22.4px */
        margin-bottom: 12px;
    }

    .ac_modal_overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #fff;
        opacity: 0.6;
    }

    .ac_modal_content a {
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.12);
        padding: 18px 0px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #FFFFFF;
        font-size: 20px;
        font-weight: 500;
        line-height: normal;
    }

    .ac_modal_list li:last-child {
        margin-bottom: 0;
    }

    .ac_modal_content a span {
        margin-right: 6px;
        display: block;
    }
    @media(max-width: 767px) {
        .ac_modal_content {
            padding: 40px 15px 15px;
        }

        .ac_modal_content .close_button {
            top: 10px;
            right: 10px;
        }

        .ac_modal_content h2 {
            font-size: 20px !important;
        }

        .ac_modal_text {
            padding: 15px 0;
        }

        .ac_modal_text img {
            max-width: 100px;
        }

        .ac_modal_content a {
            font-size: 16px;
            padding: 16px 0;
        }

        .ac_modal_list li {
            margin-bottom: 10px;
        }
    }
</style>
<div class="ac_modal_container" id="ac_modal">
    <div class="ac_modal_content">
        <button class="close_button" id="close_ac_modal">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/close-icon.svg" />
        </button>
        <h2>Signup to access all features and start your US investing journey!</h2>
        <div class="ac_modal_text">
            <ul class="ac_modal_list">
                <li><a href='#' class='signup_url' id="first_line"></a></li>
                <li>Open your account in minutes</li>
                <li>Take your portfolio global, starting at just $1</li>
            </ul>
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/usd_coin.png" />
        </div>
        <a href="#" class='signup_url'>
            <span>Get started</span>
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/arrow-right.svg" />
        </a>
    </div>
    <div class="ac_modal_overlay" id="overlay_ac_modal"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('ac_modal');
        var closeModalBtn = document.getElementById('close_ac_modal');
        var overlay = document.getElementById('overlay_ac_modal');

        // Close modal on close button click
        closeModalBtn.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        // Close modal on outside click
        window.addEventListener('click', function (event) {
            if (event.target === overlay) {
                modal.style.display = 'none';
            }
        });
    });

    function openACModal(data) {
        console.log('data', data);
        let firstLineElement = document.getElementById("first_line");
        switch (data) {
            case "add_watchlist":
                firstLineElement.textContent = "Create a watchlist and track your favorite stocks";
                break;
            case 'news':
                firstLineElement.textContent = "Stay updated with news events for your favorite stocks";
                break;
            default:
                firstLineElement.textContent = "Access Advanced Charts for 5,000+ US Stocks & ETFs";
        }

        var modal = document.getElementById('ac_modal');
        modal.style.display = 'flex';
    }

</script>