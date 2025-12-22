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
    if ($("#privacyPolicyQuill").length) {
        window.quillPrivacyPolicy = new Quill("#privacyPolicyQuill", {
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
            placeholder: Lang.get("js.privacy_policy"),
        });

        quillPrivacyPolicy.on(
            "text-change",
            function (delta, oldDelta, source) {
                if (quillPrivacyPolicy.getText().trim().length === 0) {
                    quillPrivacyPolicy.setContents([{ insert: "" }]);
                }
            }
        );
        let element = document.createElement("textarea");
        element.innerHTML = $("#privacyData").val();
        quillPrivacyPolicy.root.innerHTML = element.value;
    }

    if ($("#termConditionQuill").length) {
        window.termConditionQuill = new Quill("#termConditionQuill", {
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
            placeholder: Lang.get("js.term_condition").replace(/&amp;/g, "&"),
            theme: "snow", // or 'bubble'
        });

        termConditionQuill.on(
            "text-change",
            function (delta, oldDelta, source) {
                if (termConditionQuill.getText().trim().length === 0) {
                    termConditionQuill.setContents([{ insert: "" }]);
                }
            }
        );
        let element = document.createElement("textarea");
        element.innerHTML = $("#conditionData").val();
        termConditionQuill.root.innerHTML = element.value;
    }

        if ($("#refundCancellationQuill").length) {
        window.refundCancellationQuill = new Quill("#refundCancellationQuill", {
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
            placeholder: Lang.get("js.refund_cancellation"),
        });

        refundCancellationQuill.on(
            "text-change",
            function (delta, oldDelta, source) {
                if (refundCancellationQuill.getText().trim().length === 0) {
                    refundCancellationQuill.setContents([{ insert: "" }]);
                }
            }
        );
        let element = document.createElement("textarea");
        element.innerHTML = $("#refundCancellationData").val();
        refundCancellationQuill.root.innerHTML = element.value;
    }


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

    // Get content from all Quill editors
    let termConditionContent = '';
    let privacyPolicyContent = '';
    let refundCancellationContent = '';
    let shippingDeliveryContent = '';

    // Terms & Conditions
    if (window.termConditionQuill) {
        termConditionContent = termConditionQuill.root.innerHTML;
        if (termConditionQuill.getText().trim().length === 0) {
            displayErrorMessage(Lang.get("js.the_term_conditions"));
            return false;
        }
    }

    // Privacy Policy
    if (window.quillPrivacyPolicy) {
        privacyPolicyContent = quillPrivacyPolicy.root.innerHTML;
        if (quillPrivacyPolicy.getText().trim().length === 0) {
            displayErrorMessage(Lang.get("js.the_privacy_policy"));
            return false;
        }
    }

    // Refund Cancellation
    if (window.refundCancellationQuill) {
        refundCancellationContent = refundCancellationQuill.root.innerHTML;
        if (refundCancellationQuill.getText().trim().length === 0) {
            displayErrorMessage(Lang.get("js.the_refund_cancellation"));
            return false;
        }
    }

    // Shipping Delivery
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
