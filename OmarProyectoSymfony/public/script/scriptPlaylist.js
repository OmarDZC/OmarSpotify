document.addEventListener("DOMContentLoaded", function () {
    //MOSTRAR TODAS LAS PLAYLIST
    fetch("/mostrarPlaylist")
        .then(response => response.json()) //procesar como JSON
        .then(playlists => {
            console.log(playlists);
            const contenedor = document.getElementById("playlistList");
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
    const playlistList = document.getElementById("playlistList");
    playlistList.addEventListener("click", cancionesPlaylist);

    function cancionesPlaylist() {
        window.location.href = "cancionesPlaylist.html"; 
    }

    fetch("/playlistCancion/buscar")
        .then(response => response.json())
        .then(playlist => {
            console.log(playlist);
        })




});