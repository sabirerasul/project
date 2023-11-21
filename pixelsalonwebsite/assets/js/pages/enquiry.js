$(document).ready(function () {
  // client add logic
  $("#AddEnquiryForm").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#AddEnquiryForm");
    var url = form.attr("action");


    var branch_id = $(".branch_id");
    var branch_id_label = $(".branch_id_label");

    var client_name = $(".client_name");
    var client_name_label = $(".client_name_label");

    var contact = $(".contact");
    var contact_label = $(".contact_label");

    var email = $(".email");
    var email_label = $(".email_label");

    var followdate = $(".followdate");
    var followdate_label = $(".followdate_label");

    var enquiry_for = $(".enquiry_for");
    var enquiry_for_label = $(".enquiry_for_label");

    var source_of_enquiry = $(".source_of_client");
    var source_of_enquiry_label = $(".source_of_client_label");


    var error = false;
    var ErrorMsg = "";

    if (branch_id.val() == "") {
      ErrorMsg = "Branch field is required";
      addError(branch_id_label, branch_id, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(branch_id_label, branch_id);

    }

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
      ErrorMsg = "Date to Follow cannot be blank";
      addError(followdate_label, followdate, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(followdate_label, followdate);
    }


    if (enquiry_for.val() == "") {
      ErrorMsg = "Interested in cannot be blank";
      addError(enquiry_for_label, enquiry_for, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(enquiry_for_label, enquiry_for);
    }

    if (source_of_enquiry.val() == "") {
      ErrorMsg = "Source of enquiry cannot be blank";
      addError(source_of_enquiry_label, source_of_enquiry, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(source_of_enquiry_label, source_of_enquiry);
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

            $("#clientModalClose").click();
            showAlert("Enquiry added successfully");
            Swal.fire(
              "Good job!",
              "Enquiry Submitted successfully",
              "success"
            ).then((result) => {
              document.getElementById("AddEnquiryForm").reset();
              window.location = './enquiry.php';
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