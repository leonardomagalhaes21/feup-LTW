document.getElementById('search-form').addEventListener('submit', function(event) {
    event.preventDefault(); 
    var searchKeyword = document.getElementById('search-keyword').value;
    var category = document.getElementById('category').value;
    var size = document.getElementById('size').value;
    var condition = document.getElementById('condition').value;
    var order = document.querySelector('input[name="order"]:checked').value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var items = JSON.parse(xhr.responseText);
                updateSearchResults(items);
            } else {
                console.error('Error: ' + xhr.status);
            }
        }
    };
    xhr.open('POST', 'search_items.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    var searchData = {
        search: searchKeyword,
        category: category, 
        size: size,
        condition: condition,
        order: order
    };
    xhr.send(JSON.stringify(searchData));
});

function updateSearchResults(items) {
    var resultList = document.getElementById('search-results');
    resultList.innerHTML = ''; 
    items.forEach(function(item) {
        var listItem = document.createElement('li');
        listItem.textContent = item.name + ' - $' + item.price;
        resultList.appendChild(listItem);
    });
}
