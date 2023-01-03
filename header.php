<!DOCTYPE html>
<html <?php  language_attributes(); ?>>
    <head>
      <meta charset="<?php bloginfo('charset'); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header">
      <div class="container">
      <h1 class="school-logo-text float-left"><a href="<?php echo site_url() ?>"><strong>Direct</strong> Connection</a></h1>
       <?php if(is_user_logged_in()) {
        ?>
        <a href="<?php echo esc_url(site_url('/search')); ?>" class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <div class="site-header__menu group">
          <nav class="main-navigation">
            <ul>
              <li <?php if (get_post_type() == 'event' OR is_page('past-events')) echo 'class="current-menu-item"';
              ?>><a href="<?php echo get_post_type_archive_link('event');?>">Events</a></li>
              <li <?php if (get_post_type() == 'post') echo "class='current-menu-item'" 
              ?>><a href="<?php echo site_url('/blog'); ?>">Blogs</a></li>
            </ul>
          </nav>
       <?php } ?>
          <div class="site-header__util">
            <?php if(is_user_logged_in()) { ?>

              <a href="<?php if (is_page() == 'profile') ?>" class="btn 
              btn--small btn--dark-orange float-left push-right">View Profile</a>
              <a href="<?php echo wp_logout_url(); ?>" class="btn
              btn--small btn--orange float-left push-right btn--with-photo">
              <span class="site-header__avatar"><?php 
              echo get_avatar(get_current_user_id(), 60); ?></span>
              <span class="btn__text">Log Out</span>
            </a>
            <?php } else{ ?>
              <a href="<?php echo site_url('/login') ?>" class="btn btn--small btn--orange float-left push-right">Login</a>
           <?php }?>
           <?php if(is_user_logged_in()) {
            ?>
            <span href="<?php echo esc_url(site_url('/search')); ?>" class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
           <?php } ?>
          </div>
        </div>
      </div>
    </header>