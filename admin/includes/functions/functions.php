<?php 

    function GetLinkCss () {
        global $linkCss;
        if (isset($linkCss)) {
            echo $linkCss;
        }
    }

    function GetLinkjs () {
        global $linkjs;
        if (isset($linkjs)) {
            echo $linkjs;
        }
    }

    function GetTitle () {
        global $pageTitle;
        if (isset($pageTitle)) {
            echo $pageTitle;
        }else {
            echo 'قدرات';
        }
    }

    function Getsrc1 () {
        global $src1;
        if (isset($src1)) {
            echo $src1;
        }else {
            echo 'index.php';
        }
    }


    function Getsrc2 () {
        global $src2;
        if (isset($src2)) {
            echo $src2;
        }else {
            echo 'index.php';
        }
    }


    function Getnamesrc1 () {
        global $namesrc1;
        if (isset($namesrc1)) {
            echo $namesrc1;
        }
    }

    function Getnamesrc2 () {
        global $namesrc2;
        if (isset($namesrc2)) {
            echo $namesrc2;
        }
    }


    function redirectHome ($therMsg, $url = null, $seconds = 3) {
        if ($url == null) {
            $url = 'index.php';
            $link = 'HomePage';
        }else {
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
                $url = $_SERVER['HTTP_REFERER'];
                $link = 'BackPage';
            }else {
                $url = 'index.php';
                $link = 'HomePage';
            }
            
        }
        echo $therMsg;
        echo 'wil be redirect to ' . $link . 'after '. $seconds . 's';
        header('refresh:'.$seconds.';url='.$url);
        exit();
    }






    function checkItem ($select, $from, $value) {
        global $con;
        $statement =  $con->prepare("SELECT $select FROM $from WHERE $select = ?");
        $statement->execute(array($value));
        $count = $statement->rowCount();

        return $count;
    }



    function countItems ($Item, $Table) {
        global $con;
        $stmt2 = $con->prepare("SELECT COUNT($Item) FROM $Table");
        $stmt2->execute();
        return $stmt2->fetchColumn();
    }

    function getDates ($select, $from) {
        global $con;
        $stmt =  $con->prepare("SELECT $select FROM $from");
        $stmt->execute();
        $selector = $stmt->fetch();

        echo $selector[0];
    }


    function createFormlLogin ($msgemail, $msgpass) {
        $table = '
        <form class="form" action="index.php" method="POST">
        <h2 id="login">تسجيل الدخول</h2>
        <div class="mailError">' . $msgemail . '</div>
            <input class="text" type="text" name="mail" placeholder="البريد الإلكتروني">  
        <div class="passError">' . $msgpass . '</div>
        <input class="pass" type="password" name="pass" placeholder="كلمة المرور">
        <div class="buttons">
            <button class="submit">التالي</button>
            <a href="logup.php">إنشاء حساب</a>
        </div>
    </form>
        ';
        echo $table;
    }


    function createTable ($does, $rowname, $rowSize, $tablename, $href) {
        global $con;
        $stmt = $con->prepare("SELECT * FROM " . $tablename . $_SESSION['do'] . "");
        $stmt->execute();
        $rows = $stmt->fetchAll();

        echo '<div class="containertable">';
            echo '<table class="table">';
                echo '<thead>';
                    echo '<tr>';
                        echo '<th>ID#</td>';
                        if (isset($rows[0]['TheName'])){
                        echo '<th>الإسم</th>';
                        }
                        if (isset($rows[0]['Qusemany'])){
                            echo '<th> عدد الأسئلة </th>';
                        }
                        if (isset($rows[0]['ImageName'])){
                            echo '<th> إسم الصورة </th>';
                        }
                        if (isset($rows[0]['FileName'])){
                        echo '<th>إسم الملف</th>';
                        }
                        if (isset($rows[0]['TestName'])) {
                            echo '<th>إسم الإختبار</th>';
                        }
                        if (isset($rows[0]['VideoName'])){
                        echo '<th>إسم الفيديو</th>';
                        }
                        if (isset($rows[0]['UrlName'])){
                        echo '<th> اللينك </th>';
                        }
                        if (isset($rows[0]['FileSize'])){
                        echo '<th>حجم الملف</th>';
                        }
                        if (isset($rows[0]['TestSize'])) {
                            echo '<th>حجم الإختبار</th>';
                        }
                        if (isset($rows[0]['ImageSize'])) {
                            echo '<th>حجم الصورة</th>';
                        }
                        if (isset($rows[0]['VideoSize'])){
                        echo '<th>حجم الفيديو</th>';
                        }
                        if (isset($rows[0]['TheNote'])){
                        echo '<th> محتوى الملاحظة </th>';
                        }
                        echo '<th>يوم الإضافة </th>';
                        echo '<th>لوحة التحكم</th>';
                    echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

        foreach($rows as $row) {
            echo '<tr>';
                echo '<td>' . $row['UserID'] . '</td>';
                if (isset($row['TheName'])) {
                    echo '<td>' . $row['TheName'] . '</td>';
                }
                if (isset($row['Qusemany'])) {
                    echo '<td>' . $row['Qusemany'] . '</td>';
                }
                if (isset($row['TheNote'])){
                    echo '<td>' . $row['TheNote'] . '</td>';
                }
                if (isset($row[''. $rowname .'Name'])) {
                    echo '<td style="direction: ltr" >' . $row[''. $rowname .'Name'] . '</td>';
                }
                if (isset($row[''. $rowSize . 'Size'])) {
                echo '<td>' . $row[''. $rowSize . 'Size'] . '</td>';
                }
                echo '<td>' . $row['Date'] . '</td>';
                echo '<td>
                <a href="' . $href .'?do=Edit&userid=' . $row['UserID'] . '" class="but-green">Edit</a>
                <a href="' . $href . '?do=Delete&userid=' . $row['UserID'] . '" class="but-red confirm">Delet</a>';
                echo '</td>';
            echo '</tr>';
        }

        $table1 = '
                </tbody>
            </table>
            <a href="'. $href .'?do=' . $does . '&do=Add" class="but-blue"> إضافة </a>
        </div>
        ';
        echo $table1;


        
    }



    

    function createForm ($msgemail, $msgpass) {
        $table = '
        <section>
        <form class="form" action="logup.php" method="POST">
            <h2 id="login">إنشاءحساب</h2>
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
                    <div class="mail"> ' . $msgemail .' </div>
                    <input type="text" class="text3" placeholder="البريد الإلكتروني" name="mail" autocomplete="off">
            <div class="noteq"> ' . $msgpass .' </div>
            <div class="name"><span class="Password1Error"></span> <span class="Password2Error"></span> </div>
            <div class="coontainer">
                <div class="inputcont">
                    <input type="text" class="pass1" placeholder="كلمة المرور" name="Password1" autocomplete="new-password">
                </div>
                <div class="inputcont">
                    <span class="Password2Error2"> </span>
                    <input type="password" class="pass2" placeholder="تأكيد كلمة المرور" name="Password2" autocomplete="new-password">
                </div>
            </div>
                <div class="buttons">
                <button class="submit">حفظ</button>
                <span>شروط إنشاء حساب</span>
            </div>
        </form>
        <div class="gallary">
            <div class="containet">
                <div class="ad">يجب ملئ جميع الحقول</div>
                <div class="ad"></div>
                <div class="ad"></div>
                <div class="ad"></div>
            <div>
        </div>
    </section>
        ';
        echo $table;
    }



    function img () {
        $table = '
        <div class="imgs">
        <img src="layout/imags/log in.jpg" alt="" width="100%" height="100%">
        </div>
        ';
        echo $table;
    }

    function createLTFNU ($thetitle) {
        global $con;
        $video;
        if ($_SESSION['do'] == 'tl' || $_SESSION['do'] == 'tk') {
            $video = 't';
        }else {
            $video = 'm';
        }
        $stmt6 = $con->prepare("SELECT * FROM video".$video."");
        $stmt6->execute();
        $rows6 = $stmt6->fetch();
        $count6 = $stmt6->rowCount();
        if ($count6 > 0) {
            echo '<div class="mainvideo" dir="ltr">';
            echo '<h3>';
            echo 'مقدمة';
            if ($video == 't') {
                echo 'تأسيس';
            }else {
                echo 'محوسب';
            }
            echo '</h3>';
            echo '<video id="videoPlayer1" class="video-js vjs-big-play-centered infovideo" data-setup="{}" controls>
                <source src="../layout/video/video' . $video . "/" . $rows6['VideoName'] . ' ">
                <p class="vjs-no-js">
                    To view this video please enable JavaScript, and consider upgrading to a web browser that
                    <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
            </video>';
            echo '</div>';
        }else {
            echo '<h1> مقدمة  </h1>';
        }
        echo '<div class="containertabs">
        <ul class="tabs">
        <li class="active" data-cont=".one" id="thelesones">الدروس</li>
        <li data-cont=".two" id="thetestes">الإختبارات</li>
        <li data-cont=".three">الملفات</li>
        <li data-cont=".four">الملاحظات</li>';
        $stmt1 = $con->prepare("SELECT * FROM url".$video."");
        $stmt1->execute();
        $rows = $stmt1->fetchAll();
        $count = $stmt1->rowCount();
        if ($count > 0) {
            echo '<li data-cont=".five">لينك الحصة</li>';
        }
        echo '</ul>';


        echo '<div class="content">
            <div class="one">';

            $stmt = $con->prepare("SELECT * FROM video" . $_SESSION['do'] . " LIMIT 1");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $count = $stmt->rowCount();

            $stmt1 = $con->prepare("SELECT * FROM video" . $_SESSION['do'] . "");
            $stmt1->execute();
            $rows1 = $stmt1->fetchAll();
            $count = $stmt1->rowCount();

            if ($count == 0) {
                echo '<h2> لم يتم رفع أي درس الرجاء الإنتظار قليلا </h2>';
            }else {
                $row = $stmt->fetch();
                echo '<div class="videos">
                    <div class="container">
                        <div class="holder">
                            <div class="preview">
                                <div class="info">'; foreach($rows as $row) { echo $row['TheName']; } echo' </div>
                                <div class="video" dir="ltr">
                                    <video  id="videoPlayer2" class="video-js vjs-big-play-centered infovideo" data-setup="{}" controls>
                                    <source src="'; foreach($rows as $row) { echo "../layout/video/video" . $_SESSION['do'] . "/".$row['VideoName']; } echo '">';
                                    echo '</video>
                                </div>
                            </div>';
                            echo '<div class="list">
                            <div class="name"> ' . $thetitle . ' </div>
                            <ul>
                            '; foreach($rows1 as $row) { 
                                echo '<li data-src="../layout/video/video' . $_SESSION['do'] . '/' . $row['VideoName'] .'"> ' . $row['TheName'] . ' </li>';
                            }
                            echo '
                            </ul>
                        </div>
                    </div>
                </div>
            </div>';
        }
        echo '</div>';

        echo '<div class="two">';
            $stmt = $con->prepare("SELECT * FROM test" . $_SESSION['do'] . "");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if ($stmt->rowCount() > 0) {
                echo '<div class="continaer">';
                    foreach($rows as $row) {
                        echo '<a href="thetest.php?test='. $row['UserID'] .'">';
                            echo '<div class="title"> ' . $row['TheName'] . ' </div>';
                                echo '<div class="icon">';
                                echo '<span> ' . $row['Qusemany'] . ' سؤال </span>';
                                echo '<span> ';
                                if ($row['Qusemany'] >= 96) {
                                    echo '100';
                                }else {
                                    echo $row['Qusemany'];
                                }
                                echo ' دقيقة </span>';
                                echo '<i class="fas fa-unlock"></i>';
                            echo '</div>';
                        echo '</a>';
                    }
                echo '</div>';
            }else {
                echo '<h2> لم يتم رفع أي إختبار </h2>';
            }
            echo '</div>';

        echo '<div class="three">';
        $stmt1 = $con->prepare("SELECT * FROM file" . $_SESSION['do'] . "");
        $stmt1->execute();
        $rows = $stmt1->fetchAll();
        $count = $stmt1->rowCount();
        if ($count == 0) {
            echo '<h2> لم يتم رفع أي ملف  </h2>';
        }else {
            foreach($rows as $row) {
                echo '<a href="../layout/file/file'. $_SESSION['do'] .''."/".''.$row['FileName'] .'" download>';
                    echo '<div class="title"> ' . $row['TheName'] . ' </div>';
                        echo '<div class="icon">';
                        echo '<i class="fas fa-unlock"></i>';
                    echo '</div>';
                echo '</a>';
            }
        }
        echo '</div>';

            $stmt3 = $con->prepare("SELECT * FROM note" . $_SESSION['do'] . "");
            $stmt3->execute();
            $rows3 = $stmt3->fetchAll();
            $count3 = $stmt3->rowCount();
            echo '<div class="four">';
            if ($count3 > 0) {
                foreach($rows3 as $row) {
                echo '<div class="thenote"> ' . $row['TheNote'] . ' </div>';
                }
            }else {
                echo '<h2> لم يتم رفع أي ملاحظة </h2>';
            }
                echo '</div>';

            $stmt2 = $con->prepare("SELECT * FROM url".$video."");
            $stmt2->execute();
            $rows2 = $stmt2->fetchAll();
            $count1 = $stmt2->rowCount();
        if ($count1 > 0) {
            echo '<div class="five">';
            foreach($rows2 as $row) {
            echo '<a href="'. $row['UrlName'] .'">  إضغط هنا للدخول إلى الحصة المباشرة </a>';
            }
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';


        }
    // }