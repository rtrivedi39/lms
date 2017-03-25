/*For Add Trusted Seal image*/
        $('#trusted_image').bind('change', function() {
          /*check file type*/
            var img_ext = $('#trusted_image').val().split('.').pop().toLowerCase();
		
		
		
          /*end*/
            if(this.files[0].size > 21999999){
               $(this).val('');
	       $('#tr_preview_image').css("display","none");
	       $('#add_trust').attr('disabled','disabled');
               alert("You can not upload the selected file, file size should not exceed 2 MB.");
               return false;
            }else if($.inArray(img_ext, ['jpg','gif','png','jpeg','JPG','GIF','PNG','JPEG']) == -1) {
                $(this).val('');
                $('#tr_preview_image').css("display","none");
		$('#add_trust').attr('disabled','disabled');
                alert("Invalid file type! supports only jpg,jpeg,gif & png file type.");
                return false;
            }else{
                $("#add_trusted_error").html('');
		$('#add_trust').removeAttr('disabled');
		$('#tr_preview_image').css("display","block");	
                return true;
            }
        });



/*For Edit Trusted Seal image*/
        $('#upd_trusted_image').bind('change', function() {
          /*check file type*/
            var img_ext = $('#upd_trusted_image').val().split('.').pop().toLowerCase();
          /*end*/
            if(this.files[0].size > 2199999){
                $(this).val('');
		$('#upd_trust').attr('disabled','disabled');
		$('#upd_trusPreview').css("display","none");
                alert("You can not upload the selected file, file size should not exceed 2 MB.");
                return false;
            }else if($.inArray(img_ext, ['jpg','gif','png','jpeg','JPG','GIF','PNG','JPEG']) == -1) {
                $(this).val('');
		$('#upd_trust').attr('disabled','disabled');
		$('#upd_trusPreview').css("display","none");
                alert("Invalid file type! supports only jpg,jpeg,gif & png file type.");
                return false;
            }else{
		$('#upd_trust').removeAttr('disabled');
		$('#upd_trusPreview').css("display","block");			
                return true;
            }
        });


 function trust_validation(){
        var add_image= document.getElementById('trusted_image').value;
        if(add_image==""){
            alert("Please select trusted seal image !");
            return false;
        }else{
	    return true;
	}
    }

 function upd_trust_validation(){
        var add_image= document.getElementById('upd_trusted_image').value;
        if(add_image==""){
            alert("Please select trusted seal image !");
            return false;
        }else{
	    return true;
	}
    }
