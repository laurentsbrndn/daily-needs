document.addEventListener("DOMContentLoaded", function () {
    const quantityInput = document.getElementById("product_quantity");
    const decreaseBtn = document.querySelector(".decrease-button");
    const increaseBtn = document.querySelector(".increase-button");
    const maxStock = parseInt(quantityInput.max, 10);

    function updateButtons() {
        decreaseBtn.disabled = quantityInput.value <= 1;
        increaseBtn.disabled = quantityInput.value >= maxStock;
    }

    function decreaseQuantity() {
        let quantity = parseInt(quantityInput.value, 10);
        if (quantity > 1) {
            quantityInput.value = quantity - 1;
            updateButtons();
        }
    }

    function increaseQuantity() {
        let quantity = parseInt(quantityInput.value, 10);
        if (quantity < maxStock) {
            quantityInput.value = quantity + 1;
            updateButtons();
        }
    }

    decreaseBtn.addEventListener("click", decreaseQuantity);
    increaseBtn.addEventListener("click", increaseQuantity);
    quantityInput.addEventListener("input", updateButtons);

    updateButtons();

    $('.quantity-input').on('change', function () {
        let input = $(this);
        let quantity = parseInt(input.val());
        let maxStock = parseInt(input.attr('max'));
        let errorDiv = $('#quantity-error');
    
        if (quantity < 1) {
            input.val(1);
            errorDiv.removeClass('d-none').html(`
                <div class="alert alert-danger p-2 mt-1" role="alert">
                    Minimum quantity is 1!
                </div>
            `);
            return;
        }
    
        if (quantity > maxStock) {
            input.val(maxStock);
            errorDiv.removeClass('d-none').html(`
                <div class="alert alert-danger p-2 mt-1" role="alert">
                    Stock not enough! Maximum stock available is ${maxStock}.
                </div>
            `);
            return;
        }
    
        errorDiv.addClass('d-none').text('');
    });
    

    $('#addToCartForm').submit(function (event) {
        event.preventDefault();
    
        $('#quantity_add').val($('#product_quantity').val());
    
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                $('#cartPopup').fadeIn();
                if ($('#cartCount').length) {
                    $('#cartCount').text(response.cart_count);
                }
                setTimeout(function () {
                    $('#cartPopup').fadeOut();
                }, 3000);
            },
            error: function (xhr) {
                let response = xhr.responseJSON;
                $("#quantity-cart-error").html(`
                    <div class="alert alert-danger p-2 mt-1" role="alert">
                        ${response.error}
                    </div>
                `);
            }
        });
    });
    

    
    
    

    // document.getElementById("checkoutForm").addEventListener("submit", function (event) {
    //     document.getElementById("quantity_checkout").value = quantityInput.value;
    // });
});
