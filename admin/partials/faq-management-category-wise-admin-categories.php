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
$faq_cat_table = $wpdb->prefix . 'faq_category';
$faq_categories = $wpdb->get_results("SELECT * FROM $faq_cat_table");
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="faq-categories-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">FAQ Categories</h1>
                <div class="button-action-wrapper">
                    <button class="btn btn-default" id="add_new_faq_category" name="add-new-faq-category">Add New Category</button>
                    <button class="btn btn-default" id="remove_faq_categories" name="remove-faq-categories">Remove Categories</button>
                </div>
                <div class="faq-categories-notices"></div>
                <div class="add-new-faq-category-wrapper">
                    <form id="add_new_faq_cat" name="add-new-faq-category" method="post" action="">
                        <div class="form-group">
                            <lable>Category Title</lable>
                            <input type="text" id="cat_title" name="category-title" minlength="2" required />
                        </div>
                        <div class="form-group">
                            <lable>Category Icon</lable>
                            <input type="file" id="cat_icon" name="category-icon" />
                        </div>
                        <button type="submit" id="add_new_cat_btn" class="btn btn-primary">Submit</button>
                    </form>
                </div> 
                <div class="list-faq-categories">
                    <?php if (!empty($faq_categories)) { ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th><input type="checkbox" name="check_all_categories" id="check_all_categories" value="" /></th>
                                    <th>ID</th>
                                    <th>Category Icon</th>
                                    <th>Category Name</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach ($faq_categories as $faq_cat) { ?>
                                    <tr>
                                        <td><input type="checkbox" name="selected_cat" class="selected_cat" value="<?php echo $faq_cat->id; ?>" /></td>
                                        <td><?php echo $faq_cat->id; ?></td>
                                        <td><img width="50" height="auto" src="<?php echo $faq_cat->faq_cat_icon; ?>" /></td>
                                        <td><?php echo $faq_cat->faq_cat_title; ?></td>
                                        <td><button class="edit_category" data-id="<?php echo $faq_cat->id; ?>" class="btn">Edit</button><button class="delete_category" data-id="<?php echo $faq_cat->id; ?>" class="btn">Delete</button></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <?php } else{ ?>
                    <p>No Categories were found!</p>    
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>