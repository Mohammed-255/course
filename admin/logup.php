<?php

session_start();

$nonavbar = "";

$linkCss = "logup.css";

$linkjs = "logup.js";

$pageTitle = "إنشاء حساب";

$src1 = "#login";
$src2 = "index.php";
$namesrc1 = "إنشاء حساب";
$namesrc2 = "تسجيل الدخول";

include "init.php";
img ();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $Fname  = $_POST['FirstName'];
    $Sname = $_POST['SecondName'];
    $mail       = $_POST['mail'];
    $Pass1  = $_POST['Password1'];
    $Pass2  = $_POST['Password2'];
    $hashedpass = sha1($Pass1);

    $Emailcount = checkItem('Email', 'userss', $mail); 

    $passcount = checkItem('password', 'userss', $hashedpass);

    if ($Emailcount == 0 && $passcount > 0) {
        createForm ('','عذرا كلمة الرور مستعملة حاول مرة أخرى');
    }elseif ($Emailcount > 0 && $passcount == 0) { 
        createForm ('عذرا البريد الإلكتروني مسعتمل حاول مرة أخرى',''); 

    }elseif ($Emailcount > 0 && $passcount > 0) { 
        createForm ('عذرا البريد الإلكتروني مستعمل حاول مرة أخرى','عذرا كلمة الرور مستعملة حاول مرة أخرى');

    }else {
        $stmt = $con->prepare("INSERT INTO 
                userss(FirstName, SecondName, Email, Password, Date)
                VALUES(:zFName, :zSName, :zemail, :zpass, now())");
        $stmt->execute(array(
        'zFName' => $Fname,
        'zSName' => $Sname,
        'zemail' => $mail,
        'zpass' => $hashedpass
        ));
        echo '<h1> تم إنشاء الحساب. </h1>';
        echo '<h1>';
        echo 'الرجاء التواصل مع المشرف لتفعيل حسابك عن طريق الرقم <a href="';  getDates ("UrlName", "urlwhtsapp");  echo'"> 0508317091 </a> لتفعيل حسابك';
        echo '</h1>';
    }


}else {
    createForm ('','');
}
?>
<?php  include $tpl . "footer.php"; 
ob_end_flush();
?>