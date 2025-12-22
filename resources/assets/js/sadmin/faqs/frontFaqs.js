document.addEventListener("DOMContentLoaded", FaqDescription);

listenClick("#addFaqsBtn", function () {
    descriptionData.setContents([]);
    $("#addFrontFaqsModal").modal("show");
    $("#faqsSave").prop("disabled", false);
});

listenHiddenBsModal("#addFrontFaqsModal", function () {
    resetModalForm("#addFrontFaqsForm");
    $(".cancel-testimonial").hide();
    descriptionData.setContents([]);
});

listenSubmit("#addFrontFaqsForm", function (e) {
    let editorContent = descriptionData.getText().trim();

    if (!editorContent) {
        displayErrorMessage(Lang.get("js.description_required"));
        e.preventDefault();
        return false;
    }
    if (editorContent.length < 3) {
        displayErrorMessage(Lang.get("js.description_length"));
        e.preventDefault();
        return false;
    }
    $("#faqsSave").prop("disabled", true);
    e.preventDefault();
    $.ajax({
        url: route("frontFaqs.store"),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#addFrontFaqsModal").modal("hide");
                Livewire.dispatch("refresh");
                $("#faqsSave").prop("disabled", true);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
            $("#faqsSave").prop("disabled", false);
        },
    });
});

listenHiddenBsModal("#showFaqsModal", function () {
    $("#showTitle,#showDesc").empty();
});

listenClick(".view-faqs-btn", function (event) {
    let frontFaqsId = $(event.currentTarget).attr("data-id");
    FaqsRenderDataShow(frontFaqsId);
});
function FaqsRenderDataShow(id) {
    $.ajax({
        url: route("frontFaqs.edit", id),
        type: "GET",
        success: function (result) {
            if (result.success) {
                $("#showTitle").append(result.data.title);
                let element = document.createElement("textarea");
                element.innerHTML = result.data.description;
                $("#showDesc").append(element.value);
                $("#showFaqsModal").modal("show");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
}

listenClick(".front-faqs-edit-btn", function (event) {
    let faqsId = $(event.currentTarget).attr("data-id");
    EditFaqsRenderData(faqsId);
});
function EditFaqsRenderData(id) {
    $.ajax({
        url: route("frontFaqs.edit", id),
        type: "GET",
        success: function (result) {
            if (result.success) {
                $("#FaqsId").val(result.data.id);
                $("#editTitle").val(result.data.title);
                let element = document.createElement("textarea");
                element.innerHTML = result.data.description;
                descriptionDataEdit.root.innerHTML = element.value;
                $("#editDescription").val(result.data.description);
                $("#editFaqsModal").modal("show");
                $("#faqsUpdate").prop("disabled", false);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
}

listenSubmit("#editFrontFaqsForm", function (e) {
    let editorContent = descriptionDataEdit.getText().trim();

    if (!editorContent) {
        displayErrorMessage(Lang.get("js.description_required"));
        e.preventDefault();
        return false;
    }
    if (editorContent.length < 3) {
        displayErrorMessage(Lang.get("js.description_length"));
        e.preventDefault();
        return false;
    }
    e.preventDefault();
    $("#faqsUpdate").prop("disabled", true);
    let faqsId = $("#FaqsId").val();
    $.ajax({
        url: route("frontFaqs.updateData", faqsId),
        method: "POST",
        processData: false,
        contentType: false,
        data: new FormData(this),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#editFaqsModal").modal("hide");
                Livewire.dispatch("refresh");
                $("#faqsUpdate").prop("disabled", true);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
            $("#faqsUpdate").prop("disabled", false);
        },
    });
});

listen("click", ".front-faqs-delete-btn", function (event) {
    let deleteFrontFaqsId = $(event.currentTarget).attr("data-id");
    let url = route("frontFaqs.destroy", deleteFrontFaqsId);
    deleteItem(url, Lang.get("js.faqs"));
});

function FaqDescription() {
    if (!$('#faqDescriptionEditor').length) {
        return false;
    }
    descriptionData = new Quill("#faqDescriptionEditor", {
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
            ],
        },
        placeholder: Lang.get("js.short_description"),
        theme: "snow",
    });

    descriptionData.on("text-change", function (delta, oldDelta, source) {
        if (descriptionData.getText().trim().length === 0) {
            descriptionData.setContents([{ insert: "" }]);
        }
    });

    $("#addFrontFaqsForm").submit(function () {
        let editorContent = descriptionData.root.innerHTML;
        $("#faqDescription").val(editorContent);
    });

    if (!$('#faqDescriptionEditoredit').length) {
        return false;
    }
    descriptionDataEdit = new Quill("#faqDescriptionEditoredit", {
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
            ],
        },
        placeholder: Lang.get("js.short_description"),
        theme: "snow",
    });

    descriptionDataEdit.on("text-change", function (delta, oldDelta, source) {
        if (descriptionDataEdit.getText().trim().length === 0) {
            descriptionDataEdit.setContents([{ insert: "" }]);
        }
    });

    $("#editFrontFaqsForm").submit(function () {
        let editorContent = descriptionDataEdit.root.innerHTML;
        $("#editDescription").val(editorContent);
    });
}
