<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.ankit-jani.com
 * @since      1.0.0
 *
 * @package    Faq_Management_Category_Wise
 * @subpackage Faq_Management_Category_Wise/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Faq_Management_Category_Wise
 * @subpackage Faq_Management_Category_Wise/includes
 * @author     Ankit Jani <ankit.jani@gmail.com>
 */
class Faq_Management_Category_Wise_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'faq-management-category-wise',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
