<?php
define("DBHOST", "db_host");
define("DBUSER", "db_username");
define("DBPASSWORD", "db_password");
define("DBNAME", "db_name");

/*
define("DBHOST", "localhost");
define("DBUSER", "atqitcgz_salonusr22");
define("DBPASSWORD", "T?es^#w!_#9g");
define("DBNAME", 'atqitcgz_salon22');
*/

$get_login_user_branch = get_login_user_branch(dbCon());
$_SESSION['get_login_user_branch'] = $get_login_user_branch;

$get_login_user_model = get_login_user_model();


define("SALONNAME", $get_login_user_branch->salon_name);
define("BRANCHNAME", $get_login_user_branch->branch_name);
define("BRANCHID", $get_login_user_branch->id);
define("BRANDLOGO", "./web/salon-logo/{$get_login_user_branch->logo}");
define("POWEREDBYLOGO", "./img/atq-logo.png");
define("POWEREDBY", "Poweredby Pixel IT Software");
define("FAVICON", "./web/salon-logo/{$get_login_user_branch->logo}");
define("USERNAME", $get_login_user_model->username);
define("USER_NAME", $get_login_user_model->name);
define("USERROLE", $get_login_user_model->user_role);

define("SMSUSERNAME", "SEVATRUSTTRANS");
define("SMSPASSWORD", "123456");
define("SMSURL", "https://bhashsms.com/api/sendmsg.php?");
define("SMSSENDERID", "PICSAL");
