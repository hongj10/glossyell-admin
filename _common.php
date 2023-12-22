<?php

include_once('./common.php');


function getUsersSelect($name, $class, $style, $mb_level, $mb_id = '', $fist_id = '')
{
    global $member;
    $add_sql = '';
    if ($member['mb_level'] <= 2) {
        $add_sql .= " AND mb_id = '{$member['mb_id']}' ";
    } elseif ($member['mb_level'] <= 6) {
        $add_sql .= " AND second_id = '{$member['mb_id']}' ";
    } elseif ($member['mb_level'] <= 8) {
        $add_sql .= " AND first_id = '{$member['mb_id']}' ";
    }
    if ($mb_level == '6') {
        if ($member['mb_level'] == 8) {
            $fist_id = $member['mb_id'];
        }
        if ($fist_id) {
            $add_sql .= " AND first_id = '{$fist_id}' ";
        }
    }
    $users = cgetAll(
        "
        SELECT mb_id, mb_name
        FROM g5_member
        WHERE mb_level = {$mb_level} {$add_sql}
    "
    );
    if ($mb_level == 2) {
        $label = '영업자 선택';
    } elseif ($mb_level == 8) {
        $label = '업체 선택';
    } elseif ($mb_level == 6) {
        $label = '관리자 선택';
    } else {
        $label = '선택';
    }
    $html  = '<select name="' . $name . '" class="' . $class . '" style="' . $style . '">';
    $html  .= '<option value="">'.$label.'</option>';
    if ($users) {
        foreach ($users as $user) {
            if ($user['mb_id'] == $mb_id) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $html .= '<option value="' . $user['mb_id'] . '" ' . $selected . '>' . $user['mb_name'] . '</option>';
        }
    }
    $html .= '</select>';

    return $html;
}

function addLog($type, $target_id, $data)
{
    global $member;
    $target = get_member($target_id);

    $target_first = $target_second = $first = $second = '';
    if ($target['first_id']) {
        $target_first = get_member($target['first_id']);
    }
    if ($target['second_id']) {
        $target_second = get_member($target['second_id']);
    }
    if ($member['first_id']) {
        $first = get_member($member['first_id']);
    }
    if ($member['second_id']) {
        $second = get_member($member['second_id']);
    }
    $mergeData = array_merge([
                                 'mb_id'              => $member['mb_id'],
                                 'mb_name'            => $member['mb_name'],
                                 'first_id'           => $first['mb_id'] ?? '',
                                 'first_name'         => $first['mb_name'] ?? '',
                                 'second_id'          => $second['mb_id'] ?? '',
                                 'second_name'        => $second['mb_name'] ?? '',
                                 'target_id'          => $target['mb_id'],
                                 'target_name'        => $target['mb_name'],
                                 'target_first_id'    => $target_first['mb_id'] ?? '',
                                 'target_first_name'  => $target_first['mb_name'] ?? '',
                                 'target_second_id'   => $target_second['mb_id'] ?? '',
                                 'target_second_name' => $target_second['mb_name'] ?? '',
                                 'type'               => $type,
                                //  'store_name'         => $member['mb_id'],
                             ],
                             $data);
    kadd('log', $mergeData);
}

$kmenu['10']['1005'] = ['대시보드', '/dashboard.php', 'fa-tachometer-alt'];
$kmenu['10']['1010'] = ['슬롯타입생성', '/slot_maketype.php', 'fa-external-link-alt'];
$kmenu['10']['1020'] = ['계약관리', '/slot_manage.php', 'fa-th'];
$kmenu['10']['1030'] = ['계약단일추가', '/slot_additional.php', 'fa-plus-square'];
$kmenu['10']['1051'] = ['업체 관리', '/slot_store.php', 'fa-shopping-bag'];
$kmenu['10']['1060'] = ['사용자 관리', '/slot_user.php', 'fa-users'];
$kmenu['10']['9010'] = ['정산표', '/slot_log.php', 'fa-desktop'];

$kmenu['6']['1005'] = ['대시보드', '/dashboard.php', 'fa-tachometer-alt'];
// $kmenu['6']['1010'] = ['슬롯타입생성', '/slot_maketype.php', 'fa-external-link-alt'];
$kmenu['6']['1020'] = ['계약관리', '/slot_manage.php', 'fa-th'];
$kmenu['6']['1030'] = ['계약단일추가', '/slot_additional.php', 'fa-plus-square'];
$kmenu['6']['1051'] = ['업체 관리', '/slot_store.php', 'fa-shopping-bag'];
$kmenu['6']['1060'] = ['사용자 관리', '/slot_user.php', 'fa-users'];
$kmenu['6']['9010'] = ['정산표', '/slot_log.php', 'fa-desktop'];

// $kmenu['2']['1005'] = ['대시보드', '/dashboard.php', 'fa-tachometer-alt'];
// $kmenu['2']['1010'] = ['슬롯타입생성', '/slot_maketype.php', 'fa-external-link-alt'];
$kmenu['2']['1020'] = ['계약관리', '/slot_manage.php', 'fa-th'];
// $kmenu['2']['1030'] = ['계약단일추가', '/slot_additional.php', 'fa-plus-square'];
$kmenu['2']['1051'] = ['업체 관리', '/slot_store.php', 'fa-shopping-bag'];
// $kmenu['2']['1060'] = ['사용자 관리', '/slot_user.php', 'fa-users'];
$kmenu['2']['9010'] = ['정산표', '/slot_log.php', 'fa-desktop'];

if ($menu_code) {
    if (!isset($kmenu[$member['mb_level']][$menu_code])) {
        if ($member['mb_level'] >= 2) {
            die('접근 하실 수 없습니다.');
        } else {
            header('Location:/login.php?url=' . urlencode($_SERVER['SCRIPT_NAME']));
            exit;
        }
    }
}
if ($member['mb_level'] >= 2) {
    $snb         = $kmenu[$member['mb_level']];
    $g5['title'] = $kmenu[$member['mb_level']][$menu_code][0];
    if ($member['mb_level'] == 10) {
        $index_page = '/dashboard.php';
    } else {
        $index_page  = $kmenu[$member['mb_level']]['1020']['1'];
    }
} else {
    header('Location:/login.php?url=' . urlencode($_SERVER['SCRIPT_NAME']));
    exit;
}