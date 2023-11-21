$(document).ready(function () {
  $(".search_client_name")
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
        $(this).val(ui.item.value);
        $("#client").val(ui.item.id);
        clientView(ui.item.id);
      },
    })
    .addClass("whatever");
  $(".search_client_name").on("autocompleteopen", function (event, ui) { });

  $(".search_client_number")
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
        $(this).val(ui.item.value);
        $("#cont").val(ui.item.id);
        clientView(ui.item.id);
      },
    })
    .addClass("whatever");
  $(".search_client_number").on("autocompleteopen", function (event, ui) { });

  $(".billing_search_client_name")
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
        $(this).val(ui.item.value);
        $("#client_name").val(ui.item.id);
        billingClientView(ui.item.id);
      },
    })
    .addClass("whatever");
  $(".billing_search_client_name").on("autocompleteopen", function (event, ui) { });


  $(".billing_search_client_number")
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
        $(this).val(ui.item.value);
        $("#contact").val(ui.item.id);
        billingClientView(ui.item.id);
      },
    })
    .addClass("whatever");
  $(".billing_search_client_number").on("autocompleteopen", function (event, ui) { });

  $("#appointmentAdd").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#appointmentAdd");
    var url = form.attr("action");

    // var clientName = $('#client_name');
    // var contact = $('#contact');
    // var email = $('#email');
    // var labelemail = $('.email-label');

    // var labelClientName = $('.client_name');
    // var labelClientNumber = $('.client_number');

    // var gender = $('#gender');
    // var labelGender = $('#labelGender');

    var error = false;
    var ErrorMsg = "";
    // if (clientName.val() == '') {
    //     ErrorMsg = "Client Name field is required";
    //     addError(labelClientName, clientName, ErrorMsg);
    //     error = true;
    //     return false;
    // } else {

    //     if (isValidName(clientName.val()) == false) {
    //         ErrorMsg = "Client Name is not valid";
    //         addError(labelClientName, clientName, ErrorMsg);
    //         error = true;
    //         return false;
    //     } else {
    //         error = false;
    //         removeError(labelClientName, clientName);
    //     }
    // }

    // if (contact.val() == '') {
    //     ErrorMsg = "Client Number field is required";
    //     addError(labelClientNumber, contact, ErrorMsg);
    //     error = true;
    //     return false;
    // } else {
    //     if (isValidNumber(contact.val()) == false) {
    //         ErrorMsg = "Number is not valid (ony 10 digit without country code)";
    //         addError(labelClientNumber, contact, ErrorMsg);
    //         error = true;
    //         return false;
    //     } else {
    //         error = false;
    //         removeError(labelClientNumber, contact);
    //     }
    // }

    // if (gender.val() == '') {
    //     ErrorMsg = "Gender cannot be blank";
    //     addError(labelGender, gender, ErrorMsg);
    //     error = true;
    //     return false;
    // } else {
    //     error = false;
    //     removeError(labelGender, gender);
    // }

    // if (email.val() != '') {

    //     if (isValidEmail(email.val()) == false) {
    //         ErrorMsg = "Email is not valid";
    //         addError(labelemail, email, ErrorMsg);
    //         error = true;
    //         return false;
    //     } else {
    //         error = false;
    //         removeError(labelemail, email);
    //     }
    // }

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
          const myObj = JSON.parse(data);

          instanceLoading.hideLoading()
          if (myObj.success == true) {
            // $('#exampleModal').hide();
            // $('.modal-backdrop').hide();
            showAlert("Appointment Saved Successfully");
            Swal.fire(
              "Good job!",
              "Appointment Saved Successfully",
              "success"
            ).then((result) => {
              document.getElementById("appointmentAdd").reset();
              location.reload();
            });
          } else {
            $(".server-error").css("display", "block");
            $("#error-message").html(myObj.errors.error);
            showAlert(myObj.errors.error, "red");
          }
        },
        error: function (data) {
          $(".server-error").show();
          $("#error-message").html(myObj.errors.error);
          showAlert("Something went wrong", "red");
          instanceLoading.hideLoading()
        },
      });
    }
  });

  $("#billingAdd").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#billingAdd");
    var url = form.attr("action");

    // var clientName = $('#client_name');
    // var contact = $('#contact');
    // var email = $('#email');
    // var labelemail = $('.email-label');

    // var labelClientName = $('.client_name');
    // var labelClientNumber = $('.client_number');

    // var gender = $('#gender');
    // var labelGender = $('#labelGender');

    var error = false;
    var ErrorMsg = "";
    // if (clientName.val() == '') {
    //     ErrorMsg = "Client Name field is required";
    //     addError(labelClientName, clientName, ErrorMsg);
    //     error = true;
    //     return false;
    // } else {

    //     if (isValidName(clientName.val()) == false) {
    //         ErrorMsg = "Client Name is not valid";
    //         addError(labelClientName, clientName, ErrorMsg);
    //         error = true;
    //         return false;
    //     } else {
    //         error = false;
    //         removeError(labelClientName, clientName);
    //     }
    // }

    // if (contact.val() == '') {
    //     ErrorMsg = "Client Number field is required";
    //     addError(labelClientNumber, contact, ErrorMsg);
    //     error = true;
    //     return false;
    // } else {
    //     if (isValidNumber(contact.val()) == false) {
    //         ErrorMsg = "Number is not valid (ony 10 digit without country code)";
    //         addError(labelClientNumber, contact, ErrorMsg);
    //         error = true;
    //         return false;
    //     } else {
    //         error = false;
    //         removeError(labelClientNumber, contact);
    //     }
    // }

    // if (gender.val() == '') {
    //     ErrorMsg = "Gender cannot be blank";
    //     addError(labelGender, gender, ErrorMsg);
    //     error = true;
    //     return false;
    // } else {
    //     error = false;
    //     removeError(labelGender, gender);
    // }

    // if (email.val() != '') {

    //     if (isValidEmail(email.val()) == false) {
    //         ErrorMsg = "Email is not valid";
    //         addError(labelemail, email, ErrorMsg);
    //         error = true;
    //         return false;
    //     } else {
    //         error = false;
    //         removeError(labelemail, email);
    //     }
    // }

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
          const myObj = JSON.parse(data);
          instanceLoading.hideLoading()
          if (myObj.success == true) {
            // $('#exampleModal').hide();
            // $('.modal-backdrop').hide();
            showAlert("Invoice Created Successfully");
            Swal.fire(
              "Good job!",
              "Invoice Created Successfully",
              "success"
            ).then((result) => {
              document.getElementById("billingAdd").reset();
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
  });
});

function clientView(id) {
  $.ajax({
    url: "inc/client/get-client-view.php",
    type: "POST",
    data: { client_id: id },
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
      if (data != "") {
        instanceLoading.hideLoading()
        var ds = JSON.parse(data);
        setValue(ds);
        /*
        // $('#last_visit').html('----');
        if (ds["lastvisit"] != "") {
          $("#last_visit").html(ds["lastvisit"]);
        } else {
          $("#last_visit").html("");
        }

        if (ds["branch_name"] != "") {
          $("#branch_name").html(ds["branch_name"]);
        } else {
          $("#branch_name").html("");
        }

        $("#total_visit").html(ds["total_visit"]);
        $("#total_spending").html(ds["total_spending"] + " INR");
        $("#membership").html(ds["membership"]);
        if (ds["packages"] != "") {
          $("#active_package").html(
            ds["packages"] +
              '<br><a href="javascript:void(0)" onClick="viewPackageModal(' +
              id +
              ')"><i class="icon-eye3"></i> View details</a>'
          );
        } else {
          $("#active_package").html("----");
        }
        $("#earned_points").html(ds["reward_points"]);
        $("#reward_point").val(ds["reward_points"]);
        $("#last_feedback").html(ds["last_feedback"]);
        $("#wallet").html(ds["wallet"] + " INR");
        $("#wallet_money").val(ds["wallet"]);
*/
        $("#gender option").attr("selected", false);
        if (ds["gender"] != "") {
          var ggen = ds["gender"] == "male" ? 1 : 2;
          $("#gender #gn-" + ggen).attr("selected", true);
        } else {
          $("#gender #gn-1").attr("selected", true);
        }
        /*
        if (ds["dob"] != "0000-00-00") {
          $("#clientdob").val(ds["dob"]);
        } else {
          $("#clientdob").val("");
        }
        if (ds["Anniversary"] != "0000-00-00") {
          $("#anniversary").val(ds["anniversary"]);
        } else {
          $("#anniversary").val("");
        }
        $('#leadsource option[value="' + ds["source_of_client"] + '"]').prop(
          "selected",
          true
        );
        $(".divloader").remove();

        if (ds["customer_type"] == "active") {
          $("#customer_type").html(
            "<div style='background:#00a400; margin:10px 0; padding:10px; border-radius:3px;'><h4 style='margin-bottom:0; color:#fff;'>Customer type: Active</h4><small class='text-white'>Active Customers - Customers who visit your outlet at regular intervals.  </small></div>"
          );
        } else if (ds["customer_type"] == "inactive") {
          $("#customer_type").html(
            "<div style='background:#fa383e; margin:10px 0; padding:10px; border-radius:3px;'><h4 style='margin-bottom:0; color:#fff;'>Customer type: Defected customer</h4><small class='text-white'>Defected Customers - Customers who haven't visited your outlet and become inactive. </small></div>"
          );
        } else if (ds["customer_type"] == "newcustomer") {
          $("#customer_type").html(
            "<div style='background:#622bfb; margin:10px 0; padding:10px; border-radius:3px;'><h4 style='margin-bottom:0; color:#fff;'>Customer type: New Customer</h4><small class='text-white'>Customer who haven't visited your outlet. </small></div>"
          );
        } else {
          $("#customer_type").html(
            "<div  style='background:#fff200; margin:10px 0; padding:10px; border-radius:3px;'><h4 style='margin-bottom:0;'>Customer type: Churn prediction</h4><small >Churn Prediction - Customers who haven't visited your outlet and who are likely to leave. </small> </div>"
          );
        }
        $(".client-view-content").fadeIn();
        */
      }
    },
    error: function () {
      instanceLoading.hideLoading()
    },
  });
}


function billingClientView(id) {

  $.ajax({
    url: "inc/client/get-client-view.php",
    type: "POST",
    data: { client_id: id },

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
      if (data != "") {
        instanceLoading.hideLoading()
        var ds = JSON.parse(data);
        billingSetValue(ds);
        /*// $('#last_visit').html('----');
        if (ds["lastvisit"] != "") {
          $("#last_visit").html(ds["lastvisit"]);
        } else {
          $("#last_visit").html("");
        }

        if (ds["branch_name"] != "") {
          $("#branch_name").html(ds["branch_name"]);
        } else {
          $("#branch_name").html("");
        }

        $("#total_visit").html(ds["total_visit"]);
        $("#total_spending").html(ds["total_spending"] + " INR");
        $("#membership").html(ds["membership"]);
        if (ds["packages"] != "") {
          $("#active_package").html(
            ds["packages"] +
              '<br><a class="text-nowrap cursor-pointer" onClick="clientPackageModal(' +
              id +
              ')"><i class="fa fa-eye text-nowrap"></i> View Details</a>'
          );
        } else {
          $("#active_package").html("----");
        }
        $("#earned_points").html(ds["reward_points"]);
        $("#reward_point").val(ds["reward_points"]);
        $("#last_feedback").html(ds["last_feedback"]);
        $("#wallet").html(ds["wallet"] + " INR");
        $("#wallet_money").val(ds["wallet"]);

        $("#bill_pending_amount").html(ds["bill_pending_amount"] + " INR");
        $("#bill_pending_amount_input").val(ds["bill_pending_amount"]);
*/
        $("#billing_gender option").attr("selected", false);
        if (ds["gender"] != "") {
          var ggen = ds["gender"] == "male" ? 1 : 2;
          $("#billing_gender #gn-" + ggen).attr("selected", true);
        } else {
          $("#billing_gender #gn-1").attr("selected", true);
        }/*

        if (ds["dob"] != "0000-00-00") {
          $("#clientdob").val(ds["dob"]);
        } else {
          $("#clientdob").val("");
        }
        if (ds["Anniversary"] != "0000-00-00") {
          $("#anniversary").val(ds["anniversary"]);
        } else {
          $("#anniversary").val("");
        }
        $('#leadsource option[value="' + ds["source_of_client"] + '"]').prop(
          "selected",
          true
        );
        $(".divloader").remove();

        if (ds["customer_type"] == "active") {
          $("#customer_type").html(
            "<div style='background:#00a400' class='rounded p-1'><h4 class='h5 b-0 text-white'>Customer type: Active</h4><small class='text-white'>Active Customers - Customers who visit your outlet at regular intervals.  </small></div>"
          );
        } else if (ds["customer_type"] == "inactive") {
          $("#customer_type").html(
            "<div style='background:#fa383e' class='rounded p-1'><h4 class='h5 b-0 text-white'>Customer type: Defected Customer</h4><small class='text-white'>Defected Customers - Customers who haven't visited your outlet and become inactive. </small></div>"
          );
        } else if (ds["customer_type"] == "newcustomer") {
          $("#customer_type").html(
            "<div style='background:#622bfb' class='rounded p-1'><h4 class='h5 b-0 text-white'>Customer type: New Customer</h4><small class='text-white'>Customer who haven't visited your outlet. </small></div>"
          );
        } else {
          $("#customer_type").html(
            "<div  style='background:#fff200' class='rounded p-1'><h4 class='h5 b-0 text-dark' >Customer type: Churn Prediction</h4><small >Churn Prediction - Customers who haven't visited your outlet and who are likely to leave. </small> </div>"
          );
        }
        $(".client-view-content").fadeIn();
        */
      }
    },
    error: function () {
      instanceLoading.hideLoading()
    },
  });
}

function setValue(item) {
  $("#client").val(item.client_name);
  $("#client_id").val(item.id);
  $("#cont").val(item.contact);
  //hideLoader()
}

function billingSetValue(item) {
  console.log(item);
  $("#client_name").val(item.client_name);
  $("#billing_client_id").val(item.id);
  $("#contact").val(item.contact);
  $("#email_id").val(item.email);
  $("#billing_gender").val(item.gender)
  //hideLoader()
}

function appointment(inv, inv_id) {
  var row = $("#modal-body");
  row.find(".name").html("loading...");
  row.find(".service").html("loading...");
  row.find(".appstaff").html("loading...");
  $("#appointment_modal").modal("show");
  $.ajax({
    url: "./inc/appointment/get-appointment-details.php",
    data: {
      inv: inv_id,
      appointmentServiceId: inv,
    },
    type: "POST",
    success: function (data) {
      var row = $("#modal-body");
      var ds = JSON.parse(data.trim());

      row.find(".name").html(ds["client"]);
      row.find(".service").html(ds["service"]);
      row.find(".appstaff").html(ds["beautician"]);
      row.find(".spnotes").html(ds["notes"]);
      row.find(".apdate").html(ds["date"]);
      row.find(".aptime").html(ds["start_time"] + " To " + ds["end_time"]);
      row.find("#checkin_app_id").val(inv);
      if (ds["checkin_status"] == 1) {
        $("#checkin").hide();
        $("#checkin_time").remove();
        $("#modal-body tbody").append(
          '<tr id="checkin_time"><th>Check In Time</th><td>' +
          ds["checkin_time"] +
          "</td></tr>"
        );
      } else {
        $("#checkin").show();
        $("#checkin_time").remove();
      }
      if (ds["bill_status"] == "1") {
        $("#but").hide();
        $("#bill_cancel").hide();
        $("#checkin").hide();
        // $('#bill').show();
      } else if (ds["appointment_status"] == "Cancelled") {
        $("#bill_cancel").show();
        $("#but").hide();
        $("#checkin").hide();
      } else {
        // $('#bill').hide();
        $("#but").show();
        $("#bill_cancel").hide();
        $("#edit_md_btn").attr("href", "appointment.php?id=" + ds['appointment_id']);
        $("#conv_md_btn").attr("href", "billing-bill.php?aid=" + ds['appointment_id']);
      }
    },
    error: function () { },
  });
}
function appointmentedit(inv) {
  $("#but").html("loading...");
  jQuery.ajax({
    url: "ajax/invbuttons.php?inv=" + inv,
    type: "POST",
    success: function (data) {
      $("#but").html(data);
    },
    error: function () { },
  });
}

function markCheckIn() {
  var app_id = $("#checkin_app_id").val();
  $.ajax({
    url: "./inc/appointment/appointment-mark-checkin.php",
    type: "POST",
    data: {
      action: "mark_checkin",
      sid: app_id,
    },
    dataType: "JSON",
    beforeSend: function () {
      instanceLoading.showLoading({
        type: 'cube_flip',
        color: '#ffffff',
        backgroundColor: '#025043',
        title: 'Loading...',
        fontSize: 16,
      });
    },
    success: function (res) {
      instanceLoading.hideLoading()
      if (res.success == true) {
        showAlert("Checked in successfully.");
        Swal.fire("Good job!", "Checked in successfully.", "success").then(
          (result) => {
            window.location.reload();
          }
        );
      } else {
        alert("Error occured, please try again.");
      }
    },
    error: function (data) {
      $(".server-error").show();
      $("#error-message").html(myObj.errors.error);
      showAlert("Something went wrong", "red");
      instanceLoading.hideLoading()
    },
  });
}

function set_calendar_width() {
  var no_of_providers = "30";
  if (no_of_providers > 4) {
    var table_width = 1000;
    var extra_width = (no_of_providers - 4) * 100;
    table_width += extra_width;
    $(".fc-view").find("table").width(table_width);
  }

  $(
    ".fc-resourceTimeGridDay-button,.fc-resourceTimeGridWeek-button,.fc-resourceDayGridMonth-button"
  ).click(function () {
    if (no_of_providers > 4) {
      var table_width = 1000;
      var extra_width = (no_of_providers - 4) * 100;
      table_width += extra_width;
      $(".fc-view").find("table").width(table_width);
    }
  });
}

function addServiceProviderServices() {
  //var box = $('#service-provider-services');

  var endTime = $(".end_time1");

  var prevElem = $("#addBefore");
  var preEndTime = $(prevElem).prev().find(".end_time1");

  old_staff = prevElem.prev().find(".app-staff");

  if ($(preEndTime).val() != "") {
    var preEndTimeName = $(preEndTime).attr("name");

    var trdata = preEndTimeName.replace(/[^0-9]/gi, "");
    var arrayKey = parseInt(parseInt(trdata, 10) + 1);

    const mainHtml = `
                  <tr>
                      <td style="vertical-align: middle;">
                          <span class="sno text-danger" onclick='removeServiceProviderServices(this);changeTiming(this);'><i class="fas fa-trash"></i></span>
                      </td>
                      <td>
                          <div class="row" style="width: 400px;">
                              <div class="col-12 pr-1">
                                  <input type="hidden" class="ser_cat_id" name="appointment_service[${arrayKey}][service_cat_id]" value="0">
                                  <input type="text" class="category-services form-control form-control-sm" name="" onkeyup="searchServices(this)" placeholder="Service (Autocomplete)" required autocomplete="off">
                                  <input type="hidden" name="appointment_service[${arrayKey}][service_id]" value="" class="serr">
                                  <input type="hidden" name="service[]" value="9" class="serr">
                                  <input type="hidden" name="durr[]" value="" class="durr">
                                  <input type="hidden" name="pa_ser[]" value="" class="pa_ser">
                                  <input type="hidden" name="appointment_service[${arrayKey}][service_discount]" class="form-control form-control-sm d-input service-discount" value="0">
                                  <input type="hidden" name="appointment_service[${arrayKey}][service_discount_type]" class="form-control form-control-sm d-input service-discount" value="percentage">
                              </div>
                          </div>
                      </td>
                      <td>
                          <div class="row mb-1" id="service-provider-box" style="width: 200px;">
                              <div class="col-12 pr-1">
                                  <select name="appointment_service[${arrayKey}][sp_id][0][service_provider_id]" class="form-select form-select-sm app-staff" onchange="checkAvailabalityServiceProvider(this)" required>
                                    ${old_staff.html()}
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
                                  <input type="text" class="form-control form-control-sm start_time1 w-100" placeholder="Start time" name="appointment_service[${arrayKey}][start_time]" onclick="initTimePicker(this)" onchange="changeTimeValue(this)" readonly>
                                  <input type="hidden" class='start_timestamp' name='appointment_service[${arrayKey}][start_timestamp]'>
                                  </div>
                              <div class="col-6 pl-1">
                                  <input type="text" class="form-control form-control-sm end_time1 w-100" name="appointment_service[${arrayKey}][end_time]" placeholder="End time" readonly>
                                  <input type="hidden" class='end_timestamp' name='appointment_service[${arrayKey}][end_timestamp]'>
                              </div>
                          </div>
                      </td>
  
                      <td>
                          <input type="number" class="form-control form-control-sm service-price" name="appointment_service[${arrayKey}][price]" placeholder="0" value="0" oninput="changeTotalPrice()" readonly>
                          <input type="hidden" class="old-price">
                      </td>
                  </tr>`;

    const addBefore = prevElem;
    addBefore.before(mainHtml);
  }
}

function removeServiceProviderServices(elem) {
  //$(elem).parent().parent().hide();
  $(elem).parent().parent().remove();

  countPackage();
}

function removeBillingServiceProviderServices(elem) {
  //$(elem).parent().parent().hide();
  $(elem).parent().parent().remove();

  countBillingPackage();
}

function checkAvailabalityServiceProvider(elem) {
  var staff_id = $(elem).val();

  var starttime = $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".start_time1")
    .val();
  var endtime = $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".end_time1")
    .val();
  var select_staff = $(elem).parents("tr").find('.app-staff option[value=""]');

  var serviceId = $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".serr")
    .val();

  date = $("#date").val();
  time = $("#time").val();

  if (starttime != "" && staff_id != "" && serviceId != "") {
    $.ajax({
      url: "./inc/service-provider/check-service-provider-availability.php",
      type: "POST",
      data: {
        staff_id: staff_id,
        date: date,
        time: time,
        starttime: starttime,
        endtime: endtime,
      },
      success: function (data) {
        var ds = JSON.parse(data.trim());
        starttime = ds["start"];
        endtime = ds["end"];

        /*if (ds["available"] == "1") {
          showAlert(ds["spcat"] + " Available.");
        } else {
          showAlert(ds["spcat"] + " Unavailable.", "red");
        }*/

        if (ds["success"] == "0") {
          showAlert(ds["data"]["spcat"] + " Available.");
        } else if (ds["success"] == "1") {
          showAlert(ds["data"]["spcat"] + " Unavailable.", "red");
          //select_staff.prop("selected", true);
          //serviceProviderScheduleModal(staff_id, date, elem);
        } else if (ds["success"] == "2") {
          showAlert(ds["data"]["spcat"] + " Unavailable.", "red");
          //select_staff.prop("selected", true);
        }


      },
      error: function (d) {
      },
    });
  } else {
    select_staff.prop("selected", true);
  }
}

function initTimePicker(elem) {
  $(elem).datetimepicker({
    format: "HH:ii P",
    showMeridian: true,
    autoclose: true,
    pickDate: false,
    startView: 1,
    maxView: 1,
  });
}

function searchServices(elem) {
  $(elem)
    .autocomplete({
      source: function (request, response) {
        var timestamplocalnew = $(elem)
          .parent()
          .parent()
          .parent()
          .parent()
          .find(".start_time1")
          .val();
        var localtimestamp1 = convert12to24hours(timestamplocalnew, 2);

        var timestamp = $("#date").val() + " " + localtimestamp1;

        var timestamplocal = $(elem).parent().parent().parent().parent().prev();

        if ($(timestamplocal).length > 0) {
          var localtimestamp = $(timestamplocal).find(".end_time1").val();

          var localtimestamp1 = convert12to24hours(localtimestamp, 2);

          var localtimestamp = $("#date").val() + " " + localtimestamp1;
          var newtimestamp = localtimestamp;
        } else {
          var newtimestamp = timestamp;
        }

        $.getJSON(
          "inc/service/get-service.php",
          {
            name: request.term,
            timestamp: newtimestamp,
          },
          response
        );
      },
      minLength: 1,
      open: function (event, ui) { },
      select: function (event, ui) {
        var error = true;
        var etime = Date.parse("20 Aug 2000 " + $("#close_time").val());
        var setime = Date.parse(
          "20 Aug 2000 " + ui.item.ser_stimedate.split(" ")[1] + ":00"
        );
        var et_status = "0"; // Extra time status

        if (error === true && setime > etime && et_status == "0") {
          // var row = $(this).parent().parent().parent().parent().parent().parent();
          var row = $(this)
            .parent()
            .parent()
            .parent()
            .parent()
            .parent()
            .parent();
          row.find('input[type="text"].ser').val("");
          row.find(".serr").val("");
          // row.find('.pa_ser').val('');
          row.find(".prr").val("");
          row.find(".qt").val("0");
          row.find(".disc_row ").val("0");
          row.find(".duration").val("");
          row.find(".ser_stime").val("");
          row.find(".ser_etime").val("");
          row.find(".start_time").val("".substring(11));
          row.find(".end_time").val("".substring(11));
          var closeTimeShop = $("#close_time").val();
          var shopCloseTime = convert24to12hours(closeTimeShop);
          showAlert(
            "Appointment can't book for this service. salon will close at " +
            shopCloseTime,
            "red"
          );
        } else {
          error = false;
        }

        if (error !== true) {
          $(this).val(ui.item.value);
          $(elem).parent().find(".serr").val(ui.item.id);
          setServiceProvider(ui.item, elem);
        }
      },
    })
    .addClass("whatever");
  $(elem).on("autocompleteopen", function (event, ui) { });
}

function setServiceProvider(data, elem) {
  var sStartArr = data.ser_stime.split(":");
  var sStartSubArr = sStartArr[2].split(" ");
  var sEndArr = data.ser_etime.split(":");
  var sEndSubArr = sEndArr[2].split(" ");

  var serviceStartTime = `${sStartArr[0]}:${sStartArr[1]} ${sStartSubArr[1]}`;
  var serviceEndTime = `${sEndArr[0]}:${sEndArr[1]} ${sEndSubArr[1]}`;

  $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".start_time1")
    .val(serviceStartTime);
  $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".end_time1")
    .val(serviceEndTime);
  $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".service-price")
    .val(data.price);
  $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".old-price")
    .val(data.price);

  countPackage();

  var selRow = $(elem).parent().parent().parent().parent();
  $(selRow).find(".duration").val(data.duration);
  $(selRow).find(".ser_stime").val(data.ser_stimedate);
  $(selRow).find(".ser_etime").val(data.ser_etimedate);
  $(selRow).find(".start_time").val(data.ser_stime.substring(11));
  $(selRow).find(".end_time").val(data.ser_etime.substring(11));

  $(selRow).find(".start_timestamp").val(data.ser_stimedate);
  $(selRow).find(".end_timestamp").val(data.ser_etimedate);

  $(selRow).find(".ser_cat_id").val(data.category_id);

  getAvailableServiceProvider(
    $("#date").val(),
    data.id,
    data.ser_stimedate,
    elem
  );
}


function getAvailableServiceProvider(
  appointmentDate,
  serviceIds,
  endTime,
  elem
) {

  dateArr = appointmentDate.split("-");
  appointmentDate = `${dateArr[2]}/${dateArr[1]}/${dateArr[0]}`;
  var serviceType = "";
  $.ajax({
    url: "inc/service-provider/get-available-service-provider.php",
    type: "GET",
    data: {
      appointmentDate: appointmentDate,
      serviceIds: serviceIds,
      endTime: endTime,
      serviceType: serviceType,
    },
    beforeSend: function () { },
    success: function (data) {
      if (data != "") {
        setServiceProviders(data, elem);
      }
    },
    error: function () { },
  });
}

function setServiceProviders(data, elem) {
  const obj = JSON.parse(data);

  var options = '<option value="">Service provider</option>';

  if (obj.length != 0) {
    $.each(obj, function (i, item) {
      options += '<option value="' + item.id + '">' + item.name + "</option>";
    });
  }

  $(elem).parent().parent().parent().parent().find(".app-staff").html(options);
}

function countPackage() {
  var total_charge = $("#total");
  var sub_charge = $("#sub_total");
  var sub_total = $("#sum");
  var pending_due = $("#pending_due");
  var elem = $(".service-price");
  totalAmount = 0;
  priceArr = [];
  for (let index = 0; index < elem.length; index++) {
    var element = elem[index];
    var p = parseFloat($(element).val());
    priceArr[index] = p;
  }

  var totalPrice = priceArr.reduce((partialSum, a) => partialSum + a, 0);
  totalAmount = Math.round(totalPrice);

  if (totalAmount != "") {
    sub_total.html(totalAmount);
    total_charge.val(totalAmount);
    sub_charge.val(totalAmount);
    pending_due.val(totalAmount);

    //setDiscount();
  }
}

function countBillingPackage() {
  var total_charge = $("#billing_total");
  var sub_charge = $("#billing_sub_total");
  var sub_input = $("#billing_sum");
  var pending_due = $("#billing_pending_due");
  var elem = $(".service-price");
  var original_total_charge = $("#original_total_charge");
  totalAmount = 0;
  priceArr = [];
  for (let index = 0; index < elem.length; index++) {
    var element = elem[index];
    var p = parseFloat($(element).val());
    priceArr[index] = p;
  }

  var totalPrice = priceArr.reduce((partialSum, a) => partialSum + a, 0);
  totalAmount = Math.round(totalPrice);

  if (totalAmount != "") {
    sub_input.html(totalAmount);
    total_charge.val(totalAmount);
    sub_charge.val(totalAmount);
    pending_due.val(totalAmount);
    original_total_charge.val(totalAmount);

    //setDiscount();
  }
}

function changeTiming(e) {
  var diff_minutes = $(e).parents("tr").find(".duration").val();

  diff_minutes = parseInt(diff_minutes);

  var start = $(e).parents("tr").prevAll("tr").find(".end_time1").length;
  var count = $(e).parents("tr").nextAll("tr").find(".end_time1").length;

  for (var i = 0; i < count; i++) {
    var nextStartT = $(".start_timestamp:eq(" + (i + start + 1) + ")");
    var nextStartTime = nextStartT.val();
    var nextEndT = $(".end_timestamp:eq(" + (i + start + 1) + ")");
    var nextEndTime = nextEndT.val();

    var startTimeTimestamp = new Date(nextStartTime);
    var afterStartDateTime = getDifferenceInMinute(
      startTimeTimestamp,
      diff_minutes
    );

    var endTimeTimestamp = new Date(nextEndTime);
    var afterEndDateTime = getDifferenceInMinute(
      endTimeTimestamp,
      diff_minutes
    );

    var final_stimestamp = getTimestampFromJSDateObj(afterStartDateTime);
    var final_etimestamp = getTimestampFromJSDateObj(afterEndDateTime);

    var finalsTime = afterStartDateTime.toTimeString();
    var finaleTime = afterEndDateTime.toTimeString();

    finalsTime = finalsTime.substring(0, 9);
    finaleTime = finaleTime.substring(0, 9);

    var finalsTime12 = convert24to12hours(finalsTime);
    var finaleTime12 = convert24to12hours(finaleTime);

    nextStartT.val(final_stimestamp);
    nextEndT.val(final_etimestamp);

    $(".end_time1:eq(" + (i + start + 1) + ")").val(finaleTime12);
    $(".start_time1:eq(" + (i + start + 1) + ")").val(finalsTime12);
    $(".ser_etime:eq(" + (i + start + 1) + ")").val(final_etimestamp);
    $(".ser_stime:eq(" + (i + start + 1) + ")").val(final_stimestamp);
  }
}

function changeTimeValue(elem) {
  var mainElem = $(elem).parent().parent().parent().parent();

  var endTime = $(mainElem).find(".end_time1 ");
  var duration = $(mainElem).find(".duration");
  var ser_stime = $(mainElem).find(".ser_stime");
  var ser_etime = $(mainElem).find(".ser_etime");
  var start_timestamp = $(mainElem).find(".start_timestamp");
  var end_timestamp = $(mainElem).find(".end_timestamp");

  var afterStartTimestamp = `${getServerFormatDate(
    getTodayDate()
  )} ${convert12to24hours($(elem).val())}`;
  var afterStartTimestampDate = new Date(afterStartTimestamp);

  var afterEndTimestamp = getTimestampFromJSDateObj(
    getAfterTimestamp(afterStartTimestamp, duration.val())
  );
  var afterEndTimestampDate = getAfterTimestamp(
    afterStartTimestamp,
    duration.val()
  );

  var finalsTime = afterStartTimestampDate.toTimeString();
  var finaleTime = afterEndTimestampDate.toTimeString();

  finalsTime = finalsTime.substring(0, 9);
  finaleTime = finaleTime.substring(0, 9);

  var finalsTime12 = convert24to12hours(finalsTime);
  var finaleTime12 = convert24to12hours(finaleTime);

  $(endTime).val(finaleTime12);

  ser_stime.val(afterStartTimestamp);
  ser_etime.val(afterEndTimestamp);
  start_timestamp.val(afterStartTimestamp);
  end_timestamp.val(afterEndTimestamp);
}

function closeAppointmentModal() {
  $("#appointmentAdd")[0].reset();
  $("#sum").html("0.00");
}


function closeBillingModal() {
  $("#billingAdd")[0].reset();
  $("#billing_sum").html("0.00");
}



function searchBillingServices(elem) {
  var ser_cat_txt_elem = $(elem).parent().parent().find(".pr-1").children()[0];
  var ser_cat_elem = $(elem).parent().parent().find(".pr-1").children()[1];
  $(elem)
    .autocomplete({
      source: function (request, response) {
        var category_id = $(ser_cat_elem).val();

        //var timestamp = getServerFormatDate(getTodayDate()) + " " + getCurrentTime("HH");
        var timestamp =
          getServerFormatDate($(".billing_date").val()) +
          " " +
          convert12to24hours($(".billing_time").val(), 2);

        var timestamplocal = $(elem).parent().parent().parent().parent().prev();

        if ($(timestamplocal).length > 0) {
          var localtimestamp = $(timestamplocal).find(".end_time1").val();

          var localtimestamp1 = convert12to24hours(localtimestamp, 2);
          var localtimestamp =
            getServerFormatDate($(".billing_date").val()) +
            " " +
            localtimestamp1;
          var newtimestamp = localtimestamp;
        } else {
          var newtimestamp = timestamp;
        }
        $.getJSON(
          "inc/enquiry/get-enquiry-for.php",
          {
            category_id: category_id,
            terms: request.term,
            timestamp: newtimestamp,
          },
          response
        );
      },
      minLength: 1,
      open: function (event, ui) { },
      select: function (event, ui) {
        var error = false;
        /*
        var etime = Date.parse('20 Aug 2000 ' + $('#close_time').val());
        var setime = Date.parse('20 Aug 2000 ' + ui.item.ser_stimedate.split(' ')[1] + ':00');
        var et_status = '0'; // Extra time status

        
        if (error === true && setime > etime && et_status == '0') {
          // var row = $(this).parent().parent().parent().parent().parent().parent();
          var row = $(this).parent().parent().parent().parent().parent().parent();
          row.find('input[type="text"].ser').val('');
          row.find('.serr').val('');
          // row.find('.pa_ser').val('');
          row.find('.prr').val('');
          row.find('.qt').val('0');
          row.find('.disc_row ').val('0');
          row.find('.duration').val('');
          row.find('.ser_stime').val('');
          row.find('.ser_etime').val('');
          row.find('.start_time').val(('').substring(11));
          row.find('.end_time').val(('').substring(11));
          var closeTimeShop = $('#close_time').val();
          var shopCloseTime = convert24to12hours(closeTimeShop);
          showAlert('Appointment can\'t book for this service. salon will close at ' + shopCloseTime, 'red');

        } else {
          error = false;
        }
*/

        if (error !== true) {
          $(this).val(ui.item.value);
          $(elem).parent().find(".serr").val(ui.item.id);
          $(elem).parent().find(".service_type").val(ui.item.type);
          $(ser_cat_txt_elem).val(ui.item.category_name);
          $(ser_cat_elem).val(ui.item.category_id);

          setBillingServiceProvider(ui.item, elem);
          countBillingPackage();
        }
      },
    })
    .addClass("whatever");
  $(elem).on("autocompleteopen", function (event, ui) { });
}

$(document).ready(function () {
  const picker1 = datepicker(".billing_date", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });

  $(".billing_time").datetimepicker({
    format: "HH:ii P",
    showMeridian: true,
    autoclose: true,
    pickDate: false,
    startView: 1,
    maxView: 1,
  });



  $(".billing_date").val(getTodayDate());
  $(".billing_time").val(getCurrentTime("hh"));
})

function addBillingServiceProviderServices() {
  //var box = $('#service-provider-services');

  var endTime = $(".end_time1");

  var prevElem = $("#addBillingBefore");

  var preEndTime = $(prevElem).prev().find(".end_time1");

  if ($(preEndTime).val() != "") {
    var preEndTimeName = $(preEndTime).attr("name");

    var trdata = preEndTimeName.replace(/[^0-9]/gi, "");
    var arrayKey = parseInt(parseInt(trdata, 10) + 1);

    const mainHtml = `
                <tr>
                    <td style="vertical-align: middle;">
                        <span class="sno text-danger" onclick='removeBillingServiceProviderServices(this);changeTiming(this);'><i class="fas fa-trash"></i></span>
                    </td>
                    <td>
                                                            <div class="row" style="width: 250px;">
                                                                <div class="col-4 pr-1 d-none">
                                                                    <input type="text" class="service-category form-control form-control-sm" onkeyup="searchCategory(this)" name="" placeholder="Category" autocomplete="off">
                                                                    <input type="hidden" class="ser_cat_id" name="billing_product[${arrayKey}][service_cat_id]">
                                                                    <input type="hidden" class="billing_product_id" value="" name="billing_product[${arrayKey}][id]">
                                                                </div>
                                                                <div class="col-12 pl-1">
                                                                    <input type="text" class="category-services form-control form-control-sm" onkeyup="searchBillingServices(this)" name="" placeholder="Service (Autocomplete)" required autocomplete="off">
                                                                    <input type="hidden" name="billing_product[${arrayKey}][service_id]" value="" class="serr serviceids">
                                                                    <input type="hidden" name="billing_product[${arrayKey}][service_type]" value="" class="service_type">

                                                                    <input type="hidden" name="service[]" value="" class="serr">
                                                                    <input type="hidden" name="durr[]" value="" class="durr">
                                                                    <input type="hidden" name="pa_ser[]" value="" class="pa_ser">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row">

                                                                <div class="col-12">
                                                                    <input type="number" name="billing_product[${arrayKey}][quantity]" min="1" class="form-control form-control-sm d-input service-quantity" value="1" onchange="changeQuantity(this)">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row" style="width: 200px;">
                                                                <div class="col-6 pr-1">
                                                                    <input type="number" oninput="addDiscount(this)" name="billing_product[${arrayKey}][service_discount]" class="form-control form-control-sm d-input service-discount" value="0">
                                                                </div>
                                                                <div class="col-6 pl-1">
                                                                    <select class="form-select form-select-sm discount-type" name="billing_product[${arrayKey}][service_discount_type]" onchange="changeDiscountType(this)">
                                                                        <option value="percentage" selected>%</option>
                                                                        <option value="inr">INR</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row mb-1" id="billing-service-provider-box" style="width: 200px;">
                                                                <div class="col-12">
                                                                    <select name="billing_product[${arrayKey}][sp_id][0][service_provider_id]" class="form-select form-select-sm staff">
                                                                        <option value="0">Service Provider</option>
                                                                    </select>
                                                                    <input type="hidden" name="billing_product[${arrayKey}][sp_id][0][id]" value="">
                                                                </div>
                                                                
                                                                <input type="hidden" name="duration[]" value="" class="duration">
                                                                <input type="hidden" name="ser_stime[]" value="" class="ser_stime">
                                                                <input type="hidden" name="ser_etime[]" value="" class="ser_etime">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row" style="width: 200px;">
                                                                <div class="col-6 pr-1">
                                                                    <input type="text" class="form-control form-control-sm start_time1 w-100" placeholder="Start Time" name="billing_product[${arrayKey}][start_time]" onchange="changeTimeValue(this)" onclick="initTimePicker(this)" readonly>
                                                                    <input type="hidden" class='start_timestamp' name='billing_product[${arrayKey}][start_timestamp]'>
                                                                </div>
                                                                <div class="col-6 pl-1">
                                                                    <input type="text" class="form-control form-control-sm end_time1 w-100" name="billing_product[${arrayKey}][end_time]" placeholder="End Time" readonly>
                                                                    <input type="hidden" class='end_timestamp' name='billing_product[${arrayKey}][end_timestamp]'>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <input type="number" class="form-control form-control-sm service-price" name="billing_product[${arrayKey}][price]" placeholder="0" value="0" readonly oninput="changeTotalPrice()">
                                                                    <input type="hidden" class="old-price">
                                                                </div>
                                                            </div>
                                                        </td>
                </tr>`;

    const addBefore = prevElem;
    addBefore.before(mainHtml);
    setTimePicker();
  }
}

function addDiscount(elem) {
  var oldPrice = $(elem).parent().parent().parent().parent().find(".old-price");
  var servicePrice = $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".service-price");
  var discountType = $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".discount-type");
  var quantity = $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".service-quantity");

  var discount = $(elem).val();
  var totalPrice = oldPrice.val();

  if (totalPrice != 0) {
    if (discountType.val() == "percentage") {
      var maxDiscount = 100 - discount;
      var leftPrice = (totalPrice * maxDiscount) / 100;
    } else {
      var leftPrice = parseFloat(totalPrice - discount);
    }

    leftPrice = leftPrice * quantity.val();
    servicePrice.val(leftPrice);

    countBillingPackage();
  }
}


function changeQuantity(elem) {
  var quantity = $(elem)
    .parent()
    .parent()
    .parent()
    .find(".service-quantity")
    .val();
  var price = $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".service-price");
  var original_price = $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".old-price")
    .val();
  var discount_type = $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".discount-type")
    .val();
  var discount = $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".service-discount")
    .val();
  var actualPrice = 0;

  if (original_price != 0) {
    if (discount_type == "percentage") {
      var maxDiscount = 100 - discount;
      var leftPrice = (original_price * maxDiscount) / 100;
      actualPrice = leftPrice; //(original_price - leftPrice);
    } else {
      var leftPrice = parseFloat(original_price - discount);
      actualPrice = leftPrice;
    }
  }

  if (original_price != "") {
    actualPrice = discount != 0 ? actualPrice : original_price;
    price.val(actualPrice * quantity);
    countBillingPackage();
  }
}

function changeDiscountType(elem) {
  var element = $(elem).parent().prev().find("input");
  element = element[0];
  addDiscount(element);
}


function setBillingServiceProvider(data, elem) {

  if (data.type == "service") {
    spField = $(elem).parent().parent().parent().parent().find('.staff');

    spField.attr('required', true);
  }

  if (data.membership_price > 0) {
    var price = data.membership_price;
  } else {
    var price = data.price;
  }

  var sStartArr = data.ser_stime.split(":");
  var sStartSubArr = sStartArr[2].split(" ");
  var sEndArr = data.ser_etime.split(":");
  var sEndSubArr = sEndArr[2].split(" ");

  var serviceStartTime = `${sStartArr[0]}:${sStartArr[1]} ${sStartSubArr[1]}`;
  var serviceEndTime = `${sEndArr[0]}:${sEndArr[1]} ${sEndSubArr[1]}`;

  $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".start_time1")
    .val(serviceStartTime);
  $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".end_time1")
    .val(serviceEndTime);
  $(elem).parent().parent().parent().parent().find(".service-price").val(price);
  $(elem).parent().parent().parent().parent().find(".old-price").val(price);

  var selRow = $(elem).parent().parent().parent().parent();
  $(selRow).find(".duration").val(data.duration);
  $(selRow).find(".service-quantity").val(1);
  $(selRow).find(".ser_stime").val(data.ser_stimedate);
  $(selRow).find(".ser_etime").val(data.ser_etimedate);
  $(selRow).find(".start_time").val(data.ser_stime.substring(11));
  $(selRow).find(".end_time").val(data.ser_etime.substring(11));

  $(selRow).find(".start_timestamp").val(data.ser_stimedate);
  $(selRow).find(".end_timestamp").val(data.ser_etimedate);

  getAvailableBillingServiceProvider(
    $("#billing_date").val(),
    //$(".serr").val(),
    data.id,
    data.ser_stime,
    elem
  );
}

function getAvailableBillingServiceProvider(
  appointmentDate,
  serviceIds,
  endTime,
  elem
) {
  var serviceType = $(elem)
    .parent()
    .parent()
    .parent()
    .find(".service_type")
    .val();
  $.ajax({
    url: "inc/service-provider/get-available-service-provider.php",
    type: "GET",
    data: {
      appointmentDate: appointmentDate,
      serviceIds: serviceIds,
      serviceType: serviceType,
      endTime: endTime,
    },
    beforeSend: function () { },
    success: function (data) {
      if (data != "") {
        setBillingServiceProviders(data, elem);
      }
    },
    error: function () { },
  });
}

function setBillingServiceProviders(data, elem) {
  const obj = JSON.parse(data);

  var options = '<option value="">Service provider</option>';

  if (obj.length != 0) {
    $.each(obj, function (i, item) {
      options += '<option value="' + item.id + '">' + item.name + "</option>";
    });
  }

  $(elem).parent().parent().parent().parent().find(".staff").html(options);
}

function setTimePicker() {
  var elem = $(".start_time1");
  totalAmount = 0;
  priceArr = [];
  for (let index = 0; index < elem.length; index++) {
    var element = elem[index];
    var p = $(element);
    initTimePicker(p);
  }
}

$(document).ready(function () {
  setTimePicker();
});