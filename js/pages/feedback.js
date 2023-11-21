$(document).ready(function () {

  loadStaffTable();

  $("#addStaffForm").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();

    var form = $("#addStaffForm");

    var url = form.attr("action");

    var error = false;

    var label_name = $(".label_name");
    var name = $(".name");

    var label_email = $(".label_email");
    var email = $(".email");

    var label_mobile = $(".label_mobile");
    var mobile = $(".mobile");

    var label_address = $(".label_address");
    var address = $(".address");

    var label_affected_countries_last = $(".affected_countries_last_name");
    var affected_countries_last = $(".affected_countries_last");

    var label_confirmed_case_coronavirus = $(
      ".label_confirmed_case_coronavirus"
    );
    var confirmed_case_coronavirus = $(".confirmed_case_coronavirus");

    var label_experiencing_symptoms = $(".label_experiencing_symptoms");
    var experiencing_symptoms = $(".experiencing_symptoms");

    var ErrorMsg = "";

    if (name.val() == "") {
      ErrorMsg = "Name field is required";
      addError(label_name, name, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(label_name, name);
    }

    if (email.val() == "") {
      ErrorMsg = "Email field is required";
      addError(label_email, email, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(label_email, email);
    }

    if (mobile.val() == "") {
      ErrorMsg = "Mobile cannot be blank";
      addError(label_mobile, mobile, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(label_mobile, mobile);
    }

    if (address.val() == "") {
      ErrorMsg = "Address cannot be blank";
      addError(label_address, address, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(label_address, address);
    }

    if (affected_countries_last.val() == "") {
      ErrorMsg = "affected countries cannot be blank";
      addError(
        label_affected_countries_last,
        affected_countries_last,
        ErrorMsg
      );
      error = true;
      return false;
    } else {
      error = false;
      removeError(label_affected_countries_last, affected_countries_last);
    }

    if (confirmed_case_coronavirus.val() == "") {
      ErrorMsg = "confirmed case cannot be blank";
      addError(
        label_confirmed_case_coronavirus,
        confirmed_case_coronavirus,
        ErrorMsg
      );
      error = true;
      return false;
    } else {
      error = false;
      removeError(label_confirmed_case_coronavirus, confirmed_case_coronavirus);
    }

    if (experiencing_symptoms.val() == "") {
      ErrorMsg = "experiencing symptoms cannot be blank";
      addError(label_experiencing_symptoms, experiencing_symptoms, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(label_experiencing_symptoms, experiencing_symptoms);
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
            showAlert("Self Assessment datt successfully added");
            Swal.fire(
              "Good job!",
              "Self Assessment datt successfully added",
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
});

function loadStaffTable() {
  $.ajax({
    type: "POST",
    url: "./inc/feedback/feedback-show.php",
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

function ExportToExcel(type, fn, dl) {
  var mytable = document.getElementById("dataTable");
  TableToExcel.convert(mytable);
}


