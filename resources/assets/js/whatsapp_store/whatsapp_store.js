document.addEventListener("DOMContentLoaded", function () {
    initBusinessHourToggles();
    manageDeleteButtons();
    loadWhatsappStoreTermsCondition();
});
//delete whatsapp store
listenClick(".whatsapp-store-delete-btn", function (event) {
    let recordId = $(event.currentTarget).attr("data-id");
    deleteItem(
        route("whatsapp.stores.destroy", recordId),
        Lang.get("js.whatsapp_store")
    );
});

//save or update wp template
listenClick(".wp-template-save", function () {
    let template_id = $("#themeInput").val();

    if (isEmpty(template_id) || template_id == 0) {
        displayErrorMessage(Lang.get("js.choose_one_template"));
        return false;
    }
    let whatsappStore = $("#whatsappStoreId").val();

    $.ajax({
        url: route("wp.template.update", whatsappStore),
        type: "POST",
        data: { template_id: template_id },
        success: function (response) {
            displaySuccessMessage(response.message);
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
});

//save or update wp template seo
listenClick(".wp-template-seo-save", function (e) {
    e.preventDefault();

    let whatsappStore = $("#whatsappStoreId").val();

    let formData = new FormData();
    formData.append('site_title', $('input[name="site_title"]').val());
    formData.append('home_title', $('input[name="home_title"]').val());
    formData.append('meta_keyword', $('input[name="meta_keyword"]').val());
    formData.append('meta_description', $('input[name="meta_description"]').val());
    formData.append('google_analytics', $('textarea[name="google_analytics"]').val());

    $.ajax({
        url: route("wp.template.seo.update", whatsappStore),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            displaySuccessMessage(response.message);
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
});

// save or update wp template advanced
listenClick(".wp-template-advance-save", function (e) {
    e.preventDefault();

    let whatsappStore = $("#whatsappStoreId").val();

    let formData = new FormData();
    formData.append('custom_css', $('textarea[name="custom_css"]').val());
    formData.append('custom_js', $('textarea[name="custom_js"]').val());

    $.ajax({
        url: route("wp.template.advance.update", whatsappStore),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            displaySuccessMessage(response.message);
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
});

// save or update wp template custom fonts
listenClick(".wp-template-custom-font-save", function (e) {
    e.preventDefault();

    let whatsappStore = $("#whatsappStoreId").val();

    let formData = new FormData();
    formData.append('font_family', $('select[name="font_family"]').val());
    formData.append('font_size', $('input[name="font_size"]').val());

    $.ajax({
        url: route("wp.template.custom.fonts.update", whatsappStore),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            displaySuccessMessage(response.message);
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
});


//whatsapp store status change
listen("click", ".whatsappStoreStatus", function () {
    let whatsappStoreId = $(this).data("id");
    let updateUrl = route("whatsapp.stores.status", whatsappStoreId);
    $.ajax({
        type: "get",
        url: updateUrl,
        success: function (response) {
            displaySuccessMessage(response.message);
            Livewire.dispatch("refresh");
        },
        error: function (error) {
            displayErrorMessage(error.responseJSON.message);
        },
    });
});

listen("click", ".whatsapp-store-clone", function () {
    let whatsappStoreId = $(this).attr("data-id");
    $("body").addClass("modal-open");
    $.ajax({
        url: route("sadmin.whatsapp.store.clone", whatsappStoreId),
        success: function (result) {
            let userDropdown = $("#user_id");
            userDropdown.empty();
            userDropdown.append('<option value="">' + Lang.get("js.select_user") + '</option>');
            $.each(result.data.users, function (id, name) {
                userDropdown.append('<option value="' + id + '">' + name + '</option>');
            });
            userDropdown.select2({
                minimumResultsForSearch: 0,
                dropdownParent: $('#whatsappStoreCloneModal')
            });
            $("#duplicateWhatsappStoreBtn").attr("data-id", whatsappStoreId);

            var modalElement = document.getElementById("whatsappStoreCloneModal");
            var myModal = new bootstrap.Modal(modalElement, {
                backdrop: "static",
                keyboard: false
            });

            myModal.show();
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
            $("body").removeClass("modal-open");
        },
    });
});

$(document).on("hidden.bs.modal", "#whatsappStoreCloneModal", function () {
    $("body").removeClass("modal-open");
});


listen("submit", "#cloneWhatsappStoreForm", function (e) {
    e.preventDefault();
    $("#duplicateWhatsappStoreBtn").prop("disabled", true);
    let duplicateId = $("#duplicateWhatsappStoreBtn").attr("data-id");
    let userId = $("#user_id").val();
    $.ajax({
        url: route("sadmin.duplicate.whatsapp.store", { id: duplicateId, userId: userId }),
        type: "POST",
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#whatsappStoreCloneModal").modal("hide");
                $("#duplicateWhatsappStoreBtn").prop("disabled", false);
                Livewire.dispatch("refresh");
            }
        },
        error: function (result) {
            $("#duplicateWhatsappStoreBtn").prop("disabled", false);
            if (!userId) {
                displayErrorMessage(Lang.get("js.please_select_user"));
                return;
            }
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

function initBusinessHourToggles() {
    document.querySelectorAll('.day-toggle').forEach(function (checkbox) {
        const dayKey = checkbox.value;

        toggleDayTime(dayKey);

        checkbox.addEventListener('change', function () {
            toggleDayTime(dayKey);
        });
    });
}

function toggleDayTime(dayKey) {
    const checkbox = document.getElementById('dayToggle' + dayKey);
    const timeFields = document.getElementById('timeFields' + dayKey);
    const closedState = document.getElementById('closedState' + dayKey);

    if (checkbox.checked) {
        // Show time fields, hide closed state
        timeFields.style.display = 'flex';
        closedState.style.display = 'none';
    } else {
        // Hide time fields, show closed state
        timeFields.style.display = 'none';
        closedState.style.display = 'flex';
    }
}

listenClick(".wp-business-hours-save", function (e) {
    e.preventDefault();

    let whatsappStore = $("#whatsappStoreId").val();
    let formData = new FormData();

    formData.append("week_format", $("#week_format").val());

    let selectedDays = [];
    $('.day-toggle:checked').each(function() {
        selectedDays.push($(this).val());
    });

    selectedDays.forEach(function(day) {
        formData.append('days[]', day);
    });

    $('select[name^="startTime"]').each(function() {
        let name = $(this).attr('name');
        let value = $(this).val();
        if (value) {
            formData.append(name, value);
        }
    });

    $('select[name^="endTime"]').each(function() {
        let name = $(this).attr('name');
        let value = $(this).val();
        if (value) {
            formData.append(name, value);
        }
    });

    $.ajax({
        url: route("wp.business.hours.update", whatsappStore),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            displaySuccessMessage(response.message);
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
});

function manageDeleteButtons() {
    let totalFields = $('.youtube-links-div').length;

    if (totalFields === 1) {
        $('.youtube-links-delete-btn').hide();
    } else {
        $('.youtube-links-delete-btn').show();
    }
}

listenClick(".youtube-links", function () {
    var title = Lang.get("js.delete");
    const youtubePlaceholder = Lang.get("js.enter_youtube_video_link");
    $(".youtube-links-add").append(
        '<div class="col-lg-6 mb-3 youtube-links-div">\n' +
        '    <div class="d-flex">\n' +
        '        <div class="d-flex w-100">\n' +
        '            <input type="text" class="form-control youtube_links" name="youtube_links[]" placeholder="' + youtubePlaceholder + '">\n' +
        '            <input type="hidden" name="youtube_link_id[]" class="youtubeLinkId" value="">\n' +
        '            <a href="javascript:void(0)" title="' + title + '" \n' +
        '               class="btn px-1 text-danger fs-3 youtube-links-delete-btn">\n' +
        '                <i class="fa-solid fa-trash"></i>\n' +
        '            </a>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>'
    );

    manageDeleteButtons();
});

listenClick(".youtube-links-delete-btn", function () {
    let totalFields = $('.youtube-links-div').length;

    if (totalFields > 1) {
        $(this).closest(".youtube-links-div").remove();

        manageDeleteButtons();
    }
});

listenClick(".youtube_link_save", function (e) {
    e.preventDefault();

    let inputs = $(".youtube_links");
    let whatsappStoreId = $(this).data('whatsapp-store-id');
    let totalFields = inputs.length;

    let isFirstFieldNullable = totalFields === 1;

    inputs.removeClass('is-invalid border-danger');

    for (var i = 0; i < inputs.length; i++) {
        let inputValue = $.trim($(inputs[i]).val());
        let isFirstField = i === 0;
        let fieldNumber = i + 1;

        if (isFirstField && isFirstFieldNullable) {
            if (inputValue !== "" && !isValidYouTubeUrl(inputValue)) {
                displayErrorMessage(Lang.get("js.invalid_youtube_url"));
                $(inputs[i]).focus();
                return false;
            }
        } else {
            if (inputValue === "") {
                displayErrorMessage(Lang.get("js.youtube_link_required"));
                $(inputs[i]).focus();
                return false;
            }

            if (!isValidYouTubeUrl(inputValue)) {
                displayErrorMessage(Lang.get("js.invalid_youtube_url"));
                $(inputs[i]).focus();
                return false;
            }
        }
    }

    let linkValues = [];
    let hasError = false;

    for (var i = 0; i < inputs.length; i++) {
        let linkValue = $.trim($(inputs[i]).val());

        if (linkValue !== "") {
            if (linkValues.includes(linkValue)) {
                displayErrorMessage(Lang.get("js.duplicate_youtube_links"));
                $(inputs[i]).focus();
                hasError = true;
                break;
            }
            linkValues.push(linkValue);
        }
    }

    if (hasError) return false;

    // Submit via AJAX
    saveYoutubeLinks(whatsappStoreId);
});

// YouTube URL validation function
function isValidYouTubeUrl(url) {
    var pattern = /^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|shorts\/)|youtu\.be\/)[\w-]+/;
    return pattern.test(url);
}

function saveYoutubeLinks(whatsappStoreId) {
    let formData = new FormData();
    let inputs = $('.youtube_links');
    let totalFields = inputs.length;
    let isFirstFieldNullable = totalFields === 1;

    // Get all YouTube link inputs
    let youtubeLinks = [];
    let youtubeLinkIds = [];

    inputs.each(function(index) {
        let link = $(this).val().trim();
        let linkId = $('.youtubeLinkId').eq(index).val();
        let isFirstField = index === 0; // Based on current position

        if ((isFirstField && isFirstFieldNullable) || link !== '') {
            youtubeLinks.push(link);
            youtubeLinkIds.push(linkId);
        }
    });

    // Append data to FormData
    youtubeLinks.forEach(function(link, index) {
        formData.append('youtube_links[]', link);
        formData.append('youtube_link_id[]', youtubeLinkIds[index]);
    });

    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

    $.ajax({
        url: route("wp.template.trending.video.update", whatsappStoreId),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            displaySuccessMessage(response.message);
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
}

function loadWhatsappStoreTermsCondition() {
    // Initialize Summernote for Terms & Conditions
    if ($("#whatsappTermsConditionsDescription").length) {
        $("#whatsappTermsConditionsDescription").summernote({
            placeholder: Lang.get("js.term_condition").replace(/&amp;/g, "&"),
            tabsize: 2,
            height: 200,
            toolbar: [
                ["style", ["style"]],
                ["font", ["bold", "underline", "clear"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                ["table", ["table"]],
            ],
        });
    }

    // Initialize Summernote for Privacy Policy
    if ($("#whatsappPrivacyPolicyDescription").length) {
        $("#whatsappPrivacyPolicyDescription").summernote({
            placeholder: Lang.get("js.privacy_policy"),
            tabsize: 2,
            height: 200,
            toolbar: [
                ["style", ["style"]],
                ["font", ["bold", "underline", "clear"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                ["table", ["table"]],
            ],
        });
    }

    // Initialize Summernote for Refund Cancellation
    if ($("#whatsappRefundCancellationDescription").length) {
        $("#whatsappRefundCancellationDescription").summernote({
            tabsize: 2,
            height: 200,
            toolbar: [
                ["style", ["style"]],
                ["font", ["bold", "underline", "clear"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                ["table", ["table"]],
            ],
        });
    }

    // Keep Quill for Shipping Delivery (unchanged)
    if ($("#shippingDeliveryQuill").length) {
        window.shippingDeliveryQuill = new Quill("#shippingDeliveryQuill", {
            modules: {
                toolbar: [
                    [
                        {
                            header: [1, 2, false],
                        },
                    ],
                    ["bold", "italic", "underline"],
                ],
            },
            theme: "snow", // or 'bubble'
            placeholder: Lang.get("js.shipping_delivery"),
        });

        shippingDeliveryQuill.on(
            "text-change",
            function (delta, oldDelta, source) {
                if (shippingDeliveryQuill.getText().trim().length === 0) {
                    shippingDeliveryQuill.setContents([{ insert: "" }]);
                }
            }
        );
        let element = document.createElement("textarea");
        element.innerHTML = $("#shippingDeliveryData").val();
        shippingDeliveryQuill.root.innerHTML = element.value;
    }
}


listenClick(".wp-template-terms-conditions-save", function (e) {
    e.preventDefault();

    let whatsappStore = $("#whatsappStoreId").val();
    let formData = new FormData();

    // Get content from Summernote editors and Quill editor
    let termConditionContent = '';
    let privacyPolicyContent = '';
    let refundCancellationContent = '';
    let shippingDeliveryContent = '';

    // Terms & Conditions (Summernote)
    if ($("#whatsappTermsConditionsDescription").length) {
        termConditionContent = $("#whatsappTermsConditionsDescription").summernote('code');
        if ($.trim(termConditionContent).length === 0) {
            displayErrorMessage(Lang.get("js.the_term_conditions"));
            return false;
        }
    }

    // Privacy Policy (Summernote)
    if ($("#whatsappPrivacyPolicyDescription").length) {
        privacyPolicyContent = $("#whatsappPrivacyPolicyDescription").summernote('code');
        if ($.trim(privacyPolicyContent).length === 0) {
            displayErrorMessage(Lang.get("js.the_privacy_policy"));
            return false;
        }
    }

    // Refund Cancellation (Summernote)
    if ($("#whatsappRefundCancellationDescription").length) {
        refundCancellationContent = $("#whatsappRefundCancellationDescription").summernote('code');
        if ($.trim(refundCancellationContent).length === 0) {
            displayErrorMessage(Lang.get("js.the_refund_cancellation"));
            return false;
        }
    }

    // Shipping Delivery (Quill - unchanged)
    if (window.shippingDeliveryQuill) {
        shippingDeliveryContent = shippingDeliveryQuill.root.innerHTML;
        if (shippingDeliveryQuill.getText().trim().length === 0) {
            displayErrorMessage(Lang.get("js.the_shipping_delivery"));
            return false;
        }
    }

    // Append data to FormData
    formData.append('term_condition_id', $("#termConditionId").val());
    formData.append('term_condition', termConditionContent);

    formData.append('privacy_policy_id', $("#privacyPolicyId").val());
    formData.append('privacy_policy', privacyPolicyContent);

    formData.append('refund_cancellation_id', $("#refundCancellationId").val());
    formData.append('refund_cancellation', refundCancellationContent);

    formData.append('shipping_delivery_id', $("#shippingDeliveryId").val());
    formData.append('shipping_delivery', shippingDeliveryContent);

    $.ajax({
        url: route("wp.terms.conditions.update", whatsappStore),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            displaySuccessMessage(response.message);
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
});

// AI Generation handlers for WhatsApp Store Terms & Conditions
listenClick("#generateAiWhatsappTermsConditions", function () {
    let whatsappStoreId = $("#whatsappStoreId").val();
    let description = $("#termsConditionsAiDescription").val().trim();
    let button = $(this);
    let originalText = button.html();

    if (!description) {
        displayErrorMessage(Lang.get("js.description_required"));
        $("#termsConditionsAiDescription").focus();
        return;
    }

    button.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> ');

    $.ajax({
        url: route("whatsapp.stores.generate.ai.terms.conditions", whatsappStoreId),
        type: "POST",
        data: { 
            whatsapp_store_id: whatsappStoreId,
            description: description 
        },
        timeout: 45000,
        success: function (response) {
            $("#whatsappTermsConditionsDescription").summernote('code', response.content);
            // displaySuccessMessage(response.message);
        },
        error: function (xhr) {
            if (xhr.statusText === 'timeout') {
                displayErrorMessage(Lang.get("js.request_timeout"));
            } else {
                displayErrorMessage(xhr.responseJSON?.message || Lang.get("js.something_went_wrong"));
            }
        },
        complete: function () {
            button.prop("disabled", false).html(originalText);
        }
    });
});

// AI Generation handlers for WhatsApp Store Privacy Policy
listenClick("#generateAiWhatsappPrivacyPolicy", function () {
    let whatsappStoreId = $("#whatsappStoreId").val();
    let description = $("#privacyPolicyAiDescription").val().trim();
    let button = $(this);
    let originalText = button.html();

    if (!description) {
        displayErrorMessage(Lang.get("js.description_required"));
        $("#privacyPolicyAiDescription").focus();
        return;
    }

    button.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> ');

    $.ajax({
        url: route("whatsapp.stores.generate.ai.privacy.policy", whatsappStoreId),
        type: "POST",
        data: { 
            whatsapp_store_id: whatsappStoreId,
            description: description 
        },
        timeout: 45000,
        success: function (response) {
            $("#whatsappPrivacyPolicyDescription").summernote('code', response.content);
            // displaySuccessMessage(response.message);
        },
        error: function (xhr) {
            if (xhr.statusText === 'timeout') {
                displayErrorMessage(Lang.get("js.request_timeout"));
            } else {
                displayErrorMessage(xhr.responseJSON?.message || Lang.get("js.something_went_wrong"));
            }
        },
        complete: function () {
            button.prop("disabled", false).html(originalText);
        }
    });
});

// AI Generation handlers for WhatsApp Store Refund & Cancellation Policy
listenClick("#generateAiWhatsappRefundCancellation", function () {
    let whatsappStoreId = $("#whatsappStoreId").val();
    let description = $("#refundCancellationAiDescription").val().trim();
    let button = $(this);
    let originalText = button.html();

    if (!description) {
        displayErrorMessage(Lang.get("js.description_required"));
        $("#refundCancellationAiDescription").focus();
        return;
    }

    button.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> ');

    $.ajax({
        url: route("whatsapp.stores.generate.ai.refund.cancellation", whatsappStoreId),
        type: "POST",
        data: { 
            whatsapp_store_id: whatsappStoreId,
            description: description 
        },
        timeout: 45000,
        success: function (response) {
            $("#whatsappRefundCancellationDescription").summernote('code', response.content);
            // displaySuccessMessage(response.message);
        },
        error: function (xhr) {
            if (xhr.statusText === 'timeout') {
                displayErrorMessage(Lang.get("js.request_timeout"));
            } else {
                displayErrorMessage(xhr.responseJSON?.message || Lang.get("js.something_went_wrong"));
            }
        },
        complete: function () {
            button.prop("disabled", false).html(originalText);
        }
    });
});

// AI Generation handlers for WhatsApp Store Shipping & Delivery Policy
listenClick("#generateAiWhatsappShippingDelivery", function () {
    let whatsappStoreId = $("#whatsappStoreId").val();
    let description = $("#shippingDeliveryAiDescription").val().trim();
    let button = $(this);
    let originalText = button.html();

    if (!description) {
        displayErrorMessage(Lang.get("js.description_required"));
        $("#shippingDeliveryAiDescription").focus();
        return;
    }

    button.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> ');

    $.ajax({
        url: route("whatsapp.stores.generate.ai.shipping.delivery", whatsappStoreId),
        type: "POST",
        data: { 
            whatsapp_store_id: whatsappStoreId,
            description: description 
        },
        timeout: 45000,
        success: function (response) {
            $("#whatsappShippingDeliveryDescription").summernote('code', response.content);
            // displaySuccessMessage(response.message);
        },
        error: function (xhr) {
            if (xhr.statusText === 'timeout') {
                displayErrorMessage(Lang.get("js.request_timeout"));
            } else {
                displayErrorMessage(xhr.responseJSON?.message || Lang.get("js.something_went_wrong"));
            }
        },
        complete: function () {
            button.prop("disabled", false).html(originalText);
        }
    });
});

// AI SEO Field Generation for WhatsApp Store
// Site Title
listenClick("#generateAiWpSiteTitle", function () {
    const whatsappStoreId = $("#whatsappStoreId").val();
    const spinner = $("#wpSiteTitleSpinner");
    const button = $("#generateAiWpSiteTitle");

    spinner.removeClass("d-none");
    button.prop("disabled", true);

    $.ajax({
        url: route("whatsapp.stores.generate.ai.site.title"),
        method: "POST",
        data: {
            whatsapp_store_id: whatsappStoreId,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                $("#wpSiteTitleInput").val(response.title);
                
            } else {
                displayErrorMessage(response.message);
            }
        },
        error: function (xhr) {
            const message = xhr.responseJSON?.message || Lang.get("js.something_went_wrong");
            displayErrorMessage(message);
        },
        complete: function () {
            spinner.addClass("d-none");
            button.prop("disabled", false);
        },
    });
});

// Home Title
listenClick("#generateAiWpHomeTitle", function () {
    const whatsappStoreId = $("#whatsappStoreId").val();
    const spinner = $("#wpHomeTitleSpinner");
    const button = $("#generateAiWpHomeTitle");

    spinner.removeClass("d-none");
    button.prop("disabled", true);

    $.ajax({
        url: route("whatsapp.stores.generate.ai.home.title"),
        method: "POST",
        data: {
            whatsapp_store_id: whatsappStoreId,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                $("#wpHomeTitleInput").val(response.title);
                
            } else {
                displayErrorMessage(response.message);
            }
        },
        error: function (xhr) {
            const message = xhr.responseJSON?.message || Lang.get("js.something_went_wrong");
            displayErrorMessage(message);
        },
        complete: function () {
            spinner.addClass("d-none");
            button.prop("disabled", false);
        },
    });
});

// Meta Keyword
listenClick("#generateAiWpMetaKeyword", function () {
    const whatsappStoreId = $("#whatsappStoreId").val();
    const spinner = $("#wpMetaKeywordSpinner");
    const button = $("#generateAiWpMetaKeyword");

    spinner.removeClass("d-none");
    button.prop("disabled", true);

    $.ajax({
        url: route("whatsapp.stores.generate.ai.meta.keyword"),
        method: "POST",
        data: {
            whatsapp_store_id: whatsappStoreId,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                $("#wpMetaKeywordInput").val(response.keywords);
                
            } else {
                displayErrorMessage(response.message);
            }
        },
        error: function (xhr) {
            const message = xhr.responseJSON?.message || Lang.get("js.something_went_wrong");
            displayErrorMessage(message);
        },
        complete: function () {
            spinner.addClass("d-none");
            button.prop("disabled", false);
        },
    });
});

// Meta Description
listenClick("#generateAiWpMetaDescription", function () {
    const whatsappStoreId = $("#whatsappStoreId").val();
    const spinner = $("#wpMetaDescriptionSpinner");
    const button = $("#generateAiWpMetaDescription");

    spinner.removeClass("d-none");
    button.prop("disabled", true);

    $.ajax({
        url: route("whatsapp.stores.generate.ai.meta.description"),
        method: "POST",
        data: {
            whatsapp_store_id: whatsappStoreId,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                $("#wpMetaDescriptionInput").val(response.description);
                
            } else {
                displayErrorMessage(response.message);
            }
        },
        error: function (xhr) {
            const message = xhr.responseJSON?.message || Lang.get("js.something_went_wrong");
            displayErrorMessage(message);
        },
        complete: function () {
            spinner.addClass("d-none");
            button.prop("disabled", false);
        },
    });
});
