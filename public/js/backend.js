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
  window.addEventListener('hide-form', function (event) {
    $('#myForm').modal('hide');
    toastr.success(event.detail.message, 'Success!');
  });
});
window.addEventListener('show-form', function (event) {
  $('#myForm').modal('show');
});
window.addEventListener('alert', function (event) {
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