<?php

defined( 'ABSPATH' ) || exit();

class Quick_Audio_Player_Enqueue {

	private static $instance = null;

	function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
	}

	public function frontend_scripts() {

		wp_enqueue_style( 'dashicons' );

		wp_enqueue_style( 'quick-audio-player-frontend', QUICK_AUDIO_PLAYER_ASSETS . '/css/frontend.css', [ 'mediaelement', 'wp-mediaelement'] );


		wp_enqueue_script( 'quick-audio-player-frontend', QUICK_AUDIO_PLAYER_ASSETS . '/js/frontend.min.js',
			[ 'jquery', 'wp-mediaelement', 'wp-util' ], QUICK_AUDIO_PLAYER_VERSION, true );


		$localize_array = [
			'nonce' => '',
			'i18n'  => [
				'' => '',
			],
		];

		wp_localize_script( 'quick-audio-player-frontend', 'quickAudioPlayer', $localize_array );

	}

	public function admin_scripts() {
		wp_enqueue_style( 'toast-css', QUICK_AUDIO_PLAYER_ASSETS . '/vendor/toast/toast.css' );
		wp_enqueue_style( 'quick-audio-player-admin', QUICK_AUDIO_PLAYER_ASSETS . '/css/admin.css', [ 'mediaelement', 'wp-mediaelement', 'wp-color-picker'] );

		wp_enqueue_media();

		wp_playlist_scripts('audio');

		wp_enqueue_script( 'wp-color-picker-alpha', QUICK_AUDIO_PLAYER_ASSETS . '/vendor/wp-color-picker-alpha.js', [ 'jquery', 'jquery-ui-slider', 'wp-color-picker' ], false, true );
		wp_enqueue_script( 'jquery.syotimer', QUICK_AUDIO_PLAYER_ASSETS . '/vendor/jquery.syotimer.min.js', [ 'jquery' ], false, true );
		wp_enqueue_script( 'toast-js', QUICK_AUDIO_PLAYER_ASSETS . '/vendor/toast/toast.js', [ 'jquery' ], false, true );
		wp_enqueue_script( 'quick-audio-player-admin', QUICK_AUDIO_PLAYER_ASSETS . '/js/admin.min.js', [ 'jquery', 'wp-util', 'wp-mediaelement'], time(), true );
	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

Quick_Audio_Player_Enqueue::instance();