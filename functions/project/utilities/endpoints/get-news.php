<?php

/**
 * Registers AJAX actions for loading more posts.
 * 
 * This code snippet adds two AJAX actions for loading additional posts: one for visitors
 * and one for logged-in users. Both actions trigger the `load_more` function, which 
 * handles retrieving and rendering posts dynamically based on the provided parameters.
 */

add_action('wp_ajax_nopriv_load_more', 'load_more');
add_action('wp_ajax_load_more', 'load_more');

/**
 * Handles the loading of more posts for AJAX requests.
 * 
 * This function processes the request to load additional posts based on parameters such 
 * as the number of posts per page, offset, search term, and taxonomies. It uses WP_Query 
 * to fetch the posts and outputs the rendered HTML for these posts along with the total 
 * number of published posts.
 */

function load_more()
{
  ob_start();

  $postsPerPage = $_REQUEST['postPerPage'];
  $offset = $_REQUEST['offset'];
  $searchTerm = $_REQUEST['searchTerm'];
  $taxonomies = $_REQUEST['taxonomies'];
  $disable_lazy_loading_image = true;

  global $my_query;
  $my_query = new WP_Query($myArgs);

  $myArgs = array(
    'post_type' => 'news',
    'offset' => $offset,
    'posts_per_page' => $postsPerPage,
    'orderby' => 'date',
    'order' => 'DESC',
  );

  if ($taxonomies && count($taxonomies) > 0) {
    $myArgs['tax_query'] = array(
      'relation' => 'AND',
    );

    foreach ($taxonomies as $tax) {
      $taxonomy = key($tax);
      $term = current($tax);

      $myArgs['tax_query'][] = array(
        'taxonomy' => $taxonomy,
        'field' => 'slug',
        'terms' => $term
      );
    }
  }

  $my_query->query($myArgs);

  $myArgs['posts_per_page'] = -1;
  $myArgs['offset'] = 0;
  $posts_count = get_posts($myArgs);
  $published_posts = count($posts_count);
  $index = 0;
  ?>

  <?php while ($my_query->have_posts()) :
      $my_query->the_post(); ?>
     <?php
          $title = get_the_title();
          $subtitle = get_the_date('M j, Y', get_the_ID());
          $is_external = has_term('external', 'news-type', $post->ID);
          $url = $is_external ? get_field('link')['url'] : get_the_permalink();
          ?>
  <?php include(locate_template('components/card/card-e.php', false, false)); ?>
  
  <?php endwhile; ?>

  <?php wp_reset_postdata();

    $content = ob_get_contents();
    $response = array(
      'html' => $content,
      'postsTotal' => $published_posts,
    );
    ob_end_clean();

    echo json_encode($response);
    die();
  }
