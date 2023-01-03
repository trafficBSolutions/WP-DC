<?php
get_header();
pageBanner(array(
  'title' => 'Add Your Company',
)) ?>
<div class="container container--narrow page-section">
  <?php if(is_user_logged_in()) {
    ?> <a href="<?php echo wp_logout_url(); ?>" class="btn btn--large btn--orange float-left push-right">Log Out</a>
  <?php } else { ?>
<h2>Want to join and connect with companies? Sign up and get your company out there:</h2>
        <a href="<?php echo wp_registration_url(); ?>" class="btn btn--large btn--orange float-left push-right">Sign Up</a>
    </div>
      </div>
      <div class="container container--narrow page-section">
      <h2>Have an Account?</h2>
        <a href="<?php echo wp_login_url(); ?>" class="btn btn--large btn--dark-orange float-left push-right">Login</a>
        </div>
</div>
  <?php } ?>
<?php
get_footer();

?>