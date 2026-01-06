import SignaturePad from "signature_pad";

const canvas = document.getElementById('canvas');
const signatureTab = document.getElementById('signature-tab');

if (canvas) {

    const signaturePad = new SignaturePad(canvas, { maxWidth: 1.8 });
    const clearSignatureBtn = document.getElementById('clear_signature');
    const form = document.getElementById('permit_form');

    const signatureFile = document.getElementById('signature_file');
    const pathSignatureInput = document.getElementById('signature_data');

    if (signatureTab){
        signatureTab.addEventListener('shown.bs.tab', () => {
            resizeCanvas();
        });
    }

    resizeCanvas();
    window.addEventListener("resize", resizeCanvas);

    form.addEventListener('submit', (e) => {
        if(signaturePad.isEmpty() && signatureFile.value == null) {
            e.preventDefault();
            canvas.classList.add('border-danger');
            simpleAlert("Firma no ingresada", "El permiso debe ser firmado", 'warning')
            return;
        }
    
        if (canvas.classList.contains('border-danger')) {
            canvas.classList.remove('border-danger');
        }
        canvas.classList.add('border-success');
        pathSignatureInput.value = signaturePad.toDataURL();
    });

    clearSignatureBtn.addEventListener('click', () => {
        signaturePad.clear();
    });

    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);

        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = 265 * ratio;

        const ctx = canvas.getContext("2d");
        ctx.setTransform(1, 0, 0, 1, 0, 0);
        ctx.scale(ratio, ratio);

        signaturePad.clear();
    }
}
