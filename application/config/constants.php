<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

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
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

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
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*All Database table name define HERE*/
define('TBL_ADMIN_MASTER', 'ims_admin_master');
define('TBL_USER', 'jkm_user_master');
define('TBL_WORK_TYPE', 'jkm_work_type');
define('TBL_DOCUMENTS_MASTER','jkm_document_master');
define('TBL_CLIENT_MASTER', 'jkm_client_master');
define('TBL_CLIENTS_ATTACHMENTS', 'jkm_clients_attachments');
define('TBL_COMPANY_MASTER', 'ims_company_master');
define('TBL_COMPANY_BANK_DETAILS_MASTER', 'ims_company_bank_details');
define('TBL_COUNTRY_MASTER', 'ims_country_master');
define('TBL_CURRENCY_MASTER', 'ims_currency_master');
define('TBL_CATEGORY_MASTER', 'ims_invoice_category_master');
define('TBL_ROLE_MASTER', 'ims_role_master');
define('TBL_STATE_MASTER', 'ims_state_master');
define('TBL_TAX_MASTER', 'ims_tax_master');
define('TBL_MENU_MASTER', 'ims_menu_master');
define('TBL_MENU_MAPPER', 'ims_menu_mapper');
define('TBL_ROLE_MENU', 'ims_role_menu');
define('TBL_ROLE_SUBMENU', 'ims_role_submenu');
define('TBL_ORDER_MASTER', 'ims_order_master');
define('TBL_CHANGE_ORDER_MASTER', 'ims_change_order');
define('TBL_ORDER_INVOICE_SCHEDULE_MASTER', 'ims_order_invoice_schedule');
define('TBL_ORDER_ATTACHMENT_MASTER', 'ims_order_attachments');
define('TBL_PAYMENT_TERMS_MASTER', 'ims_payment_terms');
define('TBL_IMPRESSION_UNITS_MASTER', 'ims_impression_units');
define('TBL_INVOICE_MASTER', 'ims_invoice_master');
define('TBL_INVOICE_ATTACHMENTS', 'ims_invoice_attachments');
define('TBL_INVOICE_CATEGORY_GEN_MAPPER', 'ims_invoice_category_gen_mapper');
define('TBL_INVOICE_REQTAX_MASTER', 'ims_invoice_reqtax');
define('TBL_USER_PERMISSION_MAP', 'user_permission_map');
define('TBL_PERMISSIONS', 'permissions');
define('TBL_PROJECTIONS', 'ims_projections');
define('TBL_PROJECTIONS_TOTAL', 'ims_projections_total');
define('TBL_PROJECTIONS_AUDIT_TRAILS', 'ims_projections_audit_trails');
define('TBL_CURRENCY_CONVERSIONS', 'ims_currency_conversions');
define('TBL_CONFIG_GROUPS', 'ims_config_groups');
define('TBL_CONFIGURATIONS', 'ims_configurations');
define('TBL_INVOICE_COURIER_INFO', 'ims_invoice_courier_info');

define('TBL_JOB_MASTER', 'jkm_job_master');
define('TBL_JOBCARDS_FILES', 'jkm_job_card_files');
define('TBL_JOBS_ATTACHMENTS', 'jkm_jobs_attachments');
define('TBL_JOBCARDS_WORK_FILES', 'jkm_job_work_files');
/*End Tables*/

/*DEFINE CATEGORY ID*/
define('ADSALESCAT', '1');
define('LOCALIZATIONCAT', '2');
define('CONTENTCAT', '3');
define('WIRELESSCAT', '4');
define('TECHNOLOGYCAT', '5');
define('ADNETWORKSCAT', '6');
define('ADSALESINCCAT', '7');
define('LOCALIZATIONINCCAT', '8');
define('WIRELESSINCCAT', '9');
define('TECHNOLOGYINCCAT', '10');
define('ADNETWORKSINCCAT', '11');

/*DEFINE ROLE ID*/
define('RECIEPTIONISTROLEID', 1);
define('STAFFROLEID', 2);
define('COLLECTORROLEID', 3);
define('MANAGERROLEID', 4);
define('SUPERADMINROLEID', 5);

define('UPLOAD_ROOT_DIR', 'uploads');