// Handle form submission
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("interestForm");

  form.addEventListener("submit", (event) => {
    event.preventDefault();

    // Get values
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const animal = document.getElementById("animal").value;
    const reason = document.getElementById("reason").value;

    // Simple localStorage save (placeholder for backend connection)
    localStorage.setItem("interestForm", JSON.stringify({ name, email, animal, reason }));

    alert("Thank you for your submission!");
    form.reset();
  });
});
