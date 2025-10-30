document.addEventListener("DOMContentLoaded", () => {
  const loginBtn = document.querySelector(".tile"); // The "Log In" button
  const usernameInput = document.querySelector('input[placeholder="Username or Email"]');
  const passwordInput = document.querySelector('input[placeholder="Password"]');

  loginBtn.addEventListener("click", (event) => {
    event.preventDefault(); // prevent form reload

    const enteredUser = usernameInput.value.trim();
    const enteredPass = passwordInput.value.trim();

    // Retrieve stored user info (from signup.js localStorage)
    const storedUser = localStorage.getItem("username");
    const storedEmail = localStorage.getItem("email");
    const storedPass = localStorage.getItem("password"); // optional if added later

    // For now, use password from signup process if stored
    const storedRole = localStorage.getItem("role");

    // Simple validation
    if (!enteredUser || !enteredPass) {
      alert("Please enter both your username/email and password.");
      return;
    }

    // Check if username or email matches
    if (
      (enteredUser === storedUser || enteredUser === storedEmail) &&
      enteredPass === storedPass
    ) {
      alert(`Welcome back, ${storedUser}!`);
      window.location.href = "homePage.html";
    } else {
      alert("Invalid login credentials. Please try again.");
    }
  });
});
