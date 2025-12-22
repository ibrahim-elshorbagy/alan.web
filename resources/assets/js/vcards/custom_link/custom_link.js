listenClick("#addCustomLinkBtn", function () {
    $("#addCustomLinkModal").modal("show");
});

listenHiddenBsModal("#addCustomLinkModal", function (e) {
    $("#addCustomLinkForm")[0].reset();
    $("#buttonType").val('square').trigger("change");
    $("#customLinkSave").prop("disabled", false);
});

listenSubmit("#addCustomLinkForm", function (e) {
    e.preventDefault();
    $("#customLinkSave").prop("disabled", true);
    $.ajax({
        url: route("custom-link.store"),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result) {
                displaySuccessMessage(result.message);
                $("#customLinkSave").prop("disabled", true);
                $("#addCustomLinkModal").modal("hide");
                Livewire.dispatch("refresh");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
            $("#customLinkSave").prop("disabled", false);
        },
    });
});

listenClick(".custom-link-edit-btn", function (event) {
    let customLinkId = $(event.currentTarget).data("id");
    editCustomLinkRenderData(customLinkId);
});

function editCustomLinkRenderData(id) {
    $.ajax({
        url: route("custom-link.edit", id),
        type: "GET",
        success: function (result) {
            if (result.success) {
                $("#customLinkId").val(result.data.id);
                $("#edit_link_name").val(result.data.link_name);
                $("#edit_link").val(result.data.link);
                $("#edit_button_color").val(result.data.button_color);
                $("#editButtonType").val(result.data.button_type).trigger("change");
                $("#editShowAsButton").prop("checked", result.data.show_as_button);
                $("#editOpenNewTab").prop("checked", result.data.open_new_tab);
                $("#editCustomLinkModal").modal("show");
                $("#customLinkUpdateBtn").prop("disabled", false);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
}

listenSubmit("#editCustomLinkForm", function (event) {
    event.preventDefault();
    $("#customLinkUpdateBtn").prop("disabled", true);
    let customLinkId = $("#customLinkId").val();
    $.ajax({
        url: route("custom-link.update", customLinkId),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#editCustomLinkModal").modal("hide");
                $("#customLinkUpdateBtn").prop("disabled", true);
                Livewire.dispatch("refresh");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
            $("#customLinkUpdateBtn").prop("disabled", false);
        },
    });
});

listenClick(".custom-link-delete-btn", function (event) {
    let recordId = $(event.currentTarget).attr("data-id");
    deleteItem(route("custom-link.destroy", recordId), Lang.get("js.custom_link"));
});

listenChange('.show-as-button', function (event) {
    let customLinkId = $(event.currentTarget).data('id');
    $.ajax({
        url: route("show-as-button", customLinkId),
        method: "post",
        cache: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                Livewire.dispatch("refresh");
            }
        },
    });
});

listenChange('.open-new-tab', function (event) {
    let customLinkId = $(event.currentTarget).data('id');
    $.ajax({
        url: route("open-new-tab", customLinkId),
        method: "post",
        cache: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                Livewire.dispatch("refresh");
            }
        },
    });
});
