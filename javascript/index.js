document.getElementById('search-form').addEventListener('submit', function(event) {
    event.preventDefault(); 
    let searchKeyword = document.getElementById('search-keyword').value;
    let category = document.getElementById('category').value;
    let size = document.getElementById('size').value;
    let condition = document.getElementById('condition').value;
    let order = document.querySelector('input[name="order"]:checked').value;
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let items = JSON.parse(xhr.responseText);
                updateSearchResults(items);
            } else {
                console.error('Error: ' + xhr.status);
            }
        }
    };
    xhr.open('POST', 'search_items.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    let searchData = {
        search: searchKeyword,
        category: category, 
        size: size,
        condition: condition,
        order: order
    };
    xhr.send(JSON.stringify(searchData));
});

function updateSearchResults(items) {
    let resultList = document.getElementById('search-results');
    resultList.innerHTML = ''; 
    items.forEach(function(item) {
        let listItem = document.createElement('li');
        listItem.textContent = item.name + ' - $' + item.price;
        resultList.appendChild(listItem);
    });
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('cart-link').addEventListener('click', function(event) {
        event.preventDefault(); 
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById('cart-container').innerHTML = xhr.responseText;
                } else {
                    console.error('Error loading cart content');
                }
            }
        };
        xhr.open('GET', '../pages/cart.php');
        xhr.send();
    });
});

