<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
// 회원수는 $row['mb_cnt'];

//if (!$member['mb_id']) { echo G5_BBS_URL . '/logout.php'; }   // 실행하면 너무 많은 리디렉션 에러남

if ($member['mb_level'] > 9) {
    // add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
    add_stylesheet('<link rel="stylesheet" href="'.$connect_skin_url.'/style.css">', 0);
?>

<?php
    echo "Total: " . $row['total_cnt'];
}
?>