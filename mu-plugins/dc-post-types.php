<?php
function dc_post_types(){

// Companies Post Type
register_post_type('company', array(
  'show_in_rest' => true,
  'supports' => array('title', 'editor'),
  'rewrite' => array('slug' => 'companies'),
  'has_archive' => true,
  'public' => true,
  'labels' => array(
  'name' => 'Companies',
  'add_new_item' => 'Add New Company',
  'edit_item' => 'Edit Company',
  'all_items' => 'All Companies',
  'singular_name' => 'Companies'
),

'menu_icon' => 'dashicons-building'
));

// Portfolio Post Type
register_post_type('portfolio', array(
'show_in_rest' => true,
'supports' => array('title', 'thumbnail'),
'public' => true,
'labels' => array(
'name' => 'Portfolios',
'add_new_item' => 'Add New Portfolio',
'edit_item' => 'Edit Portfolio',
'all_items' => 'All Portfolios',
'singular_name' => 'Portfolios'
),

'menu_icon' => 'dashicons-analytics'
));

// Location Post Type
register_post_type('location', array(
'show_in_rest' => true,
'supports' => array('title', 'editor', 'excerpt'),
'rewrite' => array('slug' => 'locations'),
'has_archive' => true,
'public' => true,
'labels' => array(
'name' => 'Locations',
'add_new_item' => 'Add New Location',
'edit_item' => 'Edit Location',
'all_items' => 'All Locations',
'singular_name' => 'Locations'
),

'menu_icon' => 'dashicons-location-alt'
));
// Event Post Type
  register_post_type('event', array(
    'show_in_rest' => true,
    'capability_type' => 'event',
    'map_meta_cap' => true,
    'supports' => array('title', 'editor', 'excerpt'),
    'rewrite' => array('slug' => 'events'),
    'has_archive' => true,
    'public' => true,
    'labels' => array(
    'name' => 'Events',
    'add_new_item' => 'Add New Event',
    'edit_item' => 'Edit Event',
    'all_items' => 'All Events',
    'singular_name' => 'Event'
  ),
  'menu_icon' => 'dashicons-calendar'
));
}
add_action('init', 'dc_post_types');
?>