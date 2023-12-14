<?php
// define('G5_MYSQL_HOST', 'localhost');
define('G5_MYSQL_HOST', '2024platinum.shop');
define('G5_MYSQL_USER', 'rammus2019');
define('G5_MYSQL_PASSWORD', 'p@ssw0rd');
define('G5_MYSQL_DB', 'rammus2019');
define('G5_MYSQL_SET_MODE', true);

function sql_connect($host, $user, $pass, $db=G5_MYSQL_DB)
{
    global $g5;

    if(function_exists('mysqli_connect')) {
        mysqli_report(MYSQLI_REPORT_OFF);
        $link = @mysqli_connect($host, $user, $pass, $db) or die('MySQL Host, User, Password, DB 정보에 오류가 있습니다.');

        // 연결 오류 발생 시 스크립트 종료
        if (mysqli_connect_errno()) {
            die('Connect Error: '.mysqli_connect_error());
        }
    } else {
        $link = mysql_connect($host, $user, $pass);
    }

    return $link;
}
$connect_db = sql_connect(G5_MYSQL_HOST, G5_MYSQL_USER, G5_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');
if ($connect_db) {
    echo '연결 성공';
}