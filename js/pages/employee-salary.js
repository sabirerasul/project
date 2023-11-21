function deleteSalary(v) {
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
      showAlert("Salary deleted successfully");
      Swal.fire("Deleted!", "Salary deleted successfully.", "success").then(
        (nresult) => {
          if (nresult.isConfirmed) {
            $.ajax({
              type: "POST",
              url: "inc/employee-salary/employee-salary-delete.php",
              data: { esid: v },
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
                  window.location = './employee-salary.php'
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

$(document).ready(function () {

  loadStaffTable();

  $("#addStaffForm").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();

    var form = $("#addStaffForm");

    var url = form.attr("action");

    var error = false;

    var date_label = $(".date_label");
    var date = $(".date");

    var employee_type_label = $(".employee_type_label");
    var employee_type = $(".employee_type");

    var employee_id_label = $(".employee_label");
    var employee_id = $(".employee");

    var salary_type_label = $(".salary_type_label");
    var salary_type = $(".salary_type");

    var amount_label = $(".amount_label");
    var amount = $(".amount");

    var comments_label = $(".comments_label");
    var comments = $(".comments");

    var ErrorMsg = "";

    if (date.val() == "") {
      ErrorMsg = "Date field is required";
      addError(date_label, date, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(date_label, date);
    }

    if (employee_type.val() == "") {
      ErrorMsg = "employee type field is required";
      addError(employee_type_label, employee_type, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(employee_type_label, employee_type);
    }

    if (employee_id.val() == "") {
      ErrorMsg = "employee cannot be blank";
      addError(employee_id_label, employee_id, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(employee_id_label, employee_id);
    }

    if (salary_type.val() == "") {
      ErrorMsg = "salary type cannot be blank";
      addError(salary_type_label, salary_type, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(salary_type_label, salary_type);
    }

    if (amount.val() == "") {
      ErrorMsg = "amount cannot be blank";
      addError(amount_label, amount, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(amount_label, amount);
    }

    if (comments.val() == "") {
      ErrorMsg = "comments cannot be blank";
      addError(comments_label, comments, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(comments_label, comments);
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
            showAlert("Salary added successfully");
            Swal.fire("Good job!", "Salary added successfully", "success").then(
              (result) => {
                document.getElementById("addStaffForm").reset();
                location.reload();
              }
            );

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
    var formValues = $(this).serialize();

    var form = $("#editStaffForm");
    var url = form.attr("action");
    var error = false;
    var date_label = $(".date_label");
    var date = $(".date");

    var employee_type_label = $(".employee_type_label");
    var employee_type = $(".employee_type");

    var employee_id_label = $(".employee_label");
    var employee_id = $(".employee");

    var salary_type_label = $(".salary_type_label");
    var salary_type = $(".salary_type");

    var amount_label = $(".amount_label");
    var amount = $(".amount");

    var comments_label = $(".comments_label");
    var comments = $(".comments");

    var ErrorMsg = "";

    if (date.val() == "") {
      ErrorMsg = "Date field is required";
      addError(date_label, date, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(date_label, date);
    }

    if (employee_type.val() == "") {
      ErrorMsg = "employee type field is required";
      addError(employee_type_label, employee_type, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(employee_type_label, employee_type);
    }

    if (employee_id.val() == "") {
      ErrorMsg = "employee cannot be blank";
      addError(employee_id_label, employee_id, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(employee_id_label, employee_id);
    }

    if (salary_type.val() == "") {
      ErrorMsg = "salary type cannot be blank";
      addError(salary_type_label, salary_type, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(salary_type_label, salary_type);
    }

    if (amount.val() == "") {
      ErrorMsg = "amount cannot be blank";
      addError(amount_label, amount, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(amount_label, amount);
    }

    if (comments.val() == "") {
      ErrorMsg = "comments cannot be blank";
      addError(comments_label, comments, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(comments_label, comments);
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
            showAlert("Employee record has been updated successfully");
            Swal.fire(
              "Good job!",
              "Salary updated successfully",
              "success"
            ).then((result) => {
              document.getElementById("editStaffForm").reset();
              window.location = "./employee-salary.php";
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
    url: "./inc/employee-salary/employee-salary-show.php",
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

function setTodayDate(id) {
  elem = document.getElementById(id);
  const formattedToday = getTodayDate();
  elem.value = elem.value == "" ? formattedToday : elem.value;
  return formattedToday;
}

setTodayDate("date");

$(document).ready(function () {
  const picker2 = datepicker(".date", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });
});


function searchEmployee(elem) {
  var employee_type = $(".employee_type").val();
  if (employee_type != '') {
    $(elem)
      .autocomplete({
        source: function (request, response) {

          $.getJSON(
            "inc/employee-salary/get-employee.php",
            {
              employee_type: employee_type,
              name: request.term,
            },
            response
          );
        },
        minLength: 1,
        open: function (event, ui) { },
        select: function (event, ui) {
          var row = $(this).parent().parent();
          row.find(".employee_id").val(ui.item.id);
        },

      })
      .addClass("whatever");
    $(elem).on("autocompleteopen", function (event, ui) { });
  }
};

function ExportToExcel(type, fn, dl) {
  var mytable = document.getElementById('dataTable');
  TableToExcel.convert(mytable);
}