<?php
$menu_code = '1010';
include '_common.php';
call_user_func($method);

/**
 * 슬롯 타입 생성
 * @return void
 */
function insertSlotType()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

    kadd('slot_type', [
       'name' => $name
    ]);
    responseData(1, '생성 하였습니다.');
}
function updateData()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

    kadd('slot_type', [
       'name' => $name,
    //    'hit' => $hit,
       'is_duplicated' => $is_duplicated,
    //    'is_tested' => $is_tested,
    //    'test_date' => $test_date,
    ], ['seq' => $seq]);
    
    # 동일 타입의 슬롯에 타수 전체 변경
    // kadd('slot', [
    //     'hit' => $hit,
    // ], ['slot_type_seq' => $seq]);
    responseData(1, '수정 하였습니다.');
}
function deleteSlotType()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

    kdel('slot_type', ['seq' => $seq]);
    responseData(1, '삭제 하였습니다.');
}
