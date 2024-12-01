document.addEventListener('DOMContentLoaded',(function (){
    const removeCacheButton = document.querySelector('#remove-cache-button');
    const removeCacheUrl = document.querySelector('#remove-cache-url');
    
    removeCacheButton?.addEventListener('click', function (e) {
        e.preventDefault();

        // construct the form data
        const formData = new FormData();
        formData.append('action', 'remove_cache');
        formData.append('_wpnonce', syde_user_listing_admin.nonce);
        formData.append('data', removeCacheUrl.value);

        fetch(syde_user_listing_admin.ajax_url, {
            method: 'POST',
            body: formData,
        }).then(response => {
            if (response.ok) {
                alert('Cache removed successfully.');
            } else {
                alert('Failed to remove cache.');
            }
        })
    });

}));