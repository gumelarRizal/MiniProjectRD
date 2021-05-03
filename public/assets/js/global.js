function ajaxData(
    requestUrl,
    requestData,
    callback = false,
    multipart = false,
    showAlert = true
) {
    var ajaxSetting = {
        method: "POST",
        url: requestUrl,
        data: requestData,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        beforeSend: function (data) {
            $("form :input").prop("disabled", true);
        },
        success: function (data) {
            try {
                // var result = JSON.parse(data);
                var result = data;

                if (result.status === true) {
                    if (callback !== false) callback(result);
                } else {
                    if (showAlert === true) alert(result.message);
                }
            } catch (e) {
                alert("System Error\n " + e.message);
            }
        },
        error: function (data) {
            alert(data.status + "\n" + data.statusText);
        },
        complete: function (data) {
            $("form :input").prop("disabled", false);
        },
    };

    if (multipart === true) {
        ajaxSetting.contentType = false;
        ajaxSetting.processData = false;
    }

    $.ajax(ajaxSetting);
}

function alertSuccess(str, url = null) {
    swal(
        {
            title: "Sukses",
            text: str,
            type: "success",
            confirmButtonColor: "#62cb31",
        }
    );
}
