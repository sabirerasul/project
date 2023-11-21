function deleteCoupon(v) {
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
      showAlert("Coupon deleted successfully");
      Swal.fire("Deleted!", "Coupon deleted successfully.", "success").then(
        (nresult) => {
          if (nresult.isConfirmed) {
            $.ajax({
              type: "POST",
              url: "inc/coupon/coupon-delete.php",
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
                  window.location = './coupon.php'
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

    var coupon_code_label = $(".coupon_code_label");
    var coupon_code = $(".coupon_code");

    var discount_label = $(".discount_label");
    var discount = $(".discount");

    var discount_type_label = $(".discount_type_label");
    var discount_type = $(".discount_type");

    var min_bill_amount_label = $(".min_bill_amount_label");
    var min_bill_amount = $(".payment_mode");

    var max_discount_amount_label = $(".max_discount_amount_label");
    var max_discount_amount = $(".max_discount_amount");

    var coupon_per_user_label = $(".coupon_per_user_label");
    var coupon_per_user = $(".coupon_per_user");

    var valid_till_label = $(".valid_till_label");
    var valid_till = $(".valid_till");

    var reward_point_label = $(".reward_point_label");
    var reward_point = $(".reward_point");

    var ErrorMsg = "";

    if (coupon_code.val() == "") {
      ErrorMsg = "Coupon field is required";
      addError(coupon_code_label, coupon_code, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(coupon_code_label, coupon_code);
    }

    if (discount.val() == "") {
      ErrorMsg = "Discount field is required";
      addError(discount_label, discount, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(discount_label, discount);
    }

    if (discount_type.val() == "") {
      ErrorMsg = "Discount Type cannot be blank";
      addError(discount_type_label, discount_type, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(discount_type_label, discount_type);
    }

    if (min_bill_amount.val() == "") {
      ErrorMsg = "Min Bill Amount cannot be blank";
      addError(min_bill_amount_label, min_bill_amount, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(min_bill_amount_label, min_bill_amount);
    }

    if (max_discount_amount.val() == "") {
      ErrorMsg = "Max Discount Amount cannot be blank";
      addError(max_discount_amount_label, max_discount_amount, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(max_discount_amount_label, max_discount_amount);
    }

    if (coupon_per_user.val() == "") {
      ErrorMsg = "Coupon per user cannot be blank";
      addError(coupon_per_user_label, coupon_per_user, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(coupon_per_user_label, coupon_per_user);
    }

    if (valid_till.val() == "") {
      ErrorMsg = "Valid Till cannot be blank";
      addError(valid_till_label, valid_till, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(valid_till_label, valid_till);
    }

    if (reward_point.val() == "") {
      ErrorMsg = "Reward Point cannot be blank";
      addError(reward_point_label, reward_point, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(reward_point_label, reward_point);
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
            showAlert("Coupon added successfully");
            Swal.fire(
              "Good job!",
              "Coupon Code added successfully",
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

  $("#editStaffForm").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();

    var form = $("#editStaffForm");
    var url = form.attr("action");
    var error = false;
    var coupon_code_label = $(".coupon_code_label");
    var coupon_code = $(".coupon_code");

    var discount_label = $(".discount_label");
    var discount = $(".discount");

    var discount_type_label = $(".discount_type_label");
    var discount_type = $(".discount_type");

    var min_bill_amount_label = $(".min_bill_amount_label");
    var min_bill_amount = $(".payment_mode");

    var max_discount_amount_label = $(".max_discount_amount_label");
    var max_discount_amount = $(".max_discount_amount");

    var coupon_per_user_label = $(".coupon_per_user_label");
    var coupon_per_user = $(".coupon_per_user");

    var valid_till_label = $(".valid_till_label");
    var valid_till = $(".valid_till");

    var reward_point_label = $(".reward_point_label");
    var reward_point = $(".reward_point");

    var ErrorMsg = "";

    if (coupon_code.val() == "") {
      ErrorMsg = "Coupon field is required";
      addError(coupon_code_label, coupon_code, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(coupon_code_label, coupon_code);
    }

    if (discount.val() == "") {
      ErrorMsg = "Discount field is required";
      addError(discount_label, discount, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(discount_label, discount);
    }

    if (discount_type.val() == "") {
      ErrorMsg = "Discount Type cannot be blank";
      addError(discount_type_label, discount_type, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(discount_type_label, discount_type);
    }

    if (min_bill_amount.val() == "") {
      ErrorMsg = "Min Bill Amount cannot be blank";
      addError(min_bill_amount_label, min_bill_amount, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(min_bill_amount_label, min_bill_amount);
    }

    if (max_discount_amount.val() == "") {
      ErrorMsg = "Max Discount Amount cannot be blank";
      addError(max_discount_amount_label, max_discount_amount, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(max_discount_amount_label, max_discount_amount);
    }

    if (coupon_per_user.val() == "") {
      ErrorMsg = "Coupon per user cannot be blank";
      addError(coupon_per_user_label, coupon_per_user, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(coupon_per_user_label, coupon_per_user);
    }

    if (valid_till.val() == "") {
      ErrorMsg = "Valid Till cannot be blank";
      addError(valid_till_label, valid_till, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(valid_till_label, valid_till);
    }

    if (reward_point.val() == "") {
      ErrorMsg = "Reward Point cannot be blank";
      addError(reward_point_label, reward_point, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(reward_point_label, reward_point);
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
            showAlert("Coupon Code updated successfully");
            Swal.fire(
              "Good job!",
              "Coupon updated successfully",
              "success"
            ).then((result) => {
              document.getElementById("editStaffForm").reset();
              window.location = "./coupon.php";
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
    url: "./inc/coupon/coupon-show.php",
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

setTodayDate("valid_till");

$(document).ready(function () {
  const picker2 = datepicker(".valid_till", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });
});

function checkCoupon(elem) {
  var val = $(elem).val();

  var coupon_code_label = $('.coupon_code_label');
  var coupon_code = $('.coupon_code');
  var ErrorMsg = "Coupon Already Exist";


  $.ajax({
    type: "POST",
    url: "inc/coupon/coupon-check.php",
    data: { value: val },
    success: function (data) {
      const myObj = JSON.parse(data);

      if (myObj.success == true) {

        addError(coupon_code_label, coupon_code, ErrorMsg);
        showAlert(ErrorMsg, "red");
        $(elem).val('');
      } else {
        removeError(coupon_code_label, coupon_code);
      }
    },
    error: function (data) {
      removeError(coupon_code_label, coupon_code);
    },
  });
}

function ExportToExcel(type, fn, dl) {
  var mytable = document.getElementById('dataTable');
  TableToExcel.convert(mytable);
}