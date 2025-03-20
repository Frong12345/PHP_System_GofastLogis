<?php

if (isset($_POST['cus_id_card'])) {
    // echo 'ถูกเงื่อไข ส่งข้อมูลมาได้';
    // echo '<pre>';
    // print_r($_POST);
    // exit;

    //trigger exception in a "try" block
    try {
        // ประกาศตัวแปรรับค่าจากฟอร์ม
        $cus_id_card = $_POST['cus_id_card'];

        //check บัตรประชาชน ว่ามีข้อมูลมั้ย
        //Single row query แสดงแค่ 1 รายการ
        $stmtCheckID = $condb->prepare('SELECT cus_id_card FROM tbl_customers WHERE cus_id_card = :cus_id_card');
        // bindparam
        $stmtCheckID->bindparam(':cus_id_card', $cus_id_card, PDO::PARAM_STR);
        $stmtCheckID->execute();
        $row = $stmtCheckID->fetch(PDO::FETCH_ASSOC);

        // echo $stmtCheckID->rowCount();
        // echo '<hr>';
        // exit;
        //ถ้า query ได้ 1 คือ มีข้อมูล บัตรประชาชน  ให้ทำงานหน้ากรอกข้อมูลพัสดุต่อ
        if ($stmtCheckID->rowCount() != 0) {
            // echo 'มีข้อมูล';
            // exit;

            header('Location: orders.php?act=add&id='.$cus_id_card);
            
        } else {
            // echo 'ไม่มีข้อมูล';
            // exit;

            echo '<script>
                        setTimeout(function() {
                        swal({
                            title: "ไม่พบหมายเลขบัตรประชาชนในระบบ !!",
                            text: "กรุณาลงทะเบียนใหม่",
                            type: "error"
                        }, function() {
                            window.location = "customers.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                        });
                        }, 1000);
                    </script>';

        } //else rowCount check บัตรประชาชน มีข้อมูลเดิมมั้ย
    } // end try
    catch (Exception $e) {
        // echo 'Message: ' .$e->getMessage();
        // exit;
        echo '<script>
                        setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                            type: "error"
                        }, function() {
                            window.location = "customers.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                        });
                        }, 1000);
                    </script>';
    } //end catch
} //isset
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ฟอร์มเพิ่มข้อมูลพัสดุ</h1>
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
                                            <input type="text" name="cus_id_card" class="form-control" placeholder="กรุณากรอกเลขบัตรประชาชน" required>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-4">
                                            <button type="submit" class="btn btn-primary">ต่อไป</button>
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