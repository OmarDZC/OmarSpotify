document.addEventListener("DOMContentLoaded", function () {
    const contenedor = document.getElementById("playlistList");

    // MOSTRAR TODAS LAS PLAYLIST
    fetch("/mostrarPlaylist")
        .then(response => response.json()) // Procesar como JSON
        .then(playlists => {
            console.log(playlists);
            contenedor.innerHTML = "";

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

    //evento para la pulsar en playlist y nos lleve a otra pag y saque las canciones de dicha playlist
    contenedor.addEventListener("click", cancionesPlaylist);

    function cancionesPlaylist() {
        window.location.href = "cancionesPlaylist.html";
    }

    












});