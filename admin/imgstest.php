<?php

    ob_start();
    session_start();

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

    if (isset($_SESSION['Usename'])) {
        $pageTitle = "صور إختبارات";
        $src1 = "";
        $src2 = "";
        $namesrc1 = "";
        $namesrc2 = "";
        include 'init.php';

        if ($do == 'Manage') {
            echo '<div class="containerdash">';
        echo'<a href="imgstest.php?do=TK">
                <div>
                صور إختبارات تأسيس كمي
                <span>  </span>
                </div>
                </a>';
        echo'<a href="imgstest.php?do=TL">
                <div>
                صور إختبارات تأسيس لفظي
                    <span>  </span>
                </div>
            </a>';
        echo'<a href="imgstest.php?do=TM">
                <div>
                صور إختبارات تأسيس محاكاة
                    <span>  </span>
                </div>
            </a>';
        echo'<a href="imgstest.php?do=MK">
                <div>
                صور إختبارت محوسب كمي
                    <span>  </span>
                </div>
            </a>';
        echo'<a href="imgstest.php?do=ML">
                <div>
                صور إختبارت محوسب لفظي
                    <span>  </span>
                </div>
            </a>';
        echo'<a href="imgstest.php?do=MM">
                <div>
                صور إختبارت محوسب محاكاة
                    <span>  </span>
                </div>
            </a>';
        echo'<a href="imgstest.php?do=EQ">
                <div>
                صورة المعادلات
                    <span>  </span>
                </div>
            </a>';
        echo '</div>';
        }elseif ($do == 'TK') {

            $_SESSION['do'] = "tk";
            echo '<h1> صور إختبارات تأسيس كمي </h1>';
            createTable ('TK', 'Image', 'Image', 'images', 'imgstest.php');

        }elseif ($do == 'TL') {

            $_SESSION['do'] = "tl";
            echo '<h1> صور إختبارات تأسيس لفظي </h1>';
            createTable ('TL', 'Image', 'Image', 'images', 'imgstest.php');

        }elseif ($do == 'TM') {

            $_SESSION['do'] = "tm";
            echo '<h1> صور إختبارات تأسيس محاكاة </h1>';
            createTable ('TM', 'Image', 'Image', 'images', 'imgstest.php');

        }elseif ($do == 'MK') {

            $_SESSION['do'] = "mk";
            echo '<h1> صور إختبارات محوسب كمي </h1>';
            createTable ('MK', 'Image', 'Image', 'images', 'imgstest.php');

        }elseif ($do == 'ML') {

            $_SESSION['do'] = "ml";
            echo '<h1> صور إختبارات محوسب لفظي </h1>';
            createTable ('ML', 'Image', 'Image', 'images', 'imgstest.php');

        }elseif ($do == 'MM') {

            $_SESSION['do'] = "mm";
            echo '<h1> صور إختبارات محوسب محاكاة </h1>';
            createTable ('MM', 'Image', 'Image', 'images', 'imgstest.php');

        }elseif ($do == 'EQ') {

            $_SESSION['do'] = "eq";
            echo '<h1> صورة المعادلات </h1>';
            createTable ('EQ', 'Image', 'Image', 'images', 'imgstest.php');

        }

        elseif ($do == 'Add') { ?>

            <form action="imgstest.php?&do=Add&do=Insert" method="POST" enctype="multipart/form-data" class="add">
                <input type="file" name="file[]" multiple="multiple" id="file">
                <input type="submit" value="submit">
            </form>
    
        <?php
        }elseif ($do == "Insert") {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo '<h1> تم الإرسال </h1>';

            $fileName = $_FILES['file']['name'];
            $fileSize = $_FILES['file']['size'];
            $fileTmp = $_FILES['file']['tmp_name'];
            $fileType = $_FILES['file']['type'];
            $fileError = $_FILES['file']['error'];

            $fielCount = count($fileName);

            $fileAllowedExte = array("jpg", "gif", "jpeg", "png");

            for ($i = 0; $i < $fielCount; $i++) {

                $fileE = pathinfo($fileName[$i], PATHINFO_EXTENSION);
                $formError = [];
                if (!empty($fileName[$i])  && !in_array($fileE, $fileAllowedExte)) {
                    $formError [] = 'إمتداد الصورة رقم ' . ($i + 1) . 'غير مسموح به';
                }
                foreach($formError as $error) {
                    echo '<h1>' . $error . '</h1>';
                }
                    if ($fileError[0] == 4) {
                        echo '<h1> لم يتم رفع أي صورة </h1>';
                    }else {
                        $file = rand(0, 10000000) . '_' . $fileName[$i];
                        move_uploaded_file($fileTmp[$i], "../layout/json/json".$_SESSION['do']."/images" . "/" . $file);
                                $stmt = $con->prepare("INSERT INTO 
                                                    images".$_SESSION['do']."(ImageName, ImageSize, Date)
                                                    VALUES(:zImageName, :zImageSize, now())");
                        $stmt->execute(array(
                        'zImageName' => $file,
                        'zImageSize' => $fileSize[$i]
                        ));
                    }


            }

    
            }else {
                $theMsg = 'يجب تعبئة النموذج';
                redirectHome($theMsg);
            }
    
    
        }elseif ($do == 'Edit') {
    
            $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;
    
            $stmt = $con->prepare("SELECT * FROM images".$_SESSION['do']." WHERE UserID = ? LIMIT 1");
            $stmt->execute(array($userid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
    
            if ($stmt->rowCount() > 0) { ?>
                    <form action="imgstest.php?do=Update" method="POST" enctype="multipart/form-data" class="add">
                    <input type="hidden" name="userid" value="<?php echo $userid;?>">
                    <input type="file" name="file" id="file">
                    <input type="submit" value="submit">
                    </form>
    
    <?php
            }else {
                $theMsg = 'لا يوجد';
                redirectHome($theMsg);
            }
    
        }elseif ($do == 'Update') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
                $id = $_POST['userid'];
    
                $fileName = $_FILES['file']['name'];
                $fileSize = $_FILES['file']['size'];
                $fileTmp = $_FILES['file']['tmp_name'];
                $fileType = $_FILES['file']['type'];
    
    
                if (!empty($fileName)) {
                $stmt = $con->prepare("SELECT * FROM images".$_SESSION['do']." WHERE UserID = ? LIMIT 1");
                $stmt->execute(array($id));
                $row = $stmt->fetch();
                $oldfile = $row['ImageName'];
                unlink("../layout/json/json".$_SESSION['do']."/images" . "/" .$oldfile);
                $file = rand(0, 10000000) . '_' . $fileName;
                move_uploaded_file($fileTmp, "../layout/json/json".$_SESSION['do']."/images" . "/". $file);
                $stmt = $con->prepare("UPDATE images".$_SESSION['do']." SET
                                                        ImageName = ?, 
                                                        ImageSize = ?
                                                    WHERE
                                                        UserID = ?");
                $stmt->execute(array($file, $fileSize, $id));
                }

                echo '<h1> تم التعديل </h1>';
                
            }
        }elseif ($do == 'Delete') {

            $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

            $check = checkItem('userid', "images".$_SESSION['do']."", $userid);

            if ($check > 0) {

                $stmt = $con->prepare("SELECT ImageName FROM images".$_SESSION['do']." WHERE UserID = ? LIMIT 1");
                $stmt->execute(array($userid));
                $row = $stmt->fetch();

                unlink("../layout/json/json".$_SESSION['do']."/images" . "/" .$row['ImageName']);

                $stmt = $con->prepare("DELETE FROM images".$_SESSION['do']." WHERE UserID = :zuserid");
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