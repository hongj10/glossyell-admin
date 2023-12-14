<?php
$menu_code = '1020';
include '_common.php';
include './include/top.php';
include './include/lnb.php';
include './include/snb.php';
?>
<div class="content-wrapper">
    <?php include './include/page.header.php'?>
    <!-- content -->
    <!-- //content -->
</div>
<?php
include './include/bottom.php';
?>
<script type="text/javascript">
    function getContents() {
        $.get('slot_maketype.list.php', function(resp) {
            $('#content-body').html(resp);
        }, 'html');
    }
$(function() {
    // getContents();
    $("#form").validate({
        rules: {
        },
        submitHandler: function(form) {
            $(':submit', form).hide();
            $(form).ajaxSubmit({
                url: '/sample.ajax.php',
                type: 'POST',
                dataType: 'json',
                success: function(resp) {
                    responseHandler(resp, function() {
                        $(':submit', form).show();
                        $('input:text, textarea', form).val('');
                        getContents();
                    });
                }
            });
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.input-group').append(error);
        }
    });
    $('#content-body').on('click', '.btn-modify', function(e) {
        e.preventDefault();
        var tr = $(this).closest('tr');
        var jsonData = getTrDatas(tr);
        $.post('/sample.ajax.php', jsonData, function(resp) {
            responseHandler(resp, function() {

            });
        }, 'json');
        return false;
    });
    $('#content-body').on('click', '.btn-delete', function(e) {
        e.preventDefault();
        if (confirm('삭제하시겠습니까?')) {
            var tr = $(this).closest('tr');
            tr.find("input[name='method']").val('deleteSlotType');
            var jsonData = getTrDatas(tr);
            $.post('/sample.ajax.php', jsonData, function(resp) {
                responseHandler(resp, function() {
                    getContents();
                });
            }, 'json');
        }
        return false;
    });
});
</script>
</body>
</html>
