const loadCombo = ({url = '', object = {}, type = '', selected = '', element, isReset = true}) => {
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'JSON',
        data: object,
        success: function(data){
            if(isReset){
                $(element).empty().append('<option value="">- choose - </option>');
            }

            $.each(data, function(key, val){
                $(element).append(`<option value="${val.combo_key}">${val.combo_name}</option>`);
            });
        }
    });
}