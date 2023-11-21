$(document).ready(function () {
  // client add logic
  $("#AddEnquiryForm").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#AddEnquiryForm");
    var url = form.attr("action");

    var client_name = $(".client_name");
    var client_name_label = $(".client_name_label");

    var contact = $(".contact");
    var contact_label = $(".contact_label");

    var email = $(".email");
    var email_label = $(".email_label");

    var address = $(".address");
    var address_label = $(".address_label");

    var enquiry_for = $(".enquiry_for_title");
    var enquiry_for_label = $(".enquiry_for_title_label");

    var enquiry_type = $(".enquiry_type");
    var enquiry_type_label = $(".enquiry_type_label");

    var response = $(".response");
    var response_label = $(".response_label");

    var followdate = $(".followdate");
    var followdate_label = $(".followdate_label");

    var source_of_enquiry = $(".source_of_enquiry");
    var source_of_enquiry_label = $(".source_of_enquiry_label");

    var leaduser = $(".leaduser");
    var leaduser_label = $(".leaduser_label");

    var status = $(".status");
    var status_label = $(".status_label");

    var error = false;
    var ErrorMsg = "";

    if (client_name.val() == "") {
      ErrorMsg = "Client Name field is required";
      addError(client_name_label, client_name, ErrorMsg);
      error = true;
      return false;
    } else {
      if (isValidName(client_name.val()) == false) {
        ErrorMsg = "Client Name is not valid";
        addError(client_name_label, client_name, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(client_name_label, client_name);
      }
    }

    if (contact.val() == "") {
      ErrorMsg = "Number field is required";
      addError(contact_label, contact, ErrorMsg);
      error = true;
      return false;
    } else {
      if (isValidNumber(contact.val()) == false) {
        ErrorMsg = "Number is not valid (ony 10 digit without country code)";
        addError(contact_label, contact, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(contact_label, contact);
      }
    }

    if (email.val() != "") {
      if (isValidEmail(email.val()) == false) {
        ErrorMsg = "Email is not valid";
        addError(email_label, email, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(email_label, email);
      }
    }

    if (followdate.val() == "") {
      ErrorMsg = "Date to follow cannot be blank";
      addError(followdate_label, followdate, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(followdate_label, followdate);
    }

    // if (address.val() == '') {
    //     ErrorMsg = "Address cannot be blank";
    //     addError(address_label, address, ErrorMsg);
    //     error = true;
    //     return false;
    // } else {
    //     error = false;
    //     removeError(address_label, address);
    // }

    if (enquiry_for.val() == "") {
      ErrorMsg = "Enquiry for cannot be blank";
      addError(enquiry_for_label, enquiry_for, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(enquiry_for_label, enquiry_for);
    }

    if (enquiry_type.val() == "") {
      ErrorMsg = "Enquiry type cannot be blank";
      addError(enquiry_type_label, enquiry_type, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(enquiry_type_label, enquiry_type);
    }

    // if (response.val() == '') {
    //     ErrorMsg = "Response cannot be blank";
    //     addError(response_label, response, ErrorMsg);
    //     error = true;
    //     return false;
    // } else {
    //     error = false;
    //     removeError(response_label, response);
    // }

    if (source_of_enquiry.val() == "") {
      ErrorMsg = "Source of enquiry cannot be blank";
      addError(source_of_enquiry_label, source_of_enquiry, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(source_of_enquiry_label, source_of_enquiry);
    }

    // if (leaduser.val() == '') {
    //     ErrorMsg = "Lead representative cannot be blank";
    //     addError(leaduser_label, leaduser, ErrorMsg);
    //     error = true;
    //     return false;
    // } else {
    //     error = false;
    //     removeError(leaduser_label, leaduser);
    // }

    if (status.val() == "") {
      ErrorMsg = "Status cannot be blank";
      addError(status_label, status, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(status_label, status);
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

            if (myObj.data.status == "Converted") {
              var url = "";
              if (myObj.data.enquiry_table_type == "service") {
                url = `./appointment.php?leadid=${myObj.data.id}`;
              }

              if (myObj.data.enquiry_table_type == "package") {
                url = `./billing-bill.php?leadid=${myObj.data.id}`;
              }

              if (myObj.data.enquiry_table_type == "membership") {
                url = `./billing-bill.php?leadid=${myObj.data.id}`;
              }

              if (myObj.data.enquiry_table_type == "stock") {
                url = `./billing-bill.php?leadid=${myObj.data.id}`;
              }

              window.location = url;
            } else {
              $("#clientModalClose").click();
              showAlert("Enquiry added successfully");
              Swal.fire(
                "Good job!",
                "New Enquiry Added successfully",
                "success"
              ).then((result) => {
                document.getElementById("AddEnquiryForm").reset();
                loadClientTable();
                setTimeout(dataTableLoad, 3000);
                window.location = './enquiry.php';
              });
            }
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
  });

  $("#EditEnquiryForm").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#EditEnquiryForm");
    var url = form.attr("action");

    var client_name = $(".client_name");
    var client_name_label = $(".client_name_label");

    var contact = $(".contact");
    var contact_label = $(".contact_label");

    var email = $(".email");
    var email_label = $(".email_label");

    var address = $(".address");
    var address_label = $(".address_label");

    var enquiry_for = $(".enquiry_for");
    var enquiry_for_label = $(".enquiry_for_label");

    var enquiry_type = $(".enquiry_type");
    var enquiry_type_label = $(".enquiry_type_label");

    var response = $(".response");
    var response_label = $(".response_label");

    var followdate = $(".followdate");
    var followdate_label = $(".followdate_label");

    var source_of_enquiry = $(".source_of_enquiry");
    var source_of_enquiry_label = $(".source_of_enquiry_label");

    var leaduser = $(".leaduser");
    var leaduser_label = $(".leaduser_label");

    var status = $(".status");
    var status_label = $(".status_label");

    var error = false;
    var ErrorMsg = "";

    if (client_name.val() == "") {
      ErrorMsg = "Client Name field is required";
      addError(client_name_label, client_name, ErrorMsg);
      error = true;
      return false;
    } else {
      if (isValidName(client_name.val()) == false) {
        ErrorMsg = "Client Name is not valid";
        addError(client_name_label, client_name, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(client_name_label, client_name);
      }
    }

    if (contact.val() == "") {
      ErrorMsg = "Number field is required";
      addError(contact_label, contact, ErrorMsg);
      error = true;
      return false;
    } else {
      if (isValidNumber(contact.val()) == false) {
        ErrorMsg = "Number is not valid (ony 10 digit without country code)";
        addError(contact_label, contact, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(contact_label, contact);
      }
    }

    if (email.val() != "") {
      if (isValidEmail(email.val()) == false) {
        ErrorMsg = "Email is not valid";
        addError(email_label, email, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(email_label, email);
      }
    }

    if (followdate.val() == "") {
      ErrorMsg = "Date to follow cannot be blank";
      addError(followdate_label, followdate, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(followdate_label, followdate);
    }

    // if (address.val() == '') {
    //     ErrorMsg = "Address cannot be blank";
    //     addError(address_label, address, ErrorMsg);
    //     error = true;
    //     return false;
    // } else {
    //     error = false;
    //     removeError(address_label, address);
    // }

    if (enquiry_for.val() == "") {
      ErrorMsg = "Enquiry for cannot be blank";
      addError(enquiry_for_label, enquiry_for, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(enquiry_for_label, enquiry_for);
    }

    if (enquiry_type.val() == "") {
      ErrorMsg = "Enquiry type cannot be blank";
      addError(enquiry_type_label, enquiry_type, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(enquiry_type_label, enquiry_type);
    }

    // if (response.val() == '') {
    //     ErrorMsg = "Response cannot be blank";
    //     addError(response_label, response, ErrorMsg);
    //     error = true;
    //     return false;
    // } else {
    //     error = false;
    //     removeError(response_label, response);
    // }

    if (source_of_enquiry.val() == "") {
      ErrorMsg = "Source of enquiry cannot be blank";
      addError(source_of_enquiry_label, source_of_enquiry, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(source_of_enquiry_label, source_of_enquiry);
    }

    // if (leaduser.val() == '') {
    //     ErrorMsg = "Lead representative cannot be blank";
    //     addError(leaduser_label, leaduser, ErrorMsg);
    //     error = true;
    //     return false;
    // } else {
    //     error = false;
    //     removeError(leaduser_label, leaduser);
    // }

    if (status.val() == "") {
      ErrorMsg = "Status cannot be blank";
      addError(status_label, status, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(status_label, status);
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

            if (myObj.data.status == "Converted") {
              var url = "";
              if (myObj.data.enquiry_table_type == "service") {
                url = `./appointment.php?leadid=${myObj.data.id}`;
              }

              if (myObj.data.enquiry_table_type == "package") {
                url = `./billing.php?leadid=${myObj.data.id}`;
              }

              if (myObj.data.enquiry_table_type == "membership") {
                url = `./billing.php?leadid=${myObj.data.id}`;
              }

              if (myObj.data.enquiry_table_type == "stock") {
                url = `./billing.php?leadid=${myObj.data.id}`;
              }

              window.location = url;
            } else {
              $("#clientModalClose").click();
              showAlert("Enquiry updated successfully");
              Swal.fire(
                "Good job!",
                "Enquiry Updated successfully",
                "success"
              ).then((result) => {
                window.location = "./enquiry.php";
                // document.getElementById("EditEnquiryForm").reset();
                // loadClientTable();
                // setTimeout(dataTableLoad, 3000);
              });
            }
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
  });

  loadClient();
  loadClientTable();
  setTimeout(dataTableLoad, 2000);

  $(".client_name")
    .autocomplete({
      source: function (request, response) {
        $.getJSON(
          "inc/client/get-client-list.php",
          { client_name: request.term },
          response
        );
      },
      minLength: 1,
      open: function (event, ui) { },
      select: function (event, ui) {
        $(this).val(ui.item.client_name);
        clientView(ui.item.id);
      },
    })
    .addClass("whatever");
  $(".client_name").on("autocompleteopen", function (event, ui) { });

  $(".contact")
    .autocomplete({
      source: function (request, response) {
        $.getJSON(
          "inc/client/get-client-list.php",
          { contact: request.term },
          response
        );
      },
      minLength: 1,
      open: function (event, ui) { },
      select: function (event, ui) {
        $(this).val(ui.item.contact);
        clientView(ui.item.id);
      },
    })
    .addClass("whatever");
  $(".contact").on("autocompleteopen", function (event, ui) { });

  var timestamp =
    getServerFormatDate(getTodayDate()) + " " + getCurrentTime("HH");
  $(".enquiry_for_title")
    .autocomplete({
      source: function (request, response) {
        $.getJSON(
          "inc/enquiry/get-enquiry-for.php",
          {
            terms: request.term,
            timestamp: timestamp,
            category_id: "",
          },
          response
        );
      },
      minLength: 1,
      open: function (event, ui) { },
      select: function (event, ui) {
        console.log(ui.item);
        $(this).val(ui.item.value);
        $("#enquiry_for").val(ui.item.id);
        $("#enquiry_table_type").val(ui.item.type);
      },
    })
    .addClass("whatever");
  $(".enquiry_for_title").on("autocompleteopen", function (event, ui) { });

  $(".filterenquiry_for_title")
    .autocomplete({
      source: function (request, response) {
        $.getJSON(
          "inc/enquiry/get-enquiry-for.php",
          { terms: request.term },
          response
        );
      },
      minLength: 1,
      open: function (event, ui) { },
      select: function (event, ui) {
        console.log(ui.item);
        $(this).val(ui.item.value);
        $("#filterenquiry_for").val(ui.item.id);
        $("#filterenquiry_table_type").val(ui.item.type);
      },
    })
    .addClass("whatever");
  $(".filterenquiry_for_title").on("autocompleteopen", function (event, ui) { });
});

function clientView(id) {
  $.ajax({
    url: "inc/client/get-client-view.php",
    type: "POST",
    data: { client_id: id },
    success: function (data) {
      if (data != "") {
        var ds = JSON.parse(data);
        setValue(ds);
      }
    },
    error: function () { },
  });
}

function setValue(data) {
  console.log(data);
  $("#client_id").val(data.id);
  $("#client_name").val(data.client_name);
  $("#contact").val(parseInt(data.contact));
}

function loadClient() {
  $.ajax({
    type: "POST",
    url: "./inc/client/client-existing.php",
    success: function (result) {
      setExistingClient(result);
    },
  });
}

function loadClientTable(formData = "") {
  $.ajax({
    type: "POST",
    url: "./inc/enquiry/enquiry-show.php",
    data: formData,
    success: function (result) {
      setTable(result);
    },
  });
}

function dataTableLoad() {
  $("#dataTable").DataTable();
}

function setLeading() {
  $(".overview-existing").html("loading...");
  $(".table-data").html("loading...");
}

function setExistingClient(result) {
  $(".overview-existing").html(result);
}

function setTable(result) {
  $(".table-data").html(result);
}

// client delete logic
function clientDelete(v) {
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
      Swal.fire("Deleted!", "Enquiry deleted successfully.", "success");

      $.ajax({
        type: "POST",
        url: "inc/enquiry/enquiry-delete.php",
        data: { id: v },
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
            loadClientTable();
            setTimeout(dataTableLoad, 3000);
          }
        },
        error: function (data) { },
      });
    }
  });
}

setLeading();
setTomarrowDate();

function setTomarrowDate() {
  $(".followdate").val(tomorrowDate());
}

$(document).ready(function () {
  $("#filterForm").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    loadClientTable(formValues);
    setTimeout(dataTableLoad, 3000);
  });
});

$(document).ready(function () {
  const picker2 = datepicker(".followdate", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });
});

function onTimeChange(time) {
  var timeSplit = time.split(":"),
    hours,
    minutes,
    meridian;
  hours = timeSplit[0];
  minutes = timeSplit[1];
  if (hours > 12) {
    meridian = "PM";
    hours -= 12;
  } else if (hours < 12) {
    meridian = "AM";
    if (hours == 0) {
      hours = 12;
    }
  } else {
    meridian = "PM";
  }
  return (hours < 9 ? "0" : "") + hours + ":" + minutes + " " + meridian;
}

// function to change 12 hour time into 24 time
function time12to24(time) {
  var time = time;
  var hours = Number(time.match(/^(\d+)/)[1]);
  var minutes = Number(time.match(/:(\d+)/)[1]);
  var AMPM = time.match(/\s(.*)$/)[1];
  if (AMPM == "PM" && hours < 12) hours = hours + 12;
  if (AMPM == "AM" && hours == 12) hours = hours - 12;
  var sHours = hours.toString();
  var sMinutes = minutes.toString();
  if (hours < 10) sHours = "0" + sHours;
  if (minutes < 10) sMinutes = "0" + sMinutes;
  return sHours + ":" + sMinutes + ":00";
}

// function to check appointment time of salon
function checkappTime(id, time, errorDivId) {
  var sstime, eetime;
  var date = $("#date").val();
  if (date != "") {
    if (time != "") {
      $("#date").removeClass("invalid");
      $.ajax({
        url: "ajax/system_details.php",
        method: "POST",
        dataType: "json",
        data: { date: date, action: "checkapptime" },
        success: function (response) {
          if (response.status == "1") {
            sstime = response.starttime;
            eetime = response.endtime;
            var stime = Date.parse("20 Aug 2000 " + sstime);
            var etime = Date.parse("20 Aug 2000 " + eetime);
            var cpmtime = Date.parse("20 Aug 2000 " + time + ":00");
            if (stime == "" || etime == "") {
              //alert('Please select working hours in system setting tab.');
            } else {
              var et_status = "0";
              if ((cpmtime < stime || cpmtime > etime) && et_status != "1") {
                $("#" + id).val("");
                if (errorDivId != "") {
                  $("#" + errorDivId).text(
                    "Select between " +
                    onTimeChange(sstime) +
                    " to " +
                    onTimeChange(eetime)
                  );
                  // appointmenttime();
                  //$('.ser').prop('disabled',true);
                  //$('.ser').val('');
                }
              } else {
                var d = new Date();
                var dd = new Date(date);
                if (d.toDateString() === dd.toDateString()) {
                  if (
                    Date.parse("'" + date + "' '" + time + ":59") <
                    Date.parse(d)
                  ) {
                    $("#" + errorDivId).text("Past time not allowed");
                    $("#time").val("");
                  } else {
                    $("#" + errorDivId).text("");
                    //$('.ser').prop('disabled',false);
                    //$('.ser').val('');
                    $("#close_time").val(eetime);
                    $("#time").removeClass("invalid");
                  }
                } else {
                  $("#" + errorDivId).text("");
                  //$('.ser').prop('disabled',false);
                  //$('.ser').val('');
                  $("#close_time").val(eetime);
                  $("#time").removeClass("invalid");
                }
                if ($(".ser").val() != "") {
                  appointmenttime();
                }
              }
            }
          } else if (response.status == "0") {
            $("#" + id).val("");
            $("#" + errorDivId).text("Appointment not available");
            //$('.ser').prop('disabled',true);
          }
        },
      });
    } else {
      $("#" + errorDivId).text("Please select time");
    }
  } else {
    $("#date").addClass("invalid");
    $("#time").val("");
    $("#time").removeClass("invalid");
  }
}

// check date availability
function dateAvailability(date) {
  if (date != "") {
    $("#date").removeClass("invalid");
    $.ajax({
      url: "ajax/system_details.php",
      method: "POST",
      dataType: "json",
      data: { date: date, action: "checkDate" },
      success: function (response) {
        if (response.status == 0) {
          $("#date").val("");
          $("#dateerror").text("Salon will be closed");
        } else {
          $("#dateerror").text("");
          checkappTime("time", $("#time").val(), "apptime");
        }
      },
    });
  } else {
    $("#date").addClass("invalid");
  }
}

$("#filterEnquiry").on("submit", function (event) {
  event.preventDefault();
  var formValues = $(this).serialize();

  loadClientTable(formValues);
  setTimeout(dataTableLoad, 3000);
});

function ExportToExcel(type, fn, dl) {
  var mytable = document.getElementById("dataTable");
  TableToExcel.convert(mytable);
}

$("#enqchk").click(function () {
  if ($(this).prop("checked") == true) {
    $(".chkk").prop("checked", true);
  } else if ($(this).prop("checked") == false) {
    $(".chkk").prop("checked", false);
  }
});

//document.addEventListener("DOMContentLoaded", () => {
$(document).ready(function () {
  var monthdate = new Date(),
    y = monthdate.getFullYear(),
    m = monthdate.getMonth();
  var firstDay = new Date(y, m, 1);
  var lastDay = new Date(y, m + 1, 0);

  $('input[name="filterfollowdate"]').daterangepicker(
    {
      opens: "left",
      startDate: getDateFromObj(firstDay),
      endDate: getDateFromObj(lastDay),
    },
    function (start, end, label) {
      //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    }
  );

  //dataTableLoad2();
});
