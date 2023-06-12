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
        if (isset($_POST['text']) && isset($_FILES['pdf']) && isset($_FILES['img'])) {
            $text = $_POST['text'];
            $pdf = $_FILES['pdf'];
            $img = $_FILES['img'];
            $id_user = $_POST['id_user'];

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
            if (move_uploaded_file($pdf_tmp, $destino_pdf) && move_uploaded_file($img_tmp, $destino_img)) {
                // Insertar la información de la publicación en la base de datos
                $consulta->insertar("INSERT INTO publicaciones VALUES (NULL, $id_user, '$text', '$destino_img', '$destino_pdf', NULL, NULL, NULL, 1);");
            }

            // enviar la respuesta JSON
            $resp = array('code' => '0');
            echo json_encode($resp);
        }
    }

?>