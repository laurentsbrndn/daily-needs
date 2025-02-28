function increaseQuantity() {
    let stockInput = document.getElementById('product_stock');
    let currentValue = parseInt(stockInput.value);

    if (isNaN(currentValue)) {
        currentValue = 0;
    }

    stockInput.value = currentValue + 1;
}

function decreaseQuantity() {
    let stockInput = document.getElementById('product_stock');
    let currentValue = parseInt(stockInput.value);

    if (isNaN(currentValue)) {
        currentValue = 0;
    }

    if (currentValue > 0) {
        stockInput.value = currentValue - 1;
    }
}