
    <span class="up"><i class="fas fa-angle-double-up"></i></span>
    <footer>
        <div class="container">
            <div class="box">
                <h2>طرق التواصل</h2>
                <ul>
                    <li><a href="<?php getDates ("UrlName", "urlwhtsapp"); ?>"><i class="fas fa-phone-alt"></i>رقم التواصل</a></li>
                    <li><a href="<?php getDates ("UrlName", "urlmill"); ?>"><i class="fas fa-envelope"></i>البريد الإلكتروني</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-in-alt"></i>تسجيل الدخول</a></li>
                </ul>
            </div>
            <div class="box">
                <h2>اللينكات</h2>
                <ul>
                    <li><a href="lookus.php"><i class="fas fa-head-side-virus"></i>لمحة عنا</a></li>
                    <li><a href="benefit.php"><i class="fas fa-calendar-alt"></i>فائدة الدورة</a></li>
                    <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> خروج </a></li>
                </ul>
            </div>
        </div>
        <div class="link">
            <a href="<?php getDates ("UrlName", "urlfacebook"); ?>">
                <div class="facebook li">
                    <i class="fab fa-facebook-f"></i>
                </div>
            </a>
            <a href="<?php getDates ("UrlName", "urltwitter"); ?>">
                <div class="twitter li">
                    <i class="fab fa-twitter"></i>
                </div>
            </a>
            <a href="<?php getDates ("UrlName", "urlinstagram"); ?>">
                <div class="instagram li">
                    <i class="fab fa-instagram"></i>
                </div>
            </a>
            <a href="<?php getDates ("UrlName", "urlsnapchat"); ?>">
                <div class="snapchat li">
                    <i class="fab fa-snapchat-ghost"></i>
                </div>
            </a>
            <a href="<?php getDates ("UrlName", "urlwhtsapp"); ?>">
                <div class="whtsapp li">
                    <i class="fab fa-whatsapp"></i>
                </div>
            </a>
        </div>
    </footer>

	<script src="<?php echo $js;?>main.js"></script>
	<script src="<?php echo $js;?><?php GetLinkjs () ?>"></script>
	</body>
	</html>