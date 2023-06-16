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

const validarForm = (e) => {
    switch(e.target.name){
        case 'usuario-nombre':
            editarUsuario.nombre = validarCampo(expresiones.usuario, e.target.value, e.target.id);
            comprobarInfoUsuario();
        break;
        case 'usuario-control':
            editarUsuario.control = validarCampo(expresiones.NoControl, e.target.value, e.target.id);
            comprobarInfoUsuario();
        break;
        case 'tu-nombre':
            tuInformacion.nombre = validarCampo(expresiones.usuario, e.target.value, e.target.id);
            comprobarTuInformacion();
        break;
        case 'tu-control':
            tuInformacion.control = validarCampo(expresiones.NoControl, e.target.value, e.target.id);
            comprobarTuInformacion();
        break;
        }
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
                        alert(respuesta.menssaje);
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
}

const GuardarCambios = function () {
    if (comprobarInfoUsuario()){
        if (confirm('Seguro que quieres cambiar la información de este usuario?')){
            const formData = new FormData()
            formData.append('nombre', inputNombre.value);
            formData.append('control', inputControl.value);
            formData.append('rol', selectRol.value);
            formData.append('usuario', 'insertar');
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
                        alert(respuesta.menssaje);
                    }
                },
                error: function (error) {
                    // Manejar errores en la solicitud AJAX
                    console.log('Error en la solicitud AJAX:', error.responseText);
            }});
        }
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
selectRol.addEventListener('change', comprobarInfoUsuario);
btnGuardarCambios.addEventListener('click', GuardarCambios);
comprobarTuInformacion();
activarEscuchadoresMenuDesplegable();