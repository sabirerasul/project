<?php
require('./lib/db.php');

if (isset($_SESSION['setup_site'])) {
	unlink('install.php');
	session_destroy();
}

if (isset($_GET['accessToken'])) {
	$token = mysqli_real_escape_string($db, $_GET['accessToken']);
	is_automate_auth($db, $token);
}

check_auth();

$todayDate = date("d/m/Y");

$datetime = new DateTime('now');
$datetime_string = $datetime->format('c');

$branch_id = BRANCHID;

$serviceProviderSql1 = "SELECT id, CONCAT_WS(' - ', `name`, `username`) AS `title` FROM service_provider WHERE status=1 AND branch_id='{$branch_id}' ORDER by id DESC";
$serviceProviderModel1 = fetch_all($db, $serviceProviderSql1);


$serviceProviderIds = array_column($serviceProviderModel1, 'id');

$appointmentServiceModelArr = [];

$arrCount = 0;
foreach ($serviceProviderIds as $serviceProviderIdsKey => $serviceProviderIdsVal) {

	$appointmentAssignSPModel = fetch_all($db, "SELECT appointment_service_id FROM appointment_assign_service_provider WHERE service_provider_id='{$serviceProviderIdsVal}' ");
	$appointmentAssignSPIds = array_column($appointmentAssignSPModel, 'appointment_service_id');
	$appointmentAssignSPIds = implode(",", $appointmentAssignSPIds);

	$appointmentAssignSPIds = !empty($appointmentAssignSPIds) ? $appointmentAssignSPIds : 0;

	$appointmentServiceSql = "SELECT * FROM appointment_service WHERE id IN ({$appointmentAssignSPIds})";
	$appointmentServiceModel = fetch_all($db, $appointmentServiceSql);

	foreach ($appointmentServiceModel as $appointmentServiceKey => $appointmentServiceVal) {

		$appointmentServiceValue = (object) $appointmentServiceVal;

		//get today appointment
		//$appointmentSql = "SELECT * FROM appointment WHERE id = '" . $appointmentServiceValue->appointment_id  . "' AND appointment_date='" . $todayDate . "'";

		//get all appointment
		$appointmentSql = "SELECT * FROM appointment WHERE id = '{$appointmentServiceValue->appointment_id}' AND branch_id='{$branch_id}'";
		if (num_rows($db, $appointmentSql) > 0) {

			$appointmentModel = fetch_object($db, $appointmentSql);

			$serviceModel = fetch_object($db, "SELECT * FROM service WHERE id='" . $appointmentServiceValue->service_id . "'");
			$clientModel = fetch_object($db, "SELECT * FROM client WHERE id='" . $appointmentModel->client_id . "'");
			$serviceProviderModel = fetch_object($db, "SELECT * FROM service_provider WHERE id='" . $serviceProviderIdsVal . "'");

			$appointmentClassName = '';

			if ($appointmentModel->status == 'Billed') {
				$appointmentClassName = 'billed-appointment';
			}

			if ($appointmentModel->status == 'Pending') {
				$appointmentClassName = 'pending-appointment';
			}

			if ($appointmentModel->status == 'Cancelled') {
				$appointmentClassName = 'cancelled-appointment';
			}

			if ($appointmentModel->status == 'Checkedin') {
				$appointmentClassName = 'checkedin-appointment';
			}
			//$appointmentColor = ($appointmentModel->status == 'Billed') ? 'green' : 'blue';
			$array = [
				'id' => $appointmentServiceValue->id,
				//'resourceId' => $appointmentServiceValue->sp_id,
				'resourceId' => $serviceProviderIdsVal,
				'start' => getCFormatDate($appointmentServiceValue->start_timestamp),
				'end' => getCFormatDate($appointmentServiceValue->end_timestamp),
				'title' => $clientModel->client_name,
				//'color' => $appointmentColor,
				'beautician' => $serviceProviderModel->name,
				'className' => $appointmentClassName,
				'description' => $appointmentModel->notes,
				'service_name' => $serviceModel->service_name,
			];

			$appointmentServiceModelArr[$arrCount] = $array;
			$arrCount++;
		}
	}
}



$salonTiming = get_salon_timing($db);

$salonStart = time_24($salonTiming['start']);
$salonEnd = time_24($salonTiming['end']);


?>
<!DOCTYPE html>
<html lang="en">

<head>

	<title>Dashboard - <?= SALONNAME ?></title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Custom fonts for this template-->
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="./css/site.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="./css/sb-admin-2.min.css" rel="stylesheet">

	<!-- CSS only -->
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

	<link href="./css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

	<link href='./css/calendar/main.css' rel='stylesheet' />

	<link rel="stylesheet" href="./css/datepicker.min.css">
	<link rel="stylesheet" href="./css/pages/index.css">

	<link rel="stylesheet" href="./css/bootstrap-datetimepicker.css">
	<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.css" type="text/css" rel="stylesheet" />

	<link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">

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
					<!-- Content Row -->
					<div class="row">

						<!-- Earnings (Monthly) Card Example -->
						<div class="col-xl-3 col-md-6 mb-4">
							<a href="./index-sale.php" class="d-block text-decoration-none">
								<div class="card border-success bg-gradient-success shadow h-100 py-2 px-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-sm font-weight-bold text-white text-uppercase mb-2">Today Sales</div>
												<div class="h4 mb-0 font-weight-bold text-white">INR <?= get_today_sale($db) ?></div>
											</div>
											<div class="col-auto">
												<i class="fas fa-credit-card fa-2x text-gray-300"></i>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>

						<!-- Earnings (Monthly) Card Example -->
						<div class="col-xl-3 col-md-6 mb-4">
							<a href="./index-appointment.php" class="d-block text-decoration-none">
								<div class="card border-info bg-gradient-info shadow h-100 py-2 px-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-sm font-weight-bold text-white text-uppercase mb-2">Today Appointments</div>
												<div class="h4 mb-0 font-weight-bold text-white"><?= get_today_appointment($db) ?></div>
											</div>
											<div class="col-auto">
												<i class="fas fa-phone fa-2x text-gray-300"></i>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>

						<div class="col-xl-3 col-md-6 mb-4">
							<a href="./index-enquiry.php" class="d-block text-decoration-none">
								<div class="card border-danger bg-gradient-danger shadow h-100 py-2 px-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-sm font-weight-bold text-white text-uppercase mb-2">Today Enquiry</div>
												<div class="h4 mb-0 font-weight-bold text-white"><?= get_today_enquiry($db) ?></div>
											</div>
											<div class="col-auto">
												<i class="fas fa-user-plus fa-2x text-gray-300"></i>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>

						<div class="col-xl-3 col-md-6 mb-4">
							<a href="./index-visit.php" class="d-block text-decoration-none">
								<div class="card border-warning bg-gradient-warning shadow h-100 py-2 px-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-sm font-weight-bold text-white text-uppercase mb-2">Clients Visit</div>
												<div class="h4 mb-0 font-weight-bold text-white"><?= get_today_client_visit($db) ?></div>
											</div>
											<div class="col-auto">
												<i class="fas fa-smile fa-2x text-gray-300"></i>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-12">
							<div class="color-code-indecation">
								<ul class="text-right mb-0">
									<li style="display:inline-block;margin-right:10px;"><span class="pending-appointment" style="height:11px;width:11px;display:inline-block;"></span> Pending</li>
									<li style="display:inline-block;margin-right:10px;"><span class="checkedin-appointment" style="height:11px;width:11px;display:inline-block;"></span> Checked In</li>
									<li style="display:inline-block;margin-right:10px;"><span class="billed-appointment" style="height:11px;width:11px;display:inline-block;"></span> Billed</li>
									<li style="display:inline-block;margin-right:10px;"><span class="cancelled-appointment" style="height:11px;width:11px;display:inline-block;"></span> Cancelled</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- /.container-fluid -->

				<div class="container-fluid">
					<div id='calendar-container'>
						<div id='calendar'></div>
					</div>
				</div>

			</div>
			<!-- End of Main Content -->

			<!-- Footer -->
			<?php include('./comman/footer.php') ?>
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



	<!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

	<script src="./js/bootstrap.bundle.min.js">
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.js" type="text/javascript"></script>

	<!-- Core plugin JavaScript-->
	<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="js/sb-admin-2.min.js"></script>
	<script src="vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

	<script type="text/javascript" src="./js/toastify-js.js"></script>
	<script type="text/javascript" src="./js/sweetalert2@11.js"></script>

	<script type="text/javascript" src="./js/main.js"></script>

	<script type="text/javascript" src="./js/datepicker.min.js"></script>
	<script src="./js/bootstrap-datetimepicker.min.js"></script>


	<script src='./js/calendar/main.js'></script>

	<script type="text/javascript" src="./js/pages/index.js"></script>
	<script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');

			var calendar = new FullCalendar.Calendar(calendarEl, {
				schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
				themeSystem: 'bootstrap5',
				height: '100%',
				loading: function(isLoading, view) {
					if (isLoading) {
						instanceLoading.showLoading({
							type: 'cube_flip',
							color: '#ffffff',
							backgroundColor: '#025043',
							title: 'Loading...',
							fontSize: 16,
						});
					} else {
						instanceLoading.hideLoading()
					}
				},
				aspectRatio: 1.8,
				initialView: 'resourceTimeGridDay',
				slotMinTime: '<?= $salonStart ?>',
				slotMaxTime: '<?= $salonEnd ?>',
				businessHours: {
					// days of week. an array of zero-based day of week integers (0=Sunday)
					daysOfWeek: [1, 2, 3, 4, 5, 6, 7], // Monday - Thursday

					startTime: '<?= $salonStart ?>', // a start time (10am in this example)
					endTime: '<?= $salonEnd ?>', // an end time (6pm in this example)
				},
				expandRows: true,
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
				},*/

				eventClick: function(calEvent) {
					appointment(calEvent.event.id, calEvent.event.groupId);
				},

				// eventRender: function(eventObj) {
				// 	var s = new Date(eventObj.event.start);
				// 	var e = new Date(eventObj.event.end);
				// 	$(eventObj.el).popover({
				// 		content: "<p style=\"color:#2d2e59;\"><b style=\"color:#2d2e59;\"> Client Name: </b>&nbsp;" +
				// 			eventObj.event.title +
				// 			"&nbsp;<br><b style=\"color:#2d2e59;\"> Appointment Date: </b>" + s
				// 			.getDate() + "-" + (s.getMonth() + 1) + "-" + s.getFullYear() +
				// 			"&nbsp;<br><b style=\"color:#2d2e59;\"> Provider Name: </b>" +
				// 			eventObj.event.extendedProps.beautician +
				// 			"&nbsp;<br><b style=\"color:#2d2e59;\"> Services: </b>" + eventObj
				// 			.event.extendedProps.service_name +
				// 			"&nbsp;<br><b style=\"color:#2d2e59;\"> Appointment Time: </b>" + s
				// 			.toLocaleTimeString([], {
				// 				hour: '2-digit',
				// 				minute: '2-digit'
				// 			}) + " To " + e.toLocaleTimeString([], {
				// 				hour: '2-digit',
				// 				minute: '2-digit'
				// 			}) + "&nbsp;<br><b style=\"color:#2d2e59;\"> Notes: </b>" + eventObj
				// 			.event.extendedProps.description + "&nbsp;<br></p>",
				// 		// content: eventObj.event.extendedProps.description,
				// 		html: true,
				// 		trigger: 'hover',
				// 		placement: 'top',
				// 		container: 'body'
				// 	});
				// },

				eventMouseEnter: function(eventObj) {
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

				selectAllow: function(select) {
					return moment().diff(select.start) <= 0
				},
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

					//$('#book_appointment_modal').modal('show');
					if (provider_id != '') {
						$.ajax({
							url: './inc/appointment/appointment-stafftime.php',
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

									var element = ds['data']['serviceProviderModel']
									var sphtml = '<option value="">--Select--</option>';
									//sphtml += `<option value="${element['id']}">${element['name']}</option>`;

									$('.app-staff').html(sphtml);

									//$('.app-staff').val(ds['data']['pid']);

									$('.start_time1').val(ds['data']['start']);
									$('#book_appointment_modal').modal('show');
									$('#date').val(date);
									$('#time').val(ds['data']['start']);
									$('#appointmentTime').val(ds['data']['start'])
									$('.loader-gif').hide();
								} else if (ds['success'] == '1') {
									showAlert(ds['data']['spcat'] + ' Unavailable.', 'red')
									//calendar.render();
									//set_calendar_width();
									//$('.loader-gif').hide();
								} else if (ds['success'] == '2') {
									showAlert(ds['data']['spcat'] + ' Unavailable.', 'red')
									//calendar.render();
									//set_calendar_width();
									//$('.loader-gif').hide();
								}
							}
						});
					}
				},
				dateClick: function(arg) {}
			});

			calendar.render();
		});
	</script>

	<?php include('./comman/sidebar-button.php'); ?>
	<?php include('./comman/loading.php'); ?>

</body>

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
							<td class="appstaff"></td>
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
					<button type="button" onclick="markCheckIn()" class="btn btn-filter pull-left"><i class="fa fa-check" aria-hidden="true"></i> Check In </button>
				</div>
				<div id="but">
					<a href="#" id="edit_md_btn"><button class="btn btn-warning" type="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </button></a>
					<a href="#" id="conv_md_btn"><button class="btn btn-success" type="button"><i class="fa fa-money" aria-hidden="true"></i> Generate Bill </button></a>
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
		<form id="appointmentAdd" action="./inc/appointment/appointment-dashboard-add.php" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalLabel1">Appointment Details</h1>
					<button type="button" onclick="closeAppointmentModal()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="table-responsive" id="book-app-modal-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col-lg-3">
									<div class="form-group">
										<label for="client">Client name <span class="text-danger">*</span></label>
										<input type="text" class="form-control client_name search_client_name" id="client" name="client[client_name]" placeholder="Autocomplete (Name)" required autocomplete="off">
										<input type="hidden" name="appointment[client_id]" id="client_id">
										<input type="hidden" name="client[branch_id]" id="branch_id" value="<?= BRANCHID ?>">
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label for="cont">Contact Number <span class="text-danger">*</span></label>
										<input type="text" class="form-control search_client_number" id="cont" name="client[contact]" placeholder="Client Contact" maxlength="10" required autocomplete="off">
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label for="doa">Appointment Is On <span class="text-danger">*</span></label>
										<input type="text" class="form-control present_date" id="date" name="appointment[appointment_date]" required readonly>
									</div>
								</div>
								<div class="col-md-3">
									<label>Gender <span class="text-danger">*</span></label>
									<select class="form-select" name="client[gender]" id="gender" required>
										<option value="">--Select--</option>
										<option id="gn-1" value="male">Male</option>
										<option id="gn-2" value="female">Female</option>
									</select>
								</div>

								<div class="col-lg-12">
									<div class="table-responsive">
										<table id="catTable" class="table table-bordered">
											<thead>
												<tr>
													<th></th>
													<th>Select Service</th>
													<th>Artisan</th>
													<th>Start &amp; end time</th>
													<th>Price</th>
												</tr>
											</thead>
											<tbody>
												<tr id="service-provider-services">

													<td style="vertical-align: middle;">
														<span class="sno"><i class="fas fa-ellipsis-v"></i></span>
													</td>
													<td>
														<div class="row" style="width: 400px;">
															<div class="col-12 pr-1">

																<input type="hidden" class="ser_cat_id" name="appointment_service[0][service_cat_id]" value="0">
																<input type="text" class="category-services form-control form-control-sm" onkeyup="searchServices(this)" name="" placeholder="Service (Autocomplete)" required autocomplete="off">
																<input type="hidden" name="appointment_service[0][service_id]" value="" class="serr">

																<input type="hidden" name="service[]" value="" class="serr">
																<input type="hidden" name="durr[]" value="" class="durr">
																<input type="hidden" name="pa_ser[]" value="" class="pa_ser">
																<input type="hidden" name="appointment_service[0][service_discount]" class="form-control form-control-sm d-input service-discount" value="0">
																<input type="hidden" name="appointment_service[0][service_discount_type]" class="form-control form-control-sm d-input service-discount" value="percentage">
															</div>
														</div>
													</td>
													<td>
														<div class="row mb-1" id="service-provider-box" style="width: 200px;">
															<div class="col-12 pr-1">
																<select name="appointment_service[0][sp_id][0][service_provider_id]" class="form-select form-select-sm app-staff" onchange="checkAvailabalityServiceProvider(this)" required>
																	<option value="">Artisan</option>
																</select>
															</div>
															<input type="hidden" name="duration[]" value="" class="duration">
															<input type="hidden" name="ser_stime[]" value="" class="ser_stime">
															<input type="hidden" name="ser_etime[]" value="" class="ser_etime">
														</div>
													</td>
													<td>
														<div class="row" style="width: 250px;">
															<div class="col-6 pr-1">
																<input type="text" class="form-control form-control-sm start_time1 w-100" placeholder="Start Time" name="appointment_service[0][start_time]" onchange="changeTimeValue(this)" onclick="initTimePicker(this)" readonly>
																<input type="hidden" class='start_timestamp' name='appointment_service[0][start_timestamp]'>
															</div>
															<div class="col-6 pl-1">
																<input type="text" class="form-control form-control-sm end_time1 w-100" name="appointment_service[0][end_time]" placeholder="End Time" readonly>
																<input type="hidden" class='end_timestamp' name='appointment_service[0][end_timestamp]'>
															</div>
														</div>
													</td>

													<td>
														<input type="number" class="form-control form-control-sm service-price" name="appointment_service[0][price]" placeholder="0" value="0" readonly oninput="changeTotalPrice()">
														<input type="hidden" class="old-price">
													</td>

												</tr>

												<tr id="addBefore">
													<td colspan="5" class="text-right">
														<div>
															<span class="total" id="tot" colspan="4">Total</span>
															<span style="display: inline;">Rs. <span id="sum">0.00</span></span>
														</div>
														<br>
														<button type="button" id="btnAdd" class="btn btn-primary" onclick="addServiceProviderServices()">
															<i class="fa fa-plus" aria-hidden="true"></i> Add Service
														</button>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="modal-footer">
					<div>
						<!-- <input type="hidden" id="date" />
						<input type="hidden" id="time" name="time" />
						
						<input type="text" class="hidden" id="close_time" value="21:00:00"> -->
						<input type="hidden" id="total" name="appointment[total]" />
						<input type="hidden" id="sub_total" name="appointment[sub_total]" />
						<input type="hidden" id="pending_due" name="appointment[pending_due]" />
						<input type="hidden" id="appointmentTime" name="appointment[appointment_time]" value="" />
						<input type="hidden" name="appointment[status]" value="Pending" />

						<button class="btn btn-success" name="submit" type="submit"><i class="fa fa-calendar-check" aria-hidden="true"></i> Book Appointment</button>
						<button class="btn btn-danger" data-bs-dismiss="modal" type="button" onclick="closeAppointmentModal()"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="modal fade" id="quick_billing_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-centered">
		<form id="billingAdd" action="./inc/billing/billing-quick-add.php" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalLabel2">Quick Billing</h1>
					<button type="button" onclick="closeBillingModal()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="table-responsive" id="book-app-modal-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col-lg-3">
									<div class="form-group">
										<label for="client">Client name <span class="text-danger">*</span></label>
										<input type="text" class="form-control client_name billing_search_client_name" id="client_name" name="client[client_name]" placeholder="Autocomplete (Name)" required autocomplete="off">
										<input type="hidden" name="billing[client_id]" id="billing_client_id">
										<input type="hidden" name="client[branch_id]" id="billing_branch_id" value="<?= BRANCHID ?>">
										<input type="hidden" name="billing[id]" id="billing_id" value="">
										<input type="hidden" name="billing[appointment_id]" id="appointment_id" value="0">
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label for="cont">Contact Number <span class="text-danger">*</span></label>
										<input type="text" class="form-control billing_search_client_number" id="contact" name="client[contact]" placeholder="Client Contact" maxlength="10" required autocomplete="off">
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label for="doa">Billing Date <span class="text-danger">*</span></label>
										<input type="text" class="form-control billing_date" id="billing_date" name="billing[billing_date]" required readonly>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label for="doa">Billing Time <span class="text-danger">*</span></label>
										<input type="text" class="form-control billing_time" id="billing_time" name="billing[billing_time]" required readonly>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label for="email_id">Email ID</label>
										<input type="text" placeholder="Enter Email ID" class="form-control email_id" id="email_id" name="client[email]">
									</div>
								</div>
								<div class="col-md-3 mb-2">
									<label>Gender <span class="text-danger">*</span></label>
									<select class="form-select" name="client[gender]" id="billing_gender" required>
										<option value="">--Select--</option>
										<option id="gn-1" value="male">Male</option>
										<option id="gn-2" value="female">Female</option>
									</select>
								</div>

								<div class="col-lg-12">
									<div class="">
										<table id="catTable" class="table table-bordered">
											<thead>
												<tr>
													<th></th>
													<th>Service / Products / Packages</th>
													<th>Quantity</th>
													<th>Discount</th>
													<th>Service Provider</th>
													<th>Start &amp; End Time</th>
													<th>Price</th>
												</tr>
											</thead>
											<tbody>
												<tr id="billing-service-provider-services">

													<td style="vertical-align: middle;">
														<span class="sno"><i class="fas fa-ellipsis-v"></i></span>
													</td>
													<td>
														<div class="row" style="width: 250px;">
															<div class="col-4 pr-1 d-none">
																<input type="hidden" class="service-category form-control form-control-sm" onkeyup="searchCategory(this)" name="" value="" placeholder="Category" readonly autocomplete="off">
																<input type="hidden" class="ser_cat_id" value="0" name="billing_product[0][service_cat_id]">
																<input type="hidden" class="billing_product_id" value="0" name="billing_product[0][id]">
															</div>
															<div class="col-12 pl-1">
																<input type="text" class="category-services form-control form-control-sm" onkeyup="searchBillingServices(this)" name="" value="" placeholder="Service (Autocomplete)" required autocomplete="off">
																<input type="hidden" name="billing_product[0][service_id]" value="0" class="serr serviceids">
																<input type="hidden" name="billing_product[0][service_type]" value="0" class="service_type">

																<input type="hidden" name="service[]" value="" class="serr">
																<input type="hidden" name="durr[]" value="" class="durr">
																<input type="hidden" name="pa_ser[]" value="" class="pa_ser">
															</div>
														</div>
													</td>
													<td>
														<div class="row">

															<div class="col-12">
																<input type="number" name="billing_product[0][quantity]" min="1" class="form-control form-control-sm d-input service-quantity" value="1" onchange="changeQuantity(this)">
															</div>
														</div>
													</td>
													<td>
														<div class="row" style="width: 200px;">
															<div class="col-6 pr-1">
																<input type="number" oninput="addDiscount(this)" name="billing_product[0][service_discount]" class="form-control form-control-sm d-input service-discount" value="0">
															</div>
															<div class="col-6 pl-1">
																<select class="form-select form-select-sm discount-type" name="billing_product[0][service_discount_type]" onchange="changeDiscountType(this)">
																	<?php
																	foreach ($discountArr as $discountArrKey1 => $discountArrVal1) { ?>
																		<option value="<?= $discountArrKey1 ?>"><?= $discountArrVal1 ?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
													</td>
													<td>

														<div class="row" id="service-provider-box" style="width: 200px;">
															<div class="col-12">
																<select name="billing_product[0][sp_id][0][service_provider_id]" class="form-select form-select-sm staff">
																	<option value="0">Service provider</option>
																</select>
																<input type="hidden" name="billing_product[0][sp_id][0][id]" value="0">
															</div>
															<input type="hidden" name="duration[]" value="0" class="duration">
															<input type="hidden" name="ser_stime[]" value="0" class="ser_stime">
															<input type="hidden" name="ser_etime[]" value="0" class="ser_etime">
														</div>

													</td>
													<td>
														<div class="row" style="width: 200px;">
															<div class="col-6 pr-1">
																<input type="text" class="form-control form-control-sm start_time1 w-100" placeholder="Start Time" name="billing_product[0][start_time]" value="0" onchange="changeTimeValue(this)" readonly>
																<input type="hidden" class='start_timestamp' name='billing_product[0][start_timestamp]' value="0">
															</div>
															<div class="col-6 pl-1">
																<input type="text" class="form-control form-control-sm end_time1 w-100" name="billing_product[0][end_time]" value="0" placeholder="End Time" readonly>
																<input type="hidden" class='end_timestamp' name='billing_product[0][end_timestamp]' value="0">
															</div>
														</div>
													</td>

													<td>
														<div class="row">
															<div class="col-md-12">
																<input type="number" class="form-control form-control-sm service-price" name="billing_product[0][price]" placeholder="0" value="0" readonly>
																<input type="hidden" class="old-price" value="">
															</div>
														</div>
													</td>

												</tr>

												<tr id="addBillingBefore">
													<td colspan="7" class="text-right">

														<div class="mb-2">
															<span class="total" id="billing_tot" colspan="4">Total</span>
															<span style="display: inline;">Rs. <span id="billing_sum">0.00</span></span>
														</div>

														<button type="button" id="billingBtnAdd" class="btn btn-success" onclick="addBillingServiceProviderServices()">
															<i class="fa fa-plus" aria-hidden="true"></i> Add Service / Product / Package
														</button>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="modal-footer">
					<div>

						<input type="hidden" id="billing_total" name="billing[total]" />
						<input type="hidden" id="billing_sub_total" name="billing[sub_total]" />
						<!-- <input type="hidden" name="billing[pending_due]" /> -->
						<input type="hidden" name="billing[status]" value="1" />
						<input type="hidden" name="billing[discount]" value="0" />
						<input type="hidden" name="billing[discount_type]" value="percentage" />
						<input type="hidden" name="billing[tax]" value="0" />
						<input type="hidden" name="billing[referral_code]" value="" />
						<input type="hidden" name="billing[give_reward_point]" value="1" />
						<input type="hidden" name="billing[advance_receive]" value="0" />
						<input type="hidden" name="billing[notes]" />
						<input type="hidden" name="billing[membership_id]" value="0" />
						<input type="hidden" name="billing[service_for]" value="" />

						<input type="hidden" name="billing_payment[0][transaction_id]" value="" />
						<input type="hidden" name="billing_payment[0][id]" value="" />
						<input type="hidden" name="billing_payment[0][advance]" value="0" />
						<input type="hidden" name="billing_payment[0][method]" value="1" />
						<input type="hidden" id="billing_pending_due" name="billing[pending_amount]" value="" />
						<input type="hidden" id="original_total_charge">

						<button class="btn btn-success" name="submit" type="submit"><i class="fa fa-file-invoice" aria-hidden="true"></i> Quick Bill</button>
						<button class="btn btn-danger" data-bs-dismiss="modal" type="button" onclick="closeBillingModal()"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>

					</div>
				</div>
			</div>
		</form>
	</div>
</div>