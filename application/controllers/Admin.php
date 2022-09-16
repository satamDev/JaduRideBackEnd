<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	private function load_header($header_data = [], $header_link_data = [])
	{
		$this->load->view(page_header_link, $header_link_data);
		$this->load->view(page_header, $header_data);
	}

	private function load_sidebar($sidebar_data = [])
	{
		$this->load->view(page_sidebar, $sidebar_data);
	}

	private function load_footer($footer_data = [], $footer_link_data = [])
	{
		$this->load->view(page_footer, $footer_data);
		$this->load->view(page_footer_link, $footer_link_data);
	}

	private function is_user_logged_in()
	{
		$logged_in = (!empty($this->session->userdata(field_name))) ? true : false;
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

	private function init_admin_model()
	{
		$this->load->model(model_admin);
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
		$this->load->model(model_sarathi);
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

	public function index()
	{
		if ($this->is_user_logged_in()) {
			redirect(base_url(url_admin_page));
		} else {
			$this->load->view(page_header_link);
			$this->load->view(view_login);
			$this->load->view(page_footer_link);
		}
	}

	public function authenticate_user()
	{
		$email = $this->input->post(param_email);
		$password = md5($this->input->post(param_password));
		$user_type = $this->input->post(param_user_type);
		$user_type_name = '';

		$accepted_user_type = [
			"1" => value_administrator,
			"2" => value_admin
		];

		if (array_key_exists($user_type, $accepted_user_type)) {
			$user_type_name = $accepted_user_type[$user_type];

			$table = ($user_type_name == value_administrator) ? value_administrator : value_admin;

			$this->init_login_model();

			$type = $this->Login_model->get_user_type_id_by_user_type_name($user_type_name);
			$type_id = $type->uid;

			$this->session->set_userdata(field_user_type, $user_type_name);		// name => administrator || admin

			if (!empty($email) && !empty($password)) {

				$user_details = $this->Login_model->get_user_details_on_condition($email, $password, $type_id, $table);

				if (!empty($user_details->name)) {
         
					$this->session->set_userdata(field_name, $user_details->name);
					$this->session->set_userdata(field_type_id, $user_details->type_id);
					$this->session->set_userdata(field_user_id, $user_details->uid);
					$this->session->set_userdata(field_profile_image, $user_details->profile_image);


					if ($this->session->userdata(field_type_id) == "user_super_admin") {

						$this->response([key_success => true, key_message => "User authentication successfull", key_redirect_to => base_url('dashboard')], 200);
					}
					if ($this->session->userdata(field_type_id) == "user_admin") {

						$this->response([key_success => true, key_message => "User authentication successfull", key_redirect_to => base_url('franchise')], 200);
					}
				} else {
					$this->response([key_success => false, key_message => "Invaild Email or Password!"], 200);
				}
			} else {
				$this->response([key_success => false, key_message => "Email or Password is not given!"], 400);
			}
		} else {
			$this->response([key_success => false, key_message => "Select user type"], 400);
		}
	}

	public function profile()
	{
		if ($this->is_user_logged_in()) {

			$this->load_header();
			$this->load_sidebar();
			$this->load->view('profile');
			$this->load_footer();
		} else {
			redirect(base_url());
		}
	}

	public function get_user_profile()
	{
		$this->init_login_model();
		$user_id = $this->session->userdata(field_user_id);
		$profile = $this->Login_model->display_user_profile($user_id);

		echo json_encode($profile);
	}

	public function get_user_list()
	{
		$this->init_login_model();
		$user_count = $this->Login_model->get_user_list();
		echo json_encode($user_count);

	}

	public function update_user_profile()
	{
		$user_id = $this->input->post(param_id);

		$name = $this->input->post(param_name);
		$mobile = $this->input->post(param_mobile);
		$email = $this->input->post(param_email);
		$dob = $this->input->post(param_dob);

		$this->init_login_model();
		$update = $this->Login_model->update_admin_details($user_id, $name, $email, $mobile, $dob);
		echo json_encode($update);
	}


	public function logout()
	{
		$this->session->unset_userdata(field_name);
		$this->session->unset_userdata(field_type_id);
		$this->session->unset_userdata(field_user_type);
		$this->session->unset_userdata(field_user_id);
		$this->session->unset_userdata(field_profile_image);
		$this->session->unset_userdata('sarathi_id');
		redirect(base_url());
	}


	public function admin()
	{
		if ($this->is_user_logged_in()) {

			$this->load_header();
			$this->load_sidebar();
			$this->load->view(view_admin);
			$this->load_footer();
		} else {
			redirect(base_url());
		}
	}

	public function get_admin()
	{
		$this->init_admin_model();
		$data = $this->Admin_model->get_admin_details();
		echo json_encode($data);
	}

	public function add_admin()
	{
		$missing_key = [];
		$input_data = [];
		$admin_data = [];

		$this->init_uid_server_model();

		$user_id = $this->Uid_server_model->generate_uid(KEY_USER);
		$name = $this->input->post(param_name);
		$email = $this->input->post(param_email);
		$mobile = $this->input->post(param_mobile);
		$password = md5($this->input->post(param_mobile));

		if (!empty($name)) {
			$input_data[field_name] = $name;
		} else {
			$missing_key[] = field_name;
		}

		if (!empty($mobile)) {
			$input_data[field_mobile] = $mobile;
		} else {
			$missing_key[] = field_mobile;
		}

		if (!empty($email)) {
			$input_data[field_email] = $email;
		} else {
			$missing_key[] = field_email;
		}

		if (!empty($password)) {
			$admin_data[field_password] = $password;
		} else {
			$missing_key[] = field_password;
		}

		if (!empty($missing_key)) {
			$missing_string = implode(", ", $missing_key);
			$missing_string = rtrim($missing_string, ", ");
			$this->response([key_success => false, key_message => $missing_string . " not given!"], 200);
		} else {

			$this->init_common_model();

			$mobile_exist = $this->Common_model->is_this_value_exist($mobile, field_mobile, table_users);
			$email_exist = $this->Common_model->is_this_value_exist($email, field_email, table_users);

			if (!empty($mobile_exist)) {
				$this->response([key_success => false, key_message => "This Number already exist for " . $mobile_exist->name], 200);
				return;
			}
			if (!empty($email_exist)) {
				$this->response([key_success => false, key_message => "This Email already exist for " . $email_exist->name], 200);
				return;
			}

			$user_type_id = $this->Common_model->get_user_type_id_by_user_type_name(user_type_admin);


			$this->init_admin_model();
			$is_added = $this->Admin_model->add_admin_details($user_id, $user_type_id, $input_data, $admin_data);
			if ($is_added) {
				$this->response([key_success => true, key_message => "Add new admin successfully."], 200);
			} else {
				$this->response([key_success => false, key_message => "Failed to add  new admin"], 200);
			}
		}
	}

	public function update_admin()
	{

		$user_id = $this->input->post(param_id);

		$name = $this->input->post(param_name);
		$mobile = $this->input->post(param_mobile);
		$email = $this->input->post(param_email);
		// $password = md5($this->input->post(field_mobile));

		$this->init_admin_model();
		$update = $this->Admin_model->update_admin_details($user_id, $name, $email, $mobile);
		echo json_encode($update);
	}

	public function delete_admin()
	{
		$userid = $this->input->post(param_id);
		$this->init_admin_model();
		$delete = $this->Admin_model->delete_admin_details($userid);
		echo json_encode($delete);
	}

	public function deactive_admin()
	{
		$userid = $this->input->post(param_id);
		$this->init_admin_model();
		$status = $this->Admin_model->deactive_admin_status($userid);
		echo json_encode($status);
	}

	public function active_admin()
	{
		$userid = $this->input->post(param_id);
		$this->init_admin_model();
		$status = $this->Admin_model->active_admin_status($userid);
		echo json_encode($status);
	}

	/////////////////////////////////////////////////////////////////

	public function dashboard(){
		if ($this->is_user_logged_in()) {
			$this->load_header();
			$this->load_sidebar();
			$this->load->view('dashboard');
			$this->load_footer();
		} else {
			redirect(base_url());
		}
	}

	public function settings(){
		if ($this->is_user_logged_in()) {
			$this->load_header();
			$this->load_sidebar();
			$this->load->view('settings');
			$this->load_footer();

			$this->load->view('inc/custom_js/splashData_js');
		} else {
			redirect(base_url());
		}
	}

	//////////////////////// sarathi ////////////////////////////////

	public function sarathi()
	{
		if ($this->is_user_logged_in()) {
			$this->load_header();
			$this->load_sidebar();
			$this->load->view(view_sarathi);
			$this->load_footer();
		} else {
			redirect(base_url());
		}
	}

	public function get_sarathi()
	{
		$this->init_sarathi_model();
		$data = $this->Sarathi_model->get_sarathi_details();
		echo json_encode($data);
	}

	public function add_sarathi()
	{
		$this->init_uid_server_model();
		$user_id = $this->Uid_server_model->generate_uid(KEY_USER);
		$sarathi_id = $this->Uid_server_model->generate_uid(KEY_SARATHI);

		$name = $this->input->post(param_name);
		$email = $this->input->post(param_email);
		$mobile = $this->input->post(param_mobile);

		$this->init_common_model();
		$user_type_id = $this->Common_model->get_user_type_id_by_user_type_name(user_type_sarathi);

		$this->init_sarathi_model();
		$data = $this->Sarathi_model->add_sarathi_details($user_id, $sarathi_id, $user_type_id, $name, $email, $mobile);
		echo json_encode($data);
	}


	public function update_sarathi()
	{
		$user_id = $this->input->post(param_id);
		$name = $this->input->post(param_name);
		$mobile = $this->input->post(param_mobile);
		$email = $this->input->post(param_email);

		$this->init_sarathi_model();
		$update = $this->Sarathi_model->update_sarathi_details($user_id, $name, $mobile, $email);
		echo json_encode($update);
	}

	public function delete_sarathi()
	{
		$userid = $this->input->post(param_id);

		$this->init_sarathi_model();
		$delete = $this->Sarathi_model->delete_sarathi_details($userid);
		echo json_encode($delete);
	}

	public function deactive_sarathi()
	{
		$userid = $this->input->post(param_id);

		$this->init_sarathi_model();
		$status = $this->Sarathi_model->deactive_sarathi_status($userid);
		echo json_encode($status);
	}

	public function active_sarathi()
	{
		$userid = $this->input->post(param_id);

		$this->init_sarathi_model();
		$status = $this->Sarathi_model->active_sarathi_status($userid);
		echo json_encode($status);
	}

	////////////////////// driver start /////////////////////////////
	public function driver()
	{
		if ($this->is_user_logged_in()) {

			$this->load_header();
			$this->load_sidebar();
			$this->load->view(view_driver);
			$this->load_footer();
		} else {
			redirect(base_url());
		}
	}

	public function get_driver()
	{
		$this->init_driver_model();
		$data = $this->Driver_model->get_driver_details();
		echo json_encode($data);
	}

	public function delete_driver()
	{
		$userid = $this->input->post(param_id);
		$this->init_driver_model();
		$delete = $this->Driver_model->delete_driver_details($userid);
		echo json_encode($delete);
	}

	public function update_driver()
	{
		$userid = $this->input->post(param_id);
		$name = $this->input->post(param_name);
		$email = $this->input->post(param_email);
		$mobile = $this->input->post(param_mobile);

		$this->init_driver_model();
		$update = $this->Driver_model->update_driver_details($userid, $name, $email, $mobile);
		echo json_encode($update);
	}

	public function deactive_driver()
	{
		$userid = $this->input->post(param_id);
		$this->init_driver_model();
		$status = $this->Driver_model->deactive_driver_status($userid);
		echo json_encode($status);
	}

	public function active_driver()
	{
		$userid = $this->input->post(param_id);
		$this->init_driver_model();
		$status = $this->Driver_model->active_driver_status($userid);
		echo json_encode($status);
	}

	public function add_driver()
	{
		$this->init_uid_server_model();

		$user_id = $this->Uid_server_model->generate_uid(KEY_USER);
		$driver_id = $this->Uid_server_model->generate_uid(KEY_DRIVER);

		$name = $this->input->post(param_name);
		$email = $this->input->post(param_email);
		$mobile = $this->input->post(param_mobile);
		
		$this->init_common_model();
		$mobile_exist = $this->Common_model->is_this_value_exist($mobile, field_mobile, table_users);
		
		$email_exist = $this->Common_model->is_this_value_exist($email, field_email, table_users);

		if (!empty($mobile_exist)) {
			$this->response([key_success => false, key_message => "This Number already exist for " . $mobile_exist->name], 200);
			return;
		}
		if (!empty($email_exist)) {
			$this->response([key_success => false, key_message => "This Email already exist for " . $email_exist->name], 200);
			return;
		}


		$user_type_id = $this->Common_model->get_user_type_id_by_user_type_name(user_type_driver);

		$this->init_driver_model();
		$data = $this->Driver_model->add_driver_details($user_id, $driver_id, $name, $email, $mobile, $user_type_id);
		if ($data) {
			$this->response([key_success => true, key_message => "Data insert successfull"], 200);
		} else {
			$this->response([key_success => true, key_message => "Failed to insert data"], 200);
		}
	}

	////////////////// franchise start //////////////////////////////////////
	public function franchise()
	{
		if ($this->is_user_logged_in()) {

			$this->load_header();
			$this->load_sidebar();
			$this->load->view(view_franchise);
			$this->load_footer();
		} else {
			redirect(base_url());
		}
	}

	public function get_franchise()
	{
		$this->init_franchise_model();
		$data = $this->Franchise_model->get_franchise_details();
		echo json_encode($data);
	}

	public function delete_franchise()
	{
		$uid = $this->input->post(field_id);
		$this->init_franchise_model();
		$delete = $this->Franchise_model->delete_franchise_details($uid);
		echo json_encode($delete);
	}

	public function update_franchise()
	{
		$userid = $this->input->post(param_id);
		$name = $this->input->post(param_name);
		$email = $this->input->post(param_email);
		$mobile = $this->input->post(param_mobile);

		$this->init_franchise_model();
		$update = $this->Franchise_model->update_franchise_details($userid, $name, $email, $mobile);
		echo json_encode($update);
	}

	public function deactive_franchise()
	{
		$uid = $this->input->post(param_id);
		$this->init_franchise_model();
		$status = $this->Franchise_model->deactive_franchise_status($uid);
		echo json_encode($status);
	}

	public function active_franchise()
	{
		$userid = $this->input->post(param_id);
		$this->init_franchise_model();
		$status = $this->Franchise_model->active_franchise_status($userid);
		echo json_encode($status);
	}

	public function add_franchise()
	{
		$this->init_uid_server_model();

		$uid = $this->Uid_server_model->generate_uid(KEY_USER);
		$name = $this->input->post(param_name);
		$email = $this->input->post(param_email);
		$mobile = $this->input->post(param_mobile);
		$password = md5($this->input->post(param_mobile));

		$this->init_common_model();
		$mobile_exist = $this->Common_model->is_this_value_exist($mobile, field_mobile, table_users);
		$email_exist = $this->Common_model->is_this_value_exist($email, field_email, table_users);

		if (!empty($mobile_exist)) {
			$this->response([key_success => false, key_message => "This Number already exist for " . $mobile_exist->name], 200);
			return;
		}
		if (!empty($email_exist)) {
			$this->response([key_success => false, key_message => "This Email already exist for " . $email_exist->name], 200);
			return;
		}

		$user_type_id = $this->Common_model->get_user_type_id_by_user_type_name(user_type_franchise);

		$this->init_franchise_model();
		$data = $this->Franchise_model->add_franchise_details($uid, $name, $email, $mobile, $user_type_id, $password);

		if ($data) {
			$this->response([key_success => true, key_message => "Data insert successfull"], 200);
		} else {
			$this->response([key_success => true, key_message => "Failed to insert data"], 200);
		}
	}
	///////////////////// sub_franchise ////////////////////////////////////////
	public function sub_franchise()
	{
		if ($this->is_user_logged_in()) {

			$this->load_header();
			$this->load_sidebar();
			$this->load->view(view_sub_franchise);
			$this->load_footer();
		} else {
			redirect(base_url());
		}
	}

	public function get_sub_franchise()
	{
		$this->init_sub_franchise_model();
		$data = $this->Subfranchise_model->get_sub_franchise_details();
		echo json_encode($data);
	}

	public function delete_sub_franchise()
	{
		$uid = $this->input->post(field_id);
		$this->init_sub_franchise_model();
		$delete = $this->Subfranchise_model->delete_sub_franchise_details($uid);
		echo json_encode($delete);
	}

	public function update_sub_franchise()
	{
		$userid = $this->input->post(param_id);
		$name = $this->input->post(param_name);
		$email = $this->input->post(param_email);
		$mobile = $this->input->post(param_mobile);

		$this->init_sub_franchise_model();
		$update = $this->Subfranchise_model->update_sub_franchise_details($userid, $name, $email, $mobile);
		echo json_encode($update);
	}

	public function deactive_sub_franchise()
	{
		$uid = $this->input->post(param_id);
		$this->init_sub_franchise_model();
		$status = $this->Subfranchise_model->deactive_sub_franchise_status($uid);
		echo json_encode($status);
	}

	public function active_sub_franchise()
	{
		$uid = $this->input->post(param_id);
		$this->init_sub_franchise_model();
		$status = $this->Subfranchise_model->active_sub_franchise_status($uid);
		echo json_encode($status);
	}

	public function add_sub_franchise()
	{
		$this->init_uid_server_model();

		$uid = $this->Uid_server_model->generate_uid(KEY_USER);
		$name = $this->input->post(param_name);
		$email = $this->input->post(param_email);
		$mobile = $this->input->post(param_mobile);
		$password = md5($this->input->post(param_mobile));

		$this->init_common_model();

		$mobile_exist = $this->Common_model->is_this_value_exist($mobile, field_mobile, table_users);
		$email_exist = $this->Common_model->is_this_value_exist($email, field_email, table_users);

		if (!empty($mobile_exist)) {
			$this->response([key_success => false, key_message => "This Number already exist for " . $mobile_exist->name], 200);
			return;
		}
		if (!empty($email_exist)) {
			$this->response([key_success => false, key_message => "This Email already exist for " . $email_exist->name], 200);
			return;
		}

		$user_type_id = $this->Common_model->get_user_type_id_by_user_type_name(user_type_sub_franchise);

		$this->init_sub_franchise_model();
		$data = $this->Subfranchise_model->add_sub_franchise_details($uid, $name, $email, $mobile, $user_type_id, $password);

		if ($data) {
			$this->response([key_success => true, key_message => "Data insert successfull"], 200);
		} else {
			$this->response([key_success => true, key_message => "Failed to insert data"], 200);
		}
	}
	/////////////////////////// customers ////////////////////////////////////////
	public function customers()
	{
		if ($this->is_user_logged_in()) {
			$this->load_header();
			$this->load_sidebar();
			$this->load->view(view_customers);
			$this->load_footer();
		} else {
			redirect(base_url());
		}
	}

	public function get_customers_data()
	{
		$this->init_customer_model();
		$data = $this->Customers_model->get_customers_details();
		echo json_encode($data);
	}

	public function delete_customers()
	{
		$uid = $this->input->post(param_id);
		$this->init_customer_model();
		$delete = $this->Customers_model->delete_customers_details($uid);
		echo json_encode($delete);
	}

	public function update_customers()
	{
		$userid = $this->input->post(param_id);
		$name = $this->input->post(param_name);
		$email = $this->input->post(param_email);
		$mobile = $this->input->post(param_mobile);

		$this->init_customer_model();
		$update = $this->Customers_model->update_customers_details($userid, $name, $email, $mobile);
		echo json_encode($update);
	}

	public function deactive_customers()
	{
		$uid = $this->input->post(param_id);
		$this->init_customer_model();
		$status = $this->Customers_model->deactive_customers_status($uid);
		echo json_encode($status);
	}

	public function active_customers()
	{
		$uid = $this->input->post(param_id);
		$this->init_customer_model();
		$status = $this->Customers_model->active_customers_status($uid);
		echo json_encode($status);
	}

	public function add_customers()
	{
		$this->init_uid_server_model();
		$uid = $this->Uid_server_model->generate_uid(KEY_USER);
		$customer_id = $this->Uid_server_model->generate_uid(KEY_CUSTOMER);
		$name = $this->input->post(param_name);
		$email = $this->input->post(param_email);
		$mobile = $this->input->post(param_mobile);


		$this->init_common_model();

		$mobile_exist = $this->Common_model->is_this_value_exist($mobile, field_mobile, table_users);
		$email_exist = $this->Common_model->is_this_value_exist($email, field_email, table_users);

		if (!empty($mobile_exist)) {
			$this->response([key_success => false, key_message => "This Number already exist for " . $mobile_exist->name], 200);
			return;
		}
		if (!empty($email_exist)) {
			$this->response([key_success => false, key_message => "This Email already exist for " . $email_exist->name], 200);
			return;
		}

		$user_type_id = $this->Common_model->get_user_type_id_by_user_type_name(user_type_customer);

		$this->init_customer_model();
		$data = $this->Customers_model->add_customers_details($uid, $customer_id, $name, $email, $mobile, $user_type_id);

		if ($data) {
			$this->response([key_success => true, key_message => "Data insert successfull"], 200);
		} else {
			$this->response([key_success => true, key_message => "Failed to insert data"], 200);
		}
	}
	//////////////////////////////////////////////////////////////
	// sarathi details 
	public function sarathi_details($user_id)
	{
		$this->init_sarathi_details_model();
		$data['sarathi_data'] = $this->Sarathi_details_model->get_all_sarathi_details($user_id);

		$sarathi_id=$this->Sarathi_details_model->get_sarathi_id_by_user_id($user_id);
		$this->session->set_userdata('sarathi_id',$sarathi_id);

		$data['driver_pending']=$this->Sarathi_details_model->get_pending_driver_number($sarathi_id);

		if ($this->is_user_logged_in()) {
			$this->load_header();
			$this->load_sidebar();
			$this->load->view(view_sarathi_details, $data);
			$this->load_footer();
		} else {
			redirect(base_url());
		}
	}

	public function get_all_driver_of_sarathi()
	{
		$sarathi_id = $this->input->post(param_id);
		$this->init_sarathi_details_model();
		$data = $this->Sarathi_details_model->get_all_driver_details($sarathi_id);
		echo json_encode($data);
	}

	public function is_value_exist()
	{
		$mobile = $this->input->post(param_mobile);
		$this->init_common_model();
		$mobile_exist = $this->Common_model->is_this_value_exist($mobile, field_mobile, table_users);

		if (!empty($mobile_exist)) {
			echo json_encode("This Number already exist for " . $mobile_exist->name);
		} else {
			echo json_encode("success");
		}
	}

	public function get_pending_drivers(){
		$sarathi_id=$this->session->userdata('sarathi_id');

		// $sarathi_id=$this->input->post('id');
		$this->init_sarathi_details_model();
		$driver_detail=$this->Sarathi_details_model->get_pending_drivers($sarathi_id);
		echo json_encode($driver_detail);
	}

	public function show_pending_drivers($user_id){   // open pending driver doument page
		$this->init_sarathi_details_model();
		$user['user_id']=$user_id;
		$user['documents']=$this->Sarathi_details_model->get_pending_driver_details($user_id);

		if ($this->is_user_logged_in()) {
			$this->load_header();
			$this->load_sidebar();
			$this->load->view('pending_driver',$user);
			$this->load_footer();
		} else {
			redirect(base_url());
		}

		// $this->load_header();
		// $this->load_sidebar();
		// $this->load->view('pending_driver',$user);
		// $this->load_footer();
	}

	public function activate_pending_driver(){
		$user_id=$this->input->post('id');
		$this->init_sarathi_details_model();
		$active=$this->Sarathi_details_model->activate_pending_driver($user_id);
		if($active){
			$this->response(['success'=>true, 'message'=>'Driver is Activated','redirect_to'=>base_url('sarathi')],200);
		}
		else{
			$this->response(['success'=>false, 'message'=>'Failed to Activate driver'],200);
		}
	}

	public function approved_driver_documents(){
		$user_id=$this->input->post('id');	// driver's user_id
		$document_name=$this->input->post('name');
		$this->init_sarathi_details_model();
		$gid=$this->Sarathi_details_model->get_gid_by_user_id($user_id);
		$approved=$this->Sarathi_details_model->approved_driver_documents($gid,$document_name);
		if($approved){
			$this->response(['success'=>true, 'message'=>$document_name.' is approved','document'=>$document_name],200);
		}
		else{
			$this->response(['success'=>false, 'message'=>'Something went wrong !'],200);
		}		
	}

	public function deny_driver_documents(){
		$user_id=$this->input->post('id');	// driver's user_id
		$document_name=$this->input->post('name');
		$this->init_sarathi_details_model();
		$gid=$this->Sarathi_details_model->get_gid_by_user_id($user_id);
		$deny=$this->Sarathi_details_model->deny_driver_documents($gid, $document_name);
		if($deny){
			$this->response(['success'=>true, 'message'=>$document_name.' is Rejected','document'=>$document_name],200);
		}
		else{
			$this->response(['success'=>false, 'message'=>'Something went wrong !'],200);
		}		
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////
	public function getDashboardData(){
		$this->init_sarathi_model();
		$this->init_driver_model();	
		$this->init_customer_model();
		
		$data = [
			'totalSarathi' => $this->Sarathi_model->get_total_sarathi(),
			'drivers' => [
				'active' => $this->Driver_model->get_total_active_drivers(),
				'inactive' => $this->Driver_model->get_total_inactive_drivers(),
				'total' => $this->Driver_model->get_total_drivers()
			],
			'totalCustomers' => $this->Customers_model->get_total_customers()
		];
		echo json_encode($data);
	}

	public function getsarathiData(){
		$this->init_sarathi_model();
		$sarathiData = $this->Sarathi_model->getSarahiData();
		echo json_encode($sarathiData);
	}


	////////////////////// splash data /////////////////////////////////////////////

	public function sarathi_splash_data(){
		$this->init_admin_model();
		$sarathi_splash=$this->Admin_model->sarathi_splash_data();
		if(!empty($sarathi_splash)){
			$this->response(['success'=>true, 'message'=>'splash data found', 'data'=>$sarathi_splash], 200);
		}
		else{
			$this->response(['success'=>false, 'message'=>'splash data not found'], 200);
		}

	}

	
}
