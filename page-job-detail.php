<?php
/*
  Template Name: Job Positions Apply
 */
?>

<?php get_header(); ?>

<section class="u--pt-22 u--pt-tablets-15 u--pb-10 u--pb-tablets-7">
  <div class="f--container">
    <div class="f--row">
      <div class="f--col-12">
        <nav class="c--breadcrumbs-a">
          <a href="<?php echo esc_url(home_url('/careers/open-positions/')) ?>" class="c--back-link-a f--font-j">Back to All Open Positions</a>
        </nav>
      </div>
    </div>
  </div>
</section>

<section class="u--pb-22 u--pb-tablets-15">
  <div class="c--greenhouse-content-a">
    <?php $eId = filter_input(INPUT_GET, 'gh_jid', FILTER_SANITIZE_STRING); ?>

    <div id="grnhse_app"></div>
    <script src="https://boards.greenhouse.io/embed/job_board/js?for=seisandbox"></script>
  </div>
  <div class="f--container">
    <div class="f--row u--justify-content-center">
      <div class="f--col-8 f--col-tabletm-10 f--col-tablets-12">
        <?php include(locate_template('components/social/social-a--second.php', false, false)); ?>
      </div>
    </div>
  </div>
</section>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>