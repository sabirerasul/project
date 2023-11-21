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
            showAlert("SMS Message deleted successfully");
            Swal.fire("Deleted!", "SMS Message deleted successfully.", "success").then(
                (nresult) => {
                    if (nresult.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "inc/sms-panel/sms-message-delete.php",
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
                                    window.location = './sms-message.php'
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

        var sms_title_label = $('.sms_title_label');
        var sms_title = $('.sms_title');

        var template_id_label = $('.template_id_label');
        var template_id = $('.template_id');

        var message_label = $('.message_label');
        var message = $('.message');

        var ErrorMsg = '';

        if (sms_title.val() == '') {
            ErrorMsg = "SMS Title field is required";
            addError(sms_title_label, sms_title, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(sms_title_label, sms_title);
        }


        if (template_id.val() == '') {
            ErrorMsg = "Template field is required";
            addError(template_id_label, template_id, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(template_id_label, template_id);
        }

        if (message.val() == '') {
            ErrorMsg = "Message field is required";
            addError(message_label, message, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(message_label, message);
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
                        showAlert("SMS Message record has been added successfully");
                        Swal.fire(
                            'Good job!',
                            'SMS Message added successfully',
                            'success'
                        ).then((result) => {
                            document.getElementById("addStaffForm").reset();
                            location.reload();
                        })

                        //loadExpenseTable();
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

        var sms_title_label = $('.sms_title_label');
        var sms_title = $('.sms_title');

        var template_id_label = $('.template_id_label');
        var template_id = $('.template_id');

        var message_label = $('.message_label');
        var message = $('.message');

        var ErrorMsg = '';

        if (sms_title.val() == '') {
            ErrorMsg = "SMS Title field is required";
            addError(sms_title_label, sms_title, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(sms_title_label, sms_title);
        }

        if (template_id.val() == '') {
            ErrorMsg = "Template field is required";
            addError(template_id_label, template_id, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(template_id_label, template_id);
        }

        if (message.val() == '') {
            ErrorMsg = "Message field is required";
            addError(message_label, message, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(message_label, message);
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
                        showAlert("SMS Message record has been updated successfully");
                        Swal.fire(
                            'Good job!',
                            'SMS Message updated successfully',
                            'success'
                        ).then((result) => {
                            document.getElementById("editStaffForm").reset();
                            window.location = "./sms-message.php";
                        })

                        //loadExpenseTable();
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
});


function loadExpenseTable(data = '') {
    $.ajax({
        type: "POST",
        url: "./inc/sms-panel/sms-message-show.php",
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


function changeSMSTemplate(elem) {
    var value = $(elem).find(":selected").attr('data-template-value');
    $('#message').val(value);
}