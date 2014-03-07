<?php
   /*
   Plugin Name: Casengo Contact Widget
   Plugin URI: http://www.casengo.com/plugins/wordpress/v2
   Description: A plugin to add the Casengo widget to the Wordpress site
   Version: 1.9.4
   Author: Thijs van der Veen
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
  /*
  echo '
  		<!-- Live Chat and Customer Support Software by Casengo - WordPress Live Chat and Customer Support Software v1.9.1 - http://www.casengo.com/ -->
        <!--Place this code where you want the button to be rendered -->
		<div class="casengo-vipbtn"><!-- subdomain="' . $cas_domain . '" group="39" label="' . $cas_label . '" position="' . $cas_pos . '" theme="' . $cas_theme . '" --></div>
		<!--Place this code after the last Casengo script -->
		<script type="text/javascript">
			(function() {
				var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
				po.src = \'//' . $cas_domain . '.casengo.com/apis/vip-widget.js?r=\'+new Date().getTime();
				var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
			})();
		</script>
<a style="display:none" id="Casengo-Customer-Support-Software" href="http://www.casengo.com">Casengo is customer support software, crm, webcare and live chat software for webshops, e-commerce websites, and small businesses. Casengo supports email, livechat, social media, faq, self service and online chat.</a> 

<a style="display:none" id="Casengo-Customer-Support-Software-and-Live-Chat-FAQ" href="http://support.casengo.com">Check the Casengo Customer Support and Live Chat FAQ page for answers to frequently asked questions, and how to get Casengo customer support software, live-chat, and helpdesk software going.</a>  
        
<a style="display:none" id="Casengo-CRM-Live-Chat-and-Customer-Service-Blog" href="http://www.casengo.com/blog">The blog for anyone interested in customer support, customer service, live chat, social CRM, small business tips and Casengo product updates.</a>
		<!-- // Casengo Wordpress Live Chat and Customer Support Software -->
  ';
  */

  echo '
  		<!-- Live Chat and Customer Support Software by Casengo - WordPress Live Chat and Customer Support Software v1.9.1 - http://www.casengo.com/ -->
        <!--Place this code where you want the button to be rendered -->
		<div class="casengo-vipbtn"><span style="display:none" subdomain="' . $cas_domain . '" group="39" label="' . $cas_label . '" position="' . $cas_pos . '" theme="' . $cas_theme . '" /></div>
		<!--Place this code after the last Casengo script -->
		<script type="text/javascript">
			(function() {
				var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
				po.src = \'//' . $cas_domain . '.casengo.com/apis/vip-widget.js?r=\'+new Date().getTime();
				var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
			})();
		</script>
<a style="display:none" id="Casengo-Customer-Support-Software" href="http://www.casengo.com">Casengo is customer support software, crm, webcare and live chat software for webshops, e-commerce websites, and small businesses. Casengo supports email, livechat, social media, faq, self service and online chat.</a> 

<a style="display:none" id="Casengo-Customer-Support-Software-and-Live-Chat-FAQ" href="http://support.casengo.com">Check the Casengo Customer Support and Live Chat FAQ page for answers to frequently asked questions, and how to get Casengo customer support software, live-chat, and helpdesk software going.</a>  
        
<a style="display:none" id="Casengo-CRM-Live-Chat-and-Customer-Service-Blog" href="http://www.casengo.com/blog">The blog for anyone interested in customer support, customer service, live chat, social CRM, small business tips and Casengo product updates.</a>
		<!-- // Casengo Wordpress Live Chat and Customer Support Software -->
  ';
  
}

add_action( 'wp_footer', 'casengo' );

// *** ADMIN

function casengo_activate_plugin() {
    // work-around to redirect to admin plugin page after plugin activiation
    add_option('casengo_do_activation_redirect', true);
}

function casengo_redirect() {
    // redirect to plugin admin page after plugin activation
    if (get_option('casengo_do_activation_redirect', false)) {
        delete_option('casengo_do_activation_redirect');
	 wp_redirect(admin_url('admin.php?page=the-casengo-chat-widget/casengo.php'));
    }
}

//add_action( 'admin_menu', 'my_plugin_menu' );
add_action( 'admin_menu', 'casengo_admin_menu' );

register_activation_hook( __FILE__, 'casengo_activate_plugin' );
add_action('admin_init', 'casengo_redirect');

/*
function casengo_admin_menu_exists($menu_name) {
	global $menu;
	$menuExist = false;
	foreach($menu as $item) {
		if(strtolower($item[0]) == strtolower($menu_name)) {
			$menuExist = true;
		}
	}
	return $menuExist;

}
*/

function casengo_admin_menu_exists( $handle, $sub = true){
  global $menu, $submenu;
  $check_menu = $sub ? $submenu : $menu;
  if( empty( $check_menu ) )
    return false;
  foreach( $check_menu as $k => $item ){
    if( $sub ){
      foreach( $item as $sm ){
        if($handle == $sm[2])
          return true;
      }
    } else {
      if( $handle == $item[2] )
        return true;
    }
  }
  return false;
}

function casengo_admin_menu() {
	$file = dirname( __FILE__ ) . '/casengo.php';
	$icon = "http://www.casengo.com/assets/favicon.png";
	//if (! casengo_admin_menu_exists(dirname( __FILE__ ) . '/casengo.php')) {
		add_menu_page('Casengo ( Chat )', 'Casengo ( Chat )', 10, dirname( __FILE__ ) . '/casengo.php', '', $icon);
	//}
	add_submenu_page(dirname( __FILE__ ) . '/casengo.php', 'Settings', 'Settings', 'manage_options', dirname( __FILE__ ) . '/casengo.php', 'casengo_settings');	

	//if (! casengo_admin_menu_exists('casengo-friends')) {
		add_submenu_page(dirname( __FILE__ ) . '/casengo.php', 'Our Friends', 'Our Friends', 'manage_options', dirname( __FILE__ ) . '/friends.php');
	//}

}

function my_plugin_menu() {
	// deprecated code
	add_options_page( 'Casengo Chat Widget Options', 'Casengo Chat Widget', 'manage_options', 'casengoWidgetPlugin', 'casengo_settings' );
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
        
        // If customer enters empty label, use default
        if($_POST['cas_widget_label'] == '') {
            $label='Contact';
        } else {
            $label=stripslashes($_POST['cas_widget_label']);
        }
        
        update_option( 'cas_widget_label', $label);
        update_option( 'cas_widget_theme', $_POST['cas_widget_theme']);
        
        

        // Put an settings updated message on the screen

?>
<div class="updated"><p><?php _e('Settings saved. <strong><a href="' . get_site_url() . '">Visit your site</a></strong> to check your new widget settings.', 'menu-general' ); ?></p></div>
<?php

    }

    // Now display the settings editing screen
    echo '<div class="wrap">';

    // header
    echo "<h2>" . __( 'Casengo Chat Widget options', 'menu-general' ) . "</h2>";

    // settings form
  
    ?>

    <?php
      // Read in existing option value from database
      $opt_val = get_option( 'cas_widget_pos' );
      $opt_theme = get_option( 'cas_widget_theme' );
    ?>

<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<p>To configure the live chat plugin you must have a Casengo account. Have an account already? Great! If not, <a href="http://get.casengo.com/signup/?ref=wordpress-plugin-admin&amp;utm_source=WordPress&amp;utm_medium=Plugin&amp;utm_campaign=WordPress%2BPlugin%2BSignups" target="_blank" title="Sign up for a free Casengo account" rel="nofollow">sign up here</a>.</p>
<br>
<p><h3><strong><?php _e("Your Casengo subdomain (eg. mycompanyname)", 'menu-test' ); ?></h3></strong>
Enter your subdomain of your Casengo account below. This field is mandatory. If it is not specified, the button will not appear on the site.<br><br>
<table style="margin-left:20px">
<tr>
<td style="width:160px">Subdomain:</td>
<td>
http://<input type="text" name="cas_widget_domain" size="20" style="font-weight: bold" value="<?php echo get_option('cas_widget_domain') ?>">.casengo.com
</td>
</tr>
</table>
<p><h3><strong><?php _e("Appearance", 'menu-test' ); ?></strong></h3>
Specify how the chat button appears on your site<br><br>
<table style="margin-left:20px">
<tr>
<td style="width:160px">Position of button:</td>
<td>
<select name="<?php echo 'cas_widget_pos'; ?>" style="width:200px" value="">
<option <?php if ($opt_val === 'middle-left') echo 'selected="true"' ?> value="middle-left">Middle-left (default)</option>
<option <?php if ($opt_val === 'middle-right') echo 'selected="true"' ?> value="middle-right">Middle-right</option>
<option <?php if ($opt_val === 'bottom-right') echo 'selected="true"' ?> value="bottom-right">Bottom-right</option>
</select>
</td>
</tr>
<tr>
<td style="width:160px">Color scheme:</td>
<td>
<select name="<?php echo 'cas_widget_theme'; ?>" style="width:200px" value="">
<option <?php if ($opt_theme === 'darkgrey') echo 'selected="true"' ?> value="darkgrey">Dark grey (default)</option>
<option <?php if ($opt_theme === 'lightgrey') echo 'selected="true"' ?> value="lightgrey">Light grey</option>
<option <?php if ($opt_theme === 'white') echo 'selected="true"' ?> value="white">White</option>
<option <?php if ($opt_theme === 'orange') echo 'selected="true"' ?> value="orange">Orange</option>
<option <?php if ($opt_theme === 'blue') echo 'selected="true"' ?> value="blue">Blue</option>
<option <?php if ($opt_theme === 'purple') echo 'selected="true"' ?> value="purple">Purple</option>
<option <?php if ($opt_theme === 'red') echo 'selected="true"' ?> value="red">Red</option>
<option <?php if ($opt_theme === 'green') echo 'selected="true"' ?> value="green">Green</option>
</select>
</td>
</tr>
<tr>
<td style="width:160px">Button label:</td>
<td>
<input type="text" name="cas_widget_label" size="30" value="<?php echo get_option('cas_widget_label') ?>">
</td>
</tr>
</table>

<br />
<hr />
<p class="submit">

<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>
<?php	
	echo '</div>';
}
?>