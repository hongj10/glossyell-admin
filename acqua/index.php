<?php
include_once('./_common.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if ($member['mb_level'] < 2) {
    header('Location:/login.php');
} else {
    echo $index_page;
    header('Location:'.$index_page);
}
exit;