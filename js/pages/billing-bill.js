$(document).ready(function () {
  const picker1 = datepicker(".billing_date", {
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

  //set today date
  $(".billing_date").val(getTodayDate());
  $(".billing_time").val(getCurrentTime("hh"));

  $(".billing_time").datetimepicker({
    format: "HH:ii P",
    showMeridian: true,
    autoclose: true,
    pickDate: false,
    startView: 1,
    maxView: 1,
  });

  // $(".end_time1").datetimepicker({
  //     format: "HH:ii P",
  //     showMeridian: true,
  //     autoclose: true,
  //     pickDate: false,
  //     startView: 1,
  //     maxView: 1
  // });

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

  $("#billingAdd").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#billingAdd");
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
          instanceLoading.hideLoading()
          const myObj = JSON.parse(data);

          if (myObj.success == true) {
            // $('#exampleModal').hide();
            // $('.modal-backdrop').hide();
            showAlert("Bill Created Successfully");
            Swal.fire("Good job!", "Bill Created Successfully", "success").then(
              (result) => {
                document.getElementById("billingAdd").reset();
                billingModal(myObj.data);
                //location.reload();
              }
            );
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

  $("#billingUpdate").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#billingUpdate");
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
            // $('#exampleModal').hide();
            // $('.modal-backdrop').hide();
            showAlert("Bill Update Successfully");
            Swal.fire("Good job!", "Bill Updated Successfully", "success").then(
              (result) => {
                //document.getElementById("billAdd").reset();
                billingModal(myObj.data);
                //location.reload();
              }
            );
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

function setValue(item) {
  $("#client").val(item.client_name);
  $("#client_id").val(item.id);
  $("#cont").val(item.contact);
  //hideLoader()
}

function setServiceProvider(data, elem) {
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

  applyDiscountMembership(elem);
  getAvailableServiceProvider(
    $("#billing_date").val(),
    data.id,
    data.ser_stime,
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
  var lastId = parseInt(lastElem[26]);

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
                    <select name="billing_product[${firstNum}][sp_id][${lastId}][service_provider_id]" class="form-select form-select-sm staff" required>
                        ${option}
                    </select>
                    <input type="hidden" name="billing_product[${firstNum}][sp_id][${lastId}][id]" value="">
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
                <tr data-id='tr-${arrayKey}'>
                    <td style="vertical-align: middle;">
                        <span class="sno text-danger" onclick='removeServiceProviderServices(this);changeTiming(this);'><i class="fas fa-trash"></i></span>
                    </td>
                    <td>
                                                            <div class="row" style="width: 250px;">
                                                                <div class="col-4 pr-1">
                                                                    <input type="text" class="service-category form-control form-control-sm" onkeyup="searchCategory(this)" name="" placeholder="Category" autocomplete="off">
                                                                    <input type="hidden" class="ser_cat_id" name="billing_product[${arrayKey}][service_cat_id]">
                                                                    <input type="hidden" class="billing_product_id" value="" name="billing_product[${arrayKey}][id]">
                                                                </div>
                                                                <div class="col-8 pl-1">
                                                                    <input type="text" class="category-services form-control form-control-sm" onkeyup="searchServices(this)" name="" placeholder="Service (Autocomplete)" required autocomplete="off">
                                                                    <input type="hidden" name="billing_product[${arrayKey}][service_id]" value="" class="serr serviceids">
                                                                    <input type="hidden" name="billing_product[${arrayKey}][service_type]" value="" class="service_type">

                                                                    <input type="hidden" name="service[]" value="" class="serr">
                                                                    <input type="hidden" name="durr[]" value="" class="durr">
                                                                    <input type="hidden" name="pa_ser[]" value="" class="pa_ser">



                                                                    <input type="hidden" name="billing_product[${arrayKey}][package_id]" value="0" class="package_id">
                                                                    <input type="hidden" name="billing_product[${arrayKey}][client_package_id]" value="0" class="client_package_id">
                                                                    <input type="hidden" name="billing_product[${arrayKey}][package_details_id]" value="0" class="package_details_id">
                                                                    <input type="hidden" name="billing_product[${arrayKey}][client_package_quantity]" value="0" class="client_package_quantity">


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
                                                            <div class="row mb-1" id="service-provider-box" style="width: 200px;">
                                                                <div class="col-9 pr-1">
                                                                    <select name="billing_product[${arrayKey}][sp_id][0][service_provider_id]" class="form-select form-select-sm staff">
                                                                        <option value="0">Service Provider</option>
                                                                    </select>
                                                                    <input type="hidden" name="billing_product[${arrayKey}][sp_id][0][id]" value="">
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
                                                                    <input type="number" class="form-control form-control-sm service-price" name="billing_product[${arrayKey}][price]" placeholder="0" value="0" oninput="changeBillingPrice(this)">
                                                                    <input type="hidden" class="old-price">
                                                                </div>
                                                            </div>
                                                        </td>
                </tr>`;

    const addBefore = prevElem;
    addBefore.before(mainHtml);
    setTimePicker();

    setServiceFocus(addBefore);
  }
}

function removeServiceProviderServices(elem) {
  //$(elem).parent().parent().hide();
  $(elem).parent().parent().remove();
}

function addMultiTransaction() {
  const addBefore = $("#addBeforeTransaction");

  var preElem = $(addBefore).prev().find(".transid").attr("name");

  var trdata = preElem.replace(/[^0-9]/gi, "");
  var arrayKey = parseInt(parseInt(trdata, 10) + 1);

  var keyArr = arrayKey;
  const transHtml = `<div class="row my-1">
                        <div class="col-4">
                            <input type="text" name="billing_payment[${keyArr}][transaction_id]" class="key form-control transid" placeholder="TXN ID" onchange="advanceGiven(this)">
                            <input type="hidden" name="billing_payment[${keyArr}][id]" value="">
                        </div>

                        <div class="col-3">
                            <input type="number" name="billing_payment[${keyArr}][advance]" class="key form-control adv advance-amount" value="0" step="0.1" onchange="advanceGiven(this)" required>
                        </div>

                        <div class="col-3">
                            <select name="billing_payment[${keyArr}][method]" class="form-select adv-type" onchange="advanceGiven(this)" required>
                                <option value="">Select</option>
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

        if (error !== true) {
          $(this).val(ui.item.value);
          $(elem).parent().find(".serr").val(ui.item.id);
          $(elem).parent().find(".service_type").val(ui.item.type);
          $(ser_cat_txt_elem).val(ui.item.category_name);
          $(ser_cat_elem).val(ui.item.category_id);

          setServiceProvider(ui.item, elem);
          countPackage();



          var row = $(this).parent().parent().parent().parent()

          var trId = $(row).attr('data-id')
          client_check_available_package(ui.item.id, elem, trId);
        }
      },
      change: function (event, ui) {
        var id = (ui?.item?.id)
        id = id ? id : 0;

        if (id == 0) {

          var row = $(this).parent().parent().parent().parent()//.parent().parent();

          row.find('input[type="text"]').val('');
          row.find('input[type="number"]').val(0);
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

    countPackage();
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
              getServerFormatDate($(".billing_date").val()) +
              " " +
              convert12to24hours($("#billing_time").val())
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
              dt["min_reward_points_earned"] +
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
    var service_type = row.find(".service_type");

    var discount_on_package = $("#discount_on_package");
    var discount_on_package_type = $("#discount_on_package_type");

    var discount_on_product = $("#discount_on_product");
    var discount_on_product_type = $("#discount_on_product_type");

    var discount_on_service = $("#discount_on_service");
    var discount_on_service_type = $("#discount_on_service_type");

    var discount_value = (discount_value_type = "");

    if (service_type.val() == "service") {
      discount_value = discount_on_service.val();
      discount_value_type = discount_on_service_type.val();
    }

    if (service_type.val() == "stock") {
      discount_value = discount_on_product.val();
      discount_value_type = discount_on_product_type.val();
    }

    if (service_type.val() == "package") {
      discount_value = discount_on_package.val();
      discount_value_type = discount_on_package_type.val();
    }

    if (discount_value != 0) {
      service_discount.val(discount_value);
      service_discount.attr("readonly", "true");

      var op = discount_type.find("option");
      for (var i = 0; i < op.length; i++) {
        if (op[i].value != discount_value_type) {
          op[i].disabled = true;
        }
      }
      discount_type.val(discount_value_type).change();
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

  if (totalAmount != "" || totalAmount == 0) {
    sub_input.val(totalAmount);
    total_charge.val(totalAmount);
    sub_charge.val(totalAmount);
    pending_due.val(totalAmount);
    original_total_charge.val(totalAmount);

    set_coupon_discount();
    //setDiscount();
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
    countPackage();
  }
}

function setDiscount() {
  var total_charge = $("#total");
  var original_total_charge = $("#original_total_charge");
  var discountType = $(".total-discount-select");
  var pending_due = $("#pending_due");

  var oldPrice = $("#sum-input");
  var sum_input = $("#sum-input");
  var totalPrice = oldPrice.val();
  var coupon_code = $('#coupon_code').val()
  var coupon_discount = $('#coupon-discount').val()

  if (coupon_code != '' && coupon_discount != 0) {
    oldPrice = $(".coupon-discount-amount");
    sum_input = $(".coupon-discount-amount");
    totalPrice = oldPrice.val();
  }


  var discount = $(".total-discount-input").val();


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
    var totalValue = parseFloat(original_total_charge.val());

    var taxInterest = (totalValue * dataGst) / 100;

    var totalAfterInterest = Math.round(parseFloat(totalValue + taxInterest));

    total.val(totalAfterInterest);
    pend.val(totalAfterInterest);
  } else {
    total.val(Math.round(original_total_charge.val()));
    pend.val(Math.round(original_total_charge.val()));
  }

  countPaybleAmount();
}

function countPaybleAmount() {
  var total = $("#total");
  var payble_amount = $("#payble_amount");
  var advance_receive = $("#advance_receive");
  var pending_due = $("#pending_due");

  var paybleAmount = Math.round(parseFloat(total.val() - advance_receive.val()));

  payble_amount.val(paybleAmount);
  pending_due.val(paybleAmount);

  advanceGivenAll();
}

function advanceGiven(elem) {
  var total = $("#payble_amount");
  var totalValue = total.val();

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

function setTotalPendingDue() {
  var totalAdvance = countTotalAdvance();

  var total = $("#payble_amount");
  var pendingDue = $("#pending_due");

  var pendingAmount = parseFloat(total.val() - totalAdvance);

  if (totalAdvance <= total.val()) {
    pendingDue.val(pendingAmount);
  } else {
    showAlert("Advance amount exceeded total amount.", "orange");
    //adv.val();
  }
}

// pending task

// in searchServices function change error false to true;

// uncomment removeServiceProviderServices()

// when service provider unavailable then set empty to all field

//issue in time date old and time update for am
//get-service.php

//

function billingModal(bid) {
  /*
  $.ajax({
    url: "./inc/billing/get-billing-modal.php",
    type: "POST",
    data: { bid: bid },
    success: function (data) {*/
  onclickVal1 = `print_bill('${bid}')`;
  $("#print_bill").attr("onclick", onclickVal1);

  onclickVal2 = `send_sms('${bid}')`;
  $("#sms_bill").attr("onclick", onclickVal2);

  onclickVal3 = `send_mail('${bid}')`;
  $("#email_bill").attr("onclick", onclickVal3);

  $(".product-consumption-wrapper").hide();

  addProductConsumption(bid);
  $("#bill_options").modal("show");
  /*},
  });*/
}

$(document).ready(function () {
  $("#bill_options").on("hidden.bs.modal", function () {
    window.location = "billing-bill.php";
  });
});

function print_bill(inv_id) {
  window.open("./invoice.php?inv=" + inv_id, "_blank");
}

var params = window.location.search;
var url_string = window.location;
var url = new URL(url_string);
var id = url.searchParams.get("id");
var leadid = url.searchParams.get("leadid");
var aid = url.searchParams.get("aid");

if (id != null || leadid != null || aid != null) {
  $(document).ready(function () {
    //set today date
    var client_id = $("#client_id");
    clientView(client_id.val());

    if (leadid != null) {
      $(".billing_date").val(getTodayDate());
      $(".billing_time").val(getCurrentTime("hh"));

      var categoryServices = $(".category-services");
      var categoryServicesId = $(".serviceids");
      var timestamp = `${getServerFormatDate(
        $(".billing_date").val()
      )} ${convert12to24hours($(".billing_time").val(), 2)}`;
      var membership_id = $("#membership_id").val();

      $.ajax({
        url: "inc/enquiry/get-enquiry-for.php",
        type: "POST",
        data: {
          membership_id: membership_id,
          category_id: "",
          terms: "",
          name: categoryServices.val(),
          timestamp: timestamp,
          service_id: categoryServicesId.val(),
          service_type: $(".service_type").val(),
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
            countPackage();
          }
        },
      });
    }

    countPackage();
  });
} else {
  $(".billing_date").val(getTodayDate());
  $(".billing_time").val(getCurrentTime("hh"));
}

function pendingPayment(elem) {
  var id = $(elem).parent().parent().find(".pending_id").val();
  var paid = $(elem).parent().parent().find(".amtpay").val();
  var mode = $(elem).parent().parent().find(".mthd").val();

  if (paid != 0) {
    var formValues = { id: id, paid: paid, mode: mode };
    var url = "./inc/payment/pending-payment-add.php";
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
            showAlert("Pending Payment Saved Successfully");
            Swal.fire(
              "Good job!",
              "Pending Payment Saved Successfully",
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

function addProductConsumption(inv) {
  $.ajax({
    url: "./inc/service/get-service-product.php",
    method: "post",
    data: {
      inv: inv,
    },
    success: function (response) {
      $(".product-consumption-wrapper").show();
      $("#product_cons_table").html(response);
    },
  });
}

function send_sms(inv) {
  $.ajax({
    url: "./inc/billing/billing-send-sms.php",
    method: "post",
    data: {
      invoice_number: inv,
    },
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
        showAlert("SMS Send Successfully");
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

function send_mail(inv) {
  $.ajax({
    url: "./inc/billing/billing-send-mail.php",
    method: "post",
    data: {
      invoice_number: inv,
    },
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
        showAlert("Mail Send Successfully");
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

$(document).ready(function () {
  $("#consumption_form").on("submit", function (event) {
    console.log(event);
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#consumption_form");
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
          instanceLoading.hideLoading()
          const myObj = JSON.parse(data);

          if (myObj.success == true) {
            showAlert("Product Consumption Successfully");
            $("#bill_options").modal("hide");
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


function check_referral_code(elem) {
  var val = $(elem).val();
  var referral_code = $('#referral_code');
  var referral_code_label = $('.referral_code_label');
  var referral_code_message = $('.referral_code_message');
  var ErrorMsg = "";

  var client_name = $('.client_name');
  var client_name_label = $('.client_name_label');

  if (client_name.val() == '') {
    ErrorMsg = "First, Fill Client Details"
    addError(client_name_label, client_name, ErrorMsg);
    showAlert(ErrorMsg, "red");
    referral_code.val('')
  } else {
    removeError(client_name_label, client_name);
    var client_id = $('#client_id').val()

    client_id = (client_id == '') ? 0 : client_id;
    $.ajax({
      type: "POST",
      url: "inc/billing/refferal-code-check.php",
      data: { referral_code: val, client_id: client_id },
      success: function (data) {
        const myObj = JSON.parse(data);

        if (myObj.available == 0) {
          ErrorMsg = "Invalid Referral Code"
          addError(referral_code_label, referral_code, ErrorMsg);
          showAlert(ErrorMsg, "red");
          referral_code.val('');
        }

        if (myObj.available == 1) {
          ErrorMsg = "Already Used Referral Code"
          addError(referral_code_label, referral_code, ErrorMsg);
          showAlert(ErrorMsg, "red");
          referral_code.val('');
        }

        if (myObj.available == 2) {
          ErrorMsg = "Referral Code Applied"
          //addError(referral_code_label, referral_code, ErrorMsg);
          showAlert(ErrorMsg);
          removeError(referral_code_label, referral_code);
        }

      },
      error: function (data) {
        removeError(referral_code_label, referral_code);
      },
    });
  }
}

function check_coupon_code(elem) {
  var val = $(elem).val();
  var coupon_code = $('#coupon_code');
  var coupon_code_label = $('.coupon_code_label');
  var sub_total = $('#sum-input');
  var sub_total_label = $('.sub_total_label')
  var ErrorMsg = "";

  var client_name = $('.client_name');
  var client_name_label = $('.client_name_label');
  var client_id = $('#client_id').val();
  client_id = (client_id == '') ? 0 : client_id;
  var category_services = $('.category-services');
  var error = false;

  if (client_name.val() == '') {
    ErrorMsg = "First, Fill Client Details"
    addError(client_name_label, client_name, ErrorMsg);
    showAlert(ErrorMsg, "red");
    coupon_code.val('')
    error = true;
    return false;
  } else {
    removeError(client_name_label, client_name);
    error = true;
  }


  if (sub_total.val() == 0) {
    ErrorMsg = "Purchase one service for applying coupon"
    addError(client_name_label, category_services, ErrorMsg);
    showAlert(ErrorMsg, "red");
    coupon_code.val('')
    error = true;
    return false;
  } else {
    removeError(client_name_label, category_services);
    error = false;
  }



  if (error == false && coupon_code.val() != '') {
    $.ajax({
      type: "POST",
      url: "inc/billing/coupon-code-check.php",
      data: { coupon_code: val, client_id: client_id, sub_total: sub_total.val() },
      success: function (data) {
        const myObj = JSON.parse(data);
        if (myObj.status == true) {
          ErrorMsg = "Coupon Code Applied"
          showAlert(ErrorMsg);
          removeError(coupon_code_label, coupon_code);

          $(".coupon-discount").val(myObj.modal.discount)
          $(".coupon-discount-type").val(myObj.modal.discount_type)
          $(".coupon-max-dis-amt").val(myObj.modal.max_discount_amount)

          //set_coupon_discount()
          countPackage()

        } else {
          ErrorMsg = myObj.error
          addError(coupon_code_label, coupon_code, ErrorMsg);
          showAlert(ErrorMsg, "red");
          coupon_code.val('');
        }

      },
      error: function (data) {
        removeError(coupon_code_label, coupon_code);
      },
    });
  }
}

function set_coupon_discount() {

  var coupon_code = $('#coupon_code').val()
  var discount = $(".coupon-discount").val()
  var discountType = $(".coupon-discount-type")
  var max_dis_amt = $(".coupon-max-dis-amt").val()

  var oldPrice = $("#sum-input");
  var total_charge = $("#total");
  var original_total_charge = $("#original_total_charge")
  var pending_due = $("#pending_due")

  var totalPrice = oldPrice.val()

  var coupon_discount_amount = $('.coupon-discount-amount');



  if (totalPrice != 0) {
    if (coupon_code != '' && discount != 0) {
      if (discountType.val() == "percentage") {
        var maxDiscount = 100 - discount;
        var leftPrice = Math.round((totalPrice * maxDiscount) / 100);
      } else {
        var leftPrice = Math.round(parseFloat(totalPrice - discount));
      }

      leftPrice = (leftPrice > max_dis_amt) ? max_dis_amt : leftPrice
      leftPrice = Math.round((totalPrice - leftPrice))

      total_charge.val(leftPrice);
      pending_due.val(leftPrice);
      original_total_charge.val(leftPrice);

      coupon_discount_amount.val(leftPrice);

    }
  }
  setDiscount();
}

function changeBillingPrice(elem) {

  var value = $(elem).val();
  var oldPrice = $(elem).parent().find('.old-price')
  oldPrice.val(value)

  countPackage();
}

document.addEventListener('keydown', function (event) {
  if (event.keyCode === 45) { // 45 is the key code for the `insert` key.
    addServiceProviderServices()
  }
});


function setServiceFocus(elem) {
  var element = $(elem).prev().find('.category-services')
  $(element).focus()
}




function client_check_available_package(service_id, elem, row_id) {
  var client_id = $('#client_id').val();
  var membership_id = $("#membership_id").val();
  if (membership_id == 0 && client_id != 0) {

    $.ajax({
      url: "./inc/package/get-available-package.php",
      type: "POST",
      data: { client_id: client_id, service_id: service_id, row_id: row_id },
      success: function (data) {
        if (data != "") {
          const myModal = new bootstrap.Modal("#clientPackageModal", {
            keyboard: false,
          });
          const modalToggle = $("#clientPackageModal");
          myModal.show(modalToggle);
          $("#availablePackage").html(data);
        }
      },
    });
  }
}



function consumePackage(row_id, service_id, package_id, client_package_id, package_details_id, client_package_quantity) {

  var trId = `tr[data-id='${row_id}'`
  var row = $('#catTable').find(trId)

  $(row).find('.package_id').val(package_id)
  $(row).find('.client_package_id').val(client_package_id)
  $(row).find('.package_details_id').val(package_details_id)
    .val(client_package_quantity)

  var quantity = $(row).find('.service-quantity').val()
  var price = $(row).find('.service-price')
  var priceValue = $(price).val()

  var singlePrice = parseFloat(priceValue / quantity)

  var finalPrice = parseFloat(priceValue - singlePrice)

  price.val(finalPrice)

  $('#clientPackageModal').modal('hide');

  changeBillingPrice(price);



  $(row).find('.service-discount').attr("readonly", "true");
  $(row).find('.service-quantity').attr("readonly", "true");

  var op = $(row).find('.discount-type').find("option");
  for (var i = 0; i < op.length; i++) {
    op[i].disabled = true;
  }


  showAlert("Package successfully applied.", "green");

}