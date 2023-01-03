<?php

get_header(); 
pageBanner(array(
  'title' => 'All Locations',
  'subtitle' => 'See all of our company locations'
  ))?>

    <div class="container container--narrow page-section">
    <div class="acf-map">
    <?php 
    while(have_posts()) {
      the_post(); 
      $mapLocate = get_field('map_location'); 
      ?>
    <div class="marker" data-lat="<?php echo $mapLocate['lat'] ?>"
    data-lng="<?php echo $mapLocate['lng']; ?>"></div>
    
    <?php }
    echo paginate_links();
    ?>
    </div>
<?php
get_footer();

?>