<?php

    include_once './consultas.php';
    date_default_timezone_set("America/Mexico_City");
    $consulta = new consultas();
    $resp = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['nombre']) && isset($_FILES['pdfR']) && isset($_FILES['pdfI']) && isset($_POST['id_user'])){
            $nombre = $_POST['nombre'];
            $id_user = $_POST['id_user'];
            $error = false;
            
            do {
                $error = false;
                $nuevoNombreR = renombre(10, '../src/pdf/', $_FILES['pdfR']['name']);

                $pdfRs = $consulta->consultar("SELECT tReglamentoEstructuras FROM estructuras;");
                if ($pdfRs->rowCount()){
                    foreach ($pdfRs as $pdfR){
                        if ($pdfR['tReglamentoEstructuras'] == $nuevoNombreR){
                            $error = true;
                        }
                    }
                }
            }while($error);
            do {
                $error = false;
                $nuevoNombreI = renombre(10, '../src/pdf/', $_FILES['pdfI']['name']);

                $pdfRs = $consulta->consultar("SELECT tPdfEstructuras FROM estructuras;");
                if ($pdfRs->rowCount()){
                    foreach ($pdfRs as $pdfR){
                        if ($pdfR['tPdfEstructuras'] == $nuevoNombreI){
                            $error = true;
                        }
                    }
                }
            }while($error);
            $error = false;
            if (move_uploaded_file($_FILES['pdfR']['tmp_name'], $nuevoNombreR)){
                if (move_uploaded_file($_FILES['pdfI']['tmp_name'], $nuevoNombreI)){
                    if ($consulta->consultarConfirmar("INSERT INTO estructuras VALUES (NULL, '$nombre', '$nuevoNombreR', '$nuevoNombreI', CURRENT_TIMESTAMP, NULL, $id_user, NULL, 1);")){
                        $estructuras = $consulta->consultar("SELECT e.eCodeEstructuras, e.tNombreEstructuras, e.tReglamentoEstructuras, e.tPdfEstructuras, e.fCreateEstructuras, e.fUpdateEstructuras, u1.tNombreUsuarios AS tNombreCreateEstructuras, u2.tNombreUsuarios AS tNombreUpdateEstructuras, e.bEstadoEstructuras
                        FROM estructuras e
                        JOIN usuarios u1 ON e.eCreateEstructuras = u1.eCodeUsuarios
                        LEFT JOIN usuarios u2 ON e.eUpdateEstructuras = u2.eCodeUsuarios
                        WHERE e.bEstadoEstructuras = 1
                        ORDER BY e.eCodeEstructuras DESC LIMIT 1");

                        if ($estructuras->rowCount()){
                            foreach($estructuras as $estructura){
                                $datos = [
                                    'code' => $estructura['eCodeEstructuras'],
                                    'nombre' => $estructura['tNombreEstructuras']
                                ];
                            }
                            $resp = array('code' => '0', 'message' => 'Se agrego una nueva estrucutra', 'datos' => $datos);
                        }
                    }else{
                        unlink($nuevoNombreI);
                        unlink($nuevoNombreR);
                        $resp = array('code' => '1', 'message' => 'Error al intentar agregar la estructura');
                    }
                }else{
                    unlink($nuevoNombreR);
                    $resp = array('code' => '1', 'message' => 'Error al intentar subir el archivo: ' . $_FILES['pdfI']['name']);
                }
            }else{
                $resp = array('code' => '1', 'message' => 'Error al intentar subir el archivo: ' . $_FILES['pdfR']['name']);   
            }   
            echo json_encode($resp);
        }
        
        if (isset($_POST['getEstructura'])){
            $estructura_id = $_POST['getEstructura'];
            $estructuras = $consulta->consultar("SELECT * FROM estructuras WHERE eCodeEstructuras = $estructura_id");
            if($estructuras->rowCount()){
                foreach($estructuras as $estructura){
                    $datos = [
                        'nombre' => $estructura['tNombreEstructuras'],
                        'pdfI' => $estructura['tPdfEstructuras'],
                        'pdfR' => $estructura['tReglamentoEstructuras']
                    ];
                    $resp = array('code' => '0', 'message' => 'operación exitosa', 'datos' => $datos);
                }
            }else{
                $resp = array('code' => '1', 'message' => 'La estructura no existe');
            }
            echo json_encode($resp);
        }

        if (isset($_POST['estructura']) && isset($_POST['estructura_id']) && isset($_POST['id_user'])){
            $estructura_id = $_POST['estructura_id']; 
            $id_user = $_POST['id_user'];
            $estado = $_POST['estructura'] == 'eliminar' ? 0 : 1;
            $error = '';
            $estructuras = $consulta->consultar("SELECT bEstadoEstructuras FROM estructuras WHERE eCodeEstructuras = $estructura_id");
            if ($estructuras->rowCount()){
                foreach($estructuras as $estructura){
                    if ($estructura['bEstadoEstructuras'] == $estado){
                        $error = 'estado';
                        break;
                    }
                }
                if ($error == 'estado'){
                    if ($estado == 1){
                        $message = 'La estructura que intentas activar, ya esta activa';
                    }else{
                        $message = 'La estructura que intentas deshabilitar, ya esta inactiva';
                    }
                    $resp = array('code' => '1', 'message' => $message);
                }else{
                    if ($consulta->consultarConfirmar("UPDATE estructuras SET bEstadoEstructuras = $estado, fUpdateEstructuras = CURRENT_TIMESTAMP, eUpdateEstructuras = $id_user WHERE eCodeEstructuras = $estructura_id")){
                        $estructuras = $consulta->consultar("SELECT e.eCodeEstructuras, e.tNombreEstructuras, e.tReglamentoEstructuras, e.tPdfEstructuras, e.fCreateEstructuras, e.fUpdateEstructuras, u1.tNombreUsuarios AS tNombreCreateEstructuras, u2.tNombreUsuarios AS tNombreUpdateEstructuras, e.bEstadoEstructuras
                        FROM estructuras e
                        JOIN usuarios u1 ON e.eCreateEstructuras = u1.eCodeUsuarios
                        LEFT JOIN usuarios u2 ON e.eUpdateEstructuras = u2.eCodeUsuarios
                        WHERE e.bEstadoEstructuras = $estado;");

                        $datos = array();
                        if ($estructuras->rowCount()){
                            foreach($estructuras as $estructura){
                                $datos[] = [
                                    'code' => $estructura['eCodeEstructuras'],
                                    'nombre' => $estructura['tNombreEstructuras'],
                                    'eCreate' => $estructura['tNombreCreateEstructuras'],
                                    'fCreate' => $estructura['fCreateEstructuras'],
                                    'eUpdate' => $estructura['tNombreUpdateEstructuras'],
                                    'fUpdate' => $estructura['fUpdateEstructuras'],
                                    'estado' => $estructura['bEstadoEstructuras']
                                ];
                            }
                        }

                        $resp = array('code' => '0', 'message' => 'La estructura se actualizo correctamente', 'datos' => $datos);
                        $historial = ['accion' => 'Cambio el estado de una estructura', 'id' => $id_user];
                        $consulta->setHistorial($historial);
                    }else{
                        if ($estado == 1){
                            $message = 'Reacivar';
                        }else{
                            $message = 'Deshactivar';
                        }
                        $resp = array('code' => '1', 'message' => 'Ocurrio un error al intentar ' . $message . ' la estructura');
                    }
                }
            }else{
                $resp = array('code' => '1', 'message' => 'La estructura que estas intentando modificar no existe');
            }
            echo json_encode($resp);
        }

    }

?>