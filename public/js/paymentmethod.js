document.addEventListener("DOMContentLoaded", function() {
    let paymentSelect = document.getElementById("paymentMethod");
    let selectedPayment = document.getElementById("selectedPayment");

    selectedPayment.value = paymentSelect.value;

    paymentSelect.addEventListener("change", function() {
        selectedPayment.value = this.value;
    });
});
