$("#filterEnquiry").on("submit", function (event) {
    event.preventDefault();

    var employee_type = $('#employee_type').val()
    employee_type = (employee_type != '') ? employee_type : 0;

    var provider = $('#provider').val()
    provider = (provider != '') ? provider : 0;

    var month = $('#month').val()
    month = (month != '') ? month : 0;

    var year = $('#year').val()
    year = (year != '') ? year : 0;

    window.location = `./attendance-report.php?employee_type=${employee_type}&provider=${provider}&month=${month}&year=${year}`;

});

function changeProviderType(elem) {
    var serviceProviderArray = $('#service_provider_array');
    var staffArray = $('#staff_array');
    var provider = $('#provider');
    var html = ($(elem).val() == 1) ? serviceProviderArray.html() : staffArray.html();
    provider.html(html)
}


function ExportToExcel(type, fn, dl) {
    var mytable = document.getElementById('table-dash');
    TableToExcel.convert(mytable);
}

function ExportToExcel2(type, fn, dl) {
    var mytable = document.getElementById('full_attendance');
    TableToExcel.convert(mytable);
}


$(document).ready(function () {
    setEmployeeName();

    //dataTableLoad();
});

function setEmployeeName() {
    var provider = $('#provider option:selected').text();
    $('.employee_name').html(`Monthly Attendance of ${provider}`);
}



function dataTableLoad() {
    var table = $("#full_attendance").DataTable();
}




