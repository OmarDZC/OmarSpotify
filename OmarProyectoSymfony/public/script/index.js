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
        document.getElementById("playlistList").addEventListener("click", function (event) {
            let cancionSeleccionada = event.target;
            while (cancionSeleccionada && !cancionSeleccionada.classList.contains("cancionItem")) {
                cancionSeleccionada = cancionSeleccionada.parentElement;
            }
            if (cancionSeleccionada) {
                const audioSrc = cancionSeleccionada.dataset.audio;
                const nombreCancion = cancionSeleccionada.querySelector("h3").textContent;
                const nombreArtista = cancionSeleccionada.querySelector("p").textContent;
    
                //footer
                document.getElementById("audioCancion").src = audioSrc;
                document.getElementById("nombreCancion").textContent = nombreCancion;
                document.getElementById("nombreArtista").textContent = nombreArtista;
                document.getElementById("audioCancion").style.visibility = "visible";
                document.getElementById("reproductor").style.visibility = "visible";
    
                //reproducri
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
