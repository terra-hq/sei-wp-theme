<?php

/**
 * Registers AJAX actions for loading dynamic header content.
 * 
 * This code snippet registers two AJAX actions: one for logged-in users and one for visitors
 * (non-logged-in users). Both actions trigger the 'load_header_dynamic' function, which loads 
 * dynamic content for the header based on the provided parameters.
 */

add_action('wp_ajax_nopriv_load_header_dynamic', 'load_header_dynamic');
add_action('wp_ajax_load_header_dynamic', 'load_header_dynamic');

function load_header_dynamic()
{
  ob_start();
  $navIndex = $_REQUEST['index'];
  $wrapper = $_REQUEST['wrapper'];
  ?>

  <div class="c--dropdown-a__content">
    <?php echo $wrapper ? "<div class='c--dropdown-a__content__wrapper'>" : '' ;
    $navbar_items = get_field('navbar_items', 'option');
    $navbar_item = $navbar_items[$navIndex];
    ?>

    <?php foreach ($navbar_item['navbar_children'] as $key => $child) : ?>

      <?php if ($child['child_description_icon']) {
            $item_link = $child['child_link']['url'];
            $item_target = $child['child_link']['target'];
            $item_title = $child['child_link']['title'];
            $item_description = $child['child_description'];
            $item_icon = $child['child_icon'];
            include(locate_template('components/card/card-h.php', false, false));
          } else { ?>
        <a href="<?php echo $child['child_link']['url'] ?>" class="c--dropdown-a__content__wrapper__item"><?php echo $child['child_link']['title'] ?></a>
      <?php } ?>
    <?php endforeach; ?>
    <?php echo $wrapper ? "</div>" : '' ?>

    <?php $cta_title = $navbar_item['cta_link']['title'];
      $cta_link = $navbar_item['cta_link']['url'];
      $cta_target = $navbar_itemem['cta_link']['target']; ?>
    <?php include(locate_template('components/cta/cta-d.php', false, false)); ?>
  </div>


<?php $content = ob_get_contents();
  ob_end_clean();
  echo json_encode($content);
  die();
}
?>