document.addEventListener('DOMContentLoaded', initializeImageCroppers);

class GlobalImageCropper {
    constructor(options = {}) {
        this.options = {
            selector: '.crop-image-input',
            aspectRatio: 16/9,
            modalId: 'globalCropModal',
            cropImageId: 'globalCropImage',
            applyCropId: 'globalApplyCrop',
            cancelCropId: 'globalCancelCrop',
            ...options
        };

        this.currentInput = null;
        this.currentPreview = null;
        this.cropper = null;
        this.originalFileName = '';

        this.init();
    }

    init() {
        this.createModal();
        this.bindEvents();
    }

    createModal() {
        if (document.getElementById(this.options.modalId)) {
            return;
        }

        const modalHTML = `
            <div class="modal fade" id="${this.options.modalId}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">${Lang.get("js.crop_image")}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="crop-container d-flex align-items-center justify-content-center">
                                <img id="${this.options.cropImageId}" style="max-width: 100%; max-height: 400px;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="${this.options.cancelCropId}" data-bs-dismiss="modal">${Lang.get("js.cancel")}</button>
                            <button type="button" class="btn btn-primary" id="${this.options.applyCropId}">${Lang.get("js.crop")}</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }

    bindEvents() {
        const self = this;

        document.addEventListener('change', function(e) {
            if (e.target.matches(self.options.selector)) {
                self.handleFileSelect(e);
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target.id === self.options.applyCropId) {
                self.applyCrop();
            }
        });

        const modal = document.getElementById(this.options.modalId);
        if (modal) {
            modal.addEventListener('shown.bs.modal', function() {
                self.initCropper();
            });

            modal.addEventListener('hidden.bs.modal', function() {
                self.destroyCropper();
            });
        }
    }

    handleFileSelect(event) {
        const files = event.target.files;
        if (files && files.length > 0) {
            const file = files[0];

            this.currentInput = event.target;
            this.originalFileName = file.name;
            this.findPreviewElement();

            // Get width and height from data attributes
            const customWidth = this.currentInput.getAttribute('data-crop-width');
            const customHeight = this.currentInput.getAttribute('data-crop-height');
            const customDimensions = this.currentInput.getAttribute('data-dimensions');
            const customRatio = this.currentInput.getAttribute('data-aspect-ratio');

            if (customWidth && customHeight) {
                // Use individual width/height attributes
                const width = parseInt(customWidth);
                const height = parseInt(customHeight);
                this.currentDimensions = { width, height };
                this.options.aspectRatio = width / height;
                this.options.fixedDimensions = { width, height };
            } else if (customDimensions) {
                // Use combined dimensions attribute (fallback)
                const [width, height] = customDimensions.split('x').map(d => parseInt(d));
                this.currentDimensions = { width, height };
                this.options.aspectRatio = width / height;
                this.options.fixedDimensions = { width, height };
            } else if (customRatio) {
                // Use aspect ratio only
                this.options.aspectRatio = parseFloat(customRatio);
                this.currentDimensions = null;
                this.options.fixedDimensions = null;
            }

            if (!file.type.match(/image.*/)) {
                displayErrorMessage(Lang.get("js.allowed_image"));
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                this.showCropModal(e.target.result);
            };
            reader.readAsDataURL(file);
        }
    }

    findPreviewElement() {
        const inputId = this.currentInput.id;
        const previewId = this.currentInput.getAttribute('data-preview-id');

        if (previewId) {
            this.currentPreview = document.getElementById(previewId);
        } else if (inputId) {
            const possibleIds = [
                inputId.replace('Img', 'Preview').replace('_img', 'Preview').replace('_image', 'Preview'),
                inputId + 'Preview',
                'profilePreview',
                'coverPreview',
                'exampleInputImage'
            ];

            for (const id of possibleIds) {
                const element = document.getElementById(id);
                if (element) {
                    this.currentPreview = element;
                    break;
                }
            }
        }

        if (!this.currentPreview) {
            const container = this.currentInput.closest('.image-picker, .images-picker, .form-group, .mb-3');
            if (container) {
                this.currentPreview = container.querySelector('.previewImage, .preview-image, .image');
            }
        }
    }

    showCropModal(imageSrc) {
        const cropImage = document.getElementById(this.options.cropImageId);
        const modal = document.getElementById(this.options.modalId);

        cropImage.src = imageSrc;

        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }

    initCropper() {
        const cropImage = document.getElementById(this.options.cropImageId);

        if (this.cropper) {
            $(cropImage).cropper('destroy');
        }

        $(cropImage).cropper({
            aspectRatio: this.options.aspectRatio,
            viewMode: 2,
            dragMode: 'crop',
            autoCropArea: 0.9,
            restore: false,
            guides: true,
            center: true,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
            background: false,
            modal: true,
            ready: () => {
                this.cropper = $(cropImage).data('cropper');
            }
        });
    }

    applyCrop() {
        if (this.cropper && this.currentInput) {
            const canvas = $(document.getElementById(this.options.cropImageId)).cropper('getCroppedCanvas', {
                width: 800,
                height: 450,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });

            const base64data = canvas.toDataURL('image/png', 0.9);

            if (this.currentPreview) {
                if (this.currentPreview.tagName === 'IMG') {
                    this.currentPreview.src = base64data;
                } else {
                    this.currentPreview.style.backgroundImage = `url(${base64data})`;
                }
            }

            const croppedFile = this.base64ToFile(base64data, this.originalFileName);
            const dt = new DataTransfer();
            dt.items.add(croppedFile);
            this.currentInput.files = dt.files;

            const modal = bootstrap.Modal.getInstance(document.getElementById(this.options.modalId));
            modal.hide();
        }
    }

    base64ToFile(base64String, filename) {
        const arr = base64String.split(',');
        const mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]);
        let n = bstr.length;
        const u8arr = new Uint8Array(n);

        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }

        return new File([u8arr], filename, { type: mime });
    }

    destroyCropper() {
        if (this.cropper) {
            $(document.getElementById(this.options.cropImageId)).cropper('destroy');
            this.cropper = null;
        }
        this.currentInput = null;
        this.currentPreview = null;
    }
}

function initializeImageCroppers() {
    // Cover image cropper (16:9 aspect ratio)
    window.coverImageCropper = new GlobalImageCropper({
        selector: '.crop-cover-input',
        aspectRatio: 16/9,
        modalId: 'coverCropModal',
        cropImageId: 'coverCropImage',
        applyCropId: 'coverApplyCrop',
        cancelCropId: 'coverCancelCrop'
    });

    // Profile image cropper (1:1 aspect ratio)
    window.profileImageCropper = new GlobalImageCropper({
        selector: '.crop-profile-input',
        aspectRatio: 1,
        modalId: 'profileCropModal',
        cropImageId: 'profileCropImage',
        applyCropId: 'profileApplyCrop',
        cancelCropId: 'profileCancelCrop'
    });

    // General image cropper (configurable aspect ratio)
    window.generalImageCropper = new GlobalImageCropper({
        selector: '.crop-image-input',
        aspectRatio: 16/9,
        modalId: 'generalCropModal',
        cropImageId: 'generalCropImage',
        applyCropId: 'generalApplyCrop',
        cancelCropId: 'generalCancelCrop'
    });
}
