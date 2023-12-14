 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo G5_URL; ?>" class="brand-link">
      <img src="<?php echo G5_THEME_URL; ?>/dist/img/AdminLTELogo.png" alt="<?php echo $config['cf_title']; ?> Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?php echo $config['cf_title']; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php
          if ($is_member) {
            //$mb_nick = get_sideview($member['mb_id'], get_text($member['mb_nick']), $member['mb_email'], $member['mb_homepage']);
            $mb_dir = substr($member['mb_id'], 0, 2);
            $icon_file_src = G5_DATA_PATH . '/member_image/' . $mb_dir . '/' . get_mb_icon_name($member['mb_id']) . '.gif';
            $icon_file = G5_DATA_URL . '/member_image/' . $mb_dir . '/' . get_mb_icon_name($member['mb_id']) . '.gif';
            $is_file_exist = file_exists($icon_file_src);
            if ($is_file_exist) { ?>
              <img src="<?php echo $icon_file; ?>" class="img-circle elevation-2" alt="<?php echo $member['mb_id']; ?> Image">
            <?php } else { ?>
              <img src="<?php echo G5_THEME_URL; ?>/img/no_profile.gif" class="img-circle elevation-2" alt="<?php echo $member['mb_id']; ?> Image">
            <?php } ?>
          <?php } else { ?>
            <img src="<?php echo G5_THEME_URL; ?>/img/no_profile.gif" class="img-circle elevation-2" alt="User Image">
          <?php } ?>
        </div>
        <div class="info">
          <?php if ($is_member) { ?>
          <!-- a href="<?php echo G5_BBS_URL; ?>/profile.php?mb_id=<?php echo $member['mb_id']; ?>" class="d-block"><?php echo get_text($member['mb_nick']); ?></a -->
          <a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php" class="d-block"> <?php echo get_text($member['mb_nick']); ?></a>
          <a href="<?php echo G5_BBS_URL; ?>/logout.php" class="d-block"><i class="fas fa-sign-out-alt"></i> logout</a>
          <?php } else { ?>
            <a href="<?php echo G5_BBS_URL; ?>/login.php" class="d-block"> login</a>
          <?php } ?>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL; ?>/search.php" onsubmit="return fsearchbox_submit(this);">
          <input type="hidden" name="sfl" value="wr_subject||wr_content">
          <input type="hidden" name="sop" value="and">
          <label for="sch_stx" class="sound_only">검색어 필수</label>

          <div class="input-group">
            <input type="text" name="stx" class="form-control form-control-sidebar" id="sch_stx" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button type="submit" class="btn btn-sidebar" id="sch_submit" value="검색">
                <i class="fas fa-search fa-fw"></i><span class="sound_only">검색</span>
              </button>
            </div>
          </div>
        </form>
      </div>

<script>
function fsearchbox_submit(f)
{
    var stx = f.stx.value.trim();
    if (stx.length < 2) {
        alert("검색어는 두글자 이상 입력하십시오.");
        f.stx.select();
        f.stx.focus();
        return false;
    }

    // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
    var cnt = 0;
    for (var i = 0; i < stx.length; i++) {
        if (stx.charAt(i) == ' ')
            cnt++;
    }

    if (cnt > 1) {
        alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
        f.stx.select();
        f.stx.focus();
        return false;
    }
    f.stx.value = stx;

    return true;
}
</script>
      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
          <?php
          if ($is_admin) { ?>
          <li class="nav-header">ADMINISTRATOR</li>
          <li class="nav-item">
            <a href="<?php echo G5_ADMIN_URL; ?>" class="nav-link">
              <i class="nav-icon fas fa-ellipsis-h"></i>
              <p>관리자 페이지</p>
            </a>
          </li>
          <?php } ?>

          <?php
          $menu_datas = get_menu_db(0, true);
          $gnb_zindex = 999; // gnb_1dli z-index 값 설정용
          $i = 0;
          foreach($menu_datas as $row) {
            if(empty($row)) { continue; }
          ?>
            <!--li class="nav-item menu-open" -->
            <!--a href="#" class="nav-link active" -->
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                <?php echo $row['me_name']; ?> <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <?php if (count($row['sub']) > 0) { ?>
              <ul class="nav nav-treeview">
                <?php
                foreach($row['sub'] as $sub_row) {
                  if ($sub_row['me_use'] || $sub_row['me_mobile_use']) { ?>
                    <li class="nav-item">
                      <!-- a href="<?php echo G5_URL; ?>" class="nav-link active" -->
                      <a href="<?php echo $sub_row['me_link']; ?>" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p><?php echo $sub_row['me_name']; ?></p>
                      </a>
                    </li>
                <?php
                  }
                }?>

              </ul>
            <?php } ?>
            </li> 
          <?php } ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>