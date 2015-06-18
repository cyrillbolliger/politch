<?php

// die on direct call
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if( ! class_exists( 'Politch_Settings' ) ) {

	class Politch_Settings {
		
		public $plugin_table_prefix = POLITCH_PLUGIN_PREFIX;
		
		public $network_options = array();
		public $single_blog_options = array();
		
		public $network_tables = array();
		public $single_blog_tables = array();
		
		public $roles = array();
		
		protected $scripts = array();
		protected $styles = array();
		
		public function __construct() {
			
			$this->scripts[] = array(
				'handle'     => 'politch-admin-js', // string
				'src'        => '/js/politch-admin-js.js', // string relative to plugin folder
				'deps'       => array( 'jquery' ), // array
				'in_footer'  => true, // bool
				'scope'      => 'admin', // admin | frontend | shared
			);
			
			$this->styles[] = array(
				'handle'    => 'politch-admin-css', // string
				'src'       => '/css/politch-admin-css.css', // string relative to plugin folder
				'deps'      => array(), // array
				'media'     => 'all', // css media tag
				'scope'     => 'admin', // admin | frontend | shared
			);
			
			$network_tables = array(); // put your table names in this array (whitout prefix and stuff)
			$single_blog_tables = array(); // put your table names in this array (whitout prefix and stuff)
			
			$this->set_network_tables( $network_tables );
			$this->set_single_blog_tables( $single_blog_tables );
			
			// array must provide the arguments of the add_role() function
			$this->roles[] = array( 'politch_user', __( 'Politch_user', 'politch'), array(  ) );
		}
		
		/**
		 * loads the $network_tables array. the key will be the table name, the content will be the fully prefixed table name
		 */
		private function set_network_tables( $table_names ) {
			global $wpdb;
			
			$tables = array();
			
			foreach( $table_names as $table_name ) {
				$tables[ $table_name ] = $wpdb->base_prefix . $this->plugin_table_prefix . $table_name;
			}
			
			$this->network_tables = $tables;
		}
		
		/**
		 * loads the $single_blog_tables array. the key will be the table name, the content will be the table name with the plugin prefix.
		 * the blog prefix will NOT be set!
		 */
		private function set_single_blog_tables( $table_names ) {
			global $wpdb;
			
			$tables = array();
			
			foreach( $table_names as $table_name ) {
				$tables[ $table_name ] = $this->plugin_table_prefix . $table_name;
			}
			
			$this->single_blog_tables = $tables;
		}
	}
}