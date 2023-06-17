<?php

    include_once 'db.php';
        
    date_default_timezone_set("America/Mexico_City");

    class consultas extends DB {

        public function login($control, $contra){
            $md5 = md5($contra);
            $query = $this->connect()->prepare("SELECT u.eCodeUsuarios, u.tNombreUsuarios, u.tNumControlUsuarios, u.tContraUsuarios, r.tNombreRol AS tRolUsuarios, u.fCreateUsuarios, u.fUpdateUsuarios, u.bEstadoUsuarios
            FROM usuarios u
            INNER JOIN roles r ON u.eRolUsuarios = r.eCodeRol
            WHERE u.tNumControlUsuarios = $control AND u.bEstadoUsuarios = 1;
            ");
            $query->execute();

            if ($query->rowCount()){
                foreach ($query as $usuario){
                    $tContraUsuario = $usuario['tContraUsuarios'];
                    $datos = [
                        'eCodeUsuario' => $usuario['eCodeUsuarios'],
                        'tNombreUsuario' => $usuario['tNombreUsuarios'],
                        'tRolUsuario' => $usuario['tRolUsuarios']
                    ];
                }

                if (password_verify($md5, $tContraUsuario)){
                    $historial = ['accion' => 'Inicio sesión', 'id' => $datos['eCodeUsuario']];
                    $this->setHistorial($historial);
                    return $datos;
                }
                return false;
            }
            return false;
        }

        public function setHistorial($historial) {
            $accion = $historial['accion'];
            $id = $historial['id'];
            if (isset($historial['id2'])){
                $id2 = $historial['id2'];
                $respuesta = $this->connect()->query("SELECT tNombreUsuarios FROM usuarios WHERE eCodeUsuarios = $id2");
                foreach($respuesta as $info){
                    $nombre = $info['tNombreUsuarios'];
                }
                $accion = $historial['accion'] . $nombre;
            }else{
                $accion = $historial['accion'];
            }
            $this->connect()->query("INSERT INTO historial VALUES (NULL, '$accion', $id, CURRENT_TIMESTAMP);");
        }

        public function consultar($consulta){
            return $this->connect()->query("".$consulta."");
        }

        public function consultarConfirmar($consulta){
            $this->connect()->query("".$consulta."");
            return true;
        }

    }

    $consulta = new consultas();

    // Función para generar un nombre de archivo aleatorio
    function renombre($cantidad, $carpeta, $nombreOriginal) {
        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $nombre = '';

        for ($i = 0; $i < $cantidad; $i++) {
            $indice = rand(0, strlen($caracteres) - 1);
            $nombre .= $caracteres[$indice];
        }

        $extensionArchivo = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
        $nuevoNombre = $nombre . '.' . $extensionArchivo;

        return $carpeta . $nuevoNombre;
    }

    
    // Comprobar si se realizó una solicitud POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // consultas de la pagina usuarios ----------------------------------------------------------------------------------------------------------------

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

        if (isset($_POST['usuario'])){
            switch($_POST['usuario']){
                case 'getUser':
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
                case 'estado':
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

                case 'actualizar':
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
                case 'insertar':
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

        // consultas de lapagina publicaciones ------------------------------------------------------------------------------------------------------------

        if (isset($_POST['publicar']) and isset($_POST['id_user'])){
            $publicacion = $_POST['publicar'];
            $id_user = $_POST['id_user'];
            $publicacion = $consulta->consultarConfirmar("UPDATE publicaciones SET bEstadoPublicaciones = 1, eUpdatePublicaciones = $id_user, fUpdatePublicaciones = CURRENT_TIMESTAMP WHERE eCodePublicaciones = $publicacion");
            if (!$publicacion){
                $resp = array('code' => '1', 'message' => 'algo a salido mal al intentar eliminar la publicación');
            }else{
                $resp = array('code' => '0', 'message' => 'publicación eliminada exitosamente');
                $historial = ['accion' => 'Republico una publicación', 'id' => $id_user];
                $consulta->setHistorial($historial);
                
            }
            echo json_encode($resp);
        }

        if (isset($_POST['publicaciones'])){
            if ($_POST['publicaciones'] === 'eliminadas' || $_POST['publicaciones'] === 'publicadas' ){
                if ($_POST['publicaciones'] === 'publicadas'){
                    $tipo = 1;
                }else{
                    $tipo = 0;
                }
                $publicaciones = $consulta->consultar("SELECT p.eCodePublicaciones, u.tNombreUsuarios, p.tMensajePublicaciones, p.tImgPublicaciones, p.tPdfPublicaciones, t.tNombreTipoPublicaciones, p.fCreatePublicaciones, p.fUpdatePublicaciones, u2.tNombreUsuarios AS tNombreUsuariosUpdate
                FROM publicaciones p
                INNER JOIN usuarios u ON p.eUserPublicaciones = u.eCodeUsuarios
                INNER JOIN tipopublicaciones t ON p.eTipoPublicaciones = t.eCodeTipoPublicaciones
                LEFT JOIN usuarios u2 ON p.eUpdatePublicaciones = u2.eCodeUsuarios
                WHERE p.bEstadoPublicaciones = $tipo
                ORDER BY
                p.eCodePublicaciones;");

                if ($publicaciones->rowCount()){
                    $datos = array();
                    foreach($publicaciones as $publicacion){
                        $datos[] = [
                            'publicacion'   => $publicacion['eCodePublicaciones'],
                            'usuario'       => $publicacion['tNombreUsuarios'],
                            'tipo'          => $publicacion['tNombreTipoPublicaciones'],
                            'text'          => $publicacion['tMensajePublicaciones'],
                            'img'           => $publicacion['tImgPublicaciones'],
                            'pdf'           => $publicacion['tPdfPublicaciones'],
                            'create'        => $publicacion['fCreatePublicaciones'],
                            'update'        => $publicacion['fUpdatePublicaciones'],
                            'nameUpdate'    => $publicacion['tNombreUsuariosUpdate'],
                            'consulta'      => $_POST['publicaciones']
                        ];
                    }
                    $resp = array('code' => '0', 'menssaje' => 'operación exitosa', 'datos' => $datos);
                }else if ($tipo == 0){
                    $resp = array('code' => '1', 'menssaje' => 'No hay publicaciones eliminadas');
                }else{
                    $datos[] = ['consulta' => ''];
                    $datos[] = ['consulta' => ''];
                    $resp = array('code' => '0', 'menssaje' => 'operación exitosa', 'datos' => $datos);
                }
                echo json_encode($resp);
            }
        }

        // Verificar la existencia de los datos esperados en la solicitud para **** desactivar una publicación ****
        if (isset($_POST['eliminar']) and isset($_POST['id_user'])){
            $publicacion = $_POST['eliminar'];
            $id_user = $_POST['id_user'];
            $publicacion = $consulta->consultarConfirmar("UPDATE publicaciones SET bEstadoPublicaciones = 0, eUpdatePublicaciones = $id_user, fUpdatePublicaciones = CURRENT_TIMESTAMP WHERE eCodePublicaciones = $publicacion");
            if (!$publicacion){
                $resp = array('code' => '1', 'message' => 'algo a salido mal al intentar eliminar la publicación');
            }else{
                $resp = array('code' => '0', 'message' => 'publicación eliminada exitosamente');
                $historial = ['accion' => 'Deshabilito una publicación', 'id' => $id_user];
                $consulta->setHistorial($historial);
                
            }
            echo json_encode($resp);
        }

        // Verificar la existencia de los datos esperados en la solicitud para **** insertar una publicación ****
        if (isset($_POST['text']) AND isset($_POST['tipo'])) {
            $text = $_POST['text'];
            $id_user = $_POST['id_user'];
            $code = '0';
            $mensaje = 'Operacion exitosa';
            $destino_img = NULL;
            $destino_pdf = NULL;
            $datos = [];
            $tipo = $_POST['tipo'];

            if(isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK){
                $pdf = $_FILES['pdf'];

                // Obtener información del archivo PDF
                $pdf_nombre = $_FILES['pdf']['name'];
                $pdf_tmp = $_FILES['pdf']['tmp_name'];

                // Generar un nombre único para el archivo PDF
                do {
                    $destino_pdf = renombre(15, '../src/pdf/', $pdf_nombre);

                    // Comprobar si el nombre generado ya existe en la base de datos
                    $respuesta = $consulta->consultar("SELECT * FROM publicaciones WHERE tPdfPublicaciones = '$destino_pdf'");
                    if ($respuesta->rowCount() === 0) {
                        // Si no existe, se puede usar el nombre generado
                        break;
                    }
                    
                } while (true);
                
                // Mover los archivos cargados a las ubicaciones finales
                if (!move_uploaded_file($pdf_tmp, $destino_pdf)){
                    if ($mensaje == 'Operacion exitosa'){
                        $mensaje = 'Error al subir el pdf';
                    }else{
                        $mensaje .= ' Error al subir el pdf';
                    }
                    $code = '1';
                }
            }

            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK ){
                $img = $_FILES['img'];
                // Obtener información del archivo de imagen
                $img_nombre = $_FILES['img']['name'];
                $img_tmp = $_FILES['img']['tmp_name'];

                // Generar un nombre único para el archivo de imagen
                do {
                    $destino_img = renombre(15, '../src/img/', $img_nombre);

                    // Comprobar si el nombre generado ya existe en la base de datos
                    $respuesta = $consulta->consultar("SELECT * FROM publicaciones WHERE tImgPublicaciones = '$destino_img'");
                    if ($respuesta->rowCount() === 0) {
                        // Si no existe, se puede usar el nombre generado
                        break;
                    }

                } while (true);
                
                // Mover los archivos cargados a las ubicaciones finales
                if (!move_uploaded_file($img_tmp, $destino_img)){
                    if ($mensaje == 'Operacion exitosa'){
                        $mensaje = 'Error al subir la imagen';
                    }else{
                        $mensaje .= ' Error al subir la imagen';
                    }
                    $code = '1';
                }
            }

            
            if ($code != '1'){

                // Insertar la información de la publicación en la base de datos
                if (!$consulta->consultarConfirmar("INSERT INTO publicaciones VALUES (NULL, $id_user, '$text', '$destino_img', '$destino_pdf', $tipo, CURRENT_TIMESTAMP, NULL, NULL, 1);")) {
                    if ($mensaje == 'Operacion exitosa'){
                        $mensaje = 'Error al subir la imagen';
                    }else{
                        $mensaje .= ' Error al intentar publicar';
                    }
                    $code = '1';
                }
                
                $publicacion = $consulta->consultar("SELECT p.eCodePublicaciones, u.tNombreUsuarios, p.tMensajePublicaciones, p.tImgPublicaciones, p.tPdfPublicaciones, t.tNombreTipoPublicaciones, p.fCreatePublicaciones, p.fUpdatePublicaciones, u2.tNombreUsuarios AS tNombreUsuariosUpdate
                FROM publicaciones p
                INNER JOIN usuarios u ON p.eUserPublicaciones = u.eCodeUsuarios
                INNER JOIN tipopublicaciones t ON p.eTipoPublicaciones = t.eCodeTipoPublicaciones
                LEFT JOIN usuarios u2 ON p.eUpdatePublicaciones = u2.eCodeUsuarios
                WHERE p.bEstadoPublicaciones = 1
                ORDER BY
                p.eCodePublicaciones DESC
                LIMIT 1;");
                if ($publicacion->rowCount()){
                    foreach($publicacion as $info){
                        $datos = [
                            'publicacion'   => $info['eCodePublicaciones'],
                            'usuario'       => $info['tNombreUsuarios'],
                            'tipo'          => $info['tNombreTipoPublicaciones'],
                            'text'          => $info['tMensajePublicaciones'],
                            'img'           => $info['tImgPublicaciones'],
                            'pdf'           => $info['tPdfPublicaciones'],
                            'create'        => $info['fCreatePublicaciones'],
                            'update'        => $info['fUpdatePublicaciones'],
                            'nameUpdate'    => $info['tNombreUsuariosUpdate'],
                            'consulta'      => 'publicadas'
                        ];
                    }
                }

                if ($code != '1'){
                    $historial = ['accion' => 'Agrego una nueva publicación', 'id' => $id_user];
                    $consulta->setHistorial($historial);
                }
            
            }
            $resp = array('code' => $code, 'message' => $mensaje, 'datos' => $datos);
            echo json_encode($resp);
                
        }
            
    }
?>