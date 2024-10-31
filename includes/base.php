<?php

/** don't call the file directly */
defined( 'ABSPATH' ) || wp_die( __( 'You can\'t access this page', 'quick-audio-player' ) );

/**
 * if class `Quick_Audio_Player` doesn't exists yet.
 */
if ( ! class_exists( 'Quick_Audio_Player' ) ) {

	/**
	 * Sets up and initializes the plugin.
	 * Main initiation class
	 *
	 * @since 1.0.0
	 */
	final class Quick_Audio_Player {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;


		/**
		 * Minimum PHP version required
		 *
		 * @var string
		 */
		private static $min_php = '5.6.0';

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public function __construct() {
			if ( $this->check_environment() ) {

				$this->includes();

				add_action( 'init', [ $this, 'lang' ] );
				add_action( 'admin_notices', [ $this, 'print_notices' ], 15 );

				//add_filter( 'plugin_action_links_' . plugin_basename( QUICK_AUDIO_PLAYER_FILE ), array( $this, 'plugin_action_links' ) );

				register_activation_hook( QUICK_AUDIO_PLAYER_FILE, [ $this, 'activation' ] );
			}
		}

		public function activation(){
		    include_once QUICK_AUDIO_PLAYER_INCLUDES . '/class-install.php';
        }


		/**
		 * Ensure theme and server variable compatibility
		 *
		 * @return boolean
		 * @since  1.0.0
		 * @access private
		 */
		private function check_environment() {

			$return = true;

			/** Check the PHP version compatibility */
			if ( version_compare( PHP_VERSION, self::$min_php, '<=' ) ) {
				$return = false;

				$notice = sprintf( esc_html__( 'Unsupported PHP version Min required PHP Version: "%s"', 'quick-audio-player' ),
				                   self::$min_php );
			}

			/** Add notice and deactivate the plugin if the environment is not compatible */
			if ( ! $return ) {

				add_action( 'admin_notices',
					function () use ( $notice ) { ?>
                        <div class="notice is-dismissible notice-error">
                           <?php echo $notice; ?>
                        </div>
					<?php } );

				return $return;
			} else {
				return $return;
			}

		}

		/**
		 * Include required core files used in admin and on the frontend.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function includes() {
			include_once QUICK_AUDIO_PLAYER_INCLUDES . '/functions.php';
			include_once QUICK_AUDIO_PLAYER_INCLUDES . '/class-cpt.php';
			include_once QUICK_AUDIO_PLAYER_INCLUDES . '/class-enqueue.php';
			include_once QUICK_AUDIO_PLAYER_INCLUDES . '/class-form-handler.php';
			include_once QUICK_AUDIO_PLAYER_INCLUDES . '/class-shortcodes.php';
			include_once QUICK_AUDIO_PLAYER_INCLUDES . '/class-hooks.php';


			if ( is_admin() ) {
				include_once QUICK_AUDIO_PLAYER_INCLUDES . '/admin/class-admin.php';
				include_once QUICK_AUDIO_PLAYER_INCLUDES . '/admin/class-duplicator.php';
			}

		}

		/**
		 * Initialize plugin for localization
		 *
		 * @return void
		 * @since 1.0.0
		 *
		 */
		public function lang() {
			load_plugin_textdomain( 'quick-audio-player', false, dirname( plugin_basename( QUICK_AUDIO_PLAYER_FILE ) ) . '/languages/' );
		}

		/**
		 * Plugin action links
		 *
		 * @param array $links
		 *
		 * @return array
		 */
		public function plugin_action_links( $links ) {
			$links[] = sprintf( '<a href="%1$s">%2$s</a>',
			                    admin_url( 'admin.php?page=wp-html5-audio-player' ), __( 'Settings', 'quick-audio-player' ) );

			return $links;
		}

		/**
		 * Get template files
		 *
		 * since 1.0.0
		 *
		 * @param        $template_name
		 * @param array $args
		 * @param string $template_path
		 * @param string $default_path
		 *
		 * @return void
		 */
		public function get_template( $template_name, $args = array(), $template_path = 'wp-html5-audio-player', $default_path = '' ) {

			/* Add php file extension to the template name */
			$template_name = $template_name . '.php';

			/* Extract the args to variables */
			if ( $args && is_array( $args ) ) {
				extract( $args );
			}



			/* Look within passed path within the theme - this is high priority. */
			$template = locate_template( array( trailingslashit( $template_path ) . $template_name ) );



			/* Get default template. */
			if ( ! $template ) {
				$default_path = $default_path ? $default_path : QUICK_AUDIO_PLAYER_TEMPLATES;
				if ( file_exists( trailingslashit( $default_path ) . $template_name ) ) {
					$template = trailingslashit( $default_path ) . $template_name;
				}
			}

			// Return what we found.
			include( apply_filters( 'qap_locate_template', $template, $template_name, $template_path ) );

		}

		/**
		 * add admin notices
		 *
		 * @param           $class
		 * @param           $message
		 * @param string $only_admin
		 *
		 * @return void
		 */
		public function add_notice( $class, $message ) {

			$notices = get_option( sanitize_key( 'qap_notices' ), [] );
			if ( is_string( $message ) && is_string( $class ) && ! wp_list_filter( $notices,
			                                                                       array( 'message' => $message ) ) ) {

				$notices[] = array(
					'message'    => $message,
					'class'      => $class,
				);

				update_option( sanitize_key( 'qap_notices' ), $notices );
			}

		}

		/**
		 * Print the admin notices
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function print_notices() {
			$notices = get_option( sanitize_key( 'qap_notices' ), [] );
			foreach ( $notices as $notice ) { ?>

                <div class="notice notice-large is-dismissible notice-<?php echo $notice['class']; ?>"><?php echo $notice['message']; ?></div>

                <?php
				update_option( sanitize_key( 'qap_notices' ), [] );
			}
		}

		/**
		 * Main
		 * Quick_Audio_Player Instance.
		 *
		 * Ensures only one instance of
		 * Quick_Audio_Player is loaded or can be loaded.
		 *
		 * @return Quick_Audio_Player - Main instance.
		 * @since 1.0.0
		 * @static
		 */
		public static function instance() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

}

/** if function `wphap` doesn't exists yet. */
if ( ! function_exists( 'quick_audio_player' ) ) {
	function quick_audio_player() {
		return Quick_Audio_Player::instance();
	}
}

/** fire off the plugin */
quick_audio_player();