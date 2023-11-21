$(document).ready(function () {
  dataTableLoad1();
  dataTableLoad2();
});

function dataTableLoad1() {
  $("#dataTable1").DataTable();
}

function dataTableLoad2() {
  $("#dataTable2").DataTable();
}

$("#filterEnquiry").on("submit", function (event) {
  event.preventDefault();
  var selectedDate = $("#filterfollowdate").val();

  var service_provider_id = $("#service_provider_id").val();
  service_provider_id = service_provider_id != "" ? service_provider_id : 0;

  window.location = `./advance-job-card-report.php?filterfollowdate=${selectedDate}&service_provider_id=${service_provider_id}`;
});

function ExportToExcel1(type, fn, dl) {
  var mytable = document.getElementById("dataTable1");
  TableToExcel.convert(mytable);
}

function ExportToExcel2(type, fn, dl) {
  var mytable = document.getElementById("dataTable2");
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