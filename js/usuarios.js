const inputs = document.querySelectorAll('input');
const input_tuNombre = document.querySelector('#tu-nombre');
const input_tuControl = document.querySelector('#tu-control');

const tu_Nombre = input_tuNombre.value;
const tu_control = input_tuControl.value;

input_tuNombre.addEventListener('change', comprobarTuInformacion);
input_tuControl.addEventListener('change', comprobarTuInformacion);

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
    tuInformacion.nombre = validarCampo(expresiones.usuario, input_tuNombre.value, input_tuNombre.id);
    tuInformacion.control = validarCampo(expresiones.NoControl, input_tuControl.value, input_tuControl.id);
    if (tuInformacion.nombre && tuInformacion.control){
        if (tuInformacion.nombre == tu_Nombre && tuInformacion.control == tu_control){

        }else{
            
        }
    }
}