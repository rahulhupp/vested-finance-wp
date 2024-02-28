<script>
    var visibleCount = 3;
    var increment = 3;
    var items = document.querySelectorAll('.news_list .news_item');
    var loadMoreBtn = document.getElementById('load_more_btn');

    function loadMore() {
        for (var i = visibleCount; i < visibleCount + increment && i < items.length; i++) {
            items[i].style.display = 'flex';
        }
        visibleCount += increment;
        if (visibleCount >= items.length) {
            loadMoreBtn.style.display = 'none';
        }
    }

    loadMoreBtn.addEventListener('click', loadMore);
</script>