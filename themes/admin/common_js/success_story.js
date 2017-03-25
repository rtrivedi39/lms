function add_success_story()
{
    var checkInputs = validateInputs("add_story_form"); 	
    if(checkInputs)
    {
        $("form#add_story_form").submit();
    }    
}

function upd_success_story()
{
    var checkInputs = validateInputs("upd_story_form"); 	
    if(checkInputs)
    {
        $("form#upd_story_form").submit();
    }    
}



/*For Add Trusted Seal image*/
        $('#success_image').bind('change', function() {
          /*check file type*/
            var img_ext = $('#success_image').val().split('.').pop().toLowerCase();
          /*end*/
            if(this.files[0].size > 2199999){
               $(this).val('');
	       $('#sus_preview_image').css("display","none");
               $(".default_img").css("display","block");
               alert("You can not upload the selected file, file size should not exceed 2 MB.");
               return false;
            }else if($.inArray(img_ext, ['jpg','gif','png','jpeg','JPG','GIF','PNG','JPEG']) == -1) {
                $(this).val('');
                $('#sus_preview_image').css("display","none");
                $(".default_img").css("display","block");
                alert("Invalid file type! supports only jpg,jpeg,gif & png file type.");
                return false;
            }else{
                $("#sus_preview_image").html('');
		$('#sus_preview_image').css("display","block");	
                return true;
            }
        });



/*For Edit Trusted Seal image*/
        $('#upd_story_image').bind('change', function() {
          /*check file type*/
            var img_ext = $('#upd_story_image').val().split('.').pop().toLowerCase();
          /*end*/
            if(this.files[0].size > 2199999){
                $(this).val('');
		$('#upd_storyPreview').css("display","block");
                $(".default_img").css("display","block");
                alert("You can not upload the selected file, file size should not exceed 2 MB.");
                $("#default_image").css("display","block");
		$("#hid_succ_image").val("");
                
                return false;
            }else if($.inArray(img_ext, ['jpg','gif','png','jpeg','JPG','GIF','PNG','JPEG']) == -1) {
                $(this).val('');
		//$('#upd_storyPreview').css("display","none");
                
                alert("Invalid file type! supports only jpg,jpeg,gif & png file type.");
                $("#default_image").css("display","block");
		$("#hid_succ_image").val("");
                $(".upd_storyPreview").css("display","block");
                return false;
            }else{
		$('#upd_storyPreview').css("display","block");
                $("#default_image").css("display","none");			
                return true;
            }
        });



 function story_validation(){
	var story_writer = document.getElementById('story_writer').value;
	var designation = document.getElementById('designation').value;
        var story_text = document.getElementById('story_text').value;
        if(story_writer==""){
            alert("Please enter story writer!");
	    document.getElementById('story_writer').focus();
            return false;
        }
	if(designation==""){
            alert("Please enter story designation!");
	    document.getElementById('designation').focus();
            return false;
        }
	if(story_text==""){
            alert("Please enter story text!");
	    document.getElementById('story_text').focus();
            return false;
        }
	
    }

 function updstory_validation(){
	var story_writer = document.getElementById('story_writer').value;
	var designation = document.getElementById('upd_designation').value;
        var story_text = document.getElementById('upd_succ_text').value;
        if(story_writer==""){
            alert("Please enter story writer!");
	    document.getElementById('story_writer').focus();
            return false;
        }
	if(designation==""){
            alert("Please enter story designation!");
	    document.getElementById('designation').focus();
            return false;
        }
	if(story_text==""){
            alert("Please enter story text!");
	    document.getElementById('story_text').focus();
            return false;
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

