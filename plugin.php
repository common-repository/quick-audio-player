<?php
/**
 * Plugin Name: Quick Audio Player
 * Plugin URI:  https://wpmilitary.com/quick-audio-player
 * Description: The Easiest, Flexible and The Best Advanced HTML5 Audio Player for WordPress.
 * Version:     1.0.2
 * Author:      WP Military
 * Author URI:  http://wpmilitary.com
 * Text Domain: quick-audio-player
 * Domain Path: /languages/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

/** don't call the file directly */
defined( 'ABSPATH' ) || wp_die( __( 'You can\'t access this page', 'quick-audio-player' ) );


if ( function_exists( 'qap_fs' ) ) {
	qap_fs()->set_basename( true, __FILE__ );
} else {

	if ( ! function_exists( 'qap_fs' ) ) {
		// Create a helper function for easy SDK access.
		function qap_fs() {
			global $qap_fs;

			if ( ! isset( $qap_fs ) ) {
				// Include Freemius SDK.
				require_once dirname(__FILE__) . '/freemius/start.php';

				$qap_fs = fs_dynamic_init( array(
					'id'                  => '7528',
					'slug'                => 'quick-audio-player',
					'type'                => 'plugin',
					'public_key'          => 'pk_f0fe6fef2e870944140e5dac26f6b',
					'is_premium'          => true,
					'premium_suffix'      => 'PRO',

					// If your plugin is a serviceware, set this option to false.
					'has_premium_version' => true,
					'has_addons'          => false,
					'has_paid_plans'      => true,
					'menu'                => array(
						'slug'           => 'edit.php?post_type=quick_audio_player',
						'support'        => false,
					),

					// Set the SDK to work in a sandbox mode (for development & testing).
					// IMPORTANT: MAKE SURE TO REMOVE SECRET KEY BEFORE DEPLOYMENT.
					'secret_key'          => 'sk_A2xyE2M$v)MV+*a2wFQhy[^P+tr(Z',
				) );
			}

			return $qap_fs;
		}

		// Init Freemius.
		qap_fs();
		// Signal that SDK was initiated.
		do_action( 'qap_fs_loaded' );
	}

	define( 'QUICK_AUDIO_PLAYER_VERSION', '1.0.2' );
	define( 'QUICK_AUDIO_PLAYER_FILE', __FILE__ );
	define( 'QUICK_AUDIO_PLAYER_PATH', dirname( QUICK_AUDIO_PLAYER_FILE ) );
	define( 'QUICK_AUDIO_PLAYER_INCLUDES', QUICK_AUDIO_PLAYER_PATH . '/includes' );
	define( 'QUICK_AUDIO_PLAYER_URL', plugins_url( '', QUICK_AUDIO_PLAYER_FILE ) );
	define( 'QUICK_AUDIO_PLAYER_ASSETS', QUICK_AUDIO_PLAYER_URL . '/assets' );
	define( 'QUICK_AUDIO_PLAYER_TEMPLATES', QUICK_AUDIO_PLAYER_PATH . '/templates' );

	define( 'QUICK_AUDIO_PLAYER_PRICING', admin_url('edit.php?post_type=quick_audio_player&page=quick-audio-player-pricing') );

	require QUICK_AUDIO_PLAYER_INCLUDES . '/base.php';
}