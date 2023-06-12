// Obtener referencias a los elementos del DOM
const container = document.querySelector('#modal-container'); // Contenedor del modal
const input_pdf = document.querySelector('.pdf'); // Input de archivo PDF
const input_img = document.querySelector('.media'); // Input de archivo de imagen
const btn_publicar = document.querySelector('#btn-publicar'); // Botón de publicar
const publicador_text = document.querySelector('#publicador-text'); // Textarea del publicador

// Función para redimensionar automáticamente el textarea (no se utiliza en el código proporcionado)
function autoResize() {
  const textarea = document.querySelector('#publicador-text');
  textarea.style.height = 'auto';
  textarea.style.height = textarea.scrollHeight + 'px';
}

// Función para mostrar el modal
function showModal() {
  const img = this.src;
  container.innerHTML = `<img src="${img}" alt="...">`;
  container.classList.add('active');
  document.body.classList.add('no-scroll');
}

// Función para ocultar el modal
function hideModal() {
  container.innerHTML = '';
  container.classList.remove('active');
  document.body.classList.remove('no-scroll');
}

// Función para validar la extensión de archivo
function validateFileExtension(file, allowedExtensions) {
  const fileName = file.name.toLowerCase();
  const fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
  return allowedExtensions.includes(fileExtension);
}

// Evento change del input de archivo PDF
input_pdf.addEventListener('change', function () {
  const file = this.files[0];
  if (!validateFileExtension(file, ['pdf'])) {
    alert('Por favor, selecciona solo archivos PDF.');
    this.value = '';
  }
});

// Evento change del input de archivo de imagen
input_img.addEventListener('change', function () {
  const file = this.files[0];
  if (!validateFileExtension(file, ['webp', 'png', 'jpg', 'jpeg'])) {
    alert('Solo se aceptan los formatos webp, png, jpg y jpeg.');
    this.value = '';
  }
});

// Evento click del botón de publicar
btn_publicar.addEventListener('click', () => {
  const text = publicador_text.value.trim();
  if (text === '') {
    alert('La publicación debe tener texto');
    return;
  }

  const formData = new FormData();
  formData.append('text', text);
  if (input_pdf.files.length > 0) {
    formData.append('pdf', input_pdf.files[0]);
  }
  if (input_img.files.length > 0) {
    formData.append('img', input_img.files[0]);
  }
  formData.append('id_user', id_user)

  $.ajax({
    url: '../db/consultas.php',
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      var decodificado = JSON.parse(respuesta);
      console.log(decodificado)
    },
    error: function (error) {
      alert('¡Algo salió mal! Por favor, inténtalo de nuevo más tarde.');
    }
  });  
});

// Evento click de las imágenes de publicación
document.querySelectorAll('.publicacion_img img').forEach(el => {
  el.addEventListener('click', function (ev) {
    ev.stopPropagation();
    showModal.call(this);
  });
});

// Evento click de los elementos del modal
document.querySelectorAll('.modal-container').forEach(el => {
  el.addEventListener('click', function (ev) {
    ev.stopPropagation();
    hideModal();
  });
});


// const container = document.querySelector('#modal-container')
// const input_pdf = document.querySelector('.pdf')
// const input_img = document.querySelector('.media')
// const btn_publicar = document.querySelector('#btn-publicar')
// const publicador_text = document.querySelector('#publicador-text')

// function autoResize() {
//     const textarea = document.querySelector('.publicador-text');
//     textarea.style.height = 'auto' // Restablecer la altura a automático
//     textarea.style.height = textarea.scrollHeight + 'px' // Ajustar la altura según el contenido
// }

// document.querySelectorAll('.publicacion_img img').forEach(el=>{
//         el.addEventListener('click',function(ev){
//             ev.stopPropagation()
//             var img = this.src
//             container.innerHTML += `<img src="${img}" alt="...">`
//             container.classList.add('active')
//             document.body.classList.add('no-scroll')
//     });
// });

// document.querySelectorAll('.modal-container').forEach(el=>{
//         el.addEventListener('click',function(ev){
//             ev.stopPropagation()
//             container.innerHTML = ''
//             container.classList.remove('active')
//             document.body.classList.remove('no-scroll')
//     });
// });

// input_pdf.addEventListener('change', function() {
//   const file = this.files[0]
//   const fileName = file.name.toLowerCase()
//   const fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1)

//   if (fileExtension !== 'pdf') {
//     alert('Por favor, selecciona solo archivos PDF.')
//     this.value = '' // Limpiar el campo de entrada de archivo si no es un PDF
//   }
// });

// input_img.addEventListener('change', function() {
//     const file = this.files[0]
//     const fileName = file.name.toLowerCase()
//     const fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1)
  
//     if (fileExtension == 'webp' || fileExtension == 'png' || fileExtension == 'jpg' || fileExtension == 'jpeg'){
//     }else{    
//       alert('Solo se aceptan los formatos webp, png, jpg y jpeg')
//       this.value = '' // Limpiar el campo de entrada de archivo si no es un tipo de archivo de imagen aceptado
//     }
// });

// btn_publicar.addEventListener('click', () => {
//   const text = publicador_text.value;
//   if (text.trim() === '') {
//     alert('La publicación debe tener texto');
//     return;
//   }

//   const formData = new FormData();
//   formData.append('text', text);
//   if (input_pdf.files.length > 0) {
//     formData.append('pdf', input_pdf.files[0]);
//   }
//   if (input_img.files.length > 0) {
//     formData.append('img', input_img.files[0]);
//   }

//   $.ajax({
//     url: '../db/consultas.php',
//     type: 'POST',
//     data: formData,
//     contentType: false,
//     processData: false,
//     success: function (respuesta) {
//       // Manejar la respuesta del servidor
//     },
//     error: function (error) {
//       // Manejar errores en la solicitud AJAX
//     }
//   });
// });