<?php

get_header(); 
pageBanner(
  array(
  'photo' => get_theme_file_uri('/images/connection.jpg'),
  'title' => 'All Companies',
  'subtitle' => 'See all of our companies who joined us'
  ))?>

    <div class="container container--narrow page-section">
    <ul class="link-list min-list">
    <?php 
    while(have_posts()) {
      the_post(); 
      ?>
    <li><a href="<?php the_permalink(); ?>"><?php the_title();  
    ?></a></li>
    <?php }
    echo paginate_links();
    ?>
    </ul>
<?php 
get_footer();

?>