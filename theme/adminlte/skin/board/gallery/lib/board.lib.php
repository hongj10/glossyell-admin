<?php
if (!defined('_GNUBOARD_')) exit;

// Category option start {
$category_option = '';                        
$category_href = get_pretty_url($bo_table);
                            
$category_option .= '<label class="btn bg-olive';
if ($sca=='')
    $category_option .= ' active';
$category_option .= '"><a href="'.$category_href.'">전체</a></label>';

$categories = explode('|', $board['bo_category_list']); // 구분자가 , 로 되어 있음
for ($i=0; $i<count($categories); $i++) {
    $category = trim($categories[$i]);
    if ($category=='') continue;
    $category_option .= '<label class="btn bg-olive';
    $category_msg = '';
    if ($category==$sca) { // 현재 선택된 카테고리라면
        $category_option .= ' active">';
        $category_msg = '<span class="sound_only">열린 분류 </span>';
    } else {
        $category_option .= '">';
    }
    $category_option .= $category_msg.'<a href="'.(get_pretty_url($bo_table,'','sca='.urlencode($category))).'">'.$category.'</a></label>';
}
// } Category option end.
?>