const form = document.getElementById('user_form');
const navTabs = document.querySelectorAll('button.nav-link');

const clickEvent = new Event('click');
console.log(navTabs);

form.addEventListener('submit', function(e) {
    if (!this.checkValidity()){
        const invalidFields = [...this.elements].filter((e) => !e.checkValidity());
        
        disableTabs();
        enableInvalidTab(invalidFields[0].getAttribute('data-tab'));
        console.log(invalidFields);
    }
});

function disableTabs(){
    Array.from(navTabs).forEach(element => {
        element.classList.remove('active');
    });
}

function enableInvalidTab(value){
    const invalidTab = Array.from(navTabs).find((element) => element.id.includes(value));

    if (invalidTab){
        invalidTab.dispatchEvent(clickEvent);
    }
}