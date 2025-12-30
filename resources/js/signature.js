import SignaturePad from "signature_pad";

const canvas = document.getElementById('canvas');
const signaturePad = new SignaturePad(canvas);

const form = document.getElementById('permit_form');
const pathSignatureInput = document.getElementById('signature_data');

form.addEventListener('submit', (e) => {
    if (!canvas) return;
    if(signaturePad.isEmpty()) {
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

console.log(signaturePad);

function resizeCanvas() {
    const ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
    signaturePad.clear();
}

window.addEventListener("resize", resizeCanvas);
resizeCanvas();
