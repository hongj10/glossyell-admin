<?php

$menu_code = '1050';
include '_common.php';
call_user_func($method);

function insertData()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

    responseData(1, '생성 하였습니다.');
}
function updateData()
{
    @extract($_GET);
    @extract($_POST);

    $add_datas = getAddDatas([
                                 'first_id',
                                 'second_id',
                             ]);

    cadd('g5_member', $add_datas, ['mb_id' => $seq]);
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

function getSecondSelect()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

    echo getUsersSelect('second_id', 'form-control select2 inline-select',
                        'width:200px', '6', '', $first_id);
    exit;
}

