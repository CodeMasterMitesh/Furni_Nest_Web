// // /FurniNest/www/js/auth.js
// const serverUrl = "http://localhost:3000/api/"; // Replace with your actual IP and path

// document.getElementById("loginForm").addEventListener("submit", async function(e) {
//   e.preventDefault();
//   const formData = new FormData(this);
//   const res = await fetch(`${serverUrl}/login.php`, {
//     method: "POST",
//     body: new URLSearchParams(formData)
//   });
//   const text = await res.text();
//   document.getElementById("msg").textContent = text;
// });

// document.getElementById("registerForm").addEventListener("submit", async function(e) {
//   e.preventDefault();
//   const formData = new FormData(this);
//   const res = await fetch(`${serverUrl}/register.php`, {
//     method: "POST",
//     body: new URLSearchParams(formData)
//   });
//   const text = await res.text();
//   document.getElementById("msg").textContent = text;
// });
