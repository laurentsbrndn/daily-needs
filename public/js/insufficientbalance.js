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