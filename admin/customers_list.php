<?php
//คิวรี่ข้อมูล
$querycustomer = $condb->prepare("SELECT * FROM tbl_customers");
$querycustomer->execute();
$rpcustomer = $querycustomer->fetchAll();

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>จัดการข้อมูลลูกค้า
            <a href="customers.php?act=add" class="btn btn-primary">เพิ่มข้อมูล</a>
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
                    <th width="2%" class="text-center">No.</th>
                    <th width="10%">เลขบัตรประชาชน</th>
                    <th width="10%">ชื่อ</th>
                    <th width="7%">อีเมล</th>
                    <th width="6%" class="text-center">เบอร์</th>
                    <th width="13%" class="text-center">วันลงทะเบียน</th>
                    <th width="3%" class="text-center">แก้ไข</th>
                    <th width="3%" class="text-center">ลบ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($rpcustomer as $row) { ?>
                    <tr>
                      <td align="center"><?= $i++ ?></td>
                      <td align="center"><?= $row['cus_id_card']; ?></td>
                      <td><?= $row['name']; ?></td>
                      <td><?= $row['email']; ?></td>
                      <td align="center"><?= $row['cus_phone']; ?></td>
                      <td align="center"><?= $row['created_at']; ?></td>
                      <td align="center">
                        <a href="customers.php?id=<?= $row['customer_id']; ?>&act=edit" class="btn btn-warning btn-sm">แก้ไข</a>
                      </td>
                      <td align="center">
                        <a href="customers.php?id=<?= $row['customer_id']; ?>&act=delete" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูล??');">ลบ</a>
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