<?php
require_once "lib/db.php";
check_auth();

$serviceProviderArr = fetch_all($db, "SELECT `id`, `name` FROM `service_provider` WHERE `status`=1 ORDER by name ASC");
$staffArr = fetch_all($db, "SELECT `id`, `name` FROM `employee` WHERE `status`=1 ORDER by name ASC");

$monthArr = [
    "01" => "January",
    "02" => "February",
    "03" => "March",
    "04" => "April",
    "05" => "May",
    "06" => "June",
    "07" => "July",
    "08" => "August",
    "09" => "September",
    "10" => "October",
    "11" => "November",
    "12" => "December"
];

$employeeTypeArr = [
    "1" => "Service Provider",
    "2" => "Staff",
];

$currentYear = date('Y');
$currentMonth = date('m');

$yearArr = getPrevNextYearArr($currentYear);

if ($_REQUEST) {
    $employee_type = $_REQUEST['employee_type'];
    $provider = $_REQUEST['provider'];
    $month = $_REQUEST['month'];
    $year = $_REQUEST['year'];

    $currentMonth = $month;
    $currentYear  = $year;
} else {

    $employee_type = 1;
    $provider = !empty($serviceProviderArr[0]['id']) ? $serviceProviderArr[0]['id'] : 0;
    $month = $currentMonth;
    $year = $currentYear;
}

$providerArr = ($employee_type == 1) ? $serviceProviderArr : $staffArr;
$employee_type_text = ($employee_type == 1) ? 'service_provider' : 'staff';


$startDate = getDateServerFormat("01/{$month}/{$year}");
$last_date_find = strtotime(date("Y-m-d", strtotime($startDate)) . ", last day of this month");
$endDate = date("Y-m-d", $last_date_find);

$dateArray = displayDates($startDate, $endDate, 'Y-m-d');


$attendanceModel = fetch_all($db, "SELECT * FROM `attendance` WHERE employee_type='{$employee_type_text}' AND employee_id='{$provider}'");

$attendanceArray = [];
$attendanceArrayTable = [];
foreach ($attendanceModel as $attendanceKey => $attendanceVal) {

    $attendanceValue = (object) $attendanceVal;

    $hoursFromTime = hoursFromTime(time_24($attendanceValue->check_in_time), time_24($attendanceValue->check_out_time));

    if ($startDate > getDateServerFormat($attendanceValue->date)) {
        continue;
    }

    if ($endDate < getDateServerFormat($attendanceValue->date)) {
        continue;
    }

    if ($attendanceValue->status == 1) {

        $attendanceArray[] = [
            'date' => getDateServerFormat($attendanceValue->date),
            'eventName' => 'Present',
            'className' => 'badge bg-success',
            'dateColor' => 'green'
        ];
        $attendanceArray[] = [
            'date' => getDateServerFormat($attendanceValue->date),
            'eventName' => "In: {$attendanceValue->check_in_time}",
            'className' => 'badge bg-success',
            'dateColor' => 'green'
        ];

        $attendanceArray[] = [
            'date' => getDateServerFormat($attendanceValue->date),
            'eventName' => "Out: {$attendanceValue->check_out_time}",
            'className' => 'badge bg-success',
            'dateColor' => 'green'
        ];
        $attendanceArray[] = [
            'date' => getDateServerFormat($attendanceValue->date),
            'eventName' => "Hrs: {$hoursFromTime}",
            'className' => 'badge bg-success',
            'dateColor' => 'green'
        ];

        $attendanceArrayTable[] = [
            'date' => getDateServerFormat($attendanceValue->date),
            'checkin' => $attendanceValue->check_in_time,
            'checkout' => $attendanceValue->check_out_time,
            'hrs' => "{$hoursFromTime}",
            'status' => "present",
        ];
    } else {
        $attendanceArray[] = [
            'date' => getDateServerFormat($attendanceValue->date),
            'eventName' => 'Absent',
            'className' => 'badge bg-danger',
            'dateColor' => 'red'
        ];
        $attendanceArray[] = [
            'date' => getDateServerFormat($attendanceValue->date),
            'eventName' => 'In: 0',
            'className' => 'badge bg-danger',
            'dateColor' => 'red'
        ];
        $attendanceArray[] = [
            'date' => getDateServerFormat($attendanceValue->date),
            'eventName' => 'Out: 0',
            'className' => 'badge bg-danger',
            'dateColor' => 'red'
        ];
        $attendanceArray[] = [
            'date' => getDateServerFormat($attendanceValue->date),
            'eventName' => 'Hrs: 0',
            'className' => 'badge bg-danger',
            'dateColor' => 'red'
        ];

        $attendanceArrayTable[] = [
            'date' => getDateServerFormat($attendanceValue->date),
            'checkin' => "0",
            'checkout' => "0",
            'hrs' => "0",
            'status' => "absent",
        ];
    }
}






$attendanceModel2 = fetch_all($db, "SELECT * FROM `attendance` WHERE employee_type='{$employee_type_text}'");
$attendanceArrayTable2 = [];
foreach ($attendanceModel2 as $attendanceKey2 => $attendanceVal2) {

    $attendanceValue2 = (object) $attendanceVal2;

    $hoursFromTime = hoursFromTime(time_24($attendanceValue2->check_in_time), time_24($attendanceValue2->check_out_time));

    if ($startDate > getDateServerFormat($attendanceValue2->date)) {
        continue;
    }

    if ($endDate < getDateServerFormat($attendanceValue2->date)) {
        continue;
    }

    if ($attendanceValue2->status == 1) {

        $attendanceArrayTable2[] = [
            'date' => getDateServerFormat($attendanceValue2->date),
            'checkin' => $attendanceValue2->check_in_time,
            'checkout' => $attendanceValue2->check_out_time,
            'hrs' => "{$hoursFromTime}",
            'status' => "present",
            'id' => $attendanceValue2->employee_id,
        ];
    } else {

        $attendanceArrayTable2[] = [
            'date' => getDateServerFormat($attendanceValue2->date),
            'checkin' => "0",
            'checkout' => "0",
            'hrs' => "0",
            'status' => "absent",
            'id' => $attendanceValue2->employee_id,
        ];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Attendance Report - <?= SALONNAME ?></title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="./css/site.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link rel="stylesheet" href="./css/datepicker.min.css">



    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./css/pages/attendance-report.css">
    <link rel="stylesheet" href="./css/calendar-gc.min.css">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include('./comman/nav.php') ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">



                        <div class="col-md-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <div class="d-flex justify-content-between">
                                        <h6>Attendance Report</h6>
                                    </div>

                                    <hr>

                                    <div>
                                        <form action="" method="POST" id="filterEnquiry">

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="employee_type" class="employee_type_label required">Employee Type</label>
                                                        <select class="form-select employee_type" name="employee_type" id="employee_type" onchange="changeProviderType(this)">
                                                            <?php foreach ($employeeTypeArr as $employeeTypeArrKey => $employeeTypeArrValue) { ?>
                                                                <option value="<?= $employeeTypeArrKey ?>" <?= $employee_type == $employeeTypeArrKey ? 'selected' : '' ?>><?= $employeeTypeArrValue ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="provider">Select</label>
                                                        <select class="form-select provider" name="provider" id="provider" onchange="setEmployeeName()">
                                                            <?php foreach ($providerArr as $serviceProviderArrKey => $serviceProviderArrValue) { ?>
                                                                <option value="<?= $serviceProviderArrValue['id'] ?>" <?= ($provider == $serviceProviderArrValue['id']) ? 'selected' : '' ?>><?= $serviceProviderArrValue['name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="month">Month</label>
                                                        <select class="form-select month" name="month" id="month">
                                                            <?php foreach ($monthArr as $monthArrKey => $monthArrValue) { ?>
                                                                <option value="<?= $monthArrKey ?>" <?= ($monthArrKey == $currentMonth) ? 'selected' : '' ?>><?= $monthArrValue ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="year">Year</label>
                                                        <select class="form-select year" name="year" id="year">
                                                            <?php foreach ($yearArr as $yearArrKey => $yearArrValue) { ?>
                                                                <option value="<?= $yearArrValue ?>" <?= ($yearArrValue == $currentYear ? 'selected' : '') ?>><?= $yearArrValue ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="form-group">
                                                            <label>&nbsp;</label>
                                                            <button type="submit" name="filter" value="mfilter" class="btn btn-filter btn-block btn-primary"><i class="fa fa-filter" aria-hidden="true"></i> Apply </button>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>&nbsp;</label>
                                                            <a href="attendance-report.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="employee_name"></h6>
                                        <div class="btn btn-warning" onclick="ExportToExcel('xlsx')">Export</div>
                                    </div>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table id="table-dash" class="table table-striped table-bordered mb-0">
                                            <tbody>
                                                <tr>
                                                    <td>Day</td>
                                                    <?php
                                                    foreach ($dateArray as $dateKey => $dateValue) {
                                                        echo "<td>" . explode('-', $dateValue)[2] . "</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>In</td>
                                                    <?php
                                                    foreach ($dateArray as $dateKey => $dateValue) {
                                                        $match = 0;
                                                        foreach ($attendanceArrayTable as $attendanceArrayTableKey => $attendanceArrayTableValue) {

                                                            if ($dateValue == $attendanceArrayTableValue['date']) {
                                                                $match = 1;
                                                                echo "<td>" . $attendanceArrayTableValue['checkin'] . "</td>";
                                                            }
                                                        }

                                                        if ($match == 0) {
                                                            echo "<td></td>";
                                                        }
                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>Out</td>
                                                    <?php
                                                    foreach ($dateArray as $dateKey => $dateValue) {
                                                        $match = 0;
                                                        foreach ($attendanceArrayTable as $attendanceArrayTableKey => $attendanceArrayTableValue) {
                                                            if ($dateValue == $attendanceArrayTableValue['date']) {
                                                                $match = 1;
                                                                echo "<td>" . $attendanceArrayTableValue['checkout'] . "</td>";
                                                            }
                                                        }
                                                        if ($match == 0) {
                                                            echo "<td></td>";
                                                        }
                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>Total Hrs</td>
                                                    <?php
                                                    foreach ($dateArray as $dateKey => $dateValue) {
                                                        $match = 0;
                                                        foreach ($attendanceArrayTable as $attendanceArrayTableKey => $attendanceArrayTableValue) {
                                                            if ($dateValue == $attendanceArrayTableValue['date']) {
                                                                $match = 1;
                                                                echo "<td>" . $attendanceArrayTableValue['hrs'] . "</td>";
                                                            }
                                                        }
                                                        if ($match == 0) {
                                                            echo "<td></td>";
                                                        }
                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>Status</td>
                                                    <?php
                                                    foreach ($dateArray as $dateKey => $dateValue) {
                                                        $match = 0;
                                                        foreach ($attendanceArrayTable as $attendanceArrayTableKey => $attendanceArrayTableValue) {
                                                            if ($dateValue == $attendanceArrayTableValue['date']) {
                                                                $match = 1;
                                                                echo "<td>" . ucfirst($attendanceArrayTableValue['status']) . "</td>";
                                                            }
                                                        }
                                                        if ($match == 0) {
                                                            echo "<td></td>";
                                                        }
                                                    }
                                                    ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <div class="d-flex justify-content-between">
                                        <h6>Monthly Attendance Data of Service Provider/Staff</h6>
                                        <div class="btn btn-warning" onclick="ExportToExcel2('xlsx')">Export</div>
                                    </div>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table id="full_attendance" class="table table-bordered mb-0">

                                            <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <?php
                                                    foreach ($dateArray as $dateKey => $dateValue) {
                                                        echo "<th>" . explode('-', $dateValue)[2] . "</th>";
                                                    }
                                                    ?>
                                                    <th>Total Hrs</th>
                                                </tr>

                                                <?php

                                                foreach ($providerArr as $providerKey => $providerVal) {
                                                    echo "<tr>
                                                        <td>
                                                        <p class='m-0 text-nowrap'><b>" . strtoupper($providerVal['name']) . "</b></p>
                                                        <p class='m-0 text-nowrap'>In Time</p>
                                                        <p class='m-0 text-nowrap'>Out Time</p>
                                                        <p>Total Hrs</p>
                                                        </td>
                                                        ";

                                                    $totalHrs = [0];
                                                    foreach ($dateArray as $dateKey2 => $dateValue2) {
                                                        $match = 0;
                                                        foreach ($attendanceArrayTable2 as $attendanceArrayTableKey2 => $attendanceArrayTableValue2) {

                                                            if ($dateValue2 == $attendanceArrayTableValue2['date'] && $attendanceArrayTableValue2['id'] == $providerVal['id']) {
                                                                $match = 1;

                                                                if ($attendanceArrayTableValue2['status'] == 'absent') {
                                                                    echo "<td>
                                                                    <p class='m-0 text-nowrap'><b>" . ucfirst($attendanceArrayTableValue2['status']) . "</b></p>";
                                                                    echo "</td>";
                                                                } else {
                                                                    echo "<td>
                                                                    <p class='m-0 text-nowrap'><b>" . ucfirst($attendanceArrayTableValue2['status']) . "</b></p>";
                                                                    echo "<p class='m-0 text-nowrap'>" . $attendanceArrayTableValue2['checkin'] . "</p>";
                                                                    echo "<p class='m-0 text-nowrap'>" . $attendanceArrayTableValue2['checkout'] . "</p>";
                                                                    echo "<p class='m-0 text-nowrap'>" . $attendanceArrayTableValue2['hrs'] . "</p></td>";
                                                                }
                                                                $totalHrs[] = $attendanceArrayTableValue2['hrs'];
                                                            }
                                                        }

                                                        if ($match == 0) {
                                                            echo "<td></td>";
                                                        }
                                                    }

                                                    echo "<td><b>" . array_sum($totalHrs) . "</b></td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->


                <!-- Footer -->
                <?php include('./comman/footer.php'); ?>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
        <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
        <script src="./js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>


        <script type="text/javascript" src="./js/toastify-js.js"></script>

        <script type="text/javascript" src="./js/sweetalert2@11.js"></script>

        <script type="text/javascript" src="./js/main.js"></script>
        <script type="text/javascript" src="./js/datepicker.min.js"></script>

        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>

        <script src="./js/calendar-gc.min.js"></script>

        <script type="text/javascript" src="./js/pages/attendance-report.js"></script>

        <script>
            $(function(e) {
                var calendar = $("#calendar").calendarGC({
                    dayBegin: 0,
                    prevIcon: '&#x3c;',
                    nextIcon: '&#x3e;',
                    onPrevMonth: function(e) {
                        console.log("prev");
                        console.log(e);
                    },
                    onNextMonth: function(e) {
                        console.log("next");
                        console.log(e);
                    },
                    events: getHoliday(),
                    onclickDate: function(e, data) {
                        console.log(e, data);
                    }
                });
            });

            function getHoliday() {
                var d = new Date();
                var totalDay = new Date(d.getFullYear(), d.getMonth(), 0).getDate();
                var events = [];

                var serverEvents = <?= json_encode($attendanceArray) ?>

                for (let i = 0; i < serverEvents.length; i++) {
                    serverEvents[i]['date'] = new Date(serverEvents[i]['date'])
                }

                var events = serverEvents

                return events;
            }


            getHoliday();
        </script>


        <?php include('./comman/loading.php'); ?>
</body>

</html>



<select class="d-none" id="service_provider_array">
    <?php foreach ($serviceProviderArr as $serviceProviderArrKey => $serviceProviderArrValue) { ?>
        <option value="<?= $serviceProviderArrValue['id'] ?>"><?= $serviceProviderArrValue['name'] ?></option>
    <?php } ?>
</select>

<select class="d-none" id="staff_array">
    <?php foreach ($staffArr as $staffArrKey => $staffArrValue) { ?>
        <option value="<?= $staffArrValue['id'] ?>"><?= $staffArrValue['name'] ?></option>
    <?php } ?>
</select>