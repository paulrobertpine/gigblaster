<?php
/**
 * Plugin Name: Gig Blaster
 * Description: A simple gigs plugin
 * Version: 0.1
 * Author: Paul Clifford
 */
define( "GIGBLASTER_TABLE_NAME", "gigblaster" );
define( "DATE_FORMAT", "Y-m-d H:i" );
require_once('admin/functions.php');

/**
 * Setup
 */
register_activation_hook( __FILE__ , 'gigblaster_install' );

function gigblaster_install() {
  global $wpdb;
  $table_name = $wpdb->prefix . GIGBLASTER_TABLE_NAME;

  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    start_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    description text,
    UNIQUE KEY id (id)
  )CHARSET=utf8 ";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  $ret = dbDelta( $sql );
}

/**
 * Shortcode [gigblaster]
 */
add_shortcode( 'gigblaster' , 'gigblaster_display_gigs' );

function gigblaster_display_gigs() {
  global $wpdb;
  $gigs = gigblaster_get_upcoming_gigs();
  $public_date_format = "D, M.j, Y - g:ia"; // Sunday November 4th -- 6:00pm

  wp_enqueue_style( 'gigblaster_styles', plugin_dir_url( __FILE__ ) . 'css/style.css' );
  wp_register_script( 'gigblaster_script', plugin_dir_url( __FILE__ ) . 'js/gigblaster.js', array('jquery'));
  wp_enqueue_script( 'gigblaster_script' );

  echo "<ul class='gigblaster'>";

  foreach ($gigs as $gig) {
    echo "<li>";
    echo "<div class='gig-time'>" . date( $public_date_format, strtotime( $gig->start_time ) ) . "</div>";
    echo "<div class='gig-title'>" . $gig->title . "</div>";
    if ( $gig->description ) { echo "<div class='gig-description-button'>&nbsp;</div>" . // &nbsp; is important here
      "<div class='gig-description-text'>" . $gig->description . "</div>";
    }
    echo "</li>";
  }

  echo "</ul>";
}

/**
 * Menu
 */
add_action( 'admin_menu' , 'gigblaster_build_admin_menu' );

// admin menu
function gigblaster_build_admin_menu() {

  add_menu_page(
    'Gigs', // page title
    'Gigs', // menu title
    'manage_options', //capability
    'gigblaster_gigs', // menu slug
    'gigblaster_gigs', // function
    'dashicons-format-audio', // music icon
    40 // location in sidebar
  );

  add_submenu_page(
    'gigblaster_gigs', // parent slug
    'Add Gig', // page title
    'Add New', // menu title
    'manage_options', // capability
    'gigblaster_add_gig', // menu slug
    'gigblaster_add_gig' // function
  );
}

// menu callbacks
function gigblaster_gigs() {
	require_once plugin_dir_path( __FILE__ ) . 'admin/view_gigs.php';
}

function gigblaster_add_gig() {
	require_once plugin_dir_path( __FILE__ ) . 'admin/add_update_gig.php';
}
