<?php 

ob_start();

session_start();
if (isset($_SESSION['Usename'])) {
    $pageTitle = "testes";
    $src1 = "memberspage.php?do=T";
    $src2 = "memberspage.php?do=M";
    $namesrc1 = "التأسيس";
    $namesrc2 = "المحوسب";
    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    
    if ($do == 'Manage') { 

        echo '<h1>الإختبارات </h1>';
        ?>

        <div class="containerdash">

            <a href="testsfile.php?do=TK">
                <div>
                    إختبارات تأسيس الكمي
                    <span>  </span>
                </div>
            </a>


            <a href="testsfile.php?do=TL">
                <div>
                    إختبارات تأسيس اللفظي
                    <span>  </span>
                </div>
            </a>


            <a href="testsfile.php?do=TM">
                <div>
                    إختبارات تأسيس المحاكاة
                    <span>  </span>
                </div>
            </a>


            <a href="testsfile.php?do=MK">
                <div>
                    إختبارات محوسب الكمي
                    <span>  </span>
                </div>
            </a>

            
            <a href="testsfile.php?do=ML">
                <div>
                    إختبارات محوسب اللفظي 
                    <span>  </span>
                </div>
            </a>


            <a href="testsfile.php?do=MM">
                <div>
                    إختبارات محوسب المحاكاة 
                    <span>  </span>
                </div>
            </a>


            <a href="imgstest.php">
                <div>
                    صور
                    <span>  </span>
                </div>
            </a>

        </div>

        <?php


}elseif ($do == 'TK'){
        $_SESSION['do'] = 'tk';
        echo '<h1>تأسيس كمي </h1>'; 
        createTable ('TK', 'Test', 'Test', 'test', 'testsfile.php');


    }elseif ($do == 'TL'){
        $_SESSION['do'] = 'tl';
        echo '<h1>تأسيس لفظي </h1>'; 
        createTable ('TL', 'Test', 'Test', 'test', 'testsfile.php');


    }elseif ($do == 'MK'){
        $_SESSION['do'] = 'mk';
        echo "<h1> محوسب كمي </h1>";
        createTable ('MK', 'Test', 'Test', 'test', 'testsfile.php');


    }elseif ($do == 'ML'){
        $_SESSION['do'] = 'ml';
        echo "<h1> محوسب لفظي </h1>";
        createTable ('ML', 'Test', 'Test', 'test', 'testsfile.php');


    }elseif ($do == 'MM'){
        $_SESSION['do'] = 'mm';
        echo "<h1> محاكاة المحوسب </h1>";
        createTable ('MM', 'Test', 'Test', 'test', 'testsfile.php');

    }elseif ($do == 'TM'){
        $_SESSION['do'] = 'tm';
        echo "<h1> محاكاة التأسيس </h1>";
        createTable ('TM', 'Test', 'Test', 'test', 'testsfile.php');


    }
    elseif ($do == 'Add') { ?>

        <form action="testsfile.php?do=Add&do=Insert" method="POST" enctype="multipart/form-data" class="add">
            <input type="text" name="Name" placeholder="إسم الإختبار">
            <input type="text" name="Many" placeholder="عدد الأسئلة">
            <input type="file" name="file" id="file">
            <input type="submit" value="submit">
        </form>

    <?php
    }elseif ($do == "Insert") {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo '<h1> تم الإرسال </h1>';

        $thename = $_POST['Name'];
        $quesmany = $_POST['Many'];

        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileTmp = $_FILES['file']['tmp_name'];
        $fileType = $_FILES['file']['type'];

        $fileAllowedExte = array("json");

        $fileE = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $formError = [];

        if (!empty($fileName)  && !in_array($fileE, $fileAllowedExte)) {
            $formError [] = 'إمتداد هذا الملف غير مسموح به';
        }
        if (empty($fileName) ) {
            $formError [] = 'لم ترفع الملف ';
        }
        if (empty($thename)) {
            $formError [] = 'لم تكتب إسم الملف';
        }
        if (empty($quesmany)) {
            $formError [] = 'لم تكتب عدد الأسئلة';
        }


        foreach($formError as $error) {
            echo '<h1>' . $error . '</h1>';
        }

            if (empty($formError)) {

                $file = rand(0, 10000000) . '_' . $fileName;

                move_uploaded_file($fileTmp, "../layout/json/json".$_SESSION['do']."/" . $file);



                        $stmt = $con->prepare("INSERT INTO 
                                            test".$_SESSION['do']."(TheName, TestName, Qusemany, TestSize, Date)
                                            VALUES(:zTheName, :zTestName, :zQusemany, :zTestSize, now())");
                $stmt->execute(array(
                'zTheName'  => $thename,
                'zTestName' => $file,
                'zQusemany' => $quesmany,
                'zTestSize' => $fileSize
                ));

            }



        }else {

        }


    }elseif ($do == 'Edit') {

        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

        $stmt = $con->prepare("SELECT * FROM test" . $_SESSION['do'] . " WHERE UserID = ? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($stmt->rowCount() > 0) { ?>

                <form action="testsfile.php?do=Update" method="POST" enctype="multipart/form-data" class="add">
                <input type="hidden" name="userid" value="<?php echo $userid;?>">
                <input type="text" name="Name" value="<?php echo $row['TheName']; ?>" placeholder="إسم الإختبار">
                <input type="text" name="Many" value="<?php echo $row['Qusemany']; ?>" placeholder="عدد الأسئلة">
                <input type="file" name="file" id="file">
                <input type="submit" value="submit">
                </form>

<?php
        }else {

        }

    }elseif ($do == 'Update') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['userid'];
            $thename = $_POST['Name'];
            $quesmany = $_POST['Many'];

            $fileName = $_FILES['file']['name'];
            $fileSize = $_FILES['file']['size'];
            $fileTmp = $_FILES['file']['tmp_name'];
            $fileType = $_FILES['file']['type'];


            if (!empty($fileName)) {
            $stmt = $con->prepare("SELECT * FROM test".$_SESSION['do']." WHERE UserID = ? LIMIT 1");
            $stmt->execute(array($id));
            $row = $stmt->fetch();
            $oldfile = $row['TestName'];
            unlink("../layout/json/json".$_SESSION['do'] ."/".$oldfile);
            $file = rand(0, 10000000) . '_' . $fileName;
            move_uploaded_file($fileTmp, "../layout/json/json".$_SESSION['do']."/". $file);
            $stmt = $con->prepare("UPDATE test".$_SESSION['do']." SET
                                                    TestName = ?, 
                                                    TestSize = ?
                                                WHERE
                                                    UserID = ?");
            $stmt->execute(array($file, $fileSize, $id));
            }
        


            if (!empty($thename)) {
            $stmt = $con->prepare("UPDATE test".$_SESSION['do']." SET
                                                    thename = ? 
                                                WHERE
                                                    UserID = ?");
            $stmt->execute(array($thename, $id));
            }

            if (!empty($quesmany)) {
            $stmt = $con->prepare("UPDATE test".$_SESSION['do']." SET
                                                    Qusemany = ? 
                                                WHERE
                                                    UserID = ?");
            $stmt->execute(array($quesmany, $id));
            }

            echo '<h1> تم التعديل </h1>';

        }
    }elseif ($do == 'Delete') {


        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

        $check = checkItem('userid', "test".$_SESSION['do']."", $userid);

        if ($check > 0) {

            $stmt = $con->prepare("SELECT TestName FROM test".$_SESSION['do']." WHERE UserID = ? LIMIT 1");
            $stmt->execute(array($userid));
            $row = $stmt->fetch();

            unlink("../layout/json/jsontk/". $row['TestName']);

            $stmt = $con->prepare("DELETE FROM test".$_SESSION['do']." WHERE UserID = :zuserid");
            $stmt->bindparam(":zuserid", $userid);
            $stmt->execute();
        }
        // else {
        //     $theMsg = 'This ID is not exist';
        //     redirectHome($theMsg);
        // }


    }




    include $tpl . "footer.php";
}else {
    header('location: index.php');
    exit();
}
ob_end_flush();