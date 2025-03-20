<?php

if (isset($_GET['id']) && $_GET['act'] == 'delete') {
    // echo '<pre>';
    // print_r($_GET);
    // exit;

    //trigger exception in a "try" block
    try {

        $admin_id = $_GET['id'];
        // echo $admin_id;
        // exit;
        $stmtDelAdmin = $condb->prepare('DELETE FROM tbl_admin WHERE admin_id = :admin_id');
        $stmtDelAdmin->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $stmtDelAdmin->execute();

        $condb = null; //close connect db
        // echo 'จำนวน row ที่ลบได้ ' .$stmtDelAdmin->rowCount();
        if ($stmtDelAdmin->rowCount() == 1) {
            echo '<script>
         setTimeout(function() {
          swal({
              title: "ลบข้อมูลสำเร็จ",
              type: "success"
          }, function() {
              window.location = "admin.php"; //หน้าที่ต้องการให้กระโดดไป
          });
        }, 1000);
    </script>';
            // exit;
        }
    } //try
    //catch exception
    catch (Exception $e) {
        //echo 'Message: ' .$e->getMessage();
        echo '<script>
         setTimeout(function() {
          swal({
              title: "เกิดข้อผิดพลาด",
              type: "error"
          }, function() {
              window.location = "admin.php"; //หน้าที่ต้องการให้กระโดดไป
          });
        }, 1000);
    </script>';
    } //catch
} //isset
