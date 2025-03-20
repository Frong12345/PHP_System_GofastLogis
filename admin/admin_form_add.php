   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <section class="content-header">
       <div class="container-fluid">
         <div class="row mb-2">
           <div class="col-sm-6">
             <h1>ฟอร์มเพิ่มข้อมูล ผู้ดูแลระบบ/พนักงาน </h1>
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
                           <option value="admin">-- Admin -- </option>
                           <option value="staff">-- Staff -- </option>
                         </select>
                       </div>
                     </div>

                     <div class="form-group row">
                       <label class="col-sm-2">ภาพโปรไฟล์</label>
                       <div class="col-sm-4">
                         <div class="input-group">
                           <div class="custom-file">
                             <input type="file" name="admin_profile" class="custom-file-input" required id="exampleInputFile" accept="image/*">
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
                         <input type="text" name="admin_name" class="form-control" required placeholder="กรุณากรอกชื่อ-นามสกุล">
                       </div>
                     </div>

                     <div class="form-group row">
                       <label class="col-sm-2">เบอร์โทร</label>
                       <div class="col-sm-4">
                         <input type="text" name="admin_phone" class="form-control" required placeholder="กรุณากรอกเบอร์โทร">
                       </div>
                     </div>

                     <div class="form-group row">
                       <label class="col-sm-2">อีเมล์</label>
                       <div class="col-sm-4">
                         <input type="email" name="admin_email" class="form-control" required placeholder="กรุณากรอกอีเมล์">
                       </div>
                     </div>

                     <div class="form-group row">
                       <label class="col-sm-2">รหัสผ่าน</label>
                       <div class="col-sm-4">
                         <input type="password" name="new_password" class="form-control" required placeholder="กรุณากรอกรหัสผ่าน">
                       </div>
                     </div>

                     <div class="form-group row">
                       <label class="col-sm-2">ยืนยันรหัสผ่าน</label>
                       <div class="col-sm-4">
                         <input type="password" name="confirm_password" class="form-control" required placeholder="กรุณายืนยันรหัสผ่าน">
                       </div>
                     </div>

                     <div class="form-group row">
                       <label class="col-sm-2"></label>
                       <div class="col-sm-4">
                         <button type="submit" name="act" value="add" class="btn btn-primary"> เพิ่มข้อมูล </button>
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
    if (isset($_POST['admin_level']) && isset($_POST['admin_name']) && isset($_POST['admin_phone']) && isset($_POST['admin_email']) && isset($_POST['new_password']) && isset($_POST['confirm_password']) && $_POST['act'] == 'add') {
      // echo '<pre>';
      // print_r($_POST);
      // echo '<hr>';
      // print_r($_FILES);
      // exit;

      //trigger exception in a "try" block
      try {

        // ประกาศตัวแปรรับค่าจากฟอร์ม
        $admin_level = $_POST['admin_level'];
        $admin_name = $_POST['admin_name'];
        $admin_phone = $_POST['admin_phone'];
        $admin_email = $_POST['admin_email'];
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
                                  window.location = "admin.php?act=add";
                              });
                            }, 1000);
                        </script>';
        } else {
          // echo 'รหัสผ่านตรงกัน';
          // exit;


          //check Email ซ้ำ
          //Single row query แสดงแค่ 1 รายการ
          $stmtAdminDetail = $condb->prepare('SELECT admin_email FROM tbl_admin WHERE admin_email = :admin_email');
          //bindParam
          $stmtAdminDetail->bindParam(':admin_email', $admin_email, PDO::PARAM_STR);
          $stmtAdminDetail->execute();
          $row = $stmtAdminDetail->fetch(PDO::FETCH_ASSOC);

          //ถ้า query ได้ 1 คือ username ซ้ำ ให้หยุดการทำงาน
          if ($stmtAdminDetail->rowCount() != 0) {
            // echo 'ซ้ำ';
            // exit;
            echo '<script>
                 setTimeout(function() {
                 swal({
                     title: "อีเมล ซ้ำ !!",
                     text: "กรุณาเพิ่มข้อมูลใหม่อีกครั้ง",
                     type: "error"
                 }, function() {
                     window.location = "admin.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                 });
                 }, 1000);
             </script>';
          } else {
            // echo 'ไม่ซ้ำ';
            // exit;

            $password = hash('sha512', $_POST['new_password']); //sha512 128 str)

            //สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ใหม่
            $date1 = date("Ymd_His");
            //สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
            $numrand = (mt_rand());
            $student_image = (isset($_POST['admin_profile']) ? $_POST['admin_profile'] : '');
            $upload = $_FILES['admin_profile']['name'];

            if ($upload != '') {
              //ตัดขื่อเอาเฉพาะนามสกุล
              $typefile = strrchr($_FILES['admin_profile']['name'], ".");

              //โฟลเดอร์ที่เก็บไฟล์
              $path = "../assetsBackend/profile_img/";
              //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
              $newname = $numrand . $date1 . $typefile;
              $path_copy = $path . $newname;
              //คัดลอกไฟล์ไปยังโฟลเดอร์
              move_uploaded_file($_FILES['admin_profile']['tmp_name'], $path_copy);


              //sql insert
              $stmtInsertAdmin = $condb->prepare("INSERT INTO tbl_admin
            (admin_profile, admin_level, admin_name, admin_phone, admin_email, admin_password)
            VALUES 
            ('$newname', :admin_level, :admin_name, :admin_phone, :admin_email, '$password')
            ");

              //bindParam
              $stmtInsertAdmin->bindParam(':admin_level', $admin_level, PDO::PARAM_STR);
              $stmtInsertAdmin->bindParam(':admin_name', $admin_name, PDO::PARAM_STR);
              $stmtInsertAdmin->bindParam(':admin_phone', $admin_phone, PDO::PARAM_STR);
              $stmtInsertAdmin->bindParam(':admin_email', $admin_email, PDO::PARAM_STR);
              $result = $stmtInsertAdmin->execute();

              $condb = null; //close connect db
              if ($result) {
                echo '<script>
                             setTimeout(function() {
                             swal({
                                 title: "เพิ่มข้อมูลสำเร็จ",
                                 type: "success"
                             }, function() {
                                 window.location = "admin.php"; //หน้าที่ต้องการให้กระโดดไป
                             });
                             }, 1000);
                         </script>';
              }
            }
          }
        }
      } // end try
      catch (Exception $e) {
        echo 'Message: ' . $e->getMessage();
        exit;
        echo '<script>
                    setTimeout(function() {
                    swal({
                        title: "เกิดข้อผิดพลาด",
                        type: "error"
                    }, function() {
                        window.location = "admin.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                    });
                    }, 1000);
                </script>';
      } //end catch
    }
    ?>