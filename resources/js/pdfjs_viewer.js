import * as pdfjsLib from 'pdfjs-dist';
import pdfjsWorker from 'pdfjs-dist/build/pdf.worker?url';

pdfjsLib.GlobalWorkerOptions.workerSrc = pdfjsWorker;

const canvas = document.getElementById('canvas');
const ctxt = canvas.getContext('2d');

const container = document.getElementById('pdf-viewer-container');
const desiredWidth = 400;

const currentPageTxt = $('#current-page');
const totalPagesTxt = $('#total-pages');

let isRendering = false;
let pdfDoc = null;
let currentPage;
let zoom;

window.showPdf = function(url){
    ctxt.clearRect(0, 0, canvas.width, canvas.height);
    initPdfViewer(url);
}

//Consigue PDF y renderiza la primera pagina
function initPdfViewer(url){
    pdfjsLib.getDocument(url).promise.then(pdf => {
        currentPage = 1;
        zoom = 1;

        pdfDoc = pdf;
        renderPage(currentPage);
        totalPagesTxt.text(pdfDoc.numPages);
    })
    .catch((error) => {
        alert(error);
    })
}

//Renderiza la siguiente pagina
function renderQueuePage(num){
    if (isRendering) return;
    if (num < 1 || num > pdfDoc.numPages) return;
    currentPage = num;
    zoom = 1;
    renderPage(currentPage);
}

//Renderiza la pagina dada
function renderPage(num){
    if (isRendering) return;

    isRendering = true;
    pdfDoc.getPage(num).then(page => {
        const viewport = page.getViewport({scale: 1});
        const fitScale = desiredWidth / viewport.width;

        const scale = fitScale * zoom;
        const scaledViewport = page.getViewport({scale});
        const ratio = window.devicePixelRatio || 1;

        canvas.height = scaledViewport.height * ratio;
        canvas.width = scaledViewport.width * ratio;
        canvas.style.width = scaledViewport.width + "px";
        canvas.style.height = scaledViewport.height + "px";
        ctxt.setTransform(ratio, 0, 0, ratio, 0, 0);

        const renderTask = page.render({
            canvasContext: ctxt,
            viewport: scaledViewport
        });

        return renderTask.promise;
    })
    .then(() => {
        isRendering = false;
        container.scrollLeft = (canvas.width - desiredWidth) / 2;
        currentPageTxt.text(currentPage);
    })
    .catch((error) => {
        alert(error);
        isRendering = false;
    });
}

//FUNCIONES DE HERRAMIENTAS
$('#prev-page').on('click', () => {
    renderQueuePage(currentPage - 1); 
})

$('#next-page').on('click', () => {
    renderQueuePage(currentPage + 1);
})

$('#zoom-in').on('click', () => {
    zoom += 0.15;
    renderPage(currentPage);
})

$('#zoom-out').on('click', () => {
    zoom -= 0.15;
    renderPage(currentPage);
})