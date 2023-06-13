document.querySelector('a[href="./publicaciones"]').classList.add('active');
// Obtener referencias a los elementos del DOM
const container = document.querySelector('#modal-container'); // Contenedor del modal
const input_pdf = document.querySelector('.pdf'); // Input de archivo PDF
const input_img = document.querySelector('.media'); // Input de archivo de imagen
const btn_publicar = document.querySelector('#btn-publicar'); // Botón de publicar
const publicador_text = document.querySelector('#publicador-text'); // Textarea del publicador
const tipoPublicacion_select = document.querySelector('#tipo_publicacion');
const img_view = document.querySelector('#img-view');
const text_file = document.querySelector('#text-file');
const text_pdf = document.querySelector('#text-pdf');
const btn_cerrarModal = document.querySelector('#modal-publicar .modal-footer .btn-secondary');
const modal_pdf = document.querySelector('#modal-pdf');

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
input_pdf.addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (!validateFileExtension(file, ['pdf'])) {
    alert('Por favor, selecciona solo archivos PDF.');
    e.target.value = '';
  }
});

text_pdf.addEventListener('click', () => {
  input_pdf.click();
})
text_file.addEventListener('click', () => {
  input_img.click();
});

// Evento change del input de archivo de imagen
input_img.addEventListener('change', function(e) {
  const file = e.target.files[0];
  try {
    if (!validateFileExtension(file, ['webp', 'png', 'jpg', 'jpeg'])) {
      alert('Solo se aceptan los formatos webp, png, jpg y jpeg.');
      e.target.value = '';
    }else if (e.target.files[0]){
      const reader = new FileReader();
      reader.onload = function(e){
        img_view.src = e.target.result;
      }
      reader.readAsDataURL(e.target.files[0]);
    }else{
      img_view.src = '';
    }  
  } catch (error) {
    img_view.src = '';
    e.target.value = '';   
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
  formData.append('id_user', id_user);
  formData.append('tipo', tipoPublicacion_select.value);

  $.ajax({
    url: '../db/consultas.php',
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      var decodificado = JSON.parse(respuesta);
      if (decodificado.code === '0') {
        // La operación en el servidor fue exitosa
        document.querySelector('#modal-publicar .modal-footer .btn-secondary').click();
        nuevaPublicacion(decodificado.datos);
        desactivarModalImg();
        activarModalImg();
        desactivarButtons_pdf();
        activarButtons_pdf();
        desactivarButtons_eliminar();
        activarButtons_eliminar();
      } else {
        // La operación en el servidor no fue exitosa
        alert(decodificado.message);
      }
    },
    error: function (error) {
      // Manejar errores en la solicitud AJAX
      console.log('Error en la solicitud AJAX:', error);
    }
  });
});

// Evento click de las imágenes de publicación
const activarModalImg = function() {
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
}

const desactivarModalImg = function (){
  document.querySelectorAll('.publicacion_img img').forEach(el => {
    el.removeEventListener('click', function (ev) {
      ev.stopPropagation();
      showModal.call(this);
    });
  });
  // Evento click de los elementos del modal
  document.querySelectorAll('.modal-container').forEach(el => {
    el.removeEventListener('click', function (ev) {
      ev.stopPropagation();
      hideModal();
    });
  });
}
const activarButtons_pdf = function() {
  document.querySelectorAll('button[data-pdf]').forEach(el => {
    el.addEventListener('click', function(e) {
      e.stopPropagation();
      document.querySelector('#pdfPreview').src = e.target.dataset.pdf;
    })
  })
}
const desactivarButtons_pdf = function() {
  document.querySelectorAll('.icon-pdf').forEach(el => {
    el.removeEventListener('click', function (e) {
      e.stopPropagation();
      document.querySelector('#pdfPreview').src = e.target.dataset.pdf;
    })
  })
}

const activarButtons_eliminar = function() {
  document.querySelectorAll('.publicacion_eliminar').forEach(el => {
    el.addEventListener('click', function(e) {
      const formData = new FormData();
      formData.append('eliminar', e.target.dataset.eliminar);
      formData.append('id_user', id_user);
      $.ajax({
        url: '../db/consultas.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          var decodificado = JSON.parse(respuesta);
          if (decodificado.code === '0') {
            let padre = e.target.parentNode;
            padre = padre.parentNode;
            console.log(padre);
            padre.parentNode.removeChild(padre);
          } else {
            // La operación en el servidor no fue exitosa
            alert(decodificado.message);
          }
        },
        error: function (error) {
          // Manejar errores en la solicitud AJAX
          console.log('Error en la solicitud AJAX:', error);
        }
      });
    })
  })
}
const desactivarButtons_eliminar = function() {
  document.querySelectorAll('.publicacion_eliminar').forEach(el => {
    el.removeEventListener('click', function(e) {
      const formData = new FormData();
      formData.append('eliminar', e.target.dataset.eliminar);
      formData.append('id_user', id_user);
      $.ajax({
        url: '../db/consultas.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          var decodificado = JSON.parse(respuesta);
          if (decodificado.code === '0') {
            let padre = e.target.parentNode;
            do {
              padre = padre.parentNode;
              console.log(padre);
            } while (padre.classList.contains('container-publicacion'));
            padre.parentNode.removeChild(padre);
          } else {
            // La operación en el servidor no fue exitosa
            alert(decodificado.message);
          }
        },
        error: function (error) {
          // Manejar errores en la solicitud AJAX
          console.log('Error en la solicitud AJAX:', error);
        }
      });
    })
  })
}
activarButtons_pdf()
activarButtons_eliminar();

// funcion que crea la estructura de una nueva publicacion con los datos que se le proporcionan
const nuevaPublicacion = function (datos){
  const containerPublicaciones = document.querySelector('.container-publicaciones');

  const publicacion = document.createElement('div');
  publicacion.className = 'container-publicacion';

  const header = document.createElement('div');
  header.className = 'container-publicacion_header';

  const user = document.createElement('span');
  user.className = 'publicacion_user';
  user.textContent = `${datos.usuario} - ${datos.tipo}`;
  header.appendChild(user);

  const fecha = document.createElement('span');
  fecha.className = 'publicacion_fecha';
  fecha.textContent = datos.create;
  header.appendChild(fecha);

  publicacion.appendChild(header);

  const main = document.createElement('div');
  main.className = 'container-publicacion_main';

  const text = document.createElement('div');
  text.className = 'publicacion_text';
  const textContent = document.createElement('p');
  textContent.textContent = datos.text;
  text.appendChild(textContent);
  main.appendChild(text);

  if (datos.img != ''){
    const img = document.createElement('div');
    img.className = 'publicacion_img';
    const imgContent = document.createElement('img');
    imgContent.src = datos.img;
    img.appendChild(imgContent);
    main.appendChild(img);
  }

  if (datos.pdf != ''){
    const pdf = document.createElement('div');
    pdf.className = 'publicacion_pdf';
    const pdfButton = document.createElement('button');
    pdfButton.setAttribute('data-bs-toggle', 'modal');
    pdfButton.setAttribute('data-bs-target', '#modal-pdf');
    pdfButton.setAttribute('data-pdf', `${datos.pdf}`);
    const pdfIcon = document.createElement('span');
    pdfIcon.setAttribute('data-pdf', `${datos.pdf}`);
    pdfIcon.className = 'icon-pdf material-symbols-outlined';
    pdfIcon.textContent = 'picture_as_pdf';
    const pdfText = document.createElement('span');
    pdfText.setAttribute('data-pdf', `${datos.pdf}`);
    pdfText.textContent = 'ver pdf adjunto';
    pdfButton.appendChild(pdfIcon);
    pdfButton.appendChild(pdfText);
    pdf.appendChild(pdfButton);
    main.appendChild(pdf);
  }
  publicacion.appendChild(main);

  const footer = document.createElement('div');
  footer.className = 'container-publicacion_footer';

  const eliminar = document.createElement('span');
  eliminar.className = 'publicacion_eliminar fa fa-times';
  eliminar.setAttribute('aria-hidden', 'true');
  eliminar.textContent = ' Eliminar';
  eliminar.setAttribute('data-eliminar',`${datos.publicacion}`);
  footer.appendChild(eliminar);

  publicacion.appendChild(footer);

  containerPublicaciones.prepend(publicacion);

}

btn_cerrarModal.addEventListener('click', () => {
  publicador_text.value = '';
  input_pdf.value = '';
  input_img.value = '';
  img_view.src = ''; 
});

