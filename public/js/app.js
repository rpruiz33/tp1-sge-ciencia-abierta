document.getElementById("form").addEventListener("submit", async (e) => {
    e.preventDefault();

    const doi = document.getElementById("doi").value;
    const resDiv = document.getElementById("resultado");

    resDiv.innerHTML = "Cargando...";

    try {
        const res = await fetch("../backend/api.php?doi=" + encodeURIComponent(doi));
        const data = await res.json();

        if (data.error) {
            resDiv.innerHTML = "<p>Error al obtener datos</p>";
            return;
        }

        let html = `
        <div class="card">
            <h2>${data.title} (${data.year})</h2>
            <p><strong>Revista:</strong> ${data.journal}</p>

            <div class="metric-box">
                <div class="metric">
                    <div class="number">${data.cited_by_count}</div>
                    <div>Citas</div>
                </div>

                <div class="metric">
                    <div class="number">${data.type}</div>
                    <div>Tipo</div>
                </div>

                <div class="metric">
                    <div class="number">${data.referenced_works_count}</div>
                    <div>Referencias</div>
                </div>

                <div class="metric">
                    <div class="number">${data.open_access ? 'Sí' : 'No'}</div>
                    <div>Open Access</div>
                </div>

                <div class="metric">
                    <div class="number">${data.oa_type}</div>
                    <div>Tipo OA</div>
                </div>
            </div>

            <h3>Autores</h3>
            <p>${data.authors.join(", ")}</p>

            <h3>Distribución por tipo</h3>
        `;

        if (data.sources.length > 0) {
            html += "<ul>";
            data.sources.forEach(s => {
                html += `<li>${s.type} → ${s.count}</li>`;
            });
            html += "</ul>";
        } else {
            html += "<p>No hay datos disponibles</p>";
        }

        html += "</div>";

        resDiv.innerHTML = html;

    } catch (err) {
        resDiv.innerHTML = "<p>Error de conexión</p>";
    }
});