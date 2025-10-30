function renderCats() {
            const cats = JSON.parse(localStorage.getItem("cats")) || [];
            const listDiv = document.getElementById("lostCatsList");

            if (!cats.length) {
                listDiv.innerHTML = "<p>No lost pets reported yet 🐾</p>";
                return;
            }

            listDiv.innerHTML = cats.map((c, i) => `
      <div class="cat-card">
         ${c.imageData ? `<img src="${c.imageData}" alt="Photo of ${c.petType}" style="max-width:220px; display:block; margin-bottom:8px;"/>` : ""}
        <h3>${c.name}</h3>
        <p><strong>Description:</strong> ${c.description}</p>
        <p><strong>Last seen:</strong> ${c.location}</p>
        <p><strong>Contact:</strong> ${c.contactInfo}</p>
        <p><small>Reported: ${c.date}</small></p>
        <button onclick="deleteCat(${i})">Delete</button>
      </div>
    `).join("");
        }

        function deleteCat(index) {
            const cats = JSON.parse(localStorage.getItem("cats")) || [];
            cats.splice(index, 1); // remove 1 cat at this index
            localStorage.setItem("cats", JSON.stringify(cats));
            renderCats(); // re-render the list
        }

        // Load instantly when page opens
        window.addEventListener("DOMContentLoaded", renderCats);