<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.ankit-jani.com
 * @since      1.0.0
 *
 * @package    Faq_Management_Category_Wise
 * @subpackage Faq_Management_Category_Wise/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="general-options-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>General Options</h1>
                <?php settings_errors(); ?>
                <div class="form-wrapper">
                    <form method="post" action="options.php">
                        <?php
                        settings_fields('faq-category-wise-options');
                        do_settings_sections('faq-category-wise-options');
                        ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">General Options</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="cat_title_background_color">Category Title Background Color</label>
                                            <br />
                                            <input id="cat_title_background_color" type="text" name="cat_title_background_color" value="<?php echo (get_option('cat_title_background_color') != "") ? get_option('cat_title_background_color') : "#000000" ; ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label for="faq_question_background_color">FAQ Questions Background Color</label>
                                            <br />
                                            <input id="faq_question_background_color" type="text" name="faq_question_background_color" value="<?php echo (get_option('faq_question_background_color') != "") ? get_option('faq_question_background_color') : "#000000" ; ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label for="faq_font_size">Font Size</label>
                                            <input id="faq_font_size" type="text" name="faq_font_size" value="<?php echo get_option('faq_font_size'); ?>" class="form-control" placeholder="16px" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php submit_button(); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>