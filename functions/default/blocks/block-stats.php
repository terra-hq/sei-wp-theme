<?php

add_action('acf/init', 'register_custom_stats');
function register_custom_stats()
{
    // check function exists.
    if (function_exists('acf_register_block_type')) {

        // register a hubspot embed block.
        acf_register_block_type(array(
            'name'              => 'stats_block', // slug
            'title'             => __('Custom Stats'),
            'description'       => __('A Custom Stats'),
            'render_callback'   => 'acf_block_stats_block',
            'category'          => 'layout',
            'keywords' => array('stats'),
        ));
    }
}

function acf_block_stats_block($block, $content = '', $is_preview = false, $post_id = 0)
{

     if(is_preview()){
        if($block['data']['custom_stats']){
            $stats = $block['data']['custom_stats']['stats'];
        }else{
            $stats = get_field('custom_stats')['stats'];
        }
    }else{
        $stats = get_field('custom_stats')['stats'];
    }
    ?>
    <?php if($stats) : ?>
    <div class="f--row">
        <?php foreach($stats as $stat) : ?>
            <div class="f--col-4 f--col-tablets-6 f--col-mobile-12">
                <div class="c--card-d c--card-d--second ">
                    <div class="c--card-d__wrapper">
                        <div class="c--card-d__wrapper__title">
                           <?= $stat['stat_title'] ?>
                        </div>
                        <div class="c--card-d__wrapper__subtitle">
                            <?= $stat['stat_subtitle'] ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ;?>
    </div>
    <?php endif;?>
<?php }

if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(array(
        'key' => 'group_5dpae1b65l124go',
        'title' => 'Block Stats',
        'fields' => array(
            array(
                'key' => 'field_5eazhty15629954',
                'label' => 'Custom Stats Block',
                'name' => 'custom_stats',
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
                        'key' => 'field_5e9c6f1e1c4737',
                        'label' => 'Stats',
                        'name' => 'stats',
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
                                'key' => 'field_5e04d9789k9n671', // Unique key for the subfield.
                                'label' => 'Stat Title', // Label for the subfield.
                                'name' => 'stat_title', // Name of the subfield used in the template.
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
                                'key' => 'field_5e04d29789k9n671', // Unique key for the subfield.
                                'label' => 'Stat Subtitle', // Label for the subfield.
                                'name' => 'stat_subtitle', // Name of the subfield used in the template.
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
                    'value' => 'acf/stats-block',
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