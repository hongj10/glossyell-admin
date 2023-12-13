<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$thumb_width = 210;
$thumb_height = 150;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>
<!-- PICTURES: LATEST CONTENTS -->
<section class="col-lg-5 connectedSortable">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><a href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject; ?></a></h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <!-- /.card-header -->

        <div class="card-body">
            <div class="tab-content p-0">
                <ul class="users-list clearfix">
                <?php
                for ($i=0; $i<$list_count; $i++) {
                    $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

                    if($thumb['src']) {
                        $img = $thumb['src'];
                    } else {
                        $img = G5_IMG_URL.'/no_img.png';
                        $thumb['alt'] = '이미지가 없습니다.';
                    }
                    $img_content = '<img src="'.$img.'" alt="'.$thumb['alt'].'" >';
                    $wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);
                ?>
                    <li>
                        <a href="<?php echo $wr_href; ?>"><?php echo run_replace('thumb_image_tag', $img_content, $thumb); ?></a>
                        <a href="<?php echo $wr_href; ?>" class="users-list-name"><?php echo $list[$i]['subject']; ?></a>
                        <div class="lt_info">
                            <span class="users-list-date"><?php echo $list[$i]['name'] ?></span>
                            <span class="users-list-date"><?php echo $list[$i]['datetime2'] ?></span>              
                        </div>
                    </li>
                    
                <?php } ?>
                <?php if ($list_count == 0) {   //게시물이 없을 때 ?>
                    <li class="empty_li">아직 등록된 게시물이 없습니다.</li>
                <?php } ?>
                </ul>
                <!-- /.users-list clearfix -->
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer clearfix">
            <!-- a href="#" class="btn btn-sm btn-info float-left">Place New Order</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a -->
            <a href="<?php echo get_pretty_url($bo_table); ?>" class="btn btn-outline-secondary btn-sm float-right"><span class="sound_only"><?php echo $bo_subject ?></span>더보기</a>
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->
</section>