<?php

defined( 'ABSPATH' ) || exit();

class Quick_Audio_Player_Form_Handler {

	private static $instance = null;

	public function __construct() {
		add_action( 'save_post_quick_audio_player', [ $this, 'save_meta' ] );

		add_action( 'wp_ajax_qap_get_player', [ $this, 'get_player' ] );
	}

	public function get_player() {

		$post_id       = ! empty( $_REQUEST['post_id'] ) ? intval( $_REQUEST['post_id'] ) : '';
		$player_type   = ! empty( $_REQUEST['player_type'] ) ? sanitize_text_field( $_REQUEST['player_type'] ) : '';
		$controls      = ! empty( $_REQUEST['controls'] ) ? array_map( 'sanitize_text_field', $_REQUEST['controls'] ) : '';
		$skin_id       = ! empty( $_REQUEST['skin_id'] ) ? intval( $_REQUEST['skin_id'] ) : '';
		$playlist_item = ! empty( $_REQUEST['playlist_item'] ) ? wp_unslash( $_REQUEST['playlist_item'] ) : '';
		$track         = ! empty( $_REQUEST['track'] ) ? wp_unslash( $_REQUEST['track'] ) : '';

		$autoplay = ! empty( $_REQUEST['autoplay'] ) ? sanitize_key( $_REQUEST['autoplay'] ) : '';
		$loop     = ! empty( $_REQUEST['loop'] ) ? sanitize_key( $_REQUEST['loop'] ) : '';
		$muted    = ! empty( $_REQUEST['muted'] ) ? sanitize_key( $_REQUEST['muted'] ) : '';

		//update player_type
		if ( ! empty( $player_type ) ) {
			update_post_meta( $post_id, 'player_type', $player_type );
		}

		//update playlist_item
		if ( ! empty( $playlist_item ) ) {
			update_post_meta( $post_id, 'playlist_item', $playlist_item );
		}

		//update track
		if ( ! empty( $track ) ) {
			update_post_meta( $post_id, 'track', $track );
		}

		//update controls
		if ( ! empty( $controls ) ) {
			$player_controls = [
				'restart'     => 'off',
				'skipback'    => 'off',
				'rewind'      => 'off',
				'play'        => 'off',
				'forward'     => 'off',
				'skipforward' => 'off',
				'progress'    => 'off',
				'time'        => 'off',
				'suffle'      => 'off',
				'volume'      => 'off',
				'settings'    => 'off',
				'download'    => 'off',
			];

			foreach ( $controls as $control ) {
				$player_controls[ $control ] = 'on';
			}

			update_post_meta( $post_id, 'controls', $player_controls );
		}

		//update skin_id
		if(!empty($skin_id)){
			update_post_meta($post_id, 'skin', $skin_id);
		}

		$html = do_shortcode( "[audio_player id=$post_id ]" );

		wp_send_json_success( [ 'html' => $html ] );
	}

	public function save_meta( $post_id ) {


		$action = ! empty( $_REQUEST['action'] ) ? sanitize_key( $_REQUEST['action'] ) : null;

		if ( $action == 'qap_duplicate' ) {
			return; // Return if action is  qap_duplicate
		}

		$meta_keys = [
			'disable_autoplay',

			'player_type',

			'track',
			'playlist_item',

			'skin',
			'controls',
			'autoplay',
			'loop',
			'muted',

			'player_width',
			'border_radius',
			'player_bg_color',
			'player_text_color',
			'player_btn_color',
			'player_btn_hover_color',
		];

		foreach ( $meta_keys as $key ) {
			$value = ! empty( $_REQUEST[ $key ] ) ? wp_unslash( $_REQUEST[ $key ] ) : '';
			update_post_meta( $post_id, $key, $value );
		}

	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

Quick_Audio_Player_Form_Handler::instance();