<?php
    ob_start();
    session_start();

    $do = isset($_GET['do']) ? $_GET['do'] : 'Members' ;
    
    $linkCss = "memberspage.css";
    $linkjs = "";
    $pageTitle = "قدرات";
    
    if ($do == 'Members') {
        $src1 = "memberspage.php?do=T";
        $src2 = "memberspage.php?do=M";
        $namesrc1 = "التأسيس";
        $namesrc2 = "المحوسب";
    }elseif ($do == 'T') {
        $src1 = "lesons&testes.php?do=TL";
        $src2 = "lesons&testes.php?do=TK";
        $namesrc1 = "اللفظي";
        $namesrc2 = "الكمي";
    }elseif ($do == 'M') {
        $src1 = "lesons&testes.php?do=ML";
        $src2 = "lesons&testes.php?do=MK";
        $namesrc1 = "اللفظي";
        $namesrc2 = "الكمي";
    }

    
    if (isset($_SESSION['Usename1'])) {
        include "init.php";
        img ();
        
        

        if ($do == 'Members') { 
            echo '<h1>  أهلا وسهلا ' . $_SESSION['Usename1'] . '</h1>';
            ?>

<div class="gallery">
    <div class="container">
        
                    <a href="memberspage.php?do=T">
                        <div class="box">
                            <div class="image">
                                <img src="layout/imags/laphthy.jpg" alt="">
                            </div>
                            <div class="but">
                            <button>التـأسيس</button>
                        </div>
                    </div>
                    </a>

                    <a href="memberspage.php?do=M">
                        <div class="box">
                            <div class="image">
                                <img src="layout/imags/kammey.jpg" alt="">
                            </div>
                            <div class="but">
                                <button>المحوسب</button>
                            </div>
                        </div>
                    </a>
                    
                </div>
            </div>

<?php
    }elseif ($do == 'T') { ?>

        <div class="perant">
            <div class="container">
                <a href="lesons&testes.php?do=TL">
                    <div class="box box1">
                        <div class="img"><img src="layout/imags/laphthy.jpg" alt=""></div>
                        <h2>اللفظي</h2>
                    </div>
                </a>

                <a href="lesons&testes.php?do=TK">
                    <div class="box box2">
                        <div class="img"><img src="layout/imags/kammey.jpg" alt=""></div>
                        <h2>الكمي</h2>
                    </div>
                </a>

                <a href="simulationtestpage.php?do=T">
                    <div class="box box2">
                        <div class="img"><img src="layout/imags/laphthy.jpg" alt=""></div>
                        <h2 class="h2">إختبارات المحاكاة</h2>
                    </div>
                </a>
                
            </div>
        </div>
<?php
    }elseif ($do == 'M') { ?>


        <div class="perant">
            <div class="container">
                <a href="lesons&testes.php?do=ML">
                    <div class="box box1">
                        <div class="img"><img src="layout/imags/laphthy.jpg" alt=""></div>
                        <h2>اللفظي</h2>
                    </div>
                </a>

                <a href="lesons&testes.php?do=MK">
                    <div class="box box2">
                        <div class="img"><img src="layout/imags/kammey.jpg" alt=""></div>
                        <h2>الكمي</h2>
                    </div>
                </a>

                <a href="simulationtestpage.php?do=M">
                    <div class="box box2">
                        <div class="img"><img src="layout/imags/laphthy.jpg" alt=""></div>
                        <h2 class="h2">إختبارات المحاكاة</h2>
                    </div>
                </a>
                
            </div>
        </div>

<?php

    }else {
        header('location: logout.php');
    }


    }else {
        header('location: index.php');
        exit();
    }
?>

<?php include  $tpl . "footer.php";
ob_end_flush();
?>