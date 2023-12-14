<?php

$menu_code = '9020';
include '_common.php';
call_user_func($method);
function insertData()
{
    global $member;
    global $g5;
    @extract($_GET);
    @extract($_POST);

    $bo_table = 'excel';
    $wr_subject = $wr_content = date('Y-m-d H:i:s') . '엑셀 등록';
    $mb_id = $member['mb_id'];
    $wr_name = $member['mb_name'];

    $write_table = 'g5_write_' . $bo_table;
    $wr_num      = get_next_num($write_table);


    $sql = " insert into $write_table
                         set wr_num = '$wr_num',
                              wr_reply = '',
                              wr_comment = 0,
                              ca_name = '{$ca_name}',
                              wr_option = 'html1',
                              wr_subject = '$wr_subject',
                              wr_content = '$wr_content',
                              wr_link1 = '$wr_link1',
                              wr_link2 = '$wr_link2',
                              wr_link1_hit = 0,
                              wr_link2_hit = 0,
                              wr_hit = 0,
                              wr_good = 0,
                              wr_nogood = 0,
                              mb_id = '$mb_id',
                              wr_password = '$mb_password',
                              wr_name = '$wr_name',
                              wr_email = '$wr_email',
                              wr_homepage = '$wr_homepage',
                              wr_datetime = '" . G5_TIME_YMDHIS . "',
                              wr_last = '" . G5_TIME_YMDHIS . "',
                              wr_ip = '{$_SERVER['REMOTE_ADDR']}',
                              wr_1 = '$wr_1',
                              wr_2 = '$wr_2',
                              wr_3 = '$wr_3',
                              wr_4 = '$wr_4',
                              wr_5 = '$wr_5',
                              wr_6 = '$wr_6',
                              wr_7 = '$wr_7',
                              wr_8 = '$wr_8',
                              wr_9 = '$wr_9',
                              wr_10 = '$wr_10'
                              ";
    sql_query($sql);

    $wr_id = sql_insert_id();

    // 부모 아이디에 UPDATE
    sql_query(" update $write_table set wr_parent = '$wr_id'where wr_id = '$wr_id'");

    # 파일 업로드
    $file_upload_msg = '';
    $upload = array();
    $chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
    for ($i=0; $i<count($_FILES['bf_file']['name']); $i++) {
        $upload[$i]['file']     = '';
        $upload[$i]['source']   = '';
        $upload[$i]['filesize'] = 0;
        $upload[$i]['image']    = array();
        $upload[$i]['image'][0] = '';
        $upload[$i]['image'][1] = '';
        $upload[$i]['image'][2] = '';

        $tmp_file  = $_FILES['bf_file']['tmp_name'][$i];
        $filesize  = $_FILES['bf_file']['size'][$i];
        $filename  = $_FILES['bf_file']['name'][$i];
        $filename  = get_safe_filename($filename);

        // 서버에 설정된 값보다 큰파일을 업로드 한다면
        if ($filename) {
            if ($_FILES['bf_file']['error'][$i] == 1) {
                $file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정된 값보다 크므로 업로드 할 수 없습니다.\\n';
                continue;
            }
            else if ($_FILES['bf_file']['error'][$i] != 0) {
                $file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
                continue;
            }
        }
        if (is_uploaded_file($tmp_file)) {
            $timg = @getimagesize($tmp_file);
            // image type
            if ( preg_match("/\.({$config['cf_image_extension']})$/i", $filename) ||
                preg_match("/\.({$config['cf_flash_extension']})$/i", $filename) ) {
                if ($timg['2'] < 1 || $timg['2'] > 16)
                    continue;
            }
            //=================================================================

            $upload[$i]['image'] = $timg;

            // 존재하는 파일이 있다면 삭제합니다.
            $row = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '1' ");
            @unlink(G5_DATA_PATH.'/file/'.$bo_table.'/'.$row['bf_file']);
            // 이미지파일이면 썸네일삭제
            if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
                delete_board_thumbnail($bo_table, $row['bf_file']);
            }

            // 프로그램 원래 파일명
            $upload[$i]['source'] = $filename;
            $upload[$i]['filesize'] = $filesize;

            // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
            $filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

            shuffle($chars_array);
            $shuffle = implode('', $chars_array);

            // 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
            $upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $filename)));

            $dest_file = G5_DATA_PATH.'/file/'.$bo_table.'/'.$upload[$i]['file'];

            // 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
            $error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['bf_file']['error'][$i]);

            // 올라간 파일의 퍼미션을 변경합니다.
            chmod($dest_file, G5_FILE_PERMISSION);
        }




        $file = $dest_file;

        include_once(G5_LIB_PATH.'/PHPExcel/IOFactory.php');

        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $sheet = $objPHPExcel->getSheet(0);

        $num_rows = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $dup_it_id = array();
        $fail_it_id = array();
        $dup_count = 0;
        $total_count = 0;
        $fail_count = 0;
        $succ_count = 0;

        for ($ii = 2; $ii <= $num_rows; $ii++) {
            $total_count++;

            $j = 0;

            $rowData = $sheet->rangeToArray(
                'A' . $ii . ':' . $highestColumn . $ii,
                null,
                true,
                false
            );


            # 슬롯 추가
            kadd('slot', [
                'mb_id' => addslashes($rowData[0][$j++]),
                'slot_type_seq' => $slot_type_seq = addslashes($rowData[0][$j++]),
                'hit' => addslashes($rowData[0][$j++]),
                'start' => addslashes($rowData[0][$j++]),
                'end' => addslashes($rowData[0][$j++]),
                'rank_keyword' => addslashes($rowData[0][$j++]),
                'work_keyword' => addslashes($rowData[0][$j++]),
                'item_name' => addslashes($rowData[0][$j++]),
                'price_mid' => addslashes($rowData[0][$j++]),
                'contents_mid' => addslashes($rowData[0][$j++]),
                'memo' => addslashes($rowData[0][$j++]),
            ]);

            # 로그
            $slot_type = kget('slot_type', ['seq' => $slot_type_seq]);
            // addLog('add_slot', $mb_id, [
            //     'slot_type_seq'  => $slot_type_seq,
            //     'slot_type_name' => $slot_type['name'],
            //     'count'          => 1,
            //     'start'          => $start,
            //     'end'            => $end,
            //     'store_name'          => $store_name,
            //     'work_keyword'          => $work_keyword,
            //     'item_name'          => $item_name,
            // ]);
        }
    }
    for ($i=0; $i<count($upload); $i++)
    {
        if (!get_magic_quotes_gpc()) {
            $upload[$i]['source'] = addslashes($upload[$i]['source']);
        }

        $row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");
        if ($row['cnt'])
        {
            // 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
            // 그렇지 않다면 내용만 업데이트 합니다.
            if ($upload[$i]['del_check'] || $upload[$i]['file'])
            {
                $sql = " update {$g5['board_file_table']}
                        set bf_source = '{$upload[$i]['source']}',
                             bf_file = '{$upload[$i]['file']}',
                             bf_content = '{$bf_content[$i]}',
                             bf_filesize = '{$upload[$i]['filesize']}',
                             bf_width = '{$upload[$i]['image']['0']}',
                             bf_height = '{$upload[$i]['image']['1']}',
                             bf_type = '{$upload[$i]['image']['2']}',
                             bf_datetime = '".G5_TIME_YMDHIS."'
                      where bo_table = '{$bo_table}'
                                and wr_id = '{$wr_id}'
                                and bf_no = '{$i}' ";
                sql_query($sql);
            }
            else
            {
                $sql = " update {$g5['board_file_table']}
                        set bf_content = '{$bf_content[$i]}'
                        where bo_table = '{$bo_table}'
                                  and wr_id = '{$wr_id}'
                                  and bf_no = '{$i}' ";
                sql_query($sql);
            }
        }
        else
        {
            $sql = " insert into {$g5['board_file_table']}
                    set bo_table = '{$bo_table}',
                         wr_id = '{$wr_id}',
                         bf_no = '{$i}',
                         bf_source = '{$upload[$i]['source']}',
                         bf_file = '{$upload[$i]['file']}',
                         bf_content = '{$bf_content[$i]}',
                         bf_download = 0,
                         bf_filesize = '{$upload[$i]['filesize']}',
                         bf_width = '{$upload[$i]['image']['0']}',
                         bf_height = '{$upload[$i]['image']['1']}',
                         bf_type = '{$upload[$i]['image']['2']}',
                         bf_datetime = '".G5_TIME_YMDHIS."' ";
            sql_query($sql);
        }
    }

    // 파일의 개수를 게시물에 업데이트 한다.
    $row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
    sql_query(" update {$write_table} set wr_file = '{$row['cnt']}' where wr_id = '{$wr_id}' ");




    responseData(1, '생성 하였습니다.');
}

