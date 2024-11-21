(function ($) {
    let userID = 0;

    // Cache user data to minimize redundant AJAX calls
    const cachedUserData = {};

    document.querySelectorAll('.user-link').forEach(
        link =>
        {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                const userId = e.target.dataset.userId;

                // Short circuit if the user ID is unchanged
                if (userId === userID) {
                    return;
                }
                userID = userId;

                // Check if user data is already cached
                if (cachedUserData[userId]) {
                    displayUserData(cachedUserData[userId]);
                    return;
                }

                // Perform AJAX call for new user data
                fetchUserData(userId);
            });
        }
    );

    function fetchUserData(userId)
    {
        $.ajax({
            url: syde_user_listing.ajax_url,
            type: 'POST',
            data: {
                action: 'fetch_user_details',
                user_id: userId,
                _wpnonce: syde_user_listing.nonce,
            },
            beforeSend: () =>
            {
                displayLoadingMessage();
            },
            success: (response) =>
            {
                if (response.success) {
                    cachedUserData[userId] = response.data; // Cache the data
                    displayUserData(response.data);
                } else {
                    console.error(response.data);
                }
            },
            error: (error) =>
            {
                console.error(error.responseJSON);
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
