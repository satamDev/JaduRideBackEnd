<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customers_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set(field_location);
    }

    public function get_total_customers(){
        $this->db->get(table_customer);
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

    public function get_customers_details()
    {
        // $this->db->select('users.uid, name, email, mobile, users.status');
        // $this->db->from('users');
        // $this->db->join('customer', 'users.uid=customer.user_id');
        // $this->db->where_not_in('users.status','deleted');
        // $this->db->where('users.type_id','user_customer');

        $this->db->select(table_users.'.'.field_uid.','. table_users.'.'.field_name.','. table_users.'.'.field_email.','.table_users.'.'.field_mobile.','.table_users.'.'.field_status);
        $this->db->from(table_users);
        $this->db->join(table_customer, table_users.'.'.field_uid.'='.table_customer.'.'.field_user_id);
        $this->db->where_not_in(table_users.'.'.field_status,const_deleted);
        $this->db->where(table_users.'.'.field_type_id,value_user_customer);

        $query = $this->db->get();
        print_r($query);
        return $query->result();
    }

    // check uid from customer table

    public function delete_customers_details($uid)
    {
        $uid_exist=$this->userid_exists($uid, field_uid, table_users);
        if($uid_exist){
            $this->db->set([field_status=> const_deleted, field_modified_at=>date(field_date)]);
            $this->db->where(field_uid, $uid);
            $this->db->update(table_users);
            $this->db->affected_rows() == 1 ? true : false;
        }
        else
            return false;
    }

    public function active_customers_status($uid)
    {
        $uid_exist=$this->userid_exists($uid, field_uid, table_users);
        if($uid_exist){
            $this->db->set([field_status=> const_active, field_modified_at=>date(field_date)]);
            $this->db->where(field_uid, $uid);
            $this->db->update(table_users);
            $this->db->affected_rows() == 1 ? true : false;
        }
        else
            return false;
    }

    public function deactive_customers_status($uid)
    {
        $uid_exist=$this->userid_exists($uid, field_uid, table_users);
        if($uid_exist){
            $this->db->set([field_status=> const_deactive, field_modified_at=>date(field_date)]);
            $this->db->where(field_uid, $uid);
            $this->db->update(table_users);
            $this->db->affected_rows() == 1 ? true : false;
        }
        else
            return false;
        
    }

    public function update_customers_details($uid, $name, $email, $mobile)
    {
        $uid_exist=$this->userid_exists($uid, field_uid, table_users);
        if($uid_exist){
            $data = [
                field_name => $name,
                field_email => $email,
                field_mobile => $mobile,
                field_modified_at=>date(field_date)
            ];
            $this->db->where(field_uid, $uid);
            $this->db->update(table_users, $data);
            $this->db->affected_rows() == 1 ? true : false;
        }
        else
            return false;

    }

    public function add_customers_details($user_id, $customer_id, $name, $email, $mobile, $user_type_id)
    {
        $uid_exist = $this->userid_exists($user_id, field_uid, table_users);
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
                $customer_data = [
                    field_uid => $customer_id,
                    field_user_id => $user_id,
                ];

                $this->db->insert(table_customer, $customer_data);
                return ($this->db->affected_rows() == 1 ? true : false);
            } else
                return false;
        } else
            return "user already exist";
    }
}
