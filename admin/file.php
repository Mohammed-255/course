<?php
ob_start();

session_start();

if (isset($_SESSION['Usename'])) {

    $pageTitle = "files";
    $src1 = "memberspage.php?do=T";
    $src2 = "memberspage.php?do=M";
    $namesrc1 = "التأسيس";
    $namesrc2 = "المحوسب";
    $linkCss = "";
    $linkjs = "";

    include 'init.php';


    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

    if ($do == 'Manage') {
        echo '<h1>الملفات </h1>';
        ?>

        <div class="containerdash">

            <a href="file.php?do=TK">
                <div>
                    ملفات تأسيس الكمي
                    <span>  </span>
                </div>
            </a>


            <a href="file.php?do=TL">
                <div>
                    ملفات تأسيس اللفظي
                    <span>  </span>
                </div>
            </a>


            <a href="file.php?do=MK">
                <div>
                    ملفات محوسب الكمي
                    <span>  </span>
                </div>
            </a>

            
            <a href="file.php?do=ML">
                <div>
                    ملفات محوسب اللفظي 
                    <span>  </span>
                </div>
            </a>


        </div>

        <?php


    }elseif ($do == 'TK') {
        $_SESSION['do'] = 'tk';
        echo '<h1>تأسيس كمي </h1>'; 
        createTable ('TK', 'File', 'File', 'file', 'file.php');

    }elseif ($do == 'TL') {
        $_SESSION['do'] = 'tl';
        echo '<h1>تأسيس لفظي </h1>'; 
        createTable ('TL', 'File', 'File', 'file', 'file.php');

    }elseif ($do == 'MK') {
        $_SESSION['do'] = 'mk';
        echo '<h1>محوسب كمي </h1>'; 
        createTable ('MK', 'File', 'File', 'file', 'file.php');

    }elseif ($do == 'ML') {
        $_SESSION['do'] = 'ml';
        echo '<h1>محوسب لفظي </h1>'; 
        createTable ('ML', 'File', 'File', 'file', 'file.php');

    }
    elseif ($do == 'Add') { ?>

        <form action="file.php?do=Add&do=Insert" method="POST" enctype="multipart/form-data" class="add">
            <input type="text" name="Name" placeholder="إسم الملف">
            <input type="file" name="file" id="file">
            <input type="submit" value="submit">
        </form>

    <?php
    }elseif ($do == "Insert") {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo '<h1> تم الإرسال </h1>';

        $thename = $_POST['Name'];

        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileTmp = $_FILES['file']['tmp_name'];
        $fileType = $_FILES['file']['type'];

        $fileAllowedExte = array("docx");

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


        foreach($formError as $error) {
            echo '<h2>' . $error . '</h2>';
        }

            if (empty($formError)) {

                $file = rand(0, 10000000) . '_' . $fileName;

                move_uploaded_file($fileTmp, "../layout/file/file".$_SESSION['do']."/" . $file);

                        $stmt = $con->prepare("INSERT INTO 
                                            file".$_SESSION['do']."(TheName, FileName, FileSize, Date)
                                            VALUES(:zTheName, :zFileName, :zFileSize, now())");
                $stmt->execute(array(
                'zTheName'  => $thename,
                'zFileName' => $file,
                'zFileSize' => $fileSize
                ));
            }



        }else {

        }


    }elseif ($do == 'Edit') {

        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

        $stmt = $con->prepare("SELECT * FROM file" . $_SESSION['do'] . " WHERE UserID = ? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($stmt->rowCount() > 0) { ?>

                <form action="file.php?do=Update" method="POST" enctype="multipart/form-data" class="add">
                <input type="hidden" name="userid" value="<?php echo $userid;?>">
                <input type="text" name="Name" value="<?php echo $row['TheName']; ?>" placeholder="إسم الملف">
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

            $fileName = $_FILES['file']['name'];
            $fileSize = $_FILES['file']['size'];
            $fileTmp = $_FILES['file']['tmp_name'];
            $fileType = $_FILES['file']['type'];


            if (!empty($fileName)) {
            $stmt = $con->prepare("SELECT * FROM file".$_SESSION['do']." WHERE UserID = ? LIMIT 1");
            $stmt->execute(array($id));
            $row = $stmt->fetch();
            $oldfile = $row['FileName'];
            unlink("../layout/file/file".$_SESSION['do'] ."/".$oldfile);
            $file = rand(0, 10000000) . '_' . $fileName;
            move_uploaded_file($fileTmp, "../layout/file/file".$_SESSION['do']."/". $file);
            $stmt = $con->prepare("UPDATE file".$_SESSION['do']." SET
                                                    FileName = ?, 
                                                    FileSize = ?
                                                WHERE
                                                    UserID = ?");
            $stmt->execute(array($file, $fileSize, $id));
            }


            if (!empty($thename)) {
            $stmt = $con->prepare("UPDATE file".$_SESSION['do']." SET
                                                    thename = ? 
                                                WHERE
                                                    UserID = ?");
            $stmt->execute(array($thename, $id));
            }

            echo '<h1> تم التعديل </h1>';

        }
    }elseif ($do == 'Delete') {


        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

        $check = checkItem('userid', "file".$_SESSION['do']."", $userid);

        if ($check > 0) {

            echo '<h2> تم الحذف </h2>';

            $stmt = $con->prepare("SELECT FileName FROM file".$_SESSION['do']." WHERE UserID = ? LIMIT 1");
            $stmt->execute(array($userid));
            $row = $stmt->fetch();

            unlink("../layout/file/file". $_SESSION['do'] ."/". $row['FileName']);

            $stmt = $con->prepare("DELETE FROM file".$_SESSION['do']." WHERE UserID = :zuserid");
            $stmt->bindparam(":zuserid", $userid);
            $stmt->execute();
        }
        else {
            $theMsg = 'This ID is not exist';
            redirectHome($theMsg);
        }


    }














    include $tpl . 'footer.php';

}else {
    header('location: logout.php');
    exit();
}

ob_end_flush();