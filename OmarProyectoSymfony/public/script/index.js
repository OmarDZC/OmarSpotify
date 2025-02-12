document.addEventListener("DOMContentLoaded", function () {
    //MOSTRAR TODAS LAS CANCIONES
    fetch("/canciones") //solicita la ruta /canciones de cancionController
        .then(response => response.json()) //procesa la respuesta y la trata como JSON
        .then(canciones => {
            console.log(canciones);
            const contenedor = document.getElementById("cancionesList");
            contenedor.innerHTML = "";

            if (canciones.length === 0) {
                contenedor.innerHTML = "<p>No hay canciones disponibles.</p>";
            } else {
                canciones.forEach(cancion => {
                    const article = document.createElement("article");
                    article.classList.add("cancionItem");

                    //que el titulo coincida con el archivo
                    const archivoNombre = cancion.titulo.replace(/\s+/g, '_').toLowerCase() + ".mp3"; //en formato mp3
                    article.dataset.audio = `/music/${archivoNombre}`; //ruta del MP3
                    article.innerHTML = `
                        <h3>${cancion.titulo}</h3>
                        <p>Artista: ${cancion.autor}</p>
                    `;
                    contenedor.appendChild(article);
                });
            }

        })
        .catch(error => {
            console.error("Error al cargar las canciones:", error);
        });


    // MOSTRAR TODAS LAS PLAYLIST
    fetch("/mostrarPlaylist")
        .then(response => response.json()) // Procesar como JSON
        .then(playlists => {
            const contenedor = document.getElementById("playlistList");
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


    //reproduce musica al clicar la cancion correspondiente
    document.getElementById("cancionesList").addEventListener("click", function (event) {
        let cancionSeleccionada = event.target;
        while (cancionSeleccionada && !cancionSeleccionada.classList.contains("cancionItem")) {
            cancionSeleccionada = cancionSeleccionada.parentElement;
        }
        if (cancionSeleccionada) {
            const audioSrc = cancionSeleccionada.dataset.audio;
            const nombreCancion = cancionSeleccionada.querySelector("h3").textContent;
            const nombreArtista = cancionSeleccionada.querySelector("p").textContent;

            //actualizar el footer reproductor
            document.getElementById("audioCancion").src = audioSrc;
            document.getElementById("nombreCancion").textContent = nombreCancion;
            document.getElementById("nombreArtista").textContent = nombreArtista;
            document.getElementById("audioCancion").style.visibility = "visible";
            document.getElementById("reproductor").style.visibility = "visible";

            //reproduce la cancion
            document.getElementById("audioCancion").play();
        }
    });

    document.getElementById('iconoMusic').parentElement.addEventListener('click', () => {
        window.location.href = 'canciones.html';
    });

    document.getElementById('iconoPlaylist').parentElement.addEventListener('click', () => {
        window.location.href = 'playlist.html';
    });




});
