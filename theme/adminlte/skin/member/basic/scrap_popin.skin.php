<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 스크랩 시작 { -->
<!-- 콘텐츠 시작 { -->
	<div class="content-wrapper">
	<?php /*
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid"><!--div class="container" -->
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">스크랩하기</h1>
                </div><!-- /.col -->
                
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo G5_URL; ?>">Home</a></li>
                        <li class="breadcrumb-item active">스크랩하기</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
	*/ ?>
	<div class="content-header">
        <div class="container-fluid">
		</div>
	</div>

    <!-- Main content { -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">스크랩하기</h3>

                        <!--div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                        </div -->
                    </div><!-- /.card-header -->

                    <div class="card-body">
						<form name="f_scrap_popin" action="./scrap_popin_update.php" method="post">
							<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
							<input type="hidden" name="wr_id" value="<?php echo $wr_id; ?>">
							<div class="new_win_con">
								<h2 class="sound_only">제목 확인 및 댓글 쓰기</h2>
								<div class="container">
									<div class="container" style="padding-bottom:15px;">
										<span class="sound_only">제목</span>
										<strong><?php echo get_text(cut_str($write['wr_subject'], 255)) ?></strong>
									</div>

									<div class="container form-group">
										<label for="wr_content"><small>댓글 작성</small></label>
										<textarea class="form-control" name="wr_content" id="wr_content"></textarea>
									</div>
								</div>
							</div>
							<p class="win_desc">스크랩을 하시면서 감사 혹은 격려의 댓글을 남기실 수 있습니다.</p>

							<div class="win_btn text-center" style="padding:20px;">
								<button type="submit" class="btn btn-primary btn_submit">스크랩 확인</button>
							</div>
						</form>
                    </div><!-- /.card-body -->
                    
                    <div class="card-footer">
							<button type="button" onclick="window.close();" class="btn btn_close float-right">창닫기</button>
                    </div><!-- /.card-footer-->
                </div><!-- /.card -->
            </div><!-- /.col-12 -->
        </div><!-- /.row -->
    </section>
    <!-- } Main content -->
</div><!-- /.content-wrapper -->
<!-- } 콘텐츠 끝 -->
<!-- } 스크랩 끝 -->