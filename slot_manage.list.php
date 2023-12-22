<?php

$menu_code = '1020';
include '_common.php';

$add_sql = "";
if ($member['mb_level'] <= 2) {
    $add_sql .= " AND s.mb_id = '{$member['mb_id']}' ";
} elseif ($member['mb_level'] <= 6) {
    $add_sql .= " AND second_id = '{$member['mb_id']}' ";
} elseif ($member['mb_level'] <= 8) {
    $add_sql .= " AND first_id = '{$member['mb_id']}' ";
}

$today = date('Y-m-d');

if (isset($search_first_id)) {
if ($search_first_id != '') {
    $add_sql .= " AND m.first_id = '{$search_first_id}' ";
}
}
if (isset($search_second_id)) {
if ($search_second_id != '') {
    $add_sql .= " AND m.second_id = '{$search_second_id}' ";
}
}
if ($search_mb_id != '') {
    $add_sql .= " AND s.mb_id = '{$search_mb_id}' ";
}
if ($slot_type_seq != '') {
    $add_sql .= " AND s.slot_type_seq = '{$slot_type_seq}' ";
}
if (isset($search_play)) {
if ($search_play == 'Y') {
    $add_sql .= " AND (end >= '".date('Y-m-d')."') ";
} elseif ($search_play == 'N') {
    $add_sql .= " AND (end < '".date('Y-m-d')."') ";
}
}
if ($keyword != '') {
    $ids = cget("
        SELECT group_concat(mb_id) as ids FROM g5_member WHERE
            (
                mb_id like '%{$keyword}%'
                OR mb_name like '%{$keyword}%'
            )
    ");
    $add_ids_sql = "";
    if ($ids) {
        $ids = "'".str_replace(',', "','", $ids['ids'])."'";
        $add_ids_sql = "
        OR s.mb_id IN ({$ids})
        ";
    }

    $add_sql .= " AND (
    work_keyword LIKE '%{$keyword}%'
    OR item_name LIKE '%{$keyword}%'
    OR price_mid LIKE '%{$keyword}%'
    OR contents_mid LIKE '%{$keyword}%'
    {$add_ids_sql}
    ) ";
}

$expired_slot = isset($_GET['expired_slot']) ? $_GET['expired_slot'] : 'N';

$table_name = "k_slot";
$sql_common = " FROM {$table_name} s, g5_member m";
$today = date('Y-m-d');
// if($expired_slot=='Y'){
//     $sql_search = " WHERE s.mb_id = m.mb_id AND m.mb_level <= {$member['mb_level']} {$add_sql} AND end >= '{$today}' AND end <= DATE_ADD('{$today}', INTERVAL 3 DAY)";
// }else{
$sql_search = " WHERE s.mb_id = m.mb_id AND m.mb_level <= {$member['mb_level']} {$add_sql} ";
// }

if (!$sst) {
    $sst = "s.seq";
    $sod = "DESC";
}
$sql_order = " ORDER BY $sst $sod ";
if ($stx != '') {
    $sql_search .= ' AND ' . get_sql_search($sca, $sfl, $stx, $sop);
}

$sql         = " SELECT COUNT(1) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row         = sql_fetch($sql);
$total_count = $row['cnt'];

$list_page_rows = $item ?: 20;
$total_page     = ceil($total_count / $list_page_rows);  // 전체 페이지 계산
if ($page < 1) {
    $page = 1;
} // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $list_page_rows; // 시작 열을 구함

$top_number_org = $top_number = $total_count - ($page - 1) * $list_page_rows;

$sql    = " SELECT * {$sql_common} {$sql_search} {$sql_order}
LIMIT {$from_record}, {$list_page_rows} ";
$result = sql_query($sql);
//echo $sql;
?>
<style type="text/css">
    .hide {
        display: none;
    }
</style>
<form name="form" id="list-form" action="" method="post">
    <div class="card-body table-responsive p-0">
        <table
            class="table custom_table table-hover table-bordered text-nowrap table-striped tiny_padding">
            <thead>
                <tr>
                    <th>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="checkAll">
                            <label for="checkAll" class="custom-control-label"></label>
                        </div>
                    </th>
                    <th>번호</th>
                    <th>업체명</th>
                    <th>영업자</th>
                    <th>수정</th>
                    <th>슬롯타입</th>
                    <th>갯수</th>
                    <th>작업시작일</th>
                    <th>작업종료일</th>
                    <th>작업진행일</th>
                    <th>입금금액</th>
                    <th>리셀</th>
                    <th>수익</th>
                    <th>급여</th>
                    <th>입금자명</th>
                    <th>메모</th>
                    <th>삭제</th>
                </tr>
            </thead>
            <tbody>
                <?php
        for ($i = 0;$row = sql_fetch_array($result);$i++) {
            $slot_type = kget('slot_type', ['seq' => $row['slot_type_seq']]);
            ?>
                <tr
                    data-seq="<?php echo $row['seq'] ?>"
                    class="list-tr<?php echo (strpos($row['rank_keyword'], '실패') !== false) ? ' failed-row' : ''; ?>">
                    <td style="width: 40px">
                        <div class="custom-control custom-checkbox">
                            <input
                                class="custom-control-input checkAll"
                                type="checkbox"
                                id="check<?php echo $row['seq']?>"
                                name="seqs[]"
                                value="<?php
                        echo $row['seq'] ?>">
                            <label for="check<?php echo $row['seq']?>" class="custom-control-label"></label>
                        </div>
                    </td>
                    <td style="width: 40px"> <!-- 번호 --><?php 
                    echo $top_number-- ?>
                        <input type="hidden" name="method" value="updateData"/>
                    </td>
                    <td> <!-- 업체명 -->
                        <?php
                        echo $row['mb_name']
                    ?>
                    </td>
                    <td style="width: 80px"> <!-- 영업자 -->
                    <?php
                    if ($row['first_id']) {
                        $first = get_member($row['first_id']);
                        echo $first['mb_name'].'<br />('.$first['mb_id'].')';
                    } else {
                        echo '-';
                    }
                    ?>
                    </td>
                    <td style="width: 80px"> <!-- 수정 -->
                        <div class="ui-default">
                            <button type="button" class="btn btn-primary btn-modify-action">수정</button>
                        </div>
                        <div class="ui-modify">
                            <button type="button" class="btn btn-success btn-modify">확인</button>
                            <button type="button" class="btn btn-danger btn-cancel">취소</button>
                        </div>
                    </td>
                    <td><?php
                    echo $slot_type['name'] ?></td>
                    <td>
                        <div class="ui-default">
                            <?php
                        echo $row['hit'] ?>
                        </div>
                        <div class="ui-modify">
                            <input
                                type="text"
                                style="width:40px"
                                name="hit"
                                class="ui-input"
                                data-hit="<?php
                        echo $row['hit'] ?>"
                                value="<?php
                        echo $row['hit'] ?>"/>
                        </div>
                    </td>
                    <td style="width: 80px"> <!-- 작업시작일 -->
                        <div class="<?php echo $member['mb_level'] == 10 ? 'ui-default' : ''?>">
                            <?php
                        echo $row['start'] ?>
                        </div>
                        <div class="<?php echo $member['mb_level'] == 10 ? 'ui-modify' : 'hide'?>">
                            <input
                                type="text"
                                style="width:80px"
                                name="start"
                                class="start ui-input"
                                value="<?php
                        echo $row['start'] ?>"/>
                        </div>
                    </td>
                    <td style="width: 80px"> <!-- 작업종료일 -->
                        <div class="<?php echo $member['mb_level'] == 10 ? 'ui-default' : ''?>">
                            <?php
                        echo $row['end'] ?>
                        </div>
                        <div class="<?php echo $member['mb_level'] == 10 ? 'ui-modify' : 'hide'?>">
                            <input
                                type="text"
                                style="width:80px"
                                name="end"
                                class="end ui-input"
                                value="<?php
                        echo $row['end'] ?>"/>
                        </div>
                    </td>
                    <td style="width: 60px"> <!-- 작업진행일 -->
                        <?php
                            $startTimestamp = strtotime($row['start']);
                            $endTimestamp = strtotime($row['end']);
                            $differenceInSeconds = $endTimestamp - $startTimestamp;
                            $differenceInDays = $differenceInSeconds / (60 * 60 * 24) + 1; // 초를 일로 변환
                            echo $differenceInDays
                        ?>
                    </td>
                    <td style="width: 60px"> <!-- 입금금액 -->
                    <div class="ui-default">
                            <?php
                        echo $row['work_keyword'] ?>
                        </div>
                        <div class="ui-modify">
                            <input
                                type="text"
                                style="width:40px"
                                name="work_keyword"
                                class="ui-input"
                                data-hit="<?php
                        echo $row['work_keyword'] ?>"
                                value="<?php
                        echo $row['work_keyword'] ?>"/>
                        </div>
                    </td>
                    <td style="width: 60px"> <!-- 리셀 -->
                        <?php
                        $startTimestamp = strtotime($row['start']);
                        $endTimestamp = strtotime($row['end']);
                        $differenceInSeconds = $endTimestamp - $startTimestamp;
                        $differenceInDays = $differenceInSeconds / (60 * 60 * 24) + 1; // 초를 일로 변환
                        echo (float)$slot_type['is_duplicated'] * (float)$row['hit'] * $differenceInDays
                        ?>
                    </td>
                    <td style="width: 60px"> <!-- 수익 -->
                        <?php 
                            $startTimestamp = strtotime($row['start']);
                            $endTimestamp = strtotime($row['end']);
                            $differenceInSeconds = $endTimestamp - $startTimestamp;
                            $differenceInDays = $differenceInSeconds / (60 * 60 * 24) + 1; // 초를 일로 변환
                    echo (float)$row['work_keyword'] - ((float)$slot_type['is_duplicated'] * $differenceInDays *(float)$row['hit'])
                    ?>
                    </td>
                    <td style="width: 80px"> <!-- 급여 -->
                        <?php 
                    // echo number_format((float)$row['work_keyword'] - ((float)$slot_type['is_duplicated'] * (float)$row['hit']) / 2)
                    $startTimestamp = strtotime($row['start']);
                            $endTimestamp = strtotime($row['end']);
                            $differenceInSeconds = $endTimestamp - $startTimestamp;
                            $differenceInDays = $differenceInSeconds / (60 * 60 * 24) + 1; // 초를 일로 변환
                    echo number_format(((float)$row['work_keyword'] - ((float)$slot_type['is_duplicated'] * $differenceInDays * (float)$row['hit'])) / 2)
                    ?>
                    </td>
                    <td> 
                        <div class="ui-default">
                            <?php // 입금자명
                        echo $row['item_name'] ?>
                        </div>
                        <div class="ui-modify">
                            <input
                                type="text"
                                name="item_name"
                                class="ui-input"
                                value="<?php
                        echo $row['item_name'] ?>"/>
                        </div>
                    </td>
                    <td style="width: 40px">
                        <button type="button" class="btn btn-secondary btn-xs btn-modal">
                            <i class="fas fa-edit"></i>
                        </button>
                        <div class="data-memo"><?php
                        echo $row['memo'] ?></div>
                    </td>
                    <?php if ($is_admin) {?>
                    <td style="width: 40px">
                        <button type="button" class="btn btn-secondary btn-xs btn-delete">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </td>
                    <?php }?>
                </tr>
                <?php
        }
        if ($i == 0) {
            echo '<tr><td colspan="23" style="height: 100px">데이터가 없습니다.</td></tr>';
        }
        ?>
            </tbody>
        </table>
    </div>
</form>

<!-- pagenation -->
<div class="row" style="padding:10px 10px 0 10px;">
    <div class="col-sm-12 col-md-5">
        <div
            class="dataTables_info"
            id="example2_info"
            role="status"
            aria-live="polite">
            총
            <?php
            echo $total_count ?>
            게시물 중
            <?php
            echo $top_number_org - $result->num_rows + 1 ?>에서
            <?php
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

<style>
    .failed-row td {
        background-color: #ff0000b3;
        color: white;
    }
</style>