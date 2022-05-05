<?php
    ob_start();
    session_start();

    if (isset($_SESSION['Usename1'])) {
        
        include 'connect.php';
        include 'includes/functions/functions.php';

        $thetest = (isset($_GET['test']) && is_numeric($_GET['test'])) ? intval($_GET['test']) : 0;


        $stmt = $con->prepare("SELECT TestName FROM test".$_SESSION['do']." WHERE UserID = ? LIMIT 1");
        $stmt->execute(array($thetest));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {
            $thejson = $row['TestName'];
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="layout/css/all.min.css">
                <link rel="stylesheet" href="layout/css/normalize.css">
                <link rel="stylesheet" href="../layout/css/QuzeApp.css">
                <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Noto+Naskh+Arabic:wght@400;500;600;700&family=Work+Sans:ital,wght@0,700;1,200;1,500&display=swap" rel="stylesheet">
                <title>إختبار</title>
            </head>
            <body>

            <div class="page-title">
                <?php
                if ($_SESSION['do'] == 'tk') {
                    echo 'إختبار تأسيس كمي';
                }elseif ($_SESSION['do'] == 'tl') {
                    echo 'إختبار تأسيس لفظي';
                }elseif ($_SESSION['do'] == 'mk') {
                    echo 'إختبار محوسب كمي';
                }elseif ($_SESSION['do'] == 'ml') {
                    echo 'إختبار محوسب لفظي';
                }
                ?>
            </div>

            <div class="countdown">
                <div class="value-container"></div>
                <svg>
                    <circle class="circle"cx="65" cy="65" r="55" strok-linecap="round"/>
                </svg>
            </div>

            <div class="timer"></div>

            <div class="quiz-app">

            <ul class="question">

            </ul>

            <div class="quizbutton">
                <button class="button">تسليم الإجابات</button>
                </div>

                <p>مع تمنياتي لك بالنجاح والتفوق</p>

            </div>

            <div class="gifet"></div>

            <div class="grade"></div>

            <div class="buttonn"></div>

                <script>
                    let thetest = '<?php echo "../layout/json/json" . $_SESSION['do'] . "/" . $thejson; ?>';
                    let srcImg = '<?php echo "../layout/json/json" . $_SESSION['do'] . "/images" . "/" ; ?>';
                </script>

                <script src="../layout/js/QuzeApp.js"></script>
                
            </body>
            </html>
            <?php
        }else {
            $theMsg = 'هذا الإختبار غير موجود';
            redirectHome($theMsg);
        }


    }else {
        header('location: logout.php');
    }
    ob_end_flush();