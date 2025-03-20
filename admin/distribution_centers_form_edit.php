<?php
if (isset($_GET['id']) && $_GET['act'] == 'edit') {

    // ประกาศตัวแปรรับค่า
    $customer_id = $_GET['id'];
    
    //Single row query แสดงแค่ 1 รายการ
    $stmtCenterDetails = $condb->prepare('SELECT * FROM delivery_centers WHERE center_id = :center_id');
    $stmtCenterDetails->bindparam(':center_id', $customer_id, PDO::PARAM_INT);
    $stmtCenterDetails->execute();
    $row = $stmtCenterDetails->fetch(PDO::FETCH_ASSOC);

    // echo '<pre>';
    // print_r($row);
    // exit;

    //ถ้า query ผิดพลาดให้หยุดการทำงาน
    if ($stmtCenterDetails->rowCount() != 1) {
        exit;
    }
} //isset
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ฟอร์มแก้ไขศูนย์กระจายสินค้า</h1>
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
                                        <label class="col-sm-2">จังหวัด</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="center_name" value="<?= $row['center_name']; ?>" class="form-control" placeholder="กรุณากรอกชื่อจังหวัด" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ที่อยู่</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="center_address" value="<?= $row['center_address']; ?>" class="form-control" placeholder="กรุณากรอกที่อยู่ (เลขที่/หมู่/อำเภอ/รหัสไปรษณีย์)" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">เบอร์</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="center_phone" value="<?= $row['center_phone']; ?>" class="form-control" placeholder="กรุณากรอกเบอร์" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-4">
                                            <input type="hidden" name="id" value="<?= $row['center_id']; ?>">
                                            <button type="submit" class="btn btn-primary">ปรับปรุงข้อมูล</button>
                                            <a href="distribution_centers.php" class="btn btn-danger">ยกเลิก</a>
                                        </div>
                                    </div>

                                </div> <!-- /.card-body -->
                                <?php
                                // เช็ค Input ที่ส่งมาจากฟอร์ม
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
if (isset($_POST['id']) && isset($_POST['center_name'])  && isset($_POST['center_address'])&& isset($_POST['center_phone'])) {
    //    echo 'ถูกเงื่อไข ส่งข้อมูลมาได้';

    //trigger exception in a "try" block
    try {
        // ประกาศตัวแปรรับค่าจากฟอร์ม
        $center_name = $_POST['center_name'];
        $center_address = $_POST['center_address'];
        $center_phone = $_POST['center_phone'];
        $center_id = $_POST['id'];

        //sql insert
        $stmtUpdateCustomer = $condb->prepare("UPDATE delivery_centers SET center_name = :center_name, center_address = :center_address, center_phone = :center_phone WHERE center_id = :center_id");
        // bindparam

        $stmtUpdateCustomer->bindparam(':center_id', $center_id, PDO::PARAM_INT);
        $stmtUpdateCustomer->bindparam(':center_name', $center_name, PDO::PARAM_STR);
        $stmtUpdateCustomer->bindparam(':center_address', $center_address, PDO::PARAM_STR);
        $stmtUpdateCustomer->bindparam(':center_phone', $center_phone, PDO::PARAM_STR);
        $result = $stmtUpdateCustomer->execute();

        $condb = null; //colse connect db

        if ($result) {
            echo    '<script>
                        setTimeout(function() {
                        swal({
                            title: "แก้ไขข้อมูลสำเร็จ",
                            type: "success"
                        }, function() {
                            window.location = "distribution_centers.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                        }, 1000);
                    </script>';
        }
    } // end try
    catch (Exception $e) {
        echo 'Message: ' .$e->getMessage();
        exit;
        echo '<script>
                setTimeout(function() {
                swal({
                    title: "เกิดข้อผิดพลาด!!",
                    text: "กรุณาติดต่อผู้ดูแลระบบ",
                    type: "error"
                }, function() {
                    window.location = "distribution_centers.php?id=' . $center_id . '&act=edit"; //หน้าที่ต้องการให้กระโดดไป
                });
                }, 1000);
            </script>';
    } //end catch
} //isset
// window.location = "member.php?id='.$id.'&act=edit"; //หน้าที่ต้องการให้กระโดดไป
?>