<?php 
error_reporting(E_ALL);
echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
if(isset($_REQUEST['data']) && $_REQUEST['data']!=''){
	$s_c_data= $_REQUEST['data'];
}else{$s_c_data='';}
$post_data_array = json_decode($s_c_data, true);
/*Database Setting*/
$servername = "localhost";
$username = "dbadmin";
$password = "password";
//echo '<pre>';
//print_r($_REQUEST);
if($_REQUEST['emp_id']=='leave_livemode'){	
	$dbname="db_ftms_leave";	/*For Leave order */
}else{
$dbname = "db_ftms_eoffice_26";
}
/*Database Setting*/
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if(isset($_REQUEST['sign_data']) && $_REQUEST['sign_data']!=''){
	$signature= $_REQUEST['sign_data'];	
}else{$signature='';}
if(isset($_REQUEST['publicKey']) && $_REQUEST['publicKey']!=''){
	$public_key= $_REQUEST['publicKey'];
}else{ $public_key='';}
if(isset($_REQUEST['verification_status']) && $_REQUEST['verification_status']!=''){
	$verification_status= $_REQUEST['verification_status'];
}else{ $verification_status='';}

if(isset($_REQUEST['emp_name']) && $_REQUEST['emp_name']!=''){	
$emp_name= $_REQUEST['emp_name'];
}else{$emp_name='n/a';} 
if(isset($_REQUEST['file_id']) && $_REQUEST['file_id']!=''){
$user_level= $_REQUEST['file_id'];
}else{ $user_level=0; $draft_log_creater=0;} 
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d H:i:s');
//print_r($post_data_array);
	foreach($post_data_array as $ky=>$file_data){	
		$file_data['up_down'];
		if($file_data['up_down']=='1' && ($file_data['up_down']!='order' || $file_data['up_down']!='odn') ){
			$file_id = $file_data['ck_file_id'];
			$rmk1="ASAP";
			$mark_emp_id=$file_data['empid'];
			$section_id=$file_data['section_id'];
			$file_status=$file_data['file_status']; 			
			$draft_log_id=$file_data['file_param2']; 
			$user_level=$file_data['file_param3']; 
			$loggined_in_userId=$file_data['file_param4']; 	
			$sign_data=$file_data['sign_data']; 
			$sign_public_key=$file_data['public_key'];
			$signature= $file_data['sign_data'];				
			$md5_sign_data=$file_data['file_param1']; 			
			//$post_data=utf8_decode(base64_decode($file_data['signing_content'])); 
			$post_data=$file_data['signing_content']; 
						$file_status=safe_b64encode($file_status);
						$url = "http://10.115.254.213/manage_file/efile_updates/multi_file_send_upper_officer/$file_id/$rmk1/$mark_emp_id/$section_id/$file_status/$draft_log_id/$loggined_in_userId";
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
						// This is what solved the issue (Accepting gzip encoding)
						curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
						echo $response = curl_exec($ch);
						print_r($response);
						curl_close($ch);
		}else if($file_data['up_down']=='0' && ($file_data['up_down']!='order' || $file_data['up_down']!='odn') ){                
			$file_id = $file_data['ck_file_id'];
			$rmk1="ASAP";
			$mark_emp_id=$file_data['empid'];
			$section_id=$file_data['section_id'];
			$file_status=$file_data['file_status'];  
			$draft_log_id=$file_data['file_param2']; 
			$user_level=$file_data['file_param3']; 
			$loggined_in_userId=$file_data['file_param4']; 
			$sign_data=$file_data['sign_data']; 
			$sign_public_key=$file_data['public_key']; 
			//$post_data=utf8_decode(base64_decode($file_data['signing_content'])); 
			$post_data=$file_data['signing_content']; 
			$md5_sign_data=$file_data['file_param1'];
			
			$signature= $file_data['sign_data'];	
			$file_status=safe_b64encode($file_status);
			if($user_level==6){						
						$url = "http://10.115.254.213/view_file/efile_dealing/multi_file_sent_to_da/$file_id/$mark_emp_id/$section_id/$file_status/$draft_log_id/$loggined_in_userId";
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
						// This is what solved the issue (Accepting gzip encoding)
						curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
						$response = curl_exec($ch);
						curl_close($ch);
			}else{ 
						$url = "http://10.115.254.213/manage_file/efile_updates/multi_return_file/$file_id/$mark_emp_id/$loggined_in_userId/$section_id/$rmk1/$draft_log_id";
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
						// This is what solved the issue (Accepting gzip encoding)
						curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
						$response = curl_exec($ch);
						//echo '<pr>';
						//var_dump($response);
						//echo 'bije';
						curl_close($ch);					
				}				
		}else if(($file_data['up_down']=='odn' || $file_data['up_down']=='order') && ($file_data['up_down']!='0' || $file_data['up_down']!='1')){
			
			$signature=$file_data['sign_data'];	
			$post_data=$file_data['signing_content']; 
			$sign_public_key=$file_data['public_key']; 
			$draft_log_id=$file_data['file_param2']; 
			$loggined_in_userId=$file_data['file_param4']; 
			$file_id=$file_data['ck_file_id'];;			
			$md5_sign_data=$file_data['file_param1'];
		}	
			
		$insert_sql = "INSERT INTO ft_digital_signature(ds_signature,ds_signed_data,ds_public_key,ds_verification_status,ds_emp_name,ds_draft_log_id,ds_create_datetime,ds_emp_id,ds_file_id,ds_data,ds_local_data)
		VALUES('".$signature."','".$post_data."','".$sign_public_key."','".$verification_status."','".$emp_name."',".$draft_log_id.",'".$date."',".$loggined_in_userId.",".$file_id.",'".$post_data."','".$md5_sign_data."')";
		if ($conn->query($insert_sql) === TRUE) {
			echo 'Record Inserted success fully';
		} else {	
			echo "Error: " . $insert_sql . "<br>" . $conn->error;
		}		
}
function safe_b64encode($string) {
	$data = base64_encode($string);
	$data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
	return $data;
}
function escape_str($str, $like = TRUE)
{
	$str=trim($str);
	$ci = & get_instance();
    if (is_array($str))
    {
        foreach ($str as $key => $val)
        {
            $str[$key] = $ci->escape_str($val, $like);
        }

        return $str;
    }

    if (function_exists('mysqli_real_escape_string') AND is_object($ci->conn_id))
    {
        $str = mysqli_real_escape_string($ci->conn_id, $str);
    }
    else
    {
        $str = addslashes($str);
    }
    // escape LIKE condition wildcards
    if ($like === TRUE)
    {
        $str = str_replace(array('%', '_'), array('\\%', '\\_'), $str);
    }

    return $str;
}

?>