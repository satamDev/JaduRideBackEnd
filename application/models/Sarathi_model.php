<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sarathi_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set(field_location);
    }

    public function get_total_sarathi(){
        $this->db->get(table_sarathi);
        return $this->db->affected_rows();
    }

    public function getDriversCount($sarathi_id){
        $this->db->where(field_sarathi_id, $sarathi_id);
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

    public function get_sarathi_details()
    {
        // $this->db->select('users.uid,name,email,mobile,users.status');
        // $this->db->from('users');
        // $this->db->join('sarathi', 'users.uid=sarathi.user_id');
        // $this->db->where_not_in('users.status','deleted');
        // $this->db->where('users.type_id','user_sarathi');

        $this->db->select(table_users.'.'.field_uid.','. table_users.'.'.field_name.','. table_users.'.'.field_email.','.table_users.'.'.field_mobile.','.table_users.'.'.field_status);
        $this->db->from(table_users);
        $this->db->join(table_sarathi, table_users.'.'.field_uid.'='.table_sarathi.'.'.field_user_id);
        $this->db->where_not_in(table_users.'.'.field_status,const_deleted);
        $this->db->where(table_users.'.'.field_type_id,value_user_sarathi);
        $query = $this->db->get();
        return $query->result();
    }

    public function delete_sarathi_details($userid)
    {
        $uid_exist = $this->userid_exists($userid, field_uid, table_users);
        if ($uid_exist) {
            $this->db->set([field_status => const_deleted, field_modified_at=>date(field_date)]);
            $this->db->where(field_uid, $userid);
            $this->db->update(table_users);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }

    public function deactive_sarathi_status($userid)
    {
        $uid_exist = $this->userid_exists($userid, field_uid, table_users);
        if ($uid_exist) {
            $this->db->set([field_status => const_deactive, field_modified_at=>date(field_date)]);
            $this->db->where(field_uid, $userid);
            $this->db->update(table_users);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }


    public function active_sarathi_status($userid)
    {
        $uid_exist = $this->userid_exists($userid, field_uid, table_users);
        if ($uid_exist) {
            $this->db->set([field_status => const_active, field_modified_at=>date(field_date)]);
            $this->db->where(field_uid, $userid);
            $this->db->update(table_users);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }


    public function update_sarathi_details($user_id, $name, $mobile, $email)
    {
        $uid_exist = $this->userid_exists($user_id, field_uid, table_users);
        if ($uid_exist) {
            $data = [
                field_name => $name,
                field_mobile => $mobile,
                field_email => $email,
                field_modified_at=>date(field_date)
            ];
            $this->db->where(field_uid, $user_id);
            $this->db->update(table_users, $data);
            $this->db->affected_rows() == 1 ? true : false;
        } else
            return false;
    }

    public function add_sarathi_details($user_id, $sarathi_id, $user_type_id, $name, $email, $mobile)
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
                $sarathi_data = [
                    field_uid => $sarathi_id,
                    field_user_id => $user_id,
                ];

                $this->db->insert(table_sarathi, $sarathi_data);
                return ($this->db->affected_rows() == 1 ? true : false);
            } else
                return false;
        } else
            return "user already exist";
    }

    public function getSarahiData(){
        $this->db->select('u.name, u.created_at as joined, s.uid as id, s.user_id as userId, s.refferal_code, s.total_km_purchased');
        $this->db->from(table_sarathi . ' as s');
        $this->db->join(table_users . ' as u', 's.user_id = u.uid', 'left');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
            $query[$key]['joined'] = date("d/m/Y",strtotime($value['joined']));
            $query[$key]['totalDrivers'] = $this->getDriversCount($value['id']);

            $query[$key]['total_km_purchased'] = ( empty($query[$key]['total_km_purchased']) ) ? " 0 " : $query[$key]['total_km_purchased'] ;
            $query[$key]['total_km_purchased'] .= " KM";

            $query[$key]['refferal_code'] = ( empty($query[$key]['refferal_code']) ) ? " - " : $query[$key]['refferal_code'];
        }
        return $query;
    }
}
