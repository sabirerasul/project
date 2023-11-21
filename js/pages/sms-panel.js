$(document).ready(function () {


    const picker1 = datepicker(".present_date", {
        formatter: (input, date, instance) => {
            const value = date.toLocaleDateString();
            input.value = dateFormatter(value);
        },
    });


    $(".present_time").datetimepicker({
        format: "HH:ii P",
        showMeridian: true,
        autoclose: true,
        pickDate: false,
        startView: 1,
        maxView: 1,
    });

    $("#branch_sms_template_send").on("submit", function (event) {
        event.preventDefault();
        var formValues = $(this).serialize();

        var form = $("#branch_sms_template_send");

        var url = form.attr("action");

        var message_id_label = $(".message_id_label");
        var message_id = $(".message_id");

        if (message_id.val() == "") {
            ErrorMsg = "Message field is required";
            addError(message_id_label, message_id, ErrorMsg);
            error = true;
            return false;
        } else {
            error = false;
            removeError(message_id_label, message_id);
        }

        var error = false;

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
                        showAlert("Message saved successfully!");
                        Swal.fire(
                            "Good job!",
                            "Message saved successfully!",
                            "success"
                        ).then((result) => {
                            document.getElementById("branch_sms_template_send").reset();
                            location.reload();
                        });
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

    dataTableLoad1();
    dataTableLoad2();
})

function dataTableLoad1() {
    $('#dataTable1').DataTable();
}

function dataTableLoad2() {
    $('#dataTable2').DataTable();
}

$("#enqchk").click(function () {
    if ($(this).prop("checked") == true) {
        $(".chkk").prop("checked", true);
    } else if ($(this).prop("checked") == false) {
        $(".chkk").prop("checked", false);
    }
});

function triggerSMSModal() {
    var client_ids = $('.chkk');

    clientIdsArr = [];

    for (let index = 0; index < client_ids.length; index++) {
        const element = client_ids[index];
        if (element.checked == true) {
            clientIdsArr.push(element.value)
        }
    }

    if (clientIdsArr.length > 0) {
        $("#smsTemplateModal").modal('show');
        $('#hiddenClientId').val(clientIdsArr);
    } else {
        showAlert("Please Select at least one client", 'red');
    }

}


function changeSMSTemplate(elem) {
    var value = $(elem).find(":selected").attr('data-template-value');
    v = `<strong>Message Preview</strong><br> ${value}`;
    $('.message-preview').html(v);
}