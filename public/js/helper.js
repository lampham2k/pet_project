function showNotification(from, align, message, type) {
    // type = ['', 'info', 'success', 'warning', 'danger', 'rose', 'primary'];

    $.notify({
        icon: "notifications",
        message: message,

    }, {
        type: type,
        timer: 2000,
        placement: {
            from: from,
            align: align
        }
    });
}

function select2WithApi(select, url, placeholderString, tag, idOption, nameOption) {
    select.select2({
        tags: tag,
        placeholder: placeholderString,
        ajax: {
            url: url,
            dataType: 'json',
            type: 'GET',
            data: function (params) {
                const queryParameters = {
                    q: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            text: item.name,
                            id: item.id,
                        }
                    })
                };

            },
        },
    });

    let id      = idOption;
    let name    = nameOption;

    if(id === 0){
        var $optionNull = $("<option></option>").val(0).text(name).attr("selected","selected");
        select.append($optionNull).trigger('change');
    }

    if(id !== null){
        var $selectedOption = $("<option></option>").val(parseInt(id)).text(name).attr("selected","selected");
        select.append($selectedOption).trigger('change');
    }
    
}
