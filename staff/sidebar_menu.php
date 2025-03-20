<?php 
 //คิวรี่ข้อมูลของคนที่ผ่านการ login มาแล้ว

 //Single row query แสดงแค่ 1 รายการ
 $adminDetail = $condb->prepare('SELECT admin_name FROM tbl_admin WHERE admin_id = :admin_id');
//bindparam
 $adminDetail->bindParam(':admin_id', $_SESSION['admin_id'], PDO::PARAM_INT);
 $adminDetail->execute();
 $adminData = $adminDetail->fetch(PDO::FETCH_ASSOC);

//  echo '<pre>';
//  print_r($memberData);
 
 
 ?>
 
 
 
 <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../assetsBackend/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Hi <?= $adminData['admin_name'];?> </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
              <p>
                หน้าหลัก
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="index.php" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          
          <li class="nav-item">
            <a href="type.php" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                จัดการหมวดหมู่สินค้า
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="product.php" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                จัดการข้อมูลสินค้า  
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="admin.php" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
              <p>
                จัดการข้อมูล Admin
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="member.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                จัดการข้อมูลสมาชิก  
              </p>
            </a>
          </li>

          

          <li class="nav-item">
            <a href="../logout.php" class="nav-link">
              <i class="nav-icon fas fa-lock"></i>
              <p>
                ออกจากระบบ
              </p>
            </a>
          </li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
