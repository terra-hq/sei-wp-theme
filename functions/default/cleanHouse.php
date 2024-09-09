<?php

/** 
 * This file includes functions for hiding default WordPress elements and version information, customizing error messages on failed logins, disabling default scripts and styles, enabling async and defer for scripts, allowing additional MIME types for uploads, localizing script variables for Ajax calls, removing the admin bar margin, disabling and hiding comments, customizing canonical URLs, lowering the priority of the Yoast SEO metabox, adding custom post states, removing query strings from static resources, customizing editor block formats, generating dynamic image tags, and creating taxonomy dropdowns.
 */

/**
 * Optimize WordPress by Removing Unnecessary Actions from wp_head
 *
 * This code removes several default actions from the WordPress `wp_head` to enhance security, performance, and to reduce unnecessary clutter.
 * By removing these actions, you can minimize the amount of code that WordPress outputs in the head section of your site's HTML, 
 * which can help improve loading times and reduce the risk of exposing sensitive information.
 */

// Remove the WordPress version number for security reasons
remove_action('wp_head', 'wp_generator');

// Remove the Really Simple Discovery (RSD) link - used for external services to interact with WordPress
remove_action('wp_head', 'rsd_link');

// Remove the Windows Live Writer (WLW) manifest link - rarely used for content editing
remove_action('wp_head', 'wlwmanifest_link');

// Remove the index link - not necessary for SEO or most modern web applications
remove_action('wp_head', 'index_rel_link');

// Remove the default feed links - useful if you're not using WordPress's built-in RSS feeds
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

// Remove the link to the previous and next posts - can be useful to reduce overhead on pages
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// Remove the WordPress shortlink for the current page
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Disable the emoji detection script to prevent loading unnecessary assets (introduced in WordPress 4.2)
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


/**
 * Theme setup function to add theme support, custom image sizes, and remove roles.
 * @return void
 * 
 * @example
 * Initialize theme setup on WordPress init hook.
 * add_action('init', 'terra_setup');
 */
function terra_setup()
{
    // Add support for featured images
    add_theme_support('post-thumbnails');

    // Define custom image sizes
    add_image_size('category_thumb', 300);
    add_image_size('tablets', 810, 999999999);
    add_image_size('mobile', 580, 999999999);

    // Remove unwanted user roles
    remove_role('wpseo_manager');
    remove_role('wpseo_editor');
    remove_role('subscriber');
    remove_role('author');
    remove_role('contributor');
}
add_action('init', 'terra_setup');

/**
 * Modify login error messages for security purposes.
 * 
 * @return string Custom error message to display on failed login attempts.
 * 
 * @example
 * Use this function to obscure login details during failed login attempts.
 * add_filter('login_errors', 'show_less_login_info');
 */
function show_less_login_info()
{
    return "<strong>ERROR</strong>: Stop guessing!";
}
add_filter('login_errors', 'show_less_login_info');

/**
 * Disable WordPress version generation for security.
 * 
 * @return string An empty string to remove WordPress version output.
 * 
 * @example
 * Prevent WordPress from outputting its version number.
 * add_filter('the_generator', 'no_generator');
 */
function no_generator()
{
    return '';
}
add_filter('the_generator', 'no_generator');

/**
 * Disable default WordPress scripts and styles for optimization.
 * !to enable jQuery in your project discomment line 125
 * @return void
 * 
 * @example
 * Use this function to replace default WordPress scripts with CDN-hosted versions.
 * add_action('wp_enqueue_scripts', 'disable_default_styles_and_scripts', 100);
 */
function disable_default_styles_and_scripts()
{
    if (is_admin()) {
        return;
    }

    global $wp_scripts;

    if (!empty($wp_scripts->registered['jquery'])) {
        $wp_scripts->registered['jquery']->deps = array_diff(
            $wp_scripts->registered['jquery']->deps,
            ['jquery-migrate']
        );
        wp_deregister_style('dashicons');
    }

    wp_deregister_script('jquery');
    // wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js', [], null, true);
    wp_deregister_script('wp-embed');
    wp_deregister_script('jquery-migrate');
    wp_deregister_style('wp-block-library');
    wp_deregister_style('global-styles');
    wp_deregister_style('classic-theme-styles');
    wp_deregister_style('wp-block-library-theme');
}
add_action('wp_enqueue_scripts', 'disable_default_styles_and_scripts', 100);


/**
 * Flush rewrite rules to ensure updated permalinks.
 * 
 * @return void
 * 
 * @example
 * Use this function after modifying custom post types or taxonomies.
 * add_action('init', 'flush_rewritte');
 */
function flush_rewritte()
{
    global $wp_rewrite;
    $wp_rewrite->flush_rules(false);
}
add_action('init', 'flush_rewritte');


/**
 * Add async or defer attributes to enqueued scripts.
 * 
 * @param string $tag The script tag for the enqueued script.
 * @param string $handle The script handle.
 * @return string Modified script tag with async or defer attributes.
 * 
 * @example
 * Use this function to improve script loading performance.
 * add_filter('script_loader_tag', 'add_async_defer_attr', 10, 2);
 */
function add_async_defer_attr($tag, $handle)
{
    if (strpos($handle, "async")) {
        $tag = str_replace(' src', ' async src', $tag);
    }

    if (strpos($handle, "defer")) {
        $tag = str_replace(' src', ' defer src', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'add_async_defer_attr', 10, 2);

/**
 * Get the page ID by its title.
 * 
 * @param string $title The title of the page.
 * @return int The ID of the page with the specified title.
 * 
 * @example
 * Retrieve the ID of a page titled "Contact".
 * $page_id = get_page_id_by_title('Contact');
 */
function get_page_id_by_title($title)
{
    $page = get_page_by_title($title);
    return $page->ID;
}

/**
 * Allow upload of additional MIME types.
 * 
 * @param array $mimes The current array of allowed MIME types.
 * @return array Modified array of MIME types including SVG, WebP, and JSON.
 * 
 * @example
 * Enable SVG and WebP uploads in WordPress.
 * add_filter('upload_mimes', 'cc_mime_types');
 */
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    $mimes['webp'] = 'image/webp';
    $mimes['json'] = 'text/plain';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/**
 * Add JavaScript variables to the WordPress head section.
 * 
 * @return void
 * 
 * @example
 * Output useful JavaScript variables for use in themes and plugins.
 * add_action('wp_head', 'variables_in_header');
 */
function variables_in_header()
{ ?>
    <script>
        var base_wp_api = <?php echo json_encode(
                                    array(
                                        'ajax_url' => admin_url('admin-ajax.php'),
                                        'current_page_ID' => get_the_ID(),
                                        'root_url' => get_site_url(),
                                        'currentPage' => get_queried_object(),
                                        'theme_url' => get_template_directory_uri(),
                                    )
                                ); ?>
    </script>
    <?php
    }
    add_action('wp_head', 'variables_in_header');


    /**
     * Remove HTML margin top on the WordPress dashboard.
     * 
     * @return void
     * 
     * @example
     * Prevent admin bar margin adjustment on the frontend.
     * add_action('get_header', 'remove_admin_login_header');
     */
    function remove_admin_login_header()
    {
        remove_action('wp_head', '_admin_bar_bump_cb');
    }
    add_action('get_header', 'remove_admin_login_header');


    /**
     * Get the ALT attribute of an image or the filename if ALT is not set.
     * 
     * @param string $imageUrl The URL of the image.
     * @return string The ALT attribute or the filename.
     * 
     * @example
     * Retrieve the ALT text of an image by its URL.
     * $alt_text = get_alt_image('https://example.com/image.jpg');
     */
    function get_alt_image($imageUrl)
    {
        $attach_id = attachment_url_to_postid($imageUrl);
        $altImg = get_post_meta($attach_id, '_wp_attachment_image_alt', true);
        $filename = basename(get_attached_file($attach_id));
        $filename = explode('.', $filename);
        return ($altImg) ? $altImg : $filename[0];
    }

    /**
     * Get the target attribute for a link.
     * 
     * @param boolean $target Whether to open the link in a new window.
     * @param string $text The text of the link.
     * @return string The formatted target attribute for the link.
     * 
     * @example
     * Generate a target attribute for a link.
     * $target_attr = get_target_link(true, 'Example Link');
     */
    function get_target_link($target, $text)
    {
        $targetType = ($target) ? '_blank' : "_self";
        $targetURL = "target='" . $targetType . "'";
        $targetURL .= ($target) ? " rel='noopener noreferrer'" : '';
        $targetURL .= ($target) ? 'aria-label="' . $text . ', opens a new window"' : '';
        return $targetURL;
    }

    /**
     * Disable Comments in WordPress
     * 
     * This function completely disables comments throughout the WordPress site. It includes several steps to ensure comments are removed from both the front-end and back-end, providing a cleaner and more focused user experience without comments.
     * 
     * The steps involved include:
     * - Redirecting users trying to access the comments page in the admin area.
     * - Removing the comments metabox from the WordPress dashboard.
     * - Disabling support for comments and trackbacks for all post types.
     * 
     * @return void
     * 
     * @example
     * Use this function to completely disable comments on a WordPress site.
     * add_action('admin_init', function () {
     *     // Code to disable comments
     * });
     * 
     * @see https://developer.wordpress.org/reference/hooks/admin_init/ For more information on the `admin_init` action hook.
     * @see https://developer.wordpress.org/reference/functions/remove_meta_box/ For more information on the `remove_meta_box` function.
     * @see https://developer.wordpress.org/reference/functions/remove_post_type_support/ For more information on the `remove_post_type_support` function.
     * 
     */

    add_action('admin_init', function () {
        // Redirect any user trying to access the comments page in the admin area
        global $pagenow;

        if ($pagenow === 'edit-comments.php') {
            wp_redirect(admin_url());
            exit;
        }

        // Remove the comments metabox from the WordPress dashboard
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

        // Disable support for comments and trackbacks for all post types
        foreach (get_post_types() as $post_type) {
            if (post_type_supports($post_type, 'comments')) {
                remove_post_type_support($post_type, 'comments');
                remove_post_type_support($post_type, 'trackbacks');
            }
        }
    });

    // Close comments on the front-end
    add_filter('comments_open', '__return_false', 20, 2);
    add_filter('pings_open', '__return_false', 20, 2);

    // Hide existing comments
    add_filter('comments_array', '__return_empty_array', 10, 2);

    // Remove comments page in menu
    add_action('admin_menu', function () {
        remove_menu_page('edit-comments.php');
    });

    // Remove comments links from admin bar
    add_action('init', function () {
        if (is_admin_bar_showing()) {
            remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
        }
    });


    /**     
     * Custom WordPress filter function for generating canonical URLs.
     */
    function prefix_filter_canonical_example($canonical)
    {
        // Check if the current request is using HTTPS
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
        // Construct the canonical URL using the protocol, domain, and request URI
        $canonical = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        // Return the modified canonical URL
        return $canonical;
    }
    add_filter('wpseo_canonical', 'prefix_filter_canonical_example', 20);



    /**
     *  Sets Yoast in a page right under ACF as it gives Yoast low priority
     *  @author: Team Thunderfoot
     */
    function lower_wpseo_priority($html)
    {
        return 'low';
    }
    add_filter('wpseo_metabox_prio', 'lower_wpseo_priority');


    /**
     * wpsites_custom_post_states
     * Callback function to modify the display of post states on the Edit Post/Page screen.
     *
     * @param array $states The existing array of post states.
     * @return array $states The modified array of post states.
     */
    function wpsites_custom_post_states($states)
    {
        global $post;

        // Check if the global $post variable is set
        if ($post) {

            // Check if the post type is 'page' and the page template is 'page-home.php'
            if (('page' == get_post_type($post->ID)) && ('page-home.php' == get_page_template_slug($post->ID))) {

                // If the conditions are met, add a custom state label 'Home'
                $states[] = __('Home');
            }
        }

        // Return the modified array of post states
        return $states;
    }

    // Hook the wpsites_custom_post_states function to the 'display_post_states' action
    add_filter('display_post_states', 'wpsites_custom_post_states');


    /**
     *  Remove Query Strings From Static Resources
     *  @author: Terra team
     */

    function _remove_query_strings_1($src)
    {
        $rqs = explode('?ver', $src);
        return $rqs[0];
    }

    if (is_admin()) {
        // Remove query strings from static resources disabled in admin
    } else {
        add_filter('script_loader_src', '_remove_query_strings_1', 15, 1);
        add_filter('style_loader_src', '_remove_query_strings_1', 15, 1);
    }

    function _remove_query_strings_2($src)
    {
        $rqs = explode('&ver', $src);
        return $rqs[0];
    }

    if (is_admin()) {
        // Remove query strings from static resources disabled in admin
    } else {
        add_filter('script_loader_src', '_remove_query_strings_2', 15, 1);
        add_filter('style_loader_src', '_remove_query_strings_2', 15, 1);
    }

    /**
     *  Add/remove custom Headings for Editor
     *  @author: Terra Team
     */
    function remove_headings_from_editor($settings)
    {
        $settings['block_formats'] = 'Paragraph=p; Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Preformatted=pre;';
        return $settings;
    }
    add_filter('tiny_mce_before_init', 'remove_headings_from_editor');


    /**
     * Generate Image TAG
     * Author: Guido
     */

    /**
     * Generate an HTML image tag from ACF image field or featured image ID with dynamic attributes.
     *
     * @param mixed $image The ACF image array or featured image ID.
     * @param string $sizes The list of image sizes for the "sizes" attribute.
     * @param string $class The CSS class to apply to the image tag.
     * @param string $lazyClass The CSS lazy class to apply to the image tag.
     * @param boolean $isLazy Indicates whether to use lazy loading to load the image.
     * @param boolean $showAspectRatio If true, 'aspect-ratio' attribute will be added ad inline style.
     * @param boolean $decodingAsync Makes image decoding asynchronous and does not block the main thread.
     * @param boolean $fetchPriority To indicate that resource loading should be prioritized over others.
     * @param array $dataAttributes An associative array which includes data attribute name and value. For instance -> array('test' => '1') would be converted in data-test="1".
     * @param boolean $addFigcaption If true, the image HTML structure will be as follows -> <figure><img><figcaption></figcaption></figure>.
     * @param string $figureClass The CSS class to apply to the figure tag in case $addFigcaption attribute is set to true.
     * @return HTMLElement The generated image tag.
     */

    function generate_image_tag($payload)
    {
        $defaults = array(
            'image' => null,
            'sizes' => '',
            'class' => '',
            'lazyClass' => 'g--lazy-01',
            'isLazy' => true,
            'showAspectRatio' => true,
            'decodingAsync' => true,
            'fetchPriority' => false,
            'dataAttributes' => false,
            'addFigcaption' => false,
            'figureClass' => 'media-wrapper'
        );

        $payload = wp_parse_args($payload, $defaults);

        $is_acf_array = is_array($payload['image']);

        if (!$is_acf_array) {
            $main_featured_image = wp_get_attachment_image_src($payload['image']);
            $main_featured_image_full = wp_get_attachment_image_src($payload['image'], 'full');
        }

        $url = $is_acf_array ? $payload['image']['url'] : $main_featured_image[0];
        $class = $payload['isLazy'] ? $payload['class'] . ' ' . $payload['lazyClass'] : $payload['class'];
        $is_svg = strtolower(pathinfo($url, PATHINFO_EXTENSION)) === 'svg';
        $alt_url = $is_acf_array ? $payload['image']['url'] : $main_featured_image_full[0];
        $caption = $is_acf_array ? $payload['image']['caption'] : wp_get_attachment_caption($payload['image']);
        $src = $payload['isLazy'] ? get_placeholder_image() : $url;
        $small = $is_acf_array ? $payload['image']['sizes']['thumbnail'] : wp_get_attachment_image_src($payload['image'], 'thumbnail')[0];
        $medium = $is_acf_array ? $payload['image']['sizes']['medium'] : wp_get_attachment_image_src($payload['image'], 'medium')[0];
        $large = $is_acf_array ? $payload['image']['sizes']['large'] : wp_get_attachment_image_src($payload['image'], 'large')[0];
        $tablets = $is_acf_array ? $payload['image']['sizes']['tablets'] : wp_get_attachment_image_src($payload['image'], 'tablets')[0];
        $mobile = $is_acf_array ? $payload['image']['sizes']['mobile'] : wp_get_attachment_image_src($payload['image'], 'mobile')[0];

        if ($is_svg) {
            $svg = simplexml_load_file($url);
            $viewBox = explode(" ", (string) $svg['viewBox']);
            $width = $viewBox[2];
            $height = $viewBox[3];
        } else {
            $width = $is_acf_array ? $payload['image']['width'] : $main_featured_image[1];
            $height = $is_acf_array ? $payload['image']['height'] : $main_featured_image[2];
        }

        $aspect_ratio = "$width / $height";

        switch ($payload['sizes']) {
            case 'large':
                $sizesResult = '100vw';
                break;
            case 'medium':
                $sizesResult = '(max-width: 810px) 95vw, 50vw';
                break;
            case 'small':
                $sizesResult = '(max-width: 810px) 95vw, 33vw';
                break;
            case '':
                $sizesResult = '95vw';
                echo "<p style='color: red'>Please, 'sizes' attribute is required for generate_image_tag.</p>";
                break;

            default:
                $sizesResult = $payload['sizes'];
                break;
        }

        $html = $payload['addFigcaption'] && $caption ? '<figure class="' . $payload['figureClass'] . '">' : '';

        if ($payload['showAspectRatio']) {
            $html .=
                '<img src="' . $src . '" alt="' . get_alt_image($alt_url) . '" width="' . $width . '" height="' . $height . '"
        style="aspect-ratio:' . $aspect_ratio . '" class="' . $class . '"';
        } else {
            $html .=
                '<img src="' . $src . '" alt="' . get_alt_image($alt_url) . '" width="' . $width . '" height="' . $height . '" class="' . $class . '"';
        }

        if (!$is_svg && $payload['isLazy'] == false) {
            $html .= ' srcset="' . $url . ' ' . $width . 'w, ' . $large . ' 1024w, ' . $tablets . ' 810w, ' . $mobile . ' 580w, ' . $medium . ' 300w, ' . $small . ' 150w" sizes="' . $sizesResult . '"';
        }

        if (!$is_svg && $payload['isLazy'] == true) {
            $html .= ' data-srcset="' . $url . ' ' . $width . 'w, ' . $large . ' 1024w, ' . $tablets . ' 810w, ' . $mobile . ' 580w, ' . $medium . ' 300w, ' . $small . ' 150w" sizes="' . $sizesResult . '"';
        }

        if ($payload['isLazy']) {
            $html .= ' data-src="' . $url . '"';
        }

        if ($payload['decodingAsync']) {
            $html .= ' decoding="async"';
        }

        if ($payload['fetchPriority']) {
            $html .= 'fetchpriority="high"';
        }

        if (is_array($payload['dataAttributes'])) {
            foreach ($payload['dataAttributes'] as $key => $value) {
                $html .= ' data-' . $key . '="' . $value . '"';
            }
        }

        $html .= '/>';

        if ($payload['addFigcaption'] && $caption) {
            $html .= '<figcaption>' . esc_html($caption) . '</figcaption></figure>';
        }

        echo $html;
    }

    /**
     * Helper function.
     * Generate taxonomy dropdown.
     */
    function generate_taxonomy_dropdown($taxonomy, $taxonomySlug, $class)
    {
        $terms = get_terms(
            array(
                'taxonomy' => $taxonomy,
                'hide_empty' => true,
            )
        );
        $html = '<select data-taxonomy="' . $taxonomy . '" data-taxonomy-slug="' . $taxonomySlug . '" class="' . $class . '">
                <option value="all">Select ' . $taxonomySlug . '...</option>';

        foreach ($terms as $term) {
            $selected = $term->slug === htmlspecialchars($_GET[$taxonomySlug]) ? 'selected' : '';
            $html .= '<option value="' . $term->slug . '" ' . $selected . '>' . $term->name . '</option>';
        }

        $html .= '</select>';

        echo $html;
    }

    //hide posts
    function post_remove()
    {
        remove_menu_page('edit.php');
    }

    add_action('admin_menu', 'post_remove');

    /**
     *  RETURNS THE Placeholder image from Theme Options
     *  @author: Nerea
     */
    function get_placeholder_image()
    {
        return get_field('placeholder_image', 'option');
    }

    function my_manage_columns($columns)
    {
        unset($columns['wpseo-score']);
        unset($columns['wpseo-title']);
        unset($columns['wpseo-metadesc']);
        unset($columns['wpseo-focuskw']);
        unset($columns['wpseo-score-readability']);
        unset($columns['wpseo-links']);
        unset($columns['wpseo-linked']);
        return $columns;
    }

    function my_column_init()
    {
        /* remove from posts */
        add_filter('manage_edit-post_columns', 'my_manage_columns');
        /* remove from posts */
        add_filter('manage_edit-page_columns', 'my_manage_columns');
        // add_filter ( 'manage_edit-custom_post_type_columns', 'my_manage_columns' );
    }

    add_action('admin_init', 'my_column_init');

    // Register admin page options
    if (function_exists('acf_add_options_page')) {

        acf_add_options_page(array(
            'page_title'     => 'General Options',
            'menu_title'    => 'General Options',
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
            'redirect'        => false
        ));
    }

    ?>