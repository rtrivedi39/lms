<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Function Name      : get_section
 * @ Function Params    : $data {mixed}, $kill {boolean}
 * @ Function Purpose   : formatted display of value of varaible
 * @ Function Returns   : foramtted string
 */
function get_list($table_name, $table_data, $condition) {
    $CI = & get_instance();
    $CI->db->where($condition);
    //$check = $CI->db->update($table_name, $table_data);
    $CI->db->from($table_data);
    //$CI->db->order_by('id','DESC');
    $query = $this->db->get();
    $data = $query->result_array();
    return $data;
}


/*End*/
?>
