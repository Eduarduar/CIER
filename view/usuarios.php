<?php

    session_start();

    include '../db/consultas.php';

    if (!isset($_SESSION['eCodeUsuario']) and !isset($_SESSION['tNombreUsuario']) and !isset($_SESSION['tRolUsuario'])){
        header('location: ./login');
    }else if ($_SESSION['tRolUsuario'] !== 'administrador'){
        header('location: ./index');
    }

    $consulta = new consultas();

    $info_tu_user = $consulta->consultar("SELECT tNombreUsuarios, tNumControlUsuarios FROM usuarios WHERE eCodeUsuarios = " . $_SESSION['eCodeUsuario']);
    if (!$info_tu_user->rowCount()){
        header('location: ./index');
    }

    foreach($info_tu_user as $user){
        $tu_nombre = $user['tNombreUsuarios'];
        $tu_control = $user['tNumControlUsuarios'];
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Usuarios - CIER</title>
        <link rel="stylesheet" href="https://bootswatch.com/5/lux/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="../css/usuarios.css">
        <link rel="stylesheet" href="../css/header.css">
    </head>
    <body>

        <?php include_once '../utilities/header.php'; ?>

        <main>

            <div class="container-center main">
                
                <div class="container-infoUser col-md-6">
                    <h2>Tu información</h2>
                    <div class="mb-3 col-md-6">
                        <label for="tu-nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="tu-nombre" name="tu-nombre" value="<?php echo $tu_nombre; ?>">
                        <div class="valid-feedback">El nombre no es valido</div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="tu-control" class="form-label">No. Control</label>
                        <input type="number" class="form-control no-arrows" id="tu-control" name="tu-control" value="<?php echo $tu_control; ?>">
                        <div class="valid-feedback">El numero de control es invalido</div>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-outline-success">Guardar Cambios</button>
                        <button type="button" class="btn btn-info">Cambiar contraseña</button>
                    </div>
                </div>
                    
                <div class="container-users table-responsive">
                    <h2>Usuarios</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">No.Control</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Creado</th>
                                <th scope="col">Update</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $usuarios = $consulta->consultar("SELECT u.eCodeUsuarios, u.tNombreUsuarios, u.tNumControlUsuarios, r.tNombreRol AS tRolUsuarios, u.fCreateUsuarios, u.fUpdateUsuarios, u.bEstadoUsuarios
                                FROM usuarios u
                                INNER JOIN roles r ON u.eRolUsuarios = r.eCodeRol
                                WHERE u.eCodeUsuarios <> " . $_SESSION['eCodeUsuario'] . ";");
                                if ($usuarios->rowCount()){
                                    foreach($usuarios as $usuario){
                                        ?>
                                            <tr>
                                                <td><?php echo $usuario['eCodeUsuarios']; ?></td>
                                                <td><?php echo $usuario['tNombreUsuarios']; ?></td>
                                                <td><?php echo $usuario['tNumControlUsuarios']; ?></td>
                                                <td><?php echo $usuario['tRolUsuarios']; ?></td>
                                                <td><?php echo $usuario['fCreateUsuarios']; ?></td>
                                                <td><?php echo $usuario['fUpdateUsuarios']; ?></td>
                                                <td><?php echo $usuario['bEstadoUsuarios']; ?></td>
                                            </tr>
                                        <?php
                                    }
                                }else{
                                    echo '<td colspan="7" class="noUsuarios">No hay mas usuarios</td>';
                                }
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </main>

        <script>
            const id_user = <?php echo $_SESSION['eCodeUsuario']; ?>;
            document.querySelector('header button.btn-outline-success').classList.add('btn-success');
            document.querySelector('header button.btn-outline-success').classList.remove('btn-outline-success');
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../js/header.js"></script>
        <script src="../js/validacion.js"></script>
        <script src="../js/usuarios.js"></script>
        
    </body>
</html>