<?php

add_action('acf/init', 'register_custom_slider');
function register_custom_slider()
{
    // check function exists.
    if (function_exists('acf_register_block_type')) {

        // register a hubspot embed block.
        acf_register_block_type(array(
            'name'              => 'slider_block', // slug
            'title'             => __('Custom Slider'),
            'description'       => __('A Custom Slider'),
            'render_callback'   => 'acf_block_slider_block',
            'category'          => 'layout',
            'keywords' => array('slider'),
        ));
    }
}

function acf_block_slider_block($block, $content = '', $is_preview = false, $post_id = 0)
{

    // Create id attribute allowing for custom "anchor" value.
    $id = 'slider_block-' . $block['id'];
    if (!empty($block['anchor'])) {
        $id = $block['anchor'];
    }

    // Create class attribute allowing for custom "className" and "align" values.
    $className = 'slider_block';
    if (!empty($block['className'])) {
        $className .= ' ' . $block['className'];
    }
    if (!empty($block['align'])) {
        $className .= ' align' . $block['align'];
    }

    // Load values and assing defaults.
    $custom_slider = get_field('custom_slider');
    $slides = $custom_slider['slide'] ?: 'Custom Slider';

    ?>

    <div class="c--slider-b">
        <div class="c--slider-b__wrapper js--slider-b">
            <?php foreach ($slides as $key => $slide) { ?>
                <div class="c--slider-b__wrapper__item">
                    <?php  $image_tag_args = array(
                        'image' => $slide['img'],
                        'sizes' => '(max-width: 580px) 100w, (max-width: 810px) 50w, 33w',
                        'class' => 'c--slider-b__wrapper__item__media tns-lazy-img',
                        'isLazy' => false,
                        'showAspectRatio' => true,
                        'decodingAsync' => true,
                        'fetchPriority' => false,
                        'addFigcaption' => false,
                    );
                    generate_image_tag($image_tag_args) ?>
                </div>
            <?php } ?>

        </div>
        <div class="c--slider-b__controls">
            <button class="c--slider-b__controls__btn" aria-label="previous slide">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="22" viewBox="0 0 26 22" fill="none">
                    <path d="M25 11L1 11M1 11L10 2M1 11L10 20" stroke="#F01840" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" />
                </svg>
            </button>
            <button class="c--slider-b__controls__btn" aria-label="next slide">
                <svg width="26" height="22" viewBox="0 0 26 22" fill="none">
                    <path d="M1 11L25 11M25 11L16 20M25 11L16 2" stroke="#F01840" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </div>

<?php }

if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(array(
        'key' => 'group_5dpae1b65l1go',
        'title' => 'Block Slider',
        'fields' => array(
            array(
                'key' => 'field_5eazhty156299',
                'label' => 'Custom Slider Block',
                'name' => 'custom_slider',
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
                        'key' => 'field_5e9c6f1e1c477',
                        'label' => 'Slide',
                        'name' => 'slide',
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
                                'key' => 'field_5e009789695671',
                                'label' => 'Image',
                                'name' => 'img',
                                'type' => 'image',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'return_format' => 'url',
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
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/slider-block',
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