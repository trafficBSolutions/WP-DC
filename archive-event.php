<?php

get_header(); 
pageBanner(array(
  'title' => 'All Events',
  'subtitle' => 'See all of our events we have to offer'
));
?>

    
    <div class="container container--narrow page-section">
    <?php 
    while(have_posts()) {
      the_post(); 
      get_template_part('template-parts/content-event');
    }
    echo paginate_links();
    ?>
    <hr class="section-break">
    <a href="<?php echo site_url('/wp-admin/post-new.php?post_type=event') ?>" class="btn btn--large btn--blue">Add Event</a>
    <a href="<?php echo site_url('/past-events') ?>" class="btn btn--large btn--blue">Past Events</a>
    </div>
<?php
get_footer();

?>