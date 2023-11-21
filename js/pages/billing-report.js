$(document).ready(function () {
  dataTableLoad();
});

function dataTableLoad() {
  $("#dataTable").DataTable();
}

$("#filterEnquiry").on("submit", function (event) {
  event.preventDefault();
  selectedDate = $("#filterfollowdate").val();

  var service_provider_id = $("#employee_id").val();
  service_provider_id = service_provider_id != "" ? service_provider_id : 0;

  var service_id = $("#enquiry_for").val();
  service_id = service_id != "" ? service_id : 0;

  var service_type = $("#enquiry_table_type").val();
  service_type = service_type != "" ? service_type : 0;

  window.location = `./billing-report.php?filterfollowdate=${selectedDate}&service_provider_id=${service_provider_id}&service_id=${service_id}&service_type=${service_type}`;
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

$(document).ready(function () {
  var timestamp =
    getServerFormatDate(getTodayDate()) + " " + getCurrentTime("HH");
  $(".enquiry_for_title")
    .autocomplete({
      source: function (request, response) {
        $.getJSON(
          "inc/enquiry/get-enquiry-for.php",
          {
            terms: request.term,
            timestamp: timestamp,
            category_id: "",
          },
          response
        );
      },
      minLength: 1,
      open: function (event, ui) { },
      select: function (event, ui) {
        console.log(ui.item);
        $(this).val(ui.item.value);
        $("#enquiry_for").val(ui.item.id);
        $("#enquiry_table_type").val(ui.item.type);
      },
    })
    .addClass("whatever");
});

$(".enquiry_for_title").on("autocompleteopen", function (event, ui) { });

function searchEmployee(elem) {
  var employee_type = $(".employee_type").val();

  $(elem)
    .autocomplete({
      source: function (request, response) {
        $.getJSON(
          "inc/employee-salary/get-employee.php",
          {
            employee_type: 2,
            name: request.term,
          },
          response
        );
      },
      minLength: 1,
      open: function (event, ui) { },
      select: function (event, ui) {
        var row = $(this).parent().parent();
        row.find(".employee_id").val(ui.item.id);
      },
    })
    .addClass("whatever");
  $(elem).on("autocompleteopen", function (event, ui) { });
}
