const expresiones = {                                                               // expreciones para validar los inputs
	usuario: /^[a-zA-Z\s]+$/, // Letras, numeros, guion y guion_bajo
	contra: /^.{0}\w{8,30}$/,  // 8 a 20 digitos.
    contraS: /^.{0}\w{1,20}$/, // 1 a 20 digitos
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    NoControl: /^\d{4}$/,
    CURP: /^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/
}

const validarCampoLogin = (exprecion, value, campo) => {
    if (value == '') {
        document.getElementById(`${campo}`).classList.remove('valid');
        document.getElementById(`${campo}`).classList.remove('invalid');
    }else if (exprecion.test(value)){
        document.getElementById(`${campo}`).classList.remove('invalid');
        document.getElementById(`${campo}`).classList.add('valid');
        return true;
    }else{
        document.getElementById(`${campo}`).classList.remove('valid');
        document.getElementById(`${campo}`).classList.add('invalid');
        return false;
    }
}

const validarCampo = (exprecion, value, campo) => {
    if (exprecion.test(value)){
        document.getElementById(`${campo}`).classList.remove('is-invalid');
        document.getElementById(`${campo}`).classList.add('is-valid');
        return true;
    }else{
        document.getElementById(`${campo}`).classList.remove('is-valid');
        document.getElementById(`${campo}`).classList.add('is-invalid');
        return false;
    }
}

const validarPassword = (campo) => {
    if ((document.getElementById(`${campo}`).value == document.getElementById(`${campo + "2"}`).value) && ((document.getElementById(`${campo}`).value != "") && (document.getElementById(`${campo + "2"}`).value != ""))){
        document.getElementById(`${campo}`).classList.remove('is-invalid');
        document.getElementById(`${campo}`).classList.add('is-valid');
        return true;
    }else{
        document.getElementById(`${campo}`).classList.remove('is-valid');
        document.getElementById(`${campo}`).classList.add('is-invalid');
        return false;
    }
}