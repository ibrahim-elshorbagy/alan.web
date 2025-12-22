document.addEventListener("DOMContentLoaded", loadEmailTemplateData);
let quillInstances = {};
let currentTemplateType = null;
let currentLanguageId = 1;

function loadEmailTemplateData() {
    Description();
    initializeLanguageTabs();
    initializePageState();
}

function Description() {
    if (!$('.email-template-content-editor').length) {
        return false;
    }
    function initializeQuill(selector) {
        return new Quill(selector, {
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
            placeholder: Lang.get("js.email_template_content"),
            theme: "snow",
        });
    }

    $(".email-template-content-editor").each(function () {
        let id = $(this).attr("id");
        quillInstances[id] = initializeQuill("#" + id);

        quillInstances[id].on("text-change", function (delta, oldDelta, source) {
            if (quillInstances[id].getText().trim().length === 0) {
                quillInstances[id].setContents([{ insert: "" }]);
            }
        });
    });
}

function initializeLanguageTabs() {
    // Handle language tab switching
    $('.language-tab-btn').on('click', function() {
        currentLanguageId = $(this).data('language-id');
        $('#selectedLanguageId').val(currentLanguageId);
        const languageName = $(this).data('language-name');
        $('#selectedLanguageName').text(languageName);

        // Update active tab
        $('.language-tab-btn').removeClass('active');
        $(this).addClass('active');

        loadTemplateContent();
    });

    // Initialize default language from settings
    if (window.languages && window.languages.length > 0) {
        if (window.defaultLanguage) {
            // Use the default language from settings
            currentLanguageId = window.defaultLanguage.id;
        } else {
            // Fallback to first language if no default found
            currentLanguageId = window.languages[0].id;
        }

        $('#selectedLanguageId').val(currentLanguageId);

        // Make sure the correct tab is active
        $('.language-tab-btn').removeClass('active');
        $(`.language-tab-btn[data-language-id="${currentLanguageId}"]`).addClass('active');
    }
}

function initializePageState() {
    // Check if a template type is already selected
    let selectedType = document.getElementById('EmailTemplateType').value;

    if (selectedType !== '' && selectedType !== null) {
        currentTemplateType = parseInt(selectedType);

        // Show language tabs container
        $('#languageTabsContainer').removeClass('d-none');

        // Load template content for current selection
        loadTemplateContent();

        // Show appropriate shortcodes
        updateShortcodes(currentTemplateType);
    }
}

function loadTemplateContent() {
    if (!window.emailTemplates || currentTemplateType === null || currentLanguageId === null) {
        console.log('Missing data:', {
            emailTemplates: !!window.emailTemplates,
            currentTemplateType: currentTemplateType,
            currentLanguageId: currentLanguageId
        });
        return;
    }

    // Access the nested grouped data properly
    let templateTypeGroup = window.emailTemplates[currentTemplateType];
    let templateData = null;

    if (templateTypeGroup) {
        // Check if the language exists in this template type group
        if (templateTypeGroup[currentLanguageId]) {
            // Get the first (and should be only) template for this type+language combination
            templateData = Array.isArray(templateTypeGroup[currentLanguageId])
                ? templateTypeGroup[currentLanguageId][0]
                : templateTypeGroup[currentLanguageId];
        }
    }


    if (templateData) {
        // Update subject field
        $(`#subject_${currentLanguageId}`).val(templateData.email_template_subject || '');

        // Update Quill content
        const editorId = `emailEditor_${currentLanguageId}`;
        if (quillInstances[editorId]) {
            const content = templateData.email_template_content || '';
            quillInstances[editorId].root.innerHTML = content;
        }

    } else {
        // Clear fields if no data
        $(`#subject_${currentLanguageId}`).val('');
        const editorId = `emailEditor_${currentLanguageId}`;
        if (quillInstances[editorId]) {
            quillInstances[editorId].root.innerHTML = '';
        }
    }
}

function updateShortcodes(templateType) {
    // Show/hide shortcodes
    $('.insert-shortcode').addClass('d-none');
    $('.insert-shortcode').each(function () {
        if ($(this).data('template-type') == templateType) {
            $(this).removeClass('d-none');
        }
    });
}

// Handle template type change
listenChange("#EmailTemplateType", function () {
    currentTemplateType = parseInt($(this).val());

    if (currentTemplateType >= 0) {
        $('#languageTabsContainer').removeClass('d-none');
        loadTemplateContent();
    } else {
        $('#languageTabsContainer').addClass('d-none');
        currentTemplateType = null;
    }

    updateShortcodes(currentTemplateType);
});

// Handle shortcode insertion
listenClick(".insert-shortcode", function () {
    const shortCode = this.getAttribute('data-content');
    const editorId = `emailEditor_${currentLanguageId}`;

    if (quillInstances[editorId]) {
        const quill = quillInstances[editorId];

        // Bring focus back to Quill editor
        quill.focus();

        // Now get the cursor position
        const range = quill.getSelection(true); // true = force get latest selection
        const index = range ? range.index : quill.getLength();
        quill.insertText(index, shortCode);
        quill.setSelection(index + shortCode.length);
    }
});

// Handle form submission
listenSubmit('#emailTemplateForm', function (e) {
    e.preventDefault();

    // Validate template type selection
    if (currentTemplateType === null || currentTemplateType < 0) {
        displayErrorMessage("Please select an email template type");
        return false;
    }

    // Get current active language data
    const activeSubject = $(`#subject_${currentLanguageId}`).val();
    const editorId = `emailEditor_${currentLanguageId}`;
    const activeContent = quillInstances[editorId] ? quillInstances[editorId].root.innerHTML : '';

    // Validate required fields
    if (!activeSubject.trim()) {
        displayErrorMessage(Lang.get("js.email_template_subject_required"));
        return false;
    }

    if (!activeContent.trim() || (quillInstances[editorId] && quillInstances[editorId].getText().trim().length === 0)) {
        displayErrorMessage(Lang.get("js.email_template_content_required"));
        return false;
    }

    // Set final values for form submission
    $('#finalSubject').val(activeSubject);
    $('#finalContent').val(activeContent);
    $('#selectedLanguageId').val(currentLanguageId);

    // Submit form
    $('#emailTemplateForm')[0].submit();
});
