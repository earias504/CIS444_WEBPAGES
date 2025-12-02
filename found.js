function renderFound() {
      const found = JSON.parse(localStorage.getItem("foundCats")) || [];
      const list = document.getElementById("foundList");

      if (!found.length) {
        list.innerHTML = "<p>No found cats reported yet</p>";
        return;
      }

      list.innerHTML = found.map((f, i) => `
        <div class="cat-card">
            ${f.imageData ? `<img src="${f.imageData}" alt="Photo of found cat" style="max-width:220px; display:block; margin-bottom:8px;"/>` : ""}
          <h3>Found Cat</h3>
          <p><strong>Description:</strong> ${f.description}</p>
          <p><strong>Location:</strong> ${f.location}</p>
          <p><strong>Finder contact:</strong> ${f.contact}</p>
          <p><small>Reported: ${new Date(f.date).toLocaleString()}</small></p>
          <button class="tile" onclick="markReunited(${i})">Mark reunited</button>
          <button class="tile" onclick="deleteFound(${i})">Delete</button>
        </div>
      `).join("");
    }

    function deleteFound(index) {
      const found = JSON.parse(localStorage.getItem("foundCats")) || [];
      found.splice(index, 1);
      localStorage.setItem("foundCats", JSON.stringify(found));
      renderFound();
    }

    // Optional: move to a separate "reunited" list
    function markReunited(index) {
      const found = JSON.parse(localStorage.getItem("foundCats")) || [];
      const reunited = JSON.parse(localStorage.getItem("reunitedCats")) || [];
      reunited.push({ ...found[index], reunitedOn: new Date().toISOString() });
      localStorage.setItem("reunitedCats", JSON.stringify(reunited));
      found.splice(index, 1);
      localStorage.setItem("foundCats", JSON.stringify(found));
      renderFound();
      alert("Marked as reunited 🎉");
    }

    window.addEventListener("DOMContentLoaded", renderFound);