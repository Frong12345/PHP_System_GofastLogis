<?php
//คิวรี่ข้อมูลสมาชิก
$queryadmin = $condb->prepare("SELECT * FROM tbl_admin");
$queryadmin->execute();
$rsadmin = $queryadmin->fetchAll();

// echo '<pre>';
// $queryadmin->debugDumpParams();
// exit;
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>จัดการข้อมูล ผู้ดูแลระบบ/พนักงาน
            <a href="admin.php?act=add" class="btn btn-primary">เพิ่มข้อมูล</a>
          </h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped table-sm">
                <thead>
                  <tr class="table-info">
                    <th width="5%" class="text-center">No.</th>
                    <th width="15%" class="text-center">โปรไฟล์</th>
                    <th width="15%">ชื่อ-สกุล</th>
                    <th width="20%">Username</th>
                    <th width="8%">เบอร์โทร</th>
                    <th width="10%">สิทธิ์ใช้งาน</th>
                    <th width="5%" class="text-center">แก้ไข</th>
                    <th width="8%" class="text-center">แก้รหัส</th>
                    <th width="5%" class="text-center">ลบ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1; //start number
                  foreach ($rsadmin as $row) { ?>
                    <tr>
                      <td align="center"> <?= $i++ ?> </td>
                      <td align="center">
                        <img src="../assetsBackend/profile_img/<?= $row['admin_profile']; ?>" width="100px">
                      </td>
                      <td><?= $row['admin_name']; ?></td>
                      <td><?= $row['admin_email']; ?></td>
                      <td align="center"><?= $row['admin_phone']; ?></td>
                      <td><?= $row['admin_level']; ?></td>
                      <td align="center">
                        <a href="admin.php?id=<?= $row['admin_id']; ?>&act=edit" class="btn btn-warning btn-sm">แก้ไข</a>
                      </td>
                      <td align="center">
                        <a href="admin.php?id=<?= $row['admin_id']; ?>&act=editPwd" class="btn btn-info btn-sm">แก้รหัส</a>
                      </td>
                      <td align="center">
                        <a href="admin.php?id=<?= $row['admin_id']; ?>&act=delete" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูล??');">ลบ</a>
                      </td>
                    </tr>
                  <?php } ?>

                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->