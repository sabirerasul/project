$(document).ready(function () {
  const picker1 = datepicker(".present_date", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });

  const picker2 = datepicker('.product_exp_date', {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });

  $(".present_date").val(getTodayDate());

  //set today date
  $(".present_date").val(getTodayDate());

  $(".search_vendor_name")
    .autocomplete({
      source: function (request, response) {
        $.getJSON(
          "inc/stock/get-product-vendor-list.php",
          { terms: request.term },
          response
        );
      },
      minLength: 1,
      open: function (event, ui) { },
      select: function (event, ui) {
        setVendorDetails(ui.item);
      },
    })
    .addClass("whatever");
  $(".search_vendor_name").on("autocompleteopen", function (event, ui) { });

  $("#stockAdd").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#stockAdd");
    var url = form.attr("action");

    var error = false;
    var ErrorMsg = "";

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
            showAlert("Stock Added Successfully");
            Swal.fire("Good job!", "Stock Added Successfully", "success").then(
              (result) => {
                document.getElementById("stockAdd").reset();
                location.reload();
              }
            );
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


  $("#stockUpdate").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#stockUpdate");
    var url = form.attr("action");

    var error = false;
    var ErrorMsg = "";

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
            showAlert("Stock Updated Successfully");
            Swal.fire("Good job!", "Stock Updated Successfully", "success").then(
              (result) => {
                window.location = './product-stock-add.php';
              }
            );
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

function setVendorDetails(data) {
  $("#vendor").val(data.vendor_name);
  $("#vendor_id").val(data.id);
  $("#cont").val(data.contact);
  $("#gst_number").val(data.gst_number);
}

function addProduct() {
  var prevElem = $("#addBefore");
  var preEndTime = $(prevElem).prev().find(".product_id");

  if ($(preEndTime).val() != "") {
    var preEndTimeName = $(preEndTime).attr("name");

    var trdata = preEndTimeName.replace(/[^0-9]/gi, "");
    var arrayKey = parseInt(parseInt(trdata, 10) + 1);

    const mainHtml = `
                    <tr>
                        <td style="vertical-align: middle;">
                            <span class="sno text-danger" onclick='removeProduct(this);changeTiming(this);'><i class="fas fa-trash"></i></span>
                        </td>
                        <td>
                                                    <div class="d-flex" style="width:445px">
                                                        <div style="width:241px">
                                                            <input type="text" class="category-services form-control form-control-sm" name="stock_product_details[${arrayKey}][product]" onkeyup="searchProduct(this)" placeholder="Product (Autocomplete)" autocomplete="off" required>
                                                            <input type="hidden" name="stock_product_details[${arrayKey}][salon_product_id]" class="product_id">
                                                            <input type="hidden" name="stock_product_details[${arrayKey}][stock_record_id]">
                                                        </div>

                                                        <div style="width:100px" class="mx-1">
                                                            <input type="number" name="stock_product_details[${arrayKey}][volume]" class="qt form-control form-control-sm product_volume" placeholder="Volume" required min="0" readonly>
                                                        </div>

                                                        <div style="width:100px">
                                                            <select class="form-control form-control-sm product_unit" name="stock_product_details[${arrayKey}][volume_unit]">
                                                                <option value="1">L</option>
                                                                <option value="2">ML</option>
                                                                <option value="3">MG</option>
                                                                <option value="4">Gram</option>
                                                                <option value="5">Pcs</option>
                                                                <option value="6">Pkt</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div style="width: 100px;">
                                                        <input type="number" name="stock_product_details[${arrayKey}][mrp_price]" class="form-control form-control-sm product_mrp" placeholder="0.00" required min="0">
                                                    </div>
                                                </td>

                                                <td>
                                                    <div style="width: 122px;">
                                                        <input type="number" name="stock_product_details[${arrayKey}][purchase_price]" class="form-control form-control-sm purchase_price" placeholder="0.00" value="0.00" required min="0">
                                                    </div>
                                                </td>

                                                <td>
                                                    <div style="width: 100px;">
                                                        <input type="number" name="stock_product_details[${arrayKey}][sale_price]" value="0.00" class="form-control form-control-sm sale_price" placeholder="0.00" required min="0" onchange="changeSalePrice(this)">
                                                    </div>
                                                </td>

                                                <td>
                                                    <div style="width: 100px;">
                                                        <input type="number" class="form-control form-control-sm product_quantity" name="stock_product_details[${arrayKey}][quantity]" placeholder="0.00" value="1" onchange="changeQuantity(this)" min="0" required>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div style="width: 100px;">
                                                        <input type="text" value="" class="form-control form-control-sm product_exp_date" name="stock_product_details[${arrayKey}][exp_date]" id="product_exp_date_${arrayKey}" readonly required>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div style="width: 125px;"></div>
                                                    <input type="text" class="form-control form-control-sm product_total_price" name="stock_product_details[${arrayKey}][total_price]" placeholder="0.00" value="0" readonly>
                                                    <input type="hidden" class="original_price" value="">
                                                </td>
                    </tr>`;

    const addBefore = prevElem;
    addBefore.before(mainHtml);


    setDatePicker(addBefore)
  }
}

function removeProduct(elem) {
  $(elem).parent().parent().remove();
  countPackage();
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
        row.find(".product_volume").val(ui.item.volume);
        row.find(".product_mrp").val(ui.item.mrp);

        row.find(".product_mrp").val(ui.item.mrp);
        row.find(".purchase_price").val(ui.item.mrp);
        row.find(".sale_price").val(ui.item.mrp);
        row.find(".product_total_price").val(ui.item.mrp);
        row.find(".original_price").val(ui.item.mrp);
        row
          .find('.product_unit option[value="' + ui.item.unit + '"]')
          .prop("selected", true);
        row.find(".product_exp_date").val(ui.item.exp_date);
        countPackage();
      },
    })
    .addClass("whatever");
  $(elem).on("autocompleteopen", function (event, ui) { });
}

function changeQuantity(elem) {
  var quantity = $(elem).parent().parent().parent().find(".product_quantity");
  var price = $(elem).parent().parent().parent().find(".product_total_price");
  var purchase_price = $(elem).parent().parent().parent().find(".purchase_price");
  var original_price = $(elem)
    .parent()
    .parent()
    .parent()
    .find(".original_price");
  if (price.val() != "") {
    price.val(original_price.val() * quantity.val());
    countPackage();
  }
}

function changeSalePrice(elem) {
  var quantity = $(elem).parent().parent().parent().find(".product_quantity");
  var price = $(elem).parent().parent().parent().find(".product_total_price");
  var sale_price = $(elem).parent().parent().parent().find(".sale_price");
  var purchase_price = $(elem).parent().parent().parent().find(".purchase_price");
  var original_price = $(elem)
    .parent()
    .parent()
    .parent()
    .find(".original_price");
  if (price.val() != "") {
    original_price.val(purchase_price.val());
    price.val(purchase_price.val() * quantity.val());
    countPackage();
  }
}

function countPackage() {
  var total_charge = $("#total_charge");
  var original_total_charge = $("#original_total_charge");

  var pending_due = $("#pending_due");
  var sub_total = $("#sum");
  var sub_total_input = $("#sum-input");
  var elem = $(".product_total_price");
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
    sub_total.html(totalAmount);
    sub_total_input.val(totalAmount);
    total_charge.val(totalAmount);
    original_total_charge.val(totalAmount);
    pending_due.val(totalAmount);

    setDiscount();

  }
}

function setDiscount() {
  var oldPrice = $("#sum-input");
  var total_charge = $("#total_charge");
  var original_total_charge = $("#original_total_charge");
  var discountType = $(".total-discount-select");
  var pending_due = $("#pending_due");

  var discount = $(".total-discount-input").val();

  var totalPrice = oldPrice.val();

  if (totalPrice != 0) {
    if (discountType.val() == "percentage") {
      var maxDiscount = 100 - discount;
      var leftPrice = (totalPrice * maxDiscount) / 100;
    } else {
      var leftPrice = parseFloat(totalPrice - discount);
    }
    total_charge.val(leftPrice);
    pending_due.val(leftPrice);
    original_total_charge.val(leftPrice);


  }

  appointmentTax()
  //countPackage();
}

function checkDiscountLength(discount) {
  var value = $(discount).val();
  var discountType = $(discount).parent().next().find(".total-discount-select");
  if ($(discountType).val() == "percentage") {
    var newVal = value.length <= 3 ? value : value.substring(0, 3);
    var newVal = value > 100 ? 100 : value;
  } else {
    var price = $(discount)
      .parent()
      .parent()
      .parent()
      .parent()
      .find("#sum-input");
    var newVal = value > price ? price : value;
  }
  $(discount).val(newVal);

  setDiscount();
}

function appointmentTax() {
  var taxArray = $(".appointment-tax").val();

  var taxHtml = $(".appointment-tax").find(":selected");//.text();

  dataProductType = $(taxHtml).attr('data-product-type');
  dataTaxType = $(taxHtml).attr('data-tax-type');
  dataGst = $(taxHtml).attr('data-gst');

  var original_total_charge = $("#original_total_charge");

  var total = $("#total_charge");
  var pend = $("#pending_due");
  if (dataGst != 0 && dataTaxType == 'exclusive') {
    var totalValue = parseFloat(original_total_charge.val());

    var taxInterest = (totalValue * dataGst) / 100;

    var totalAfterInterest = parseFloat(totalValue + taxInterest);

    total.val(totalAfterInterest);
    pend.val(totalAfterInterest);
  } else {
    total.val(original_total_charge.val());
    pend.val(original_total_charge.val());
  }

  setShippingCharge();
}

function advanceGiven() {
  var total = $("#total_charge");
  var totalValue = total.val();

  var adv = $("#amount_paid");
  var advValue = adv.val();
  var advType = $(".adv-type");
  var advTypeValue = advType.val();

  var pendingDue = $("#pending_due");
  var pendingDueValue = pendingDue.val();

  if (totalValue != 0) {
    if (advValue <= totalValue) {
      var finalValue = parseFloat(totalValue - advValue);
      pendingDue.val(finalValue);
    } else {
      showAlert("Advance amount exceeded total amount.", "orange");
      adv.val(0);
      pendingDue.val(totalValue);
    }
  }
}

function setShippingCharge() {
  var total = $("#total_charge");
  var totalValue = total.val();

  var adv = $("#shipping_charge");
  var advValue = adv.val();

  var pendingDue = $("#pending_due");
  var pendingDueValue = pendingDue.val();

  if (totalValue != 0) {
    var finalValue = parseFloat(parseFloat(totalValue) + parseFloat(advValue));
    pendingDue.val(finalValue);
    total.val(finalValue);

    advanceGiven();
  }
}


function checkInvoiceNumber(elem) {
  var val = $(elem).val();

  var package_name_label = $('.invoice_number_label');
  var package_name = $('.invoice_number');
  var ErrorMsg = "Invoice Number Already Exist";


  $.ajax({
    type: "POST",
    url: "inc/stock/stock-check-invoice.php",
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



function initDatePicker(elem) {
  const picker2 = datepicker(`#${elem}`, {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });
}


function setDatePicker(oldElem) {
  var elem = $(oldElem).prev().find(".product_exp_date")
  var id = $(elem).attr('id')
  initDatePicker(id)
}

