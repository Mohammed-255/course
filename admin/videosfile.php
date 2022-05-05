<?php 

ob_start();

session_start();
if (isset($_SESSION['Usename'])) {

    $pageTitle = "videoes";
    $src1 = "memberspage.php?do=T";
    $src2 = "memberspage.php?do=M";
    $namesrc1 = "التأسيس";
    $namesrc2 = "المحوسب";

    include 'init.php';

    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    
    if ($do == 'Manage') { 
        echo '<h1> الفيدوهات </h1>';
        ?>

        <div class="containerdash">

            <a href="videosfile.php?do=TK">
                <div>
                    فيدوهات تأسيس الكمي
                    <span>  </span>
                </div>
            </a>


            <a href="videosfile.php?do=TL">
                <div>
                    فيدوهات تأسيس اللفظي
                    <span>  </span>
                </div>
            </a>


            <a href="videosfile.php?do=MK">
                <div>
                    فيدوهات محوسب الكمي 
                    <span>  </span>
                </div>
            </a>


            <a href="videosfile.php?do=ML">
                <div>
                    فيدوهات محوسب اللفظي 
                    <span>  </span>
                </div>
            </a>


            <a href="videosfile.php?do=M">
                <div>
                مقدمة محوسب  
                    <span>  </span>
                </div>
            </a>


            <a href="videosfile.php?do=T">
                <div>
                مقدمة تأسيس  
                    <span>  </span>
                </div>
            </a>

        </div>

    <?php


    }elseif ($do == 'TK'){

        $_SESSION['do'] = "tk";
        echo '<h1> تأسيس كمي </h1>';
        createTable ('TK', 'Video', 'Video', 'video', 'videosfile.php');

    }elseif ($do == 'TL'){

        $_SESSION['do'] = "tl";
        echo '<h1> تأسيس لفظي </h1>';
        createTable ('TL', 'Video', 'Video', 'video', 'videosfile.php');


    }elseif ($do == 'MK'){

        $_SESSION['do'] = "mk";
        echo '<h1> محوسب كمي </h1>';
        createTable ('MK', 'Video', 'Video', 'video', 'videosfile.php');

    }elseif ($do == 'ML'){

        $_SESSION['do'] = "ml";
        echo '<h1> محوسب لفظي </h1>';
        createTable ('ML', 'Video', 'Video', 'video', 'videosfile.php');

    }elseif ($do == 'M'){
        
        $_SESSION['do'] = "m";
        echo '<h1> محوسب لفظي </h1>';
        createTable ('ML', 'Video', 'Video', 'video', 'videosfile.php');

    }elseif ($do == 'T'){

        $_SESSION['do'] = "t";
        echo '<h1> محوسب لفظي </h1>';
        createTable ('ML', 'Video', 'Video', 'video', 'videosfile.php');

    }



    if ($do == 'Add') { ?>

        <form action="videosfile.php?do=TK&do=Add&do=Insert" method="POST" enctype="multipart/form-data" class="add">
            <input type="text" name="Name">
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

        $fileAllowedExte = array("mp4");
        
        $fileE = pathinfo($fileName, PATHINFO_EXTENSION);

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
            echo '<h1>' . $error . '</h1>';
        }

            if (empty($formError)) {

                $file = rand(0, 10000000) . '_' . $fileName;

                move_uploaded_file($fileTmp, "../layout/video/video".$_SESSION['do']."/" . $file);



                        $stmt = $con->prepare("INSERT INTO 
                                            video".$_SESSION['do']."(TheName, VideoName, VideoSize, Date)
                                            VALUES(:zTheName, :zVideoName, :zVideoSize, now())");
                $stmt->execute(array(
                'zTheName' => $thename,
                'zVideoName' => $file,
                'zVideoSize' => $fileSize
                ));

            }



        }else {

        }


    }elseif ($do == 'Edit') {

        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

        $stmt = $con->prepare("SELECT * FROM video".$_SESSION['do']." WHERE UserID = ? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($stmt->rowCount() > 0) { ?>
                <form action="videosfile.php?do=Update" method="POST" enctype="multipart/form-data" class="add">
                <input type="hidden" name="userid" value="<?php echo $userid;?>">
                <input type="text" name="Name" value="<?php echo $row['TheName']; ?>">
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
            $stmt = $con->prepare("SELECT * FROM video".$_SESSION['do']." WHERE UserID = ? LIMIT 1");
            $stmt->execute(array($id));
            $row = $stmt->fetch();
            $oldfile = $row['VideoName'];
            unlink("../layout/video/video".$_SESSION['do']."/".$oldfile);
            $file = rand(0, 10000000) . '_' . $fileName;
            move_uploaded_file($fileTmp, "../layout/video/video".$_SESSION['do']."/". $file);
            $stmt = $con->prepare("UPDATE video".$_SESSION['do']." SET
                                                    VideoName = ?, 
                                                    VideoSize = ?
                                                WHERE
                                                    UserID = ?");
            $stmt->execute(array($file, $fileSize, $id));
            }


            if (!empty($thename)) {
                $stmt = $con->prepare("UPDATE video".$_SESSION['do']." SET 
                                                        TheName = ? 
                                                            WHERE 
                                                        UserID = ?");
                $stmt->execute(array($thename, $id));
            }

            echo '<h1> تم التعديل </h1>';
            
        }
    }elseif ($do == 'Delete') {


        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

        $check = checkItem('userid', "video".$_SESSION['do']."", $userid);

        if ($check > 0) {

            $stmt = $con->prepare("SELECT VideoName FROM video".$_SESSION['do']." WHERE UserID = ? LIMIT 1");
            $stmt->execute(array($userid));
            $row = $stmt->fetch();

            unlink("../layout/video/video".$_SESSION['do']."/".$row['VideoName']);

            $stmt = $con->prepare("DELETE FROM video".$_SESSION['do']." WHERE UserID = :zuserid");
            $stmt->bindparam(":zuserid", $userid);
            $stmt->execute();

            echo '<h1> تم الحذف </h1>';
        }
        else {
            $theMsg = 'This ID is not exist';
            redirectHome($theMsg);
        }


    }













    include $tpl . "footer.php";
    
}else {
    header('location: index.php');
    exit();
}

ob_end_flush();