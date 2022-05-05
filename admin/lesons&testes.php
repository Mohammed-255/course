<?php
    ob_start();
    session_start();

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    
    $linkCss = "leson.css";
    $linkjs = "leson.js";
    $pageTitle = "";
    
    $src1 = "#thelesones";
    $src2 = "#thetestes";
    $namesrc1 = "الدروس";
    $namesrc2 = "الإختبارات";

    if (isset($_SESSION['Usename1'])) {
        include 'init.php';

        if ($do == 'TL') {
            $_SESSION['do'] = 'tl';
            createLTFNU('تأسيس لفظي');
        }elseif ($do == 'TK') {
            $_SESSION['do'] = 'tk';
            createLTFNU('تأسيس كمي');
        }elseif ($do == 'ML') {
            $_SESSION['do'] = 'ml';
            createLTFNU('محوسب لفظي');
        }elseif ($do == 'MK') {
            $_SESSION['do'] = 'mk';
            createLTFNU('محوسب كمي');
        }
    }else {
        header('location: index.php');
        exit();
    }


    include  $tpl . "footer.php";
    ob_end_flush();
?>