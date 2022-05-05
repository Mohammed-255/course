<?php
    ob_start();

    session_start();
    if (isset($_SESSION['Usename'])) {
        $pageTitle = "dashboard";
        $src1 = "memberspage.php?do=T";
        $src2 = "memberspage.php?do=M";
        $namesrc1 = "التأسيس";
        $namesrc2 = "المحوسب";
        include 'init.php';
        ?>

        <h1>Dashboard</h1>
        <div class="containerdash">
            <a href="members.php?do=Manage">
            <div>
                جميع الأعضاء
                <span><?php echo countItems('UserID', 'userss') ?></span>
            </div>
            </a>

            <a href="members.php?do=Manage&page=Pending">
                <div>
                    الأعضاء الخاملة
                    <span><?php echo checkItem ('RegStatus', 'userss', 0) ?></span>
                </div>
            </a>

            <a href="videosfile.php">
                <div>
                    الفيدوهات
                    <span>  </span>
                </div>
            </a>

            <a href="testsfile.php">
                <div>
                    الإختبارات
                    <span>  </span>
                </div>
            </a>

            <a href="file.php">
                <div>
                    الملفات
                    <span>  </span>
                </div>
            </a>

            <a href="note.php">
                <div>
                    الملاحظات
                    <span>  </span>
                </div>
            </a>

            <a href="linkurl.php">
                <div>
                    لينك الحصة
                    <span>  </span>
                </div>
            </a>
        </div>

<?php
        include $tpl . "footer.php";
    }else {
        header('location: index.php');
        exit();
    }

    ob_end_flush();

?>
