// document.addEventListener('DOMContentLoaded', function () {
//     const form = document.getElementById('checkoutForm');
//     const button = form.querySelector('button[type="submit"]');

//     button.addEventListener('click', function (e) {
//         e.preventDefault();

//         const balance = parseFloat(document.getElementById('customerBalance').value);
//         const totalPrice = parseFloat(document.getElementById('totalPrice').value);
//         const selectedPayment = document.getElementById('selectedPayment').value;

//         if (selectedPayment == 1 && balance < totalPrice) {
//             document.getElementById('currentBalanceText').innerText = 
//                 'Rp ' + balance.toLocaleString('id-ID');

//             let myModal = new bootstrap.Modal(document.getElementById('insufficientBalanceModal'));
//             myModal.show();
//         } else {
//             form.submit();
//         }
//     });
// });

function handleInsufficientBalance(form) {
    const balance = parseFloat($('#customerBalance').val());
    const totalPrice = parseFloat($('#totalPrice').val());
    const selectedPayment = $('#selectedPayment').val();

    if (selectedPayment == 1 && balance < totalPrice) {
        $('#currentBalanceText').text('Rp ' + balance.toLocaleString('id-ID'));
        let modal = new bootstrap.Modal(document.getElementById('insufficientBalanceModal'));
        modal.show();
        return false;
    }

    return true;
}
