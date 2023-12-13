<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 쪽지 보내기 시작 { -->
<!-- 콘텐츠 시작 { -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid"><!--div class="container" -->
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">쪽지함</h1>
                </div><!-- /.col -->
                
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo G5_URL; ?>">Home</a></li>
                        <li class="breadcrumb-item active">쪽지함</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content { -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $g5['title']; ?></h3>

                        <!--div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                        </div -->                        
                    </div><!-- /.card-header -->

                    <div class="card-body new_win">
                        <div class="new_win_con2">
                            <ul class="win_ul">
                                <li><a href="./memo.php?kind=recv">받은 쪽지</a></li>
                                <li><a href="./memo.php?kind=send">보낸 쪽지</a></li>
                                <li class="selected"><a href="./memo_form.php">쪽지 쓰기</a></li>
                            </ul>

                            <form name="fmemoform" action="<?php echo $memo_action_url; ?>" onsubmit="return fmemoform_submit(this);" method="post" autocomplete="off">
                            <div class="form_01">
                                <h2 class="sound_only">쪽지쓰기</h2>
                                <ul>
                                    <li>
                                        <label for="me_recv_mb_id" class="sound_only">받는 회원아이디<strong>필수</strong></label>
                                        
                                        <input type="text" name="me_recv_mb_id" value="<?php echo $me_recv_mb_id; ?>" id="me_recv_mb_id" required class="frm_input full_input required" size="47" placeholder="받는 회원아이디">
                                        <span class="frm_info">여러 회원에게 보낼때는 컴마(,)로 구분하세요.</span>
                                        <?php if ($config['cf_memo_send_point']) { ?>
                                        <br ><span class="frm_info">쪽지 보낼때 회원당 <?php echo number_format($config['cf_memo_send_point']); ?>점의 포인트를 차감합니다.</span>
                                        <?php } ?>
                                    </li>
                                    <li>
                                        <label for="me_memo" class="sound_only">내용</label>
                                        <textarea name="me_memo" id="me_memo" required class="required"><?php echo $content ?></textarea>
                                    </li>
                                    <li>
                                        <span class="sound_only">자동등록방지</span>
                                        
                                        <?php echo captcha_html(); ?>
                                        
                                    </li>
                                </ul>
                            </div>

                            <div class="win_btn">
                                <button type="submit" id="btn_submit" class="btn btn-primary">보내기</button>
                                <!--button type="button" onclick="window.close();" class="btn_close">창닫기</button -->
                            </div>
                        </div>
                        </form>
                    </div><!-- /.card-body -->
                    
                    <!--div class="card-footer">
                        footer
                    </div --><!-- /.card-footer -->               
                </div><!-- /.card -->
            </div><!-- /.col-12 -->
        </div><!-- /.row -->
    </section>
    <!-- } Main content -->
</div><!-- /.content-wrapper -->
<!-- } 콘텐츠 끝 -->
<!-- } 쪽지 보내기 끝 -->
<script>
function fmemoform_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    return true;
}
</script>