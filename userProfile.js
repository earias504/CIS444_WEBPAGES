// Elements
const editBtn = document.getElementById("editBtn");
const saveBtn = document.getElementById("saveBtn");
const inputs = document.querySelectorAll(".profile-field input");
const profilePic = document.getElementById("profilePic");
const changePicBtn = document.getElementById("changePicBtn");
const profilePicInput = document.getElementById("profilePicInput");

// Load from localStorage if any previous data
window.addEventListener("load", () => {
  inputs.forEach((input) => {
    const savedValue = localStorage.getItem(input.id);
    if (savedValue) input.value = savedValue;
  });

  const savedPic = localStorage.getItem("profilePic");
  if (savedPic) profilePic.src = savedPic;
});

// Enable edit mode
editBtn.addEventListener("click", () => {
  inputs.forEach((input) => (input.disabled = false));
  editBtn.style.display = "none";
  saveBtn.style.display = "inline-block";
});

// Save changes
saveBtn.addEventListener("click", () => {
  inputs.forEach((input) => {
    input.disabled = true;
    localStorage.setItem(input.id, input.value);
  });

  editBtn.style.display = "inline-block";
  saveBtn.style.display = "none";
  alert("Profile saved!");
});

// Change profile picture
changePicBtn.addEventListener("click", () => profilePicInput.click());

profilePicInput.addEventListener("change", (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      profilePic.src = e.target.result;
      localStorage.setItem("profilePic", e.target.result);
    };
    reader.readAsDataURL(file);
  }
});
