// Marcar enlace activo
document.querySelector('a[href="./actividades"]').classList.add('active');

// referencias a elementos DOM
const container_actividades = document.querySelector('.container-actividades');
const buttonAddImgs = document.querySelector('#text-file');
const inputImgs = document.querySelector('#media');
const inputText = document.querySelector('#titulo');
const buttonAgregar = document.querySelector('#agregarActividad .modal-footer button.btn.btn-primary');

// Función para crear el formato del DOM
function insertarActividad(titulo, fecha, carrusel, imagenes, usuarioC, usuarioA = '', fechaA = '',estado = '1') {
    // Crear elementos del DOM
    let containerActividades = document.createElement('div');
    containerActividades.className = 'container-actividades';

    let containerActividad = document.createElement('div');
    containerActividad.className = 'container-actividad';

    let card = document.createElement('div');
    card.className = 'card';

    let cardBody = document.createElement('div');
    cardBody.className = 'card-body';

    let cardTitle = document.createElement('h2');
    cardTitle.className = 'card-title';
    cardTitle.textContent = titulo;

    let cardText = document.createElement('p');
    cardText.className = 'card-text';
    
    let smallTextUsuario = document.createElement('small');
    let smallText = document.createElement('small');
    if (estado == 0){
        smallTextUsuario.className = 'text-body-secondary';
        smallTextUsuario.innerHTML = usuarioC + ' <br> [Eliminado por ' + usuarioA + '] <br>';
        smallText.className = 'text-body-secondary';
        smallText.innerHTML = fecha + 'Eliminado[' + fechaA + ']';
    }else{
        smallTextUsuario.className = 'text-body-secondary';
        smallTextUsuario.innerHTML = usuarioC + '<br>';
        smallText.className = 'text-body-secondary';
        smallText.innerHTML = fecha;
    }

    let cardImgBottom = document.createElement('div');
    cardImgBottom.className = 'card-img-bottom';

    let carruselDiv = document.createElement('div');
    carruselDiv.id = carrusel;
    carruselDiv.className = 'carousel slide';

    let carouselIndicators = document.createElement('div');
    carouselIndicators.className = 'carousel-indicators';

    let carouselInner = document.createElement('div');
    carouselInner.className = 'carousel-inner';

    let carouselControlPrev = document.createElement('button');
    carouselControlPrev.type = 'button';
    carouselControlPrev.setAttribute('data-bs-target', '#' + carrusel);
    carouselControlPrev.setAttribute('data-bs-slide', 'prev');
    carouselControlPrev.className = 'carousel-control-prev';

    let prevIconSpan = document.createElement('span');
    prevIconSpan.className = 'carousel-control-prev-icon';
    prevIconSpan.setAttribute('aria-hidden', 'true');

    let prevSpan = document.createElement('span');
    prevSpan.className = 'visually-hidden';
    prevSpan.textContent = 'Previous';

    let carouselControlNext = document.createElement('button');
    carouselControlNext.type = 'button';
    carouselControlNext.setAttribute('data-bs-target', '#' + carrusel);
    carouselControlNext.setAttribute('data-bs-slide', 'next');
    carouselControlNext.className = 'carousel-control-next';

    let nextIconSpan = document.createElement('span');
    nextIconSpan.className = 'carousel-control-next-icon';
    nextIconSpan.setAttribute('aria-hidden', 'true');

    let nextSpan = document.createElement('span');
    nextSpan.className = 'visually-hidden';
    nextSpan.textContent = 'Next';

    // Construir la estructura del DOM para los botones de las imagenes
    imagenes.forEach(function(imagen, index) {
        let carouselItem = document.createElement('div');
        carouselItem.className = 'carousel-item';
        if (index === 0) {
            carouselItem.classList.add('active');
        }

        let img = document.createElement('img');
        img.src = imagen;
        img.className = 'd-block w-100';

        carouselItem.appendChild(img);
        carouselInner.appendChild(carouselItem);

        // Agregar botones al carrusel-indicators
        let indicatorButton = document.createElement('button');
        indicatorButton.type = 'button';
        indicatorButton.setAttribute('data-bs-target', '#' + carrusel);
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