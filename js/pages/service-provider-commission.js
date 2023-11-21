document.addEventListener("DOMContentLoaded", () => {

  var monthdate = new Date(), y = monthdate.getFullYear(), m = monthdate.getMonth();
  var firstDay = new Date(y, m, 1);
  var lastDay = new Date(y, m + 1, 0);


  $('input[name="daterange"]').daterangepicker({
    opens: 'left',
    startDate: getDateFromObj(firstDay),
    endDate: getDateFromObj(lastDay),
  }, function (start, end, label) {

  });

})


$(document).ready(function () {
  dataTableLoad();
})

function dataTableLoad() {
  var table = $('#dataTable').DataTable();
}