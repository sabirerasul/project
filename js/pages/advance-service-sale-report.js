$(document).ready(function () {
  dataTableLoad();
});

function dataTableLoad() {
  $("#dataTable").DataTable();
}

$("#filterEnquiry").on("submit", function (event) {
  event.preventDefault();
  var selectedDate = $("#filterfollowdate").val();

  var service_type = $("#service_type").val();
  service_type = service_type != "" ? service_type : 0;

  window.location = `./advance-service-sale-report.php?filterfollowdate=${selectedDate}&service_type=${service_type}`;
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
