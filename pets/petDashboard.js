

function loadPets(){

    const sortCheckbox = document.getElementById("sortAscending");
    const order = sortCheckbox && sortCheckbox.checked ? "asc" : "desc";
    fetch("getPets.php?order="+order).then((Response) => Response.json()).then((pets) => {

        const petsList = document.querySelector(".pets-list");
        petsList.innerHTML = "";

        if (pets.error === "not_logged_in") {
            petsList.innerHTML = "<p>You must be logged in to see your pets.</p>";
            return;
        }

        if (pets.length === 0) {
            petsList.innerHTML = "<p>You have no pets yet.</p>";
            return;
        }

        pets.forEach((pet) => {
            const div = document.createElement("div");
            div.className = "cat-card";

            div.innerHTML = `
            <div class="cat-info">
                <p><strong> Name: </strong>${pet.pet_name} </p>
                <p><strong> Age: </strong>${pet.age !== null ? `(${pet.age} yrs)` : "Unknown"}</p>
                <p><strong> Gender: </strong>${pet.gender !== "Unknown" ? ` ${pet.gender}` : "Unknown"}</p>
            </div>
            <button class="delete-cat-btn" data-id="${pet.cat_id}">Delete</button>
            
            `;

            const deleteBtn = div.querySelector(".delete-cat-btn");
            deleteBtn.addEventListener("click", () => deleteCat(pet.cat_id));



            petsList.appendChild(div);

        });



    }).catch((err) => console.error("Error loading pets:", err));



}

function deleteCat(catId) {
    if (!confirm("Are you sure you want to delete this pet?")) {
        return;
    }

    fetch("deletePet.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "cat_id=" + encodeURIComponent(catId),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                loadPets(); // reload list after delete
            } else {
                alert(data.message || "Failed to delete pet.");
            }
        })
        .catch((err) => {
            console.error("Error deleting pet:", err);
            alert("Error deleting pet.");
        });
}

function goToAddPet() {
    window.location.href = "addPet.html";
}


function goToCreateLog() {
    window.location.href = "../logs/createLog.html";
}

function loadLogs() {
    const logsList = document.getElementById("logsList");
    const logs = JSON.parse(localStorage.getItem("petLogs")) || [];
    logsList.innerHTML = "";

    logs.forEach((log, index) => {
        const div = document.createElement("div");
        div.className = "log-item";

        const textSpan = document.createElement("span");
        textSpan.textContent = log;

        const deleteBtn = document.createElement("button");
        deleteBtn.className = "delete-btn";
        deleteBtn.textContent = "âœ•";
        deleteBtn.onclick = () => deleteLog(index);

        div.appendChild(textSpan);
        div.appendChild(deleteBtn);
        logsList.appendChild(div);
    });
}

function deleteLog(index) {
    const logs = JSON.parse(localStorage.getItem("petLogs")) || [];
    logs.splice(index, 1);
    localStorage.setItem("petLogs", JSON.stringify(logs));
    loadLogs();
}

// Initialize logs on page load
window.addEventListener("DOMContentLoaded", () => {
    loadLogs();
    loadPets();

    const sortCheckbox = document.getElementById("sortAscending");
    if (sortCheckbox) {
        sortCheckbox.addEventListener("change", loadPets);
    }
});

