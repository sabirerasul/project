$(document).ready(function () {
  // client add logic
  $("#addClientForm").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#addClientForm");
    var url = form.attr("action");

    var clientName = $("#client_name");
    var contact = $("#contact");
    var email = $("#email");
    var labelemail = $(".email-label");

    var labelClientName = $(".client_name");
    var labelClientNumber = $(".client_number");

    var gender = $("#gender");
    var labelGender = $("#labelGender");

    var error = false;
    var ErrorMsg = "";
    if (clientName.val() == "") {
      ErrorMsg = "Client Name field is required";
      addError(labelClientName, clientName, ErrorMsg);
      error = true;
      return false;
    } else {
      if (isValidName(clientName.val()) == false) {
        ErrorMsg = "Client Name is not valid";
        addError(labelClientName, clientName, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(labelClientName, clientName);
      }
    }

    if (contact.val() == "") {
      ErrorMsg = "Client Number field is required";
      addError(labelClientNumber, contact, ErrorMsg);
      error = true;
      return false;
    } else {
      if (isValidNumber(contact.val()) == false) {
        ErrorMsg = "Number is not valid (ony 10 digit without country code)";
        addError(labelClientNumber, contact, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(labelClientNumber, contact);
      }
    }

    if (gender.val() == "") {
      ErrorMsg = "Gender cannot be blank";
      addError(labelGender, gender, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(labelGender, gender);
    }

    if (email.val() != "") {
      if (isValidEmail(email.val()) == false) {
        ErrorMsg = "Email is not valid";
        addError(labelemail, email, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(labelemail, email);
      }
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
              "New Client registered successfully",
              "success"
            );
            document.getElementById("addClientForm").reset();

            loadClientTable({ type: 'existing' });
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

  $("#followup_form").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#followup_form");
    var url = form.attr("action");
    var error = false;

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
            $("#followupModal").modal("hide");
            showAlert("form has been successfully submitted");
            Swal.fire(
              "Good job!",
              "New Follow up added successfully!",
              "success"
            );
            document.getElementById("followup_form").reset();
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

  loadClientTable({ type: 'existing' });

});

function loadClientTable(formData = "") {
  $.ajax({
    type: "POST",
    url: "./inc/client/client-show.php",
    data: formData,
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
    },
  });
}

function dataTableLoad() {
  $("#dataTable").DataTable();
}


function setTable(result) {
  $("#table-html").html('<tr></tr>');
  $("#table-html").html(result);
  setTimeout(dataTableLoad, 1000);
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
      Swal.fire("Deleted!", "Your file has been deleted.", "success");

      $.ajax({
        type: "POST",
        url: "inc/client/client-delete.php",
        data: { cid: v },
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
            loadClientTable({ type: 'existing' });

          }
        },
        error: function (data) { instanceLoading.hideLoading() },
      });
    }
  });
}

$(document).ready(function () {
  $("#filterForm").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    loadClientTable(formValues);
  });
});

function addFollowup(id) {
  $("#client_id").val(id);
  $("#followupModal").modal("show");
}

$(document).ready(function () {
  $(".followup_time").datetimepicker({
    format: "HH:ii P",
    showMeridian: true,
    autoclose: true,
    pickDate: false,
    startView: 1,
    maxView: 1,
  });

  const picker1 = datepicker(".user-dob", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });

  const picker2 = datepicker(".user-anniversary", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });

  const picker3 = datepicker(".followup_date", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });


  $(".followup_date").val(getTodayDate());

  $(".followup_time").val(getCurrentTime("hh"));
});


function genReferral(elem, id) {
  var url = "./inc/client/client-referral-code-add.php";
  $.ajax({
    type: "POST",
    url: url,
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
      instanceLoading.hideLoading()
      const myObj = JSON.parse(data);

      if (myObj.success == true) {
        showAlert("Referral Code generated successfully!");
        $(elem).parent().html(myObj.data)
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