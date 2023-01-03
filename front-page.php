<?php get_header(); ?>
<div class="page-banner">
<div class="page-banner__bg-image" style="background-image: url('<?php echo get_theme_file_uri('images/connection.jpg'); ?>'); height:579px;width:100%;"></div>
      <div class="page-banner__content container t-center c-white">
        <h1 class="headline headline--large">Direct Connection</h1>
        <?php if(is_user_logged_in()) {
          ?><a href="<?php echo get_post_type_archive_link('company') ?>" 
          class="btn btn--large btn--blue">Companies</a>
          <?php 
          }
          else { ?>
            <a href="<?php echo site_url('/add-your-company-to-our-website') ?>" class="btn btn--large btn--blue">Add Your Company</a>
         <?php }

          ?>
        <div class="row">
        <div class="col-xs-12 col-md-10 col-md-offset-1-text-center white">

          <h1>What DC has to offer</h1>
              <p>DC is a company that makes connecting faster, easier and more convenient. We can help you and your company to get your personal
                 or business name out there. We are the first Online Company convention center. 
                You will find yourself traveling through a variety of companies that you can interact with online. You
                can locate a company and immediately request open bids on projects, connect with different departments through the company, send payment and receive payment, 
                find the next date that company will be interacting and do live meetings and marketing via zoom, webinars, skype and much more. Think as if you just saved yourself hours on
                 end locating your next company project and add a few members to your team along the way.    
                Find what request application forms and highly qualified employees  connected to Companies that Qualified employees,  future investors, employees
                  with  other swap company information swap, quotes send quotes, futuristic, billing processing. DC connections can help get companies` portfolios easily available.</p>
        </div>
      </div>

      <div class="full-width-split group">
        <div class="full-width-split__one">
          <div class="full-width-split__inner">
          <div style="color: Black;"> 
            <h2 class="headline headline--small-plus t-center">Upcoming Events</h2></div>

            <?php 
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
                )
              )
            ));
            while($homepageEvents->have_posts()) {
              $homepageEvents->the_post(); 
              get_template_part('template-parts/content', 'event');
            }
            ?>

          
          <?php if(is_user_logged_in()) {
            ?>
            <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event'); ?>"
            class="btn btn--blue">View All Events</a></p>
          <?php }
          ?>
        </div>
      </div>
        <div class="full-width-split__two">
        <div class="full-width-split__inner">
          <div style="color: Black;">
          <h2 class="headline headline--small-plus t-center">From Our Blogs</h2></div>
          <?php 
          $homepagePosts = new WP_Query(array(
            'posts_per_page' => 2
          ));
          while($homepagePosts->have_posts()) {
            $homepagePosts->the_post(); ?>
            
            <?php if(is_user_logged_in()) {
              ?>
              <div class="event-summary">
            <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
              <span class="event-summary__month"><?php the_time('M'); ?></span>
              <span class="event-summary__day"><?php the_time('d'); ?></span>
            </a>
            <div class="event-summary__content container t-left">
              <h5 class="event-summary__title headline headline--tiny">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
              <div style="color: Black;">
              <p><?php if(has_excerpt()) {
                echo get_the_excerpt();
              } else{
                echo wp_trim_words(get_the_content(), 18);
              }?></div>
              <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
            </div>
          </div>
         <?php } 
         else {
          ?>
          <div class="event-summary">
            <a class="event-summary__date event-summary__date--beige t-center">
              <span class="event-summary__month"><?php the_time('M'); ?></span>
              <span class="event-summary__day"><?php the_time('d'); ?></span>
            </a>
            <div class="event-summary__content container t-left">
              <h5 class="event-summary__title headline headline--tiny">
              <div style="color: Black;">
              <?php the_title(); ?></h5></div>
              <div style="color: Black;">
              <p><?php if(has_excerpt()) {
                echo get_the_excerpt();
              } else{
                echo wp_trim_words(get_the_content(), 18);
              }?></div>
              </p>
            </div>
          </div>
         <?php } 
         wp_reset_postdata();
         ?>
         <?php } ?>

            
<?php get_footer(); 
?>