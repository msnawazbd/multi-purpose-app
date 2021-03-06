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

window.addEventListener('show-view-modal', event => {
    $('#viewModal').modal('show');
})

window.addEventListener('show-modal', event => {
    $('#myModal').modal('show');
})

window.addEventListener('success', event => {
    toastr.success(event.detail.message, 'Success!')
})

window.addEventListener('warning', event => {
    toastr.warning(event.detail.message, 'Warning!')
})

window.addEventListener('info', event => {
    toastr.info(event.detail.message, 'Info!')
})

window.addEventListener('error', event => {
    toastr.error(event.detail.message, 'Error!')
})

$('[x-ref="profileLink"]').on('click', function () {
    localStorage.setItem('_x_currentTab', '"profile"')
});
$('[x-ref="changePasswordLink"]').on('click', function () {
    localStorage.setItem('_x_currentTab', '"changePassword"')
});
