<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<!-- 콘텐츠 시작 { -->
<?php /*
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid"><!--div class="container" -->
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?php echo $g5['title']; ?></h1>
            </div><!-- /.col -->
            
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo G5_URL; ?>">Home</a></li>
                    <li class="breadcrumb-item active"><?php echo $g5['title']; ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
*/ ?>

<!-- Main content { -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <div id="bo_v_ans" class="card">
                <div class="card-header"  style="border:none;">
                    <h3 class="card-title"><?php echo get_text($answer['qa_subject']); ?>&nbsp;&nbsp;</h3>
                    
                    <div id="ans_datetime">
                        <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $answer['qa_datetime']; ?>
                    </div>

                    <?php if ( $answer_update_href || $answer_delete_href ){ ?>
                    <div id="ans_add">
                        <button type="button" class="btn_more_add btn_more_opt btn_b01 btn" title="답변 옵션"><i class="fa fa-ellipsis-v" aria-hidden="true"></i><span class="sound_only">답변 옵션</span></button>
                        <ul class="more_add">
                            <?php if($answer_update_href) { ?>
                            <li><a href="<?php echo $answer_update_href; ?>" class="btn_b01 btn" title="답변수정">답변 수정</a></li>
                            <?php } ?>
                            <?php if($answer_delete_href) { ?>
                            <li><a href="<?php echo $answer_delete_href; ?>" class="btn_b01 btn" onclick="del(this.href); return false;" title="답변삭제">답변 삭제</a></li>
                            <?php } ?>	
                        </ul>
                        <script>
                            // 답변하기 옵션
                            $(".btn_more_add").on("click", function() {
                                $(".more_add").toggle();
                            })
                        </script>
                    </div>
                    <?php } ?>

                    <!--div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                    </div -->                        
                </div><!-- /.card-header -->

                <div class="card-body">                
                    <div id="ans_con">
                        <?php
                        // 파일 출력
                        if(isset($answer['img_count']) && $answer['img_count']) {
                            echo "<div id=\"bo_v_img\">\n";

                            for ($i=0; $i<$answer['img_count']; $i++) {
                                echo get_view_thumbnail($answer['img_file'][$i], $qaconfig['qa_image_width']);
                            }

                            echo "</div>\n";
                        }
                        ?>

                        <?php echo get_view_thumbnail(conv_content($answer['qa_content'], $answer['qa_html']), $qaconfig['qa_image_width']); ?>

                        <?php if(isset($answer['download_count']) && $answer['download_count']) { ?>
                        <!-- 첨부파일 시작 { -->
                        <section id="bo_v_file">
                            <h2>첨부파일</h2>
                            <ul>
                            <?php
                            // 가변 파일
                            for ($i=0; $i<$answer['download_count']; $i++) {
                            ?>
                                <li>
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    <a href="<?php echo $answer['download_href'][$i];  ?>" class="view_file_download" download>
                                        <strong><?php echo $answer['download_source'][$i] ?></strong>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                            </ul>
                        </section>
                        <!-- } 첨부파일 끝 -->
                        <?php } ?>
                    </div>
                </div><!-- /.card-body -->
                
                <div class="card-footer">
                    <div class="bo_v_btn">
                        <a href="<?php echo $rewrite_href; ?>" class="add_qa" title="추가질문">추가질문</a>  
                    </div>
                </div><!-- /.card-footer -->               
            </div><!-- /.card -->
        </div><!-- /.col-12 -->
    </div><!-- /.row -->
</section>
<!-- } Main content -->
<!-- } 콘텐츠 끝 -->