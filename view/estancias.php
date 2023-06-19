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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CIER</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/lux/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/estancias.css">
</head>
<body>

    <?php include '../utilities/header.php' ?>

    <main>

        <div class="container-center">
            <div class="container-estancias">

            <?php
            
                $estancias = $consulta->consultar("SELECT e.eCodeEstancias, e.tTextoEstancias, e.tYoutubeEstancias, e.tImgsEstancias, e.fCreateEstancias, e.fUpdateEstancias, usuariosCreador.tNombreUsuarios AS tNombreCreador, usuariosActualizador.tNombreUsuarios AS tNombreActualizador, e.bEstadoEstancias
                FROM estancias e
                INNER JOIN usuarios AS usuariosCreador ON e.eCreateEstancias = usuariosCreador.eCodeUsuarios
                LEFT JOIN usuarios AS usuariosActualizador ON e.eUpdateEstancias = usuariosActualizador.eCodeUsuarios
                WHERE e.bEstadoEstancias = 1;");

                if ($estancias->rowCount()){
                    $carrusel = 1;
                    foreach($estancias as $estancia){

                        $links = encontrarEnlacesYouTube($estancia['tYoutubeEstancias']);

                        ?>
                            
                            <div class="card container-estancia">
                                <div class="card-body">
                                    <p class="card-text"><small class="text-body-secondary"><?php echo $estancia['fCreateEstancias']; ?></small></p>
                                    <p class="card-text"><?php echo $estancia['tTextoEstancias']; ?></p>
                                </div>
                                <?php
                                
                                    if (!empty($links)){ // seguir con el formato de los videos ------------------------------

                                        ?>
                                        
                                            <div class="card-img-bottom">
                                                <div id="carrusel<?php echo $carrusel; ?>" class="carousel slide videos">
                                                    <div class="carousel-inner">

                                                        <div class="carousel-item active">
                                                            <iframe id="player" type="text/html" width="640" height="360" src="[link]" frameborder="0"></iframe>
                                                        </div>
                                                    </div>
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#carrusel[carruselVideos]" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#carrusel[carruselVideos]" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </button>
                                                </div>
                                            </div>
                                
                                        <?php

                                    }
                                
                                ?>
                    
                                <div class="card-img-bottom">
                                    <div id="carrusel[carruselImagenes]" class="carousel slide">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                            <img src="..." class="d-block w-100">
                                            </div>
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carrusel[carruselImagenes]" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carrusel[carruselImagenes]" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                        <?php

                        $carrusel++;

                    }
                }

            ?>


            </div>        
        </div>


    </main>

    <script>
        const id_user = <?php echo $_SESSION['eCodeUsuario']; ?>;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script> -->
    <script src="../js/header.js"></script>
    <script src="../js/validacion.js"></script>
    <script src="../js/estancias.js"></script>
    
</body>
</html>

<!-- https://www.youtube.com/embed/Qr4FPQxPx54 -->
<!-- https://youtu.be/Qr4FPQxPx54 -->
<!-- https://www.youtube.com/watch?v=Qr4FPQxPx54&list=RDQr4FPQxPx54&start_radio=1 -->


            <!--
                <div class="card container-estancia">
                    <div class="card-body">
                        <p class="card-text"><small class="text-body-secondary">[fecha]</small></p>
                        <p class="card-text">[texto]</p>
                    </div>
                    <div class="card-img-bottom">
                        <div id="carrusel[carrusel]" class="carousel slide videos">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <iframe id="player" type="text/html" width="640" height="360" src="[link]" frameborder="0"></iframe>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carrusel[carrusel]" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carrusel[carrusel]" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-img-bottom">
                        <div id="carrusel[carrusel]" class="carousel slide">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="..." class="d-block w-100">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carrusel[carrusel]" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carrusel[carrusel]" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div> 
            -->

            <!-- <div class="card container-estancia">
                <div class="card-body">
                    <p class="card-text"><small class="text-body-secondary">[fecha]</small></p>
                    <p class="card-text">[texto]</p>

                    <div class="containerLinks">
                        <div class="container-link">

                            <iframe id="player" type="text/html" width="640" height="360" src="[link]" frameborder="0"></iframe>

                        </div>
                    </div>
                </div>
                <div class="card-img-bottom">
                    <div id="carrusel[carrusel]" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="..." class="d-block w-100">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carrusel[carrusel]" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carrusel[carrusel]" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div> -->