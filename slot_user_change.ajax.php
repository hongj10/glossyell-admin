<?php

$menu_code = '1051';
include '_common.php';
call_user_func($method);

function insertData()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

}
function updateData()
{
    @extract($_GET);
    @extract($_POST);

    $add_datas = getAddDatas([
                                 'hit',
                                 'start',
                                 'end',
                                 'rank_keyword',
                                 'store_name',
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

function updateList()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

    if ($seq) {
        foreach ($seq as $s) {
            kadd('slot', ['mb_id' => $change_mb_id], ['seq' => $s]);
        }
    }
    responseData(1, '변경 하였습니다.');
}



