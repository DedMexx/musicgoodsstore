// // После закрузки страницы
// document.addEventListener('DOMContentLoaded', function () {
//
//     // Определяем элементы
//     let queryInputs = document.querySelectorAll('.autocompleteInput');
//
//     // let currentUrl = window.location.href;
//     // let firstSlashIndex = currentUrl.indexOf('/', 8);
//     // let secondSlashIndex = currentUrl.indexOf('/', firstSlashIndex + 1);
//     // let baseUrl = currentUrl.substring(0, secondSlashIndex);
//
//     // При вводе
//     if (queryInputs) {
//         queryInputs.forEach((queryInput) => {
//             let inputName = queryInput.name;
//             let autocompleteList = document.querySelector('.' + inputName);
//             queryInput.addEventListener('input', function () {
//                 // Значение в поле
//                 let query = this.value;
//                 if (query.length >= 2) {
//                     let xhr = new XMLHttpRequest();
//                     xhr.addEventListener('readystatechange', function () {
//                         if (xhr.readyState === XMLHttpRequest.DONE) {
//                             //
//                             let selectedOption = null;
//                             let suggestOptions = null;
//                             let selectedIndex = -1;
//
//                             // При получении ответа
//                             if (xhr.status === 200) {
//                                 // Получить список предложений
//                                 let response = JSON.parse(xhr.responseText);
//                                 let data = response.map(function (suggestion) {
//                                     return '<li class="suggestOption">' + suggestion[inputName] + '</li>';
//                                 });
//                                 // Вывести список
//                                 autocompleteList.innerHTML = data.join('');
//                                 // Получить все элементы списка
//                                 suggestOptions = document.querySelectorAll('.suggestOption');
//                                 // Назвачить выбранный элемент
//                                 selectedOption = suggestOptions[selectedIndex];
//                                 // Метод для подсветки выбранного стрелочками или же мышкой элемента
//                                 highlightSelectedOption();
//                             }
//
//                             function highlightSelectedOption() {
//                                 suggestOptions.forEach(option => {
//                                     // Убрать у всех посдветку
//                                     option.classList.remove('selected');
//                                     // Вставить выбранный элемент в поле
//                                     option.addEventListener('click', function () {
//                                         queryInput.value = option.innerHTML;
//                                     });
//                                     // Hover для элементов списка и выбор что они selected
//                                     option.addEventListener('mouseenter', function () {
//                                         suggestOptions.forEach(option => {
//                                             option.classList.remove('selected');
//                                         });
//                                         option.classList.add('selected');
//                                         selectedOption = option;
//                                     });
//                                     option.addEventListener('mouseleave', function () {
//                                         option.classList.remove('selected');
//                                         selectedOption = null;
//                                     });
//                                 });
//                                 // Подсветить если выбран стрелочками
//                                 if (selectedOption) {
//                                     selectedOption.classList.add('selected');
//                                 }
//                             }
//
//                             document.addEventListener('keydown', function (event) {
//                                 if (suggestOptions) {
//                                     switch (event.key) {
//                                         case 'ArrowUp':
//                                             event.preventDefault();
//                                             if (selectedIndex > 0) {
//                                                 selectedIndex--;
//                                                 selectedOption = suggestOptions[selectedIndex];
//                                             }
//                                             break;
//                                         case 'ArrowDown':
//                                             event.preventDefault();
//                                             if (selectedIndex < suggestOptions.length - 1) {
//                                                 selectedIndex++;
//                                                 selectedOption = suggestOptions[selectedIndex];
//                                             }
//                                             break;
//                                         case 'Enter':
//                                             event.preventDefault();
//                                             if (selectedOption) {
//                                                 queryInput.value = selectedOption.innerHTML;
//                                             }
//                                             break;
//                                     }
//                                     highlightSelectedOption();
//                                 }
//                             });
//
//                         }
//                     });
//                     xhr.open('GET', '/autocomplete?query=' + query + '&name=' + inputName, true);
//                     xhr.send();
//                 }
//                 // Удалить список если меньше 2 символов в поле
//                 else {
//                     autocompleteList.innerHTML = null;
//                 }
//             })
//             // Убрать список при расфокусе
//             document.addEventListener('click', function (event) {
//                 if (event.target !== queryInput && !event.target.classList.contains('suggestOption')) {
//                     autocompleteList.innerHTML = null;
//                 }
//             });
//         });
//     }
// });
