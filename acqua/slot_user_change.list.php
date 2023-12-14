<?php

$menu_code = '1051';
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
$sql_search = " WHERE s.mb_id = m.mb_id AND m.mb_level <= {$member['mb_level']} {$add_sql} ";
if (!$sst) {
    $sst = "mb_no";
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
<form name="form" id="list-form" action="" method="post">
<div class="card-body table-responsive p-0">
    <table class="table custom_table table-hover table-bordered text-nowrap table-striped tiny_padding">
        <thead>
        <tr>
            <th>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="checkAll">
                    <label for="checkAll" class="custom-control-label"></label>
                </div>
            </th>
            <th>번호</th>
            <th>총판</th>
            <th>대리점</th>
            <th>사용자</th>
            <th>슬롯 타입</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i = 0;$row = sql_fetch_array($result);$i++) {
            $slot_type = kget('slot_type', ['seq' => $row['slot_type_seq']]);
            ?>
            <tr data-seq="<?php
            echo $row['seq'] ?>" class="list-tr">
                <td>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input checkAll" id="check<?php echo $row['seq']?>" type="checkbox" name="seq[]" value="<?php
                        echo $row['seq'] ?>">
                        <label for="check<?php echo $row['seq']?>" class="custom-control-label"></label>
                    </div>
                </td>
                <td><?php
                    echo $top_number-- ?>
                </td>
                <td>
                    <?php
                    if ($row['first_id']) {
                        $first = get_member($row['first_id']);
                        echo $first['mb_name'].'<br />('.$first['mb_id'].')';
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($row['second_id']) {
                        $second = get_member($row['second_id']);
                        echo $second['mb_name'].'<br />('.$second['mb_id'].')';
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    echo $row['mb_name'].'<br />('.$row['mb_id'].')';
                    ?>
                </td>
                <td><?php
                    echo $slot_type['name'] ?></td>
            </tr>
            <?php
        }
        if ($i == 0) {
            echo '<tr><td colspan="20" style="height: 100px">데이터가 없습니다.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>
</form>
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