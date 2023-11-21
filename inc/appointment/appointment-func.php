<?php
function getTodayAppointment($db){
    $todayDate = date('d/m/Y', time());
    $sql = "SELECT * FROM appointment WHERE appointment_date='".$todayDate."'";
    return num_rows($db, $sql);
}

?>