<?php
$menu_code = '9010';
include '_common.php';
if ($isExcel) {
    $filename = 'log-'.date('YmdHis').'.xls';
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=".$filename);
    header("Content-Description: PHP4 Generated Data");
}
$add_sql = '';
if ($member['mb_level'] <= 2) {
    $add_sql = " AND (mb_id = '{$member['mb_id']}' OR target_id = '{$member['mb_id']}') ";
} elseif ($member['mb_level'] <= 6) {
    $add_sql = " AND (mb_id = '{$member['mb_id']}' OR target_id = '{$member['mb_id']}') ";
} elseif ($member['mb_level'] <= 8) {
    $add_sql = " AND (mb_id = '{$member['mb_id']}' OR target_id = '{$member['mb_id']}') ";
}
if (isset($search_first_id)) {
if ($search_first_id != '') {
    $add_sql .= " AND target_first_id = '{$search_first_id}' ";
}
}
if (isset($search_second_id)) {
if ($search_second_id != '') {
    $add_sql .= " AND target_second_id = '{$search_second_id}' ";
}
}

if ($start) {
    $add_sql .= " AND start > '{$start}' ";
}
if ($end) {
    $add_sql .= " AND start < '{$end}' ";
}

if ($target_id) {
    $add_sql .= " AND target_id = '{$target_id}' ";
}

$table_name = "k_log";
$sql_common = " FROM {$table_name}";
$sql_search = " WHERE type = '{$type}' {$add_sql} ";
if (!$sst) {
    $sst = "seq";
    $sod = "DESC";
}
$sql_order = " ORDER BY $sst $sod ";
if ($stx != '') {
    $sql_search .= ' AND ' . get_sql_search($sca, $sfl, $stx, $sop);
}

$sql         = " SELECT COUNT(1) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row         = sql_fetch($sql);
$total_count = $row['cnt'];

if ($isExcel) {
    $list_page_rows = 10000;
} else {
    $list_page_rows = $item ?: 20;
}

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
    <?php
    if ($type == 'add_slot') {
    ?>
    <table class="table custom_table table-hover table-bordered text-nowrap table-striped tiny_padding">
        <thead>
        <tr>
            <th>키워드(10자이내)</th>
            <th>수량</th>
            <th>상품링크</th>
            <th>시작일</th>
            <th>종료일</th>
            <th>스토어명</th>
            <!-- <th>발급일시</th>
            <th>발급자</th>
            <th>업체</th>
            <th>대리점</th>
            <th>아이디</th>
            <th>이름</th>
            <th>슬롯</th>
            <th>수량</th>
            <th>시작일</th>
            <th>만료일</th> -->
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i = 0;$row = sql_fetch_array($result);$i++) {
        ?>
        <!-- <tr>
            <td><?php echo $row['created']?></td>
            <td><?php echo $row['mb_name']?>(<?php echo $row['mb_id']?>)</td>
            <td>
                <?php
                if ($row['target_first_id']) {
                    echo $row['target_first_name'].'('.$row['target_first_id'].')';
                } else {
                    echo '-';
                }
                ?>
            </td>
            <td>
                <?php
                if ($row['target_second_id']) {
                    echo $row['target_second_name'].'('.$row['target_second_id'].')';
                } else {
                    echo '-';
                }
                ?>
            </td>
            <td><?php echo $row['target_id']?></td>
            <td><?php echo $row['target_name']?></td>
            <td><?php echo $row['slot_type_name']?></td>
            <td><?php echo $row['count']?></td>
            <td><?php echo $row['start']?></td>
            <td><?php echo $row['end']?></td>
        </tr> -->
        <tr>
            <td><?php echo $row['work_keyword']?></td>
            <td><?php echo $row['count']?></td>
            <td><?php echo $row['item_name']?></td>
            <td><?php echo $row['start']?></td>
            <td><?php echo $row['end']?></td>
            <td><?php echo $row['store_name']?></td>
        </tr>
        <?php
        }
        if ($i == 0) {
            echo '<tr><td colspan="20" style="height: 100px">데이터가 없습니다.</td></tr>';
        }
        ?>
        </tbody>
    </table>
    <?php
    } elseif ($type == 'delete_slot') {
        ?>
        <table class="table custom_table table-hover table-bordered text-nowrap table-striped tiny_padding">
            <thead>
            <tr>
                <th>삭제일시</th>
                <th>삭제한 사용자</th>
                <th>슬롯 ID</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for ($i = 0;$row = sql_fetch_array($result);$i++) {
                ?>
                <tr>
                    <td><?php echo $row['created']?></td>
                    <td><?php echo $row['mb_name']?>(<?php echo $row['mb_id']?>)</td>
                    <td><?php echo $row['slot_seq']?></td>
                </tr>
                <?php
            }
            if ($i == 0) {
                echo '<tr><td colspan="20" style="height: 100px">데이터가 없습니다.</td></tr>';
            }
            ?>
            </tbody>
        </table>
        <?php
    } elseif ($type == 'add_period') {
        ?>
        <table class="table custom_table table-hover table-bordered text-nowrap table-striped tiny_padding">
            <thead>
            <tr>
                <th>연장 일시</th>
                <th>슬롯 ID</th>
                <th>슬롯 TYPE</th>
                <th>연장 실행자</th>
                <th>슬롯 사용자</th>
                <th>시작일</th>
                <th>연장전 만료일</th>
                <th>연장후 만료일</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for ($i = 0;$row = sql_fetch_array($result);$i++) {
                ?>
                <tr>
                    <td><?php echo $row['created']?></td>
                    <td><?php echo $row['slot_seq']?></td>
                    <td><?php echo $row['slot_type_name']?></td>
                    <td><?php echo $row['mb_name']?>(<?php echo $row['mb_id']?>)</td>
                    <td><?php echo $row['target_name'].'('.$row['target_id'].')'?></td>
                    <td><?php echo $row['start']?></td>
                    <td><?php echo $row['last_end']?></td>
                    <td><?php echo $row['end']?></td>
                </tr>
                <?php
            }
            if ($i == 0) {
                echo '<tr><td colspan="20" style="height: 100px">데이터가 없습니다.</td></tr>';
            }
            ?>
            </tbody>
        </table>
        <?php
    }
    ?>
</div>
<?php
if (!$isExcel) {
?>
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
<?php
}
?>