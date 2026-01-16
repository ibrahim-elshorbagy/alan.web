// Add NFC
listenClick("#superadminguideNfc", function () {
    $("#superadminguideNfcModal").modal("show");
});

listenClick("#adminguideNfc", function () {
    $("#adminguideNfcModal").modal("show");
});

listenClick("#newNfc", function () {
    $("#addNfcModal").modal("show");
    resetModalForm("#addNfcForm");
    toggleCoordinateFields("#applyCoordinates", "#coordinatesFields");
    toggleDimensionFields("#printFormat", "#dimensionFields");
});

listenHiddenBsModal("#addNfcModal", function () {
    resetModalForm("#addNfcForm");
});

// Toggle coordinate fields when checkbox is clicked
listen("change", "#applyCoordinates", function () {
    toggleCoordinateFields("#applyCoordinates", "#coordinatesFields");
});

listen("change", "#editApplyCoordinates", function () {
    toggleCoordinateFields("#editApplyCoordinates", "#editCoordinatesFields");
});

// Toggle dimension fields when print format is changed
listen("change", "#printFormat", function () {
    toggleDimensionFields("#printFormat", "#dimensionFields");
});

listen("change", "#editPrintFormat", function () {
    toggleDimensionFields("#editPrintFormat", "#editDimensionFields");
});

function toggleCoordinateFields(checkboxId, fieldsId) {
    if ($(checkboxId).is(":checked")) {
        $(fieldsId).show();
    } else {
        $(fieldsId).hide();
    }
}

function toggleDimensionFields(selectId, fieldsId) {
    if ($(selectId).val() === "a5") {
        $(fieldsId).hide();
    } else {
        $(fieldsId).show();
    }
}

listenSubmit("#addNfcForm", function (e) {
    e.preventDefault();
    $.ajax({
        url: route("nfc.store"),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#addNfcModal").modal("hide");
                Livewire.dispatch("refresh");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

listenHiddenBsModal("#addNfcModal", function () {
    $("#addNfcForm")[0].reset();
    let defaultGalleryUrl = $("#defaultNfcImgUrl").val();
    $("#nfcPreview").css("background-image", "url(" + defaultGalleryUrl + ")");
});

// Delete NFC Type

listenClick(".nfc-delete-btn", function (event) {
    let recordId = $(event.currentTarget).data("id");
    deleteItem(route("nfc.delete", recordId), Lang.get("js.nfc_card"));
});

// Edit NFC Type

listenClick(".nfc-view-btn", function (event) {
    let nfcId = $(event.currentTarget).data("id");

    nfcRenderDataShow(nfcId);
});

function nfcRenderDataShow(id) {
    $.ajax({
        url: route("nfc.edit", { id: id }),
        type: "GET",
        success: function (result) {
            if (result.success) {
                $("#nfcId").val(result.data.id);
                $("#editNfcTitle").val(result.data.name);
                $("#editNfcDescription").val(result.data.description);
                $("#editNfcPrice").val(result.data.price);

                // Set coordinate fields
                $("#editApplyCoordinates").prop("checked", result.data.apply_coordinates == 1);
                $("#editQrXPosition").val(result.data.qr_x_position);
                $("#editQrYPosition").val(result.data.qr_y_position);
                $("#editQrSize").val(result.data.qr_size);
                $("#editQrPositionSide").val(result.data.qr_position_side || 'front');

                // Set image dimensions
                $("#editImageWidth").val(result.data.image_width);
                $("#editImageHeight").val(result.data.image_height);

                // Set print settings
                $("#editPrintFormat").val(result.data.print_format || 'fixed');
                $("#editTextFontSize").val(result.data.text_font_size || 14);
                $("#editPrintFrontImage").prop("checked", result.data.print_front_image == 1);
                $("#editPrintBackImage").prop("checked", result.data.print_back_image == 1);
                $("#editPrintOnlyQr").prop("checked", result.data.print_only_qr == 1);

                // Toggle coordinate fields visibility
                toggleCoordinateFields("#editApplyCoordinates", "#editCoordinatesFields");

                // Toggle dimension fields visibility
                toggleDimensionFields("#editPrintFormat", "#editDimensionFields");

                $("#editNfcPreview").css(
                    "background-image",
                    'url("' + result.data.nfc_image + '")'
                );
                $("#editNfcBackPreview").css(
                    "background-image",
                    'url("' + result.data.nfc_back_image + '")'
                );
                $("<img>").attr("src", result.data.nfc_image).on("error", function () {
                    $("#editNfcPreview").css(
                        "background-image",
                        'url("' + defaultNfcCard + '")'
                    );
                });

                $("<img>").attr("src", result.data.nfc_back_image).on("error", function () {
                    $("#editNfcBackPreview").css(
                        "background-image",
                        'url("' + defaultNfcCard + '")'
                    );
                });
                $("#editNfcModal").modal("show");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
}

listenSubmit("#editNfcForm", function (event) {
    event.preventDefault();
    let nfcId = $("#nfcId").val();
    $.ajax({
        url: route("nfc.update", nfcId),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#editNfcModal").modal("hide");
                Livewire.dispatch("refresh");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

listenSubmit("#addNfcTaxForm", function (e) {
    e.preventDefault();
    $.ajax({
        url: route("nfc.tax"),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#addNfcTaxModal").modal("hide");
                Livewire.dispatch("refresh");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

listenClick("#newNfcTax", function () {
    $.ajax({
        url: route("nfc.tax.get"),
        type: "GET",
        success: function (response) {
            $('#nfcCardTax').val(response.tax);
            $('#nfcTaxStatus').prop('checked', response.status ?? false);

            $('#addNfcTaxModal').modal("show");
        },
        error: function () {
            displayErrorMessage(result.responseJSON.message);
        }
    });
});
