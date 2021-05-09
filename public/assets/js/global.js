var action;

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
    colDef.push({
        "defaultContent": "-",
        "targets": "_all"
    });
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

function resetForm(elem) {
    $(elem)[0].reset();
    $(elem + ' span.error').remove();
    $(elem + ' :input').removeClass('error');
    $(elem + ' select').trigger('change');
    $(elem + ' textarea').html('');
    $(elem + ' input[type="file"]').each(function (index, el) {
        var target = $(el).data('target');

        $(target).prop('src', $(el).data('default'));
    });
}

$('input[type="file"]').change(function (e) {
    if ($(this).data('target') !== undefined) {
        var imageType = ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'];
        var target = $(this).data('target');
        var reader = new FileReader();
        var uploadedFile = this.files[0];
        var fileType = uploadedFile.name.split('.');
        fileType = fileType[fileType.length - 1];

        if ($.inArray(fileType, imageType) != -1) {
            reader.onload = function (event) {
                $(target).prop('src', event.target.result);
            }

            reader.readAsDataURL(uploadedFile);
        } else {
            alert('Tipe file harus sesuai');
        }
    }
});