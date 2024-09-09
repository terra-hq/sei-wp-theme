<?php 

/**
 * Register Custom Highlighted Block
 *
 * This code registers a custom block in WordPress using Advanced Custom Fields (ACF) for adding highlighted text to content.
 * 
 * 1. **Block Registration**:
 *    - The `register_highlighted_block` function hooks into `acf/init` to register a custom block type if ACF is available.
 *    - The block is named `highlighted_block` with the title "Custom Highlighted" and is categorized under 'layout'.
 *    - The block's icon is set to 'editor-italic' and it can be found using the keyword 'highlighted'.
 *    - The block is rendered using the `acf_block_highlighted_block` callback function.
 *
 * 2. **Block Rendering**:
 *    - The `acf_block_highlighted_block` function handles how the highlighted text content is displayed on the front end.
 *    - It checks if the block is being previewed (`is_preview`). If true, it uses the block's data for the highlighted text; otherwise, it retrieves the highlighted text using `get_field`.
 *    - The highlighted text is then output within a `<p>` tag with the class `highlighted`.
 *
 * 3. **ACF Field Group for Highlighted Block**:
 *    - The code also creates an ACF field group named "Highlighted" with a single textarea field called `highlighted`.
 *    - This field group is only displayed when editing the custom `highlighted_block`.
 *    - The field is used to input the text that will be highlighted within the custom block.
 * 
 * @hook acf/init Registers the custom highlighted block when ACF is initialized.
 */


add_action('acf/init', 'register_highlighted_block');
function register_highlighted_block() {
    if( function_exists('acf_register_block_type') ) {

        acf_register_block_type(array(
            'name'              => 'highlighted_block', 
            'title'             => __('Custom highlighted'),
            'description'       => __('A Custom highlighted'),
            'render_callback'   => 'acf_block_highlighted_block',
            'category'          => 'layout',
            'icon'              => 'editor-italic',
            'keywords' => array('highlighted'),
        ));
    }
}

function acf_block_highlighted_block( $block, $content = '', $is_preview = false, $post_id = 0 ) {
    if(is_preview()){
        $highlighted = $block['data']['highlighted'];
    }else{
        $highlighted = get_field('highlighted');
    }
    ?>
        <p class="highlighted">
            <?= $highlighted; ?>
        </p>
    <?php
}


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_5ecce1b657124',
        'title' => 'highlighted',
        'fields' => array(
            array(
                'key' => 'field_5ecce2ec5613',
                'label' => 'Highlighted Text',
                'name' => 'highlighted',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/highlighted-block',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    
    endif;
    
?>