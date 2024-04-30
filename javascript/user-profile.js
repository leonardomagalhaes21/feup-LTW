document.addEventListener("DOMContentLoaded", function() {
    function loadContent(url, containerId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    document.getElementById(containerId).innerHTML = xhr.responseText;
                } else {
                    console.error(xhr.statusText);
                }
            }
        };
        xhr.send();
    }

    document.getElementById('user-details').addEventListener('click', function(e) {
        e.preventDefault(); 
        document.getElementById('admin-content-container').innerHTML = '';
        loadContent('profile_user_details.php', 'content-container'); 
    });

    document.getElementById('wishlist').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('admin-content-container').innerHTML = '';
        loadContent('wishlist.php', 'content-container');
    });

    document.getElementById('your-items').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('admin-content-container').innerHTML = '';
        loadContent('profile_your_items.php', 'content-container');
    });

    document.getElementById('your-orders').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('admin-content-container').innerHTML = '';
        loadContent('profile_your_orders.php', 'content-container');
    });

    document.getElementById('orders-to-ship').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('admin-content-container').innerHTML = '';
        loadContent('profile_orders_to_ship.php', 'content-container');
    });

    if (isAdmin) {
        document.getElementById('admin-page').addEventListener('click', function(e) {
            e.preventDefault(); 
            document.getElementById('content-container').innerHTML = '';
            loadContent('admin-page.php', 'admin-content-container');
        });
    }
});
