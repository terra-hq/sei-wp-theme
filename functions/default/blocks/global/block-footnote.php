
<?php 
/**
 * Register Custom Footnote Block
 *
 * This code registers a custom block in WordPress using Advanced Custom Fields (ACF) for adding footnotes to content.
 * 
 * 1. **Block Registration**:
 *    - The `register_footnote_block` function hooks into `acf/init` to register a custom block type if ACF is available.
 *    - The block is named `footnote_block` with the title "Custom Footnote" and is categorized under 'layout'.
 *    - The block's icon is set to 'editor-italic' and it can be found using the keyword 'Footnote'.
 *    - The block is rendered using the `acf_block_footnote_block` callback function.
 *
 * 2. **Block Rendering**:
 *    - The `acf_block_footnote_block` function handles how the footnote content is displayed on the front end.
 *    - It checks if the block is being previewed (`is_preview`). If true, it uses the block's data for the footnote; otherwise, it retrieves the footnote text using `get_field`.
 *    - The footnote text is then output within a `<p>` tag with the class `footnote`.
 *
 * 3. **ACF Field Group for Footnote**:
 *    - The code also creates an ACF field group named "Footnote" with a single textarea field called `footnote`.
 *    - This field group is only displayed when editing the custom `footnote_block`.
 *    - The field is used to input the text of the footnote that will be displayed within the custom block.
 * 
 * @hook acf/init Registers the custom footnote block when ACF is initialized.
 */

add_action('acf/init', 'register_footnote_block');
function register_footnote_block() {
    if( function_exists('acf_register_block_type') ) {

        acf_register_block_type(array(
            'name'              => 'footnote_block', // slug
            'title'             => __('Custom Footnote'),
            'description'       => __('A Custom Footnote'),
            'render_callback'   => 'acf_block_footnote_block',
            'category'          => 'layout',
            'icon'              => 'editor-italic',
            'keywords' => array('Footnote'),
        ));
    }
}

function acf_block_footnote_block( $block, $content = '', $is_preview = false, $post_id = 0 ) {
    if(is_preview()){
        $footnote = $block['data']['footnote'];
    }else{
        $footnote = get_field('footnote');
    }
    ?>
        <p class="footnote">
            <?= $footnote; ?>
        </p>
    <?php
}


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_5ecce1b657123',
        'title' => 'Footnote',
        'fields' => array(
            array(
                'key' => 'field_5ecce2ec5612',
                'label' => 'Footnote Text',
                'name' => 'footnote',
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
                    'value' => 'acf/footnote-block',
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