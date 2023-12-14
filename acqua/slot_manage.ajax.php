<?php
include 'simple_html_dom.php';

$menu_code = '1020';
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

    if (empty($_POST['item_name']) || strpos($_POST['item_name'], 'search.shopping.naver') !== false) {
                // 나머지 작업 처리 및 응답
                $add_datas = getAddDatas([
                    'hit',
                    'start',
                    'end',
                    // 'rank_keyword',
                    'store_name',
                    'work_keyword',
                    'item_name',
                    'price_mid',
                    'contents_mid',
                ]);
        
                kadd('slot', $add_datas, ['seq' => $seq]);

                responseData(1, '수정 하였습니다.');
        // responseData(0, '링크가 유효하지 않습니다.');
        return;
    }

    // 크롤링 시작 ============================================================
    $SLEEP = 2;
    $price = '';

    // URL Header 설정
    $context = stream_context_create([
        'http' => [
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36', 
        ],
        'DNT' => ['1'
        ],
    ]);

        $html = file_get_contents(${'item_name'}, false, $context);
        // DOM 객체로 HTML 파싱
        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        // price - 상품 가격 가져오기
        $elements = $dom->getElementsByTagName('span');
        foreach ($elements as $element) {
            if ($element->getAttribute('class') == '_1LY7DqCnwR') {
                $value = $element->nodeValue;
                $price = str_replace(',', '', $value);
            }
        }

        // 정규 표현식 패턴을 정의하는 부분
        $pattern = '/"mallSeq":(\d+),/';

        // 패턴을 사용하여 일치하는 값을 찾는 부분
        if (preg_match($pattern, $html, $matches)) {
            $mallSeq = $matches[1];
            // echo "mallSeq 값: " . $mallSeq;
        } 

        // 최종 URL 생성
        $finalUrl = 'https://msearch.shopping.naver.com/search/all?query=' . urlencode($work_keyword) . '&minPrice=' . $price . '&maxPrice=' . $price . '&mall=' . $mallSeq;

        // 정규 표현식 패턴을 정의하는 부분
        $pattern1 = '/"syncNvMid":(\d+)},/';

        if (preg_match($pattern1, $html, $matches1)) {
            $nvMid = $matches1[1];
        } 
                
        // 네이버 복구 시 주석 해제 ========================================================================
        $url1 = "http://14.7.33.34:5000/productCnt?keyword=" . urlencode($work_keyword) . "&price=" . $price . "&mall=" . $mallSeq;
        $url2 = "http://14.7.33.34:5000/findRanking?keyword=" . urlencode($work_keyword) . "&price=" . $price . "&mall=" . $mallSeq . "&mid=" . $nvMid;
        
        $response1 = file_get_contents($url1, false, $context);
        if($response1!=1){
            $response2 = file_get_contents($url2, false, $context);
            $_POST['rank_keyword'] = '실패 Ranking : ' . $response2;
        } else {
            $_POST['rank_keyword'] = '성공';
        }

        //  ========================================================================

        $_POST['item_name'] = $finalUrl;
        $_POST['contents_mid'] = $nvMid;
        
        // 나머지 작업 처리 및 응답
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

        $slot      = kget('slot', ['seq' => $seq]);
        $slot_type = kget('slot_type', ['seq' => $slot['slot_type_seq']]);

        addLog('add_slot', $slot['mb_id'], [
            'slot_seq'       => $slot['seq'],
            'slot_type_seq'  => $slot_type['seq'],
            'slot_type_name' => $slot_type['name'],
            'start'          => $slot['start'],
            'end'            => $slot['end'],
            'store_name'     => $slot['store_name'],
            'work_keyword'   => $slot['work_keyword'],
            'item_name'      => $finalUrl,
        ]);

    
        kadd('slot', $add_datas, ['seq' => $seq]);   
        
    responseData(1, '수정되었습니다.');
    
}



function deleteData()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

    # 로그
    $slot      = kget('slot', ['seq' => $seq]);
    $slot_type = kget('slot_type', ['seq' => $slot['slot_type_seq']]);
    // addLog('delete_slot', $slot['mb_id'], [
    //     'slot_seq'       => $slot['seq'],
    //     'slot_type_seq'  => $slot_type['seq'],
    //     'slot_type_name' => $slot_type['name'],
    //     'start'          => $slot['start'],
    //     'end'            => $slot['end'],
    // ]);

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
    $end       = date("Y-m-d", $timestamp);

    kadd('slot', ['end' => $end], ['seq' => $seq]);

    # 로그
    $slot_type = kget('slot_type', ['seq' => $slot['slot_type_seq']]);
    // addLog('add_period', $slot['mb_id'], [
    //     'slot_seq'       => $seq,
    //     'slot_type_seq'  => $slot_type['seq'],
    //     'slot_type_name' => $slot_type['name'],
    //     'start'          => $slot['start'],
    //     'end'            => $end,
    //     'last_end'       => $slot['end'],
    // ]);
    responseData(1, '연장 하였습니다.');
}


function updateList()
{
    global $member;
    @extract($_GET);
    @extract($_POST);

    if ($seqs) {
        foreach ($seqs as $seq) {
            $slot = kget('slot', ['seq' => $seq]);

            $timestamp = strtotime("{$day_count} days", strtotime($slot['end']));
            $end       = date("Y-m-d", $timestamp);

            kadd('slot', ['end' => $end], ['seq' => $seq]);

            # 로그
            $slot_type = kget('slot_type', ['seq' => $slot['slot_type_seq']]);
            // addLog('add_period', $slot['mb_id'], [
            //     'slot_seq'       => $seq,
            //     'slot_type_seq'  => $slot_type['seq'],
            //     'slot_type_name' => $slot_type['name'],
            //     'start'          => $slot['start'],
            //     'end'            => $end,
            //     'last_end'       => $slot['end'],
            //     'store_name'     => $slot['store_name'],
            //     'item_name'      => $slot['item_name'],
            //     'work_keyword'   => $slot['work_keyword'],
            // ]);
        }
    }
    responseData(1, '연장처리 되었습니다.');

}
