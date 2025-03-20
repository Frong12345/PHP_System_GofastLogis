  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1>ฟอร์มเพิ่มข้อมูลศูนย์กระจายสินค้า</h1>
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
                                              <input type="text" name="name" class="form-control" placeholder="กรุณากรอกชื่อจังหวัด" required>
                                          </div>
                                      </div>

                                      <div class="form-group row">
                                          <label class="col-sm-2">ที่อยู่</label>
                                          <div class="col-sm-4">
                                              <input type="text" name="center_address" class="form-control" placeholder="กรุณากรอกที่อยู่ (เลขที่/หมู่/อำเภอ/รหัสไปรษณีย์)" required>
                                          </div>
                                      </div>

                                      <div class="form-group row">
                                          <label class="col-sm-2">เบอร์</label>
                                          <div class="col-sm-4">
                                              <input type="text" name="center_phone" class="form-control" placeholder="กรุณากรอกเบอร์" required>
                                          </div>
                                      </div>

                                      <div class="form-group row">
                                          <label class="col-sm-2"></label>
                                          <div class="col-sm-4">
                                              <button type="submit" class="btn btn-primary">เพิ่มข้อมูล</button>
                                              <a href="distribution_centers.php" class="btn btn-danger">ยกเลิก</a>
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
    // exit;

    if (isset($_POST['name']) && isset($_POST['center_address']) && isset($_POST['center_phone'])) {
        // echo 'ถูกเงื่อไข ส่งข้อมูลมาได้';
        // echo '<pre>';
        // print_r($_POST);
        // exit;

        //trigger exception in a "try" block
        try {
            // ประกาศตัวแปรรับค่าจากฟอร์ม
            $name = $_POST['name'];
            $center_address = $_POST['center_address'];
            $center_phone = $_POST['center_phone'];

            //check ที่อยู่ ซ้ำ
            //Single row query แสดงแค่ 1 รายการ
            $stmtCheckAddress = $condb->prepare('SELECT center_address FROM delivery_centers WHERE center_address = :center_address');
            // bindparam
            $stmtCheckAddress->bindparam(':center_address', $center_address, PDO::PARAM_STR);
            $stmtCheckAddress->execute();
            $row = $stmtCheckAddress->fetch(PDO::FETCH_ASSOC);

            // echo $stmtCheckID->rowCount();
            // echo '<hr>';
            // exit;
            //ถ้า query ได้ 1 คือ ที่อยู่ ซ้ำ ให้หยุดการทำงาน
            if ($stmtCheckAddress->rowCount() != 0) {
                // echo 'ซ้ำ';
                // exit;
                echo '<script>
                        setTimeout(function() {
                        swal({
                            title: "ที่อยู่ศูนย์กระจายสินค้า ซ้ำ !!",
                            text: "กรุณาเพิ่มข้อมูลใหม่อีกครั้ง",
                            type: "error"
                        }, function() {
                            window.location = "distribution_centers.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                        });
                        }, 1000);
                    </script>';
            } else {
                // echo 'ไม่ซ้ำ';
                // exit;

                //sql insert
                $stmtInsertCenter = $condb->prepare("INSERT INTO delivery_centers (center_name, center_address, center_phone) VALUES (:name, :center_address, :center_phone)");
                // bindparam
                $stmtInsertCenter->bindparam(':name', $name, PDO::PARAM_STR);
                $stmtInsertCenter->bindparam(':center_address', $center_address, PDO::PARAM_STR);
                $stmtInsertCenter->bindparam(':center_phone', $center_phone, PDO::PARAM_STR);
                $result = $stmtInsertCenter->execute();

                $condb = null; //colse connect db

                if ($result) {
                    echo    '<script>
                                        setTimeout(function() {
                                        swal({
                                            title: "เพิ่มข้อมูลสำเร็จ",
                                            type: "success"
                                        }, function() {
                                            window.location = "distribution_centers.php"; //หน้าที่ต้องการให้กระโดดไป
                                        });
                                        }, 1000);
                                    </script>';
                }
            } //else rowCount check ที่อยู่ ไม่ซ้ำ
        } // end try
        catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
            exit;
            echo '<script>
                        setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                            type: "error"
                        }, function() {
                            window.location = "distribution_centers.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                        });
                        }, 1000);
                    </script>';
        } //end catch
    } //isset
    ?>