
function loadStaffTable() {
    $.ajax({
        type: "POST",
        url: "./inc/stock/stock-transfer-available-show.php",
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
        }
    });
}

function setTable(result) {
    $('.active-table-data').html(result);
}


function dataTableLoad() {
    var table = $('#dataTable').DataTable();
}


$(function () {
    $("#category_field").autocomplete({
        source: function (request, response) {
            $.getJSON("inc/service-category/get-service-category.php", { name: request.term }, response);
        },
        minLength: 1,
        open: function (event, ui) {
            //console.log('onclick');
            //console.log('open',event,ui,this);
        },
        select: function (event, ui) {
            $(this).val(ui.item.value);
            $('#cat_id').val(ui.item.id);
        }
    }).addClass("whatever");
    $("#category_field").on("autocompleteopen", function (event, ui) {
        //console.log('autocompleteopen',event,ui,this);
    });
});


function ExportToExcel(type, fn, dl) {
    var mytable = document.getElementById('dataTable');
    TableToExcel.convert(mytable);
}

$(document).ready(function () {
    loadStaffTable();






    $("#stockTransferAdd").on("submit", function (event) {
        event.preventDefault();
        var formValues = $(this).serialize();
        var form = $("#stockTransferAdd");
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
            const myObj = JSON.parse(data);
            instanceLoading.hideLoading()
            if (myObj.success == true) {
              showAlert("Stock Transferred successfully");
              Swal.fire(
                "Good job!",
                "Stock Transferred successfully",
                "success"
              ).then((result) => {
                document.getElementById("stockTransferAdd").reset();
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
      });
})



function transferStock(e) {
    const model = $(e).attr("data-model")

    const myObj = JSON.parse(model);

    var name = myObj.title
    $("#stock_id").val(myObj.id);
    $("#stock_volume").val(myObj.volume);
    $("#stock_unit").val(myObj.unit.toUpperCase());
    $("#stock_quantity").attr('data-quantity', myObj.available);
    var exampleModalLabelSchedule = `Transfer Stock (${name})`;
    $("#exampleModalLabelSchedule").html(exampleModalLabelSchedule);
    $("#exampleModal").modal("show");
}



function checkQuantity(elem) {
    var maxQuantity = $(elem).attr("data-quantity")
    var quantity = $(elem).val()

    if (quantity > maxQuantity) {
        showAlert(`Available Quantity: ${maxQuantity}`, 'red')
        $(elem).val(maxQuantity)
    }
}