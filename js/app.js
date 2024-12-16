const cartIcon = document.querySelector("#cart-icon");
const cart = document.querySelector(".cart");
const closeCart = document.querySelector("#cart-close");
const cartContent = document.querySelector(".cart-content");
const totalPriceElement = document.querySelector(".total-price");

cartIcon.addEventListener("click", () => {
    cart.classList.add("active");
});

closeCart.addEventListener("click", () => {
    cart.classList.remove("active");
});

let cartItems = []; // Estado local para los productos del carrito

function addProducto(id, token, nombre, imagen, precio) {
   console.log("Producto agregado:", id, token, nombre, imagen, precio); // Debugging

   const existingProduct = cartItems.find(item => item.id === id);

   if (existingProduct) {
       existingProduct.quantity += 1;
   } else {
       const newProduct = {
           id: id,
           token: token,
           nombre: nombre,
           imagen: imagen,
           precio: precio,
           quantity: 1
       };
       cartItems.push(newProduct);
   }

   console.log("Estado actual del carrito:", cartItems); // Debugging
   updateCartUI();

   // Enviar los datos al servidor (opcional, para sincronizar)
   let url = 'php/carrito.php';
   let formData = new FormData();
   formData.append('id', id);
   formData.append('token', token);

   fetch(url, {
       method: 'POST',
       body: formData,
       mode: 'cors'
   })
       .then(response => response.json())
       .then(data => {
           if (data.ok) {
               const elemento = document.getElementById("num_cart");
               elemento.innerHTML = data.numero; // Actualizar número del carrito en la interfaz
           }
       })
       .catch(error => {
           console.error('Error al agregar al carrito:', error);
       });
}
        function updateCartUI() {
         const cartContent = document.querySelector(".cart-content");
         const totalPriceElement = document.querySelector(".total-price");
         cartContent.innerHTML = ""; // Limpiar el contenido del carrito
     
         if (cartItems.length === 0) {
             cartContent.innerHTML = "<p>El carrito está vacío.</p>";
             totalPriceElement.textContent = "$0";
             return;
         }
     
         let total = 0;
     
         // Recorremos cada producto en el carrito
         cartItems.forEach(product => {
             // Calcula el precio total para este producto
             const productTotal = product.precio * product.quantity;
             total += productTotal; // Suma al total general
     
             // Crear un elemento visual para este producto en el carrito
             const cartBox = document.createElement("div");
             cartBox.classList.add("cart-box");
             cartBox.innerHTML = `
                <div class="cart-box">
                    <img src="${product.imagen}" alt="${product.nombre}" class="cart-img" alt="Producto">
                    <div class="cart-product-info">   
                        <div class="cart-product-title">${product.nombre}</div>
                        <div class="cart-price">$${product.precio.toFixed(2)}</div>
                    </div>
                </div>
                    <div class="cart-actions">
                        <input type="number" value="${product.quantity}" class="cart-quantity" min="1">
                        <span class="bx bx-trash cart-remove" onclick="removeFromCart(${product.id})"></i>
                    </div>
             `;
     
             // Añade un evento al campo de cantidad para actualizar el precio
             const quantityInput = cartBox.querySelector(".cart-quantity");
             quantityInput.addEventListener("change", (e) => {
                 const newQuantity = parseInt(e.target.value);
                 if (newQuantity > 0) {
                     product.quantity = newQuantity; // Actualiza la cantidad en el carrito
                     updateCartUI(); // Vuelve a calcular y actualizar
                 }
             });
     
             cartContent.appendChild(cartBox);
         });
     
         // Actualiza el precio total en el carrito
         totalPriceElement.textContent = `$${total.toFixed(2)}`;
     }

// Función para eliminar un producto del carrito
function removeFromCart(productId) {
    cartItems = cartItems.filter(item => item.id !== productId);
    updateCartUI();
}

