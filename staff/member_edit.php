<?php
    if (isset($_GET['id']) && isset($_GET['act']) && $_GET['act'] == 'edit') {

        //single row query แสดงแค่ 1 รายการ   
        $stmtstuDetail = $condb->prepare("SELECT * FROM tbl_studeninfo WHERE id=:id");
        $stmtstuDetail->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmtstuDetail->execute();
        $row = $stmtstuDetail->fetch(PDO::FETCH_ASSOC);

        //    echo '<pre>';
        //    print_r($row);    
        //    exit;
        //    echo $stmtstuDetail->rowCount();
        //    exit;

        //ถ้าคิวรี่ผิดพลาดให้หยุดการทำงาน
        if ($stmtstuDetail->rowCount() == 0) {
            echo    '<script>
                    setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                            type: "error"
                        }, function() {
                            window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
                            });
                    }, 1000);
                </script>';
        }
    }
?>

 <!-- js check file type -->
 <script type="text/javascript">
  var _validFileExtensions = [".jpg", ".JPG", ".jpeg", ".JPEG", ".png", ".PNG"];     //กำหนดนามสกุลไฟล์ที่สามรถอัพโหลดได้
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
                    <h1> ฟอร์มแก้ไขข้อมูลสมาชิก </h1>
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
                                            <input type="text" name="stu_id" class="form-control" required placeholder="รหัสนักศึกษา" value="<?= $row['student_id'] ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">คำนำหน้า</label>
                                        <div class="col-sm-3">
                                            <select name="stu_prefix" class="form-control" required>
                                                <option disabled value="">-- กรุณาเลือก --</option>
                                                <option <?= ($row['prefix'] == "นาย") ? "selected" : ""; ?> value="นาย">นาย</option>
                                                <option <?= ($row['prefix'] == "นางสาว") ? "selected" : ""; ?> value="นางสาว">นางสาว</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ชื่อจริง</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="stu_fname" class="form-control" required placeholder="ชื่อจริง" value="<?= $row['first_name'] ?>">
                                            <?php 
                                            echo $row['first_name'];
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">นามสกุล</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="stu_lname" class="form-control" required placeholder="นามสกุล" value="<?= $row['last_name'] ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">อีเมล</label>
                                        <div class="col-sm-4">
                                            <input type="email" name="stu_email" class="form-control" required placeholder="อีเมล" value="<?= $row['email'] ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">เบอร์โทร</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="stu_phone" class="form-control" required placeholder="เบอร์โทร" value="<?= $row['phone'] ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">สาขา</label>
                                        <div class="col-sm-3">
                                            <select name="stu_major" class="form-control" required>
                                                <option disabled value="">-กรุณาเลือก-</option>
                                                <option <?= ($row['major'] == "IT") ? "selected" : ""; ?> value="IT">IT</option>
                                                <option <?= ($row['major'] == "BI") ? "selected" : ""; ?> value="BI">BI</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">สถานะ</label>
                                        <div class="col-sm-3">
                                            <select name="stu_status" class="form-control" required>
                                                <option <?= ($row['status'] == "Active") ? "selected" : ""; ?> value="Active">Active</option>
                                                <option <?= ($row['status'] == "Graduated") ? "selected" : ""; ?> value="Graduated">Graduated</option>
                                                <option <?= ($row['status'] == "Drop") ? "selected" : ""; ?> value="Drop">Drop</option>
                                                <option <?= ($row['status'] == "ETC.") ? "selected" : ""; ?> value="ETC.">ETC.</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ภาษาโปรแกรมที่ชอบ</label>
                                        <div class="col-sm-3">
                                            <select name="stu_favpro" class="form-control" required>
                                                <option disabled value="">-กรุณาเลือก-</option>
                                                <option <?= ($row['favorite_prog'] == "SQL") ? "selected" : ""; ?> value="SQL">SQL</option>
                                                <option <?= ($row['favorite_prog'] == "PHP") ? "selected" : ""; ?> value="PHP">PHP</option>
                                                <option <?= ($row['favorite_prog'] == "JAVA") ? "selected" : ""; ?> value="JAVA">JAVA</option>
                                                <option <?= ($row['favorite_prog'] == "PYTHON") ? "selected" : ""; ?> value="PYTHON">PYTHON</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ภาพโปรไฟล์</label>
                                        <div class="col-sm-4">
                                            ภาพเก่า <?= $row['student_image'] ?> <br>
                                            <img src="../assetsBackendBackend/product_img/<?= $row['student_image'] ?>" width="150px">
                                            <br> <br>
                                            เลือกภาพใหม่
                                            <br>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="student_image" class="custom-file-input" id="exampleInputFile" accept="image/*">
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
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <input type="hidden" name="Old_image" value="<?= $row['student_image']; ?>">
                                            <button type="submit" class="btn btn-primary" name="action" value="edit"> ปรับปรุงข้อมูล </button>
                                            <a href="member.php" class="btn btn-danger"> ยกเลิก </a>
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

if (isset($_POST['id']) && isset($_POST['stu_id']) && isset($_POST['stu_prefix']) && isset($_POST['stu_fname']) && isset($_POST['stu_lname']) && isset($_POST['stu_email']) && isset($_POST['stu_phone']) && isset($_POST['stu_major']) && isset($_POST['stu_status']) && isset($_POST['stu_favpro']) &&  isset($_POST['action']) && $_POST['action'] == 'edit') {
    // echo 'ถูกเงื่อนไข ส่งข้อมูลมาได้';
    // exit;

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
    $id = $_POST['id'];

    $upload = $_FILES['student_image']['name'];
    //สร้างเงื่อนไขตรวจสอบการอัพโหลดไฟล์
    if ($upload == '') {
        // echo 'ไม่มีการอัพโหลดไฟล์';
        //sql update without upload file
        $stmtUpdateStudent = $condb->prepare("UPDATE tbl_studeninfo SET
                student_id=:stu_id,
                prefix=:stu_prefix,
                first_name=:stu_fname,
                last_name=:stu_lname,
                email=:stu_email,
                phone=:stu_phone,
                major=:stu_major,
                status=:stu_status,
                favorite_prog=:stu_favpro
                WHERE id=:id 
                ");

        //bindparam STR // INT
        $stmtUpdateStudent->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtUpdateStudent->bindParam(':stu_id', $stu_id, PDO::PARAM_STR);
        $stmtUpdateStudent->bindParam(':stu_prefix', $stu_prefix, PDO::PARAM_STR);
        $stmtUpdateStudent->bindParam(':stu_fname', $stu_fname, PDO::PARAM_STR);
        $stmtUpdateStudent->bindParam(':stu_lname', $stu_lname, PDO::PARAM_STR);
        $stmtUpdateStudent->bindParam(':stu_email', $stu_email, PDO::PARAM_STR);
        $stmtUpdateStudent->bindParam(':stu_phone', $stu_phone, PDO::PARAM_STR);
        $stmtUpdateStudent->bindParam(':stu_major', $stu_major, PDO::PARAM_STR);
        $stmtUpdateStudent->bindParam(':stu_status', $stu_status, PDO::PARAM_STR);
        $stmtUpdateStudent->bindParam(':stu_favpro', $stu_favpro, PDO::PARAM_STR);
        $result = $stmtUpdateStudent->execute();

        if ($result) {
            echo '<script>
                        setTimeout(function() {
                        swal({
                            title: "ปรับปรุงข้อมูลสำเร็จ",
                            type: "success"
                        }, function() {
                            window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
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
                            window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                        }, 1000);
                    </script>';
        }
    } else {
            // echo 'มีการอัพโหลดไฟล์ใหม่';
            //สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ใหม่
            $date1 = date("Ymd_His");
            //สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
            $numrand = (mt_rand());
            $student_image = (isset($_POST['student_image']) ? $_POST['student_image'] : '');

            //ตัดขื่อเอาเฉพาะนามสกุล
            $typefile = strrchr($_FILES['student_image']['name'], ".");

            // echo $typefile;
            // exit;

           
                
            //ลบภาพเก่า
            unlink('../assetsBackendBackend/product_img/'.$_POST['Old_image']);

            //โฟลเดอร์ที่เก็บไฟล์
            $path = "../assetsBackendBackend/product_img/";
            //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
            $newname = $numrand . $date1 . $typefile;
            $path_copy = $path . $newname;
            //คัดลอกไฟล์ไปยังโฟลเดอร์
            move_uploaded_file($_FILES['student_image']['tmp_name'], $path_copy);

            //sql update with upload file
            $stmtUpdateStudent = $condb->prepare("UPDATE tbl_studeninfo SET
                student_id=:stu_id,
                prefix=:stu_prefix,
                first_name=:stu_fname,
                last_name=:stu_lname,
                email=:stu_email,
                phone=:stu_phone,
                major=:stu_major,
                status=:stu_status,
                favorite_prog=:stu_favpro,
                student_image='$newname'
                WHERE id=:id 
                ");

            //bindparam STR // INT
            $stmtUpdateStudent->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtUpdateStudent->bindParam(':stu_id', $stu_id, PDO::PARAM_STR);
            $stmtUpdateStudent->bindParam(':stu_prefix', $stu_prefix, PDO::PARAM_STR);
            $stmtUpdateStudent->bindParam(':stu_fname', $stu_fname, PDO::PARAM_STR);
            $stmtUpdateStudent->bindParam(':stu_lname', $stu_lname, PDO::PARAM_STR);
            $stmtUpdateStudent->bindParam(':stu_email', $stu_email, PDO::PARAM_STR);
            $stmtUpdateStudent->bindParam(':stu_phone', $stu_phone, PDO::PARAM_STR);
            $stmtUpdateStudent->bindParam(':stu_major', $stu_major, PDO::PARAM_STR);
            $stmtUpdateStudent->bindParam(':stu_status', $stu_status, PDO::PARAM_STR);
            $stmtUpdateStudent->bindParam(':stu_favpro', $stu_favpro, PDO::PARAM_STR);
            $result = $stmtUpdateStudent->execute();

            if ($result) {
                echo '<script>
                            setTimeout(function() {
                            swal({
                                title: "ปรับปรุงข้อมูลสำเร็จ",
                                type: "success"
                            }, function() {
                                window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
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
                                window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
                            });
                            }, 1000);
                        </script>';
            } //else ของ if result

            
            

        } //else not upload file

    // exit;
} //isset
?>