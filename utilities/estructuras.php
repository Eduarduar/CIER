<div id="menuDesplegableHeader" class="menu">
    <ul>
    </ul>
</div>

<div class="modal fade" id="agregarEstructura" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva Estructura</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nombreEstructura" class="form-label">Nombre de la Estructura</label>
                    <input type="text" class="form-control" id="nombreEstructura" name="nombreEstructura" placeholder="Ej: Laboratorio de Biomasa">
                </div>
                <div class="mb-3">
                    <label for="pdfR" class="form-label">Pdf de Reglamento</label>
                    <input class="form-control" type="file" id="pdfR" accept="application/pdf">
                </div>
                <div class="mb-3">
                    <label for="pdfI" class="form-label">Pdf de Infraestructura</label>
                    <input class="form-control" type="file" id="pdfI" accept="application/pdf">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" disabled>Agregar Estructura</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-xl" id="verEliminados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Estructuras Eliminadas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body table-responsive">

                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Estructura</th>
                        <th scope="col">Creado por</th>
                        <th scope="col">Creado</th>
                        <th scope="col">Actualizado por</th>
                        <th scope="col">Actualizado</th>
                        <th scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        
                            $estructuras = $consulta->consultar("SELECT e.eCodeEstructuras, e.tNombreEstructuras, e.tReglamentoEstructuras, e.tPdfEstructuras, e.fCreateEstructuras, e.fUpdateEstructuras, u1.tNombreUsuarios AS tNombreCreateEstructuras, u2.tNombreUsuarios AS tNombreUpdateEstructuras, e.bEstadoEstructuras
                            FROM estructuras e
                            JOIN usuarios u1 ON e.eCreateEstructuras = u1.eCodeUsuarios
                            LEFT JOIN usuarios u2 ON e.eUpdateEstructuras = u2.eCodeUsuarios
                            WHERE e.bEstadoEstructuras = 0;");

                            if ($estructuras->rowCount()){
                                foreach($estructuras as $estructura){
                                    ?>
                                    
                                        <tr class="contenidoHeader" data-estructura="<?php echo $estructura['eCodeEstructuras']; ?>" data-accion="estructura_tabla" data-estado="inactivo">
                                            <td data-estructura="<?php echo $estructura['eCodeEstructuras']; ?>" data-accion="estructura_tabla" data-estado="inactivo"><?php echo $estructura['eCodeEstructuras']; ?></td>
                                            <td data-estructura="<?php echo $estructura['eCodeEstructuras']; ?>" data-accion="estructura_tabla" data-estado="inactivo"><?php echo $estructura['tNombreEstructuras']; ?></td>
                                            <td data-estructura="<?php echo $estructura['eCodeEstructuras']; ?>" data-accion="estructura_tabla" data-estado="inactivo"><?php echo $estructura['tNombreCreateEstructuras']; ?></td>
                                            <td data-estructura="<?php echo $estructura['eCodeEstructuras']; ?>" data-accion="estructura_tabla" data-estado="inactivo"><?php echo $estructura['fCreateEstructuras']; ?></td>
                                            <td data-estructura="<?php echo $estructura['eCodeEstructuras']; ?>" data-accion="estructura_tabla" data-estado="inactivo"><?php if ($estructura['tNombreUpdateEstructuras'] == NULL) {echo '------';}else{echo $estructura['tNombreUpdateEstructuras'];} ?></td>
                                            <td data-estructura="<?php echo $estructura['eCodeEstructuras']; ?>" data-accion="estructura_tabla" data-estado="inactivo"><?php if ($estructura['fUpdateEstructuras'] == NULL) {echo '------';}else{echo $estructura['fUpdateEstructuras'];}  ?></td>
                                            <td data-estructura="<?php echo $estructura['eCodeEstructuras']; ?>" data-accion="estructura_tabla" data-estado="inactivo">inactivo</td>
                                        </tr>
                                    
                                    <?php
                                }
                            }else{
                                
                                ?>
                                
                                    <tr>
                                        <td colspan="7" class="noEstructuras">No hay estructuras eliminadas</td>
                                    </tr>

                                <?php

                            }
                        
                        ?>
                    
                    </tbody>
                </table>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="verEstructura" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalNombreVerEstructura"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body flex-center">
                <button class="btn btn-danger" data-bs-target="#verPdf" id="buttonPdfR" data-bs-toggle="modal">Reglamento de laboratorio</button>
                <button class="btn btn-success mt-4" data-bs-target="#verPdf" id="buttonPdfI" data-bs-toggle="modal">Infraestructura de laboratorio</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade modal-xl" id="verPdf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-target="#verEstructura" data-bs-toggle="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="verPDF" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>

