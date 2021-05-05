function setDataTable(divId, dataUrl, colDef = [], requestData = null, requestOrder = null) {
    var dataTableConf = {
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.childRowImmediate
            }
        },
        destroy: true,
        autoWidth: true,
        processing: true,
        serverSide: true,
        autoFill: false,
        ajax: {
            url: dataUrl,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: function (d) {
                if (requestData !== null) {
                    $.each(requestData, function (key, value) {
                        d[key] = value;
                    });
                }
            },
            complete: function (d) {

            }
        },
        columnDefs: colDef
    }

    colDef.push({ render: renderNumRow, targets: 0 });

    if (requestOrder !== null) {
        dataTableConf.order = requestOrder;
    }

    return $(divId).DataTable(dataTableConf);
}

function renderNumRow(data, type, row, meta) {
    return meta.row + 1 + meta.settings._iDisplayStart;
}

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
