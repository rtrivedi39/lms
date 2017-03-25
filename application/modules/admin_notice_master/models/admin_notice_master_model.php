<?php

class Admin_notice_master_model extends CI_Model {

 	function __construct() {
        parent::__construct();
    }
    public function fetchnoticebyid($noticeid='')
    {
        $tbl_notice = NOTICE_BOARD;
        $tbl_notice_type = NOTICE_BOARD_TYPE;
        $tbl_section = SECTIONS;
        $this->db->select(NOTICE_BOARD.'.notice_id,notice_subject,notice_description,notice_created_date,notice_from_date,notice_to_date,notice_title,section_name_en,notice_attachment,notice_type_id,notice_section_id,notice_remark,notice_is_active');
        $this->db->from($tbl_notice);
        $this->db->join($tbl_notice_type, "$tbl_notice.notice_type_id = $tbl_notice_type.notice_id",'left');
        $this->db->join($tbl_section, "$tbl_notice.notice_section_id = $tbl_section.section_id",'left');
        $trash_status = '0';
        if($noticeid){
        $this->db->where("$tbl_notice.notice_id", $noticeid);
        }
        $this->db->where("$tbl_notice.notice_trash", $trash_status);
		$this->db->order_by('notice_id','DESC');
        $query = $this->db->get();
		
        if($query->num_rows() != 0)
        {
            // print_r($query->result());die;
            return $query->result_array();
        }
        else{
            return FALSE;
        }


        // public function shownotice()
        // {
        //     $tbl_notice = NOTICE_BOARD;
        //      $tbl_notice_type = NOTICE_BOARD_TYPE;
        //     $tbl_section = SECTIONS;
        //      $this->db->select(NOTICE_BOARD.'.notice_id,notice_subject,notice_description,notice_created_date,notice_from_date,notice_to_date,notice_title,section_name_en');
        //      $this->db->from($tbl_notice);
        //     $this->db->join($tbl_notice_type, "$tbl_notice.notice_type_id = $tbl_notice_type.notice_id",'left');
        //     $this->db->join($tbl_section, "$tbl_notice.notice_section_id = $tbl_section.section_id",'left');
        //     $query = $this->db->get();
        //      return $query->result_array();

        // }


    }
	
}

