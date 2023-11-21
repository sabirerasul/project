$(document).ready(function () {
  const picker1 = datepicker(".present_date", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });

  const picker2 = datepicker("#clientdob", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });

  const picker3 = datepicker("#anniversary", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });

  $(".present_time").datetimepicker({
    format: "HH:ii P",
    showMeridian: true,
    autoclose: true,
    pickDate: false,
    startView: 1,
    maxView: 1,
  });

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

  $("#appointmentAdd").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#appointmentAdd");
    var url = form.attr("action");

    var error = false;
    var ErrorMsg = "";

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
            showAlert("Appointment Saved Successfully");
            Swal.fire(
              "Good job!",
              "Appointment Saved Successfully",
              "success"
            ).then((result) => {
              document.getElementById("appointmentAdd").reset();
              window.location = "./appointment.php";
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

  $("#appointmentUpdate").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#appointmentUpdate");
    var url = form.attr("action");

    var error = false;
    var ErrorMsg = "";

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
            showAlert("Appointment Updated Successfully");
            Swal.fire(
              "Good job!",
              "Appointment Updated Successfully",
              "success"
            ).then((result) => {
              document.getElementById("appointmentUpdate").reset();
              window.location = "./appointment.php";
            });
          } else {
            instanceLoading.hideLoading()
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

function setValue(item) {
  $("#client").val(item.client_name);
  $("#client_id").val(item.id);
  $("#cont").val(item.contact);
  //hideLoader()
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

  var selRow = $(elem).parent().parent().parent().parent();
  $(selRow).find(".duration").val(data.duration);
  $(selRow).find(".ser_stime").val(data.ser_stimedate);
  $(selRow).find(".ser_etime").val(data.ser_etimedate);
  $(selRow).find(".start_time").val(data.ser_stime.substring(11));
  $(selRow).find(".end_time").val(data.ser_etime.substring(11));

  $(selRow).find(".start_timestamp").val(data.ser_stimedate);
  $(selRow).find(".end_timestamp").val(data.ser_etimedate);

  applyDiscountMembership(elem);

  getAvailableServiceProvider(
    $("#date").val(),
    $(".serr").val(),
    data.ser_stimedate,
    elem
  );
}

function clientView(id) {
  client_check_membership_availability(id);
  client_check_pending_payment(id);
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
            '<br><a class="text-nowrap cursor-pointer" onclick="clientPackageModal(' +
            id +
            ')"><i class="icon-eye3"></i> View Details</a>'
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

        $("#gender option").attr("selected", false);
        if (ds["gender"] != "") {
          var ggen = ds["gender"] == "male" ? 1 : 2;
          $("#gender #gn-" + ggen).attr("selected", true);
        } else {
          $("#gender #gn-1").attr("selected", true);
        }

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
            "<div style='background:#00a400' class='rounded p-1'><h4 class='h5 b-0 text-dark'>Customer type: Active</h4><small class='text-white'>Active Customers - Customers who visit your outlet at regular intervals.  </small></div>"
          );
        } else if (ds["customer_type"] == "inactive") {
          $("#customer_type").html(
            "<div style='background:#fa383e' class='rounded p-1'><h4 class='h5 b-0 text-dark'>Customer type: Defected Customer</h4><small class='text-white'>Defected Customers - Customers who haven't visited your outlet and become inactive. </small></div>"
          );
        } else if (ds["customer_type"] == "newcustomer") {
          $("#customer_type").html(
            "<div style='background:#622bfb' class='rounded p-1'><h4 class='h5 b-0 text-dark'>Customer type: New Customer</h4><small class='text-white'>Customer who haven't visited your outlet. </small></div>"
          );
        } else {
          $("#customer_type").html(
            "<div  style='background:#fff200' class='rounded p-1'><h4 class='h5 b-0 text-dark' >Customer type: Churn Prediction</h4><small >Churn Prediction - Customers who haven't visited your outlet and who are likely to leave. </small> </div>"
          );
        }
        $(".client-view-content").fadeIn();
      }
    },
    error: function () {
      instanceLoading.hideLoading()
    },
  });
}

function getAvailableServiceProvider(
  appointmentDate,
  serviceIds,
  endTime,
  elem
) {
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

  $(elem).parent().parent().parent().parent().find(".staff").html(options);
}
function addServiceProvider(elem) {
  var box = $(elem).parent().parent().parent().parent();
  let html1 = box;

  let lastElem = $(elem)
    .parent()
    .parent()
    .parent()
    .parent()
    .children()
    .last()
    .find(".staff")
    .attr("name");

  var lastId = parseInt(lastElem[30]);

  lastId = parseInt(lastId + 1);

  let d = html1.find("div")[0];

  let option = $(d).find("select").html();

  var elemAttrName = $(elem)
    .parent()
    .parent()
    .parent()
    .find(".staff")
    .attr("name");

  const index = elemAttrName.search(/[0-9]/);
  const firstNum = Number(elemAttrName[index]);

  var html = `
            <div class="row mb-1 service-provider-box-dup" style="width: 200px;">
                <div class="col-9 pr-1">
                    <select name="appointment_service[${firstNum}][sp_id][${lastId}][service_provider_id]" class="form-select form-select-sm staff" onchange="checkAvailabalityServiceProvider(this)" required>
                        ${option}
                    </select>
                    <input type="hidden" name="appointment_service[${firstNum}][sp_id][${lastId}][id]" value="">
                </div>
                <div class="col-3 pl-1">
                    <span class="input-group-btn">
                        <button class="btn btn-minus btn-sm btn-danger" type="button" onclick="removeServiceProvider(this)">
                            <i class="fas fa-minus"></i>
                        </button>
                    </span>
                </div>
            </div>`;

  box.append(html);
}

function removeServiceProvider(elem) {
  $(elem).parent().parent().parent().remove();
}

function addServiceProviderServices() {
  //var box = $('#service-provider-services');

  var endTime = $(".end_time1");

  var prevElem = $("#addBefore");
  var preEndTime = $(prevElem).prev().find(".end_time1");

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
                        <div class="row" style="width: 250px;">
                            <div class="col-4 pr-1">
                                <input type="text" class="service-category form-control form-control-sm" onkeyup="searchCategory(this)" name="" placeholder="Category" autocomplete="off">
                                <input type="hidden" class="ser_cat_id" name="appointment_service[${arrayKey}][service_cat_id]">
                                <input type="hidden" class="appointment_service_id" value="" name="appointment_service[${arrayKey}][id]">
                            </div>
                            <div class="col-8 pl-1">
                                <input type="text" class="category-services form-control form-control-sm" name="" onkeyup="searchServices(this)" placeholder="Service (Autocomplete)" required autocomplete="off">
                                <input type="hidden" name="appointment_service[${arrayKey}][service_id]" value="" class="serr serviceids">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row" style="width: 200px;">
                            <div class="col-6 pr-1">
                                <input type="number" oninput="addDiscount(this)" name="appointment_service[${arrayKey}][service_discount]" class="form-control form-control-sm service-discount" value="0">
                            </div>
                            <div class="col-6 pl-1">
                                <select class="form-select form-select-sm discount-type" name="appointment_service[${arrayKey}][service_discount_type]" onchange="changeDiscountType(this)">
                                    <option value="percentage" selected>%</option>
                                    <option value="inr">INR</option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row mb-1" id="service-provider-box" style="width: 200px;">
                            <div class="col-9 pr-1">
                                <select name="appointment_service[${arrayKey}][sp_id][0][service_provider_id]" class="form-select form-select-sm staff" onchange="checkAvailabalityServiceProvider(this)" required>
                                    <option value="">Service Provider</option>
                                </select>
                                <input type="hidden" name="appointment_service[${arrayKey}][sp_id][0][id]" value="">
                            </div>
                            <div class="col-3 pl-1">
                                <span class="input-group-btn">
                                    <button class="btn btn-plus btn-sm btn-success" type="button" onclick="addServiceProvider(this)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </span>
                            </div>
                            <input type="hidden" name="duration[]" value="" class="duration">
                            <input type="hidden" name="ser_stime[]" value="" class="ser_stime">
                            <input type="hidden" name="ser_etime[]" value="" class="ser_etime">
                        </div>
                    </td>
                    <td>
                        <div class="row" style="width: 200px;">
                            <div class="col-6 pr-1">
                                <input type="text" class="form-control form-control-sm start_time1 w-100" placeholder="Start Time" name="appointment_service[${arrayKey}][start_time]" onchange="changeTimeValue(this)" readonly>
                                <input type="hidden" class='start_timestamp' name='appointment_service[${arrayKey}][start_timestamp]'>
                                </div>
                            <div class="col-6 pl-1">
                                <input type="text" class="form-control form-control-sm end_time1 w-100" name="appointment_service[${arrayKey}][end_time]" placeholder="End Time" readonly>
                                <input type="hidden" class='end_timestamp' name='appointment_service[${arrayKey}][end_timestamp]'>
                            </div>
                        </div>
                    </td>

                    <td>
                        <input type="number" class="form-control form-control-sm service-price" name="appointment_service[${arrayKey}][price]" placeholder="0" value="0" readonly>
                        <input type="hidden" class="old-price">
                    </td>
                </tr>`;

    const addBefore = prevElem;
    addBefore.before(mainHtml);

    setTimePicker();
  }
}

function removeServiceProviderServices(elem) {
  //$(elem).parent().parent().hide();
  $(elem).parent().parent().remove();
  countPackage();
}

function addMultiTransaction() {
  const addBefore = $("#addBeforeTransaction");

  var preElem = $(addBefore).prev().find(".transid").attr("name");

  var trdata = preElem.replace(/[^0-9]/gi, "");
  var arrayKey = parseInt(parseInt(trdata, 10) + 1);

  var keyArr = arrayKey;
  const transHtml = `<div class="row my-1">
                        <div class="col-4">
                            <input type="text" name="appointment_advance_payment[${keyArr}][transaction_id]" class="key form-control transid" placeholder="TXN ID" onchange="advanceGiven(this)">
                            <input type="hidden" name="appointment_advance_payment[${keyArr}][id]" value="">
                        </div>

                        <div class="col-3">
                            <input type="number" name="appointment_advance_payment[${keyArr}][advance]" class="key form-control adv advance-amount" value="0" step="0.1" onchange="advanceGiven(this)" required>
                        </div>

                        <div class="col-3">
                            <select name="appointment_advance_payment[${keyArr}][method]" class="form-select adv-type" onchange="advanceGiven(this)" required>
                                <option value=''>--Select--</option>
                                <option value="1">Cash</option>
                                <option value="3">Credit/Debit card</option>
                                <option value="4">Cheque</option>
                                <option value="5">Online payment</option>
                                <option value="6">Paytm</option>
                                <option value="7">E-wallet</option>
                                <option value="9">Reward points</option>
                                <option value="10">PhonePe</option>
                                <option value="11">Gpay</option>
                            </select>
                        </div>

                        <div class="col-2">
                            <button style="pointer-events: initial;" class="btn btn-minus btn-danger" type="button" onclick="removeMultiTransaction(this)">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>`;

  addBefore.before(transHtml);
}

function removeMultiTransaction(elem) {
  $(elem).parent().parent().remove();
  advanceGivenAll();
}

function searchServices(elem) {
  var ser_cat_txt_elem = $(elem).parent().parent().find(".pr-1").children()[0];
  var ser_cat_elem = $(elem).parent().parent().find(".pr-1").children()[1];

  $(elem)
    .autocomplete({
      source: function (request, response) {
        var category_id = $(ser_cat_elem).val();
        //var timestamp = getServerFormatDate(getTodayDate()) + " " + getCurrentTime("HH");
        var timestamp =
          getServerFormatDate($(".present_date").val()) +
          " " +
          convert12to24hours($(".present_time").val(), 2);

        var membership_id = $("#membership_id").val();

        var timestamplocal = $(elem).parent().parent().parent().parent().prev();

        if ($(timestamplocal).length > 0) {
          var localtimestamp = $(timestamplocal).find(".end_time1").val();

          var localtimestamp1 = convert12to24hours(localtimestamp, 2);
          var localtimestamp =
            getServerFormatDate($(".present_date").val()) + " " + localtimestamp1;
          var newtimestamp = localtimestamp;
        } else {
          var newtimestamp = timestamp;
        }
        $.getJSON(
          "inc/service/get-service.php",
          {
            membership_id: membership_id,
            category_id: category_id,
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
          $(ser_cat_txt_elem).val(ui.item.cat_name);
          $(ser_cat_elem).val(ui.item.category_id);
          //clientHistoryPackageModal($('#client_id').val(), ui.item.id);

          setServiceProvider(ui.item, elem);
          countPackage();
        }
      },
    })
    .addClass("whatever");
  $(elem).on("autocompleteopen", function (event, ui) { });
}

function searchCategory(elem) {
  $(".service-category")
    .autocomplete({
      source: function (request, response) {
        $.getJSON(
          "inc/service-category/get-service-category.php",
          { name: request.term },
          response
        );
      },
      minLength: 1,
      open: function (event, ui) { },
      select: function (event, ui) {
        $(this).val(ui.item.value);
        $(elem).parent().find(".ser_cat_id").val(ui.item.id);
      },
    })
    .addClass("whatever");
  $(".service-category").on("autocompleteopen", function (event, ui) { });
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
  var select_staff = $(elem).parents("tr").find('.staff option[value=""]');

  date = $("#date").val();
  time = $("#time").val();

  if (starttime != "" && staff_id != "") {
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

        if (ds["success"] == "0") {
          showAlert(ds["data"]["spcat"] + " Available.");
        } else if (ds["success"] == "1") {
          showAlert(ds["data"]["spcat"] + " Unavailable.", "red");
          select_staff.prop("selected", true);
          serviceProviderScheduleModal(staff_id, date, elem);
        } else if (ds["success"] == "2") {
          showAlert(ds["data"]["spcat"] + " Unavailable.", "red");
          select_staff.prop("selected", true);
        }
      },
      error: function (d) { },
    });
  } else {
    select_staff.prop("selected", true);
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

  var discount = $(elem).val();
  var totalPrice = oldPrice.val();

  if (totalPrice != 0) {
    if (discountType.val() == "percentage") {
      discount = discount > 100 ? 0 : discount;
      $(elem).val(discount);
    } else {
      discount = discount > servicePrice.val() ? 0 : discount;
      $(elem).val(discount);
    }

    if (discountType.val() == "percentage") {
      var maxDiscount = 100 - discount;
      var leftPrice = (totalPrice * maxDiscount) / 100;
      servicePrice.val(leftPrice);
    } else {
      var leftPrice = parseFloat(totalPrice - discount);
      servicePrice.val(leftPrice);
    }

    var totalPriceElem = $(".service-price");
    var totalPriceElemLength = totalPriceElem.length;

    var newTotalPriceAr = [];
    for (let index = 0; index < totalPriceElemLength; index++) {
      const element = totalPriceElem[index];
      var afterP = parseFloat($(element).val());
      newTotalPriceAr[index] = afterP;
    }

    var newTotalPrice = newTotalPriceAr.reduce(
      (partialSum, a) => partialSum + a,
      0
    );

    var oldTotalPrice = parseFloat($("#sum-input").val());
    var totalLeftPrice = parseFloat(newTotalPrice - oldTotalPrice);

    countPackage();
    if (totalLeftPrice > 0) {
      //addPrice(totalLeftPrice);
    } else {
      var totalLeftPricePositive = getPositiveNumber(totalLeftPrice);
      // /subtractPrice(totalLeftPricePositive);
    }
  }
}

function changeDiscountType(elem) {
  var element = $(elem).parent().prev().find("input");
  element = element[0];
  addDiscount(element);
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

function changeTimeValue(elem) {
  var mainElem = $(elem).parent().parent().parent().parent();

  $(mainElem).find('.staff option[value=""]').prop("selected", true);

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

// pending task

// in searchServices function change error false to true;

// uncomment removeServiceProviderServices()

// when service provider unavailable then set empty to all field

//issue in time date old and time update for am
//get-service.php

//

function checkSchedule() {
  var selectedDate = $(".present_date").val();

  var heading = `Service Providers Schedule On ${selectedDate}`;

  $("#exampleModalLabelSchedule").html(heading);

  $.ajax({
    url: "./inc/appointment/get-schedule-appointment.php",
    method: "post",
    data: { date: selectedDate },
    success: function (response) {
      $("#todaySchedule").html(response);
    },
  });
}

function client_check_membership_availability(client_id) {
  $.ajax({
    url: "./inc/membership/check-membership-availability.php",
    type: "POST",
    data: { client_id: client_id },
    success: function (data) {
      if (data) {
        var dt = $.parseJSON(data);
        if (dt[0]["total"] == "1") {
          if (
            new Date(dt[0]["result"]["time_update"]) <
            new Date(
              getServerFormatDate($(".present_date").val()) +
              " " +
              convert12to24hours($("#appointment_time").val())
            )
          ) {
            dt = dt[0]["result"];
            var discount_on_package = dt.discount_on_package;
            var discount_on_product = dt.discount_on_product;
            var discount_on_service = dt.discount_on_service;

            var discount_on_package_type =
              dt.discount_on_package_type == "percentage" ? "%" : "INR";
            var discount_on_product_type =
              dt.discount_on_product_type == "percentage" ? "%" : "INR";
            var discount_on_service_type =
              dt.discount_on_service_type == "percentage" ? "%" : "INR";

            $("#discount_on_package").val(discount_on_package);
            $("#discount_on_product").val(discount_on_product);
            $("#discount_on_service").val(discount_on_service);

            $("#discount_on_package_type").val(dt.discount_on_package_type);
            $("#discount_on_product_type").val(dt.discount_on_product_type);
            $("#discount_on_service_type").val(dt.discount_on_service_type);
            $("#membership_reward_boost").val(dt.reward_points_boost);
            $("#membership_condition").val(dt.membership_condition);
            $("#mem_reward_point").val(dt.min_reward_points_earned);
            $("#min_bill_amount").val(dt.min_bill_amount);
            $("#membership_condition").val(dt.mem_condition);
            $("#membership_id").val(dt.id);

            discount_on_package = `${discount_on_package} ${discount_on_package_type}`;
            discount_on_service = `${discount_on_service} ${discount_on_service_type}`;
            discount_on_product = `${discount_on_product} ${discount_on_product_type}`;

            if (dt.membership_condition == 1) {
              var condition = "<strong>AND</strong>";
            } else if (dt.membership_condition == 2) {
              var condition = "<strong>OR</strong>";
            }

            var html =
              '<br /><div class="alert alert-success light"><i class="icon-check_circle"></i><strong>Wow! </strong>';
            html += "This client has a membership with ";
            html +=
              "Discount on <strong>Service " +
              discount_on_service +
              "</strong> , ";
            html +=
              "Discount on <strong>Products " +
              discount_on_product +
              "</strong> , ";
            html +=
              "Discount on <strong>Packages " +
              discount_on_package +
              "</strong>";
            html +=
              '<div class="text-danger"><i style="margin-left:0px;" class="fa fa-exclamation-circle" aria-hidden="true"></i> <strong>Note:</strong> ';
            html +=
              "Minimum <strong>Reward point</strong> should be <strong>" +
              dt.min_reward_points_earned +
              "</strong> " +
              condition +
              " minimum <strong>Bill amount</strong> should be <strong>INR " +
              dt["min_bill_amount"] +
              "</strong> to apply membership discount.";
            html += "</div></div>";
            $("#member_ship_message").html(html);
          } else {
            $("#member_ship_message").html("");
          }
        } else {
          $("#member_ship_message").html("");
        }
      }
    },
  });
}

function client_check_pending_payment(client_id) {
  $.ajax({
    url: "./inc/payment/get-pending-payment.php",
    type: "POST",
    data: { client_id: client_id },
    success: function (data) {
      if (data != "") {
        const myModal = new bootstrap.Modal("#paymentModal", {
          keyboard: false,
        });
        const modalToggle = $("#paymentModal");
        myModal.show(modalToggle);
        $("#pendingPaymentTable").html(data);
      }
    },
  });
}

function applyDiscountMembership(elem) {
  var membership_id = $("#membership_id").val();
  if (membership_id != 0) {
    var row = $(elem).parent().parent().parent().parent();

    var service_discount = row.find(".service-discount");
    var discount_type = row.find(".discount-type");

    var discount_on_service = $("#discount_on_service");
    var discount_on_service_type = $("#discount_on_service_type");

    if (discount_on_service.val() != 0) {
      service_discount.val(discount_on_service.val());
      service_discount.attr("readonly", "true");

      var op = discount_type.find("option");
      for (var i = 0; i < op.length; i++) {
        if (op[i].value != discount_on_service_type.val()) {
          op[i].disabled = true;
        }
      }
      discount_type.val(discount_on_service_type.val()).change();
    }
  }
}

function changeAppointmentDate() {
  $('.staff option[value=""]').prop("selected", true);

  // $('.staff option[value=""]').prop('selected',true);
  // $('.ser').val("");
  // $('.start_time').val("");
  // $('.end_time').val("");
  // $('.ser_stime').val("");
  // $('.ser_etime').val("");
  // $('.prr').val("");
  // $('.pr ').val("");
  // $('.serr').val("");
  // $('.disc_row').val("");
}

function changeAppointmentTime() {
  $('.staff option[value=""]').prop("selected", true);
}

function serviceProviderScheduleModal(staff_id, date, elem) {
  $(document).ready(function () {
    const myModal = new bootstrap.Modal("#serviceProviderScheduleModel", {
      keyboard: false,
    });
    const modalToggle = $("#serviceProviderScheduleModel");
    myModal.show(modalToggle);

    $.ajax({
      url: "./inc/appointment/get-schedule-service-provider-appointment.php",
      method: "post",
      data: {
        staff_id: staff_id,
        date: date,
      },
      success: function (response) {
        $("#serviceProviderScheduleTable").html(response);
      },
    });
  });
}

function countPackage() {
  var total_charge = $("#total");
  var sub_charge = $("#sub_total");
  var sub_input = $("#sum-input");
  var pending_due = $("#pending_due");
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
  totalAmount = totalPrice;

  if (totalAmount != "") {
    sub_input.val(totalAmount);
    total_charge.val(totalAmount);
    sub_charge.val(totalAmount);
    pending_due.val(totalAmount);
    original_total_charge.val(totalAmount);

    setDiscount();
  }
}

function setDiscount() {
  var oldPrice = $("#sum-input");
  var total_charge = $("#total");
  var original_total_charge = $("#original_total_charge");
  var discountType = $(".total-discount-select");
  var pending_due = $("#pending_due");

  var sum_input = $('#sum-input');

  var discount = $(".total-discount-input").val();

  var totalPrice = oldPrice.val();

  if (discountType.val() == "percentage") {
    discount = discount > 100 ? 0 : discount;
    $(".total-discount-input").val(discount);
  } else {
    discount = discount > sum_input.val() ? 0 : discount;
    $(".total-discount-input").val(discount);
  }

  if (totalPrice != 0) {
    if (discountType.val() == "percentage") {
      var maxDiscount = 100 - discount;
      var leftPrice = Math.round((totalPrice * maxDiscount) / 100);
    } else {
      var leftPrice = Math.round(parseFloat(totalPrice - discount));
    }
    total_charge.val(leftPrice);
    pending_due.val(leftPrice);
    original_total_charge.val(leftPrice);
  }

  appointmentTax();
  //countPackage();
}


function appointmentTax() {
  var taxArray = $(".appointment-tax").val();

  var taxHtml = $(".appointment-tax").find(":selected");//.text();

  dataProductType = $(taxHtml).attr('data-product-type');
  dataTaxType = $(taxHtml).attr('data-tax-type');
  dataGst = $(taxHtml).attr('data-gst');

  var original_total_charge = $("#original_total_charge");

  var total = $("#total");
  var pend = $("#pending_due");

  if (dataGst != 0 && dataTaxType == 'exclusive') {
    var totalValue = Math.round(parseFloat(original_total_charge.val()));

    var taxInterest = (totalValue * dataGst) / 100;

    var totalAfterInterest = Math.round(parseFloat(totalValue + taxInterest));

    total.val(totalAfterInterest);
    pend.val(totalAfterInterest);
  } else {
    total.val(Math.round(original_total_charge.val()));
    pend.val(Math.round(original_total_charge.val()));
  }

  advanceGivenAll();
}

function advanceGiven(elem) {
  var total = $("#total");
  var totalValue = total.val();

  /*
  var wallet_money = $("#wallet_money");
  var reward_point = $("#reward_point");

  
  var mainElem = $(elem).parent().parent();

  var transid = $(mainElem).find(".transid");
  var adv = $(mainElem).find(".advance-amount");
  var advValue = adv.val();
  var advType = $(mainElem).find(".adv-type");
  var advTypeValue = advType.val();

  var pendingDue = $("#pending_due");
  var pendingDueValue = pendingDue.val();

  if (totalValue != 0) {
    if (advTypeValue == 9) {
      var rPoint = rewardPoint.val();

      fRPoint = "";

      if (rPoint > pendingDueValue) {
        fRPoint = pendingDueValue;
      }

      if (rPoint < pendingDueValue && rPoint != 0) {
        fRPoint = rPoint;
      }

      adv.val(fRPoint);
    } else if (advTypeValue == 7) {
      var wMoney = walletMoney.val();

      fwPoint = "";

      if (wMoney > pendingDueValue) {
        fwPoint = pendingDueValue;
      }

      if (wMoney < pendingDueValue && wMoney != 0) {
        fwPoint = wMoney;
      }

      adv.val(fwPoint);
    }

    setTotalPendingDue();
  } else {
    //showAlert("Advance amount exceeded total amount.", "orange");
    adv.val(0);
  }

  */

  var options = 0;
  var totalVal = parseInt(totalValue);
  var modeDiv = $(elem).parent().parent().find(".adv-type");
  var modeDivRemoveBtn = $(elem).parent().parent().find(".btn-danger");
  var mode_id = modeDiv.val();
  if (totalVal == 0) {
    modeDiv.val("1");
  } else {
    $("#transaction-row .adv-type").each(function () {
      var selected_options = $(this).val();
      if (mode_id == selected_options) {
        options += 1;
      }
    });

    if (options > 1) {
      showAlert("Payment option is already selected.", "red");
      removeMultiTransaction(modeDivRemoveBtn);
      return false;
    }
  }

  var modeDiv = modeDiv.parent().parent();
  var wallet_money = parseInt($("#wallet_money").val());
  var reward_point = parseInt($("#reward_point").val());
  if (mode_id == "7") {
    if (totalVal != 0) {
      if (wallet_money == "0" || wallet_money == "") {
        showAlert("Wallet is empty.", "red");
        modeDiv.find(".adv-type").val("1");
        modeDiv.find(".advance-amount").val("0");
      } else {
        var price_cal = parseInt(wallet_money);
        if (totalVal < wallet_money) {
          modeDiv
            .find(".advance-amount")
            .val(parseFloat($("#pending_due").val()));
        } else {
          modeDiv.find(".advance-amount").val(price_cal);
        }
        if (reward_point == "" || reward_point == "0") {
        } else {
          $("#reward_point").val(reward_point);
          $("#earned_points").text(reward_point);
        }
      }
    }
  } else if (mode_id == "9") {
    if (totalVal != 0) {
      if (reward_point == "" || reward_point == "0") {
        modeDiv.find(".advance-amount").val("0");
        showAlert("Do not have any reward point.", "red");
        modeDiv.find(".adv-type").val("1");
      } else {
        var point;
        var point_price = $("#price_reward_setting").val();
        var redeem_point = $("#redeem_point_reward_setting").val();
        var pprice = parseFloat($("#pending_due").val());
        if (reward_point > 200) {
          point = 200;
        } else {
          point = reward_point;
        }
        var price_cal =
          (parseInt(point) / parseInt(redeem_point)) * parseInt(point_price);
        if (pprice > price_cal) {
          modeDiv.find(".advance-amount").val(price_cal);
        } else {
          modeDiv.find(".advance-amount").val(pprice);
        }
      }
    }
  } else {
    //modeDiv.find('.advance-amount').val('0');
  }

  setTotalPendingDue();
}

function advanceGivenAll() {
  var elem = $(".adv");
  priceArr = [];
  for (let index = 0; index < elem.length; index++) {
    var element = elem[index];
    advanceGiven($(element));
  }
}

function countTotalAdvance() {
  var elem = $(".advance-amount");
  totalAmount = 0;
  priceArr = [];
  for (let index = 0; index < elem.length; index++) {
    var element = elem[index];
    var p = parseFloat($(element).val());
    priceArr[index] = p;
  }

  var totalPrice = priceArr.reduce((partialSum, a) => partialSum + a, 0);
  totalAmount = totalPrice;
  return totalAmount;
}

function setStatus() {
  var pending_due = $("#pending_due");
  var appointment_status = $(".appointment_status");
  if (pending_due.val() == 0) {
    appointment_status.val("Billed").change();
  }
}

function setTotalPendingDue() {
  var totalAdvance = countTotalAdvance();

  var total = $("#total");
  var pendingDue = $("#pending_due");

  var pendingAmount = Math.round(parseFloat(total.val() - totalAdvance));

  if (totalAdvance <= total.val()) {
    pendingDue.val(pendingAmount);
    setStatus();
  } else {
    showAlert("Advance amount exceeded total amount.", "orange");
    //adv.val();
  }
}

var params = window.location.search;
var url_string = window.location;
var url = new URL(url_string);
var id = url.searchParams.get("id");
var leadid = url.searchParams.get("leadid");

if (id != null || leadid != null) {
  $(document).ready(function () {
    //set today date
    var client_id = $("#client_id");
    clientView(client_id.val());

    if (leadid != null) {
      $(".present_date").val(getTodayDate());
      $(".present_time").val(getCurrentTime("hh"));


      var categoryServices = $(".category-services");
      var categoryServicesId = $(".serviceids");
      var timestamp = `${getServerFormatDate(
        $(".present_date").val()
      )} ${convert12to24hours($(".present_time").val(), 2)}`;
      var membership_id = $("#membership_id").val();

      $.ajax({
        url: "inc/service/get-service.php",
        type: "POST",
        data: {
          membership_id: membership_id,
          category_id: "",
          name: categoryServices.val(),
          timestamp: timestamp,
          service_id: categoryServicesId.val(),
        },
        success: function (data) {
          if (data) {
            var data = $.parseJSON(data);
            data = data[0];
            var ser_cat_txt_elem = categoryServices
              .parent()
              .parent()
              .find(".pr-1")
              .children()[0];
            var ser_cat_elem = categoryServices
              .parent()
              .parent()
              .find(".pr-1")
              .children()[1];
            categoryServices.val(data.value);
            categoryServices.parent().find(".serr").val(data.id);
            $(ser_cat_txt_elem).val(data.cat_name);
            $(ser_cat_elem).val(data.category_id);
            setServiceProvider(data, categoryServices);
          }
        },
      });
    }
  });
} else {
  $(".present_date").val(getTodayDate());
  $(".present_time").val(getCurrentTime("hh"));
}

function pendingPayment(elem) {
  var id = $(elem).parent().parent().find(".pending_id").val();
  var paid = $(elem).parent().parent().find(".amtpay").val();
  var mode = $(elem).parent().parent().find(".mthd").val();

  if (paid != 0) {
    var formValues = { id: id, paid: paid, mode: mode };
    var url = './inc/payment/pending-payment-add.php';
    var error = false;
    var ErrorMsg = "";

    if (error == false) {
      instanceLoading.showLoading({
        type: 'cube_flip',
        color: '#ffffff',
        backgroundColor: '#025043',
        title: 'Loading...',
        fontSize: 16,
      });
      $.ajax({
        type: "POST",
        url: url,
        data: formValues,
        success: function (data) {
          const myObj = JSON.parse(data);
          instanceLoading.hideLoading()
          if (myObj.success == true) {
            showAlert("Pending payment Saved Successfully");
            Swal.fire(
              "Good job!",
              "Pending payment Saved Successfully",
              "success"
            ).then((result) => {
              location.reload();
            });
          } else {
            instanceLoading.hideLoading()
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
  }
}




function clientPackageModal(client_id) {
  $(document).ready(function () {
    const myModal = new bootstrap.Modal("#packageModal", {
      keyboard: false,
    });
    const modalToggle = $("#packageModal");
    myModal.show(modalToggle);

    $.ajax({
      url: "./inc/package/get-package.php",
      method: "post",
      data: {
        client_id: client_id,
      },
      success: function (response) {
        $("#packageTable").html(response);
      },
    });
  });
}




function clientHistoryPackageModal(client_id, service_id) {
  $(document).ready(function () {
    const myModal = new bootstrap.Modal("#packageHistoryModal", {
      keyboard: false,
    });
    const modalToggle = $("#packageHistoryModal");
    myModal.show(modalToggle);

    $.ajax({
      url: "./inc/package/get-package-service.php",
      method: "post",
      data: {
        client_id: client_id,
      },
      success: function (response) {
        $("#packageHistoryTable").html(response);
      },
    });
  });
}