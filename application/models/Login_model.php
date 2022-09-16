<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    private function userid_exists($userid, $field_name, $table_name)
    {
        $this->db->select($field_name);
        $this->db->from($table_name);
        $this->db->where($field_name, $userid);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_user_type_id_by_user_type_name($user_type_name)
    {
        $this->db->select(field_uid);
        $this->db->where(field_name, $user_type_name);
        $query = $this->db->get(field_user_type);
        $query = $query->result();
        return $query[0];
    }

    public function get_user_details_on_condition($email, $password, $type_id, $table)
    {
   
        $this->db->select(table_users . '.' . field_uid . ',' . table_users . '.' . field_name . ',' . table_users . '.' . field_type_id . ',' . $table . '.' . field_password.','.field_profile_image);
        $this->db->from(table_users);
        $this->db->join(table_user_type, table_users . '.' . field_type_id . '=' . table_user_type . '.' . field_uid);
        $this->db->join($table, table_users . '.' . field_uid . '=' . $table . '.' . field_user_id);

        $this->db->where(table_users . '.' . field_email, $email);
        $this->db->where($table . '.' . field_password, $password);
        $this->db->where(table_users . '.' . field_type_id, $type_id);

        $query = $this->db->get();
        $query = $query->result();
        return (!empty($query)) ? $query[0] : null;
    }

    public function display_user_profile($user_id)
    {
        $this->db->where(field_uid, $user_id);
        $this->db->where_not_in(field_status, const_deleted);
        $query = $this->db->get(table_users);
        return $query->result();
    }

    public function update_admin_details($user_id, $name, $email, $mobile, $dob)
    {
        $uid_exist = $this->userid_exists($user_id, field_uid, table_users);
        if ($uid_exist) {

            $input_data = [
                field_name => $name,
                field_email => $email,
                field_mobile => $mobile,
                field_dob=>$dob
            ];
            $this->db->where(field_uid, $user_id);
            $this->db->update(table_users, $input_data);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }

    public function get_user_list(){

        $user_count=[];
        
        $this->db->where(field_type_id, value_user_admin);
        $query = $this->db->get(table_users);
        $user_count['admin']= $query->num_rows();

        $this->db->where(field_type_id, value_user_franchise);
        $query = $this->db->get(table_users);
        $user_count['franchise']= $query->num_rows();

        $this->db->where(field_type_id, value_user_sub_franchise);
        $query = $this->db->get(table_users);
        $user_count['sub_franchise']= $query->num_rows();

        return $user_count;

    }
    
    //////////////////// Sarathi Login //////////////////

    public function get_sarathi_details_on_condition($email, $mobile){

        $this->db->where(['email'=> $email, 'mobile'=> $mobile]);
        $query = $this->db->get('users');
        $query = $query->result();
        return (!empty($query)) ? $query[0] : null;
    }
    
}
