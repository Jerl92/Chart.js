<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://jerl92.tk
 * @since      1.0.0
 *
 * @package    Chart
 * @subpackage Chart/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Chart
 * @subpackage Chart/public
 * @author     Jeremie Langevin <jeremie.langevin@outlook.com>
 */
class Chart_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Chart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/chart-public.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'Chart.min', plugin_dir_url( __FILE__ ) . 'css/Chart.min.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'Chart', plugin_dir_url( __FILE__ ) . 'css/Chart.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Chart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/chart-public.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'Chart.bundle.min', plugin_dir_url( __FILE__ ) . 'js/Chart.bundle.min.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'Chart.bundle', plugin_dir_url( __FILE__ ) . 'js/Chart.bundle.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'Chart.min', plugin_dir_url( __FILE__ ) . 'js/Chart.min.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'Chart', plugin_dir_url( __FILE__ ) . 'js/Chart.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'Chart-render', plugin_dir_url( __FILE__ ) . 'js/Chart-render.js', array( 'jquery' ), $this->version, false );

	}

}
