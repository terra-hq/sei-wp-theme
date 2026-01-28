<?php 

/**
 *  Redirects the user to the homepage when visiting these post types
 *  @author: Eli
 */

 function redirect_config()
 {
     $queried_post_type = get_query_var('post_type');
     $queried_id = get_queried_object_id();
     $queried_post = get_post($queried_id);
     $term_obj_list = get_the_terms( $queried_id, 'insight-types' );
     $terms_string = ( $term_obj_list) ? join(', ', wp_list_pluck($term_obj_list, 'slug')) : '';  
     if ( is_single() && 'insight' ==  $queried_post_type) {
         if( isset($terms_string) ){
             if ($terms_string == 'case-study' && get_field('case_study_type', $queried_id) == "external"){
                 $principalUrl  = esc_url( home_url( '/' ) ). 'insights';
                 wp_redirect($principalUrl, 301 );
                 exit;
             }
         }
     }
    if ( is_single() && 'case-study' ==  $queried_post_type) {
        if (get_field('case_study_type', $queried_id) == "external"){
            $principalUrl  = esc_url( home_url( '/' ) ). 'success-stories';
            wp_redirect($principalUrl, 301 );
            exit;
        }
    }

     if (is_single() && 'news' == $queried_post_type) {
        // Verificar si el post tiene la taxonomía 'type' y que no sea 'internal'
        $terms = get_the_terms(get_the_ID(), 'news-type');

        if ($terms && !is_wp_error($terms)) {
            $redirect = true;

            foreach ($terms as $term) {
                if ($term->slug === 'internal') {
                    $redirect = false;
                    break;
                }
            }

            if ($redirect) {
                $principalUrl = esc_url(home_url('/news'));
                wp_redirect($principalUrl, 301);
                exit;
            }
        } else {
            // Si no tiene términos asociados o hay un error, hacer el redireccionamiento
            $principalUrl = esc_url(home_url('/news'));
            wp_redirect($principalUrl, 301);
            exit;
        }
    }
 
     if ( is_single() && 'people' ==  $queried_post_type) {
         $principalUrl  = esc_url( home_url( '/about/leadership/' ) );
         wp_redirect($principalUrl, 301 );
         exit;
     }
     
     if ( is_single() && 'awards' ==  $queried_post_type) {
         $principalUrl  = esc_url( home_url( '/about/about-sei/awards-and-recognition/' ) );
         wp_redirect($principalUrl, 301 );
         exit;
     }
 
     if (is_page('about')) {
         $principalUrl  = esc_url(home_url('/about/about-sei/'));
         wp_redirect($principalUrl, 301);
         exit;
     }
     if (is_single() && 'functions' ==  $queried_post_type) {
        if(!get_field('heros')){
            $principalUrl  = esc_url(home_url('/functions/'));
            wp_redirect($principalUrl, 301);
            exit;
        }
     }
 }
 add_action('template_redirect', 'redirect_config'); ?>