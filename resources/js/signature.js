import SignaturePad from "signature_pad";

const canvas = document.getElementById('canvas');

if (canvas){
    const signaturePad = new SignaturePad(canvas, {
        maxWidth: 1.8,
    });
    const clearSignatureBtn = document.getElementById('clear_signature');
    
    const form = document.getElementById('permit_form');
    const pathSignatureInput = document.getElementById('signature_data');
    
    canvas.height = 265;

    clearSignatureBtn.addEventListener('click', clearSignature);
    window.addEventListener("resize", resizeCanvas);
    resizeCanvas();
    
    function clearSignature(){
        signaturePad.clear();
    }
    
    form.addEventListener('submit', (e) => {
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
    
    function resizeCanvas() {
        const ratio =  Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }
}    

