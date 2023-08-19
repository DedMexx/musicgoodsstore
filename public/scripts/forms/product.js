const addSpecification = document.getElementById('addSpecification');
const addCategory = document.getElementById('addCategory');
const addSpecificationWrapper = document.getElementById('addSpecificationWrapper');
const addCategoryWrapper = document.getElementById('addCategoryWrapper');

addSpecification.addEventListener('click', function () {
    const lastSpecificationBlock = document.getElementsByClassName('specificationBlock')[document.getElementsByClassName('specificationBlock').length - 1];
    let key = 0;
    if (lastSpecificationBlock) {
        const input = lastSpecificationBlock.querySelector('input[id^="specification_"]');
        const id = input.id;
        key = parseInt(id.split('_')[1]) + 1;
    }
    const inputBlock =
        `<div class="inputBlock specificationBlock">
            <label class="insertFormLabel dynamicInputLabel" for="specification_${key}">
                <input class="autocompleteInput insertFormInput dynamicInputLabelInput" type="text"
                       id="specification_${key}_label" name="specification_${key}_label" placeholder="Количество струн">
                <div class="suggest"><ul class="autocomplete specification_${key}_label"></ul></div>
            </label>
            <input class="autocompleteInput insertFormInput dynamicInput" type="text" id="specification_${key}"
                   name="specification_${key}" placeholder="6">
        </div>`;
    addSpecificationWrapper.insertAdjacentHTML('beforebegin', inputBlock);
    autocomplete();
});

addCategory.addEventListener('click', function () {
    const lastCategoryBlock = document.getElementsByClassName('categoryBlock')[document.getElementsByClassName('categoryBlock').length - 1];
    let key = 0;
    if (lastCategoryBlock) {
        const input = lastCategoryBlock.querySelector('input[id^="category_"]');
        const id = input.id;
        key = parseInt(id.split('_')[1]) + 1;
    }
    const inputBlock =
        `<div class="inputBlock categoryBlock">
            <input class="autocompleteInput insertFormInput categoryInput" type="text" id="category_${key}"
                   name="category_${key}" placeholder="Гитары">
            <div class="suggest">
                <ul class="autocomplete category_${key}"></ul>
            </div>
        </div>`;
    addCategoryWrapper.insertAdjacentHTML('beforebegin', inputBlock);
    autocomplete();
});

