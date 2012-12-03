<?php
   /*
   Plugin Name: Casengo Chat Widget
   Plugin URI: http://www.casengo.com/plugins/wordpress
   Description: a plugin to create a Casengo widget into wordpress site
   Version: 1.0
   Author: Casengo
   Author URI: http://www.casengo.com
   License: GPL2
   */

function casengo() {
	
  $cas_domain = get_option('cas_widget_domain');
  $cas_pos = get_option('cas_widget_pos');
  $cas_label = get_option('cas_widget_label');
  $cas_theme = get_option('cas_widget_theme');
  
  // DEFAULT VALUES
  if(!isset($cas_domain)) $cas_domain = 'support';
  if(!isset($cas_pos)) $cas_pos = 'middle-left';
  if(!isset($cas_label)) $cas_label = 'Contact';
  if(!isset($cas_theme)) $cas_theme = 'darkgrey';
  
  // embed script	
  echo '
  		<!--Place this code where you want VIP widget to be rendered -->
		<div class="casengo-vipbtn"><!-- subdomain="' . $cas_domain . '" group="39" label="' . $cas_label . '" position="' . $cas_pos . '" theme="' . $cas_theme . '" --></div>
		<!--Place this code after the last Casengo VIP widget -->
		<script type="text/javascript">
			(function() {
				var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
				po.src = \'//' . $cas_domain . '.casengo.com/apis/vip-widget.js?r=\'+new Date().getTime();
				var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
			})();
		</script>
  ';
}

add_action( 'wp_footer', 'casengo' );

// *** ADMIN

add_action( 'admin_menu', 'my_plugin_menu' );

function my_plugin_menu() {
	add_options_page( 'Casengo Options', 'Casengo', 'manage_options', 'casengoWidgetPlugin', 'casengo_settings' );
}

function casengo_settings() {

  if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

      // variables for the field and option names 
    $opt_name = 'cas_widget_pos';
    $hidden_field_name = 'cas_submit_hidden';
    $data_field_name = 'cas_widget_pos';

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {

        // Save the posted values in the database
        update_option( 'cas_widget_pos', $_POST['cas_widget_pos']);
        update_option( 'cas_widget_domain', $_POST['cas_widget_domain']);
        update_option( 'cas_widget_label', $_POST['cas_widget_label']);
        update_option( 'cas_widget_theme', $_POST['cas_widget_theme']);

        // Put an settings updated message on the screen

?>
<div class="updated"><p><strong><?php _e('settings saved.', 'menu-general' ); ?></strong></p></div>
<?php

    }

    // Now display the settings editing screen
    echo '<div class="wrap">';

    // header
    echo "<h2>" . __( 'Widget options', 'menu-general' ) . "</h2>";

    // settings form
  
    ?>

    <?php
      // Read in existing option value from database
      $opt_val = get_option( 'cas_widget_pos' );
      $opt_theme = get_option( 'cas_widget_theme' );
    ?>

<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("account subdomain:", 'menu-test' ); ?>
<input type="text" name="cas_widget_domain" value="<?php echo get_option('cas_widget_domain') ?>">
<p><?php _e("Position:", 'menu-test' ); ?> 
<select name="<?php echo 'cas_widget_pos'; ?>" value="">
<option <?php if ($opt_val === 'middle-left') echo 'selected="true"' ?> value="middle-left">Middle-left</option>
<option <?php if ($opt_val === 'middle-right') echo 'selected="true"' ?> value="middle-right">Middle-right</option>
<option <?php if ($opt_val === 'bottom-right') echo 'selected="true"' ?> value="bottom-right">Bottom-right</option>
</select>
<br />
<p><?php _e("Label:", 'menu-test' ); ?>
<input type="text" name="cas_widget_label" value="<?php echo get_option('cas_widget_label') ?>">
<p><?php _e("Color theme:", 'menu-test' ); ?>
<select name="<?php echo 'cas_widget_theme'; ?>" value="">
<option <?php if ($opt_theme === 'darkgrey') echo 'selected="true"' ?> value="darkgrey">Dark grey</option>
<option <?php if ($opt_theme === 'lightgrey') echo 'selected="true"' ?> value="lightgrey">Light grey</option>
<option <?php if ($opt_theme === 'white') echo 'selected="true"' ?> value="white">White</option>
<option <?php if ($opt_theme === 'orange') echo 'selected="true"' ?> value="orange">Orange</option>
<option <?php if ($opt_theme === 'blue') echo 'selected="true"' ?> value="blue">Blue</option>
<option <?php if ($opt_theme === 'purple') echo 'selected="true"' ?> value="purple">Purple</option>
<option <?php if ($opt_theme === 'red') echo 'selected="true"' ?> value="red">Red</option>
<option <?php if ($opt_theme === 'green') echo 'selected="true"' ?> value="green">Green</option>
</select>
</p><hr />

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>
<?php	
	echo '</div>';
}
?>