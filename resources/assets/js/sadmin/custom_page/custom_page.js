Livewire.hook("element.init", () => {
    loadCustomPagefilter();
});

listenChange('.custom-page-status', function (event) {
    let subscriptionPlanId = $(event.currentTarget).attr("data-id");
    $.ajax({
        url: route("custom.page.status", subscriptionPlanId),
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

listen("click", ".custom-page-delete-btn", function (event) {
    let deleteBlogId = $(event.currentTarget).attr("data-id");
    let url = route("custom.page.destroy", { customPage: deleteBlogId });
    deleteItem(url, Lang.get("js.custom_page"));
});

function loadCustomPagefilter() {
    $("#customPageStatus").select2();
}
listen("change", "#customPageStatus", function () {
    Livewire.dispatch("statusFilter", { status: $(this).val() });
    window.hideDropdownManually(
        $("#dropdownMenucustomPageStatus"),
        $(".dropdown-menu")
    );
});
function hideDropdownManually(button, menu) {
    button.attr("aria-expanded", "false"); // Set aria-expanded attribute to false on the dropdown button
    menu.removeClass("show"); // Remove 'show' class from the dropdown menu
}
listen("click", "#customPageResetFilter", function () {
    $("#customPageStatus").val(2).change();
    Livewire.dispatch("statusFilter", { status: "" });
    window.hideDropdownManually(
        $("#dropdownMenucustomPageStatus"),
        $(".dropdown-menu")
    );
});
