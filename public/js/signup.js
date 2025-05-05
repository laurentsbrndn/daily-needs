document.addEventListener('DOMContentLoaded', function () {
    function togglePassword() {
        const passwordInput = document.getElementById("customer_password");
        const icon = document.querySelector(".toggle-password i");
    
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        }
    }
    
   
});
