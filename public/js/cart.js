$(document).ready(function () {
    function updateTotalPrice() {
        let selectedProducts = [];
        let totalPrice = 0;
    
        $('.cart-checkbox:checked').each(function () {
            selectedProducts.push($(this).data("product-id"));
            totalPrice += parseFloat($(this).data("price"));
        });

        $.ajax({
            url: "/cart/subtotal",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: JSON.stringify({ selected_products: selectedProducts }),
            contentType: "application/json",
            success: function (data) {
                let subtotal = data.subtotal ? `Rp ${data.subtotal.toLocaleString()}` : "Rp 0";
                $('#total-price').text(subtotal);
                $('#checkout-btn').prop('disabled', selectedProducts.length === 0);
            },
            error: function () {
                console.error("Error updating subtotal");
            }
        });
    }

    $('.cart-checkbox').on("change", updateTotalPrice);
    updateTotalPrice(); 

    $('#addToCartForm').submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function () {
                $('#cartPopup').fadeIn();
                setTimeout(function () {
                    $('#cartPopup').fadeOut();
                }, 3000);
            },
            error: function () {
                alert('Failed to add to cart!');
            }
        });
    });

    function updateButtons(input) {
        var value = parseInt(input.val());
        var maxStock = parseInt(input.data('max-stock'));
        var decreaseBtn = input.siblings('.decrease-btn');
        var increaseBtn = input.siblings('.increase-btn');

        decreaseBtn.prop('disabled', value <= 1);
        increaseBtn.prop('disabled', value >= maxStock);
    }

    $('.quantity-input').on('change', function () {
        
        var input = $(this);
        var form = input.closest('.update-cart-form');
        var url = form.data('url');
        var value = parseInt(input.val());
    
        updateButtons(input);
        $.ajax({
            url: url,
            method: 'PATCH',
            data: form.serialize(),
            success: function (response) {
                var newValue = response.new_quantity ?? value;  
                input.val(newValue).trigger('input');
                if (response.error) {
                    input.closest(".update-cart-form").find(".error-message").html(`
                        <div class="alert alert-danger p-2 mt-1" role="alert">
                            ${response.error}
                        </div>
                    `);
                } 
                else {
                    input.closest(".update-cart-form").find(".error-message").html(''); 
                }
                updateTotalPrice();
            },
            error: function (xhr) {
                var response = xhr.responseJSON;
        
                if (response && response.error) {
                    input.closest(".update-cart-form").find(".error-message").html(`
                        <div class="alert alert-danger p-2 mt-1" role="alert">
                            ${response.error}
                        </div>
                    `);
                    var newValue = response.new_quantity ?? value;
                    input.val(newValue).trigger('input'); 
                }
                else {
                    input.closest(".update-cart-form").find(".error-message").html('');
                }
                updateButtons(input);
            }
        });
    
    });

    $('.increase-btn, .decrease-btn').on('click', function (event) {
        event.preventDefault();
    
        var input = $(this).siblings('.quantity-input');
        var form = input.closest('.update-cart-form');        
        var url = form.data('url');  
        var action = $(this).hasClass('increase-btn') ? 'increase' : 'decrease'; 
        
        var currentValue = parseInt(input.val());
        var maxStock = parseInt(input.data('max-stock'));
        
        var newValue = action === 'increase' ? currentValue + 1 : currentValue - 1;

        if (newValue < 1) {
            newValue = 1;
        }
        else if (newValue > maxStock) {
            newValue = maxStock;
        }
    
        input.val(newValue);
        updateButtons(input);
        
        $.ajax({
            url: url,
            method: 'PATCH',
            data: form.serialize() + '&action=' + action, 
            success: function (response) {
                if (response.success) {
                    input.val(response.new_quantity);
                    
                    updateTotalPrice(); 
                }
                updateButtons(input);
            },
            error: function (xhr) {
                var response = xhr.responseJSON;
                if (response && response.max_stock) {
                    input.val(response.max_stock).trigger('input');
                    input.closest(".update-cart-form").find(".error-message").html(`
                        <div class="alert alert-danger p-2 mt-1" role="alert">
                            ${response.error}
                        </div>
                    `);
                }
                updateButtons(input);
            }
        });
    });

    $(document).on('submit', '.delete-cart-form', function(e) {
        e.preventDefault(); 
    
        var form = $(this); 
        var url = form.attr('action');
        var row = form.closest('tr'); 
    
        $.ajax({
            url: url,
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    // row.fadeOut(500, function () { $(this).remove(); });
                    row.remove();
                    updateTotalPrice();
                } 
                else {
                    alert(response.error);
                }
            },
            error: function(xhr) {
                alert('Error removing item. Please try again.');
            }
        });
    });
    

    $('.quantity-input').each(function() {
        updateButtons($(this));
    });
    
    $('.update-cart-form').on('submit', function (event) {
        event.preventDefault();

        var form = $(this);
        var url = form.data('url');

        $.ajax({
            url: url,
            method: 'PATCH',
            data: form.serialize(),
            success: function (response) {
                if (response.success) {
                    form.find('.quantity-input').val(response.new_quantity);
                    updateTotalPrice();
                }
            },
            error: function (xhr) {
                console.error("Update error", xhr);
            }
        });
    });
});