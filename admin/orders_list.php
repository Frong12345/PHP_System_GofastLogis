<?php

// ดึงรายการพัสดุทั้งหมด
$stmtOrderDetail = $condb->prepare("SELECT o.order_id, o.tracking_number, o.shipping_type, c.name, o.receiver_name, o.receiver_phone, d.center_name, o.order_address, o.order_province, o.current_status, o.created_at 
FROM orders AS o
INNER JOIN tbl_customers AS c ON o.customer_id_ref = c.customer_id
LEFT JOIN delivery_centers AS d ON o.ref_center_id = d.center_id
");
$stmtOrderDetail->execute();
$rsOrders = $stmtOrderDetail->fetchAll();

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>รายการพัสดุ
                        <a href="orders.php?act=check_add" class="btn btn-primary">เพิ่มพัสดุใหม่</a>
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
                                    <tr class="table-info" align="center">
                                        <th width="10%" class="text-center">ว/ด/ป</th>
                                        <th width="14%" class="text-center">หมายเลขติดตาม</th>
                                        <th width="10%" class="text-center">ประเภทจัดส่ง</th>
                                        <th width="8%">ผู้ส่ง</th>
                                        <th width="8%">ผู้รับ</th>
                                        <th width="8%">เบอร์ผู้รับ</th>
                                        <th width="18%">ที่อยู่จัดส่ง</th>
                                        <th width="6%">ต้นทาง</th>
                                        <th width="8%">ปลายทาง</th>
                                        <th width="10%">สถานะ</th>
                                        <th width="7%">แก้ไข</th>
                                        <th width="7%">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($rsOrders as $row) { ?>
                                        <tr>
                                            <td align="center"> <?= date('d/m/y H:i:s', strtotime($row['created_at'])); ?> </td>
                                            <td align="center"> <?= $row['tracking_number']; ?> </td>
                                            <td><?= $row['shipping_type']; ?></td>
                                            <td><?= $row['name']; ?></td>
                                            <td><?= $row['receiver_name']; ?></td>
                                            <td><?= $row['receiver_phone']; ?></td>
                                            <td><?= $row['order_address']; ?></td>
                                            <td><?= $row['center_name']; ?></td>
                                            <td><?= $row['order_province']; ?></td>
                                            <td><?= $row['current_status']; ?></td>
                                            <td align="center">
                                                <a href="orders.php?id=<?= $row['order_id']; ?>&act=edit" class="btn btn-warning btn-sm">แก้ไข</a>
                                            </td>
                                            <td align="center">
                                                <a href="orders.php?id=<?= $row['order_id']; ?>&act=delete" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูล??');">ลบ</a>
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