<?php
ob_start();
session_start();

$linkCss = "";
$linkjs = "";
$pageTitle = "لمحة عنا";
$src1 = "index.php";
$src2 = "logup.php";
$namesrc1 = "تسجيل الدخول";
$namesrc2 = "إنشاء حساب";


include 'init.php';

$stmt = $con->prepare("SELECT TheNote FROM notelookus");
$stmt->execute();
$rows = $stmt->fetchAll();

foreach ($rows as $row) {
    echo '<div class="">';
    echo $row['TheNote'];
    echo '</div>';
}

include $tpl . 'footer.php';

ob_end_flush();