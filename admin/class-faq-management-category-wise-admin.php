<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.ankit-jani.com
 * @since      1.0.0
 *
 * @package    Faq_Management_Category_Wise
 * @subpackage Faq_Management_Category_Wise/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Faq_Management_Category_Wise
 * @subpackage Faq_Management_Category_Wise/admin
 * @author     Ankit Jani <ankit.jani@gmail.com>
 */
class Faq_Management_Category_Wise_Admin {

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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        if (isset($_REQUEST['page']) && ($_REQUEST['page'] == 'faq-category-wise-page' || $_REQUEST['page'] == 'faq-category-wise-categories' || $_REQUEST['page'] == 'faq-category-wise-settings' )) {
            wp_enqueue_style($this->plugin_name . '-bootstrap-style', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-spectrum-style', plugin_dir_url(__FILE__) . 'css/spectrum.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/faq-management-category-wise-admin.css', array(), $this->version, 'all');
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        if (isset($_REQUEST['page']) && ($_REQUEST['page'] == 'faq-category-wise-page' || $_REQUEST['page'] == 'faq-category-wise-categories' || $_REQUEST['page'] == 'faq-category-wise-settings' )) {
            //wp_enqueue_script($this->plugin_name . '-bootstrap-script', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script($this->plugin_name.'-spectrum', plugin_dir_url(__FILE__) . 'js/spectrum.js', array('jquery'), $this->version, false);
            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/faq-management-category-wise-admin.js', array('jquery'), $this->version, false);
            wp_localize_script($this->plugin_name, 'ajax_url', array('url' => admin_url('admin-ajax.php')));
            wp_localize_script($this->plugin_name, 'site_url', array('url' => site_url('/')));
        }
    }

    public function faq_admin_menu() {
        add_menu_page(
                __('FAQ Category Wise', $this->plugin_name), __('FAQ Category Wise', $this->plugin_name), 'manage_options', 'faq-category-wise-page', array($this, 'faq_category_wise_contents'), 'dashicons-category', 85
        );
        add_submenu_page('faq-category-wise-page', 'FAQ Category Wise', 'FAQ Category Wise', 'manage_options', 'faq-category-wise-page');
        add_submenu_page('faq-category-wise-page', 'FAQ Categories', 'FAQ Categories', 'manage_options', 'faq-category-wise-categories', array($this, 'faq_category_wise_categories'));
        add_submenu_page('faq-category-wise-page', 'FAQ Settings', 'FAQ Settings', 'manage_options', 'faq-category-wise-settings', array($this, 'faq_category_wise_settings'));
    }

    public function faq_category_wise_contents() {
        $file_path = plugin_dir_path(__FILE__) . 'partials/faq-management-category-wise-admin-display.php';
        include($file_path);
    }

    public function faq_category_wise_categories() {
        $file_path = plugin_dir_path(__FILE__) . 'partials/faq-management-category-wise-admin-categories.php';
        include($file_path);
    }

    public function faq_category_wise_settings() {
        $file_path = plugin_dir_path(__FILE__) . 'partials/faq-management-category-wise-admin-settings.php';
        include($file_path);
    }

    public function add_faq_cat() {
        if (isset($_POST) && (!empty($_POST) && !empty($_FILES['category-icon']))) {
            global $wpdb;

            $cat_icon = $_FILES['category-icon'];
            $upload_dir = wp_upload_dir();

            if (!file_exists($upload_dir['basedir'] . '/FAQ_cat_icons')) {
                mkdir($upload_dir['basedir'] . '/FAQ_cat_icons', 0777, true);
            }

            $path = $upload_dir['basedir'] . '/FAQ_cat_icons/' . $cat_icon['name'];
            if (move_uploaded_file($cat_icon['tmp_name'], $path)) {
                $full_image_path = $upload_dir['baseurl'] . '/FAQ_cat_icons/' . $cat_icon['name'];
            }

            $cat_name = $_POST['category-title'];
            $cat_icon = $full_image_path;

            $faq_cat_table = $wpdb->prefix . 'faq_category';
            $insert = $wpdb->insert(
                    $faq_cat_table, array(
                'faq_cat_title' => $cat_name,
                'faq_cat_icon' => $cat_icon
                    ), array(
                '%s',
                '%s'
                    )
            );
            $return_data = array();
            if ($insert) {
                $return_data['success'] = 'The records is successfully inserted!';
                $return_data['data'] = $this->get_all_categories();
            } else {
                $return_data['error'] = $wpdb->print_error();
            }
            echo json_encode($return_data);
        }
        die();
    }

    public function delete_cat() {
        if (isset($_POST) && !empty($_POST['cat'])) {
            global $wpdb;
            $faq_cat_table = $wpdb->prefix . 'faq_category';
            if (is_array($_POST['cat'])) {
                $ids = implode(',', array_map('absint', $_POST['cat']));
                $delete = $wpdb->query("DELETE FROM $faq_cat_table WHERE id IN($ids)");
            } else {
                $cat_id = $_POST['cat'];
                $delete = $wpdb->delete($faq_cat_table, array('id' => $cat_id));
            }

            $return_data = array();
            if ($delete) {
                $return_data['success'] = 'The records is successfully deleted!';
                $return_data['data'] = $this->get_all_categories();
            } else {
                $return_data['error'] = $wpdb->print_error();
            }
            echo json_encode($return_data);
        }
        die();
    }

    public function get_all_categories() {
        global $wpdb;
        $faq_cat_table = $wpdb->prefix . 'faq_category';
        $faq_categories = $wpdb->get_results("SELECT * FROM $faq_cat_table");
        $return_data = '';
        if (!empty($faq_categories)) {
            $return_data .= '
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Category Icon</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>';
            foreach ($faq_categories as $faq_cat) {
                $return_data .= '
                            <tr>
                                <td><input type="checkbox" name="selected_cat" class="selected_cat" value="' . $faq_cat->id . '" /></td>
                                <td>' . $faq_cat->id . '</td>
                                <td><img width="50" height="auto" src="' . $faq_cat->faq_cat_icon . '" /></td>
                                <td>' . $faq_cat->faq_cat_title . '</td>
                                <td><button class="edit_category" data-id="' . $faq_cat->id . '" class="btn">Edit</button><button class="delete_category" data-id="' . $faq_cat->id . '" class="btn">Delete</button></td>
                            </tr>';
            }
            $return_data .= '
                        </table>
                    </div>';
        } else {
            $return_data .= '<p>No Categories were found!</p>';
        }
        return $return_data;
    }

    public function add_faq() {
        if (isset($_POST) && !empty($_POST)) {
            global $wpdb;
            $data = array();
            parse_str($_POST['data'], $data);

            $faq_title = $data['faq-title'];
            $faq_content = $data['faq-desc'];
            $faq_cats = implode(', ', $data['faq-cat']);

            $faq_table = $wpdb->prefix . 'faq_category_wise';

            $insert = $wpdb->insert(
                    $faq_table, array(
                'faq_title' => $faq_title,
                'faq_content' => $faq_content,
                'faq_cat' => $faq_cats
                    ), array(
                '%s',
                '%s',
                '%s'
                    )
            );

            $return_data = array();
            if ($insert) {
                $return_data['success'] = 'The records is successfully inserted!';
                $return_data['data'] = $this->get_all_faq();
            } else {
                $return_data['error'] = $wpdb->print_error();
            }
            echo json_encode($return_data);
        }
        die();
    }

    public function delete_faq() {
        if (isset($_POST) && !empty($_POST['faq'])) {
            global $wpdb;
            $faq_table = $wpdb->prefix . 'faq_category_wise';
            if (is_array($_POST['faq'])) {
                $ids = implode(',', array_map('absint', $_POST['faq']));
                $delete = $wpdb->query("DELETE FROM $faq_table WHERE id IN($ids)");
            } else {
                $faq_id = $_POST['faq'];
                $delete = $wpdb->delete($faq_table, array('id' => $faq_id));
            }

            $return_data = array();
            if ($delete) {
                $return_data['success'] = 'The records is successfully deleted!';
                $return_data['data'] = $this->get_all_faq();
            } else {
                $return_data['error'] = $wpdb->print_error();
            }
            echo json_encode($return_data);
        }
        die();
    }

    public function get_all_faq() {
        global $wpdb;
        $faq_table = $wpdb->prefix . 'faq_category_wise';
        $faq_cat_table = $wpdb->prefix . 'faq_category';
        $faqs = $wpdb->get_results("SELECT * FROM $faq_table");

        $return_data = '';
        if (!empty($faqs)) {
            $return_data .= '
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>FAQ Title</th>
                                <th>FAQ Description</th>
                                <th>FAQ Category</th>
                                <th>Action</th>
                            </tr>';
            foreach ($faqs as $faq) {
                $faq_cat_ids = $faq->faq_cat;
                $faq_cat = wp_list_pluck( $wpdb->get_results( "SELECT faq_cat_title FROM $faq_cat_table WHERE id IN ($faq_cat_ids) " ), 'faq_cat_title');
                
                $return_data .= '
                            <tr>
                                <td><input type="checkbox" name="selected_faq" class="selected_faq" value="' . $faq->id . '" /></td>
                                <td>' . $faq->id . '</td>
                                <td>' . $faq->faq_title . '</td>
                                <td>' . $faq->faq_content . '</td>
                                <td>' . implode(', ', $faq_cat) . '</td>
                                <td><button class="edit_faq" data-id="' . $faq->id . '" class="btn">Edit</button><button class="delete_faq" data-id="' . $faq->id . '" class="btn">Delete</button></td>
                            </tr>';
            }
            $return_data .= '
                        </table>
                    </div>';
        } else {
            $return_data .= '<p>No FAQs were found!</p>';
        }
        return $return_data;
    }

    public function register_faq_category_wise_settings() {
      //register our settings
      register_setting('faq-category-wise-options', 'cat_title_background_color');
      register_setting('faq-category-wise-options', 'faq_question_background_color');
      register_setting('faq-category-wise-options', 'faq_font_size');
    }
}
