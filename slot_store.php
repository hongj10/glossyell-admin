<?php
$menu_code = '1051';
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
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12 c_form_group">
                            <div class="card" style="background:#acb5bd">
                                <div class="card-body">
                                    <form name="form" id="form" action="" method="post">
                                        <input type="hidden" name="method" value="insertData"/>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input
                                                    type="text"
                                                    name="mb_name"
                                                    class="required form-control col-md-3 inline-input"
                                                    id="mb_name"
                                                    placeholder="업체명"
                                                    required="required">
                                                <input
                                                    type="text"
                                                    name="mb_id"
                                                    class="required form-control col-md-3 inline-input"
                                                    id="mb_id"
                                                    placeholder="아이디"
                                                    style="display: none"
                                                    required="required">
                                                <input
                                                    type="text"
                                                    name="mb_password"
                                                    class="required form-control col-md-3 inline-input"
                                                    id="mb_password"
                                                    placeholder="비밀번호"
                                                    style="display: none"
                                                    required="required">
                                                <select
                                                    class="form-control inline-select"
                                                    name="mb_level"
                                                    style="display: none">
                                                    <?php
                                                        echo '<option selected="selected" value="8">업체 생성</option>';
                                                    ?>
                                                </select>
                                                <button type="submit" class="btn btn-dark btn-inlineblock">
                                                    <i class="fas fa-user-plus"></i>
                                                    등록하기
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <form name="form" id="search-form" action="" method="post">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input
                                                    type="text"
                                                    name="keyword"
                                                    class="form-control col-md-3 inline-input"
                                                    id=""
                                                    placeholder="업체 검색어">
                                                <button type="submit" class="btn btn-primary btn-inlineblock">
                                                    <i class="fas fa-search"></i>
                                                    검색
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
                            <div class="card" id="content-body"></div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<?php
include './include/bottom.php';
?>
<script type="text/javascript">
    function getContents(href) {
        if (href == undefined) {
            href = 'slot_store.list.php';
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
        $('#search-form').submit(function () {
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
                url: '/slot_store.ajax.php',
                dataType: 'json',
                beforeSubmit: function () {},
                success: function (resp) {
                    responseHandler(resp, function (resp) {
                        // getContents();
                        $('.mb_password').val('');
                    });
                },
                complete: function (resp) {
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
                url: '/slot_store.ajax.php',
                dataType: 'json',
                beforeSubmit: function () {},
                success: function (resp) {
                    responseHandler(resp, function (resp) {
                        // getContents();
                        $('.select-tr')
                            .find('.mb_memo')
                            .val($('.textarea-mb-memo').val());
                    });
                },
                complete: function (resp) {
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
                    url: '/slot_store.ajax.php',
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
                element
                    .closest('.input-group')
                    .append(error);
            }
        });
        $('#content-body').on('click', '.btn-modify', function (e) {
            e.preventDefault();
            var $tr = $(this).closest('tr');
            var jsonData = getTrDatas($tr);
            $.post('/slot_store.ajax.php', jsonData, function (resp) {
                responseHandler(resp, function () {});
            }, 'json');
            return false;
        });
        // 삭제
        $('#content-body').on('click', '.btn-delete', function (e) {
            e.preventDefault();
            if (confirm('삭제하시겠습니까?')) {
                var $tr = $(this).closest('tr');
                $tr
                    .find("input[name='method']")
                    .val('deleteData');
                var jsonData = getTrDatas($tr);
                $.post('/slot_store.ajax.php', jsonData, function (resp) {
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