<?php
$menu_code = '9010';
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
                <div class="col-sm-12 c_form_group">
                    <div class="card" style="background:#acb5bd">
                        <form name="form" id="search-form" action="slot_log.list.php" method="post">
                            <input type="hidden" name="isExcel" id="isExcel" value="0" />
                        <div class="card-body">
                            <div class="row text-right">
                                <div class="col-sm-12">
                                    <select name="item" class="form-control inline-select">
                                        <option selected="selected">20</option>
                                        <option>80</option>
                                        <option>100</option>
                                    </select>
                                    <select name="type" class="form-control  inline-select">
                                        <option value="add_slot">발급로그</option>
                                        <option value="add_period">연장로그</option>
                                        <option value="delete_slot">삭제로그</option>
                                    </select>
                                    <?php
                                    if ($member['mb_level'] > 8) {
                                        echo getUsersSelect('search_first_id', 'form-control select2 inline-select',
                                                            'width:120px', '8');
                                    }
                                    if ($member['mb_level'] > 6) {
                                        echo getUsersSelect('search_second_id', 'form-control select2 inline-select',
                                                            'width:120px', '6');
                                    }
                                    echo getUsersSelect('target_id', 'form-control select2 inline-select',
                                                        'width:120px', '2');
                                    ?>
                                    <button type="submit" class="btn btn-primary btn-inlineblock"><i class="fas fa-search"></i> 검색</button>
                                </div>
                            </div>
                            <div class="row text-right">

                                <div class="col-sm-6"></div>
                                <div class="col-sm-2">
                                    <div class="input-group date" data-target-input="nearest" style="width:100%">
                                        <input type="text" name="start" class="form-control datetimepicker-input" style="margin-bottom:0" />
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group date" data-target-input="nearest" style="width:100%">
                                        <input type="text" name="end" class="form-control datetimepicker-input" style="margin-bottom:0" />
                                        <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-secondary btn-inlineblock btn-excel" style="width: 100%"><i class="fas fa-download"></i> 엑셀 다운로드</button>
                                </div>

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
</div>
<form name="form" id="memo-form" action="" method="post">
<div class="modal fade" id="modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <input type="hidden" name="method" value="updateMemo" />
                <input type="hidden" name="seq" id="modal-seq" value="" />
                <h4 class="modal-title" style="font-size:0.9rem">메모작성</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" rows="3" placeholder="메모를 작성하세요" name="memo" id="modal-memo"></textarea>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
                <button type="submit" class="btn btn-primary">저장</button>
            </div>
        </div>
    </div>
</div>
</form>
<?php
include './include/bottom.php';
?>
<script type="text/javascript">
    function DatetimepickerDefaults(opts) {
        return $.extend({},{
            locale: 'ko',
            format: 'Y-m-d',
            changeMonth: true,
            changeYear: true,
            timepicker: false,
            defaultDate: new Date()
        }, opts);
    }
    $.datetimepicker.setLocale('ko');
    function getContents(href) {
        if (href == undefined) {
            href = 'slot_log.list.php';
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
            if ($('#isExcel').val() == '1') {

            } else {
                getContents();
                return false;
            }
        });

        // 엑셀 다운로드
        $('.btn-excel').click(function () {
           $('#isExcel').val('1');
           $('#search-form').submit();
        });

        $('#search-form select').change(function() {
            getContents();
        });

        $('.datetimepicker-input').datetimepicker(DatetimepickerDefaults({
            onSelectDate:function(ct){
                getContents();
            }
        }));
    });
</script>
</body>
</html>
