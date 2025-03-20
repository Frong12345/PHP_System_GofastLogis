<?php
if (isset($_GET['id']) && $_GET['act'] == 'edit') {

    // ประกาศตัวแปรรับค่า
    $customer_id = $_GET['id'];
    
    //Single row query แสดงแค่ 1 รายการ
    $stmtCustomerDetail = $condb->prepare('SELECT * FROM tbl_customers WHERE customer_id = :customer_id');

    //bindParam
    $stmtCustomerDetail->bindparam(':customer_id', $customer_id, PDO::PARAM_INT);
    $stmtCustomerDetail->execute();
    $row = $stmtCustomerDetail->fetch(PDO::FETCH_ASSOC);

    // echo '<pre>';
    // print_r($row);
    // exit;

    //ถ้า query ผิดพลาดให้หยุดการทำงาน
    if ($stmtCustomerDetail->rowCount() != 1) {
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
                    <h1>ฟอร์มแก้ไขข้อมูลพนักงาน</h1>
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
                                        <label class="col-sm-2">เลขบัตรประชาชน</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="cus_id_card" value="<?= $row['cus_id_card']; ?>" class="form-control" placeholder="กรุณากรอกเลขบัตรประชาชน" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ชื่อ</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="name" value="<?= $row['name']; ?>" class="form-control" placeholder="กรุณากรอกชื่อ" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">อีเมล์</label>
                                        <div class="col-sm-4">
                                            <input type="email" name="email" value="<?= $row['email']; ?>" class="form-control" placeholder="กรุณากรอกอีเมล์" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">เบอร์</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="cus_phone" value="<?= $row['cus_phone']; ?>" class="form-control" placeholder="กรุณากรอกเบอร์" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-4">
                                            <input type="hidden" name="id" value="<?= $row['customer_id']; ?>">
                                            <button type="submit" class="btn btn-primary">ปรับปรุงข้อมูล</button>
                                            <a href="customers.php" class="btn btn-danger">ยกเลิก</a>
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
if (isset($_POST['id']) && isset($_POST['cus_id_card']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['cus_phone'])) {
    //    echo 'ถูกเงื่อไข ส่งข้อมูลมาได้';

    //trigger exception in a "try" block
    try {
        // ประกาศตัวแปรรับค่าจากฟอร์ม
        $customer_id = $_POST['id'];
        $cus_id_card = $_POST['cus_id_card'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $cus_phone = $_POST['cus_phone'];

        //sql insert
        $stmtUpdateCustomer = $condb->prepare("UPDATE tbl_customers SET cus_id_card = :cus_id_card, name = :name, email = :email, cus_phone = :cus_phone WHERE customer_id = :customer_id");
        // bindparam
        $stmtUpdateCustomer->bindparam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmtUpdateCustomer->bindparam(':cus_id_card', $cus_id_card, PDO::PARAM_STR);
        $stmtUpdateCustomer->bindparam(':name', $name, PDO::PARAM_STR);
        $stmtUpdateCustomer->bindparam(':email', $email, PDO::PARAM_STR);
        $stmtUpdateCustomer->bindparam(':cus_phone', $cus_phone, PDO::PARAM_STR);
        $result = $stmtUpdateCustomer->execute();

        $condb = null; //colse connect db

        if ($result) {
            echo    '<script>
                        setTimeout(function() {
                        swal({
                            title: "แก้ไขข้อมูลสำเร็จ",
                            type: "success"
                        }, function() {
                            window.location = "customers.php"; //หน้าที่ต้องการให้กระโดดไป
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
                    title: "เกิดข้อผิดพลาด || เลขบัตรประชาชน ซ้ำ !!",
                    text: "กรุณาติดต่อผู้ดูแลระบบ",
                    type: "error"
                }, function() {
                    window.location = "customers.php?id=' . $customer_id . '&act=edit"; //หน้าที่ต้องการให้กระโดดไป
                });
                }, 1000);
            </script>';
    } //end catch
} //isset
// window.location = "member.php?id='.$id.'&act=edit"; //หน้าที่ต้องการให้กระโดดไป
?>