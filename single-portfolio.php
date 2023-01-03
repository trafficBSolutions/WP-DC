<?php
get_header();
while (have_posts()){
    the_post(); 
    pageBanner();
    ?>
   
    <div class="container container--narrow page-section">
    
    
        <div class="generic_content">
            <div class="row group">
                <div class="one-third">  
                    <?php the_post_thumbnail('dcPortrait'); ?>      
    </div>
    <div class="two-thirds">
        <?php the_field('main') ?>
</div>
    </div>
    </div>

        <?php 
        $dcHosts = get_field('company_port');

        if($dcHosts) {
          echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Company</h2>';
        echo '<ul class="link-list min-list">';
        foreach($dcHosts as $companies) { ?>
          <li><a href="<?php echo get_the_permalink($companies); ?>">
          <?php echo get_the_title($companies); ?></a></li>
        <?php }
        echo '</ul>';
        ?>
</div>
        

        
<?php }
}
get_footer();
?>