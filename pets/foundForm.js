const fileInput = document.getElementById('foundPhoto');
    const preview = document.getElementById('photoPreview');

    fileInput.addEventListener('change', () => {
      const file = fileInput.files?.[0];
      if (!file) { preview.style.display = 'none'; preview.src = ''; return; }
      const r = new FileReader();
      r.onload = () => { preview.src = r.result; preview.style.display = 'block'; };
      r.readAsDataURL(file);
    });


    document.getElementById("foundForm").addEventListener("submit", async (e) => {
      e.preventDefault();

      const file = fileInput.files?.[0] || null;

        const imageData = file ? await fileToDataURLCompressed(file, 800) : null;

      const entry = {
        description: document.getElementById("catDesc").value.trim(),
        location: document.getElementById("foundLoc").value.trim(),
        contact: document.getElementById("finderContact").value.trim(),
        date: new Date().toISOString(),
        imageData
      };

      const found = JSON.parse(localStorage.getItem("foundCats")) || [];
      found.push(entry);
      localStorage.setItem("foundCats", JSON.stringify(found));

      alert("Found cat reported. Thank you!");
      e.target.reset();
      preview.style.display = 'none';
      preview.src = '';
     

    });

     function fileToDataURL(file) {
      return new Promise((resolve, reject) => {
        const r = new FileReader();
        r.onload = () => resolve(r.result);
        r.onerror = reject;
        r.readAsDataURL(file);
      });
    }

    async function fileToDataURLCompressed(file, maxW = 800) {
      const bmp = await createImageBitmap(file);
      const scale = Math.min(1, maxW / bmp.width);
      const w = Math.round(bmp.width * scale);
      const h = Math.round(bmp.height * scale);

      const canvas = document.createElement('canvas');
      canvas.width = w; canvas.height = h;
      const ctx = canvas.getContext('2d');
      ctx.drawImage(bmp, 0, 0, w, h);

      // JPEG with quality ~0.8 to keep size down
      return canvas.toDataURL('image/jpeg', 0.8);
    }