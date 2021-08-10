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
global $wpdb;
$faq_table = $wpdb->prefix . 'faq_category_wise';
$faq_cat_table = $wpdb->prefix . 'faq_category';
$faq_categories = $wpdb->get_results("SELECT * FROM $faq_cat_table");
$faqs = $wpdb->get_results("SELECT * FROM $faq_table");
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="faq-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">FAQ Category Wise</h1>
                <div class="button-action-wrapper">
                    <button class="btn btn-default" id="add_new_faq" name="add-new-faq">Add New FAQ</button>
                    <button class="btn btn-default" id="remove_faq" name="remove-faq">Remove FAQ</button>
                </div>
                <div class="faq-notices"></div>
                <div class="add-new-faq-wrapper">
                    <form id="add_new_faq_frm" name="add-new-faq" method="post" action="">
                        <div class="form-group">
                            <lable>FAQ Title</lable>
                            <input type="text" id="faq_title" name="faq-title" minlength="2" required />
                        </div>
                        <div class="form-group">
                            <lable>FAQ Description</lable>
                            <textarea name="faq-desc" rows="5" col="10"></textarea>
                        </div>
                        <div class="form-group">
                            <lable>Choose FAQ Categories</lable>
                            <?php
                            if (!empty($faq_categories)) {
                                foreach ($faq_categories as $faq_cat) {
                                    ?>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="faq-cat[]" value="<?php echo $faq_cat->id; ?>"><?php echo $faq_cat->faq_cat_title; ?></label>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <button type="submit" id="add_new_faq_btn" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="list-faq">
                    <?php if (!empty($faqs)) { ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th><input type="checkbox" name="check_all_faqs" id="check_all_faqs" value="" /></th>
                                    <th>ID</th>
                                    <th>FAQ Title</th>
                                    <th>FAQ Description</th>
                                    <th>FAQ Category</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                foreach ($faqs as $faq) {
                                    $faq_cat_ids = $faq->faq_cat;
                                    $faq_cat = wp_list_pluck($wpdb->get_results("SELECT faq_cat_title FROM $faq_cat_table WHERE id IN ($faq_cat_ids) "), 'faq_cat_title');
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" name="selected_faq" class="selected_faq" value="<?php echo $faq->id; ?>" /></td>
                                        <td><?php echo $faq->id; ?></td>
                                        <td><?php echo $faq->faq_title; ?></td>
                                        <td><?php echo $faq->faq_content; ?></td>
                                        <td><?php echo implode(', ', $faq_cat); ?></td>
                                        <td><button class="edit_faq" data-id="<?php echo $faq->id; ?>" class="btn">Edit</button><button class="delete_faq" data-id="<?php echo $faq->id; ?>" class="btn">Delete</button></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <?php } else { ?>
                        <p>No FAQs were found!</p>    
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>