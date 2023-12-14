<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>로그인</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<link rel="preconnect" href="https://fonts.googleapis.com">
  	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  	<link href="https://fonts.googleapis.com/css2?amily=Noto+Sans+JP:wght@100;300;400;500;700;900&family=Noto+Serif+JP:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/plugins/dist/css/adminlte.min.css">
    
    <meta property="og:url" content="http://2024platinum.shop/">
    <meta property="og:title" content="ACQUA">
    <meta property="og:type" content="website">
    <!-- <meta property="og:image" content="https://code-study.tistory.com/images/img_share.png"> -->
    <meta property="og:description" content="아쿠아">
</head>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary" style="border-top: 3px solid #38b9e0;">
        <div class="card-header text-center">
        <img src="/img/logo_doto.png" style="display: block; float: none; margin: 0 auto; width: 120px;"></img>
        </div>
        <div class="card-body">
            <form id="form" action="/bbs/login_check.php" method="post">
                <input type="hidden" name="url" id="url" value="<?php echo $_GET['url']?>" />
                <div class="input-group mb-3">
                    <input type="text" id="mb_id" name="mb_id" class="form-control" placeholder="아이디">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" id="mb_password" name="mb_password" class="form-control" placeholder="비밀번호">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">

                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block" style="background-color: #38b9e0;border-color: #38b9e0;">로그인</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <!-- /.social-auth-links -->
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="/plugins/jquery-validation/jquery.validate.min.js"></script>
<script>
    $(function () {
        $('#form').validate({
            rules: {
                mb_id: {
                    required: true
                },
                mb_password: {
                    required: true
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.input-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
        $.extend($.validator.messages, {
            required: "필수 항목입니다."
        });
    });
</script>
</body>
</html>
