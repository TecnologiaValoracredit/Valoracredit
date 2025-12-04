const checkbox = document.getElementById('is_indeterminate');

const durationInput = document.getElementById('duration');
const durationLabel = document.querySelector(`label[for="duration"]`)
const durationContainer = document.getElementById('duration-container');
let lastSavedValue = durationInput.value;

const changeEvent = new Event('change');

checkbox.addEventListener('change', updateFunction);

function updateFunction() {
    if (this.checked){
        lastSavedValue = durationInput.value == -1 ? '' : durationInput.value;

        durationInput.setAttribute('type', 'hidden');
        durationInput.value = -1;
        durationLabel.setAttribute('hidden', '');
        durationContainer.classList.remove('mb-4');
    }
    else{
        durationInput.setAttribute('type', 'number');
        durationInput.value = lastSavedValue;
        durationLabel.removeAttribute('hidden');
        durationContainer.classList.add('mb-4');
    }
};

window.markCheckbox = function() {
    checkbox.checked = true;
    checkbox.dispatchEvent(changeEvent);
};

