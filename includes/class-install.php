<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class WP_Plugin_Boilerplate_Install
 * Do the activate stuffs
 */
class Quick_Audio_Player_Install {

	private static $instance = null;

	public function __construct() {
		$this->create_default_data();
	}

	public function create_default_data() {
		update_option( 'quick_audio_player_version', QUICK_AUDIO_PLAYER_VERSION );
		$install_time = get_option( 'quick_audio_player_install_time' );

		if ( ! $install_time ) {
			update_option( 'quick_audio_player_install_time', time() );
		}
	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

Quick_Audio_Player_Install::instance();