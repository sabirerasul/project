$(document).ready(function () {

  checkSMSBalance();

  $(".time_picker").datetimepicker({
    format: "HH:ii P",
    showMeridian: true,
    autoclose: true,
    pickDate: false,
    startView: 1,
    maxView: 1,
  });

  $("#sms_api_setting_save").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();

    var form = $("#sms_api_setting_save");

    var url = form.attr("action");

    var error = false;

    var today_date_label = $(".today_date_label");
    var today_date = $(".today_date");

    var expense_type_label = $(".expense_type_label");
    var expense_type = $(".expense_type");

    var amount_paid_label = $(".amount_paid_label");
    var amount_paid = $(".amount_paid");

    var payment_mode_label = $(".payment_mode_label");
    var payment_mode = $(".payment_mode");

    var recipient_name_label = $(".recipient_name_label");
    var recipient_name = $(".recipient_name");

    var description_label = $(".description_label");
    var description = $(".description");

    var ErrorMsg = "";

    /*
    if (today_date.val() == "") {
      ErrorMsg = "Date field is required";
      addError(today_date_label, today_date, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(today_date_label, today_date);
    }

    if (expense_type.val() == "") {
      ErrorMsg = "Expense field is required";
      addError(expense_type_label, expense_type, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(expense_type_label, expense_type);
    }

    if (amount_paid.val() == "") {
      ErrorMsg = "Amount cannot be blank";
      addError(amount_paid_label, amount_paid, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(amount_paid_label, amount_paid);
    }

    if (payment_mode.val() == "") {
      ErrorMsg = "Payment mode cannot be blank";
      addError(payment_mode_label, payment_mode, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(payment_mode_label, payment_mode);
    }

    if (recipient_name.val() == "") {
      ErrorMsg = "recipient name cannot be blank";
      addError(recipient_name_label, recipient_name, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(recipient_name_label, recipient_name);
    }

    if (description.val() == "") {
      ErrorMsg = "description cannot be blank";
      addError(description_label, description, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(description_label, description);
    }*/

    if (error == false) {
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
            // $('#exampleModal').hide();
            // $('.modal-backdrop').hide();

            $("#clientModalClose").click();
            showAlert("API details saved successfully!");
            Swal.fire(
              "Good job!",
              "API details saved successfully!",
              "success"
            ).then((result) => {
              document.getElementById("sms_api_setting_save").reset();
              location.reload();
            });
          } else {
            errorMsg = myObj.errors?.error;
            $(".server-error").css("display", "block");
            $("#error-message").html(errorMsg);
            showAlert(errorMsg, "red");
          }
        },
        error: function (data) {
          instanceLoading.hideLoading()
          const myObj = JSON.parse(data);
          $(".server-error").show();
          $("#error-message").html(myObj.errors?.error);
          showAlert("Something went wrong", "red");
        },
      });
    }
  });

  $("#branch_redeem_points_save").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();

    var form = $("#branch_redeem_points_save");

    var url = form.attr("action");

    var error = false;

    var today_date_label = $(".today_date_label");
    var today_date = $(".today_date");

    var expense_type_label = $(".expense_type_label");
    var expense_type = $(".expense_type");

    var amount_paid_label = $(".amount_paid_label");
    var amount_paid = $(".amount_paid");

    var payment_mode_label = $(".payment_mode_label");
    var payment_mode = $(".payment_mode");

    var recipient_name_label = $(".recipient_name_label");
    var recipient_name = $(".recipient_name");

    var description_label = $(".description_label");
    var description = $(".description");

    var ErrorMsg = "";

    /*
    if (today_date.val() == "") {
      ErrorMsg = "Date field is required";
      addError(today_date_label, today_date, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(today_date_label, today_date);
    }

    if (expense_type.val() == "") {
      ErrorMsg = "Expense field is required";
      addError(expense_type_label, expense_type, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(expense_type_label, expense_type);
    }

    if (amount_paid.val() == "") {
      ErrorMsg = "Amount cannot be blank";
      addError(amount_paid_label, amount_paid, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(amount_paid_label, amount_paid);
    }

    if (payment_mode.val() == "") {
      ErrorMsg = "Payment mode cannot be blank";
      addError(payment_mode_label, payment_mode, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(payment_mode_label, payment_mode);
    }

    if (recipient_name.val() == "") {
      ErrorMsg = "recipient name cannot be blank";
      addError(recipient_name_label, recipient_name, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(recipient_name_label, recipient_name);
    }

    if (description.val() == "") {
      ErrorMsg = "description cannot be blank";
      addError(description_label, description, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(description_label, description);
    }*/

    if (error == false) {
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
            // $('#exampleModal').hide();
            // $('.modal-backdrop').hide();

            $("#clientModalClose").click();
            showAlert("Redeem points saved successfully!");
            Swal.fire(
              "Good job!",
              "Redeem points saved successfully!",
              "success"
            ).then((result) => {
              document.getElementById("branch_redeem_points_save").reset();
              location.reload();
            });
          } else {
            errorMsg = myObj.errors?.error;
            $(".server-error").css("display", "block");
            $("#error-message").html(errorMsg);
            showAlert(errorMsg, "red");
          }
        },
        error: function (data) {
          instanceLoading.hideLoading()
          const myObj = JSON.parse(data);
          $(".server-error").show();
          $("#error-message").html(myObj.errors?.error);
          showAlert("Something went wrong", "red");
        },
      });
    }
  });

  $("#branch_holiday_setting_save").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();

    var form = $("#branch_holiday_setting_save");

    var url = form.attr("action");

    var error = false;

    var today_date_label = $(".today_date_label");
    var today_date = $(".today_date");

    var expense_type_label = $(".expense_type_label");
    var expense_type = $(".expense_type");

    var amount_paid_label = $(".amount_paid_label");
    var amount_paid = $(".amount_paid");

    var payment_mode_label = $(".payment_mode_label");
    var payment_mode = $(".payment_mode");

    var recipient_name_label = $(".recipient_name_label");
    var recipient_name = $(".recipient_name");

    var description_label = $(".description_label");
    var description = $(".description");

    var ErrorMsg = "";
    /*
    if (today_date.val() == "") {
      ErrorMsg = "Date field is required";
      addError(today_date_label, today_date, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(today_date_label, today_date);
    }

    if (expense_type.val() == "") {
      ErrorMsg = "Expense field is required";
      addError(expense_type_label, expense_type, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(expense_type_label, expense_type);
    }

    if (amount_paid.val() == "") {
      ErrorMsg = "Amount cannot be blank";
      addError(amount_paid_label, amount_paid, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(amount_paid_label, amount_paid);
    }

    if (payment_mode.val() == "") {
      ErrorMsg = "Payment mode cannot be blank";
      addError(payment_mode_label, payment_mode, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(payment_mode_label, payment_mode);
    }

    if (recipient_name.val() == "") {
      ErrorMsg = "recipient name cannot be blank";
      addError(recipient_name_label, recipient_name, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(recipient_name_label, recipient_name);
    }

    if (description.val() == "") {
      ErrorMsg = "description cannot be blank";
      addError(description_label, description, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(description_label, description);
    }*/

    if (error == false) {
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
            // $('#exampleModal').hide();
            // $('.modal-backdrop').hide();

            $("#clientModalClose").click();
            showAlert("Holiday saved successfully!");
            Swal.fire(
              "Good job!",
              "Holiday saved successfully!",
              "success"
            ).then((result) => {
              document.getElementById("branch_holiday_setting_save").reset();
              window.location = './software-setting-super-admin.php';
            });
          } else {
            errorMsg = myObj.errors?.error;
            $(".server-error").css("display", "block");
            $("#error-message").html(errorMsg);
            showAlert(errorMsg, "red");
          }
        },
        error: function (data) {
          instanceLoading.hideLoading()
          const myObj = JSON.parse(data);
          $(".server-error").show();
          $("#error-message").html(myObj.errors?.error);
          showAlert("Something went wrong", "red");
        },
      });
    }
  });

  $("#branch_automatic_reminder").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();

    var form = $("#branch_automatic_reminder");

    var url = form.attr("action");

    var error = false;

    var today_date_label = $(".today_date_label");
    var today_date = $(".today_date");

    var expense_type_label = $(".expense_type_label");
    var expense_type = $(".expense_type");

    var amount_paid_label = $(".amount_paid_label");
    var amount_paid = $(".amount_paid");

    var payment_mode_label = $(".payment_mode_label");
    var payment_mode = $(".payment_mode");

    var recipient_name_label = $(".recipient_name_label");
    var recipient_name = $(".recipient_name");

    var description_label = $(".description_label");
    var description = $(".description");

    var ErrorMsg = "";
    /*
    if (today_date.val() == "") {
      ErrorMsg = "Date field is required";
      addError(today_date_label, today_date, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(today_date_label, today_date);
    }

    if (expense_type.val() == "") {
      ErrorMsg = "Expense field is required";
      addError(expense_type_label, expense_type, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(expense_type_label, expense_type);
    }

    if (amount_paid.val() == "") {
      ErrorMsg = "Amount cannot be blank";
      addError(amount_paid_label, amount_paid, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(amount_paid_label, amount_paid);
    }

    if (payment_mode.val() == "") {
      ErrorMsg = "Payment mode cannot be blank";
      addError(payment_mode_label, payment_mode, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(payment_mode_label, payment_mode);
    }

    if (recipient_name.val() == "") {
      ErrorMsg = "recipient name cannot be blank";
      addError(recipient_name_label, recipient_name, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(recipient_name_label, recipient_name);
    }

    if (description.val() == "") {
      ErrorMsg = "description cannot be blank";
      addError(description_label, description, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(description_label, description);
    }*/

    if (error == false) {
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
            // $('#exampleModal').hide();
            // $('.modal-backdrop').hide();

            $("#clientModalClose").click();
            showAlert("Automatic reminder saved successfully!");
            Swal.fire(
              "Good job!",
              "Automatic reminder saved successfully!",
              "success"
            ).then((result) => {
              document.getElementById("branch_automatic_reminder").reset();
              location.reload();
            });
          } else {
            errorMsg = myObj.errors?.error;
            $(".server-error").css("display", "block");
            $("#error-message").html(errorMsg);
            showAlert(errorMsg, "red");
          }
        },
        error: function (data) {
          instanceLoading.hideLoading()
          const myObj = JSON.parse(data);
          $(".server-error").show();
          $("#error-message").html(myObj.errors?.error);
          showAlert("Something went wrong", "red");
        },
      });
    }
  });
});

function dataTableLoad() {
  var table = $('#dataTable').DataTable();
}

$(document).ready(function () {
  dataTableLoad();


  const picker1 = datepicker(".holiday_date", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });

})


var params = window.location.search;
var url_string = window.location;
var url = new URL(url_string);
var hid = url.searchParams.get("hid");

if (hid != null) {

  $(document).ready(function () {

    const myModal = new bootstrap.Modal("#branchHolidayModal", {
      keyboard: false,
    });
    const modalToggle = $("#branchHolidayModal");
    myModal.show(modalToggle);

  })

} else {
  $(".holiday_date").val(getTodayDate());
}


function setHolidayModal() {
  $(document).ready(function () {
    document.getElementById("branch_holiday_setting_save").reset();

    $('#holiday_date').val('');
    $('#holiday_id').val('');
    $('#holiday_title').val('');

    $(".holiday_date").val(getTodayDate());
    const myModal = new bootstrap.Modal("#branchHolidayModal", {
      keyboard: false,
    });
    const modalToggle = $("#branchHolidayModal");
    myModal.show(modalToggle);
  })
}

function checkSMSBalance() {
  $.ajax({
    type: "POST",
    url: './inc/software-setting/branch-sms-balance-show.php',
    data: '',
    success: function (data) {
      const myObj = JSON.parse(data);
      $('.transbal').val(myObj.Trans)
      $('.promobal').val(myObj.Promo)
    },
    error: function (data) {
      const myObj = JSON.parse(data);
      $(".server-error").show();
      $("#error-message").html(myObj.errors?.error);
      showAlert("Something went wrong", "red");
    },
  });
}