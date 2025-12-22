
Livewire.hook("element.init", () => {
    loadProductFilter();
});

function loadProductFilter() {
    $(".wp-product-order-status").select2({
        minimumResultsForSearch: -1,
    });
}

listenChange(".wp-product-order-status", function () {
    let orderId = $(this).data("id");
    let status = $(this).val();
    if (status == 0) return;

    let url = route("wp.product.update.order.status", orderId);
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

listenClick(".wp-product-transaction-order-view-btn", function () {
    let orderId = $(this).data("id");
    viewproductOrderRenderData(orderId);
});

function viewproductOrderRenderData(orderId) {
    let url = route("wp.product.show.order", orderId);
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

Livewire.hook("element.init", () => {
    loadwpProductOrderFilter();
});
function loadwpProductOrderFilter() {
    $("#wpProductOrderFilter").select2();
}
listen("change", "#wpProductOrderFilter", function () {
    Livewire.dispatch("changeFilterStore", { id: $(this).val() });
    window.hideDropdownManually(
        $("#dropdownMenuWpProductOrderFilter"),
        $(".dropdown-menu")
    );
});
function hideDropdownManually(button, menu) {
    button.attr("aria-expanded", "false");
    menu.removeClass("show");
}

listen("click", "#wpProductOrderResetFilter", function () {
    $("#wpProductOrderFilter").val('').trigger('change');
    Livewire.dispatch("changeFilterStore", { id: "" });
    window.hideDropdownManually($("#dropdownMenuWpProductOrderFilter"), $(".dropdown-menu"));
});
