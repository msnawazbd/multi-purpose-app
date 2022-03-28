/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/backend.js ***!
  \*********************************/
$(document).ready(function () {
  toastr.options = {
    "progressBar": true,
    "positionClass": "toast-bottom-right"
  };
  window.addEventListener('hide-modal', function (event) {
    $('#myModal').modal('hide');
    toastr.success(event.detail.message, 'Success!');
  });
});
window.addEventListener('show-modal', function (event) {
  $('#myModal').modal('show');
});
window.addEventListener('alert', function (event) {
  toastr.warning(event.detail.message, 'Warning!');
});
window.addEventListener('info', function (event) {
  toastr.info(event.detail.message, 'Info!');
});
window.addEventListener('error', function (event) {
  toastr.error(event.detail.message, 'Error!');
});
window.addEventListener('success', function (event) {
  toastr.success(event.detail.message, 'Success!');
});
window.addEventListener('updated', function (event) {
  toastr.success(event.detail.message, 'Success!');
});
$('[x-ref="profileLink"]').on('click', function () {
  localStorage.setItem('_x_currentTab', '"profile"');
});
$('[x-ref="changePasswordLink"]').on('click', function () {
  localStorage.setItem('_x_currentTab', '"changePassword"');
});
/******/ })()
;