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
                            <a class="nav-link dropdown-toggle contenidoHeader" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-accion="contenedor">
                            Infraestructura
                            </a>
                            <ul class="dropdown-menu contenidoHeader" data-accion="contenedor">
                                <?php
                                
                                    if (isset($consulta)){
                                        $estructuras = $consulta->consultar("SELECT e.eCodeEstructuras, e.tNombreEstructuras, e.tReglamentoEstructuras, e.tPdfEstructuras, e.fCreateEstructuras, e.fUpdateEstructuras, u1.tNombreUsuarios AS tNombreCreateEstructuras, u2.tNombreUsuarios AS tNombreUpdateEstructuras, e.bEstadoEstructuras
                                        FROM estructuras e
                                        JOIN usuarios u1 ON e.eCreateEstructuras = u1.eCodeUsuarios
                                        LEFT JOIN usuarios u2 ON e.eUpdateEstructuras = u2.eCodeUsuarios
                                        WHERE e.eCodeEstructuras = 1;");
                                        
                                        if ($estructuras->rowCount()) {
                                            foreach($estructuras as $estructura){
                                                ?>

                                                    <li data-estructura="<?php echo $estructura['eCodeEstructuras']; ?>" data-accion="estructura" data-estado="activo"><a class="dropdown-item" href="#" data-estructura="<?php echo $estructura['eCodeEstructuras']; ?>" data-accion="estructura" data-estado="activo" data-bs-toggle="modal" data-bs-target="#verEstructura"><?php echo $estructura['tNombreEstructuras']; ?></a></li>
                                                
                                                <?php
                                            }
                                        }
                                    }
                                
                                ?>
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
                        <li class="nav-item">
                            <a class="nav-link" href="./actividades">Actividades Diversas</a>
                        </li>
                    </ul>
                    <?php 
                        if ($_SESSION['tRolUsuario'] === 'administrador'){
                            echo '<button class="btn btn-outline-success" id="btn_usuarios"><i class="fa-solid fa-users fa-xl" style="color: #ffffff;"></i></button>';
                        }
                    ?>
                    <button class="btn btn-outline-danger" id="btn_cerrarSesion" type="button"><i class="fa-solid fa-right-from-bracket fa-xl" style="color: #fff;"></i></button>
                </div>
            </div>
        </nav>
    </div>
</header>