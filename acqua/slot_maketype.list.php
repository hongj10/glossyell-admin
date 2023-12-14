<?php
$menu_code = '1010';
include '_common.php';
$rows = kgetAll('slot_type', array(1=>1), "seq asc");
?>
<div class="card-body table-responsive p-0">
<table class="table custom_table table-hover table-bordered text-nowrap table-striped tiny_padding">
    <thead>
    <tr>
        <th>슬롯ID</th>
        <th>슬롯명</th>
        <th>타수</th>
        <th>슬롯 중복체크</th>
        <th>슬롯 테스트 여부</th>
        <th>슬롯 테스트 일자</th>
        <th>변경</th>
        <th>삭제</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($rows) {
        foreach ($rows as $row) {
?>
            <tr data-seq="<?php echo $row['seq']?>">
                <td><?php echo $row['seq']?><input type="hidden" name="method" value="updateData" /></td>
                <td>
                    <input type="text" name="name" class="form-control required" placeholder="슬롯명" value="<?php echo $row['name']?>">
                </td>
                <td>
                    <input type="text" name="hit" class="form-control required" placeholder="타수" value="<?php echo $row['hit']?>">
                </td>
                <td>
                    <select class="form-control select2" name="is_duplicated">
                        <option selected="selected" value="1">중복체크함</option>
                        <option <?php echo get_selected('0',  $row['is_duplicated'])?> value="0">중복체크 안함</option>
                    </select>
                </td>
                <td>
                    <select class="form-control select2" name="is_tested">
                        <option selected="selected" value="1">테스트 슬롯 O</option>
                        <option <?php echo get_selected('0',  $row['is_tested'])?> value="0">테스트 슬롯 X</option>
                    </select>
                </td>
                <td><input type="text" name="test_date" class="form-control" placeholder="테스트 일자" value="<?php echo $row['test_date']?>"></td>
                <td class="text-center"><button type="button" class="btn btn-primary btn-modify">변경</button></td>
                <td class="text-center"><button type="button" class="btn btn-danger btn-delete">삭제</button></td>
            </tr>
    <?php

        }
    } else {
?>
        <tr>
            <td colspan="20" style="height: 100px">데이터가 없습니다.</td>
        </tr>
    <?php

    }
    ?>
    </tbody>
</table>
</div>