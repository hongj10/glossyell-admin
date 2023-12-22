<?php
$menu_code = '1051';
include '_common.php';
call_user_func($method);

/**
 * 슬롯 타입 생성
 * @return void
 */
function insertData()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

    $check = cget('g5_member', ['mb_id' => $mb_name]);
    if ($check) {
        responseData(0, '이미 등록된 업체 입니다.');
    }

    if ($mb_level > $member['mb_level']) {
        $mb_level = $member['mb_level'];
    }
    $data = [
        'mb_id' => $mb_name,
        'mb_name' => $mb_name,
        'mb_level' => '8',
        'mb_password' => 'p@ssw0rd',
        'mb_datetime' => date('Y-m-d H:i:s'),
    ];
    if ($member['mb_level'] == 8) {
        $data['first_id'] = $member['mb_id'];
    } elseif ($member['mb_level'] == 6) {
        $data['first_id'] = $member['first_id'];
        $data['second_id'] = $member['mb_id'];
    }
    cadd('g5_member', $data);
    responseData(1, '생성 하였습니다.');
}
function updateData()
{
    @extract($_GET);
    @extract($_POST);

    $add_datas = getAddDatas([
                                 'first_id',
                                //  'second_id',
                             ]);

    cadd('g5_member', $add_datas, ['mb_id' => $seq]);
    responseData(1, '수정 하였습니다.');
}

function deleteData()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

    del('g5_member', ['mb_id' => $seq]);
    del('k_slot', ['mb_id' => $seq]);
    responseData(1, '삭제 하였습니다.');
}
// function updateMemo()
// {
//     global $member;
//     @extract($_GET);
//     @extract($_POST);

//     cadd('g5_member', ['mb_memo' => $mb_memo], ['mb_id' => $mb_id]);
//     responseData(1, '저장 하였습니다.');
// }
// function updatePassword()
// {
//     global $member;
//     @extract($_GET);
//     @extract($_POST);

//     cadd('g5_member', ['mb_password' => get_encrypt_string($mb_password)], ['mb_id' => $mb_id]);
//     responseData(1, '저장 하였습니다.');
// }
