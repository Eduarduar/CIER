let btn_cerrar_sesion = document.querySelector('#btn_cerrarSesion');
let btn_usuarios = document.querySelector('header button.btn-outline-success');

btn_cerrar_sesion.addEventListener('click', () => {
    window.location = '../db/cerrarSesion';
})

btn_usuarios.addEventListener('click', () => {
    window.location = './usuarios';
});