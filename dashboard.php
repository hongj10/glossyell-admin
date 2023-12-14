<?php
$menu_code = '1005';
include '_common.php';
include './include/top.php';
include './include/lnb.php';
include './include/snb.php';

$today = date('Y-m-d');
$three_days_later = date('Y-m-d', strtotime($today . ' +3 days'));
$normal_slot = cget("SELECT COUNT(1) AS cnt FROM k_slot WHERE `end` >= '{$today}'");
$expired_slot_count = cget("SELECT COUNT(1) AS cnt FROM k_slot WHERE `end` >= '{$today}' AND `end` <= '{$three_days_later}'");
$ative_hit = cget("SELECT SUM(hit) AS cnt FROM k_slot WHERE `end` >= '{$today}'");
?>
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<div class="content-wrapper">
    <?php
    include './include/page.header.php' ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 c_form_group">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php echo $normal_slot['cnt']?></h3>

                                    <p>현재 활성 슬롯</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="/slot_manage.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?php echo $expired_slot_count['cnt']?></h3>
                                    <p>만료 예정 슬롯</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="/slot_manage.php?expired_slot=Y" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box">
                                <div class="inner">
                                    <h3><?php echo $ative_hit['cnt']?></h3>

                                    <p>클릭 갯수</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="/slot_manage.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>
<form name="form" id="memo-form" action="" method="post">
    <div class="modal fade" id="modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <input type="hidden" name="method" value="updateMemo" />
                    <input type="hidden" name="seq" id="modal-seq" value="" />
                    <h4 class="modal-title" style="font-size:0.9rem">메모작성</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" rows="3" placeholder="메모를 작성하세요" name="memo" id="modal-memo"></textarea>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
                    <button type="submit" class="btn btn-primary">저장</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
include './include/bottom.php';
?>
<script type="text/javascript">
</script>
</body>
</html>
