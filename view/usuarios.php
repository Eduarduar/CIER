<?php

    session_start();

    include '../db/consultas.php';

    if (!isset($_SESSION['eCodeUsuario']) and !isset($_SESSION['tNombreUsuario']) and !isset($_SESSION['tRolUsuario'])){
        header('location: ./login');
    }else if ($_SESSION['tRolUsuario'] !== 'administrador'){
        header('location: ./index');
    }

    $id_user = $_SESSION['eCodeUsuario'];
    
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
        <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="../css/usuarios.css">
        <link rel="stylesheet" href="../css/header.css">
    </head>
    <body>

        <?php include_once '../utilities/header.php'; ?>

        <main>

            <div class="container-center main">
                    
                <div class="container-users">
                    <div class="container-subTitulo">
                        <h2>Usuarios</h2>
                        <div class="container-buttons-tabla">
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#tuInformacion"><span class="fa fa-user" aria-hidden="true"></span>  Tu información</button>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#insertarUsuario"><span class="fa fa-plus" aria-hidden="true"></span>  Agregar usuario</button>
                        </div>
                    </div>
                    <div clas="">
                        <table class="table" id="tabla-usuarios" data-accion="insert-usuario">
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
                            <tbody id="tabla_usuarios">
                                <?php
                                $usuarios = $consulta->consultar("SELECT u.eCodeUsuarios, u.tNombreUsuarios, u.tNumControlUsuarios, r.tNombreRol AS tRolUsuarios, u.fCreateUsuarios, u.fUpdateUsuarios, u.bEstadoUsuarios
                                FROM usuarios u
                                INNER JOIN roles r ON u.eRolUsuarios = r.eCodeRol
                                WHERE u.eCodeUsuarios <> $id_user ORDER BY u.eCodeUsuarios;");
                                if ($usuarios->rowCount()){
                                    foreach($usuarios as $usuario){
                                        ?>
                                            <tr data-accion="usuario" class="contenido <?php
                                            
                                            if ($usuario['bEstadoUsuarios'] == 0){
                                                
                                                echo 'inactivo';
                                            }
                                            
                                            ?>" data-usuario="<?php echo $usuario['eCodeUsuarios']; ?>" >
                                                <td data-accion="usuario" data-usuario="<?php echo $usuario['eCodeUsuarios']; ?>"><?php echo $usuario['eCodeUsuarios']; ?></td>
                                                <td data-accion="usuario" data-usuario="<?php echo $usuario['eCodeUsuarios']; ?>"><?php echo $usuario['tNombreUsuarios']; ?></td>
                                                <td data-accion="usuario" data-usuario="<?php echo $usuario['eCodeUsuarios']; ?>"><?php echo $usuario['tNumControlUsuarios']; ?></td>
                                                <td data-accion="usuario" data-usuario="<?php echo $usuario['eCodeUsuarios']; ?>"><?php echo $usuario['tRolUsuarios']; ?></td>
                                                <td data-accion="usuario" data-usuario="<?php echo $usuario['eCodeUsuarios']; ?>"><?php echo $usuario['fCreateUsuarios']; ?></td>
                                                <td data-accion="usuario" data-usuario="<?php echo $usuario['eCodeUsuarios']; ?>"><?php 
                                                
                                                if ($usuario['fUpdateUsuarios'] == ''){
                                                    echo '-----';
                                                }else{
                                                    echo $usuario['fUpdateUsuarios'];   
                                                } 
                                                
                                                ?></td>
                                                <td data-accion="usuario" data-usuario="<?php echo $usuario['eCodeUsuarios']; ?>"><?php 
                                                    
                                                    if ($usuario['bEstadoUsuarios'] == 1){
                                                        echo 'activo';
                                                    }else{
                                                        echo 'inactivo';
                                                    }
                                                    ?></td>
                                            </tr>
                                            <?php
                                    }
                                }else{
                                    ?>
                                        <tr>
                                            <td colspan="7"  data-accion="usuario" class="noUsuarios">No hay mas usuarios</td>
                                        </tr>
                                        <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="container-tabla-historial">
                    <div class="container-subTitulo">
                        <h2>Historial</h2>
                    </div>
                    <div class="">
                        <table class="table" id="tabla-historial">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">acción</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Fecha</th>
                                </tr>
                            </thead>
                            <tbody id="tabla_historial">
                                <?php
                                $registros = $consulta->consultar("SELECT h.eCodeHistorial, h.tAccionHistorial, u.tNombreUsuarios AS nombreUsuario, u.tNumControlUsuarios AS numeroControlUsuario, h.fCreateHistorial
                                FROM historial h
                                INNER JOIN usuarios u ON h.eUsuarioHistorial = u.eCodeUsuarios ORDER BY eCodeHistorial DESC;");
                                if ($usuarios->rowCount()){
                                    foreach($registros as $registro){
                                        ?>
                                            <tr>
                                                <td><?php echo $registro['eCodeHistorial']; ?></td>
                                                <td><?php echo $registro['tAccionHistorial']; ?></td>
                                                <td><?php echo $registro['nombreUsuario'] . " - " . $registro['numeroControlUsuario']; ?></td>
                                                <td><?php echo $registro['fCreateHistorial']; ?></td>
                                            </tr>
                                            <?php
                                    }
                                }else{
                                    ?>
                                        <tr>
                                            <td colspan="4" class="noUsuarios">No hay acciones registradas</td>
                                        </tr>
                                        <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            
        </main>
        
        <div id="menuDesplegable" class="menu">
            <ul>
            </ul>
        </div>

        <div class="modal fade" id="editarUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Usuario <br> [usuario prueba] </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="usuario-nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" name="usuario-nombre" id="usuario-nombre">
                            <div class="invalid-feedback">El nombre no es valido</div>
                        </div>
                        <div class="mb-3">
                            <label for="usuario-control" class="form-label">No. Control</label>
                            <input type="number" class="form-control no-arrows" name="usuario-control" id="usuario-control">
                            <div class="invalid-feedback">El numero de control no es valido</div>
                        </div>
                        <div class="mb-3">
                            <label for="usuario-rol" class="form-label">Rol</label>
                            <select name="usuario-rol" id="usuario-rol" class="form-select">
                                <option value="1">Administrador</option>
                                <option value="2">Coordinador</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="cambiarContra" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar Contraseña</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="passA">Contraseña actual:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default" data-contra="1"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                <input type="password" id="pass" name="pass" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                <div class="invalid-feedback" id="feedback-pass">minimo 8 caracteres</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="passN2">Nueva contraseña:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default"data-contra="2"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                <input type="password" id="passN2" name="passN2" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                <div class="invalid-feedback" id="feedback-passN2">minimo 8 caracteres</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="passN">Confirmar contraseña:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default"data-contra="3"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                <input type="password" id="passN" name="passN" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                <div class="invalid-feedback">La contraseña no coinside</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-target="#tuInformacion" data-bs-toggle="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" disabled>Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="insertarUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar usuario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="insertar-usuario-nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" name="insertar-usuario-nombre" id="insertar-usuario-nombre">
                            <div class="invalid-feedback">El nombre no es valido</div>
                        </div>
                        <div class="mb-3">
                            <label for="insertar-usuario-control" class="form-label">No. Control</label>
                            <input type="number" class="form-control no-arrows" name="insertar-usuario-control" id="insertar-usuario-control">
                            <div class="invalid-feedback">El numero de control no es valido</div>
                        </div>
                        <div class="mb-3">
                            <label for="insertar-usuario-rol" class="form-label">Rol</label>
                            <select name="insertar-usuario-rol" id="insertar-usuario-rol" class="form-select">
                                <option value="1">Administrador</option>
                                <option value="2">Coordinador</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="insertar-passN2">contraseña:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default"data-contra="2"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                <input type="password" id="insertar-passN2" name="insertar-passN2" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                <div class="invalid-feedback" id="feedback-passN2">minimo 8 caracteres</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="insertar-passN">Confirmar contraseña:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default"data-contra="3"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                <input type="password" id="insertar-passN" name="insertar-passN" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                <div class="invalid-feedback">La contraseña no coinside</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" disabled>Agregar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="tuInformacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar usuario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">                         
                        <div class="container-infoUser">
                            <h2>Tu información</h2>
                            <div class="mb-3">
                                <label for="tu-nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="tu-nombre" name="tu-nombre" value="<?php echo $tu_nombre; ?>">
                                <div class="invalid-feedback">El nombre no es valido</div>
                            </div>
                            <div class="mb-3">
                                <label for="tu-control" class="form-label">No. Control</label>
                                <input type="number" class="form-control no-arrows" id="tu-control" name="tu-control" value="<?php echo $tu_control; ?>">
                                <div class="invalid-feedback">El numero de control es invalido</div>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-success" disabled>Guardar Cambios</button>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#cambiarContra">Cambiar contraseña</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

        <script>
            const id_user = <?php echo $_SESSION['eCodeUsuario']; ?>;
            document.querySelector('header button.btn-outline-success').classList.add('btn-success');
            document.querySelector('header button.btn-outline-success').classList.remove('btn-outline-success');
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
        <script src="../js/header.js"></script>
        <script src="../js/validacion.js"></script>
        <script src="../js/usuarios.js"></script>
        
    </body>
</html>