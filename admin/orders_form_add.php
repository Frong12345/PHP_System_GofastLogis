<?php
if (isset($_GET['id']) && $_GET['act'] == 'add') {

    // ประกาศตัวแปรรับค่า
    $cus_id_card = $_GET['id'];

    // echo '<pre>';
    // print_r($_GET);

    //Single row query แสดงแค่ 1 รายการ
    $stmtCustomerDetails = $condb->prepare('SELECT customer_id, cus_id_card, name FROM tbl_customers WHERE cus_id_card = :cus_id_card');
    $stmtCustomerDetails->bindparam(':cus_id_card', $cus_id_card, PDO::PARAM_STR);
    $stmtCustomerDetails->execute();
    $rowCus = $stmtCustomerDetails->fetch(PDO::FETCH_ASSOC);

    //คิวรี่ข้อมูล
    $querycenters = $condb->prepare("SELECT center_id, center_name FROM delivery_centers");
    $querycenters->execute();
    $querycenters = $querycenters->fetchAll();
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ฟอร์มเพิ่มข้อมูลลูกค้า</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <div class="card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="" method="post">
                                <div class="card-body">

                                    <div class="form-group row">
                                        <label class="col-sm-2">ศูนย์รับพัสดุ</label>
                                        <div class="col-sm-2">
                                            <select name="ref_center_id" class="form-control" required>
                                                <option value="">-- เลือกข้อมูล -- </option>
                                                <?php
                                                foreach ($querycenters as $row) { ?>
                                                    <option value="<?= $row['center_id'] ?>">-- <?= $row['center_name'] ?> -- </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ประเภทการจัดส่งพัสดุ</label>
                                        <div class="col-sm-2">
                                            <select name="shipping_type" class="form-control" required>
                                                <option value="">-- เลือกข้อมูล -- </option>
                                                <option value="ปกติ">-- ส่งปกติ -- </option>
                                                <option value="ส่งด่วน">-- ส่งด่วน -- </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">เลขบัตรประชาชน</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="cus_id_card" value="<?= $rowCus['cus_id_card'] ?>" class="form-control" placeholder="กรุณากรอกเลขบัตรประชาชน" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ผู้ส่ง</label>
                                        <div class="col-sm-4">
                                            <input type="hidden" name="customer_id_ref" value="<?= $rowCus['customer_id'] ?>" class="form-control" disabled>
                                            <input type="text" name="name" value="<?= $rowCus['name'] ?>" class="form-control" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ผู้รับ</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="receiver_name" class="form-control" placeholder="กรุณากรอกชื่อผู้รับ" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">เบอร์ผู้รับ</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="receiver_phone" class="form-control" placeholder="กรุณากรอกเบอร์ผู้รับ" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ที่อยู่ปลายทาง</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="order_address" class="form-control" placeholder="กรุณากรอกที่อยู่ปลายทาง" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">จังหวัดปลายทาง</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="order_province" class="form-control" placeholder="กรุณากรอกจังหวัดปลายทาง" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-4">
                                            <input type="hidden" name="customer_id_ref" value="<?= $rowCus['customer_id'] ?>">
                                            <input type="hidden" name="customer_id_ref" value="<?= $rowCus['customer_id'] ?>">
                                            <button type="submit" class="btn btn-primary">เพิ่มข้อมูล</button>
                                            <a href="orders.php?act=orders_list" class="btn btn-danger">ยกเลิก</a>
                                        </div>
                                    </div>

                                </div> <!-- /.card-body -->
                                <?php
                                // echo '<pre>';
                                // print_r($_POST);
                                // exit;
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
//เช็ค Input ที่า่งมาจากฟอร์ม
// echo '<pre>';
// print_r($_POST);

if (isset($_POST['ref_center_id']) && isset($_POST['shipping_type']) && isset($_POST['receiver_name']) && isset($_POST['receiver_phone']) && isset($_POST['order_address']) && isset($_POST['order_province']) && isset($_POST['customer_id_ref'])) {
    // echo 'ถูกเงื่อไข ส่งข้อมูลมาได้';
    // echo '<pre>';
    // print_r($_POST);
    // exit;

    //trigger exception in a "try" block
    try {

        // รับค่า ref_center_id จากฟอร์ม
        $ref_center_id = $_POST['ref_center_id'];

        // คำนวณจำนวนหลักที่เหลือสำหรับเลขสุ่ม
        $remaining_length = 13 - strlen($ref_center_id);

        // สุ่มเลขที่เหลือให้ได้ตามจำนวนที่ต้องการ
        $random_number = str_pad(mt_rand(0, pow(10, $remaining_length) - 1), $remaining_length, '0', STR_PAD_LEFT);

        // รวมเป็น Tracking Number 13 หลัก
        $tracking_number = $ref_center_id . $random_number;

        // ประกาศตัวแปรรับค่าจากฟอร์ม
        $ref_center_id = $_POST['ref_center_id'];
        $shipping_type = $_POST['shipping_type'];
        $receiver_name = $_POST['receiver_name'];
        $receiver_phone = $_POST['receiver_phone'];
        $order_address = $_POST['order_address'];
        $order_province = $_POST['order_province'];
        $customer_id_ref = $_POST['customer_id_ref'];


        //sql insert
        $stmtInsertOrders = $condb->prepare("INSERT INTO orders (tracking_number, shipping_type, customer_id_ref , receiver_name, receiver_phone, ref_center_id, order_address, order_province) VALUES ('$tracking_number', :shipping_type, :customer_id_ref , :receiver_name, :receiver_phone, :ref_center_id, :order_address, :order_province)");
        // bindparam
        $stmtInsertOrders->bindparam(':shipping_type', $shipping_type, PDO::PARAM_STR);
        $stmtInsertOrders->bindparam(':customer_id_ref', $customer_id_ref, PDO::PARAM_INT);
        $stmtInsertOrders->bindparam(':receiver_name', $receiver_name, PDO::PARAM_STR);
        $stmtInsertOrders->bindparam(':receiver_phone', $receiver_phone, PDO::PARAM_STR);
        $stmtInsertOrders->bindparam(':ref_center_id', $ref_center_id, PDO::PARAM_INT);
        $stmtInsertOrders->bindparam(':order_address', $order_address, PDO::PARAM_STR);
        $stmtInsertOrders->bindparam(':order_province', $order_province, PDO::PARAM_STR);
        $resultOrders = $stmtInsertOrders->execute();

        if ($resultOrders) {

            // รับค่า order_id ล่าสุดที่ถูกเพิ่ม
            $last_order_id = $condb->lastInsertId();

            // กำหนดค่าเริ่มต้นของ status
            $initial_status = "รับพัสดุเข้าศูนย์";

            // เพิ่มข้อมูลลงใน order_logs
            $stmtInsertLogs = $condb->prepare("INSERT INTO order_logs (order_id, status) VALUES (:order_id, :status)");
            $stmtInsertLogs->bindparam(':order_id', $last_order_id, PDO::PARAM_INT);
            $stmtInsertLogs->bindparam(':status', $initial_status, PDO::PARAM_STR);
            $stmtInsertLogs->execute();

            if ($stmtInsertLogs) {
                echo    '<script>
                            setTimeout(function() {
                            swal({
                                title: "เพิ่มข้อมูลสำเร็จ",
                                type: "success"
                            }, function() {
                                window.location = "orders.php?act=orders_list"; //หน้าที่ต้องการให้กระโดดไป
                            });
                            }, 1000);
                        </script>';
            }
        }
    } // end try
    catch (Exception $e) {
        echo 'Message: ' . $e->getMessage();
        // exit;
        echo '<script>
                        setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                            type: "error"
                        }, function() {
                            window.location = "orders.php?act=add&id=' . $cus_id_card . '; //หน้าที่ต้องการให้กระโดดไป
                        });
                        }, 1000);
                    </script>';
    } //end catch
} //isset
?>