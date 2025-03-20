<?php
if (isset($_GET['id']) && $_GET['act'] == 'edit') {

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
          <h1>ฟอร์มแก้ไขข้อมูล ผู้ดูแลระบบ/พนักงาน </h1>
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
                      <input type="email" name="admin_username" value="<?= $row['admin_username'] ?>" class="form-control" required placeholder="Username">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">Admin Name</label>
                    <div class="col-sm-4">
                      <input type="text" name="admin_name" value="<?= $row['admin_name'] ?>" class="form-control" required placeholder="Admin Name">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">Admin Level</label>
                    <div class="col-sm-2">
                      <select name="admin_level" class="form-control" required>
                        <option disabled>-- เลือกข้อมูล -- </option>
                        <option <?= ($row['admin_level'] == 'admin') ? 'selected' : '' ?> value="admin">-- Admin -- </option>
                        <option <?= ($row['admin_level'] == 'staff') ? 'selected' : '' ?> value="staff">-- Staff -- </option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-4">
                      <input type="hidden" name="admin_id" value="<?= $row['admin_id'] ?>">
                      <button type="submit" name="act" value="edit" class="btn btn-primary"> ปรับปรุงข้อมูล </button>
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

if (isset($_POST['admin_id']) && isset($_POST['admin_username']) && isset($_POST['admin_name']) && isset($_POST['admin_level']) && isset($_POST['act']) && $_POST['act'] == 'edit') {
  // echo '<pre>';
  // print_r($_POST);
  // exit;

  //trigger exception in a "try" block
  try {
    //ประกาศตัวแปรรับค่าจากฟอร์ม
    $admin_id = $_POST['admin_id'];
    $admin_username = $_POST['admin_username'];
    $admin_name = $_POST['admin_name'];
    $admin_level = $_POST['admin_level'];

    //sql update
    $stmtadminUpdate = $condb->prepare("UPDATE tbl_admin SET 
                    admin_username=:admin_username,
                    admin_name=:admin_name,
                    admin_level=:admin_level

                    WHERE admin_id=:admin_id
                    ");
    //bindParam
    $stmtadminUpdate->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
    $stmtadminUpdate->bindParam(':admin_username', $admin_username, PDO::PARAM_STR);
    $stmtadminUpdate->bindParam(':admin_name', $admin_name, PDO::PARAM_STR);
    $stmtadminUpdate->bindParam(':admin_level', $admin_level, PDO::PARAM_STR);

    $AdminEdit = $stmtadminUpdate->execute();

    $condb = null; //close connect db

    if ($AdminEdit) {
      echo '<script>
                             setTimeout(function() {
                              swal({
                                  title: "แก้ไขข้อมูลสำเร็จ",
                                  type: "success"
                              }, function() {
                                  window.location = "admin.php";
                              });
                            }, 1000);
                        </script>';
    }
  } //try
  //catch exception
  catch (Exception $e) {
    //echo 'Message: ' .$e->getMessage();
    echo '<script>
         setTimeout(function() {
          swal({
              title: "เกิดข้อผิดพลาด || ข้อมูล Username ซ้ำ !!",
              type: "error"
          }, function() {
              window.location = "admin.php?id=' . $row['admin_id'] . '&act=edit"; //หน้าที่ต้องการให้กระโดดไป
          });
        }, 1000);
    </script>';
  } //catch


} //isset

//window.location = "type.php?id='.$id.'&act=edit"; //หน้าที่ต้องการให้กระโดดไป
?>