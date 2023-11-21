$(document).ready(function () {
  $(".time_picker").datetimepicker({
    format: "HH:ii P",
    showMeridian: true,
    autoclose: true,
    pickDate: false,
    startView: 1,
    maxView: 1,
  });

  $("#branch_setting_save").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();

    var form = $("#branch_setting_save");

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
            showAlert("Salon information saved successfully!");
            Swal.fire(
              "Good job!",
              "Salon information saved successfully!",
              "success"
            ).then((result) => {
              document.getElementById("branch_setting_save").reset();
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

  $("#branch_working_hour_setting_save").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();

    var form = $("#branch_working_hour_setting_save");

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
            showAlert("Salon working information saved successfully!");
            Swal.fire(
              "Good job!",
              "Salon working information saved successfully!",
              "success"
            ).then((result) => {
              document.getElementById("branch_working_hour_setting_save").reset();
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

  $("#branch_sms_template_setting_save").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();

    var form = $("#branch_sms_template_setting_save");

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
            showAlert("Salon SMS Template saved successfully!");
            Swal.fire(
              "Good job!",
              "Salon SMS Template saved successfully!",
              "success"
            ).then((result) => {
              document.getElementById("branch_sms_template_setting_save").reset();
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

function addTofield(fieldId, name, id) {
  var shortcode = name;
  var oldval = $("#" + fieldId).val();
  $("#" + id).css("color", "#676767");
  if (oldval.indexOf(name) > -1) {
    $("#" + id).css("color", "#676767");
  } else {
    $("#" + fieldId).val(oldval + shortcode);
    textlength("smstemplate", "text_lenght");
  }
}

function savesmsTemplate() {
  var dropdownDiv = $("#templatefor");
  var dropdownid = dropdownDiv.val();
  var template_detail = $("#smstemplate").val();
  var template_id = $("#template_id").val();
  if (dropdownid == "" || dropdownid == "0") {
    dropdownDiv.addClass("invalid");
  } else if (template_detail == "") {
    $("#smstemplate").addClass("invalid");
  } else {
    $("#smstemplate").removeClass("invalid");
    $.ajax({
      url: "ajax/system_details.php",
      method: "POST",
      data: {
        id: template_id,
        detail: template_detail,
        action: "savesmstemplate",
      },
      success: function (response) {
        if (response == "1") {
          location.reload();
        }
      },
    });
  }
}

function changeSalonTime() {
  var working_hours_start = $(".working_hours_start").val();
  var working_hours_end = $(".working_hours_end").val();

  var new_open_hour = $(".new_open_hour");
  var new_close_hour = $(".new_close_hour");

  for (let index = 0; index < new_open_hour.length; index++) {
    const element = new_open_hour[index];
    element.value = working_hours_start;
  }

  for (let index = 0; index < new_close_hour.length; index++) {
    const element = new_close_hour[index];
    element.value = working_hours_end;
  }
}
