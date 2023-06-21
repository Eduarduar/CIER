<?php

    session_start();

    include '../db/consultas.php';

    if (!isset($_SESSION['eCodeUsuario']) and !isset($_SESSION['tNombreUsuario']) and !isset($_SESSION['tRolUsuario'])){
        header('location: ./login');
    }

    $consulta = new consultas();

?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../img/logocier.png" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Actividades Diversas - CIER</title>
        <link rel="stylesheet" href="https://bootswatch.com/5/lux/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="../css/actividades.css">
        <link rel="stylesheet" href="../css/header.css">
</head>
<body>
    
        <?php include_once '../utilities/header.php' ?>

        <main>

            <div class="container-center">

                <div class="container-buttons">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarActividad">Agregar Actividad</button>
                    <button class="btn btn-outline-danger">Actividades Eliminadas</button>
                    <button class="btn btn-outline-success" style="display:none">Actividades</button>
                </div>

                <div class="container-actividades">

                    <?php
                    
                        $actividades = $consulta->consultar("SELECT a.eCodeActividades, a.tTituloActividades, a.tImgsActividades, a.fCreateActividades, a.fUpdateActividades, u1.tNombreUsuarios AS eCreateActividades, u2.tNombreUsuarios AS eUpdateActividades, a.bEstadoActividades
                        FROM actividades a
                        LEFT JOIN usuarios u1 ON a.eCreateActividades = u1.eCodeUsuarios
                        LEFT JOIN usuarios u2 ON a.eUpdateActividades = u2.eCodeUsuarios
                        WHERE a.bEstadoActividades = 1
                        ORDER BY a.eCodeActividades DESC
                        ");
                        
                        if ($actividades->rowCount()){
                            foreach ($actividades as $actividad) {
                                
                                ?>
                                    <div class="container-actividad contenido" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">
                                        <div class="card" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">
                                            <div class="card-body" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">
                                                <h2 class="card-title" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>"><?php echo $actividad['tTituloActividades'];?></h2>
                                                <p class="card-text" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">
                                                <small class="text-body-secondary" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>"><?php echo $actividad['eCreateActividades'];?></small><br>
                                                <small class="text-body-secondary" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>"><?php echo $actividad['fCreateActividades'];?></small>
                                                </p>
                                            </div>
                                            <div class="card-img-bottom" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">
                                                <div id="carrusel<?php echo $actividad['eCodeActividades'];?>" class="carousel slide" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">
                                                <div class="carousel-indicators" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">
                                                    <?php
                                                    
                                                        $links = explode(",", $actividad['tImgsActividades']);
                                                        $i = 0;
                                                        foreach($links as $link){
                                                            if ($i == 0){
                                                                ?>
                                                                    <button type="button" data-bs-target="#carrusel<?php echo $actividad['eCodeActividades'];?>" data-bs-slide-to="<?php echo $i;?>" class="active" aria-current="true" aria-label="Slide <?php echo $i;?>" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>"></button>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                    <button type="button" data-bs-target="#carrusel<?php echo $actividad['eCodeActividades'];?>" data-bs-slide-to="<?php echo $i;?>" aria-label="Slide <?php echo $i;?>" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>"></button>
                                                                <?php
                                                            }
                                                            $i++;
                                                        }
                                                        $i = 0;

                                                    ?>
                                                </div>
                                                <div class="carousel-inner" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">
                                                    <?php

                                                        $i = 0;
                                                        foreach($links as $link){
                                                            if ($i == 0){
                                                                ?>
                                                                    <div class="carousel-item active" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">
                                                                        <img src="<?php echo $link;?>" class="d-block w-100" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">
                                                                    </div>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                    <div class="carousel-item" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">
                                                                        <img src="<?php echo $link;?>" class="d-block w-100" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">
                                                                    </div>
                                                                <?php
                                                            }
                                                            $i++;
                                                        }
                                                    ?>
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carrusel<?php echo $actividad['eCodeActividades'];?>" data-bs-slide="prev" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>"></span>
                                                    <span class="visually-hidden" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carrusel<?php echo $actividad['eCodeActividades'];?>" data-bs-slide="next" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">
                                                    <span class="carousel-control-next-icon" aria-hidden="true" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>"></span>
                                                    <span class="visually-hidden" data-accion="actividad_activa" data-actividad="<?php echo $actividad['eCodeActividades'] ;?>">Next</span>
                                                </button>
                                                </div>
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
        
        <div id="menuDesplegable" class="menu">
            <ul>
            </ul>
        </div>
        <div class="modal fade" id="agregarActividad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Actividad</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Titulo</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" maxlength="100">
                        </div>
                        <div class="container-media">

                            <p class="text-file" id="text-file" ><span class="material-symbols-outlined">photo_library</span>
                            <input type="file" class="media form-control" name="imgs[]" id="media" accept="image/*" multiple></p>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="btn-publicar" class="btn btn-primary">Agregar</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../utilities/estructuras.php'; ?>

        <script>
            const id_user = <?php echo $_SESSION['eCodeUsuario']; ?>
        </script>
    <script src="https://kit.fontawesome.com/b47dcd53a4.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../js/validacion.js"></script>
        <script src="../js/header.js"></script>
        <script src="../js/actividades.js"></script>

</body>
</html>