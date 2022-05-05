<?php
ob_start();

session_start();

if (isset($_SESSION['Usename'])) {

    $pageTitle = "members";

    $linkCss = "logup.css";

    $linkjs = "logup.js";

    $src1 = "memberspage.php?do=T";
    $src2 = "memberspage.php?do=M";
    $namesrc1 = "التأسيس";
    $namesrc2 = "المحوسب";

    include 'init.php';


    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

    if ($do == 'Manage') { 

        $query = '';
        if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
            $query = 'AND RegStatus = 0';
        }


        $stmt = $con->prepare("SELECT * FROM userss WHERE GroupID != 1 $query");
        $stmt->execute();

        $rows= $stmt->fetchAll();

        ?>


        <h1>Manage member</h1>
        
        <div class="containertable">
        <table class="table">
        <thead>
            <tr>
                <th>ID#</td>
                <th>الإسم</th>
                <th>إسم الأب</th>
                <th>البريد الإكتروني</th>
                <th>يوم تسجيل الدخول</th>
                <th>لوحة التحكم</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach($rows as $row) {

                echo '<tr>';
                    echo '<td>' . $row['UserID'] . '</td>';
                    echo '<td>' . $row['FirstName'] . '</td>';
                    echo '<td>' . $row['SecondName'] . '</td>';
                    echo '<td>' . $row['Email'] . '</td>';
                    echo '<td>' . $row['Date'] . '</td>';
                    echo '<td>
                    <a href="members.php?do=Edit&userid= ' . $row['UserID'] . ' " class="but-green">Edit</a>
                    <a href="members.php?do=Delete&userid= ' . $row['UserID'] . ' " class="but-red confirm">Delet</a>';
                    if ($row['RegStatus'] == 0) {
                        echo '<a href="members.php?do=Activate&userid= ' . $row['UserID'] . ' " class="but-blue Activate">Activate</a>';
                    }

                    echo '</td>';
                echo '</tr>';
            
            }
            ?>
        </tbody>
        </table>
            <a href="members.php?do=Add" class="but-blue"> add new member </a>
        </div>




        <?php
    }elseif ($do == 'Add') { ?>


            <section>
                <form class="form" action="?do=Insert" method="POST">
                        <h2 id="login">إضافة عضو جديد</h2>
                        <div class="name"><span class="FirstNameError"></span> <span class="SecondNameError"></span> </div>
                        <div class="coontainer">
                            <div class="inputcont">
                                <input type="text" class="text1" placeholder="الإسم الأول" name="FirstName" autocomplete="off">
                            </div>
                            <div class="inputcont">
                                <span class="SecondNameError2"></span>
                                <input type="text" class="text2" placeholder="إسم الأب"   name="SecondName" autocomplete="off">
                            </div>
                        </div>

                                <div class="mail"></div>
                                <input type="text" class="text3" placeholder="البريد الإلكتروني" name="mail" autocomplete="off">

                        <div class="noteq"></div>
                        <div class="name"><span class="Password1Error"></span> <span class="Password2Error"></span> </div>
                        <div class="coontainer">
                            <div class="inputcont">
                                <input type="text" class="pass1" placeholder="كلمة المرور" name="Password1" autocomplete="new-password">
                            </div>
                            <div class="inputcont">
                                <span class="Password2Error2"></span>
                                <input type="password" class="pass2" placeholder="تأكيد كلمة المرور" name="Password2" autocomplete="new-password">
                            </div>
                        </div>


                            <div class="buttons">
                            <button class="submit">حفظ</button>
                        </div>
                    </form>
            </section>


<?php

    }elseif ($do == 'Insert') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo '<h1>Add new member</h1>';

            $Fname          = $_POST['FirstName'];
            $Sname          = $_POST['SecondName'];
            $email          = $_POST['mail'];
            $pass1          = $_POST['Password1'];
            $pass2          = $_POST['Password2'];
            $hashpass       = sha1($pass1);


            $formErrors = array();


            if (empty($pass1)) {
                $formErrors[] = 'password can not be empty';
            }
            if (empty($email)) {
                $formErrors[] = 'email can not be empty';
            }

            foreach($formErrors as $error) {
                echo $error . '<br/>';
            }

            if (empty($formErrors)) {


                $check = checkItem('Password', 'userss', $hashpass);

                $check1 = checkItem('Email', 'userss', $email);

                if ($check > 0 && $check > 0) {
                $theMsg = 'Sorry This email is exist and pass';
                redirectHome($theMsg, 'back');
                }elseif ($check > 0) {
                    $theMsg = 'Sorry This Password is exist';
                    redirectHome($theMsg, 'back');
                }elseif ($check1 > 0) {
                    $theMsg = 'Sorry This email is exist';
                    redirectHome($theMsg, 'back');
                }else {
                                        $stmt = $con->prepare("INSERT INTO 
                                        userss(FirstName, SecondName, Email, Password, RegStatus, Date)
                                        VALUES(:Fname, :Sname, :email, :pass1, 1, now())");
                    $stmt->execute(array(
                    'Fname' => $Fname,
                    'Sname' => $Sname,
                    'email' => $email,
                    'pass1' => $hashpass
                    ));

                    $theMsg = $stmt->rowCount() . 'Record Updated';
                    redirectHome($theMsg, 'back');
                    }
                }

        }
        else {
            $theMsg = 'sorry you can not browse this page direcly';
            redirectHome($theMsg);
        }


    }elseif ($do == 'Edit') {
        
        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

            $stmt = $con->prepare("SELECT * FROM userss WHERE UserID = ? LIMIT 1");
            $stmt->execute(array($userid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            if ($stmt->rowCount() > 0) {

        ?>


                            <h1>Edit member</h1>

                            <form action="?do=Update" class="login" method="POST">

                                <input type="hidden" name="userid" value="<?php echo $userid;?>">

                                
                                <div>
                                    <label for="FirstName">الإسم الأول</label>
                                    <input type="text" name="FirstName" id="FirstName" value="<?php echo $row['FirstName']; ?>" autocomplete="off">
                                </div>



                                <div>
                                    <label for="SecondName">إسم الأب</label>
                                    <input type="text" name="SecondName" id="SecondName" value="<?php echo $row['SecondName']; ?>" autocomplete="off">
                                </div>


                                
                                <div>
                                    <label for="Email">البريد الإلكتروني</label>
                                    <input type="text" name="email" id="Email" value="<?php echo $row['Email']; ?>" autocomplete="off">
                                </div>
                                
                                
                                <div>
                                    <label for="Password1">كلمة المرور</label>
                                    <input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>">
                                    <input type="password" name="newpassword1" id="Password1" autocomplete="new-password">
                                </div>


                                <div>
                                    <label for="Password2">تأكيد كلمة المرور</label>
                                    <input type="password" name="newpassword2" id="Password2" autocomplete="new-password">
                                </div>




                                <div>
                                    <input type="submit" value="Save" autocomplete="off">
                                </div>


                            </form>






<?php
        }else {
            $theMsg = 'there is not this ID';
            redirectHome($theMsg);
        }
    }elseif ($do == 'Update') {

        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            echo '<h1>upedate member</h1>';

            $id     = $_POST['userid'];
            $Fname   = $_POST['FirstName'];
            $Sname   = $_POST['SecondName'];
            $email  = $_POST['email'];

            $pass = '';

            $pass = empty($_POST['newpassword1']) ? $_POST['oldpassword'] : sha1($_POST['newpassword1']);

            $formErrors = array();


            if (empty($email)) {
                $formErrors[] = 'email can not be empty';
            }


            foreach($formErrors as $error) {
                echo $error . '<br/>';
            }




            if (empty($formErrors)) {

                $checkpass = sha1($_POST['newpassword1']);

                $check = checkItem('Password', 'userss', $checkpass);


                if ($check > 0) {
                    $theMsg = 'عذرا كلمة المرور هذه مستعملة';
                    redirectHome($theMsg, 'back');
                }else {

                    $stmt = $con->prepare("UPDATE userss SET FirstName = ?, SecondName = ?, Email = ?, Password = ? WHERE UserID = ?");
                    $stmt->execute(array($Fname, $Sname, $email, $pass, $id));

                    $theMsg = $stmt->rowCount() . 'Record Updated';
                    redirectHome($theMsg, 'back');
                }



            }





        }else {
            $theMsg = 'sorry you can not browse this page direcly';
            redirectHome($theMsg);
        }

    }elseif ($do == 'Delete') {

        echo '<h1> Delete Member </h1>';

        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

        $check = checkItem('userid', 'userss', $userid);

            if ($check > 0) {

                $stmt = $con->prepare("DELETE FROM userss WHERE UserID = :zuserid");
                $stmt->bindparam(":zuserid", $userid);
                $stmt->execute();

                $theMsg = $stmt->rowCount() . 'Record Delete';
                redirectHome($theMsg, 'members.php?do=Manage', 0);

            }else {
                $theMsg = 'This ID is not exist';
                redirectHome($theMsg);
            }


    }elseif ($do == 'Activate') {


        echo '<h1> Activate Member </h1>';

        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

        $check = checkItem('userid', 'userss', $userid);

            if ($check > 0) {

                $stmt = $con->prepare("UPDATE userss SET RegStatus = 1 WHERE UserID = ?");

                $stmt->execute(array($userid));

                $theMsg = $stmt->rowCount() . 'Record Activate';
                redirectHome($theMsg);

            }else {
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