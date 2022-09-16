<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sarathi_details_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set(field_location);
    }

    public function userid_exists($userid, $field_name, $table_name)
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

    public function get_all_sarathi_details($user_id)
    {
        $this->db->select('users.uid, users.name, sarathi.uid as sarathi_id');
        $this->db->from('users');
        $this->db->join('sarathi', 'users.uid=sarathi.user_id');
        $this->db->where('sarathi.user_id',$user_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_driver_details($sarathi_id)
    {
        $this->db->select('users.name, users.email, users.mobile ,users.status');
        $this->db->from('users');
        $this->db->join('driver', 'users.uid=driver.user_id');
        $this->db->where('driver.sarathi_id',$sarathi_id);
        $this->db->where_not_in('users.status','deleted');
        $this->db->where_not_in('users.status','pending');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_pending_driver_number($sarathi_id){
        $this->db->from(table_users);
        $this->db->join(table_driver,'driver.user_id=users.uid');
        $this->db->where([
            table_users.'.'.field_status=>const_pending, 
            table_users.'.'.field_type_id=>value_user_driver,
            table_driver.'.sarathi_id'=>$sarathi_id
        ]);
        $query=$this->db->get();
        return $query->num_rows();
    }

    public function get_sarathi_id_by_user_id($user_id){
        $this->db->select('uid');
        $this->db->where('user_id',$user_id);
        $query=$this->db->get('sarathi');
        $query=$query->result_array();
        return (!empty($query))? $query[0]['uid']:null;
    }
    
    public function get_pending_drivers($sarathi_id){
        $this->db->select('users.name, users.profile_image, users.uid, users.email, users.mobile');
        $this->db->from(table_users);
        $this->db->join(table_driver,'driver.user_id=users.uid');
        $this->db->where([
            table_users.'.'.field_status=>const_pending, 
            table_users.'.'.field_type_id=>value_user_driver,
            table_driver.'.sarathi_id'=>$sarathi_id
        ]);
        $query=$this->db->get();
        $query=$query->result();
        return(!empty($query))?$query:[];
        
    }

    public function get_pending_driver_details($user_id){
        $this->db->select('documents.assets, documents.name, documents.verified');
        $this->db->from('users');
        $this->db->join('documents','users.gid=documents.gid');
        $this->db->where('users.uid',$user_id);
        $query=$this->db->get();
        $query=$query->result();

        foreach($query as $q){
            if($q->name=="back_with_no_plate"){
                $q->name="backside_with_number_plate";
            }
        }

        return (!empty($query))? $query:[];
    }

    public function activate_pending_driver($user_id){
        $this->db->set(field_status, const_active);
        $this->db->where(field_uid, $user_id);
        return $this->db->update(table_users);
    }

    public function get_gid_by_user_id($user_id){
        $this->db->select('gid');
        $this->db->where('uid',$user_id);
        $query=$this->db->get(table_users);
        $query=$query->result_array();
        return (!empty($query))?$query[0]['gid']:null;
        
    }

    public function approved_driver_documents($gid, $document_name){

        $this->db->set([field_verified => const_submit, field_status => const_active]);
        $this->db->where([field_group_id=>$gid, field_name=>$document_name]);
        $this->db->update(table_documents);
        return ($this->db->affected_rows()==1)? true:false;
    }

    public function deny_driver_documents($gid, $document_name){

        $this->db->set([field_verified=> const_rejected, field_status=>const_deactive]);
        $this->db->where([field_group_id=>$gid, field_name=>$document_name]);
        $this->db->update(table_documents);
        return ($this->db->affected_rows()==1)? true:false;
    }




   
}
