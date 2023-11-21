<?php

function sendWhatsappMessage1()
{

  $username = "SEVATRUSTWA";
  $Password = "123456";
  //Getting form data
  $sender = 'WTSAPP';
  $number = '9453179080'; //$_POST['number'];

  //$message=$_POST['message'];
  $priority = 'wa';
  $stype = 'normal';
  //
  //$body = 'Thank You ' . $$regModel->aud_name . ' for registering for UP Health Summit 2022. Your registration is confirmed. Your registration ID is (' . $regModel->aud_reg_no . '). You will receive entry pass before 1st December 2022. Kindly carry your entry pass and a valid ID Card to be verified at the registration desk. You can collect your delegate kit from the registration counter. For Any queries write us at connect@uphealthsummit.com or WhatsApp at +91-9119878592.';
  $body = "Thank you for completing your registration for UP Health Summit 2022.
  Our Representative will Call you shortly On Your Registered Number";
  
  $message = urlencode($body);
  $var = "user=" . $username . "&pass=" . $Password . "&sender=" . $sender . "&phone=" . $number . "&text=" . $message . "&priority=" . $priority . "&stype=" . $stype . "";
  $link = "http://bhashsms.com/api/sendmsg.php?" . $var;

  //$link = "http://bhashsms.com/api/getsenderids.php?user=SEVATRUSTWA&pass=123456";

  //$link = "http://bhashsms.com/api/sendmsg.php?user=SEVATRUSTWA&pass=123456&sender=WTSAPP&phone=9125149648&text=Test SMS&priority=wa&stype=normal";
  $curl = curl_init($link);

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($curl);
  var_dump($response);
  die();
  curl_close($curl);
  return $response;
}


function sendWhatsappMessage2($db, $appointment_id)
{

  $username = WASMSUSERNAME;
  $password = WASMSPASSWORD;
  $sender = WASMSSENDERID;
  $link = WASMSURL;

  $appointmentModel = fetch_object($db, "SELECT * FROM appointment WHERE id='{$appointment_id}'");
  $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$appointmentModel->client_id}'");

  $name = $clientModel->client_name;
  $number = $clientModel->contact;
  $date = $appointmentModel->appointment_date;
  $time = $appointmentModel->appointment_time;
  $salon_name = SALONNAME;

  $priority = 'wa';
  $stype = 'normal';

  $message = urlencode("Thank You {$name}. Your Appointment is booked for {$date} {$time}. From {$salon_name}.");

  $var = "user={$username}&pass={$password}&sender={$sender}&phone={$number}&text={$message}&priority={$priority}&stype={$stype}";

  $url = $link . $var;


  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}
