<?php 

ob_start();

session_start();
if (isset($_SESSION['Usename'])) {

    $pageTitle = "links";
    $src1 = "memberspage.php?do=T";
    $src2 = "memberspage.php?do=M";
    $namesrc1 = "التأسيس";
    $namesrc2 = "المحوسب";
    include 'init.php';

    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    
    if ($do == 'Manage') { 
        echo '<div class="containerdash">';
        echo'<a href="linkurl.php?do=T">
        <div>
        لينك حصة تأسيس 
        <span>  </span>
                </div>
            </a>';
        echo'<a href="linkurl.php?do=M">
                <div>
                لينك حصة محوسب 
                <span>  </span>
                </div>
                </a>';
        echo'<a href="linkurl.php?do=facebook">
                <div>
                رابط facebook
                    <span>  </span>
                </div>
            </a>';
        echo'<a href="linkurl.php?do=twitter">
                <div>
                رابط twitter
                    <span>  </span>
                </div>
            </a>';
        echo'<a href="linkurl.php?do=instagram">
                <div>
                رابط instagram
                    <span>  </span>
                </div>
            </a>';
        echo'<a href="linkurl.php?do=snapchat">
                <div>
                رابط snapchat
                    <span>  </span>
                </div>
            </a>';
        echo'<a href="linkurl.php?do=whtsapp">
                <div>
                رابط whtsapp
                    <span>  </span>
                </div>
            </a>';
        echo'<a href="linkurl.php?do=mill">
                <div>
                رابط mail
                    <span>  </span>
                </div>
            </a>';
        echo '</div>';
    }

    if ($do == 'M') {

        $_SESSION['do'] = "m";
        echo '<h1> حصة محوسب </h1>';
        createTable ('M', 'Url', 'Url', 'url', 'linkurl.php');

    }elseif ($do == 'T') {

        $_SESSION['do'] = "t";
        echo '<h1> حصة تأسيس </h1>';
        createTable ('T', 'Url', 'Url', 'url', 'linkurl.php');

    }elseif ( $do == 'facebook') {

        $_SESSION['do'] = "facebook";
        echo '<h1> رابط facebook </h1>';
        createTable ('facebook', 'Url', 'Url', 'url', 'linkurl.php');

    }elseif ( $do == 'twitter') {

        $_SESSION['do'] = "twitter";
        echo '<h1>  رابط twitter </h1>';
        createTable ('twitter', 'Url', 'Url', 'url', 'linkurl.php');

    }elseif ( $do == 'instagram') {

        $_SESSION['do'] = "instagram";
        echo '<h1>  رابط instagram </h1>';
        createTable ('instagram', 'Url', 'Url', 'url', 'linkurl.php');

    }elseif ( $do == 'snapchat') {

        $_SESSION['do'] = "snapchat";
        echo '<h1>  رابط snapchat </h1>';
        createTable ('snapchat', 'Url', 'Url', 'url', 'linkurl.php');

    }elseif ( $do == 'whtsapp') {

        $_SESSION['do'] = "whtsapp";
        echo '<h1>  رابط whtsapp </h1>';
        createTable ('whtsapp', 'Url', 'Url', 'url', 'linkurl.php');

    }elseif ( $do == 'mill') {

        $_SESSION['do'] = "mill";
        echo '<h1>  رابط mill </h1>';
        createTable ('mill', 'Url', 'Url', 'url', 'linkurl.php');

    }




    elseif ($do == 'Add') { ?>

        <form action="linkurl.php?do=Add&do=Insert" method="POST" enctype="multipart/form-data" class="add">
            <input type="text" name="Name" placeholder="الرابط">
            <input type="submit" value="submit">
        </form>

    <?php
    }elseif ($do == "Insert") {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo '<h1> تم الإرسال </h1>';

        $thenote = $_POST['Name'];


        $formError = [];

        if (empty($thenote)) {
            $formError [] = 'لم تكتب الرابط';
        }


        foreach($formError as $error) {
            echo '<h2>' . $error . '</h2>';
        }

            if (empty($formError)) {

                        $stmt = $con->prepare("INSERT INTO 
                                            url".$_SESSION['do']."(UrlName, Date)
                                            VALUES(:zUrlName, now())");
                $stmt->execute(array(
                'zUrlName'  => $thenote
                ));
            }



        }else {

        }


    }elseif ($do == 'Edit') {

        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

        $stmt = $con->prepare("SELECT * FROM url" . $_SESSION['do'] . " WHERE UserID = ? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($stmt->rowCount() > 0) { ?>

                <form action="linkurl.php?do=Update" method="POST" enctype="multipart/form-data" class="add">
                <input type="hidden" name="userid" value="<?php echo $userid;?>">
                <input type="text" name="Name" value="<?php echo $row['UrlName']; ?>" placeholder= "الرابط">
                <input type="submit" value="submit">
                </form>

<?php
        }else {

        }

    }elseif ($do == 'Update') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['userid'];
            $thenote = $_POST['Name'];

            if (!empty($thenote)) {
            $stmt = $con->prepare("UPDATE url".$_SESSION['do']." SET
                                                    UrlName = ? 
                                                WHERE
                                                    UserID = ?");
            $stmt->execute(array($thenote, $id));
            }

            echo '<h1> تم التعديل </h1>';

        }
    }elseif ($do == 'Delete') {


        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

        $check = checkItem('userid', "url".$_SESSION['do']."", $userid);

        if ($check > 0) {

            echo '<h2> تم الحذف </h2>';

            $stmt = $con->prepare("DELETE FROM url".$_SESSION['do']." WHERE UserID = :zuserid");
            $stmt->bindparam(":zuserid", $userid);
            $stmt->execute();
        }
        else {
            $theMsg = 'This ID is not exist';
            redirectHome($theMsg);
        }

    }


        ?>

<?php
        include $tpl . "footer.php";
    }else {
        header('location: index.php');
        exit();
    }
    ob_end_flush();
?>