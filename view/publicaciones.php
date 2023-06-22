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
        <link rel="shortcut icon" href="../img/logocier.png" type="image/x-icon">
        <title>Publicaciones - CIER</title>
        <link rel="stylesheet" href="https://bootswatch.com/5/lux/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="../css/publicaciones.css">
        <link rel="stylesheet" href="../css/header.css">
    </head>
    <body>

        <?php include_once '../utilities/header.php' ?>

        <main>

            <div class="container-center">
                
                <div class="container-publicador">

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-publicar">añadir publicación</button>
                    <button type="button" class="btn btn-outline-danger">publicaciones eliminadas</button>
                    <button type="button" class="btn btn-outline-success" style="display:none">publicaciones</button>

                </div>

                <div class="container-publicaciones">

                    <?php
                    
                        $publicaciones = $consulta->consultar("SELECT p.eCodePublicaciones, u.tNombreUsuarios, p.tMensajePublicaciones, p.tImgPublicaciones, p.tPdfPublicaciones, p.fCreatePublicaciones, tp.tNombreTipoPublicaciones
                        FROM publicaciones p
                        JOIN usuarios u ON p.eUserPublicaciones = u.eCodeUsuarios
                        JOIN tipopublicaciones tp ON p.eTipoPublicaciones = tp.eCodeTipoPublicaciones
                        WHERE p.bEstadoPublicaciones = 1
                        GROUP BY p.eCodePublicaciones DESC
                        ");
                        if ($publicaciones->rowCount()){
                            foreach($publicaciones as $publicacion){
                                
                                ?>
                                
                                <div class="container-publicacion">

                                    <div class="container-publicacion_header">

                                        <span class="publicacion_user"><?php echo $publicacion['tNombreUsuarios'] . ' - ' . $publicacion['tNombreTipoPublicaciones']; ?></span>

                                        <span class="publicacion_fecha"><?php echo $publicacion['fCreatePublicaciones']; ?></span>

                                    </div>

                                    <div class="container-publicacion_main">

                                        <div class="publicacion_text"><p><?php echo $publicacion['tMensajePublicaciones'];?></p></div>

                                        <?php
                                        
                                            if ($publicacion['tImgPublicaciones'] != NULL){

                                                ?>
                                                
                                                    <div class="publicacion_img"><img src="<?php echo $publicacion['tImgPublicaciones'];?>"></div>
                                                
                                                <?php

                                            }

                                            if ($publicacion['tPdfPublicaciones'] != NULL){
                                                ?>
                                                    
                                                    <div class="publicacion_pdf">
                                                        <button  data-bs-toggle="modal" data-bs-target="#modal-pdf" data-pdf="<?php echo $publicacion['tPdfPublicaciones']; ?>">
                                                            <span class="icon-pdf material-symbols-outlined"  data-pdf="<?php echo $publicacion['tPdfPublicaciones']; ?>">picture_as_pdf</span>
                                                            <span data-pdf="<?php echo $publicacion['tPdfPublicaciones']; ?>">ver pdf adjunto</span>
                                                        </button>
                                                    </div>
                                                
                                                <?php
                                            }
                                        
                                        ?>

                                    </div>

                                    <!-- solo moderador y admin -->

                                    <div class="container-publicacion_footer">

                                        <span class="publicacion_eliminar fa fa-times" data-eliminar="<?php echo $publicacion['eCodePublicaciones'];?>" aria-hidden="true"> Eliminar</span>

                                    </div>

                                </div>

                                
                                <?php

                            }
                        }
                    
                    ?>

                </div>

            </div>

        </main>

        <div class="modal fade" id="modal-publicar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Publicación</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <textarea class="publicador-text" id="publicador-text" oninput="autoResize()"></textarea>

                        
                        <label for="tipo_publicacion" class="form-label">Tipo de publicacion</label>
                        <select class="form-select" id="tipo_publicacion" name="tipo_publicacion" aria-label=".form-select-lg">
                            <?php 
                            
                                $tipos = $consulta->consultar("SELECT * FROM tipopublicaciones ORDER BY eCodeTipoPublicaciones");
                                foreach($tipos as $tipo){
                                    echo '<option value="'. $tipo['eCodeTipoPublicaciones'] .'">'. $tipo['tNombreTipoPublicaciones'] .'</option>';
                                }
                            ?>
                        </select>

                        <div class="container-media">
                            
                            <p class="text-pdf" id="text-pdf"><span class="material-symbols-outlined">picture_as_pdf</span>
                            <input type="file" class="pdf form-control" accept="application/pdf"></p>

                            <p class="text-file" id="text-file" ><span class="material-symbols-outlined">image</span>
                            <input type="file" class="media form-control" name="media" id="media" accept="image/*"></p>

                        </div>
                        
                        <div class="vista">

                            <img src="" id="img-view" class="img-view">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="btn-publicar" class="btn btn-primary">Publicar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-xl" id="modal-pdf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <iframe id="pdfPreview" src="" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../utilities/estructuras.php'; ?>
        
        <div class="modal-container" id="modal-container"></div>
        <script>
            const id_user = <?php echo $_SESSION['eCodeUsuario']; ?>
        </script>
        <script src="https://kit.fontawesome.com/b47dcd53a4.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../js/validacion.js"></script>
        <script src="../js/header.js"></script>
        <script src="../js/publicaciones.js"></script>
        <script>
            activarModalImg()
        </script>
        
        
        
    </body>
</html>