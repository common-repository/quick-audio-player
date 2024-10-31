<?php

defined( 'ABSPATH' ) || exit();


class Quick_Audio_Player_Admin {

	private static $instance = null;

	public function __construct() {
		add_action( 'do_meta_boxes', [ $this, 'register_metaboxes' ] );

		add_filter( 'manage_quick_audio_player_posts_columns', [ $this, 'post_columns' ] );
		add_filter( 'manage_quick_audio_player_posts_custom_column', [ $this, 'columns_data' ], 10, 2 );
	}

	public function post_columns( $columns ) {
		unset( $columns['date'] );
		$columns['shortcode'] = __( 'Shortcode', 'quick-audio-player' );

		$columns['date'] = __( 'Date', 'quick-audio-player' );

		return $columns;
	}

	public function columns_data( $column, $post_id ) {
		if ( 'shortcode' == $column ) {
			printf( '<span class="notification-plus-n-shortcode" title="Copy Shortcode">
								<input type="text" class="shortcode" readonly value="[audio_player id=' . $post_id . ']">
							</span>' );
		}
	}

	public function register_metaboxes() {
		add_meta_box( 'player_preview', 'Player Preview', [ $this, 'render_preview' ], 'quick_audio_player', 'normal', 'high' );
		add_meta_box( 'player_settings', 'Player Settings', [ $this, 'render_metabox' ], 'quick_audio_player', 'normal', 'high' );
	}

	public function render_preview() {
		include QUICK_AUDIO_PLAYER_INCLUDES . '/admin/views/metabox/preview.php';
	}

	public function render_metabox() {
		include QUICK_AUDIO_PLAYER_INCLUDES . '/admin/views/metabox/index.php';
	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

Quick_Audio_Player_Admin::instance();