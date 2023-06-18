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
?>