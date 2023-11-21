function deleteServiceReminder(v) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      showAlert("Reminder deleted successfully");
      Swal.fire("Deleted!", "Reminder deleted successfully.", "success").then(
        (nresult) => {
          if (nresult.isConfirmed) {
            $.ajax({
              type: "POST",
              url: "inc/service-reminder/service-reminder-delete.php",
              data: { srid: v },
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
                  window.location = './service-reminder.php'
                }
              },
              error: function (data) { instanceLoading.hideLoading() },
            });
          }
        }
      );
    }
  });
}

$(document).ready(function () {

  loadStaffTable();

  $("#addStaffForm").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();

    var form = $("#addStaffForm");

    var url = form.attr("action");

    var error = false;

    var service_id_label = $(".service_id_label");
    var service_id = $(".service_id");

    var interval_days_label = $(".interval_days_label");
    var interval_days = $(".interval_days");

    var message_label = $(".message_label");
    var message = $(".message");

    var ErrorMsg = "";

    if (service_id.val() == "") {
      ErrorMsg = "service field is required";
      addError(service_id_label, service_id, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(service_id_label, service_id);
    }

    if (interval_days.val() == "") {
      ErrorMsg = "interval days field is required";
      addError(interval_days_label, interval_days, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(interval_days_label, interval_days);
    }

    if (message.val() == "") {
      ErrorMsg = "Message cannot be blank";
      addError(message_label, message, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(message_label, message);
    }

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
            showAlert("form has been successfully submitted");
            Swal.fire(
              "Good job!",
              "Service Reminder added successfully",
              "success"
            ).then((result) => {
              document.getElementById("addStaffForm").reset();
              location.reload();
            });

            loadStaffTable();
            setTimeout(dataTableLoad, 3000);
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

  $("#editStaffForm").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();

    var form = $("#editStaffForm");
    var url = form.attr("action");
    var error = false;
    var service_id_label = $(".service_id_label");
    var service_id = $(".service_id");

    var interval_days_label = $(".interval_days_label");
    var interval_days = $(".interval_days");

    var message_label = $(".message_label");
    var message = $(".message");

    var ErrorMsg = "";

    if (service_id.val() == "") {
      ErrorMsg = "service field is required";
      addError(service_id_label, service_id, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(service_id_label, service_id);
    }

    if (interval_days.val() == "") {
      ErrorMsg = "interval days field is required";
      addError(interval_days_label, interval_days, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(interval_days_label, interval_days);
    }

    if (message.val() == "") {
      ErrorMsg = "Message cannot be blank";
      addError(message_label, message, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(message_label, message);
    }

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
            showAlert("Service Reminder record has been updated successfully");
            Swal.fire(
              "Good job!",
              "Service Reminder updated successfully",
              "success"
            ).then((result) => {
              document.getElementById("editStaffForm").reset();
              window.location = './service-reminder.php';
            });

            loadStaffTable();
            setTimeout(dataTableLoad, 3000);
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

function loadStaffTable() {
  $.ajax({
    type: "POST",
    url: "./inc/service-reminder/service-reminder-show.php",
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

function fnExcelReport() {
  $.ajax({
    type: "POST",
    url: "./inc/staff/staff-show-full.php",
    success: function (result) {
      var tab_text = result;
      var ua = window.navigator.userAgent;
      var msie = ua.indexOf("MSIE ");

      if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        // If Internet Explorer
        txtArea1.document.open("txt/html", "replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus();
        sa = txtArea1.document.execCommand(
          "SaveAs",
          true,
          "Say Thanks to Sumit.xls"
        );
      } //other browser not tested on IE 11
      else
        sa = window.open(
          "data:application/vnd.ms-excel," + encodeURIComponent(tab_text)
        );

      return sa;
    },
  });
}



function setTodayDate(id) {
  elem = document.getElementById(id);
  const formattedToday = getTodayDate();
  elem.value = elem.value == "" ? formattedToday : elem.value;
  return formattedToday;
}

function searchService(elem) {
  $(elem)
    .autocomplete({
      source: function (request, response) {
        var timestamp =
          getServerFormatDate(getTodayDate()) + " " + getCurrentTime("HH");
        var category_id = $(elem).parent().parent().find(".category_id").val();
        $.getJSON(
          "inc/service/get-service.php",
          {
            category_id: category_id,
            name: request.term,
            timestamp: timestamp,
          },
          response
        );
      },
      minLength: 1,
      open: function (event, ui) { },
      select: function (event, ui) {
        var row = $(this).parent().parent();
        row.find(".service_id").val(ui.item.id);
      },
    })
    .addClass("whatever");
  $(elem).on("autocompleteopen", function (event, ui) { });
};