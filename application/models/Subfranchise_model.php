<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subfranchise_model extends CI_Model
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

    public function get_sub_franchise_details()
    {
        // $this->db->select('users.uid, users.name, email, mobile, users.status');
        // $this->db->from('users');
        // $this->db->join('subfranchise', 'users.uid=subfranchise.user_id');
        // $this->db->where('users.type_id', 'user_sub_franchise');
        // $this->db->where_not_in('users.status', 'deleted');

        $this->db->select(table_users.'.'.field_uid.','. table_users.'.'.field_name.','. table_users.'.'.field_email.','.table_users.'.'.field_mobile.','.table_users.'.'.field_status);
        $this->db->from(table_users);
        $this->db->join(table_subfranchise, table_users.'.'.field_uid.'='.table_subfranchise.'.'.field_user_id);
        $this->db->where_not_in(table_users.'.'.field_status,const_deleted);
        $this->db->where(table_users.'.'.field_type_id,value_user_sub_franchise);
        $query = $this->db->get();
        return $query->result();
    }

    public function delete_sub_franchise_details($uid)
    {
        $uid_exist = $this->userid_exists($uid, field_uid, table_users);
        if ($uid_exist) {
            $this->db->set([field_status=> const_deleted, field_modified_at=>date(field_date)]);
            $this->db->where(field_uid, $uid);
            $this->db->update(table_users);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }

    public function deactive_sub_franchise_status($uid)
    {
        $uid_exist = $this->userid_exists($uid, field_uid, table_users);
        if ($uid_exist) {
            $this->db->set([field_status=> const_deactive, field_modified_at=>date(field_date)]);
            $this->db->where(field_uid, $uid);
            $this->db->update(table_users);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }

    public function active_sub_franchise_status($uid)
    {
        $uid_exist = $this->userid_exists($uid, field_uid, table_users);
        if ($uid_exist) {
            $this->db->set([field_status=> const_active, field_modified_at=>date(field_date)]);
            $this->db->where(field_uid, $uid);
            $this->db->update(table_users);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }

    public function update_sub_franchise_details($uid, $name, $email, $mobile)
    {
        $uid_exist = $this->userid_exists($uid, field_uid, table_users);
        if ($uid_exist) {
            $data = [
                field_name => $name,
                field_email => $email,
                field_mobile => $mobile,
                field_modified_at=>date(field_date)
            ];
            $this->db->where(field_uid, $uid);
            $this->db->update(table_users, $data);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }

    public function add_sub_franchise_details($uid, $name, $email, $mobile, $user_type_id, $password)
    {
        $uid_exist = $this->userid_exists($uid, field_uid, table_users);
        if (!$uid_exist) {
            $data = [
                field_uid => $uid,
                field_name => $name,
                field_email => $email,
                field_mobile => $mobile,
                field_type_id=>$user_type_id
            ];

            $insert=$this->db->insert(table_users, $data);
            if($insert){
                $sub_franchise_data=[
                    field_user_id=>$uid,
                    field_password=>$password
                ];
                $this->db->insert(table_subfranchise,$sub_franchise_data);
                return ($this->db->affected_rows() == 1 ? true : false);
            }
            else{
                return false;
            }
            
        } else
            return false;
    }
}
