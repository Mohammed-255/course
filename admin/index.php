<?php
    session_start();

    $linkCss = "login.css";

    $linkjs = "login.js";

    $pageTitle = "تسجيل الدخول";

    $src1 = "#login";
    $src2 = "logup.php";
    $namesrc1 = "تسجيل الدخول";
    $namesrc2 = "إنشاء حساب";

    if (isset($_SESSION['Usename'])) {
        header('Location: dashboard.php');
    }elseif (isset($_SESSION['Usename1'])) {
        header('Location: memberspage.php');
        exit();
    }

    include "init.php"; 
    img ();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email      = $_POST['mail'];
        $password   = $_POST['pass'];
        $hashedpass = sha1($password);



        $Emailcount = checkItem('Email', 'userss', $email);

        $passcount = checkItem('password', 'userss', $hashedpass);

        $stmt = $con->prepare("SELECT
                                    *
                                FROM
                                    userss
                                WHERE
                                    Email = ?
                                AND
                                    password = ?
                                LIMIT 1");
        $stmt->execute(array($email, $hashedpass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();


                if ($count > 0) {
                    if (($_SESSION['ID'] = $row['GroupID']) == 1 && ($_SESSION['ID'] = $row['RegStatus']) == 1) {
                        $_SESSION['Usename'] = $row['FirstName'];
                        $_SESSION['Usename1'] = $row['FirstName'];
                        $_SESSION['ID'] = $row['UserID'];
                        $_SESSION['ID1'] = $row['UserID'];
                        header('Location: dashboard.php');
                        exit();

                    }elseif (($_SESSION['ID'] = $row['GroupID']) == 0 && ($_SESSION['ID'] = $row['RegStatus']) == 1) {
                        $_SESSION['Usename1'] = $row['FirstName'];
                        $_SESSION['ID1'] = $row['UserID'];
                        header('Location: memberspage.php');
                        exit();

                    }elseif (($_SESSION['ID'] = $row['GroupID']) == 0 && ($_SESSION['ID'] = $row['RegStatus']) == 0) {
                        echo '<h2>';
                        echo 'الرجاء التواصل مع المشرف لتفعيل حسابك عن طريق الرقم <a href="';  getDates ("UrlName", "urlwhtsapp");  echo'"> 0508317091 </a>  لتفعيل حسابك';
                        echo '</h2>';

                    }
                }elseif ($count == 0) {

                    if ($Emailcount > 0 && $passcount == 0) { 
                        createFormlLogin ('', 'الرقم السري خاطئ أعد المحاولة');
                    }elseif ($Emailcount == 0 && $passcount > 0) {
                        createFormlLogin('البريد الإلكتروني خاطئ أعد المحاولة','');
                    }elseif ($Emailcount == 0 && $passcount == 0) {
                        createFormlLogin('البريد الإلكتروني خاطئ أعد المحاولة','الرقم السري خاطئ أعد المحاولة');
                    }elseif ($Emailcount > 0 && $passcount > 0) {
                        echo '<h1>';
                        echo 'الرجاء إعاد المحاولة والتأكد من البيانات';
                        echo '</h1>';
                    }

                }
        }else {
            createFormlLogin('','');
}


include $tpl . "footer.php"; 
ob_end_flush();
?>