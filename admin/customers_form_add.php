  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1>ฟอร์มเพิ่มข้อมูลลูกค้า</h1>
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
                                          <label class="col-sm-2">ชื่อ</label>
                                          <div class="col-sm-4">
                                              <input type="text" name="name" class="form-control" placeholder="กรุณากรอกชื่อ" required>
                                          </div>
                                      </div>

                                      <div class="form-group row">
                                          <label class="col-sm-2">อีเมล์</label>
                                          <div class="col-sm-4">
                                              <input type="email" name="email" class="form-control" placeholder="กรุณากรอกอีเมล์" required>
                                          </div>
                                      </div>

                                      <div class="form-group row">
                                          <label class="col-sm-2">เบอร์</label>
                                          <div class="col-sm-4">
                                              <input type="text" name="cus_phone" class="form-control" placeholder="กรุณากรอกเบอร์" required>
                                          </div>
                                      </div>

                                      <div class="form-group row">
                                          <label class="col-sm-2"></label>
                                          <div class="col-sm-4">
                                              <button type="submit" class="btn btn-primary">เพิ่มข้อมูล</button>
                                              <a href="customers.php" class="btn btn-danger">ยกเลิก</a>
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

    if (isset($_POST['cus_id_card']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['cus_phone'])) {
        // echo 'ถูกเงื่อไข ส่งข้อมูลมาได้';
        // echo '<pre>';
        // print_r($_POST);
        // exit;

        //trigger exception in a "try" block
        try {
            // ประกาศตัวแปรรับค่าจากฟอร์ม
            $cus_id_card = $_POST['cus_id_card'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $cus_phone = $_POST['cus_phone'];

            //check บัตรประชาชน ซ้ำ
            //Single row query แสดงแค่ 1 รายการ
            $stmtCheckID = $condb->prepare('SELECT cus_id_card FROM tbl_customers WHERE cus_id_card = :cus_id_card');
            // bindparam
            $stmtCheckID->bindparam(':cus_id_card', $cus_id_card, PDO::PARAM_STR);
            $stmtCheckID->execute();
            $row = $stmtCheckID->fetch(PDO::FETCH_ASSOC);

            // echo $stmtCheckID->rowCount();
            // echo '<hr>';
            // exit;
            //ถ้า query ได้ 1 คือ บัตรประชาชน ซ้ำ ให้หยุดการทำงาน
            if ($stmtCheckID->rowCount() != 0) {
                // echo 'ซ้ำ';
                // exit;
                echo '<script>
                        setTimeout(function() {
                        swal({
                            title: "เลขบัตรประชาชน ซ้ำ !!",
                            text: "กรุณาเพิ่มข้อมูลใหม่อีกครั้ง",
                            type: "error"
                        }, function() {
                            window.location = "customers.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                        });
                        }, 1000);
                    </script>';
            } else {
                // echo 'ไม่ซ้ำ';
                // exit;

                //sql insert
                $stmtInsertCustomer = $condb->prepare("INSERT INTO tbl_customers (cus_id_card, name, email, cus_phone) VALUES ( :cus_id_card, :name, :email, :cus_phone)");
                // bindparam
                $stmtInsertCustomer->bindparam(':cus_id_card', $cus_id_card, PDO::PARAM_STR);
                $stmtInsertCustomer->bindparam(':name', $name, PDO::PARAM_STR);
                $stmtInsertCustomer->bindparam(':email', $email, PDO::PARAM_STR);
                $stmtInsertCustomer->bindparam(':cus_phone', $cus_phone, PDO::PARAM_STR);
                $result = $stmtInsertCustomer->execute();

                $condb = null; //colse connect db

                if ($result) {
                    echo    '<script>
                                        setTimeout(function() {
                                        swal({
                                            title: "เพิ่มข้อมูลสำเร็จ",
                                            type: "success"
                                        }, function() {
                                            window.location = "customers.php"; //หน้าที่ต้องการให้กระโดดไป
                                        });
                                        }, 1000);
                                    </script>';
                }
            } //else rowCount check บัตรประชาชน ไม่ซ้ำ
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