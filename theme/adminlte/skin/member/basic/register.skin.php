<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
        <a href="<?php echo G5_URL; ?>" class="h2"><b><?php echo $config['cf_title']; ?></b><br><?php echo $g5['title'] ?></a>
    </div>
    <div class="card-body">      
      <form name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">
      <p class="login-box-msg"><i class="fa fa-check-circle" aria-hidden="true"></i> 회원가입약관 및 개인정보 수집 및 이용의 내용에 동의하셔야 회원가입 하실 수 있습니다.</p>
        
      <div class="input-group mb-3">
          <h2 class="card-title">회원가입약관</h2>
          <div>
            <table>
              <tr>
                  <td class="form-control" readonly><?php echo get_text($config['cf_stipulation']); ?></td>
              </tr>
              <tr>
                <td>
                  <fieldset class="register_agree">
                      <input type="checkbox" name="agree" value="1" id="agree11" class="selec_chk">
                      <label for="agree11"><span></span><b class="sound_only">회원가입약관의 내용에 동의합니다.</b></label>
                  </fieldset>
                </td>
              </tr>
            </table>
          </div>
      </div>
      
      <div class="input-group mb-3">
          <h2 class="card-title">개인정보 수집 및 이용</h2>
          <div>
            <table>
                <!-- caption>개인정보 수집 및 이용</caption -->
                <thead>
                <tr>
                    <th>목적</th>
                    <th>항목</th>
                    <th>보유기간</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>이용자 식별 및 본인여부 확인</td>
                    <td>아이디, 이름, 비밀번호<?php echo ($config['cf_cert_use'])? ", 생년월일, 휴대폰 번호(본인인증 할 때만, 아이핀 제외), 암호화된 개인식별부호(CI)" : ""; ?></td>
                    <td>회원 탈퇴 시까지</td>
                </tr>
                <tr>
                    <td>고객서비스 이용에 관한 통지,<br>CS대응을 위한 이용자 식별</td>
                    <td>연락처 (이메일, 휴대전화번호)</td>
                    <td>회원 탈퇴 시까지</td>
                </tr>
                </tbody>
            </table>
          </div>          
          <div>
            <fieldset class="fregister_agree">
                <input type="checkbox" name="agree2" value="1" id="agree21" class="selec_chk">
                <label for="agree21"> <b class="sound_only">개인정보 수집 및 이용의 내용에 동의합니다.</b></label>
            </fieldset>
          </div>
      </div>

      <div id="fregister_chkall" class="chk_all fregister_agree">
          <input type="checkbox" name="chk_all" id="chk_all" class="selec_chk">          
          <label for="agreeTerms">&nbsp;회원가입 약관에 모두 동의합니다</label>
      </div>

      <div class="row">
          <div class="col-8">
            <a href="<?php echo G5_URL; ?>" class="btn_close">Cancel</a>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
      </div>

      <?php
      // 소셜로그인 사용시 소셜로그인 버튼
      @include_once(get_social_skin_path().'/social_register.skin.php');
      ?>

      </form>     

      <!-- div class="social-auth-links text-center">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div -->

      <a href="<?php echo G5_BBS_URL; ?>/login.php" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->
















<script>
function fregister_submit(f)
{
    if (!f.agree.checked) {
        alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
        f.agree.focus();
        return false;
    }

    if (!f.agree2.checked) {
        alert("개인정보 수집 및 이용의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
        f.agree2.focus();
        return false;
    }

    return true;
}

jQuery(function($){
    // 모두선택
    $("input[name=chk_all]").click(function() {
        if ($(this).prop('checked')) {
            $("input[name^=agree]").prop('checked', true);
        } else {
            $("input[name^=agree]").prop("checked", false);
        }
    });
});

</script>
<!-- } 회원가입 약관 동의 끝 -->
