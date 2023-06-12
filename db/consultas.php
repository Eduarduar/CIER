<?php

    include_once 'db.php';
        
    date_default_timezone_set("America/Mexico_City");

    class consultas extends DB {

        public function login($control, $contra){
            $md5 = md5($contra);
            $query = $this->connect()->prepare("SELECT * FROM usuarios WHERE tNumControlUsuarios = '$control'");
            $query->execute();

            if ($query->rowCount()){
                foreach ($query as $usuario){
                    $tContraUsuario = $usuario['tContraUsuarios'];
                    $datos = [
                        'eCodeUsuario' => $usuario['eCodeUsuarios'],
                        'tNombreUsuario' => $usuario['tNombreUsuarios']
                    ];
                }

                if (password_verify($md5, $tContraUsuario)){
                    return $datos;
                }
                return false;
            }
            return false;
        }

        public function consultar($consulta){
            return $this->connect()->query("".$consulta."");
        }

        public function insertar($consulta){
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
        // Verificar la existencia de los datos esperados en la solicitud
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
            
            // Insertar la información de la publicación en la base de datos
            if (!$consulta->insertar("INSERT INTO publicaciones VALUES (NULL, $id_user, '$text', '$destino_img', '$destino_pdf', $tipo, CURRENT_TIMESTAMP, NULL, NULL, 1);")) {
                if ($mensaje == 'Operacion exitosa'){
                    $mensaje = 'Error al subir la imagen';
                }else{
                    $mensaje .= ' Error al intentar publicar';
                }
                $code = '1';
            }
            
            $publicacion = $consulta->consultar("SELECT
                publicaciones.eCodePublicaciones,
                usuarios.tNombreUsuarios,
                publicaciones.tMensajePublicaciones,
                publicaciones.tImgPublicaciones,
                publicaciones.tPdfPublicaciones,
                publicaciones.fCreatePublicaciones,
                tipopublicaciones.tNombreTipoPublicaciones
                FROM
                publicaciones, usuarios, tipopublicaciones
                WHERE
                publicaciones.eUserPublicaciones = usuarios.eCodeUsuarios
                AND publicaciones.eTipoPublicaciones = tipopublicaciones.eCodeTipoPublicaciones
                ORDER BY
                publicaciones.eCodePublicaciones DESC
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
                        'create'        => $info['fCreatePublicaciones']
                    ];
                }
            }

            $resp = array('code' => $code, 'message' => $mensaje, 'datos' => $datos);
            echo json_encode($resp);
                
        }
            
    }

?>