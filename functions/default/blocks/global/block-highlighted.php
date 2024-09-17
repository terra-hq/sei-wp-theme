<?php 

add_action('acf/init', 'register_highlighted_block');
function register_highlighted_block() {
    // check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register an highlighted block.
        acf_register_block_type(array(
            'name'              => 'highlighted_block', // slug
            'title'             => __('Custom highlighted'),
            'description'       => __('A Custom highlighted'),
            'render_callback'   => 'acf_block_highlighted_block',
            'category'          => 'layout',
            'icon'              => 'editor-italic',
            'keywords' => array('highlighted'),
            'example'           => array(
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => array(
                        'preview_image_help' => get_template_directory_uri() . '/assets/frontend/blocks/sei_custom-block-call-out.webp',
                    )
                )
            ),
        ));
    }
}

function acf_block_highlighted_block( $block, $content = '', $is_preview = false, $post_id = 0 ) {
    if ($is_preview && isset($block['data']['preview_image_help'])) {
        echo '<img src="' . esc_url($block['data']['preview_image_help']) . '" alt="Preview of Custom Block Not Found">';
        return;
    }

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