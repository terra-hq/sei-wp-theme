<?php
/**
 * Module Usage API Endpoint
 * 
 * Technical Implementation:
 * - ACF have_rows() and get_row_layout() for flexible content scanning
 * - Dynamic post type discovery with get_post_types()
 * - Post querying with get_posts() and optimized fields parameter
 * - WordPress link generation with get_edit_post_link() and get_permalink()
 * - Array manipulation for duplicate prevention and sorting
 * - Debug logging with error_log() for troubleshooting
 * 
 * @package Visual_ACF_Modules
 * @subpackage API_Endpoints
 */

add_action('wp_ajax_get_module_usage', 'get_module_usage');
add_action('wp_ajax_nopriv_get_module_usage', 'get_module_usage');

/**
 * Module usage discovery across all public post types
 * Scans ACF flexible content fields for specific layouts
 * Returns usage data with edit/view links and usage counts
 */
function get_module_usage() {
    $module_name = isset($_POST['module_name']) ? sanitize_text_field($_POST['module_name']) : '';
    $field_type = isset($_POST['field_type']) ? sanitize_text_field($_POST['field_type']) : '';
    
    if (empty($module_name)) {
        wp_send_json_error('Module name is required');
        return;
    }
    
    error_log('Module usage search for: ' . $module_name . ', field type: ' . $field_type);
    
    $usage = array();
    
    // Get public post types excluding system types
    $post_types = get_post_types(['public' => true]);
    $excluded_post_types = [
        'attachment', 'revision', 'nav_menu_item', 'custom_css',
        'customize_changeset', 'oembed_cache', 'user_request', 'wp_block'
    ];
    $post_types = array_diff($post_types, $excluded_post_types);
    
    error_log('Searching in post types: ' . implode(', ', $post_types));
    
    // Query posts with optimized fields parameter
    $posts = get_posts([
        'post_type' => $post_types,
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'fields' => 'ids'
    ]);
    
    // Scan hero fields if applicable
    foreach ($posts as $post_id) {
        $hero_fields = ['hero', 'heros', 'hero_section', 'hero_modules'];
        if (empty($field_type) || $field_type === 'heros') {
            $hero_count = 0;
            $found_hero_field = '';
            
            foreach ($hero_fields as $hero_field) {
                if (have_rows($hero_field, $post_id)) {
                    while (have_rows($hero_field, $post_id)) {
                        the_row();
                        $layout = get_row_layout();
                        if ($layout === $module_name) {
                            $hero_count++;
                            if (empty($found_hero_field)) {
                                $found_hero_field = $hero_field;
                            }
                        }
                    }
                }
            }
            
            if ($hero_count > 0) {
                $usage[] = [
                    'id' => $post_id,
                    'title' => get_the_title($post_id),
                    'type' => get_post_type($post_id),
                    'edit_link' => get_edit_post_link($post_id, ''),
                    'view_link' => get_permalink($post_id),
                    'field' => $found_hero_field,
                    'count' => $hero_count
                ];
            }
        }
        
        // Scan modules field if applicable
        if (empty($field_type) || $field_type === 'modules') {
            if (have_rows('modules', $post_id)) {
                $module_count = 0;
                while (have_rows('modules', $post_id)) {
                    the_row();
                    $layout = get_row_layout();
                    if ($layout === $module_name) {
                        $module_count++;
                    }
                }
                
                if ($module_count > 0) {
                    // Prevent duplicates from hero scan
                    $existing = array_filter($usage, function($item) use ($post_id) {
                        return $item['id'] === $post_id;
                    });
                    
                    if (empty($existing)) {
                        $usage[] = [
                            'id' => $post_id,
                            'title' => get_the_title($post_id),
                            'type' => get_post_type($post_id),
                            'edit_link' => get_edit_post_link($post_id, ''),
                            'view_link' => get_permalink($post_id),
                            'field' => 'modules',
                            'count' => $module_count
                        ];
                    }
                }
            }
        }
    }
    
    // Sort results by title
    usort($usage, function($a, $b) {
        return strcasecmp($a['title'], $b['title']);
    });
    
    wp_send_json_success([
        'module' => $module_name,
        'total' => count($usage),
        'usage' => $usage
    ]);
}
