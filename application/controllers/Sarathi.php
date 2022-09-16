<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sarathi extends CI_Controller
{
    private function load_header($header_data = [], $header_link_data = [])
    {
        $this->load->view(sarathi_page_header_link, $header_link_data);
        $this->load->view(sarathi_page_header, $header_data);
    }

    private function load_sidebar($sidebar_data = [])
    {
        $this->load->view(sarathi_page_sidebar, $sidebar_data);
    }

    private function load_footer($footer_data = [], $footer_link_data = [])
    {
        $this->load->view(sarathi_page_footer, $footer_data);
        $this->load->view(sarathi_page_footer_link, $footer_link_data);
    }

    private function is_user_logged_in()
    {
        $logged_in = (!empty($this->session->userdata('sarathi_login_status'))) ? true : false;
        // $logged_in = (!empty($this->session->userdata(field_name))) ? true : false;
        return $logged_in;
    }


    private function init_login_model()
    {
        $this->load->model(model_login);
    }

    private function init_uid_server_model()
    {
        $this->load->model(model_uid_server);
    }

    private function init_common_model()
    {
        $this->load->model(model_common);
    }

   
    private function init_franchise_model()
    {
        $this->load->model(model_franchise_model);
    }

    private function init_sub_franchise_model()
    {
        $this->load->model(model_sub_franchise_model);
    }

    private function init_sarathi_model()
    {
        $this->load->model('Sarathi/Sarathi_model');
    }

    private function init_sarathi_details_model()
    {
        $this->load->model(model_sarathi_details);
    }

    private function init_driver_model()
    {
        $this->load->model(model_driver);
    }

    private function init_customer_model()
    {
        $this->load->model(model_customers_model);
    }


    private function response($data, $status)
    {
        return $this->output->set_content_type("application/json")
            ->set_status_header($status)
            ->set_output(json_encode($data));
    }

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set(field_location);
    }

    public function index(){
        if ($this->is_user_logged_in()) {
            redirect(base_url('sarathi_driver'));
        } else {
            $this->load->view(sarathi_page_header_link);
            $this->load->view('sarathi/sarathi_login');
            $this->load->view(sarathi_page_footer_link);
        }
    }

    public function authenticate_sarathi(){

        $email = $this->input->post(param_email);
        $mobile =$this->input->post(param_mobile);

        $this->init_login_model();

        if (!empty($email) && !empty($mobile)) {

            $user_details = $this->Login_model->get_sarathi_details_on_condition($email, $mobile);

            if (!empty($user_details)) {

                $this->session->set_userdata('sarathi_login_status', 'sarathi_logged_in');

                $this->session->set_userdata('sarathi_name', $user_details->name);
                $this->session->set_userdata('sarathi_type_id', $user_details->type_id);
                $this->session->set_userdata('sarathi_user_id', $user_details->uid);
                $this->session->set_userdata('sarathi_profile_image', $user_details->profile_image);

                $this->response([key_success => true, key_message => "User authentication successfull", key_redirect_to => base_url('sarathi_driver')], 200);
            } else {
                $this->response([key_success => false, key_message => 'Invalid Login Details'], 200);
            }
        } else {
            $this->response([key_success => false, key_message => "Email or Password is not given!"], 400);
        }
    }

    public function logout(){
        			
        $this->session->unset_userdata('sarathi_name');
		$this->session->unset_userdata('sarathi_type_id');
        $this->session->unset_userdata('sarathi_user_id');
		$this->session->unset_userdata('sarathi_profile_image');
		$this->session->unset_userdata('sarathi_id');

		$this->session->unset_userdata('sarathi_login_status');

		redirect(base_url('sarathi_login'));
	}

    public function driver(){

        if ($this->is_user_logged_in()) {
            
            $this->load->view(sarathi_page_header_link);
            $this->load->view(sarathi_page_header);
			$this->load->view('sarathi/driver');
            $this->load->view(sarathi_page_footer_link);
            $this->load->view(sarathi_page_footer);
            $this->load->view(sarathi_page_sidebar);
			
		} else {
			redirect(base_url('sarathi_login'));
		}
    }

    public function get_driver_of_sarathi(){

        //$user_id= $this->session->userdata('user_id');      //------ sarathi user_id
        $user_id= $this->session->userdata('sarathi_user_id');
        $this->init_sarathi_model();
        $sarathi_id=$this->Sarathi_model->get_sarathi_id_by_user_id($user_id);

        $driver=$this->Sarathi_model->get_driver_of_paticular_sarathi($sarathi_id);
        if(!empty($driver)){
            $this->response(['succcess'=>true, 'message'=>'driver list','data'=>$driver],200);
        }
        else{
            $this->response(['succcess'=>true, 'message'=>'driver list', 'user-id'=> $user_id, 'sarathi-id'=> $sarathi_id],200);
        }
    }

    public function sarathi_profile(){
        if ($this->is_user_logged_in()) {
            
            $this->load->view(sarathi_page_header_link);
            $this->load->view(sarathi_page_header);
			$this->load->view('sarathi/sarathi_profile');
            $this->load->view(sarathi_page_footer_link);
            $this->load->view(sarathi_page_footer);
            $this->load->view(sarathi_page_sidebar);
			
		} else {
			redirect(base_url('sarathi_login'));
		}
    }


}
