function deleteData(id, operation_on)
{
    var msg = "";
    var status = "";
    msg = "Are you sure, you want to delete this ?";
    if (confirm(msg))
    {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: site_path + 'admin/admin_ajax/deleteData',
            data: {
                'id': id,
                'operation_on': operation_on
            },
            success: function(data) {
                if (data == 1) {
                    $("#row_" + id).hide();
                    $("#row_" + id).delay(800);
                } else {
                    bootbox.alert(data.error + " !");
                }
            }
        });
    }
}

function deleteImage()
{

    var msg = "";
    msg = "Are you sure, you want to delete this image ?";
    if (confirm(msg))
    {
    $("#upd_subcate_image").html('');
    $(".default_img").css("display","block");
    $("#upd_subcategory_Image").val('');
    $("#updcategoryimages").html('');
    $("#categoryImage").val('');
    $("#updcategoryimages").html('<img id="succblankimage" width="83px" src="'+site_path +'/assets/uploads/category_image/default_flag.jpg"/>');
    $("#hide_category_image").val('');
    $("#sus_preview_image").html('');
    $("#success_image").val('');
    $("#upd_storyImage").html("");
    $("#upd_story_image").val('');
    $("#hid_succ_image").val('');
    $("#file_text").val();

    $("#upd_storyPreview").html('<img id="succblankimage" width="83px" src="'+site_path +'/assets/uploads/category_image/default_flag.jpg"/>');
   
    $("#upd_story_image").val('');
     
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: site_path + 'admin/admin_ajax/deleteData',
            data: {
                'id': id,
                'operation_on': operation_on
            },
            success: function(data) {
                if (data == 1) {
                    $("#row_" + id).hide();
                    $("#row_" + id).delay(800);
                } else {
                    bootbox.alert(data.error + " !");
                }
            }
        });
    }
}

function isNumberKey(evt)
{

    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
    if (!emailReg.test(email)) {
        return false;
    } else {
        return true;
    }
}

function isValidURL(url) {
    //var RegExp1 = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    var RegExp = /((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)/i;
    if (RegExp.test(url)) {
        return true;
    } else {
        return false;
    }
}

var GroupTable = function() {
    return {
        //main function to initiate the module
        init: function() {
            if (!jQuery().dataTable) {
                return;
            }
            $('#group_table').dataTable({
                "bRetrieve": true,
                "bDestroy": true,
                "aaSorting": [[3, "desc"]],
                "aaSorting": [],
                "aLengthMenu": [
                    [10, 15, 20, -1],
                    [10, 15, 20, "All"] // change per page values here
                ],
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ ",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });

            jQuery('#group_table .group-checkable').change(function() {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function() {
                    var tr = $(this).parent().parent();
                    if (checked) {
                        $(this).prop('checked', true);
                        $(tr).addClass("success");
                    } else {
                        $(this).prop('checked', false);
                        $(tr).removeClass("success");
                    }
                });
                setme();
            });
            jQuery('#group_table_wrapper .dataTables_filter input').addClass("input-sm"); // modify table search input
            jQuery('#group_table_wrapper .dataTables_length select').addClass("form-control input-sm"); // modify table per page dropdown

        }

    };
}();

jQuery(document).ready(function() {
    GroupTable.init();
    $(".dataTables_paginate ul").addClass("pagination");
});
var oTable;
var giRedraw = false;
$(document).ready(function() {
    /* Init the table */
    oTable = $('.allow_table_script').dataTable();
});


function set_usersstatus(id, operation_on) {

    if ($("#status_" + id).hasClass("icon-ok-sign text-success")) {
        $("#status_" + id).removeClass("icon-ok-sign text-success");
        $("#status_" + id).addClass("icon-minus-sign text-error");
        var status = 0;
    } else if ($("#status_" + id).hasClass("icon-minus-sign text-error")) {
        $("#status_" + id).removeClass("icon-minus-sign text-error");
        $("#status_" + id).addClass("icon-ok-sign text-success ");
        var status = 1;
    }
    $.ajax({
        type: 'post',
        dataType: 'text',
        acync: false,
        url: site_path + 'admin/admin_ajax/setstatus',
        data: {
            'id': id,
            'status': status,
            'operation_on': operation_on
        },
        success: function(data) {
        }

    });
}

function validateInputs(form_id)
{
    var ack = 1;
    $("form#" + form_id + " .required").each(function() {
        if ($(this).val() == "")
        {
            ack = 0;
            $(this).css("border", "1px solid red");

        }
        else {
            $(this).css("border", "1px solid green");
        }
    });

    if (ack == 0)
    {
        return false;

    } else {
        return true;
    }

}




//----------------------------------------------------------------------------------------------------------------------------------------------
//Trim Multiple Space in to Single Space 
//----------------------------------------------------------------------------------------------------------------------------------------------
function trimspace(element) {
    var cat = jQuery('#' + element).val();
    cat = cat.replace(/ +(?= )/g, '');
    if (cat != " ") {
        jQuery('#' + element).val(cat);
    } else {
        jQuery('#' + element).val($.trim(cat));
    }
}

jQuery('.vSingleSpace').on('keyup keypress', function() {
    trimspace(this.id);
});

//----------------------------------------------------------------------------------------------------------------------------------------------


//----------------------------------------------------------------------------------------------------------------------------------------------
//Block Alphabets
//----------------------------------------------------------------------------------------------------------------------------------------------
/* Block Alphabets, Eg. for Contact Field */
jQuery('.vNumericOnly').keydown(function(e) {
    // If you want decimal(.) please use 190 in inArray.
    // Allow: backspace, delete, tab, escape, enter.
    if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
            // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right, down, up
                            (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
//----------------------------------------------------------------------------------------------------------------------------------------------


//----------------------------------------------------------------------------------------------------------------------------------------------
//Block Numbers
//----------------------------------------------------------------------------------------------------------------------------------------------
/* Block Numbers, Eg. for Name Field */
jQuery('.vAlphabetsOnly').bind('keyup blur', function() {
    var node = jQuery(this);
    node.val(node.val().replace(/[^a-zA-Z ]/g, ''));
});
//-----------------

//----------------------------------------------------------------------------------------------------------------------------------------------
//Block Space
//----------------------------------------------------------------------------------------------------------------------------------------------
/* Block Space*/
$(".vNoSpace").on("keydown", function(e) {
    return e.which !== 32;
});
//-----------------







