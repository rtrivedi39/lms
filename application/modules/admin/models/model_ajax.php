<?php

class Model_ajax extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('email');
        //   $this->load->library('S3');
    }

    public function delete_data() {
        $table = "tbl_" . $this->input->post('operation_on');

        $feild_prefix = $this->input->post('operation_on');

        if ($this->input->post('id')) {
            if ($this->input->post('operation_on') == "category") {
                $cat_detail = $this->db->query('SELECT category_image FROM tbl_category WHERE category_id = "' . $this->input->post('id') . '" ')->row_array();

                $fileName = $cat_detail['category_image'];
                @unlink('assets/uploads/category_image/' . $fileName);
                $this->db->query('Delete FROM ' . $table . ' WHERE 	category_child = "' . $this->input->post('id') . '" ');
                return $this->db->query('Delete FROM ' . $table . ' WHERE category_id = "' . $this->input->post('id') . '" ');
            }

            //======= Delete Advertisement ==================
            elseif ($this->input->post('operation_on') == "advertisement") {
                $add_detail = $this->db->query('SELECT advertisement_content FROM tbl_advertisement WHERE advertisement_id = "' . $this->input->post('id') . '" ')->row_array();
                $fileName = $add_detail['advertisement_content'];
                @unlink('assets/uploads/ad_image/' . $fileName);
                return $this->db->query('Delete FROM ' . $table . ' WHERE ' . $feild_prefix . '_id = "' . $this->input->post('id') . '" ');
            }

             //======= Delete Trusted Seal ==================
            elseif ($this->input->post('operation_on') == "trusted_seal") {
                $trust_detail = $this->db->query('SELECT trusted_seal_image FROM tbl_trusted_seal WHERE trusted_seal_id = "' . $this->input->post('id') . '" ')->row_array();

                $fileName = $trust_detail['trusted_seal_image'];

                @unlink('assets/uploads/trusted_seal/' . $fileName);
                return $this->db->query('Delete FROM ' . $table . ' WHERE ' . $feild_prefix . '_id = "' . $this->input->post('id') . '" ');
            }

            //======= Delete Success Story ==================
            elseif ($this->input->post('operation_on') == "success_story") {
                $trust_detail = $this->db->query('SELECT success_story_image FROM tbl_success_story WHERE success_story_id = "' . $this->input->post('id') . '" ')->row_array();
                $data = array(
                    'success_story_image' => null,
                    'is_deleted' => 1
                );

                $fileName = $trust_detail['success_story_image'];
                @unlink('assets/uploads/success_story_img/' . $fileName);

                $this->db->where('success_story_id', $this->input->post('id'));
                return $foo = $this->db->update($table, $data);
            }

            //======= Delete Business Card ==================
            elseif ($this->input->post('operation_on') == "business_card") {
                $card_image = $this->db->query('SELECT * FROM tbl_business_card WHERE business_card_id = "' . $this->input->post('id') . '" ')->row_array();
                $cardFlag = $this->input->post('card_flag');
                
                if($cardFlag==1){
                    $data = array(
                        'business_card_front_image' => NULL,
                        'business_card_front_verification' => 0,
                        'is_read' =>0,
                        'is_card_status' =>0
                    );
                    $front_image_Name = $card_image['business_card_front_image'];
                    @unlink('assets/uploads/company/business_card/' . $front_image_Name);    
                }
                if($cardFlag==2){
                    $data = array(
                        'business_card_back_image' =>NULL,
                        'business_card_back_verification' => 0,
                        'is_read' =>0,
                        'is_card_status' =>0
                    );
                    $back_image_Name = $card_image['business_card_back_image'];
                    @unlink('assets/uploads/company/business_card/' . $back_image_Name);
                }    
                $this->db->where('business_card_id', $this->input->post('id'));
                return $foo = $this->db->update($table, $data);
            }

            //======= Delete Press Section ==================
            elseif ($this->input->post('operation_on') == "press_section") {
                $trust_detail = $this->db->query('SELECT press_image FROM tbl_press_section WHERE press_id = "' . $this->input->post('id') . '" ')->row_array();
                $data = array(
                    'press_image' => null,
                    'is_deleted' => 1
                );

                $fileName = $trust_detail['press_image'];
                @unlink('assets/uploads/press_img/' . $fileName);

                $this->db->where('press_id', $this->input->post('id'));
                return $foo = $this->db->update($table, $data);
            }

            //======= Delete Tender Section ==================
            elseif ($this->input->post('operation_on') == "tender_request") {
                $data = array(
                    'is_deleted' => 1
                );
                $this->db->where('tender_request_id', $this->input->post('id'));
                return $foo = $this->db->update($table, $data);
            }

            //======= Delete Publish Tender Section ==================
            elseif ($this->input->post('operation_on') == "tender") {
                $data = array(
                    'tender_is_deleted' => 1
                );
                $this->db->where('tender_id', $this->input->post('id'));
                return $foo = $this->db->update($table, $data);
            }

            //======= Delete Other Content Section ==================
            elseif ($this->input->post('operation_on') == "other_content") {
                return $this->db->query('Delete FROM ' . $table . ' WHERE content_id = "' . $this->input->post('id') . '" ');
            }
            elseif ($this->input->post('operation_on') == "user") {
                $data = array(
                    'is_deleted' => 1
                );
                //	$this->db->where('success_story_id', $this->input->post('id'));
                $this->db->where('user_id', $this->input->post('id'));
                return $foo = $this->db->update($table, $data);
            }
            elseif ($this->input->post('operation_on') == "city") {
                $this->db->where('user_id', $this->input->post('id'));
                return $this->db->query('Delete FROM ' . $table . ' WHERE city_id = "' . $this->input->post('id') . '" ');
            }elseif($this->input->post('operation_on') == "banner"){
                
                $this->db->select('bnrImgPath');
                $this->db->where('banners_id',$this->input->post('id'));
                $this->db->from('tbl_banners');
                $query = $this->db->get();
                if($query->num_rows() > 0){
                    $result = $query->row_array();
                    unlink('assets/uploads/banners/'.$result['bnrImgPath']);
                }
                $this->db->where('banners_id', $this->input->post('id'));
                return $this->db->query('Delete FROM tbl_banners WHERE banners_id = "' . $this->input->post('id') . '" ');
            }elseif($this->input->post('operation_on') =="industry"){
                $this->db->where('industry_id', $this->input->post('id'));
                return $this->db->query('Delete FROM tbl_industry_master WHERE industry_id = "' . $this->input->post('id') . '" ');
            }
            else {
                return $this->db->query('Delete FROM ' . $table . ' WHERE ' . $feild_prefix . '_id = "' . $this->input->post('id') . '" ');
            }
        }
        else {
            return false;
        }
    }

    //----------Set Status--------------------------
    public function setstatus() {

        $table = "tbl_" . $this->input->post('operation_on');

        $feild_prefix = $this->input->post('operation_on');
        if ($feild_prefix == 'user') {
            $status = $this->input->post('status');
            if ($status == 1) {
                $status = 1;
            }
            else {
                $status = 0;
            }
            $data = array(
                'is_status' => $status
            );
            $this->db->where('user_id', $this->input->post('id'));
            $foo = $this->db->update($table, $data);
        }
        elseif ($feild_prefix == 'success_story') {
            $status = $this->input->post('status');
            //print_r($status);die;
            if ($status == 1) {
                $status = 1;
            }
            else {
                $status = 0;
            }
            $data = array(
                'status' => $status
            );
            $this->db->where('success_story_id', $this->input->post('id'));
            $foo = $this->db->update($table, $data);
        }
        elseif ($feild_prefix == 'press_section') {
            $status = $this->input->post('status');
            //print_r($status);die;
            if ($status == 1) {
                $status = 1;
            }
            else {
                $status = 0;
            }
            $data = array(
                'status' => $status
            );
            $this->db->where('press_id', $this->input->post('id'));
            $foo = $this->db->update($table, $data);
        }
        elseif ($feild_prefix == 'cms_management') {
            $status = $this->input->post('status');

            if ($status == 1) {
                $status = 1;
            }
            else {
                $status = 0;
            }
            $data = array(
                'page_status' => $status
            );
            $this->db->where('page_id', $this->input->post('id'));
            $foo = $this->db->update($table, $data);
        }
        elseif ($feild_prefix == 'business_card') {
            $status = $this->input->post('status');
            //print_r($status);die('fjsdjfhasdhfs');
            if ($status == 1) {
                $status = 1;
            }
            else {
                $status = 0;
            }
            $data = array(
                'is_card_status' => $status
            );
            $this->db->where('business_card_id', $this->input->post('id'));
            $foo = $this->db->update($table, $data);
        }
        elseif ($feild_prefix == 'mc_battles') {
            $status = $this->input->post('status');
            if ($status == 1) {
                $status = 'y';
            }
            else {
                $status = 'n';
            }
            $data = array(
                'mc_btl_Is_active' => $status
            );
            $this->db->where('mc_btl_id', $this->input->post('id'));
            $foo = $this->db->update($table, $data);
        }
        elseif ($feild_prefix == 'battle_registers_artist') {
            $status = $this->input->post('status');
            if ($status == 0) {
                $status = 'y';
            }
            else {
                $status = 'n';
            }
            $data = array(
                'btl_register_artist_is_eliminate' => $status
            );
            $this->db->where('btl_register_id', $this->input->post('id'));
            $foo = $this->db->update($table, $data);
        }
        elseif ($feild_prefix == 'enquiries') {
            $data = array(
                $feild_prefix . '_status' => $this->input->post('status')
            );
            $this->db->where($feild_prefix . '_id', $this->input->post('id'));
            $foo = $this->db->update($table, $data);

            /*Update reply id status closed*/
                $data = array($feild_prefix . '_status' => $this->input->post('status'));
                $this->db->where(array('reply_enquiry_id'=>$this->input->post('id')));
                $foo = $this->db->update($table, $data);
                
            /*End*/
            if($foo && $this->input->post('status')==0){
                $enq_condition = array(
                    $feild_prefix . '_id' => $this->input->post('id')
                );
                $enq_field = "enquiries_product_service,enquiries_description,enquiries_status,sender_user_id";
                $enquiries_detail = getData('tbl_enquiries', $enq_condition, $enq_field);
                //pr($enquiries_detail[0]->sender_user_id);
                /*Get user detail*/
                $usr_condition = array(
                    'user_id' => $enquiries_detail[0]->sender_user_id
                );
                $user_field = "user_name,user_primary_email,user_primary_mobile_number";
                $user_detail = getData('tbl_user', $usr_condition, $user_field);
                //pr($user_detail);
                if($enquiries_detail[0]->enquiries_status!=1){
                   $other = "<span style='color:#f00;font-weight:bold;'>Your enquiry has been closed</span>";
                }else{
                    $other = "";
                }
                send_enquery_reply($user_detail[0]->user_name,$user_detail[0]->user_primary_email,$subject,$enquiries_detail[0]->enquiries_product_service,$enquiries_detail[0]->enquiries_description,$other);
                send_sms($user_detail[0]->user_name,$user_detail[0]->user_primary_mobile_number,'Your enauiry has been closed');
            } 
            return $foo;
        }
        else {
            //pr($feild_prefix);
            $data = array(
                $feild_prefix . '_status' => $this->input->post('status')
            );
            $this->db->where($feild_prefix . '_id', $this->input->post('id'));
            $foo = $this->db->update($table, $data);

            
            //echo $this->db->last_query();
            return $foo;
        }
    }
    public function get_city_detail($stateid) {
        if ($stateid) {
            return $this->db->query('SELECT * FROM tbl_city WHERE state_id = "' . $cityid . '" ')->result_array();
        }
        else {
            return false;
        }
    }
    public function get_state_detail($stateid) {
        if ($stateid) {
            return $this->db->query('SELECT * FROM tbl_state WHERE state_id = "' . $stateid . '" ')->result_array();
        }
        else {          
            return false;
        }
    }
    /*End*/

    public function view_country() {
        if ($this->input->post('id')) {
            return $this->db->query('SELECT * FROM tbl_country
			WHERE country_id = "' . $this->input->post('id') . '" ')->result_array();
        }
        else {
            return false;
        }
    }

    public function view_edit_state() {
        if ($this->input->post('id')) {
            return $this->db->query('SELECT * FROM tbl_state
			WHERE state_id = "' . $this->input->post('id') . '" ')->result_array();
        }
        else {
            return false;
        }
    }

    public function view_city_detail() {
        if ($this->input->post('id')) {
            return $this->db->query('SELECT * FROM tbl_city
			WHERE city_id = "' . $this->input->post('id') . '" ')->result_array();
        }
        else {
            return false;
        }
    }

    //===============Old function======================
    public function viewUser_old() {
        if ($this->input->post('id')) {
            return $this->db->query('SELECT * FROM mh_user
					    LEFT JOIN mh_country ON mh_country.country_id = mh_user.user_country
					    LEFT JOIN mh_state ON mh_state.state_id = mh_user.user_state
					    LEFT JOIN mh_city ON mh_city.city_id = mh_user.user_city
					    WHERE mh_user.user_type !=2 and mh_user.user_id = "' . $this->input->post('id') . '" ')->result_array();
        }
        else {
            return false;
        }
    }

    //Admin User List Actions

    public function delUser() {

        if ($this->input->post('id')) {
            return $this->db->query('Delete FROM tbl_user WHERE user_id = "' . $this->input->post('id') . '" ');
        }
        else {
            return false;
        }
    }

    public function viewUser() {
        if ($this->input->post('id')) {
            return $this->db->query('SELECT * FROM mh_user
					    LEFT JOIN mh_country ON mh_country.country_id = mh_user.user_country
					    LEFT JOIN mh_state ON mh_state.state_id = mh_user.user_state
					    LEFT JOIN mh_city ON mh_city.city_id = mh_user.user_city
					    LEFT JOIN mh_user_subscription as mh_usr_sub ON mh_usr_sub.user_id = mh_user.user_id
					    LEFT JOIN mh_vote_subscription as mh_plan ON mh_plan.vote_id = mh_usr_sub.vote_id
					    LEFT JOIN mh_payments as usr_payment ON usr_payment.id = mh_usr_sub.payment_id
					    WHERE mh_user.user_type !=2 and mh_user.user_id = "' . $this->input->post('id') . '" ')->result_array();
        }
        else {
            return false;
        }
    }

    public function view_video() {
        //echo $this->input->post('id');
        if ($this->input->post('id')) {
            return $this->db->query('SELECT * FROM mh_videos WHERE videos_id = "' . $this->input->post('id') . '" ')->result_array();
        }
        else {
            return false;
        }
    }

    public function update_vedio() {
        if ($_POST) {
            $data = array(
                'videos_name' => $this->input->post('videos_name'),
                'videos_path' => $this->input->post('video_path'),
                'videos_status' => $this->input->post('videos_status'),
            );
            $this->db->where('videos_id', $this->input->post('videos_id'));
            $foo = $this->db->update('mh_videos', $data);
            return $this->db->last_query();
        }
        else {
            return false;
        }
    }

   
    // Common Functions
    public function beat_path() {
        $beat_path = $this->db->query('SELECT beat_path FROM mh_beat WHERE beat_id = "' . $this->input->post('id') . '" ')->result_array();
        return '<div id="myElement"></div><script>jwplayer("myElement").setup({file:"' . base_url() . $beat_path[0]["beat_path"] . '",width:420,height:26});</script>';
    }
    /* Get state list co */
    public function ajax_state_city($loadType, $loadId) {
        if ($loadType == "State" || $loadType == "state") {
            $this->db->order_by('state_name', 'asc');
            $result = $this->db->get_where('mh_state', array('state_country' => $loadId));
            //$sql="select id,state_name from state_test where
            //    country_id='".$loadId."' order by state_name asc";
        }
        else {
            $this->db->order_by('city_name', 'asc');
            $result = $this->db->get_where('mh_city', array('city_state' => $loadId));
            //$sql="select id,city_name from city_test where
            //    state_id='".$loadId."' order by city_name asc";
        }
        //$result = $this->db->get();
        //echo $this->db->last_query();
        return $result->result_array();
    }
    /**
     * @ Function Name   : delete_image
     * @ Function Purpose: Delete image form databae and Amazone S3
     * @ Function Returns: boolean
     */
    public function delete_image($img_id) {
        $s3 = $this->amazon_s3;
        /* Get Image path and owner id */
        $logged_user_id = $this->session->userdata['user_detail']['user_id'];
        $this->db->where(array('id' => $img_id));
        $result = $this->db->get('mh_image');
        $img_detail = $result->row_array();

        $dlt_file_name_array = explode('/', $img_detail["image_name"]);
        $dlt_file_name = end($dlt_file_name_array);
        $rvrc_array = array_reverse($dlt_file_name_array); // $mode = "foot';
        //pre($rvrc_array);
        $second_last_element = $rvrc_array[1];
        $delete_file_object = $rvrc_array[2] . '/' . $second_last_element . '/' . $dlt_file_name;
        //exit;
        $response = $s3->deleteObject('mighty_user_data', $delete_file_object);
        echo $response;
        if ($response) {
            /* Delete Thumbnail */
            $dlt_img_name_array = explode('/', $img_detail["thumb_path"]);
            $dlt_img_thum_name = end($dlt_img_name_array);
            $delete_file_thumb_object = $rvrc_array[2] . '/' . $second_last_element . '/thumb/' . $dlt_img_thum_name;
            $s3->deleteObject('mighty_user_data', $delete_file_thumb_object);
            return $this->db->delete('mh_image', array('id' => $img_id));
            //return $this->db->query("Delete FROM 'mh_image' WHERE id =".$img_id);
        }
        else {
            return false;
        }
    }
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
