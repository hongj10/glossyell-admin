<?php

$menu_code = '9020';
include '_common.php';

if ($member['mb_level'] <= 2) {
    $add_sql = " AND s.mb_id = '{$member['mb_id']}' ";
} elseif ($member['mb_level'] <= 6) {
    $add_sql = " AND second_id = '{$member['mb_id']}' ";
} elseif ($member['mb_level'] <= 8) {
    $add_sql = " AND first_id = '{$member['mb_id']}' ";
}

$table_name = "g5_write_excel";
$sql_common = " FROM {$table_name} s, g5_member m";
$sql_search = " WHERE s.mb_id = m.mb_id AND m.mb_level <= {$member['mb_level']} {$add_sql} ";
if (!$sst) {
    $sst = "wr_id";
    $sod = "DESC";
}
$sql_order = " ORDER BY $sst $sod ";
if ($search_mb_id != '') {
    $sql_search .= ' AND ' . get_sql_search('', 'm.mb_id', $search_mb_id);
}
if ($slot_type_seq != '') {
    $sql_search .= ' AND ' . get_sql_search('', 's.slot_type_seq', $slot_type_seq);
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
            <th>처리 일시</th>
            <th>처리자</th>
            <th>업로드 된 파일</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i = 0;$row = sql_fetch_array($result);$i++) {
        ?>
        <tr>
            <td><?php echo $row['wr_datetime']?></td>
            <td><?php echo $row['wr_name']?></td>
            <td>
                <a href="<?php echo G5_BBS_URL."/download.php?bo_table=excel&wr_id={$row['wr_id']}&no=0"?>" type="button" class="btn btn-dark btn-xs"><i class="far fa-file-excel"></i> 파일</a>
            </td>
        </tr>
        <?php
        }
        if ($i == 0) {
            echo '<tr><td colspan="20" style="height: 100px">데이터가 없습니다.</td></tr>';
        }
        ?>
        </tbody>
    </table>
    <div class="callout callout-danger" style="width:95%; margin:20px auto">
        <h5>안내사항</h5>
        <ul>
            <li><a href="/sample.xlsx">샘플 파일 엑셀 다운로드</a></li>
            <li>엑셀은 반드시 Excel 통합문서 (.xlsx)로 저장 후 업로드해주세요.</li>
        </ul>
    </div>
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