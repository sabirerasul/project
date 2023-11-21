function deleteProduct(v) {
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
            showAlert("Product deleted successfully");
            Swal.fire("Deleted!", "Product deleted successfully.", "success").then((nresult) => {
                if (nresult.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "inc/stock/product-delete.php",
                        data: { pid: v },
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
                                window.location = './product.php';
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

    $('#addProduct').on("submit", function (event) {
        event.preventDefault();
        var formValues = $(this).serialize();
        var form = $('#addProduct');
        var url = form.attr('action');

        var product = $('#product_field');
        var labelProduct = $('.product_label');

        var volume = $('#volume');
        var labelVolume = $('.volume_label');

        var unit = $('#unit');
        var labelUnit = $('.unit_label');

        var price = $('#price');
        var labelPrice = $('.price_label');


        var error = false;
        var ErrorMsg = '';


        if (product.val() == '') {
            ErrorMsg = "Product field is required";
            addError(labelProduct, product, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(labelProduct, product);
        }

        if (volume.val() == '') {
            ErrorMsg = "Volume field is required";
            addError(labelVolume, volume, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(labelVolume, volume);
        }



        if (unit.val() == '') {
            ErrorMsg = "Price field is required";
            addError(labelUnit, unit, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(labelUnit, unit);
        }

        if (price.val() == '') {
            ErrorMsg = "Price field is required";
            addError(labelPrice, price, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(labelPrice, price);
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
                        showAlert("Product Added successfully");
                        Swal.fire(
                            'Good job!',
                            'Product Added successfully',
                            'success'
                        ).then((result) => {
                            document.getElementById("addProduct").reset();
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
        }
    });

    $('#updateProduct').on("submit", function (event) {
        event.preventDefault();
        var formValues = $(this).serialize();
        var form = $('#updateProduct');
        var url = form.attr('action');

        var product = $('#product_field');
        var labelProduct = $('.product_label');

        var volume = $('#volume');
        var labelVolume = $('.volume_label');

        var unit = $('#unit');
        var labelUnit = $('.unit_label');

        var price = $('#price');
        var labelPrice = $('.price_label');

        var error = false;
        var ErrorMsg = '';


        if (product.val() == '') {
            ErrorMsg = "Product field is required";
            addError(labelProduct, product, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(labelProduct, product);
        }

        if (volume.val() == '') {
            ErrorMsg = "Volume field is required";
            addError(labelVolume, volume, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(labelVolume, volume);
        }



        if (unit.val() == '') {
            ErrorMsg = "Price field is required";
            addError(labelUnit, unit, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(labelUnit, unit);
        }

        if (price.val() == '') {
            ErrorMsg = "Price field is required";
            addError(labelPrice, price, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(labelPrice, price);
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
                        showAlert("Product Updated successfully");
                        Swal.fire(
                            'Good job!',
                            'Product Updated successfully',
                            'success'
                        ).then((result) => {
                            document.getElementById("updateProduct").reset();
                            window.location = './product.php';
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
        }
    });

})

function isProductAlready(elem) {
    var val = $(elem).val();
    valLength = val.length;

    var product_label = $('.product_label');
    var product_field = $('#product_field');
    var ErrorMsg = "Product name already exists.";

    if (valLength > 0) {

        console.log(valLength);
        console.log('is trigger');
        $.ajax({
            type: "POST",
            url: "inc/stock/product-check-name.php",
            data: { value: val },
            success: function (data) {
                const myObj = JSON.parse(data);

                if (myObj.success == true) {

                    addError(product_label, product_field, ErrorMsg);
                    showAlert(ErrorMsg, "red");
                    $(elem).val('');
                } else {
                    removeError(product_label, product_field);
                }
            },
            error: function (data) {
                removeError(product_label, product_field);
            },
        });
    }
}



function loadStaffTable() {
    $.ajax({
        type: "POST",
        url: "./inc/stock/product-show.php",
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




function ExportToExcel(type, fn, dl) {
    var mytable = document.getElementById('dataTable');
    TableToExcel.convert(mytable);
}