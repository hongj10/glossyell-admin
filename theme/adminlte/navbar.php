  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo G5_URL; ?>" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company" class="nav-link">회사소개</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy" class="nav-link">개인정보 처리방침</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision" class="nav-link">서비스 이용약관</a>
      </li>

      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo G5_BBS_URL; ?>/qalist.php" class="nav-link">1:1문의</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo G5_BBS_URL; ?>/faq.php?fm_id=1" class="nav-link">FAQ</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form name="fsearchbox" class="form-inline" method="get" action="<?php echo G5_BBS_URL; ?>/search.php" onsubmit="return fsearchbox_submit(this);">
          <input type="hidden" name="sfl" value="wr_subject||wr_content">
          <input type="hidden" name="sop" value="and">
          <label for="sch_stx" class="sound_only">검색어 필수</label>

            <div class="input-group input-group-sm">
              <input type="text" name="stx" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <?php
      if ($is_member) {
        $memo_total_count = 0;
        $memo_sql = " select * from {$g5['memo_table']} where me_recv_mb_id = '{$member['mb_id']}' and me_type = 'recv' ORDER BY me_id DESC ";
        $memo_result = sql_query($memo_sql);
        for ($m=0; $memo_row=sql_fetch_array($memo_result); $m++) {
          if (substr($memo_row['me_read_datetime'],0,1) == 0) {
            //$read_datetime = '아직 읽지 않음';
            $memo_list[$memo_total_count]['me_id'] = $memo_row['me_id'];
            $memo_list[$memo_total_count]['me_send_mb_id'] = $memo_row['me_send_mb_id'];
            $memo_list[$memo_total_count]['me_memo'] = $memo_row['me_memo'];
            $memo_list[$memo_total_count]['me_send_datetime'] = $memo_row['me_send_datetime'];

            $memo_total_count = $memo_total_count + 1;
          }
        }
        ?>
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge"><?php echo $memo_total_count; ?></span>
          </a>

          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <?php
          if ($memo_total_count > 0) {
            for ($me=0; $me < $memo_total_count; $me++) {
              //echo $memo_list[$me]['me_id'];
              //echo $memo_list[$me]['me_send_mb_id'];
              //echo $memo_list[$me]['me_memo'];
              if ($me == 0) { ?>              
                  <a href="<?php echo G5_BBS_URL; ?>/memo_view.php?me_id=<?php echo $memo_list[$me]['me_id']; ?>&kind=recv&page=1" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                      <!-- img src="<?php echo G5_THEME_URL; ?>/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle" -->
                      <?php echo get_member_profile_img($memo_list[$me]['me_send_mb_id'], '30', '30', 'img-circle'); ?>
                      <div class="media-body">
                        <h3 class="dropdown-item-title">
                          &nbsp;<?php echo $memo_list[$me]['me_send_mb_id']; ?>
                        </h3>
                        <p class="text-sm">&nbsp;&nbsp;<?php echo get_text(cut_str($memo_list[$me]['me_memo'], 20)); ?></p>
                        <p class="text-sm text-muted">&nbsp;<i class="far fa-clock mr-1"></i> <?php echo $memo_list[$me]['me_send_datetime']; ?></p>
                      </div>
                    </div>
                    <!-- Message End -->
                  </a>
              <?php } else { ?>
                <div class="dropdown-divider"></div>
                  <a href="<?php echo G5_BBS_URL; ?>/memo_view.php?me_id=<?php echo $memo_list[$me]['me_id']; ?>&kind=recv&page=1" class="dropdown-item">
                  <!-- Message Start -->
                  <div class="media">
                    <?php echo get_member_profile_img($memo_list[$me]['me_send_mb_id'], '30', '30', 'img-circle'); ?>
                    <div class="media-body">
                      <h3 class="dropdown-item-title">
                        &nbsp;<?php echo $memo_list[$me]['me_send_mb_id']; ?>
                        <!-- span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span -->
                      </h3>
                      <p class="text-sm">&nbsp;&nbsp;<?php echo get_text(cut_str($memo_list[$me]['me_memo'], 20)); ?></p>
                      <p class="text-sm text-muted">&nbsp;<i class="far fa-clock mr-1"></i> <?php echo $memo_list[$me]['me_send_datetime']; ?></p>
                    </div>
                  </div>
                  <!-- Message End -->
                  </a>
              <?php
              } 
            }
          }
          ?>
            <div class="dropdown-divider"></div>
            <a href="<?php echo G5_BBS_URL; ?>/memo.php" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li>
      <?php } ?>

      <!-- Notifications Dropdown Menu -->
      <!-- li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li -->
      <!--li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li-->
      <?php if ($is_member) { ?>
      <li class="nav-item">
        <a class="nav-link" data-controlsidebar-slide="true" href="<?php echo G5_BBS_URL; ?>/logout.php" role="button">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
      <?php } ?>
    </ul>
  </nav>
  <!-- /.navbar -->