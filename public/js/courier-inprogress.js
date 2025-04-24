document.addEventListener('DOMContentLoaded', function () {
    const rows = document.querySelectorAll('.in-progress');
    const codModalEl = document.getElementById('codConfirmModal');
    const detailModalEl = document.getElementById('inProgressStatusModal');

    const codModal = new bootstrap.Modal(codModalEl);
    const detailModal = new bootstrap.Modal(detailModalEl);

    const hiddenShipmentId = document.getElementById('hiddenShipmentId');
    const hiddenTransactionId = document.getElementById('hiddenTransactionId');
    const hiddenRecipientName = document.getElementById('hiddenRecipientName');
    const recipientNameInput = document.getElementById('recipientName');
    const confirmForm = document.getElementById('inProgressConfirmForm');

    if (confirmForm) {
        confirmForm.addEventListener('submit', function () {
            hiddenRecipientName.value = recipientNameInput.value;
        });
    }

    rows.forEach(row => {
        row.addEventListener('click', () => {
            const {
                shipmentId,
                transactionId,
                shipmentDate,
                address,
                paymentMethod,
                totalPrice,
            } = row.dataset;

            document.getElementById('modalShipmentNumber').textContent = shipmentId;
            document.getElementById('modalTransactionNumber').textContent = transactionId;
            document.getElementById('modalShipmentDateStart').textContent = shipmentDate;
            document.getElementById('modalAddressInProgress').textContent = address;
            document.getElementById('modalPaymentInProgress').textContent = paymentMethod;
            document.getElementById('cod-total-price').textContent = `Rp${parseInt(totalPrice).toLocaleString('id-ID')}`;

            hiddenShipmentId.value = shipmentId;
            hiddenTransactionId.value = transactionId;

            confirmForm.setAttribute('action', `/courier/delivery-order/in-progress/${shipmentId}`)

            if (paymentMethod === 'Cash on Delivery') {
                codModal.show();

                document.getElementById('cod-no').onclick = function () {
                    codModal.hide();
                    setTimeout(() => {
                        window.location.href = `/courier/delivery-order/in-progress/cancel/${shipmentId}`;
                    }, 200);
                };

                document.getElementById('cod-yes').onclick = function () {
                    codModal.hide();
                    setTimeout(() => {
                        detailModal.show();
                    }, 200);
                };
                
            } 
            else {
                detailModal.show();
            }
        });
    });
});