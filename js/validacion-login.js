const inputs = document.querySelectorAll('form input')
const form_sesion = document.querySelector('.login-card-form')
const button_sesion = document.querySelector('button[type="button"]')
const candado = document.querySelector('.login-card-form .lock')
const salir = document.querySelector('.login-card-button-exit span')

let mostrar = false

const sesion = {
    control: false,
    contra: false
}

const validarForm = (e) => {
    switch (e.target.name){
        case 'control':
            sesion.control = validarCampo(expresiones.NoControl, e.target.value, e.target.id)
        break;
        case 'contra':
            sesion.contra = validarCampo(expresiones.contra, e.target.value, e.target.id)
        break;
    }
}

const submit = function (){
    let control = form_sesion.elements[0],
    contra = form_sesion.elements[1]
    sesion.control  = validarCampo(expresiones.NoControl,   control.value,  control.id  )
    sesion.contra   = validarCampo(expresiones.contra,      contra.value,   contra.id   ) 
    if (sesion.control == true && sesion.contra == true){
        form_sesion.submit()
    }
}

inputs.forEach((input) => {
    input.addEventListener('keyup',validarForm)
    input.addEventListener('blur',validarForm)
})

button_sesion.addEventListener('click', () => {
    submit()
})

candado.addEventListener('click', () => {
    if (mostrar == false){
        form_sesion.elements[1].removeAttribute('type')
        form_sesion.elements[1].setAttribute('type','text')
        mostrar = true
    }else {
        form_sesion.elements[1].removeAttribute('type')
        form_sesion.elements[1].setAttribute('type','password')
        mostrar = false
    }
})

salir.addEventListener('click', () => {
    window.location = ''
})