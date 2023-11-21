$(document).ready(function () {

  loadStaffTable();

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

  $("#addStaffForm").on("submit", function (event) {
    event.preventDefault();
    //var formValues = $(this).serialize();

    var form = $("#addStaffForm");
    var formValues = $("#addStaffForm").serializeArray();

    var url = form.attr("action");

    var error = false;

    var emp_name_label = $(".emp_name_label");
    var emp_name = $(".emp_name");
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
        if (emp_password.val() == '') {
            ErrorMsg = "Password cannot be blank";
            addError(emp_password_label, emp_password, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(emp_password_label, emp_password);
        }

        if (emp_confirm_password.val() == '') {
            ErrorMsg = "Confirm Password cannot be blank";
            addError(emp_confirm_password_label, emp_confirm_password, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(emp_confirm_password_label, emp_confirm_password);
        }


        if ((emp_password.val() != '' && emp_confirm_password.val() != '') && (emp_password.val() != emp_confirm_password.val())) {
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
              "New Staff registered successfully",
              "success"
            ).then((result) => {
              document.getElementById("addStaffForm").reset();
              location.reload();
            })

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

  $("#editStaffForm").on("submit", function (event) {
    event.preventDefault();
    //var formValues = $(this).serialize();

    var form = $("#editStaffForm");
    var formValues = $("#editStaffForm").serializeArray();

    var url = form.attr("action");

    var error = false;

    var emp_name_label = $(".emp_name_label");
    var emp_name = $(".emp_name");
    var emp_dob_label = $(".emp_dob_label");
    var emp_dob = $(".emp_dob");
    var emp_number_label = $(".emp_number_label");
    var emp_number = $(".emp_number");
    var emp_email_label = $(".emp_email_label");
    var emp_email = $(".emp_email");

    var emp_working_from_label = $(".emp_working_from_label");
    //var emp_working_from = $('.emp_working_from');
    var emp_working_to_label = $(".emp_working_to_label");
    //var emp_working_to = $('.emp_working_to');

    var working_hours_start_label = $(".working_hours_start_label");
    var working_hours_start = $(".working_hours_start");
    var working_hours_end_label = $(".working_hours_end_label");
    var working_hours_end = $(".working_hours_end");

    var emp_salary_label = $(".emp_salary_label");
    var emp_salary = $(".emp_salary");
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
    
        
        if ((emp_password.val() != '' && emp_confirm_password.val() != '') && (emp_password.val() != emp_confirm_password.val())) {
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
            showAlert("Employee record has been updated successfully");
            Swal.fire(
              "Good job!",
              "Employee updated successfully",
              "success"
            ).then((result) => {
              document.getElementById("editStaffForm").reset();
              window.location = "./staff.php";
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
    url: "./inc/staff/staff-show.php",
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

function fnExcelReport() {
  $.ajax({
    type: "POST",
    url: "./inc/staff/staff-show-full.php",
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

function setTodayDate(id) {
  elem = document.getElementById(id);
  const formattedToday = getTodayDate();
  elem.value = elem.value == "" ? formattedToday : elem.value;
  return formattedToday;
}

setTodayDate("doj");

$(document).ready(function () {
  const picker1 = datepicker(".emp_dob", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });
  const picker2 = datepicker(".date_of_joining", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });
});



//dataTableLoad();
