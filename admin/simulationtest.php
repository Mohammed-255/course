<?php 
    ob_start();
    session_start();

    if (isset($_SESSION['Usename1'])) {

        include 'connect.php';
        include 'includes/functions/functions.php';

        $thetest = (isset($_GET['test']) && is_numeric($_GET['test'])) ? intval($_GET['test']) : 0;


        $stmt = $con->prepare("SELECT TestName FROM testtm  WHERE UserID = ? LIMIT 1");
        $stmt->execute(array($thetest));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        $stmt1 = $con->prepare("SELECT ImageName FROM imageseq");
        $stmt1->execute(array());
        $row1 = $stmt1->fetch();

        if ($count > 0) {
            $thejson = $row['TestName'];
            $theimg = $row1['ImageName'];
            ?>

                <!DOCTYPE html>
                <html lang="Arabic">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="layout/css/all.min.css">
                    <link rel="stylesheet" href="layout/css/normalize.css">
                    <link rel="stylesheet" href="../layout/css/simulationtest.css">
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Noto+Naskh+Arabic:wght@400;500;600;700&family=Work+Sans:ital,wght@0,700;1,200;1,500&display=swap" rel="stylesheet">
                    <title>إختبار</title>
                </head>
                <body>

                    <div class="containerintro">
                        <div class="image">
                            <img src="layout/imags/entro.png" alt="">
                        </div>
                        <h1>مرحبا بك في</h1>
                        <h1>اختبارات المركز الوطني للقياس على الحاسب الآلي</h1>
                        <p>عند الدخول للإختبار ضع السماعةعلى أذنيك للإستماع إلى الشرح المعد في تعليمات الإختبار</p>
                        <p>ومحتوياته إذا لم تسمع التعليمات الرجاء رفع اليد وإبلاغ مشرف القاعة بذلك</p>
                        <p>زر "التالي" في أسفل الصفحة ينقلك إلى تعليمات الإختبار ومحتوياته.</p>
                        <p>ملحوظة إن مدة التعليمات هي عشر دقائق فقط فإذا إنتهت يبدأ الإختبار آليا.</p>
                    </div>

                    <div class="quxeinform">
                    </div>

                    <div class="nextele">
                        <button>التالي <i class="fa-solid fa-arrow-left"></i> </button>
                    </div>
                    
                    <div class="informationcontanerqusetion"></div>

                    <script>
                        let thetest = '<?php echo "../layout/json/json" . $_SESSION['do'] . "/" . $thejson; ?>';
                        let theimgeq = '<?php echo "../layout/json/jsoneq/images/" . $theimg; ?>';
                        let srcImg = '<?php echo "../layout/json/json" . $_SESSION['do'] . "/images" . "/"; ?>';
                        let theName = '<?php echo $_SESSION['Usename1']; ?>';
                    </script>

                    <script src="../layout/js/simulationtest.js"></script>
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