 <!-- js check file type -->
 <script type="text/javascript">
  var _validFileExtensions = [".jpg",".JPG", ".jpeg", ".png", ".PNG"];     //กำหนดนามสกุลไฟล์ที่สามรถอัพโหลดได้
  function ValidateTypeFile(oForm) {
    var arrInputs = oForm.getElementsByTagName("input");
    for (var i = 0; i < arrInputs.length; i++) {
        var oInput = arrInputs[i];
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    } // if (sFileName.substr(sFileName.length....
                } // for (var j = 0; j < _validFileExtensions.length; j++) {
 
                //ถ้าเลือกไฟล์ไม่ถุูกต้องจะมี Alert แจ้งเตือน   
                if (!blnValid) {
                    // alert("คำเตือน , " + sFileName + "\n ระบบรองรับเฉพาะไฟล์นามสกุล   : " + _validFileExtensions.join(", "));
                    setTimeout(function() {
                        swal({
                            title: "อัพโหลดไฟล์ไม่ถูกต้อง ",  
                            text: "รองรับ .jpg, .jpeg, .png เท่านั้น !!",
                            type: "error"
                        }, function() {
                            //window.location.reload();
                            //window.location = "product.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                            });
                        }, 1000);
                        return false;
                    } //if (!blnValid) {
                } //if (sFileName.length > 0) {
            } // if (oInput.type == "file") {
        } //for
  
        return true;
    } //function ValidateTypeFile(oForm) {
 </script>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> ฟอร์มเพิ่มข้อมูลสมาชิก </h1>
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
                                        <label class="col-sm-2 col-form-label">รหัสนักศึกษา</label>
                                        <div class="col-sm-2">
                                            <input type="text" name="stu_id" class="form-control" required placeholder="รหัสนักศึกษา">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">คำนำหน้า</label>
                                        <div class="col-sm-3">
                                            <select name="stu_prefix" class="form-control" required>
                                                <option value="">-- กรุณาเลือก --</option>
                                                <option value="นาย">นาย</option>
                                                <option value="นางสาว">นางสาว</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ชื่อจริง</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="stu_fname" class="form-control" required placeholder="ชื่อจริง">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">นามสกุล</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="stu_lname" class="form-control" required placeholder="นามสกุล">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">อีเมล</label>
                                        <div class="col-sm-4">
                                            <input type="email" name="stu_email" class="form-control" required placeholder="อีเมล">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">เบอร์โทร</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="stu_phone" class="form-control" required placeholder="เบอร์โทร">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">สาขา</label>
                                        <div class="col-sm-3">
                                            <select name="stu_major" class="form-control" required>
                                                <option value="">-กรุณาเลือก-</option>
                                                <option value="IT">IT</option>
                                                <option value="BI">BI</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">สถานะ</label>
                                        <div class="col-sm-3">
                                            <select name="stu_status" class="form-control" required>
                                                <option value="Active">Active</option>
                                                <option value="Graduated">Graduated</option>
                                                <option value="Drop">Drop</option>
                                                <option value="ETC.">ETC.</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ภาษาโปรแกรมที่ชอบ</label>
                                        <div class="col-sm-3">
                                            <select name="stu_favpro" class="form-control" required>
                                                <option value="">-กรุณาเลือก-</option>
                                                <option value="SQL">SQL</option>
                                                <option value="PHP">PHP</option>
                                                <option value="JAVA">JAVA</option>
                                                <option value="PYTHON">PYTHON</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ภาพโปรไฟล์</label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="student_image" class="custom-file-input" required id="exampleInputFile" accept="image/*">
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

                                            <a href="member.php" class="btn btn-danger" name="action" value="delete"> ยกเลิก </a>
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

if (isset($_POST['stu_id']) && isset($_POST['stu_prefix']) && isset($_POST['stu_fname']) && isset($_POST['stu_lname']) && isset($_POST['stu_email']) && isset($_POST['stu_phone']) && isset($_POST['stu_major']) && isset($_POST['stu_status']) && isset($_POST['stu_favpro']) &&  isset($_POST['action']) && $_POST['action'] == 'add') {
    // echo 'ถูกเงื่อนไข ส่งข้อมูลมาได้';
    // exit;

    //trigger exception in a "try" block
    try {



        //ประกาศตัวแปรรับค่าจากฟอร์ม
        $stu_id = $_POST['stu_id'];
        $stu_prefix = $_POST['stu_prefix'];
        $stu_fname = $_POST['stu_fname'];
        $stu_lname = $_POST['stu_lname'];
        $stu_email = $_POST['stu_email'];
        $stu_phone = $_POST['stu_phone'];
        $stu_major = $_POST['stu_major'];
        $stu_status = $_POST['stu_status'];
        $stu_favpro = $_POST['stu_favpro'];

        //สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ใหม่
        $date1 = date("Ymd_His");
        //สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
        $numrand = (mt_rand());
        $student_image = (isset($_POST['student_image']) ? $_POST['student_image'] : '');
        $upload = $_FILES['student_image']['name'];

        //มีการอัพโหลดไฟล์
        if ($upload != '') {
            //ตัดขื่อเอาเฉพาะนามสกุล
            $typefile = strrchr($_FILES['student_image']['name'], ".");

                //โฟลเดอร์ที่เก็บไฟล์
                $path = "../assetsBackend/product_img/";
                //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
                $newname = $numrand . $date1 . $typefile;
                $path_copy = $path . $newname;
                //คัดลอกไฟล์ไปยังโฟลเดอร์
                move_uploaded_file($_FILES['student_image']['tmp_name'], $path_copy);


                //sql insert
                $stmtInsertStudent = $condb->prepare("INSERT INTO tbl_studeninfo 
                    (
                        student_image,
                        student_id, 
                        prefix, 
                        first_name, 
                        last_name, 
                        email, 
                        phone, 
                        major, 
                        status, 
                        favorite_prog
                    )
                    VALUES 
                    (
                        '$newname',
                        :stu_id, 
                        :stu_prefix, 
                        :stu_fname, 
                        :stu_lname, 
                        :stu_email, 
                        :stu_phone, 
                        :stu_major, 
                        :stu_status, 
                        :stu_favpro
                        
                    )
                    ");

                //bindParam
                $stmtInsertStudent->bindParam(':stu_prefix', $stu_prefix, PDO::PARAM_STR);
                $stmtInsertStudent->bindParam(':stu_id', $stu_id, PDO::PARAM_STR);
                $stmtInsertStudent->bindParam(':stu_fname', $stu_fname, PDO::PARAM_STR);
                $stmtInsertStudent->bindParam(':stu_lname', $stu_lname, PDO::PARAM_STR);
                $stmtInsertStudent->bindParam(':stu_email', $stu_email, PDO::PARAM_STR);
                $stmtInsertStudent->bindParam(':stu_phone', $stu_phone, PDO::PARAM_STR);
                $stmtInsertStudent->bindParam(':stu_major', $stu_major, PDO::PARAM_STR);
                $stmtInsertStudent->bindParam(':stu_status', $stu_status, PDO::PARAM_STR);
                $stmtInsertStudent->bindParam(':stu_favpro', $stu_favpro, PDO::PARAM_STR);
                $result = $stmtInsertStudent->execute();
                $condb = null; //close connect db

                //เงื่อนไขตรวจสอบการเพิ่มข้อมูล
                if ($result) {
                    echo '<script>
                            setTimeout(function() {
                              swal({
                                  title: "เพิ่มข้อมูลสำเร็จ",
                                  type: "success"
                              }, function() {
                                  window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
                              });
                            }, 1000);
                        </script>';
                } //if

        } // if
    } //try
    //catch exception
    catch (Exception $e) {
        echo 'Message: ' . $e->getMessage();
        // exit;
        echo '<script>
                     setTimeout(function() {
                      swal({
                          title: "เกิดข้อผิดพลาด",
                          type: "error"
                      }, function() {
                          window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
                      });
                    }, 1000);
                </script>';
    } //catch
} //isset
?>