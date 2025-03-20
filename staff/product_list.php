<?php
//คิวรี่ข้อมูลสินค้า

$queryproduct = $condb->prepare("SELECT p.product_id, p.product_name, p.product_price, t.type_name, p.product_image FROM tbl_product p INNER JOIN tbl_type t on p.ref_type_id = t.type_id");
$queryproduct->execute();
$rsproduct = $queryproduct->fetchAll();

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>จัดการข้อมูลสินค้า
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
                    <th width="20%">หมวดหมู่</th>
                    <th width="40%">ชื่อสินค้า</th>
                    <th width="10%" class="text-center">Price</th>
                    <th width="5%" class="text-center">แก้ไข</th>
                    <th width="5%" class="text-center">ลบ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($rsproduct as $row) {
                  ?>
                    <tr>
                      <td align="center"><?= $i++; ?></td>
                      <td>
                        <img src="../assetsBackend/product_img/<?= $row['product_image']; ?>" width="100px">
                      </td>
                      <td><?= $row['type_name']; ?></td>
                      <td><?= $row['product_name']; ?></td>
                      <td align="right"><?= number_format($row['product_price'], 2); ?></td>
                      <td align="center">
                        <a href="type.php?id=<?= $row['product_id']; ?>&act=edit" class="btn btn-warning btn-sm">แก้ไข</a>
                      </td>
                      <td align="center">
                        <form action="product.php" method="post">
                          <input type="hidden" name="product_id" value="<?= $row['product_id']; ?>">
                          <input type="hidden" name="product_image" value="<?= $row['product_image']; ?>">
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