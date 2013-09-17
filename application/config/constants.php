<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Permision Constant
 */ 
define('VIEW',0);
define('PARTICIPATE',1);
define('NORMAL_APPLY',2);
define('MANAGE_ACTIVITY',3);
define('MANAGE_MEMBER',4);
define('BUSINESS_PUBLIC',5);
define('SHOP_SHOW',6);

define('BASE_PERMISSION_MANAGE',0);
define('PERMISSION_MANAGE',1);
define('GROUP_MANAGE',2);
define('SHOP_MANAGE',3);
define('BASE_VOLUNTEER_MANAGE',4);
define('NOT_LOGIN',30);

/**
 * Role Constant
 */
define('GROUP_MANAGER_SHIFT',2);
define('SUPERVOLUNTEER',1);
define('SUPERMAN',30);

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
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */
