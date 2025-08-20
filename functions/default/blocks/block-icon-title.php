<?php

add_action('acf/init', 'register_custom_icontitle');
function register_custom_icontitle()
{
    // check function exists.
    if (function_exists('acf_register_block_type')) {

        // register a hubspot embed block.
        acf_register_block_type(array(
            'name'              => 'icontitle_block', // slug
            'title'             => __('Custom Icon +  Title'),
            'description'       => __('A Custom Icon + Title'),
            'render_callback'   => 'acf_block_icontitle_block',
            'category'          => 'layout',
            'keywords' => array('icontitle'),
        ));
    }
}

function acf_block_icontitle_block($block, $content = '', $is_preview = false, $post_id = 0)
{

    if(is_preview()){
        if($block['data']['custom_icontitle']){
            $icon_title = $block['data']['custom_icontitle']['icon_title'];
            $icon_image = $block['data']['custom_icontitle']['icon_img'];
            $image_option = $block['data']['custom_icontitle']['image_option'];
        }else{
            $icon_title = get_field('custom_icontitle')['icon_title'];
            $icon_image = get_field('custom_icontitle')['icon_img'];
            $image_option = get_field('custom_icontitle')['image_option'];
        }
       
    }else{
        $icon_title = get_field('custom_icontitle')['icon_title'];
        $icon_image = get_field('custom_icontitle')['icon_img'];
        $image_option = get_field('custom_icontitle')['image_option'];
    }
    ?>
    <?php 
    if($image_option === 'problem') :
        $icon_image = get_template_directory_uri() . '/img/icon-problem.svg';
    elseif($image_option === 'solution') :
        $icon_image = get_template_directory_uri() . '/img/icon-solution.svg';
    elseif($image_option === 'results') :
        $icon_image = get_template_directory_uri() . '/img/icon-results.svg';
    endif;
    ?>

    <?php if($icon_title || $icon_image) : ?>
        <div class="c--icon-heading-a">
            <?php
            if($icon_image && $image_option === 'custom') :
                $image_tag_args = array(
                    'image' => $icon_image,
                    'sizes' => '48px',
                    'class' => 'c--icon-heading-a__artwork',
                    'isLazy' => false,
                    'showAspectRatio' => true,
                    'decodingAsync' => true,
                    'fetchPriority' => false,
                    'addFigcaption' => false,
                );
                generate_image_tag($image_tag_args);
            endif;
            ?> 
            <?php
            if($image_option != 'custom' ) : ?>
                <img src="<?= $icon_image ?>" alt="<?= $icon_title ?>" class="c--icon-heading-a__artwork" />
            <?php endif;?> 
            <h2 class="c--icon-heading-a__title"><?= $icon_title ?></h2>
        </div>
    <?php endif;?>
<?php }

if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(array(
        'key' => 'group_5dpae1b65ldf124hgo',
        'title' => 'Block Icon + title',
        'fields' => array(
            array(
                'key' => 'field_5esfaghty15629954',
                'label' => 'Custom Icon + title Block',
                'name' => 'custom_icontitle',
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
                        'key' => 'field_6876158b07f81',
                        'label' => 'Image Option',
                        'name' => 'image_option',
                        'aria-label' => '',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '33%',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'problem' => 'Problem',
                            'solution' => 'Solution',
                            'results' => 'Results',
                            'custom' => 'Custom',
                        ),
                        'default_value' => 'custom',
                        'return_format' => 'value',
                        'multiple' => 0,
                        'allow_custom' => 0,
                        'placeholder' => '',
                        'search_placeholder' => '',
                        'allow_null' => 0,
                        'ui' => 0,
                        'ajax' => 0,
                    ),
                     array(
                        'key' => 'field_5e04d9s89k9n671', // Unique key for the subfield.
                        'label' => 'Title', // Label for the subfield.
                        'name' => 'icon_title', // Name of the subfield used in the template.
                        'type' => 'text', // Subfield type (textarea).
                        'instructions' => '', // Instructions for the subfield (if any).
                        'required' => 0, // Whether the subfield is required.
                        'conditional_logic' => 0, // Conditional logic for the subfield (if any).
                        'wrapper' => array( // Wrapper attributes for the subfield.
                            'width' => '33%',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '', // Default value for the subfield.
                        'placeholder' => '', // Placeholder text for the subfield.
                        'maxlength' => '', // Maximum length for the textarea.
                    ),
                    array(
                        'key' => 'field_5e00sd9789695671',
                        'label' => 'Image',
                        'name' => 'icon_img',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_6876158b07f81',
                                    'operator' => '==',
                                    'value' => 'custom',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '33%',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/icontitle-block',
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