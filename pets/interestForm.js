document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("interestForm");

  form.addEventListener("submit", async (event) => {
    event.preventDefault();

    const cat_name = document.getElementById("name").value;
    const age = document.getElementById("age").value;
    const gender = document.getElementById("gender").value;
    const description = document.getElementById("reason").value;
    const contactInfo = document.getElementById("email").value;

    const response = await fetch("addAdoptionPet.php", {
      method: "POST",
      headers: { "Content-Type": "application/json"},
      body: JSON.stringify({
        cat_name,
        age,
        gender,
        description,
        contactInfo
      })
    });

    const result = await response.json();

    if (result.success) {
      alert("Pet added to adoption list!");
      window.location.href = "readyToAdopt.html";
    } else {
      alert("Error: " + result.error);
    }
  });
});
