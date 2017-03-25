
/*For Image Upload*/
        $('#advertise_image').bind('change', function() {
          /*check file type*/
            var img_ext = $('#advertise_image').val().split('.').pop().toLowerCase();
          /*end*/
            if(this.files[0].size > 2199999){
               $(this).val('');
	       $('#add_image').attr('disabled','disabled');
	       $('#preview_image').css("display","none");
               alert("You can not upload the selected file, file size should not exceed 2 MB.");
               return false;
            }else if($.inArray(img_ext, ['jpg','gif','png','jpeg','JPG','GIF','PNG','JPEG']) == -1) {
               $(this).val('');
	       $('#add_image').attr('disabled','disabled');
	       $('#preview_image').css("display","none");
               alert("Invalid file type! supports only jpg, jpeg, gif & png file type.");
               return false;
            }else{
                $("#add_advertise_error").html('');
		$('#add_image').removeAttr('disabled');
                $('#preview_image').css("display","block");
		//$('#advertise_error').css('display','none');		
                return true;
            }
        });


/*For Image Upload*/
        $('#advertisement_image').bind('change', function() {
          /*check file type*/
            var img_ext = $('#advertisement_image').val().split('.').pop().toLowerCase();
          /*end*/
            if(this.files[0].size > 2199999){
                $(this).val('');
		$('#upd_add').attr('disabled','disabled');
		$('#imagePreview').css("display","none");
                alert("You can not upload the selected file, file size should not exceed 2 MB.");
                return false;
            }else if($.inArray(img_ext, ['jpg','gif','png','jpeg','JPG','GIF','PNG','JPEG']) == -1) {
                $(this).val('');
		$('#upd_add').attr('disabled','disabled');
		$('#imagePreview').css("display","none");
                alert("Invalid file type! supports only jpg,jpeg,gif & png file type.");
                return false;
            }else{
		$('#upd_add').removeAttr('disabled');
		//$('#advertise_error').css('display','none');
		$('#imagePreview').css("display","block");			
                return true;
            }
        });


 function image_validation(){
        var add_image= document.getElementById('advertise_image').value;
        if(add_image==""){
            alert("Please select advertisement image !");
            return false;
        }else{
	    return true;
	}
    }

 function edit_ad_validation(){
        var add_image= document.getElementById('advertisement_image').value;
        if(add_image==""){
            alert("Please select advertisement image !");
            return false;
        }else{
	    return true;
	}
    }
