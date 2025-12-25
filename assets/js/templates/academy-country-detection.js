/**
 * Academy Country Detection
 * Detects user country and stores it for content filtering
 */

(function() {
    'use strict';

    function sendCountryToServer(country) {
        // Get AJAX URL from localized script or use default
        var ajaxUrl = (typeof ajaxurl !== 'undefined') ? ajaxurl : '/wp-admin/admin-ajax.php';
        
        var formData = new FormData();
        formData.append('action', 'vested_store_user_country');
        formData.append('country', country);
        formData.append('nonce', (typeof vestedCountryNonce !== 'undefined') ? vestedCountryNonce : '');
        
        fetch(ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            // Country stored on server
        })
        .catch(function(error) {
            // Error storing country on server
        });
    }

    function getUserLocationByIP() {
        // Check if country is already stored in sessionStorage
        var storedCountry = sessionStorage.getItem('user_country');
        if (storedCountry) {
            // Still send to server to ensure PHP session has it
            sendCountryToServer(storedCountry);
            return;
        }
        
        // Make a request to get user location based on IP
        fetch('https://get.geojs.io/v1/ip/country.json')
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.country) {
                    // Store country in sessionStorage
                    sessionStorage.setItem('user_country', data.country);
                    
                    // Send to server to store in session
                    sendCountryToServer(data.country);
                }
            })
            .catch(function(error) {
                // Error getting user location based on IP
            });
    }

    // Run on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', getUserLocationByIP);
    } else {
        getUserLocationByIP();
    }
})();

