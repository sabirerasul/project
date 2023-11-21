
function loadStaffTable() {
    $.ajax({
        type: "POST",
        url: "./inc/stock/stock-expire-show.php",
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
        }
    });
}

function setTable(result) {
    $('.active-table-data').html(result);
}


function dataTableLoad() {
    var table = $('#dataTable').DataTable();
}




$(function () {
    $("#category_field").autocomplete({
        source: function (request, response) {
            $.getJSON("inc/service-category/get-service-category.php", { name: request.term }, response);
        },
        minLength: 1,
        open: function (event, ui) {
            //console.log('onclick');
            //console.log('open',event,ui,this);
        },
        select: function (event, ui) {
            $(this).val(ui.item.value);
            $('#cat_id').val(ui.item.id);
        }
    }).addClass("whatever");
    $("#category_field").on("autocompleteopen", function (event, ui) {
        //console.log('autocompleteopen',event,ui,this);
    });
});

function ExportToExcel(type, fn, dl) {
    var mytable = document.getElementById('dataTable');
    TableToExcel.convert(mytable);
}

$(document).ready(function () {
    loadStaffTable();
})