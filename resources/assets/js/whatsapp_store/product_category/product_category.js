//product category store
listenSubmit("#whatsappStoreProductCategoryForm", function (e) {
    e.preventDefault();

    $("#productCategorySave").prop("disabled", true);
    $.ajax({
        url: route("product.categories.store"),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#addProductCategoryModal").modal("hide");
                Livewire.dispatch("refresh");
                $("#productCategorySave").prop("disabled", false);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
            $("#productCategorySave").prop("disabled", false);
        },
    });
});

//delete product category
listenClick(".product-category-delete-btn", function (event) {
    let recordId = $(event.currentTarget).attr("data-id");
    deleteItem(
        route("product.categories.destroy", recordId),
        Lang.get("js.product_category")
    );
});

//add product category modal
listenClick("#addProductCategory", function () {
    let url = $("#categoryDefaultImage").val();
    $("#productCategoryPreview").css("background-image", "url('" + url + "')");
    $("#addProductCategoryModal").modal("show");
});


listenHiddenBsModal("#addProductCategoryModal", function (e) {
    $("#whatsappStoreProductCategoryForm")[0].reset();
    $("#productCategoryPreview").css("background-image", "url('')");
});

//edit product category modal
listenClick(".product-category-edit-btn", function (event) {
    event.preventDefault();
    let productCategoryId = $(this).data("id");
    editProductCategoryRenderData(productCategoryId);
});
//get product category
function editProductCategoryRenderData(productCategoryId) {
    $.ajax({
        url: route("product.categories.edit", productCategoryId),
        type: "GET",
        success: function (result) {
            if (result.success) {
                $("#editProductCategoryModal").modal("show");
                $("#editProductCategoryName").val(result.data.name);
                $("#editProductCategoryId").val(result.data.id);
                $("#editProductCategoryPreview").css(
                    "background-image",
                    'url("' + result.data.image_url + '")'
                );
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
}

//product category update
listenSubmit("#editProductCategoryForm", function (e) {
    e.preventDefault();
    let productCategory = $("#editProductCategoryId").val();

    $("#editProductCategorySave").prop("disabled", true);
    $.ajax({
        url: route("product.categories.update", productCategory),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#editProductCategoryModal").modal("hide");
                Livewire.dispatch("refresh");
                $("#editProductCategorySave").prop("disabled", false);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
            $("#editProductCategorySave").prop("disabled", false);
        },
    });
});

//show product category modal
listenClick(".product-category-view-btn", function (event) {
    event.preventDefault();
    let productCategoryId = $(this).data("id");
    viewProductCategoryRenderData(productCategoryId);
});

//get product category
function viewProductCategoryRenderData(productCategoryId) {
    $.ajax({
        url: route("product.categories.edit", productCategoryId),
        type: "GET",
        success: function (result) {
            if (result.success) {
              
                $("#wpStoreCategoryName").text(result.data.name);
                $("#wpStoreCategoryProductCount").text(result.data.products_count);
                
                $("#showProductCategoryImage").empty();
                let imageElement = `<img src="${result.data.image_url}" class="img-fluid rounded shadow-sm m-2" style="width: 100px; height: 100px;"  loading="lazy">`;
                $("#showProductCategoryImage").append(imageElement);
                
                $("#showProductCategoryModal").modal("show");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
}