<?php




require get_theme_file_path('/inc/search-route.php');

function dc_custom_rest() {
register_rest_field('post', 'authorName', array(
  'get_callback' => function() {
    return get_the_author();
  }
));
}

add_action('rest_api_init', 'dc_custom_rest');

function pageBanner($args = []){
  
  if(!array_key_exists('title', $args)){
    $args['title'] = get_the_title();
  }
  if(!array_key_exists('subtitle', $args)){
    $args['subtitle'] = get_field('page_banner_subtitle');
  }
  if(!array_key_exists('photo', $args)){
    if(get_field('page_banner_background_image')){
      $args['photo'] =  get_field('page_banner_background_image')['sizes']['pageBanner'];
    }else{
      $args['photo'] = get_theme_file_uri('/images/connection.jpg');
    }
  }

  ?>
   <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url('<?php 
      echo $args['photo']; ?>');"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
        <div class="page-banner__intro">
            <p><?php echo $args['subtitle']; ?></p>
        </div>
      </div>
    </div>

<?php }



function load_stylesheets()
{
wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyA_k8ttnvmjDgg-pfXQ6qXHVZAE9TKMUR4', NULL, '1.0', true);
wp_enqueue_script('live-search-javascript', get_theme_file_uri('/js/modules/Search.js'), array('jquery'), '1.0', true);
wp_enqueue_script('myNotes-javascript', get_theme_file_uri('/js/modules/MyNotes.js'), array('jquery'), '1.0', true);
wp_enqueue_script('main-dc-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
wp_enqueue_style('custom-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
wp_enqueue_style('traffic_main_styles', get_theme_file_uri('/build/style-index.css'));
wp_enqueue_style('traffic_extra_styles', get_theme_file_uri('/build/index.css'));

wp_localize_script('main-dc-js', 'dcData', array(
  'root_url' => get_site_url()
));

}

add_action('wp_enqueue_scripts', 'load_stylesheets');

function dc_features(){
    
    
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('dcLandscape', 400, 260, true);
    add_image_size('dcPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}
add_action('after_setup_theme', 'dc_features');

function dc_adjust_queries($query) {
  if(!is_admin() AND is_post_type_archive('company') AND is_main_query()) {
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
  }

  if(!is_admin() AND is_post_type_archive('event') AND 
  $query->is_main_query()) {
    $today = date('Ymd');
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', array(
      array(
        'key' => 'event_date',
        'compare' => '>=',
        'value' => $today,
        'type' => 'numeric'
      )
    ));
  }
}
add_action('pre_get_posts', 'dc_adjust_queries');

function dcMapKey($api) {
  $api['key'] = 'AIzaSyA_k8ttnvmjDgg-pfXQ6qXHVZAE9TKMUR4';
  return $api;
}

add_filter('acf/fields/google_map/api', 'dcMapKey');
// Redirect subscriber accounts out of admin and onto homepage
function redirectSubsToFrontEnd() {
    $ourCurrentUser = wp_get_current_user();
   if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] ==
   'subscriber') {
     wp_redirect(site_url());
    exit;
    }
    add_action('admin_init', 'redirectSubsToFrontEnd');
 }

 function noSubs() {
  $ourCurrentUser = wp_get_current_user();
 if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] ==
 'subscriber') {
  show_admin_bar(false);
  }
  add_action('wp_loaded', 'noSubs');
}

// Custom log in screen

function ourHeader() {
  return esc_url(site_url('/'));

}

add_filter('login_headerurl', 'ourHeader');

function loginCSS() {
  wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('custom-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('traffic_main_styles', get_theme_file_uri('/build/style-index.css'));
  wp_enqueue_style('traffic_extra_styles', get_theme_file_uri('/build/index.css'));
}

add_action('login_enqueue_scripts', 'loginCSS');

function headerTitle() {
  return get_option('blogname');
}
add_filter('login_headertitle', 'headerTitle');

function contributor_profile($atts)
{
    if (is_user_logged_in() && !is_feed()) {
         $url = um_user_profile_url( get_current_user_id()  );

        return '&nbsp;<span class="profile"><a href="' . $url . '">' . ( 'Edit Profile' ) . '</a></span>';
    }
}
add_shortcode('contributor_profile', 'contributor_profile');