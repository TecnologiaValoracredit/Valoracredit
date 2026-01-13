const form = document.getElementById('product_form');
const productsTable = document.getElementById('table_body');

const showBtn = document.getElementById('show_btn');
const closeBtn = document.getElementById('close_btn');
const clickEvent = new Event('click');

const quantityInput = document.getElementById('product_quantity');
const costInput = document.getElementById('product_cost');
const ivaInput = document.getElementById('has_iva');
const currencyInput = document.getElementById('currency_type_id');
const evidenceInput = document.getElementById('evidence');

const totalCost = document.getElementById('total_cost');
const visibleTotal = document.getElementById('visible_total');

let isEditingProduct = false;
let editingProductIndex = 0;

const products = [];

// UPDATE TOTAL ON INPUT UPDATE
quantityInput.addEventListener('input', updateTotal);
costInput.addEventListener('input', updateTotal);
ivaInput.addEventListener("change", updateTotal);
currencyInput.addEventListener('change', updateTotal);

showBtn.addEventListener('click', handleOnEditinProduct);

form.addEventListener('submit', (e) => {
    e.preventDefault();
    const data = new FormData(form);
    let values = Object.fromEntries(data.entries());

    //Handle if has IVA checkbox is unchecked and fix index for table positioning
    if (data.has('has_iva')){
        data.delete('has_iva');
        data.append('has_iva', 'on');
    }
    else{
        data.append('has_iva', 'off');
    }

    //Add product data before filtering out
    if (isEditingProduct){
        console.log(editingProductIndex);
        console.log(products[editingProductIndex]);
        updateProduct(values);
    }
    else{
        products.push(values);
        addProductRow(values);
    }
    
    closeBtn.dispatchEvent(clickEvent);
    form.reset();
    return false;
})


// FUNCTIONS

function addProductRow(data){
    let row = productsTable.insertRow(-1);

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
            <a onclick=editProduct(this) title="Editar" class="btn btn-outline-secondary btn-icon p-auto">
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
        'total_cost',
        'has_iva',
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
    for (const [key, value] of Object.entries(data)){
        if (!form.elements[key]) continue;

        try {            
            const field = form.elements[key];
            field.value = value;
        } catch (e) {
            // Catch if a file input can't be set again 
        }
    }

    editingProductIndex = index;
}

function updateProduct(updatedData){
    let existingData = products[editingProductIndex];
    console.log(existingData);

    for (const [key, value] of Object.entries(updatedData)){
        if (key == 'evidence' && value == '') continue;
        existingData[key] = value;
    }

    products[editingProductIndex] = existingData;
}

function handleOnEditinProduct(){
    if (isEditingProduct){
        evidenceInput.removeAttribute('required');
    }
    else{
        evidenceInput.setAttribute('required', '');
    }
}