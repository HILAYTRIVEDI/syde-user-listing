(function ($) {

    document.querySelectorAll('.user-link').forEach(function (link)
    {
        link.addEventListener('click', function (e)
        {
            e.preventDefault();
            var userId = e.target.dataset.userId;


            $.ajax({
                url: syde_user_listing.ajax_url,
                type: 'POST',
                data: {
                    action: 'fetch_user_details',
                    user_id: userId,
                    _wpnonce: syde_user_listing.nonce
                },
                success: function (response)
                {
                    if(response.success){
                        document.getElementById('user-additional-data').innerHTML = response.data;
                    } else {
                        console.log(response.data);
                    }
                },
                error: function (error)
                {
                    console.log(error.responseJSON);
                }
            });
        });
    });
})(jQuery);