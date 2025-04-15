<?php 
//คิวรี่ข้อมูลสินค้า

$queryproduct = $condb->prepare("SELECT * FROM tbl_service");
$queryproduct->execute();
$rsproduct = $queryproduct->fetchAll();

  // echo '<pre>';
  // print_r($rsproduct);


?>  
  
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>จัดการข้อมูลการบริการ
            <a href="product.php?act=add" class="btn btn-primary">+ข้อมูล</a>
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
                    <th width="5%">ภาพ</th>
                    <th width="10%">ชื่อสินค้า</th>
                    <th width="20%">คำโปรย</th>
                    <th width="30%">รายละเอียด</th>
                    <!-- <th width="5%" class="text-center">แก้ไข</th> -->
                    <th width="5%" class="text-center">ลบ</th>
                  </tr>
                  </thead>
                  <tbody>
                <?php foreach($rsproduct as $row){ ?>
                  <tr>
                    <td align="center"><?= $row['service_id']; ?></td>
                    <td>
                      <img src="../assetsBackend/product_img/<?=$row['service_img'];?>" width="100px">
                    </td>
                    <td><?= $row['service_names']; ?></td>
                    <td><?= $row['service_caption']; ?></td>
                    <td><?= $row['service_details']; ?></td>
                    <!-- <td align="center">
                      <a href="product.php?id=<?=$row['service_id'];?>&act=edit" class="btn btn-warning btn-sm">แก้ไข</a>
                    </td> -->
                    <td align="center">
                      <form action="product.php" method="post">
                        <input type="hidden" name="service_id" value="<?= $row['service_id']; ?>">
                        <input type="hidden" name="service_img" value="<?= $row['service_img'];?>">
                        <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันกลบข้อมูล')">ลบ</button>
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