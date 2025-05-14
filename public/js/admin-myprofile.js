function previewImage(event) {
    const image = event.target.files[0];
    if (image) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.querySelector('#profile-image');
            img.src = e.target.result;
            img.width = 100; // Ensure the image is properly sized
        }
        reader.readAsDataURL(image);
    }
}


setTimeout(function() {
    const alert = document.getElementById('success-alert');
    if (alert) {
        alert.classList.add('hidden');
        setTimeout(function() {
            alert.style.display = 'none'; 
        }, 500); 
    }
}, 1500);

function hidePenIcon(iconId) {
    var icon = document.getElementById(iconId);
    icon.style.display = 'none'; // Hide the pen icon
}
