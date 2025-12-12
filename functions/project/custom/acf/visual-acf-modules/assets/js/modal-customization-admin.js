/**
 * Modal Customization Admin - Color Picker & Logo Upload
 * 
 * Technical Implementation:
 * - Real-time color preview with CSS backgroundColor updates
 * - Button state management based on value comparison
 * - File input validation and button enabling/disabling
 * - CSS class manipulation for visual feedback
 * 
 * @package Visual_ACF_Modules
 * @subpackage Admin_Interface
 */

document.addEventListener('DOMContentLoaded', function() {
    setupColorPicker();
    setupLogoUpload();
});

/**
 * Color picker with real-time preview and button state management
 * Compares current vs original values to enable/disable save/reset buttons
 */
function setupColorPicker() {
    const colorInput = document.getElementById('background-color-input');
    const colorPreview = document.getElementById('background-color-preview');
    const saveButton = document.querySelector('button[name="save_background_color"]');
    const resetButton = document.querySelector('button[name="reset_background_color"]');
    
    const defaultColor = '#fff';
    
    if (colorInput && colorPreview && saveButton && resetButton) {
        const originalColor = colorInput.value;
        
        updateButtonStates();
        
        /**
         * Real-time color preview update with error handling
         */
        colorInput.addEventListener('input', function() {
            try {
                colorPreview.style.backgroundColor = this.value;
                updateButtonStates();
            } catch (e) {
                console.error('Invalid color format:', e);
            }
        });
        
        /**
         * Button state logic:
         * Save: enabled when current != original
         * Reset: enabled when current != default AND original != default
         */
        function updateButtonStates() {
            if (colorInput.value === originalColor) {
                saveButton.disabled = true;
                saveButton.classList.add('button-disabled');
            } else {
                saveButton.disabled = false;
                saveButton.classList.remove('button-disabled');
            }
            
            if (colorInput.value === defaultColor || originalColor === defaultColor) {
                resetButton.disabled = true;
                resetButton.classList.add('button-disabled');
            } else {
                resetButton.disabled = false;
                resetButton.classList.remove('button-disabled');
            }
        }
    }
}

/**
 * Logo upload button state management
 * Enables upload button only when file is selected
 */
function setupLogoUpload() {
    const fileInput = document.getElementById('modal_logo');
    const uploadButton = document.getElementById('upload_logo_button');
    
    if (fileInput && uploadButton) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                uploadButton.disabled = false;
                uploadButton.classList.remove('button-disabled');
            } else {
                uploadButton.disabled = true;
                uploadButton.classList.add('button-disabled');
            }
        });
    }
}
