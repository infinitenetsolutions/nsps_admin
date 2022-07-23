<?php
include './framwork/main.php';
$condition =1 ;
if (isset($_POST["export"])) {
    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=all_student_data.xls');
?>
    <table class="table table-hover table-border ">
        <thead>
            <tr>
                <?php thGen("student_export", 'false')  ?>
            </tr>
        </thead>
        <tbody>
            <?php tdGen("student_export", '', '', '', $condition, 50) ?>
        </tbody>
    </table>
<?php
}
?>