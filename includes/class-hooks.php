<?php

defined( 'ABSPATH' ) || exit();

if ( ! class_exists( 'Quick_Audio_Player_Hooks' ) ) {
	class Quick_Audio_Player_Hooks {
		/** @var null */
		private static $instance = null;

		/**
		 * WPHAP_HOOKS constructor.
		 */
		public function __construct() {

		}

		/**
		 * @return Quick_Audio_Player_Hooks|null
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

}

Quick_Audio_Player_Hooks::instance();