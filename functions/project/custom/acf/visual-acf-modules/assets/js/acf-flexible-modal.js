/**
 * ACF Flexible Content Modal Handler
 * 
 * Technical Implementation:
 * - Event interception of ACF "Add Layout" buttons
 * - MutationObserver for DOM changes during layout selection
 * - CSS injection to hide default ACF popup
 * - Field type detection via dataset analysis
 * - Modal lifecycle management with cleanup
 * 
 * @package Visual_ACF_Modules
 * @subpackage Frontend_Interface
 */

document.addEventListener('DOMContentLoaded', () => {
    // Application state variables
    let currentButton = null;        // ACF button reference
    let previewImages = {};          // Image cache: {slug: url}
    let brandingLogo = null;         // Logo URL
    let modalBackground = '#fff';    // Background color
    let isSelectingLayout = false;   // Selection state flag

    // Asset preloading
    ACFApiService.getPreviewImages()
        .then(images => {
            previewImages = images;
        })
        .catch(error => console.error('Failed to load preview images:', error));

    ACFApiService.getBrandingLogo()
        .then(logoUrl => {
            brandingLogo = logoUrl;
        })
        .catch(error => console.error('Failed to load branding logo:', error));
        
    ACFApiService.getModalBackground()
        .then(color => {
            modalBackground = color;
        })
        .catch(error => console.error('Failed to load modal background color:', error));

    /**
     * Field type detection: 'modules' or 'heros'
     * Checks field.dataset.name, button text, field.dataset.key for 'hero' keyword
     */
    const getFieldType = (button, field) => {
        if (!field) return 'modules';
        
        const name = field.dataset.name || '';
        const type = button.textContent.toLowerCase() || '';
        const key = field.dataset.key || '';
        
        if (name.includes('hero') || type.includes('hero') || key.includes('hero')) return 'heros';
        
        return 'modules';
    };

    /**
     * Extract layouts from ACF popup
     * Returns array: [{name: 'slug', label: 'Display Name'}]
     */
    const extractLayouts = (popup) => {
        const layouts = [];
        popup.querySelectorAll('a[data-layout]').forEach(link => {
            const name = link.dataset.layout;
            const label = link.textContent.trim();
            if (name && label) layouts.push({ name, label });
        });
        return layouts;
    };

    const showLoading = async (title = 'Loading...') => {
        try {
            const html = await ACFApiService.getModalTemplate('loading', { title });
            document.body.insertAdjacentHTML('beforeend', html);
        } catch (error) {
            console.error('Failed to show loading modal:', error);
        }
    };

    const hideLoading = () => {
        document.querySelector('.acf-loading-modal')?.remove();
    };

    const showError = async (title = 'Error', message = 'An error occurred') => {
        try {
            const html = await ACFApiService.getModalTemplate('error', { title, message });
            document.body.insertAdjacentHTML('beforeend', html);
            const modal = document.querySelector('.acf-error-modal');
            
            const closeModal = () => modal.remove();
            modal.querySelector('.acf-error-modal-close').addEventListener('click', closeModal);
            modal.addEventListener('click', e => {
                if (e.target === modal) closeModal();
            });
        } catch (error) {
            console.error('Failed to show error modal:', error);
        }
    };

    const closeModal = () => {
        document.querySelector('.acf-modal-overlay')?.remove();
        
        // Also hide any ACF popup that might be visible
        const acfPopup = document.querySelector('.acf-fc-popup');
        if (acfPopup) acfPopup.style.display = 'none';
    };

    const showModal = async (button) => {
        // Store the button for later use
        currentButton = button;
        
        // No necesitamos este log
        
        const field = button.closest('.acf-flexible-content');
        const popup = document.querySelector('.acf-fc-popup');
        const layouts = extractLayouts(popup);
        
        if (layouts.length === 0) {
            await showError('Error', 'No layouts found');
            return;
        }
        
        // Get essential field information (name, key, id)
        let fieldId = field.dataset.id || field.id || '';
        let fieldName = field.dataset.name || '';
        let fieldKey = field.dataset.key || '';
        
        // If not found in the flexible content field, try the parent acf-field
        const acfField = field.closest('.acf-field');
        if (acfField) {
            fieldId = fieldId || acfField.dataset.id || acfField.id || '';
            fieldName = fieldName || acfField.dataset.name || '';
            fieldKey = fieldKey || acfField.dataset.key || '';
        }
        
        // Get existing layouts/sections in the page
        const existingLayouts = field.querySelectorAll('.layout');
        const currentSections = [];
        
        existingLayouts.forEach(layout => {
            const layoutType = layout.dataset.layout || '';
            const layoutId = layout.dataset.id || '';
            
            currentSections.push({
                type: layoutType,
                id: layoutId
            });
        });
        
        // Determine field type from button text and field attributes
        const fieldType = getFieldType(button, field);
        
        // Log essential field information (sin key)
        console.log('Field Information:', {
            id: fieldId,
            name: fieldName,
            type: fieldType
        });
        
        await showLoading('Loading modules...');
        
        try {
            const html = await ACFApiService.post('get_modal_template', {
                field_type: fieldType,
                layouts: JSON.stringify(layouts),
                preview_images: JSON.stringify(previewImages)
            }).then(data => data.html);
            
            hideLoading();
            document.body.insertAdjacentHTML('beforeend', html);
            
            const modal = document.querySelector('.acf-modal-overlay');
            const searchInput = modal.querySelector('.acf-modal-search-input');
            
            // Set logo if available
            if (brandingLogo) {
                const logoImg = modal.querySelector('.acf-modal-logo');
                if (logoImg) {
                    logoImg.src = brandingLogo;
                    logoImg.style.display = 'block';
                }
            }
            
            // Set background color for the modal container
            if (modalBackground) {
                const modalContainer = modal.querySelector('.acf-modal-container');
                if (modalContainer) {
                    modalContainer.style.background = modalBackground;
                }
            }
            
            // Close button
            modal.querySelector('.acf-modal-close').addEventListener('click', () => closeModal());
            
            // Click outside
            modal.addEventListener('click', e => {
                if (e.target === modal) closeModal();
            });
            
            // Search
            searchInput.addEventListener('input', () => {
                const term = searchInput.value.toLowerCase();
                modal.querySelectorAll('.acf-modal-card').forEach(card => {
                    const title = card.querySelector('.acf-modal-card-title').textContent.toLowerCase();
                    const layout = card.dataset.layout.toLowerCase();
                    card.style.display = title.includes(term) || layout.includes(term) ? '' : 'none';
                });
            });
            
            // Card clicks
            modal.querySelector('.acf-modal-grid').addEventListener('click', e => {
                const card = e.target.closest('.acf-modal-card');
                const infoButton = e.target.closest('.acf-modal-card-info');
                
                if (!card) return;
                
                if (infoButton) {
                    e.preventDefault();
                    e.stopPropagation();
                    showModuleUsage(infoButton.dataset.layout);
                } else if (!e.target.closest('.acf-modal-card-info')) {
                    selectLayout(card.dataset.layout);
                }
            });
            
            // Keyboard
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') closeModal();
            });
            
            searchInput.focus();
            
        } catch (error) {
            hideLoading();
            console.error('Failed to show modal:', error);
            await showError('Error', 'Failed to load modules');
        }
    };

    const selectLayout = (layoutName) => {
        // Clean up modals
        closeModal();
        
        // Trigger original button again to get fresh ACF popup
        if (currentButton) {
            // Set flag to prevent modal from opening
            isSelectingLayout = true;
            
            // Reset any ACF popup css override
            const style = document.getElementById('acf-modal-override-styles');
            if (style) style.remove();
            
            // Create a MutationObserver to watch for the popup being added to DOM
            const observer = new MutationObserver((mutations) => {
                for (const mutation of mutations) {
                    if (mutation.type === 'childList' && mutation.addedNodes.length) {
                        for (const node of mutation.addedNodes) {
                            if (node.classList && node.classList.contains('acf-fc-popup')) {
                                // We found the popup
                                const link = node.querySelector(`a[data-layout="${layoutName}"]`);
                                if (link) {
                                    link.click();
                                }
                                
                                // Cleanup
                                observer.disconnect();
                                clearTimeout(safetyTimeout);
                                
                                // Restore the override style and reset flag
                                requestAnimationFrame(() => {
                                    setupStyles();
                                    isSelectingLayout = false;
                                });
                                
                                return;
                            }
                        }
                    }
                }
            });
            
            // Start observing the document body for the popup
            observer.observe(document.body, { childList: true, subtree: true });
            
            // Click the button to get fresh popup
            currentButton.click();
            
            // Set a safety timeout to reset the flag in case something goes wrong
            const safetyTimeout = setTimeout(() => {
                observer.disconnect();
                setupStyles();
                isSelectingLayout = false;
            }, 1000);
        }
    };

    const showModuleUsage = async (layoutName) => {
        // Hide our modal
        const modal = document.querySelector('.acf-modal-overlay');
        modal.style.display = 'none';
        
        // Get the field information from the current button
        const field = currentButton ? currentButton.closest('.acf-flexible-content') : null;
        let fieldInfo = {};
        
        if (field) {
            // Get essential field information (name, key, id)
            let fieldId = field.dataset.id || field.id || '';
            let fieldName = field.dataset.name || '';
            let fieldKey = field.dataset.key || '';
            
            // If not found in the flexible content field, try the parent acf-field
            const acfField = field.closest('.acf-field');
            if (acfField) {
                fieldId = fieldId || acfField.dataset.id || acfField.id || '';
                fieldName = fieldName || acfField.dataset.name || '';
                fieldKey = fieldKey || acfField.dataset.key || '';
            }
            
            // Get existing layouts/sections in the page
            const existingLayouts = field.querySelectorAll('.layout');
            const currentSections = [];
            
            existingLayouts.forEach(layout => {
                const layoutType = layout.dataset.layout || '';
                const layoutId = layout.dataset.id || '';
                const layoutTitle = layout.querySelector('.acf-fc-layout-handle')?.textContent.trim() || '';
                
                currentSections.push({
                    type: layoutType,
                    id: layoutId,
                    title: layoutTitle
                });
            });
            
            fieldInfo = {
                id: fieldId,
                name: fieldName,
                key: fieldKey,
                currentSections: currentSections
            };
            
            console.log('Field Information in usage modal:', fieldInfo);
        }
        
        // Determine field type based on name and key
        const fieldType = (fieldInfo.name?.toLowerCase().includes('hero') || fieldInfo.key?.toLowerCase().includes('hero')) ? 'heros' : 'modules';
        
        // Debug logging
        console.log('Determined field type:', fieldType);
        
        await showLoading('Loading usage information...');
        
        try {
            // Fetch usage data
            const usageData = await ACFApiService.getModuleUsage(layoutName, fieldType);
            
            // Fetch module description
            const descData = await ACFApiService.getModuleDescription(layoutName);
            
            // Debug logging for module description
            console.log('Module description data:', {
                hasDescription: descData.description ? true : false
            });
            
            const description = descData.description || '';
            const layoutLabel = document.querySelector(`.acf-modal-card[data-layout="${layoutName}"] .acf-modal-card-title`).textContent;
            
            // Get usage modal template
            const html = await ACFApiService.getUsageModalTemplate({
                layout_name: layoutName,
                layout_label: layoutLabel,
                field_type: fieldType,
                usage_data: JSON.stringify(usageData),
                description: description
            });
            
            hideLoading();
            document.body.insertAdjacentHTML('beforeend', html);
            
            const usageModal = document.querySelector('.acf-usage-modal');
            
            // Set logo if available
            if (brandingLogo) {
                const logoImg = usageModal.querySelector('.acf-usage-modal-logo');
                if (logoImg) {
                    logoImg.src = brandingLogo;
                    logoImg.style.display = 'block';
                }
            }
            
            // Set background color for the modal container
            if (modalBackground) {
                const modalContainer = usageModal.querySelector('.acf-usage-modal-content');
                if (modalContainer) {
                    modalContainer.style.background = modalBackground;
                }
            }
            
            // Close button
            usageModal.querySelector('.acf-usage-modal-close').addEventListener('click', () => closeUsageModal());
            
            // Click outside
            usageModal.addEventListener('click', e => {
                if (e.target === usageModal) closeUsageModal();
            });
            
            // Action buttons
            usageModal.querySelectorAll('.acf-usage-actions .button').forEach(button => {
                button.addEventListener('click', e => {
                    e.preventDefault();
                    e.stopPropagation();
                    window.open(button.href, '_blank');
                });
            });
            
            // Description links (Module Documentation, etc.)
            usageModal.querySelectorAll('.acf-usage-description a').forEach(link => {
                link.addEventListener('click', e => {
                    e.stopPropagation(); // Prevent modal close event
                    // Let the link work normally (target="_blank" will open in new tab)
                });
            });
            
            // Filtrado por tipo
            usageModal.querySelectorAll('.acf-filter-pill').forEach(pill => {
                pill.addEventListener('click', e => {
                    // Actualizar estado de pills
                    usageModal.querySelectorAll('.acf-filter-pill').forEach(p => p.classList.remove('active'));
                    pill.classList.add('active');
                    
                    // Obtener tipo a filtrar
                    const filterType = pill.dataset.type;
                    
                    // Filtrar elementos
                    usageModal.querySelectorAll('.acf-usage-list li').forEach(item => {
                        if (filterType === 'all' || item.dataset.type === filterType) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                    
                    // Actualizar el contador en el título
                    const visibleItems = usageModal.querySelectorAll('.acf-usage-list li[style="display: none;"]').length;
                    const totalItems = usageModal.querySelectorAll('.acf-usage-list li').length;
                    const displayCount = filterType === 'all' ? totalItems : totalItems - visibleItems;
                    
                    // Actualizar título si contiene el número entre paréntesis
                    const titleElement = usageModal.querySelector('.acf-usage-modal-header h3');
                    if (titleElement) {
                        const title = titleElement.textContent;
                        const regex = /\((\d+) pages\)/;
                        if (regex.test(title)) {
                            titleElement.textContent = title.replace(regex, `(${displayCount} pages)`);
                        }
                    }
                });
            });
            
        } catch (error) {
            hideLoading();
            console.error('Error showing module usage:', error);
            await showError('Error', 'Failed to load module usage');
            document.querySelector('.acf-modal-overlay').style.display = '';
        }
    };

    const closeUsageModal = () => {
        document.querySelector('.acf-usage-modal')?.remove();
        document.querySelector('.acf-modal-overlay').style.display = '';
        document.querySelector('.acf-modal-search-input')?.focus();
    };

    const setupStyles = () => {
        // Create style element if not exists
        if (!document.getElementById('acf-modal-override-styles')) {
            const style = document.createElement('style');
            style.id = 'acf-modal-override-styles';
            style.textContent = '.acf-fc-popup { display: none !important; }';
            document.head.appendChild(style);
        }
    };

    // Main event listener
    document.addEventListener('click', e => {
        const addButton = e.target.closest('.acf-button[data-name="add-layout"]');
        if (addButton && !isSelectingLayout) {
            e.preventDefault();
            
            // Set up styles to hide ACF popup
            setupStyles();
            
            // Show our modal
            showModal(addButton);
        }
    });

    // Initialize
    setupStyles();
});
