// document.addEventListener("turbo:load", loadSettingData);
document.addEventListener("DOMContentLoaded", loadSettingData);

let form;
let phone;
let prefixCode;

function loadSettingData() {
    $(".customDomainStatus").select2();
    TermCondition();
    ManualPaymentGuide();
    loadColorPicker();
    if (!$("#createSetting").length) {
        return;
    }
    form = document.getElementById("createSetting");

    form.addEventListener("reset", reset);

    phone = document.getElementById("phoneNumber").value;
    prefixCode = document.getElementById("prefix_code").value;

    let input = document.querySelector("#defaultCountryData");
    let intl = window.intlTelInput(input, {
        initialCountry: defaultCountryCodeValue,
        separateDialCode: true,
        geoIpLookup: function (success, failure) {
            $.get("https://ipinfo.io", function () {}, "jsonp").always(
                function (resp) {
                    var countryCode = resp && resp.country ? resp.country : "";
                    success(countryCode);
                }
            );
        },
        utilsScript: utilsScript,
    });
    let getCode =
        intl.selectedCountryData["name"] +
        "+" +
        intl.selectedCountryData["dialCode"];
    $("#defaultCountryData").val(getCode);
}

listenKeyup("#defaultCountryData", function () {
    let str2 = $(this).val().slice(0, 2) + "";
    $("#defaultCountryCode").val(str2);
    return $(this).val(str2);
});

listenClick(".iti__standard,.iti__preferred", function () {
    let defaultCountryCodeInput = $(this)
        .parents("div.iti.iti--allow-dropdown")
        .next("#defaultCountryCode");
    if (defaultCountryCodeInput.length) {
        $("#defaultCountryData").val($(this).text());
        $("#defaultCountryCode").val($(this).attr("data-country-code"));
    }
});

listenChange("#appLogo", function () {
    displayPhoto(this, "#appLogoPreview");
});

listenClick(".cancel-app-logo", function () {
    $("#appLogoPreview").attr("src", defaultAppLogoUrl);
});

listenChange("#favicon", function () {
    displayPhoto(this, "#faviconPreview", true);
});

listenClick(".cancel-favicon", function () {
    $("#faviconPreview").attr("src", defaultFaviconUrl);
});

function reset() {
    document.getElementById("phoneNumber").setAttribute("value", phone);
    document
        .getElementById("prefix_code")
        .setAttribute("value", "+" + prefixCode);
}

function isEmail(email) {
    let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

listenSubmit("#createSetting", function () {
    if ($.trim($("#settingAppName").val()) == "") {
        displayErrorMessage(Lang.get("js.app_name_required"));
        return false;
    }

    if (!isEmail($("#settingEmail").val())) {
        displayErrorMessage(Lang.get("js.enter_valid_email"));
        return false;
    }

    if ($.trim($("#phoneNumber").val()) == "") {
        displayErrorMessage(Lang.get("js.phone_number_required"));
        return false;
    }

    if ($.trim($("#settingPlanExpireNotification").val()) == "") {
        displayErrorMessage(Lang.get("js.plan_expire_notification"));
        return false;
    }

    if ($.trim($("#settingAddress").val()) == "") {
        displayErrorMessage(Lang.get("js.address_field"));
        return false;
    }

    if ($("#paypal_payment").prop("checked") && $("")) {
    }

    const raw = $("#blockEmailDomain").val().trim();

    if (raw !== "") {
        const cleanedRaw = raw.replace(/[\n\r]+/g, ',').replace(/\s+/g, ' ');

        const potentialDomains = cleanedRaw.split(/[\s,]+/).filter(d => d.trim() !== '');

        if (potentialDomains.length > 1 && !cleanedRaw.includes(',')) {
            displayErrorMessage(Lang.get("js.entering_multiple_domain_must_be_comma_separated"));
            return false;
        }

        const domains = cleanedRaw.split(',').map(d => d.trim()).filter(d => d !== "");

        const regex = /^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        let seen = new Set();
        let invalid = [];
        let duplicates = [];

        for (let domain of domains) {
            if (!regex.test(domain)) {
                invalid.push(domain);
                continue;
            }

            const lower = domain.toLowerCase();
            if (seen.has(lower)) {
                duplicates.push(domain);
            } else {
                seen.add(lower);
            }
        }

        if (invalid.length > 0) {
            displayErrorMessage(Lang.get("js.invalid_email_domain"));
            return false;
        }

        if (duplicates.length > 0) {
            displayErrorMessage(Lang.get("js.duplicate_email_domain"));
            return false;
        }

        $("#blockEmailDomain").val([...seen].join(','));
    }

    if ($("#defaultCountryCode").val() != defaultCountryCodeValue) {
        $("#createSetting")[0].submit();
    }
});

listenChange("#mobileValidation", function (e) {
    e.preventDefault();
    $.ajax({
        url: route("update.mobile.validation"),
        method: "POST",
        success: function (result) {
            window.location.reload();
        },
    });
});

listen("click", ".open-ai-enable", function () {
    $(".open-ai-div").toggleClass("d-none");
});

listen("click", ".stripe-enable", function () {
    $(".stripe-div").toggleClass("d-none");
});

listen("click", ".flutterwave-enable", function () {
    $(".flutterwave-div").toggleClass("d-none");
});

listen("click", ".paystack-enable", function () {
    $(".paystack-div").toggleClass("d-none");
});

// listen('click', '.notifation-enable', function () {
//     $('.notifation-div').toggleClass('d-none')
// })

listen("click", ".phonepe-enable", function () {
    $(".phonepe-div").toggleClass("d-none");
});

listen("click", ".paypal-enable", function () {
    $(".paypal-div").toggleClass("d-none");
});

listen("click", ".payfast-enable", function () {
    $(".payfast-div").toggleClass("d-none");
});

// listen("click", ".sslcommerz-enable", function () {
//     $(".sslcommerz-div").toggleClass("d-none");
// });

listen("click", ".iyzico-enable", function () {
    $(".iyzico-div").toggleClass("d-none");
});

listen("click", "#paypal_payment", function () {
    console.log("true");
    $(".paypal-cred").toggleClass("d-none");
});

listen("click", "#stripe_payment", function () {
    $(".stripe-cred").toggleClass("d-none");
});

listen("click", "#phonepe_payment", function () {
    $(".phonepe-cred").toggleClass("d-none");
});

listen("click", "#paystack_payment", function () {
    $(".paystack-cred").toggleClass("d-none");
});

listen("click", "#manually_payment", function () {
    $(".manually-cred").toggleClass("d-none");
});

listen("click", "#mercado_pago_payment", function () {
    $(".mercado-pago").toggleClass("d-none");
});

listen("click", "#iyzico_payment", function () {
    const isChecked = $(this).is(':checked');
    const credDiv = $(".iyzico-cred");

    if (isChecked) {
        credDiv.removeClass("d-none");
        $(".iyzico-key, .iyzico-secret").attr('required', true);
        $("#iyzico_mode").attr('required', true);
    } else {
        credDiv.addClass("d-none");
        $(".iyzico-key, .iyzico-secret").removeAttr('required');
        $("#iyzico_mode").removeAttr('required');
    }
});

$(document).on("click", "#userManualPaymentSetting", function () {
    $(".user-manually-cred").toggleClass("d-none", !this.checked);
});

listen("click", "#razorpay_payment", function () {
    $(".razorpay-cred").toggleClass("d-none");
});
listen("click", "#rozorpayEnable", function () {
    $(".razorpay-cred").toggleClass("d-none");
});

listen("click", "#flutterwave_payment", function () {
    $(".flutterwave-cred").toggleClass("d-none");
});

listen("click", "#payfast_payment", function () {
    $(".payfast-cred").toggleClass("d-none");
});

// listen("click", "#sslcommerz_payment", function () {
//     $(".sslcommerz-cred").toggleClass("d-none");
// });

listen("click", ".pwa-enable", function () {
    $(".pwa-div").toggleClass("d-none");
});

listen("submit", "#UserCredentialsSettings", function () {

    if ($("#openAiEnable").prop("checked")) {
        if ($("#openAikey").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.open_ai_key"));
            return false;
        } else if ($("#openAiModel").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.open_ai_model"));
            return false;
        }
    }


    if ($("#stripeEnable").prop("checked")) {
        if ($("#stripeKey").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.stripe_secret"));
            return false;
        } else if ($("#stripeSecret").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.stripe_secret"));
            return false;
        }
    }

    if ($("#paystackEnable").prop("checked")) {
        if ($("#paystackKey").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.paystack_key"));
            return false;
        } else if ($("#paystackSecret").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.paystack_secret"));
            return false;
        }
    }

    if ($("#flutterwaveEnable").prop("checked")) {
        if ($("#flutterwaveKey").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.flutterwave_key"));
            return false;
        } else if ($("#flutterwaveSecret").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.flutterwave_secret"));
            return false;
        }
    }

    // if ($('#notifationEnable').prop('checked')) {
    //     if ($('#onesignalAppId').val().trim().length === 0) {
    //         displayErrorMessage(Lang.get('js.onesignal_app_id'))
    //         return false
    //     } else if ($('#onesignalRestApiKey').val().trim().length === 0) {
    //         displayErrorMessage(Lang.get('js.onesignal_rest_api_key'))
    //         return false
    //     }
    // }

    if ($("#paypalEnable").prop("checked")) {
        if ($("#paypalKey").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.paypal_key"));
            return false;
        } else if ($("#paypalSecret").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.paypal_secret"));
            return false;
        } else if ($("#paypalMode").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.paypal_mode"));
            return false;
        }
    }

    if ($("#rozorpayEnable").prop("checked")) {
        if ($("#razorpayKey").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.razorpay_key"));
            return false;
        } else if ($("#razorpaySecret").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.razorpay_secret"));
            return false;
        }
    }

    if ($("#payfastEnable").prop("checked")) {
        if ($("#payfastKey").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.payfast_key"));
            return false;
        } else if ($("#payfastSecret").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.payfast_secret"));
            return false;
        }
    }

    // if ($("#sslcommerzEnable").prop("checked")) {
    //     if ($("#sslcommerzStoreId").val().trim().length === 0) {
    //         displayErrorMessage(Lang.get("js.sslcommerz_StoreId"));
    //         return false;
    //     } else if ($("#sslcommerzPassword").val().trim().length === 0) {
    //         displayErrorMessage(Lang.get("js.sslcommerz_Password"));
    //         return false;
    //     }
    // }

    if ($("#iyzico_payment").prop("checked")) {
        if ($("#iyzico_key").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.iyzico_key"));
            return false;
        } else if ($("#iyzico_secret").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.iyzico_secret"));
            return false;
        }
    }

    // if ($("#mercadoPagoEnable").prop("checked")) {
    //     if ($("#mpPublicKey").val().trim().length === 0) {
    //         displayErrorMessage(Lang.get("js.mp_public_key"));
    //         return false;
    //     } else if ($("#mpAccessToken").val().trim().length === 0) {
    //         displayErrorMessage(Lang.get("js.mp_access_token"));
    //         return false;
    //     }
    // }

    if ($("#phonepeEnable").prop("checked")) {
        if ($("#phonepeMerchantId").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.phonepe_merchant_id_required"));
            return false;
        } else if ($("#phonepeMerchantUserId").val().trim().length === 0) {
            displayErrorMessage(
                Lang.get("js.phonepe_merchant_user_id_required")
            );
            return false;
        } else if ($("#phonepeEnv").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.phonepe_env_required"));
            return false;
        } else if ($("#phonepeSaltKey").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.phonepe_salt_key_required"));
            return false;
        } else if ($("#phonepeSaltIndex").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.phonepe_salt_index_required"));
            return false;
        } else if (
            $("#phonepeMerchantTransactionId").val().trim().length === 0
        ) {
            displayErrorMessage(
                Lang.get("js.phonepe_merchant_transaction_id_required")
            );
            return false;
        }
    }

    processingBtn(
        "#UserCredentialsSettings",
        "#userCredentialSettingBtn",
        "loading"
    );
    $("#userCredentialSettingBtn").prop("disabled", true);
});
function TermCondition() {
    if (
        !$("#termConditionId").length ||
        !$("#privacyPolicyId").length ||
        !$("#refundCancellationId").length ||
        !$("#shippingDeliveryId").length ||
        !$("#imprintId").length
    ) {
        return;
    }
    quill1 = new Quill("#termConditionId", {
        modules: {
            toolbar: [
                [
                    {
                        header: [1, 2, false],
                    },
                ],
                ["bold", "italic", "underline"],
                ["image", "code-block"],
            ],
        },
        placeholder: Lang.get("js.term_condition").replace(/&amp;/g, "&"),
        theme: "snow", // or 'bubble'
    });

    quill1.on("text-change", function (delta, oldDelta, source) {
        if (quill1.getText().trim().length === 0) {
            quill1.setContents([{ insert: "" }]);
        }
    });
    quill2 = new Quill("#privacyPolicyId", {
        modules: {
            toolbar: [
                [
                    {
                        header: [1, 2, false],
                    },
                ],
                ["bold", "italic", "underline"],
                ["image", "code-block"],
            ],
        },
        placeholder: Lang.get("js.privacy_policy"),
        theme: "snow", // or 'bubble'
    });

    quill2.on("text-change", function (delta, oldDelta, source) {
        if (quill2.getText().trim().length === 0) {
            quill2.setContents([{ insert: "" }]);
        }
    });

    quill3 = new Quill("#refundCancellationId", {
        modules: {
            toolbar: [
                [
                    {
                        header: [1, 2, false],
                    },
                ],
                ["bold", "italic", "underline"],
                ["image", "code-block"],
            ],
        },
        placeholder: Lang.get("Refund & Cancellation"),
        theme: "snow", // or 'bubble'
    });

    quill3.on("text-change", function (delta, oldDelta, source) {
        if (quill3.getText().trim().length === 0) {
            quill3.setContents([{ insert: "" }]);
        }
    });

    quill4 = new Quill("#shippingDeliveryId", {
        modules: {
            toolbar: [
                [
                    {
                        header: [1, 2, false],
                    },
                ],
                ["bold", "italic", "underline"],
                ["image", "code-block"],
            ],
        },
        placeholder: Lang.get("Shipping & Delivery"),
        theme: "snow", // or 'bubble'
    });

    quill4.on("text-change", function (delta, oldDelta, source) {
        if (quill4.getText().trim().length === 0) {
            quill4.setContents([{ insert: "" }]);
        }
    });

    quill5 = new Quill("#imprintId", {
        modules: {
            toolbar: [
                [
                    {
                        header: [1, 2, false],
                    },
                ],
                ["bold", "italic", "underline"],
                ["image", "code-block"],
            ],
        },
        placeholder: Lang.get("Imprint"),
        theme: "snow", // or 'bubble'
    });

    quill5.on("text-change", function (delta, oldDelta, source) {
        if (quill5.getText().trim().length === 0) {
            quill5.setContents([{ insert: "" }]);
        }
    });


    let element = document.createElement("textarea");
    element.innerHTML = $("#termConditionData").val();
    quill1.root.innerHTML = element.value;
    element.innerHTML = $("#privacyPolicyData").val();
    quill2.root.innerHTML = element.value;
    element.innerHTML = $("#refundCancellationsData").val();
    quill3.root.innerHTML = element.value;
    element.innerHTML = $("#shippingDeliveriesData").val();
    quill4.root.innerHTML = element.value;
    element.innerHTML = $("#imprintsData").val();
    quill5.root.innerHTML = element.value;

    listenSubmit("#TermsConditions", function () {
        let elements = document.createElement("textarea");
        let editor_content_1 = quill1.root.innerHTML;

        elements.innerHTML = editor_content_1;
        let editor_content_2 = quill2.root.innerHTML;
        let editor_content_3 = quill3.root.innerHTML;
        let editor_content_4 = quill4.root.innerHTML;
        let editor_content_5 = quill5.root.innerHTML;

        if (quill1.getText().trim().length === 0) {
            editor_content_1 = "";
        }

        if (quill2.getText().trim().length === 0) {
            editor_content_2 = "";
        }

        if (quill3.getText().trim().length === 0) {
            editor_content_3 = "";
        }

        if (quill4.getText().trim().length === 0) {
            editor_content_4 = "";
        }

        if (quill5.getText().trim().length === 0) {
            editor_content_5 = "";
        }

        $("#termData").val(JSON.stringify(editor_content_1));
        $("#privacyData").val(JSON.stringify(editor_content_2));
        $("#refundCancellationData").val(JSON.stringify(editor_content_3));
        $("#shippingDeliveryData").val(JSON.stringify(editor_content_4));
        $("#imprintData").val(JSON.stringify(editor_content_5));

    });
}

function ManualPaymentGuide() {
    if (!$("#manualPaymentGuideId").length) {
        return;
    }
    quill = new Quill("#manualPaymentGuideId", {
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, 4, 5, 6, false] }],
                ["bold", "italic", "underline", "strike"],
                ["blockquote", "code-block"],
                [{ list: "ordered" }, { list: "bullet" }],
                [{ script: "sub" }, { script: "super" }],
                [{ indent: "-1" }, { indent: "+1" }],
                [{ direction: "rtl" }],
                [{ color: [] }, { background: [] }],
                [{ font: [] }],
                [{ align: [] }],
                ["image", "code-block"],
            ],
        },
        placeholder: Lang.get("js.manual_payment_guide"),
        theme: "snow", // or 'bubble'
    });

    quill.on("text-change", function (delta, oldDelta, source) {
        if (quill.getText().trim().length === 0) {
            quill.setContents([{ insert: "" }]);
        }
    });

    let element = document.createElement("textarea");
    element.innerHTML = $("#manualPaymentGuideData").val();
    quill.root.innerHTML = element.value;

    listenSubmit("#SuperAdminCredentialsSettings", function () {
        let elements = document.createElement("textarea");
        let editor_content = quill.root.innerHTML;

        elements.innerHTML = editor_content;
        if (quill.getText().trim().length === 0) {
            editor_content = "";
        }

        $("#guideData").val(editor_content);
    });

    listenSubmit("#UserCredentialsSettings", function () {
        let elements = document.createElement("textarea");
        let editor_content = quill.root.innerHTML;

        elements.innerHTML = editor_content;
        if (quill.getText().trim().length === 0) {
            editor_content = "";
        }

        $("#guideData").val(editor_content);
    });
}

listenChange("#appLogo", function () {
    let fileExtension = ["jpeg", "jpg", "png", "gif", "bmp"];
    if (
        $.inArray(
            $(this).val().split(".").pop().toLowerCase(),
            fileExtension
        ) === -1
    ) {
        displayErrorMessage(
            "The app logo must be a file of type: jpg, jpeg, png, gif, bmp."
        );
        $(this).val("");
        return false;
    }
});

listenChange("#favicon", function () {
    let fileExtension = ["jpeg", "jpg", "png", "gif", "bmp"];
    if (
        $.inArray(
            $(this).val().split(".").pop().toLowerCase(),
            fileExtension
        ) === -1
    ) {
        displayErrorMessage(
            "The favicon must be a file of type: jpg, jpeg, png, gif, bmp."
        );
        $(this).val("");
        return false;
    }
});

listenSubmit("#createSetting", function () {
    let affiliationAmount = $("#affiliationAmount").val();
    let affiliationAmountType = $("#affiliationAmountType").val();
    let affiliationAmountError = $("#affiliationAmountError");

    affiliationAmountError.text("");

    if (affiliationAmountType === "2" && parseFloat(affiliationAmount) > 100) {
        let errorMessage = Lang.get("js.affiliation_amount_error");
        affiliationAmountError.text(errorMessage);
        return false;
    }
});

listenClick(".copy-delete-account-url", function () {
    let $temp = $("<input>");
    $("body").append($temp);
    $temp.val($("#deleteAccountURL").text()).select();
    document.execCommand("copy");
    $temp.remove();
    displaySuccessMessage(Lang.get("js.copied_successfully"));
});

listenChange(".customDomainStatus", function () {
    let isApproved = $(this).val();
    let id = $(this).data("id");
    if (isApproved == 2) {
        $("#customDomainRejectModal").modal("show");
        $("#customDomainId").val(id);
        $(this).val(0);
        Livewire.dispatch("refresh");
        return;
    }
    $("#customDomainStatus-" + id).addClass("d-none");
    $("#customDomainSpinner-" + id).removeClass("d-none");
    $.ajax({
        url: route("custom.domain.update", { id: id }),
        method: "POST",
        data: {
            isApproved: isApproved,
        },
        success: function (res) {
            if (res.success) {
                displaySuccessMessage(res.message);
                Livewire.dispatch("refresh");
            }
        },
        error: function (xhr) {
            $("#customDomainStatus-" + id).removeClass("d-none");
            $("#customDomainSpinner-" + id).addClass("d-none");
            displayErrorMessage(xhr.responseJSON.message);
            ``;
        },
    });
});

listenSubmit("#customDomainRejectForm", function (e) {
    e.preventDefault();
    let id = $("#customDomainId").val();
    let isApproved = 2;
    let rejectionNote = $("#rejectionNote").val();
    if (!rejectionNote) {
        displayErrorMessage("Please enter rejection note");
        return false;
    }
    $("#customDomainRejectBtn").attr("disabled", true);
    $.ajax({
        url: route("custom.domain.update", { id: id }),
        method: "POST",
        data: $(this).serialize() + "&isApproved=" + isApproved,
        success: function (res) {
            if (res.success) {
                displaySuccessMessage(res.message);
                $("#customDomainRejectModal").modal("hide");
                Livewire.dispatch("refresh");
            }
        },
        error: function (xhr) {
            $("#customDomainRejectBtn").attr("disabled", false);
            displayErrorMessage(xhr.responseJSON.message);
        },
    });
});

listenClick(".custom-domain-is-active", function () {
    let id = $(this).data("id");
    let updateUrl = route("custom.domain.status.update", id);
    $.ajax({
        type: "get",
        url: updateUrl,
        success: function (response) {
            Livewire.dispatch("refresh");
            displaySuccessMessage(response.message);
        },
    });
});

listenChange("#useCustomDomainUrl", function () {
    let useCustomDomainUrl = $(this).is(":checked");
    let customDomainId = $("#customDomainId").val();
    $.ajax({
        type: "POST",
        url: route("change.domain.status", customDomainId),
        data: { useCustomDomainUrl: useCustomDomainUrl },
        success: function (response) {
            displaySuccessMessage(response.message);
        },
    });
});


function loadColorPicker() {
    const primaryPickr = Pickr.create({
        el: ".primary-picker",
        theme: "nano",

        swatches: [
            "rgba(244, 67, 54, 1)",
            "rgba(233, 30, 99, 0.95)",
            "rgba(156, 39, 176, 0.9)",
            "rgba(103, 58, 183, 0.85)",
            "rgba(63, 81, 181, 0.8)",
            "rgba(33, 150, 243, 0.75)",
            "rgba(3, 169, 244, 0.7)",
            "rgba(0, 188, 212, 0.7)",
            "rgba(0, 150, 136, 0.75)",
            "rgba(76, 175, 80, 0.8)",
            "rgba(139, 195, 74, 0.85)",
            "rgba(205, 220, 57, 0.9)",
            "rgba(255, 235, 59, 0.95)",
            "rgba(255, 193, 7, 1)",
        ],

        components: {

            preview: true,
            opacity: true,
            hue: true,

            interaction: {
                input: true,
                clear: true,
                save: true,
            },
        },
    });

    primaryPickr.on("change", (color, source, instance) => {
        const rgbaColor = color.toHEXA().toString();
        $("#primaryColor").val(rgbaColor);
        primaryPickr.setColor(rgbaColor);
    });

    const secondaryPickr = Pickr.create({
        el: ".secondary-picker",
        theme: "nano",

        swatches: [
            "rgba(244, 67, 54, 1)",
            "rgba(233, 30, 99, 0.95)",
            "rgba(156, 39, 176, 0.9)",
            "rgba(103, 58, 183, 0.85)",
            "rgba(63, 81, 181, 0.8)",
            "rgba(33, 150, 243, 0.75)",
            "rgba(3, 169, 244, 0.7)",
            "rgba(0, 188, 212, 0.7)",
            "rgba(0, 150, 136, 0.75)",
            "rgba(76, 175, 80, 0.8)",
            "rgba(139, 195, 74, 0.85)",
            "rgba(205, 220, 57, 0.9)",
            "rgba(255, 235, 59, 0.95)",
            "rgba(255, 193, 7, 1)",
        ],

        components: {

            preview: true,
            opacity: true,
            hue: true,


            interaction: {
                input: true,
                clear: true,
                save: true,
            },
        },
    });

    secondaryPickr.on("change", (color, source, instance) => {
        const rgbaColor = color.toHEXA().toString();
        $("#secondaryColor").val(rgbaColor);
        secondaryPickr.setColor(rgbaColor);
    });

    setTimeout(function() {
        primaryPickr.setColor($("#primaryColor").val());
        secondaryPickr.setColor($("#secondaryColor").val());
    }, 200);

}

document.addEventListener("DOMContentLoaded", function () {
    const quillEditors = {};

    document.querySelectorAll('[id^="noteModal"]').forEach((modal) => {
        modal.addEventListener('shown.bs.modal', function () {
            const id = this.id.replace('noteModal', '');
            const editorEl = document.getElementById('quillEditor' + id);

            if (!quillEditors[id]) {
                const quill = new Quill(editorEl, {
                    theme: 'snow',
                    placeholder: 'Write your note...',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, false] }],
                            ['bold', 'italic', 'underline'],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                            ['link', 'clean']
                        ]
                    }
                });

                // Set initial content from hidden input
                const initialContent = document.getElementById('noteContent' + id).value;
                quill.root.innerHTML = initialContent;

                quillEditors[id] = quill;
            }
        });

        modal.addEventListener('hidden.bs.modal', function () {
            const id = this.id.replace('noteModal', '');
            const quill = quillEditors[id];
            if (quill) quill.blur();
        });
    });

    // Save note via AJAX
    $(document).on('click', '.save-note-btn', function () {
        const id = $(this).data('id');
        const url = $(this).data('url'); // ✅ already full URL
        const quill = quillEditors[id];
        if (!quill) return;

        const noteContent = quill.root.innerHTML;


        $.ajax({
            url: url,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                note: noteContent
            },
            success: function () {
                toastr.success(Lang.get("js.successful"));
                $('#noteModal' + id).modal('hide');
            },
            error: function () {
                toastr.error(Lang.get("js.error"));
            }
        });
    });
});
