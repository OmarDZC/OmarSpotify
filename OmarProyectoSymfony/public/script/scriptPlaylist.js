document.addEventListener("DOMContentLoaded", function () {
    const contenedor = document.getElementById("playlistList");
    const tituloCanciones = document.getElementById("tituloCanciones"); // Asegúrate de que existe en el HTML y está fuera de #playlistList

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

                    // Agregamos un atributo con el nombre de la playlist para identificarla
                    article.setAttribute("data-nombre", playlist.nombre);

                    article.innerHTML = `
                        <h3>${playlist.nombre}</h3>
                        <p>Propietario: ${playlist.propietario ? playlist.propietario : "Desconocido"}</p>
                    `;

                    contenedor.appendChild(article);
                });

                // Evento para cuando se haga clic en una playlist
                document.querySelectorAll(".playlistItem").forEach(item => {
                    item.addEventListener("click", function () {
                        contenedor.innerHTML = "";

                        const nombrePlaylist = item.getAttribute("data-nombre"); // Obtiene el nombre de la playlist clicada
                        console.log(nombrePlaylist);

                        tituloCanciones.innerHTML = `<h3>${nombrePlaylist}</h3>`;
                        tituloCanciones.style.color = "white";
                        tituloCanciones.style.fontSize = "40px";
                        // Hacer visible el reproductor
                        const reproductor = document.getElementById('reproductor');
                        reproductor.style.visibility = 'visible';

                        fetch(`/cancionesPlaylist/${nombrePlaylist}`)
                            .then(response => response.json())
                            .then(canciones => {
                                console.log(canciones);

                                if (canciones.length === 0) {
                                    contenedor.innerHTML = "<p>No hay canciones disponibles.</p>";
                                } else {
                                    // Crear un contenedor para las canciones dentro de la playlist seleccionada
                                    const cancionesList = document.createElement("div");
                                    cancionesList.setAttribute("id", "cancionesList");

                                    canciones.forEach(cancion => {
                                        const article = document.createElement("article");
                                        article.classList.add("cancionItem");

                                        // Que el título coincida con el archivo
                                        const archivoNombre = cancion.titulo.replace(/\s+/g, '_').toLowerCase() + ".mp3"; // En formato mp3
                                        article.dataset.audio = `/music/${archivoNombre}`; // Ruta del MP3
                                        article.innerHTML = `
                                            <h3>${cancion.titulo}</h3>
                                            <p>Artista: ${cancion.autor}</p>
                                        `;
                                        cancionesList.appendChild(article);
                                    });

                                    // Asegúrate de que el contenedor de canciones se agregue a la pantalla
                                    contenedor.appendChild(cancionesList);
                                }

                            })
                    });
                });
            }
        })
        .catch(error => {
            console.error("Error al cargar las playlists:", error);
        });

    // Reproduce música al clicar la canción correspondiente
    document.getElementById("playlistList").addEventListener("click", function (event) {
        let cancionSeleccionada = event.target; // Elemento exacto que se clicó
        while (cancionSeleccionada && !cancionSeleccionada.classList.contains("cancionItem")) {
            cancionSeleccionada = cancionSeleccionada.parentElement;
        }
        if (cancionSeleccionada) {
            const audioSrc = cancionSeleccionada.dataset.audio;
            const nombreCancion = cancionSeleccionada.querySelector("h3").textContent;
            const nombreArtista = cancionSeleccionada.querySelector("p").textContent;

            // Actualizar el footer reproductor
            document.getElementById("audioCancion").src = audioSrc;
            document.getElementById("nombreCancion").textContent = nombreCancion;
            document.getElementById("nombreArtista").textContent = nombreArtista;
            document.getElementById("audioCancion").style.visibility = "visible";
            document.getElementById("reproductor").style.visibility = "visible";

            // Reproducir la canción
            document.getElementById("audioCancion").play();
        }
    });
});
