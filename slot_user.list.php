<?php
$menu_code = '1060';
include '_common.php';
$add_sql = '';
if ($member['mb_level'] <= 2) {
    $add_sql .= " AND mb_id = '{$member['mb_id']}' ";
} elseif ($member['mb_level'] <= 6) {
    $add_sql .= " AND second_id = '{$member['mb_id']}' ";
} elseif ($member['mb_level'] <= 8) {
    $add_sql .= " AND first_id = '{$member['mb_id']}' ";
}
if ($keyword != '') {
    $add_sql .= " AND (
    mb_id LIKE '%{$keyword}%'
    OR mb_name LIKE '%{$keyword}%'
    ) ";
}

$table_name = "g5_member";
$sql_common = " FROM {$table_name}";
$sql_search = " WHERE mb_level != 8 {$add_sql} ";
if (!$sst) {
    $sst  = "mb_no";
    $sod = "DESC";
}
$sql_order = " ORDER BY $sst $sod ";
if ($stx != '')
    $sql_search .= ' AND ' . get_sql_search($sca, $sfl, $stx, $sop);

$sql = " SELECT COUNT(1) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$list_page_rows = 50;
$total_page  = ceil($total_count / $list_page_rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $list_page_rows; // 시작 열을 구함

$top_number_org = $top_number = $total_count - ($page - 1) * $list_page_rows;

$sql = " SELECT * {$sql_common} {$sql_search} {$sql_order}
LIMIT {$from_record}, {$list_page_rows} ";
$result = sql_query($sql);
$slot_type = kgetAll('slot_type', array(1=>1), "seq asc");
?>
<div class="card-body table-responsive p-0">
    <table class="table custom_table table-hover table-bordered text-nowrap table-striped tiny_padding">
        <thead>
        <tr>
            <th>번호</th>
            <th>권한</th>
            <!-- <th>업체</th> -->
            <!-- <th>대리점</th> -->
            <th>아이디</th>
            <th>이름</th>
            <th>등록일시</th>
            <th>로그인일시</th>
            <?php
            if ($slot_type) {
                foreach ($slot_type as $s) {
                    ?>
                    <th><?php echo $s['name'] ?></th>
                    <?php
                }
            }
            ?>
            <th>상세정보</th>
            <th>삭제</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $row=sql_fetch_array($result); $i++) {
            if ($row['mb_level'] == 10) {
                $label = '슈퍼관리자';
                $label_css = 'bg-black color-palette';
            } elseif ($row['mb_level'] >= 8) {
                $label = '업체';
                $label_css = 'bg-indigo color-palette';
            } elseif ($row['mb_level'] >= 6) {
                $label = '대리점';
                $label_css = 'bg-lightblue color-palette';
            } else {
                $label = '사용자';
                $label_css = 'bg-success color-palette';

            }
        ?>
        <tr data-seq="<?php echo $row['mb_id']?>" class="list-tr">
            <td><?php echo $top_number--?>
                <input type="hidden" name="method" value="updateData" />
                <input type="hidden" name="mb_memo" class="mb_memo" value="<?php echo $row['mb_memo']?>" />
            </td>
            <td><span class="badge <?php echo $label_css?>"><?php echo $label?></span></td>
            <!-- <td>
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
            </td> -->
            <td><?php echo $row['mb_id']?></td>
            <td><?php echo $row['mb_name']?></td>
            <td><?php echo str_replace(' ', '<br />', $row['mb_datetime'])?></td>
            <td><?php echo str_replace(' ', '<br />', $row['mb_today_login'])?></td>
            <?php
            if ($slot_type) {
                foreach ($slot_type as $s) {
                    $slot = get("SELECT COUNT(1) as cnt FROM k_slot WHERE mb_id = '{$row['mb_id']}' AND slot_type_seq = '{$s['seq']}'");
                    ?>
                    <td><?php echo $slot ? $slot['cnt'] : '0' ?></td>
                    <?php
                }
            }
            ?>
            <td>
                <button type="button" class="btn btn-primary btn-xs btn-detail">정보보기</button>
            </td>
            <td>
                <?php if ($row['mb_level'] < 10) {?>
                <button type="button" class="btn btn-secondary btn-xs btn-delete"><i
                            class="far fa-trash-alt"></i>유저삭제
                </button>
                <?php }?>
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
</div>

<!-- pagenation -->
<div class="row" style="padding:10px 10px 0 10px;">
    <div class="col-sm-12 col-md-5">
        <div class="dataTables_info" id="example2_info" role="status"
             aria-live="polite">
            총 <?php echo $total_count?> 게시물 중 <?php echo $top_number_org-$result->num_rows+1?>에서 <?php echo $top_number_org?>까지
        </div>
    </div>
    <div class="col-sm-12 col-md-7 text-right">
        <?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>
    </div>
</div>
<!-- /.card-body -->