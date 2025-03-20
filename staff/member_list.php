<?php 
//คิวรี่ข้อมูลสินค้า

$querystu = $condb->prepare("SELECT * FROM tbl_studeninfo");
$querystu->execute();
$rpstudents = $querystu->fetchAll();

?>  
  
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>จัดการข้อมูลสมาชิก
            <a href="member.php?act=add" class="btn btn-primary">+ข้อมูล</a>
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
                    <th width="5%">ภาพ</th>
                    <th width="5%" class="text-center">รหัสนศ</th>
                    <!-- <th width="5%">คำนำหน้า</th> -->
                    <th width="15%">ชื่อ-นามสกุล</th>
                    <!-- <th width="6%">นามสกุล</th> -->
                    <th width="7%">อีเมล</th>
                    <th width="6%" class="text-center">เบอร์โทร</th>
                    <th width="2%" class="text-center">สาขา</th>
                    <th width="15%" class="text-center">วันลงทะเบียนเรียน</th>
                    <th width="2%" class="text-center">สถานะ</th>
                    <th width="3%" class="text-center">ภาษา</th>
                    <th width="3%" class="text-center">แก้ไข</th>
                    <th width="3%" class="text-center">ลบ</th>
                  </tr>
                  </thead>
                  <tbody>
                <?php foreach($rpstudents as $row){ ?>
                  <tr>
                    <td align="center"><?= $row['id']; ?></td>
                    <td align="center">
                      <img src="../assetsBackend/product_img/<?= $row['student_image'];?>" width="100px">
                    </td>
                    <td align="center"><?= $row['student_id']; ?></td>
                    <td><?= $row['prefix'].' '.$row['first_name'].' '.$row['last_name']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td align="center"><?= $row['phone']; ?></td>
                    <td><?= $row['major']; ?></td>
                    <td align="center"><?= $row['register_date']; ?></td>
                    <td><?= $row['status']; ?></td>
                    <td><?= $row['favorite_prog']; ?></td>
                    <td align="center">
                        <form action="member.php" method="get">
                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                            <button type="submit" name="act" value="edit" class="btn btn-warning btn-sm">แก้ไข</button>
                        </form>
                      <!-- <a href="member.php?id=<=$row['id'];?>&act=edit" class="btn btn-warning btn-sm">แก้ไข</a> -->
                    </td>
                    <td align="center">
                      <form action="member.php" method="post">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <input type="hidden" name="student_image" value="<?= $row['student_image'];?>">
                        <button type="submit" name="act" value="delete" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันลบข้อมูล')">ลบ</button>
                      </form>
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

