<?php
if (isset($_GET['id']) && $_GET['act'] == 'editPwd') {

    //single row query แสดงแค่ 1 รายการ   
    $stmtadminDetail = $condb->prepare("SELECT * FROM tbl_admin WHERE admin_id=?");
    $stmtadminDetail->execute([$_GET['id']]);
    $row = $stmtadminDetail->fetch(PDO::FETCH_ASSOC);

    // echo '<pre>';
    // print_r($row);    
    // exit;
    // echo $stmtadminDetail->rowCount();
    // exit;

    //ถ้าคิวรี่ผิดพลาดให้หยุดการทำงาน
    if ($stmtadminDetail->rowCount() != 1) {
        exit();
    }
} //isset
?>


<!-- Array
(
    [admin_id] => 8
    [admin_username] => frong@g.com
    [admin_password] => 3627909a29c31381a071ec27f7c9ca97726182aed29a7ddd2e54353322cfb30abb9e3a6df2ac2c20fe23436311d678564d0c8d305930575f60e2d3d048184d79
    [admin_name] => wiwat chaichana
    [admin_level] => admin
    [dateCreate] => 2025-02-23 11:14:38
) -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ฟอร์มแก้ไขรหัสผ่าน </h1>
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
                            <!-- form start -->
                            <form action="" method="post">
                                <div class="card-body">

                                    <div class="form-group row">
                                        <label class="col-sm-2">Username</label>
                                        <div class="col-sm-4">
                                            <input type="email" name="admin_username" value="<?= $row['admin_username'] ?>" class="form-control" disabled placeholder="Username">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">Admin Name</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="admin_name" value="<?= $row['admin_name'] ?>" class="form-control" disabled placeholder="Admin Name">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">Admin Level</label>
                                        <div class="col-sm-2">
                                            <select name="admin_level" class="form-control" disabled>
                                                <option disabled>-- เลือกข้อมูล -- </option>
                                                <option <?= ($row['admin_level'] == 'sdmin') ? 'selected' : '' ?> value="admin">-- Admin -- </option>
                                                <option <?= ($row['admin_level'] == 'staff') ? 'selected' : '' ?> value="staff">-- Staff -- </option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">New Password</label>
                                        <div class="col-sm-4">
                                            <input type="password" name="new_password" class="form-control" required placeholder="New password">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">Confirm Password</label>
                                        <div class="col-sm-4">
                                            <input type="password" name="confirm_password" class="form-control" required placeholder="Confirm password">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-4">
                                            <input type="hidden" name="admin_id" value="<?= $row['admin_id'] ?>">
                                            <button type="submit" name="act" value="editPwd" class="btn btn-primary"> แก้ไขรหัสผ่าน </button>
                                            <a href="admin.php" class="btn btn-danger">ยกเลิก</a>
                                        </div>
                                    </div>

                                </div> <!-- /.card-body -->

                            </form>
                            <?php
                            // echo '<pre>';
                            // print_r($_POST);
                            // exit;
                            ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- ./row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
// echo '<pre>';
// print_r($_POST);
// exit;

if (isset($_POST['admin_id']) && isset($_POST['new_password']) && isset($_POST['confirm_password']) && isset($_POST['act']) && $_POST['act'] == 'editPwd') {
    // echo '<pre>';
    // print_r($_POST);
    // exit;

    //trigger exception in a "try" block
    //ประกาศตัวแปรรับค่าจากฟอร์ม
    $admin_id = $_POST['admin_id'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    //ตรวจสอบรหัสผ่านว่าตรงกันมั้ย
    if ($new_password != $confirm_password) {
        // echo 'รหัสผ่านไม่ตรงกัน';
        echo '<script>
                             setTimeout(function() {
                              swal({
                                  title: "รหัสผ่านไม่ตรงกัน || กรุณากรอกรหัสผ่านใหม่อีกครั้ง",
                                  type: "error"
                              }, function() {
                                  window.location = "admin.php?id=' . $admin_id . '&act=editPwd";
                              });
                            }, 1000);
                        </script>';
    } else {
        // echo 'รหัสผ่านตรงกัน';

        $password = hash('sha512', $_POST['new_password']); //sha512 128 str)

        //sql update
        $stmtadminUpdate = $condb->prepare("UPDATE tbl_admin SET 
        admin_password='$password'
        WHERE admin_id = :admin_id
        ");

        //bindParam
        $stmtadminUpdate->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $AdminEdit = $stmtadminUpdate->execute();

        $condb = null; //close connect db

        if ($AdminEdit) {
            echo    '<script>
                        setTimeout(function() {
                        swal({
                            title: "แก้ไขรหัสผ่านสำเร็จ",
                            type: "success"
                        }, function() {
                            window.location = "admin.php";
                        });
                        }, 1000);
                    </script>';
        } else {
            echo    '<script>
                        setTimeout(function() {
                        swal({
                        title: "เกิดข้อผิดพลาด !!",
                        type: "error"
                        }, function() {
                        window.location = "admin.php?id=' . $row['admin_id'] . '&act=edit"; //หน้าที่ต้องการให้กระโดดไป
                        });
                        }, 1000);
                    </script>';
        } //else sweetalert
    } //else check password
} //isset

//window.location = "type.php?id='.$id.'&act=edit"; //หน้าที่ต้องการให้กระโดดไป
?>