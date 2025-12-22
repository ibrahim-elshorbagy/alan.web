"use strict";

const { pull } = require("lodash");

document.addEventListener("DOMContentLoaded", load);

function load() {
    $("html, body").animate({
        scrollTop: $("html, body").offset().top,
    });

    $(".customSelect").each(function () {
        let selectedOption = $(this).find("option:selected");
        let newPrice = selectedOption.data("price");
        let planId = $(this).data("plan-id");
        let choosePaymnetURL = route("choose.payment.type", planId);
        $(".custom-price-" + planId).text(newPrice);
        $("#planId" + planId).attr(
            "href",
            choosePaymnetURL + "?customFieldId=" + selectedOption.val()
        );
    });
}

listenSubmit("#addEmail", function (e) {
    e.preventDefault();
    $(".subscribeBtn").attr("disabled", true);
    $.ajax({
        url: route("email.sub"),
        type: "POST",
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                document.getElementById("addEmail").reset();
            }
            $(".subscribeBtn").attr("disabled", false);
        },
        error: function (result) {
            $(".subscribeBtn").attr("disabled", false);
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

listenClick(".navbar-nav .nav-item .nav-link", function () {
    $(".navbar-collapse").collapse("hide");
});

listenClick(".js-cookie-consent-declined", function () {
    $(".js-cookie-consent").addClass("d-none");
    $.ajax({
        url: route("declineCookie"),
        type: "GET",
        success: function (result) { },
        error: function error(result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});
listenClick(".js-cookie-consent-agree", function () {
    $(".js-cookie-consent").addClass("d-none");
});

listenClick(".fa-scroll-torah-custom", function () {
    $("html, body").animate({
        scrollTop: $("html, body").offset().top,
    });
});

listenClick(".nav-link", function () {
    $(".navbar-toggler ").removeClass("open");
});

listenClick(".close-btn", function () {
    $(".banner-section ").addClass("d-none");
    var expires = new Date();
    expires.setHours(expires.getHours() + 24);
    document.cookie = "banner-section=1; expires=" + expires.toUTCString();
});

window.onload = function () {
    if (document.cookie.includes("banner-section")) {
        $(".banner-cookie").addClass("d-none").removeClass("d-block");
    } else {
        $(".banner-cookie").addClass("d-block").removeClass("d-none");
    }
};

listenClick(".close-btn", function () {
    $(".banner-section-theme4").addClass("hidden");
    var expires = new Date();
    expires.setHours(expires.getHours() + 24);
    document.cookie = "banner-section-theme4=1; expires=" + expires.toUTCString();
});

window.onload = function () {
    if (document.cookie.includes("banner-section-theme4")) {
        $(".banner-cookie-theme4").addClass("hidden").removeClass("block");
    } else {
        $(".banner-cookie-theme4").addClass("block").removeClass("hidden");
    }
};

listenClick(".show-plan-features", function (event) {
    var pricingCard = $(this).closest(".pricing-card");
    var allFeatures = pricingCard.find(".all-features");
    allFeatures.removeClass("d-none");
    allFeatures.slideDown("slow", function () {
        pricingCard.find(".show-plan-features").addClass("d-none");
        pricingCard.find(".less-plan-features").removeClass("d-none");
    });
});

listenClick(".less-plan-features", function (event) {
    var pricingCard = $(this).closest(".pricing-card");
    var allFeatures = pricingCard.find(".all-features");
    allFeatures.slideUp("slow", function () {
        allFeatures.addClass("d-none");
        pricingCard.find(".show-plan-features").removeClass("d-none");
        pricingCard.find(".less-plan-features").addClass("d-none");
    });
});



function listenChange(selector, callback) {
    $(document).on("change", selector, function () {
        callback.call(this);
    });
}

listenChange(".customSelect", function () {
    let selectedOption = $(this).find("option:selected");
    let newPrice = selectedOption.data("price");
    let planId = $(this).data("plan-id");
    let choosePaymnetURL = route("choose.payment.type", planId);
    $(".custom-price-" + planId).text(newPrice);
    $("#planId" + planId).attr(
        "href",
        choosePaymnetURL + "?customFieldId=" + selectedOption.val()
    );
});

listenClick("#search-alias-btn", function () {
    let vcardAlias = $("#search-alias-input").val().trim();
    if (vcardAlias.length > 0) {
        $.ajax({
            url: route("vcards.check-url-alias-available", vcardAlias),
            type: "GET",
            success: function (result) {
                let data = result.data;

                if (!data.isUnique && data.usedInVcard) {
                    $("#search-alias-success").addClass("d-none");
                    $("#search-alias-error").removeClass("d-none").hide().slideDown();
                } else {
                    $("#search-alias-error").addClass("d-none");
                    $("#search-alias-success").removeClass("d-none").hide().slideDown();
                }

                setTimeout(() => {
                    $("#search-alias-error").addClass("d-none");
                    $("#search-alias-success").addClass("d-none");
                }, 5000);
            }
        });
    }
});

listenClick("#search-alias-btn-theme4", function () {
    let vcardAlias = $("#search-alias-input-theme4").val().trim();
    if (vcardAlias.length > 0) {
        $.ajax({
            url: route("vcards.check-url-alias-available", vcardAlias),
            type: "GET",
            success: function (result) {
                let data = result.data;

                $("#search-alias-success-theme4, #search-alias-error-theme4").hide();

                if (!data.isUnique && data.usedInVcard) {
                    $("#search-alias-error-theme4").slideDown();
                } else {
                    $("#search-alias-success-theme4").slideDown();
                }

                setTimeout(() => {
                    $("#search-alias-error-theme4, #search-alias-success-theme4").slideUp();
                }, 6000);
            }
        });
    }
});


$(document).ready(function () {
    $('#search-alias-btn').on('click', function (e) {
        const loader = $('#loader-icon');
        const text = $('#check-text');
        const errorMsg = $('#search-alias-error');
        const successMsg = $('#search-alias-success');
        const inputValue = $('#search-alias-input').val().trim();

        const isErrorVisible = !errorMsg.hasClass('d-none');
        const isSuccessVisible = !successMsg.hasClass('d-none');

        if (inputValue === '') {
            return;
        }

        if (!isErrorVisible && !isSuccessVisible) {
            loader.removeClass('hidden');
            text.addClass('hidden');

            setTimeout(() => {
                loader.addClass('hidden');
                text.removeClass('hidden');
            }, 1000);
        }
    });
});
