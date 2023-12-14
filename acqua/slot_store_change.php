<?php
$menu_code = '1050';
include '_common.php';
include './include/top.php';
include './include/lnb.php';
include './include/snb.php';
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
            href = 'slot_store_change.list.php';
        }
        $.get(href, function (resp) {
            $('#content-body').html(resp);
            $('.select2').select2();
        }, 'html');
    }

    $(function () {
        getContents();

        // 수정
        $('#content-body').on('click', '.btn-modify', function (e) {
            e.preventDefault();
            var $tr = $(this).closest('tr');
            $tr.find("input[name='method']").val('updateData');
            var jsonData = getTrDatas($tr);
            $.post('/slot_store_change.ajax.php', jsonData, function (resp) {
                responseHandler(resp, function () {
                    getContents();
                });
            }, 'json');
            return false;
        });

        // 총판 변경
        $('#content-body').on('change', '.first_id', function (e) {
            e.preventDefault();
            var $tr = $(this).closest('tr');
            $tr.find("input[name='method']").val('getSecondSelect');
            var jsonData = getTrDatas($tr);
            $.post('/slot_store_change.ajax.php', jsonData, function (resp) {
                $tr.find('.second-td').html(resp);
                $tr.find('.second-td select').select2();
            }, 'html');
            return false;
        });
    });
</script>
</body>
</html>
