<?php
$edit_id = $_GET["edit_id"];
$return_message = "";
$field_array = array(
	"title" => sanitize($_POST['title']),
	"start_time" => sanitize($_POST['start_time']),
	"description" => stripslashes($_POST['description'])
);

// if updating, retrieve the record on first load
if ( isset( $edit_id ) && !isset($_POST['submit']) ) {

	$gigs = gigblaster_get_gig( $edit_id );

	foreach ($gigs as $gig) {
		$field_array["title"] = $gig->title;
		$field_array["start_time"] = format_date( $gig->start_time );
		$field_array["description"] = $gig->description;
	}
}

// echo "<pre>" . print_r($field_array) . "</pre>";

/**
 * validation
 */
if( isset($_POST['submit']) ) {

	if( empty( $field_array["title"] ) ) {
		$return_message .= "Please enter a title <br>";
	}

	if( empty( $field_array["start_time"] ) ) {
		$return_message .= "Please enter a start time <br>";
	} elseif ( !validate_date( $field_array["start_time"] ) ) {
		$return_message .= "Date/Time should be in the following format: yyyy-mm-dd HH:MM <br/>";
	}

	if ( $return_message === "" ) { // go ahead and write to DB

		if ( !isset( $edit_id ) ) { // create
			gigblaster_create_gig( $field_array ) ? $return_message = "New gig added" : $return_message = "Problem adding new record!";
			echo "<div class='wrap'><div class='updated'>" . $return_message . "</div></div>";
			exit;
		} else { // update
			gigblaster_update_gig( $field_array, $edit_id ) ? $return_message = "Gig updated" : $return_message = "Problem updating record! (did you actually change any values?)";
		}
	}
}

// echo $return_message;
?>
<div class="wrap">
	<h2><?php echo ( isset( $edit_id ) ) ? 'Edit Gig' : 'Add Gig'; ?></h2>

	<?php if( $return_message != "" ) {
		echo "<div class='updated'>" . $return_message . "</div>";
	}	?>

	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="title">Title *</label></th>
					<td><input class="regular-text ltr" type="text" id="title" name="title" value="<?php echo $field_array["title"]; ?>"/></td>
				</tr>
				<tr>
					<th><label for="start_date">Date &amp; Time *</label></th>
					<td>
						<input class="regular-text ltr" type="text" id="start_time" name="start_time" value="<?php echo $field_array["start_time"]; ?>"/>
						<p>yyyy-mm-dd HH:MM</p>
					</td>
				</tr>
				<tr>
					<th><label for="description">Description</label></th>
					<td>
						<?php wp_editor( $field_array["description"], 'description', array( 'media_buttons' => true ) ); ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" class="button-primary" name="submit" value="<?php echo isset( $edit_id ) ?  'Update Gig' : 'Add Gig'; ?>"/>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
