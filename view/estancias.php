<?php

    session_start();

    if (!isset($_SESSION['eCodeUsuario']) and !isset($_SESSION['tNombreUsuario'])){
        header('location: ./login');
    }

    include '../db/consultas.php';    
    $consulta = new consultas();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../img/logocier.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estancias - CIER</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/lux/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/estancias.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>

    <?php include '../utilities/header.php' ?>

    <main>

        <div class="container-center">

            <div class="container-buttons">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarEstancia">Agregar Estancia</button>
                <button class="btn btn-outline-danger">Estancias Eliminadas</button>
                <button class="btn btn-outline-success" style="display:none">Estancias</button>
            </div>

            <div class="container-estancias">

            <?php
            
                $estancias = $consulta->consultar("SELECT est.eCodeEstancias, est.tNombreEstancias, est.tProvenienciaEstancias, est.tProyectoEstancias, est.fFechaEstancias, est.tInstalacionesEstancias, te.tNombreTipoEstancia AS tTipoEstancia, est.tLinksEstancias, est.tImgsEstancias, est.fCreateEstancias, est.fUpdateEstancias, uc.tNombreUsuarios AS tCreateUsuario, uu.tNombreUsuarios AS tUpdateUsuario, est.bEstadoEstancias
                FROM estancias est
                LEFT JOIN tipoestancia te ON est.eTipoEstancias = te.eCodeTipoEstancia
                LEFT JOIN usuarios uc ON est.eCreateEstancias = uc.eCodeUsuarios
                LEFT JOIN usuarios uu ON est.eUpdateEstancias = uu.eCodeUsuarios
                WHERE est.bEstadoEstancias = 1
                ORDER BY est.eCodeEstancias DESC;");

                if ($estancias->rowCount()){
                    foreach($estancias as $estancia){
                        $index = 0;

                        $links = encontrarEnlacesYouTubeYFacebook($estancia['tLinksEstancias']);

                        ?>
                            
                            <div class="card container-estancia contenido" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                <div class="card-body" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                    <p class="card-text" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                        <small class="text-body-secondary" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa"><?php echo $estancia['fCreateEstancias']; ?> - <strong><?php echo $estancia['tCreateUsuario']; ?></strong></small>
                                    </p>
                                    <div class="card-text" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                        <span data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa"><?php echo $estancia['tNombreEstancias'];  if ($estancia['tProvenienciaEstancias'] != ''){echo ' - <strong>' . $estancia['tProvenienciaEstancias'] . '</strong>'; } ?></span>
                                        <ul data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                            <li data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                <strong data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">Fecha: </strong><?php echo $estancia['fFechaEstancias']; ?>
                                            </li>
                                            <li data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                <strong data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">Proyecto: </strong><?php echo $estancia['tProyectoEstancias']; ?>
                                            </li data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                            <li data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                <strong data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">Instalaciones: <?php echo $estancia['tInstalacionesEstancias']; ?></strong>
                                            </li>
                                            <li data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                <strong data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">Tipo: </strong><?php echo $estancia['tTipoEstancia']; ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <?php
                                
                                    if (!empty($links)){ 

                                        ?>
                                        
                                            <div class="card-img-bottom" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                <div id="carrusel<?php echo $estancia['eCodeEstancias']; ?>" class="carousel slide videos" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                    <div class="carousel-inner" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">

                                                    <?php
                                                        foreach($links as $link){
                                                            
                                                            // if (verificarFacebook(obtenerEnlaceRedSocial($link)) == true){
                                                            //     echo obtenerEnlaceRedSocial($link);
                                                            // }else{
                                                            //     echo obtenerEnlaceRedSocial($link);
                                                            // }

                                                            // echo obtenerURLEmbed($link);

                                                            if ($index == 0){
                                                                if (verificarFacebook(obtenerEnlaceRedSocial($link)) == true){
                                                                    ?>
                                                                        <div class="carousel-item active" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                                            <div class="container-facebook" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                                                <iframe class="facebook" type="text/html" src="<?php echo obtenerEnlaceRedSocial($link); ?>" frameborder="0" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa" allowfullscreen></iframe>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                        <div class="carousel-item active" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                                            <iframe type="text/html" src="<?php echo obtenerEnlaceRedSocial($link); ?>" frameborder="0" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa" allowfullscreen></iframe>
                                                                        </div>
                                                                    <?php
                                                                }
                                                            }else{
                                                                if (verificarFacebook(obtenerEnlaceRedSocial($link)) == true){
                                                                    ?>
                                                                        <div class="carousel-item" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                                            <div class="container-facebook" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                                                <iframe class="facebook" type="text/html" src="<?php echo obtenerEnlaceRedSocial($link); ?>" frameborder="0" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa" allowfullscreen></iframe>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                        <div class="carousel-item" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                                            <iframe type="text/html" src="<?php echo obtenerEnlaceRedSocial($link); ?>" frameborder="0" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa" allowfullscreen></iframe>
                                                                        </div>
                                                                    <?php
                                                                }
                                                            }

                                                            $index++;
                                                        }
                                                        $index = 0
                                                    
                                                    ?>

                                                    </div>
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#carrusel<?php echo $estancia['eCodeEstancias']; ?>" data-bs-slide="prev" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa"></span>
                                                        <span class="visually-hidden" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#carrusel<?php echo $estancia['eCodeEstancias']; ?>" data-bs-slide="next" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                        <span class="carousel-control-next-icon" aria-hidden="true" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa"></span>
                                                        <span class="visually-hidden" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">Next</span>
                                                    </button>
                                                </div>
                                            </div>
                                
                                        <?php

                                    }                                   
                                
                                ?>
                    
                                <div class="card-img-bottom" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                    <div id="carrusel<?php echo $estancia['eCodeEstancias'] . '1'; ?>" class="carousel slide" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                        <div class="carousel-inner" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">

                                        <?php

                                            $imgs = explode(",", $estancia['tImgsEstancias']);

                                            foreach($imgs as $img){

                                                if($index == 0){
                                                    ?>
                                                    
                                                        <div class="carousel-item active" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                            <img src="<?php echo $img; ?>" class="d-block w-100" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                        </div>
                                                    
                                                    <?php
                                                }else{
                                                    ?>
                                                    
                                                        <div class="carousel-item" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                            <img src="<?php echo $img; ?>" class="d-block w-100" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                                        </div>
                                                    
                                                    <?php
                                                }
                                                $index++;
                                            }
                                        
                                        ?>
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carrusel<?php echo $estancia['eCodeEstancias'] . '1'; ?>" data-bs-slide="prev" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                            <span class="carousel-control-prev-icon" aria-hidden="true" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa"></span>
                                            <span class="visually-hidden" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carrusel<?php echo $estancia['eCodeEstancias'] . '1'; ?>" data-bs-slide="next" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">
                                            <span class="carousel-control-next-icon" aria-hidden="true" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa"></span>
                                            <span class="visually-hidden" data-estancia="<?php echo $estancia['eCodeEstancias']; ?>" data-accion="estancia_activa">Next</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                        <?php
                    }
                }

            ?>


            </div>        
        </div>
    </main>

    <?php include '../utilities/footer.php'; ?>
        
        <div id="menuDesplegable" class="menu">
            <ul>
            </ul>
        </div>
        <div class="modal fade" id="agregarEstancia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Estancia</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre*</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" >
                            <div class="invalid-feedback">El nombre no es valido</div>
                        </div>
                        <div class="mb-3">
                            <label for="proveniencia" class="form-label">Lugar de proveniencia</label>
                            <input type="text" class="form-control" id="proveniencia" name="proveniencia">
                            <div class="invalid-feedback">El texto no es valido</div>
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha*</label>
                            <input type="date" class="form-control" id="fecha" name="fecha">
                        </div>
                        <div class="mb-3">
                            <label for="proyecto" class="form-label">Proyecto*</label>
                            <input type="text" class="form-control" id="proyecto" name="proyecto">
                            <div class="invalid-feedback">El nombre del proyecto no es valido</div>
                        </div>
                        <div class="mb-3">
                            <label for="instalaciones" class="form-label">Instalaciones*</label>
                            <input type="text" class="form-control" id="instalaciones" name="instalaciones">
                            <div class="invalid-feedback">El nombre no es valido</div>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de Estancia*</label>
                            <select class="form-select" id="tipo" aria-label=".form-select-lg">
                                <?php 
                                    $tipos = $consulta->consultar("SELECT * FROM tipoestancia ORDER BY eCodeTipoEstancia");
                                    foreach($tipos as $tipo){
                                        echo '<option value="'. $tipo['eCodeTipoEstancia'] .'">'. $tipo['tNombreTipoEstancia'] .'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="links" class="form-label">links de videos (youtube o facebook)</label>
                            <input type="text" class="form-control" id="links" name="links">
                        </div>
                        <div class="container-media">

                            <p class="text-file" id="text-file" ><span class="material-symbols-outlined">photo_library</span>
                            <input type="file" class="media form-control" name="imgs[]" id="media" accept="image/*" multiple></p>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="btn-publicar" class="btn btn-primary" disabled>Agregar</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../utilities/estructuras.php'; ?>

    <script>
        const id_user = <?php echo $_SESSION['eCodeUsuario']; ?>;
    </script>
    <script src="https://kit.fontawesome.com/b47dcd53a4.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script> -->
    <script src="../js/header.js"></script>
    <script src="../js/validacion.js"></script>
    <script src="../js/estancias.js"></script>
    
</body>
</html>
