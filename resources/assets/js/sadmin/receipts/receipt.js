// Add Receipt
listenClick("#newReceipt", function () {
    $("#addReceiptModal").modal("show");
    resetModalForm("#addReceiptForm");
    // Set user_id from hidden field
    $("#addUserId").val($("#userId").val());
});

listenHiddenBsModal("#addReceiptModal", function () {
    resetModalForm("#addReceiptForm");
});

listenSubmit("#addReceiptForm", function (e) {
    e.preventDefault();
    $.ajax({
        url: route("receipts.store"),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#addReceiptModal").modal("hide");
                Livewire.dispatch('refresh');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

// Edit Receipt
listenClick(".receipt-edit-btn", function (event) {
    let receiptId = $(event.currentTarget).data("id");
    receiptRenderDataShow(receiptId);
});

function receiptRenderDataShow(id) {
    $.ajax({
        url: route("receipts.edit", { id: id }),
        type: "GET",
        success: function (result) {
            if (result.success) {
                let receipt = result.data;
                $("#receiptId").val(receipt.id);
                $("#editUserId").val(receipt.user_id);
                $("#editAmount").val(receipt.amount);
                $("#editReceivedAt").val(receipt.received_at);
                $("#editDescription").val(receipt.description);
                $("#editReceiptModal").modal("show");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
}

listenSubmit("#editReceiptForm", function (event) {
    event.preventDefault();
    let receiptId = $("#receiptId").val();
    $.ajax({
        url: route("receipts.update", receiptId),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#editReceiptModal").modal("hide");
                Livewire.dispatch('refresh');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

// Delete Receipt
listenClick(".receipt-delete-btn", function (event) {
    let recordId = $(event.currentTarget).data("id");
    deleteItem(route("receipts.delete", recordId), 'السند');
});
