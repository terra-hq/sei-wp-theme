<?php 

add_action('acf/init', 'register_footnote_block');
function register_footnote_block() {
    // check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register an footnote block.
        acf_register_block_type(array(
            'name'              => 'footnote_block', // slug
            'title'             => __('Custom Footnote'),
            'description'       => __('A Custom Footnote'),
            'render_callback'   => 'acf_block_footnote_block',
            'category'          => 'layout',
            'icon'              => 'editor-italic',
            'keywords' => array('Footnote'),
            'example'           => array(
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => array(
                        'preview_image_help' => get_template_directory_uri() . '/assets/frontend/blocks/sei_custom-block-footnote.webp',
                    )
                )
            ),
        ));
    }
}

function acf_block_footnote_block( $block, $content = '', $is_preview = false, $post_id = 0 ) {
    if ($is_preview && isset($block['data']['preview_image_help'])) {
        echo '<img src="' . esc_url($block['data']['preview_image_help']) . '" alt="Preview of Custom Block Not Found">';
        return;
    }

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