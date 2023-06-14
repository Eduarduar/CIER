<header>
    <div class="container-center">
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-bottom-dark" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">C.I.E.R.</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./proyectos">Proyectos</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown link
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">aaaa</a></li>
                                <li><a class="dropdown-item" href="#">aaaa</a></li>
                                <li><a class="dropdown-item" href="#">aaaa</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./cuerposAcademicos">Cuerpos Académicos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./publicaciones">Publicaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./estancias">Estancias de investigación</a>
                        </li>
                    </ul>
                    <?php 
                        if ($_SESSION['tRolUsuario'] === 'administrador'){
                            echo '<button class="btn btn-outline-success" id="btn_usuarios"><span class="fa fa-users" aria-hidden="true"></span></button>';
                        }else{
                            echo $_SESSION['tRolUsuario'];
                        }
                    ?>
                    <button class="btn btn-outline-danger" id="btn_cerrarSesion" type="button">Cerrar sesión</button>
                </div>
            </div>
        </nav>
    </div>
</header>