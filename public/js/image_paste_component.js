/**
 * Image Paste Component
 * Button to select images + paste functionality + CLIPBOARD BUTTON
 */

//
//<div data-image-paste data-file-input-id="coverImg" data-preview-id="coverPreview"
// data-button-text="{{ __('messages.select_image') }}"
// data-clipboard-button-text="{{ __('messages.paste_from_clipboard') }}"
// data-paste-area-text="{{ __('messages.or_paste_image_here') }}"
// data-success-text="{{ __('messages.image_pasted_successfully') }}"
// data-invalid-type-text="{{ __('messages.invalid_image_type') }}"
// data-image-too-large-text="{{ __('messages.image_too_large') }}"
// data-no-image-text="{{ __('messages.no_image_in_clipboard') }}"></div>

class ImagePasteComponent {
    constructor(options) {
        this.options = {
            buttonText: options.buttonText || 'Select Image',
            clipboardButtonText: options.clipboardButtonText || 'Paste from Clipboard',
            pasteAreaText: options.pasteAreaText || 'Or paste image here (Ctrl+V)',
            successText: options.successText || 'Image pasted successfully!',
            invalidTypeText: options.invalidTypeText || 'Please paste a valid image file (PNG, JPG, JPEG, GIF, WebP)',
            imageTooLargeText: options.imageTooLargeText || 'Image file is too large. Please use an image smaller than 5MB.',
            noImageText: options.noImageText || 'No image found in clipboard',
            fileInputId: options.fileInputId,
            previewId: options.previewId,
            onImageSelected: options.onImageSelected || null,
            ...options
        };

        this.container = options.container;
        this.init();
    }

    init() {
        this.createUI();
        this.bindEvents();
    }

    createUI() {
        // Select button
        const selectButton = document.createElement('button');
        selectButton.type = 'button';
        selectButton.className = 'btn btn-outline-secondary btn-sm me-2';
        selectButton.innerHTML = '<i class="fas fa-image"></i> ' + this.options.buttonText;
        selectButton.onclick = () => this.selectImage();

        // Clipboard button
        const clipboardButton = document.createElement('button');
        clipboardButton.type = 'button';
        clipboardButton.className = 'btn btn-outline-primary btn-sm my-2';
        clipboardButton.innerHTML = '<i class="fas fa-clipboard"></i> ' + this.options.clipboardButtonText;
        clipboardButton.onclick = () => this.readClipboard();

        this.container.appendChild(selectButton);
        this.container.appendChild(clipboardButton);

        this.selectButton = selectButton;
        this.clipboardButton = clipboardButton;
    }

    bindEvents() {
        // Handle file input change event
        const fileInput = document.getElementById(this.options.fileInputId);
        if (fileInput) {
            fileInput.addEventListener('change', (e) => {
                this.handleFileSelect(e);
            });
        }
    }

    selectImage() {
        const fileInput = document.getElementById(this.options.fileInputId);
        if (fileInput) {
            fileInput.click();
        }
    }

    // NEW METHOD: Read from clipboard - ONLY WORKS ON HTTPS!
    async readClipboard() {
        try {
            // This ONLY works on HTTPS sites!
            const clipboardItems = await navigator.clipboard.read();

            for (const item of clipboardItems) {
                for (const type of item.types) {
                    if (type.startsWith('image/')) {
                        const blob = await item.getType(type);
                        this.processImage(blob);
                        return;
                    }
                }
            }

            alert(this.options.noImageText);

        } catch (error) {
            console.error('Clipboard error:', error);
            alert('CLIPBOARD REQUIRES HTTPS! Your site must use HTTPS (not HTTP) for automatic clipboard reading. Ask your developer to enable SSL/HTTPS.');
        }
    }

    handleFileSelect(e) {
        const files = e.target.files;
        if (files.length > 0) {
            this.processImage(files[0]);
        }
    }

    processImage(file) {
        if (!file) return;

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert(this.options.invalidTypeText);
            return;
        }

        // Validate file size (max 5MB)
        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            alert(this.options.imageTooLargeText);
            return;
        }

        // Create a data URL for preview
        const reader = new FileReader();
        reader.onload = (e) => {
            const dataUrl = e.target.result;

            // Update preview
            if (this.options.previewId) {
                const preview = document.getElementById(this.options.previewId);
                if (preview) {
                    preview.style.backgroundImage = `url('${dataUrl}')`;
                }
            }

            // Create a new file from the blob with proper name
            const newFile = new File([file], `pasted-image-${Date.now()}.${file.type.split('/')[1]}`, {
                type: file.type
            });

            // Set to file input
            const fileInput = document.getElementById(this.options.fileInputId);
            if (fileInput) {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(newFile);
                fileInput.files = dataTransfer.files;
            }

            // Show success message
            this.showSuccess();

            // Call callback if provided
            if (this.options.onImageSelected) {
                this.options.onImageSelected(newFile, dataUrl);
            }
        };
        reader.readAsDataURL(file);
    }

    showSuccess() {
        // Show success message briefly
        const successDiv = document.createElement('div');
        successDiv.className = 'alert alert-success alert-dismissible fade show mt-2';
        successDiv.innerHTML = '<i class="fas fa-check me-2"></i>' + this.options.successText;
        this.container.appendChild(successDiv);

        setTimeout(() => {
            successDiv.remove();
        }, 2000);
    }
}

// Initialize the component when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const pasteElements = document.querySelectorAll('[data-image-paste]');
    pasteElements.forEach(element => {
        const options = {
            fileInputId: element.dataset.fileInputId,
            previewId: element.dataset.previewId,
            buttonText: element.dataset.buttonText || 'Select Image',
            clipboardButtonText: element.dataset.clipboardButtonText || 'Paste from Clipboard',
            pasteAreaText: element.dataset.pasteAreaText || 'Or paste image here (Ctrl+V)',
            successText: element.dataset.successText,
            invalidTypeText: element.dataset.invalidTypeText,
            imageTooLargeText: element.dataset.imageTooLargeText,
            noImageText: element.dataset.noImageText,
            container: element
        };
        new ImagePasteComponent(options);
    });
});
