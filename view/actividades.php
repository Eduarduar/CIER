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
                                    <div class="container-actividad">
                                        <div class="card">
                                            <div class="card-body">
                                                <h2 class="card-title"><?php echo $actividad['tTituloActividades'];?></h2>
                                                <p class="card-text">
                                                <small class="text-body-secondary"><?php echo $actividad['eCreateActividades'];?></small><br>
                                                <small class="text-body-secondary"><?php echo $actividad['fCreateActividades'];?></small>
                                                </p>
                                            </div>
                                            <div class="card-img-bottom">
                                                <div id="carrusel<?php echo $actividad['eCodeActividades'];?>" class="carousel slide">
                                                <div class="carousel-indicators">
                                                    <?php
                                                    
                                                        $links = explode(",", $actividad['tImgsActividades']);
                                                        $i = 0;
                                                        foreach($links as $link){
                                                            if ($i == 0){
                                                                ?>
                                                                    <button type="button" data-bs-target="#carrusel<?php echo $actividad['eCodeActividades'];?>" data-bs-slide-to="<?php echo $i;?>" class="active" aria-current="true" aria-label="Slide <?php echo $i;?>"></button>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                    <button type="button" data-bs-target="#carrusel<?php echo $actividad['eCodeActividades'];?>" data-bs-slide-to="<?php echo $i;?>" aria-label="Slide <?php echo $i;?>"></button>
                                                                <?php
                                                            }
                                                            $i++;
                                                        }
                                                        $i = 0;

                                                    ?>
                                                </div>
                                                <div class="carousel-inner">
                                                    <?php

                                                        $i = 0;
                                                        foreach($links as $link){
                                                            if ($i == 0){
                                                                ?>
                                                                    <div class="carousel-item active">
                                                                        <img src="<?php echo $link;?>" class="d-block w-100">
                                                                    </div>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                    <div class="carousel-item">
                                                                        <img src="<?php echo $link;?>" class="d-block w-100">
                                                                    </div>
                                                                <?php
                                                            }
                                                            $i++;
                                                        }
                                                    ?>
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carrusel<?php echo $actividad['eCodeActividades'];?>" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carrusel<?php echo $actividad['eCodeActividades'];?>" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
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
        <div class="modal fade" id="agregarActividad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">ACtividad</h1>
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

        <script>
            const id_user = <?php echo $_SESSION['eCodeUsuario']; ?>
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../js/header.js"></script>
        <script src="../js/actividades.js"></script>

</body>
</html>


<!-- 
<div class="container-actividad">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">Día Mundial del Medio Ambiente</h2>
                                <p class="card-text">
                                <small class="text-body-secondary">Eduardo Arcega <br> [Eliminado por Eduarod Arcega]</small><br>
                                <small class="text-body-secondary">17/06/2023 - Eliminado[20/06/2024]</small>
                                </p>
                            </div>
                            <div class="card-img-bottom">
                                <div id="carrusel1" class="carousel slide">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carrusel1" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carrusel1" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carrusel1" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    <button type="button" data-bs-target="#carrusel1" data-bs-slide-to="3" aria-label="Slide 4"></button>
                                    <button type="button" data-bs-target="#carrusel1" data-bs-slide-to="4" aria-label="Slide 5"></button>
                                    <button type="button" data-bs-target="#carrusel1" data-bs-slide-to="5" aria-label="Slide 6"></button>
                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="../img/fondo1.jpg" class="d-block w-100">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../img/fondo1.jpg" class="d-block w-100">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../img/fondo1.jpg" class="d-block w-100">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../img/fondo1.jpg" class="d-block w-100">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../img/fondo1.jpg" class="d-block w-100">
                                    </div>
                                    <div class="carousel-item">
                                    <img src="../img/fondo1.jpg" class="d-block w-100">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carrusel1" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carrusel1" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                                </div>
                            </div>
                        </div>
                    </div> -->