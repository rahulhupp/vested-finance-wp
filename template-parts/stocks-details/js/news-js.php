<?php
    if (function_exists('get_partner_tokens_from_database')) {
        $token = get_partner_tokens_from_database();
    } else {
        $token = us_stocks_get_token();
    }
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
		setTimeout(() => {
			callNewsApi();
		}, 1000);
	});

    let currentIndex = 0;
    const itemsPerLoad = 3;

    function callNewsApi() {
        var csrf = localStorage.getItem('csrf');
        var jwToken = localStorage.getItem('jwToken');
        const ratiosApiUrl = `https://vested-woodpecker-prod.vestedfinance.com/instrument/<?php echo $symbol; ?>/news`;
        headers = {
            'x-csrf-token': csrf,
            'Authorization': `Bearer ${jwToken}`
        }
        fetch(ratiosApiUrl, { method: 'GET',  headers: headers })
        .then(response => response.json())
        .then(data => {
            var newsSkeleton = document.getElementById('news_skeleton');
            newsSkeleton.style.display = 'none';
            bindNewsData(data);
        })
        .catch(error => console.error('Error:', error));
    }

    function bindNewsData(data) {
        const newsContainer = document.getElementById('news_content');

        // Check if the "news_list" div already exists
            let newsListDiv = document.querySelector('.news_list');

        // If not, create a new one
        if (!newsListDiv) {
            newsListDiv = document.createElement('div');
            newsListDiv.classList.add('news_list');
            newsContainer.appendChild(newsListDiv);
        }

        data.data.slice(currentIndex, currentIndex + itemsPerLoad).forEach(newsItem => {
            // Create a new div element for each news item
            const newsDiv = document.createElement('div');
            newsDiv.classList.add('news_item');

            // Create HTML structure for the news item
            newsDiv.innerHTML = `
                <div class="news_item_image">
                    <a href="${newsItem.url}" rel="nofollow">
                        <img src="${newsItem.image}" alt="">
                    </a>
                </div>
                <div class="news_item_content">
                    <h2>
                        <a href="${newsItem.url}" rel="nofollow">
                            ${newsItem.headline}
                        </a>
                    </h2>
                    <p>${newsItem.summary}</p>
                    <div class="news_item_info">
                        <span>${formatDatetime(newsItem.datetime)}</span>
                        <span>${newsItem.source}</span>
                    </div>
                </div>
            `;

            // Append the news item to the news content container
            newsListDiv.appendChild(newsDiv);
        });

        currentIndex += itemsPerLoad;

       const loadMoreBtn = document.getElementById('load_more_btn');

        // If there is no more data, hide the "Load More" button
        if (currentIndex >= data.data.length) {
            if (loadMoreBtn) {
                loadMoreBtn.style.display = 'none';
            }
        } else {
            // If the button is hidden, show it
            if (loadMoreBtn) {
                loadMoreBtn.style.display = 'block';
            } else {
                // If the button doesn't exist, create and append it
                const newLoadMoreBtn = document.createElement('button');
                newLoadMoreBtn.id = 'load_more_btn';
                newLoadMoreBtn.innerText = 'More';
                newLoadMoreBtn.addEventListener('click', loadMoreItems);
                newsContainer.appendChild(newLoadMoreBtn);
            }
        }
    }

    function loadMoreItems() {
            callNewsApi();  // Assuming you want to load more data from the API
    }

    function formatDatetime(timestamp) {
        const date = new Date(timestamp);
        
        const day = date.getDate();
        const month = new Intl.DateTimeFormat('en-US', { month: 'short' }).format(date);
        const year = date.getFullYear();
        
        const hour = date.getHours();
        const minute = date.getMinutes();
        const ampm = hour >= 12 ? 'pm' : 'am';

        const formattedDate = `${day} ${month}, ${year} at ${formatHour(hour)}:${formatMinute(minute)} ${ampm}`;
        
        return formattedDate;
    }

    function formatHour(hour) {
        return hour % 12 === 0 ? 12 : hour % 12;
    }

    function formatMinute(minute) {
        return minute < 10 ? `0${minute}` : minute;
    }
</script>