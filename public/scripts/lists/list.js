const email = document.querySelectorAll('.emailLink');
const deleteForms = Array.from(document.querySelectorAll('.delete form'));

deleteForms.forEach((deleteForm) => {
    deleteForm.addEventListener('submit', function (event) {
        event.preventDefault();
        Swal.fire({
            title: 'Вы уверены?',
            text: "Вы не сможете отменить это действие!",
            icon: 'warning',
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Да, удалить!',
            cancelButtonText: 'Отмена'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    {
                        title: 'Удалено',
                        text: 'Запись была удалена',
                        icon: 'success',
                        buttonsStyling: false
                    }
                )
                deleteForm.submit();
            }
        })
    });
});

email.forEach((item) =>{
    const chunkSize = 30;
    const regex = new RegExp(`(\\S{${chunkSize}})`, 'g');
    item.innerHTML = item.innerHTML.replace(regex, '$1<br>');
});
