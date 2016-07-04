<?php
/*
Plugin Name: ns-plugin-2
*/

function ps_plugindev_options_page() {
  ?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php _e( 'Pluralsight Plugin Development Demo', 'ps-demo' ); ?></h2>
			<p><?php _e( 'This is a demonstration plugin for Introduction to WordPress Plugin Development.
      This plugin will add a sharing link underneath the post content.', 'ps-demo' ); ?></p>
			<form method="POST" action="options.php">
				<?php
        // initialize setting
					settings_fields( 'ps_plugindev_settings' );
				?>
				<table class="form-table">
					<tbody>
						<?php
            // display options
            ps_plugindev_do_options(); ?>
					</tbody>
				</table>
				<input type="submit" class="button-primary" value="
        <?php
          // add submit button
         _e( 'Save Options', 'ps-demo' ); ?>" />
				<input type="hidden" name="ps-plugindev-submit" value="Y" />
			</form>
		</div>
	<?php
}
// add link to regular options page menu for accessing aption page
function ps_plugindev_menu() {
	add_submenu_page( 'options-general.php', __( 'Plugin Demo', 'ps-demo' ),
   __( 'Plugin Demo', 'ps-demo' ), 'administrator', 'ps_plugindev',
   'ps_plugindev_options_page' );
}
add_action( 'admin_menu', 'ps_plugindev_menu' );

// register the settings
function ps_plugindev_init() {
	register_setting( 'ps_plugindev_settings', 'ps_plugindev', 'ps_plugindev_validate' );
}
add_action( 'admin_init', 'ps_plugindev_init' );

// get options from database if any exists
function ps_plugindev_do_options() {
	$options = get_option( 'ps_plugindev' );
	ob_start();
	?>
		<tr valign="top"><th scope="row"><?php _e( 'Sharing text', 'ps-demo' ); ?></th>
			<td>
				<?php
					if ( $options['sharing-text'] ) {
						$options['sharing-text'] = wp_kses($options['sharing-text']);
					} else {
						$options['sharing-text'] = __( 'Share this post', 'ps-demo' );
					}
				?>
				<input type="text" id="sharing-text" name="ps_plugindev[sharing-text]" width="30" value="<?php echo $options['sharing-text']; ?>" /><br />
				<label class="description" for="ps_plugindev[sharing-text]"><?php _e( 'Allows you to change the text that displays next to the sharing buttons', 'ps-demo' ); ?></label>
			</td>
		</tr>
		<tr valign="top"><th scope="row"><?php _e( 'What services do you want to share to?', 'ps-demo' ); ?></th>
			<td>
				<?php
					foreach ( ps_plugindev_services() as $service ) {
						$label = $service['label'];
						$value = $service['value'];
						echo '<label><input type="checkbox" name="ps_plugindev[' . $value . '] value="1" ';
						switch ($value) {
							case 'google' :
								if ( isset( $options['google'] ) ) { checked( 'on', $options['google'] ); }
								break;
							case 'twitter' :
								if ( isset( $options['twitter'] ) ) { checked( 'on', $options['twitter'] ); }
								break;
							case 'facebook' :
								if ( isset( $options['facebook'] ) ) { checked( 'on', $options['facebook'] ); }
								break;
							case 'stumbleupon' :
								if ( isset( $options['stumbleupon'] ) ) { checked( 'on', $options['stumbleupon'] ); }
								break;
							case 'digg' :
								if ( isset( $options['digg'] ) ) { checked( 'on', $options['digg'] ); }
								break;
							case 'email' :
								if ( isset( $options['email'] ) ) { checked( 'on', $options['email'] ); }
								break;
						}
						echo '/> ' . esc_attr($label) . '</label><br />';
					}
				?>
			</td>
	<?php
}
// nima salehi
