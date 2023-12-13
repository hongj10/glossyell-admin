<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$nick = get_sideview($mb['mb_id'], $mb['mb_nick'], $mb['mb_email'], $mb['mb_homepage']);
if($kind == "recv") {
    $kind_str = "보낸";
    $kind_date = "받은";
}
else {
    $kind_str = "받는";
    $kind_date = "보낸";
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 쪽지보기 시작 { -->
<!-- 콘텐츠 시작 { -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid"><!--div class="container" -->
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $g5['title']; ?></h1>
                </div><!-- /.col -->
                
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo G5_URL; ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?php echo $g5['title']; ?></li>
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

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                        </div>                        
                    </div><!-- /.card-header -->

                    <div class="card-body new_win">
                        <div class="new_win_con2">
                            <!-- 쪽지함 선택 시작 { -->
                            <ul class="win_ul">
                                <li class="<?php if ($kind == 'recv') {  ?>selected<?php }  ?>"><a href="./memo.php?kind=recv">받은쪽지</a></li>
                                <li class="<?php if ($kind == 'send') {  ?>selected<?php }  ?>"><a href="./memo.php?kind=send">보낸쪽지</a></li>
                                <li><a href="./memo_form.php">쪽지쓰기</a></li>
                            </ul>
                            <!-- } 쪽지함 선택 끝 -->

                            <div class="memo_btn">
                                <?php if($prev_link) {  ?>
                                <a href="<?php echo $prev_link ?>" class="btn_left"><i class="fa fa-chevron-left" aria-hidden="true"></i> 이전쪽지</a>
                                <?php }  ?>
                                <?php if($next_link) {  ?>
                                <a href="<?php echo $next_link ?>" class="btn_right">다음쪽지 <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                                <?php } ?>  
                            </div>

                            <div id="memo_view_ul">
                                <div class="memo_view_li memo_view_name">
                                    <ul class="memo_from">
                                        <li class="memo_profile">
                                            <?php echo get_member_profile_img($mb['mb_id']); ?>
                                        </li>
                                        <li class="memo_view_nick"><?php echo $nick; ?><div><span class="sound_only"><?php echo $kind_date ?>시간</span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $memo['me_send_datetime']; ?></div></li>
                                        <li class="memo_op_btn list_btn"><a href="<?php echo $list_link; ?>" class="btn_b01 btn"><i class="fa fa-list" aria-hidden="true"></i><span class="sound_only">목록</span></a></li>
                                        <li class="memo_op_btn del_btn"><a href="<?php echo $del_link; ?>" onclick="del(this.href); return false;" class="memo_del btn_b01 btn"><i class="fa fa-trash" aria-hidden="true"></i> <span class="sound_only">삭제</span></a></li>	
                                    </ul>
                                    
                                </div>
                            </div>
                            <div class="card-body "><?php echo conv_content($memo['me_memo'], 0) ?></div>
                        </div>                            
                    </div><!-- /.card-body -->
                    
                    <div class="card-footer text-center" style="background:none;">
                        <?php if ($kind == 'recv') {  ?><a href="./memo_form.php?me_recv_mb_id=<?php echo $mb['mb_id'] ?>&amp;me_id=<?php echo $memo['me_id'] ?>" class="btn btn-primary">답장</a><?php }  ?>
                        <!-- button type="button" onclick="window.close();" class="btn_close">창닫기</button -->
                    </div><!-- /.card-footer -->               
                </div><!-- /.card -->
            </div><!-- /.col-12 -->
        </div><!-- /.row -->
    </section>
    <!-- } Main content -->
</div><!-- /.content-wrapper -->
<!-- } 콘텐츠 끝 -->
<!-- } 쪽지보기 끝 -->