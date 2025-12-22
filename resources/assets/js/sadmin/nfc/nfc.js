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
});

listenHiddenBsModal("#addNfcModal", function () {
    resetModalForm("#addNfcForm");
});

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
