<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.ankit-jani.com
 * @since      1.0.0
 *
 * @package    Faq_Management_Category_Wise
 * @subpackage Faq_Management_Category_Wise/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Faq_Management_Category_Wise
 * @subpackage Faq_Management_Category_Wise/includes
 * @author     Ankit Jani <ankit.jani@gmail.com>
 */
class Faq_Management_Category_Wise_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
        global $wpdb;
        $faq_table = $wpdb->prefix . 'faq_category_wise';
        $faq_cat_table = $wpdb->prefix . 'faq_category';

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        // create the faq category wise database table
        if($wpdb->get_var("show tables like '$faq_table'") != $faq_table) {
            $sql = "CREATE TABLE " . $faq_table . " (
		`id` bigint(20) NOT NULL AUTO_INCREMENT,
		`faq_title` text NOT NULL,
		`faq_content` longtext NOT NULL,
		`faq_cat` varchar(255) NOT NULL,
                PRIMARY KEY (id)
            );";

            dbDelta($sql);
        }
        
        // create the faq category database table
        if($wpdb->get_var("show tables like '$faq_cat_table'") != $faq_cat_table) {
            $sql = "CREATE TABLE " . $faq_cat_table . " (
		`id` bigint(20) NOT NULL AUTO_INCREMENT,
		`faq_cat_title` text NOT NULL,
		`faq_cat_icon` varchar(255) NOT NULL,
                PRIMARY KEY (id)
            );";

            dbDelta($sql);
        }
    }

}
