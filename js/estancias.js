// Marcar enlace activo
document.querySelector('a[href="./estancias"]').classList.add('active');

// referencias DOM
const contenedorEstancias = document.querySelector('.container-estancias');
const inputs = document.querySelectorAll('input');
const buttonAgregar = document.querySelector('#agregarEstancia .modal-footer button.btn.btn-primary');
const inputNombre = document.querySelector('input#nombre');
const inputProveniencia = document.querySelector('input#proveniencia');
const inputFecha = document.querySelector('input#fecha');
const inputProyecto = document.querySelector('input#proyecto');
const inputInstalaciones = document.querySelector('input#instalaciones');
const inputLinks = document.querySelector('input#links');
const selectTipo = document.querySelector('select#tipo');
const inputImgs = document.querySelector('input#media');
const buttonAddImgs = document.querySelector('#text-file');

// encuentra todos los links de youtube en un texto
const encontrarEnlacesYouTubeYFacebook = function (texto) {
  const regex = /(https?:\/\/(?:www\.)?youtube\.com\/(?:watch\?v=|embed\/|v\/)?[\w-]+|https?:\/\/youtu\.be\/[\w-]+|https:\/\/www\.facebook\.com\/plugins\/video\.php\?height=\d+&href=https%3A%2F%2Fwww\.facebook\.com%2F[\w-]+%2Fvideos%2F\d+%2F&show_text=\w+&width=\d+&t=\d+)/gi;
  const matches = texto.match(regex);

  if (matches) {
    return matches;
  } else {
    return [];
  }
}

const eliminarEnlaces = function (texto) {
  const regex = /(https?:\/\/(?:www\.)?youtube\.com\/(?:watch\?v=|embed\/|v\/)?[\w-]+|https?:\/\/youtu\.be\/[\w-]+|https:\/\/www\.facebook\.com\/plugins\/video\.php\?height=\d+&href=https%3A%2F%2Fwww\.facebook\.com%2F[\w-]+%2Fvideos%2F\d+%2F&show_text=\w+&width=\d+&t=\d+)/gi;
  const textoSinEnlaces = texto.replace(regex, '');

  return textoSinEnlaces;
}

const obtenerEnlaceRedSocial = function (enlace) {
  const regexYouTube = /(https?:\/\/(?:www\.)?youtube\.com\/(?:watch\?v=|embed\/|v\/)?[\w-]+|https?:\/\/youtu\.be\/[\w-]+)/i;
  
  if (regexYouTube.test(enlace)) {
    return obtenerURLEmbed(enlace);
  } else {
    return enlace;
  }
}

const verificarFacebook = function (enlace) {
  const regexYouTube = /(https?:\/\/(?:www\.)?youtube\.com\/(?:watch\?v=|embed\/|v\/)?[\w-]+|https?:\/\/youtu\.be\/[\w-]+)/i;
  
  if (regexYouTube.test(enlace)) {
    return false;
  } else {
    return true;
  }
}

function obtenerURLEmbed(url) {
  let videoId = '';
  let playlistId = '';

  // Comprobar si el enlace está en el formato "https://www.youtube.com/watch?v=VIDEO_ID"
  if (url.includes('youtube.com/watch?v=')) {
    const params = new URLSearchParams(new URL(url).search);
    videoId = params.get('v');
  }
  // Comprobar si el enlace está en el formato "https://youtu.be/VIDEO_ID"
  else if (url.includes('youtu.be/')) {
    videoId = url.split('youtu.be/')[1];
  }
  // Comprobar si el enlace está en el formato "https://www.youtube.com/v/VIDEO_ID"
  else if (url.includes('youtube.com/v/')) {
    videoId = url.split('youtube.com/v/')[1];
  }
  // Comprobar si el enlace está en el formato "https://www.youtube.com/embed/VIDEO_ID?list=PLAYLIST_ID"
  else if (url.includes('youtube.com/embed/') && url.includes('?list=')) {
    const urlParts = url.split('?');
    videoId = urlParts[0].split('youtube.com/embed/')[1];
    const params = new URLSearchParams(urlParts[1]);
    playlistId = params.get('list');
  }
  // Comprobar si el enlace está en el formato "https://www.youtube.com/embed/videoseries?list=PLAYLIST_ID"
  else if (url.includes('youtube.com/embed/videoseries?list=')) {
    playlistId = url.split('youtube.com/embed/videoseries?list=')[1];
  }
  // Comprobar si el enlace está en el formato "https://www.youtube.com/embed/VIDEO_ID"
  else if (url.includes('youtube.com/embed/')) {
    videoId = url.split('youtube.com/embed/')[1];
  }

  // Comprobar si se obtuvo el ID del video
  if (videoId) {
    return `https://www.youtube.com/embed/${videoId}${playlistId ? `?list=${playlistId}` : ''}`;
  } else {
    // Si el enlace no coincide con ninguno de los formatos esperados, retorna null o un valor predeterminado según tus necesidades
    return null;
  }
}


const crearEstancia = function(datos) {
  let imagenes = datos.imagenes.split(',');
  let links = encontrarEnlacesYouTubeYFacebook(datos.links);
  let stringEstado;
  if (datos.estado == 1){
    stringEstado = 'estancia_activa';
  }else{
    stringEstado = 'estancia_inactiva'
  }
  // Crear el elemento contenedor principal
  const containerEstancia = document.createElement('div');
  containerEstancia.classList.add('card', 'container-estancia', 'contenido');
  containerEstancia.setAttribute('data-accion', `${stringEstado}`);
  containerEstancia.setAttribute('data-estancia', `${datos.estancia}`);

  // Crear el elemento del cuerpo de la tarjeta
  const cardBody = document.createElement('div');
  cardBody.classList.add('card-body');
  cardBody.setAttribute('data-accion', `${stringEstado}`);
  cardBody.setAttribute('data-estancia', `${datos.estancia}`);

  // Agregar el elemento de texto al cuerpo de la tarjeta
  const fecha = document.createElement('p');
  fecha.classList.add('card-text');
  fecha.innerHTML = `<small class="text-body-secondary"> ${datos.fCreate} - <strong> ${datos.eCreate} </strong> </small>`;
  fecha.setAttribute('data-accion', `${stringEstado}`);
  fecha.setAttribute('data-estancia', `${datos.estancia}`);
  cardBody.appendChild(fecha);

  const infoElement = document.createElement('div');
  infoElement.classList.add('card-text');
  infoElement.setAttribute('data-accion', `${stringEstado}`);
  infoElement.setAttribute('data-estancia', `${datos.estancia}`);

  const spanInfo = document.createElement('span');
  spanInfo.setAttribute('data-accion', `${stringEstado}`);
  spanInfo.setAttribute('data-estancia', `${datos.estancia}`);
  if (datos.proveniencia != null){
    spanInfo.innerHTML = `${datos.nombre} - <strong> ${datos.proveniencia} </strong>`; 
  }
  spanInfo.innerHTML = datos.nombre;

  infoElement.appendChild(spanInfo);

  const ulInfo = document.createElement('ul');
  ulInfo.setAttribute('data-accion', `${stringEstado}`);
  ulInfo.setAttribute('data-estancia', `${datos.estancia}`);

  const liFecha = document.createElement('li');
  liFecha.innerHTML = `<strong>Fecha: </strong> ${datos.fecha}`;
  liFecha.setAttribute('data-accion', `${stringEstado}`);
  liFecha.setAttribute('data-estancia', `${datos.estancia}`);

  const liProyecto = document.createElement('li');
  liProyecto.innerHTML = `<strong>Proyecto: </strong> ${datos.proyecto}`;
  liProyecto.setAttribute('data-accion', `${stringEstado}`);
  liProyecto.setAttribute('data-estancia', `${datos.estancia}`);

  const liInstalaciones = document.createElement('li');
  liInstalaciones.innerHTML = `<strong>Instalaciones del ${datos.instalacion} </strong>`;
  liInstalaciones.setAttribute('data-accion', `${stringEstado}`);
  liInstalaciones.setAttribute('data-estancia', `${datos.estancia}`);

  const liTipo = document.createElement('li');
  liTipo.innerHTML = `<strong>Tipo: </strong> ${datos.tipo}`;
  liTipo.setAttribute('data-accion', `${stringEstado}`);
  liTipo.setAttribute('data-estancia', `${datos.estancia}`);

  ulInfo.appendChild(liFecha);
  ulInfo.appendChild(liProyecto);
  ulInfo.appendChild(liInstalaciones);
  ulInfo.appendChild(liTipo);
  infoElement.appendChild(ulInfo);

  // Agregar el cuerpo de la tarjeta al contenedor principal
  containerEstancia.appendChild(cardBody);
  containerEstancia.appendChild(infoElement);

  // Crear el contenedor de vídeos
  const videosContainer = document.createElement('div');
  videosContainer.classList.add('card-img-bottom');
  videosContainer.setAttribute('data-accion', `${stringEstado}`);
  videosContainer.setAttribute('data-estancia', `${datos.estancia}`);

  // Crear el carrusel de vídeos
  const carruselVideosElement = document.createElement('div');
  carruselVideosElement.id = `carrusel${datos.estancia}`;
  carruselVideosElement.classList.add('carousel', 'slide', 'videos');
  carruselVideosElement.setAttribute('data-accion', `${stringEstado}`);
  carruselVideosElement.setAttribute('data-estancia', `${datos.estancia}`);

  if (links.length != 0){
      // Crear el elemento interior del carrusel de vídeos
      const carruselVideosInner = document.createElement('div');
      carruselVideosInner.classList.add('carousel-inner');
      carruselVideosInner.setAttribute('data-accion', `${stringEstado}`);
      carruselVideosInner.setAttribute('data-estancia', `${datos.estancia}`);
    
      // Crear los elementos de los vídeos del carrusel
      links.forEach((link, index) => {
          const carouselItem = document.createElement('div');
          carouselItem.classList.add('carousel-item');
          if (index === 0) {
              carouselItem.classList.add('active');
          }
          
          const iframe = document.createElement('iframe');
          iframe.setAttribute('type', 'text/html');
          iframe.setAttribute('src',`${obtenerEnlaceRedSocial(link)}`);
          iframe.setAttribute('frameBorder', '0');
          iframe.setAttribute('allowfullscreen','true');
          iframe.setAttribute('data-accion', `${stringEstado}`);
          iframe.setAttribute('data-estancia', `${datos.estancia}`);
          
          if (verificarFacebook(obtenerEnlaceRedSocial(link))){
            const containerFacebook = document.createElement('div');
            containerFacebook.classList.add('container-facebook');
            containerFacebook.appendChild(iframe);
            containerFacebook.setAttribute('data-accion', `${stringEstado}`);
            containerFacebook.setAttribute('data-estancia', `${datos.estancia}`);
            carouselItem.appendChild(containerFacebook);
          }else{
            carouselItem.appendChild(iframe);
            carruselVideosInner.appendChild(carouselItem);
          }
      });
      // Crear los botones de control del carrusel de vídeos
      const prevButtonVideos = document.createElement('button');
      prevButtonVideos.classList.add('carousel-control-prev');
      prevButtonVideos.type = 'button';
      prevButtonVideos.dataset.bsTarget = `#carrusel${datos.estancia}`;
      prevButtonVideos.dataset.bsSlide = 'prev';
      prevButtonVideos.setAttribute('data-accion', `${stringEstado}`);
      prevButtonVideos.setAttribute('data-estancia', `${datos.estancia}`);
    
      const prevIconVideos = document.createElement('span');
      prevIconVideos.classList.add('carousel-control-prev-icon');
      prevIconVideos.setAttribute('aria-hidden', 'true');
      prevIconVideos.setAttribute('data-accion', `${stringEstado}`);
      prevIconVideos.setAttribute('data-estancia', `${datos.estancia}`);
    
      const prevLabelVideos = document.createElement('span');
      prevLabelVideos.classList.add('visually-hidden');
      prevLabelVideos.textContent = 'Previous';
      prevLabelVideos.setAttribute('data-accion', `${stringEstado}`);
      prevLabelVideos.setAttribute('data-estancia', `${datos.estancia}`);
    
      prevButtonVideos.appendChild(prevIconVideos);
      prevButtonVideos.appendChild(prevLabelVideos);
    
      const nextButtonVideos = document.createElement('button');
      nextButtonVideos.classList.add('carousel-control-next');
      nextButtonVideos.type = 'button';
      nextButtonVideos.dataset.bsTarget = `#carrusel${datos.estancia}`;
      nextButtonVideos.dataset.bsSlide = 'next';
      nextButtonVideos.setAttribute('data-accion', `${stringEstado}`);
      nextButtonVideos.setAttribute('data-estancia', `${datos.estancia}`);
    
      const nextIconVideos = document.createElement('span');
      nextIconVideos.classList.add('carousel-control-next-icon');
      nextIconVideos.setAttribute('aria-hidden', 'true');
      nextIconVideos.setAttribute('data-accion', `${stringEstado}`);
      nextIconVideos.setAttribute('data-estancia', `${datos.estancia}`);
    
      const nextLabelVideos = document.createElement('span');
      nextLabelVideos.classList.add('visually-hidden');
      nextLabelVideos.textContent = 'Next';
      nextLabelVideos.setAttribute('data-accion', `${stringEstado}`);
      nextLabelVideos.setAttribute('data-estancia', `${datos.estancia}`);
    
      nextButtonVideos.appendChild(nextIconVideos);
      nextButtonVideos.appendChild(nextLabelVideos);
    
      // Agregar los elementos del carrusel de vídeos al contenedor del carrusel
      carruselVideosElement.appendChild(carruselVideosInner);
      carruselVideosElement.appendChild(prevButtonVideos);
      carruselVideosElement.appendChild(nextButtonVideos);
    
      // Agregar el carrusel de vídeos al contenedor de vídeos
      videosContainer.appendChild(carruselVideosElement);
    
      // Agregar el contenedor de vídeos al contenedor principal
      containerEstancia.appendChild(videosContainer);
  }

  if (imagenes.length != 0){
      // Crear el segundo contenedor de imágenes
      const imagenesContainer = document.createElement('div');
      imagenesContainer.classList.add('card-img-bottom');
      imagenesContainer.setAttribute('data-accion', `${stringEstado}`);
      imagenesContainer.setAttribute('data-estancia', `${datos.estancia}`);
    
      // Crear el carrusel de imágenes
      const carruselImagenesElement = document.createElement('div');
      carruselImagenesElement.id = `carrusel${datos.estancia}-1`;
      carruselImagenesElement.classList.add('carousel', 'slide');
      carruselImagenesElement.setAttribute('data-accion', `${stringEstado}`);
      carruselImagenesElement.setAttribute('data-estancia', `${datos.estancia}`);
    
      // Crear el elemento interior del carrusel de imágenes
      const carruselImagenesInner = document.createElement('div');
      carruselImagenesInner.classList.add('carousel-inner');
      carruselImagenesInner.setAttribute('data-accion', `${stringEstado}`);
      carruselImagenesInner.setAttribute('data-estancia', `${datos.estancia}`);
    
      // Crear los elementos de las imágenes del carrusel
      imagenes.forEach((imagen, index) => {
        const carouselItem = document.createElement('div');
        carouselItem.classList.add('carousel-item');
        carouselItem.setAttribute('data-accion', `${stringEstado}`);
        carouselItem.setAttribute('data-estancia', `${datos.estancia}`);
        if (index === 0) {
          carouselItem.classList.add('active');
        }
    
        const img = document.createElement('img');
        img.setAttribute('data-accion', `${stringEstado}`);
        img.setAttribute('data-estancia', `${datos.estancia}`);
        img.src = imagen;
        img.classList.add('d-block', 'w-100');
    
        carouselItem.appendChild(img);
        carruselImagenesInner.appendChild(carouselItem);
      });
    
      // Crear los botones de control del carrusel de imágenes
      const prevButtonImagenes = document.createElement('button');
      prevButtonImagenes.classList.add('carousel-control-prev');
      prevButtonImagenes.type = 'button';
      prevButtonImagenes.dataset.bsTarget = `#carrusel${datos.estancia}-1`;
      prevButtonImagenes.dataset.bsSlide = 'prev';
      prevButtonImagenes.setAttribute('data-accion', `${stringEstado}`);
      prevButtonImagenes.setAttribute('data-estancia', `${datos.estancia}`);
    
      const prevIconImagenes = document.createElement('span');
      prevIconImagenes.classList.add('carousel-control-prev-icon');
      prevIconImagenes.setAttribute('aria-hidden', 'true');
      prevIconImagenes.setAttribute('data-accion', `${stringEstado}`);
      prevIconImagenes.setAttribute('data-estancia', `${datos.estancia}`);
    
      const prevLabelImagenes = document.createElement('span');
      prevLabelImagenes.classList.add('visually-hidden');
      prevLabelImagenes.textContent = 'Previous';
      prevLabelImagenes.setAttribute('data-accion', `${stringEstado}`);
      prevLabelImagenes.setAttribute('data-estancia', `${datos.estancia}`);
    
      prevButtonImagenes.appendChild(prevIconImagenes);
      prevButtonImagenes.appendChild(prevLabelImagenes);
    
      const nextButtonImagenes = document.createElement('button');
      nextButtonImagenes.classList.add('carousel-control-next');
      nextButtonImagenes.type = 'button';
      nextButtonImagenes.dataset.bsTarget = `#carrusel${datos.estancia}-1`;
      nextButtonImagenes.dataset.bsSlide = 'next';
      nextButtonImagenes.setAttribute('data-accion', `${stringEstado}`);
      nextButtonImagenes.setAttribute('data-estancia', `${datos.estancia}`);
    
      const nextIconImagenes = document.createElement('span');
      nextIconImagenes.classList.add('carousel-control-next-icon');
      nextIconImagenes.setAttribute('aria-hidden', 'true');
      nextIconImagenes.setAttribute('data-accion', `${stringEstado}`);
      nextIconImagenes.setAttribute('data-estancia', `${datos.estancia}`);
    
      const nextLabelImagenes = document.createElement('span');
      nextLabelImagenes.classList.add('visually-hidden');
      nextLabelImagenes.textContent = 'Next';
      nextLabelImagenes.setAttribute('data-accion', `${stringEstado}`);
      nextLabelImagenes.setAttribute('data-estancia', `${datos.estancia}`);
    
      nextButtonImagenes.appendChild(nextIconImagenes);
      nextButtonImagenes.appendChild(nextLabelImagenes);
    
      // Agregar los elementos del carrusel de imágenes al contenedor del carrusel
      carruselImagenesElement.appendChild(carruselImagenesInner);
      carruselImagenesElement.appendChild(prevButtonImagenes);
      carruselImagenesElement.appendChild(nextButtonImagenes);
    
      // Agregar el carrusel de imágenes al contenedor de imágenes
      imagenesContainer.appendChild(carruselImagenesElement);
    
      // Agregar el contenedor de imágenes al contenedor principal
      containerEstancia.appendChild(imagenesContainer);
  }
  return containerEstancia;
};
  
const Estancia = {
  nombre: false, 
  lugar: false,
  fecha: false,
  proyecto: false,
  instalacion: false,
  links: false
};

const validarEstancia = function (){
  if (Estancia.nombre && Estancia.fecha && Estancia.proyecto && Estancia.instalacion && Estancia.links){
    Estancia.nombre = validarCampo(expresiones.usuario, inputNombre.value, inputNombre.id);
    Estancia.lugar = validarCampo(expresiones.textOpcional, inputProveniencia.value, inputProveniencia.id);
    Estancia.fecha = validarCampo(expresiones.fecha, inputFecha.value, inputFecha.id);
    Estancia.proyecto = validarCampo(expresiones.usuario, inputProyecto.value, inputProyecto.id);
    Estancia.instalacion = validarCampo(expresiones.usuario, inputInstalaciones.value, inputInstalaciones.id);
    Estancia.links = validarCampo(expresiones.links, inputLinks.value, inputLinks.id);
    if (Estancia.nombre && Estancia.fecha && Estancia.proyecto && Estancia.instalacion && Estancia.links){
      buttonAgregar.removeAttribute('disabled');
      return true;
    }else{
      buttonAgregar.setAttribute('disabled', 'true');
      return false;
    }
  }
  buttonAgregar.setAttribute('disabled', 'true');
  return false;
}


const validarForm = (e) => {
  switch(e.target.name) {
    case 'nombre':
      Estancia.nombre = validarCampo(expresiones.usuario, e.target.value, e.target.id);
      break;

    case 'proveniencia':
      Estancia.lugar = validarCampo(expresiones.textOpcional, e.target.value, e.target.id);
      break;

    case 'fecha':
      Estancia.fecha = validarCampo(expresiones.fecha, e.target.value, e.target.id);
      break;

    case 'proyecto':
      Estancia.proyecto = validarCampo(expresiones.usuario, e.target.value, e.target.id);
      break;

    case 'instalaciones':
      Estancia.instalacion = validarCampo(expresiones.usuario, e.target.value, e.target.id);
      break;

    case 'links':
      Estancia.links = validarCampo(expresiones.links, e.target.value, e.target.id);
    break;
  }
  
  validarEstancia();
};

const agregar = function () {
  if (validarEstancia()){
    if (selectTipo.value > 0){
      if (inputImgs.value != ''){
        if (confirm('seguro que la información es correcta?')){
          const formData = new FormData();
          for (var i = 0; i < inputImgs.files.length; i++) {
              formData.append('imgs[]', inputImgs.files[i]);
          }
          formData.append('nombre', inputNombre.value);
          formData.append('proveniencia', inputProveniencia.value);
          formData.append('fecha', inputFecha.value);
          formData.append('proyecto', inputProyecto.value);
          formData.append('instalacion', inputInstalaciones.value);
          formData.append('tipo', selectTipo.value);
          let enlaces = encontrarEnlacesYouTubeYFacebook(inputLinks.value);
          formData.append('enlaces', enlaces);
          formData.append('id_user', id_user);
          $.ajax({
            url: '../db/consultas_estancias.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (respuesta) {
              if (respuesta.code === '0') {
                // La operación en el servidor fue exitosa
                contenedorEstancias.prepend(crearEstancia(respuesta.datos));
                // (nombre, proveniencia, proyecto, Instalaciones, links, fechaProyecto, carrusel, imagenes, fechaCreate, usuarioC, usuarioA = '', FechaUPdate = '')
                inputs.forEach((input) => {
                  input.value = '';
                  input.classList.remove('is-valid');
                });
                selectTipo.selectedIndex = -1;
                document.querySelector('#agregarEstancia .modal-footer button.btn.btn-secondary').click();
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
        }
      }else{
        alert('La estancia debe incluir minimo una imagen de evidencia');
      }
    }else{
      alert('El tipo de estancia no es valida')
    }
  }
}

buttonAgregar.addEventListener('click', agregar);

inputs.forEach((input)=>{
  // input.addEventListener('change', validarForm);
  // input.addEventListener('keypress', validarForm);
  // input.addEventListener('keyup', validarForm);
  input.addEventListener('input', validarForm);
});

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

Estancia.links = validarCampo(expresiones.links, inputLinks.value, inputLinks.id);