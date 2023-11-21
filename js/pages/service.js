function deleteService(v) {
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
      showAlert("Service deleted successfully");
      Swal.fire("Deleted!", "Service deleted successfully.", "success").then(
        (nresult) => {
          if (nresult.isConfirmed) {
            $.ajax({
              type: "POST",
              url: "inc/service/service-delete.php",
              data: { sid: v },
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
                  window.location = './service.php'
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

function deleteServiceCategory(v) {
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
      showAlert("Category deleted successfully");
      Swal.fire("Deleted!", "Category deleted successfully.", "success").then(
        (nresult) => {
          //if (nresult.isConfirmed) {
          $.ajax({
            type: "POST",
            url: "inc/service/service-category-delete.php",
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
                window.location = "./service.php";
              }
            },
            error: function (data) { instanceLoading.hideLoading() },
          });
          //}
        }
      );
    }
  });
}

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
          instanceLoading.hideLoading()
          const myObj = JSON.parse(data);
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

  $("#editService").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#editService");
    var url = form.attr("action");

    var serviceCat = $("#service_cat");
    var labelServiceCat = $(".service_cat_label");

    var serviceName = $("#service_name");
    var labelserviceName = $(".service_name_label");

    var servicePrice = $("#service_price");
    var servicePriceLabel = $(".service_price_label");

    var durationHh = $("#duration_hh");
    var durationMm = $("#duration_mm");
    var durationLabel = $(".duration_label");

    var error = false;
    var ErrorMsg = "";

    if (serviceCat.val() == "") {
      ErrorMsg = "Category field is required";
      addError(labelServiceCat, serviceCat, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(labelServiceCat, serviceCat);
    }

    if (serviceName.val() == "") {
      ErrorMsg = "Service field is required";
      addError(labelserviceName, serviceName, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(labelserviceName, serviceName);
    }

    if (servicePrice.val() == "") {
      ErrorMsg = "Price field is required";
      addError(servicePriceLabel, servicePrice, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(servicePriceLabel, servicePrice);
    }

    if (durationHh.val() == "") {
      ErrorMsg = "Hour field is required";
      addError(durationLabel, durationHh, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(durationLabel, durationHh);
    }

    if (durationMm.val() == "") {
      ErrorMsg = "Minute field is required";
      addError(durationLabel, durationMm, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(durationLabel, durationMm);
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
            showAlert("Service Updated successfully");
            Swal.fire(
              "Good job!",
              "Service Updated successfully",
              "success"
            ).then((result) => {
              document.getElementById("editService").reset();
              window.location = "./service.php";
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

  $("#addServiceCategory").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#addServiceCategory");
    var url = form.attr("action");

    var category = $("#service_category_field");
    var labelCategory = $(".service_category_field");

    var error = false;
    var ErrorMsg = "";
    if (category.val() == "") {
      ErrorMsg = "Category field is required";
      addError(labelCategory, category, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(labelCategory, category);
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
            showAlert("Service Category Added successfully");
            Swal.fire(
              "Good job!",
              "Service Category Added successfully",
              "success"
            ).then((result) => {
              document.getElementById("addServiceCategory").reset();
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

  $("#editServiceCategory").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#editServiceCategory");
    var url = form.attr("action");

    var category = $("#service_category_field");
    var labelCategory = $(".service_category_label");

    var error = false;
    var ErrorMsg = "";
    if (category.val() == "") {
      ErrorMsg = "Category field is required";
      addError(labelCategory, category, ErrorMsg);
      error = true;
      return false;
    } else {
      error = false;
      removeError(labelCategory, category);
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
            showAlert("Service Category Updated successfully");
            Swal.fire(
              "Good job!",
              "Service Category Updated successfully",
              "success"
            ).then((result) => {
              document.getElementById("editServiceCategory").reset();
              window.location = "./service.php";
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

function loadServiceTable() {
  $.ajax({
    type: "POST",
    url: "./inc/service/service-show.php",
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
      setTableService(result);
      setTimeout(dataTableLoadService, 3000);
    },
  });
}

function loadCategoryTable() {
  $.ajax({
    type: "POST",
    url: "./inc/service/service-category-show.php",
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
      setTableCategory(result);
      setTimeout(dataTableLoadCategory, 3000);
    },
  });
}

function setTableService(result) {
  $(".active-service-data").html(result);
}

function setTableCategory(result) {
  $(".active-category-data").html(result);
}

function dataTableLoadService() {
  var table = $("#dataTableService").DataTable();
}

function dataTableLoadCategory() {
  var table = $("#dataTableCategory").DataTable();
}


$(document).ready(function () {
  loadServiceTable();
  loadCategoryTable();
})

$(function () {
  $("#category_field")
    .autocomplete({
      source: function (request, response) {
        $.getJSON(
          "inc/service/get-service-category.php",
          { name: request.term },
          response
        );
      },
      minLength: 1,
      open: function (event, ui) {
        //console.log('onclick');
        //console.log('open',event,ui,this);
      },
      select: function (event, ui) {
        $(this).val(ui.item.value);
        $("#category_id").val(ui.item.id);
      },
    })
    .addClass("whatever");
  $("#category_field").on("autocompleteopen", function (event, ui) {
    //console.log('autocompleteopen',event,ui,this);
  });
});

var params = window.location.search;
var url_string = window.location;
var url = new URL(url_string);
var sid = url.searchParams.get("sid");
var csid = url.searchParams.get("csid");

if (sid != null) {
  const myModal = new bootstrap.Modal("#exampleModal", {
    keyboard: false,
  });
  const modalToggle = $("#exampleModal");
  myModal.show(modalToggle);
}

if (csid != null) {
  const myModal = new bootstrap.Modal("#exampleModal1", {
    keyboard: false,
  });
  const modalToggle = $("#exampleModal1");
  myModal.show(modalToggle);
}

function addServiceProviderServices() {
  var prevElem = $("#addBefore");
  var preEndTime = $(prevElem).prev().find(".product_id");

  if ($(preEndTime).val() != "") {
    var preEndTimeName = $(preEndTime).attr("name");

    var trdata = preEndTimeName.replace(/[^0-9]/gi, "");
    var arrayKey = parseInt(parseInt(trdata, 10) + 1);

    const mainHtml = `
                    <tr>
                        <td style="vertical-align: middle;">
                            <span class="sno text-danger" onclick='removeServiceProviderServices(this);'><i class="fas fa-trash"></i></span>
                        </td>
                        <td>
                                                <div class="row">
                                                    <div class="col-7 pr-1">
                                                        <input type="text" class="service-category form-control form-control-sm" onkeyup="searchProduct(this)" placeholder="Product (Autocomplete)" autocomplete="off">
                                                        <input type="hidden" class="product_id" name="service_product[${arrayKey}][product_id]">
                                                        <input type="hidden" class="service_product_id" name="service_product[${arrayKey}][id]" value="">
                                                    </div>
                                                    <div class="col-3 pl-1">
                                                        <input type="number" name="service_product[${arrayKey}][volume]" class="volume form-control form-control-sm d-input" placeholder="volume">
                                                    </div>

                                                    <div class="col-2 pl-1">
                                                        <select class="form-select form-select-sm unit" name="service_product[${arrayKey}][unit]">
                                                            <?php
                                                            foreach ($unitArr as $unitKey => $unitValue) {
                                                            ?>
                                                            <option value="l">L</option>
                                                            <option value="ml">ML</option>
                                                            <option value="mg">MG</option>
                                                            <option value="gram">Gram</option>
                                                            <option value="pcs">Pcs</option>
                                                            <option value="pkt">Pkt</option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <input type="number" class="form-control form-control-sm quantity_used w-100" value="1" placeholder="quantity used" name="service_product[${arrayKey}][quantity_used]">
                                            </td>

                    </tr>`;

    const addBefore = prevElem;
    addBefore.before(mainHtml);
  }
}

function removeServiceProviderServices(elem) {
  //$(elem).parent().parent().hide();
  $(elem).parent().parent().remove();
}

function searchProduct(elem) {
  $(elem)
    .autocomplete({
      source: function (request, response) {
        $.getJSON(
          "inc/stock/get-product-list.php",
          {
            name: request.term,
          },
          response
        );
      },
      minLength: 1,
      open: function (event, ui) { },
      select: function (event, ui) {
        var row = $(this).parent().parent().parent().parent();

        $(this).val(ui.item.product);
        row.find(".product_id").val(ui.item.id);
        row.find(".volume").val(ui.item.volume);

        row
          .find('.unit option[value="' + ui.item.unit + '"]')
          .prop("selected", true);
      },
    })
    .addClass("whatever");
  $(elem).on("autocompleteopen", function (event, ui) { });
}


function ExportToExcel1(type, fn, dl) {
  var mytable = document.getElementById('dataTableService');
  TableToExcel.convert(mytable);
}

function ExportToExcel2(type, fn, dl) {
  var mytable = document.getElementById('dataTableCategory');
  TableToExcel.convert(mytable);
}