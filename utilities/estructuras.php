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

<div class="modal fade" id="verEliminados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Estructuras Eliminadas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


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


<div class="modal fade modal-dialog modal-xl" id="verPdf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

