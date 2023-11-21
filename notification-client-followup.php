<?php
require_once "lib/db.php";
check_auth();

$followupModel = fetch_all($db, "SELECT * FROM client_followup WHERE response_type='client' ORDER BY id DESC");

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Client Follow up - <?= SALONNAME ?></title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">


    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- CSS only -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <link href="./css/site.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this page -->

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="./css/datepicker.min.css">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
                <?php include('./comman/notification-tabs.php') ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-12 bg-white my-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Client Follow up</h6>
                                </div>
                                <div class="card-body shadow rounded p-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Customer Name</th>
                                                    <th>Phone Number</th>
                                                    <th>Response/Feedback</th>
                                                    <th>Followup Date</th>
                                                    <th>Followup Time</th>
                                                    <th>Representative</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="active-table-data">
                                                <?php
                                                if (count($followupModel) > 0) {
                                                    $count = 0;

                                                    foreach ($followupModel as $key => $val) {
                                                        $value = (object) $val;
                                                        $count++;

                                                        $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='{$value->client_id}'");

                                                        $approveBtn = "<a class='btn btn-sm btn-success text-nowrap m-1' onclick='addFollowup({$value->client_id})'><i class='fas fa-plus'></i> Add followup </a>";
                                                ?>
                                                        <tr>
                                                            <td><?= $count ?></td>
                                                            <td><?= $clientModel->client_name ?></td>
                                                            <td><?= $clientModel->contact ?></td>
                                                            <td><?= $value->response ?></td>
                                                            <td><?= $value->followup_date ?></td>
                                                            <td><?= $value->followup_time ?></td>
                                                            <td><?= ucfirst($value->representative) ?></td>
                                                            <td><?= $approveBtn ?></td>
                                                        </tr>
                                                <?php
                                                    }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
    <script src="./js/bootstrap.bundle.min.js">
    </script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- JavaScript Bundle with Popper -->

    <!-- Page level plugins -->

    <script src="./js/validation.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript" src="./js/toastify-js.js"></script>

    <script type="text/javascript" src="./js/sweetalert2@11.js"></script>

    <script type="text/javascript" src="./js/main.js"></script>
    <script type="text/javascript" src="./js/datepicker.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="./js/bootstrap-datetimepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            dataTableLoad()

            $(".followup_time").datetimepicker({
                format: "HH:ii P",
                showMeridian: true,
                autoclose: true,
                pickDate: false,
                startView: 1,
                maxView: 1,
            });



            const picker3 = datepicker(".followup_date", {
                formatter: (input, date, instance) => {
                    const value = date.toLocaleDateString();
                    input.value = dateFormatter(value);
                },
            });


            $(".followup_date").val(getTodayDate());

            $(".followup_time").val(getCurrentTime("hh"));


            $("#followup_form").on("submit", function(event) {
                event.preventDefault();
                var formValues = $(this).serialize();
                var form = $("#followup_form");
                var url = form.attr("action");
                var error = false;

                if (error == false) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: formValues,
                        success: function(data) {
                            const myObj = JSON.parse(data);

                            if (myObj.success == true) {
                                $("#followupModal").modal("hide");
                                showAlert("form has been successfully submitted");
                                Swal.fire(
                                    "Good job!",
                                    "New Follow up added successfully!",
                                    "success"
                                );
                                document.getElementById("followup_form").reset();
                            } else {
                                $(".server-error").css("display", "block");
                                $("#error-message").html(myObj.errors.error);
                                showAlert(myObj.errors.error, "red");
                            }
                        },
                        error: function(data) {
                            $(".server-error").show();
                            $("#error-message").html(myObj.errors.error);
                            showAlert("Something went wrong", "red");
                        },
                    });
                }
            });
        })

        function dataTableLoad() {
            $('#dataTable').DataTable();
        }

        function addFollowup(id) {
            $("#client_id").val(id);
            $("#followupModal").modal("show");
        }
    </script>


<?php include('./comman/loading.php'); ?>
</body>

</html>


<!-- Modal End -->

<div class="modal fade" id="followupModal" tabindex="-1" aria-labelledby="exampleModalLabelSchedule" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form class="" action="./inc/client/client-followup-add.php" id="followup_form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelSchedule">Add New Followup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Next Followup Date : <span class="text-danger">*</span></label>
                                <input type="text" name="followup_date" placeholder="" class="followup_date form-control" required />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Next Followup Time : <span class="text-danger">*</span></label>
                                <input type="text" name="followup_time" placeholder="" class="followup_time form-control" required />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="userName">Response : <span class="text-danger">*</span></label>
                                <textarea name="response" style="resize: none" rows="5" class="form-control" required=""></textarea>
                                <input type="hidden" name="representative" value="<?= USERROLE ?>">
                                <input type="hidden" name="response_type" value="admin">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="hidden" name="client_id" id="client_id" value="">
                                <input type="hidden" name="branch_id" value="<?= BRANCHID ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success add-new-client">Save</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" id="exampleModal3">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal End -->