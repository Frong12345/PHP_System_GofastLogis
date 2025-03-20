    <!-- start nav bar -->
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="index.php" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assetsFront/img/logo.png" alt=""> -->
                <h1 class="sitename">GOFast <h5>Logis</h5>
                </h1>
                <h1><i class="fa-solid fa-truck-fast"></i></h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="index.php?act=หน้าหลัก" class="<?= ($current_page == 'หน้าหลัก') ? 'active' : '' ?>">หน้าหลัก<br></a></li>
                    <li><a href="track.php?act=ตรวจสอบสถานะพัสดุ" class="<?= ($current_page == 'ตรวจสอบสถานะพัสดุ' || $current_page == 'tracking_number') ? 'active' : '' ?>">ตรวจสอบสถานะพัสดุ</a></li>
                    <li><a href="about.php?act=เกี่ยวกับเรา" class="<?= ($current_page == 'เกี่ยวกับเรา') ? 'active' : '' ?>">เกี่ยวกับเรา</a></li>
                    <li><a href="services.php?act=บริการของเรา" class="<?= ($current_page == 'บริการของเรา') ? 'active' : '' ?>">บริการของเรา</a></li>
                    <li><a href="contact.php?act=ติดต่อเรา" class="<?= ($current_page == 'ติดต่อเรา') ? 'active' : '' ?>">ติดต่อเรา</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="login.php?act=เข้าสู่ระบบ">เข้าสู่ระบบ</a>

        </div>
    </header>
    <!-- end nav bar -->