<?php
$menu_code = '1051';
include '_common.php';
include './include/top.php';
include './include/lnb.php';
include './include/snb.php';

$slots = kgetAll('slot_type', ['1' => 1], " name ");
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
                <div class="col-sm-12 c_form_group">
                    <div class="card" style="background:#acb5bd">
                        <div class="card-body">
                            <form name="form" id="search-form" action="" method="post">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input name="search_mb_id" type="text" class="form-control col-md-3 inline-input" id=""
                                               placeholder="아이디">
                                        <button type="submit" class="btn btn-primary btn-inlineblock"><i
                                                    class="fas fa-search"></i> 검색
                                        </button>
                                        <select name="slot_type_seq" class="form-control select2 inline-select slot_type_seq">
                                            <option value="">슬롯 TYPE</option>
                                            <?php
                                            if ($slots) {
                                                foreach ($slots as $slot) {
                                                    ?>
                                                    <option value="<?php echo $slot['seq']?>"><?php echo $slot['name']?></option>
                                                    <?php

                                                }
                                            }
                                            ?>
                                        </select>
                                        <?php
                                        echo getUsersSelect('change_mb_id', 'form-control select2 inline-select change_mb_id',
                                                            'width:120px', '2');
                                        ?>
                                        <button type="button" class="btn btn-dark btn-inlineblock btn-change-all"><i class="fas fa-redo-alt"></i> 일괄변경
                                        </button>
                                    </div>
                                </div>
                            </form>
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
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
</div>
<?php
include './include/bottom.php';
?>
<script type="text/javascript">
    function getContents(href) {
        if (href == undefined) {
            href = 'slot_user_change.list.php';
        }
        $('#search-form').ajaxSubmit({
            url: href,
            type: 'GET',
            dataType: 'html',
            success: function (resp) {
                $('#content-body').html(resp);
            }
        });
    }
    $(function () {
        getContents();
        $('.select2').select2();
        $('#search-form').submit(function() {
            getContents();
            return false;
        });
        $('.slot_type_seq').change(function() {
            getContents();
        });
        $('.btn-change-all').click(function() {
            if ($('.change_mb_id').val() == '') {
                alert('사용자를 선택해주세요.');
                return false;
            }
            if ($(".checkAll:checked").length == 0) {
                alert('변경할 데이터를 1개 이상 체크해주세요.');
                return false;
            }
            $('#list-form').ajaxSubmit({
                url: '/slot_user_change.ajax.php',
                type: 'POST',
                dataType: 'json',
                data:{'method':'updateList', 'change_mb_id':$('.change_mb_id').val()},
                success: function (resp) {
                    responseHandler(resp, function () {
                        getContents();
                    });
                }
            });
        });
    });
</script>
</body>
</html>
