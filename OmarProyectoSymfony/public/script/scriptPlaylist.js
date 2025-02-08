//MOSTRAR TODAS LAS PLAYLIST
fetch("/mostrarPlaylist") 
.then(response => response.json()) // Procesa la respuesta como JSON
.then(playlists => {
    console.log(playlists);
    console.log(playlists);
    const contenedor = document.getElementById("playlistList");
    contenedor.innerHTML = ""; // Limpia contenido previo

    if (playlists.length === 0) {
        contenedor.innerHTML = "<p>No hay playlists disponibles.</p>";
    } else {
        playlists.forEach(playlist => {
            const article = document.createElement("article");
            article.classList.add("playlistItem");

            article.innerHTML = `
                <h3>${playlist.nombre}</h3>
                <p>Propietario: ${playlist.propietario ? playlist.propietario : "Desconocido"}</p>
            `;

            contenedor.appendChild(article);
        });
    }
})
.catch(error => {
    console.error("Error al cargar las playlists:", error);
});