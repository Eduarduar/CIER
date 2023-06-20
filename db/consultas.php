<?php

    include_once 'db.php';

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
    
    function encontrarEnlacesYouTubeYFacebook($texto) {
        $regex = '/(https?:\/\/(?:www\.)?youtube\.com\/(?:watch\?v=|embed\/|v\/)?[\w-]+|https?:\/\/youtu\.be\/[\w-]+|https:\/\/www\.facebook\.com\/plugins\/video\.php\?height=\d+&href=https%3A%2F%2Fwww\.facebook\.com%2F[\w-]+%2Fvideos%2F\d+%2F&show_text=\w+&width=\d+&t=\d+)/i';
        preg_match_all($regex, $texto, $matches);
      
        if (!empty($matches[0])) {
          return $matches[0];
        } else {
          return [];
        }
      }      

    function obtenerURLEmbed($url) {
        $videoId = '';
        $playlistId = '';
    
        // Comprobar si el enlace está en el formato "https://www.youtube.com/watch?v=VIDEO_ID"
        if (strpos($url, 'youtube.com/watch?v=') !== false) {
            $params = parse_url($url, PHP_URL_QUERY);
            parse_str($params, $query);
            $videoId = $query['v'];
        }
        // Comprobar si el enlace está en el formato "https://youtu.be/VIDEO_ID"
        elseif (strpos($url, 'youtu.be/') !== false) {
            $videoId = explode('youtu.be/', $url)[1];
        }
        // Comprobar si el enlace está en el formato "https://www.youtube.com/v/VIDEO_ID"
        elseif (strpos($url, 'youtube.com/v/') !== false) {
            $videoId = explode('youtube.com/v/', $url)[1];
        }
        // Comprobar si el enlace está en el formato "https://www.youtube.com/embed/VIDEO_ID?list=PLAYLIST_ID"
        elseif (strpos($url, 'youtube.com/embed/') !== false && strpos($url, '?list=') !== false) {
            $urlParts = explode('?', $url);
            $videoId = explode('youtube.com/embed/', $urlParts[0])[1];
            $params = parse_url($url, PHP_URL_QUERY);
            parse_str($params, $query);
            $playlistId = $query['list'];
        }
        // Comprobar si el enlace está en el formato "https://www.youtube.com/embed/videoseries?list=PLAYLIST_ID"
        elseif (strpos($url, 'youtube.com/embed/videoseries?list=') !== false) {
            $playlistId = explode('youtube.com/embed/videoseries?list=', $url)[1];
        }
    
        // Comprobar si se obtuvo el ID del video
        if ($videoId) {
            return "https://www.youtube.com/embed/{$videoId}" . ($playlistId ? "?list={$playlistId}" : '');
        } else {
            // Si el enlace no coincide con ninguno de los formatos esperados, retorna null o un valor predeterminado según tus necesidades
            return null;
        }
    }

    function obtenerEnlaceRedSocial($enlace) {
        $regexYouTube = '/(https?:\/\/(?:www\.)?youtube\.com\/(?:watch\?v=|embed\/|v\/)?[\w-]+|https?:\/\/youtu\.be\/[\w-]+)/i';
        
        if (preg_match($regexYouTube, $enlace)) {
          return obtenerURLEmbed($enlace);
        } else {
          return $enlace;
        }
    }

    function verificarFacebook($enlace) {
        $regexYouTube = '/(https?:\/\/(?:www\.)?youtube\.com\/(?:watch\?v=|embed\/|v\/)?[\w-]+|https?:\/\/youtu\.be\/[\w-]+)/i';
        
        if (preg_match($regexYouTube, $enlace)) {
          return false;
        } else {
          return true;
        }
    }
      
    
?>