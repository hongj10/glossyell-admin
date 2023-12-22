<?php
$menu_code = '1020';
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
                        <form name="form" id="search-form" action="" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php
                                    if ($member['mb_level'] > 8) {
                                        echo getUsersSelect('search_first_id', 'form-control select22 inline-select',
                                                            'width:120px', '8');
                                    }
                                    if ($member['mb_level'] > 6) {
                                        echo getUsersSelect('search_second_id', 'form-control select22 inline-select',
                                                            'width:120px', '6');
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php
                                    echo getUsersSelect('search_mb_id', 'form-control select22 inline-select',
                                                        'width:120px', '2');
                                    ?>
                                    <input name="keyword" type="text" class="form-control col-md-3 inline-input" id=""
                                           placeholder="검색어">
                                    <button type="submit" class="btn btn-primary btn-inlineblock"><i
                                                class="fas fa-search"></i> 검색
                                    </button>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <select name="item" class="form-control inline-select">
                                        <option value="20">20</option>
                                        <option value="80">80</option>
                                        <option value="100">100</option>
                                    </select>
                                    <?php
                                    $slots = kgetAll('slot_type', ['1' => 1], " name ");
                                    ?>
                                    <select name="slot_type_seq" class="form-control select2 inline-select">
                                        <option value="">선택하세요</option>
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
                                    <a href="slot_manage.php" class="btn btn-dark btn-inlineblock"><i
                                                class="fas fa-undo-alt"></i> 전체초기화
                                    </a>
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

                </div>
            </div>
        </div>
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
    var mb_level = '<?php echo $member['mb_level']?>';
    var href = '';
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

    // 한 번만 실행되도록 할 변수
    var expiredSlotAdded = false;

    function getContents(href) {
        if (href == undefined || href == '') {
            href = 'slot_manage.list.php';
        }

        if (!expiredSlotAdded) { // 한 번만 실행되도록 확인
            // url에서 expired_slot 값 가져오기
            const urlParams = new URL(location.href).searchParams;
            const expired_slot = urlParams.get('expired_slot');
            if (expired_slot != null) {
                href += '?expired_slot=' + expired_slot;
                expiredSlotAdded = true; // 한 번 추가되면 변수 값을 true로 설정
            }
        }
        $('#search-form').ajaxSubmit({
            url: href,
            type: 'GET',
            dataType: 'html',
            success: function (resp) {
                $('#content-body').html(resp);
                $('.start, .end').datetimepicker(DatetimepickerDefaults({}));
            }
        });
    }

    $(function () {
        getContents();
        $('#search-form').submit(function() {
            getContents();
            return false;
        });
        $("select[name='search_keyword'], select[name='search_play'], select[name='search_first_id'], select[name='search_second_id']").change(function() {
            getContents();
        });
        $("select[name='search_mb_id'], select[name='item'], select[name='slot_type_seq']").change(function() {
            getContents();
        });
        // 메모 저장
        $("#memo-form").validate({
            rules: {},
            submitHandler: function (form) {
                $(':submit', form).hide();
                $(form).ajaxSubmit({
                    url: '/slot_manage.ajax.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function (resp) {
                        responseHandler(resp, function () {
                            $(':submit', form).show();
                            $('input:text, textarea', form).val('');
                            getContents(href);
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
            $tr.find("input[name='method']").val('updateData');
            if (mb_level < 6 && parseInt($tr.find("input[name='hit']").data('hit'), 10) < parseInt($tr.find("input[name='hit']").val(), 10)) {
                alert('타수는 '+$tr.find("input[name='hit']").data('hit')+' 이하로 입력해주세요.');
                return false;
            }
            var jsonData = getTrDatas($tr);
            $.post('/slot_manage.ajax.php', jsonData, function (resp) {
                responseHandler(resp, function () {
                    $('.ui-input', $tr).each(function() {
                        $(this).closest('td').find('.ui-default').text($(this).val());
                    });
                    $tr.find('.ui-modify').hide();
                    $tr.find('.ui-default').show();
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
                var $tr = $(this).closest('tr');
                $tr.find("input[name='method']").val('deleteData');
                var jsonData = getTrDatas($tr);
                $.post('/slot_manage.ajax.php', jsonData, function (resp) {
                    responseHandler(resp, function () {
                        getContents(href);
                    });
                }, 'json');
            }
            return false;
        });
        // 연장
        $('#content-body').on('click', '.btn-add-date', function (e) {
            e.preventDefault();
            if (confirm('기간 연장 하시겠습니까?')) {
                var $tr = $(this).closest('tr');
                $tr.find("input[name='method']").val('addPeriod');
                var jsonData = getTrDatas($tr);
                $.post('/slot_manage.ajax.php', jsonData, function (resp) {
                    responseHandler(resp, function () {
                        getContents(href);
                    });
                }, 'json');
            }
            return false;
        });
        // 선택 연장
        $('body').on('click', '.btn-add-all-period', function (e) {
            e.preventDefault();
            if ($(".checkAll:checked").length == 0) {
                alert('변경할 데이터를 1개 이상 체크해주세요.');
                return false;
            }
            var day_count = $('#day_count').val();
            if (day_count == '' || day_count == '0' || isNaN(day_count)) {
                alert('연장할 일수를 0 보다 크거나 작은수를 입력해주세요.');
                $('#day_count').focus()
                return false;
            }
            if (confirm('선택한 데이터를 연장 하시겠습니까?')) {
                $('input:text, input:hidden', '#list-form').remove();
                $('#list-form').ajaxSubmit({
                    url: '/slot_manage.ajax.php',
                    type: 'POST',
                    dataType: 'json',
                    data:{'method':'updateList', 'day_count':$('#day_count').val()},
                    success: function (resp) {
                        responseHandler(resp, function () {
                            getContents(href);
                        });
                    }
                });
            }
            return false;
        });
    });
</script>
</body>
</html>