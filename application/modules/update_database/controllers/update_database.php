<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Update_database extends MX_Controller {

    function __construct() {
        //$this->load->module('template');
    }

    public function index() {

       //$this->leave_movement_update();
       //$this->update_employees_leave();
       //$this->update_employees_leave_balance();
       //$this->update_employees_details();
       //$this->update_employees_dob();
		
      /* $sql = "ALTER TABLE `ft_emp_leave_movement` ADD `emp_leave_HQ_start_date` DATE NULL AFTER `emp_leave_is_HQ`, ADD `emp_leave_HQ_end_date` DATE NULL AFTER `emp_leave_HQ_start_date`";
        $res = $this->db->query($sql);
        if ($res) {
            echo "ft_emp_leave_movement table column updated successfully";
            echo "<br>";
        }
        
        //UPDATE `ft_emp_leave_movement` SET `emp_leave_approval_emp_id` ='3' WHERE `emp_leave_approval_type` != 0 
        //UPDATE `ft_emp_leave_movement` SET `emp_leave_forword_emp_id` ='26' WHERE `emp_leave_forword_type` != 0 
        //UPDATE `ft_emp_leave_movement` SET `on_behalf_leave` ='26' WHERE `emp_leave_type` !='el' */
    }
    
    function leave_movement_update(){
        // leave type update -> 
        // half leave type update -> 
        // half leave type update ->  
        // approval forword type update ->  
        // apprval  type update ->  
        // approval  type update -> 
        /*UPDATE `movement` SET `leave_type` = 'hpl' WHERE `leave_type` = 'ml';
        UPDATE `movement` SET `half_type` = 'SH' WHERE `leave_type` = 'sh';
        UPDATE `movement` SET `half_type` = 'FH' WHERE `leave_type` = 'fh';
        UPDATE `movement` SET `ao_approvel` = '1' WHERE `ao_approvel` = 'ha';
        UPDATE `movement` SET `ao_approvel` = '1' WHERE `ao_approvel` = 'yes' or `ao_approvel` = 'ha';       
        UPDATE `movement` SET `ao_approvel` = '2' WHERE `ao_approvel` = 'no'; 
        UPDATE `movement` SET `sl_approvel` = '1' WHERE `sl_approvel` = 'yes';
        UPDATE `movement` SET `sl_approvel` = '0' WHERE `sl_approvel` = 'not';*/

        $this->db->select('DISTINCT(uid)');     
        $query = $this->db->get(LEAVE_MOVEMENT);
        $results = $query->result();
        $this->db->last_query();
        foreach ($results as $result) {
            $this->db->select('emp_id, emp_unique_id'); 
            $this->db->where('emp_unique_id', $result->uid);
            $query1 = $this->db->get(EMPLOYEES);            
            $results1 = $query1->result();
            $this->db->last_query();
            foreach ($results1 as $result1) {                
                $data['emp_id'] = $result1->emp_id;
                $this->db->where('uid',$result->uid);
                $response = $this->db->update(LEAVE_MOVEMENT, $data);
                 if ($response) {
                    echo "employee table updated successfully..!<br>";
                }
                echo $this->db->last_query();
            }
        }
        //$query_mysql = "INSERT into ft_emp_leave_movement(emp_id, uid, emp_name, emp_leave_type,emp_leave_no_of_days, emp_leave_half_type, emp_leave_date, emp_leave_end_date, emp_leave_forword_type,emp_leave_forword_date, emp_leave_approval_type, emp_leave_approvel_date,emp_leave_create_date) SELECT userid,uid, emp_name, leave_type, no_of_days, half_type, leave_date, end_date, ao_approvel, ao_approvel_date, sl_approvel, sl_approvel_date, ao_approvel_date FROM movement";
        // el manage ="INSERT into ft_emp_leave_movement(emp_id, uid, emp_name, emp_leave_type,emp_leave_no_of_days, emp_leave_half_type, emp_leave_date, emp_leave_end_date, emp_leave_forword_type,emp_leave_forword_date, emp_leave_approval_type, emp_leave_approvel_date,emp_leave_create_date, emp_leave_address,emp_leave_reason) SELECT uid,uid_code,'','el',	period, '', start_date, end_date,'1',create_at,'0','',create_at,address,apply_for FROM request_el";
    }
    
    function update_employees_leave(){
        //INSERT into ft_employee_leave(`emp_id`,`uid`,`cl_leave`,`ol_leave`,`el_leave`,`hpl_leave`,`ot_leave`) SELECT 	ID, uid,cl_leave,ol_leave,el_leave,ml_leave,ot_leave FROM ft_users
        $this->db->select('DISTINCT(emp_id)');     
        $query = $this->db->get(EMPLOYEE_LEAVE);
        $results = $query->result();
        $this->db->last_query();
        foreach ($results as $result) {
            $this->db->select('emp_id, emp_unique_id'); 
            $this->db->where('emp_id', $result->emp_id);
            $query1 = $this->db->get(EMPLOYEES);            
            $results1 = $query1->result();
            $this->db->last_query();
            foreach ($results1 as $result1) {                
                $data['uid'] = $result1->emp_unique_id;
                $this->db->where('emp_id',$result->emp_id);
                $response = $this->db->update(EMPLOYEE_LEAVE, $data);
                 if ($response) {
                    echo "employee table updated successfully..!<br>";
                }
                echo $this->db->last_query();
            }
        }
        
    }
    function update_employees_details(){
         //UPDATE `ft_employee_details` f1 LEFT OUTER JOIN ft_emp_service_record f2 ON f1.uid = f2.Emp_id SET f1.`emp_detail_address` = f2.Cu_emp_address 
        $this->db->select('DISTINCT(emp_id)');     
        $query = $this->db->get(EMPLOYEE_DETAILS);
        $results = $query->result();
        $this->db->last_query();
         
        foreach ($results as $result) {
           
            $this->db->select('emp_id, emp_unique_id'); 
            $this->db->where('emp_id', $result->emp_id);
            $query1 = $this->db->get(EMPLOYEES);            
            $results1 = $query1->result();
            $this->db->last_query();
            foreach ($results1 as $result1) {                
                 $data['uid'] = $result1->emp_unique_id;
                $this->db->where('emp_id',$result->emp_id);
                $response = $this->db->update(EMPLOYEE_DETAILS, $data);
                 if ($response) {
                    echo "employee table updated successfully..!<br>";
                }
                echo $this->db->last_query();
            }
        }
        
    }
     function update_employees_dob(){
          
        $this->db->select('DISTINCT(uid)');     
        $query = $this->db->get(EMPLOYEE_DETAILS);
        $results = $query->result();
        $this->db->last_query();
        foreach ($results as $result) {
            $this->db->select('Emp_id,Date_of_birth'); 
            $this->db->where('Emp_id', $result->uid);
            $query1 = $this->db->get('emp_service_record');            
            $results1 = $query1->result();
            $this->db->last_query();
            foreach ($results1 as $result1) {                
                $data['emp_detail_dob'] = $result1->Date_of_birth;
                $this->db->where('uid',$result->uid);
                $response = $this->db->update(EMPLOYEE_DETAILS, $data);
                 if ($response) {
                    echo "employee table updated successfully..!<br>";
                }
                echo $this->db->last_query();
            }
        }
        
    }
    
    function update_employees_leave_balance(){        
        $this->db->select('*');        
        $query1 = $this->db->get('users');            
        $results1 = $query1->result();
        $this->db->last_query();
        foreach ($results1 as $result1) {                
            $data['cl_leave'] = $result1->cl_leave;
            $data['ol_leave'] = $result1->ol_leave;
            $data['el_leave'] = $result1->el_leave;
            $data['hpl_leave'] = $result1->ml_leave;
            $data['ol_leave'] = $result1->ol_leave;
            $data['ot_leave'] = $result1->ot_leave;
               
            $this->db->where('uid',$result1->uid);
            $response = $this->db->update(EMPLOYEE_LEAVE, $data);
             if ($response) {
                echo "employee table updated successfully..!<br>";
            }
            echo $this->db->last_query();
        }                
    }
    
    
    function employee_update() {
        $query = $this->db->get('employee');
        $results = $query->result();
        foreach ($results as $result) {
            $email = $result->emp_email;
            $emails = explode('@', $email);
            if (isset($emails[0])) {
                $this->db->where('emp_email', $result->emp_email);
                $data['emp_login_id'] = $emails[0];

                $response = $this->db->update('employee', $data);
                $this->db->last_query();
                if ($response) {
                    "employee table updated successfully..! ";
                    echo "<br>";
                }
            }

            //$sql = "ALTER TABLE `ft_employee` CHANGE `emp_login_id` `emp_login_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
            $sql = "CREATE TABLE IF NOT EXISTS `db_ftams`.`ft_alloted_employee_section` (
                    `alloted_section_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                    `section_id` INT UNSIGNED NULL,
                    `emp_id` INT NOT NULL,
                    `role_id` INT NOT NULL,
                    `created_datetime` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`alloted_section_id`),
                    UNIQUE INDEX `alloted_section_id_UNIQUE` (`alloted_section_id` ASC),
                    INDEX `mastsectid_idx` (`section_id` ASC),
                    INDEX `mastempid01_idx` (`emp_id` ASC),
                    INDEX `mast_role002_idx` (`role_id` ASC),
                    CONSTRAINT `mastsectid`
                      FOREIGN KEY (`section_id`)
                      REFERENCES `db_ftams`.`ft_sections_master` (`section_id`)
                      ON DELETE NO ACTION
                      ON UPDATE NO ACTION,
                    CONSTRAINT `mastempid01`
                      FOREIGN KEY (`emp_id`)
                      REFERENCES `db_ftams`.`ft_employee` (`emp_id`)
                      ON DELETE NO ACTION
                      ON UPDATE NO ACTION,
                    CONSTRAINT `mast_role002`
                      FOREIGN KEY (`role_id`)
                      REFERENCES `db_ftams`.`ft_emprole_master` (`role_id`)
                      ON DELETE NO ACTION
                      ON UPDATE NO ACTION)";
            $res = $this->db->query($sql);
            if ($res) {
                echo "employee table column updated successfully";
                echo "<br>";
            }
        }

        $sql = "ALTER TABLE `ft_emp_leave_movement` ADD `medical_files` VARCHAR(255) NULL ";
        $res = $this->db->query($sql);
        if ($res) {
            echo "ft_emp_leave_movement table column updated successfully";
            echo "<br>";
        }
        // ADD COLUMN IN LEAVED MOVEMENT
        // /ALTER TABLE `ft_emp_leave_movement`  ADD `type_of_headquoter` ENUM('GG','MG','','') NOT NULL  AFTER `medical_files`;
    }
	
	
	function leave_report(){
		$sql = "SELECT  emp.emp_id as emp_id,emp_unique_id as 'code', emp_full_name_hi as 'name',
		emprole_name_hi as 'post', section_name_hi as 'section', cl_leave as 'CL', ol_leave as 'OL' 
		FROM  `ft_employee` as emp
		 inner join `ft_sections_master` as sec on emp.emp_section_id = sec.section_id 
		 inner join `ft_emprole_master` as role on emp.role_id = role.role_id
		 inner join `ft_employee_leave_2015` as leaves  on emp.emp_id = leaves.emp_id
		WHERE emp.`emp_status` = '1' and `emp_is_retired` = '0' and emp.emp_id != '1'  and emp_is_parmanent = '1'
		ORDER BY cl_leave DESC, ol_leave DESC ";
		$output = '<table style="border:1px solid;">';
		$output .=	'<tr>';
		$output .=	'<th align="center">क्रमांक</th>';
		$output .=	'<th align="center">कोड</th>';
		$output .=	'<th>नाम</th>';
		$output .=	'<th>पद</th>';
		$output .=	'<th>शाखा</th>';
		$output .=	'<th align="center">शेष OL</th>';
		$output .=	'<th align="center">शेष CL</th>';
		$output .=	'</tr>';
		$qry = $this->db->query($sql);
		$res = $qry->result() ;
		$i = 1; foreach($res as $row){
			$output .=	'<tr>';
			$output .=	'<td align="center">'.$i.'</td>';
			$output .=	'<td align="center">'.$row->code.'</td>';
			$output .=	'<td>'.getemployeeName($row->emp_id, true).'</td>';
			$output .=	'<td>'.$row->post.'</td>';
			$output .=	'<td>'.$row->section.'</td>';
			$output .=	'<td align="center">'.$row->CL.'</td>';
			$output .=	'<td align="center">'.$row->OL.'</td>';
			$output .=	'</tr>';
		$i++;}
		$output .=	'</table>';
		echo $output;
	}
	

}
