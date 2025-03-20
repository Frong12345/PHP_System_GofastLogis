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
                <form action="" method="post">
                  <div class="card-body">

                    <div class="form-group row">
                      <label class="col-sm-2">Username</label>
                      <div class="col-sm-4">
                        <input type="email" name="admin_username" class="form-control" required placeholder="Username">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2">Password</label>
                      <div class="col-sm-4">
                        <input type="password" name="admin_password" class="form-control" required placeholder="password">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2">Admin Name</label>
                      <div class="col-sm-4">
                        <input type="text" name="admin_name" class="form-control" required placeholder="Admin Name">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2">Admin Level</label>
                      <div class="col-sm-2">
                        <select name="admin_level" class="form-control" required>
                          <option value="">-- เลือกข้อมูล -- </option>
                          <option value="admin">-- Admin -- </option>
                          <option value="staff">-- Staff -- </option>
                        </select>

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
  //เช็ค input ที่ส่งมาจากฟอร์ม
  // echo '<pre>';
  // print_r($_POST);
  // exit;

  if (isset($_POST['admin_username']) && isset($_POST['admin_password']) && isset($_POST['admin_name']) && isset($_POST['admin_level']) && isset($_POST['act']) && $_POST['act'] == 'add') {
    // echo 'ถูกเงื่อนไข ส่งข้อมูลมาได้';
    // exit;

    //trigger exception in a "try" block
    try {

      //ประกาศตัวแปรรับค่าจากฟอร์ม
      $admin_username = $_POST['admin_username'];
      $admin_password = hash('sha512', $_POST['admin_password']); //sha512 128 str)
      $admin_name = $_POST['admin_name'];
      $admin_level = $_POST['admin_level'];

      //เช็ค admin_name ซ้ำ
      //single row query แสดงแค่ 1 รายการ   
      $stmtadminDetail = $condb->prepare("SELECT admin_username FROM tbl_admin WHERE admin_username = :admin_username");
      //bindParam
      $stmtadminDetail->bindParam(':admin_username', $admin_username, PDO::PARAM_STR);
      $stmtadminDetail->execute();
      $row = $stmtadminDetail->fetch(PDO::FETCH_ASSOC);

      //นับจำนวนการคิวรี่ ถ้าได้ 1 คือ admin_name ซ้ำ
      // echo $stmtadminDetail->rowCount();
      // echo '<hr>';
      // exit;
      if ($stmtadminDetail->rowCount() != 0) {
        //echo 'admin_name ซ้ำ';
        echo '<script>
                        setTimeout(function() {
                          swal({
                              title: "Username ซ้ำ !!",
                              text: "กรุณาเพิ่มข้อมูลใหม่อีกครั้ง",
                              type: "error"
                          }, function() {
                              window.location = "admin.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                          });
                        }, 1000);
                    </script>';
      } else {
        //echo 'ไม่มี admin_name ซ้ำ';
        //sql insert
        $stmtInsertadmin = $condb->prepare("INSERT INTO tbl_admin
                    (admin_username, admin_password, admin_name, admin_level)
                    VALUES 
                    (:admin_username, '$admin_password', :admin_name, :admin_level)
                    ");

        //bindParam
        $stmtInsertadmin->bindParam(':admin_username', $admin_username, PDO::PARAM_STR);
        $stmtInsertadmin->bindParam(':admin_name', $admin_name, PDO::PARAM_STR);
        $stmtInsertadmin->bindParam(':admin_level', $admin_level, PDO::PARAM_STR);
        $result = $stmtInsertadmin->execute();

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
      } //เช็คข้อมูลซ้ำ                         
    } //try
    //catch exception
    catch (Exception $e) {
      //echo 'Message: ' .$e->getMessage();
      //exit;
      echo '<script>
                             setTimeout(function() {
                              swal({
                                  title: "เกิดข้อผิดพลาด",
                                  admin: "error"
                              }, function() {
                                  window.location = "admin.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                              });
                            }, 1000);
                        </script>';
    } //catch
  } //isset
  ?>