<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $board['bo_subject']; ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo G5_URL; ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?php echo $board['bo_subject']; ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <!-- 게시물 작성/수정 시작 { -->
        <h2 class="sound_only"><?php echo $g5['title'] ?></h2>

        <form name="fwrite" id="fwrite" action="<?php echo $action_url; ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
            <input type="hidden" name="w" value="<?php echo $w; ?>">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
            <input type="hidden" name="wr_id" value="<?php echo $wr_id; ?>">
            <input type="hidden" name="sca" value="<?php echo $sca; ?>">
            <input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
            <input type="hidden" name="stx" value="<?php echo $stx; ?>">
            <input type="hidden" name="spt" value="<?php echo $spt; ?>">
            <input type="hidden" name="sst" value="<?php echo $sst; ?>">
            <input type="hidden" name="sod" value="<?php echo $sod; ?>">
            <input type="hidden" name="page" value="<?php echo $page; ?>">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <!-- h3 class="card-title">Title</h3 -->
                                <?php if ($is_category) { ?>
                                <div class="btn-group btn-group-toggle">
                                    <label for="ca_name" class="sound_only">분류<strong>필수</strong></label>
                                    <select name="ca_name" class="form-control" id="ca_name" required>
                                        <option value="">분류를 선택하세요</option>
                                        <?php echo $category_option ?>
                                    </select>
                                </div>
                                <?php } ?>
                                <?php if ($option) { ?>
                                <div class="form-control">
                                    <span class="sound_only">옵션</span>
                                    <ul class="bo_v_option"><?php echo $option ?></ul>
                                </div>
                                <?php } ?>

                            <!-- div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div -->
                        </div>
                        <!-- /.card-header 1 -->

                        <div class="card-header">
                            <?php
                            $option = '';
                            $option_hidden = '';
                            if ($is_notice || $is_html || $is_secret || $is_mail) { 
                                $option = '';
                                if ($is_notice) {
                                    $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="notice" name="notice"  class="selec_chk" value="1" '.$notice_checked.'>'.PHP_EOL.'<label for="notice"><span></span>공지</label></li>';
                                }
                                if ($is_html) {
                                    if ($is_dhtml_editor) {
                                        $option_hidden .= '<input type="hidden" value="html1" name="html">';
                                    } else {
                                        $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" class="selec_chk" value="'.$html_value.'" '.$html_checked.'>'.PHP_EOL.'<label for="html"><span></span>html</label></li>';
                                    }
                                }
                                if ($is_secret) {
                                    if ($is_admin || $is_secret==1) {
                                        $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="secret" name="secret"  class="selec_chk" value="secret" '.$secret_checked.'>'.PHP_EOL.'<label for="secret"><span></span>비밀글</label></li>';
                                    } else {
                                        $option_hidden .= '<input type="hidden" name="secret" value="secret">';
                                    }
                                }
                                if ($is_mail) {
                                    $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="mail" name="mail"  class="selec_chk" value="mail" '.$recv_email_checked.'>'.PHP_EOL.'<label for="mail"><span></span>답변메일받기</label></li>';
                                }
                            }
                            echo $option_hidden;

                            if ($is_name || $is_password || $is_email || $is_homepage) {
                            ?>
                            <div class="card-body">
                                <div class="row write_div">
                                    <?php if ($is_name) { ?>
                                        <label for="wr_name" class="sound_only">이름<strong>필수</strong></label>
                                        <input type="text" name="wr_name" value="<?php echo $name; ?>" id="wr_name" required class="form-control col-sm-6 required" placeholder="이름">
                                    <?php } ?>
                                
                                    <?php if ($is_password) { ?>
                                        <label for="wr_password" class="sound_only">비밀번호<strong>필수</strong></label>
                                        <input type="password" name="wr_password" id="wr_password" <?php echo $password_required; ?> class="form-control col-sm-6 <?php echo $password_required ?>" placeholder="비밀번호">
                                    <?php } ?>
                                </div>

                                <div class="row write_div">
                                    <?php if ($is_email) { ?>
                                        <label for="wr_email" class="sound_only">이메일</label>
                                        <input type="email" name="wr_email" value="<?php echo $email; ?>" id="wr_email" class="form-control col-sm-6 email" placeholder="이메일">
                                    <?php } ?>                            
                                
                                    <?php if ($is_homepage) { ?>
                                        <label for="wr_homepage" class="sound_only">홈페이지</label>
                                        <input type="text" name="wr_homepage" value="<?php echo $homepage; ?>" id="wr_homepage" class="form-control col-sm-6" size="50" placeholder="홈페이지">
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="row write_div">
                                <label for="wr_subject" class="sound_only">제목<strong>필수</strong></label>
                                <input type="text" name="wr_subject" value="<?php echo $subject; ?>" id="wr_subject" required class="form-control required" size="50" maxlength="255" placeholder="제목">                                
                            </div>
                        </div>
                        <!-- /.card-header 2 -->

                        <div class="card-body">
                            <div class="write_div">
                                <label for="wr_content" class="sound_only">내용<strong>필수</strong></label>
                                <div class="wr_content <?php echo $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
                                    <?php if($write_min || $write_max) { ?>
                                    <!-- 최소/최대 글자 수 사용 시 -->
                                    <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                                    <?php } ?>
                                    <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
                                    <?php if($write_min || $write_max) { ?>
                                    <!-- 최소/최대 글자 수 사용 시 -->
                                    <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                                    <?php } ?>
                                </div>            
                            </div>

                            <?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
                            <div class="form-group write_div">
                                <div class="input-group">
                                    <label for="wr_link<?php echo $i ?>"><span class="sound_only"> 링크  #<?php echo $i ?></span></label>
                                    <input type="text" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){ echo $write['wr_link'.$i]; } ?>" id="wr_link<?php echo $i ?>" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-link" aria-hidden="true"></i></span>
                                    </div>                                    
                                </div>
                            </div>
                            <?php } ?>

                            <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
                            <div class="form-group write_div">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <label for="bf_file_<?php echo $i+1 ?>" class="lb_icon"><span class="sound_only"> 파일 #<?php echo $i+1 ?></span></label>
                                        <input type="file" name="bf_file[]" id="bf_file_<?php echo $i+1 ?>" title="파일첨부 <?php echo $i+1 ?> : 용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능" class="frm_file">
                                        <label class="custom-file-label frm_file" for="bf_file_<?php echo $i+1 ?>">Choose file</label>
                                    </div>
                                    <!--div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div -->                                    
                                    <?php if ($is_file_content) { ?>
                                        <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="full_input frm_input" size="50" placeholder="파일 설명을 입력해주세요.">
                                    <?php } ?>
                                    <?php if($w == 'u' && $file[$i]['file']) { ?>
                                    <span class="file_del">
                                        <input type="checkbox" id="bf_file_del<?php echo $i; ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <label for="bf_file_del<?php echo $i; ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label>
                                    </span>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if ($is_use_captcha) { //자동등록방지  ?>
                            <div class="write_div">
                                <?php echo $captcha_html ?>
                            </div>
                            <?php } ?>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <div class="card-tools btn_confirm">
                                <a href="<?php echo get_pretty_url($bo_table); ?>" class="btn btn-secondary">취소</a>
                                <span class="float-right"><button type="submit" id="btn_submit" accesskey="s" class="btn_submit btn btn-primary">작성완료</button></span>
                            </div>
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
        </form>
    </section>

<script>
<?php if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<?php echo $write_min; ?>); // 최소
var char_max = parseInt(<?php echo $write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
    $("#wr_content").on("keyup", function() {
        check_byte("wr_content", "char_count");
    });
});

<?php } ?>
function html_auto_br(obj)
{
    if (obj.checked) {
        result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
        if (result)
            obj.value = "html2";
        else
            obj.value = "html1";
    }
    else
        obj.value = "";
}

function fwrite_submit(f)
{
    <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": f.wr_subject.value,
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (subject) {
        alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
        f.wr_subject.focus();
        return false;
    }

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        if (typeof(ed_wr_content) != "undefined")
            ed_wr_content.returnFalse();
        else
            f.wr_content.focus();
        return false;
    }

    if (document.getElementById("char_count")) {
        if (char_min > 0 || char_max > 0) {
            var cnt = parseInt(check_byte("wr_content", "char_count"));
            if (char_min > 0 && char_min > cnt) {
                alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                return false;
            }
            else if (char_max > 0 && char_max < cnt) {
                alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                return false;
            }
        }
    }

    <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}
</script>
<!-- } 게시물 작성/수정 끝 -->