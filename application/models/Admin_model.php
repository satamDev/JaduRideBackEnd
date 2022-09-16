<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set(field_location);
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

    public function get_admin_details()
    {
        // $this->db->select('users.uid, users.name, email, mobile, users.status');
        // $this->db->from('users');
        // $this->db->join('admin', 'users.uid=admin.user_id');
        // $this->db->where('users.type_id', 'user_admin');
        // $this->db->where_not_in('users.status', 'deleted');

        $this->db->select(table_users.'.'.field_uid.','. table_users.'.'.field_name.','. table_users.'.'.field_email.','.table_users.'.'.field_mobile.','.table_users.'.'.field_status);
        $this->db->from(table_users);
        $this->db->join(table_admin, table_users.'.'.field_uid.'='.table_admin.'.'.field_user_id);
        $this->db->where_not_in(table_users.'.'.field_status,const_deleted);
        $this->db->where(table_users.'.'.field_type_id,value_user_admin);

        $query = $this->db->get();
        return $query->result();
    }

    public function delete_admin_details($userid)
    {
        $uid_exist = $this->userid_exists($userid, field_uid, table_users);
        if ($uid_exist) {
            $this->db->set([field_status=> const_deleted,field_modified_at=>date(field_date)]);
            $this->db->where(field_uid, $userid);
            $this->db->update(table_users);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }


    public function deactive_admin_status($userid)
    {
        $uid_exist = $this->userid_exists($userid, field_uid, table_users);
        if ($uid_exist) {
            $this->db->set([field_status=> const_deactive,field_modified_at=>date(field_date)]);
            $this->db->where(field_uid, $userid);
            $this->db->update(table_users);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }


    public function active_admin_status($userid)
    {
        $uid_exist = $this->userid_exists($userid, field_uid, table_users);
        if ($uid_exist) {

            $this->db->set([field_status=> const_active,field_modified_at=>date(field_date)]);
            $this->db->where(field_uid, $userid);
            $this->db->update(table_users);
            return ($this->db->affected_rows() == 1 ? true : false);
        } else
            return false;
    }


    public function update_admin_details($user_id, $name, $email, $mobile)
    {
        $uid_exist = $this->userid_exists($user_id, field_uid, table_users);
        if ($uid_exist) {

            $input_data = [
                field_name => $name,
                field_email => $email,
                field_mobile => $mobile,
                field_modified_at=>date(field_date)

            ];
            $this->db->where(field_uid, $user_id);
            $this->db->update(table_users, $input_data);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }

    public function add_admin_details($user_id, $user_type_id, $input_data, $admin_data)
    {
        $uid_exist = $this->userid_exists($user_id, field_uid, table_users);
        if ($uid_exist) {
            return false;
        } else {
            $this->db->set([field_uid => $user_id, field_type_id => $user_type_id]);
            $insert = $this->db->insert(table_users, $input_data);
            if ($insert) {
                $this->db->set(field_user_id, $user_id);
                $this->db->insert(table_admin, $admin_data);
            }
            return ($this->db->affected_rows() == 1 ? true : false);
        }
    }


    public function sarathi_splash_data(){
        $this->db->where('specific_for_app', 'sarathi');
        $query=$this->db->get('app_splash_data');
        $query=$query->result_array();
        return (!empty($query))? $query : null;
    }



}
