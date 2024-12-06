<?php
/*
Template Name: Test Page
*/

get_header();
?>

<script>
    const apiUrl = 'https://metabase-partners.vestedfinance.com/api/card/100/query';
    const apiKey = 'mb_r6Zpg4+Ekt3SWy1rWgyq+VgQmDQc9feAGK6b70yUIqs=';

    fetch(apiUrl, {
            method: "POST",
            headers: {
                "x-api-key": apiKey,
                "Content-Type": "application/json",
            },
        })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            console.log("API response:", data);
        })
        .catch((error) => {
            console.error("Error making API call:", error);
        });
</script>
<?php
get_footer();
