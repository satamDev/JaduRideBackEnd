<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Driver_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_total_drivers(){        
        $this->db->get(table_driver);
        return $this->db->affected_rows();
    }

    public function get_total_active_drivers(){
        $this->db->where(field_status, const_active);
        $this->db->get(table_driver);
        return $this->db->affected_rows();
    }
    public function get_total_inactive_drivers(){
        $this->db->where(field_status, const_deactive);
        $this->db->get(table_driver);
        return $this->db->affected_rows();
    }

    public function get_total_driver(){        
        $this->db->get(table_driver);
        return $this->db->affected_rows();
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

    public function get_driver_details()
    {
        $select = table_users . '.' . field_uid . ',' . table_users . '.' . field_name . ',' . table_users . '.' . field_email . ',' . table_users . '.' . field_mobile . ',' . table_users . '.' . field_status;
        $join_user_driver = table_users . '.' . field_uid . '=' . table_driver . '.' . field_user_id;
        $this->db->select($select);
        $this->db->from(table_users);
        $this->db->join(table_driver, $join_user_driver);
        $this->db->where_not_in(table_users . '.' . field_status, const_deleted);
        $this->db->where(table_users . '.' . field_type_id, value_user_driver);
        $query = $this->db->get();
        return $query->result();
    }


    public function delete_driver_details($userid)
    {
        $uid_exist = $this->userid_exists($userid, field_uid, table_users);
        if ($uid_exist) {
            $this->db->set([field_status=> const_deleted, field_modified_at=>date(field_date)]);
            $this->db->where(field_uid, $userid);
            $this->db->update(table_users);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }

    
    public function deactive_driver_status($userid)
    {
        $uid_exist = $this->userid_exists($userid, field_uid, table_users);
        if ($uid_exist) {
            $this->db->set([field_status=> const_deactive, field_modified_at=>date(field_date)]);
            $this->db->where(field_uid, $userid);
            $this->db->update(table_users);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }

    public function active_driver_status($userid)
    {
        $uid_exist = $this->userid_exists($userid, field_uid, table_users);
        if ($uid_exist) {
            $this->db->set([field_status=> const_active, field_modified_at=>date(field_date)]);
            $this->db->where(field_uid, $userid);
            $this->db->update(table_users);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }

    public function update_driver_details($userid, $name, $email, $mobile)
    {
        $uid_exist = $this->userid_exists($userid, field_user_id, table_driver);
        if ($uid_exist) {
            $data = [
                field_name => $name,
                field_email => $email,
                field_mobile => $mobile,
                field_modified_at=>date(field_date)
            ];
            $this->db->where(field_uid, $userid);
            $this->db->update(table_users, $data);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }

    public function add_driver_details($user_id, $driver_id, $name, $email, $mobile, $user_type_id)
    {
        $uid_exist = $this->userid_exists($user_id, field_uid, table_driver);
        if (!$uid_exist) {
            $data = [
                field_uid => $user_id,
                field_name => $name,
                field_email => $email,
                field_mobile => $mobile,
                field_type_id => $user_type_id
            ];

            $this->db->insert(table_users, $data);

            if ($this->db->affected_rows() > 0) {
                $driver_data = [
                    field_uid => $driver_id,
                    field_user_id => $user_id,
                ];

                $this->db->insert(table_driver, $driver_data);
                return ($this->db->affected_rows() == 1 ? true : false);
            } else
                return false;
        } else
            return false;
    }
}
