<?php
class Admin_employeerole_master_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    public function getunitlevel() {
        $query = $this->db->get(UNIT_LEVEL);
        return $query->result();
    }
    public function get_employee_list() {
        $unit_levle = UNIT_LEVEL;
        $emp_role = EMPLOYEEE_ROLE ;
        $this->db->select("$unit_levle.unit_name,$emp_role.role_id,$emp_role.emprole_name_hi,$emp_role.emprole_name_en,$emp_role.emprole_create_date");
        $this->db->join(UNIT_LEVEL,"$unit_levle.unit_id=$emp_role.unit_id",'LEFT');
        $this->db->from(EMPLOYEEE_ROLE);
        $query = $this->db->get();
        $rows = $query->result();
        //echo $this->db->last_query();
        return $rows;
    }
}
