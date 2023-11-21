$(document).ready(function () {

  loadCart()


  $(document).ready(function () {
    $('#appointment_time').val(getCurrentTime())
    $('#appointment_time').mdtimepicker({

      // format of the time value (data-time attribute)
      timeFormat: 'hh:mm:ss.000',

      // format of the input value
      format: 'h:mm tt',

      // theme of the timepicker

      // 'red', 'purple', 'indigo', 'teal', 'green', 'dark'
      theme: 'green',

      // determines if input is readonly
      readOnly: true,

      // determines if display value has zero padding for hour value less than 10 (i.e. 05:30 PM); 24-hour format has padding by default
      hourPadding: false,

      // determines if clear button is visible 
      clearBtn: false,

    });

    //$('#appointment_time').mdtimepicker('setValue','6:35 PM');

  });



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

function addToCart(elem) {
  var element = $(elem)

  var html = `<span class="bg-white py-1 px-2 me-2 rounded"><i class="fa text-success fa-check"></i></span>`;

  //add select service wrapper
  var elementArray = $(element).children()
  var id = $(element).attr('data-id')

  //add cart wrapper]

  if (elementArray.length == 1) {

    $(element).addClass('active')

    var html2 = $(html).clone().addClass('cursor-pointer').attr('onclick', 'removeCart(this)').removeClass('bg-white').addClass('bg-danger').children().removeClass('fa-check').removeClass('text-success').addClass('fa-trash').addClass('text-white').parent()
    var cloneElem = $(element).clone().removeAttr('onclick').removeClass('active').prepend(html2)
    var cloneElem1 = $(cloneElem).children()[1]
    var cloneElem1 = ($(cloneElem1).children()).removeClass('service-price').addClass('service-cart-price')

    cloneElem = $(cloneElem1).parent().parent();
    cloneElem.appendTo('.cart-wrapper')
    $(element).prepend(html)
    service(id, 'add')
  }


}

function removeCart(elem) {
  var element = $(elem).parent()

  var elementArray = $(element).children()
  var id = $(element).attr('data-id')

  $('[data-item-id="stand-out"]')
  var serviceElement = $('.service-wrapper li[data-id="' + id + '"]')
  serviceElement.removeClass('active')
  serviceElement.children()[0].remove()

  if (elementArray.length == 2) {
    element.remove()
    service(id, 'remove')
  }
}

function service(id, type) {
  $.ajax({
    type: "POST",
    url: "./inc/appointment/session-appointment-save.php",
    data: { id: id, type: type },
    beforeSend: function () {
      instanceLoading.showToast()
      /*instanceLoading.showLoading({
        type: 'cube_flip',
        color: '#ffffff',
        backgroundColor: '#025043',
        title: 'Loading...',
        fontSize: 16,
      });*/
    },
    success: function (result) {
      cartCount()
      totalCount()

      if (type == 'add') {
        showAlert('Service added in cart!')
      } else {
        showAlert('Service removed from cart!')
      }

      //instanceLoading.hideLoading()
      //loadCart()
    },
  });
}


function loadCart() {
  $.ajax({
    type: "POST",
    url: "./inc/appointment/session-appointment-show.php",
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
      $('.cart-wrapper').html(result)
      totalCount()
    },
  });
}


function cartCount() {
  var countWrapper = $('.cart-count')
  var counter = $('.cart-wrapper').children().length

  countWrapper.html(counter)
  totalCount()
}

function totalCount() {

  totalAmount = 0
  priceArr = []
  elem = $('.service-cart-price')

  for (let index = 0; index < elem.length; index++) {
    var element = elem[index]
    var p = parseFloat($(element).html())
    priceArr[index] = p
  }

  var totalPrice = priceArr.reduce((partialSum, a) => partialSum + a, 0)
  $('.total_price').html(totalPrice)
  $('#totalPrice').val(totalPrice)
}




function check_coupon_code(elem) {
  var val = $('.coupon_code').val();
  var coupon_code = $('#coupon_code');
  var coupon_code_label = $('.coupon_code_label');
  var sub_total = $('#totalPrice');
  var sub_total_label = $('.sub_total_label')
  var ErrorMsg = "";

  var client_name = $('.client_name');
  var client_name_label = $('.client_name_label');
  var client_id = $('#client_id').val();
  client_id = (client_id == '') ? 0 : client_id;
  var category_services = $('#accordionPanelsStayOpenExample');
  var error = false;

  if (client_name.val() == '') {
    ErrorMsg = "First, Fill Client Details"
    addError(client_name_label, client_name, ErrorMsg);
    showAlert(ErrorMsg, "red");
    coupon_code.val('')
    error = true;
    return false;
  } else {
    removeError(client_name_label, client_name);
    error = true;
  }


  if (sub_total.val() == 0) {
    ErrorMsg = "Purchase one service for applying coupon"
    addError(client_name_label, category_services, ErrorMsg);
    showAlert(ErrorMsg, "red");
    coupon_code.val('')
    error = true;
    return false;
  } else {
    removeError(client_name_label, category_services);
    error = false;
  }



  if (error == false && coupon_code.val() != '') {
    $.ajax({
      type: "POST",
      url: "inc/appointment/coupon-code-check.php",
      data: { coupon_code: val, client_id: client_id, sub_total: sub_total.val() },
      success: function (data) {
        const myObj = JSON.parse(data);
        if (myObj.status == true) {
          ErrorMsg = "Coupon Code Applied"
          showAlert(ErrorMsg);
          removeError(coupon_code_label, coupon_code);

          $(".coupon-discount").val(myObj.modal.discount)
          $(".coupon-discount-type").val(myObj.modal.discount_type)
          $(".coupon-max-dis-amt").val(myObj.modal.max_discount_amount)

          set_coupon_discount()

        } else {
          ErrorMsg = myObj.error
          addError(coupon_code_label, coupon_code, ErrorMsg);
          showAlert(ErrorMsg, "red");
          coupon_code.val('');
        }

      },
      error: function (data) {
        removeError(coupon_code_label, coupon_code);
      },
    });
  }
}

function set_coupon_discount() {

  var coupon_code = $('#coupon_code').val()
  var discount = $(".coupon-discount").val()
  var discountType = $(".coupon-discount-type")
  var max_dis_amt = $(".coupon-max-dis-amt").val()

  var oldPrice = $("#totalPrice");
  var total_charge = $("#totalPrice");

  var totalPrice = oldPrice.val()

  var coupon_discount_amount = $('.coupon-discount-amount');

  if (totalPrice != 0) {
    if (coupon_code != '' && discount != 0) {
      if (discountType.val() == "percentage") {
        var maxDiscount = 100 - discount;
        var leftPrice = Math.round((totalPrice * maxDiscount) / 100);
      } else {
        var leftPrice = Math.round(parseFloat(totalPrice - discount));
      }

      leftPrice = (leftPrice > max_dis_amt) ? max_dis_amt : leftPrice
      leftPrice = Math.round((totalPrice - leftPrice))

      $('.total_price').html(leftPrice)

      total_charge.val(leftPrice);
      coupon_discount_amount.val(leftPrice);

    }
  }
}



function checkClientNumber(elem) {
  var val = $(elem).val();

  var contact_label = $('.contact_label');
  var contact = $('.contact');

  var error = true;

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

  if (error == false) {
    $.ajax({
      type: "POST",
      url: "inc/appointment/get-client.php",
      data: { value: val },
      success: function (data) {
        const myObj = JSON.parse(data);
        if (myObj.status == true) {
          $('#client_id').val(myObj.data.id)
          $('.client_name').val(myObj.data.client_name)
        }
      },
      error: function (data) {

      },
    })
  }
}