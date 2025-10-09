<?php

add_action('acf/init', 'register_custom_pills');
function register_custom_pills()
{
    // check function exists.
    if (function_exists('acf_register_block_type')) {

        // register a hubspot embed block.
        acf_register_block_type(array(
            'name'              => 'pills_block', // slug
            'title'             => __('Custom List of Capabilities'),
            'description'       => __('A Custom list of capabilities.'),
            'render_callback'   => 'acf_block_pills_block',
            'category'          => 'layout',
            'keywords' => array('pills'),
        ));
    }
}

function acf_block_pills_block($block, $content = '', $is_preview = false, $post_id = 0)
{

    if(is_preview()){
        if($block['data'] && $block['data']['custom_pills'] && $block['data']['custom_pills']['pills']){
            $pills = $block['data']['custom_pills']['pills'];
        }else{
             $pills = get_field('custom_pills')['pills'];
        }
    }else{
        $pills = get_field('custom_pills')['pills'];
    }
    ?>
    <?php if($pills) : ?>
        <div class="c--pills-a">
            <?php foreach($pills as $pill) : ?>
                <?php if($pill['pill_link'] && count($pill['pill_link']) > 0) :?>
                    <a class="g--pill-01" href="<?= get_the_permalink($pill['pill_link'][0])?>" ><?= $pill['pill_title'] ?></a>
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
                'label' => 'List of Capabilities + Industry',
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
                        'label' => 'List of Capabilities + Industry',
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
                                'key' => 'field_5e0df4d9s89k9n671', // Unique key for the subfield.
                                'label' => 'Title', // Label for the subfield.
                                'name' => 'pill_title', // Name of the subfield used in the template.
                                'type' => 'text', // Subfield type (textarea).
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
                                'key' => 'field_g5eckk2ec56map',
                                'label' => 'Pill Link',
                                'name' => 'pill_link',
                                'type' => 'relationship',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'post_type' => array(
                                    0 => 'capability',
                                    1 => 'industry',
                                ),
                                'taxonomy' => '',
                                'filters' => array(
                                    0 => 'search',
                                ),
                                'elements' => '',
                                'min' => '',
                                'max' => '1',
                                'return_format' => 'id',
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
