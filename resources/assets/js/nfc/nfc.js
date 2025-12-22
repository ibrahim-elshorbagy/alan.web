// document.addEventListener("turbo:load", loadNFCData);
document.addEventListener("DOMContentLoaded", loadNFCData);
Livewire.hook("element.init", () => {
    loadNfcOrderfilter();
});

document.addEventListener("DOMContentLoaded", function () {
    var nfcOrderFormModal = document.getElementById('nfcOrderFormModal');
    if (!nfcOrderFormModal) {
        return false;
    }
    nfcOrderFormModal.addEventListener('show.bs.modal', function () {
        resetModalForm("#orderNfcForm");
        $("#vcard-id").select2({
            placeholder: Lang.get("js.select_vcard"),
        });
        $("#paymentType").select2({
            placeholder: Lang.get("js.select_payment_type"),
        });

        $("#appLogoPreview").css(
            "background-image",
            "url(" + defaltNfcLogo + ")"
        );
    });

    var nfcCardFormModal = document.getElementById('nfcCardDetailModal');
    if (!nfcCardFormModal) {
        return false;
    }
    nfcCardFormModal.addEventListener('show.bs.modal', function () {
        resetModalForm("#orderNfcForm");
        $("#quantity").val(1);
        sessionStorage.setItem('quantity', 1);
    });
});

function loadNFCData() {
    // $("#vcard-id").select2({
    //     placeholder: "Select Vcard",
    // });
    $("#vcard-id").select2({
        dropdownParent: $("#nfcOrderFormModal"),
    });

    $(".paymentType").select2({
        dropdownParent: $("#nfcOrderFormModal"),
    });

    $("#NFC-card-type").select2({
        placeholder: "Select Card Type",
    });
}

listenChange("#vcard-id", function (e) {
    e.preventDefault();
    let vcardId = $("#vcard-id").val();
    $.ajax({
        url: route("vcard-data"),
        type: "GET",
        data: { vcardId: vcardId },
        success: function (result) {
            if (result.success) {
                if (result.data.first_name == null) {
                    var name = '';
                } else {
                    var name = result.data.first_name + " " + result.data.last_name;
                }
                $("#e-card-name").val(name);
                $("#e-card-email").val(result.data.email);
                $("#e-card-occupation").val(result.data.occupation);
                $("#e-card-location").val(result.data.location);
                $("#phoneNumber").val(result.data.phone);
                $("#regionCode").val(result.data.region_code);
                $("#companyName").val(result.data.company);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

// listenChange("#paymentType", function () {
//     let paymentType = $("#paymentType").val();
//     let form = $(".order-nfc-card-form");
//     let submitButton = form.find('button[type="submit"]');
//     if (paymentType == 4) {
//         form.removeAttr("id");
//         form.attr("action", route("nfc.order.store"));
//     } else {
//         form.removeAttr("action");
//         form.attr("id", "orderNfcForm");
//     }

//     form.on("submit", function () {
//         submitButton.prop("disabled", true);
//     });
// });

listenClick(".nfc-img-radio", function () {
    // $(".nfc-price").addClass("d-none");
    $(".nfc-img-radio").removeClass("img-border");
    $(this).addClass("img-border");
    $("#card-id").val($(this).attr("data-id"));
    // $(this).parent().find(".nfc-price").removeClass("d-none");
});

listenClick(".nfccard", function () {
    $(".nfc-img-radio").removeClass("img-border");
    const nfcImgRadio = $(this).find(".nfc-img-radio");
    nfcImgRadio.addClass("img-border");
    const cardId = nfcImgRadio.attr("data-id");
    $("#card-id").val(cardId);
});

listenSubmit("#orderNfcForm", function (e) {
    e.preventDefault();
    $("#order-btn").prop("disabled", true);
    var storedQuantity = sessionStorage.getItem('quantity');
    $("#quantity").val(storedQuantity);
    $.ajax({
        url: route("nfc.order.store"),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                if (!isEmpty(result.data)) {

                    if (result.data.payment_method == 1) {
                        let sessionId = result.data[0].sessionId;
                        stripe.redirectToCheckout({
                            sessionId: sessionId,
                        });
                    }

                    if (result.data.payment_method == 3) {
                        let { id, amount, name, email, contact } =
                            result.data[0];

                        options.amount = amount;
                        options.order_id = id;
                        options.prefill.name = name;
                        options.prefill.email = email;
                        options.prefill.contact = contact;
                        let razorPay = new Razorpay(options);
                        razorPay.open();
                        razorPay.on("nfc.payment.failed");
                        return false;
                    }

                    if (result.data.payment_method == 2) {
                        if (result.data[0].original.link) {
                            window.location.href = result.data[0].original.link;
                        }

                        if (result.data[0].original.statusCode === 201) {
                            let redirectTo = "";

                            $.each(
                                result.data[0].original.result.links,
                                function (key, val) {
                                    if (val.rel == "approve") {
                                        redirectTo = val.href;
                                    }
                                }
                            );
                            location.href = redirectTo;
                        }
                    }

                    if (result.data.payment_method == 5) {
                        window.location.href = result.data[0];
                    }

                    if (result.data.payment_method == 7 || result.data.payment_method == 9 || result.data.payment_method == 11) {
                        window.location.href = result.data[0];
                    }

                    if (result.data.payment_method == 6) {
                        if (result.data[0].original.link) {
                            window.location.href = result.data[0].original.link;
                        }

                        if (result.data[0].original.statusCode === 201) {
                            let redirectTo = "";

                            $.each(
                                result.data[0].original.result.links,
                                function (key, val) {
                                    if (val.rel == "approve") {
                                        redirectTo = val.href;
                                    }
                                }
                            );

                            location.href = redirectTo;
                        }
                    }

                    if (result.data.payment_method == 8 && result.data[0].body.id) {
                        nfcMercadoPagoPublicKey.checkout({
                            preference: {
                                id: result.data[0].body.id
                            },
                            autoOpen: true
                        });
                    }
                    if (result.data.payment_method == 4) {
                        location.href = route("user.orders");
                    }
                    // if (result.data.payment_method == 10) {
                    //     window.location.href = result.data[0];
                    // }
                }
                $("#order-btn").prop("disabled", false);
                resetModalForm("#orderNfcForm");
                displaySuccessMessage(result.message);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
            $("#order-btn").prop("disabled", false);
        },
    });
});

listenClick("#paymentStatus", function () {
    let transactionId = $(this).data("id");
    let updateUrl = route("nfc.payment.status", transactionId);
    $.ajax({
        type: "get",
        url: updateUrl,
        success: function (response) {
            displaySuccessMessage(response.message);
            Livewire.dispatch("resetPageTable");
        },
    });
});

listenClick(".order-status", function () {
    let status = $(this).data("status");
    let orderId = $(this).parents("ul").next().val();
    let updateUrl = route("nfc.order.status", orderId);
    $.ajax({
        type: "get",
        url: updateUrl,
        data: { status: status },
        success: function (response) {
            displaySuccessMessage(response.message);
            Livewire.dispatch("resetPageTable");
        },
    });
});

// NFC Card Type Filter
function loadNfcOrderfilter() {
    $("#cardType").select2();
}

listen("change", "#cardType", function () {
    Livewire.dispatch("changeFilter", { type: $(this).val() });
    hideDropdownManually($("#cardTypeFilterBtn"), $("#cardTypeFilter"));
});
listen("change", "#appointmentStatus", function () {
    Livewire.dispatch("changeFilterStatus", { status: $(this).val() });
    hideDropdownManually($("#cardTypeFilterBtn"), $("#cardTypeFilter"));
});

listen("click", "#cardTypeResetFilter", function () {
    $("#cardType").val(0);
    Livewire.dispatch("changeFilter", { type: "" });
    Livewire.dispatch("changeFilterStatus", "");
    hideDropdownManually($("#cardTypeFilterBtn"), $("#cardTypeFilter"));
});

listenClick(".nfccard", function (event) {
    let id = $(event.currentTarget).attr("data-id");
    let NfcDetails = route("nfc-details", id);
    $.ajax({
        url: NfcDetails,
        type: "GET",
        data: {
            id: id,
        },
        success: function (result) {
            var decimalVal = $('#settings').data('value');
            var formatPrice = parseFloat(result.data.price).toFixed(decimalVal == 1 ? 0 : 2);
            $('#name').text(result.data.name)
            $('#description').text(result.data.description)
            $('#nfcProductImg').attr('src', result.data.nfc_image);
            $('#nfcProductBackImg').attr('src', result.data.nfc_back_image);
            $('#price').text(result.message + formatPrice);

            var nfcvalue = result.message + formatPrice;
            const numericValue = parseFloat(nfcvalue.replace(result.message, '')).toFixed(decimalVal == 1 ? 0 : 2);

            $(document).off('click', '.increaseCount').on('click', '.increaseCount', function () {
                var input = this.previousElementSibling;
                var value = parseInt(input.value, 10);
                value = isNaN(value) ? 0 : value;
                value++;
                input.value = value;
                sessionStorage.setItem('quantity', value);
                var formatPrice = parseFloat(input.value).toFixed(decimalVal == 1 ? 0 : 2);
                var finalPrice = numericValue * formatPrice;
                $('#price').text(result.message + finalPrice.toFixed(decimalVal == 1 ? 0 : 2));
            });

            $(document).off('click', '.decreaseCount').on('click', '.decreaseCount', function () {
                var input = this.nextElementSibling;
                var value = parseInt(input.value, 10);
                if (value > 1) {
                    value = isNaN(value) ? 0 : value;
                    value--;
                    input.value = value;
                }
                sessionStorage.setItem('quantity', value);

                var formatPrice = parseFloat(input.value).toFixed(decimalVal == 1 ? 0 : 2);
                var finalPrice = numericValue * formatPrice;
                $('#price').text(result.message + finalPrice.toFixed(decimalVal == 1 ? 0 : 2));
            });
            $('#nfcCardDetailModal').modal('show');
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

listenKeyup(".quantity", function () {
    var value = parseInt($(this).val());
    if (value < 1) {
        $(this).val(1);
    }
});
listen("click", ".nfc-order-delete-btn", function (event) {
    let deleteNFCOrderId = $(event.currentTarget).attr("data-id");
    let url = route("nfc-card-order.delete", deleteNFCOrderId);
    deleteItem(url, Lang.get("js.nfc_order"));
});
