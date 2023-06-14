<?php

    session_start();

    if (isset($_SESSION['eCodeUsuario']) and isset($_SESSION['tNombreUsuario']) and isset($_SESSION['tRolUsuario'])){
        header('location: ./index');
    }

    include_once '../db/consultas.php';
    $consultar = new consultas();
    $error = false;
    
    if (isset($_POST['control']) and isset($_POST['contra'])){
        $datos = $consultar->login($_POST['control'], $_POST['contra']);
        if ($datos != false){
            $_SESSION['eCodeUsuario'] = $datos['eCodeUsuario'];
            $_SESSION['tNombreUsuario'] = $datos['tNombreUsuario'];
            $_SESSION['tRolUsuario'] = $datos['tRolUsuario'];
            header('location: ./index');
        }
        $error = true;
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/login.css">
        <link rel="shortcut icon" href="../img/utem.png" type="image/x-icon">
    <link rel="stylesheet" href="https://bootswatch.com/5/lux/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Iniciar de sesión</title>
    </head>
    <body>

        <div class="login-card-container">

            <div class="login-card-button-exit">

                <span id="close" class="material-symbols-outlined">close</span>

            </div>

            <div class="login-card">

                <div class="login-card-logo">

                    <img src="../img/utem_logo_blanco.png" alt="logo">
                
                </div>

                <div class="login-card-header">

                    <h1>INICIAR SESIÓN</h1>

                    <?php
                    
                        if ($error == true){
                            ?> <h4 class="login-card-header-error-container"> Numero de control o contraseña incorrecta </h4><?php
                        }

                    ?>
                    

                </div>

                <form action="./login" method="POST" class="login-card-form">

                    <div class="form-item">
                        <span class="form-item-icon material-symbols-outlined">person</span>
                        <input type="number" class="no-arrows" name="control" id="control" placeholder="No. Control" required>
                        <p class="text-invalid">numero incorrecto</p>
                    </div>

                    <div class="form-item">
                        <span class="form-item-icon material-symbols-outlined lock">lock</span>
                        <input type="password" name="contra" id="contra" placeholder="Contraseña" required>
                        <p class="text-invalid">min 8, max. 30</p>
                    </div>

                    <button type="button">INICIAR</button>

                </form>
                
                <!-- <div class="login-card-footer">

                    You do not have an <a href="">account</a>?

                </div> -->


            </div>

        </div>

        <script src="../js/Evitar_reemvio.js"></script>
        <script src="../js/validacion.js"></script>
        <script src="../js/validacion-login.js"></script>
        
    </body>
</html>