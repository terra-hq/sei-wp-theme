<?php

// Outside the class or inside a static method
add_action('acf/init', function () {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_emails',
            'title' => 'Terra Lighthouse Settings',
            'fields' => array(
                array(
                    'key' => 'field_6863d3a6dd58445',
                    'label' => 'Interval:',
                    'name' => 'terra_lighthouse_interval',
                    'type' => 'select',
                    'choices' => array(
                        '86400' => 'Every Day',
                        '604800' => 'Every Week',
                        '2592000' => 'Every Month', // <- Correct value for month
                    ),
                    'default_value' => '604800', // <- Valid default
                ),
                array(
                    'key' => 'field_emails_repeater',
                    'label' => 'Emails',
                    'name' => 'terra_lighthouse_emails',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_single_email',
                            'label' => 'Email',
                            'name' => 'email',
                            'type' => 'text',
                        ),
                    ),
                    'min' => 1,
                    'layout' => 'table',
                    'button_label' => 'Add Email',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'theme-general-settings',
                    ),
                ),
            ),
        ));
    }
});
?>