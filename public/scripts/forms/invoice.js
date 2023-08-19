const addProduct = document.getElementById('addProduct');
const addProductWrapper = document.getElementById('addProductWrapper');

addProduct.addEventListener('click', function () {
    const lastProductBlock = document.getElementsByClassName('productBlock')[document.getElementsByClassName('productBlock').length - 1];
    let key = 0;
    if (lastProductBlock) {
        const input = lastProductBlock.querySelector('input[id^="product_"]');
        const id = input.id;
        key = parseInt(id.split('_')[1]) + 1;
    }
    const inputBlock =
        `<div class="inputBlock productBlock">
            <label class="insertFormLabel dynamicInputLabel" for="product_${key}">
                <input class="autocompleteInput insertFormInput dynamicInputLabelInput" type="text"
                       id="product_${key}_label" name="product_${key}_label" placeholder="Yamaha Pacific">
                <div class="suggest"><ul class="autocomplete product_${key}_label"></ul>
            </div>
            </label>
            <input class="autocompleteInput insertFormInput dynamicInput" type="text" id="product_${key}"
                   name="product_${key}" placeholder="11">
        </div>`;
    addProductWrapper.insertAdjacentHTML('beforebegin', inputBlock);
    autocomplete();
});
