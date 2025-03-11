$(document).ready(function () {
    // ✅ Fungsi untuk update harga subtotal
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

    // ✅ Jalankan update subtotal saat checkbox diubah
    $('.cart-checkbox').on("change", updateTotalPrice);
    updateTotalPrice(); // Panggil saat halaman pertama kali dimuat

    // ✅ Prevent page reload saat menambahkan produk ke dalam keranjang
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

    // ✅ Update jumlah produk di keranjang dengan AJAX
    // $('.quantity-input').on('change', function () {
    //     var input = $(this);
    //     var form = input.closest('.update-cart-form');
    //     var url = form.data('url');

    //     $.ajax({
    //         url: url,
    //         method: 'PATCH',
    //         data: form.serialize(),
    //         success: function (response) {
    //             if (response.success) {
    //                 input.val(response.new_quantity).trigger('input'); // Update input quantity
    //                 updateTotalPrice();
    //             }
    //             if (response.max_stock) {
    //                 input.val(response.max_stock).trigger('input'); // ✅ Pastikan input sesuai stok maksimum
    //                 input.closest(".update-cart-form").find(".error-message").html(`
    //                     <div class="alert alert-warning p-2 mt-1" role="alert">
    //                         Maksimal stok produk hanya ${response.max_stock}
    //                     </div>
    //                 `);
    //             }
    //         },
    //         error: function (xhr) {
    //             console.error("Update error", xhr);
    //         }
    //         // error: function (xhr) {
    //         //     var response = xhr.responseJSON;
    //         //     if (response && response.error) {
    //         //         var row = input.closest('tr');
    //         //         row.find('.error-message').html(`
    //         //             <div class="alert alert-danger p-2 mt-1" role="alert">
    //         //                 ${response.error}
    //         //             </div>
    //         //         `);
    //         //         if (response.max_stock) {
    //         //             input.val(response.max_stock);
    //         //         }
    //         //     }
    //         // }
    //     });
    // });

    $('.quantity-input').on('change', function () {
        var input = $(this);
        var form = input.closest('.update-cart-form');
        var url = form.data('url');
    
        $.ajax({
            url: url,
            method: 'PATCH',
            data: form.serialize(),
            success: function (response) {
                if (response.success) {
                    input.val(response.new_quantity).trigger('input'); // ✅ Update input quantity
                    updateTotalPrice();
                }
                if (response.max_stock) {
                    input.val(response.max_stock).trigger('input'); // ✅ Pastikan input sesuai stok maksimum
                    input.closest(".update-cart-form").find(".error-message").html(`
                        <div class="alert alert-warning p-2 mt-1" role="alert">
                            Maksimal stok produk hanya ${response.max_stock}
                        </div>
                    `);
                }
            },
            error: function (xhr) {
                var response = xhr.responseJSON;
                if (response && response.prev_quantity !== undefined) {
                    input.val(response.prev_quantity).trigger('input'); // ✅ Kembalikan ke angka sebelum diubah
                    input.closest(".update-cart-form").find(".error-message").html(`
                        <div class="alert alert-danger p-2 mt-1" role="alert">
                            ${response.error}
                        </div>
                    `);
                }
            }
        });
    });
    //     event.preventDefault();
    
    //     var input = $(this).siblings('.quantity-input');
    //     var form = input.closest('.update-cart-form');  
    //     var url = form.data('url');
    //     var action = $(this).hasClass('increase-btn') ? 1 : -1; 
    
    //     var newValue = parseInt(input.val()) + action; 
    
    //     if (newValue >= 1) { 
    //         input.val(newValue); 
            
    //         $.ajax({
    //             url: url,
    //             method: 'PATCH',
    //             data: form.serialize(),
    //             success: function (response) {
    //                 if (response.success) {
    //                     input.val(response.new_quantity); d
    //                     updateTotalPrice(); 
    //             },
    //             error: function (xhr) {
    //                 console.error("Update error", xhr);
    //             }
    //         });
    //     }
    // });

    $('.increase-btn, .decrease-btn').on('click', function (event) {
        event.preventDefault();
    
        var input = $(this).siblings('.quantity-input');
        var form = input.closest('.update-cart-form');        
        var url = form.data('url');  
        var action = $(this).hasClass('increase-btn') ? 'increase' : 'decrease'; 
        
        var newValue = parseInt(input.val()) + (action === 'increase' ? 1 : -1); 
        
        if (newValue >= 1) { 
            input.val(newValue); 
            
            $.ajax({
                url: url,
                method: 'PATCH',
                data: form.serialize() + '&action=' + action, 
                success: function (response) {
                    if (response.success) {
                        input.val(response.new_quantity);d
                        updateTotalPrice(); 
                    }
                },
                error: function (xhr) {
                    var response = xhr.responseJSON;
                    if (response && response.max_stock) {
                        input.val(response.max_stock);
                        input.closest(".update-cart-form").find(".error-message").html(`
                            <div class="alert alert-warning p-2 mt-1" role="alert">
                                Stock not enough! Maximum stock available is ${response.max_stock}
                            </div>
                        `);
                    }
                }
            });
        }
    });
    


    // Prevent reload saat form update quantity dikirim
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
