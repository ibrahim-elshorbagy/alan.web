document.addEventListener("DOMContentLoaded", Description);
let customPageDescriptionData;

function Description() {
    if(!$('#customPageDescriptionEditor').length){
        return false;
    }
    customPageDescriptionData = new Quill("#customPageDescriptionEditor", {
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, 4, 5, 6, false] }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                ["bold", "italic", "underline", "strike"],
                ["blockquote", "code-block"],
                [{ list: "ordered" }, { list: "bullet" }],
                [{ script: "sub" }, { script: "super" }],
                [{ indent: "-1" }, { indent: "+1" }],
                [{ direction: "rtl" }],
                [{ color: [] }, { background: [] }],
                [{ font: [] }],
                [{ align: [] }],
                ['link', 'image', 'video', 'formula'],
                ['clean'],
            ],
        },
        placeholder: Lang.get("js.blog_description"),
        theme: "snow",
    });

    customPageDescriptionData.on("text-change", function (delta, oldDelta, source) {
        if (customPageDescriptionData.getText().trim().length === 0) {
            customPageDescriptionData.setContents([{ insert: "" }]);
        }
    });

    $("#customPageCreateForm").submit(function () {
        let editorContent = customPageDescriptionData.root.innerHTML;
        $("#customPageDescriptionData").val(editorContent);
    });

    $("#customPageEditForm").submit(function () {
        let editorContent = customPageDescriptionData.root.innerHTML;
        $("#customPageDescriptionData").val(editorContent);
    });
}

listenSubmit('#customPageCreateForm', function (e) {
    e.preventDefault()

    if (customPageDescriptionData.getText().trim().length === 0) {
        displayErrorMessage(Lang.get("js.description_required"));
        return false;
    }

    $('#customPageCreateForm')[0].submit();
})

listenSubmit('#customPageEditForm', function (e) {
    e.preventDefault()
    if (customPageDescriptionData.getText().trim().length === 0) {
        displayErrorMessage(Lang.get("js.description_required"));
        return false;
    }
        $('#customPageEditForm')[0].submit();
})

listen("keyup", "#customPageTitle", function () {
    var Text = $.trim($(this).val());
    Text = Text.toLowerCase();
    Text = Text.replace(/[^a-zA-Z0-9-ğüşöçİĞÜŞÖÇ]+/g, "-");
    $("#customPageSlug").val(Text);
});

listen("keyup", "#customPageSlug", function () {
    var Text = $(this).val();
    Text = Text.toLowerCase();
    Text = Text.replace(/[^a-zA-Z0-9-ğüşöçİĞÜŞÖÇ]+/g, "-");
    $(this).val(Text);
});

$("#customPageTitle").blur(function () {
    let text = $(this).val();
    $.ajax({
        url: route("custom-page-slug"),
        type: "post",
        data: {
            text: text,
        },
        success: function (result) {
            alert("succes");
            if (result.success) {
                $("#customPageSlug").val(result.data);
            }
        },
    });
});
