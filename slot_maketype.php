<?php
$menu_code = '1010';
include '_common.php';
include './include/top.php';
include './include/lnb.php';
include './include/snb.php';
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?php include './include/page.header.php'?>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form name="form" id="form" action="" method="post">
                                <input type="hidden" name="method" value="insertSlotType" />
                                <div class="card-body">
                                    <div class="input-group">
                                        <input type="text" name="name" class="form-control col-md-3 required" id="name"
                                               required placeholder="슬롯타입명" style="display:inline-block">
                                        <button type="submit" class="btn btn-primary">슬롯타입 추가하기</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" id="content-body">
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
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
    getContents();
    $("#form").validate({
        rules: {
        },
        submitHandler: function(form) {
            $(':submit', form).hide();
            $(form).ajaxSubmit({
                url: '/slot_maketype.ajax.php',
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
        var $tr = $(this).closest('tr');
        var jsonData = getTrDatas($tr);
        $.post('/slot_maketype.ajax.php', jsonData, function(resp) {
            responseHandler(resp, function() {

            });
        }, 'json');
        return false;
    });
    $('#content-body').on('click', '.btn-delete', function(e) {
        e.preventDefault();
        if (confirm('삭제하시겠습니까?')) {
            var $tr = $(this).closest('tr');
            $tr.find("input[name='method']").val('deleteSlotType');
            var jsonData = getTrDatas($tr);
            $.post('/slot_maketype.ajax.php', jsonData, function(resp) {
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
