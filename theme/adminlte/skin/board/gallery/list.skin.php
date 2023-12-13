<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<!-- 갤러리 목록 시작 { -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $board['bo_subject']; ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo G5_URL; ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?php echo $board['bo_subject']; ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <?php if ($is_admin == 'super' || $is_auth || $admin_href || $is_checkbox || $rss_href) { ?>
        <!-- 게시판 페이지 정보 및 버튼 시작 { -->
        <div class="row">
            <div class="col-12">                  
                <?php if ($admin_href) { ?><a href="<?php echo $admin_href ?>" class="btn_admin btn" title="관리자"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a><?php } ?>
                <?php if ($rss_href) { ?><a href="<?php echo $rss_href ?>" class="btn_b01 btn" title="RSS"><i class="fa fa-rss" aria-hidden="true"></i><span class="sound_only">RSS</span></a><?php } ?>
                <?php if ($is_admin == 'super' || $is_auth) {  ?>
                    <?php if ($is_checkbox) { ?>                            
                        <button type="submit" name="btn_submit" class="btn btn-secondary btn-sm" value="선택삭제" onclick="document.pressed=this.value"><i class="fa fa-trash-o" aria-hidden="true"></i> 선택삭제</button>
                        <button type="submit" name="btn_submit" class="btn btn-secondary btn-sm" value="선택복사" onclick="document.pressed=this.value"><i class="fa fa-files-o" aria-hidden="true"></i> 선택복사</button>
                        <button type="submit" name="btn_submit" class="btn btn-secondary btn-sm" value="선택이동" onclick="document.pressed=this.value"><i class="fa fa-arrows" aria-hidden="true"></i> 선택이동</button>
                    <?php } ?>                    
                <?php }  ?>
            </div>
        </div>
        <!-- } 게시판 페이지 정보 및 버튼 끝 -->
        <?php } ?>

        <div class="row">
            <div class="col-12">
                <span>Total <?php echo number_format($total_count); ?>건</span>
                <?php echo $page; ?> 페이지
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <!--h3 class="card-title">Responsive Hover Table</h3 -->
                        <!-- 게시판 카테고리 시작 { -->
                        <?php if ($is_category) {
                            include_once($board_skin_path.'/lib/board.lib.php');
                        ?>
                        <nav id="bo_cate">                        
                            <div class="btn-group btn-group-toggle">
                                <?php echo $category_option; ?>
                            </div>
                        </nav>
                        <?php } ?>
                        <!-- } 게시판 카테고리 끝 -->

                        <!-- 게시판 검색 시작 { -->
                        <div class="card-tools bo_sch_wrap">
                            <fieldset class="bo_sch">
                                <form name="fsearch" method="get">
                                    <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
                                    <input type="hidden" name="sca" value="<?php echo $sca; ?>">
                                    <input type="hidden" name="sop" value="and">
                                    <input type="hidden" name="sfl" value="wr_subject||wr_content">                                    
                                    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
                                    
                                    <div class="sch_bar input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="stx" value="<?php echo stripslashes($stx); ?>" required id="stx" class="sch_input form-control float-right" placeholder="Search">
                                        <div class="input-group-append">
                                            <button type="submit" value="검색" class="btn btn-default sch_btn">
                                                <i class="fas fa-search"></i><span class="sound_only">검색</span>
                                            </button>
                                        </div>                                        
                                    </div>
                                </form>
                            </fieldset>
                            <div class="bo_sch_bg"></div>
                        </div>
                        <!-- } 게시판 검색 끝 -->
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <form name="fboardlist"  id="fboardlist" action="<?php echo G5_BBS_URL; ?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
                            <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
                            <input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
                            <input type="hidden" name="stx" value="<?php echo $stx; ?>">
                            <input type="hidden" name="spt" value="<?php echo $spt; ?>">
                            <input type="hidden" name="sst" value="<?php echo $sst; ?>">
                            <input type="hidden" name="sod" value="<?php echo $sod; ?>">
                            <input type="hidden" name="page" value="<?php echo $page; ?>">
                            <input type="hidden" name="sw" value="">

                            <?php if ($is_checkbox) { ?>
                            <div id="gall_allchk" class="all_chk chk_box">
                                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);" class="selec_chk">
                                <label for="chkall">
                                    <span></span>
                                    <b class="sound_only">현재 페이지 게시물 </b> 전체선택
                                </label>
                            </div>
                            <?php } ?>

                            <div class="row">
                                <?php for ($i=0; $i<count($list); $i++) {
                                $classes = array();
                                $classes[] = 'gall_li';
                                $classes[] = 'col-gn-'.$bo_gallery_cols;

                                if($i && ($i % $bo_gallery_cols == 0)){
                                    $classes[] = 'box_clear';
                                }

                                if($wr_id && $wr_id == $list[$i]['wr_id']){
                                    $classes[] = 'gall_now';
                                }

                                $line_height_style = ($board['bo_gallery_height'] > 0) ? 'line-height:'.$board['bo_gallery_height'].'px' : '';
                                ?>
                                
                                <div class="col-sm-2">
                                    <?php if ($is_checkbox) { ?>
                                    <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="selec_chk">
                                    <label for="chk_wr_id_<?php echo $i ?>">
                                        <span></span>
                                        <b class="sound_only"><?php echo $list[$i]['subject']; ?></b>
                                    </label>
                                    
                                    <?php } ?>

                                    <a href="<?php echo $list[$i]['href']; ?>" style="display:block; height:<?php echo $board['bo_gallery_height']; ?>px;" data-toggle="lightbox" data-title='<?php echo $list[$i]['subject']; ?>' data-gallery="gallery">
                                    <?php
                                    if ($list[$i]['is_notice']) { // 공지사항  ?>
                                        <span class="is_notice" style="<?php echo $line_height_style; ?>">공지</span>
                                    <?php
                                    } else {
                                        $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);

                                        if($thumb['src']) {
                                            $img_content = '<img src="'.$thumb['src'].'" width="'.$board['bo_gallery_width'].'" height="'.$board['bo_gallery_height'].'" class="img-fluid mb-2" alt="'.$thumb['alt'].'">';
                                        } else {
                                            $img_content = '<img src="'.G5_THEME_IMG_URL.'/No_Image_Available.jpg" width="'.$board['bo_gallery_width'].'" height="'.$board['bo_gallery_height'].'" class="img-fluid mb-2" alt="no image">';
                                        }

                                        echo run_replace('thumb_image_tag', $img_content, $thumb);
                                    }
                                    echo "</a>";
                                    ?>

                                    <div class="gall_info">
                                        <a href="<?php echo $list[$i]['href']; ?>">
                                            <div><?php echo $list[$i]['subject']; ?></div>
                                            <span class="gall_write"><span class="sound_only">작성자 </span><?php echo $list[$i]['name']; ?></span>
                                            <span class="gall_date"><span class="sound_only">작성일 </span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $list[$i]['datetime2']; ?></span>
                                            <!--span class="gall_view"><span class="sound_only">조회 </span><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $list[$i]['wr_hit']; ?></span -->
                                        </a>
                                    </div>
                                    <?php if ($is_good || $is_nogood) { ?>
                                    <div class="gall_option">
                                        <?php if ($is_good) { ?><span class="sound_only">추천</span><strong><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <?php echo $list[$i]['wr_good']; ?></strong><?php } ?>
                                        <?php if ($is_nogood) { ?><span class="sound_only">비추천</span><strong><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> <?php echo $list[$i]['wr_nogood']; ?></strong><?php } ?>           
                                    </div>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                                <?php if (count($list) == 0) { echo '<div class="btn-block empty_list text-center">아직 갤러리 게시물이 없습니다.</div>'; } ?>
                                
                            </div>

                            <?php if ($write_pages) { ?>
                                <div class="row">                        
                                    <!-- 페이지 -->
                                    <?php echo $write_pages; ?>
                                    <!-- 페이지 -->
                                </div>
                            <?php } ?>

                        </form>
                    </div>
                    <!-- /.card-body -->

                    <?php if ($write_href) { ?>
                    <div class="card-footer">
                        <!-- button type="submit" class="btn btn-info">Sign in</button -->
                        <?php if ($write_href) { ?><a href="<?php echo $write_href; ?>" class="btn btn-primary float-right" title="글쓰기"><i class="fas fa-edit"></i> Write<span class="sound_only">글쓰기</span></a><?php } ?>
                        
                    </div>
                    <?php } ?>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-12 -->
        </div>
        <!-- /.row -->
    </section>
<!-- } 게시판 목록 끝 -->

<script>
    // 게시판 검색
    $(".btn_bo_sch").on("click", function() {
        $(".bo_sch_wrap").toggle();
    })
    $('.bo_sch_bg, .bo_sch_cls').click(function(){
        $('.bo_sch_wrap').hide();
    });
</script>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = g5_bbs_url+"/board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == 'copy')
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = g5_bbs_url+"/move.php";
    f.submit();
}

// 게시판 리스트 관리자 옵션
jQuery(function($){
    $(".btn_more_opt.is_list_btn").on("click", function(e) {
        e.stopPropagation();
        $(".more_opt.is_list_btn").toggle();
    });
    $(document).on("click", function (e) {
        if(!$(e.target).closest('.is_list_btn').length) {
            $(".more_opt.is_list_btn").hide();
        }
    });
});
</script>
<?php } ?>