<?php
$past_gigs = $_GET["past"];
$delete_id = $_GET["delete_id"];

// if updating, retrieve the record on first load
if ( isset( $delete_id ) ) {
  $return_message = "";
  gigblaster_delete_gig( $delete_id ) ? $return_message = "Gig deleted." : $return_message = "Problem deleting record!";
  echo "<div class='wrap'><div class='updated'>" . $return_message . "</div></div>";
}

?>
<div class="wrap">
  <h2>Gigs</h2>
  <div class="tablenav top">
      <div class="alignleft actions">
          <a href="<?php echo admin_url('admin.php?page=gigblaster_gigs'); ?>">Upcoming Gigs</a> |
          <a href="<?php echo admin_url('admin.php?page=gigblaster_gigs&past=true'); ?>">Past Gigs</a>
      </div>
      <br class="clear">
  </div>
  <?php
    if ($past_gigs) {
      echo "<h3>Past Gigs</h3>";
      $rows = gigblaster_get_past_gigs();
    }
    else {
      echo "<h3>Upcoming Gigs</h3>";
      $rows = gigblaster_get_upcoming_gigs();
    }
  ?>
  <table class='wp-list-table widefat fixed striped posts'>
      <tr>
          <th class="manage-column ss-list-width">Title</th>
          <th class="manage-column ss-list-width">Start Time</th>
          <th class="manage-column ss-list-width">Description</th>
          <th class="manage-column ss-list-width">Actions</th>
      </tr>
      <?php foreach ($rows as $row) { ?>
          <tr>
              <td class="manage-column ss-list-width"><?php echo truncate_for_display( $row->title ); ?></td>
              <td class="manage-column ss-list-width"><?php echo format_date( $row->start_time ); ?></td>
              <td class="manage-column ss-list-width"><?php echo truncate_for_display( $row->description ); ?></td>
              <td>
                <a href="<?php echo admin_url('admin.php?page=gigblaster_add_gig&edit_id=' . $row->id); ?>">Edit</a> |
                <a href="<?php echo admin_url('admin.php?page=gigblaster_gigs&delete_id=' . $row->id); ?>" onclick="return confirm('Positive?')">Delete</a>
              </td>
          </tr>
      <?php } ?>
  </table>
</div>
