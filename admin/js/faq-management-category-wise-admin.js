var $ = jQuery.noConflict();
$(document).ready(function () {
    //show add new category form
    $('#add_new_faq_category').click(function () {
        $('.add-new-faq-category-wrapper').show();
    });

    //validate add new category fields
    $('#add_new_faq_cat #add_new_cat_btn').click(function () {
        $('.faq-categories-notices').html('');
        var cat_name = $('#cat_title').val();

        if (cat_name.length == 0) {
            $('.faq-categories-notices').css("border", "2px solid red").html("<p>Category Title cannot be blank!</p>");
            $('.faq-categories-notices').show();
            $("#cat_title").focus();
            return false;
        }

        var maxSize = '2048';
        var file_size = Math.round(($('#cat_icon')[0].files[0].size / 1024));
        var fileName = $("#cat_icon").val();

        if (fileName.length == 0) {
            $('.faq-categories-notices').css("border", "2px solid red").html("<p>Please select horse image!</p>");
            $('.faq-categories-notices').show();
            $("#cat_icon").focus();
            return false;
        }

        if (file_size > maxSize) {
            $('.faq-categories-notices').css("border", "2px solid red").html("<p>File size is greater than 2MB! Please upload file less than 2MB!</p>");
            $('.faq-categories-notices').show();
            $("#cat_icon").focus();
            return false;
        }

        return true;
    });

    //save entries of add new category
    $('#add_new_faq_cat').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(document.getElementById("add_new_faq_cat"));
        formData.append('action', 'add_faq_cat');

        $.ajax({
            type: "post",
            dataType: "json",
            processData: false,
            cache: false,
            contentType: false,
            url: ajax_url.url,
            data: formData,
            success: function (response) {
                $('.faq-categories-notices').html('');
                if (response.success != null && response.success != "") {
                    $('.faq-categories-notices').css("border", "2px solid green").html('<p>' + response.success + '</p>');
                    $('.faq-categories-notices').show();
                    $('.list-faq-categories').html(response.data);
                    $("#add_new_faq_cat").trigger("reset");
                    $(".add-new-faq-category-wrapper").hide();
                } else {
                    $('.faq-categories-notices').css("border", "2px solid red").html('<p>' + response.error + '</p>');
                    $('.faq-categories-notices').show();
                }

                setTimeout(function () {
                    $('.faq-categories-notices').hide();
                    $('.faq-categories-notices').html('');
                }, 5000);
            }
        });
    });
    
    //delete single category
    $('.delete_category').on('click', function (e) {
        var cat_id = $(this).data('id');
        $.ajax({
            type: "post",
            dataType: "json",
            url: ajax_url.url,
            data: {action: 'delete_cat', cat: cat_id},
            success: function (response) {
                $('.faq-categories-notices').html('');
                if (response.success != null && response.success != "") {
                    $('.faq-categories-notices').css("border", "2px solid green").html('<p>' + response.success + '</p>');
                    $('.faq-categories-notices').show();
                    $('.list-faq-categories').html(response.data);
                } else {
                    $('.faq-categories-notices').css("border", "2px solid red").html('<p>' + response.error + '</p>');
                    $('.faq-categories-notices').show();
                }

                setTimeout(function () {
                    $('.faq-categories-notices').hide();
                    $('.faq-categories-notices').html('');
                }, 5000);
            }
        });
    });

    //delete multiple categories
    $('#remove_faq_categories').click(function () {
        var selected_categories = [];
        $(".list-faq-categories .selected_cat:checked").each(function () {
            selected_categories.push($(this).val());
        });

        $.ajax({
            type: "post",
            dataType: "json",
            url: ajax_url.url,
            data: {action: 'delete_cat', cat: selected_categories},
            success: function (response) {
                $('.faq-categories-notices').html('');
                if (response.success != null && response.success != "") {
                    $('.faq-categories-notices').css("border", "2px solid green").html('<p>' + response.success + '</p>');
                    $('.faq-categories-notices').show();
                    $('.list-faq-categories').html(response.data);
                } else {
                    $('.faq-categories-notices').css("border", "2px solid red").html('<p>' + response.error + '</p>');
                    $('.faq-categories-notices').show();
                }

                setTimeout(function () {
                    $('.faq-categories-notices').hide();
                    $('.faq-categories-notices').html('');
                }, 5000);
            }
        });
    });
    
    $('#add_new_faq').click(function () {
        $('.add-new-faq-wrapper').show();
    });
    
    //validate add new category fields
    $('#add_new_faq_frm #add_new_faq_btn').click(function () {
        $('.faq-notices').html('');
        var faq_name = $('#faq_title').val();
        var faq_cat = $('input[name="faq-cat[]"]:checked');

        if (faq_name.length == 0) {
            $('.faq-notices').css("border", "2px solid red").html("<p>FAQ Title cannot be blank!</p>");
            $('.faq-notices').show();
            $("#faq_title").focus();
            return false;
        }

        if (faq_cat.length == 0) {
            $('.faq-notices').css("border", "2px solid red").html("<p>Please select atleast one FAQ Category!</p>");
            $('.faq-notices').show();
            return false;
        }

        return true;
    });

    //save entries of add new category
    $('#add_new_faq_frm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        
        $.ajax({
            type: "post",
            dataType: "json",
            url: ajax_url.url,
            data: {action: 'add_faq', data: formData},
            success: function (response) {
                $('.faq-notices').html('');
                if (response.success != null && response.success != "") {
                    $('.faq-notices').css("border", "2px solid green").html('<p>' + response.success + '</p>');
                    $('.faq-notices').show();
                    $('.list-faq').html(response.data);
                    $("#add_new_faq_frm").trigger("reset");
                    $(".add-new-faq-wrapper").hide();
                } else {
                    $('.faq-notices').css("border", "2px solid red").html('<p>' + response.error + '</p>');
                    $('.faq-notices').show();
                }

                setTimeout(function () {
                    $('.faq-notices').hide();
                    $('.faq-notices').html('');
                }, 5000);
            }
        });
    });
    
    //delete single FAQ
    $('.delete_faq').on('click', function (e) {
        var faq_id = $(this).data('id');
        $.ajax({
            type: "post",
            dataType: "json",
            url: ajax_url.url,
            data: {action: 'delete_faq', faq: faq_id},
            success: function (response) {
                $('.faq-notices').html('');
                if (response.success != null && response.success != "") {
                    $('.faq-notices').css("border", "2px solid green").html('<p>' + response.success + '</p>');
                    $('.faq-notices').show();
                    $('.list-faq').html(response.data);
                } else {
                    $('.faq-notices').css("border", "2px solid red").html('<p>' + response.error + '</p>');
                    $('.faq-notices').show();
                }

                setTimeout(function () {
                    $('.faq-notices').hide();
                    $('.faq-notices').html('');
                }, 5000);
            }
        });
    });

    //delete multiple faqs
    $('#remove_faq').click(function () {
        var selected_faqs = [];
        $(".list-faq .selected_faq:checked").each(function () {
            selected_faqs.push($(this).val());
        });

        $.ajax({
            type: "post",
            dataType: "json",
            url: ajax_url.url,
            data: {action: 'delete_faq', faq: selected_faqs},
            success: function (response) {
                $('.faq-notices').html('');
                if (response.success != null && response.success != "") {
                    $('.faq-notices').css("border", "2px solid green").html('<p>' + response.success + '</p>');
                    $('.faq-notices').show();
                    $('.list-faq').html(response.data);
                } else {
                    $('.faq-notices').css("border", "2px solid red").html('<p>' + response.error + '</p>');
                    $('.faq-notices').show();
                }

                setTimeout(function () {
                    $('.faq-notices').hide();
                    $('.faq-notices').html('');
                }, 5000);
            }
        });
    });
    
    $("#cat_title_background_color, #faq_question_background_color").spectrum({
        showInput: true,
        className: "full-spectrum",
        showInitial: true,
        showPalette: true,
        showSelectionPalette: true,
        maxSelectionSize: 10,
        preferredFormat: "hex",
        localStorageKey: "spectrum.demo",
        palette: [
            ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
                "rgb(204, 204, 204)", "rgb(217, 217, 217)", "rgb(255, 255, 255)"],
            ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
                "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
            ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
                "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
                "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
                "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
                "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
                "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
                "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
                "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
                "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
                "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
        ]
    });
    
    $("#check_all_categories").click(function(){
        $('.selected_cat').not(this).prop('checked', this.checked);
    });
    
    $("#check_all_faqs").click(function(){
        $('.selected_faq').not(this).prop('checked', this.checked);
    });
});
