$(document).ready(function () {
    toastr.options = {
        "progressBar": true,
        "positionClass": "toast-bottom-right",
    }

    window.addEventListener('hide-modal', event => {
        $('#myModal').modal('hide');
        toastr.success(event.detail.message, 'Success!')
    })
});

window.addEventListener('show-modal', event => {
    $('#myModal').modal('show');
})

window.addEventListener('alert', event => {
    toastr.warning(event.detail.message, 'Warning!')
})

window.addEventListener('info', event => {
    toastr.info(event.detail.message, 'Info!')
})

window.addEventListener('error', event => {
    toastr.error(event.detail.message, 'Error!')
})

window.addEventListener('success', event => {
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
