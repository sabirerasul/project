<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('config-details.php');

function dbCon()
{
  return mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBNAME);

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
  }
}


function mdbCon()
{
  return mysqli_connect(MDBHOST, MDBUSER, MDBPASSWORD, MDBNAME);

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
  }
}

$db = dbCon();

function check_auth()
{
  if (!isset($_SESSION['user'])) {
    header('location: ./login.php');
  }
}

function throw_exception()
{
  function check_auth_exp()
  {
    if (!isset($_SESSION['user'])) {
      throw new Exception("Unauthorized Access", 1);
    }
    //return true;
  }

  try {
    echo check_auth_exp();
  } catch (Exception $e) {
    echo $e->getMessage();
    die();
  }
}

function is_auth()
{
  if (isset($_SESSION['user'])) {
    header('location: index.php');
  }
}

function is_automate_auth($db, $token)
{

  $model = fetch_object($db, "SELECT * FROM `user` WHERE `password`='{$token}'");

  if (!empty($model)) {
    $array = [
      "id" => $model->id,
      "name" => $model->name,
      "username" => $model->username,
      "email" => $model->email,
      "user_role" => $model->user_role,
    ];

    $arr = (object) $array;
    $model = json_encode($arr);
    $userArray =
      [
        'user' => $array['name'],
        'user_id' => $array['id'],
        'model' => $model
      ];

    $_SESSION['user'] = $userArray;
    $page = 'index.php';
  } else {
    $page = 'login.php';
  }
  header("location: ../{$page}");
}

function formatDate($date)
{
  return date("d/m/Y", strtotime($date));
}

function todayDate()
{
  return date("d/m/Y");
}


function validName($name)
{
  return preg_match("/^[A-Za-z\s]*$/", $name) ? true : false;
}

function validEmail($email)
{
  return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
}

function validNumber($number)
{
  return preg_match('/^[0-9]{10}+$/', $number) ? true : false;
}

function getAttendanceId($id)
{
  $threshold = 7;
  $sum = sprintf('%0' . $threshold . 's', ($id + 1));
  return $sum;
}

function imageUpload($FILES)
{

  //$target_dir = "uploads/";

  $dir = dirname(__FILE__);

  $dir = str_replace("\'", "/", $dir);
  $dir = str_replace('lib', "", $dir);

  $target_dir = $dir . "/web/employee_doc/";

  $uploadOk = 1;

  $error = '';

  $data = [];
  $data['filename'] = '';
  $data['success'] = 'false';
  $data['error'] = '';

  if (empty($FILES)) {

    $data['filename'] = '';
    $data['success'] = 'false';
    $data['error'] = 'NO FILE FOUND';

    return $data;
  }

  $target_file = $target_dir . basename($FILES["name"]);
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $filename = rand(0, 987654321);

  $filename = $filename . '.' . $imageFileType;

  $target = $target_dir . basename($filename);


  // Check if image file is a actual image or fake image
  /*$check = getimagesize($FILES["tmp_name"]);
  if ($check !== false) {
    $uploadOk = 1;
  } else {
    $error = "File is not an image.";
    $uploadOk = 0;
    $data['error'] = $error;
    $data['success']  = 'false';
  }*/

  // Check file size
  if ($FILES["size"] > 500000) {
    $error = "Sorry, your file is too large.";
    $uploadOk = 0;
    $data['error'] = $error;
    $data['success']  = 'false';
  }

  // Allow certain file formats
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf") {
    $error = "Sorry, only JPG, JPEG, PNG, PDF files are allowed.";
    $uploadOk = 0;
    $data['error'] = $error;
    $data['success']  = 'false';
  }

  if ($uploadOk == 0) {
    $error = "Sorry, your file was not uploaded.";
  } else {
    if (move_uploaded_file($FILES["tmp_name"], $target)) {
      $error = $filename;
      $data['error'] = '';
      $data['filename'] = $filename;
      $data['success']  = 'true';
    } else {
      $error = "Sorry, there was an error uploading your file.";
      $data['error'] = $error;
      $data['success']  = 'false';
    }
  }

  return $data;
}

function fetch_all($db, $sql)
{
  $query = mysqli_query($db, $sql);
  return mysqli_fetch_all($query, MYSQLI_ASSOC);
}

function fetch_object($db, $sql)
{
  $query = mysqli_query($db, $sql);
  return mysqli_fetch_object($query);
}

function fetch_assoc($db, $sql)
{
  $query = mysqli_query($db, $sql);
  return mysqli_fetch_assoc($query);
}

function num_rows($db, $sql)
{
  return mysqli_num_rows(mysqli_query($db, $sql));
}

function debug($v)
{
  echo "<pre>";
  print_r($v);
  echo "<pre>";
}


function genNumArr($number)
{
  $arr = [];
  for ($i = 0; $i <= $number; $i++) {
    $arr[$i] = ($i <= 9) ? '0' . $i : $i;
  }
  return $arr;
}


function getEndTime($timestamp, $duration)
{
  $timestamp = $timestamp . ':00';
  $startTime = date("Y-m-d H:i:s", strtotime($timestamp));
  $addMinute = "+" . getMinute($duration) . " minutes";

  $startTimeString = strtotime($startTime);
  $endTime = date('Y-m-d H:i:s', strtotime($addMinute, $startTimeString));

  return $endTime;
}

function getMinute($duration)
{
  $timesplit = explode(':', $duration);
  //return (($timesplit[0] * 60) + ($timesplit[1]));
  return $duration;
}

function getOnlyTime($timestamp, $format = 'H')
{
  return ($format == 'h') ? date($format . ":i:s A", strtotime($timestamp)) : date($format . ":i:s", strtotime($timestamp));
}

function getOnlyTimeWithoutSecond($timestamp, $format = 'H')
{
  return ($format == 'h') ? date($format . ":i A", strtotime($timestamp)) : date($format . ":i:s", strtotime($timestamp));
}

function getDateServerFormat($date, $separator = '/', $formatter = '-')
{
  $d = explode($separator, $date);

  $dd = $d[2] . $formatter . $d[1] . $formatter . $d[0];

  return $dd;
}

function getCFormatDate($date)
{
  $datetime = new DateTime($date);
  return $datetime->format('c');
}

function availableStock($db, $id)
{
  $branch_id = BRANCHID;
  $productModel = fetch_object($db, "SELECT sum(credit) as creditStock, sum(debit) as debitStock FROM stock_record WHERE stock_main_id='" . $id . "' AND branch_id='{$branch_id}'");
  return ($productModel->creditStock - $productModel->debitStock);
}

$appointmentPaymentModeArr = [
  "1" => "Cash",
  "3" => "Credit/Debit card",
  "4" => "Cheque",
  "5" => "Online payment",
  "6" => "Paytm",
  "7" => "E-wallet",
  "9" => "Reward points",
  "10" => "PhonePe",
  "11" => "Gpay",
];

$paymentModeArr = [
  "1" =>  "Cash",
  "3" =>  "Credit/Debit card",
  "4" =>  "Cheque",
  "5" =>  "Online payment",
  "6" =>  "Paytm",
  "10" => "PhonePe",
  "11" => "Gpay",
];

$unitArr = [
  "l" => "L",
  "ml" => "ML",
  "mg" => "MG",
  "gram" => "Gram",
  "pcs" => "Pcs",
  "pkt" => "Pkt"
];

$serviceForArr = [
  "1" => "Men",
  "2" => "Women",
  "3" => "Men &amp; Women",
];



$appointmentStatusArr = [
  "Pending" => "Pending",
  "Billed" => "Billed",
  "Cancelled" => "Cancelled",
];


$userRoleArr = [
  "admin" => "Admin",
  "superadmin" => "SuperAdmin",
];

$taxTypeArr = [
  1 => 'inclusive',
  2 => 'exclusive',
];

$productServiceArr = [
  0 => 'product',
  1 => 'service'
];

$discountArr = [
  "percentage" => "%",
  "inr" => "INR",
];

$rewardPointBoostArr = [
  "1" => "1X",
  "2" => "2X",
  "3" => "3X",
  "4" => "4X",
];

$appointmentSourceArr = [
  "on call" => "On-call",
  "walkin" => "Walkin",
  "website" => "Website",
];

$leadStatus = [
  "Pending" => "Pending",
  "Converted" => "Converted",
  "Close" => "Close"
];

$enquirySourceArr = [
  "Client refrence" => "Client refrence",
  "Cold Calling" => "Cold Calling",
  "Facebook" => "Facebook",
  "Twitter" => "Twitter",
  "Instagram" => "Instagram",
  "Other Social Media" => "Other Social Media",
  "Website" => "Website",
  "Walk-In" => "Walk-In",
  "Flex" => "Flex",
  "Flyer" => "Flyer",
  "Newspaper" => "Newspaper",
  "SMS" => "SMS",
  "Street Hoardings" => "Street Hoardings",
  "Event" => "Event",
  "TV/Radio" => "TV/Radio"
];


$enquiryTypeArr = [
  "Hot" => "Hot",
  "Cold" => "Cold",
  "Warm" => "Warm"
];

function dateMMFormar($date)
{
  $dateArr = explode('/', $date);
  return "{$dateArr[1]}/{$dateArr[0]}/{$dateArr[2]}";
}


function fireAlert($message, $color = 'green')
{
  echo "<script>";
  echo 'document.addEventListener("DOMContentLoaded", () => {';
  echo "showAlert('" . $message . "', '" . $color . "')";
  echo "})";
  echo "</script>";
}


function all_branch($db)
{
  return fetch_all($db, "SELECT * FROM branch");
}

function time_12($time)
{
  return !empty($time) ? date("g:i a", strtotime($time)) : $time;
}

function time_24($time)
{
  return !empty($time) ? date("H:i:s", strtotime($time)) : $time;
}


function get_login_user_id()
{
  if (isset($_SESSION['user'])) {
    return $_SESSION['user']['user_id'];
  } else {
    return 0;
  }
}

function get_login_user_role()
{
  if (isset($_SESSION['user'])) {
    $model = json_decode($_SESSION['user']['model']);
    return $model->user_role;
  } else {
    return '';
  }
}

function get_login_user_name()
{
  if (isset($_SESSION['user'])) {
    return $_SESSION['user']['user'];
  } else {
    return '';
  }
}

function get_login_user_model()
{
  if (isset($_SESSION['user'])) {
    $model = json_decode($_SESSION['user']['model']);
    return $model;
  } else {
    class User1
    {
      public $id;
      public $name;
      public $username;
      public $email;
      public $password;
      public $plain_password;
      public $user_role;
      public $created_at;
      public $created_by;
      public $updated_at;
      public $updated_by;
    }
    return new User1();
  }
}

function get_login_user_branch($db)
{
  class Branch1
  {
    public $id;
    public $uid;
    public $branch_name;
    public $salon_name;
    public $address;
    public $phone;
    public $email;
    public $website;
    public $gst;
    public $working_hours_start;
    public $working_hours_end;
    public $logo;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
  }
  if (isset($_SESSION['user'])) {
    $model = json_decode($_SESSION['user']['model']);

    if (isset($_SESSION['branch_select']) && !empty($_SESSION['branch_select']) && is_numeric($_SESSION['branch_select'])) {
      $branch_select = $_SESSION['branch_select'];
      $cond = ($model->user_role == 'superadmin') ? "id={$branch_select}" : 1;
    } else {
      $cond = ($model->user_role == 'superadmin') ? 1 : "uid={$model->id}";
    }
    $branchModel = fetch_object($db, "SELECT * FROM branch WHERE {$cond}");
    if (!empty($branchModel)) {
      return $branchModel;
    } else {
      return new Branch1();
    }
  } else {
    return new Branch1();
  }
}

function getUsername($id)
{
  $threshold = 3;
  $rand = rand(01, 99);
  $sum = ($id + 1) . $rand;
  return 'E' . $sum;
}

function get_client_rating($db, $client_id)
{
  $rating = '';
  $cond = "client_id='{$client_id}' AND status='1'";
  $ratingSql = "SELECT sum(rating) as rating FROM feedback WHERE {$cond}";
  $numRatingSql = "SELECT * FROM feedback WHERE {$cond}";
  $model = fetch_assoc($db, $ratingSql);
  $numModel = num_rows($db, $numRatingSql);

  if ($numModel != 0) {
    $totalRating = round(($model['rating'] / $numModel));
    $rating = '<div style="white-space:nowrap;display:inline-block">';
    for ($i = 0; $i < $totalRating; $i++) {
      $rating .= '<i class="fa fa-star rating-color" style="margin:0px;" aria-hidden="true"></i>';
    }
    $rating .= '</div>';
  } else {
    $rating = '';
  }
  return $rating;
}

function get_client_feedback($db, $client_id)
{
  $model = fetch_object($db, "SELECT * FROM feedback WHERE client_id='{$client_id}' AND status='1' ORDER by id DESC");
  return !empty($model) ? $model->review : '';
}


function get_filter_branch($id, $db)
{
  $modifiedBranchArr = [];
  $allBranchArr = all_branch($db);

  $count = 0;
  foreach ($allBranchArr as $modifiedBranchKey => $modifiedBranchValue) {
    if ($id != $modifiedBranchValue['id']) {
      $modifiedBranchArr[$count] = $modifiedBranchValue;
      $count++;
    }
  }

  return $modifiedBranchArr;
}

function get_split_string($str, $split)
{
  $string = strtoupper(str_replace(' ', '', $str));

  $strLen = strlen($string);

  if ($strLen >= $split) {
    $result = mb_substr($string, 0, $split);
  } else {
    $leftZero = ($split - $strLen);

    $zeros = '';
    for ($i = 0; $i < $leftZero; $i++) {
      $zeros .= "0";
    }

    $result1 = mb_substr($string, 0, $strLen);
    $result = $result1 . $zeros;
  }

  return $result;
}

function get_referral_code($db, $client_id)
{
  $model = fetch_object($db, "SELECT * FROM client WHERE id='{$client_id}'");
  $client_name = $model->client_name;
  $short_name = get_split_string($client_name, 4);
  $ym = date("ym");
  return "{$short_name}{$ym}{$client_id}";
}

function get_invoice_number()
{
  $branch_id = BRANCHID;
  $model = fetch_object(dbCon(), "SELECT * FROM branch WHERE id='{$branch_id}'");
  $short_name = get_split_string($model->salon_name, 2);
  $date = date("ymHis");
  return "{$short_name}{$date}";
}

function get_client_last_visit($db, $client_id)
{
  $model = fetch_object($db, "SELECT billing_date FROM client_billing WHERE client_id='{$client_id}' ORDER by ID desc");
  return !empty($model) ? $model->billing_date : '';
}

function get_client_first_visit($db, $client_id)
{
  $model = fetch_object($db, "SELECT billing_date FROM client_billing WHERE client_id='{$client_id}' ORDER by ID asc");
  return !empty($model) ? $model->billing_date : '';
}

function get_client_total_visit($db, $client_id)
{
  return num_rows($db, "SELECT * FROM client_billing WHERE client_id='{$client_id}'");
}

function get_client_total_spend($db, $client_id)
{
  $model = fetch_object($db, "SELECT sum(total) as total_spend FROM client_billing WHERE client_id='{$client_id}'");
  return !empty($model->total_spend) ? $model->total_spend : 0;
}


function get_client_type($db, $client_id)
{
  $model = fetch_object($db, "SELECT * FROM client_billing WHERE client_id='{$client_id}' ORDER BY id DESC");

  $customer = '';

  if (!empty($model)) {

    $oldDate = date("Y-m-01", strtotime("-1 month"));
    $billingDate = getDateServerFormat($model->billing_date);

    if ($oldDate <= $billingDate) {
      $customer = "active";
    }

    $churnOldDate = date("Y-m-d", strtotime("-2 month"));
    $churnOldDate =  date("Y-m-t", strtotime($churnOldDate));

    if ($churnOldDate >= $billingDate) {
      $customer = "churnprediction";
    }

    $defectedOldDate = date("Y-m-d", strtotime("-6 month"));
    $defectedOldDate =  date("Y-m-t", strtotime($defectedOldDate));

    if ($defectedOldDate >= $billingDate) {
      $customer = 'inactive';
    }
  } else {
    $customer = "newcustomer";
  }

  return $customer;
}

function get_client_wallet($db, $client_id)
{
  $sql1 = "SELECT sum(amount) AS amount FROM client_wallet WHERE client_id='{$client_id}' AND transaction_type='Credit'";
  $sql2 = "SELECT sum(amount) AS amount FROM client_wallet WHERE client_id='{$client_id}' AND transaction_type='Debit'";
  $rewardModel1 = fetch_object($db, $sql1);
  $rewardModel2 = fetch_object($db, $sql2);

  $cAmount = !empty($rewardModel1->amount) ? $rewardModel1->amount : 0;
  $dAmount = !empty($rewardModel2->amount) ? $rewardModel2->amount : 0;
  $total = $cAmount - $dAmount;

  return $total;
}

function get_client_pending_amount($db, $client_id)
{

  $paymentModel = fetch_all($db, "SELECT * FROM `pending_payment_history` WHERE client_id='{$client_id}' AND pending!=0 AND `bill_type`='bill'");

  $html[] = 0;
  foreach ($paymentModel as $paymentKey => $paymentVal) {
    $paymentValue = (object) $paymentVal;

    $model = fetch_object($db, "SELECT sum(total) as total, sum(advance) as advance, sum(paid) as paid FROM `pending_payment_history` WHERE app_bill_id='{$paymentValue->app_bill_id}'");
    if (!empty($model)) {

      $pendingPaid = 0; //!empty($pendingPaymentModel->paid) ? $pendingPaymentModel->paid : 0;

      $total = $model->total;
      $advance = $model->advance;
      $paid = $model->paid + $pendingPaid;

      $pending = ($total - $advance - $paid);

      if ($pending == 0) {
        continue;
      }

      if ($paymentValue->bill_type == "appointment") {
        continue;
      }

      if ($paymentValue->bill_type == "pending payment") {
        continue;
      }
    }

    $html[] = $pending;
  }


  $client_pending = array_sum($html);
  return $client_pending;
}



function get_client_reward_point($db, $client_id)
{
  $sql1 = "SELECT sum(points) AS points FROM reward_point WHERE client_id='{$client_id}' AND transaction_type='Credit'";
  $sql2 = "SELECT sum(points) AS points FROM reward_point WHERE client_id='{$client_id}' AND transaction_type='Debit'";
  $rewardModel1 = fetch_object($db, $sql1);
  $rewardModel2 = fetch_object($db, $sql2);

  $cPoint = !empty($rewardModel1->points) ? $rewardModel1->points : 0;
  $dPoint = !empty($rewardModel2->points) ? $rewardModel2->points : 0;
  $total = $cPoint - $dPoint;

  return $total;
}


function get_client_billing_service_provider($db, $billing_id)
{
  $billingProductModel = fetch_all($db, "SELECT * FROM client_billing_product WHERE billing_id='{$billing_id}'");

  $serviceProvider = '';
  foreach ($billingProductModel as $billingProductKey => $billingProductVal) {
    $billingProductValue = (object) $billingProductVal;

    $serviceProviderAssignModel = fetch_all($db, "SELECT * FROM client_billing_assign_service_provider WHERE billing_id='{$billing_id}' AND billing_service_id='{$billingProductValue->id}'");

    foreach ($serviceProviderAssignModel as $serviceProviderAssignKey => $serviceProviderAssignVal) {
      $serviceProviderAssignValue = (object) $serviceProviderAssignVal;
      $serviceProviderModel = fetch_object($db, "SELECT * FROM service_provider WHERE id='{$serviceProviderAssignValue->service_provider_id}'");
      $serviceProvider .= !empty($serviceProviderModel) ? $serviceProviderModel->name . ", " : '';
    }
  }

  $serviceProvider = rtrim($serviceProvider, ", ");
  return $serviceProvider;
}

function get_client_billing_service($db, $billing_id)
{
  $serviceTitle = '';
  $billingProductModel = fetch_all($db, "SELECT * FROM client_billing_product WHERE billing_id='{$billing_id}'");
  foreach ($billingProductModel as $serviceKey => $serviceValue) {
    $serviceObject = (object) $serviceValue;

    $enquiryForModel = fetch_object($db, "SELECT * FROM {$serviceObject->service_type} WHERE id='{$serviceObject->service_id}'");

    $arrayField = [
      'service' => 'service_name',
      'membership' => 'membership_name',
      'package' => 'package_name',
      'stock' => 'product_id'
    ];

    $fieldName = $arrayField[$serviceObject->service_type];

    $enquiryForText = '';
    if ($serviceObject->service_type == 'stock') {
      $productModel = fetch_object($db, "SELECT * FROM product WHERE id='{$enquiryForModel->$fieldName}'");
      $enquiryForText = $productModel->product;
    } else {
      $enquiryForText = $enquiryForModel->$fieldName;
    }

    $serviceTitle .= $enquiryForText . ", ";
  }

  return $serviceTitle = rtrim($serviceTitle, ", ");
}

function get_client_last_bill_amount($db, $client_id)
{
  $model = fetch_object($db, "SELECT total FROM client_billing WHERE client_id='{$client_id}' ORDER BY id DESC");
  return !empty($model) ? $model->total : 0;
}


function get_existing_client($db)
{
  $model = num_rows($db, "SELECT * FROM client");
  return $model;
}

function get_active_client($db)
{
  $client[] = 0;

  $model = fetch_all($db, "SELECT * FROM client");

  foreach ($model as $key => $value) {
    $client_id = $value['id'];
    //$oldDate = date("Y-m-01");

    $oldDate = date("Y-m-01", strtotime("-1 month"));

    $model = fetch_object($db, "SELECT * FROM client_billing WHERE client_id='{$client_id}' ORDER BY id DESC");

    if (!empty($model)) {
      $billingDate = getDateServerFormat($model->billing_date);

      if ($oldDate <= $billingDate) {
        $client[] = 1;
      }
    }
  }

  return array_sum($client);
}

function get_churn_client($db)
{
  $client[] = 0;

  $model = fetch_all($db, "SELECT * FROM client");

  foreach ($model as $key => $value) {
    $client_id = $value['id'];
    //$oldDate = date("Y-m-01");

    $oldDate = date("Y-m-d", strtotime("-2 month"));
    $oldDate =  date("Y-m-t", strtotime($oldDate));


    $defectedOldDate = date("Y-m-d", strtotime("-6 month"));
    $defectedOldDate =  date("Y-m-t", strtotime($defectedOldDate));

    $model = fetch_object($db, "SELECT * FROM client_billing WHERE client_id='{$client_id}' ORDER BY id DESC");

    if (!empty($model)) {
      $billingDate = getDateServerFormat($model->billing_date);
      if ($oldDate >= $billingDate && $defectedOldDate < $billingDate) {
        $client[] = 1;
      }
    }
  }

  return array_sum($client);
}

function get_defected_client($db)
{
  $client[] = 0;

  $model = fetch_all($db, "SELECT * FROM client");

  foreach ($model as $key => $value) {
    $client_id = $value['id'];
    //$oldDate = date("Y-m-01");

    $oldDate = date("Y-m-d", strtotime("-6 month"));
    $oldDate =  date("Y-m-t", strtotime($oldDate));

    $model = fetch_object($db, "SELECT * FROM client_billing WHERE client_id='{$client_id}' ORDER BY id DESC");

    if (!empty($model)) {
      $billingDate = getDateServerFormat($model->billing_date);

      if ($oldDate >= $billingDate) {
        $client[] = 1;
      }
    }
  }

  return array_sum($client);
}

function get_billing_product_amount($db, $billing_id, $serviceType)
{
  $model = fetch_all($db, "SELECT * FROM `client_billing_product` WHERE `billing_id`='{$billing_id}' AND `service_type`='{$serviceType}'");
  $amount = [];
  $amount[] = 0;

  foreach ($model as $key => $val) {
    $value = (object) $val;

    $price = $value->price;
    if ($value->service_discount_type == 'percentage') {
      $oldPrice = ($value->service_discount != 0) ? $price : 0;
      $price = ($value->service_discount != 0) ? get_price_from_discount($value->service_discount, $price) : $price;
      $price = $price + $oldPrice;
    } else {
      $price = ($value->service_discount + $price);
    }

    $amount[] = $price;
  }

  $total = array_sum($amount);

  return $total;
}

function get_actual_product_amount($value)
{

  $price = $value->price;
  if ($value->service_discount_type == 'percentage') {
    $oldPrice = ($value->service_discount != 0) ? $price : 0;
    $price = ($value->service_discount != 0) ? get_price_from_discount($value->service_discount, $price) : $price;
    $price = $price + $oldPrice;
  } else {
    $price = ($value->service_discount + $price);
  }

  return $price;
}

function get_total_billing_product($db, $billing_id, $serviceType)
{
  $model = fetch_all($db, "SELECT * FROM client_billing_product WHERE billing_id='{$billing_id}' AND service_type='{$serviceType}'");
  $amount = [];
  $amount[] = 0;

  foreach ($model as $key => $value) {
    $amount[] = 1;
  }

  $total = array_sum($amount);

  return $total;
}

function get_billing_discount($db, $billing_id)
{
  $mainModel = fetch_object($db, "SELECT * FROM `client_billing` WHERE id='{$billing_id}'");
  $model = fetch_all($db, "SELECT * FROM client_billing_product WHERE billing_id='{$billing_id}'");

  $mPrice = 0;
  if ($mainModel->discount_type == 'percentage') {
    $dis = (int) $mainModel->discount;
    $mPrice = get_price_from_discount($dis, $mainModel->total);
  } else {
    $mPrice = ($mainModel->discount - $mainModel->total);
  }

  $amount = [];
  $amount[] = 0;

  foreach ($model as $key => $val) {
    $value = (object) $val;
    $price = 0;
    if ($value->service_discount_type == 'percentage') {
      $price = get_price_from_discount($value->service_discount, $value->price);
    } else {
      $price = ($value->service_discount - $value->price);
    }

    $amount[] = $price;
  }

  $amount[] = $mPrice;
  $total = array_sum($amount);

  return $total;
}

function get_today_appointment($db)
{
  $branch_id = BRANCHID;
  $todayDate = date('d/m/Y');
  return num_rows($db, "SELECT * FROM appointment WHERE appointment_date='{$todayDate}' AND branch_id='{$branch_id}'");
}

function get_today_sale($db)
{
  $branch_id = BRANCHID;
  $todayDate = date('Y-m-d');
  $sql = "SELECT sum(total) as total FROM `client_billing` WHERE branch_id='{$branch_id}' AND created_at LIKE '%{$todayDate}%'";
  $numSql = "SELECT * FROM `client_billing` WHERE branch_id='{$branch_id}' AND created_at LIKE '%{$todayDate}%'";
  $m = num_rows($db, $numSql);
  return $m ? fetch_object($db, $sql)->total : $m;
}

function get_today_enquiry($db)
{
  $branch_id = BRANCHID;
  $todayDate = date("Y-m-d");
  return num_rows($db, "SELECT * FROM `enquiry` WHERE branch_id='{$branch_id}' AND `created_at` LIKE '%{$todayDate}%'");
}

function get_today_client_visit($db)
{
  $branch_id = BRANCHID;
  $todayDate = date("Y-m-d");
  return num_rows($db, "SELECT * FROM `client_billing` WHERE branch_id='{$branch_id}' AND `created_at` LIKE '%{$todayDate}%'");
}


function get_price_from_discount($per, $price)
{
  $price = (int) $price;
  $price = ($price * $per) / 100;
  return $price;
}

function get_service_provider_commission($db, $service_provider_id, $billingProduct)
{
  $serviceProviderModel = fetch_object($db, "SELECT * FROM service_provider WHERE id='{$service_provider_id}'");

  $serviceCommission = $serviceProviderModel->service_commission;
  $productCommission = $serviceProviderModel->product_commission;

  $serviceCommission = !empty($serviceCommission) ? $serviceCommission : 0;
  $productCommission = !empty($productCommission) ? $productCommission : 0;

  $price = $billingProduct->price;

  $commission = 0;

  if ($billingProduct->service_type == 'service' || $billingProduct->service_type == 'package') {
    $commission = get_price_from_discount($serviceCommission, $billingProduct->price);
  }

  if ($billingProduct->service_type == 'stock') {
    $commission = get_price_from_discount($productCommission, $billingProduct->price);
  }

  $commission = !empty($commission) ? $commission : 0;

  return $commission;
}

function get_available_service_provider($db, $appointmentDate, $serviceIds, $endTime, $serviceType = 'service')
{
  $appointmentDate = empty($appointmentDate) ? todayDate() : $appointmentDate;
  $newappointmentDate = explode('/', $appointmentDate);
  $appointmentDate = $newappointmentDate[0] . "-" . $newappointmentDate[1] . "-" . $newappointmentDate[2];
  $serverAppointmentDate = $newappointmentDate[2] . "-" . $newappointmentDate[1] . "-" . $newappointmentDate[0];

  $dayName = date('l', strtotime($serverAppointmentDate));

  $spSql = "SELECT id, CONCAT_WS(' - ', `name`, `username`) AS `name`, working_hours_start, working_hours_end FROM service_provider WHERE status = 1";
  $modal = fetch_all($db, $spSql);

  $arr = [];

  $i = 0;
  foreach ($modal as $key => $value) {
    $serviceModal = (object) $value;

    if ($serviceType != 'membership' && $serviceType != 'package' && $serviceType != 'stock') {

      $holidaySql = "SELECT id FROM service_provider_holiday WHERE sp_id='" . $serviceModal->id . "' AND date='" . $appointmentDate . "'";
      $holidayQuery = mysqli_query($db, $holidaySql);
      $numHoliday = mysqli_num_rows($holidayQuery);

      $offWeekDaySql = "SELECT id FROM service_provider_off_week_day WHERE sp_id='" . $serviceModal->id . "' AND day='" . $dayName . "'";
      $offWeekDayQuery = mysqli_query($db, $offWeekDaySql);
      $numOffWeekDay = mysqli_num_rows($offWeekDayQuery);

      $assignServiceSql = "SELECT id FROM service_provider_assign_services WHERE sp_id='" . $serviceModal->id . "' AND s_id='" . $serviceIds . "'";
      $assignServiceQuery = mysqli_query($db, $assignServiceSql);
      $numAssignService = mysqli_num_rows($assignServiceQuery);

      $serviceSql = "SELECT id, duration FROM service WHERE id='" . $serviceIds . "' AND status=1";
      $serviceQuery = mysqli_query($db, $serviceSql);
      $serviceObj = mysqli_fetch_object($serviceQuery);
      $serviceEndTime = getOnlyTimeWithoutSecond($endTime, 'h');

      $serviceEndTime_24_format = date("H:i", strtotime($serviceEndTime));
      $working_hours_end_24_format  = date("H:i", strtotime($serviceModal->working_hours_end));

      if ($numHoliday == 1 || $numOffWeekDay == 1 || $numAssignService != 1 || ($serviceEndTime_24_format > $working_hours_end_24_format)) {
        continue;
      }
    }

    $arr[$i] = $value;
    $i++;
  }

  $newArr = [];

  foreach ($arr as $k => $val) {
    foreach ($val as $k1 => $v1) {
      if ($k1 == 'id' || $k1 == 'name') {
        $newArr[$k][$k1] = $v1;
      }
    }
  }


  return $newArr;
}

function js_redirect($url)
{
  return "<script> window.location = '{$url}'</script>";
}

function phpClientView($id)
{
  $html = "<script>
    document.addEventListener('DOMContentLoaded', function(event) {
      clientView({$id});
    });
    </script>
  ";

  echo $html;
}

function client_wallet_debit($db, $value, $bill_id, $type)
{

  $created_at = date('Y-m-d H:i:s', time());
  $transaction_type = 'Debit';

  if ($type == 'app') {
    $model = fetch_object($db, "SELECT * FROM `appointment` WHERE id='{$bill_id}'");
    $branch_id = $model->branch_id;
    $client_id = $model->client_id;
    $date = $model->appointment_date;
    $amount_receive_from = 'Appointment';
    $paid_amount = 0;
    $payment_method = 7;
    $amount = $value['advance'];

    $val = "'{$branch_id}', '{$client_id}', '{$bill_id}', '{$date}', '{$transaction_type}', '{$paid_amount}', '{$amount}', '{$payment_method}', '{$amount_receive_from}', '{$created_at}'";
  }

  if ($type == 'bill') {
    $model = fetch_object($db, "SELECT * FROM `client_billing` WHERE id='{$bill_id}'");
    $branch_id = $model->branch_id;
    $client_id = $model->client_id;
    $date = $model->billing_date;
    $amount_receive_from = 'Bill';
    $paid_amount = 0;
    $payment_method = 7;
    $amount = $value['advance'];

    $val = "'{$branch_id}', '{$client_id}', '{$bill_id}', '{$date}', '{$transaction_type}', '{$paid_amount}', '{$amount}', '{$payment_method}', '{$amount_receive_from}', '{$created_at}'";
  }

  $k = "`branch_id`, `client_id`, `bill_id`, `date`, `transaction_type`, `paid_amount`, `amount`, `payment_method`, `amount_receive_from`, `created_at`";
  $sql = "INSERT INTO `client_wallet` ({$k}) VALUES ({$val})";
  $query = mysqli_query($db, $sql);
  return $query ? true : false;
}

function addRewardPoint($db, $billing_id)
{
  $model = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$billing_id}'");

  $membershipModel = fetch_object($db, "SELECT * FROM membership WHERE id='{$model->membership_id}'");

  if (!empty($model) && $model->give_reward_point == 1) {

    $productModel = fetch_all($db, "SELECT * FROM client_billing_product WHERE billing_id='{$billing_id}'");

    $point = [];
    foreach ($productModel as $key => $val) {
      $value = (object) $val;

      $enquiryForModel = fetch_object($db, "SELECT * FROM {$value->service_type} WHERE id='{$value->service_id}'");

      $arrayField = [
        'service' => 'service_name',
        'membership' => 'membership_name',
        'package' => 'package_name',
        'stock' => 'product_id'
      ];

      $fieldName = $arrayField[$value->service_type];

      $rPoint = 0;

      if ($value->service_type == 'stock') {
        $productModel = fetch_object($db, "SELECT * FROM product WHERE id='{$enquiryForModel->$fieldName}'");
        $rPoint = $productModel->reward_point_on_purchase;
      }

      if ($value->service_type == 'membership') {
        $rPoint = $enquiryForModel->reward_point;
      }

      if ($value->service_type == 'service') {
        $rPoint = $enquiryForModel->reward_point;
      }

      $boostPoint = (!empty($membershipModel)) ? $membershipModel->reward_point_boost : 1;

      $point[] = ($rPoint * $boostPoint);
    }

    $points = array_sum($point);

    if (!empty($model->referral_code)) {
      $refferalModel = fetch_object($db, "SELECT * FROM `client_referral_code` WHERE referral_code='{$model->referral_code}'");
      $refferalClientModel = fetch_object($db, "SELECT * FROM `client_referral_code_use_history` WHERE `referral_code_id`='{$refferalModel->id}' AND `billing_id`='{$model->id}' AND `billing_rc_redeem`=0");

      if (!empty($refferalClientModel)) {
        $points = ($points + 100);
        mysqli_query($db, "UPDATE `client_referral_code_use_history` SET `billing_rc_redeem`=1 WHERE `id`='{$refferalClientModel->id}'");
      }
    } else {
      $refferalModel = fetch_object($db, "SELECT * FROM `client_referral_code` WHERE client_id='{$model->client_id}'");

      $referralCodeId = !empty($refferalModel) ? $refferalModel->id : 0;

      $refferalClientModel = fetch_object($db, "SELECT * FROM `client_referral_code_use_history` WHERE `referral_code_id`='{$referralCodeId}' AND `client_rc_redeem`=0 AND `billing_rc_redeem`=1");

      if (!empty($refferalClientModel)) {
        $points = ($points + 100);
        mysqli_query($db, "UPDATE `client_referral_code_use_history` SET `client_rc_redeem`=1 WHERE `id`='{$refferalClientModel->id}'");
      }
    }

    if (!empty($model->coupon_code)) {
      $couponModel = fetch_object($db, "SELECT * FROM `coupon` WHERE coupon_code='{$model->coupon_code}'");
      $points = ($points + $couponModel->reward_point);
    }

    $transaction_type = 'Credit';
    $created_at = date('Y-m-d H:i:s', time());

    $key = "`client_id`, `branch_id`, `date`, `app_bill_id`, `type`, `points`, `transaction_type`, `created_at`";
    $value = "'{$model->client_id}','{$model->branch_id}','{$model->billing_date}','{$model->id}','billing','{$points}','{$transaction_type}', '{$created_at}'";

    $rewardSql = "INSERT INTO `reward_point`({$key}) VALUES ({$value})";
    $rewardQuery = mysqli_query($db, $rewardSql);
  }
}


function subtractRewardPoint($db, $advance, $app_bill_id, $type)
{
  if ($type == 'app') {
    $model = fetch_object($db, "SELECT * FROM appointment WHERE id='{$app_bill_id}'");
    $app_type = 'appointment';
    $client_id = $model->client_id;
    $branch_id = $model->branch_id;
    $modelDate = $model->appointment_date;
  } else {
    $model = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$app_bill_id}'");
    $app_type = 'billing';
    $client_id = $model->client_id;
    $branch_id = $model->branch_id;
    $modelDate = $model->billing_date;
  }

  $points = $advance;
  $transaction_type = 'Debit';
  $created_at = date('Y-m-d H:i:s', time());

  $key = "`client_id`, `branch_id`, `date`, `app_bill_id`, `type`, `points`, `transaction_type`, `created_at`";
  $value = "'{$client_id}','{$branch_id}','{$modelDate}','{$app_bill_id}','{$app_type}','{$points}','{$transaction_type}', '{$created_at}'";

  $rewardSql = "INSERT INTO `reward_point`({$key}) VALUES ({$value})";
  $rewardQuery = mysqli_query($db, $rewardSql);
}

function get_salon_timing($db)
{
  $branch_id = BRANCHID;
  $start = '';
  $end = '';
  $dayName = strtolower(date('l'));
  $model = fetch_assoc($db, "SELECT * FROM `branch_working_day_hour`");
  $branchModel = fetch_object($db, "SELECT * FROM `branch` WHERE id='{$branch_id}'");
  $branch_working_hours_start = !empty($branchModel) ? $branchModel->working_hours_start : '10:00 AM';
  $branch_working_hours_end = !empty($branchModel) ? $branchModel->working_hours_end : '09:00 PM';

  $workingDay = $model[$dayName];

  if ($workingDay == 1) {
    $workingOpen = $model["{$dayName}_hour_open"];
    $workingClose = $model["{$dayName}_hour_close"];

    if (!empty($workingOpen)) {
      $start = $workingOpen;
    } else {
      $start = $branch_working_hours_start;
    }

    if (!empty($workingClose)) {
      $end = $workingClose;
    } else {
      $end = $branch_working_hours_end;
    }
  } else {
    $start = $branch_working_hours_start;
    $end = $branch_working_hours_start;
  }
  $arr = [
    'start' => $start,
    'end' => $end
  ];

  return $arr;
}

function addServiceProductPackageCommission($db, $billing_id = 0)
{
  $assignServiceProvider = fetch_all($db, "SELECT * FROM `client_billing_assign_service_provider` WHERE billing_id='{$billing_id}'");
  $billingModel = fetch_object($db, "SELECT * FROM `client_billing` WHERE `id`='{$billing_id}'");

  foreach ($assignServiceProvider as $assignServiceProviderKey => $assignServiceProviderVal) {
    $assignServiceProviderValue = (object) $assignServiceProviderVal;
    $billingProduct = fetch_object($db, "SELECT * FROM `client_billing_product` WHERE id='{$assignServiceProviderValue->billing_service_id}'");
    if ($billingProduct->service_type == 'membership') {
      continue;
    }
    $commission = get_service_provider_commission($db, $assignServiceProviderValue->service_provider_id, $billingProduct);
    $created_at = date('Y-m-d H:i:s', time());
    $key = "`service_provider_id`, `billing_id`, `date`, `price`, `service_id`, `service_type`, `commission`, `created_at`";
    $value = "'{$assignServiceProviderValue->service_provider_id}','{$billing_id}','{$billingModel->billing_date}','{$billingProduct->price}','{$billingProduct->service_id}','{$billingProduct->service_type}','{$commission}','{$created_at}'";
    $sql = "INSERT INTO `service_provider_commission_history`({$key}) VALUES ({$value})";
    mysqli_query($db, $sql);
  }
}


function get_tax_value($db, $tax, $price)
{
  $array = [
    'inclusive' => 0,
    'exclusive' => 0
  ];

  $inclusivePrice = 0;
  $exclusivePrice = 0;

  if (!empty($tax)) {

    $taxModel = fetch_object($db, "SELECT * FROM gst_slab WHERE id='{$tax}'");

    $taxType = $taxModel->tax_type;
    $gstPercentage = $taxModel->gst;

    if ($taxType == 'inclusive') {
      $inclusivePrice = (($price * $gstPercentage) / 100);
    }

    if ($taxType == 'exclusive') {
      $exclusivePrice = (($price * $gstPercentage) / 100);
    }

    $array = [
      'inclusive' => $inclusivePrice,
      'exclusive' => $exclusivePrice
    ];
  }

  return $array;
}


function getTotalPaymentMode($db, $billing_id, $method)
{
  $billingModel  = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$billing_id}'");
  $appointment_id = !empty($billingModel->appointment_id) ? $billingModel->appointment_id : 0;

  $model = fetch_object($db, "SELECT sum(advance) as advance FROM `client_billing_payment` WHERE `billing_id`='{$billing_id}' AND `method`='{$method}'");
  $model1 = fetch_object($db, "SELECT sum(advance) as advance FROM `appointment_advance_payment` WHERE `appointment_id`='{$appointment_id}' AND `method`='{$method}'");

  $advance = !empty($model->advance) ? $model->advance : 0;

  if (!empty($model1)) {
    $advance1 = !empty($model1->advance) ? $model1->advance : 0;

    $advance = ($advance + $advance1);
  }

  return $advance;
}


function displayDates($date1, $date2, $format = 'd-m-Y')
{
  $dates = [];

  $current = strtotime($date1);
  $date2 = strtotime($date2);
  $stepVal = '+1 day';
  while ($current <= $date2) {
    $dates[] = date($format, $current);
    $current = strtotime($stepVal, $current);
  }

  return $dates;
}


function getBillingReward_point($db, $billing_id)
{
  $point = 0;

  $model = fetch_object($db, "SELECT points FROM `reward_point` WHERE `app_bill_id`='{$billing_id}' AND `type`='billing' AND `transaction_type`='Credit'");
  $point = !empty($model) ? $model->points : $point;

  return $point;
}


function getPrevNextYearArr($currentYear)
{
  $years = [];

  for ($i = -5; $i <= 5; $i++) {
    $years[] = $currentYear + $i;
  }

  return $years;
}

function hoursFromTime($start_time, $end_time)
{
  $hours = 0;

  if (!empty($start_time) && !empty($end_time)) {

    $start_timestamp = strtotime($start_time);
    $end_timestamp = strtotime($end_time);

    $difference = $end_timestamp - $start_timestamp;

    $hours = $difference / 3600;
    $hours = round($hours);
  }

  return $hours;
}

function query_maker(array $sql, string $type = 'AND')
{
  $cond = 1;
  if (count($sql)) {
    $query = '';
    foreach ($sql as $key => $value) {
      $query .= ($value != 0) ? "`{$key}`='{$value}' {$type}" : '';
    }

    $cond = !empty($query) ? rtrim($query, $type) : $cond;
  }

  return $cond;
}

function sms_balance()
{
  $username = SMSUSERNAME;
  $password = SMSPASSWORD;

  $link = "http://bulksms.anksms.com/api/mt/GetBalance?User={$username}&Password={$password}";

  $url = $link;
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($curl);
  curl_close($curl);
  $response = json_decode($response);
  $response = explode('|', $response->Balance);
  $response1 = explode(':', $response[0]);
  $response2 = explode(':', $response[1]);
  $transactionalBal = !empty($response2[1]) ? $response2[1] : 0;
  $promotionalBal = !empty($response1[1]) ? $response1[1] : 0;

  $data = [
    'Promo' => $promotionalBal,
    'Trans' => $transactionalBal,
  ];

  return $data;
}

function add_client_referral($db, $billing_id)
{
  $model = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$billing_id}'");
  $refferalModel = fetch_object($db, "SELECT * FROM `client_referral_code` WHERE referral_code='{$model->referral_code}'");

  if ($model->client_id != $refferalModel->client_id) {
    $refferalClientModel = fetch_object($db, "SELECT * FROM `client_referral_code_use_history` WHERE `referral_code_id`='{$refferalModel->id}' AND `client_id`='{$model->client_id}'");
    $created_at = date('Y-m-d H:i:s', time());
    if (empty($refferalClientModel)) {
      $sql = "INSERT INTO `client_referral_code_use_history`
    (`branch_id`, `billing_id`, `client_id`, `referral_client_id`, `referral_code_id`, `referral_code`, `created_at`)  VALUES 
    ('{$model->branch_id}', '{$model->id}', '{$model->client_id}', '{$refferalModel->client_id}', '{$refferalModel->id}', '{$model->referral_code}', '{$created_at}')";
      mysqli_query($db, $sql);
    }
  }

  return true;
}


function add_coupon_code($db, $billing_id)
{
  $model = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$billing_id}'");
  $couponModel = fetch_object($db, "SELECT * FROM `coupon` WHERE coupon_code='{$model->coupon_code}'");
  /*
  $refferalClientModel = fetch_object($db, "SELECT * FROM `client_referral_code_use_history` WHERE `referral_code_id`='{$refferalModel->id}' AND `client_id`='{$model->client_id}'");
  
  if (empty($refferalClientModel)) {*/

  $created_at = date('Y-m-d H:i:s', time());
  $sql = "INSERT INTO `client_coupon_code_use_history`
  (`branch_id`, `billing_id`, `client_id`, `coupon_code_id`, `coupon_code`, `created_at`)  VALUES 
  ('{$model->branch_id}', '{$model->id}', '{$model->client_id}', '{$couponModel->id}', '{$model->coupon_code}', '{$created_at}')";
  mysqli_query($db, $sql);
  // /}


  return true;
}


function is_demo_version()
{
  $version = 'demo';
  //$version = 'live';

  $html = <<<HTML
    <div class="bg-warning text-center text-bold position-sticky py-1">
      <b>You are using Pixel Salon Software demo.</b>
    </div>
  HTML;

  return ($version == 'demo') ? $html : '';
}


function saveShortenerLink($db, $domain, $billing_id, $invoice_number, $type)
{
  $token = "b9b3cc3f3a30d8ef2bb1e2e267ed97de";

  // set post fields
  $post = [
    'domain' => $domain,
    'billing_id' => $billing_id,
    'invoice_number'   => $invoice_number,
    'type'   => $type,
    'token'   => $token,
  ];

  $ch = curl_init('http://pxsf.in/set-url.php');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

  // execute!
  $response = curl_exec($ch);

  // close the connection, release resources used
  curl_close($ch);

  $serverResponse = json_decode($response);

  // do anything you want with your response
  $key = !empty($serverResponse->data) ? $serverResponse->data : '';

  $created_at = date('Y-m-d H:i:s', time());
  $queryKey = "`billing_id`, `invoice_number`, `domain`, `link_type`, `shortener_key`, `created_at`";
  $queryValue = "'{$billing_id}', '{$invoice_number}', '{$domain}', '{$type}', '{$key}', '$created_at'";
  $sql = "INSERT INTO `link_shortener`({$queryKey}) VALUES ({$queryValue})";
  $query = mysqli_query($db, $sql);
}

/*
function add_wallet($db, $amount_receive_from, $model)
{
  extract($model);

  $transaction_type = "Credit";
  $created_at = date('Y-m-d H:i:s', time());
  $k = "`branch_id`, `client_id`, `date`, `transaction_type`, `paid_amount`, `amount`, `payment_method`, `amount_receive_from`, `notes`, `created_at`";
  $val = "'{$branch_id}', '{$client_id}', '{$date}', '{$transaction_type}', '{$paid_amount}', '{$amount}', '{$payment_method}', '{$amount_receive_from}', '{$notes}', '{$created_at}'";
  $sql = "INSERT INTO `client_wallet` ({$k}) VALUES ({$val})";

  $query = mysqli_query($db, $sql);
  return $query ? true : false;
}
*/

function rep_under_space($text)
{
  return str_replace('_', ' ', $text);
}

$alphabetsArr = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];



function check_excel_header($tableModel, $excelHeader)
{

  $tableHeader = [];
  foreach ($tableModel as $key => $value) {

    if ($key == 'id' || $key == 'created_by' || $key == 'updated_by' || $key == 'created_at' || $key == 'updated_at') {
      continue;
    }

    $tableHeader[] = $key;
  }

  $c = (count(array_diff($tableHeader, $excelHeader)));

  return $c == 0 ? true : false;
}
