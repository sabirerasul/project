$(document).ready(function () {

  loadStaffTable();
  
  const picker1 = datepicker(".transfer_date", {
    formatter: (input, date, instance) => {
      const value = date.toLocaleDateString();
      input.value = dateFormatter(value);
    },
  });

  $("#transferAdd").on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();
    var form = $("#transferAdd");
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
          showAlert("Service Provider Transferred successfully");
          Swal.fire(
            "Good job!",
            "Service Provider Transferred successfully",
            "success"
          ).then((result) => {
            document.getElementById("transferAdd").reset();
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
});

function transferServiceProvider(e) {
  var id = $(e).attr("data-id");
  var name = $(e).attr("data-name");
  $("#service_provider_id").val(id);
  var exampleModalLabelSchedule = `Transfer service provider (${name})`;
  $("#exampleModalLabelSchedule").html(exampleModalLabelSchedule);
  $("#exampleModal").modal("show");
}

function loadStaffTable() {
  $.ajax({
    type: "POST",
    url: "./inc/transfer-option/transfer-option-show.php",
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
  var mytable = document.getElementById("dataTable");
  TableToExcel.convert(mytable);
}
