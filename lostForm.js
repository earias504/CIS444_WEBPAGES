


 async function fileToDataURLCompressed(file, maxW = 800) {
                const bitmap = await createImageBitmap(file);
                const scale = Math.min(1, maxW / bitmap.width);
                const w = Math.round(bitmap.width * scale);
                const h = Math.round(bitmap.height * scale);

                const canvas = document.createElement('canvas');
                canvas.width = w; canvas.height = h;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(bitmap, 0, 0, w, h);

                // quality: 0.8 works well for JPEG
                return canvas.toDataURL('image/jpeg', 0.8);
            }



            const fileInput = document.getElementById('petPhoto');
            const preview   = document.getElementById('photoPreview');
            
            
            
            fileInput.addEventListener('change', () => {
                const file = fileInput.files?.[0];
                if (!file) { preview.style.display = 'none'; return; }
                const reader = new FileReader();
                reader.onload = () => { preview.src = reader.result; preview.style.display = 'block'; };
                reader.readAsDataURL(file);
            });

            document.getElementById("lostForm").addEventListener("submit", async (e) => {
                e.preventDefault(); // stop page reload
                

                const file = fileInput.files?.[0];
                const imageData = file ? await fileToDataURLCompressed(file) : null;
                
                const cat = {
                    name: document.getElementById("petType").value,
                    description: document.getElementById("description").value,
                    location: document.getElementById("location").value,
                    contactInfo: document.getElementById("contactInfo").value,
                    date: new Date().toLocaleString(),
                    imageData // Data URL or null
                }
                
                const cats = JSON.parse(localStorage.getItem("cats")) || [];
                cats.push(cat);
                localStorage.setItem("cats", JSON.stringify(cats));
                alert("Cat added successfully!");
                this.reset(); // clear form
                e.target.reset();
            });

            function fileToDataURL(file) {
                // (Basic) Convert to DataURL. For better UX, see the compression option below.
                return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload  = () => resolve(reader.result);
                reader.onerror = reject;
                reader.readAsDataURL(file);
                });
            }