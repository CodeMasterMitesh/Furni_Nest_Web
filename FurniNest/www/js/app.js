// Load header component
fetch("components/header.html")
  .then(res => res.text())
  .then(html => document.getElementById("header").innerHTML = html);

// On DOM load
document.addEventListener("DOMContentLoaded", () => {
  const email = localStorage.getItem("email") || "User";
  document.getElementById("userEmail").textContent = email;

  fetch("../www/products.php")
    .then(res => res.json())
    .then(data => renderProducts(data));
});

function renderProducts(products) {
  const container = document.getElementById("productList");
  container.innerHTML = "";

  products.forEach(product => {
    const card = document.createElement("div");
    card.className = "col";
    card.innerHTML = `
      <div class="card p-2 h-100 text-center">
        <h6>${product.name}</h6>
        <p>₹${product.price}</p>
        <button class="btn btn-sm btn-primary w-100" onclick="addToCart(${product.id})">Add to Cart</button>
      </div>
    `;
    container.appendChild(card);
  });
}

function addToCart(productId) {
  const email = localStorage.getItem("email");
  fetch("../www/add_to_cart.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `email=${email}&product_id=${productId}`
  })
  .then(res => res.json())
  .then(data => alert(data.message));
}

function logout() {
  localStorage.clear();
  window.location.href = "index.html";
}

function viewCart() { alert("Cart Page Coming Soon!"); }
function viewOrders() { alert("Orders Page Coming Soon!"); }
function viewProfile() { alert("Profile Page Coming Soon!"); }
