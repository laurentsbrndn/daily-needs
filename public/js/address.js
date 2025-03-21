// document.getElementById("chooseAddressBtn").addEventListener("click", function() {
//     fetch('/addresses')
//     .then(response => response.json())
//     .then(data => {
//         let addressList = document.getElementById("addressList");
//         addressList.innerHTML = "";
        
//         data.forEach(address => {
//             let addressItem = document.createElement("div");
//             addressItem.innerHTML = `
//                 <p><strong>${address.customer_address_name}</strong></p>
//                 <p>${address.customer_address_street}, ${address.customer_address_city}</p>
//                 <button class="selectAddress" data-id="${address.customer_address_id}" data-name="${address.customer_address_name}">Pilih</button>
//                 <hr>
//             `;
//             addressList.appendChild(addressItem);
//         });

//         document.querySelectorAll(".selectAddress").forEach(button => {
//             button.addEventListener("click", function() {
//                 let addressId = this.getAttribute("data-id");
//                 let addressName = this.getAttribute("data-name");

//                 document.getElementById("selectedAddress").innerHTML = `Dikirim ke: <strong>${addressName}</strong>`;
//                 document.getElementById("selectedAddressId").value = addressId;
//                 document.getElementById("addressModal").style.display = "none";
//             });
//         });
//     });

//     document.getElementById("addressModal").style.display = "block";
// });

// document.getElementById("addNewAddressBtn").addEventListener("click", function() {
//     document.getElementById("newAddressForm").style.display = "block";
// });

// document.getElementById("cancelNewAddress").addEventListener("click", function() {
//     document.getElementById("newAddressForm").style.display = "none";
// });

// document.getElementById("addAddressForm").addEventListener("submit", function(event) {
//     event.preventDefault();

//     let formData = new FormData(this);
    
//     fetch('/addresses', {
//         method: "POST",
//         body: JSON.stringify(Object.fromEntries(formData)),
//         headers: { "Content-Type": "application/json" }
//     })
//     .then(response => response.json())
//     .then(data => {
//         alert("Alamat berhasil ditambahkan!");
//         document.getElementById("newAddressForm").style.display = "none";
//         document.getElementById("chooseAddressBtn").click();
//     });
// });

// document.getElementById("closeModal").addEventListener("click", function() {
//     document.getElementById("addressModal").style.display = "none";
// });