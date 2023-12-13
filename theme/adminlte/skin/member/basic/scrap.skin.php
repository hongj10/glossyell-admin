<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<!-- 스크랩 목록 시작 { -->
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

                    <div class="card-body table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>제목</th>
                                    <th>게시판명</th>
                                    <th>스크랩 일시</th>
                                    <th>삭제</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php for ($i=0; $i<count($list); $i++) {  ?>
                                <tr>
                                    <td><a href="<?php echo $list[$i]['opener_href_wr_id'] ?>" class="scrap_tit" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href_wr_id'] ?>'; return false;"><?php echo $list[$i]['subject'] ?></a></td>
                                    <td><a href="<?php echo $list[$i]['opener_href'] ?>" class="scrap_cate" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href'] ?>'; return false;"><?php echo $list[$i]['bo_subject'] ?></a></td>
                                    <td class="scrap_datetime"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $list[$i]['ms_datetime']; ?></td>
                                    <td><a href="<?php echo $list[$i]['del_href']; ?>" onclick="del(this.href); return false;" class="btn btn-outline-primary btn-xs"><i class="fa-solid fa-trash-can"></i>삭제<span class="sound_only">삭제</span></a></td>
                            </tr>
                            <?php }  ?>

                            <?php if ($i == 0) echo "<tr><td class=\"empty_li\">아직 스크랩 자료가 없습니다.</td></tr>";  ?>
                            </tbody>
                        </table>
                        <?php echo get_paging($config['cf_write_pages'], $page, $total_page, "?$qstr&amp;page="); ?>

                        <!-- div class="win_btn">
                            <button type="button" onclick="window.close();" class="btn_close">창닫기</button>
                        </div -->
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
<!-- } 스크랩 목록 끝 -->