$(document).ready(function () {

  loadStaffTable();
  
  const picker1 = datepicker(".present_date", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });
  $(".present_date").val(getTodayDate());

  $(".today_date").val(getCurrentTime("hh"));

  $(".today_date").datetimepicker({
    format: "HH:ii P",
    showMeridian: true,
    autoclose: true,
    pickDate: false,
    startView: 1,
    maxView: 1,
  });
});

function checkIn() {
  var url = "./inc/mark-attendance/attendance-check-in.php";
  var checkInTime = $(".today_date").val();
  var employee = $(".payment_mode");
  var date = $(".present_date").val();
  var employee_id = employee.val();

  var e = document.getElementsByClassName("payment_mode")[0];
  var employee_type = e.options[e.selectedIndex].getAttribute("data-type");

  var formValues = {
    check_in_time: checkInTime,
    employee_id: employee_id,
    employee_type: employee_type,
    date: date,
  };
  $.ajax({
    type: "POST",
    url: url,
    data: formValues,
    beforeSend: function () {
      instanceLoading.showLoading({
        type: 'cube_flip',
        color: '#ffffff',
        backgroundColor: '#025043',
        title: 'Loading...',
        fontSize: 16,
      });
    },
    success: function (data) {
      instanceLoading.hideLoading()
      const myObj = JSON.parse(data);

      if (myObj.success == true) {
        showAlert("Attendance marked successfully!");
        Swal.fire(
          "Good job!",
          "Attendance marked successfully!",
          "success"
        ).then((result) => {
          location.reload();
        });
      } else {
        $(".server-error").css("display", "block");
        $("#error-message").html(myObj.errors.error);
        showAlert(myObj.errors.error, "red");
      }
    },
    error: function (data) {
      instanceLoading.hideLoading()
      $(".server-error").show();
      $("#error-message").html(myObj.errors.error);
      showAlert("Something went wrong", "red");
    },
  });
}

function absent() {
  var url = "./inc/mark-attendance/attendance-absent.php";
  var checkInTime = $(".today_date").val();
  var employee = $(".payment_mode");
  var employee_id = employee.val();
  var date = $(".present_date").val();

  var e = document.getElementsByClassName("payment_mode")[0];
  var employee_type = e.options[e.selectedIndex].getAttribute("data-type");

  var formValues = {
    check_in_time: checkInTime,
    employee_id: employee_id,
    employee_type: employee_type,
    date: date,
  };
  $.ajax({
    type: "POST",
    url: url,
    data: formValues,
    beforeSend: function () {
      instanceLoading.showLoading({
        type: 'cube_flip',
        color: '#ffffff',
        backgroundColor: '#025043',
        title: 'Loading...',
        fontSize: 16,
      });
    },
    success: function (data) {
      instanceLoading.hideLoading()
      const myObj = JSON.parse(data);

      if (myObj.success == true) {
        showAlert("Attendance marked successfully!");
        Swal.fire(
          "Good job!",
          "Attendance marked successfully!",
          "success"
        ).then((result) => {
          location.reload();
        });
      } else {
        $(".server-error").css("display", "block");
        $("#error-message").html(myObj.errors.error);
        showAlert(myObj.errors.error, "red");
      }
    },
    error: function (data) {
      instanceLoading.hideLoading()
      $(".server-error").show();
      $("#error-message").html(myObj.errors.error);
      showAlert("Something went wrong", "red");
    },
  });
}

function checkInTable(elem) {
  var url = "./inc/mark-attendance/attendance-check-in.php";
  var checkInTime = $(".today_date").val();
  var employee_id = $(elem).attr("data-id");
  var employee_type = $(elem).attr("data-src");

  var formValues = {
    check_in_time: checkInTime,
    employee_id: employee_id,
    employee_type: employee_type,
  };

  $.ajax({
    type: "POST",
    url: url,
    data: formValues,
    beforeSend: function () {
      instanceLoading.showLoading({
        type: 'cube_flip',
        color: '#ffffff',
        backgroundColor: '#025043',
        title: 'Loading...',
        fontSize: 16,
      });
    },
    success: function (data) {
      instanceLoading.hideLoading()
      const myObj = JSON.parse(data);

      if (myObj.success == true) {
        showAlert("Attendance marked successfully!");
        Swal.fire(
          "Good job!",
          "Attendance marked successfully!",
          "success"
        ).then((result) => {
          location.reload();
        });
      } else {
        $(".server-error").css("display", "block");
        $("#error-message").html(myObj.errors.error);
        showAlert(myObj.errors.error, "red");
      }
    },
    error: function (data) {
      instanceLoading.hideLoading()
      $(".server-error").show();
      $("#error-message").html(myObj.errors.error);
      showAlert("Something went wrong", "red");
    },
  });
}

function checkOut(elem) {
  var url = "./inc/mark-attendance/attendance-check-out.php";

  var checkOutTime = $(".today_date").val();
  var employee_id = $(elem).attr("data-id");
  var employee_type = $(elem).attr("data-src");

  var formValues = {
    check_out_time: checkOutTime,
    employee_id: employee_id,
    employee_type: employee_type,
  };

  $.ajax({
    type: "POST",
    url: url,
    data: formValues,
    beforeSend: function () {
      instanceLoading.showLoading({
        type: 'cube_flip',
        color: '#ffffff',
        backgroundColor: '#025043',
        title: 'Loading...',
        fontSize: 16,
      });
    },
    success: function (data) {
      instanceLoading.hideLoading()
      const myObj = JSON.parse(data);

      if (myObj.success == true) {
        showAlert("Attendance marked successfully!");
        Swal.fire(
          "Good job!",
          "Attendance marked successfully!",
          "success"
        ).then((result) => {
          location.reload();
        });
      } else {
        $(".server-error").css("display", "block");
        $("#error-message").html(myObj.errors.error);
        showAlert(myObj.errors.error, "red");
      }
    },
    error: function (data) {
      instanceLoading.hideLoading()
      $(".server-error").show();
      $("#error-message").html(myObj.errors.error);
      showAlert("Something went wrong", "red");
    },
  });
}

function loadStaffTable() {
  $.ajax({
    type: "POST",
    url: "./inc/mark-attendance/attendance-show.php",
    beforeSend: function () {
      instanceLoading.showLoading({
        type: 'cube_flip',
        color: '#ffffff',
        backgroundColor: '#025043',
        title: 'Loading...',
        fontSize: 16,
      });
    },
    success: function (result) {
      instanceLoading.hideLoading()
      setTable(result);
      setTimeout(dataTableLoad, 3000);
    },
  });
}

function setTable(result) {
  $(".active-table-data").html(result);
}

function dataTableLoad() {
  var table = $("#dataTable").DataTable();
}


