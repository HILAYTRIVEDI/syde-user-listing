(function ()
{
    let tempDataId = 0;

    const apiEndpoint = document.querySelector('#user-additional-data').dataset.apiUrl;

    document.querySelectorAll('.user-link').forEach(link =>
    {
        link.addEventListener('click', function (e)
        {
            e.preventDefault();

            const dataId = e.target.dataset.id;

            if (tempDataId === dataId)
            {
                return;
            }

            tempDataId = dataId;

            fetchUserData(dataId);
        });
    });

    /**
     * Fetch user data via AJAX
     *
     * @param {string} dataId - The user ID to fetch data for
     */
    function fetchUserData(dataId)
    {
        displayLoadingMessage();

        const postData = new FormData();
        postData.append('action', 'fetch_user_details');
        postData.append('userId', dataId);
        postData.append('_apiEndpoint', apiEndpoint);
        postData.append('_wpnonce', syde_user_listing.nonce);

        fetch(syde_user_listing.ajax_url, {
            method: 'POST',
            body: postData,
        })
            .then(response => response.json())
            .then(data =>
            {
                if (data.success)
                {
                    displayUserData(data.data);
                } else
                {
                    displayError(data.data || 'An error occurred while fetching user details.');
                }
            })
            .catch(error =>
            {
                displayError('Failed to fetch user details.' + error);
            });
    }

    /**
     * Display a loading message in the target element
     */
    function displayLoadingMessage()
    {
        document.getElementById('user-additional-data').innerHTML = '<div class="syde-user-listing-loading-spinner">Fetching....</div>';
    }

    /**
     * Display fetched user data
     *
     * @param {string} data - The HTML content to display
     */
    function displayUserData(data)
    {
        document.getElementById('user-additional-data').innerHTML = data;
    }

    /**
     * Display an error message
     *
     * @param {string} message - The error message to display
     */
    function displayError(message)
    {
        document.getElementById('user-additional-data').innerHTML = `<div class="syde-user-listing-error">${message}</div>`;
    }
})();
