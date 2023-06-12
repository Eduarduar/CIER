let btn_cerrar_sesion = document.querySelector('.btn-danger')

btn_cerrar_sesion.addEventListener('click', () => {
    window.location = '../db/cerrarSesion'
})