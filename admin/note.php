<?php
ob_start();
session_start();

if (isset($_SESSION['Usename'])) {

    $pageTitle = "theNotes";
    $linkCss = "";
    $linkjs = "";
    $src1 = "memberspage.php?do=T";
    $src2 = "memberspage.php?do=M";
    $namesrc1 = "التأسيس";
    $namesrc2 = "المحوسب";

    include 'init.php';


    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

    if ($do == 'Manage') {
        echo '<h1>الملاحظات </h1>';
        ?>

        <div class="containerdash">

        <a href="note.php?do=TK">
            <div>
                ملاحظات تأسيس الكمي
                <span>  </span>
            </div>
        </a>


        <a href="note.php?do=TL">
            <div>
                ملاحظات تأسيس اللفظي
                <span>  </span>
            </div>
        </a>


        <a href="note.php?do=MK">
            <div>
                ملاحظات محوسب الكمي
                <span>  </span>
            </div>
        </a>

        
        <a href="note.php?do=ML">
            <div>
                ملاحظات محوسب اللفظي 
                <span>  </span>
            </div>
        </a>

        
        <a href="note.php?do=BENEFIT">
            <div>
                فائدة الدورة
                <span>  </span>
            </div>
        </a>

        
        <a href="note.php?do=LOOK">
            <div>
                لمحة عنا
                <span>  </span>
            </div>
        </a>


    </div>

    <?php

    }elseif ($do == 'TK') {
        $_SESSION['do'] = 'tk';
        echo '<h1>تأسيس كمي </h1>'; 
        createTable ('TK', 'The', '', 'note', 'note.php');

    }elseif ($do == 'TL') {
        $_SESSION['do'] = 'tl';
        echo '<h1>تأسيس لفظي </h1>'; 
        createTable ('TL', 'The', '', 'note', 'note.php');

    }elseif ($do == 'MK') {
        $_SESSION['do'] = 'mk';
        echo '<h1>محوسب كمي </h1>'; 
        createTable ('MK', 'The', '', 'note', 'note.php');

    }elseif ($do == 'ML') {
        $_SESSION['do'] = 'ml';
        echo '<h1>محوسب لفظي </h1>'; 
        createTable ('ML', 'The', '', 'note', 'note.php');

    }elseif ($do == 'LOOK') {

        $_SESSION['do'] = 'lookus';
        echo '<h1> فائدة عنا </h1>'; 
        createTable ('LOOK', 'The', '', 'note', 'note.php');

    }elseif ($do == 'BENEFIT') {
        $_SESSION['do'] = 'benefit';
        echo '<h1>  </h1>'; 
        createTable ('BENEFIT', 'The', '', 'note', 'note.php');

    }

    elseif ($do == 'Add') { ?>

        <form action="note.php?do=Add&do=Insert" method="POST" enctype="multipart/form-data" class="add">
            <input type="text" name="Name" placeholder="الملاحظة">
            <input type="submit" value="submit">
        </form>

    <?php
    }elseif ($do == "Insert") {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo '<h1> تم الإرسال </h1>';

        $thenote = $_POST['Name'];


        $formError = [];

        if (empty($thenote)) {
            $formError [] = 'لم تكتب الملاحظة';
        }


        foreach($formError as $error) {
            echo '<h2>' . $error . '</h2>';
        }

            if (empty($formError)) {

                        $stmt = $con->prepare("INSERT INTO 
                                            note".$_SESSION['do']."(TheNote, Date)
                                            VALUES(:zTheNote, now())");
                $stmt->execute(array(
                'zTheNote'  => $thenote
                ));
            }



        }else {

        }


    }elseif ($do == 'Edit') {

        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

        $stmt = $con->prepare("SELECT * FROM note" . $_SESSION['do'] . " WHERE UserID = ? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($stmt->rowCount() > 0) { ?>

                <form action="note.php?do=Update" method="POST" enctype="multipart/form-data" class="add">
                <input type="hidden" name="userid" value="<?php echo $userid;?>">
                <input type="text" name="Name" value="<?php echo $row['TheNote']; ?>" placeholder= "الملاحظة">
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
            $stmt = $con->prepare("UPDATE note".$_SESSION['do']." SET
                                                    TheNote = ? 
                                                WHERE
                                                    UserID = ?");
            $stmt->execute(array($thenote, $id));
            }

            echo '<h1> تم التعديل </h1>';

        }
    }elseif ($do == 'Delete') {


        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

        $check = checkItem('userid', "note".$_SESSION['do']."", $userid);

        if ($check > 0) {

            echo '<h2> تم الحذف </h2>';

            $stmt = $con->prepare("DELETE FROM note".$_SESSION['do']." WHERE UserID = :zuserid");
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
