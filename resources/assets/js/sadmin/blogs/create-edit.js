
// document.addEventListener("turbo:load", Description);
document.addEventListener("DOMContentLoaded", Description);
let blogDescriptionData;

function Description() {
    if(!$('#blogDescriptionEditor').length){
        return false;
    }
    blogDescriptionData = new Quill("#blogDescriptionEditor", {
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
        placeholder: Lang.get("js.blog_description"),
        theme: "snow",
    });

    blogDescriptionData.on("text-change", function (delta, oldDelta, source) {
        if (blogDescriptionData.getText().trim().length === 0) {
            blogDescriptionData.setContents([{ insert: "" }]);
        }
    });

    $("#blogCreateForm").submit(function () {
        let editorContent = blogDescriptionData.root.innerHTML;
        $("#blogDescriptionData").val(editorContent);
    });

    $("#blogEditForm").submit(function () {
        let editorContent = blogDescriptionData.root.innerHTML;
        $("#blogDescriptionData").val(editorContent);
    });
}

listenSubmit('#blogCreateForm', function (e) {
    e.preventDefault()

    if ($('#blog_image').val().trim().length === 0) {
        displayErrorMessage(Lang.get("js.blog_image_required"));
        return false;
    }

    if (blogDescriptionData.getText().trim().length === 0) {
        displayErrorMessage(Lang.get("js.description_required"));
        return false;
    }

    $('#blogCreateForm')[0].submit();
})

listenSubmit('#blogEditForm', function (e) {
    e.preventDefault()
    if (blogDescriptionData.getText().trim().length === 0) {
        displayErrorMessage(Lang.get("js.description_required"));
        return false;
    }
        $('#blogEditForm')[0].submit();
})

listen("keyup", "#blogTitle", function () {
    var Text = $.trim($(this).val());
    Text = Text.toLowerCase();
    Text = Text.replace(/[^a-zA-Z0-9-ğüşöçİĞÜŞÖÇ]+/g, "-");
    $("#blogSlug").val(Text);
});

listen("keyup", "#blogSlug", function () {
    var Text = $(this).val();
    Text = Text.toLowerCase();
    Text = Text.replace(/[^a-zA-Z0-9-ğüşöçİĞÜŞÖÇ]+/g, "-");
    $(this).val(Text);
});

$("#blogTitle").blur(function () {
    let text = $(this).val();
    $.ajax({
        url: route("blog-slug"),
        type: "post",
        data: {
            text: text,
        },
        success: function (result) {
            alert("succes");
            if (result.success) {
                $("#blogSlug").val(result.data);
            }
        },
    });
});
