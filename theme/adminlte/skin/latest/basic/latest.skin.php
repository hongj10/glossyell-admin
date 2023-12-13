<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>
<!-- TABLE: LATEST CONTENTS -->
<section class="col-lg-5 connectedSortable">
    <div class="card">
        <div class="card-header border-transparent">
            <h3 class="card-title"><a href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject; ?></a></h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <!-- /.card-header -->

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>제목</th>
                            <th>글쓴이</th>
                            <th>날짜</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i=0; $i<$list_count; $i++) { ?>
                        <tr>
                            <td><?php echo $list_count - $i; ?></td>
                            <td><a href="<?php echo get_pretty_url($bo_table, $list[$i]['wr_id']); ?>"><?php echo $list[$i]['subject']; ?></a></td>
                            <td><a href="<?php echo get_pretty_url($bo_table, $list[$i]['wr_id']); ?>"><?php echo $list[$i]['name']; ?></a></td>
                            <td><a href="<?php echo get_pretty_url($bo_table, $list[$i]['wr_id']); ?>"><?php echo $list[$i]['datetime2']; ?></a></td>
                        </tr>
                        <?php } ?>
                        <?php if ($list_count == 0) {   //게시물이 없을 때 ?>
                            <tr><td colspan="4" class="empty_table">아직 등록된 게시물이 없습니다.</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
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