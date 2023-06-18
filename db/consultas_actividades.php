<?php

    include_once './consultas.php';
    date_default_timezone_set("America/Mexico_City");
    $consulta = new consultas();
    $resp = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // consultas de la pagina actividades diversas  ------------------------------------------------------------------------------------------------------------
        
        $resp = array('code' => '1', 'message' => 'error');
        if (isset($_POST['titulo']) && isset($_FILES['imgs']) && isset($_POST['id_user'])) {
            $titulo = $_POST['titulo'];
            $id_user = $_POST['id_user'];
            $direcciones = array();
            $existentes = array();
            $error = false; // Variable de control para verificar si hay errores
            $archivo_error;
            
            if (strlen($titulo) <= 100) {
                // Obtener los nombres de archivo existentes de la base de datos
                $respuesta = $consulta->consultar("SELECT tImgsActividades FROM actividades");
                if ($respuesta->rowCount()) {
                    foreach ($respuesta as $actividad) {
                        $linksArray = explode(',', $actividad['tImgsActividades']);
                        $existentes = array_merge($existentes, $linksArray);
                    }
                }else{
                    $existentes = false;
                }
        
                foreach ($_FILES['imgs']['name'] as $key => $tmpName) {
                    if ($existentes != false){
                        do {
                            $direccion = renombre(10, '../src/img/', $_FILES['imgs']['name'][$key]);
            
                            // Verificar si el nombre generado ya existe en el array de existentes
                            if (!in_array($direccion, $existentes)) {
                                // Mover el archivo cargado al destino final
                                if (move_uploaded_file($_FILES['imgs']['tmp_name'][$key], $direccion)) {
                                    $direcciones[] = $direccion;
                                } else {
                                    $archivo_error = $_FILES['imgs']['name'][$key];
                                    $error = true; // Se produjo un error al mover el archivo
                                    break; // Salir del bucle
                                }
                                break;
                            }
                        } while (true);
                    }else{  
                        $direccion = renombre(10, '../src/img/', $_FILES['imgs']['name'][$key]);
                        if (move_uploaded_file($_FILES['imgs']['tmp_name'][$key], $direccion)) {
                            $direcciones[] = $direccion;
                        } else {
                            $archivo_error = $_FILES['imgs']['name'][$key];
                            $error = true; // Se produjo un error al mover el archivo
                            break; // Salir del bucle
                        }
                    }
                }
                $direccionesString = implode(',', $direcciones);
                // Verificar si se produjo algún error al mover los archivos
                if ($error) {
                    // Eliminar los archivos nuevos previamente cargados
                    foreach ($direcciones as $direccion) {
                        if (file_exists($direccion)) {
                            unlink($direccion);
                        }
                    }
                    $resp = array('code' => '1', 'message' => 'Error al intentar subir el archivo: ' . $archivo_error);
                }else{
                    if ($consulta->consultarConfirmar("INSERT INTO actividades VALUES (NULL, '$titulo', '$direccionesString', CURRENT_TIMESTAMP, NULL, $id_user, NULL , 1);")){
                        $actividades = $consulta->consultar("SELECT a.eCodeActividades, a.tTituloActividades, a.tImgsActividades, a.fCreateActividades, a.fUpdateActividades, u1.tNombreUsuarios AS eCreateActividades, u2.tNombreUsuarios AS eUpdateActividades, a.bEstadoActividades
                        FROM actividades a
                        LEFT JOIN usuarios u1 ON a.eCreateActividades = u1.eCodeUsuarios
                        LEFT JOIN usuarios u2 ON a.eUpdateActividades = u2.eCodeUsuarios
                        WHERE a.bEstadoActividades = 1
                        ORDER BY a.eCodeActividades DESC LIMIT 1;
                        ");
                        if ($actividades->rowCount()){
                            foreach($actividades as $actividad){
                                $datos = [
                                    'titulo' => $actividad['tTituloActividades'],
                                    'fecha' => $actividad['fCreateActividades'],
                                    'carrusel' => $actividad['eCodeActividades'],
                                    'imagenes' => $actividad['tImgsActividades'],
                                    'usuarioC' => $actividad['eCreateActividades']
                                ];
                            }
                            $resp = array('code' => '0', 'message' => 'Actividad agregada correctamente', 'datos' => $datos);
                        }
                    }else{
                        // Eliminar los archivos nuevos previamente cargados por que no se puedo registrar la actividad
                        foreach ($direcciones as $direccion) {
                            if (file_exists($direccion)) {
                                unlink($direccion);
                            }
                        }
                        $resp = array('code' => '1', 'message' => 'Error al intentar agregar la actividad');
                    }
                }
            }else{
                $resp = array('code' => '1', 'message' => 'El titulo es muy largo (limite 100 caracteres)');
            }
        }    
    }
    echo json_encode($resp);



    



?>