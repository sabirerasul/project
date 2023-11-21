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
            Swal.fire("Deleted!", "Expense deleted successfully.", "success").then(
                (nresult) => {
                    if (nresult.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "inc/expense/expense-delete.php",
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
                                    window.location = './expense.php'
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

    var filter_date = $('.filter_date').val()
    loadExpenseTable(filter_date);

    $('#addStaffForm').on("submit", function (event) {
        event.preventDefault();
        var formValues = $(this).serialize();

        var form = $('#addStaffForm');

        var url = form.attr('action');

        var error = false;

        var today_date_label = $('.today_date_label');
        var today_date = $('.today_date');

        var expense_type_label = $('.expense_type_label');
        var expense_type = $('.expense_type');

        var amount_paid_label = $('.amount_paid_label');
        var amount_paid = $('.amount_paid');

        var payment_mode_label = $('.payment_mode_label');
        var payment_mode = $('.payment_mode');

        var recipient_name_label = $('.recipient_name_label');
        var recipient_name = $('.recipient_name');

        var description_label = $('.description_label');
        var description = $('.description');

        var ErrorMsg = '';

        if (today_date.val() == '') {
            ErrorMsg = "Date field is required";
            addError(today_date_label, today_date, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(today_date_label, today_date);
        }

        if (expense_type.val() == '') {
            ErrorMsg = "Expense field is required";
            addError(expense_type_label, expense_type, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(expense_type_label, expense_type);
        }


        if (amount_paid.val() == '') {
            ErrorMsg = "Amount cannot be blank";
            addError(amount_paid_label, amount_paid, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(amount_paid_label, amount_paid);
        }

        if (payment_mode.val() == '') {
            ErrorMsg = "Payment mode cannot be blank";
            addError(payment_mode_label, payment_mode, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(payment_mode_label, payment_mode);
        }


        if (recipient_name.val() == '') {
            ErrorMsg = "recipient name cannot be blank";
            addError(recipient_name_label, recipient_name, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(recipient_name_label, recipient_name);
        }

        if (description.val() == '') {
            ErrorMsg = "description cannot be blank";
            addError(description_label, description, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(description_label, description);
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
                        showAlert("Expense record has been added successfully");
                        Swal.fire(
                            'Good job!',
                            'New Expense added successfully',
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

        var today_date_label = $('.today_date_label');
        var today_date = $('.today_date');

        var expense_type_label = $('.expense_type_label');
        var expense_type = $('.expense_type');

        var amount_paid_label = $('.amount_paid_label');
        var amount_paid = $('.amount_paid');

        var payment_mode_label = $('.payment_mode_label');
        var payment_mode = $('.payment_mode');

        var recipient_name_label = $('.recipient_name_label');
        var recipient_name = $('.recipient_name');

        var description_label = $('.description_label');
        var description = $('.description');

        var ErrorMsg = '';

        if (today_date.val() == '') {
            ErrorMsg = "Date field is required";
            addError(today_date_label, today_date, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(today_date_label, today_date);
        }

        if (expense_type.val() == '') {
            ErrorMsg = "Expense field is required";
            addError(expense_type_label, expense_type, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(expense_type_label, expense_type);
        }


        if (amount_paid.val() == '') {
            ErrorMsg = "Amount cannot be blank";
            addError(amount_paid_label, amount_paid, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(amount_paid_label, amount_paid);
        }

        if (payment_mode.val() == '') {
            ErrorMsg = "Payment mode cannot be blank";
            addError(payment_mode_label, payment_mode, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(payment_mode_label, payment_mode);
        }


        if (recipient_name.val() == '') {
            ErrorMsg = "recipient name cannot be blank";
            addError(recipient_name_label, recipient_name, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(recipient_name_label, recipient_name);
        }

        if (description.val() == '') {
            ErrorMsg = "description cannot be blank";
            addError(description_label, description, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(description_label, description);
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
                        showAlert("Expense record has been updated successfully");
                        Swal.fire(
                            'Good job!',
                            'Expense updated successfully',
                            'success'
                        ).then((result) => {
                            document.getElementById("editStaffForm").reset();
                            window.location = "./expense.php";
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
});


function loadExpenseTable(data = '') {
    $.ajax({
        type: "POST",
        url: "./inc/expense/expense-show.php",
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

function setTodayDate(id) {
    elem = document.getElementById(id);
    const formattedToday = getTodayDate();
    elem.value = (elem.value == '') ? formattedToday : elem.value;
    return formattedToday;
}

setTodayDate("date");

$(document).ready(function () {
    const picker2 = datepicker('.today_date', {
        formatter: (input, date, instance) => {
            const value = date.toLocaleDateString()
            input.value = dateFormatter(value)
        }
    })
})

$(function () {
    $("#expense_type")
        .autocomplete({
            source: function (request, response) {
                $.getJSON(
                    "inc/expense/get-expense-type.php",
                    { name: request.term },
                    response
                );
            },
            minLength: 1,
            open: function (event, ui) {
                //console.log('onclick');
                //console.log('open',event,ui,this);
            },
            select: function (event, ui) {
                $(this).val(ui.item.value);
                $("#expense_type_id").val(ui.item.id);
            },
        })
        .addClass("whatever");
    $("#expense_type").on("autocompleteopen", function (event, ui) {
        //console.log('autocompleteopen',event,ui,this);
    });
});

$(function () {
    $("#recipient_name")
        .autocomplete({
            source: function (request, response) {
                $.getJSON(
                    "inc/expense/get-recipient.php",
                    { name: request.term },
                    response
                );
            },
            minLength: 1,
            open: function (event, ui) {
                //console.log('onclick');
                //console.log('open',event,ui,this);
            },
            select: function (event, ui) {
                $(this).val(ui.item.value);
                $("#recipient_name_id").val(ui.item.id);
            },
        })
        .addClass("whatever");
    $("#recipient_name").on("autocompleteopen", function (event, ui) {
        //console.log('autocompleteopen',event,ui,this);
    });
});

document.addEventListener("DOMContentLoaded", () => {

    var monthdate = new Date(), y = monthdate.getFullYear(), m = monthdate.getMonth();
    var firstDay = new Date(y, m, 1);
    var lastDay = new Date(y, m + 1, 0);


    $('input[name="daterange"]').daterangepicker({
        opens: 'left',
        startDate: getDateFromObj(firstDay),
        endDate: getDateFromObj(lastDay),
    }, function (start, end, label) {

        //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

    //dataTableLoad2();
})

function filterExpense() {
    var formValues = $('.filter_date').val()
    loadExpenseTable(formValues);
    setTimeout(dataTableLoad, 3000);
}