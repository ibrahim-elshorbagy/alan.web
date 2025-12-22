Livewire.hook("element.init", () => {
    loadBlogfilter();
});

listenChange('.blog-status', function (event) {
    let subscriptionPlanId = $(event.currentTarget).attr("data-id");
    $.ajax({
        url: route("blog-status", subscriptionPlanId),
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

listen("click", ".blog-delete-btn", function (event) {
    let deleteBlogId = $(event.currentTarget).attr("data-id");
    let url = route("blogs.destroy", { blog: deleteBlogId });
    deleteItem(url, Lang.get("js.blog"));
});

function loadBlogfilter() {
    $("#blogStatus").select2();
}
listen("change", "#blogStatus", function () {
    Livewire.dispatch("statusFilter", { status: $(this).val() });
    window.hideDropdownManually(
        $("#dropdownMenuBlogStatus"),
        $(".dropdown-menu")
    );
});
function hideDropdownManually(button, menu) {
    button.attr("aria-expanded", "false"); // Set aria-expanded attribute to false on the dropdown button
    menu.removeClass("show"); // Remove 'show' class from the dropdown menu
}
listen("click", "#blogResetFilter", function () {
    $("#blogStatus").val(2).change();
    Livewire.dispatch("statusFilter", { status: "" });
    window.hideDropdownManually(
        $("#dropdownMenuBlogStatus"),
        $(".dropdown-menu")
    );
});
