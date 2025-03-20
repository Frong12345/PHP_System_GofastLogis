<?php 

//trigger exception in a "try" block
try {
    
    $stmtDelPrd = $condb->prepare('DELETE FROM tbl_product WHERE product_id = :product_id');
    $stmtDelPrd->bindParam(':product_id', $_POST['product_id'] , PDO::PARAM_INT);
    $stmtDelPrd->execute();
    
    $condb = null; //close connect db
    //echo 'จำนวน row ที่ลบได้ ' .$stmtDelPrd->rowCount();
    if($stmtDelPrd->rowCount() == 1){

        //delete image file
        unlink('../assetsBackend/product_img/'.$_POST['product_image']);

        echo '<script>
             setTimeout(function() {
              swal({
                  title: "ลบข้อมูลสำเร็จ",
                  type: "success"
              }, function() {
                  window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
    exit;
    } 
    
    } //try
    //catch exception
    catch(Exception $e) {
        //echo 'Message: ' .$e->getMessage();
        echo '<script>
             setTimeout(function() {
              swal({
                  title: "เกิดข้อผิดพลาด",
                  type: "error"
              }, function() {
                  window.location = "type.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
      } //catch


?>