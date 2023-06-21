<?php

    include_once './consultas.php';
    date_default_timezone_set("America/Mexico_City");
    $consulta = new consultas();
    $resp = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
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

        // if (isset($_POST['']))

    }

?>