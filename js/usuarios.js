const inputs = document.querySelectorAll('input');
const inputTuNombre = document.querySelector('#tu-nombre');
const inputTuControl = document.querySelector('#tu-control');
const btnGuardarTuInformacion = document.querySelector('.container-infoUser .btn.btn-outline-success');

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
        if (tuInformacion.nombre == tu_Nombre && tuInformacion.control == tu_control){
            btnGuardarTuInformacion.removeAttribute('disabled');
        }else{
            btnGuardarTuInformacion.setAttribute('disabled','true');
        }
    }
}
inputTuNombre.addEventListener('keyup', comprobarTuInformacion);
inputTuNombre.addEventListener('keypress', comprobarTuInformacion);
inputTuControl.addEventListener('keyup', comprobarTuInformacion);
inputTuControl.addEventListener('keypress', comprobarTuInformacion);
comprobarTuInformacion();