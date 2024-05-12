document.addEventListener("DOMContentLoaded", function() {
    async function loadContent(url, containerId) {
        const response = await fetch(url);
        const data = await response.text();
        document.getElementById(containerId).innerHTML = data;
    }

    document.getElementById('user-details').addEventListener('click', function(e) {
        e.preventDefault(); 
        loadContent('profile_user_details.php?section=container', 'content-container'); 
    });

    document.getElementById('wishlist').addEventListener('click', function(e) {
        e.preventDefault();
        loadContent('wishlist.php?section=container', 'content-container');
    });

    document.getElementById('your-items').addEventListener('click', function(e) {
        e.preventDefault();
        loadContent('profile_your_items.php?section=container', 'content-container');
    });

    document.getElementById('your-orders').addEventListener('click', function(e) {
        e.preventDefault();
        loadContent('profile_your_orders.php?section=container', 'content-container');
    });

    document.getElementById('orders-to-ship').addEventListener('click', function(e) {
        e.preventDefault();
        loadContent('profile_orders_to_ship.php?section=container', 'content-container');
    });

    if (isAdmin) {
        document.getElementById('admin-page').addEventListener('click', function(e) {
            e.preventDefault(); 
            loadContent('admin-page.php?section=container', 'content-container');
        });
    }
});
