<?php
//คิวรี่ข้อมูลสินค้า

$queryDistCenter = $condb->prepare("SELECT * FROM delivery_centers");
$queryDistCenter->execute();
$rpDistCenter = $queryDistCenter->fetchAll();

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>จัดการข้อมูลศูนย์กระจายสินค้า
            <a href="distribution_centers.php?act=add" class="btn btn-primary">เพิ่มข้อมูล</a>
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
                <thead align="center">
                  <tr class="table-info">
                    <th width="5%" class="text-center">No.</th>
                    <th width="10%">รหัส</th>
                    <th width="15%">จังหวัด</th>
                    <th width="40%">ที่อยู่</th>
                    <th width="10%">เบอร์</th>
                    <th width="10%">แก้ไข</th>
                    <th width="10%">ลบ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($rpDistCenter as $row) { ?>
                    <tr>
                      <td align="center"><?= $i++ ?></td>
                      <td align="center"><?= $row['center_id']; ?></td>
                      <td align="center"><?= $row['center_name']; ?></td>
                      <td><?= $row['center_address']; ?></td>
                      <td align="center"><?= $row['center_phone']; ?></td>
                      <td align="center">
                        <a href="distribution_centers.php?id=<?= $row['center_id']; ?>&act=edit" class="btn btn-warning btn-sm">แก้ไข</a>
                      </td>
                      <td align="center">
                        <a href="distribution_centers.php?id=<?= $row['center_id']; ?>&act=delete" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูล??');">ลบ</a>
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