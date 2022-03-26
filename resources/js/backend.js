$(document).ready(function () {
    toastr.options = {
        "progressBar": true,
        "positionClass": "toast-bottom-right",
    }

    window.addEventListener('hide-form', event => {
        $('#myForm').modal('hide');
        toastr.success(event.detail.message, 'Success!')
    })
});

window.addEventListener('show-form', event => {
    $('#myForm').modal('show');
})

window.addEventListener('alert', event => {
    toastr.success(event.detail.message, 'Success!')
})

window.addEventListener('updated', event => {
    toastr.success(event.detail.message, 'Success!')
})

$('[x-ref="profileLink"]').on('click', function () {
    localStorage.setItem('_x_currentTab', '"profile"')
});
$('[x-ref="changePasswordLink"]').on('click', function () {
    localStorage.setItem('_x_currentTab', '"changePassword"')
});