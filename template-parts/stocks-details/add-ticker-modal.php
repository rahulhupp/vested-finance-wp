<style>
    .at_modal_container {
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

    .at_modal_content {
        max-width: 444px;
        height: 448px;
        width: 100%;
        border-radius: 6px;
        border: 1px solid #CBD5E1;
        background: #FFF;
        padding: 32px;
        position: relative;
        z-index: 1;
    }

    .at_modal_overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #fff;
        opacity: 0.6;
    }

    .at_modal_header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .at_modal_header h2 {
        color: #111827;
        font-size: 18px;
        font-weight: 600;
        line-height: 28px;
    }

    .at_modal_header button {
        padding: 0;
        background-color: transparent;
    }

    .at_stock_search {
        position: relative;
    }

    @media(max-width: 767px) {
        .at_modal_content {
            padding: 40px 15px 15px;
        }
    }
</style>
<div class="at_modal_container" id="at_modal">
    <div class="at_modal_content">
        <div class="at_modal_header">
            <h2>Add ticker to compare</h2>
            <button id="close_at_modal">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/close.png" />
            </button>
        </div>
        <div class="at_stock_search" id="at_stock_search">
            <?php get_template_part('template-parts/stocks-details/stock-search-ticker'); ?>
        </div>
    </div>
    <div class="at_modal_overlay" id="overlay_at_modal"></div>
</div>

<script defer>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('at_modal');
        var closeModalBtn = document.getElementById('close_at_modal');
        var overlay = document.getElementById('overlay_at_modal');

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

    function openModalAddTicker(data) {
        var modal = document.getElementById('at_modal');
        var tickerModalName = document.getElementById('at_stock_search');
        modal.style.display = 'flex';
        tickerModalName.dataset.value = data;
    }

</script>