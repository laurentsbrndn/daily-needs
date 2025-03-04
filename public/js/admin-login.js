document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.querySelector(".toggle-password");
    const passwordInput = document.getElementById("admin_password");

    togglePassword.addEventListener("click", function () {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            this.classList.remove("bi-eye-slash"); 
            this.classList.add("bi-eye"); 
        } else {
            passwordInput.type = "password";
            this.classList.remove("bi-eye"); 
            this.classList.add("bi-eye-slash"); 
        }
    });
});