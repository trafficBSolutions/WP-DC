<?php
get_header();
while (have_posts()){
    the_post(); 
    pageBanner();
    $mapLocate = get_field('map_location'); 
    ?>
    <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo
        get_post_type_archive_link('company'); ?>"
          ><i class="fa fa-home" aria-hidden="true"></i> All Companies</a> 
          <span class="metabox__main"><?php the_title(); ?></span></p>
          </div>

    
        <div class="generic_content"><?php the_content(); ?></div>

        <?php 
$companyPort = new WP_Query(array(
  'posts_per_page' => -1,
  'post_type' => 'portfolio',
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(

    array(
        'key'=> 'company_port',
        'compare' => 'LIKE',
        'value' => get_the_ID()
    )
  )
));
if($companyPort->have_posts()) {
echo '<hr class="section-break">';
echo '<h2 class="headline headline--medium">' . get_the_title() . ' Portfolio</h2>';

echo '<ul class="professor-cards">';
while($companyPort->have_posts()) {
  $companyPort->the_post(); ?>
  <li class="professor-card__list-item">
    <a class="professor-card" href="<?php the_permalink(); ?>"><?php the_title(); ?>
    <img class="professor-card__image" src="<?php the_post_thumbnail_url('dcLandscape'); ?>">
    <span class="professor-card__name"><?php the_title(); ?></span>
  </a>
  </li>
<?php }
echo '</ul>';
} ?>

<hr class="section-break"></hr>
<h2 class="headline headline--medium">Map</h2>
<div class="acf-map">
  <div class="marker" data-lat="<?php echo $mapLocate['lat'] ?>"
  data-lng="<?php echo $mapLocate['lng']; ?>">
  <h3><?php the_title(); ?></h3>
  <?php echo $mapLocate['address']; ?>
</div>
    </div>

  <?php
wp_reset_postdata();


            $today = date('Ymd');
            $homepageEvents = new WP_Query(array(
              'posts_per_page' => 2,
              'post_type' => 'event',
              'meta_key' => 'event_date',
              'orderby' => 'meta_value_num',
              'order' => 'ASC',
              'meta_query' => array(
                array(
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'numeric'
                ),
                array(
                    'key'=> 'event_host',
                    'compare' => 'LIKE',
                    'value' => get_the_ID()
                )
              )
            ));
           if($homepageEvents->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';

            while($homepageEvents->have_posts()) {
              $homepageEvents->the_post(); 
              get_template_part('template-parts/content-event');
            }
           }
            ?>
</div>
<?php }
get_footer();
?>