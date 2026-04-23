import './addSupplier.js';
import './ivaUiHandler.js';

const formatterMX = new Intl.NumberFormat('es-MX', {
    style: "currency",
    currency: "MXN",
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
});

const productForm = document.getElementById('product_form');
const requisitionForm = document.getElementById('requisition_form');
const productsTableBody = document.getElementById('table_body');

const onEditRequisitionId = document.getElementById('requisition_id');

const showBtn = document.getElementById('show_btn');
const closeBtn = document.getElementById('close_btn');
const submitBtn = document.getElementById('submit_btn');
const clickEvent = new Event('click');

const quantityInput = document.getElementById('product_quantity');
const costInput = document.getElementById('product_cost');
const ivaInput = document.getElementById('has_iva');
const ivaPercentageInput = document.getElementById('iva_percentage');
const currencyInput = document.getElementById('currency_type_id');
const evidenceInput = document.getElementById('evidence');

const totalCost = document.getElementById('total_cost');
const visibleTotal = document.getElementById('visible_total');
const requisitionTotal = document.getElementById('requisition_total');

const evidenceMessage = document.getElementById('evidence_message');
const evidenceFilesContainer = document.getElementById('evidence_files_container');

const loader = document.getElementById('load_screen');
const loaderHtml = loader.outerHTML;

let isEditingProduct = false;
let editingProductIndex = 0;

const modal = document.getElementById('reg-modal');

const products = [];

// UPDATE TOTAL ON INPUT UPDATE
modal.addEventListener('hidden.bs.modal',resetFormFields);
quantityInput.addEventListener('input', updateTotal);
costInput.addEventListener('input', updateTotal);
ivaInput.addEventListener("change", updateTotal);
ivaPercentageInput.addEventListener("input", updateTotal);
currencyInput.addEventListener('change', updateTotal);

showBtn.addEventListener('click', onEditingProduct);

document.addEventListener('DOMContentLoaded', () => {
    addExistingProductsOnEdit();
});

requisitionForm.addEventListener('submit', (e) => {
    e.preventDefault();

    if (!requisitionForm.checkValidity()){
        simpleAlert("Campos requeridos no ingresados", "Llene los campos requeridos", 'warning');
        return;
    }
    
    if (products.length <= 0){        
        simpleAlert("Productos no ingresados", "Ingrese los productos a comprar", 'warning');
        return;
    }
    
    if (!validateProductsEvidence()){
        simpleAlert("Evidencias no ingresadas", "Ingrese la evidencia de todos los productos a comprar", 'warning');
        return;
    }
    
    submitBtn.setAttribute('disabled', '');
    const requisitionFormData = new FormData(requisitionForm);

    for (let i = 0; i < products.length; i++) {
        for (const[key, value] of Object.entries(products[i])){
            requisitionFormData.append(`product_${i}_${key}`, value);
        }
    }
    
    const productsValues = Object.values(products);
    const amount = getAmount();

    requisitionFormData.append('products_length', productsValues.length);
    requisitionFormData.append('amount', amount);
    
    let url = '/requisitions';

    if (onEditRequisitionId){
        requisitionFormData.append('_method', 'PUT');
        url = `/requisitions/${onEditRequisitionId.value}`;
    }

    const originalHtml = document.body.innerHTML;
    document.body.innerHTML += loaderHtml;

    fetch(url, {
        credentials: "include",
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        body: requisitionFormData,
        processData: false,
        contentType: false,
        })
        .then(response => {
            const ok = response['ok'];

            if (ok){
                window.location.href = response['url'];
            }
            else{
                document.body.innerHTML = originalHtml;
                simpleAlert("Ocurrió un error", "Contacta al tecnico", 'warning');
            }
        })
    .catch(error => console.error('Error:', error));

});

productForm.addEventListener('submit', (e) => {
    e.preventDefault();
    
    const data = new FormData(productForm);
    
    const hasCompressedFile = validateCompressedFile(data);
    if (hasCompressedFile){
        simpleAlert("Formato de evidencia no valido", "Suba la evidencia en cualquier formato de imagen o PDF", 'warning');
        return;
    }

    //Handle if has IVA checkbox is unchecked
    if (!data.has('has_iva')){
        data.append('has_iva', 'off');
    }
    data.delete('token');

    if (isEditingProduct){
        updateProduct(data);
    }
    else{
        let values = convertFormDataToObject(data);
        products.push(values);
        addProductRow(values);
    }

    closeBtn.dispatchEvent(clickEvent);
    updateRequisitionAmount();
})

// FUNCTIONS

function validateCompressedFile(data){
    let hasCompressedFile = false;

    for (let [key, value] of data.entries()) {
        if (value instanceof File) {
            const fileName = value.name.toLowerCase();
            const fileType = value.type;

            if (
            fileName.endsWith('.zip') ||
            fileName.endsWith('.rar') ||
            fileType === 'application/zip' ||
            fileType === 'application/x-zip-compressed' ||
            fileType === 'application/vnd.rar' ||
            fileType === 'application/x-rar-compressed'
            ) {
                hasCompressedFile = true;
                break;
            }
        }
    }

    return hasCompressedFile;
}

function getAmount(){
    let amount = 0;

    for (let i = 0; i < products.length; i++) {
        const product = products[i];
        amount = amount + Number(product['total_cost']);
    }

    return Number(amount).toFixed(2);
}

function updateRequisitionAmount(){
    const amount = getAmount();
    requisitionTotal.textContent = formatterMX.format(amount);
}

function addProductRow(data){
    let row = productsTableBody.insertRow(-1);

    //Filter the showable data for the user
    const values = filterValues(data);

    let i = 0;
    for (const [key, value] of Object.entries(values)){
        let cell = row.insertCell(i);

        if (key == 'has_iva'){
            cell.textContent = value == 'on' ? 'SI' : 'NO';
        }
        else if (key == 'total_cost' || key == 'product_cost'){
            cell.textContent = formatterMX.format(value);
        }
        else if (key == 'iva_percentage'){
            cell.textContent = value == '1' ? 'NO APLICA' : value;
        }
        else{
            cell.textContent = value;
        }
        i++;
    }

    let actionsCell = row.insertCell(6);
    actionsCell.innerHTML = `
            <a onclick="editProduct(this)" title="Editar" class="btn btn-outline-secondary btn-icon p-auto">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                </svg>
            </a>
        `;
    
    actionsCell.innerHTML += `
        <a onclick="deleteProduct(this)" title="Eliminar" class="btn btn-outline-danger btn-outline-danger btn-icon p-auto">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </svg>
        </a>
    `;
}

function filterValues(data){
    let result = {};

    const showable = [
        'product',
        'product_quantity',
        'product_cost',
        'has_iva',
        'iva_percentage',
        'total_cost',
    ];

    //Create an object with filtered results
    showable.forEach(key => {
        if (data[key]){
            result[key] = data[key];
        }
    });

    return result;
}

function updateTotal(e){
    if (quantityInput <= 0 || costInput <= 0) return;

    let total = quantityInput.value * costInput.value;

    // Handle IVA
    if (!ivaInput.checked){
        total = total * (1 + ivaPercentageInput.value / 100);
    }

    totalCost.value = Number(total).toFixed(2);
    visibleTotal.textContent = formatterMX.format(totalCost.value);
}

window.deleteProduct = function(elem, id = null){
    const row = elem.parentNode.parentNode;
    const index = row.rowIndex - 1 ;

    const confirm = alertYesNo(
        "Elimiar producto",
        "Estas seguro de eliminar este producto?"
    );

    confirm.then((response) => {
        if (response){
            products.splice(index, 1);
            row.remove();
        }
    });

    console.log(products);
}

window.editProduct = function(elem){
    isEditingProduct = true;

    showBtn.dispatchEvent(clickEvent);
    const row = elem.parentNode.parentNode;
    const index = row.rowIndex - 1 ;
    
    repopulateForm(products[index], index);
}

function repopulateForm(data, index){

    if (data['row_id']){
        showEvidences(data['row_id']);
    }

    for (const [key, value] of Object.entries(data)){
        if (!productForm.elements[key]) continue;

        try {
            if (key == 'has_iva'){
                if (value == 'on'){
                    ivaInput.checked = true;
                }
                else{
                    ivaInput.checked = false;
                    $('#percentage_container').removeClass('d-none');
                    $('#iva_percentage').prop('required', true);
                }
            }
            else{
                const field = productForm.elements[key];
                field.value = value;
            }           
        } catch (e) {
            // Catch if a file input can't be set again 
        }
    }
    
    updateTotal();
    editingProductIndex = index;
}

function updateProduct(updatedData){
    //Consigue el producto que esta editandose
    let existingData = products[editingProductIndex];

    const updatedEvidence = updatedData.getAll('evidence');
    let evidence = updatedEvidence[0].size;

    // Si el producto contenia nueva evidencia, reasigna toda la informacion
    if (evidence > 0){
        //Si el producto es existente, y se le esta agregando nueva evidencia, se guarda y reasigna su id
        let existingId = null;
        if (existingData['row_id']){
            existingId = existingData['row_id'];
        }

        existingData = convertFormDataToObject(updatedData);

        if (existingId){
            existingData['row_id'] = existingId;
        }
    }
    // Si el producto ya contenia evidencia, y se actualizan solamente los demas datos 
    else{
        for (const [key, value] of updatedData.entries()){
            if (String(key).includes('evidence')) continue;
            existingData[key] = value;
        }
    }

    products[editingProductIndex] = existingData;
    updateRow();
    isEditingProduct = false;
}

function updateRow(){
    let row = productsTableBody.rows[editingProductIndex];
    const updatedValues = filterValues(products[editingProductIndex]);
    
    let i = 0;
    for (const [key, value] of Object.entries(updatedValues)){
        let cell = row.cells[i];
        
        if (key == 'has_iva'){
            cell.textContent = value == 'on' ? 'SI' : 'NO';
        }
        else if (key == 'total_cost' || key == 'product_cost'){
            cell.textContent = formatterMX.format(value);
        }
        else if (key == 'iva_percentage'){
            cell.textContent = value == '1' ? 'NO APLICA' : value;
        }
        else{
            cell.textContent = value;
        }
        i++;
    }
}

function onEditingProduct(){
    const currentProduct = products[editingProductIndex];
    // Permite subir evidencia si un producto NUEVO tiene evidencia O si un producto EXISTENTE ya contiene evidencia
    // ['has_no_evidence'] es un key que se aplica sobre de un producto existente con evidencia, que se agrega al eliminar toda su evidencia.
    if (isEditingProduct && (currentProduct['evidence_length'] || !currentProduct['has_no_evidence'])){
        evidenceInput.removeAttribute('required');

        if (currentProduct['evidence_length']){
            evidenceMessage.textContent = "La evidencia ya ha sido subida. En caso de querer cambiarla, suba los archivos nuevamente."
        }
        else{
            evidenceMessage.textContent = "";
        }
    }
    else{
        evidenceInput.setAttribute('required', '');
        evidenceMessage.textContent = "";
    }
}

function convertFormDataToObject(data){
    let obj = {};
    
    let evidenceSize = data.getAll('evidence');

    // Si se brinda evidencia, se asigna cantidad y añade cada evidencia con index
    if (evidenceSize.length > 0){
        obj['evidence_length'] = evidenceSize.length;
        for (let i = 0; i < evidenceSize.length; i++) {
            obj[`evidence_${i}`] = evidenceSize[i];
        }
        data.delete('evidence');
    }

    for (const [key, value] of data.entries()){
        obj[key] = value;
    }

    return obj;
}

window.addExistingProductsOnEdit = function (){
    if (productsTableBody.rows.length > 0){
        const rows = Array.from(productsTableBody.rows);

        rows.forEach((row) => {
            const childs = Array.from(row.childNodes);
            const inputs = childs.filter((e) => e.nodeName == 'INPUT');

            let obj = {};
            inputs.forEach((input) => {
                obj[input.name] = input.value;
            });

            products.push(obj);
        })
    }

    console.log(products);
}

function showEvidences(id){
    fetch(`/requisition_row_evidences/${id}/evidences`, {
        credentials: "include",
        method: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        })
        .then(res => res.json())
        .then(response => {
            const paths = Object.values(response);
            
            for (let i = 0; i < paths.length; i++) {
                const path = response[i];
                const evidenceId = path['id'];
                const src = path['path'];

                const extension = String(src).slice(-3); 
                console.log(extension);

                let evidenceNode = document.createElement('div');

                if (extension == 'pdf'){
                    evidenceNode.classList.add('text-center');

                    evidenceNode.innerHTML += `
                        <a href="${src}" class="link-primary text-center" target="_blank">
                            Ver PDF
                        </a>
                    `;
                }
                else{
                    evidenceNode.innerHTML += `
                        <a href="${src}" target="_blank">
                            <img src="${src}" style="width:110px;">
                        </a>
                    `;
                }
                evidenceNode.width = 110;

                const parentNode = document.createElement('div');
                parentNode.classList.add('d-flex', 'flex-column', 'justify-content-center', 'align-items-center', 'gap-3');
                parentNode.style.height = 220;
                parentNode.appendChild(evidenceNode);
                
                parentNode.innerHTML += `
                    <a onclick="" title="Eliminar" class="btn btn-outline-danger btn-outline-danger btn-icon p-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                    </a>
                `;

                const deleteBtn = parentNode.querySelector('a[class*=btn]');
                deleteBtn.addEventListener('click', destroyEvidence.bind(null, evidenceId, parentNode));

                evidenceFilesContainer.appendChild(parentNode);
            }
        })
    .catch(error => console.error('Error:', error));
}

function destroyEvidence(id, parentNode){
    fetch(`/requisition_row_evidences/${id}`, {
        credentials: "include",
        method: "DELETE",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest',
        },
        })
        .then(response => {
            parentNode.remove();
            onDestroyUpdateProduct();
        })
    .catch(error => console.error('Error:', error));
}

function onDestroyUpdateProduct(){
    if (!evidenceFilesContainer.hasChildNodes()){
        products[editingProductIndex]['has_no_evidence'] = true;
        evidenceInput.setAttribute('required', '');
        evidenceMessage.textContent = "";
    }
}

function validateProductsEvidence(){
    let valid = true;

    for (const p of products){
        if (p['has_no_evidence']){
            valid = false;
            break;
        }
    }

    return valid;
}

function resetFormFields(){
    productForm.reset();
    evidenceFilesContainer.replaceChildren();

    $('#percentage_container').addClass('d-none');
    $('#iva_percentage').prop('required', false);
    $('#iva_percentage').val('1');

    totalCost.value = 0.00;
    visibleTotal.textContent = `$${totalCost.value}`;

    if (isEditingProduct) {
        isEditingProduct = false;
    }
}