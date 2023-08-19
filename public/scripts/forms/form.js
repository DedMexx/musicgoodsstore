const form = document.getElementsByTagName('form')[0];
const requiredFields = ['name', 'email', 'phone', 'country', 'region', 'city', 'street', 'house', 'post_index',
    'first_name', 'last_name', 'purchase_price', 'selling_price', 'manufacturer', 'date', 'amount'];

for (let i = 0; i < form.length; i++) {
    const input = form[i];
    if (requiredFields.includes(input.id)) {
        input.addEventListener('input', function () {
            validateForm(input);
        });
    }
}
function validateForm(input) {
    if ((input.value === '' || ((input.value.length < 2)) && input.id !== 'house' && input.id !== 'first_name'
        && input.id !== 'last_name')) {
        input.classList.add('notFilled');
        input.setCustomValidity('Пожалуйста, заполните это поле (Не менее 2 символов).');
    } else if (input.id === 'phone' && input.value.length < 6) {
        input.classList.add('notFilled');
        input.setCustomValidity('Пожалуйста, заполните номер телефона (Не менее 6 символов).');
    } else {
        input.classList.remove('notFilled');
        input.setCustomValidity('');
    }
}

form.addEventListener('submit', function (event) {
    let valid = true;
    const emailInput = document.getElementById('email');

    if (emailInput && !emailInput.value.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/)) {
        event.preventDefault();
        Swal.fire({
            title: 'Ошибка',
            text: 'Пожалуйста, введите валидную почту',
            icon: 'error',
            buttonsStyling: false
        });
    }

    for (let i = 0; i < requiredFields.length; i++) {
        const input = document.getElementById(requiredFields[i]);
        if (input && form.id !== 'manufacturer') {
            validateForm(input);
            if (!input.checkValidity()) {
                valid = false;
                // break;
            }
        }
    }

    if (!valid) {
        event.preventDefault();
        Swal.fire({
            title: 'Ошибка',
            text: 'Пожалуйста, заполните все поля',
            icon: 'error',
            buttonsStyling: false
        });
    }
});

const phone = document.getElementById('phone');
if (phone) {
    phone.addEventListener('input', function (event) {
        this.value = this.value.replace(/[^0-9+()-]/g, '');
    });
}

function handleInputWithUnicodeRegex(event) {
    const regex = /[^\p{L}\s.\-]/gu;
    event.target.value = event.target.value.replace(regex, '');
}

function handleInputWithSingleDot(event) {
    event.target.value = event.target.value.replace(/[^0-9.]/g, '');

    const dotCount = event.target.value.split('.').length - 1;
    const parts = event.target.value.split('.');

    if (dotCount > 1) {
        event.target.value = parts[0] + '.' + parts.slice(1).join('');
    }

    if (parts[1] && parts[1].length > 2) {
        event.target.value = parts[0] + '.' + parts[1].slice(0, 2);
    }
}


// Handle только цифры
function handleInputDigit(event) {
    event.target.value = event.target.value.replace(/[^0-9]/gu, '');
}

const country = document.getElementById('country');
if (country) {
    country.addEventListener('input', handleInputWithUnicodeRegex);
}

const region = document.getElementById('region');
if (region) {
    region.addEventListener('input', handleInputWithUnicodeRegex);
}

const city = document.getElementById('city');
if (city) {
    city.addEventListener('input', handleInputWithUnicodeRegex);
}

const purchase_price = document.getElementById('purchase_price');
if (purchase_price) {
    purchase_price.addEventListener('input', handleInputWithSingleDot);
}

const selling_price = document.getElementById('selling_price');
if (selling_price) {
    selling_price.addEventListener('input', handleInputWithSingleDot);
}

const amount = document.getElementById('amount');
if (amount) {
    amount.addEventListener('input', handleInputWithSingleDot);
}

function autocomplete() {

    let autocompleteInputs = document.querySelectorAll('.autocompleteInput');
    Array.from(autocompleteInputs).forEach((autocompleteInput) => {
        let autocompleteList = document.querySelector('ul.' + autocompleteInput.id);

        // console.log(autocompleteInput)
        autocompleteInput.addEventListener('input', function () {
            // Значение в поле
            let query = this.value;
            if (query.length >= 1) {
                let xhr = new XMLHttpRequest();
                xhr.addEventListener('readystatechange', function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        //
                        let selectedOption = null;
                        let suggestOptions = null;
                        let selectedIndex = -1;

                        // При получении ответа
                        if (xhr.status === 200) {
                            // Получить список предложений

                            let response = JSON.parse(xhr.responseText);
                            let data = response.map(function (suggestion) {
                                let value = suggestion.name || suggestion.email || suggestion.country || suggestion.region ||
                                    suggestion.city || suggestion.street || suggestion.house || suggestion.post_index;
                                return '<li class="suggestOption">' + value + '</li>';
                            });

                            // Вывести список
                            autocompleteList.innerHTML = data.join('');
                            // Получить все элементы списка
                            suggestOptions = document.querySelectorAll('.suggestOption');
                            // Назвачить выбранный элемент
                            selectedOption = suggestOptions[selectedIndex];
                            // Метод для подсветки выбранного стрелочками или же мышкой элемента
                            highlightSelectedOption();
                        }

                        function highlightSelectedOption() {
                            suggestOptions.forEach(option => {
                                // Убрать у всех посдветку
                                option.classList.remove('selected');
                                // Вставить выбранный элемент в поле
                                option.addEventListener('click', function () {
                                    autocompleteInput.value = option.innerHTML;
                                    validateForm(autocompleteInput);
                                });
                                // Hover для элементов списка и выбор что они selected
                                option.addEventListener('mouseenter', function () {
                                    suggestOptions.forEach(option => {
                                        option.classList.remove('selected');
                                    });
                                    option.classList.add('selected');
                                    selectedOption = option;
                                });
                                option.addEventListener('mouseleave', function () {
                                    option.classList.remove('selected');
                                    selectedOption = null;
                                });
                            });
                            // Подсветить если выбран стрелочками
                            if (selectedOption) {
                                selectedOption.classList.add('selected');
                            }
                        }

                        document.addEventListener('keydown', function (event) {
                            if (suggestOptions) {
                                switch (event.key) {
                                    case 'ArrowUp':
                                        event.preventDefault();
                                        if (selectedIndex > 0) {
                                            selectedIndex--;
                                            selectedOption = suggestOptions[selectedIndex];
                                        }
                                        break;
                                    case 'ArrowDown':
                                        event.preventDefault();
                                        if (selectedIndex < suggestOptions.length - 1) {
                                            selectedIndex++;
                                            selectedOption = suggestOptions[selectedIndex];
                                        }
                                        break;
                                    case 'Enter':
                                        event.preventDefault();
                                        if (selectedOption) {
                                            autocompleteInput.value = selectedOption.innerHTML;
                                        }
                                        validateForm(autocompleteInput);
                                        break;
                                }
                                highlightSelectedOption();
                            }
                        });
                    }
                });
                xhr.open('GET', '/autocomplete?query=' + query + '&name=' + autocompleteInput.id, true);
                xhr.send();
            } else {
                autocompleteList.innerHTML = ``;
            }
        })
        // Убрать список при расфокусе
        document.addEventListener('click', function (event) {
            if (event.target !== autocompleteInput && !event.target.classList.contains('suggestOption')) {
                autocompleteList.innerHTML = ``;
            }
        });
    });
}

autocomplete();
