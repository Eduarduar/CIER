let btn_cerrar_sesion = document.querySelector('#btn_cerrarSesion');
let btn_usuarios = document.querySelector('header button.btn-outline-success');
const menuDesplegableHeader = document.querySelector('#menuDesplegableHeader');
const inputNombreEstructura = document.querySelector('#nombreEstructura');
const inputPdfR = document.querySelector('#pdfR');
const inputPdfI = document.querySelector('#pdfI');
const buttonAgregarEstructura = document.querySelector('#agregarEstructura .modal-footer button.btn.btn-primary');
const buttonVerPdfR = document.querySelector('#verEstructura .modal-body button.btn-danger');
const buttonVerPdfI = document.querySelector('#verEstructura .modal-body button.btn-success');
const iframeViewPdf = document.querySelector('iframe#verPDF');

btn_cerrar_sesion.addEventListener('click', () => {
    window.location = '../db/cerrarSesion';
})
try {
    btn_usuarios.addEventListener('click', () => {
    window.location = './usuarios';
    });
} catch (error) {
    
}

const agregarEstructura = {
    nombre: false,
    pdfR: false,
    pdfI: false
}

const validarAgregarEstructura = function () {
    if (agregarEstructura.nombre && agregarEstructura.pdfI && agregarEstructura.pdfR){
        agregarEstructura.nombre = validarCampo(expresiones.textNum, inputNombreEstructura.value, inputNombreEstructura.id);
        if (agregarEstructura.nombre && agregarEstructura.pdfI && agregarEstructura.pdfR){
            buttonAgregarEstructura.removeAttribute('disabled');
            return true;
        }else{
            buttonAgregarEstructura.setAttribute('disabled', 'true');
            return false;
        }
    }
    buttonAgregarEstructura.setAttribute('disabled', 'true');
    return false;
}

inputNombreEstructura.addEventListener('input', (e) => {
    agregarEstructura.nombre = validarCampo(expresiones.textNum, e.target.value, e.target.id);
    validarAgregarEstructura();
});

const validarPDF = function(e) {
    if (e.target.files.length > 0){
        const file = e.target.files[0];
        if (!validateFileExtension(file, ['pdf'])) {
          alert('Por favor, selecciona solo archivos PDF.');
          e.target.value = '';
          return false;
        }else{
            return true;
        }
    }else{
        return false;
    }
}

inputPdfI.addEventListener('change', (e) => {
    if (validarPDF(e)){
        agregarEstructura.pdfI = true;
    }else{
        agregarEstructura.pdfI = false;
    }
    validarAgregarEstructura();
});
inputPdfR.addEventListener('change', (e) => {
    if (validarPDF(e)){
        agregarEstructura.pdfR = true;
        validarAgregarEstructura();
    }else{
        agregarEstructura.pdfR = false;
    }
    validarAgregarEstructura();
});

const activarMenuDesplegableHeader = function (e) {
    if (typeof id_user !== 'undefined'){

        e.preventDefault();
        menuDesplegableHeader.innerHTML = '<ul></ul>';
        let ul = document.querySelector('#menuDesplegableHeader ul');
        
        if (e.target.dataset.accion == 'contenedor'){
            
            let liAgregar = document.createElement('li');
            liAgregar.textContent = 'Agregar Estructura';
            liAgregar.setAttribute('data-bs-toggle', 'modal');
            liAgregar.setAttribute('data-bs-target', '#agregarEstructura');
            
            let liEliminados = document.createElement('li');
            liEliminados.textContent = 'Ver Estructuras Eliminadas';
            liEliminados.setAttribute('data-bs-toggle', 'modal');
            liEliminados.setAttribute('data-bs-target', '#verEliminados');
            
            ul.appendChild(liAgregar);
            ul.appendChild(liEliminados);
            
        }else if (e.target.dataset.accion == 'estructura'){
            
            // Crear elementos li
            let liEstado = document.createElement('li');
            
            // Agregar texto a los elementos li
            if (e.target.dataset.estado == 'activo'){
                liEstado.textContent = 'Eliminar Estructura';
            }else{
                liEstado.textContent = 'Reactivar Estructura';
            }
            liEstado.setAttribute('data-estructura',`${e.target.dataset.estructura}`);
            // Agregar elementos li a la lista
            ul.appendChild(liEstado);
            
            liEstado.addEventListener('click', (e2) => {
                const formData = new FormData();
                if (e.target.dataset.estado == 'activo'){
                    formData.append('estructura', 'eliminar');
                }else{
                    formData.append('estructura', 'activar');
                }
                formData.append('estructura_id', e.target.dataset.estructura);
                formData.append('id_user', id_user);
                $.ajax({
                    url: '../db/consultas_header.php',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        if (respuesta.code === '0') {
                            let estructura = e.target;
                            do {
                                if (estructura.classList.contains('contenidoHeader')){
                                    estructuras = estructura.parentNode;
                                    break;
                                }
                                estructura = estructura.parentNode;
                            } while (true);
                            estructuras.removeChild(estructura);
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
            }
        menuDesplegableHeader.style.display = 'block';
        menuDesplegableHeader.style.left = e.pageX + 'px';
        menuDesplegableHeader.style.top = e.pageY + 'px';
    }
}

const mostrarInfoEstructura = function (e) {
    const formData = new FormData();
    formData.append('getEstructura', e.target.dataset.estructura);
    $.ajax({
        url: '../db/consultas_header.php',
        type: 'POST',
        dataType: 'json',
        data: formData,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta.code === '0') {
                document.querySelector('#modalNombreVerEstructura').innerHTML = `${respuesta.datos.nombre}`;
                buttonVerPdfI.setAttribute('data-pdf',`${respuesta.datos.pdfI}`);
                buttonVerPdfR.setAttribute('data-pdf',`${respuesta.datos.pdfR}`);
            } else {
                // La operación en el servidor no fue exitosa
                setTimeout(() => {
                    document.querySelector('#verEstructura .modal-footer button.btn.btn-secondary').click();
                }, 500);
                alert(respuesta.message);
            }
        },
        error: function (error) {
            // Manejar errores en la solicitud AJAX
            setTimeout(() => {
                document.querySelector('#verEstructura .modal-footer button.btn.btn-secondary').click();
            }, 500 );
            console.log('Error en la solicitud AJAX:', error.responseText);
        }
    });
}

buttonAgregarEstructura.addEventListener('click', () => {
    if (validarAgregarEstructura()){
        if (confirm('La información es correcta?')){
            const formData = new FormData();
            formData.append('nombre', inputNombreEstructura.value);
            formData.append('pdfR', inputPdfR.files[0]);
            formData.append('pdfI', inputPdfI.files[0]);
            $.ajax({
                url: '../db/consultas_header.php',
                type: 'POST',
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    if (respuesta.code === '0') {
                        let ul = document.querySelector('.dropdown-menu');
                        let li = document.createElement('li');
                        li.setAttribute('data-estructura', respuesta.datos.code);
                        li.setAttribute('data-accion','estructura');
                        li.setAttribute('data-estado','activo');
                        li.addEventListener('contextmenu', (e) => {
                            activarMenuDesplegableHeader(e);
                        });  
                        let a = document.createElement('a');
                        a.setAttribute('data-estructura', respuesta.datos.code);
                        a.setAttribute('data-accion','estructura');
                        a.setAttribute('data-estado','activo');
                        a.setAttribute('data-bs-toggle','modal');
                        a.setAttribute('data-bs-target','#verEstructura');
                        a.setAttribute('href','#');
                        a.addEventListener('click', mostrarInfoEstructura);
                        a.classList.add('dropdown-item');
                        li.appendChild(a);
                        ul.appendChild(li);
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
    }
});

const verPdf = function (e) {
    console.log(e.target.dataset.pdf)
    iframeViewPdf.setAttribute('src', `${e.target.dataset.pdf}`)
}

buttonVerPdfI.addEventListener('click', verPdf);
buttonVerPdfR.addEventListener('click', verPdf);

let contenido = document.querySelectorAll('.contenidoHeader');
contenido.forEach((element) => {
    element.addEventListener('contextmenu', (e) => {
        activarMenuDesplegableHeader(e);
    });  
});

let estructuras = document.querySelectorAll('.dropdown-menu li a');
estructuras.forEach((element) => {
    element.addEventListener('click', mostrarInfoEstructura);
});

document.addEventListener('click', function() {
    menuDesplegableHeader.style.display = 'none';
    menuDesplegableHeader.innerHTML = '<ul></ul>';
});