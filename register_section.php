<!-- login Section -->
<section id="get-a-quote" class="get-a-quote section">

    <div class="container">

        <div class="row g-0" data-aos="fade-up" data-aos-delay="100">

            <div class="col-lg-5 quote-bg" style="background-image: url(assetsFront/img/quote-bg.jpg);"></div>

            <!-- Start Form login -->
            <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">
                <form action="" method="post" class="php-email-form">
                    <div class="row gy-4">

                        <div class="col-lg-12">
                            <h2>ลงทะเบียนเพื่อใช้งาน</h2>
                        </div>

                        <div class="col-12">
                            <h4>ชื่อ</h4>
                            <input type="text" name="name" class="form-control" placeholder="กรุณากรอกชื่อ" required>
                        </div>

                        <div class="col-12">
                            <h4>เบอร์โทร</h4>
                            <input type="text" name="cus_phone" class="form-control" placeholder="กรุณากรอกเบอร์โทร" required>
                        </div>

                        <div class="col-12">
                            <h4>อีเมล</h4>
                            <input type="email" name="email" class="form-control" placeholder="กรุณากรอกอีเมล" required>
                        </div>

                        <div class="col-12">
                            <h4>รหัสผ่าน</h4>
                            <input type="password" name="new_password" class="form-control" placeholder="กรุณากรอกรหัสผ่าน" required>
                        </div>

                        <div class="col-12">
                            <h4>ยืนยันรหัสผ่าน</h4>
                            <input type="password" name="confirm_password" class="form-control" placeholder="กรุณายืนยันรหัสผ่าน" required>
                        </div>

                        <div class="d-flex justify-content-between mt-2">
                            <div></div>
                            <a href="login.php?act=เข้าสู่ระบบ" style="text-decoration: none;">เข้าสู่ระบบ</a>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" name="act" value="register">ลงทะเบียน</button>
                        </div>

                    </div>

                    <?php
                    // echo '<pre>';
                    // print_r($_POST);
                    ?>

                </form>
            </div><!-- End Form login -->
        </div>
    </div> <!-- container Section -->
</section><!-- login Section -->

</main>

<?php
if (isset($_POST['name']) && isset($_POST['cus_phone']) && isset($_POST['email']) && isset($_POST['new_password']) && isset($_POST['confirm_password']) && $_POST['act'] == 'register') {
    // echo 'ถูกเงื่อไข ส่งข้อมูลมาได้';
    // echo '<pre>';
    // print_r($_POST);
    // exit;

    //trigger exception in a "try" block
    try {
        // ประกาศตัวแปรรับค่าจากฟอร์ม
        $name = $_POST['name'];
        $cus_phone = $_POST['cus_phone'];
        $email = $_POST['email'];
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
                                  window.location = "login.php?act=ลงทะเบียน";
                              });
                            }, 1000);
                        </script>';
        } else {
            // echo 'รหัสผ่านตรงกัน';


            //check Username ซ้ำ
            //Single row query แสดงแค่ 1 รายการ
            $stmtCostomerDetail = $condb->prepare('SELECT email FROM tbl_customers WHERE email = :email');
            //bindParam
            $stmtCostomerDetail->bindParam(':email', $email, PDO::PARAM_STR);
            $stmtCostomerDetail->execute();
            $row = $stmtCostomerDetail->fetch(PDO::FETCH_ASSOC);

            //ถ้า query ได้ 1 คือ username ซ้ำ ให้หยุดการทำงาน
            if ($stmtCostomerDetail->rowCount() != 0) {
                // echo 'ซ้ำ';
                echo '<script>
                 setTimeout(function() {
                 swal({
                     title: "อีเมล ซ้ำ !!",
                     text: "กรุณาเพิ่มข้อมูลใหม่อีกครั้ง",
                     type: "error"
                 }, function() {
                     window.location = "login.php?act=ลงทะเบียน"; //หน้าที่ต้องการให้กระโดดไป
                 });
                 }, 1000);
             </script>';
            } else {
                // echo 'ไม่ซ้ำ';

                $password = hash('sha512', $_POST['new_password']); //sha512 128 str)

                //sql insert
                $stmtInsertCustomer = $condb->prepare("INSERT INTO tbl_customers
               (name, email, cus_password, cus_phone)
               VALUES 
               (:name, :email, '$password', :cus_phone)
               ");

                //bindParam
                $stmtInsertCustomer->bindParam(':name', $name, PDO::PARAM_STR);
                $stmtInsertCustomer->bindParam(':email', $email, PDO::PARAM_STR);
                $stmtInsertCustomer->bindParam(':cus_phone', $cus_phone, PDO::PARAM_STR);
                $result = $stmtInsertCustomer->execute();

                $condb = null; //close connect db
                if ($result) {
                    echo '<script>
                                setTimeout(function() {
                                swal({
                                    title: "เพิ่มข้อมูลสำเร็จ",
                                    type: "success"
                                }, function() {
                                    window.location = "login.php?act=เข้าสู่ระบบ"; //หน้าที่ต้องการให้กระโดดไป
                                });
                                }, 1000);
                            </script>';
                }
            }
        }
    } // end try
    catch (Exception $e) {
        // echo 'Message: ' . $e->getMessage();
        // exit;
        echo '<script>
                    setTimeout(function() {
                    swal({
                        title: "เกิดข้อผิดพลาด",
                        type: "error"
                    }, function() {
                        window.location = "login.php?act=ลงทะเบียน"; //หน้าที่ต้องการให้กระโดดไป
                    });
                    }, 1000);
                </script>';
    } //end catch
}
?>