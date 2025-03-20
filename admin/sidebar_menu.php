<?php
//คิวรี่ข้อมูลของคนที่ผ่านการ login มาแล้ว

//Single row query แสดงแค่ 1 รายการ
$adminDetail = $condb->prepare('SELECT admin_name, admin_profile FROM tbl_admin WHERE admin_id = :admin_id');
//bindparam
$adminDetail->bindParam(':admin_id', $_SESSION['admin_id'], PDO::PARAM_INT);
$adminDetail->execute();
$adminData = $adminDetail->fetch(PDO::FETCH_ASSOC);

//  echo '<pre>';
//  print_r($memberData);


?>



<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-info elevation-4">
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="../assetsBackend/profile_img/<?= $adminData['admin_profile']; ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <span class="brand-text font-weight-light text-white"><?= $adminData['admin_name']; ?> </span>
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="index.php" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>หน้าหลัก</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="dashboard.php" class="nav-link">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-truck-loading"></i>
            <p>
              พัสดุ & สถานะ
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="orders.php?act=orders_list" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>รายการพัสดุ</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="orders.php?act=update_status" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>อัปเดตสถานะพัสดุ</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="customers.php" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>จัดการข้อมูลลูกค้า</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="admin.php" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>จัดการข้อมูลพนักงาน</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="distribution_centers.php" class="nav-link">
            <i class="nav-icon fas fa-map-marked-alt"></i>
            <p>จัดการศูนย์กระจายสินค้า</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="../logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>ออกจากระบบ</p>
          </a>
        </li>



      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>