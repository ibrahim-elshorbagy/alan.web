// Add NFC
listenClick("#superadminguideNfc", function () {
    $("#superadminguideNfcModal").modal("show");
});

listenClick("#adminguideNfc", function () {
    $("#adminguideNfcModal").modal("show");
});

listenClick("#newNfc", function () {
    $("#addNfcModal").modal("show");
    resetModalForm("#addNfcForm");
    toggleCoordinateFields("#applyCoordinates", "#coordinatesFields");
    toggleDimensionFields("#printFormat", "#dimensionFields");
    initQrPreview(); // Initialize QR preview for create modal
});

listenHiddenBsModal("#addNfcModal", function () {
    resetModalForm("#addNfcForm");
});

// Toggle coordinate fields when checkbox is clicked
listen("change", "#applyCoordinates", function () {
    toggleCoordinateFields("#applyCoordinates", "#coordinatesFields");
});

listen("change", "#editApplyCoordinates", function () {
    toggleCoordinateFields("#editApplyCoordinates", "#editCoordinatesFields");
});

// Toggle dimension fields when print format is changed
listen("change", "#printFormat", function () {
    toggleDimensionFields("#printFormat", "#dimensionFields");
});

listen("change", "#editPrintFormat", function () {
    toggleDimensionFields("#editPrintFormat", "#editDimensionFields");
});

function toggleCoordinateFields(checkboxId, fieldsId) {
    if ($(checkboxId).is(":checked")) {
        $(fieldsId).show();
    } else {
        $(fieldsId).hide();
    }
}

function toggleDimensionFields(selectId, fieldsId) {
    if ($(selectId).val() === "a5") {
        $(fieldsId).hide();
    } else {
        $(fieldsId).show();
    }
}

listenSubmit("#addNfcForm", function (e) {
    e.preventDefault();
    $.ajax({
        url: route("nfc.store"),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#addNfcModal").modal("hide");
                Livewire.dispatch("refresh");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

listenHiddenBsModal("#addNfcModal", function () {
    $("#addNfcForm")[0].reset();
    let defaultGalleryUrl = $("#defaultNfcImgUrl").val();
    $("#nfcPreview").css("background-image", "url(" + defaultGalleryUrl + ")");
});

// Delete NFC Type

listenClick(".nfc-delete-btn", function (event) {
    let recordId = $(event.currentTarget).data("id");
    deleteItem(route("nfc.delete", recordId), Lang.get("js.nfc_card"));
});

// Export Test Images

listenClick(".nfc-export-test-btn", function (event) {
    let nfcId = $(event.currentTarget).data("id");
    window.location.href = route("nfc.export.test", nfcId);
});

// Edit NFC Type

listenClick(".nfc-view-btn", function (event) {
    let nfcId = $(event.currentTarget).data("id");

    nfcRenderDataShow(nfcId);
});

function nfcRenderDataShow(id) {
    $.ajax({
        url: route("nfc.edit", { id: id }),
        type: "GET",
        success: function (result) {
            if (result.success) {
                $("#nfcId").val(result.data.id);
                $("#editNfcTitle").val(result.data.name);
                $("#editNfcDescription").val(result.data.description);
                $("#editNfcPrice").val(result.data.price);
                $("#editNfcSalesPrice").val(result.data.sales_price);

                // Set coordinate fields
                $("#editApplyCoordinates").prop("checked", result.data.apply_coordinates == 1);
                $("#editQrXPosition").val(result.data.qr_x_position);
                $("#editQrYPosition").val(result.data.qr_y_position);
                $("#editQrSize").val(result.data.qr_size);
                $("#editQrPositionSide").val(result.data.qr_position_side || 'front');

                // Set image dimensions
                $("#editImageWidth").val(result.data.image_width);
                $("#editImageHeight").val(result.data.image_height);

                // Set print settings
                $("#editPrintFormat").val(result.data.print_format || 'fixed');
                $("#editTextFontSize").val(result.data.text_font_size || 14);
                $("#editPrintFrontImage").prop("checked", result.data.print_front_image == 1);
                $("#editPrintBackImage").prop("checked", result.data.print_back_image == 1);
                $("#editPrintOnlyQr").prop("checked", result.data.print_only_qr == 1);

                // Toggle coordinate fields visibility
                toggleCoordinateFields("#editApplyCoordinates", "#editCoordinatesFields");

                // Toggle dimension fields visibility
                toggleDimensionFields("#editPrintFormat", "#editDimensionFields");

                $("#editNfcPreview").css(
                    "background-image",
                    'url("' + result.data.nfc_image + '")'
                );
                $("#editNfcBackPreview").css(
                    "background-image",
                    'url("' + result.data.nfc_back_image + '")'
                );
                $("<img>").attr("src", result.data.nfc_image).on("error", function () {
                    $("#editNfcPreview").css(
                        "background-image",
                        'url("' + defaultNfcCard + '")'
                    );
                });

                $("<img>").attr("src", result.data.nfc_back_image).on("error", function () {
                    $("#editNfcBackPreview").css(
                        "background-image",
                        'url("' + defaultNfcCard + '")'
                    );
                });
                $("#editNfcModal").modal("show");
                initQrPreviewEdit(); // Initialize QR preview for edit modal
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
}

listenSubmit("#editNfcForm", function (event) {
    event.preventDefault();
    let nfcId = $("#nfcId").val();
    $.ajax({
        url: route("nfc.update", nfcId),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#editNfcModal").modal("hide");
                Livewire.dispatch("refresh");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

listenSubmit("#addNfcTaxForm", function (e) {
    e.preventDefault();
    $.ajax({
        url: route("nfc.tax"),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#addNfcTaxModal").modal("hide");
                Livewire.dispatch("refresh");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

listenClick("#newNfcTax", function () {
    $.ajax({
        url: route("nfc.tax.get"),
        type: "GET",
        success: function (response) {
            $('#nfcCardTax').val(response.tax);
            $('#nfcTaxStatus').prop('checked', response.status ?? false);

            $('#addNfcTaxModal').modal("show");
        },
        error: function () {
            displayErrorMessage(result.responseJSON.message);
        }
    });
});

// ==================== QR CODE LIVE PREVIEW FUNCTIONALITY ====================

// Global variables for QR preview
let qrPreviewState = {
    frontImage: null,
    backImage: null,
    currentSide: 'front'
};

let qrPreviewStateEdit = {
    frontImage: null,
    backImage: null,
    currentSide: 'front'
};

// Initialize QR preview for CREATE modal
function initQrPreview() {
    qrPreviewState = {
        frontImage: null,
        backImage: null,
        currentSide: 'front'
    };

    // Listen to front image upload
    $('#nfc_img').off('change').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    qrPreviewState.frontImage = img;
                    updateQrPreview();
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Listen to back image upload
    $('#nfc_back_img').off('change').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    qrPreviewState.backImage = img;
                    updateQrPreview();
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Listen to QR position inputs
    $('.qr-position-input').off('input change').on('input change', function() {
        updateQrPreview();
    });
}

// Update QR preview canvas for CREATE modal
function updateQrPreview() {
    const canvas = document.getElementById('qrPreviewCanvas');
    const placeholder = document.getElementById('qrPreviewPlaceholder');

    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const side = $('#qrPositionSide').val() || 'front';
    qrPreviewState.currentSide = side;

    const currentImage = side === 'front' ? qrPreviewState.frontImage : qrPreviewState.backImage;

    if (!currentImage) {
        canvas.style.display = 'none';
        placeholder.style.display = 'block';
        return;
    }

    canvas.style.display = 'block';
    placeholder.style.display = 'none';

    // Set canvas size to match image
    canvas.width = currentImage.width;
    canvas.height = currentImage.height;

    // Draw the base image
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.drawImage(currentImage, 0, 0);

    // Get QR position and size
    const qrX = parseInt($('#qrXPosition').val()) || 0;
    const qrY = parseInt($('#qrYPosition').val()) || 0;
    const qrSize = parseInt($('#qrSize').val()) || 100;

    // Draw QR placeholder with semi-transparent overlay
    ctx.fillStyle = 'rgba(0, 123, 255, 0.3)';
    ctx.fillRect(qrX, qrY, qrSize, qrSize);

    // Draw QR border
    ctx.strokeStyle = '#007bff';
    ctx.lineWidth = 3;
    ctx.strokeRect(qrX, qrY, qrSize, qrSize);

    // Draw crosshair in center
    ctx.strokeStyle = '#ff0000';
    ctx.lineWidth = 2;
    const centerX = qrX + qrSize / 2;
    const centerY = qrY + qrSize / 2;
    const crossSize = 10;

    // Horizontal line
    ctx.beginPath();
    ctx.moveTo(centerX - crossSize, centerY);
    ctx.lineTo(centerX + crossSize, centerY);
    ctx.stroke();

    // Vertical line
    ctx.beginPath();
    ctx.moveTo(centerX, centerY - crossSize);
    ctx.lineTo(centerX, centerY + crossSize);
    ctx.stroke();

    // Draw corner markers
    const markerSize = 8;
    ctx.fillStyle = '#ff0000';

    // Top-left
    ctx.fillRect(qrX - 2, qrY - 2, markerSize, markerSize);
    // Top-right
    ctx.fillRect(qrX + qrSize - markerSize + 2, qrY - 2, markerSize, markerSize);
    // Bottom-left
    ctx.fillRect(qrX - 2, qrY + qrSize - markerSize + 2, markerSize, markerSize);
    // Bottom-right
    ctx.fillRect(qrX + qrSize - markerSize + 2, qrY + qrSize - markerSize + 2, markerSize, markerSize);

    // Get font size from input
    const fontSize = parseInt($('#textFontSize').val()) || 14;

    // Add Code and Serial No text below QR box, starting from QR box left edge
    ctx.fillStyle = '#000000';
    ctx.font = `${fontSize}px Arial`;
    ctx.textAlign = 'left';
    ctx.textBaseline = 'top';
    let textY = qrY + qrSize + 10;

    // Draw "Code: Test123" - positioned at QR box X coordinate
    ctx.fillText('Code: Test123', qrX, textY);

    // Draw "Serial No: 00001" on next line
    textY += fontSize + 5;
    ctx.fillText('Serial No: 00001', qrX, textY);
}

// Initialize QR preview for EDIT modal
function initQrPreviewEdit() {
    qrPreviewStateEdit = {
        frontImage: null,
        backImage: null,
        currentSide: 'front'
    };

    // Load existing images
    const frontImageUrl = $('#editNfcPreview').css('background-image');
    const backImageUrl = $('#editNfcBackPreview').css('background-image');

    if (frontImageUrl && frontImageUrl !== 'none') {
        const url = frontImageUrl.replace(/^url\(['"]?/, '').replace(/['"]?\)$/, '');
        loadImageForEdit(url, 'front');
    }

    if (backImageUrl && backImageUrl !== 'none') {
        const url = backImageUrl.replace(/^url\(['"]?/, '').replace(/['"]?\)$/, '');
        loadImageForEdit(url, 'back');
    }

    // Listen to front image upload
    $('#editNfcImg').off('change').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    qrPreviewStateEdit.frontImage = img;
                    updateQrPreviewEdit();
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Listen to back image upload
    $('#editNfcBackImg').off('change').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    qrPreviewStateEdit.backImage = img;
                    updateQrPreviewEdit();
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Listen to QR position inputs
    $('.qr-position-input-edit').off('input change').on('input change', function() {
        updateQrPreviewEdit();
    });

    // Initial preview update
    setTimeout(updateQrPreviewEdit, 100);
}

// Helper function to load image for edit
function loadImageForEdit(url, side) {
    const img = new Image();
    img.crossOrigin = 'Anonymous';
    img.onload = function() {
        if (side === 'front') {
            qrPreviewStateEdit.frontImage = img;
        } else {
            qrPreviewStateEdit.backImage = img;
        }
        updateQrPreviewEdit();
    };
    img.onerror = function() {
        console.log('Error loading image for preview:', url);
    };
    img.src = url;
}

// Update QR preview canvas for EDIT modal
function updateQrPreviewEdit() {
    const canvas = document.getElementById('editQrPreviewCanvas');
    const placeholder = document.getElementById('editQrPreviewPlaceholder');

    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const side = $('#editQrPositionSide').val() || 'front';
    qrPreviewStateEdit.currentSide = side;

    const currentImage = side === 'front' ? qrPreviewStateEdit.frontImage : qrPreviewStateEdit.backImage;

    if (!currentImage) {
        canvas.style.display = 'none';
        placeholder.style.display = 'block';
        return;
    }

    canvas.style.display = 'block';
    placeholder.style.display = 'none';

    // Set canvas size to match image
    canvas.width = currentImage.width;
    canvas.height = currentImage.height;

    // Draw the base image
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.drawImage(currentImage, 0, 0);

    // Get QR position and size
    const qrX = parseInt($('#editQrXPosition').val()) || 0;
    const qrY = parseInt($('#editQrYPosition').val()) || 0;
    const qrSize = parseInt($('#editQrSize').val()) || 100;

    // Draw QR placeholder with semi-transparent overlay
    ctx.fillStyle = 'rgba(0, 123, 255, 0.3)';
    ctx.fillRect(qrX, qrY, qrSize, qrSize);

    // Draw QR border
    ctx.strokeStyle = '#007bff';
    ctx.lineWidth = 3;
    ctx.strokeRect(qrX, qrY, qrSize, qrSize);

    // Draw crosshair in center
    ctx.strokeStyle = '#ff0000';
    ctx.lineWidth = 2;
    const centerX = qrX + qrSize / 2;
    const centerY = qrY + qrSize / 2;
    const crossSize = 10;

    // Horizontal line
    ctx.beginPath();
    ctx.moveTo(centerX - crossSize, centerY);
    ctx.lineTo(centerX + crossSize, centerY);
    ctx.stroke();

    // Vertical line
    ctx.beginPath();
    ctx.moveTo(centerX, centerY - crossSize);
    ctx.lineTo(centerX, centerY + crossSize);
    ctx.stroke();

    // Draw corner markers
    const markerSize = 8;
    ctx.fillStyle = '#ff0000';

    // Top-left
    ctx.fillRect(qrX - 2, qrY - 2, markerSize, markerSize);
    // Top-right
    ctx.fillRect(qrX + qrSize - markerSize + 2, qrY - 2, markerSize, markerSize);
    // Bottom-left
    ctx.fillRect(qrX - 2, qrY + qrSize - markerSize + 2, markerSize, markerSize);
    // Bottom-right
    ctx.fillRect(qrX + qrSize - markerSize + 2, qrY + qrSize - markerSize + 2, markerSize, markerSize);

    // Get font size from input
    const fontSize = parseInt($('#editTextFontSize').val()) || 14;

    // Add Code and Serial No text below QR box, starting from QR box left edge
    ctx.fillStyle = '#000000';
    ctx.font = `${fontSize}px Arial`;
    ctx.textAlign = 'left';
    ctx.textBaseline = 'top';
    let textY = qrY + qrSize + 10;

    // Draw "Code: Test123" - positioned at QR box X coordinate
    ctx.fillText('Code: Test123', qrX, textY);

    // Draw "Serial No: 00001" on next line
    textY += fontSize + 5;
    ctx.fillText('Serial No: 00001', qrX, textY);
}
