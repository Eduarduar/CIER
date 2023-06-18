<?php

    include_once './consultas.php';
    date_default_timezone_set("America/Mexico_City");
    $consulta = new consultas();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // consultas de la pagina usuarios ----------------------------------------------------------------------------------------------------------------

        // consulta para obtener el historial actualizado
        if (isset($_POST['historial'])){
            $historial = $consulta->consultar("SELECT h.eCodeHistorial, h.tAccionHistorial, u.tNombreUsuarios AS nombreUsuario, u.tNumControlUsuarios AS numeroControlUsuario, h.fCreateHistorial
            FROM historial h
            INNER JOIN usuarios u ON h.eUsuarioHistorial = u.eCodeUsuarios ORDER BY eCodeHistorial DESC LIMIT 1;");
            $datos = array();
            if ($historial->rowCount()){
                foreach($historial as $registro){
                    $datos[] = [
                        'eCodeHistorial' => $registro['eCodeHistorial'],
                        'tAccionHistorial' => $registro['tAccionHistorial'],
                        'tUsuarioHistorial' => $registro['nombreUsuario'],
                        'fCreateHistorial' => $registro['fCreateHistorial']
                    ];
                }
                $resp = array('code' => '0', 'message' => 'Operación exitosa', 'datos' => $datos);
            }else{
                $resp = array('code' => '1', 'message' => 'No hay historial');
            }
            echo json_encode($resp);
        }

        // consultas para manejar los usuarios
        if (isset($_POST['usuario'])){
            switch($_POST['usuario']){ 
                case 'getUser': // consulta para obtener todos los usuarios exepto el actual
                    if (isset($_POST['usuario_id'])){
                        $id = $_POST['usuario_id'];
                        $usuario = $consulta->consultar("SELECT u.tNombreUsuarios, u.tNumControlUsuarios, r.tNombreRol FROM usuarios u JOIN roles r ON u.eRolUsuarios = r.eCodeRol WHERE u.eCodeUsuarios = $id;");
                        if ($usuario->rowCount()){
                            foreach($usuario as $info){
                                $datos = [
                                    'nombre' => $info['tNombreUsuarios'],
                                    'numControl' => $info['tNumControlUsuarios'],
                                    'rol' => $info['tNombreRol']
                                ];
                            }
                            $resp = array('code' => '0', 'message' => 'Operación exitosa', 'datos' => $datos);
                        }else{
                            $resp = array('code' => '1', 'message' => 'El usuario no existe');
                        }
                    }else{
                        $resp = array('code' => '1', 'message' => 'La acción no es valida');
                    }
                break;
                case 'estado': // consulta para actualizar el estado de un usuario
                    if (isset($_POST['usuario_id']) && isset($_POST['id_user'])){
                        $id = $_POST['usuario_id'];
                        $id_user = $_POST['id_user'];
                        $usuario = $consulta->consultar("SELECT bEstadoUsuarios FROM usuarios WHERE eCodeUsuarios = $id");
                        if ($usuario->rowCount()){
                            foreach($usuario as $info){
                                $newEstado = $info['bEstadoUsuarios'] == 1 ? 0 : 1;
                            }
                            if ($consulta->consultarConfirmar("UPDATE usuarios SET fUpdateUsuarios = CURRENT_TIMESTAMP, bEstadoUsuarios = $newEstado WHERE eCodeUsuarios = $id")){
                                $usuarios = $consulta->consultar("SELECT u.eCodeUsuarios, u.tNombreUsuarios, u.tNumControlUsuarios, r.tNombreRol AS tRolUsuarios, u.fCreateUsuarios, u.fUpdateUsuarios, u.bEstadoUsuarios
                                FROM usuarios u
                                INNER JOIN roles r ON u.eRolUsuarios = r.eCodeRol
                                WHERE u.eCodeUsuarios <> $id_user ORDER BY u.eCodeUsuarios;;");

                                $datos = array();

                                if ($usuarios->rowCount()) {
                                    foreach ($usuarios as $usuario) {
                                        $datos[] = array(
                                            'eCodeUsuario' => $usuario['eCodeUsuarios'],
                                            'tNombreUsuario' => $usuario['tNombreUsuarios'],
                                            'tNumControlUsuario' => $usuario['tNumControlUsuarios'],
                                            'tRolUsuario' => $usuario['tRolUsuarios'],
                                            'fCreateUsuario' => $usuario['fCreateUsuarios'],
                                            'fUpdateUsuario' => $usuario['fUpdateUsuarios'],
                                            'bEstadoUsuario' => $usuario['bEstadoUsuarios']
                                        );
                                    }
                                    $historial = ['accion' => 'Cambio el estado  de ', 'id' => $id_user, 'id2' => $id];
                                    $consulta->setHistorial($historial);
                                    $resp = array('code' => '0', 'message' => 'El usuario a sido actualizado', 'datos' => $datos);
                                }
                            }else{
                                $resp = array('code' => '1', 'message' => 'Ocurrio un error al intentar actualizar el usuario');
                            }
                        }else{
                            $resp = array('code' => '1', 'message' => 'El usuario no existe');
                        }
                    }else{
                        $resp = array('code' => '1', 'message' => 'La acción no es valida');
                    }
                break;

                case 'actualizar': // consulta para actualizar los datos de un usuario 
                    if (isset($_POST['usuario_id']) && isset($_POST['id_user']) && isset($_POST['nombre']) && isset($_POST['control']) && isset($_POST['rol'])){
                        $id = $_POST['usuario_id'];
                        $id_user = $_POST['id_user'];
                        $nombre = $_POST['nombre'];
                        $control = $_POST['control'];
                        $rol = $_POST['rol'];
                        $usuario = $consulta->consultar("SELECT eCodeUsuarios FROM usuarios WHERE eCodeUsuarios = $id");
                        if ($usuario->rowCount()){
                            $users = $consulta->consultar("SELECT eCodeUsuarios FROM usuarios WHERE tNumControlUsuarios = '$control' AND eCodeUsuarios <> $id");
                            if ($users->rowCount()){
                                $resp = array('code' => '1', 'message' => 'El numero de control ya existe');
                            }else{
                                if ($consulta->consultarConfirmar("UPDATE usuarios SET fUpdateUsuarios = CURRENT_TIMESTAMP, tNombreUsuarios = '$nombre', tNumControlUsuarios = '$control', eRolUsuarios = $rol WHERE eCodeUsuarios = $id")){
                                    $usuarios = $consulta->consultar("SELECT u.eCodeUsuarios, u.tNombreUsuarios, u.tNumControlUsuarios, r.tNombreRol AS tRolUsuarios, u.fCreateUsuarios, u.fUpdateUsuarios, u.bEstadoUsuarios
                                    FROM usuarios u
                                    INNER JOIN roles r ON u.eRolUsuarios = r.eCodeRol
                                    WHERE u.eCodeUsuarios <> $id_user ORDER BY u.eCodeUsuarios;");

                                    $datos = array();

                                    if ($usuarios->rowCount()) {
                                        foreach ($usuarios as $usuario) {
                                            $datos[] = array(
                                                'eCodeUsuario' => $usuario['eCodeUsuarios'],
                                                'tNombreUsuario' => $usuario['tNombreUsuarios'],
                                                'tNumControlUsuario' => $usuario['tNumControlUsuarios'],
                                                'tRolUsuario' => $usuario['tRolUsuarios'],
                                                'fCreateUsuario' => $usuario['fCreateUsuarios'],
                                                'fUpdateUsuario' => $usuario['fUpdateUsuarios'],
                                                'bEstadoUsuario' => $usuario['bEstadoUsuarios']
                                            );
                                        }
                                        $historial = ['accion' => 'Actualizo la infomación de ', 'id' => $id_user, 'id2' => $id];
                                        $consulta->setHistorial($historial);
                                        $resp = array('code' => '0', 'message' => 'El usuario a sido actualizado', 'datos' => $datos);
                                    }
                                }else{
                                    $resp = array('code' => '1', 'message' => 'Ocurrio un error al intentar actualizar el usuario');
                                }
                            }
                        }else{
                            $resp = array('code' => '1', 'message' => 'El usuario no existe');
                        }
                    }else{
                        $resp = array('code' => '1', 'message' => 'La acción no es valida');
                    }
                break;
                case 'insertar': // consulta para insertar un nuevo usuario
                    if (isset($_POST['contra']) && isset($_POST['id_user']) && isset($_POST['nombre']) && isset($_POST['control']) && isset($_POST['rol'])){
                        $id_user = $_POST['id_user'];
                        $nombre = $_POST['nombre'];
                        $control = $_POST['control'];
                        $rol = $_POST['rol'];
                        $contra = md5($_POST['contra']); 
                        $users = $consulta->consultar("SELECT eCodeUsuarios FROM usuarios WHERE tNumControlUsuarios = '$control'");
                        if ($users->rowCount()){
                            $resp = array('code' => '1', 'message' => 'El numero de control ya existe');
                        }else{
                            $passHash = password_hash($contra, PASSWORD_DEFAULT, ['cost' => 10]);
                            if ($consulta->consultarConfirmar("INSERT INTO usuarios VALUES (NULL, '$nombre', '$control', '$passHash', $rol, CURRENT_TIMESTAMP, NULL, 1);")){
                                $usuarios = $consulta->consultar("SELECT u.eCodeUsuarios, u.tNombreUsuarios, u.tNumControlUsuarios, r.tNombreRol AS tRolUsuarios, u.fCreateUsuarios, u.fUpdateUsuarios, u.bEstadoUsuarios
                                FROM usuarios u
                                INNER JOIN roles r ON u.eRolUsuarios = r.eCodeRol
                                WHERE u.eCodeUsuarios <> $id_user ORDER BY u.eCodeUsuarios DESC LIMIT 1;");

                                $datos = array();

                                if ($usuarios->rowCount()) {
                                    foreach ($usuarios as $usuario) {
                                        $datos[] = array(
                                            'eCodeUsuario' => $usuario['eCodeUsuarios'],
                                            'tNombreUsuario' => $usuario['tNombreUsuarios'],
                                            'tNumControlUsuario' => $usuario['tNumControlUsuarios'],
                                            'tRolUsuario' => $usuario['tRolUsuarios'],
                                            'fCreateUsuario' => $usuario['fCreateUsuarios'],
                                            'fUpdateUsuario' => $usuario['fUpdateUsuarios'],
                                            'bEstadoUsuario' => $usuario['bEstadoUsuarios']
                                        );
                                    }
                                }
                                $historial = ['accion' => 'Agrego al usuario ['. $nombre . ' - ' . $control . ']', 'id' => $id_user];
                                $consulta->setHistorial($historial);
                                $resp = array('code' => '0', 'message' => 'Usuario agregado correctamente', 'datos' => $datos);
                            }else{
                                $resp = array('code' => '1', 'message' => 'Algo salio mal, al intentar insertar el usuario');
                            }
                        }
                    }
                break;
                default:
                    $resp = array('code' => '1', 'message' => 'La acción no es valida');
            }
            echo json_encode($resp);
        }

        // consulta para actualizar la contraseña del usuario actual
        if (isset($_POST['passN']) && isset($_POST['passA']) && isset($_POST['id_user'])){
            $passA = md5($_POST['passA']);
            $passN = md5($_POST['passN']);
            $id_user = $_POST['id_user'];
            $contra = $consulta->consultar("SELECT tContraUsuarios FROM usuarios WHERE eCodeUsuarios = $id_user");
            if ($contra->rowCount()){
                foreach($contra as $info){
                    $contraA = $info['tContraUsuarios'];
                }
                if (password_verify($passA,$contraA)){
                    if (!password_verify($passN,$contraA)){
                        $passHash = password_hash($passN, PASSWORD_DEFAULT, ['cost' => 10]);
                        if ($consulta->consultarConfirmar("UPDATE usuarios SET tContraUsuarios = '$passHash' WHERE eCodeUsuarios = $id_user;")){
                            $resp = array('code' => '0', 'message' => 'Se cambio la contraseña correctamente');
                            $historial = ['accion' => 'cambio su propia contraseña', 'id' => $id_user];
                            $consulta->setHistorial($historial);
                        }else{
                            $resp = array('code' => '1', 'message' => 'algo a salido mal al intentar actualizar la contraseña');
                        }
                    }else{
                        $resp = array('code' => '2', 'message' => 'Tu nueva contraseña no puede ser igual a la actual');
                    }
                }else{
                    $resp = array('code' => '3', 'message' => 'La contraseña actual es incorrecta');
                }
            }else{
                $resp = array('code' => '4', 'message' => 'El usuario que intenta modificar no existe');
            }
            echo json_encode($resp);
        }

        // consulta para actualizar la información del usuario actual 
        if (isset($_POST['tuControl']) && isset($_POST['tuNombre']) && isset($_POST['id_user'])){
            $nombre = $_POST['tuNombre'];
            $control = $_POST['tuControl'];
            $id_user = $_POST['id_user'];
            $users = $consulta->consultar("SELECT eCodeUsuarios FROM usuarios WHERE tNumControlUsuarios = '$control' AND eCodeUsuarios <> $id_user");
            if ($users->rowCount()){
                $resp = array('code' => '1', 'message' => 'El numero de control ya existe');
            }else{
                if ($consulta->consultarConfirmar("UPDATE usuarios SET tNombreUsuarios = '$nombre', tNumControlUsuarios = $control, fUpdateUsuarios = CURRENT_TIMESTAMP WHERE eCodeUsuarios = $id_user;")){
                    $resp = array('code' => '0', 'message' => 'se actualizo correctamente los datos');
                    $historial = ['accion' => 'Actualizo su propia información', 'id' => $id_user];
                    $consulta->setHistorial($historial);
                }else{
                    $resp = array('code' => '1', 'message' => 'algo a salido mal al intentar actualizar los datos');
                }
            }
            echo json_encode($resp);
        }
    }
?>