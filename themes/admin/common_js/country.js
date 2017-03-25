function add_new_country()
{
    var checkInputs = validateInputs("add_country");
    if(checkInputs)
    {
        $("form#add_country").submit();
    }    
}

function updatecountry()
{
    var checkInputs = validateInputs("update_country_frm");
    if(checkInputs)
    {
        $("form#update_country_frm").submit();
    }    
}

function update_region()
{
    var checkInputs = validateInputs("update_region_frm");
    if(checkInputs)
    {
        $("form#update_region_frm").submit();
    }    
}

function add_new_region()
{
    var checkInputs = validateInputs("add_region");
    if(checkInputs)
    {
        $("form#add_region").submit();
    }    
}

function add_new_state()
{
    var checkInputs = validateInputs("add_state");
    if(checkInputs)
    {
        $("form#add_state").submit();
    }    
}


function add_new_city()
{
    var checkInputs = validateInputs("add_city_frm");
    if(checkInputs)
    {
        $("form#add_city_frm").submit();
    }    
}


function view_country(id) {
    $.ajax({
        type: 'post',
        url: site_path + 'admin/admin_ajax/view_country',
        data: {
            'id': id
        },
        success: function(data) {
            if (data) {
                var response = JSON.parse(data);
               //alert(response[0].country_dialing_code);
                $("#upd_country_name").val(response[0].country_name);
                $("#upd_country_dialing_code").val(response[0].country_dialing_code);
                $("#hid_country_flag").val(response[0].country_flag);
		if(response[0].country_flag=="" || response[0].country_flag=="null"){
			$("#blank_countryImage").html('<img width="83px" src="'+site_path +'/assets/uploads/category_image/default_flag.jpg"/>');
			$("#upd_country_flag").css('display','none');
		}else{
			$("#upd_country_flag").html('<img id="updcountry_flag" width="83px" src="'+site_path +'/assets/uploads/country_flag/'+response[0].country_flag + '" />');
			$("#upd_country_flag").css('display','block');
		}
                $("#upd_cntry_id").val(response[0].country_id);
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function(data) {
            
            $('#Edit_country').modal('show');
        }
    });
}


function view_edit_state(id) {
    $.ajax({
        type: 'post',
        url: site_path + 'admin/admin_ajax/view_edit_state',
        data: {
            'id': id
        },
        success: function(data) {
            if (data) {
                var response = JSON.parse(data);
                //alert(response[0].country_id);
                $("#add_new_myModalLabel").text('Update State');
                $("#hidden_state_id").val(response[0].state_id);
                $("#stateName").val(response[0].state_name);
                $("#upd_cntry_id").val(response[0].country_id);
                //$("#upd_cntry_id").val(response[0].rgn_id);

                $('[name=regionName] option').filter(function() { 
                    return ($(this).val() == response[0].rgn_id); //To select Blue
                }).prop('selected', true);
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function(data) {
            
            $('#Edit_country').modal('show');
        }
    });
}

function view_city_detail(id) {
    $.ajax({
        type: 'post',
        url: site_path + 'admin/admin_ajax/view_city_detail',
        data: {
            'id': id
        },
        success: function(data) {
            if (data) {
                var response = JSON.parse(data);
                //alert(response[0].country_id);
                $('.hide_filed').hide();
                $("#myModalLabel_city").text('Update City');
                $("#hidden_city_id").val(response[0].city_id);
                $("#cityName").val(response[0].city_name);
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function(data) {
            
            $('#add_city_frm').modal('show');
        }
    });
}




function deleteUser(id)
{
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: site_path + 'admin/admin_ajax/delUser',
        data: {
            'id': id
        },
        success: function(data) {
            
            if (data) {
                $(this).parent.parent().hide();
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function() {
            $('#myModal').modal('hide');
        }
    });
}


/*For Image Upload*/
        $('#country_flag').bind('change', function() {
          /*check file type*/
            var img_ext = $('#country_flag').val().split('.').pop().toLowerCase();
          /*end*/
            if(this.files[0].size > 2199999){
               $(this).val('');
		$('#add_cntry').attr('disabled','disabled');	
               $("#add_country_error").html('<div class="alert-error hideauto" style="margin-top:2px">You can not upload the selected file, file size should not exceed 2 MB.</div>');
               return false;
            }else if($.inArray(img_ext, ['jpg','gif','png','jpeg','JPG','GIF','PNG','JPEG']) == -1) {
                $(this).val('');
		$('#add_cntry').attr('disabled','disabled');	
                $("#add_country_error").html('<div class="alert-error hideauto">Invalid file type! supports only jpg,jpeg,gif & png file type.</div>');
                return false;
                //alert('invalid extension!');
            }else{
                $("#add_country_error").html('');
		$('#add_cntry').removeAttr('disabled');	
                return true;
            }
        });


/*For update country flag Upload*/
        $('#countryflag').bind('change', function() {
          /*check file type*/
            var img_ext = $('#countryflag').val().split('.').pop().toLowerCase();
          /*end*/
            if(this.files[0].size > 2199999){
               $(this).val('');
		$('#upd_cntry').attr('disabled','disabled');
               $("#updcountry_error").html('<div class="alert-error hideauto" style="margin-top:2px">You can not upload the selected file, file size should not exceed 2 MB.</div>');
               return false;
            }else if($.inArray(img_ext, ['jpg','gif','png','jpeg','JPG','GIF','PNG','JPEG']) == -1) {
                $(this).val('');
		$('#upd_cntry').attr('disabled','disabled');
                $("#updcountry_error").html('<div class="alert-error hideauto">Invalid file type! supports only jpg,jpeg,gif & png file type.</div>');
                return false;
                //alert('invalid extension!');
            }else{
                $("#updcountry_error").html('');
		$('#upd_cntry').removeAttr('disabled');	
                return true;
            }
        });




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




