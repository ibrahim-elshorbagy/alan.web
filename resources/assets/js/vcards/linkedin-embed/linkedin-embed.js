listenClick("#addLinkedinBtn", function () {
    $("#addLinkedinModal").modal("show");
});

listenHiddenBsModal("#addLinkedinModal", function (e) {
    $("#addLinkedinForm")[0].reset();
    $("#typeId").val(null).trigger("change");
});

listenSubmit("#addLinkedinForm", function (e) {
    e.preventDefault();

    $("#LinkedinEmbedSave").prop("disabled", true);
    $.ajax({
        url: route("linkedin-embed.store"),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#addLinkedinModal").modal("hide");
                $("#addLinkedinForm").trigger("reset");
                $("#LinkedinEmbedSave").prop("disabled", false);
                Livewire.dispatch("refresh");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
            $("#LinkedinEmbedSave").prop("disabled", false);
        },
    });
});

listenClick(".linkedinembed-edit-btn", function (event) {
    let LinkedinId = $(event.currentTarget).attr("data-id");
    editLinkedinRenderData(LinkedinId);
});

function editLinkedinRenderData(id) {
    $.ajax({
        url: route("linkedin-embed.edit", id),
        type: "GET",
        success: function (result) {
            if (result.success) {
                $("#editTypeId").val(result.data.type).trigger("change");
                $("#editEmbedtag").val(result.data.embedtag);
                $("#editVcard").val(result.data.vcard_id);
                $("#editEmbedId").val(result.data.id);
                $("#editLinkedinEmbedModal").modal("show");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
}

listenSubmit("#EditLinkedinForm", function (event) {
    event.preventDefault();

    $("#editLinkedinEmbedSave").prop("disabled", true);
    let embedId = $("#editEmbedId").val();
    $.ajax({
        url: route("linkedin-embed.update", embedId),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#editLinkedinEmbedModal").modal("hide");
                $("#EditLinkedinForm").trigger("reset");
                $("#editLinkedinEmbedSave").prop("disabled", false);
                Livewire.dispatch("refresh");
            }
        },
        error: function (result) {
            $("#editLinkedinEmbedSave").prop("disabled", false);
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

listenClick(".linkedinembed-delete-btn", function (event) {
    let recordId = $(event.currentTarget).attr("data-id");
    console.log(recordId);
    deleteItem(
        route("linkedin-embed.destroy", recordId),
        Lang.get("js.embedtag")
    );
});

listenClick("#linkedinEmbedGuideBtn", function () {
    $("#linkedinEmbedGuideModal").modal("show");
});
