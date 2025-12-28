
Livewire.hook("element.init", () => {
    ProductOrdeerFilter();
});
listenClick("#addProductBtn", function () {
    $("#addProductModal").modal("show");
});

listenHiddenBsModal("#addProductModal", function (e) {
    $("#addProductForm")[0].reset();
    $("#vcardProduct").val(null).trigger("change");
    $("#productPreview").css(
        "background-image",
        "url(" + defaultServiceIconUrl + ")"
    );
    $('.append-picker').addClass('d-none');
    $('.remove-image-picker').addClass('d-none');
    $('.append-remove-image-picker').addClass('d-none');
    $("#productSave").prop("disabled", false);
    $(".cancel-service").hide();
});

listenHiddenBsModal("#showProductModal", function () {
    $("#showName,#showDesc,#showPrice,#showProductUrl").empty();
    $("#productPreview").css(
        "background-image",
        "url(" + defaultServiceIconUrl + ")"
    );
});

listenChange("#productIcon", function () {
    changeImg(
        this,
        "#productIconValidationErrors",
        "#productPreview",
        defaultServiceIconUrl
    );
    $(".cancel-service").show();
});

listenClick(".cancel-service", function () {
    $("#productPreview").css(
        "background-image",
        "url(" + defaultServiceIconUrl + ")"
    );
});

listenSubmit("#addProductForm", function (e) {
    e.preventDefault();
    $("#productSave").prop("disabled", true);
    $.ajax({
        url: route("vcard.products.store"),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#addProductModal").modal("hide");
                Livewire.dispatch("refresh");
                $("#productSave").prop("disabled", true);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
            $("#productSave").prop("disabled", false);
        },
    });
});

listenHiddenBsModal("#editProductModal", function (e) {
    $(".cancel-edit-service").hide();
});

listenClick(".product-delete-btn", function (event) {
    let recordId = $(event.currentTarget).attr("data-id");
    deleteItem(route("vcard.products.destroy", recordId), Lang.get("js.product"));
});

listenClick(".product-edit-btn", function (event) {
    let vcardProductId = $(event.currentTarget).data("id");
    editVcardProductRenderData(vcardProductId);
});
let productIconUrl = "";
function editVcardProductRenderData(id) {
    $.ajax({
        url: route("vcard.products.edit", id),
        type: "GET",
        success: function (result) {
            if (result.success) {
                $("#productId").val(result.data.id);
                $("#editName").val(result.data.name);
                if (result.data.currency_id != null) {
                    $("#editCurrencyId")
                        .val(result.data.currency.id)
                        .trigger("change");
                }
                $("#editPrice").val(result.data.price);
                $("#editDescription").val(result.data.description);
                $("#editProductUrl").val(result.data.product_url);
                const productImagesContainer = $("#editImageContainer");
                productImagesContainer.empty();
                result.data.media.forEach(function (mediaItem, index) {
                    const mediaId = mediaItem.id;
                    const imageUrl = mediaItem.original_url;
                    const uniqueId = `productIcon-${Date.now()}`;
                    let trashButton = `
                        <div class="text-center">
                           <a class="btn-sm remove-image-picker delete-media mt-2 mb-4 text-danger" data-id="${mediaId}">
                               <i class="fa-solid fa-trash"></i>
                           </a>
                        </div>`;
                    const imagePreview = `
                        <div class="image-picker ms-2">
                            <div class="image previewImage ms-4 mt-4" style="background-image: url('${imageUrl}')"></div>
                            <div class="edit-trash">
                             ${trashButton}
                        </div>`;
                    productImagesContainer.append(imagePreview);
                });
                defaultEditImg = `<div class="d-block">
                                    <div class="image-picker">
                                        <div class="image previewImage ms-4 mt-4" id="editProductPreview"
                                            style="background-image: url('${defaultServiceIconUrl}')">
                                        </div>
                                        <span class="picker-edit rounded-circle text-gray-500 fs-small mt-4"
                                            data-bs-toggle="tooltip" data-placement="top"
                                            data-bs-original-title="{{ __('messages.tooltip.image') }}">
                                            <label>
                                                <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                                <input type="file" id="editProductIcon" name="product_icon[]"
                                                    class="image-upload file-validation d-none" accept="image/*" data-preview-id="editVcardProductPreview"
                                                    multiple />
                                            </label>
                                        </span>
                                    </div>
                                </div>`
                productImagesContainer.append(defaultEditImg);

                listen("change", 'input[type="file"]', function (event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            $(event.target).closest('.image-picker').find('.previewImage').css('background-image', `url(${e.target.result})`);
                        };
                        reader.readAsDataURL(file);
                    }

                });
                listenClick(".remove-image-picker", function () {
                    $(this).closest('.image-picker').remove();
                });

                $("#editProductModal").modal("show");
                productIconUrl = result.data.product_icon;
                $("#productUpdateBtn").prop("disabled", false);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
}

listenChange("#editProductIcon", function () {
    changeImg(
        this,
        "#editProductIconValidation",
        "#editProductPreview",
        productIconUrl
    );
    $(".cancel-edit-service").show();
});

listenClick(".cancel-edit-service", function () {
    $("#editProductPreview").attr("src", productIconUrl);
});

listenSubmit("#editProductForm", function (event) {
    event.preventDefault();
    $("#productUpdateBtn").prop("disabled", true);
    let vcardProductId = $("#productId").val();
    $.ajax({
        url: route("vcard.products.update", vcardProductId),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#editProductModal").modal("hide");
                Livewire.dispatch("refresh");
                $("#productUpdateBtn").prop("disabled", true);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
            $("#productUpdateBtn").prop("disabled", false);
        },
    });
});

listenClick(".product-view-btn", function (event) {
    let vcardProductId = $(event.currentTarget).data("id");
    vcardProductRenderDataShow(vcardProductId);
});

function vcardProductRenderDataShow(id) {
    $.ajax({
        url: route("vcard.products.edit", id),
        type: "GET",
        success: function (result) {
            if (result.success) {
                var decimalVal = $('#settings').data('value');
                $("#showName").append(result.data.name);
                if (result.data.formatted_amount) {
                    if (result.data.currency.currency_icon === "$") {
                        $("#showPrice").append(
                            result.data.currency.currency_icon +
                            parseFloat(result.data.price).toFixed(decimalVal == 1 ? 0 : 2)
                        );
                    } else {
                        var priceOnly = parseFloat(result.data.formatted_amount.replace(/[^0-9.]/g, ''));
                        var formattedPrice = priceOnly.toFixed(decimalVal == 1 ? 0 : 2);
                        $("#showPrice").append(result.data.currency.currency_icon + formattedPrice);
                    }
                } else if (result.data.price != null) {
                    $("#showPrice").append(parseFloat(result.data.price).toFixed(decimalVal == 1 ? 0 : 2));
                } else {
                    $("#showPrice").append("N/A");
                }
                let element = document.createElement("textarea");
                element.innerHTML = result.data.description;
                $("#showDesc").append(element.value);
                if (result.data.product_url != null) {
                    $(".productUrl").removeClass('d-none');
                    $("#showProductUrl").append(
                        '<a href="' +
                        result.data.product_url +
                        '">' +
                        result.data.product_url +
                        "</a>"
                    );
                } else {
                    $(".productUrl").addClass('d-none');
                }
                $("#productImagesContainer").html("");

                $.each(result.data.media, function (index, media) {
                    let imageUrl = media.original_url;
                    let imagePreview = `
                        <div class="image-picker">
                            <div class="image previewImage" style="background-image: url('${imageUrl}')"></div>
                                <label>
                                    <input type="file" name="product_icon[]" class="image-upload file-validation d-none" accept="image/*"/>
                                </label>
                            </span>
                        </div>`;
                    $("#productImagesContainer").append(imagePreview);
                });
                $("#showProductModal").modal("show");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
}
function ProductOrdeerFilter() {
    $("#productPaymentType").select2();
}
listen("change", "#productPaymentType", function () {
    let value = $(this).val();

    Livewire.dispatch("changeFilter", { type: "" });
    Livewire.dispatch("changeStatusFilter", { status: "" });

    if (value.startsWith('status_')) {
        let status = value.replace('status_', '');
        Livewire.dispatch("changeStatusFilter", { status: status });
    } else if (value) {
        Livewire.dispatch("changeFilter", { type: value });
    }

    window.hideDropdownManually($("#dropdownMenuProduct"), $(".dropdown-menu"));
});

listen("click", "#productOrderResetFilter", function () {
    $("#productPaymentType").val('').change();
    Livewire.dispatch("changeFilter", { type: "" });
    Livewire.dispatch("changeStatusFilter", { status: "" });
    window.hideDropdownManually($("#dropdownMenuProduct"), $(".dropdown-menu"));
});



listenClick(".delete-media", function () {
    $(this).closest('.image-picker').remove();
    if ($(".image-picker").length === 2) {
        $(".image-picker .remove-image-picker").remove();
    }
    let mediaId = $(this).data("id");
    $.ajax({
        url: route("product.media.destroy", mediaId),
        type: "DELETE",
        success: function (response) {
            displaySuccessMessage(response.message);
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
});
