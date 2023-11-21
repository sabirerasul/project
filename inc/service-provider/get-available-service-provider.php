<?php
require_once "../../lib/db.php";
throw_exception();


extract($_REQUEST);

$branch_id = BRANCHID;

$newappointmentDate = explode('/', $appointmentDate);
$appointmentDate = $newappointmentDate[0] . "-" . $newappointmentDate[1] . "-" . $newappointmentDate[2];
$serverAppointmentDate = $newappointmentDate[2] . "-" . $newappointmentDate[1] . "-" . $newappointmentDate[0];

$dayName = date('l', strtotime($serverAppointmentDate));

$spSql = "SELECT id, CONCAT_WS(' - ', `name`, `username`) AS `name`, working_hours_start, working_hours_end FROM service_provider WHERE status = 1 AND branch_id='{$branch_id}'";
$modal = fetch_all($db, $spSql);

$arr = [];

$i = 0;
foreach ($modal as $key => $value) {
    $serviceModal = (object) $value;

    if ($serviceType != 'membership' && $serviceType != 'package' && $serviceType != 'stock') {
        $holidaySql = "SELECT `id` FROM `service_provider_holiday` WHERE `sp_id`='{$serviceModal->id}' AND date='{$appointmentDate}'";
        $holidayQuery = mysqli_query($db, $holidaySql);
        $numHoliday = mysqli_num_rows($holidayQuery);

        $offWeekDaySql = "SELECT `id` FROM `service_provider_off_week_day` WHERE `sp_id`='{$serviceModal->id}' AND day='{$dayName}'";
        $offWeekDayQuery = mysqli_query($db, $offWeekDaySql);
        $numOffWeekDay = mysqli_num_rows($offWeekDayQuery);

        $assignServiceSql = "SELECT `id` FROM `service_provider_assign_services` WHERE `sp_id`='{$serviceModal->id}' AND s_id='{$serviceIds}'";
        $assignServiceQuery = mysqli_query($db, $assignServiceSql);
        $numAssignService = mysqli_num_rows($assignServiceQuery);

        $serviceSql = "SELECT `id`, `duration` FROM service WHERE `id`='{$serviceIds}' AND `status`=1";
        $serviceQuery = mysqli_query($db, $serviceSql);
        $serviceObj = mysqli_fetch_object($serviceQuery);
        $serviceEndTime = getOnlyTimeWithoutSecond($endTime, 'h');

        $serviceEndTime_24_format = date("H:i", strtotime($serviceEndTime));
        $working_hours_end_24_format  = date("H:i", strtotime($serviceModal->working_hours_end));

        $timingCondition = ($serviceEndTime_24_format < $working_hours_end_24_format);
        $timingCondition = ($timingCondition) ? 1 : 0;

        if ($numHoliday == 1 || $numOffWeekDay == 1 || $numAssignService != 1 || $timingCondition != 1) {
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

$html = json_encode($newArr);
echo $html;
