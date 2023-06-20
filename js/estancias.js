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
const inputMedia = document.querySelector('input#media');

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


const crearEstancia = function(nombre, proveniencia, proyecto, Instalaciones, links, fechaProyecto, carruselVideos, imagenes, carruselImagenes, fechaCreate, FechaUPdate, usuarioC, usuarioA) {
    // Crear el elemento contenedor principal
    const containerEstancia = document.createElement('div');
    containerEstancia.classList.add('card', 'container-estancia');
  
    // Crear el elemento del cuerpo de la tarjeta
    const cardBody = document.createElement('div');
    cardBody.classList.add('card-body');
  
    // Agregar el elemento de texto al cuerpo de la tarjeta
    // const fecha = document.createElement('p');
    // fecha.classList.add('card-text');
    // fecha.innerHTML = '<small class="text-body-secondary">'+ textFecha +'</small>';
    // cardBody.appendChild(fecha);
  
    const textoElement = document.createElement('p');
    textoElement.classList.add('card-text');
    textoElement.textContent = texto;
    cardBody.appendChild(textoElement);
  
    // Agregar el cuerpo de la tarjeta al contenedor principal
    containerEstancia.appendChild(cardBody);
  
    // Crear el contenedor de vídeos
    const videosContainer = document.createElement('div');
    videosContainer.classList.add('card-img-bottom');
  
    // Crear el carrusel de vídeos
    const carruselVideosElement = document.createElement('div');
    carruselVideosElement.id = `carrusel${carruselVideos}`;
    carruselVideosElement.classList.add('carousel', 'slide', 'videos');
  
    if (links.length != 0){
        // Crear el elemento interior del carrusel de vídeos
        const carruselVideosInner = document.createElement('div');
        carruselVideosInner.classList.add('carousel-inner');
      
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
            
            if (verificarFacebook(obtenerEnlaceRedSocial(link))){
              const containerFacebook = document.createElement('div');
              containerFacebook.classList.add('container-facebook');
              containerFacebook.appendChild(iframe);
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
        prevButtonVideos.dataset.bsTarget = `#carrusel${carruselVideos}`;
        prevButtonVideos.dataset.bsSlide = 'prev';
      
        const prevIconVideos = document.createElement('span');
        prevIconVideos.classList.add('carousel-control-prev-icon');
        prevIconVideos.setAttribute('aria-hidden', 'true');
      
        const prevLabelVideos = document.createElement('span');
        prevLabelVideos.classList.add('visually-hidden');
        prevLabelVideos.textContent = 'Previous';
      
        prevButtonVideos.appendChild(prevIconVideos);
        prevButtonVideos.appendChild(prevLabelVideos);
      
        const nextButtonVideos = document.createElement('button');
        nextButtonVideos.classList.add('carousel-control-next');
        nextButtonVideos.type = 'button';
        nextButtonVideos.dataset.bsTarget = `#carrusel${carruselVideos}`;
        nextButtonVideos.dataset.bsSlide = 'next';
      
        const nextIconVideos = document.createElement('span');
        nextIconVideos.classList.add('carousel-control-next-icon');
        nextIconVideos.setAttribute('aria-hidden', 'true');
      
        const nextLabelVideos = document.createElement('span');
        nextLabelVideos.classList.add('visually-hidden');
        nextLabelVideos.textContent = 'Next';
      
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
      
        // Crear el carrusel de imágenes
        const carruselImagenesElement = document.createElement('div');
        carruselImagenesElement.id = `carrusel${carruselImagenes}`;
        carruselImagenesElement.classList.add('carousel', 'slide');
      
        // Crear el elemento interior del carrusel de imágenes
        const carruselImagenesInner = document.createElement('div');
        carruselImagenesInner.classList.add('carousel-inner');
      
        // Crear los elementos de las imágenes del carrusel
        imagenes.forEach((imagen, index) => {
          const carouselItem = document.createElement('div');
          carouselItem.classList.add('carousel-item');
          if (index === 0) {
            carouselItem.classList.add('active');
          }
      
          const img = document.createElement('img');
          img.src = imagen;
          img.classList.add('d-block', 'w-100');
      
          carouselItem.appendChild(img);
          carruselImagenesInner.appendChild(carouselItem);
        });
      
        // Crear los botones de control del carrusel de imágenes
        const prevButtonImagenes = document.createElement('button');
        prevButtonImagenes.classList.add('carousel-control-prev');
        prevButtonImagenes.type = 'button';
        prevButtonImagenes.dataset.bsTarget = `#carrusel${carruselImagenes}`;
        prevButtonImagenes.dataset.bsSlide = 'prev';
      
        const prevIconImagenes = document.createElement('span');
        prevIconImagenes.classList.add('carousel-control-prev-icon');
        prevIconImagenes.setAttribute('aria-hidden', 'true');
      
        const prevLabelImagenes = document.createElement('span');
        prevLabelImagenes.classList.add('visually-hidden');
        prevLabelImagenes.textContent = 'Previous';
      
        prevButtonImagenes.appendChild(prevIconImagenes);
        prevButtonImagenes.appendChild(prevLabelImagenes);
      
        const nextButtonImagenes = document.createElement('button');
        nextButtonImagenes.classList.add('carousel-control-next');
        nextButtonImagenes.type = 'button';
        nextButtonImagenes.dataset.bsTarget = `#carrusel${carruselImagenes}`;
        nextButtonImagenes.dataset.bsSlide = 'next';
      
        const nextIconImagenes = document.createElement('span');
        nextIconImagenes.classList.add('carousel-control-next-icon');
        nextIconImagenes.setAttribute('aria-hidden', 'true');
      
        const nextLabelImagenes = document.createElement('span');
        nextLabelImagenes.classList.add('visually-hidden');
        nextLabelImagenes.textContent = 'Next';
      
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
  
// let links = ['https://www.youtube.com/watch?v=Qr4FPQxPx54', 'https://www.youtube.com/watch?v=LfX6JxfND44', 'https://www.youtube.com/watch?v=wuJIqmha2Hk', 'https://www.youtube.com/watch?v=52Gg9CqhbP8', 'https://www.youtube.com/watch?v=fx9VygrLek4'];

// let carruselVideos = '1';
// let carruselImagenes = '1-1';

// let texto = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vitae quos consequatur non, maiores assumenda harum ea laudantium delectus esse aliquam sapiente, voluptas laboriosam quibusdam ad minima consectetur ullam dicta quia.';

// let imagenes = ['../src/img/50jKa6UKvS.jpg', '../src/img/1f7y5pTsm0.png', '../src/img/7wp2Bn7pWm.jpg', '../src/img/6rmZBVlxgt.jpg'];

// let fecha = '20/06/2023'
// contenedorEstancias.appendChild(crearEstancia(texto, links, fecha, carruselVideos, imagenes, carruselImagenes));

const Estancia = {
  nombre: false, 
  lugar: false,
  fecha: false,
  proyecto: false,
  instalacion: false,
  links: false
};

const validarEstancia = function (){
  if (Estancia.nombre && Estancia.lugar && Estancia.fecha && Estancia.proyecto && Estancia.instalacion && Estancia.links){
    Estancia.nombre = validarCampo(expresiones.usuario, inputNombre.value, inputNombre.id);
    Estancia.lugar = validarCampo(expresiones.usuario, inputProveniencia.value, inputProveniencia.id);
    Estancia.fecha = validarCampo(expresiones.fecha, inputFecha.value, inputFecha.id);
    Estancia.proyecto = validarCampo(expresiones.usuario, inputProyecto.value, inputProyecto.id);
    Estancia.instalacion = validarCampo(expresiones.usuario, inputInstalaciones.value, inputInstalaciones.id);
    Estancia.links = validarCampo(expresiones.links, inputLinks.value, inputLinks.id);
    if (Estancia.nombre && Estancia.lugar && Estancia.fecha && Estancia.proyecto && Estancia.instalacion && Estancia.links){
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
      Estancia.lugar = validarCampo(expresiones.usuario, e.target.value, e.target.id);
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

inputs.forEach((input)=>{
  // input.addEventListener('change', validarForm);
  // input.addEventListener('keypress', validarForm);
  // input.addEventListener('keyup', validarForm);
  input.addEventListener('input', validarForm);
});

Estancia.links = validarCampo(expresiones.links, inputLinks.value, inputLinks.id);