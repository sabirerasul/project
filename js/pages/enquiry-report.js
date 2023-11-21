$(document).ready(function () {

    loadClientTable();
    setTimeout(dataTableLoad, 2000);

});


function loadClientTable(formData = '') {
    $.ajax({
        type: "POST",
        url: "./inc/enquiry/enquiry-show.php",
        data: formData,
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
        }
    });
}

function dataTableLoad() {
    $('#dataTable').DataTable();
}


function setTable(result) {
    $('.table-data').html(result);
}

$(document).ready(function () {
    $('#filterForm').on("submit", function (event) {
        event.preventDefault();
        var formValues = $(this).serialize();
        loadClientTable(formValues);
        setTimeout(dataTableLoad, 3000);
    })
})



$('#filterEnquiry').on("submit", function (event) {
    event.preventDefault();
    var formValues = $(this).serialize();

    loadClientTable(formValues);
    setTimeout(dataTableLoad, 3000);

});


function ExportToExcel(type, fn, dl) {
    var mytable = document.getElementById('dataTable');
    TableToExcel.convert(mytable);
}

$("#enqchk").click(function () {
    if ($(this).prop("checked") == true) {
        $('.chkk').prop("checked", true);
    }
    else if ($(this).prop("checked") == false) {
        $('.chkk').prop("checked", false);
    }
});


//document.addEventListener("DOMContentLoaded", () => {
$(document).ready(function () {

    var monthdate = new Date(), y = monthdate.getFullYear(), m = monthdate.getMonth();
    var firstDay = new Date(y, m, 1);
    var lastDay = new Date(y, m + 1, 0);

    $('input[name="filterfollowdate"]').daterangepicker({
        opens: 'left',
        startDate: getDateFromObj(firstDay),
        endDate: getDateFromObj(lastDay),
    }, function (start, end, label) {

        //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

    //dataTableLoad2();
})
