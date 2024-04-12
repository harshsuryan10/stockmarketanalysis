document.getElementById("stockForm").addEventListener("submit", function(event) {
    event.preventDefault();
    var ticker = document.getElementById("ticker").value;
    fetchStockInfo(ticker);
});

function fetchStockInfo(ticker) {
    // AJAX call or fetch to your backend API
    fetch(`/api/stock?ticker=${ticker}`)
    .then(response => response.json())
    .then(data => {
        displayStockInfo(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function displayStockInfo(data) {
    var stockInfoDiv = document.getElementById("stockInfo");
    stockInfoDiv.innerHTML = `<h2>${data.symbol}</h2>
                              <p>Name: ${data.name}</p>
                              <p>Price: ${data.price}</p>
                              <p>Market Cap: ${data.marketCap}</p>`;
}
