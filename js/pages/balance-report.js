$(document).ready(function () {
  dataTableLoad();
});

function dataTableLoad() {
  $("#dataTable").DataTable();
}

$("#filterEnquiry").on("submit", function (event) {
  event.preventDefault();
  selectedDate = $("#filterfollowdate").val();

  var payment_method = $(".payment-method").val();
  //payment_method = (payment_method != '') ? payment_method : 1;
  payment_method = 1;

  window.location = `./balance-report.php?filterfollowdate=${selectedDate}&payment_method=${payment_method}`;
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

function setBalanceReportTitle(elem) {
  var methodTitle = $(elem).find("option:selected").text();
  var balanceReportTitle = `${methodTitle} Balance Report`;
  $(".balance-report-title").html(balanceReportTitle);
}
