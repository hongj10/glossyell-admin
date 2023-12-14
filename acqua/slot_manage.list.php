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

if ($search_play == 'Y') {
    $add_sql .= " AND end >= '{$today}' ";
} elseif ($search_play == 'N') {
    $add_sql .= " AND end < '{$today}' ";
}

if ($search_keyword == 'Y') {
    $add_sql .= " AND (rank_keyword != '' OR work_keyword != '') ";
} elseif ($search_keyword == 'N') {
    $add_sql .= " AND (rank_keyword = '' AND work_keyword = '') ";
}

if ($search_first_id != '') {
    $add_sql .= " AND m.first_id = '{$search_first_id}' ";
}
if ($search_second_id != '') {
    $add_sql .= " AND m.second_id = '{$search_second_id}' ";
}
if ($search_mb_id != '') {
    $add_sql .= " AND s.mb_id = '{$search_mb_id}' ";
}
if ($slot_type_seq != '') {
    $add_sql .= " AND s.slot_type_seq = '{$slot_type_seq}' ";
}

if ($search_play == 'Y') {
    $add_sql .= " AND (end >= '".date('Y-m-d')."') ";
} elseif ($search_play == 'N') {
    $add_sql .= " AND (end < '".date('Y-m-d')."') ";
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
if($expired_slot=='Y'){
    $sql_search = " WHERE s.mb_id = m.mb_id AND m.mb_level <= {$member['mb_level']} {$add_sql} AND end >= '{$today}' AND end <= DATE_ADD('{$today}', INTERVAL 3 DAY)";
}else{
    $sql_search = " WHERE s.mb_id = m.mb_id AND m.mb_level <= {$member['mb_level']} {$add_sql} ";
}

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
    .hide {display: none}
</style>
<form name="form" id="list-form" action="" method="post">
<div class="card-body table-responsive p-0">
    <table class="table custom_table table-hover table-bordered text-nowrap table-striped tiny_padding" >
        <thead>
        <tr>
            <th>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="checkAll">
                    <label for="checkAll" class="custom-control-label"></label>
                </div>
            </th>
            <th>번호</th>
            <?php if ($member['mb_level'] == 10) {?>
            <th>총판</th>
            <?php }?>
            <?php if ($member['mb_level'] >= 8) {?>
            <th>대리점</th>
            <?php }?>
            <?php if ($member['mb_level'] >= 6) {?>
            <th>사용자</th>
            <?php }?>
            <th>수정</th>
            <th>타입</th>
            <th>타수</th>
            <th>시작일</th>
            <th>만료일</th>
            <th>잔여일</th>
            <?php if ($member['mb_level'] > 3) {?>
            <th>기간연장</th>
            <?php }?>
            <th>스토어명</th>
            <th>작업 검색어</th>
            <th style="max-width: 300px;">링크</th>
            <th>상품 유효 여부</th>
            <th>가격비교 MID</th>
            <th>컨텐츠 MID</th>
            <!-- <th>오늘 클릭</th>
            <th>어제 클릭</th> -->
            <th>메모</th>
            <?php if ($is_admin) {?>
            <th>삭제</th>
            <?php }?>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i = 0;$row = sql_fetch_array($result);$i++) {
            $slot_type = kget('slot_type', ['seq' => $row['slot_type_seq']]);
            ?>
            <tr data-seq="<?php echo $row['seq'] ?>" class="list-tr<?php echo (strpos($row['rank_keyword'], '실패') !== false) ? ' failed-row' : ''; ?>">
                <td>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input checkAll" type="checkbox" id="check<?php echo $row['seq']?>" name="seqs[]" value="<?php
                        echo $row['seq'] ?>">
                        <label for="check<?php echo $row['seq']?>" class="custom-control-label"></label>
                    </div>
                </td>
                <td><?php
                    echo $top_number-- ?>
                    <input type="hidden" name="method" value="updateData" />
                </td>
                <?php if ($member['mb_level'] == 10) {?>
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
                <?php }?>
                <?php if ($member['mb_level'] >= 8) {?>
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
                <?php }?>
                <?php if ($member['mb_level'] >= 6) {?>
                <td>
                    <?php
                    $third = get_member($row['mb_id']);
                    echo $third['mb_name'].'<br />('.$third['mb_id'].')';
                    ?>
                </td>
                <?php }?>
                <td>
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
                        <input type="text" style="width:40px" name="hit" class="ui-input" data-hit="<?php
                        echo $row['hit'] ?>" value="<?php
                        echo $row['hit'] ?>"/>
                    </div>
                </td>
                <td>
                    <div class="<?php echo $member['mb_level'] == 10 ? 'ui-default' : ''?>">
                        <?php
                        echo $row['start'] ?>
                    </div>
                    <div class="<?php echo $member['mb_level'] == 10 ? 'ui-modify' : 'hide'?>">
                        <input type="text" style="width:80px" name="start" class="start ui-input" value="<?php
                        echo $row['start'] ?>"/>
                    </div>
                </td>
                <td>
                    <div class="<?php echo $member['mb_level'] == 10 ? 'ui-default' : ''?>">
                        <?php
                        echo $row['end'] ?>
                    </div>
                    <div class="<?php echo $member['mb_level'] == 10 ? 'ui-modify' : 'hide'?>">
                        <input type="text" style="width:80px" name="end" class="end ui-input" value="<?php
                        echo $row['end'] ?>"/>
                    </div>
                </td>
                <td><?php
                    echo getDateDiff($row['start'], $row['end'])?></td>
                <?php if ($member['mb_level'] > 3) {?>
                <td>
                    <button type="button" class="btn btn-secondary btn-add-date">연장</button>
                </td>
                <?php }?>
                <td>
                    <div class="ui-default">
                        <?php
                        echo $row['store_name'] ?>
                    </div>
                    <div class="ui-modify">
                        <input type="text" name="store_name" class="ui-input" value="<?php
                        echo $row['store_name'] ?>"/>
                    </div>
                </td>
                <td>
                    <div class="ui-default">
                        <?php
                        echo $row['work_keyword'] ?>
                    </div>
                    <div class="ui-modify">
                        <input type="text" name="work_keyword" class="ui-input" value="<?php
                        echo $row['work_keyword'] ?>"/>
                    </div>
                </td>
                <td style="overflow-x: scroll; max-width: 200px;">
                    <div class="ui-default">
                        <?php
                        echo $row['item_name'] ?>
                    </div>
                    <div class="ui-modify">
                        <input type="text" name="item_name" class="ui-input" value="<?php
                        echo $row['item_name'] ?>"/>
                    </div>
                </td>
                <td>
                    <div class="ui-default">
                        <?php
                        echo $row['rank_keyword'] ?>
                    </div>
                    <div class="ui-modify">
                        <input type="text" name="rank_keyword" class="ui-input" value="<?php
                        echo $row['rank_keyword'] ?>"/>
                    </div>
                </td>
                <td>
                    <div class="ui-default">
                        <?php
                        echo $row['price_mid'] ?>
                    </div>
                    <div class="ui-modify">
                        <input type="text" name="price_mid" class="ui-input" value="<?php
                        echo $row['price_mid'] ?>"/>
                    </div>
                </td>
                <td>
                    <div class="ui-default">
                        <?php
                        echo $row['contents_mid'] ?>
                    </div>
                    <div class="ui-modify">
                        <input type="text" name="contents_mid" class="ui-input"  value="<?php
                        echo $row['contents_mid'] ?>"/>
                    </div>
                </td>
                <!-- <td><?php echo $row['COUNT']?></td>
                <td><?php echo $row['LAST_COUNT']?></td> -->
                <td>
                    <button type="button" class="btn btn-secondary btn-xs btn-modal"><i class="fas fa-edit"></i></button>
                    <div class="data-memo"><?php
                        echo $row['memo'] ?></div>
                </td>
                <?php if ($is_admin) {?>
                <td>
                    <button type="button" class="btn btn-secondary btn-xs btn-delete"><i
                                class="far fa-trash-alt"></i></button>
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

<style>
    .failed-row td {
    background-color: #ff0000b3; /* 빨간색 백그라운드 스타일 */
    color: white; /* 텍스트 색상을 흰색으로 변경 (선택사항) */
}
</style>