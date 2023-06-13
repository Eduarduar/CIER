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
    <title>CIER</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/lux/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/header.css">
</head>
<body>

    <?php include '../utilities/header.php' ?>

    <main>

        

    </main>

    <script src="../js/header.js"></script>
    
</body>
</html>