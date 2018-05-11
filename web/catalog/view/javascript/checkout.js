$(document).on('click', 'ul#shipping-methods-tabs li.shipping-method-item-item-variant', function(e) {
        var element = e.target;
        $(element).find("input:radio[name=shipping_method]").prop('checked', true);

});

$(document).on('change', '#shipping-method-novaposhta-inner-container select', function(element) {
    var checked_select = $(element.target);
    var selected_name = checked_select.attr('name');
    var url = "";
    switch(selected_name) {
        case "novaposhta_warehouse":
            url = "/index.php?route=shipping/novaposhta/changewarehouseaction";
            break;
        case "novapochta_city":
            url = "/index.php?route=shipping/novaposhta/changecityaction";
            break;
        default:
            url = "/index.php?route=shipping/novaposhta/changeregionaction";
    }


    $.ajax({
        url: url,
        type: 'post',
        data: $('#shipping-method-novaposhta-inner-container :input').serialize(),
        dataType: 'html',
        success: function(html) {
            $('#shipping-method-novaposhta-inner-container').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });

});

