document.addEventListener("DOMContentLoaded", function () {
    let listaCanciones = [];
    //MOSTRAR TODAS LAS CANCIONES
    fetch("/canciones") //solicita la ruta /canciones de cancionController
        .then(response => response.json()) //procesa la respuesta y la trata como JSON
        .then(canciones => {
            console.log(canciones);
            listaCanciones = canciones;
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


    const contenedor = document.getElementById("playlistList");
    const tituloCanciones = document.getElementById("tituloCanciones");

    //MOSTRAR TODAS LAS PLAYLIST
    fetch("/mostrarPlaylist")
        .then(response => response.json())
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

                //evento de clic en cada playlist
                document.querySelectorAll(".playlistItem").forEach(item => {
                    item.addEventListener("click", function () {
                        contenedor.innerHTML = "";
                        document.getElementById('h2Canciones').innerHTML = '';
                        document.getElementById('cancionesList').innerHTML = '';

                        const nombrePlaylist = item.getAttribute("data-nombre"); //obtener el nombre de la playlist clicada
                        console.log(nombrePlaylist);

                        tituloCanciones.innerHTML = `<h3>${nombrePlaylist}</h3>`;
                        tituloCanciones.style.color = "white";
                        tituloCanciones.style.fontSize = "40px";

                        const reproductor = document.getElementById('reproductor');
                        reproductor.style.visibility = 'visible';

                        //fetch sobre recoger todas las canciones de esa playlist
                        fetch(`/cancionesPlaylist/${nombrePlaylist}`)
                            .then(response => response.json())
                            .then(canciones => {
                                console.log(canciones);

                                if (canciones.length === 0) {
                                    contenedor.innerHTML = "<p>No hay canciones disponibles.</p>";
                                } else {
                                    //crear contenedor para las canciones
                                    const cancionesList = document.createElement("div");
                                    cancionesList.setAttribute("id", "cancionesList");

                                    canciones.forEach(cancion => {
                                        const article = document.createElement("article");
                                        article.classList.add("cancionItem");

                                        //que el titulo coincida con la busqueda
                                        const archivoNombre = cancion.titulo.replace(/\s+/g, '_').toLowerCase() + ".mp3"; //en formato mp3
                                        article.dataset.audio = `/music/${archivoNombre}`; //Ruta del MP3
                                        article.innerHTML = `
                                                <h3>${cancion.titulo}</h3>
                                                <p>Artista: ${cancion.autor}</p>
                                            `;
                                        cancionesList.appendChild(article);
                                    });

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

    //reproduce musica al clicar
    document.body.addEventListener("click", function (event) {
        let cancionSeleccionada = event.target;

        while (cancionSeleccionada && !cancionSeleccionada.classList.contains("cancionItem")) {
            cancionSeleccionada = cancionSeleccionada.parentElement;
        }

        if (cancionSeleccionada) {
            console.log("✅ Clic detectado en:", cancionSeleccionada);

            const audioSrc = cancionSeleccionada.dataset.audio;
            const nombreCancion = cancionSeleccionada.querySelector("h3")?.textContent;
            const nombreArtista = cancionSeleccionada.querySelector("p")?.textContent;

            const audioElement = document.getElementById("audioCancion");
            if (audioElement) {
                audioElement.src = audioSrc;
                document.getElementById("nombreCancion").textContent = nombreCancion;
                document.getElementById("nombreArtista").textContent = nombreArtista;

                audioElement.play().catch(error => console.error("❌ Error al reproducir:", error));
            } else {
                console.error("❌ No se encontró el elemento de audio.");
            }
        }
    });


    document.getElementById('iconoMusic').parentElement.addEventListener('click', () => {
        window.location.href = 'canciones.html';
    });

    document.getElementById('iconoPlaylist').parentElement.addEventListener('click', () => {
        window.location.href = 'playlist.html';
    });



    //dar evento al boton de buscar
    let inputBuscar = document.getElementById('buscarCancion');
    let btnBuscar = document.getElementById('btnBuscar');
    btnBuscar.addEventListener('click', () => {
        let textoBusqueda = inputBuscar.value.toLowerCase().trim();

        // Filtrar las canciones de la lista original
        let cancionesFiltradas = listaCanciones.filter(cancion =>
            cancion.titulo.toLowerCase().startsWith(textoBusqueda) //Busca si el título incluye el texto
        );

        // Mostrar las canciones filtradas en la consola
        console.log("Canciones filtradas:", cancionesFiltradas);

        //mostrarlas
        mostrarCanciones(cancionesFiltradas);
    });

    //Función para mostrar canciones
    function mostrarCanciones(canciones) {
        const contenedor = document.getElementById("cancionesList");
        contenedor.innerHTML = ""; // Limpiar resultados anteriores

        if (canciones.length === 0) {
            contenedor.innerHTML = "<p>No hay canciones disponibles.</p>";
        } else {
            canciones.forEach(cancion => {
                const article = document.createElement("article");
                article.classList.add("cancionItem");

                const archivoNombre = cancion.titulo.replace(/\s+/g, '_').toLowerCase() + ".mp3"; //Formato mp3
                article.dataset.audio = `/music/${archivoNombre}`; //Ruta del MP3
                article.innerHTML = `
                <h3>${cancion.titulo}</h3>
                <p>Artista: ${cancion.autor}</p>
            `;
                contenedor.appendChild(article);
            });
        }
    }






});
