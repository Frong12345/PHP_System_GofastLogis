<?php

// ดึงรายการพัสดุทั้งหมด
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$query = "SELECT o.order_id, o.tracking_number, o.shipping_type, c.name, o.receiver_name, d.center_name, o.order_address, o.order_province, o.current_status, o.created_at 
FROM orders AS o
INNER JOIN tbl_customers AS c ON o.customer_id_ref = c.customer_id
LEFT JOIN delivery_centers AS d ON o.ref_center_id = d.center_id
";

// ตรวจสอบค่าที่ส่งมา
if (!empty($status_filter)) {
    $query .= " WHERE o.current_status = :status";
}

// เตรียมคำสั่ง SQL
$stmtOrderDetail = $condb->prepare($query);

// ถ้ามีตัวกรอง ให้ bind ค่า
if (!empty($status_filter)) {
    $stmtOrderDetail->bindParam(':status', $status_filter, PDO::PARAM_STR);
}

// Execute คำสั่งเสมอ
$stmtOrderDetail->execute();

// ดึงข้อมูล
$rsOrders = $stmtOrderDetail->fetchAll();

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>อัปเดตสถานะพัสดุ</h1>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <form method="GET" action="" class="mt-3">
                        <label>ตัวกรองสถานะ:</label>
                        <select name="status" onchange="this.form.submit()" class="form-control form-select w-auto d-inline-block">
                            <option value="" <?= ($status_filter == '') ? 'selected' : '' ?>>ทั้งหมด</option>
                            <option value="รับพัสดุเข้าศูนย์" <?= ($status_filter == 'รับพัสดุเข้าศูนย์') ? 'selected' : '' ?>>รับพัสดุเข้าศูนย์</option>
                            <option value="พัสดุกำลังเดินทาง" <?= ($status_filter == 'พัสดุกำลังเดินทาง') ? 'selected' : '' ?>>พัสดุกำลังเดินทาง</option>
                            <option value="พัสดุอยู่ระหว่างการนำส่ง" <?= ($status_filter == 'พัสดุอยู่ระหว่างการนำส่ง') ? 'selected' : '' ?>>พัสดุอยู่ระหว่างการนำส่ง</option>
                            <option value="พัสดุจัดส่งสำเร็จ" <?= ($status_filter == 'พัสดุจัดส่งสำเร็จ') ? 'selected' : '' ?>>พัสดุจัดส่งสำเร็จ</option>
                            <option value="พัสดุจัดส่งไม่สำเร็จ" <?= ($status_filter == 'พัสดุจัดส่งไม่สำเร็จ') ? 'selected' : '' ?>>พัสดุจัดส่งไม่สำเร็จ</option>
                            <option value="พัสดุถูกตีกลับ" <?= ($status_filter == 'พัสดุถูกตีกลับ') ? 'selected' : '' ?>>พัสดุถูกตีกลับ</option>
                        </select>
                    </form>
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
                                        <th width="5%" class="text-center">ว/ด/ป</th>
                                        <th width="14%" class="text-center">หมายเลขติดตาม</th>
                                        <th width="6%" class="text-center">ประเภท</th>
                                        <th width="10%">ผู้รับ</th>
                                        <th width="20%">ที่อยู่</th>
                                        <th width="10%">ปลายทาง</th>
                                        <th width="10%">สถานะ</th>
                                        <th width="25%">อัปเดต</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rsOrders as $row) { ?>
                                        <tr>
                                            <td align="center"> <?= date('d/m/y H:m:s', strtotime($row['created_at'])); ?> </td>
                                            <td align="center"> <?= $row['tracking_number']; ?> </td>
                                            <td><?= $row['shipping_type']; ?></td>
                                            <td><?= $row['receiver_name']; ?></td>
                                            <td><?= htmlspecialchars($row['order_address']) ?></td>
                                            <td><?= $row['order_province']; ?></td>
                                            <td style="color: 
                                            <?php
                                            switch ($row['current_status']) {
                                                case 'รับพัสดุเข้าศูนย์':
                                                    echo 'rgb(19, 124, 236)';
                                                    break;
                                                case 'พัสดุจัดส่งสำเร็จ':
                                                    echo '#38A169';
                                                    break;
                                                case 'พัสดุจัดส่งไม่สำเร็จ':
                                                    echo 'orange';
                                                    break;
                                                case 'พัสดุถูกตีกลับ':
                                                    echo 'red';
                                                    break;
                                                default:
                                                    echo '#D69E2E';
                                            }
                                            ?>;">
                                                <?= htmlspecialchars($row['current_status']) ?>
                                            </td>
                                            <td align="center" style="color: <?= ($row['current_status'] == 'รับพัสดุเข้าศูนย์' ? 'orange' : ($row['current_status'] == 'พัสดุจัดส่งสำเร็จ' ? 'green' : ($row['current_status'] == 'พัสดุจัดส่งไม่สำเร็จ' ? 'red' : 'black'))) ?>;">
                                                <div class="row">
                                                    <div class="col-sm-1"></div>
                                                    <form method="POST" class="d-inline">
                                                        <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                                                        <select name="new_status" class="col-sm-8 form-control form-select d-inline">
                                                            <option value="รับพัสดุเข้าศูนย์" <?= (htmlspecialchars($row['current_status']) == 'รับพัสดุเข้าศูนย์') ? 'selected' : '' ?>>รับพัสดุเข้าศูนย์</option>
                                                            <option value="พัสดุกำลังเดินทาง" <?= (htmlspecialchars($row['current_status']) == 'พัสดุกำลังเดินทาง') ? 'selected' : '' ?>>พัสดุกำลังเดินทาง</option>
                                                            <option value="พัสดุถึงปลายทาง" <?= (htmlspecialchars($row['current_status']) == 'พัสดุถึงปลายทาง') ? 'selected' : '' ?>>พัสดุถึงปลายทาง</option>
                                                            <option value="พัสดุอยู่ระหว่างการนำส่ง" <?= (htmlspecialchars($row['current_status']) == 'พัสดุอยู่ระหว่างการนำส่ง') ? 'selected' : '' ?>>พัสดุอยู่ระหว่างการนำส่ง</option>
                                                            <option value="พัสดุจัดส่งสำเร็จ" <?= (htmlspecialchars($row['current_status']) == 'พัสดุจัดส่งสำเร็จ') ? 'selected' : '' ?>>พัสดุจัดส่งสำเร็จ</option>
                                                            <option value="พัสดุจัดส่งไม่สำเร็จ" <?= (htmlspecialchars($row['current_status']) == 'พัสดุจัดส่งไม่สำเร็จ') ? 'selected' : '' ?>>พัสดุจัดส่งไม่สำเร็จ</option>
                                                            <option value="พัสดุถูกตีกลับ" <?= (htmlspecialchars($row['current_status']) == 'พัสดุถูกตีกลับ') ? 'selected' : '' ?>>พัสดุถูกตีกลับ</option>
                                                        </select>
                                                        <button type="submit" name="update_status" value="status" class="btn btn-primary ml-1">อัปเดต</button>
                                                    </form>
                                                </div>
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

<?php
// อัปเดตสถานะ
if (isset($_POST['update_status']) && $_POST['update_status'] == 'status') {
    // echo 'ถูกเงื่อไข ส่งข้อมูลมาได้';
    // exit;

    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    //trigger exception in a "try" block
    try {

        $updateLogs = $condb->prepare("INSERT order_logs (order_id, status) VALUES (:order_id, :new_status)");
        // bindparam
        $updateLogs->bindparam(':new_status', $new_status, PDO::PARAM_STR);
        $updateLogs->bindparam(':order_id', $order_id, PDO::PARAM_INT);
        $updateLogs->execute();

        if ($updateLogs) {

            $updateOrders = $condb->prepare("UPDATE orders 
            SET current_status = (
                SELECT status 
                FROM order_logs 
                WHERE order_id = :order_id
                ORDER BY updated_at DESC 
                LIMIT 1
            )

            WHERE order_id = :order_id;");
            // bindparam
            $updateOrders->bindparam(':order_id', $order_id, PDO::PARAM_INT);
            $updateOrders->execute();

            if ($updateOrders) {
                echo    '<script>
                setTimeout(function() {
                swal({
                    title: "แก้ไขสถานะพัสดุสำเร็จ",
                    type: "success"
                }, function() {
                    window.location = "orders.php?status="; //หน้าที่ต้องการให้กระโดดไป
                });
                }, 1000);
            </script>';
            }
        }
    } // end try
    catch (Exception $e) {
        echo 'Message: ' . $e->getMessage();
        exit;
        echo '<script>
                setTimeout(function() {
                swal({
                    title: "เกิดข้อผิดพลาด !!",
                    text: "กรุณาติดต่อผู้ดูแลระบบ",
                    type: "error"
                }, function() {
                    window.location = "orders.php?status="; //หน้าที่ต้องการให้กระโดดไป
                });
                }, 1000);
            </script>';
    } //end catch
} //isset





?>