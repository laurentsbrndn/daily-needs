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

    // $('.input-quantity').on('change', function () {
    //     var input = $(this);
    //     var form = input.closest('.quantity');
    //     var productId = $('input[name="product_id"]').val();
    //     var quantity = parseInt(input.val());
    //     var errorDiv = $('#quantity-error');

    //     $.ajax({
    //         url: "{{ route('cart.store') }}",
    //         type: "POST",
    //         data: {
    //             _token: "{{ csrf_token() }}",
    //             product_id: productId,
    //             quantity: quantity
    //         },
    //         success: function (response) {
    //             if (response.success) {
    //                 $('#quantity_add').val(response.new_quantity);
    //                 $('#quantity_checkout').val(response.new_quantity);
    //                 errorDiv.addClass('d-none').text(''); 
    //             }
    //         },
    //         error: function (xhr) {
    //             var response = xhr.responseJSON;
    //             if (response.error) {
    //                 errorDiv.removeClass('d-none').text(response.error);
    //                 input.val(response.new_quantity || input.attr('min'));
    //             }
    //         }
    //     });
    // });

    $('.input-quantity').on('change', function () {
        var input = $(this);
        var quantity = parseInt(input.val());
        var maxStock = parseInt(input.attr('max'));
        var errorDiv = $('#quantity-error');
    
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
