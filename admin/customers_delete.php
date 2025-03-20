<?php

if (isset($_GET['id']) && $_GET['act'] == 'delete') {
    // echo '<pre>';
    // print_r($_GET);
    // exit;

    //trigger exception in a "try" block
    try {

        $customer_id = $_GET['id'];
        // echo $admin_id;
        // exit;
        $stmtDelCustomer = $condb->prepare('DELETE FROM tbl_customers WHERE customer_id = :customer_id');
        $stmtDelCustomer->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmtDelCustomer->execute();

        $condb = null; //close connect db
        // echo 'จำนวน row ที่ลบได้ ' .$stmtDelAdmin->rowCount();
        if ($stmtDelCustomer->rowCount() == 1) {
            echo '<script>
         setTimeout(function() {
          swal({
              title: "ลบข้อมูลสำเร็จ",
              type: "success"
          }, function() {
              window.location = "customers.php"; //หน้าที่ต้องการให้กระโดดไป
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
              window.location = "customers.php"; //หน้าที่ต้องการให้กระโดดไป
          });
        }, 1000);
    </script>';
    } //catch
} //isset
?>