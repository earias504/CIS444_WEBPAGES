// userProfile.js

window.addEventListener("load", () => {
  fetch("userProfile.php")
    .then((res) => res.json())
    .then((data) => {
      if (data.error) {
        alert("Error loading profile");
        return;
      }

      document.getElementById("fullName").value = data.fullName;
      document.getElementById("username").value = data.username;
      document.getElementById("email").value = data.email;
      document.getElementById("bio").value = data.bio ?? "";

      // Role display
      document.getElementById("roleDisplay").innerText =
        data.role === "rescuer" ? "Rescuer Account" : "Pet Owner";

      // Profile picture
      document.getElementById("pfPicture").value = data.pfPicture;
      document.getElementById("profilePic").src =
        `../images/pfPicture${data.pfPicture}.jpg`;
    });

  // When user selects a picture
  document.getElementById("pfPicture").addEventListener("change", (e) => {
    const num = e.target.value;
    document.getElementById("profilePic").src =
      `../images/pfPicture${num}.jpg`;
  });
});
