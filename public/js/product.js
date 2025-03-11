function updateQuantity(value) {
    let stockInput = document.getElementById('product_stock');
    let hiddenQuantity = document.getElementById('quantity_add');
    let currentValue = parseInt(stockInput.value);

    if (isNaN(currentValue) || currentValue < 1) {
        currentValue = 1;
    }

    let newValue = currentValue + value;

    if (newValue >= 1 && newValue <= parseInt(stockInput.max)) {
        stockInput.value = newValue;
        hiddenQuantity.value = newValue;
    }
}

function increaseQuantity() {
    updateQuantity(1);
}

function decreaseQuantity() {
    updateQuantity(-1);
}
