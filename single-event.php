<?php
get_header();
while (have_posts()){
    the_post(); 
    pageBanner();
    ?>

    <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo
        get_post_type_archive_link('event'); ?>"
          ><i class="fa fa-home" aria-hidden="true"></i> Events Home</a> 
          <span class="metabox__main"><?php the_title(); ?></span></p>
          </div>

    
        <div class="generic_content"><?php the_content(); ?></div>

        <?php 
        $dcHosts = get_field('event_host');

        if($dcHosts) {
          echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Event Host(s)</h2>';
        echo '<ul class="link-list min-list">';
        foreach($dcHosts as $companies) { ?>
          <li><a href="<?php echo get_the_permalink($companies); ?>">
          <?php echo get_the_title($companies); ?></a></li>
        <?php }
        echo '</ul>';
        ?>
</div>
        }

        
<?php }
}
get_footer();
?>