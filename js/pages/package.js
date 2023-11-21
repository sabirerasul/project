$(document).ready(function () {
  const picker1 = datepicker(".package_validity", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });
});

function deletePackage(v) {
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
      showAlert("Package deleted successfully");
      Swal.fire("Deleted!", "Package deleted successfully.", "success").then(
        (nresult) => {
          if (nresult.isConfirmed) {
            $.ajax({
              type: "POST",
              url: "./inc/package/package-delete.php",
              data: { pid: v },
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
                  window.location = './package.php'
                }
              },
              error: function (data) { },
            });
          }
        }
      );
    }
  });
}

$(document).ready(function () {
  $("#addPackage").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#addPackage");
    var url = form.attr("action");

    var package_name = $("#package_name");
    var package_name_label = $(".package_name_label");

    var package_duration = $("#package_duration");
    var package_duration_label = $(".package_duration_label");

    var package_validity = $("#package_validity");
    var package_validity_label = $(".package_validity_label");

    var package_price = $("#package_price");
    var package_price_label = $(".package_price_label");

    var error = false;
    var ErrorMsg = "";

    if (package_name.val() == "") {
      ErrorMsg = "Package Name field is required";
      addError(package_name_label, package_name, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(package_name_label, package_name);
    }

    if (package_duration.val() == "") {
      ErrorMsg = "Duration field is required";
      addError(package_duration_label, package_duration, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(package_duration_label, package_duration);
    }

    if (package_validity.val() == "") {
      ErrorMsg = "Validity field is required";
      addError(package_validity_label, package_validity, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(package_validity_label, package_validity);
    }

    if (package_price.val() == "") {
      ErrorMsg = "Price field is required";
      addError(package_price_label, package_price, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(package_price_label, package_price);
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
            showAlert("Package Added successfully");
            Swal.fire(
              "Good job!",
              "Package Added successfully",
              "success"
            ).then((result) => {
              document.getElementById("addPackage").reset();
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

  $("#editPackage").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#editPackage");
    var url = form.attr("action");

    var package_name = $("#package_name");
    var package_name_label = $(".package_name_label");

    var package_duration = $("#package_duration");
    var package_duration_label = $(".package_duration_label");

    var package_validity = $("#package_validity");
    var package_validity_label = $(".package_validity_label");

    var package_price = $("#package_price");
    var package_price_label = $(".package_price_label");

    var error = false;
    var ErrorMsg = "";

    if (package_name.val() == "") {
      ErrorMsg = "Package Name field is required";
      addError(package_name_label, package_name, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(package_name_label, package_name);
    }

    if (package_duration.val() == "") {
      ErrorMsg = "Duration field is required";
      addError(package_duration_label, package_duration, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(package_duration_label, package_duration);
    }

    if (package_validity.val() == "") {
      ErrorMsg = "Validity field is required";
      addError(package_validity_label, package_validity, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(package_validity_label, package_validity);
    }

    if (package_price.val() == "") {
      ErrorMsg = "Price field is required";
      addError(package_price_label, package_price, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(package_price_label, package_price);
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
            showAlert("Package Updated successfully");
            Swal.fire(
              "Good job!",
              "Package Updated successfully",
              "success"
            ).then((result) => {
              document.getElementById("editPackage").reset();
              window.location = "./package.php";
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

function loadStaffTable() {
  $.ajax({
    type: "POST",
    url: "./inc/package/package-show.php",
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

function addServiceProviderServices() {
  //var box = $('#service-provider-services');

  var prevElem = $("#addBefore");
  var preEndTime = $(prevElem).prev().find(".price");

  var preEndTimeName = $(preEndTime).attr("name");

  old_staff = prevElem.prev().find(".staff");

  var trdata = preEndTimeName.replace(/[^0-9]/gi, "");
  var arrayKey = parseInt(parseInt(trdata, 10) + 1);

  const mainHtml = `
                    <tr>
                        <td style="vertical-align: middle;">
                            <span class="sno text-danger" onclick='removeServiceProviderServices(this)'><i class="fas fa-trash"></i></span>
                        </td>

                        <td>
                            <input type="text" class="service-category form-control form-control-sm" onkeyup="searchCategory(this)" placeholder="category" required>
                            <input type="hidden" class="category_id" value="">
                        </td>
                        <td>
                            <input type="text" name="" class="category-services form-control form-control-sm d-input" onkeyup="searchServices(this)" placeholder="Service (Autocomplete)" required>
                            <input type="hidden" name="package_service[${arrayKey}][service_id]" class="service_id">
                        </td>

                        <td>
                            <input type="number" name="package_service[${arrayKey}][quantity]" class="quantity form-control form-control-sm d-input" onchange="changeQuantity(this)" placeholder="Quantity" required>
                        </td>

                        <td>
                            <input type="number" class="form-control form-control-sm price w-100" placeholder="Price" name="package_service[${arrayKey}][price]" onchange="countPackage" required>
                            <input type="hidden" class="original_price">
                        </td>
                    </tr>`;

  const addBefore = prevElem;
  addBefore.before(mainHtml);
}

function removeServiceProviderServices(elem) {
  $(elem).parent().parent().remove();
  countPackage();
}

function searchCategory(elem) {
  $(".service-category")
    .autocomplete({
      source: function (request, response) {
        $.getJSON(
          "inc/service/get-service-category.php",
          { name: request.term },
          response
        );
      },
      minLength: 1,
      open: function (event, ui) { },
      select: function (event, ui) {
        $(this).val(ui.item.value);
        $(elem).parent().find(".category_id").val(ui.item.id);
      },
    })
    .addClass("whatever");
  $(".service-category").on("autocompleteopen", function (event, ui) { });
}

function searchServices(elem) {
  $(elem)
    .autocomplete({
      source: function (request, response) {
        var timestamp =
          getServerFormatDate(getTodayDate()) + " " + getCurrentTime("HH");
        var category_id = $(elem).parent().parent().find(".category_id").val();
        $.getJSON(
          "inc/service/get-service.php",
          {
            category_id: category_id,
            name: request.term,
            timestamp: timestamp,
          },
          response
        );
      },
      minLength: 1,
      open: function (event, ui) { },
      select: function (event, ui) {
        var row = $(this).parent().parent();
        row.find(".service-category").val(ui.item.cat_name);
        row.find(".service_id").val(ui.item.id);
        row.find(".quantity").val(1);
        row.find(".price").val(ui.item.price);
        row.find(".original_price").val(ui.item.price);
        countPackage();
      },
    })
    .addClass("whatever");
  $(elem).on("autocompleteopen", function (event, ui) { });
}

function changeQuantity(elem) {
  var quantity = $(elem).val();
  var price = $(elem).parent().parent().find(".price");
  var original_price = $(elem).parent().parent().find(".original_price");
  if (price.val() != "") {
    price.val(original_price.val() * quantity);
    countPackage();
  }
}
function countPackage() {
  var package_worth = $("#package_worth");
  var total_saving_inr = $("#total_saving_inr");
  var total_saving_per = $("#total_saving_per");
  var package_price = $("#package_price");
  var elem = $(".price");
  totalAmount = 0;
  priceArr = [];
  for (let index = 0; index < elem.length; index++) {
    var element = elem[index];
    var p = parseFloat($(element).val());
    priceArr[index] = p;
  }

  var totalPrice = priceArr.reduce((partialSum, a) => partialSum + a, 0);
  totalAmount = totalPrice;

  if (totalAmount != "") {
    package_worth.html(totalAmount);

    var saving =
      package_price.val() < totalAmount ? totalAmount - package_price.val() : 0;

    total_saving_inr.html(saving);

    var perSaving = (saving * 100) / totalAmount;
    total_saving_per.html(perSaving.toFixed());
  }
}


function checkPackage(elem) {
  var val = $(elem).val();

  var package_name_label = $('.package_name_label');
  var package_name = $('.package_name');
  var ErrorMsg = "Package Already Exist";


  $.ajax({
    type: "POST",
    url: "inc/package/package-check.php",
    data: { value: val },
    success: function (data) {
      const myObj = JSON.parse(data);

      if (myObj.success == true) {

        addError(package_name_label, package_name, ErrorMsg);
        showAlert(ErrorMsg, "red");
        $(elem).val('');
      } else {
        removeError(package_name_label, package_name);
      }
    },
    error: function (data) {
      removeError(package_name_label, package_name);
    },
  });
}

$(document).ready(function () {

  loadStaffTable();

  var params = window.location.search;
  var url_string = window.location;
  var url = new URL(url_string);
  var id = url.searchParams.get("id");

  if (id != null) {
    countPackage();
  }

})