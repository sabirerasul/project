<?php
date_default_timezone_set('Asia/Kolkata');

const DBHOST = "localhost";
const DBUSER = "root";
const DBPASSWORD = "";
const DBNAME = "salon_soft";

$db = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBNAME);

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

function getCFormatDate($date)
{
    $datetime = new DateTime($date);
    return $datetime->format('c');
}

$datetime = new DateTime('now');
$datetime_string = $datetime->format('c');

$serviceProviderSql1 = "SELECT id,name as title FROM service_provider WHERE status=1 ORDER by id DESC";
$serviceProviderModel1 = fetch_all($db, $serviceProviderSql1);


$serviceProviderIds = array_column($serviceProviderModel1, 'id');

$appointmentServiceModelArr = [];
$todayDate = date("d/m/Y");

$arrCount = 0;
foreach ($serviceProviderIds as $serviceProviderIdsKey => $serviceProviderIdsVal) {

    $appointmentServiceSql = "SELECT * FROM appointment_service WHERE sp_id='" . $serviceProviderIdsVal . "'";
    $appointmentServiceModel = fetch_all($db, $appointmentServiceSql);

    foreach ($appointmentServiceModel as $appointmentServiceKey => $appointmentServiceVal) {

        $appointmentServiceValue = (object) $appointmentServiceVal;



        $appointmentSql = "SELECT * FROM appointment WHERE id = '" . $appointmentServiceValue->appointment_id  . "' AND appointment_date='" . $todayDate . "'";
        if (num_rows($db, $appointmentSql) > 0) {

            $appointmentModel = fetch_object($db, $appointmentSql);

            $serviceModel = fetch_object($db, "SELECT * FROM service WHERE id='" . $appointmentServiceValue->service_id . "'");
            $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='" . $appointmentModel->client_id . "'");
            $serviceProviderModel = fetch_object($db, "SELECT * FROM service_provider WHERE id='" . $appointmentServiceValue->sp_id . "'");

            $appointmentClassName = ($appointmentModel->status == 'Billed') ? 'billed-appointment' : 'pending-appointment';
            //$appointmentColor = ($appointmentModel->status == 'Billed') ? 'green' : 'blue';
            $array = [
                'id' => $appointmentServiceValue->id,
                'resourceId' => $appointmentServiceValue->sp_id,
                'start' => getCFormatDate($appointmentServiceValue->start_timestamp),
                'end' => getCFormatDate($appointmentServiceValue->end_timestamp),
                'title' => $clientModel->client_name,
                //'color' => $appointmentColor,
                'beautician' => $serviceProviderModel->name,
                'className' => $appointmentClassName,
                'description' => $appointmentModel->notes,
                'service_name' => $serviceModel->label,
            ];

            $appointmentServiceModelArr[$arrCount] = $array;
            $arrCount++;
        }
    }
}


?>


<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8' />

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href='../lib/main.css' rel='stylesheet' />

    <style>
        .fc-time-grid-container {
            height: auto !important;
        }

        .fc-content {
            cursor: pointer;
        }

        .fc-today-button,
        .fc-axis,
        .fc-resourceTimeGridDay-button,
        .fc-resourceTimeGridWeek-button,
        .fc-resourceDayGridMonth-button {
            text-transform: capitalize;
        }

        .ui-autocomplete {
            z-index: 9999;
        }

        .pending-appointment {
            background-color: #ffeea9;
            border-color: #ffd52c;
            color: (--bs-primary);
        }

        .cancelled-appointment {
            background-color: #f97979;
            border-color: #ff4242;
            color: (--bs-danger);
        }

        .billed-appointment {
            background-color: #bef1be;
            border-color: #83e783;
            color: (--bs-success);
        }

        .checkedin-appointment {
            background-color: #d7c8ff;
            border-color: #ae9be1;
        }

        .fc-time-grid .fc-slats {
            /*z-index: 4;*/
            /*pointer-events: none;*/
        }

        .fc-resourceDayGridMonth-view .fc-widget-content,
        .fc-resourceDayGridMonth-view .fc-day-grid-container {
            height: auto !important;
            min-height: 8em !important;
        }

        .fc-time-grid .fc-event,
        .fc-time-grid .fc-bgevent {
            min-height: 15px;
        }

        .fc-resourceDayGridMonth-view .fc-day-grid-container {
            min-height: 600px !important;
        }

        .fc-view {
            overflow-x: auto;
        }


        .fc-scroller.fc-time-grid-container {
            overflow: initial !important;
        }

        .fc-axis {
            position: sticky;
            left: 0;
            background: white;
        }

        .popover {
            background: #fff;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .popover.top>.arrow:after {
            border-top-color: #ccc;
        }

        .fc-event,
        .fc-event:hover {
            color: #000 !important;
        }

        .fc-unthemed td.fc-today {
            background: #fff;
        }
    </style>
    </style>
    <script src='../lib/main.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                themeSystem: 'bootstrap5',
                height: '100%',
                aspectRatio: 1.8,
                initialView: 'resourceTimeGridDay',
                //initialDate: 'now',
                now: <?= json_encode($datetime_string) ?>,
                editable: false,
                selectable: true,
                dayMaxEvents: true, // allow "more" link when too many events
                dayMinWidth: 200,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'resourceTimeGridDay,resourceTimeGridWeek,dayGridMonth'
                },

                navLinks: true,
                nowIndicator: true,
                slotDuration: '00:15:00',

                //// uncomment this line to hide the all-day slot
                //allDaySlot: false,

                resources: <?= json_encode($serviceProviderModel1) ?>,
                events: <?= json_encode($appointmentServiceModelArr) ?>,
                /*
                select: function(arg) {
                    console.log(
                        'select',
                        arg.startStr,
                        arg.endStr,
                        arg.resource ? arg.resource.id : '(no resource)'
                    );
                },*/

                eventClick: function(calEvent) {
                    appointment(calEvent.event.id, calEvent.event.groupId);
                },

                eventRender: function(eventObj) {
                    var s = new Date(eventObj.event.start);
                    var e = new Date(eventObj.event.end);
                    $(eventObj.el).popover({
                        content: "<p style=\"color:#2d2e59;\"><b style=\"color:#2d2e59;\"> Client Name: </b>&nbsp;" +
                            eventObj.event.title +
                            "&nbsp;<br><b style=\"color:#2d2e59;\"> Appointment Date: </b>" + s
                            .getDate() + "-" + (s.getMonth() + 1) + "-" + s.getFullYear() +
                            "&nbsp;<br><b style=\"color:#2d2e59;\"> Provider Name: </b>" +
                            eventObj.event.extendedProps.beautician +
                            "&nbsp;<br><b style=\"color:#2d2e59;\"> Services: </b>" + eventObj
                            .event.extendedProps.service_name +
                            "&nbsp;<br><b style=\"color:#2d2e59;\"> Appointment Time: </b>" + s
                            .toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            }) + " To " + e.toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            }) + "&nbsp;<br><b style=\"color:#2d2e59;\"> Notes: </b>" + eventObj
                            .event.extendedProps.description + "&nbsp;<br></p>",
                        // content: eventObj.event.extendedProps.description,
                        html: true,
                        trigger: 'hover',
                        placement: 'top',
                        container: 'body'
                    });

                },
                // selectAllow: function(select) {
                //     return moment().diff(select.start) <= 0
                // },
                selectable: true,

                select: function(event) {

                    var provider_id = event.resource.id;
                    var start_time = event.startStr;
                    start_time = start_time.split('T');
                    var date = start_time[0];
                    start_time = date + " " + start_time[1].split('+')[0];
                    var end_time = event.endStr;
                    end_time = end_time.split('T');
                    end_time = date + " " + end_time[1].split('+')[0];
                    var curr_time = '22:07:17';

                    $('#book_appointment_modal').modal('show');
                    if (provider_id != '') {
                        $.ajax({
                            url: '../../../project/inc/appointment/appointment-stafftime.php',
                            type: "POST",
                            data: {
                                id: provider_id,
                                date: date,
                                time: curr_time,
                                starttime: start_time,
                                endtime: end_time
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                $('.loader-gif').show();
                            },
                            success: function(response) {
                                var ds = response;
                                if (ds['success'] == '0') {
                                    $('.staff').html('<option value="">--Select--</option><option selected value="' + ds['data']['pid'] + '">' + ds['data']['pname'] + '</option>');
                                    $('.start_time').val(ds['data']['start']);
                                    $('#book_appointment_modal').modal('show');
                                    $('#date').val(date);
                                    $('#time').val(ds['data']['start']);
                                    $('.loader-gif').hide();
                                } else if (ds['success'] == '1') {
                                    toastr.error(ds['data']['spcat'] + ' Unavailable.');
                                    calendar.render();
                                    set_calendar_width();
                                    $('.loader-gif').hide();
                                } else if (ds['success'] == '2') {
                                    toastr.error(ds['data']['spcat'] + ' Unavailable.');
                                    calendar.render();
                                    set_calendar_width();
                                    $('.loader-gif').hide();
                                }
                            }
                        });
                    }
                },
                dateClick: function(arg) {
                    console.log(
                        'dateClick',
                        arg.date,
                        arg.resource ? arg.resource.id : '(no resource)'
                    );
                }
            });

            calendar.render();
        });



        function appointment(inv, inv_id) {
            var row = $("#modal-body");
            row.find('.name').html('loading...');
            row.find('.service').html('loading...');
            row.find('.staff').html('loading...');
            $("#appointment_modal").modal('show');
            $.ajax({
                url: "../../../project/inc/appointment/get-appointment-details.php",
                data: {
                    inv: inv_id,
                    appointmentServiceId: inv
                },
                type: "POST",
                success: function(data) {
                    var row = $("#modal-body");
                    var ds = JSON.parse(data.trim());

                    row.find('.name').html(ds['client']);
                    row.find('.service').html(ds['service']);
                    row.find('.staff').html(ds['beautician']);
                    row.find('.spnotes').html(ds['notes']);
                    row.find('.apdate').html(ds['date']);
                    row.find('.aptime').html(ds['start_time'] + ' To ' + ds['end_time']);
                    row.find('#checkin_app_id').val(inv_id);
                    if (ds['checkin_status'] == 1) {
                        $('#checkin').hide();
                        $('#checkin_time').remove();
                        $('#modal-body tbody').append('<tr id="checkin_time"><th>Check In Time</th><td>' + ds['checkin_time'] + '</td></tr>');
                    } else {
                        $('#checkin').show();
                        $('#checkin_time').remove();
                    }
                    if (ds['bill_status'] == '1') {
                        $('#but').hide();
                        $('#bill_cancel').hide();
                        $('#checkin').hide();
                        // $('#bill').show();
                    } else if (ds['appointment_status'] == 'Cancelled') {
                        $('#bill_cancel').show();
                        $('#but').hide();
                        $('#checkin').hide();
                    } else {
                        // $('#bill').hide();
                        $('#but').show();
                        $('#bill_cancel').hide();
                        $('#edit_md_btn').attr('href', "appointment.php?id=" + inv_id);
                        $('#conv_md_btn').attr('href', "billing.php?bid=" + inv_id);
                    }
                },
                error: function() {},
            });
        }

        function appointmentedit(inv) {

            $("#but").html('loading...');
            jQuery.ajax({
                url: "ajax/invbuttons.php?inv=" + inv,
                type: "POST",
                success: function(data) {
                    $("#but").html(data);
                },
                error: function() {}
            });
        }

        function markCheckIn() {
            var app_id = $('#checkin_app_id').val();
            $.ajax({
                url: '../../../project/inc/appointment/appointment_stafftime.php',
                type: 'POST',
                data: {
                    action: 'mark_checkin',
                    app_id: app_id
                },
                dataType: 'JSON',
                success: function(res) {
                    if (res.status == 1) {
                        alert('Checked in successfully.');
                        window.location.reload();
                    } else {
                        alert('Error occured, please try again.');
                    }
                }
            });
        }
    </script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            font-size: 14px;
        }

        html,
        body {
            overflow: hidden;
        }


        #calendar-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .fc-header-toolbar {
            /*
    the calendar will be butting up against the edges,
    but let's scoot in the header's buttons
    */
            padding-top: 1em;
            padding-left: 1em;
            padding-right: 1em;
        }

        /*
        #calendar {
            max-width: 1100px;
            margin: 50px auto;
        }*/
    </style>
<link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
</head>

<body>

    <div id='calendar-container'>
        <div id='calendar'></div>
    </div>

</body>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

<script src="https://momentjs.com/downloads/moment.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

</html>



<!-- Modal -->
<div class="modal fade" id="appointment_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Appointment Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" id="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="150">Client Name</th>
                            <td class="name"></td>
                        </tr>
                        <tr>
                            <th>Appointment Date</th>
                            <td class="apdate"></td>
                        </tr>
                        <tr>
                            <th>Appointment Time</th>
                            <td class="aptime"></td>
                        </tr>
                        <tr>
                            <th>Service</th>
                            <td class="service"></td>
                        </tr>
                        <tr>
                            <th>Beautician Name</th>
                            <td class="staff"></td>
                        </tr>
                        <tr>
                            <th>Notes</th>
                            <td class="spnotes"></td>
                        </tr>
                    </table>
                    <input type="hidden" id="checkin_app_id" />
                </div>
            </div>
            <br>
            <div class="modal-footer">


                <div id="checkin">
                    <button type="button" onclick="markCheckIn()" class="btn btn-filter pull-left"><i class="fa fa-check" aria-hidden="true"></i>Check In</button>
                </div>
                <div id="but">
                    <a href="#" id="edit_md_btn"><button class="btn btn-warning" type="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</button></a>
                    <a href="#" id="conv_md_btn"><button class="btn btn-success" type="button"><i class="fa fa-money" aria-hidden="true"></i>Generate bill</button></a>
                </div>
                <div id="bill">
                    <!--<a href="#" id="app_billed"><button class="btn btn-success"  type="button"><i class="fa fa-money" aria-hidden="true"></i>Bill paid</button></a>-->
                </div>
                <div id="bill_cancel" style="display:none;">
                    <button class="btn btn-danger" type="button">Cancelled</button>
                </div>

                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>









<div class="modal fade" id="book_appointment_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form action="" id="dash_app" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel1">Appointment Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="book-app-modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Client name <span class="text-danger">*</span></label>
                                    <input type="text" class="client form-control client_name" id="client" name="client" placeholder="Autocomplete (Phone)" value="" required>
                                    <input type="hidden" name="clientid" id="clientid" value="" class="clt">
                                    <input type="hidden" name="client_branch_id" id="client_branch_id" value="" class="clt">
                                </div>
                                <div class="col-md-3">
                                    <label>Contact number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control client" value="" onBlur="check();contact_no_length($(this), this.value);" id="cont" name="cont" placeholder="Client contact" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" maxLength="10" required>
                                    <span style="color:red" id="client-status"></span>
                                    <span style="color:red" id="digit_error"></span>
                                </div>
                                <div class="col-md-3">
                                    <label>Appointment date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="date" name="doa" required readonly />
                                    <span class="text-danger" id="dateerror"></span>
                                </div>
                                <div class="col-md-3">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <select class="form-control" name="gender" required id="gender">
                                        <option value="">--Select--</option>
                                        <option id="gn-1" value="1">Male</option>
                                        <option id="gn-2" value="2">Female</option>
                                    </select>
                                </div>
                                <div class="clearfix"></div><br />
                                <div class="col-md-12">
                                    <table class="table table-bordered" style="margin-bottom:10px;">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Select service</th>
                                                <!--<th>Discount</th>-->
                                                <th>Artisan</th>
                                                <th>Start & end time</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="TextBoxContainer" class="TextBoxContainer">
                                                <td style="vertical-align: middle"><span class="sno"><span class="icon-dots-three-vertical"></span></span></td>
                                                <td width="450"><input type="text" class="ser form-control slot" name="services[]" value="" placeholder="Service (Autocomplete)" required>
                                                    <input type="hidden" name="service[]" value="" class="serr">
                                                    <input type="hidden" name="durr[]" value="" class="durr">
                                                    <input type="hidden" name="pa_ser[]" value="" class="pa_ser">
                                                </td>
                                                <td class="spr_row" width="250">
                                                    <table id="add_row" style="width:100%" class="inner-table-space">
                                                        <tbody>
                                                            <tr>
                                                                <td width="100%" id="select_row">
                                                                    <select name="staffid0[]" data-validation="required" class="form-control staff" required>
                                                                        <option value="">Artisan</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <input type="hidden" name="duration[]" value="" class="duration">
                                                <input type="hidden" name="ser_stime[]" value="" class="ser_stime">
                                                <input type="hidden" name="ser_etime[]" value="" class="ser_etime">
                                                <td>
                                                    <table class="inner-table-space">
                                                        <tr>
                                                            <td width="50%">
                                                                <input type="text" class="form-control start_time time" value="" placeholder="Start time" name="start_time[]" onchange="servicestarttime(this.value, $(this))" readonly>
                                                            </td>
                                                            <td width="50%">
                                                                <input type="text" class="form-control end_time" name="end_time[]" value="" placeholder="End time" readonly>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td>
                                                    <input type="number" readonly class="pr form-control price positivenumber decimalnumber" step="0.01" name="price[]" id="userName" placeholder="9800.00">
                                                    <input type="hidden" class="prr">
                                                </td>
                                            </tr>
                                            <tr id="addBefore"></tr>
                                        </tbody>
                                    </table>
                                    <div class="total-amount" style="text-align:right; font-weight: 600; margin-bottom: 10px;">
                                        <p>Total amount : <span>0.00</span></p>
                                    </div>
                                    <button type="button" id="btnAdd" class="btn btn-info pull-right"><i class="fa fa-plus" aria-hidden="true"></i>Add service</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="modal-footer">
                    <div>
                        <input type="hidden" id="date" />
                        <input type="hidden" id="time" name="time" />
                        <input type="hidden" id="total" name="total_amount" />
                        <input type="text" class="hidden" id="close_time" value="21:00:00">
                        <button class="btn btn-success" name="submit" type="submit"><i class="fa fa-calendar-check-o" aria-hidden="true"></i>Book appointment</button>
                        <button class="btn btn-danger" data-dismiss="modal" type="button" onclick="$('#dash_app')[0].reset();"><i class="fa fa-times" aria-hidden="true"></i>Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>