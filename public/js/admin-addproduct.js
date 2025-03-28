document.getElementById("product_image").addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewImage = document.getElementById("image-preview");
            const placeholder = document.querySelector(".image-placeholder");

            previewImage.src = e.target.result;
            previewImage.style.display = "block"; 
            placeholder.style.display = "none"; 
        };
        reader.readAsDataURL(file);
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const decreaseBtn = document.getElementById("decrease-btn");
    const increaseBtn = document.getElementById("increase-btn");
    const stockInput = document.querySelector("input[name='product_stock']");

    decreaseBtn.addEventListener("click", function () {
        let currentValue = parseInt(stockInput.value) || 0;
        if (currentValue > 0) {
            stockInput.value = currentValue - 1;
        }
    });

    increaseBtn.addEventListener("click", function () {
        let currentValue = parseInt(stockInput.value) || 0;
        stockInput.value = currentValue + 1;
    });
});

