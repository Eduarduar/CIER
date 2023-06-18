<?php

    include_once './consultas.php';
    date_default_timezone_set("America/Mexico_City");
    $consulta = new consultas();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // consultas de la pagina publicaciones ------------------------------------------------------------------------------------------------------------

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