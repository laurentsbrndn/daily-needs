$(document).ready(function () {

    function updateTotalPrice() {
        let selectedProducts = [];
    
        $(".cart-checkbox:checked").each(function () {
            selectedProducts.push($(this).data("product-id"));
        });
    
        $.ajax({
            url: "/cart/subtotal",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                selected_products: selectedProducts
            },
            success: function (response) {
                $("#total-price").text("Rp " + response.subtotal);
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
            }
        });
    }
    
    $('.cart-checkbox').on("change", updateTotalPrice);
    updateTotalPrice(); 

    function updateButtons(input) {
        let value = parseInt(input.val());
        let maxStock = parseInt(input.data('max-stock'));
        let decreaseBtn = input.siblings('.decrease-btn');
        let increaseBtn = input.siblings('.increase-btn');

        decreaseBtn.prop('disabled', value <= 1);
        increaseBtn.prop('disabled', value >= maxStock);
    }

    $('.quantity-input').on('change', function () {
        let input = $(this);
        let form = input.closest('.update-cart-form');
        let url = form.data('url');
        let value = parseInt(input.val());
        let totalPriceElement = form.closest('tr').find('.total-price-per-item');

        input.val(value);
        updateButtons(input);

        $.ajax({
            url: url,
            method: 'PATCH',
            data: form.serialize(),
            success: function (response) {
                let newValue = response.new_quantity ?? value;
                input.val(newValue).trigger('input');

                if (response.success) {

                    totalPriceElement.html("Rp " + response.total_price.toLocaleString());

                    updateTotalPrice();
                }
            },
            error: function (xhr) {
                let response = xhr.responseJSON;

                if (response && response.error) {
                    totalPriceElement.html("Rp " + response.total_price.toLocaleString());
                    input.closest(".update-cart-form").find(".error-message").html(`
                        <div class="alert alert-danger p-2 mt-1" role="alert">
                            ${response.error}
                        </div>
                    `);
                    input.val(response.new_quantity).trigger('input');
                    updateTotalPrice();
                }
            }
        });
    });

    $('.increase-btn, .decrease-btn').on('click', function (event) {
        event.preventDefault();
    
        let input = $(this).siblings('.quantity-input');
        let form = input.closest('.update-cart-form');        
        let url = form.data('url');  
        let action = $(this).hasClass('increase-btn') ? 'increase' : 'decrease'; 
        
        let currentValue = parseInt(input.val());
        let maxStock = parseInt(input.data('max-stock'));
        
        let newValue = action === 'increase' ? currentValue + 1 : currentValue - 1;

        if (newValue < 1) {
            newValue = 1;
        }
        else if (newValue > maxStock) {
            newValue = maxStock;
        }
    
        input.val(newValue);

        let totalPriceElement = form.closest('tr').find('.total-price-per-item');

        updateButtons(input);
        
        $.ajax({
            url: url,
            method: 'PATCH',
            data: form.serialize() + '&action=' + action, 
            success: function (response) {
                if (response.success) {
                    input.val(response.new_quantity);
                    totalPriceElement.text("Rp " + response.total_price.toLocaleString());
                    
                    updateTotalPrice(); 
                }
                updateButtons(input);
            },
            error: function (xhr) {
                let response = xhr.responseJSON;
                if (response && response.max_stock) {
                    input.val(response.max_stock).trigger('input');
                    input.closest(".update-cart-form").find(".error-message").html(`
                        <div class="alert alert-danger p-2 mt-1" role="alert">
                            ${response.error}
                        </div>
                    `);
                    updateTotalPrice();
                }
                updateButtons(input);
            }
        });
    });

    $(document).on('submit', '.delete-cart-form', function(e) {
        e.preventDefault(); 
    
        let form = $(this); 
        let url = form.attr('action');
        let row = form.closest('tr'); 
    
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

        let form = $(this);
        let url = form.data('url');

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