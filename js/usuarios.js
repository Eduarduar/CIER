const inputs = document.querySelectorAll('input');
const inputTuNombre = document.querySelector('#tu-nombre');
const inputTuControl = document.querySelector('#tu-control');
const btnGuardarTuInformacion = document.querySelector('.container-infoUser .btn.btn-outline-success');
const menuDesplegable = document.querySelector('#menuDesplegable');
const tablaUsuarios = document.querySelector('#tabla_usuarios');
const inputNombre = document.querySelector('#usuario-nombre');
const inputControl = document.querySelector('#usuario-control');
const selectRol = document.querySelector('#usuario-rol');
const btnGuardarCambios = document.querySelector('#editarUsuario .modal-footer button.btn-primary');
const btnShow = document.querySelectorAll('span[data-contra]');
const btnCambiarContra = document.querySelector('#cambiarContra .modal-footer button.btn-primary');
const inputPassA = document.querySelector('#pass');
const inputPassN = document.querySelector('#passN');
const inputPassN2 = document.querySelector('#passN2');
const inputInsertarNombre = document.querySelector('');
const inputInsertarControl = document.querySelectorI('');
const selectInsertarRol = document.querySelector('');
const inputInsertarPassN2 = document.querySelector('');
const inputInsertarPassN = document.querySelector('');
const tu_Nombre = inputTuNombre.value;
const tu_control = inputTuControl.value;


const tuInformacion = {
    nombre: false,
    control: false
};

const editarUsuario = {
    nombre: false,
    control: false,
    tNombre: undefined,
    tControl: undefined,
    eRol: undefined,
    iduser: undefined
}

const cambiarContra = {
    pass: false,
    passN2: false,
    passN: false
}

const insertarUsuario = {
    nombre: false,
    control: false,
    passN: false,
    passN2:false
}

const validarForm = (e) => {
    switch(e.target.name){
        case 'usuario-nombre':
            comprobarInfoUsuario();
        break;
        case 'usuario-control':
            comprobarInfoUsuario();
        break;
        case 'tu-nombre':
            comprobarTuInformacion();
        break;
        case 'tu-control':
            comprobarTuInformacion();
        break;
        case 'pass':
            cambiarContra.pass = validarCampo(expresiones.contra, e.target.value, e.target.id);
            comprobarCambioContra();
        break;
        case 'passN2':
            cambiarContra.passN2 = validarCampo(expresiones.contra, e.target.value, e.target.id);
            cambiarContra.passN = validarPassword(e.target.id.substring(0, e.target.id.length - 1));
            comprobarCambioContra();
        break;
        case 'passN':
            cambiarContra.passN = validarPassword(e.target.id);
            comprobarCambioContra();
        break;
        case 'insertar-usuario-nombre':
            insertarUsuario.nombre = validarCampo(expresiones.usuario, e.target.value, e.target.id);
            comprobarInsertarUsuario();
        break;
        case 'insertar-usuario-control':
            insertarUsuario.control = validarCampo(expresiones.NoControl, e.target.value, e.target.id);
            comprobarInsertarUsuario();
        break;
        case 'insertar-passN2':
            cambiarContra.passN2 = validarCampo(expresiones.contra, e.target.value, e.target.id);
            cambiarContra.passN = validarPassword(e.target.id.substring(0, e.target.id.length - 1));
            comprobarInsertarUsuario();
        break;
        case 'insertar-passN':
            cambiarContra.passN = validarPassword(e.target.id);
            comprobarInsertarUsuario();
        break;

    }
}

const comprobarInsertarUsuario = function () {

}

const comprobarCambioContra = function () {
    if (cambiarContra.pass && cambiarContra.passN && cambiarContra.passN2){
        cambiarContra.pass = validarCampo(expresiones.contra, inputPassA.value, inputPassA.id);
        cambiarContra.passN2 = validarCampo(expresiones.contra, inputPassN2.value, inputPassN2.id);
        cambiarContra.passN = validarPassword(inputPassN.id);
        if (cambiarContra.pass && cambiarContra.passN && cambiarContra.passN2){
            btnCambiarContra.removeAttribute('disabled');
            return true;
        }else{
            btnCambiarContra.setAttribute('disabled','true');
            return false;
        }
    }
    btnCambiarContra.setAttribute('disabled','true');
    return false;
}

const comprobarInfoUsuario = function () {
    editarUsuario.nombre = validarCampo(expresiones.usuario, inputNombre.value, inputNombre.id);
    editarUsuario.control = validarCampo(expresiones.NoControl, inputControl.value, inputControl.id);
    if (editarUsuario.nombre && editarUsuario.control){
        if (inputNombre.value == editarUsuario.tNombre && inputControl.value == editarUsuario.tControl && selectRol.value == editarUsuario.eRol){
            btnGuardarCambios.setAttribute('disabled','true');
            return false;
        }else{
            btnGuardarCambios.removeAttribute('disabled');
            return true;
        }
    }
    btnGuardarCambios.setAttribute('disabled','true');
    return false;
}

const comprobarTuInformacion = function () {
    tuInformacion.nombre = validarCampo(expresiones.usuario, inputTuNombre.value, inputTuNombre.id);
    tuInformacion.control = validarCampo(expresiones.NoControl, inputTuControl.value, inputTuControl.id);
    if (tuInformacion.nombre == true && tuInformacion.control == true){
        if (inputTuNombre.value == tu_Nombre && inputTuControl.value == tu_control){
            btnGuardarTuInformacion.setAttribute('disabled','true');
            return false;
        }else{
            btnGuardarTuInformacion.removeAttribute('disabled');
            return true;
        }
    }
    btnGuardarTuInformacion.setAttribute('disabled','true');
    return false;
}

const insertarFila = function (datos) {                       
    var fila = document.createElement('tr');
    fila.setAttribute('data-accion', 'usuario');
    fila.setAttribute('class', 'contenido');
    fila.setAttribute('data-usuario', `${datos[0]}`);
    datos[6] = (datos[6] == 1 ? 'activo' : 'inactivo');

    for (var i = 0; i < textos.length; i++) {
        var celda = document.createElement('td');
        celda.setAttribute('data-accion', 'usuario');
        celda.setAttribute('data-usuario', `${datos[0]}`);
        celda.textContent = textos[i];

        fila.appendChild(celda);
        tablaUsuarios.appendChild(fila);
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
}

const activarMenuDesplegable = function (e) {
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
        liEditar.setAttribute('data-bs-toggle', 'modal');
        liEditar.setAttribute('data-bs-target', '#editarUsuario');
        liEstado.textContent = 'Cambiar Estado';
        liEstado.setAttribute('data-usuario',`${e.target.dataset.usuario}`);
        
        // Agregar elementos li a la lista
        ul.appendChild(liEditar);
        ul.appendChild(liEstado);

        liEditar.addEventListener('click', (el) => {
            const formData = new FormData();
            formData.append('usuario', 'getUser');
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
                        document.querySelector('#editarUsuario .modal-header h1').innerHTML = `Editar Usuario <br/> ${respuesta.datos.nombre}`;
                        inputNombre.value = `${respuesta.datos.nombre}`;
                        inputControl.value = `${respuesta.datos.numControl}`;
                        if (respuesta.datos.rol == 'administrador'){
                            document.querySelector(`${selectRol.tagName.toLowerCase()} option[value="2"]`).removeAttribute('selected');
                            document.querySelector(`${selectRol.tagName.toLowerCase()} option[value="1"]`).setAttribute('selected','true');
                            editarUsuario.eRol = 1;
                        }else{
                            document.querySelector(`${selectRol.tagName.toLowerCase()} option[value="1"]`).removeAttribute('selected');
                            document.querySelector(`${selectRol.tagName.toLowerCase()} option[value="2"]`).setAttribute('selected','true');
                            editarUsuario.eRol = 2;
                        }
                        editarUsuario.nombre = validarCampo(expresiones.usuario, inputNombre.value, inputNombre.id);
                        editarUsuario.control = validarCampo(expresiones.NoControl, inputControl.value, inputControl.id);
                        editarUsuario.tNombre = `${respuesta.datos.nombre}`;
                        editarUsuario.tControl = `${respuesta.datos.numControl}`;
                        editarUsuario.iduser = e.target.dataset.usuario;
                        comprobarInfoUsuario();
                    } else {
                        // La operación en el servidor no fue exitosa
                        alert(respuesta.message);
                    }
                    activarEscuchadoresMenuDesplegable();
                },
                error: function (error) {
                    // Manejar errores en la solicitud AJAX
                    console.log('Error en la solicitud AJAX:', error.responseText);
            }});
        });

        liEstado.addEventListener('click', (e2) => {
            const formData = new FormData();
            formData.append('usuario', 'estado');
            formData.append('usuario_id', e.target.dataset.usuario);
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
                        tablaUsuarios.innerHTML = '';
                        for (var i = 0; i < respuesta.datos.length; i++) {
                            textos = [
                                respuesta.datos[i].eCodeUsuario,
                                respuesta.datos[i].tNombreUsuario,
                                respuesta.datos[i].tNumControlUsuario,
                                respuesta.datos[i].tRolUsuario,
                                respuesta.datos[i].fCreateUsuario,
                                respuesta.datos[i].fUpdateUsuario,
                                respuesta.datos[i].bEstadoUsuario
                            ];
                            
                            insertarFila(textos);
                        }
                        activarEscuchadoresMenuDesplegable();
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
    menuDesplegable.style.display = 'block';
    menuDesplegable.style.left = e.clientX + 'px';
    menuDesplegable.style.top = e.clientY + 'px';
}

const GuardarCambios = function () {
    if (comprobarInfoUsuario()){
        if (confirm('Seguro que quieres cambiar la información de este usuario?')){
            const formData = new FormData()
            formData.append('nombre', inputNombre.value);
            formData.append('control', inputControl.value);
            formData.append('rol', selectRol.value);
            formData.append('usuario', 'actualizar');
            formData.append('usuario_id', editarUsuario.iduser)
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
                        editarUsuario.tcontrol = undefined;
                        editarUsuario.tnombre = undefined;
                        editarUsuario.eRol = undefined;
                        editarUsuario.iduser = undefined;
                        editarUsuario.control = false;
                        editarUsuario.nombre = false;
                        inputControl.value = '';
                        inputNombre.value = '';
                        document.querySelector(`${selectRol.tagName.toLowerCase()} option[value="1"]`).removeAttribute('selected');
                        document.querySelector(`${selectRol.tagName.toLowerCase()} option[value="2"]`).removeAttribute('selected');
                        document.querySelector('#editarUsuario .modal-footer button.btn-secondary').click();
                        tablaUsuarios.innerHTML = '';
                        for (var i = 0; i < respuesta.datos.length; i++) {
                            textos = [
                                respuesta.datos[i].eCodeUsuario,
                                respuesta.datos[i].tNombreUsuario,
                                respuesta.datos[i].tNumControlUsuario,
                                respuesta.datos[i].tRolUsuario,
                                respuesta.datos[i].fCreateUsuario,
                                respuesta.datos[i].fUpdateUsuario,
                                respuesta.datos[i].bEstadoUsuario
                            ];
                            
                            insertarFila(textos);
                        }
                        activarEscuchadoresMenuDesplegable();
                    } else {
                        // La operación en el servidor no fue exitosa
                        alert(respuesta.message);
                    }
                },
                error: function (error) {
                    // Manejar errores en la solicitud AJAX
                    console.log('Error en la solicitud AJAX:', error.responseText);
            }});
        }
    }
}

const guardarContra = function () {
    if (comprobarCambioContra()){
        if (confirm('seguro que quiere cambiar su contraseña?')){
            const formData = new FormData();
            formData.append('passA', inputPassA.value);
            formData.append('passN', inputPassN.value);
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
                        document.querySelector('#cambiarContra .modal-footer button.btn-secondary').click();
                        inputPassA.value = '';
                        inputPassN.value = '';
                        inputPassN2.value = '';
                        inputPassA.classList.remove('is-valid');
                        inputPassN2.classList.remove('is-valid');
                        inputPassN.classList.remove('is-valid');
                    } else if (respuesta.code === '1'){
                        alert(respuesta.message);
                    }else if (respuesta.code === '3'){
                        inputPassA.classList.remove('is-valid');
                        inputPassA.classList.add('is-invalid');
                        document.querySelector('#feedback-pass').innerHTML = 'La contraseña es incorrecta';
                        setTimeout(()=>{
                            document.querySelector('#feedback-pass').innerHTML = 'minimo 8 caracteres';
                        }, 3000);
                    }else if(respuesta.code === '2'){
                        inputPassN2.classList.remove('is-valid');
                        inputPassN2.classList.add('is-invalid');
                        document.querySelector('#feedback-passN2').innerHTML = 'La contraseña no puede ser la misma que la actual';
                        inputPassN2.addEventListener('keypress',()=>{
                            document.querySelector('#feedback-passN2').innerHTML = 'minimo 8 caracteres';
                        })
                    }else if (respuesta.code === '4'){
                        window.location = '../db/cerrarSesion';
                    }
                },
                error: function (error) {
                    // Manejar errores en la solicitud AJAX
                    console.log('Error en la solicitud AJAX:', error.responseText);
            }});
        }
    }
}

const cambiarVisualizacionContra = function (e) {
    let padre = e.target.parentNode;
    if (e.target.tagName == 'I')
        padre = padre.parentNode;
    if (padre.children[0].children[0].classList.contains('fa-eye-slash')){
        padre.children[1].removeAttribute('type');
        padre.children[1].setAttribute('type','text');
        padre.children[0].children[0].classList.remove('fa-eye-slash');
        padre.children[0].children[0].classList.add('fa-eye');
    }else{
        padre.children[1].removeAttribute('type');
        padre.children[1].setAttribute('type','password');
        padre.children[0].children[0].classList.remove('fa-eye');
        padre.children[0].children[0].classList.add('fa-eye-slash');
    }
    
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


btnGuardarTuInformacion.addEventListener('click', guardarTuInformacion);
inputs.forEach((input)=>{
    input.addEventListener('keypress', validarForm);
    input.addEventListener('keyup', validarForm);
});
btnShow.forEach((element) => {
    element.addEventListener('click', cambiarVisualizacionContra)
});
btnCambiarContra.addEventListener('click', guardarContra);
selectRol.addEventListener('change', comprobarInfoUsuario);
btnGuardarCambios.addEventListener('click', GuardarCambios);
comprobarTuInformacion();
activarEscuchadoresMenuDesplegable();