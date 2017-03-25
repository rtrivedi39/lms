function add_new_category()
{
    var checkInputs = validateInputs("add_category_frm"); 	
    if(checkInputs)
    {
        $("form#add_category_frm").submit();
    }    
}

function update_category()
{
    var checkInputs = validateInputs("update_category_frm");
    if(checkInputs)
    {
        $("form#update_category_frm").submit();
    }    
}



function add_new_sub_category()
{
    var checkInputs = validateInputs("add_sub_category_frm");
    if(checkInputs)
    {
        $("form#add_sub_category_frm").submit();
    }    
}

function upd_new_sub_category()
{
    var checkInputs = validateInputs("upd_sub_category_frm");
    if(checkInputs)
    {
        $("form#upd_sub_category_frm").submit();
    }    
}

function view_category(id) {
    $.ajax({
        type: 'post',
        url: site_path + 'admin/admin_ajax/view_category',
        data: {
            'id': id
        },
        success: function(data) {
            if (data) {
                var response = JSON.parse(data);
                //alert(response[0].category_id);
                $("#upd_category_name").val(response[0].category_name);
		$("#hide_category_image").val(response[0].category_image);
		//var cat="'category'";
		if(response[0].category_image=="" || response[0].category_image=="null"){
			$("#blank_cateImage").html('<img width="83px" src="'+site_path +'/assets/uploads/category_image/default_flag.jpg"/>');
			$("#updcategoryimages").css('display','none');
		}else{
                    $("#updcategoryimages").html('<img id="updcategoryimages" width="83px" src="'+site_path +'/assets/uploads/category_image/'+response[0].category_image + '" /> <div style="margin-top:5px"><a onclick="deleteImage()" href="javascript:void(0)" id="delete">x</a></div>');
                //alert("change cate image");
		$("#updcategoryimages").css('display','block');
                }
                $("#upd_category_id").val(response[0].category_id);
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function(data) {
            
        //$('#Edit_country').modal('show');
        }
    });
}

function view_sub_category(id) {
    $.ajax({
        type: 'post',
        url: site_path + 'admin/admin_ajax/view_category',
        data: {
            'id': id
        },
        success: function(data) {
            if (data) {
                var cat="'category'";
                var response = JSON.parse(data);
                //alert(response[0].category_name);
                $("#update_sub_cat_name").val(response[0].category_name);
		$("#hide_subcategory_image").val(response[0].category_image);
		if(!response[0].category_image=="" || !response[0].category_image=="null"){
		   $("#upd_subcateimages").html('<img id="updsubcateimages" width="83px" src="'+site_path +'/assets/uploads/category_image/'+response[0].category_image + '" /><div style="margin-top:5px"><a onclick="deleteImage()" href="javascript:void(0)" id="delete">x</a></div>');
			$("#upd_subcateimages").css('display','block');
		}else{
			$("#upd_subcateimages").css("display","none");
			$("#blank_subcateImages").html('<img width="83px" src="'+site_path +'/assets/uploads/category_image/default_flag.jpg"/>');
                	
                        //$("#blank_subcateImages").css("display","none");
		}
                $("#update_sub_category_id").val(response[0].category_id);
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function(data) {  
            //$('#Edit_country').modal('show');
        }
    });
}

/******Open Update Category Image Preview Query******/

$(function() {
    $("#categoryImage").on("change", function()
    { 
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
        
          if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            var abs= reader.readAsDataURL(files[0]);
            reader.onloadend = function(){ // set image data as background of div
            //alert(this.result);
                  // var newSrc = $("#updcategory_image").attr('src', this.result );
                   var newSrc = $("#updcategoryimages").html('<img class="img_border" width="100px" src="'+this.result+'"><div style="margin-top:5px"><a href="javascript:void(0);" onclick="deleteImage()" id="delete">x</a></div>');
                  if(newSrc){
                     $("#updcategoryimages").css('display','block');
                     $("#blank_cateImage").css("display","none");	
                   }  
            }
        }
    });
});


$(function() {
    $("#upd_subcategory_Image").on("change", function()
    { 
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
        
          if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            var abs= reader.readAsDataURL(files[0]);
            reader.onloadend = function(){ // set image data as background of div
              var newSrc = $("#updsubcateimages").html('<img class="img_border" width="100px" src="'+this.result+'"><div style="margin-top:5px"><a href="javascript:void(0);" onclick="deleteImage()" id="delete">x</a></div>');
              if(newSrc){
		  $("#upd_subcateimages").css('display','block');
                  $("#blank_subcateImages").css("display","none");	
              }
                   
                    
            }
        }
    });
});

/******Close Update Category Image Preview Query******/


/*For Add Category Image Upload*/
        $('#category_image').bind('change', function() {
          /*check file type*/
            var img_ext = $('#category_image').val().split('.').pop().toLowerCase();
          /*end*/
            if(this.files[0].size > 2199999){
               $(this).val('');
               $("#add_category").html('<div class="alert-error hideauto" style="margin-top:2px">You can not upload the selected file, file size should not exceed 2 MB.</div>');	
               return false;
            }else if($.inArray(img_ext, ['jpg','gif','png','jpeg','JPG','GIF','PNG','JPEG']) == -1) {
                $(this).val('');
                $("#add_category").html('<div class="alert-error hideauto">Invalid file type! supports only jpg,jpeg,gif & png file type.</div>');
                return false;
                //alert('invalid extension!');
            }else{
                $("#add_category").html('');
                return true;
            }
        });



/*For Image Upload*/
        $('#categoryImage').bind('change', function() {
          /*check file type*/
            var img_ext = $('#categoryImage').val().split('.').pop().toLowerCase();
          /*end*/
            if(this.files[0].size > 2199999){
               $(this).val('');
               $("#upd_category_error").html('<div class="alert-error hideauto" style="margin-top:2px">You can not upload the selected file, file size should not exceed 2 MB.</div>');
               return false;
            }else if($.inArray(img_ext, ['jpg','gif','png','jpeg','JPG','GIF','PNG','JPEG']) == -1) {
                $(this).val('');
                
                $("#upd_category_error").html('<div class="alert-error hideauto">Invalid file type! supports only jpg,jpeg,gif & png file type.</div>');
                return false;
                //alert('invalid extension!');
            }else{
                $("#upd_category_error").html('');
                return true;
            }
        });


/*For Image Upload*/
        $('#sub_category_image').bind('change', function() {
          /*check file type*/
            var img_ext = $('#sub_category_image').val().split('.').pop().toLowerCase();
          /*end*/
            if(this.files[0].size > 2199999){
               $(this).val('');	
               $("#subcategoryError").html('<div class="alert-error hideauto" style="margin-top:2px">You can not upload the selected file, file size should not exceed 2 MB.</div>');
               return false;
            }else if($.inArray(img_ext, ['jpg','gif','png','jpeg','JPG','GIF','PNG','JPEG']) == -1) {
                $(this).val('');			
                $("#subcategoryError").html('<div class="alert-error hideauto">Invalid file type! supports only jpg,jpeg,gif & png file type.</div>');
                return false;
                //alert('invalid extension!');
            }else{
                $("#subcategoryError").html('');
                return true;
            }
        });


/*For Image Upload*/
        $('#upd_subcategory_Image').bind('change', function() {
          /*check file type*/
            var img_ext = $('#upd_subcategory_Image').val().split('.').pop().toLowerCase();
          /*end*/
            if(this.files[0].size > 2199999){
               $(this).val('');
               $("#updsub_cate_error").html('<div class="alert-error hideauto" style="margin-top:2px">You can not upload the selected file, file size should not exceed 2 MB.</div>');
			
               return false;
            }else if($.inArray(img_ext, ['jpg','gif','png','jpeg','JPG','GIF','PNG','JPEG']) == -1) {
                $(this).val('');
		
                $("#updsub_cate_error").html('<div class="alert-error hideauto">Invalid file type! supports only jpg,jpeg,gif & png file type.</div>');
                return false;
                //alert('invalid extension!');
            }else{
                $("#updsub_cate_error").html('');
		
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


