(function ($) {
    let tempDataId = 0;

    // Cache user data to minimize redundant AJAX calls
    const cachedUserData = {};

    document.querySelectorAll('.user-link').forEach(
        link =>
        {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                const dataId = e.target.dataset.id;

                // Short circuit if the user ID is unchanged
                if (tempDataId === dataId) {
                    return;
                }

                // Check if user data is already cached
                if (cachedUserData[dataId]) {
                    displayUserData(cachedUserData[dataId]);
                    return;
                }

                // Perform AJAX call for new user data
                fetchUserData(dataId);
            });
        }
    );

    function fetchUserData(dataId)
    {
        $.ajax({
            url: syde_user_listing.ajax_url,
            type: 'POST',
            data: {
                action: 'fetch_user_details',
                user_id: dataId,
                _wpnonce: syde_user_listing.nonce,
            },
            beforeSend: () =>
            {
                displayLoadingMessage();
            },
            success: (response) =>
            {
                if (response.success) {
                    cachedUserData[dataId] = response.data; // Cache the data
                    displayUserData(response.data);
                } else {
                    displayUserData(response.data)
                }
            },
            error: (error) =>
            {
                displayUserData(error.responseJSON)
            },
        });
    }

    function displayLoadingMessage()
    {
        document.getElementById('user-additional-data').innerHTML = '<div class="syde-user-listing-loading-spinner">Fetching....</div>';
    }

    function displayUserData(data)
    {
        document.getElementById('user-additional-data').innerHTML = data;
    }
})(jQuery);
