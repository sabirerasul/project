function deleteMembership(v) {
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
      showAlert("Membership deleted successfully");
      Swal.fire("Deleted!", "Membership deleted successfully.", "success").then(
        (nresult) => {
          if (nresult.isConfirmed) {
            $.ajax({
              type: "POST",
              url: "inc/membership/membership-delete.php",
              data: { mid: v },
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
                  window.location = "./membership.php";
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

    var membership_name_label = $('.membership_name_label');
    var membership_name = $('.membership_name');

    var price_label = $('.price_label');
    var price = $('.price');

    var validity_label = $('.validity_label');
    var validity = $('.validity');

    var reward_point_label = $('.reward_point_label');
    var reward_point = $('.reward_point');

    var discount_on_service_label = $('.discount_on_service_label');
    var discount_on_service = $('.discount_on_service');

    var discount_on_product_label = $('.discount_on_product_label');
    var discount_on_product = $('.discount_on_product');

    var discount_on_package_label = $('.discount_on_package_label');
    var discount_on_package = $('.discount_on_package');

    var reward_point_boost_label = $('.reward_point_boost_label');
    var reward_point_boost = $('.reward_point_boost');

    var min_reward_point_earned_label = $('.min_reward_point_earned_label');
    var min_reward_point_earned = $('.min_reward_point_earned');

    var membership_condition_label = $('.membership_condition_label');
    var membership_condition = $('.membership_condition');

    var min_bill_amount_label = $('.min_bill_amount_label');
    var min_bill_amount = $('.min_bill_amount');

    var ErrorMsg = '';

    if (membership_name.val() == '') {
      ErrorMsg = "Name field is required";
      addError(membership_name_label, membership_name, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(membership_name_label, membership_name);
    }

    if (price.val() == '') {
      ErrorMsg = "Price field is required";
      addError(price_label, price, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(price_label, price);
    }


    if (validity.val() == '') {
      ErrorMsg = "Validity cannot be blank";
      addError(validity_label, validity, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(validity_label, validity);
    }

    if (reward_point.val() == '') {
      ErrorMsg = "Reward Point cannot be blank";
      addError(reward_point_label, reward_point, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(reward_point_label, reward_point);
    }


    if (discount_on_service.val() == '') {
      ErrorMsg = "Discount on service cannot be blank";
      addError(discount_on_service_label, discount_on_service, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(discount_on_service_label, discount_on_service);
    }

    if (discount_on_product.val() == '') {
      ErrorMsg = "Discount on product cannot be blank";
      addError(discount_on_product_label, discount_on_product, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(discount_on_product_label, discount_on_product);
    }

    if (discount_on_package.val() == '') {
      ErrorMsg = "Discount on package cannot be blank";
      addError(discount_on_package_label, discount_on_package, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(discount_on_package_label, discount_on_package);
    }

    if (reward_point_boost.val() == '') {
      ErrorMsg = "Reward point boost cannot be blank";
      addError(reward_point_boost_label, reward_point_boost, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(reward_point_boost_label, reward_point_boost);
    }

    if (min_reward_point_earned.val() == '') {
      ErrorMsg = "Min reward point earned cannot be blank";
      addError(min_reward_point_earned_label, min_reward_point_earned, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(min_reward_point_earned_label, min_reward_point_earned);
    }

    if (membership_condition.val() == '') {
      ErrorMsg = "Condition cannot be blank";
      addError(membership_condition_label, membership_condition, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(membership_condition_label, membership_condition);
    }

    if (min_bill_amount.val() == '') {
      ErrorMsg = "Min Bill Amount cannot be blank";
      addError(min_bill_amount_label, min_bill_amount, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(min_bill_amount_label, min_bill_amount);
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
              "New Staff registered successfully",
              "success"
            );
            document.getElementById("addStaffForm").reset();
            location.reload();

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

    var membership_name_label = $('.membership_name_label');
    var membership_name = $('.membership_name');

    var price_label = $('.price_label');
    var price = $('.price');

    var validity_label = $('.validity_label');
    var validity = $('.validity');

    var reward_point_label = $('.reward_point_label');
    var reward_point = $('.reward_point');

    var discount_on_service_label = $('.discount_on_service_label');
    var discount_on_service = $('.discount_on_service');

    var discount_on_product_label = $('.discount_on_product_label');
    var discount_on_product = $('.discount_on_product');

    var discount_on_package_label = $('.discount_on_package_label');
    var discount_on_package = $('.discount_on_package');

    var reward_point_boost_label = $('.reward_point_boost_label');
    var reward_point_boost = $('.reward_point_boost');

    var min_reward_point_earned_label = $('.min_reward_point_earned_label');
    var min_reward_point_earned = $('.min_reward_point_earned');

    var membership_condition_label = $('.membership_condition_label');
    var membership_condition = $('.membership_condition');

    var min_bill_amount_label = $('.min_bill_amount_label');
    var min_bill_amount = $('.min_bill_amount');

    var ErrorMsg = '';

    if (membership_name.val() == '') {
      ErrorMsg = "Name field is required";
      addError(membership_name_label, membership_name, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(membership_name_label, membership_name);
    }

    if (price.val() == '') {
      ErrorMsg = "Price field is required";
      addError(price_label, price, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(price_label, price);
    }


    if (validity.val() == '') {
      ErrorMsg = "Validity cannot be blank";
      addError(validity_label, validity, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(validity_label, validity);
    }

    if (reward_point.val() == '') {
      ErrorMsg = "Reward Point cannot be blank";
      addError(reward_point_label, reward_point, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(reward_point_label, reward_point);
    }


    if (discount_on_service.val() == '') {
      ErrorMsg = "Discount on service cannot be blank";
      addError(discount_on_service_label, discount_on_service, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(discount_on_service_label, discount_on_service);
    }

    if (discount_on_product.val() == '') {
      ErrorMsg = "Discount on product cannot be blank";
      addError(discount_on_product_label, discount_on_product, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(discount_on_product_label, discount_on_product);
    }

    if (discount_on_package.val() == '') {
      ErrorMsg = "Discount on package cannot be blank";
      addError(discount_on_package_label, discount_on_package, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(discount_on_package_label, discount_on_package);
    }

    if (reward_point_boost.val() == '') {
      ErrorMsg = "Reward point boost cannot be blank";
      addError(reward_point_boost_label, reward_point_boost, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(reward_point_boost_label, reward_point_boost);
    }

    if (min_reward_point_earned.val() == '') {
      ErrorMsg = "Min reward point earned cannot be blank";
      addError(min_reward_point_earned_label, min_reward_point_earned, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(min_reward_point_earned_label, min_reward_point_earned);
    }

    if (membership_condition.val() == '') {
      ErrorMsg = "Condition cannot be blank";
      addError(membership_condition_label, membership_condition, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(membership_condition_label, membership_condition);
    }

    if (min_bill_amount.val() == '') {
      ErrorMsg = "Min Bill Amount cannot be blank";
      addError(min_bill_amount_label, min_bill_amount, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(min_bill_amount_label, min_bill_amount);
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
            showAlert("Membership record has been updated successfully");
            Swal.fire(
              "Good job!",
              "Employee updated successfully",
              "success"
            ).then((result) => {
              document.getElementById("editStaffForm").reset();
              window.location = './membership.php';
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
    url: "./inc/membership/membership-show.php",
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
  var mytable = document.getElementById('dataTable');
  TableToExcel.convert(mytable);
}