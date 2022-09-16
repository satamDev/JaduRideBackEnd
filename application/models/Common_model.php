<?php
class Common_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

    private function get_user_type_id($user_type){
        $this->db->select(field_id);
        $this->db->where(field_name, $user_type);
        $query = $this->db->get(table_user_type);
        $query = $query->result_array();
        return $query[0][field_id];
    }

	// public function get_country_code(){
	// 	$query = $this->db->get(table_country);
	// 	return $query->result_array();
	// }

    // public function get_country_list(){
    //     $this->db->select(field_id .",". field_name);
    //     $this->db->where(field_type, STATIC_PLACE_COUNTRY);
    //     $this->db->where(field_status, STATIC_STATUS_ACTIVE);
    //     $query = $this->db->get(table_place);
        
    //     return $query->result_array();
    // }

    // public function get_state_list($country_id){
    //     $this->db->select(field_id .",". field_name);
    //     $this->db->where(field_type, STATIC_PLACE_STATE);
    //     $this->db->where(field_status, STATIC_STATUS_ACTIVE);
    //     $this->db->where(field_parent, $country_id);
    //     $query = $this->db->get(table_place);
        
    //     return $query->result_array();
    // }

    // public function get_district_list($state_id){
    //     $this->db->select(field_id .",". field_name);
    //     $this->db->where(field_type, STATIC_PLACE_DISTRICT);
    //     $this->db->where(field_status, STATIC_STATUS_ACTIVE);
    //     $this->db->where(field_parent, $state_id);
    //     $query = $this->db->get(table_place);

    //     return $query->result_array();
    // }

    // public function get_city_list($district_id){
    //     $this->db->select(field_id .",". field_name);
    //     $this->db->where(field_type, STATIC_PLACE_CITY);
    //     $this->db->where(field_status, STATIC_STATUS_ACTIVE);
    //     $this->db->where(field_parent, $district_id);
    //     $query = $this->db->get(table_place);
        
    //     return $query->result_array();
    // }

	// public function do_upload($path, $send_img){
    //     $resp = function ($data) {
    //         $data_final = [
    //             key_status => $data[0],
    //             key_message => $data[1],
    //             key_isadd => $data[2],
    //         ];
    //         return $data_final;
    //     };
    //     $config[key_upload_path]   = './' . $path;
    //     $config[key_allowed_types] = type_allowed;
    //     // $config[key_encrypt_name] = TRUE;

    //     $this->load->library(library_upload, $config);
    //     $this->upload->initialize($config);

    //     return (!$this->upload->do_upload($send_img)) ? false : true;
    // }

    // public function get_all_packages($user_type){
    //     $user_type_id = $this->get_user_type_id($user_type);
    //     $this->db->select(field_id .",". field_name);
    //     $this->db->where(field_user_type_id, $user_type_id);
    //     $this->db->where(field_status, STATIC_STATUS_ACTIVE);
    //     $query = $this->db->get(table_packages);
    //     return $query->result_array();
    // }



    public function is_this_value_exist($field_value, $field_name, $table){		

		// $this->db->select('user_type.name');
        // $this->db->from($table);
		// $this->db->join('user_type', $table.'.type_id = user_type.uid');
        // $this->db->where('users.'.$field_name, $field_value);

		$this->db->select(table_user_type.'.'.field_name);
        $this->db->from($table);
		$this->db->join(table_user_type, $table.'.'.field_type_id.' = '.table_user_type.'.'.field_uid);
        $this->db->where(table_users.'.'.$field_name, $field_value);
        $query = $this->db->get();
		$query=$query->result();

		return (!empty($query))? $query[0]: [];
	}

    
	public function get_user_type_id_by_user_type_name($user_type_name){
		$this->db->select(field_uid);
		$this->db->where(field_name,$user_type_name);
		$query=$this->db->get(table_user_type);
		$query=$query->result_array();
		return (!empty($query))? $query[0][field_uid]: null;
		
	}

}
?>