<?php

$menu_code = '1030';
include '_common.php';
include './include/top.php';
include './include/lnb.php';
include './include/snb.php';

# 사용자
$default = ['mb_level' => 2];
$add_where = [];
if ($member['mb_level'] <= 2) {
    $add_where = [
        'member_id' => $member['mb_id'],
    ];
} elseif ($member['mb_level'] <= 6) {
    $add_where = [
        'second_id' => $member['mb_id'],
    ];
} elseif ($member['mb_level'] <= 8) {
    $add_where = [
        'first_id' => $member['mb_id'],
    ];
}
$where = array_merge($default, $add_where);
$users = cgetAll('g5_member', $where, " mb_name ");
$slots = kgetAll('slot_type', ['1' => 1], " name ");
?>
<div class="content-wrapper">
    <?php
    include './include/page.header.php' ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 c_form_group">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i>
                                슬롯신청
                            </h3>
                        </div>
                        <form name="form" id="form" action="" method="post">
                            <input type="hidden" name="method" value="insertData" />
                            <div class="card-body slot_add_from">
                            <div class="row">
                                <div class="col-sm-2 text-right">
                                    <label>사용자</label>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                    <select name="mb_id" class="form-control select2 inline-select" required style="width: 100%">
                                        <option value="">선택하세요</option>
                                        <?php
                                        if ($users) {
                                            foreach ($users as $user) {
                                                ?>
                                        <option value="<?php echo $user['mb_id']?>"><?php echo $user['mb_name']?>(<?php echo $user['mb_id']?>)</option>
                                        <?php

                                            }
                                        }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control col-md-3 inline-input" id=""
                                           placeholder="검색키워드">
                                    <button type="button" class="btn btn-primary btn-inlineblock"><i
                                                class="fas fa-search"></i> 검색
                                    </button>
                                </div>
                            </div>
                            <div class="row">
    <div class="col-sm-2 text-right">
        <label>슬롯타입</label>
    </div>
    <div class="col-sm-2">
        <div class="input-group">
            <select name="slot_type_seq" class="form-control select2 inline-select" required style="width: 100%" id="slotTypeSelect">
                <option value="">선택하세요</option>
                <?php
                if ($slots) {
                    foreach ($slots as $slot) {
                        ?>
                        <option value="<?php echo $slot['seq'] ?>" data-days="<?php echo $slot['days'] ?>"><?php echo $slot['name'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="col-sm-2 text-right">
        <label>수량</label>
    </div>
    <div class="col-sm-4">
        <input name="count" id="count" type="text" class="form-control inline-input" required id="" placeholder="" value="10">
    </div>
</div>
<div class="row">
    <div class="col-sm-2 text-right">
        <label>시작일</label>
    </div>
    <div class="col-sm-2">
        <div class="form-group" style="display: inline-block">
            <div class="input-group date" id="start_input" data-target-input="nearest">
                <input type="text" name="start" id="start" required readonly class="form-control datetimepicker-input" style="margin-bottom:0" value="<?php echo date('Y-m-d')?>" />
                <div class="input-group-append" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-2 text-right">
        <label>만료일</label>
    </div>
    <div class="col-sm-2">
        <div class="input-group date" id="end_input" data-target-input="nearest">
            <input type="text" name="end" id="end" required readonly class="form-control datetimepicker-input" data-target="#reservationdate" style="margin-bottom:0" />
            <div class="input-group-append" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
    </div>
</div>
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-dark btn-lg btn-inlineblock"><i
                                            class="fas fa-external-link-alt"></i> 슬롯부여
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
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

    $(function () {
        $('#start').datetimepicker(DatetimepickerDefaults({
            onSelectDate:function(ct){
                $('#end').focus();
            }
        }));
        $('#end').datetimepicker(DatetimepickerDefaults({
            onShow:function(ct){
                this.setOptions({
                    minDate:jQuery('#start_date').val()?jQuery('#start_date').val():false
                })
            }
        }));
        $('.select2').select2()

        // 슬롯 부여
        $("#form").validate({
            rules: {},
            submitHandler: function (form) {
                $(':submit', form).hide();
                $(form).ajaxSubmit({
                    url: '/slot_additional.ajax.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function (resp) {
                        responseHandler(resp, function () {
                            $(':submit', form).show();
                            $('input:text, textarea, select', form).val('');
                            $('#count').val('10');
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

        $("#slotTypeSelect").change(function() {
        var selectedOption = $(this).find("option:selected");
        var days = selectedOption.data("days");
        if (days) {
            var currentDate = new Date();
            var startDate = new Date(currentDate.getTime() + 24 * 60 * 60 * 1000); // 현재 날짜에서 하루를 더한 시작일
            var endDate = new Date(startDate.getTime() + (days - 1) * 24 * 60 * 60 * 1000); // 계산된 만료일 (시작일을 기준으로 하루씩 더합니다)
            var startDateString = startDate.getFullYear() + "-" + (startDate.getMonth() + 1) + "-" + startDate.getDate();
            var endDateString = endDate.getFullYear() + "-" + (endDate.getMonth() + 1) + "-" + endDate.getDate();
            
            $("#start").val(startDateString);
            if(days!=1){
                $("#end").val(endDateString);
            }
            
        } else {
            $("#start").val("");
            $("#end").val("");
        }
    });

    });
</script>
</body>
</html>
