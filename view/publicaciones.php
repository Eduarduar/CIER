<?php

    session_start();

    if (!isset($_SESSION['eCodeUsuario']) and !isset($_SESSION['tNombreUsuario'])){
        header('location: ./login');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicaciones - CIER</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/lux/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/publicaciones.css">
    <link rel="stylesheet" href="../css/controles.css">
    <link rel="stylesheet" href="../css/header.css">
</head>
<body>

    <?php include '../utilities/header.php' ?>

    <main>

        <div class="container-center">
            
            <div class="container-publicador">

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">añadir publicación</button>

            </div>

            <div class="container-publicaciones">

                <div class="container-publicacion">

                    <div class="container-publicacion_header">

                        <span class="publicacion_user">Eduarduar</span>

                        <span class="publicacion_fecha">11/06/2023 12:00</span>

                    </div>

                    <div class="container-publicacion_main">

                        <div class="publicacion_text"><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus quaerat laborum distinctio tempore optio ipsam. Excepturi laudantium id, doloribus voluptas eum labore inventore reprehenderit animi aperiam asperiores earum est sit.</p></div>

                        <div class="publicacion_img"><img src="../img/fondo1.jpg" alt=""></div>

                        <div class="publicacion_pdf">
                            <button>
                                <span class="icon-pdf material-symbols-outlined">picture_as_pdf</span>
                                <span>ver pdf adjunto</span>
                            </button>
                        </div>

                    </div>

                     <!-- solo moderador y admin -->

                    <div class="container-publicacion_footer">

                        <span class="publicacion_eliminar fa fa-times" aria-hidden="true"> Eliminar</span>

                    </div>

                </div>

            </div>

        </div>

    </main>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Publicación</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <label for="publicador-text">texto:</label>
                        <textarea class="publicador-text" id="publicador-text" oninput="autoResize()"></textarea>

                        <div class="container-media">
                            
                            <input type="file" class="pdf form-control" accept="application/pdf">

                            <div class="container-file">
                                <p class="text-file" id="text-file" ><span class="material-symbols-outlined">image</span></p>
                                <input type="file" class="media form-control" name="media" id="media" onchange="" accept="image/*">
                            </div>

                            <div class="vista">

                                <img src="" alt="" id="img-foto" class="img-foto">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="btn-publicar" class="btn btn-primary">Publicar</button>
                    </div>
                </div>
            </div>
        </div>
    
    <div class="modal-container" id="modal-container"></div>
    <script>
        const id_user = <?php echo $_SESSION['eCodeUsuario']; ?>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/header.js"></script>
    <script src="../js/publicaciones.js"></script>
    
    
</body>
</html>