const addProduct = document.getElementById('addProduct');
const addProductWrapper = document.getElementById('addProductWrapper');

// Для количества товара
let amounts = Array.from(document.getElementsByClassName('amount'));
amounts.forEach(amount => {
    amount.addEventListener('input', handleInputDigit);
});

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
            <input class="autocompleteInput insertFormInput dynamicInput productName" type="text"
                       id="product_${key}" name="product_${key}" placeholder="Yamaha Pacific">
            <div class="suggest"><ul class="autocomplete product_${key}"></ul></div>
            <input class="insertFormInput dynamicInput amount" type="text" id="product_${key}_amount" name="product_${key}_amount"
               placeholder="2">
            <input disabled class="insertFormInput dynamicInput" type="text" id="product_${key}_price" name="product_${key}_price"
               placeholder="15,000.50₽">
            <input disabled class="insertFormInput dynamicInput cost" type="text" id="product_${key}_cost"
                   name="product_${key}_cost" placeholder="30,001.00₽">
        </div>`;
    addProductWrapper.insertAdjacentHTML('beforebegin', inputBlock);
    autocomplete();
    autocompleteCost()
    let amount = document.getElementById(`product_${key}_amount`);
    amount.addEventListener('input', handleInputDigit);
});

function autocompleteCost() {
    let products = document.querySelectorAll('.productName');
    products.forEach(product => {
        const id = product.id;
        let key = parseInt(id.split('_')[1]);
        let price = document.getElementById('product_' + key + '_price');
        let amount = document.getElementById('product_' + key + '_amount');
        let cost = document.getElementById('product_' + key + '_cost');
        product.addEventListener('input', function () {
            autocompletePrice(price, cost, amount, product)
        });
        setInterval(function () {
            autocompletePrice(price, cost, amount, product)
        }, 1000);
        amount.addEventListener('input', function () {
            if (amount && price) {
                cost.value = parseInt(price.value) * parseInt(amount.value);
            }
        });
    });
}

function autocompletePrice(price, cost, amount, product) {
    let xhr = new XMLHttpRequest();
    xhr.addEventListener('readystatechange', function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            if (xhr.responseText === '[]') {
                price.value = 'Товар не найден';
            } else {
                price.value = Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2,
                    useGrouping: true
                }).format(xhr.responseText) + '₽';
                if (amount.value) {
                    cost.value = Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 2,
                        useGrouping: true
                    }).format(parseInt(xhr.responseText) * parseInt(amount.value)) + '₽';
                } else {
                    cost.value = 'Не указано количество';
                }
            }
        }
    });
    xhr.open('GET', '/autocomplete?query=' + product.value + '&name=price', true);
    xhr.send();

    // Высчитывание полной стоимости заказа
    let totalCostNumber = 0;
    let totalCost = document.getElementById('totalCost');
    let costs = Array.from(document.getElementsByClassName('cost'));
    costs.forEach(thisCost => {
        // Извлечение числового значения из строки с валютой
        let costValue = thisCost.value.replace(/[^\d.-]/g, '');
        if (!isNaN(parseFloat(costValue))) {
            totalCostNumber += parseFloat(costValue);
        }
    });
    // Форматирование общей стоимости с разделителем тысяч
    if (totalCostNumber === 0 || isNaN(totalCostNumber)) {
        totalCost.value = 'Нет данных для расчета';
    } else {
        totalCost.value = Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            useGrouping: true
        }).format(totalCostNumber) + '₽';
    }
}

autocompleteCost();
