<?php

$menu_code = '9020';
include '_common.php';

if ($member['mb_level'] <= 2) {
    $add_sql = " AND mb_id = '{$member['mb_id']}' ";
} elseif ($member['mb_level'] <= 6) {
    $add_sql = " AND second_id = '{$member['mb_id']}' ";
} elseif ($member['mb_level'] <= 8) {
    $add_sql = " AND first_id = '{$member['mb_id']}' ";
}

$table_name = "k_slot";
$sql_common = " FROM {$table_name} s, g5_member m";
$sql_search = " WHERE s.mb_id = m.mb_id {$add_sql} ";
if (!$sst) {
    $sst = "mb_no";
    $sod = "DESC";
}
$sql_order = " ORDER BY $sst $sod ";
if ($stx != '') {
    $sql_search .= ' AND ' . get_sql_search($sca, $sfl, $stx, $sop);
}

$sql         = " SELECT COUNT(1) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row         = sql_fetch($sql);
$total_count = $row['cnt'];

$list_page_rows = 50;
$total_page     = ceil($total_count / $list_page_rows);  // 전체 페이지 계산
if ($page < 1) {
    $page = 1;
} // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $list_page_rows; // 시작 열을 구함

$top_number_org = $top_number = $total_count - ($page - 1) * $list_page_rows;

$sql    = " SELECT * {$sql_common} {$sql_search} {$sql_order}
LIMIT {$from_record}, {$list_page_rows} ";
$result = sql_query($sql);
?>
<div class="card-body table-responsive p-0">
    <table class="table custom_table table-hover table-bordered text-nowrap table-striped tiny_padding">
        <thead>
        <tr>
            <th>요청일</th>
            <th>빌헹일</th>
            <th>발행 해준 상위 유저</th>
            <th>발행 업체</th>
            <th>발행 대리점</th>
            <th>아이디</th>
            <th>이름</th>
            <th>슬롯</th>
            <th>수량</th>
            <th>시작일</th>
            <th>만료일</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>2023-02-09 / 23:54:00</td>
            <td>-</td>
            <td>manager2</td>
            <td>test(테스트업체)</td>
            <td>cemter4019(지앤에스)</td>
            <td>glossyelltest</td>
            <td>글로시엘테스트</td>
            <td>PC 무한타 T</td>
            <td>2</td>
            <td>2023-02-10</td>
            <td>2023-02-15</td>
        </tr>
        <tr>
            <td>2023-02-09 / 23:54:00</td>
            <td>-</td>
            <td>manager2</td>
            <td>test(테스트업체)</td>
            <td>cemter4019(지앤에스)</td>
            <td>glossyelltest</td>
            <td>글로시엘테스트</td>
            <td>PC 무한타 T</td>
            <td>2</td>
            <td>2023-02-10</td>
            <td>2023-02-15</td>
        </tr>
        </tbody>
    </table>
</div>

<!-- pagenation -->
<div class="row" style="padding:10px 10px 0 10px;">
    <div class="col-sm-12 col-md-5">
        <div class="dataTables_info" id="example2_info" role="status"
             aria-live="polite">
            총 <?php
            echo $total_count ?> 게시물 중 <?php
            echo $top_number_org - $result->num_rows + 1 ?>에서 <?php
            echo $top_number_org ?>까지
        </div>
    </div>
    <div class="col-sm-12 col-md-7 text-right">
        <?php
        echo get_paging(
            G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'],
            $page,
            $total_page,
            $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;page='
        ); ?>
    </div>
</div>
<!-- /.card-body -->