<?php
$menu_code = '1060';
include '_common.php';
include './include/top.php';
include './include/lnb.php';
include './include/snb.php';
?>
<div class="content-wrapper">
    <?php
    include './include/page.header.php' ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">

                    <div class="row">
                        <div class="col-sm-12 c_form_group">
                            <div class="card" style="background:#acb5bd">
                                <div class="card-body">
                                    <form name="form" id="form" action="" method="post">
                                        <input type="hidden" name="method" value="insertData" />
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input type="text" name="mb_name"
                                                       class="required form-control col-md-3 inline-input" id="mb_name"
                                                       placeholder="이름" required>
                                                <input type="text" name="mb_id"
                                                       class="required form-control col-md-3 inline-input" id="mb_id"
                                                       placeholder="아이디" required>
                                                <input type="text" name="mb_password"
                                                       class="required form-control col-md-3 inline-input" id="mb_password"
                                                       placeholder="비밀번호" required>
                                                <select class="form-control inline-select" name="mb_level">
                                                    <?php
                                                    if ($member['mb_level'] > 8) {
                                                        echo '<option selected="selected" value="8">총판 생성</option>';
                                                    }
                                                    if ($member['mb_level'] > 6) {
                                                        echo '<option value="6">대리점 생성</option>';
                                                    }
                                                    if ($member['mb_level'] > 2) {
                                                        echo '<option value="2">사용자 생성</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <button type="submit" class="btn btn-dark btn-inlineblock"><i
                                                            class="fas fa-user-plus"></i> 등록하기
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <form name="form" id="search-form" action="" method="post">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" name="keyword" class="form-control col-md-3 inline-input" id=""
                                                   placeholder="검색어">
                                            <button type="submit" class="btn btn-primary btn-inlineblock"><i
                                                        class="fas fa-search"></i> 검색
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

                </div>
                <div class="col-md-2">
                    <div class="card" style="">
                        <div class="card-body">
                            <blockquote class="quote-secondary"
                                        style="margin:0; margin-bottom:15px; padding: 0px 5px 0px 10px">
                                <h6 style="font-size: 0.9rem">현재 등록된 회원</h6>
                            </blockquote>
                            <p class="select-id">선택 안함</p>
                            <form name="form" id="form-memo" action="" method="post">
                                <div class="row user_detail">
                                    <div class="col-sm-7">
                                        <blockquote class="quote-secondary"
                                                    style="margin:0; margin-bottom:15px; padding: 0px 5px 0px 10px">
                                            <h6 style="font-size: 0.9rem">메모작성</h6>
                                        </blockquote>
                                    </div>
                                        <input type="hidden" name="mb_id" class="mb_id" value="" />
                                        <input type="hidden" name="method" value="updateMemo" />
                                        <div class="col-sm-5 text-right">
                                            <button type="submit" class="btn btn-primary btn-inlineblock btn-memo"><i
                                                        class="far fa-save"></i> 저장
                                            </button>
                                        </div>
                                        <div class="col-12 p-1">
                                            <textarea name="mb_memo" class="textarea-mb-memo form-control" rows="3" placeholder="메모를 작성하세요"></textarea>
                                        </div>

                                </div>
                            </form>
                            <form name="form" id="form-password" action="" method="post">
                                <div class="row user_detail">
                                    <div class="col-sm-7">
                                        <blockquote class="quote-secondary"
                                                    style="margin:0; margin-bottom:15px; padding: 0px 5px 0px 10px">
                                            <h6 style="font-size: 0.9rem">비밀번호 변경</h6>
                                        </blockquote>
                                    </div>

                                        <input type="hidden" name="mb_id" class="mb_id" value="" />
                                        <input type="hidden" name="method" value="updatePassword" />
                                    <div class="col-sm-5 text-right">
                                        <button type="submit" class="btn btn-primary btn-inlineblock btn-password"><i
                                                    class="far fa-save"></i> 저장
                                        </button>
                                    </div>
                                    <div class="col-12 p-1">
                                        <label>변경할 비밀번호</label>
                                        <input type="text" name="mb_password" class="mb_password form-control col-12 inline-input" id="" placeholder=""
                                               style="width: 100%">
                                    </div>                               
                                </div>
                            </form>
                        </div>
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
    function getContents(href) {
        if (href == undefined) {
            href = 'slot_user.list.php';
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
        $('#search-form').submit(function() {
            getContents();
            return false;
        });
        // 비밀번호 변경
        $(document).on('submit', '#form-password', function (e) {
            e.preventDefault();
            if ($('.mb_id').val() == '') {
                alert('사용자를 선택해주세요.');
                return false;
            }
            var this_ = $(this);
            // $(':submit', this_).hide();
            this_.ajaxSubmit({
                type: 'post',
                url: '/slot_user.ajax.php',
                dataType: 'json',
                beforeSubmit: function () {
                },
                success: function (resp) {
                    responseHandler(resp, function (resp) {
                        // getContents();
                        $('.mb_password').val('');
                    });
                },
                complete: function(resp) {
                    // $(':submit', this_).show();
                }
            });
            return false;
        });
        // 메모 저장
        $(document).on('submit', '#form-memo', function (e) {
            e.preventDefault();
            if ($('.mb_id').val() == '') {
                alert('사용자를 선택해주세요.');
                return false;
            }
            var this_ = $(this);
            // $(':submit', this_).hide();
            this_.ajaxSubmit({
                type: 'post',
                url: '/slot_user.ajax.php',
                dataType: 'json',
                beforeSubmit: function () {
                },
                success: function (resp) {
                    responseHandler(resp, function (resp) {
                        // getContents();
                        $('.select-tr').find('.mb_memo').val($('.textarea-mb-memo').val());
                    });
                },
                complete: function(resp) {
                    // $(':submit', this_).show();
                }
            });
            return false;
        });
        $("#form").validate({
            rules: {},
            submitHandler: function (form) {
                $(':submit', form).hide();
                $(form).ajaxSubmit({
                    url: '/slot_user.ajax.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function (resp) {
                        $(':submit', form).show();
                        responseHandler(resp, function () {
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
        $('#content-body').on('click', '.btn-modify', function (e) {
            e.preventDefault();
            var $tr = $(this).closest('tr');
            var jsonData = getTrDatas($tr);
            $.post('/slot_user.ajax.php', jsonData, function (resp) {
                responseHandler(resp, function () {

                });
            }, 'json');
            return false;
        });
        // 삭제
        $('#content-body').on('click', '.btn-delete', function (e) {
            e.preventDefault();
            if (confirm('삭제하시겠습니까?')) {
                var $tr = $(this).closest('tr');
                $tr.find("input[name='method']").val('deleteData');
                var jsonData = getTrDatas($tr);
                $.post('/slot_user.ajax.php', jsonData, function (resp) {
                    responseHandler(resp, function () {
                        getContents();
                    });
                }, 'json');
            }
            return false;
        });
        // 사용자 선택
        $('#content-body').on('click', '.btn-detail', function (e) {
            e.preventDefault();
            var $tr = $(this).closest('tr');
            var mb_id = $tr.data('seq');
            $('.mb_id').val(mb_id);
            $('.select-id').text(mb_id);
            $('.list-tr').removeClass('bg-info');
            $('.list-tr').removeClass('select-tr');
            $('.textarea-mb-memo').val($tr.find('.mb_memo').val());
            $tr.addClass('bg-info');
            $tr.addClass('select-tr');
        });
    });
</script>
</body>
</html>
