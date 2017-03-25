<?php

class Admin_unit_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('email');
    }

    public function logged_in()
    {
        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from(EMPLOYEES);
        $this->db->where('emp_login_id', $this->input->post('username'));
        $this->db->where('emp_password', md5($this->input->post('password')));
        $this->db->where('emp_status',1);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return $query->row_array();
        } else
        {
            return $query->row_array();
        }
    }
    //get the email template from database 
    public function get_email_template($condition = FALSE) {
        $this->db->select('*');
        $this->db->from('tbl_email_templates');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $data = $query->result_array();
        if ($query->num_rows) {
            return $data;
        }return FALSE;
    }
    

    /**
    * created by sulbha shrivastava
    * @ Function Name      : addUnit
    * @ Function Params    : $data {mixed}, $kill {boolean}
    * @ Function Purpose   : update unit value
    * @ Function Returns   : insert id
    */
    public function  addUnit($data)
    {
       $this->db->insert(UNIT_LEVEL, $data);
        return $this->db->insert_id();
    }

    /**
    * created by sulbha shrivastava
    * @ Function Name      : updateUnit
    * @ Function Params    : $data {mixed}, $kill {boolean}
    * @ Function Purpose   : update unit value
    * @ Function Returns   : insert id
    */
    public function  updateUnit($data,$unit_id)
    {
        $this->db->where('unit_id',$unit_id);
        return $this->db->update(UNIT_LEVEL, $data);

    }

    /**
    * created by sulbha shrivastava
    * @ Function Name      : getUnitData
    * @ Function Params    : $data {mixed}, $kill {boolean}
    * @ Function Purpose   : get single unit value
    * @ Function Returns   : single record
    */
    public function   getUnitData($id)
    {
       
        $query = $this->db->get_where(UNIT_LEVEL,
                                    array(
                                            'unit_id'=>$id
                                            )
                                    );
        return $query->row_array();
    }
    /**
    * created by sulbha shrivastava
    * @ Function Name      : getUnitData
    * @ Function Params    : $data {mixed}, $kill {boolean}
    * @ Function Purpose   : get single unit value
    * @ Function Returns   : single record
    */
    public function   delete_unit( $delete_id = '')
    {
       
        $this->db->where('unit_id' , $delete_id);
        return $this->db->delete(UNIT_LEVEL);
       
    }
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

