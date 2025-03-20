<?php
if (isset($_GET['id']) && $_GET['act'] == 'edit') {

    // echo '<pre>';
    // print_r($_GET);
    // exit;

    // ประกาศตัวแปรรับค่า
    $order_id  = $_GET['id'];

    //คิวรี่ข้อมูล Single row พัสดุ
    $stmtOrdersDetails = $condb->prepare('SELECT ord.tracking_number, ord.shipping_type, c.name, c.cus_id_card , ord.receiver_name, ord.receiver_phone, ord.ref_center_id, d.center_name, ord.order_address, ord.order_province  
    FROM orders AS ord
    INNER JOIN tbl_customers AS c ON ord.customer_id_ref = c.customer_id
    LEFT JOIN delivery_centers AS d ON ord.ref_center_id = d.center_id
    WHERE ord.order_id = :order_id');
    //bindParam
    $stmtOrdersDetails->bindparam(':order_id', $order_id, PDO::PARAM_INT);
    $stmtOrdersDetails->execute();
    $rowOders = $stmtOrdersDetails->fetch(PDO::FETCH_ASSOC);


    //คิวรี่ข้อมูล
    $querycenters = $condb->prepare("SELECT center_id, center_name FROM delivery_centers");
    $querycenters->execute();
    $querycenters = $querycenters->fetchAll();

    // //คิวรี่ข้อมูล Single row ศูนย์กระจายสินค้า
    // $stmtcentersDetails = $condb->prepare("SELECT center_id, center_name FROM delivery_centers WHERE center_id = :center_id");
    // //bindParam
    // $stmtcentersDetails->bindparam(':center_id', $rowOders['center_id'], PDO::PARAM_STR);
    // $stmtcentersDetails->execute();
    // $rowcenters = $stmtcentersDetails->fetch(PDO::FETCH_ASSOC);

    // echo '<pre>';
    // print_r($rowcenters);
    // exit;

} //isset
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ฟอร์มแก้ไขข้อมูลพัสดุ</h1>
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
                                                <option disabled value="">-- เลือกข้อมูล -- </option>
                                                <?php
                                                foreach ($querycenters as $row) { ?>
                                                    <option <?= ($rowOders['ref_center_id'] == $row['center_id']) ? 'selected' : '' ?> value="<?= $row['center_id'] ?>">-- <?= $row['center_name'] ?> -- </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ประเภทการจัดส่งพัสดุ</label>
                                        <div class="col-sm-2">
                                            <select name="shipping_type" class="form-control" required>
                                                <option disabled value="">-- เลือกข้อมูล -- </option>
                                                <option <?= ($rowOders['shipping_type'] == 'ส่งปกติ') ? 'selected' : '' ?> value="ปกติ">-- ส่งปกติ -- </option>
                                                <option <?= ($rowOders['shipping_type'] == 'ส่งด่วน') ? 'selected' : '' ?> value="ส่งด่วน">-- ส่งด่วน -- </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">เลขบัตรประชาชน</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="cus_id_card" value="<?= $rowOders['cus_id_card'] ?>" class="form-control" placeholder="กรุณากรอกเลขบัตรประชาชน" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ผู้ส่ง</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="name" value="<?= $rowOders['name'] ?>" class="form-control" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ผู้รับ</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="receiver_name" value="<?= $rowOders['receiver_name'] ?>" class="form-control" placeholder="กรุณากรอกชื่อผู้รับ" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">เบอร์ผู้รับ</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="receiver_phone" value="<?= $rowOders['receiver_phone'] ?>" class="form-control" placeholder="กรุณากรอกเบอร์ผู้รับ" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ที่อยู่ปลายทาง</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="order_address" value="<?= $rowOders['order_address'] ?>" class="form-control" placeholder="กรุณากรอกที่อยู่ปลายทาง" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">จังหวัดปลายทาง</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="order_province" value="<?= $rowOders['order_province'] ?>" class="form-control" placeholder="กรุณากรอกจังหวัดปลายทาง" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-4">
                                            <input type="hidden" name="order_id" value="<?= $order_id ?>">
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
if (isset($_POST['order_id']) && isset($_POST['ref_center_id']) && isset($_POST['shipping_type']) && isset($_POST['receiver_name']) && isset($_POST['receiver_phone']) && isset($_POST['order_address']) && isset($_POST['order_province'])) {
    // echo 'ถูกเงื่อไข ส่งข้อมูลมาได้';
    // exit;

    //trigger exception in a "try" block
    try {
        // ประกาศตัวแปรรับค่าจากฟอร์ม
        $ref_center_id = $_POST['ref_center_id'];
        $shipping_type = $_POST['shipping_type'];
        $receiver_name = $_POST['receiver_name'];
        $receiver_phone = $_POST['receiver_phone'];
        $order_address = $_POST['order_address'];
        $order_province = $_POST['order_province'];

        //sql insert
        $stmtUpdateOrders= $condb->prepare("UPDATE orders SET ref_center_id = :ref_center_id, shipping_type = :shipping_type, receiver_name = :receiver_name, receiver_phone = :receiver_phone, order_address = :order_address, order_province = :order_province WHERE order_id = :order_id");
        // bindparam
        $stmtUpdateOrders->bindparam(':order_id', $order_id, PDO::PARAM_INT);
        $stmtUpdateOrders->bindparam(':ref_center_id', $ref_center_id, PDO::PARAM_INT);
        $stmtUpdateOrders->bindparam(':shipping_type', $shipping_type, PDO::PARAM_STR);
        $stmtUpdateOrders->bindparam(':receiver_name', $receiver_name, PDO::PARAM_STR);
        $stmtUpdateOrders->bindparam(':receiver_phone', $receiver_phone, PDO::PARAM_STR);
        $stmtUpdateOrders->bindparam(':order_address', $order_address, PDO::PARAM_STR);
        $stmtUpdateOrders->bindparam(':order_province', $order_province, PDO::PARAM_STR);
        $resultOrders = $stmtUpdateOrders->execute();

        $condb = null; //colse connect db

        if ($resultOrders) {
            echo    '<script>
                        setTimeout(function() {
                        swal({
                            title: "แก้ไขข้อมูลพัสดุสำเร็จ",
                            type: "success"
                        }, function() {
                            window.location = "orders.php?act=orders_list"; //หน้าที่ต้องการให้กระโดดไป
                        });
                        }, 1000);
                    </script>';
        }
    } // end try
    catch (Exception $e) {
        //echo 'Message: ' .$e->getMessage();
        //exit;
        echo '<script>
                setTimeout(function() {
                swal({
                    title: "เกิดข้อผิดพลาด !!",
                    text: "กรุณาติดต่อผู้ดูแลระบบ",
                    type: "error"
                }, function() {
                    window.location = "orders.php?id=' . $order_id . '&act=edit"; //หน้าที่ต้องการให้กระโดดไป
                });
                }, 1000);
            </script>';
    } //end catch
} //isset
// window.location = "member.php?id='.$id.'&act=edit"; //หน้าที่ต้องการให้กระโดดไป
?>