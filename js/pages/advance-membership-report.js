$(document).ready(function () {
  dataTableLoad();
});

function dataTableLoad() {
  $("#dataTable").DataTable();
}

$("#filterEnquiry").on("submit", function (event) {
  event.preventDefault();
  var selectedDate = $("#filterfollowdate").val();

  var membership_id = $("#membership_id").val();
  membership_id = membership_id != "" ? membership_id : 0;

  var client_id = $("#client_id").val();
  client_id = client_id != "" ? client_id : 0;

  var membership_type_id = $("#membership_type_id").val();
  membership_type_id = membership_type_id != "" ? membership_type_id : 0;

  window.location = `./advance-membership-report.php?filterfollowdate=${selectedDate}&membership_id=${membership_id}&client_id=${client_id}&membership_type_id=${membership_type_id}`;
});

function ExportToExcel(type, fn, dl) {
  var mytable = document.getElementById("dataTable");
  TableToExcel.convert(mytable);
}

$(document).ready(function () {
  var start_date = $("#start_date").val();
  var end_date = $("#end_date").val();

  $('input[name="filterfollowdate"]').daterangepicker(
    {
      opens: "left",
      startDate: start_date,
      endDate: end_date,
    },
    function (start, end, label) { }
  );
});
