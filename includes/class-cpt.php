<?php

defined( 'ABSPATH' ) || exit();

class Quick_Audio_Player_CPT {

	private static $instance = null;

	/**
	 * Post_Types constructor.
	 */
	function __construct() {
		add_action( 'init', [ $this, 'register_post_types' ] );
		add_action( 'init', [ $this, 'flush_rewrite_rules' ], 99 );
	}

	public function register_post_types() {
		register_post_type( 'quick_audio_player', array(
			'labels'    => $this::get_posts_labels( __( 'Audio Players', 'quick-audio-player' ),
				__( 'Audio Player', 'quick-audio-player' ), __( 'Audio Players', 'quick-audio-player' ) ),
			'supports'  => [ 'title' ],
			'show_ui'   => true,
			'menu_icon' => QUICK_AUDIO_PLAYER_ASSETS . '/images/icon-24x24.png',
		) );

	}

	protected static function get_posts_labels( $menu_name, $singular, $plural, $type = 'plural' ) {
		$labels = array(
			'name'               => 'plural' == $type ? $plural : $singular,
			'all_items'          => sprintf( __( "All %s", 'quick-audio-player' ), $plural ),
			'singular_name'      => $singular,
			'add_new'            => sprintf( __( 'Add New %s', 'quick-audio-player' ), $singular ),
			'add_new_item'       => sprintf( __( 'Add New %s', 'quick-audio-player' ), $singular ),
			'edit_item'          => sprintf( __( 'Edit %s', 'quick-audio-player' ), $singular ),
			'new_item'           => sprintf( __( 'New %s', 'quick-audio-player' ), $singular ),
			'view_item'          => sprintf( __( 'View %s', 'quick-audio-player' ), $singular ),
			'search_items'       => sprintf( __( 'Search %s', 'quick-audio-player' ), $plural ),
			'not_found'          => sprintf( __( 'No %s found', 'quick-audio-player' ), $plural ),
			'not_found_in_trash' => sprintf( __( 'No %s found in Trash', 'quick-audio-player' ), $plural ),
			'parent_item_colon'  => sprintf( __( 'Parent %s:', 'quick-audio-player' ), $singular ),
			'menu_name'          => $menu_name,
		);

		return $labels;
	}

	public function flush_rewrite_rules() {
		if ( get_option( 'quick_audio_player_flush_rewrite_rules' ) ) {
			flush_rewrite_rules();
			delete_option( 'quick_audio_player_flush_rewrite_rules' );
		}
	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

Quick_Audio_Player_CPT::instance();