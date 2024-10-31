<?php

defined( 'ABSPATH' ) || exit();

class Quick_Audio_Player_Shortcodes {

	private static $instance = null;

	public function __construct() {
		add_shortcode( 'audio_player', [ $this, 'audio_player' ] );
	}

	public function audio_player( $atts ) {

		ob_start();
		if ( empty( $atts['id'] ) ) {

			$data = [
				'player_id'  => '',
				'attributes' => sprintf( ' %s %s %s ', 'on' == $autoplay ? 'autoplay' : '', 'on' == $loop ? 'loop' : '', 'on' == $muted ? 'muted' : '' ),
			];

			quick_audio_player()->get_template( 'players/1', $data );
		} else {
			$post_id = $atts['id'];

			$skin   = qap_get_meta( $post_id, 'skin', 1 );

			$controls = qap_get_meta( $post_id, 'controls', [] );
			$controls = array_filter( $controls, function ( $control ) {
				return 'on' == $control;
			} );
			$controls = json_encode( array_keys( $controls ) );


			if ( empty( $autoplay ) ) {
				$autoplay = qap_get_meta( $post_id, 'autoplay', 'off' );
			}
			if ( empty( $loop ) ) {
				$loop = qap_get_meta( $post_id, 'loop', 'off' );
			}
			if ( empty( $muted ) ) {
				$muted = qap_get_meta( $post_id, 'muted', 'off' );
			}

			$attributes = sprintf( ' %s %s %s', 'on' == $autoplay ? 'autoplay' : '', 'on' == $loop ? 'loop' : '', 'on' == $muted ? 'muted' : '' );

			$data = [
				'player_id'  => $post_id,
				'controls'   => $controls,
				'src'        => qap_get_meta( $post_id, 'audio_file', QUICK_AUDIO_PLAYER_ASSETS . '/vendor/default.mp3' ),
				'attributes' => $attributes,
			];

			$skin_path = in_array( $skin, quick_audio_player_pro_skins() ) ? "players/{$skin}__premium_only" : "players/$skin";

			quick_audio_player()->get_template( $skin_path, $data );
		}

		qap_get_player_css($post_id);

		return ob_get_clean();
	}

	public static function instance(){
		if(is_null(self::$instance)){
			self::$instance = new self();
		}

		return self::$instance;
	}

}

Quick_Audio_Player_Shortcodes::instance();