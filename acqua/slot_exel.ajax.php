<?php

$menu_code = '9020';
include '_common.php';
call_user_func($method);

/*function insertData()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

    if ($mb_level > $member['mb_level']) {
        $mb_level = $member['mb_level'];
    }

    cadd('g5_member', [
       'mb_id' => $mb_id,
       'mb_name' => $mb_name,
       'mb_level' => $mb_level,
       'mb_password' => get_encrypt_string($mb_password),
       'mb_datetime' => date('Y-m-d H:i:s'),
    ]);
    responseData(1, '생성 하였습니다.');
}*/
function updateData()
{
    @extract($_GET);
    @extract($_POST);

    $add_datas = getAddDatas([
                                 'hit',
                                 'start',
                                 'end',
                                 'rank_keyword',
                                 'work_keyword',
                                 'item_name',
                                 'price_mid',
                                 'contents_mid',
                             ]);

    kadd('slot', $add_datas, ['seq' => $seq]);
    responseData(1, '수정 하였습니다.');
}

function deleteData()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

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
    $end = date("Y-m-d", $timestamp);

    kadd('slot', ['end' => $end], ['seq' => $seq]);
    responseData(1, '저장 하였습니다.');
}

