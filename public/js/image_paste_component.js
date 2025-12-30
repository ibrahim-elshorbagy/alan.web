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
        // Clipboard button
        const clipboardButton = document.createElement('button');
        clipboardButton.type = 'button';
        clipboardButton.className = 'btn btn-outline-primary btn-sm my-2 position-relative';
        clipboardButton.innerHTML = '<i class="fas fa-paste"></i>';
        clipboardButton.onclick = () => this.readClipboard();

        // Create tooltip element
        const tooltip = document.createElement('div');
        tooltip.className = 'custom-tooltip';
        tooltip.textContent = 'لصق الصورة من الحافظة - انقر للصق الصورة الموجودة في الحافظة';
        tooltip.style.cssText = `
            position: absolute;
            background: #333;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(5px);
            margin-bottom: 5px;
            pointer-events: none;
        `;

        // Add arrow
        const arrow = document.createElement('div');
        arrow.style.cssText = `
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #333;
        `;
        tooltip.appendChild(arrow);

        // Add hover events
        clipboardButton.addEventListener('mouseenter', () => {
            tooltip.style.opacity = '1';
            tooltip.style.visibility = 'visible';
            tooltip.style.transform = 'translateX(-50%) translateY(0)';
        });

        clipboardButton.addEventListener('mouseleave', () => {
            tooltip.style.opacity = '0';
            tooltip.style.visibility = 'hidden';
            tooltip.style.transform = 'translateX(-50%) translateY(5px)';
        });

        // Create wrapper for positioning
        const wrapper = document.createElement('div');
        wrapper.className = 'position-relative d-inline-block';
        wrapper.appendChild(clipboardButton);
        wrapper.appendChild(tooltip);

        this.container.appendChild(wrapper);

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
            alert('الوصول إلى الحافظة يتطلب إذن المتصفح! قد لا يسمح متصفحك بهذه الميزة - يرجى التحقق من إعدادات المتصفح والأذونات.');
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
