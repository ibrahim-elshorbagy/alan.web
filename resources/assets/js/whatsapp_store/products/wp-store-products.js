document.addEventListener("DOMContentLoaded", loadView);

Livewire.hook("element.init", () => {
    loadProductFilter();
});

function loadProductFilter() {
    $(".product-order-status").select2({
        minimumResultsForSearch: -1,
    });
}

function loadView() {
    if (!document.querySelector("#wpStoreProductDescriptionQuill")) return;

    window.quillwpStoreDescription = new Quill(
        "#wpStoreProductDescriptionQuill",
        {
            modules: {
                toolbar: [
                    ["bold", "italic", "underline", "strike"],
                    ["blockquote", "code-block"],
                    [{ header: [1, 2, 3, 4, 5, 6, false] }],
                    [{ color: [] }, { background: [] }],
                ],
            },
            theme: "snow",
            placeholder: Lang.get("js.short_description"),
        }
    );

    quillwpStoreDescription.on("text-change", function () {
        console.log(quillwpStoreDescription.root.innerHTML);
        $("#wpStoreProductDescriptionData").val(
            quillwpStoreDescription.root.innerHTML
        );
    });

    let savedContent = document.querySelector(
        "#wpStoreProductDescriptionData"
    ).value;
    if (savedContent.trim() !== "") {
        quillwpStoreDescription.root.innerHTML = savedContent;
    }

    if (!document.querySelector("#editWpStoreProductDescriptionQuill")) return;

    window.quillwpStoreEditDescription = new Quill(
        "#editWpStoreProductDescriptionQuill",
        {
            modules: {
                toolbar: [
                    ["bold", "italic", "underline", "strike"],
                    ["blockquote", "code-block"],
                    [{ header: [1, 2, 3, 4, 5, 6, false] }],
                    [{ color: [] }, { background: [] }],
                ],
            },
            theme: "snow",
            placeholder: Lang.get("js.short_description"),
        }
    );

    quillwpStoreEditDescription.on("text-change", function () {
        $("#editWpStoreProductDescriptionData").val(
            quillwpStoreEditDescription.root.innerHTML
        );
    });

    let element2 = document.createElement("textarea");
    element2.innerHTML = $("#editWpStoreProductDescriptionData").val();
    quillwpStoreEditDescription.root.innerHTML = element2.value;
}

// AI Product Description Generation for WhatsApp Store - Create Form
listenClick("#generateAiWpProductDescriptionBtn", function () {
    const $button = $(this);
    const productName = $("input[name='name']").val();
    const categoryId = $("select[name='category_id']").val();
    const whatsappStoreId = $("input[name='whatsapp_store_id']").val();

    if (!productName || !productName.trim()) {
        displayErrorMessage(Lang.get("js.product_name_required"));
        return;
    }

    if (!categoryId || categoryId == "0") {
        displayErrorMessage(Lang.get("js.product_category_required"));
        return;
    }

    if (!whatsappStoreId) {
        displayErrorMessage("WhatsApp Store ID not found");
        return;
    }

    $button.prop('disabled', true);
    $button.find('i').addClass('fa-spin');

    $.ajax({
        url: route('whatsapp.stores.products.generate.ai.description'),
        type: 'POST',
        data: {
            product_name: productName.trim(),
            category_id: categoryId,
            whatsapp_store_id: whatsappStoreId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 45000,
        success: function (result) {
            $button.prop('disabled', false);
            $button.find('i').removeClass('fa-spin');

            if (result.success) {
                // Update the Quill editor with AI-generated content
                quillwpStoreDescription.root.innerHTML = result.description;
                $("#wpStoreProductDescriptionData").val(result.description);
                displaySuccessMessage(Lang.get("js.description_generated_successfully"));
            } else {
                displayErrorMessage(result.message);
            }
        },
        error: function (xhr, status, error) {
            $button.prop('disabled', false);
            $button.find('i').removeClass('fa-spin');

            if (xhr.responseJSON && xhr.responseJSON.message) {
                displayErrorMessage(xhr.responseJSON.message);
            } else {
                displayErrorMessage("An error occurred while generating description");
            }
        }
    });
});

// AI Product Description Generation for WhatsApp Store - Edit Form
listenClick("#generateAiWpProductDescriptionBtnEdit", function () {
    const $button = $(this);
    const productName = $("#editProductName").val();
    const categoryId = $("select[name='category_id']").val();
    const whatsappStoreId = $("input[name='whatsapp_store_id']").val();

    if (!productName || !productName.trim()) {
        displayErrorMessage(Lang.get("js.product_name_required"));
        return;
    }

    if (!categoryId || categoryId == "0" || categoryId == "") {
        displayErrorMessage(Lang.get("js.product_category_required"));
        return;
    }

    if (!whatsappStoreId) {
        displayErrorMessage("WhatsApp Store ID not found");
        return;
    }

    $button.prop('disabled', true);
    $button.find('i').addClass('fa-spin');

    $.ajax({
        url: route('whatsapp.stores.products.generate.ai.description'),
        type: 'POST',
        data: {
            product_name: productName.trim(),
            category_id: categoryId,
            whatsapp_store_id: whatsappStoreId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 45000,
        success: function (result) {
            $button.prop('disabled', false);
            $button.find('i').removeClass('fa-spin');

            if (result.success) {
                // Update the Quill editor with AI-generated content
                quillwpStoreEditDescription.root.innerHTML = result.description;
                $("#editWpStoreProductDescriptionData").val(result.description);
                displaySuccessMessage(Lang.get("js.description_generated_successfully"));
            } else {
                displayErrorMessage(result.message);
            }
        },
        error: function (xhr, status, error) {
            $button.prop('disabled', false);
            $button.find('i').removeClass('fa-spin');

            if (xhr.responseJSON && xhr.responseJSON.message) {
                displayErrorMessage(xhr.responseJSON.message);
            } else {
                displayErrorMessage("An error occurred while generating description");
            }
        }
    });
});

//wp store product form
listenClick("#addWpStoreProduct", function () {
    let url = $("#wpProductDefaultImage").val();
    $("#wpStoreProductPreview").css("background-image", "url('" + url + "')");
    $("select[name='category_id']").val(0).trigger("change");
    $("select[name='currency_id']").val(0).trigger("change");
    $("#addWpStoreProductModal").modal("show");
});

listenHiddenBsModal("#addWpStoreProductModal", function (e) {
    let element = document.createElement("textarea");
    element.innerHTML = "";
    quillwpStoreDescription.root.innerHTML = element.value;

    $("select[name='category_id']").val(0).trigger("change");
    $("select[name='currency_id']").val(0).trigger("change");
    $(".append-picker").addClass("d-none");
    $(".remove-image-picker-wp-store").addClass("d-none");
    $(".append-remove-image-picker").addClass("d-none");
    $("#whatsappStoreProductForm")[0].reset();
});

//product  store
listenSubmit("#whatsappStoreProductForm", function (e) {
    e.preventDefault();
    $("#wpStoreProductSave").prop("disabled", true);
    $.ajax({
        url: route("wp.store.product.store"),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#addWpStoreProductModal").modal("hide");
                Livewire.dispatch("refresh");
                $("#wpStoreProductSave").prop("disabled", false);
            }
        },

        error: function (result) {
            let url = $("#wpProductDefaultImage").val();
            $("#wpStoreProductPreview").css(
                "background-image",
                "url('" + url + "')"
            );
            displayErrorMessage(result.responseJSON.message);
            $("#wpStoreProductSave").prop("disabled", false);
        },
    });
});

//delete wp store product
listenClick(".wp-store-product-delete-btn", function (event) {
    let recordId = $(event.currentTarget).attr("data-id");
    deleteItem(
        route("wp.store.product.destroy", recordId),
        Lang.get("js.product")
    );
});

//edit product category modal
listenClick(".wp-store-product-edit-btn", function (event) {
    event.preventDefault();
    let productId = $(this).data("id");
    editProductRenderData(productId);
});

//get product
function editProductRenderData(productId) {
    $.ajax({
        url: route("wp.store.product.edit", productId),
        type: "GET",
        success: function (result) {
            if (result.success) {
                $("#editProductName").val(result.data.name);
                $("#editProductNetPrice").val(result.data.net_price);
                $("#editProductSellingPrice").val(result.data.selling_price);
                $("#editProductTotalStock").val(result.data.total_stock);
                $("#editProductAvilableStock").val(result.data.available_stock);
                $("#editProductDescription").val(result.data.description);
                $("#editProductID").val(result.data.id);
                let url = $("#wpProductDefaultImage").val();

                if (result.data.description.trim() !== "") {
                    quillwpStoreEditDescription.root.innerHTML =
                        result.data.description;
                }

                // Set selected category
                $("select[name='category_id']")
                    .val(result.data.category_id)
                    .trigger("change");

                // Set selected currency
                $("select[name='currency_id']")
                    .val(result.data.currency.id)
                    .trigger("change");

                const productImagesContainer = $("#editWpStoreImageContainer");
                productImagesContainer.empty();

                result.data.media.forEach(function (mediaItem, index) {
                    const mediaId = mediaItem.id;
                    const imageUrl = mediaItem.original_url;
                    const uniqueId = `productIcon-${Date.now()}`;
                    let trashButton = "";
                    if (result.data.media.length === 1) {
                        trashButton = "";
                    } else {
                        trashButton = `
                        <div class="text-center">
                           <a class="btn-sm remove-image-picker wp-delete-media mt-2 mb-4 text-danger" data-id="${mediaId}">
                               <i class="fa-solid fa-trash"></i>
                           </a>
                        </div>`;
                    }
                    const imagePreview = `
                        <div class="image-picker ms-2">
                            <div class="image previewImage ms-4 mt-3" style="background-image: url('${imageUrl}')"></div>
                            <div class="edit-trash">
                             ${trashButton}
                        </div>`;
                    productImagesContainer.append(imagePreview);
                });

                defaultEditImg = `<div class="d-block">
                <div class="image-picker">
                    <div class="image previewImage ms-4 mt-4" id="editProductPreview"
                        style="background-image: url('${url}')">
                    </div>
                    <span class="picker-edit rounded-circle text-gray-500 fs-small mt-4"
                        data-bs-toggle="tooltip" data-placement="top"
                        data-bs-original-title="{{ __('messages.tooltip.image') }}">
                        <label>
                            <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                            <input type="file" id="editProductIcon" name="images[]"
                                class="image-upload d-none" accept="image/*"
                                multiple />
                        </label>
                    </span>
                </div>
            </div>`;

                productImagesContainer.append(defaultEditImg);

                $("#editWpStoreProductModal").modal("show");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
}

listen("change", 'input[type="file"]', function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $(event.target)
                .closest(".image-picker")
                .find(".previewImage")
                .css("background-image", `url(${e.target.result})`);
        };
        reader.readAsDataURL(file);
    }
});
listenClick(".remove-image-picker", function () {
    $(this).closest(".image-picker").remove();
    if ($(".image-picker").length <= 3) {
        $(".image-picker .remove-image-picker").remove();
    }
});

//product  update
listenSubmit("#editWhatsappStoreProductForm", function (e) {
    e.preventDefault();
    let product = $("#editProductID").val();

    $("#editWPStoreProductSave").prop("disabled", true);
    $.ajax({
        url: route("wp.store.product.update", product),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#editWpStoreProductModal").modal("hide");
                Livewire.dispatch("refresh");
                $("#editWPStoreProductSave").prop("disabled", false);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
            $("#editWPStoreProductSave").prop("disabled", false);
        },
    });
});

listenClick(".wp-delete-media", function () {
    let mediaId = $(this).data("id");
    $.ajax({
        url: route("wp.product.media.destroy", mediaId),
        type: "DELETE",
        success: function (response) {
            displaySuccessMessage(response.message);
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
});

//show products

listenClick(".wp-store-product-view-btn", function (event) {
    event.preventDefault();
    let productId = $(this).data("id");
    viewProductRenderData(productId);
});

//show product
function viewProductRenderData(productId) {
    $.ajax({
        url: route("wp.store.product.edit", productId),
        type: "GET",
        success: function (result) {
            if (result.success) {
                $("#wpStoreProductName").text(result.data.name);
                $("#wpStoreProductCategory").text(
                    result.data.category.name || "N/A"
                );
                let netPrice = result.data.net_price
                    ? result.data.currency.currency_icon +
                    " " +
                    result.data.net_price
                    : "0";
                $("#wpStoreProductNetPrice").text(netPrice);
                $("#wpStoreProductSellingPrice").text(
                    result.data.currency.currency_icon +
                    " " +
                    result.data.selling_price
                );
                $("#wpStoreProductDescription").html(result.data.description);

                $("#showProductImages").empty();
                if (result.data.images_url.length > 0) {
                    result.data.images_url.forEach(function (imageUrl) {
                        let imageElement = `<img src="${imageUrl}" class="img-fluid rounded shadow-sm m-2" style="width: 100px; height: 100px;"  loading="lazy">`;
                        $("#showProductImages").append(imageElement);
                    });
                }

                $("#wpStoreShowProductModal").modal("show");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
}

listenClick(".wp-product-order-view-btn", function () {
    let orderId = $(this).data("id");
    viewOrderRenderData(orderId);
});

function viewOrderRenderData(orderId) {
    let url = route("wp.stores.show.order", orderId);
    const STATUS_ARR = {
        0: Lang.get('js.pending'),
        1: Lang.get('js.dispatched'),
        2: Lang.get('js.delivered'),
        3: Lang.get('js.cancelled'),
    };

    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {
            if (response.success) {
                let order = response.data;

                $("#orderId").text(order.order_id);
                $("#orderName").text(order.name);
                $("#orderPhone").text(`+${order.region_code} ${order.phone}`);
                $("#orderStatus").text(STATUS_ARR[order.status]);
                $("#orderGrandTotal").html(order.grand_total);
                $("#orderAddress").text(order.address);

                let productRows = "";
                order.products.forEach((product, index) => {
                    productRows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${product.product?.name}</td>
                            <td>${product.price}</td>
                            <td>${product.qty}</td>
                            <td>${product.total_price}</td>
                        </tr>
                    `;
                });

                $(".product-list").html(productRows);

                $("#wpStoreShowProductOrderModal").modal("show");
            }
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
}

listenChange(".product-order-status", function () {
    let orderId = $(this).data("id");
    let status = $(this).val();
    if (status == 0) return;

    let url = route("wp.stores.update.order.status", orderId);
    $.ajax({
        url: url,
        type: "POST",
        data: { status: status },
        success: function (response) {
            Livewire.dispatch("refresh");
            prepareAndSendWpMessage(response.data[0], response.data[1]);
            displaySuccessMessage(response.message);
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
});

function prepareAndSendWpMessage(order, base_url) {
    let baseUrl = base_url;
    let storeAlias = order.wp_store.url_alias;
    let regionCode = order.region_code;
    let whatsappNumber = order.phone;
    let message = "";

    if (order.status == 1) {
        message = Lang.get("js.order_dispatched") + `:\n\n`;
    } else if (order.status == 2) {
        message = Lang.get("js.order_delivered") + `:\n\n`;
    } else if (order.status == 3) {
        message = Lang.get("js.order_cancelled") + `:\n\n`;
    } else {
        return;
    }

    message = Lang.get("js.customer_details") + `:\n`;
    message += `------------------------------\n`;
    message += Lang.get("js.name") + `: ${order.name}\n`;
    message +=
        Lang.get("js.phone") + `: +${order.region_code} ${order.phone}\n`;
    message += Lang.get("js.address") + `: ${order.address}\n\n`;
    message += Lang.get("js.order_id") + `: ${order.order_id}\n`;
    message += `------------------------------\n`;
    message += Lang.get("js.product_details") + `:\n`;
    message += `------------------------------\n`;

    order.products.forEach((product, index) => {
        let productUrl = `${baseUrl}/whatsapp-store/${storeAlias}/${product.product_id}/product-details`;

        message += `${index + 1}.\n`;
        message +=
            Lang.get("js.product_name") +
            `: ${product.product ? product.product.name : "Unknown"}\n`;
        message += Lang.get("js.product_url") + ` : ${productUrl}\n`;
        message +=
            Lang.get("js.price") +
            ` : ${product.product.currency.currency_icon} ${product.price}\n`;
        message += Lang.get("js.quantity") + ` : ${product.qty}\n`;
        message +=
            Lang.get("js.total_price") +
            ` : ${product.product.currency.currency_icon} ${product.total_price}\n`;
        message += `------------------------------\n`;
    });

    message += `\n${Lang.get("js.grand_total")}: ${order.grand_total}\n`;

    let encodedMessage = encodeURIComponent(message);
    let recipientPhone = `+${regionCode}${whatsappNumber}`;

    let whatsappUrl = `https://wa.me/${recipientPhone}?text=${encodedMessage}`;

    window.open(whatsappUrl);
}
listen("keyup", ".product-total-stock", function () {
    var $totalStock = $(this).val();
    $(".product-avilable-stock").val($totalStock);
});

listenClick(".wp-product-order-delete-btn", function (event) {
    let orderId = $(event.currentTarget).attr("data-id");
    deleteItem(
        route("wp.stores.destroy.order", orderId),
        Lang.get("js.whatsapp_product_order")
    );
});

Livewire.hook("element.init", () => {
    loadProductOrderFilter();
});

function loadProductOrderFilter() {
    $("#productOrderStatus").select2();
}
listen("change", "#productOrderStatus", function () {
    Livewire.dispatch("changeFilterStatus", { status: $(this).val() });
    window.hideDropdownManually(
        $("#dropdownMenuProductOrderStatus"),
        $(".dropdown-menu")
    );
});
function hideDropdownManually(button, menu) {
    button.attr("aria-expanded", "false");
    menu.removeClass("show");
}
listen("click", "#productOrderResetFilter", function () {
    $("#productOrderStatus").val('').change();
    Livewire.dispatch("changeFilterStatus", { status: "" });
    window.hideDropdownManually(
        $("#dropdownMenuProductOrderStatus"),
        $(".dropdown-menu")
    );
});
