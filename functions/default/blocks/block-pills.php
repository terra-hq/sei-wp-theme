<?php

add_action('acf/init', 'register_custom_pills');
function register_custom_pills()
{
    // check function exists.
    if (function_exists('acf_register_block_type')) {

        // register a hubspot embed block.
        acf_register_block_type(array(
            'name'              => 'pills_block', // slug
            'title'             => __('Custom pills'),
            'description'       => __('A Custom pills'),
            'render_callback'   => 'acf_block_pills_block',
            'category'          => 'layout',
            'keywords' => array('pills'),
        ));
    }
}

function acf_block_pills_block($block, $content = '', $is_preview = false, $post_id = 0)
{

    if(is_preview()){
        $pills = $block['data']['custom_pills']['pills'];
    }else{
        $pills = get_field('custom_pills')['pills'];
    }
    ?>
    <?php if($pills) : ?>
        <div class="c--pills-a">
            <?php foreach($pills as $pill) : ?>
                <?php if($pill) : ?>
                    <a class="g--pill-01" href="<?=$pill['pill_link']['url']?>"  <?= get_target_link($pill['pill_link']['target'], $pill['pill_link']['title']); ?>><?= $pill['pill_link']['title'] ?></a>
                <?php endif; ?>
            <?php endforeach ;?>
        </div>
    <?php endif;?>
<?php }

if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(array(
        'key' => 'group_5dpae1b65ldf124go',
        'title' => 'Block pills',
        'fields' => array(
            array(
                'key' => 'field_5esfazhty15629954',
                'label' => 'Custom Pills Block',
                'name' => 'custom_pills',
                'type' => 'group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_5eg9c6f1e1c4737',
                        'label' => 'Pills',
                        'name' => 'pills',
                        'type' => 'repeater',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'collapsed' => '',
                        'min' => 0,
                        'max' => 0,
                        'layout' => 'table',
                        'button_label' => '',
                        'sub_fields' => array(
                           
                            array(
                                'key' => 'field_g5eckk2ec56map', // Unique key for the subfield.
                                'label' => 'Pill Link', // Label for the subfield.
                                'name' => 'pill_link', // Name of the subfield used in the template.
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
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/pills-block',
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