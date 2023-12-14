<?php
$menu_code = '9020';
include '_common.php';
include './include/top.php';
include './include/lnb.php';
include './include/snb.php';
$slots = kgetAll('slot_type', array(1=>1), "seq asc");
?>

<style>
    .ui-modify {display: none}
</style>
<div class="content-wrapper">
    <?php
    include './include/page.header.php' ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <form name="form" id="form" action="" method="post">
                    <input type="hidden" name="method" value="insertData" />
                    <div class="col-12">
                        <div class="card" style="background:#acb5bd">
                            <div class="card-body">
                                <label>상품 일괄 업로드</label>
                                <div class="custom-file" style="width: 300px; margin-left:20px">
                                    <input type="file" name="bf_file[]" required class="custom-file-input" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                    <label class="custom-file-label" for="customFile">파일선택</label>
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> 업로드</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-md-2 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-th"></i>
                                슬롯 정보
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table custom_table table-hover table-bordered text-nowrap table-striped tiny_padding">
                                <tr>
                                    <td>슬롯 ID</td>
                                    <td>슬롯 명</td>
                                </tr>
                                <?php
                                if ($slots) {
                                    foreach ($slots as $slot)
                                    {
                                        ?>
                                <tr>
                                    <td><?php echo $slot['seq']?></td>
                                    <td><?php echo $slot['name']?></td>
                                </tr>
                                <?php

                                    }
                                }
                                ?>
                            </table>
                        </div>
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
        </div><!-- /.container-fluid -->
    </section>
</div>
<?php
include './include/bottom.php';
?>
<script type="text/javascript">
    function getContents() {
        $.get('slot_excel.list.php', function (resp) {
            $('#content-body').html(resp);
        }, 'html');
    }
    $(function() {
        getContents();
        $('.custom-file-input').change(function() {
            $('.custom-file-label').text($(this).val());
        });
        $("#form").validate({
            rules: {
                bf_file: {
                    required: true,
                    extension: "xlsx"
                },
            },
            submitHandler: function (form) {
                // $(':submit', form).hide();
                $(form).ajaxSubmit({
                    url: '/slot_excel.ajax.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function (resp) {
                        responseHandler(resp, function () {
                            $(':submit', form).show();
                            $('.custom-file-input').val('');
                            $('.custom-file-label').text('파일선택');
                            getContents();
                        });
                    }
                });
            }
        });
    });
</script>
</body>
</html>
