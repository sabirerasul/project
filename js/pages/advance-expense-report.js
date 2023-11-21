$(document).ready(function () {
  dataTableLoad();
});

function dataTableLoad() {
  $("#dataTable").DataTable();
}

$("#filterEnquiry").on("submit", function (event) {
  event.preventDefault();
  var selectedDate = $("#filterfollowdate").val();

  var payment_method_id = $("#payment_method_id").val();
  payment_method_id = payment_method_id != "" ? payment_method_id : 0;

  var expense_type_id = $("#expense_type_id").val();
  expense_type_id = expense_type_id != "" ? expense_type_id : 0;

  window.location = `./advance-expense-report.php?filterfollowdate=${selectedDate}&expense_type_id=${expense_type_id}&payment_method_id=${payment_method_id}`;
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
