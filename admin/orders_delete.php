<?php

if (isset($_GET['id']) && $_GET['act'] == 'delete') {
    // echo '<pre>';
    // print_r($_GET);
    // exit;

    //trigger exception in a "try" block
    try {

        // ประกาศตัวแปรรับค่า
        $order_id = $_GET['id'];
        

        $stmtDelOrders = $condb->prepare('DELETE FROM orders WHERE order_id = :order_id');
        $stmtDelOrders->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmtDelOrders->execute();

        $condb = null; //close connect db
        // echo 'จำนวน row ที่ลบได้ ' .$stmtDelAdmin->rowCount();
        if ($stmtDelOrders->rowCount() == 1) {
            echo '<script>
                        setTimeout(function() {
                        swal({
                            title: "ลบข้อมูลสำเร็จ",
                            type: "success"
                        }, function() {
                            window.location = "orders.php?act=orders_list"; //หน้าที่ต้องการให้กระโดดไป
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
              window.location = "orders.php?act=orders_list"; //หน้าที่ต้องการให้กระโดดไป
          });
        }, 1000);
    </script>';
    } //catch
} //isset
