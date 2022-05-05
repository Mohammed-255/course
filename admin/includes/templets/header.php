<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="<?php echo $css;?>all.min.css">
		<link rel="stylesheet" href="<?php echo $css;?>normalize.css">
		<link rel="stylesheet" href="<?php echo $css;?>backend.css">
		<link rel="stylesheet" href="<?php echo $css;?>master.css">
		<link rel="stylesheet" href="../layout/css/<?php echo GetLinkCss();?>">

		<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Work+Sans:ital,wght@0,700;1,200;1,500&display=swap" rel="stylesheet">
		<title><?php GetTitle() ?></title>
	</head>

	<body>

	<header>
        <div class="contaner">
            <div class="logo">قدرات</div>
                <nav>
                        <ul class="nav">
                            <li><a href="<?php Getsrc1 () ?>"> <?php Getnamesrc1 () ?> </a></li>
                            <li><a href="<?php Getsrc2 () ?>"> <?php Getnamesrc2 () ?> </a></li>
                            <li><a href="">لمحة</a></li>
                            <li><a href="logout.php">خروج</a></li>
                        </ul>
                    <div class="liner">
                        <div class="pearant">
                            <span></span>
                            <span></span>
                            <span></span>
                            <div class="list">
                                        <a href="<?php Getsrc1 () ?>"> <?php Getnamesrc1 () ?> </a>
                                        <a href="<?php Getsrc2 () ?>"><?php Getnamesrc2 () ?></a>
                                        <a href="">لمحة</a>
                                        <a href="logout.php">خروج</a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
    </header>


