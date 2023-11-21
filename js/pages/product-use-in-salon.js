function deleteService(v) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            showAlert("Service deleted successfully");
            Swal.fire("Deleted!", "Service deleted successfully.", "success").then((nresult) => {
                if (nresult.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "inc/stock/product-use-in-salon-delete.php",
                        data: { id: v },
                        beforeSend: function () {
                            instanceLoading.showLoading({
                                type: 'cube_flip',
                                color: '#ffffff',
                                backgroundColor: '#025043',
                                title: 'Loading...',
                                fontSize: 16,
                            });
                        },
                        success: function (data) {
                            instanceLoading.hideLoading()
                            const myObj = JSON.parse(data);

                            if (myObj.success == true) {
                                window.location = './product-use-in-salon.php'
                            }
                        },
                        error: function (data) { instanceLoading.hideLoading() },
                    });
                }
            });
        }
    });
}

$(document).ready(function () {

    loadStaffTable();

    $('#serviceAdd').on("submit", function (event) {
        event.preventDefault();
        var formValues = $(this).serialize();
        var form = $('#serviceAdd');
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: formValues,
            beforeSend: function () {
                instanceLoading.showLoading({
                    type: 'cube_flip',
                    color: '#ffffff',
                    backgroundColor: '#025043',
                    title: 'Loading...',
                    fontSize: 16,
                });
            },
            success: function (data) {
                instanceLoading.hideLoading()
                const myObj = JSON.parse(data);
                if (myObj.success == true) {
                    showAlert("Product consume successfully");
                    Swal.fire(
                        'Good job!',
                        'Product consume successfully',
                        'success'
                    ).then((result) => {
                        document.getElementById("serviceAdd").reset();
                        location.reload();
                    });

                } else {
                    $('.server-error').css("display", "block");
                    $('#error-message').html(myObj.errors.error);
                    showAlert(myObj.errors.error, "red");
                }
            },
            error: function (data) {
                instanceLoading.hideLoading()
                $('.server-error').show();
                $('#error-message').html(myObj.errors.error);
                showAlert("Something went wrong", "red");
            }
        })
    });



    $('#serviceUpdate').on("submit", function (event) {
        event.preventDefault();
        var formValues = $(this).serialize();
        var form = $('#serviceUpdate');
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: formValues,
            beforeSend: function () {
                instanceLoading.showLoading({
                    type: 'cube_flip',
                    color: '#ffffff',
                    backgroundColor: '#025043',
                    title: 'Loading...',
                    fontSize: 16,
                });
            },
            success: function (data) {
                instanceLoading.hideLoading()
                const myObj = JSON.parse(data);
                if (myObj.success == true) {
                    showAlert("Product Updated successfully");
                    Swal.fire(
                        'Good job!',
                        'Product consumption update successfully',
                        'success'
                    ).then((result) => {
                        document.getElementById("serviceUpdate").reset();
                        window.location = './product-use-in-salon.php';
                    });

                } else {
                    $('.server-error').css("display", "block");
                    $('#error-message').html(myObj.errors.error);
                    showAlert(myObj.errors.error, "red");
                }
            },
            error: function (data) {
                instanceLoading.hideLoading()
                $('.server-error').show();
                $('#error-message').html(myObj.errors.error);
                showAlert("Something went wrong", "red");
            }
        })
    });
})

function loadStaffTable() {
    $.ajax({
        type: "POST",
        url: "./inc/stock/product-use-in-salon-show.php",
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



function addServiceProviderServices() {
    //var box = $('#service-provider-services');

    var prevElem = $('#addBefore');
    var preEndTime = $(prevElem).prev().find('.product-remark');

    var preEndTimeName = $(preEndTime).attr('name');

    old_staff = prevElem.prev().find('.staff');

    var trdata = preEndTimeName.replace(/[^0-9]/gi, '');
    var arrayKey = parseInt(parseInt(trdata, 10) + 1);

    const mainHtml = `
                    <tr>
                        <td style="vertical-align: middle;">
                            <span class="sno text-danger" onclick='removeServiceProviderServices(this)'><i class="fas fa-trash"></i></span>
                        </td>
                        <td>
                            <input type="text" class="category-services form-control form-control-sm" onkeyup="searchServices(this)" placeholder="Service (Autocomplete)" autocomplete="off" required>
                            <input type="hidden" name="product_use_in_salon[${arrayKey}][salon_product_id]" class="serr">
                        </td>
                        <td>
                            <input type="number" name="product_use_in_salon[${arrayKey}][quantity]" class="quantity form-control form-control-sm d-input" value="1" onkeydown="checkAvailableQuantity(this)" required max="0">
                        </td>
                        <td>
                            <select name="product_use_in_salon[${arrayKey}][sp_id]" class="form-select form-select-sm staff" required>
                                ${old_staff.html()}
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm product-remark w-100" placeholder="Remark" name="product_use_in_salon[${arrayKey}][remark]">
                        </td>
                    </tr>`;

    const addBefore = prevElem;
    addBefore.before(mainHtml);

}

function removeServiceProviderServices(elem) {
    $(elem).parent().parent().remove();
}



function searchServices(elem) {
    var ser_cat_txt_elem = $(elem).parent().parent().find(".pr-1").children()[0];
    var ser_cat_elem = $(elem).parent().parent().find(".pr-1").children()[1];

    $(elem)
        .autocomplete({
            source: function (request, response) {


                $.getJSON(
                    "inc/stock/get-stock.php",
                    {
                        product: request.term
                    },
                    response
                );
            },
            minLength: 1,
            open: function (event, ui) { },
            select: function (event, ui) {
                $(this).val(ui.item.value);
                $(elem).parent().find(".serr").val(ui.item.id);
                $(ser_cat_txt_elem).val(ui.item.cat_name);
                $(ser_cat_elem).val(ui.item.cat_id);

                $(elem).parent().next().find(".quantity").attr('max', ui.item.actual_stock);
                if (ui.item.actual_stock == 0) {
                    $(elem).parent().next().find(".quantity").attr('min', ui.item.actual_stock);
                }
                checkAvailableQuantity($(elem).parent().next().find(".quantity"));
            },
        })
        .addClass("whatever");
    $(elem).on("autocompleteopen", function (event, ui) { });
}


function checkAvailableQuantity(elem) {
    var val = $(elem).parent().prev().find('.serr').val();
    if (val != '' || val != 0) {
        var max_val = parseInt($(elem).attr('max'));
        var quant_val = parseInt($(elem).val());
        if (quant_val > max_val) {
            showAlert(max_val + " " + ((max_val > 1) ? ' Stocks are left.' : 'Stock is left '), "orange");
            $(elem).val('1');
        }
    }
}


function ExportToExcel(type, fn, dl) {
    var mytable = document.getElementById('dataTable');
    TableToExcel.convert(mytable);
}