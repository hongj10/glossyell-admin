<?php
include 'simple_html_dom.php';

$menu_code = '1020';
include '_common.php';
call_user_func($method);

function updateData()
{
    @extract($_GET);
    @extract($_POST);

    $add_datas = getAddDatas([
        'hit',
        'start',
        'end',
        'work_keyword',
        'item_name',
    ]);

    kadd('slot', $add_datas, ['seq' => $seq]);

    responseData(1, '수정되었습니다.');
            
}



function deleteData()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

    # 로그
    $slot      = kget('slot', ['seq' => $seq]);
    $slot_type = kget('slot_type', ['seq' => $slot['slot_type_seq']]);
    // addLog('delete_slot', $slot['mb_id'], [
    //     'slot_seq'       => $slot['seq'],
    //     'slot_type_seq'  => $slot_type['seq'],
    //     'slot_type_name' => $slot_type['name'],
    //     'start'          => $slot['start'],
    //     'end'            => $slot['end'],
    // ]);

    kdel('slot', ['seq' => $seq]);
    responseData(1, '삭제 하였습니다.');
}

function updateMemo()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

    kadd('slot', ['memo' => $memo], ['seq' => $seq]);
    responseData(1, '저장 하였습니다.');
}

/**
 * 기간 연장
 * @return void
 */
function addPeriod()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

    $slot = kget('slot', ['seq' => $seq]);

    $timestamp = strtotime("+7 days", strtotime($slot['end']));
    $end       = date("Y-m-d", $timestamp);

    kadd('slot', ['end' => $end], ['seq' => $seq]);

    # 로그
    $slot_type = kget('slot_type', ['seq' => $slot['slot_type_seq']]);
    // addLog('add_period', $slot['mb_id'], [
    //     'slot_seq'       => $seq,
    //     'slot_type_seq'  => $slot_type['seq'],
    //     'slot_type_name' => $slot_type['name'],
    //     'start'          => $slot['start'],
    //     'end'            => $end,
    //     'last_end'       => $slot['end'],
    // ]);
    responseData(1, '연장 하였습니다.');
}


function updateList()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

    if ($seqs) {
        foreach ($seqs as $seq) {
            $slot = kget('slot', ['seq' => $seq]);

            $timestamp = strtotime("{$day_count} days", strtotime($slot['end']));
            $end       = date("Y-m-d", $timestamp);

            kadd('slot', ['end' => $end], ['seq' => $seq]);

            # 로그
            $slot_type = kget('slot_type', ['seq' => $slot['slot_type_seq']]);
            // addLog('add_period', $slot['mb_id'], [
            //     'slot_seq'       => $seq,
            //     'slot_type_seq'  => $slot_type['seq'],
            //     'slot_type_name' => $slot_type['name'],
            //     'start'          => $slot['start'],
            //     'end'            => $end,
            //     'last_end'       => $slot['end'],
            //     'store_name'     => $slot['store_name'],
            //     'item_name'      => $slot['item_name'],
            //     'work_keyword'   => $slot['work_keyword'],
            // ]);
        }
    }
    responseData(1, '연장처리 되었습니다.');

}
