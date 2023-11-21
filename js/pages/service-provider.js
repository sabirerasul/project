$(document).ready(function () {

  loadServiceProviderTable();

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

  var monthdate = new Date(), y = monthdate.getFullYear(), m = monthdate.getMonth();
  var firstDay = new Date(y, m, 1);
  var lastDay = new Date(y, m + 1, 0);

  $('input[name="daterange"]').daterangepicker({
    opens: 'left',
    startDate: getDateFromObj(firstDay),
    endDate: getDateFromObj(lastDay),
  }, function (start, end, label) {

    //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });


  $("#addServiceProviderForm").on("submit", function (event) {
    event.preventDefault();
    //var formValues = $(this).serialize();

    var form = $("#addServiceProviderForm");
    var formValues = $("#addServiceProviderForm").serializeArray();

    var url = form.attr("action");

    var error = false;

    var emp_name_label = $(".emp_name_label");
    var emp_name = $(".emp_name");

    var productCommision = $(".product-commision");
    var productCommision_label = $(".product-commision_label");
    var serviceCommision = $(".service-commision");
    var serviceCommision_label = $(".service-commision_label");

    var emp_dob_label = $(".emp_dob_label");
    var emp_dob = $(".emp_dob");
    var emp_number_label = $(".emp_number_label");
    var emp_number = $(".emp_number");
    var emp_email_label = $(".emp_email_label");
    var emp_email = $(".emp_email");

    var working_hours_start_label = $(".working_hours_start_label");
    var working_hours_start = $(".working_hours_start");
    var working_hours_end_label = $(".working_hours_end_label");
    var working_hours_end = $(".working_hours_end");

    var emp_salary_label = $(".emp_salary_label");
    var emp_salary = $(".emp_salary");

    var service_provider_type_label = $(".service_provider_type_label");
    var service_provider_type = $(".service_provider_type");

    var emp_username_label = $(".emp_username_label");
    var emp_username = $(".emp_username");
    /*
        var emp_password_label = $('.emp_password_label');
        var emp_password = $('.emp_password');
        var emp_confirm_password_label = $('.emp_confirm_password_label');
        var emp_confirm_password = $('.emp_confirm_password');
        */
    var emp_gender_label = $(".emp_gender_label");
    var emp_gender = $(".emp_gender");
    var emp_doj_label = $(".emp_doj_label");
    var date_of_joining = $(".date_of_joining");
    var emp_department_label = $(".emp_department_label");
    var emp_department = $(".emp_department");

    var photo = $("#photo");
    var id_front_proof = $("#id_front_proof");
    var id_back_proof = $("#id_back_proof");

    var photo_label = $(".photo_label");
    var id_front_proof_label = $(".id_front_proof_label");
    var id_back_proof_label = $(".id_back_proof_label");

    var ErrorMsg = "";

    if (emp_name.val() == "") {
      ErrorMsg = "Name field is required";
      addError(emp_name_label, emp_name, ErrorMsg);
      error = true;
      return false;
    } else {
      if (isValidName(emp_name.val()) == false) {
        ErrorMsg = "Name is not valid";
        addError(emp_name_label, emp_name, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(emp_name_label, emp_name);
      }
    }

    if (serviceCommision.val() != "") {
      if (serviceCommision.val() > 100) {
        ErrorMsg = "Invalid Service Commision Percentage";
        addError(serviceCommision_label, serviceCommision, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(serviceCommision_label, serviceCommision);
      }
    }

    if (productCommision.val() != "") {
      if (productCommision.val() > 100) {
        ErrorMsg = "Invalid Product Commision Percentage";
        addError(productCommision_label, productCommision, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(productCommision_label, productCommision);
      }
    }

    if (emp_number.val() == "") {
      ErrorMsg = "Number field is required";
      addError(emp_number_label, emp_number, ErrorMsg);
      error = true;
      return false;
    } else {
      if (isValidNumber(emp_number.val()) == false) {
        ErrorMsg = "Number is not valid (ony 10 digit without country code)";
        addError(emp_number_label, emp_number, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(emp_number_label, emp_number);
      }
    }

    if (emp_email.val() != "") {
      if (isValidEmail(emp_email.val()) == false) {
        ErrorMsg = "Email is not valid";
        addError(emp_email_label, emp_email, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(emp_email_label, emp_email);
      }
    }

    if (working_hours_start.val() == "") {
      ErrorMsg = "Working Hours Start cannot be blank";
      addError(working_hours_start_label, working_hours_start, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(working_hours_start_label, working_hours_start);
    }

    if (working_hours_end.val() == "") {
      ErrorMsg = "Working Hours End cannot be blank";
      addError(working_hours_end_label, working_hours_end, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(working_hours_end_label, working_hours_end);
    }

    if (emp_salary.val() == "") {
      ErrorMsg = "Salary cannot be blank";
      addError(emp_salary_label, emp_salary, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(emp_salary_label, emp_salary);
    }
    /*
    if (emp_password.val() == "") {
      ErrorMsg = "Password cannot be blank";
      addError(emp_password_label, emp_password, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(emp_password_label, emp_password);
    }

    if (emp_confirm_password.val() == "") {
      ErrorMsg = "Confirm Password cannot be blank";
      addError(emp_confirm_password_label, emp_confirm_password, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(emp_confirm_password_label, emp_confirm_password);
    }

    if (
      emp_password.val() != "" &&
      emp_confirm_password.val() != "" &&
      emp_password.val() != emp_confirm_password.val()
    ) {
      ErrorMsg = "Password and Confirm Password must be same";
      addError(emp_confirm_password_label, emp_confirm_password, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(emp_confirm_password_label, emp_confirm_password);
    }

    */

    if (emp_gender.val() == "") {
      ErrorMsg = "Gender cannot be blank";
      addError(emp_gender_label, emp_gender, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(emp_gender_label, emp_gender);
    }

    if (date_of_joining.val() == "") {
      ErrorMsg = "Date of Joining cannot be blank";
      addError(emp_doj_label, date_of_joining, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(emp_doj_label, date_of_joining);
    }

    if (emp_department.val() == "") {
      ErrorMsg = "Department cannot be blank";
      addError(emp_department_label, emp_department, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(emp_department_label, emp_department);
    }

    // Get the files from the input
    var photofiles = photo[0].files;
    var id_front_prooffiles = id_front_proof[0].files;
    var id_back_prooffiles = id_back_proof[0].files;

    let allowedExtension = ["image/jpeg", "image/jpg", "image/png", "application/pdf"];

    if (photofiles.length != 0) {
      var photofile = photofiles[0];

      //Check the file type.
      if (!photofile.type.match("image.*")) {
        ErrorMsg = "file format not supported.";
        addError(photo_label, photo, ErrorMsg);
        error = true;
        return false;
      } else {
        if (allowedExtension.indexOf(photofile.type) == -1) {
          ErrorMsg = "file format only jpg and png are currently supported.";
          addError(photo_label, photo, ErrorMsg);
          error = true;
          return false;
        } else {
          error = false;
          removeError(photo_label, photo);
        }
      }

      if (photofile.size >= 500000) {
        ErrorMsg = "Size exceeds the maximum limit of 500 KB.";
        addError(photo_label, photo, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(photo_label, photo);
      }
    }

    if (id_front_prooffiles.length != 0) {
      var id_front_prooffile = id_front_prooffiles[0];

      //Check the file type.
      if (!id_front_prooffile.type.match("image.*") && !id_front_prooffile.type.match("application.*")) {
        ErrorMsg = "file format not supported.";
        addError(id_front_proof_label, id_front_proof, ErrorMsg);
        error = true;
        return false;
      } else {
        if (allowedExtension.indexOf(id_front_prooffile.type) == -1) {
          ErrorMsg = "file format only jpg, png and pdf are currently supported.";
          addError(id_front_proof_label, id_front_proof, ErrorMsg);
          error = true;
          return false;
        } else {
          error = false;
          removeError(id_front_proof_label, id_front_proof);
        }
      }

      if (id_front_prooffile.size >= 500000) {
        ErrorMsg = "Size exceeds the maximum limit of 1 MB.";
        addError(id_front_proof_label, id_front_proof, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(id_front_proof_label, id_front_proof);
      }
    }

    if (id_back_prooffiles.length != 0) {
      var id_back_prooffile = id_back_prooffiles[0];

      //Check the file type.
      if (!id_back_prooffile.type.match("image.*") && !id_back_prooffile.type.match("application.*")) {
        ErrorMsg = "file format not supported.";
        addError(id_back_proof_label, id_back_proof, ErrorMsg);
        error = true;
        return false;
      } else {
        if (allowedExtension.indexOf(id_back_prooffile.type) == -1) {
          ErrorMsg = "file format only jpg, png and pdf are currently supported.";
          addError(id_back_proof_label, id_back_proof, ErrorMsg);
          error = true;
          return false;
        } else {
          error = false;
          removeError(id_back_proof_label, id_back_proof);
        }
      }

      if (id_back_prooffile.size >= 500000) {
        ErrorMsg = "Size exceeds the maximum limit of 500 KB.";
        addError(id_back_proof_label, id_back_proof, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(id_back_proof_label, id_back_proof);
      }
    }

    if (error == false) {
      var photofile1 = photofiles.length != 0 ? photofile : "";
      var id_front_prooffile1 =
        id_front_prooffiles.length != 0 ? id_front_prooffile : "";
      var id_back_prooffile1 =
        id_back_prooffiles.length != 0 ? id_back_prooffile : "";

      var form_data = new FormData();

      form_data.append("photo", photofile1);
      form_data.append("frontproof", id_front_prooffile1);
      form_data.append("backproof", id_back_prooffile1);

      for (let index = 0; index < formValues.length; index++) {
        const element = formValues[index];
        form_data.append(element.name, element.value);
      }

      $.ajax({
        type: "POST",
        url: url,
        data: form_data,
        contentType: false,
        processData: false,
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
              "New Service Provider registered successfully",
              "success"
            ).then((result) => {
              document.getElementById("addServiceProviderForm").reset();
              location.reload();
            })

            loadServiceProviderTable();
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

  $("#editServiceProviderForm").on("submit", function (event) {
    event.preventDefault();
    //var formValues = $(this).serialize();

    var form = $("#editServiceProviderForm");
    var formValues = $("#editServiceProviderForm").serializeArray();

    var url = form.attr("action");

    var error = false;

    var emp_name_label = $(".emp_name_label");
    var emp_name = $(".emp_name");

    var productCommision = $(".product-commision");
    var productCommision_label = $(".product-commision_label");
    var serviceCommision = $(".service-commision");
    var serviceCommision_label = $(".service-commision_label");

    var emp_dob_label = $(".emp_dob_label");
    var emp_dob = $(".emp_dob");
    var emp_number_label = $(".emp_number_label");
    var emp_number = $(".emp_number");
    var emp_email_label = $(".emp_email_label");
    var emp_email = $(".emp_email");

    var working_hours_start_label = $(".working_hours_start_label");
    var working_hours_start = $(".working_hours_start");
    var working_hours_end_label = $(".working_hours_end_label");
    var working_hours_end = $(".working_hours_end");

    var emp_salary_label = $(".emp_salary_label");
    var emp_salary = $(".emp_salary");
    var emp_username_label = $(".emp_username_label");
    var emp_username = $(".emp_username");

    /*
    var emp_password_label = $(".emp_password_label");
    var emp_password = $(".emp_password");
    var emp_confirm_password_label = $(".emp_confirm_password_label");
    var emp_confirm_password = $(".emp_confirm_password");
    */

    var emp_gender_label = $(".emp_gender_label");
    var emp_gender = $(".emp_gender");
    var emp_doj_label = $(".emp_doj_label");
    var date_of_joining = $(".date_of_joining");
    var emp_department_label = $(".emp_department_label");
    var emp_department = $(".emp_department");

    var photo = $("#photo");
    var id_front_proof = $("#id_front_proof");
    var id_back_proof = $("#id_back_proof");

    var photo_label = $(".photo_label");
    var id_front_proof_label = $(".id_front_proof_label");
    var id_back_proof_label = $(".id_back_proof_label");

    var ErrorMsg = "";

    if (emp_name.val() == "") {
      ErrorMsg = "Name field is required";
      addError(emp_name_label, emp_name, ErrorMsg);
      error = true;
      return false;
    } else {
      if (isValidName(emp_name.val()) == false) {
        ErrorMsg = "Name is not valid";
        addError(emp_name_label, emp_name, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(emp_name_label, emp_name);
      }
    }

    if (serviceCommision.val() != "") {
      if (serviceCommision.val() > 100) {
        ErrorMsg = "Invalid Service Commision Percentage";
        addError(serviceCommision_label, serviceCommision, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(serviceCommision_label, serviceCommision);
      }
    }

    if (productCommision.val() != "") {
      if (productCommision.val() > 100) {
        ErrorMsg = "Invalid Product Commision Percentage";
        addError(productCommision_label, productCommision, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(productCommision_label, productCommision);
      }
    }

    if (emp_number.val() == "") {
      ErrorMsg = "Number field is required";
      addError(emp_number_label, emp_number, ErrorMsg);
      error = true;
      return false;
    } else {
      if (isValidNumber(emp_number.val()) == false) {
        ErrorMsg = "Number is not valid (ony 10 digit without country code)";
        addError(emp_number_label, emp_number, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(emp_number_label, emp_number);
      }
    }

    if (emp_email.val() != "") {
      if (isValidEmail(emp_email.val()) == false) {
        ErrorMsg = "Email is not valid";
        addError(emp_email_label, emp_email, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(emp_email_label, emp_email);
      }
    }

    if (working_hours_start.val() == "") {
      ErrorMsg = "Working Hours Start cannot be blank";
      addError(working_hours_start_label, working_hours_start, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(working_hours_start_label, working_hours_start);
    }

    if (working_hours_end.val() == "") {
      ErrorMsg = "Working Hours End cannot be blank";
      addError(working_hours_end_label, working_hours_end, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(working_hours_end_label, working_hours_end);
    }

    if (emp_salary.val() == "") {
      ErrorMsg = "Salary cannot be blank";
      addError(emp_salary_label, emp_salary, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(emp_salary_label, emp_salary);
    }

    /*
            if(emp_password.val() == ''){
                ErrorMsg = "Password cannot be blank";
                addError(emp_password_label, emp_password, ErrorMsg);
                error = true;
                return false;
            }else{
                error = false;
                removeError(emp_password_label, emp_password);
            }
    
            if(emp_confirm_password.val() == ''){
                ErrorMsg = "Confirm Password cannot be blank";
                addError(emp_confirm_password_label, emp_confirm_password, ErrorMsg);
                error = true;
                return false;
            }else{
                error = false;
                removeError(emp_confirm_password_label, emp_confirm_password);
            }
    
        
    if (
      emp_password.val() != "" &&
      emp_confirm_password.val() != "" &&
      emp_password.val() != emp_confirm_password.val()
    ) {
      ErrorMsg = "Password and Confirm Password must be same";
      addError(emp_confirm_password_label, emp_confirm_password, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(emp_confirm_password_label, emp_confirm_password);
    }

    */

    if (emp_gender.val() == "") {
      ErrorMsg = "Gender cannot be blank";
      addError(emp_gender_label, emp_gender, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(emp_gender_label, emp_gender);
    }

    if (date_of_joining.val() == "") {
      ErrorMsg = "Date of Joining cannot be blank";
      addError(emp_doj_label, date_of_joining, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(emp_doj_label, date_of_joining);
    }

    if (emp_department.val() == "") {
      ErrorMsg = "Department cannot be blank";
      addError(emp_department_label, emp_department, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(emp_department_label, emp_department);
    }

    // Get the files from the input
    var photofiles = photo[0].files;
    var id_front_prooffiles = id_front_proof[0].files;
    var id_back_prooffiles = id_back_proof[0].files;

    let allowedExtension = ["image/jpeg", "image/jpg", "image/png", "application/pdf"];

    if (photofiles.length != 0) {
      var photofile = photofiles[0];

      //Check the file type.
      if (!photofile.type.match("image.*")) {
        ErrorMsg = "file format not supported.";
        addError(photo_label, photo, ErrorMsg);
        error = true;
        return false;
      } else {
        if (allowedExtension.indexOf(photofile.type) == -1) {
          ErrorMsg = "file format only jpg and png are currently supported.";
          addError(photo_label, photo, ErrorMsg);
          error = true;
          return false;
        } else {
          error = false;
          removeError(photo_label, photo);
        }
      }

      if (photofile.size >= 500000) {
        ErrorMsg = "Size exceeds the maximum limit of 500 KB.";
        addError(photo_label, photo, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(photo_label, photo);
      }
    }

    if (id_front_prooffiles.length != 0) {
      var id_front_prooffile = id_front_prooffiles[0];

      //Check the file type.
      if (!id_front_prooffile.type.match("image.*") && !id_front_prooffile.type.match("application.*")) {
        ErrorMsg = "file format not supported.";
        addError(id_front_proof_label, id_front_proof, ErrorMsg);
        error = true;
        return false;
      } else {
        if (allowedExtension.indexOf(id_front_prooffile.type) == -1) {
          ErrorMsg = "file format only jpg, png and pdf are currently supported.";
          addError(id_front_proof_label, id_front_proof, ErrorMsg);
          error = true;
          return false;
        } else {
          error = false;
          removeError(id_front_proof_label, id_front_proof);
        }
      }

      if (id_front_prooffile.size >= 500000) {
        ErrorMsg = "Size exceeds the maximum limit of 1 MB.";
        addError(id_front_proof_label, id_front_proof, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(id_front_proof_label, id_front_proof);
      }
    }

    if (id_back_prooffiles.length != 0) {
      var id_back_prooffile = id_back_prooffiles[0];

      //Check the file type.
      if (!id_back_prooffile.type.match("image.*") && !id_back_prooffile.type.match("application.*")) {
        ErrorMsg = "file format not supported.";
        addError(id_back_proof_label, id_back_proof, ErrorMsg);
        error = true;
        return false;
      } else {
        if (allowedExtension.indexOf(id_back_prooffile.type) == -1) {
          ErrorMsg = "file format only jpg, png and pdf are currently supported.";
          addError(id_back_proof_label, id_back_proof, ErrorMsg);
          error = true;
          return false;
        } else {
          error = false;
          removeError(id_back_proof_label, id_back_proof);
        }
      }

      if (id_back_prooffile.size >= 500000) {
        ErrorMsg = "Size exceeds the maximum limit of 500 KB.";
        addError(id_back_proof_label, id_back_proof, ErrorMsg);
        error = true;
        return false;
      } else {
        error = false;
        removeError(id_back_proof_label, id_back_proof);
      }
    }

    if (error == false) {
      var photofile1 = photofiles.length != 0 ? photofile : "";
      var id_front_prooffile1 =
        id_front_prooffiles.length != 0 ? id_front_prooffile : "";
      var id_back_prooffile1 =
        id_back_prooffiles.length != 0 ? id_back_prooffile : "";

      var form_data = new FormData();

      form_data.append("photo", photofile1);
      form_data.append("frontproof", id_front_prooffile1);
      form_data.append("backproof", id_back_prooffile1);

      for (let index = 0; index < formValues.length; index++) {
        const element = formValues[index];
        form_data.append(element.name, element.value);
      }

      $.ajax({
        type: "POST",
        url: url,
        data: form_data,
        contentType: false,
        processData: false,
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
            showAlert("Service Provider record has been updated successfully");
            Swal.fire(
              "Good job!",
              "Service Provider updated successfully",
              "success"
            ).then((result) => {
              document.getElementById("editServiceProviderForm").reset();
              window.location = "./service-provider.php";
            });

            loadServiceProviderTable();
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

  $("#saveCommission1").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#saveCommission1");
    var url = form.attr("action");

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
          showAlert("Commission record has been updated successfully");

          document.getElementById("saveCommission1").reset();
          setTimeout(() => {
            location.reload();
          }, 2000);
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
  });

  $("#saveCommission2").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#saveCommission2");
    var url = form.attr("action");

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
          showAlert("Commission record has been updated successfully");

          document.getElementById("saveCommission2").reset();
          setTimeout(() => {
            location.reload();
          }, 2000);
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
  });

  const picker1 = datepicker(".emp_dob", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });
});

function loadServiceProviderTable() {
  $.ajax({
    type: "POST",
    url: "./inc/service-provider/service-provider-show.php",
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
  var table = $("#dataTable").DataTable({
    scrollY: false,
    scrollX: true,
  });
}

function dataTableLoad2() {
  $("#offSettingDataTable").DataTable();
}

function fnExcelReport() {
  $.ajax({
    type: "POST",
    url: "./inc/service-provider/service-provider-show-full.php",
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

function deleteServiceProvider(v) {
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
      showAlert("Product deleted successfully");
      Swal.fire("Deleted!", "Product deleted successfully.", "success").then(
        (nresult) => {
          if (nresult.isConfirmed) {
            $.ajax({
              type: "POST",
              url: "inc/service-provider/service-provider-delete.php",
              data: { spid: v },
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
                  window.location = './service-provider.php'
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

function saveAssignServices() {
  var service = [];
  var provider_id = $("#provider_id").val();
  $(".provider_service").each(function () {
    if ($(this)[0].checked) {
      service.push($(this).val());
    }
  });

  if (service.length == 0) {
    showAlert("Please select min 1 service", "red");
  } else {
    $.ajax({
      url: "inc/service-provider/assign-service-provider-services.php",
      type: "POST",
      dataType: "JSON",
      data: { services: service.join(","), provider_id: provider_id },
      beforeSend: function () {
        instanceLoading.showLoading({
          type: 'cube_flip',
          color: '#ffffff',
          backgroundColor: '#025043',
          title: 'Loading...',
          fontSize: 16,
        });
      },
      success: function (response) {
        instanceLoading.hideLoading()
        if (response.status == 1) {
          showAlert("Services saved successfully");
          $("#save_service_btn").html(
            '<i class="fa fa-save" aria-hidden="true"></i> Save'
          );
          $("#s_services").html("(" + service.length + ")");
        } else if (response.status == 0) {
          showAlert("Error occured, please save again", "red");
        }
      },
      error: function () { instanceLoading.hideLoading() },
    });
  }
}

$("#checkAll").click(function () {
  if ($("#checkAll").is(":checked")) {
    $(".provider_service").prop("checked", true);
  } else {
    $(".provider_service").prop("checked", false);
  }
});

function save_off_days() {
  var week_day = [];
  var provider_id = $("#provider_id").val();
  $(".day").each(function () {
    if ($(this)[0].checked) {
      week_day.push($(this).val());
    }
  });

  $.ajax({
    url: "./inc/service-provider/assign-service-provider-off-week-days.php",
    type: "POST",
    dataType: "JSON",
    data: {
      action: "off_days_list",
      week_day: week_day,
      provider_id: provider_id,
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
    success: function (response) {
      instanceLoading.hideLoading()
      if (response.status == 1) {
        showAlert("Saved successfully");
      } else if (response.status == 0) {
        showAlert("Error occured, please save again", "red");
      }
    },
    error: function (response) {
      instanceLoading.hideLoading()
      console.log(response);
      showAlert("Error occured, please save again", "red");
    },
  });
}

function save_off_dates() {
  var off_dates = $("#off_date").val();
  var startDate = $("#off_date")
    .data("daterangepicker")
    .startDate.format("YYYY-MM-DD");
  var endDate = $("#off_date")
    .data("daterangepicker")
    .endDate.format("YYYY-MM-DD");
  var provider_id = $("#provider_id").val();
  //console.log(startDate);
  //console.log(endDate);

  $.ajax({
    url: "inc/service-provider/assign-service-provider-holidays.php",
    type: "POST",
    dataType: "JSON",
    data: {
      action: "save_off_dates",
      startDate: startDate,
      endDate: endDate,
      provider_id: provider_id,
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
    success: function (response) {
      instanceLoading.hideLoading()
      if (response.status == 1) {
        showAlert("Saved successfully");
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      } else if (response.status == 0) {
        showAlert("Error occured, please save again", "red");
      }
    },
    error: function () {
      instanceLoading.hideLoading()
      showAlert("Error occured, please save again", "red");
    },
  });
}

function removeHoliday(id) {
  $.ajax({
    url: "inc/service-provider/assign-service-provider-holidays-delete.php",
    type: "POST",
    dataType: "JSON",
    data: { action: "delete_dates", id: id },
    beforeSend: function () {
      instanceLoading.showLoading({
        type: 'cube_flip',
        color: '#ffffff',
        backgroundColor: '#025043',
        title: 'Loading...',
        fontSize: 16,
      });
    },
    success: function (response) {
      instanceLoading.hideLoading()
      if (response.status == 1) {
        showAlert("Deleted successfully");
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      } else if (response.status == 0) {
        showAlert("Error occured, please save again", "red");
      }
    },
    error: function () {
      instanceLoading.hideLoading()
      showAlert("Error occured, please save again", "red");
    },
  });
}



//dataTableLoad();

const tooltipTriggerList = document.querySelectorAll(
  '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
  (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);

/*
function ExportToExcel(type, fn, dl) {
  var mytable = document.getElementById("dataTable");
  TableToExcel.convert(mytable);
}
*/

function addServiceCommisionRow() {
  //var box = $('#service-provider-services');

  var prevElem = $("#addServiceBefore");
  var preEndTime = $(prevElem).prev().find(".commission1");
  var preCommissionType = $(prevElem).prev().find(".commission_type1");
  var precommission_sp_id = $(prevElem).prev().find(".commission_sp_id1");

  var preEndTimeName = $(preEndTime).attr("name");

  var trdata = preEndTimeName.replace(/[^0-9]/gi, "");
  var arrayKey = parseInt(parseInt(trdata, 10) + 1);

  var commision_type = preCommissionType.val();
  var commission_sp_id = precommission_sp_id.val();

  const mainHtml = `
                    <tr>
                        <td style="vertical-align: middle;">
                            <span class="sno text-danger" onclick='removeServiceCommissionRow(this)'><i class="fas fa-trash"></i></span>
                        </td>
                        <td>
                            <input type="number" class="form-control sale_from1" id="sale_from1" name="commission[${arrayKey}][sale_from]" value="" min="0" placeholder="10000" required>
                            <input type="hidden" class="commission_id1" name="commission[${arrayKey}][id]" value="">
                            <input type="hidden" class="commission_type1" name="commission[${arrayKey}][type]" value="${commision_type}">
                            <input type="hidden" class="commission_sp_id1" name="commission[${arrayKey}][sp_id]" value="${commission_sp_id}">
                        </td>
                        <td>
                            <input type="number" placeholder="100000" class="form-control sale_to1" id="sale_to1" name="commission[${arrayKey}][sale_to]" value="" min="0" required>
                        </td>
                        <td>
                            <input type="number" placeholder="10%" class="form-control commission1" id="commission1" name="commission[${arrayKey}][commission]" value="" min="0" required>
                        </td>
                    </tr>`;

  const addBefore = prevElem;
  addBefore.before(mainHtml);
}

function addProductCommisionRow() {
  //var box = $('#service-provider-services');

  var prevElem = $("#addProductBefore");
  var preEndTime = $(prevElem).prev().find(".commission2");
  var preCommissionType = $(prevElem).prev().find(".commission_type2");
  var precommission_sp_id = $(prevElem).prev().find(".commission_sp_id2");

  var preEndTimeName = $(preEndTime).attr("name");

  var trdata = preEndTimeName.replace(/[^0-9]/gi, "");
  var arrayKey = parseInt(parseInt(trdata, 10) + 1);

  var commision_type = preCommissionType.val();
  var commission_sp_id = precommission_sp_id.val();

  const mainHtml = `
                <tr>
                    <td style="vertical-align: middle;">
                        <span class="sno text-danger" onclick='removeProductCommissionRow(this)'><i class="fas fa-trash"></i></span>
                    </td>
                    <td>
                        <input type="number" class="form-control sale_from2" id="sale_from2" name="commission[${arrayKey}][sale_from]" value="" min="0" placeholder="10000" required>
                        <input type="hidden" class="commission_id2" name="commission[${arrayKey}][id]" value="">
                        <input type="hidden" class="commission_type2" name="commission[${arrayKey}][type]" value="${commision_type}">
                        <input type="hidden" class="commission_sp_id2" name="commission[${arrayKey}][sp_id]" value="${commission_sp_id}">
                    </td>
                    <td>
                        <input type="number" placeholder="100000" class="form-control sale_to2" id="sale_to2" name="commission[${arrayKey}][sale_to]" value="" min="0" required>
                    </td>
                    <td>
                        <input type="number" placeholder="10%" class="form-control commission2" id="commission2" name="commission[${arrayKey}][commission]" value="" min="0" required>
                    </td>
                </tr>`;

  const addBefore = prevElem;
  addBefore.before(mainHtml);
}

function removeServiceCommissionRow(elem) {
  $(elem).parent().parent().remove();
}

function removeProductCommissionRow(elem) {
  $(elem).parent().parent().remove();
}
