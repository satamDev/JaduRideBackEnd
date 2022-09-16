<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
/////////////////////////////////////////////////////////////////
define('API_KEY', '4c174057-0a6b-4fe8-98df-5699fac7c51a');
define('PLARTFORM', 'web');
/////////////////////////////////////////////////////////////////

define('page_header_link', 'inc/header_link');
define('page_header', 'inc/header');
define('page_sidebar', 'inc/sidebar');
define('page_footer', 'inc/footer');
define('page_footer_link', 'inc/footer_link');

////////////////////////////////////////////////////////////
define('view_admin', 'admin');
define('view_sarathi', 'sarathi');
define('view_driver', 'driver');
define('view_franchise', 'franchise');
define('view_sub_franchise', 'sub_franchise');
define('view_customers', 'customers');
define('view_login', 'login');
define('view_sarathi_details', 'sarathi_details');

//////////////////////////////////////////////////////////

define('model_login', 'Login_model');
define('model_uid_server', 'Uid_server_model');
define('model_common', 'Common_model');
define('model_admin', 'Admin_model');
define('model_sarathi', 'Sarathi_model');
define('model_driver', 'Driver_model');
define('model_sarathi_details', 'Sarathi_details_model');
define('model_customers_model', 'Customers_model');
define('model_franchise_model', 'Franchise_model');
define('model_sub_franchise_model', 'Subfranchise_model');
///////////////////////////////////////////////////////////
define('field_id', 'id');
define('field_uid', 'uid');
define('field_user_id', 'user_id');
define('field_name', 'name');
define('field_email', 'email');
define('field_mobile', 'mobile');
define('field_password', 'password');
define('field_status', 'status');
define('field_professional_details', 'professional_details');
define('field_address_details', 'address_details');
define('field_banking_details', 'banking_details');
define('field_kyc_details', 'kyc_details');
define('field_type_id', 'type_id');
define('field_location', 'asia/kolkata');
define('field_user_type', 'user_type');
define('field_profile_image', 'profile_image');
define('field_modified_at', 'modified_at');
define('field_date', 'Y-m-d H:i:s');
define('field_dob', 'dob');
define('field_verified', 'verified');
define('field_group_id', 'gid');
define('field_sarathi_id', 'sarathi_id');
////////////////////////////////////////////////////////////////
define('value_administrator', 'administrator');
define('value_admin', 'admin');

////////////////////////////////////////////////////////////////
define('table_sarathi', 'sarathi');
define('table_users', 'users');
define('table_driver', 'driver');
define('table_franchise', 'franchise');
define('table_subfranchise', 'subfranchise');
define('table_customer', 'customer');
define('table_admin', 'admin');
define('table_user_type', 'user_type');
define('table_documents', 'documents');

/////////////////////////////////////////////////////
define('const_deleted', 'deleted');
define('const_active', 'active');
define('const_deactive', 'deactive');
define('const_pending', 'pending');

define('const_submit', 'submit');
define('const_rejected', 'rejected');
//////////////////////////////////////////////////////
define('key_redirect_to', 'redirect_to');
define('key_message', 'message');
define('key_success', 'success');

//////////////////////////////////////////////////
define('url_admin_page', 'admin');

////////////////////////////////////////////////////

define('KEY_USER', 'USER');
define('KEY_SARATHI', 'SARATHI');
define('KEY_DRIVER', 'DRIVER');
define('KEY_CUSTOMER', 'CUSTOMER');

/////////////////////////////////////////

define('UID_USER_PREFIX', 'USER_');
define('UID_SARATHI_PREFIX', 'SARATHI_');
define('UID_DRIVER_PREFIX', 'DRIVER_');
define('UID_CUSTOMER_PREFIX', 'CUSTOMER_');

/////////////////////////////////////////////
define('user_type_admin', 'admin');
define('user_type_franchise', 'franchise');
define('user_type_sub_franchise', 'sub franchise');
define('user_type_sarathi', 'sarathi');
define('user_type_driver', 'driver');
define('user_type_customer', 'customer');
//////////////////////////////////////////////////////////////

define('value_user_admin', 'user_admin');
define('value_user_franchise', 'user_franchise');
define('value_user_sub_franchise', 'user_sub_franchise');
define('value_user_sarathi', 'user_sarathi');
define('value_user_driver', 'user_driver');
define('value_user_customer', 'user_customer');

///////////////////////////////////////////////////////////
define('param_id', 'id');
define('param_name', 'name');
define('param_email', 'email');
define('param_mobile', 'mobile');
define('param_dob', 'dob');
define('param_password', 'password');
define('param_user_type', 'user_type');
///////////////////////////////////////////////////////////////////

define('sarathi_page_header_link', 'sarathi/inc/header_link');
define('sarathi_page_header', 'sarathi/inc/header');
define('sarathi_page_sidebar', 'sarathi/inc/sidebar');
define('sarathi_page_footer', 'sarathi/inc/footer');
define('sarathi_page_footer_link', 'sarathi/inc/footer_link');

/////////////////////////////////////////////////////////////////////