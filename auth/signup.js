// signup.js

document.addEventListener("DOMContentLoaded", () => {
  const signupBtn = document.getElementById("signupBtn");

  signupBtn.addEventListener("click", () => {
    const fullName = document.getElementById("fullName").value.trim();
    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const confirmPassword = document.getElementById("confirmPassword").value.trim();
    const role = document.getElementById("role").value;

    if (!fullName || !username || !email || !password || !confirmPassword || !role) {
      alert("Please fill in all fields and select your role.");
      return;
    }

    if (password !== confirmPassword) {
      alert("Passwords do not match.");
      return;
    }

    // Store temporarily in localStorage for now
    localStorage.setItem("username", username);
    localStorage.setItem("email", email);
    localStorage.setItem("role", role);

    alert(`Account created as a ${role === "owner" ? "Pet Owner 🐶" : "Pet Rescuer 🐾"}!`);
    window.location.href = "../homePage.html";
  });
});
