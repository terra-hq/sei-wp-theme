<?php

/**
 * Register a custom ACF block for a CTA with text and button.
 * 
 * @return void
 * 
 * @example
 * This function registers a new block in the WordPress editor using Advanced Custom Fields (ACF). 
 * The block is identified as 'cta_block' and displays a customizable call-to-action (CTA) 
 * with a title and a button.
 */
add_action('acf/init', 'register_custom_cta');
function register_custom_cta()
{
    // Check if the function acf_register_block_type exists to ensure ACF is active.
    if (function_exists('acf_register_block_type')) {

        // Register a new block type with various settings.
        acf_register_block_type(array(
            'name'              => 'cta_block', // Unique slug for the block.
            'title'             => __('Custom CTA - Text + button'), // Block title shown in the editor.
            'description'       => __('A CTA - Text + button'), // Short description of the block.
            'render_callback'   => 'acf_block_cta_block', // Callback function to render the block's content.
            'category'          => 'layout', // Block category under which it appears in the editor.
            'keywords'          => array('cta', 'text', 'button', 'custom'), // Search keywords.
            'example'           => array( // Example configuration for the block preview.
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => array(
                        'preview_image_help' => get_template_directory_uri() . '/assets/frontend/blocks/sei_custom-block-cta.webp',
                    )
                )
            ),
        ));
    }
}

/**
 * Render callback for the custom CTA block.
 * 
 * @param array $block The block settings and attributes.
 * @param string $content The block content (empty for dynamic blocks).
 * @param bool $is_preview True during AJAX preview.
 * @param int $post_id The post ID this block is saved to.
 * 
 * @return void
 * 
 * @example
 * Outputs the HTML structure for the CTA block, using fields defined in ACF.
 * If the block is in preview mode and a preview image is set, it will display the image.
 */
function acf_block_cta_block($block, $content = '', $is_preview = false, $post_id = 0)
{
    // If in preview mode and a preview image is set, display the image.
    if ($is_preview && isset($block['data']['preview_image_help'])) {
        echo '<img src="' . esc_url($block['data']['preview_image_help']) . '" alt="Preview of Custom Block Not Found">';
        return;
    }

    // Create ID attribute allowing for custom "anchor" for the CTA block.
    $id = 'cta_block-' . $block['id'];
    if (!empty($block['anchor'])) {
        $id = $block['anchor'];
    }

    // Create class attribute allowing for custom "className" and "align" for the CTA block.
    $className = 'cta_block';
    if (!empty($block['className'])) {
        $className .= ' ' . $block['className'];
    }
    if (!empty($block['align'])) {
        $className .= ' align' . $block['align'];
    }

    // Load CTA fields and assign defaults.
    $custom_cta = get_field('custom_cta_block');
    $cta = $custom_cta ?: 'Custom CTA'; ?>

    <!-- HTML structure for the CTA block. -->
    <div class="g--card-07">
        <div class="g--card-07__ft-items">
            <h3 class="g--card-07__ft-items__item-primary"><?php echo $custom_cta['title'] ?></h3>
            <div class="g--card-07__ft-items__list-group">
                <?php if ($custom_cta['button']) : ?>
                    <a href="<?php echo $custom_cta['button']['url'] ?>" class="g--card-07__ft-items__list-group__item">
                        <span><?php echo $custom_cta['button']['title'] ?></span>
                        <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php }

/**
 * Register custom ACF fields for the CTA block.
 * 
 * @return void
 * 
 * @example
 * This function registers a new field group in ACF containing fields for the CTA block. 
 * The fields include a title and a button link.
 */
if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(array(
        'key' => 'group_5eccepb657kfc', // Unique key for the field group.
        'title' => 'Block CTA', // Title of the field group.
        'fields' => array(
            array(
                'key' => 'field_5eccp2d15p299', // Unique key for the field.
                'label' => 'Custom CTA Block', // Label for the field.
                'name' => 'custom_cta_block', // Name of the field used in the template.
                'type' => 'group', // Field type (group of subfields).
                'instructions' => '', // Instructions for the field (if any).
                'required' => 0, // Whether the field is required.
                'conditional_logic' => 0, // Conditional logic for the field (if any).
                'wrapper' => array( // Wrapper attributes for the field (like width, class, etc.).
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'layout' => 'block', // Layout type for the group.
                'sub_fields' => array(
                    array(
                        'key' => 'field_5e049789k9n671', // Unique key for the subfield.
                        'label' => 'CTA Title', // Label for the subfield.
                        'name' => 'title', // Name of the subfield used in the template.
                        'type' => 'textarea', // Subfield type (textarea).
                        'rows' => 3, // Number of rows for the textarea.
                        'instructions' => '', // Instructions for the subfield (if any).
                        'required' => 0, // Whether the subfield is required.
                        'conditional_logic' => 0, // Conditional logic for the subfield (if any).
                        'wrapper' => array( // Wrapper attributes for the subfield.
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '', // Default value for the subfield.
                        'placeholder' => '', // Placeholder text for the subfield.
                        'maxlength' => '', // Maximum length for the textarea.
                    ),
                    array(
                        'key' => 'field_5eckk2ec56map', // Unique key for the subfield.
                        'label' => 'CTA Button', // Label for the subfield.
                        'name' => 'button', // Name of the subfield used in the template.
                        'type' => 'link', // Subfield type (link).
                        'instructions' => '', // Instructions for the subfield (if any).
                        'required' => 0, // Whether the subfield is required.
                        'conditional_logic' => 0, // Conditional logic for the subfield (if any).
                        'wrapper' => array( // Wrapper attributes for the subfield.
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array', // Format in which the link field value is returned.
                        'preview_size' => 'thumbnail', // Preview size for the link (if applicable).
                        'library' => 'all', // Media library restriction (if any).
                        'min_width' => '', // Minimum width for the media (if any).
                        'min_height' => '', // Minimum height for the media (if any).
                        'min_size' => '', // Minimum file size (if any).
                        'max_width' => '', // Maximum width for the media (if any).
                        'max_height' => '', // Maximum height for the media (if any).
                        'max_size' => '', // Maximum file size (if any).
                        'mime_types' => '', // Allowed MIME types for the field (if any).
                    ),
                ),
            ),
        ),
        'location' => array( // Define where this field group appears.
            array(
                array(
                    'param' => 'block', // The field group appears when editing blocks.
                    'operator' => '==',
                    'value' => 'acf/cta-block', // The block type for which the fields apply.
                ),
            ),
        ),
        'menu_order' => 0, // The order of the field group.
        'position' => 'normal', // Position of the field group in the editor.
        'style' => 'default', // Style of the field group.
        'label_placement' => 'top', // Placement of field labels.
        'instruction_placement' => 'label', // Placement of field instructions.
        'hide_on_screen' => '', // Fields to hide on the screen (if any).
        'active' => true, // Whether the field group is active.
        'description' => '', // Description of the field group (if any).
    ));

endif;
?>
