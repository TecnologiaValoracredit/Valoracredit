<div class="modal-header bg-light">
    <h5 class="modal-title" id="pdf-viewer-modal-title">Visualizador de PDF</h5>
    <button id="pdf-viewer-close_btn" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
    </button>
</div>

<div class="modal-body bg-light">
    @include("components.custom.errors")

    <div class="p-3 bg-light rounded shadow-sm">
        @csrf
        <div class="d-flex justify-content-center">
            <div class="w-100">
            <!-- PDF VIEWER CONTAINER -->
                <div class="mt-4 row d-flex justify-content-center gap-3">
                    <!-- CONTROLES -->
                    <div class="col-md-10 py-1 px-2 d-flex justify-content-between align-items-center bg-light">
                        <div class="navigation-btns d-flex justify-content-center align-items-center gap-2">
                            <div id="prev-page" class="btn btn-primary">&larr;</div>
                            <div id="next-page" class="btn btn-primary">&rarr;</div>
                        </div>
                        <div class="page-info d-flex justify-content-center align-items-center gap-2">
                            <span id="current-page">#</span>
                            /
                            <span id="total-pages">#</span>
                        </div>
                        <div class="scale-btns d-flex justify-content-center align-items-center gap-2">
                            <div id="zoom-out" class="btn btn-primary">&minus;</div>
                            <div id="zoom-in" class="btn btn-primary">&plus;</div>
                        </div>
                    </div>
                    <div class="col-md-10 d-flex justify-content-center bg-light py-2">
                        <div id="pdf-viewer-container" style="width: 400px; height: 600px;" class="border overflow-auto">
                            <canvas id="canvas" style="display: block; margin: 0 auto;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer bg-light">
    <button type="button" id="close_pdf_viewer" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
</div>