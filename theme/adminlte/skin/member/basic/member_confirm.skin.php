<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원 비밀번호 확인 시작 { -->
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href="<?php echo G5_URL; ?>"><?php echo $g5['title'] ?></a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name"><?php echo $member['mb_nick']; ?></div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
        <?php
        $mb_dir = substr($member['mb_id'], 0, 2);
        $icon_file_src = G5_DATA_PATH . '/member_image/' . $mb_dir . '/' . get_mb_icon_name($member['mb_id']) . '.gif';
        $icon_file = G5_DATA_URL . '/member_image/' . $mb_dir . '/' . get_mb_icon_name($member['mb_id']) . '.gif';
        $is_file_exist = file_exists($icon_file_src);
        if ($is_file_exist) { ?>
            <img src="<?php echo $icon_file; ?>" class="img-circle elevation-2" alt="<?php echo $member['mb_id']; ?> Image">
        <?php } else { ?>
            <img src="<?php echo G5_THEME_URL; ?>/img/no_profile.gif" class="img-circle elevation-2" alt="<?php echo $member['mb_id']; ?> Image">
        <?php } ?>
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form name="fmemberconfirm" class="lockscreen-credentials" action="<?php echo $url ?>" onsubmit="return fmemberconfirm_submit(this);" method="post">
        <input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
        <input type="hidden" name="w" value="u">

        <div class="input-group">
            <input type="password" name="mb_password" autofocus class="form-control autofocus" id="confirm_mb_password" required class="required frm_input" size="15" maxLength="20" placeholder="비밀번호">
            <div class="input-group-append">
                <button type="button" class="btn">
                    <i class="fas fa-arrow-right text-muted"></i>
                </button>
            </div>
        </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Enter your password to retrieve your session
  </div>
  <div class="text-center">
    <a href="<?php echo G5_BBS_URL; ?>/login.php">Or sign in as a different user</a>
  </div>
  <!-- div class="lockscreen-footer text-center">
    Copyright &copy; 2014-2021 <b><a href="https://adminlte.io" class="text-black">AdminLTE.io</a></b><br>
    All rights reserved
  </div -->
</div>
<!-- /.center -->


<script>
function fmemberconfirm_submit(f)
{
    document.getElementById("btn_submit").disabled = true;

    return true;
}
</script>
<!-- } 회원 비밀번호 확인 끝 -->