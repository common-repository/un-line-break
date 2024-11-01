<?php
/**
 * Plugin Name: Un-Line-Break
 * Plugin URI: https://strongplugins.com/plugins/un-line-break/
 * Description: Improve the readability of content within shortcodes.
 * Author: Chris Dillon
 * Version: 0.2.2
 * Author URI: https://strongplugins.com
 * Text Domain: un-line-break
 * Requires: 3.5 or higher
 * License: GPLv3 or later
 *
 * Copyright 2016-2017  Chris Dillon  chris@strongplugins.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

class UnLineBreak {

	public function __construct() {

		if ( ! defined( 'UNLINEBREAK_INC' ) )
			define( 'UNLINEBREAK_INC', plugin_dir_path( __FILE__ ) . 'inc/' );

		if ( ! defined( 'UNLINEBREAK_IMAGES' ) )
			define( 'UNLINEBREAK_IMAGES', plugin_dir_url( __FILE__ ) . 'images/' );

		register_activation_hook( __FILE__, array( $this, 'install' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_styles' ) );

		add_filter( 'plugin_action_links', array( $this, 'plugin_action_links' ), 10, 2 );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );

		add_action( 'admin_menu', array( $this, 'add_options_page' ) );

		add_filter( 'the_content', array( $this, 'the_content_filter' ) );

	}

	public function register_admin_styles( $hook ) {
		if ( 'settings_page_un-line-break' == $hook ) {
			wp_enqueue_style( 'unlinebreak-style', plugins_url( '/css/admin.css', __FILE__ ) );
			$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'settings';
			if ( 'settings' == $active_tab ) {
				wp_enqueue_script( 'unlinebreak-script', plugins_url( '/js/admin.js', __FILE__ ), array( 'jquery' ) );
			}
		}
		elseif ( 'plugins.php' == $hook ) {
			wp_enqueue_style( 'unlinebreak-plugins-style', plugins_url( '/css/plugins.css', __FILE__ ) );
		}
	}

	/**
	 * Install with default setting.
	 *
	 * @since 0.1.0
	 */
	public function install() {
		$unlinebreak = array(
			'shortcodes' => array(),
			'lnt' => 1
		);
		update_option( 'unlinebreak', $unlinebreak );
	}

	/**
	 * Plugin list action links
	 *
	 * @param $links
	 * @param $file
	 *
	 * @since 0.1.0
	 *
	 * @return mixed
	 */
	public function plugin_action_links( $links, $file ) {
		if ( $file == plugin_basename( __FILE__ ) ) {
			$settings_link = '<a href="' . admin_url( 'options-general.php?page=un-line-break' ) . '">' . __( 'Settings', 'un-line-break' ) . '</a>';
			array_unshift( $links, $settings_link );
		}
		return $links;
	}

	/**
	 * Plugin meta row
	 *
	 * @param        $plugin_meta
	 * @param        $plugin_file
	 * @param array  $plugin_data
	 * @param string $status
	 *
	 * @since 0.1.0
	 *
	 * @return array
	 */
	public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data = array(), $status = '' ) {
		if ( $plugin_file == plugin_basename( __FILE__ ) ) {
			$plugin_meta[] = '<span class="lnt-ulb">Leave No Trace</span>';
		}
		return $plugin_meta;
	}

	/**
	 * Add options page to Settings menu.
	 *
	 * @since 0.1.0
	 */
	public function add_options_page() {
		add_options_page( 'Un-Line-Break', 'Un-Line-Break', 'manage_options', 'un-line-break', array( $this, 'settings_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Register the setting.
	 *
	 * @since 0.1.0
	 */
	public function register_settings() {
		register_setting( 'unlinebreak_settings_group', 'unlinebreak', array( $this, 'sanitize_options' ) );
	}

	/**
	 * Sanitize user input.
	 *
	 * @param $input
	 *
	 * @since 0.1.0
	 *
	 * @return mixed
	 */
	public function sanitize_options( $input ) {
		$input['lnt'] = sanitize_text_field( $input['lnt'] );

		return $input;
	}

	/**
	 * Our settings page.
	 *
	 * @since 0.1.0
	 */
	public function settings_page() {
		if ( ! current_user_can( 'manage_options' ) )
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );

		global $shortcode_tags;

		// Remove WordPress shortcodes without content option.
		unset( $shortcode_tags['gallery'] );
		unset( $shortcode_tags['playlist'] );

		// Assemble into groups.
		$groups = array();
		$wp     = array( 'audio', 'caption', 'embed', 'gallery', 'playlist', 'video', 'wp_caption' );
		$known  = array(
			'Su_Shortcodes' => 'Shortcodes Ultimate',
		);

		foreach ( $shortcode_tags as $shortcode => $info ) {

			if ( in_array( $shortcode, $wp ) ) {
				$name = 'WordPress';
			}
			elseif ( is_array( $info ) ) {
				if ( is_object( $info[0] ) ) {
					$name = get_class( $info[0] );
				}
				else {
					$name = $info[0];
				}
			}
			else {
				$name = 'ungrouped';
			}

			if ( isset( $known[ $name ] ) ) {
				$name = $known[ $name ];
			}
			else {
				$name = str_replace( '_', ' ', $name );
			}

			$groups[ $name ][] = $shortcode;
			
		}

		// Filter
		$groups = apply_filters( 'unlinebreak', $groups );

		// Sort alphabetically but leave key order as is.
		//foreach ( array_keys( $groups ) as $key ) {
		//	if ( 'WordPress' != $key ) {
		//		sort( $groups[ $key ] );
		//	}
		//}
		?>
		<div class="wrap">
			<form method="post" action="options.php">
				<?php settings_fields( 'unlinebreak_settings_group' ); ?>

				<h1><?php _e( 'Un-Line-Break', 'un-line-break' ); ?></h1>

				<?php include( UNLINEBREAK_INC . 'settings.php' ); ?>
			</form>
		</div><!-- .wrap -->
		<?php
	}


	/**
	 * Remove line breaks from shortcode content.
	 * Thanks https://wordpress.stackexchange.com/questions/130075/stop-wordpress-automatically-adding-br-tags-to-post-content/130185#130185
	 *
	 * @param $content
	 *
	 * @since 0.1.0
	 *
	 * @return mixed
	 */
	public function the_content_filter( $content ) {
		$unlinebreak = get_option( 'unlinebreak' );
		if ( $unlinebreak['shortcodes'] ) {
			$block = join( '|', $unlinebreak['shortcodes'] );
			$content = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content );
			$content = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $content );
		}

		return $content;
	}

}

new UnLineBreak();
