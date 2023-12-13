<?php
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');
?>

<!-- 콘텐츠 시작 { -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid"><!--div class="container" -->
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo G5_URL; ?>">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
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
                        <h3 class="card-title">Dashboard</h3>

                        <!--div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                        </div -->                        
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <!-- 일반 최신글(목록 타입) 시작 { -->
                        <div class="row">
                            <?php
                            // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
                            // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
                            // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
                            echo latest('theme/basic', 'notice', 4, 23);		// 공지사항 게시판
                            ?>                        
                        <!-- } 일반 최신글(목록 타입) 끝 -->

                        <!-- 사진 최신글 { -->                        
                            <?php
                            // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
                            // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
                            // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
                            echo latest('theme/pic_block', 'notice', 4, 23);		// 갤러리 게시판
                            ?>
                        </div>
                        <!-- } 사진 최신글 끝 -->

                        <!-- 최신글(공지사항과 갤러리 게시판은 제외) 시작 { -->
                        <div class="row">
                            <?php
                            //  최신글
                            $sql = " select bo_table
                                        from `{$g5['board_table']}` a left join `{$g5['group_table']}` b on (a.gr_id=b.gr_id)
                                        where a.bo_device <> 'mobile' ";
                            if(!$is_admin)
                            $sql .= " and a.bo_use_cert = '' ";
                            $sql .= " and a.bo_table not in ('notice', 'gallery') ";     // 공지사항과 갤러리 게시판은 제외
                            $sql .= " order by b.gr_order, a.bo_order ";
                            $result = sql_query($sql);
                            for ($i=0; $row=sql_fetch_array($result); $i++) {
                                $lt_style = '';
                                if ($i%3 !== 0 ) $lt_style = "margin-left:2%";
                            ?>
                            <div style="float:left;<?php echo $lt_style ?>" class="lt_wr">
                                <?php
                                // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
                                // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
                                // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
                                echo latest('theme/basic', $row['bo_table'], 6, 24);
                                ?>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <!-- } 최신글(공지사항과 갤러리 게시판은 제외) 끝 -->
                        <div class="row">
                            <section class="col-lg-12 connectedSortable">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">참고 - 샘플 페이지</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <a href="<?php echo G5_THEME_URL; ?>/index1.php">샘플 메인 페이지</a>
                                    </div>
                                </div>
                            </section>
                        </div>
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

<?php
include_once(G5_THEME_PATH.'/tail.php');