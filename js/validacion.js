const expresiones = {    // Expresiones para validar los inputs
	usuario: /^(?=.{1,100}$)[a-zA-ZáéíóúÁÉÍÓÚ]+(?:\s[a-zA-ZáéíóúÁÉÍÓÚ]+)*$/,  // Valida un nombre de usuario que contenga letras y espacios, con un máximo de 100 caracteres.
	contra: /^\w{8,30}$/,  // Valida una contraseña de 8 a 30 caracteres.
	contraS: /^\w{1,30}$/,  // Valida una contraseña de 1 a 20 caracteres.
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,  // Valida un formato de correo electrónico válido.
	NoControl: /^\d{4}$/,  // Valida un número de control de 4 dígitos.
	CURP: /^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/,  // Valida el formato de una CURP (Clave Única de Registro de Población) válida en México.
    fecha: /^\d{4}-\d{2}-\d{2}$/,
    links: /^(\s*|((https?:\/\/(?:www\.)?youtube\.com\/(?:watch\?v=|embed\/|v\/)?[\w-]+|https?:\/\/youtu\.be\/[\w-]+|https:\/\/www\.facebook\.com\/plugins\/video\.php\?height=\d+&href=https%3A%2F%2Fwww\.facebook\.com%2F[\w-]+%2Fvideos%2F\d+%2F&show_text=\w+&width=\d+&t=\d+)(\s+|$))+)$/i
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