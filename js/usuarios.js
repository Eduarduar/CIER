const inputs = document.querySelectorAll('input');
const inputTuNombre = document.querySelector('#tu-nombre');
const inputTuControl = document.querySelector('#tu-control');
const btnGuardarTuInformacion = document.querySelector('.container-infoUser .btn.btn-outline-success');
const menuDesplegable = document.querySelector('#menuDesplegable');
const contenido = document.querySelectorAll('.contenido');

const tu_Nombre = inputTuNombre.value;
const tu_control = inputTuControl.value;


const tuInformacion = {
    nombre: false,
    control: false
};

const validarForm = (e) => {
    switch(e.target.name){
        case 'tu-nombre':
            tuInformacion.nombre = validarCampo(expresiones.usuario, e.target.value, e.target.id);
        break;
        case 'tu-control':
            tuInformacion.control = validarCampo(expresiones.NoControl, e.target.value, e.target.id);
        break;
    }
}

const comprobarTuInformacion = function () {
    tuInformacion.nombre = validarCampo(expresiones.usuario, inputTuNombre.value, inputTuNombre.id);
    tuInformacion.control = validarCampo(expresiones.NoControl, inputTuControl.value, inputTuControl.id);
    if (tuInformacion.nombre && tuInformacion.control){
        if (inputTuNombre.value == tu_Nombre && inputTuControl.value == tu_control){
            btnGuardarTuInformacion.setAttribute('disabled','true');
            return false;
        }else{
            btnGuardarTuInformacion.removeAttribute('disabled');
            return true;
        }
    }
}

const guardarTuInformacion = function() {
    if (comprobarTuInformacion()){
        if (confirm('Seguro que quiere cambiar sus datos? se cerrara la sesión')){
            const formData = new FormData();
            formData.append('tuControl', inputTuControl.value);
            formData.append('tuNombre', inputTuNombre.value);
            formData.append('id_user', id_user);
            $.ajax({
                url: '../db/consultas.php',
                type: 'POST',
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    if (respuesta.code === '0') {
                        window.location = '../db/cerrarSesion.php';
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
    }
}

contenido.forEach((element) => {
    element.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        menuDesplegable.innerHTML = '<ul></ul>';
        if (e.target.dataset.accion == 'usuario'){
            let ul = document.querySelector('#menuDesplegable ul');

            // Crear elementos li
            let liEditar = document.createElement('li');
            let liEstado = document.createElement('li');
          
            // Agregar texto a los elementos li
            liEditar.textContent = 'Editar';
            liEditar.setAttribute('data-usuario',`${e.target.dataset.usuario}`);
            liEstado.textContent = 'Cambiar Estado';
            liEstado.setAttribute('data-usuario',`${e.target.dataset.usuario}`);
            
            // Agregar elementos li a la lista
            ul.appendChild(liEditar);
            ul.appendChild(liEstado);
            
            liEditar.addEventListener('click', (e1) => {
                
            });

            liEstado.addEventListener('click', (e2) => {
                const formData = new FormData();
                formData.append('usuario', 'estado');
                formData.append('usuario_id', e.target.dataset.usuario);
                $.ajax({
                    url: '../db/consultas.php',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        if (respuesta.code === '0') {
                            document.querySelector(`${e.target.tagName.toLowerCase()} `)
                        } else {
                            // La operación en el servidor no fue exitosa
                            alert(respuesta.menssaje);
                        }
                    },
                    error: function (error) {
                        // Manejar errores en la solicitud AJAX
                        console.log('Error en la solicitud AJAX:', error.responseText);
                    }});
            });
        }
        
        menuDesplegable.style.display = 'block';
        menuDesplegable.style.left = e.clientX + 'px';
        menuDesplegable.style.top = e.clientY + 'px';
    });  
});
  
document.addEventListener('click', function() {
    menuDesplegable.style.display = 'none';
    menuDesplegable.innerHTML = '<ul></ul>';
});


btnGuardarTuInformacion.addEventListener('click', guardarTuInformacion);
inputTuNombre.addEventListener('keyup', comprobarTuInformacion);
inputTuNombre.addEventListener('keypress', comprobarTuInformacion);
inputTuControl.addEventListener('keyup', comprobarTuInformacion);
inputTuControl.addEventListener('keypress', comprobarTuInformacion);
comprobarTuInformacion();