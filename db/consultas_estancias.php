<?php

    include_once './consultas.php';
    date_default_timezone_set("America/Mexico_City");
    $consulta = new consultas();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['estancia']) && isset($_POST['estancia_id']) && isset($_POST['id_user'])){
            $estancia_id = $_POST['estancia_id']; 
            $id_user = $_POST['id_user'];
            $estado = $_POST['estancia'] == 'eliminar' ? 0 : 1;
            $error = '';
            $estancias = $consulta->consultar("SELECT bEstadoEstancias FROM estancias WHERE eCodeEstancias = $estancia_id");
            if ($estancias->rowCount()){
                foreach($estancias as $estancia){
                    if ($estancia['bEstadoEstancias'] == $estado){
                        $error = 'estado';
                        break;
                    }
                }
                if ($error == 'estado'){
                    if ($estado == 1){
                        $message = 'La estancia que intentas activar, ya esta activa';
                    }else{
                        $message = 'La estancia que intentas deshabilitar, ya esta inactiva';
                    }
                    $resp = array('code' => '1', 'message' => $message);
                }else{
                    if ($consulta->consultarConfirmar("UPDATE Estancias SET bEstadoEstancias = $estado, fUpdateEstancias = CURRENT_TIMESTAMP, eUpdateEstancias = $id_user WHERE eCodeEstancias = $estancia_id")){
                        $resp = array('code' => '0', 'message' => 'La estancia se actualizo correctamente');
                    }else{
                        if ($estado == 1){
                            $message = 'Reacivar';
                        }else{
                            $message = 'Deshactivar';
                        }
                        $resp = array('code' => '1', 'message' => 'Ocurrio un error al intentar ' . $message . ' la estancia');
                    }
                }
            }else{
                $resp = array('code' => '1', 'message' => 'La estancia que estas intentando modificar no existe');
            }
            echo json_encode($resp);
        }

        if (isset($_POST['nombre']) && isset($_POST['proveniencia']) && isset($_POST['fecha']) && isset($_POST['proyecto']) && isset($_POST['instalacion']) && isset($_POST['tipo']) && isset($_POST['enlaces']) && isset($_POST['id_user']) && isset($_FILES['imgs'])){
            $nombre = $_POST['nombre'];
            $proveniencia = $_POST['proveniencia'];
            $fecha = $_POST['fecha'];
            $proyecto = $_POST['proyecto'];
            $instalacion = $_POST['instalacion'];
            $tipo = $_POST['tipo'];
            $enlaces = implode(' ',explode(',', $_POST['enlaces']));
            $direcciones = array();
            $existentes = array();
            $error = false;
            $archivo_error;
            $id_user = $_POST['id_user'];

            // Obtener los nombres de archivo existentes de la base de datos
            $respuesta = $consulta->consultar("SELECT tImgsEstancias FROM estancias");
            if ($respuesta->rowCount()) {
                foreach ($respuesta as $estancia) {
                    $linksArray = explode(',', $estancia['tImgsEstancias']);
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
                if ($consulta->consultarConfirmar("INSERT INTO estancias VALUES (NULL, '$nombre', '$proveniencia', '$proyecto', '$fecha', '$instalacion', $tipo, '$enlaces', '$direccionesString', CURRENT_TIMESTAMP, NULL, $id_user, NULL, 1);")){
                    $estancias = $consulta->consultar("SELECT est.eCodeEstancias, est.tNombreEstancias, est.tProvenienciaEstancias, est.tProyectoEstancias, est.fFechaEstancias, est.tInstalacionesEstancias, te.tNombreTipoEstancia AS tTipoEstancia, est.tLinksEstancias, est.tImgsEstancias, est.fCreateEstancias, est.fUpdateEstancias, uc.tNombreUsuarios AS tCreateUsuario, uu.tNombreUsuarios AS tUpdateUsuario, est.bEstadoEstancias
                    FROM estancias est
                    LEFT JOIN tipoestancia te ON est.eTipoEstancias = te.eCodeTipoEstancia
                    LEFT JOIN usuarios uc ON est.eCreateEstancias = uc.eCodeUsuarios
                    LEFT JOIN usuarios uu ON est.eUpdateEstancias = uu.eCodeUsuarios
                    WHERE est.bEstadoEstancias = 1
                    ORDER BY est.eCodeEstancias DESC LIMIT 1;
                    ");
                    if ($estancias->rowCount()){
                        foreach($estancias as $estancia){
                            $datos = [
                                'estancia' => $estancia['eCodeEstancias'],
                                'nombre' => $estancia['tNombreEstancias'],
                                'proveniencia' => $estancia['tProvenienciaEstancias'],
                                'proyecto' => $estancia['tProyectoEstancias'],
                                'fecha' => $estancia['fFechaEstancias'],
                                'instalacion' => $estancia['tInstalacionesEstancias'],
                                'tipo' => $estancia['tTipoEstancia'],
                                'links' => $estancia['tLinksEstancias'],
                                'imagenes' => $estancia['tImgsEstancias'],
                                'fCreate' => $estancia['fCreateEstancias'],
                                'fUpdate' => $estancia['fUpdateEstancias'],
                                'eCreate' => $estancia['tCreateUsuario'],
                                'eUpdate' => $estancia['tUpdateUsuario'],
                                'estado' => $estancia['bEstadoEstancias']
                            ];
                        }
                        $resp = array('code' => '0', 'message' => 'Estancia agregada correctamente', 'datos' => $datos);
                    }
                }else{
                    // Eliminar los archivos nuevos previamente cargados por que no se puedo registrar la Estancia
                    foreach ($direcciones as $direccion) {
                        if (file_exists($direccion)) {
                            unlink($direccion);
                        }
                    }
                    $resp = array('code' => '1', 'message' => 'Error al intentar agregar la estancia');
                }
            }
            
            echo json_encode($resp);

        }

        if (isset($_POST['estancias'])){
            $estado = $_POST['estancias'] == 'activas' ? 1 : 0;
            $estancias = $consulta->consultar("SELECT est.eCodeEstancias, est.tNombreEstancias, est.tProvenienciaEstancias, est.tProyectoEstancias, est.fFechaEstancias, est.tInstalacionesEstancias, te.tNombreTipoEstancia AS tTipoEstancia, est.tLinksEstancias, est.tImgsEstancias, est.fCreateEstancias, est.fUpdateEstancias, uc.tNombreUsuarios AS tCreateUsuario, uu.tNombreUsuarios AS tUpdateUsuario, est.bEstadoEstancias
            FROM estancias est
            LEFT JOIN tipoestancia te ON est.eTipoEstancias = te.eCodeTipoEstancia
            LEFT JOIN usuarios uc ON est.eCreateEstancias = uc.eCodeUsuarios
            LEFT JOIN usuarios uu ON est.eUpdateEstancias = uu.eCodeUsuarios
            WHERE est.bEstadoEstancias = $estado
            ORDER BY est.eCodeEstancias DESC");

            if ($estancias->rowCount()){
                $datos = array();
                foreach($estancias as $estancia){
                    $datos[] = [
                        'estancia' => $estancia['eCodeEstancias'],
                        'nombre' => $estancia['tNombreEstancias'],
                        'proveniencia' => $estancia['tProvenienciaEstancias'],
                        'proyecto' => $estancia['tProyectoEstancias'],
                        'fecha' => $estancia['fFechaEstancias'],
                        'instalacion' => $estancia['tInstalacionesEstancias'],
                        'tipo' => $estancia['tTipoEstancia'],
                        'links' => $estancia['tLinksEstancias'],
                        'imagenes' => $estancia['tImgsEstancias'],
                        'fCreate' => $estancia['fCreateEstancias'],
                        'fUpdate' => $estancia['fUpdateEstancias'],
                        'eCreate' => $estancia['tCreateUsuario'],
                        'eUpdate' => $estancia['tUpdateUsuario'],
                        'estado' => $estancia['bEstadoEstancias']
                    ];
                }
                $resp = array('code' => '0', 'message' => 'operación exitosa', 'datos' => $datos);
            }else if ($estado == 0){
                $resp = array('code' => '1', 'message' => 'No hay estancias elimindas');
            }else{
                $datos = array();
                $resp = array('code' => '0', 'message' => 'operación exitosa', 'datos' => $datos);
            }
            echo json_encode($resp);
        }
    }
?>