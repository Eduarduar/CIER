// Marcar enlace activo
document.querySelector('a[href="./actividades"]').classList.add('active');

// referencias a elementos DOM
const container_actividades = document.querySelector('.container-actividades');
const buttonAddImgs = document.querySelector('#text-file');
const inputImgs = document.querySelector('#media');
const inputText = document.querySelector('#titulo');
const buttonAgregar = document.querySelector('#agregarActividad .modal-footer button.btn.btn-primary');
const menuDesplegable = document.querySelector('#menuDesplegable');

// Función para crear el formato del DOM
const insertarActividad = function (titulo, fecha, carrusel, imagenes, usuarioC, usuarioA = '', fechaA = '',estado = '1') {
    let accion;
    if (estado == '1'){
        accion = 'actividad_activa';
    }else{
        accion = 'actividad_inactiva';
    }
    // Crear elementos del DOM
    let containerActividad = document.createElement('div');
    containerActividad.className = 'container-actividad';
    containerActividad.classList.add('contenido');
    containerActividad.setAttribute('data-actividad', `${carrusel}`);
    containerActividad.setAttribute('data-accion', `${accion}`);

    let card = document.createElement('div');
    card.className = 'card';
    card.setAttribute('data-actividad', `${carrusel}`);
    card.setAttribute('data-accion', `${accion}`);

    let cardBody = document.createElement('div');
    cardBody.className = 'card-body';
    cardBody.setAttribute('data-actividad', `${carrusel}`);
    cardBody.setAttribute('data-accion', `${accion}`);

    let cardTitle = document.createElement('h2');
    cardTitle.className = 'card-title';
    cardTitle.textContent = titulo;
    cardTitle.setAttribute('data-actividad', `${carrusel}`);
    cardTitle.setAttribute('data-accion', `${accion}`);

    let cardText = document.createElement('p');
    cardText.className = 'card-text';
    cardText.setAttribute('data-actividad', `${carrusel}`);
    cardText.setAttribute('data-accion', `${accion}`);
    
    let smallTextUsuario = document.createElement('small');
    let smallText = document.createElement('small');
    if (estado == 0){
        smallTextUsuario.className = 'text-body-secondary';
        smallTextUsuario.innerHTML = usuarioC + ' <br> [Eliminado por ' + usuarioA + '] <br>';
        smallText.className = 'text-body-secondary';
        smallText.innerHTML = fecha + ' - Eliminado[' + fechaA + ']';
    }else{
        smallTextUsuario.className = 'text-body-secondary';
        smallTextUsuario.innerHTML = usuarioC + '<br>';
        smallText.className = 'text-body-secondary';
        smallText.innerHTML = fecha;
    }
    smallTextUsuario.setAttribute('data-actividad', `${carrusel}`);
    smallTextUsuario.setAttribute('data-accion', `${accion}`);
    smallText.setAttribute('data-actividad', `${carrusel}`);
    smallText.setAttribute('data-accion', `${accion}`);

    let cardImgBottom = document.createElement('div');
    cardImgBottom.className = 'card-img-bottom';
    cardImgBottom.setAttribute('data-actividad', `${carrusel}`);
    cardImgBottom.setAttribute('data-accion', `${accion}`);

    let carruselDiv = document.createElement('div');
    carruselDiv.id = 'carrusel' + carrusel;
    carruselDiv.className = 'carousel slide';
    carruselDiv.setAttribute('data-actividad', `${carrusel}`);
    carruselDiv.setAttribute('data-accion', `${accion}`);

    let carouselIndicators = document.createElement('div');
    carouselIndicators.className = 'carousel-indicators';
    carouselIndicators.setAttribute('data-actividad', `${carrusel}`);
    carouselIndicators.setAttribute('data-accion', `${accion}`);

    let carouselInner = document.createElement('div');
    carouselInner.className = 'carousel-inner';
    carouselInner.setAttribute('data-actividad', `${carrusel}`);
    carouselInner.setAttribute('data-accion', `${accion}`);

    let carouselControlPrev = document.createElement('button');
    carouselControlPrev.type = 'button';
    carouselControlPrev.setAttribute('data-bs-target', '#carrusel' + carrusel);
    carouselControlPrev.setAttribute('data-bs-slide', 'prev');
    carouselControlPrev.className = 'carousel-control-prev';
    carouselControlPrev.setAttribute('data-actividad', `${carrusel}`);
    carouselControlPrev.setAttribute('data-accion', `${accion}`);

    let prevIconSpan = document.createElement('span');
    prevIconSpan.className = 'carousel-control-prev-icon';
    prevIconSpan.setAttribute('aria-hidden', 'true');
    prevIconSpan.setAttribute('data-actividad', `${carrusel}`);
    prevIconSpan.setAttribute('data-accion', `${accion}`);

    let prevSpan = document.createElement('span');
    prevSpan.className = 'visually-hidden';
    prevSpan.textContent = 'Previous';
    prevSpan.setAttribute('data-actividad', `${carrusel}`);
    prevSpan.setAttribute('data-accion', `${accion}`);

    let carouselControlNext = document.createElement('button');
    carouselControlNext.type = 'button';
    carouselControlNext.setAttribute('data-bs-target', '#carrusel' + carrusel);
    carouselControlNext.setAttribute('data-bs-slide', 'next');
    carouselControlNext.className = 'carousel-control-next';
    carouselControlNext.setAttribute('data-actividad', `${carrusel}`);
    carouselControlNext.setAttribute('data-accion', `${accion}`);

    let nextIconSpan = document.createElement('span');
    nextIconSpan.className = 'carousel-control-next-icon';
    nextIconSpan.setAttribute('aria-hidden', 'true');
    nextIconSpan.setAttribute('data-actividad', `${carrusel}`);
    nextIconSpan.setAttribute('data-accion', `${accion}`);

    let nextSpan = document.createElement('span');
    nextSpan.className = 'visually-hidden';
    nextSpan.textContent = 'Next';
    nextSpan.setAttribute('data-actividad', `${carrusel}`);
    nextSpan.setAttribute('data-accion', `${accion}`);

    // Construir la estructura del DOM para los botones de las imagenes
    imagenes.forEach(function(imagen, index) {
        let carouselItem = document.createElement('div');
        carouselItem.className = 'carousel-item';
        if (index === 0) {
            carouselItem.classList.add('active');
        }
        carouselItem.setAttribute('data-actividad', `${carrusel}`);
        carouselItem.setAttribute('data-accion', `${accion}`);

        let img = document.createElement('img');
        img.src = imagen;
        img.className = 'd-block w-100';
        img.setAttribute('data-actividad', `${carrusel}`);
        img.setAttribute('data-accion', `${accion}`);

        carouselItem.appendChild(img);
        carouselInner.appendChild(carouselItem);

        // Agregar botones al carrusel-indicators
        let indicatorButton = document.createElement('button');
        indicatorButton.setAttribute('data-actividad', `${carrusel}`);
        indicatorButton.setAttribute('data-accion', `${accion}`);
        indicatorButton.type = 'button';
        indicatorButton.setAttribute('data-bs-target', '#carrusel' + carrusel);
        indicatorButton.setAttribute('data-bs-slide-to', index.toString());
        if (index === 0) {
            indicatorButton.classList.add('active');
            indicatorButton.setAttribute('aria-current', 'true');
        }
        indicatorButton.setAttribute('aria-label', 'Slide ' + (index + 1).toString());
        carouselIndicators.appendChild(indicatorButton);
    });


    carouselControlPrev.appendChild(prevIconSpan);
    carouselControlPrev.appendChild(prevSpan);

    carouselControlNext.appendChild(nextIconSpan);
    carouselControlNext.appendChild(nextSpan);

    cardBody.appendChild(cardTitle);
    cardText.appendChild(smallTextUsuario);
    cardText.appendChild(smallText);
    cardBody.appendChild(cardText);
    cardImgBottom.appendChild(carruselDiv);

    carruselDiv.appendChild(carouselIndicators);
    carruselDiv.appendChild(carouselInner);
    carruselDiv.appendChild(carouselControlPrev);
    carruselDiv.appendChild(carouselControlNext);

    card.appendChild(cardBody);
    card.appendChild(cardImgBottom);

    containerActividad.appendChild(card);
    container_actividades.prepend(containerActividad);
    containerActividad.addEventListener('contextmenu', (e) => {
        activarMenuDesplegable(e);
    });  
}


buttonAddImgs.addEventListener('click', () => {
    inputImgs.click();
});

function validateFileExtension(file, allowedExtensions) {
    const fileName = file.name.toLowerCase();
    const fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
    return allowedExtensions.includes(fileExtension);
}  

inputImgs.addEventListener('change', (e) => {
    const files = Array.from(e.target.files); // Convertir la colección de archivos en un array
    try {
        for (const file of files) {
            if (!validateFileExtension(file, ['webp', 'png', 'jpg', 'jpeg'])) {
                alert('Solo se aceptan los formatos webp, png, jpg y jpeg.');
                inputImgs.value = ''; // Limpiar el valor del input
                return; // Detener la ejecución si un archivo no es válido
            }
        }
    } catch (error) {
        inputImgs.value = ''; // Limpiar el valor del input en caso de error
    }
});

buttonAgregar.addEventListener('click', () => {
    if (inputText.value != ''){
        if (inputImgs.value != ''){
            const formData = new FormData();
            formData.append('titulo', inputText.value);
            for (var i = 0; i < inputImgs.files.length; i++) {
                formData.append('imgs[]', inputImgs.files[i]);
            }
            formData.append('id_user', id_user);
            $.ajax({
                url: '../db/consultas_actividades.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (respuesta) {
                if (respuesta.code === '0') {
                    // La operación en el servidor fue exitosa
                    let imagenes = respuesta.datos.imagenes.split(',');
                    insertarActividad(respuesta.datos.titulo, respuesta.datos.fecha, respuesta.datos.carrusel, imagenes, respuesta.datos.usuarioC);
                    inputText.value = '';
                    inputImgs.value = '';
                    document.querySelector('#agregarActividad .modal-footer button.btn.btn-secondary').click();
                } else {
                    // La operación en el servidor no fue exitosa
                    alert(respuesta.message);
                }
                },
                error: function (error) {
                // Manejar errores en la solicitud AJAX
                console.log('Error en la solicitud AJAX:', error.responseText);
            }
        });
        }else{
            alert('La actividad debe tener al menos una imagen');
        }
    }else{
        alert('La actividad debe tener un titulo');
    }
});

const activarMenuDesplegable = function (e) {
    e.preventDefault();
    menuDesplegable.innerHTML = '<ul></ul>';
        let ul = document.querySelector('#menuDesplegable ul');

        // Crear elementos li
        let liEstado = document.createElement('li');
        
        // Agregar texto a los elementos li
        if (e.target.dataset.accion == 'actividad_activa'){
            liEstado.textContent = 'Eliminar Actividad';
        }else{
            liEstado.textContent = 'Reactivar Actividad';
        }
        liEstado.setAttribute('data-actividad',`${e.target.dataset.actividad}`);
        // Agregar elementos li a la lista
        ul.appendChild(liEstado);

        liEstado.addEventListener('click', (e2) => {
            const formData = new FormData();
            if (e.target.dataset.accion == 'actividad_activa'){
                formData.append('actividad', 'eliminar');
            }else{
                formData.append('actividad', 'activar');
            }
            formData.append('actividad_id', e.target.dataset.actividad);
            formData.append('id_user', id_user);
            $.ajax({
                url: '../db/consultas_actividades.php',
                type: 'POST',
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    if (respuesta.code === '0') {
                        let actividad = e.target;
                        do {
                            if (actividad.classList.contains('contenido')){
                                actividades = actividad.parentNode;
                                break;
                            }
                            actividad = actividad.parentNode;
                        } while (true);
                        actividades.removeChild(actividad);
                    } else {
                        // La operación en el servidor no fue exitosa
                        alert(respuesta.message);
                    }
                },
                error: function (error) {
                    // Manejar errores en la solicitud AJAX
                    console.log('Error en la solicitud AJAX:', error.responseText);
            }});
        });
    menuDesplegable.style.display = 'block';
    menuDesplegable.style.left = e.pageX + 'px';
    menuDesplegable.style.top = e.pageY + 'px';
}

const showActividadesActivas = (e) => {
    const containerActividades = document.querySelector('.container-actividades');
    const formData = new FormData();
    formData.append('actividades', 'activas');
    $.ajax({
        url: '../db/consultas_actividades.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (respuesta) {
        if (respuesta.code === '0') {
            containerActividades.innerHTML = '';
            respuesta.datos.forEach((actividad) => {
                let imagenes = actividad.imagenes.split(',');
                insertarActividad(actividad.titulo, actividad.fecha, actividad.carrusel, imagenes, actividad.usuarioC);
            });
            let boton = document.querySelector(' .container-buttons button.btn-outline-success');
            let boton2 = document.querySelector('.container-buttons button.btn-outline-danger');
            let boton3 = document.querySelector('.container-buttons button.btn-primary');
            boton.setAttribute('style','display:none');
            boton2.removeAttribute('style');
            boton3.removeAttribute('disabled');
        } else {
            // La operación en el servidor no fue exitosa
            alert(respuesta.menssaje);
        }
        },
        error: function (error) {
        // Manejar errores en la solicitud AJAX
        console.log('Error en la solicitud AJAX:', error.responseText);
        }
    });
}

const showActividadesEliminadas = function () {
    const containerActividades = document.querySelector('.container-actividades');
    const formData = new FormData();
    formData.append('actividades', 'eliminadas');
    $.ajax({
        url: '../db/consultas_actividades.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta.code === '0') {
            containerActividades.innerHTML = '';
            respuesta.datos.forEach((actividad) => {
                let imagenes = actividad.imagenes.split(',');
                insertarActividad(actividad.titulo, actividad.fecha, actividad.carrusel, imagenes, actividad.usuarioC, actividad.usuarioA, actividad.fechaA, actividad.estado);
            });
            let boton = document.querySelector(' .container-buttons button.btn-outline-success');
            let boton2 = document.querySelector('.container-buttons button.btn-outline-danger');
            let boton3 = document.querySelector('.container-buttons button.btn-primary');
            boton2.setAttribute('style','display:none');
            boton.removeAttribute('style');
            boton3.setAttribute('disabled','true');
          } else {
            // La operación en el servidor no fue exitosa
            alert(respuesta.menssaje);
          }
        },
        error: function (error) {
          // Manejar errores en la solicitud AJAX
          console.log('Error en la solicitud AJAX:', error.responseText);
        }
      });
}

const activarEscuchadoresMenuDesplegable = function() {
    let contenido = document.querySelectorAll('.contenido');
    contenido.forEach((element) => {
        element.addEventListener('contextmenu', (e) => {
            activarMenuDesplegable(e);
        });  
    });
}
document.addEventListener('click', function() {
    menuDesplegable.style.display = 'none';
    menuDesplegable.innerHTML = '<ul></ul>';
});

activarEscuchadoresMenuDesplegable();
document.querySelector('.container-buttons button.btn-outline-danger').addEventListener('click',  showActividadesEliminadas);
document.querySelector('.container-buttons button.btn-outline-success').addEventListener('click', showActividadesActivas);