
$(document).ready(function () {
  $("#addService").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#addService");
    var url = form.attr("action");

    var category_field = $("#category_field");
    var category_field_label = $(".category_field_label");

    var service_name = $("#service_name");
    var service_name_label = $(".service_name_label");

    var service_price = $("#service_price");
    var service_price_label = $(".service_price_label");

    var membership_price = $("#membership_price");
    var membership_price_label = $(".membership_price_label");

    var duration = $("#duration");
    var duration_label = $(".duration_label");

    var error = false;
    var ErrorMsg = "";

    if (category_field.val() == "") {
      ErrorMsg = "Category field is required";
      addError(category_field_label, category_field, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(category_field_label, category_field);
    }

    if (service_name.val() == "") {
      ErrorMsg = "Service Name field is required";
      addError(service_name_label, service_name, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(service_name_label, service_name);
    }

    if (service_price.val() == "") {
      ErrorMsg = "Price field is required";
      addError(service_price_label, service_price, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(service_price_label, service_price);
    }

    if (membership_price.val() == "") {
      ErrorMsg = "Membership Price field is required";
      addError(membership_price_label, membership_price, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(membership_price_label, membership_price);
    }

    if (duration.val() == "") {
      ErrorMsg = "Duration field is required";
      addError(duration_label, duration, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(duration_label, duration);
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
          const myObj = JSON.parse(data);
          instanceLoading.hideLoading()
          if (myObj.success == true) {
            showAlert("New Service Added successfully");
            Swal.fire(
              "Good job!",
              "New Service Added successfully",
              "success"
            ).then((result) => {
              document.getElementById("addService").reset();
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

  dataTableLoadSuperAdmin();
  dataTableLoadBranches();
  dataTableLoadTemplate();

});

function dataTableLoadSuperAdmin() {
  var table = $("#dataTableService").DataTable();
}

function dataTableLoadBranches() {
  var table = $("#dataTableCategory").DataTable();
}

function dataTableLoadTemplate() {
  var table = $("#dataTableTemplate").DataTable();
}


$(document).ready(function() {
  $(".working_hours_start").datetimepicker({
      format: "HH:ii P",
      showMeridian: true,
      autoclose: true,
      pickDate: false,
      startView: 1,
      maxView: 1,
  });

  $(".working_hours_end").datetimepicker({
      format: "HH:ii P",
      showMeridian: true,
      autoclose: true,
      pickDate: false,
      startView: 1,
      maxView: 1,
  });
})