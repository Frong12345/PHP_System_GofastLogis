<?php
//คิวรี่ข้อมูลหมวดหมู่สินค้า
// $queryType = $condb->prepare("SELECT * FROM tbl_type");
// $queryType->execute();
// $rsType = $queryType->fetchAll();
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1> ฟอร์มเพิ่มข้อมูลผลิตภัณฑ์ </h1>
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
              <form action="" method="post" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group col">

                    <div class="form-group row">
                      <label class="col-sm-2">ชื่อผลิดภัณฑ์</label>
                      <div class="col-sm-10">
                        <input type="text" name="service_names" class="form-control" required placeholder="ชื่อผลิดภัณฑ์">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2">คำชี้ชวน</label>
                      <div class="col-sm-10">
                        <textarea name="service_caption" ></textarea>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2">รายละเอียดสินค้า</label>
                      <div class="col-sm-10">
                        <textarea name="service_details" id="summernote"></textarea>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2">ภาพสินค้า</label>
                      <div class="col-sm-4">
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="service_img" class="custom-file-input" required id="exampleInputFile" accept="image/*">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2"></label>
                      <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary" name="action" value="add"> เพิ่มข้อมูล </button>
                        <a href="product.php" class="btn btn-danger" name="action" value="delete"> ยกเลิก </a>
                      </div>
                    </div>

                  </div> <!-- /.card-body -->

              </form>
              <?php
              // echo '<pre>';
              // print_r($_POST);
              // echo '<hr>';
              // print_r($_FILES);
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

if (isset($_POST['service_names']) && isset($_POST['service_caption']) && isset($_POST['action']) && $_POST['action'] == 'add') {
  //echo 'ถูกเงื่อนไข ส่งข้อมูลมาได้';

  //trigger exception in a "try" block
  try {



    //ประกาศตัวแปรรับค่าจากฟอร์ม
    $service_names = $_POST['service_names'];
    $service_caption = $_POST['service_caption'];
    $service_details = $_POST['service_details'];


    //สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ใหม่
    $date1 = date("Ymd_His");
    //สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
    $numrand = (mt_rand());
    $service_img = (isset($_POST['service_img']) ? $_POST['service_img'] : '');
    $upload = $_FILES['service_img']['name'];

    //มีการอัพโหลดไฟล์
    if ($upload != '') {
      //ตัดขื่อเอาเฉพาะนามสกุล
      $typefile = strrchr($_FILES['service_img']['name'], ".");

      //สร้างเงื่อนไขตรวจสอบนามสกุลของไฟล์ที่อัพโหลดเข้ามา
      if ($typefile == '.jpg' || $typefile  == '.jpeg' || $typefile  == '.png') {

        //โฟลเดอร์ที่เก็บไฟล์
        $path = "../assetsBackend/product_img/";
        //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
        $newname = $numrand . $date1 . $typefile;
        $path_copy = $path . $newname;
        //คัดลอกไฟล์ไปยังโฟลเดอร์
        move_uploaded_file($_FILES['service_img']['tmp_name'], $path_copy);


        //sql insert
        $stmtInsertProduct = $condb->prepare("INSERT INTO tbl_service 
                    (
                      service_names,
                      service_details,
                      service_caption,
                      service_img
                    )
                    VALUES 
                    (
                      :service_names,
                      :service_details,
                      :service_caption,
                      '$newname'
                    )
                    ");

        //bindParam
        $stmtInsertProduct->bindParam(':service_names', $service_names, PDO::PARAM_STR);
        $stmtInsertProduct->bindParam(':service_details', $service_details, PDO::PARAM_STR);
        $stmtInsertProduct->bindParam(':service_caption', $service_caption, PDO::PARAM_STR);
        $result = $stmtInsertProduct->execute();
        $condb = null; //close connect db

        //เงื่อนไขตรวจสอบการเพิ่มข้อมูล
        if ($result) {
          echo '<script>
                            setTimeout(function() {
                              swal({
                                  title: "เพิ่มข้อมูลสำเร็จ",
                                  type: "success"
                              }, function() {
                                  window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
                              });
                            }, 1000);
                        </script>';
        } //if

      } else { //ถ้าไฟล์ที่อัพโหลดไม่ตรงตามที่กำหนด
        echo '<script>
                                setTimeout(function() {
                                  swal({
                                      title: "คุณอัพโหลดไฟล์ไม่ถูกต้อง",
                                      type: "error"
                                  }, function() {
                                      window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
                                  });
                                }, 1000);
                            </script>';
      } //else ของเช็คนามสกุลไฟล์

    } // if($upload !='') {
  } //try
  //catch exception
  catch (Exception $e) {
    // echo 'Message: ' .$e->getMessage();
    // exit;
    echo '<script>
                     setTimeout(function() {
                      swal({
                          title: "เกิดข้อผิดพลาด",
                          type: "error"
                      }, function() {
                          window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
                      });
                    }, 1000);
                </script>';
  } //catch
} //isset
?>