<?php

$menu_code = '1030';
include '_common.php';
call_user_func($method);

/**
 * 슬롯 추가
 * @return void
 */
function insertData()
{
    global $member;
    @extract($_GET);
    @extract($_POST);
    $add_datas = getAddDatas([
                                 'slot_type_seq',
                                 'work_keyword',
                                 'hit',
                                 'mb_id',
                                 'start',
                                 'end',
                             ]);
    // $add_datas['hit'] = 0;
    if ($count) {
        for ($i = 0;$i < $count;$i++) {
            kadd('slot', $add_datas);
        }
    }

    # 로그
    $slot_type = kget('slot_type', ['seq' => $slot_type_seq]);
    // addLog('add_slot', $mb_id, [
    //     'slot_type_seq'  => $slot_type_seq,
    //     'slot_type_name' => $slot_type['name'],
    //     'store_name'          => $store_name,
    //     'work_keyword'          => $work_keyword,
    //     'item_name'          => $item_name,
    //     'count'          => $count,
    //     'start'          => $start,
    //     'end'            => $end,
    // ]);

    responseData(1, '생성 하였습니다.');
}