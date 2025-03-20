<?php 
//คิวรี่ข้อมูลหมวดหมู่สินค้า
$queryType = $condb->prepare("SELECT * FROM tbl_type");
$queryType->execute();
$rsType = $queryType->fetchAll();
?>
  
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> ฟอร์มเพิ่มข้อมูลสินค้า  </h1>
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

                  <div class="form-group row">
                      <label class="col-sm-2">หมวดหมู่สินค้า</label>
                      <div class="col-sm-2">
                        <select name="ref_type_id" class="form-control" required>
                           <option value="">-- เลือกข้อมูล --</option>

                           <?php foreach($rsType as $row){ ?>

                            <option value="<?php echo $row['type_id'];?>">-- <?php echo $row['type_name'];?> --</option>
                           
                            <?php } ?>

                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                            <label class="col-sm-2">ชื่อสินค้า</label>
                            <div class="col-sm-10">
                              <input type="text" name="product_name" class="form-control" required placeholder="ชื่อสินค้า">
                            </div>
                    </div>

                   
                    <div class="form-group row">
                      <label class="col-sm-2">รายละเอียดสินค้า</label>
                      <div class="col-sm-10">
                      <textarea name="product_detail" id="summernote"></textarea>
                      </div>
                    </div>


                    <div class="form-group row">
                            <label class="col-sm-2">ราคาสินค้า</label>
                            <div class="col-sm-2">
                              <input type="number" name="product_price" class="form-control" required min=0>
                            </div>
                    </div>
 

                    <div class="form-group row">
                      <label class="col-sm-2">ภาพสินค้า</label>
                      <div class="col-sm-4">
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file"  name="product_image" class="custom-file-input" required id="exampleInputFile" accept="image/*">
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

    if(isset($_POST['product_name']) && isset($_POST['ref_type_id']) && isset($_POST['product_price']) && isset($_POST['action']) && $_POST['action'] == 'add'){
                    //echo 'ถูกเงื่อนไข ส่งข้อมูลมาได้';

      //trigger exception in a "try" block
    try {


                    
                    //ประกาศตัวแปรรับค่าจากฟอร์ม
                    $ref_type_id = $_POST['ref_type_id'];
                    $product_name = $_POST['product_name'];
                    $product_detail = $_POST['product_detail'];
                    $product_price = $_POST['product_price'];
                    

                     //สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ใหม่
                    $date1 = date("Ymd_His");
                    //สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
                    $numrand = (mt_rand());
                    $product_image = (isset($_POST['product_image']) ? $_POST['product_image'] : '');
                    $upload=$_FILES['product_image']['name'];
                
                    //มีการอัพโหลดไฟล์
                    if($upload !='') {
                    //ตัดขื่อเอาเฉพาะนามสกุล
                    $typefile = strrchr($_FILES['product_image']['name'],".");
                
                    //สร้างเงื่อนไขตรวจสอบนามสกุลของไฟล์ที่อัพโหลดเข้ามา
                    if($typefile =='.jpg' || $typefile  =='.jpeg' || $typefile  =='.png'){
                
                    //โฟลเดอร์ที่เก็บไฟล์
                    $path="../assetsBackend/product_img/";
                    //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
                    $newname = $numrand.$date1.$typefile;
                    $path_copy=$path.$newname;
                    //คัดลอกไฟล์ไปยังโฟลเดอร์
                    move_uploaded_file($_FILES['product_image']['tmp_name'],$path_copy); 


                    //sql insert
                    $stmtInsertProduct = $condb->prepare("INSERT INTO tbl_product 
                    (
                      ref_type_id,
                      product_name,
                      product_detail,
                      product_price,
                      product_image
                    )
                    VALUES 
                    (
                      :ref_type_id,
                      :product_name,
                      :product_detail,
                      :product_price,
                      '$newname'
                    )
                    ");

                    //bindParam
                    $stmtInsertProduct->bindParam(':ref_type_id', $ref_type_id, PDO::PARAM_INT);
                    $stmtInsertProduct->bindParam(':product_name', $product_name, PDO::PARAM_STR);
                    $stmtInsertProduct->bindParam(':product_detail', $product_detail, PDO::PARAM_STR);
                    $stmtInsertProduct->bindParam(':product_price', $product_price , PDO::PARAM_STR);
                    $result = $stmtInsertProduct->execute();
                    $condb = null; //close connect db

                    //เงื่อนไขตรวจสอบการเพิ่มข้อมูล
                      if($result){
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
                
                }else{ //ถ้าไฟล์ที่อัพโหลดไม่ตรงตามที่กำหนด
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
            catch(Exception $e) {
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



