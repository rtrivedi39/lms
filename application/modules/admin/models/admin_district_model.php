<?php

class Admin_district_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();

    }

    public function   getdistrictData($id)
    {

        $query = $this->db->get_where(DISTRICT,
            array(
                'district_id'=>$id
            )
        );
        return $query->row_array();
    }

    public function adddistrict($data)
    {
        //pr($data);
        $this->db->insert(DISTRICT, $data);
        return $this->db->insert_id();

    }

    public function updatedistrict($data , $district_id)
    {
        $this->db->where('district_id' ,$district_id);
       return $this->db->update(DISTRICT,$data);
    }

    public function deletedistrict( $delete_id='')
    {
        $this->db->where('district_id' , $delete_id);
        return $this->db->delete(DISTRICT);
    }

}