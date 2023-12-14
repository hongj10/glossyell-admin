<?php
$menu_code = '9020';
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
                        <div class="card-body">
                            <div class="row text-right">
                                <div class="col-sm-12">
                                    <select class="form-control inline-select">
                                        <option selected="selected">20</option>
                                        <option>80</option>
                                        <option>100</option>
                                    </select>
                                    <select class="form-control  inline-select">
                                        <option selected="selected">발급로그</option>
                                        <option>요청로그</option>
                                        <option>연장로그</option>
                                        <option>승인로그</option>
                                        <option>반려로그</option>
                                        <option>삭제로그</option>
                                    </select>
                                    <select class="form-control select2 inline-select" style="width:200px">
                                        <option selected="selected">사용자</option>
                                        <option>test1(테스트1)</option>
                                        <option>test12(테스트12)</option>
                                        <option>test13(테스트13)</option>
                                        <option>test14(테스트14)</option>
                                        <option>test15(테스트15)</option>
                                        <option>test16(테스트16)</option>
                                        <option>test17(테스트17)</option>
                                        <option>test18(테스트18)</option>
                                        <option>test19(테스트19)</option>
                                        <option>test20(테스트20)</option>
                                        <option>test21(테스트21)</option>
                                        <option>test31(테스트31)</option>
                                        <option>test41(테스트41)</option>
                                        <option>test51(테스트51)</option>
                                        <option>test61(테스트61)</option>
                                    </select>
                                    <input type="text" class="form-control col-md-3 inline-input" id="" placeholder="사용자검색">
                                    <button type="button" class="btn btn-primary btn-inlineblock"><i class="fas fa-search"></i> 검색</button>
                                </div>
                            </div>
                            <div class="row text-right">

                                <div class="col-sm-6"></div>
                                <div class="col-sm-2">
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest" style="width:100%">
                                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" style="margin-bottom:0" />
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group date" id="reservationdate2" data-target-input="nearest" style="width:100%">
                                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate2" style="margin-bottom:0" />
                                        <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-secondary btn-inlineblock" style="width: 100%"><i class="fas fa-download"></i> 엑셀다운로드</button>
                                </div>

                            </div>
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
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
    function getContents() {
        $.get('slot_log.list.php', function (resp) {
            $('#content-body').html(resp);
            $('.start, .end').datetimepicker(DatetimepickerDefaults({}));
        }, 'html');
    }

    $(function () {
        getContents();
        // 메모 저장
        $("#memo-form").validate({
            rules: {},
            submitHandler: function (form) {
                $(':submit', form).hide();
                $(form).ajaxSubmit({
                    url: '/slot_log.ajax.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function (resp) {
                        responseHandler(resp, function () {
                            $(':submit', form).show();
                            $('input:text, textarea', form).val('');
                            getContents();
                            $('#modal').modal('hide');
                        });
                    }
                });
            }
        });
        
        // 수정 화면
        $('#content-body').on('click', '.btn-modify-action', function (e) {
            e.preventDefault();
            var $tr = $(this).closest('tr');
            $tr.find('.ui-default').hide();
            $tr.find('.ui-modify').show();
            return false;
        });
        // 수정 취소
        $('#content-body').on('click', '.btn-cancel', function (e) {
            e.preventDefault();
            var $tr = $(this).closest('tr');
            $tr.find('.ui-modify').hide();
            $tr.find('.ui-default').show();
            return false;
        });
        // 확인-수정
        $('#content-body').on('click', '.btn-modify', function (e) {
            e.preventDefault();
            var $tr = $(this).closest('tr');
            tr.find("input[name='method']").val('updateData');
            var jsonData = getTrDatas($tr);
            $.post('/slot_log.ajax.php', jsonData, function (resp) {
                responseHandler(resp, function () {
                    getContents();
                });
            }, 'json');
            return false;
        });
        // modal
        $('#content-body').on('click', '.btn-modal', function (e) {
            e.preventDefault();
            var $tr = $(this).closest('tr');
            $('#modal-seq').val($tr.data('seq'));
            $('#modal-memo').val($tr.find('.data-memo').text());
            $('#modal').modal();
            return false;
        });
        // 삭제
        $('#content-body').on('click', '.btn-delete', function (e) {
            e.preventDefault();
            if (confirm('삭제 하시겠습니까?')) {
                var tr = $(this).closest('tr');
                tr.find("input[name='method']").val('deleteData');
                var jsonData = getTrDatas(tr);
                $.post('/slot_log.ajax.php', jsonData, function (resp) {
                    responseHandler(resp, function () {
                        getContents();
                    });
                }, 'json');
            }
            return false;
        });
        // 연장
        $('#content-body').on('click', '.btn-add-date', function (e) {
            e.preventDefault();
            if (confirm('기간 연장 하시겠습니까?')) {
                var tr = $(this).closest('tr');
                tr.find("input[name='method']").val('addPeriod');
                var jsonData = getTrDatas(tr);
                $.post('/slot_log.ajax.php', jsonData, function (resp) {
                    responseHandler(resp, function () {
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
