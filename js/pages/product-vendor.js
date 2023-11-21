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
            showAlert("Vendor deleted successfully");
            Swal.fire("Deleted!", "Vendor deleted successfully.", "success").then((nresult) => {
                if (nresult.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "inc/stock/product-vendor-delete.php",
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
                                window.location = './product-vendor.php'
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

    $('#addProductVendorForm').on("submit", function (event) {
        event.preventDefault();
        var formValues = $(this).serialize();
        var form = $('#addProductVendorForm');
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
                    showAlert("Product Vendor Added successfully");
                    Swal.fire(
                        'Good job!',
                        'Product Vendor Added successfully',
                        'success'
                    ).then((result) => {
                        document.getElementById("addProductVendorForm").reset();
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



    $('#updateProductVendorForm').on("submit", function (event) {
        event.preventDefault();
        var formValues = $(this).serialize();
        var form = $('#updateProductVendorForm');
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
                    showAlert("Product Vendor Updated successfully");
                    Swal.fire(
                        'Good job!',
                        'Product Vendor Updated successfully',
                        'success'
                    ).then((result) => {
                        document.getElementById("updateProductVendorForm").reset();
                        window.location = './product-vendor.php';
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
        url: "./inc/stock/product-vendor-show.php",
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


function isNumberAlready(elem) {
    var val = $(elem).val();
    valLength = val.length;
    fVal = val.slice(0, 10);
    $(elem).val(fVal)

    var emp_number_label = $('.emp_number_label');
    var emp_number = $('.emp_number');
    var ErrorMsg = "Mobile number Already register";

    if (valLength == 10) {
        $.ajax({
            type: "POST",
            url: "inc/stock/product-vendor-check-mobile.php",
            data: { value: val },
            success: function (data) {
                const myObj = JSON.parse(data);

                if (myObj.success == true) {

                    addError(emp_number_label, emp_number, ErrorMsg);
                    showAlert(ErrorMsg, "red");
                    $(elem).val('');
                } else {
                    removeError(emp_number_label, emp_number);
                }
            },
            error: function (data) {
                removeError(emp_number_label, emp_number);
            },
        });
    }
}

function ExportToExcel(type, fn, dl) {
    var mytable = document.getElementById('dataTable');
    TableToExcel.convert(mytable);
}