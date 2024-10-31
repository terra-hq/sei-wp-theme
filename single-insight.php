<?php get_header() ?>

<section class="f--pt-15 f--pt-tablets-10 f--pb-15 f--pb-tablets-10">
  <div class="f--container">
    <div class="f--row">
      <div class="f--col-12">
        <a href="<?php echo esc_url(home_url('/insights')) ?>" class="c--back-link-a f--mb-10">Back to All Insights</a>
        <?php
        $insight_types = get_the_terms(get_the_ID(), 'insight-types');
        if ($insight_types && !is_wp_error($insight_types)) {
          $insight_type = $insight_types[0];
          $insight_type_name = $insight_type->name;
          echo '<p class="f--font-i f--color-c u--text-uppercase u--letter-spacing-a u--font-medium f--mb-3">' . esc_html($insight_type_name) . '</p>';
        }
        ?>
      </div>
    </div>
    <div class="f--row u--justify-content-space-between f--gap-a">
      <div class="f--col-7 f--col-tablets-12">
        <h1 class="f--font-c f--sp-c"><?php the_title() ?></h1>
        <p class="f--font-h"><span class="u--opacity-6"><?php echo get_the_date('M j, Y', get_the_ID()) ?></span> <span class="u--opacity-6">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
          <span class="u--opacity-6">By</span>
          <?php $authors = get_field('author');
          if ($authors) {
            $output = '';
            $total_authors = count($authors);
            foreach ($authors as $index => $author) {
              if ($index == $total_authors - 1 && $total_authors > 1) {
                $output .= ' and ';
              } elseif ($index > 0) {
                $output .= ', ';
              }
              $output .= '<a target="_blank" href="' . get_field('linkedin_link', $author->ID) . '" class="g--link-01 g--link-01--fourth">' . $author->post_title . '</a>';
            }
            echo $output;
          } ?>
        </p>
        <?php $topics = get_the_terms(get_the_ID(), 'topics');
        if ($topics && !is_wp_error($topics)) {
          ?><div class="c--list-a f--pt-4 f--pt-tablets-3"><?php
          foreach ($topics as $topic) {
            $topic_name = $topic->name;
            $topic_slug = $topic->slug;
            $topic_link = get_term_link($topic);
            echo '<a href="' . esc_url(home_url('/insights/?topic=' . $topic_slug)) . '" class="c--list-a__item g--pill-01 g--pill-01--third">' . esc_html($topic_name) . '</a>';
          }
          ?></div><?php
        } ?>
        <article class="f--pt-8 f--pt-tablets-5 f--pb-4">
          <div class="c--content-a">
            <?php the_content() ?>
          </div>
        </article>
        <div class="c--border-a f--pt-4 u--display-flex u--align-items-center">
          <p class="f--font-i f--color-c f--mr-1">Share on</p>
          <?php include(locate_template('components/social/social-a--second.php', false, false)); ?>
        </div>
      </div>
      <div class="f--col-4 f--col-tabletl-5 f--col-tablets-12">
        <?php if(get_field('subscribe_form_id', 'option') && get_field('subscribe_form_portal', 'option')): ?>
          <div class="c--form-b">
          <h2 class="c--form-b__title"><?php echo get_field('subscribe_form_title', 'option') ?></h2>
          <div class="js--hubspot-script" data-form-id="<?php echo get_field('subscribe_form_id', 'option') ?>" data-portal-id="<?php echo get_field('subscribe_form_portal', 'option') ?>"></div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php
$btn = get_field('related_section_button', 'option');
$spacing = 'f--pb-8 f--pb-tablets-5';
$title = get_field('related_section_title', 'option');
include(locate_template('components/heading/heading-a.php', false, false));
?>

<?php

$args = array(
  'post_type' => 'insight',
  'posts_per_page' => 3,
  'orderby' => 'date',
  'order' => 'DESC',
  'post__not_in' => array(get_the_ID())
);

$custom_query = new WP_Query($args);

if ($custom_query->have_posts()) :
  ?>

  <section class="f--pb-15 f--pb-tablets-10">
    <div class="f--container">
      <div class="f--row f--gap-a">
        <?php
          while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
          <div class="f--col-4 f--col-tablets-6 f--col-mobile-12 <?php echo ($custom_query->current_post == $custom_query->post_count - 1) ? 'u--display-tablets-none u--display-mobile-block' : '' ?>">
            <?php
            $insight_types = get_the_terms(get_the_ID(), 'insight-types');
            if ($insight_types && !is_wp_error($insight_types)) {
              $insight_type = $insight_types[0];
              $insight_type_name = $insight_type->name;
            }
            $title = get_the_title();
            $topics = get_the_terms(get_the_ID(), 'topics');
            $permalink = get_the_permalink();
            $image = get_post_thumbnail_id(get_the_ID());
                include(locate_template('components/card/card-24.php', false, false));
              ?>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </section>


<?php
  wp_reset_postdata();
endif;
?>

<?php get_footer() ?>