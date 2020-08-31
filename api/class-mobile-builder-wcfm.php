<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://rnlab.io
 * @since      1.0.0
 *
 * @package    Mobile_Builder
 * @subpackage Mobile_Builder/cart
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mobile_Builder
 * @subpackage Mobile_Builder/api
 * @author     RNLAB <ngocdt@rnlab.io>
 */
class Mobile_Builder_WCFM {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since      1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Registers a REST API route
	 *
	 * @since 1.0.0
	 */
	public function add_api_routes() {
		$namespace = $this->plugin_name . '/v' . intval( $this->version );

		register_rest_route( $namespace, 'wcfm-report-data', array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => array( $this, 'get_report_data' ),
			'permission_callback' => '__return_true',
		) );

		register_rest_route( $namespace, 'wcfm-report-html', array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => array( $this, 'get_report_html' ),
			'permission_callback' => '__return_true',
		) );

	}

	/**
	 *
	 * Get report for vendors
	 *
	 * @param $request
	 *
	 * @return bool|string
	 * @since    1.0.0
	 */
	public function get_report_data( $request ) {
		global $WCMp, $WCFM, $wpdb;

		include_once( $WCFM->plugin_path . 'includes/reports/class-wcfmmarketplace-report-sales-by-date.php' );
		$wcfm_report_sales_by_date = new WCFM_Marketplace_Report_Sales_By_Date( 'month' );
		$wcfm_report_sales_by_date->calculate_current_range( 'month' );

		return $wcfm_report_sales_by_date->get_report_data();
	}

	/**
	 *
	 * Get report for vendors
	 *
	 * @param $request
	 *
	 * @return bool|string
	 * @since    1.0.0
	 */
	public function get_report_html( $request ) {
		global $WCMp, $WCFM, $wpdb;

		include_once( $WCFM->plugin_path . 'includes/reports/class-wcfmmarketplace-report-sales-by-date.php' );
		$wcfm_report_sales_by_date = new WCFM_Marketplace_Report_Sales_By_Date( 'month' );
		$wcfm_report_sales_by_date->calculate_current_range( 'month' );
		$report_data = $wcfm_report_sales_by_date->get_report_data();

		$wcfm_report_sales_by_date->get_main_chart();
	}

	/**
	 *
	 * Check user logged in
	 *
	 * @param $request
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public function user_permissions_check( $request ) {
		return true;
	}

}
