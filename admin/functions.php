<?php
/**
 * Functions
 */
function gigblaster_get_upcoming_gigs() {
	global $wpdb;
	$table_name = $wpdb->prefix . GIGBLASTER_TABLE_NAME;
  $query = "SELECT * FROM $table_name WHERE start_time >= NOW() ORDER BY start_time ASC";
	return $wpdb->get_results( $query );
}

function gigblaster_get_past_gigs() {
	global $wpdb;
	$table_name = $wpdb->prefix . GIGBLASTER_TABLE_NAME;
  $query = "SELECT * FROM $table_name WHERE start_time < NOW() ORDER BY start_time DESC";
	return $wpdb->get_results( $query );
}

function gigblaster_get_gig( $id ) {
	global $wpdb;
	$table_name = $wpdb->prefix . GIGBLASTER_TABLE_NAME;
  $query = "SELECT * FROM $table_name WHERE id = $id";
	return $wpdb->get_results( $query );
}

function gigblaster_create_gig( $field_array ) {
	global $wpdb;
	$table_name = $wpdb->prefix . GIGBLASTER_TABLE_NAME;
	return $wpdb->insert( $table_name , $field_array );
}

function gigblaster_update_gig( $field_array, $id ) {
  // echo "<pre>" . print_r($field_array) . "</pre>";
	global $wpdb;
	$table_name = $wpdb->prefix . GIGBLASTER_TABLE_NAME;
  return $wpdb->update( $table_name , $field_array, array( 'ID' => $id ) );
}

function gigblaster_delete_gig( $id ) {
	global $wpdb;
	$table_name = $wpdb->prefix . GIGBLASTER_TABLE_NAME;
  return $wpdb->delete( $table_name, array( 'ID' => $id ) );
}

function sanitize( $data ) {
  $data = trim( $data );
  $data = stripslashes( $data );
  $data = htmlspecialchars( $data );
  return $data;
}

function validate_date( $date ) {
  $d = DateTime::createFromFormat( DATE_FORMAT, $date );
  return $d && $d->format( DATE_FORMAT ) === $date;
}

function format_date( $date ) {
  return date( DATE_FORMAT, strtotime( $date ) );
}

function truncate_for_display( $string ) {
    $length = 100;
    sanitize( $string );

    if( strlen($string) > $length) {
      $string = wordwrap($string, $length);
      $string = explode("\n", $string, 2);
      $string = $string[0] . "...";
    }

    return $string;
}
