/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!******************************************!*\
  !*** ./resources/assets/js/auth/auth.js ***!
  \******************************************/


$(document).ready(function () {
  $('[data-toggle="password"]').each(function () {
    var input = $(this);
    var eye_btn = $(this).parent().find(".input-icon");
    eye_btn.css("cursor", "pointer").addClass("input-password-hide");
    eye_btn.on("click", function () {
      if (eye_btn.hasClass("input-password-hide")) {
        eye_btn.removeClass("input-password-hide").addClass("input-password-show");
        eye_btn.find(".bi").removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
        input.attr("type", "text");
      } else {
        eye_btn.removeClass("input-password-show").addClass("input-password-hide");
        eye_btn.find(".bi").removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
        input.attr("type", "password");
      }
    });
  });
  if (!$("#phoneNumber").length) {
    return false;
  }
  var input = document.querySelector("#phoneNumber"),
    errorMsg = document.querySelector("#error-msg"),
    validMsg = document.querySelector("#valid-msg");
  var errorMap = [Lang.get("js.invalid_number"), Lang.get("js.invalid_country_number"), Lang.get("js.too_short"), Lang.get("js.too_long"), Lang.get("js.invalid_number"), Lang.get("js.invalid_number")];

  // initialise plugin
  var intl = window.intlTelInput(input, {
    initialCountry: defaultCountryCodeValue,
    separateDialCode: true,
    geoIpLookup: function geoIpLookup(success, failure) {
      $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
        var countryCode = resp && resp.country ? resp.country : "";
        success(countryCode);
      });
    },
    utilsScript: utilsScript
  });
  var reset = function reset() {
    input.classList.remove("error");
    errorMsg.innerHTML = "";
    errorMsg.classList.add("d-none");
    validMsg.classList.add("d-none");
  };
  if (mobileValidation == 1) {
    input.addEventListener("blur", function () {
      reset();
      if (input.value.trim()) {
        if (intl.isValidNumber()) {
          validMsg.classList.remove("d-none");
        } else {
          input.classList.add("error");
          var errorCode = intl.getValidationError();
          if (errorCode >= 0) {
            errorMsg.innerHTML = errorMap[errorCode];
          } else {
            errorMsg.innerHTML = Lang.get("js.invalid_number");
          }
          errorMsg.classList.remove("d-none");
        }
      }
    });
  }

  // on keyup / change flag: reset
  input.addEventListener("change", reset);
  input.addEventListener("keyup", reset);
  if (typeof phoneNo != "undefined" && phoneNo !== "") {
    setTimeout(function () {
      $("#phoneNumber").trigger("change");
    }, 500);
  }
  $("#phoneNumber").on("blur keyup change countrychange", function () {
    if (typeof phoneNo != "undefined" && phoneNo !== "") {
      intl.setNumber("+" + phoneNo);
      phoneNo = "";
    }
    var getCode = intl.selectedCountryData["dialCode"];
    $("#prefix_code").val(getCode);
    var phoneNumber = $(this).val();
    phoneNumber = phoneNumber.replace(/-/g, "");
    $(this).val(phoneNumber);
  });
  var getCode = intl.selectedCountryData["dialCode"];
  $("#prefix_code").val(getCode);
  var getPhoneNumber = $("#phoneNumber").val();
  var removeSpacePhoneNumber = getPhoneNumber.replace(/\s/g, "");
  $("#phoneNumber").val(removeSpacePhoneNumber);
  $("#phoneNumber").focus();
  $("#phoneNumber").trigger("blur");
});
listenSubmit("#UserRegisterForm", function () {
  if (phoneNumberRequired == 1) {
    if (mobileValidation == 1) {
      if ($("#error-msg").text() !== "") {
        $("#phoneNumber").focus();
        return false;
      }
    }
  }
  if ($("#privacyPolicyCheckbox").prop("checked") == false) {
    displayErrorMessage(Lang.get("js.agree_term"));
    return false;
  }
});
listenKeyup("#email", function () {
  var email = $(this).val();
  $.ajax({
    url: route('check.email', email),
    type: "GET",
    success: function success(result) {
      if (result.success) {
        $("#email-error-msg").text("");
      } else {
        $("#email-error-msg").text(Lang.get("js.check_email"));
      }
    }
  });
});
listenClick(".languageSelection", function () {
  var languageName = $(this).data("prefix-value");
  $.ajax({
    type: "POST",
    url: "/change-language",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    data: {
      languageName: languageName
    },
    success: function success() {
      location.reload();
    }
  });
});
/******/ })()
;