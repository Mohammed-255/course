<?php 

    ob_start();
    session_start();

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    
    $linkCss = "";
    $linkjs = "";
    $pageTitle = "";



    if (isset($_SESSION['Usename1'])) {

        include 'init.php';

        function createTest ($from) {
            global $con;
            $stmt = $con->prepare("SELECT * FROM $from");
            $stmt->execute();
            $rows = $stmt->fetchAll();

            echo '<div class="parent">';
            if ($stmt->rowCount() > 0) {
                echo '<div class="continaer">';
                foreach ($rows as $row) {
                    echo '<a href="simulationtest.php?test=' . $row['UserID'] . '">';
                        echo '<div class="title"> ' . $row['TheName'] . ' </div>';
                        echo '<div class="icon">';
                            echo '<span>' . $row['Qusemany'] . 'سؤال </span>';
                            echo '<span>';
                                if ($row['Qusemany'] >= 96) {
                                    echo '100';
                                }else {
                                    echo $row['Qusemany'];
                                }
                                echo 'دقيقة';
                            echo '</span>';
                            echo '<i class="fas fa-unlock"></i>';
                        echo '</div>';
                    echo '</a>';
                }
                echo '</div>';
            }else {
                echo '<h2> لم يتم رفع أي إختبار </h2>';
            }
        echo '</div>';
        }

        if ($do == 'T') {
            $_SESSION['do'] = 'tm';
            echo '<h1>';
            echo 'إختبارات محاكاة للتأسيسس';
            echo '</h1>';
            createTest ('testtm');
        }elseif ($do == 'M') {
            $_SESSION['do'] = 'mm';
            echo '<h1>';
            echo 'إختبارات محاكاة للمحوسب';
            echo '</h1>';
            createTest ('testmm');
        }

    }else {
        header('location: index.php');
        exit();
    }

    include  $tpl . "footer.php";
    ob_end_flush();
?>