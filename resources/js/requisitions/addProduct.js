const productForm = document.getElementById('product_form');
const requisitionForm = document.getElementById('requisition_form');
const productsTableBody = document.getElementById('table_body');

const showBtn = document.getElementById('show_btn');
const closeBtn = document.getElementById('close_btn');
const submitBtn = document.getElementById('submit_btn');
const clickEvent = new Event('click');

const quantityInput = document.getElementById('product_quantity');
const costInput = document.getElementById('product_cost');
const ivaInput = document.getElementById('has_iva');
const currencyInput = document.getElementById('currency_type_id');
const evidenceInput = document.getElementById('evidence');

const totalCost = document.getElementById('total_cost');
const visibleTotal = document.getElementById('visible_total');

const evidenceMessage = document.getElementById('evidence_message');

let isEditingProduct = false;
let editingProductIndex = 0;

const products = [];

// UPDATE TOTAL ON INPUT UPDATE
quantityInput.addEventListener('input', updateTotal);
costInput.addEventListener('input', updateTotal);
ivaInput.addEventListener("change", updateTotal);
currencyInput.addEventListener('change', updateTotal);

showBtn.addEventListener('click', handleOnEditingProduct);

requisitionForm.addEventListener('submit', (e) => {
    e.preventDefault();

    if (!requisitionForm.checkValidity()) return;
    
    submitBtn.setAttribute('disabled', '');
    const requisitionFormData = new FormData(requisitionForm);

    for (let i = 0; i < products.length; i++) {
        for (const[key, value] of Object.entries(products[i])){
            requisitionFormData.append(`product_${i}_${key}`, value);
        }
    }

    const productsValues = Object.values(products);
    requisitionFormData.append('products_length', productsValues.length);

    fetch(`/requisitions`, {
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
            window.location.href = '/requisitions';
        })
    .catch(error => console.error('Error:', error));

});

productForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const data = new FormData(productForm);
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
        console.log(values);
        products.push(values);
        addProductRow(values);
    }
    
    closeBtn.dispatchEvent(clickEvent);
    productForm.reset();
    return false;
})


// FUNCTIONS

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
        else{
            cell.textContent = value;
        }
        i++;
    }

    let actionsCell = row.insertCell(5);
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
        total = total * 1.16;
    }

    totalCost.value = Number(total).toFixed(2);
    visibleTotal.textContent = `$${totalCost.value}`;
}

window.deleteProduct = function(elem){
    const row = elem.parentNode.parentNode;
    const index = row.rowIndex - 1 ;
    products.splice(index, 1);
    row.remove();
}

window.editProduct = function(elem, onUpdate = false){
    isEditingProduct = true;

    showBtn.dispatchEvent(clickEvent);
    const row = elem.parentNode.parentNode;
    const index = row.rowIndex - 1 ;
    
    repopulateForm(products[index], index);
}

function repopulateForm(data, index){
    for (const [key, value] of Object.entries(data)){
        if (!productForm.elements[key]) continue;

        try {
            if (key == 'has_iva'){
                if (value == 'on'){
                    ivaInput.checked = true;
                }
                else{
                    ivaInput.checked = false;
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
    console.log([...updatedData.entries()]);
    let existingData = products[editingProductIndex];

    const updatedEvidence = updatedData.getAll('evidence');
    let evidence = updatedEvidence[0].size;

    // If the form has new Evidence, delete the previous
    if (evidence > 0){
        existingData = convertFormDataToObject(updatedData);
    }
    // Else update all other fields from the previous one, keeping the evidence 
    else{
        for (const [key, value] of updatedData.entries()){
            if (String(key).includes('evidence')) continue;
            existingData[key] = value;
        }
    }

    products[editingProductIndex] = existingData;
    updateRow();
    productForm.reset();
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
        else{
            cell.textContent = value;
        }
        i++;
    }
}

function handleOnEditingProduct(){
    if (isEditingProduct){
        evidenceInput.removeAttribute('required');
        evidenceMessage.textContent = "La evidencia ya ha sido subida. En caso de querer cambiarla, suba los archivos nuevamente."
    }
    else{
        evidenceInput.setAttribute('required', '');
        evidenceMessage.textContent = "";
    }
}

function convertFormDataToObject(data){
    let obj = {};
    
    let evidenceSize = data.getAll('evidence');

    // If evidence was provided
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

document.addEventListener('DOMContentLoaded', addExistingProductsOnEdit);

function addExistingProductsOnEdit(){
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
            console.log(products);
        })
    }
}