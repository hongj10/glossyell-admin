<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (!$member['mb_id']) { goto_url(G5_URL); }

if ($member['mb_level'] > 9) {
    // add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
    add_stylesheet('<link rel="stylesheet" href="'.$connect_skin_url.'/style.css">', 0);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">현재 접속자</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo G5_URL; ?>">Home</a></li>
                        <li class="breadcrumb-item active">현재 접속자</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        <!-- 현재접속자 목록 시작 { -->
        <div id="current_connect">
            <ul>
            <?php
            for ($i=0; $i<count($list); $i++) {
                //$location = conv_content($list[$i]['lo_location'], 0);
                $location = $list[$i]['lo_location'];
                // 최고관리자에게만 허용
                // 이 조건문은 가능한 변경하지 마십시오.
                if ($list[$i]['lo_url'] && $is_admin == 'super') $display_location = "<a href=\"".$list[$i]['lo_url']."\">".$location."</a>";
                else $display_location = $location;
            ?>
                <li>
                    <span class="crt_num"><?php echo $list[$i]['num'] ?></span>
                    <span class="crt_profile"><?php echo get_member_profile_img($list[$i]['mb_id']); ?></span>
                    <div class="crt_info">
                        <span class="crt_name"><?php echo $list[$i]['name'] ?></span>
                        <span class="crt_lct"><?php echo $display_location ?></span>  
                    </div>
                </li>
            <?php
            }
            if ($i == 0)
                echo "<li class=\"empty_li\">현재 접속자가 없습니다.</li>";
            ?>
            </ul>
        </div>
        <!-- } 현재접속자 목록 끝 -->
    </section>
    <!-- /.content -->
    
<?php
}
?>