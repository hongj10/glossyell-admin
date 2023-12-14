function paddingZero(n) {
    return ('00' + n).slice(-2);
}

function goUrl(url) {
    document.location.href = url;
}

//String Util
(function($) {
    $.extend($.fn, {
        replaceAll : function(targetString, replacement) {
            return replaceAll(jQuery( this).val(), targetString, replacement);
        }
    });
})(jQuery);

function replaceAll(org, targetString, replacement) {
    var t = new RegExp(targetString, "g");
    str = org.replace(t, replacement);
    return str;
}

function responseHandler(resp, success, fail) {
    var r = false;
    if (resp.success) {
        if (resp.message != undefined && resp.message != '') toastr.success(replaceAll(resp.message, 'nn', '\n'));
        if (success != undefined) success(resp);
        r = true;
    } else {
        if (resp.message) toastr.error(replaceAll(resp.message, 'nn', '\n'));
        if (resp.url) goUrl(resp.url);
        if (fail != undefined) fail(resp);
    }
    return r;
}

function getTrDatas($tr) {
    var td = $tr.children();
    var data = new Object() ;
    data['seq'] = $tr.data('seq');
    td.each(function(i){
        $(this).find(':text, :hidden, .select2').each(function() {
            if ($(this).attr('name') != undefined) {
                data[$(this).attr('name')] = $(this).val();
            }
        });
    });
    return data;
}

$(function() {
    $('body').on('click', '.paginate_button', function(e) {
        e.preventDefault();
        var newHref = $(this).find('a').attr('href');
        if (typeof href !== 'undefined') {
            href = newHref;
        }
        getContents(newHref);
    });
    $('body').on('click', '#checkAll', function(e) {
        $('.checkAll').prop('checked', $(this).prop('checked'));
    });
    $('.select22').select2();
});