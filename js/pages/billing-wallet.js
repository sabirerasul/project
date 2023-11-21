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

  //set today date
  $(".present_date").val(getTodayDate());
  $(".present_time").val(getCurrentTime("hh"));

  $(".present_time").datetimepicker({
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
  // })

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

  $("#walletAdd").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#walletAdd");
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
          instanceLoading.hideLoading()
          const myObj = JSON.parse(data);

          if (myObj.success == true) {
            // $('#exampleModal').hide();
            // $('.modal-backdrop').hide();
            showAlert("Amount Added Successfully");
            Swal.fire(
              "Good job!",
              "Amount Added Successfully",
              "success").then((result) => {
                document.getElementById("walletAdd").reset();
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

function setValue(item) {
  $("#client").val(item.client_name);
  $("#client_id").val(item.id);
  $("#cont").val(item.contact);
}

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
        var ds = JSON.parse(data);
        instanceLoading.hideLoading()
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
            "<div style='background:#00a400' class='rounded p-1'><h4 class='h5 b-0 text-white'>Customer type: Active</h4><small class='text-white'>Active Customers - Customers who visit your outlet at regular intervals.  </small></div>"
          );
        } else if (ds["customer_type"] == "inactive") {
          $("#customer_type").html(
            "<div style='background:#fa383e' class='rounded p-1'><h4 class='h5 b-0 text-white'>Customer type: Defected customer</h4><small class='text-white'>Defected Customers - Customers who haven't visited your outlet and become inactive. </small></div>"
          );
        } else if (ds["customer_type"] == "newcustomer") {
          $("#customer_type").html(
            "<div style='background:#622bfb' class='rounded p-1'><h4 class='h5 b-0 text-white'>Customer type: New Customer</h4><small class='text-white'>Customer who haven't visited your outlet. </small></div>"
          );
        } else {
          $("#customer_type").html(
            "<div  style='background:#fff200' class='rounded p-1'><h4 class='h5 b-0 text-white' >Customer type: Churn prediction</h4><small >Churn Prediction - Customers who haven't visited your outlet and who are likely to leave. </small> </div>"
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