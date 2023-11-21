function deleteExpense(v) {
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
            showAlert("Expense deleted successfully");
            Swal.fire("Deleted!", "GST Slab deleted successfully.", "success").then(
                (nresult) => {
                    if (nresult.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "inc/gst-slab/gst-slab-delete.php",
                            data: { eid: v },
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
                                    window.location = './gst-slab.php'
                                }
                            },
                            error: function (data) { instanceLoading.hideLoading() },
                        });
                    }
                }
            );
        }
    });
}


$(document).ready(function () {

    $('#addStaffForm').on("submit", function (event) {
        event.preventDefault();
        var formValues = $(this).serialize();

        var form = $('#addStaffForm');

        var url = form.attr('action');

        var error = false;

        var product_service_type_label = $('.product_service_type_label');
        var product_service_type = $('.product_service_type');

        var tax_type_label = $('.tax_type_label');
        var tax_type = $('.tax_type');

        var gst_label = $('.gst_label');
        var gst = $('.gst');

        var ErrorMsg = '';

        if (product_service_type.val() == '') {
            ErrorMsg = "Product Service field is required";
            addError(product_service_type_label, product_service_type, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(product_service_type_label, product_service_type);
        }

        if (tax_type.val() == '') {
            ErrorMsg = "Tax Type field is required";
            addError(tax_type_label, tax_type, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(tax_type_label, tax_type);
        }


        if (gst.val() == '') {
            ErrorMsg = "GST Slab cannot be blank";
            addError(gst_label, gst, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(gst_label, gst);
        }

        if (error == false) {

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
                        // $('#exampleModal').hide();
                        // $('.modal-backdrop').hide();

                        $('#clientModalClose').click();
                        showAlert("GST Slab record has been added successfully");
                        Swal.fire(
                            'Good job!',
                            'New GST Slab added successfully',
                            'success'
                        ).then((result) => {
                            document.getElementById("addStaffForm").reset();
                            location.reload();
                        })

                        loadExpenseTable();
                        setTimeout(dataTableLoad, 3000);

                    } else {
                        errorMsg = myObj.errors?.error
                        $('.server-error').css("display", "block");
                        $('#error-message').html(errorMsg);
                        showAlert(errorMsg, "red");
                    }
                },
                error: function (data) {
                    instanceLoading.hideLoading()
                    const myObj = JSON.parse(data);
                    $('.server-error').show();
                    $('#error-message').html(myObj.errors?.error);
                    showAlert("Something went wrong", "red");
                }
            })
        }

    });


    $('#editStaffForm').on("submit", function (event) {
        event.preventDefault();
        var formValues = $(this).serialize();

        var form = $('#editStaffForm');
        var url = form.attr('action');
        var error = false;

        var product_service_type_label = $('.product_service_type_label');
        var product_service_type = $('.product_service_type');

        var tax_type_label = $('.tax_type_label');
        var tax_type = $('.tax_type');

        var gst_label = $('.gst_label');
        var gst = $('.gst');

        if (product_service_type.val() == '') {
            ErrorMsg = "Product Service field is required";
            addError(product_service_type_label, product_service_type, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(product_service_type_label, product_service_type);
        }

        if (tax_type.val() == '') {
            ErrorMsg = "Tax Type field is required";
            addError(tax_type_label, tax_type, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(tax_type_label, tax_type);
        }


        if (gst.val() == '') {
            ErrorMsg = "GST Slab cannot be blank";
            addError(gst_label, gst, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(gst_label, gst);
        }

        if (error == false) {

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
                        // $('#exampleModal').hide();
                        // $('.modal-backdrop').hide();

                        $('#clientModalClose').click();
                        showAlert("GST Slab record has been updated successfully");
                        Swal.fire(
                            'Good job!',
                            'GST Slab updated successfully',
                            'success'
                        ).then((result) => {
                            document.getElementById("editStaffForm").reset();
                            window.location = "./gst-slab.php";
                        })

                        loadExpenseTable();
                        setTimeout(dataTableLoad, 3000);

                    } else {
                        errorMsg = myObj.errors?.error
                        $('.server-error').css("display", "block");
                        $('#error-message').html(errorMsg);
                        showAlert(errorMsg, "red");
                    }
                },
                error: function (data) {
                    instanceLoading.hideLoading()
                    const myObj = JSON.parse(data);
                    $('.server-error').show();
                    $('#error-message').html(myObj.errors?.error);
                    showAlert("Something went wrong", "red");
                }
            })
        }

    });

    loadExpenseTable()

});


function loadExpenseTable(data = '') {
    $.ajax({
        type: "POST",
        url: "./inc/gst-slab/gst-slab-show.php",
        data: { 'date': data },
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
    $('.active-table-data').html('');
    $('.active-table-data').html(result);
}

function dataTableLoad() {
    var table = $('#dataTable').DataTable();
}

function ExportToExcel(type, fn, dl) {
    var mytable = document.getElementById('dataTable');
    TableToExcel.convert(mytable);
}

