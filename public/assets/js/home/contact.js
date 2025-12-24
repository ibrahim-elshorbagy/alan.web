/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************!*\
  !*** ./resources/assets/js/home/contact.js ***!
  \*********************************************/
function displayError(selector, msg) {
  var selectorAttr = $(selector);
  selectorAttr.removeClass('d-none');
  selectorAttr.show();
  selectorAttr.text(msg);
  setTimeout(function () {
    $(selector).slideUp();
  }, 3000);
}
listenSubmit('#myForm', function (event) {
  event.preventDefault();
  $.ajax({
    url: route('contact.store'),
    type: 'POST',
    data: $(this).serialize(),
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $('#myForm')[0].reset();
      }
    },
    error: function error(result) {
      displayError('#contactError', result.responseJSON.message);
    }
  });
});
listenClick('.contact-enquiry-delete-btn', function (event) {
  var recordId = $(event.currentTarget).attr('data-id');
  deleteItem(route('contactus.destroy', recordId), Lang.get("js.enquiry"));
});
/******/ })()
;