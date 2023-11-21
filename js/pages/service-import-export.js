function serviceExport() {
    var url = "./inc/service/service-show-full.php";
    window.location = url
}

function serviceSample() {
    var url = "./inc/service/service-show-sample.php";
    window.location = url
}


$(document).ready(function () {

    $("#excel_form").on("submit", function (event) {
        event.preventDefault();
        //var formValues = $(this).serialize();

        var form = $("#excel_form");
        var formValues = $("#excel_form").serializeArray();

        var url = form.attr("action");

        var error = false;

        var fileInputLabel = $("fileInputLabel");
        var fileInput = $("#fileInput");

        var ErrorMsg = "";

        var excelfiles = fileInput[0].files;

        let allowedExtension = ["text/xls", "text/xlsx", "application/excel", "application/vnd.msexcel", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];

        if (excelfiles.length != 0) {
            var photofile = excelfiles[0];

            if (allowedExtension.indexOf(photofile.type) == -1) {
                ErrorMsg = "Excel file format currently supported.";
                addError(fileInputLabel, fileInput, ErrorMsg);
                error = true;
                return false;
            } else {
                error = false;
                removeError(fileInputLabel, fileInput);
            }

            if (photofile.size >= 5000000) {
                ErrorMsg = "Size exceeds the maximum limit of 5000 KB.";
                addError(fileInputLabel, fileInput, ErrorMsg);
                error = true;
                return false;
            } else {
                error = false;
                removeError(fileInputLabel, fileInput);
            }
        } else {
            addError(fileInputLabel, fileInput, "Excel File is required");
            error = true;
            return false;
        }

        if (error == false) {
            var photofile1 = excelfiles.length != 0 ? photofile : "";

            var form_data = new FormData();

            form_data.append("file", photofile1);

            for (let index = 0; index < formValues.length; index++) {
                const element = formValues[index];
                form_data.append(element.name, element.value);
            }

            $.ajax({
                type: "POST",
                url: url,
                data: form_data,
                contentType: false,
                processData: false,
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

                        showAlert("Excel file has been imported successfully");
                        Swal.fire(
                            "Good job!",
                            myObj.errors,
                            "success"
                        ).then((result) => {
                            document.getElementById("excel_form").reset();
                            location.reload();
                        })

                    } else {
                        errorMsg = myObj.errors;
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
})