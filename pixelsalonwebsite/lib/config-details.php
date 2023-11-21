<?php

if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {
    // main db details
    define("DBHOST", "localhost");
    define("DBUSER", "root");
    define("DBPASSWORD", "");
    define("DBNAME", "pixelsalonsoftware");

    define("MDBHOST", "localhost");
    define("MDBUSER", "root");
    define("MDBPASSWORD", "");
    define("MDBNAME", "pixelsalonsoftwareroot");
} else {

    define("DBHOST", "localhost");
    define("DBUSER", "pixelsalonuser");
    define("DBPASSWORD", "IT)*&E)dOvJh");
    define("DBNAME", "pixelsalon");

    define("MDBHOST", "localhost");
    define("MDBUSER", "pixelsalonuser");
    define("MDBPASSWORD", "IT)*&E)dOvJh");
    define("MDBNAME", "pxlsoftware_main");
}

// demo db details

/*
define("DBHOST", "localhost");
define("DBUSER", "atqitcgz_demoslonusr1");
define("DBPASSWORD", "hSH&3bb7+lh%");
define("DBNAME", 'atqitcgz_demosaloon');

define("MDBHOST", "localhost");
define("MDBUSER", "atqitcgz_pixlogusr1");
define("MDBPASSWORD", '&Hg9cvi3l${1');
define("MDBNAME", "atqitcgz_pixlogin");
*/


$get_login_user_branch = get_login_user_branch(dbCon());
//$_SESSION['get_login_user_branch'] = $get_login_user_branch;

$get_login_user_model = get_login_user_model(dbCon());

$domainLink = get_main_url();

define("BRANDLOGO", $domainLink . "/web/salon-logo/{$get_login_user_branch->logo}");
define("SALONNAME", $get_login_user_branch->salon_name);
define("BRANCHNAME", $get_login_user_branch->branch_name);
define("BRANCHID", $get_login_user_branch->id);
//define("BRANDLOGO", "/web/salon-logo/{$get_login_user_branch->logo}");
define("POWEREDBYLOGO", "./img/atq-logo.png");
define("POWEREDBY", "Powered by Pixel IT Software");
define("FAVICON", "./web/salon-logo/{$get_login_user_branch->logo}");
define("USERNAME", $get_login_user_model->username);
define("USER_NAME", $get_login_user_model->name);
define("USERROLE", $get_login_user_model->user_role);


$branch_api_setting_model = fetch_object(dbCon(), "SELECT * FROM `branch_api_setting`");

define("SMSUSERNAME", $branch_api_setting_model->username);
define("SMSPASSWORD", $branch_api_setting_model->password);
define("SMSURL", $branch_api_setting_model->url);
define("SMSSENDERID", $branch_api_setting_model->sender_id);




function get_main_url()
{
    if (
        isset($_SERVER['HTTPS']) &&
        ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
    ) {
        $protocol = 'https://';
    } else {
        $protocol = 'http://';
    }


    $domain = $_SERVER['SERVER_NAME'];
    $url = $_SERVER['REQUEST_URI'];

    if (!empty($url)) {
        $script = explode('/', $url);
        $dir = '';
        if (count($script) > 0) {
            foreach ($script as $key => $value) {
                if (empty($value)) {
                    continue;
                }

                if (strpos($value, ".php")) {
                    continue;
                }

                if ($key > 2) {
                    continue;
                }

                $dir .= "/{$value}";
            }
        }
    } else {
        $dir = '';
    }

    return "{$protocol}{$domain}{$dir}";
}
