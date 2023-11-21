$(document).ready(function () {

    $("#addFeedbackForm").on("submit", function (event) {
        event.preventDefault();
        var formValues = $(this).serialize();

        var form = $("#addFeedbackForm");

        var url = form.attr("action");

        var error = false;

        var invoice_number = $(".invoice_number");
        var invoice_number_label = $(".invoice_number_label");

        var name = $(".name");
        var name_label = $(".name_label");

        var email = $(".email");
        var email_label = $(".email_label");

        var review = $(".review");
        var review_label = $(".review_label");

        var suggestion = $(".suggestion");
        var suggestion_label = $(".suggestion_label");

        var ErrorMsg = "";

        if (invoice_number.val() == "") {
            ErrorMsg = "Invoice Number field is required";
            addError(invoice_number_label, invoice_number, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(invoice_number_label, invoice_number);
        }

        if (name.val() == "") {
            ErrorMsg = "Name field is required";
            addError(name_label, name, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(name_label, name);
        }

        if (email.val() == "") {
            ErrorMsg = "Email cannot be blank";
            addError(email_label, email, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(email_label, email);
        }

        if (review.val() == "") {
            ErrorMsg = "Review cannot be blank";
            addError(review_label, review, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(review_label, review);
        }

        if (suggestion.val() == "") {
            ErrorMsg = "Suggestion field cannot be blank";
            addError(suggestion_label, suggestion, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(suggestion_label, suggestion);
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

                        $("#clientModalClose").click();
                        showAlert("Feedback submitted successfully");
                        Swal.fire(
                            "Good job!",
                            "Thankyou for giving your valuable feedback.",
                            "success"
                        ).then((result) => {
                            document.getElementById("addFeedbackForm").reset();
                            location.reload();
                        });

                        loadStaffTable();
                        setTimeout(dataTableLoad, 3000);
                    } else {
                        errorMsg = myObj.errors?.error;
                        $(".server-error").css("display", "block");
                        $("#error-message").html(errorMsg);
                        showAlert(errorMsg, "red");
                    }
                },
                error: function (data) {
                    instanceLoading.hideLoading()
                    const myObj = JSON.parse(data);
                    $(".server-error").show();
                    $("#error-message").html(myObj.errors?.error);
                    showAlert("Something went wrong", "red");
                },
            });
        }
    });
});



function check_invoice() {
    var invoice_number = $('.invoice_number');
    var invoice_number_label = $('.invoice_number_label');

    if (invoice_number.val() != '') {
        $.ajax({
            type: "POST",
            url: "inc/feedback/invoice-number-check.php",
            data: { invoice_number: invoice_number.val() },
            success: function (data) {
                const myObj = JSON.parse(data);
                if (myObj.status == true) {
                    ErrorMsg = "Invoice number validate successfully"
                    showAlert(ErrorMsg);
                    removeError(invoice_number_label, invoice_number);

                    $(".client_id").val(myObj.modal.client_id)
                    $(".branch_id").val(myObj.modal.branch_id)

                    $(".name").val(myObj.modal.client_name)
                    $(".email").val(myObj.modal.email)

                } else {
                    ErrorMsg = myObj.error
                    addError(invoice_number_label, invoice_number, ErrorMsg);
                    showAlert(ErrorMsg, "red");
                    invoice_number.val('');
                }

            },
            error: function (data) {
                removeError(invoice_number_label, invoice_number);
            },
        });
    }

}