let time = 0;

function searchItemsWithDelay(formData) {
    clearTimeout(time);
    time = setTimeout(function() {
        searchItems(formData);
    }, 300); //300 ms
}

function searchItems(formData) {
    let query = new URLSearchParams(formData).toString();

    let xhr = new XMLHttpRequest();
    xhr.open('GET', '../api/api_search.php?' + query);
    xhr.onload = function() {
        if (xhr.status === 200) { //request succeeded
            let response = JSON.parse(xhr.responseText);

            let itemsSection = document.getElementById('items');
            itemsSection.innerHTML = '';

            let itemsHeader = document.createElement('h2');
            itemsHeader.textContent = 'Items for Sale';
            itemsSection.appendChild(itemsHeader);

            response.forEach(function(item) {
                let itemElement = document.createElement('article');
                itemElement.innerHTML = `
                    <a href="../pages/item.php?idItem=${item.id}">
                        <img src="${item.image}" alt="${item.name}">
                    </a>
                    <div class="item-details">
                        <h2>
                            <a href="../pages/item.php?idItem=${item.id}">${item.name}</a>
                        </h2>
                        <h3>${item.brand} - ${item.model}</h3>
                        <p>Price: ${item.price}€</p>
                        <form action="../actions/action_add_to_cart.php" method="post">
                            <input type="hidden" name="idItem" value="${item.id}">
                            <button type="submit">Add to Cart</button>
                        </form>
                    </div>`;
                itemsSection.appendChild(itemElement);
            });
        } 
        else {
            console.error('Error status ' + xhr.status);
        }
    };

    xhr.onerror = function() {
        console.error('Request failed');
    };

    xhr.send();
}

document.getElementById('search-form').addEventListener('input', function(event) {
    event.preventDefault();
    let formData = new FormData(document.getElementById('search-form'));
    searchItemsWithDelay(formData);
});

document.getElementById('search-button').addEventListener('click', function(event) {
    event.preventDefault();
    let formData = new FormData(document.getElementById('search-form'));
    searchItems(formData);
});
