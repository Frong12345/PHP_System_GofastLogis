<?php
if (isset($_GET['id']) && $_GET['act'] == 'edit') {

  // ประกาศตัวแปรรับค่า
  $admin_id = $_GET['id'];

  //single row query แสดงแค่ 1 รายการ   
  $stmtadminDetail = $condb->prepare("SELECT * FROM tbl_admin WHERE admin_id=:admin_id");

  //bindParam
  $stmtadminDetail->bindparam(':admin_id', $admin_id, PDO::PARAM_INT);
  $stmtadminDetail->execute();
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
              <form action="" method="post" onsubmit="return ValidateTypeFile(this);" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group row">
                    <label class="col-sm-2">สิทธื์การเข้าใช้งาน</label>
                    <div class="col-sm-2">
                      <select name="admin_level" class="form-control" required>
                        <option value="">-- เลือกข้อมูล -- </option>
                        <option <?= ($row['admin_level'] == 'admin') ? 'selected' : '' ?> value="admin">-- Admin -- </option>
                        <option <?= ($row['admin_level'] == 'staff') ? 'selected' : '' ?> value="staff">-- Staff -- </option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">ภาพโปรไฟล์</label>
                    <div class="col-sm-4">
                      ภาพเก่า <?= $row['admin_profile'] ?> <br>
                      <img src="../assetsBackend/profile_img/<?= $row['admin_profile'] ?>" width="150px">
                      <br> <br>
                      เลือกภาพใหม่
                      <br>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" name="admin_profile" class="custom-file-input" id="exampleInputFile" accept="image/*">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                          <span class="input-group-text">Upload</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">ชื่อ</label>
                    <div class="col-sm-4">
                      <input type="text" name="admin_name" value="<?= $row['admin_name']; ?>" class="form-control" required placeholder="กรุณากรอกชื่อ-นามสกุล">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">เบอร์โทร</label>
                    <div class="col-sm-4">
                      <input type="text" name="admin_phone" value="<?= $row['admin_phone']; ?>" class="form-control" required placeholder="กรุณากรอกเบอร์โทร">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">อีเมล์</label>
                    <div class="col-sm-4">
                      <input type="email" name="admin_email" value="<?= $row['admin_email']; ?>" class="form-control" required placeholder="กรุณากรอกอีเมล์">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-4">
                      <input type="hidden" name="id" value="<?= $row['admin_id'] ?>">
                      <input type="hidden" name="Old_image" value="<?= $row['admin_profile']; ?>">
                      <button type="submit" name="act" value="edit" class="btn btn-primary"> ปรับปรุงข้อมูล </button>
                      <a href="admin.php" class="btn btn-danger">ยกเลิก</a>
                    </div>
                  </div>

                </div> <!-- /.card-body -->

                <?php
                // echo '<pre>';
                // print_r($_POST);
                // echo '<hr>';
                // print_r($_FILES);
                // exit;
                ?>
              </form>

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

if (isset($_POST['id']) && isset($_POST['admin_level']) && isset($_POST['admin_name']) && isset($_POST['admin_phone']) && isset($_POST['admin_email']) && $_POST['act'] == 'edit') {
  // print_r($_POST);
  // echo '<hr>';
  // print_r($_FILES);
  // exit;


  //ประกาศตัวแปรรับค่าจากฟอร์ม
  $admin_id = $_POST['id'];
  $admin_email = $_POST['admin_email'];
  $admin_name = $_POST['admin_name'];
  $admin_phone = $_POST['admin_phone'];
  $admin_level = $_POST['admin_level'];


  $upload = $_FILES['admin_profile']['name'];
  //สร้างเงื่อนไขตรวจสอบการอัพโหลดไฟล์

  if ($upload == '') {
    // echo 'ไม่มีการอัพโหลดไฟล์';
    // exit;

    //trigger exception in a "try" block
    try {
      //sql update without upload file
      $stmtadminUpdate = $condb->prepare("UPDATE tbl_admin SET 
      admin_email=:admin_email,
      admin_name=:admin_name,
      admin_phone=:admin_phone,
      admin_level=:admin_level
      WHERE admin_id=:admin_id
      ");

      //bindParam
      $stmtadminUpdate->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
      $stmtadminUpdate->bindParam(':admin_email', $admin_email, PDO::PARAM_STR);
      $stmtadminUpdate->bindParam(':admin_name', $admin_name, PDO::PARAM_STR);
      $stmtadminUpdate->bindParam(':admin_phone', $admin_phone, PDO::PARAM_STR);
      $stmtadminUpdate->bindParam(':admin_level', $admin_level, PDO::PARAM_STR);
      $AdminEdit = $stmtadminUpdate->execute();

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
      } else {
        echo '<script>
                    setTimeout(function() {
                    swal({
                        title: "เกิดข้อผิดพลาด",
                        type: "error"
                    }, function() {
                        window.location = "admin.php?id=' . $admin_id . '&act=edit""; //หน้าที่ต้องการให้กระโดดไป
                    });
                    }, 1000);
                </script>';
      } //else ของ if AdminEdit
    } catch (Exception $e) {
      //echo 'Message: ' .$e->getMessage();
      echo '<script>
           setTimeout(function() {
            swal({
                title: "เกิดข้อผิดพลาด || ข้อมูล Username ซ้ำ !!",
                type: "error"
            }, function() {
                window.location = "admin.php?id=' . $admin_id . '&act=edit"; //หน้าที่ต้องการให้กระโดดไป
            });
          }, 1000);
      </script>';
    } //catch
  } //if ไม่มีการอัพโหลดไฟล์
  else {
    // echo 'มีการอัพโหลดไฟล์ใหม่';
    // exit;

    //สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ใหม่
    $date1 = date("Ymd_His");
    //สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
    $numrand = (mt_rand());
    $admin_profile = (isset($_POST['admin_profile']) ? $_POST['admin_profile'] : '');

    //ตัดขื่อเอาเฉพาะนามสกุล
    $typefile = strrchr($_FILES['admin_profile']['name'], ".");

    // echo $typefile;
    // echo '<hr>';
    // echo $_POST['Old_image'];
    // exit;

    //โฟลเดอร์ที่เก็บไฟล์
    $path = "../assetsBackend/profile_img/";
    //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
    $newname = $numrand . $date1 . $typefile;
    $path_copy = $path . $newname;

    // echo $path_copy;
    // exit;

    //trigger exception in a "try" block
    try {
      //sql update without upload file
      $stmtadminUpdate = $condb->prepare("UPDATE tbl_admin SET 
      admin_email=:admin_email,
      admin_name=:admin_name,
      admin_phone=:admin_phone,
      admin_level=:admin_level,
      admin_profile='$newname'

      WHERE admin_id=:admin_id
      ");

      //bindParam
      $stmtadminUpdate->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
      $stmtadminUpdate->bindParam(':admin_email', $admin_email, PDO::PARAM_STR);
      $stmtadminUpdate->bindParam(':admin_name', $admin_name, PDO::PARAM_STR);
      $stmtadminUpdate->bindParam(':admin_phone', $admin_phone, PDO::PARAM_STR);
      $stmtadminUpdate->bindParam(':admin_level', $admin_level, PDO::PARAM_STR);
      $AdminEdit = $stmtadminUpdate->execute();

      if ($AdminEdit) {
        echo '<script>
                    setTimeout(function() {
                    swal({
                        title: "ปรับปรุงข้อมูลสำเร็จ",
                        type: "success"
                    }, function() {
                        window.location = "admin.php"; //หน้าที่ต้องการให้กระโดดไป
                    });
                    }, 1000);
                </script>';
      }
      if ($AdminEdit) {
        //ลบภาพเก่า
        unlink('../assetsBackend/profile_img/' . $_POST['Old_image']);
        //คัดลอกไฟล์ไปยังโฟลเดอร์
        move_uploaded_file($_FILES['admin_profile']['tmp_name'], $path_copy);
      }
    } //try
    //catch exception
    catch (Exception $e) {
      echo 'Message: ' . $e->getMessage();
      echo '<script>
          setTimeout(function() {
          swal({
              title: "เกิดข้อผิดพลาด",
              type: "error"
          }, function() {
              window.location = "admin.php?id=' . $admin_id . '&act=edit"; //หน้าที่ต้องการให้กระโดดไป
          });
          }, 1000);
      </script>';
    } //catch
  } //else มีการอัพโหลดไฟล์
} //isset

//window.location = "type.php?id='.$id.'&act=edit"; //หน้าที่ต้องการให้กระโดดไป
?>