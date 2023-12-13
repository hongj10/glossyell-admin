<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<!-- 쪽지 목록 시작 { -->
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
                            <div class="btn btn-outline-primary btn-sm">전체 <?php echo $kind_title; ?>쪽지 <?php echo $total_count ?>통</div>
                            <!--button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button -->
                        </div>                        
                    </div><!-- /.card-header -->

                    <div class="card-body new_win">
                        <div class="new_win_con2">
                            <ul class="win_ul">
                                <li class="<?php if ($kind == 'recv') {  ?>selected<?php }  ?>"><a href="./memo.php?kind=recv">받은쪽지</a></li>
                                <li class="<?php if ($kind == 'send') {  ?>selected<?php }  ?>"><a href="./memo.php?kind=send">보낸쪽지</a></li>
                                <li><a href="./memo_form.php">쪽지쓰기</a></li>
                            </ul>
                            
                            <div class="memo_list">
                                <ul>
                                    <?php
                                    for ($i=0; $i<count($list); $i++) {
                                    $readed = (substr($list[$i]['me_read_datetime'],0,1) == 0) ? '' : 'read';
                                    $memo_preview = utf8_strcut(strip_tags($list[$i]['me_memo']), 30, '..');
                                    ?>
                                    <li class="<?php echo $readed; ?>">
                                        <div class="memo_li profile_big_img">
                                            <?php echo get_member_profile_img($list[$i]['mb_id']); ?>
                                            <?php if (! $readed){ ?><span class="no_read">안 읽은 쪽지</span><?php } ?>
                                        </div>
                                        <div class="memo_li memo_name">
                                            <?php echo $list[$i]['name']; ?> <span class="memo_datetime"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $list[$i]['me_send_datetime']; ?></span>
                                            <div class="memo_preview">
                                                <a href="<?php echo $list[$i]['view_href']; ?>"><?php echo $memo_preview; ?></a>
                                            </div>
                                        </div>	
                                        <a href="<?php echo $list[$i]['del_href']; ?>" onclick="del(this.href); return false;" class="memo_del float-right"><i class="fa fa-trash" aria-hidden="true"></i> <span class="sound_only">삭제</span></a>
                                    </li>
                                    <?php } ?>
                                    <?php if ($i==0) { echo '<li class="empty_table">쪽지가 없습니다.</li>'; }  ?>
                                </ul>
                            </div>

                            <!-- 페이지 -->
                            <?php echo $write_pages; ?>
                        </div>
                    </div><!-- /.card-body -->
                    
                    <div class="card-footer">
                        <p class="win_desc"><i class="fa fa-info-circle" aria-hidden="true"></i> 쪽지 보관 일수는 최장 <strong><?php echo $config['cf_memo_del'] ?></strong>일 입니다.</p>
                    </div><!-- /.card-footer -->               
                </div><!-- /.card -->
            </div><!-- /.col-12 -->
        </div><!-- /.row -->
    </section>
    <!-- } Main content -->
</div><!-- /.content-wrapper -->
<!-- } 콘텐츠 끝 -->
<!-- } 쪽지 목록 끝 -->