<?php 
  include 'header.php';
  include 'navbar.php';
  include 'sidebar_menu.php';

  $act = (isset($_GET['act']) ? $_GET['act'] : '');

  //สร้างเงื่อนไขในการเรียกใช้ไฟล์
  if($act == 'add'){
      include 'product_form_add.php';
  }else{
      include 'product_list.php';
  }


  //สร้างเงื่อนไขลบข้อมูล
  if(isset($_POST['product_id']) && isset($_POST['product_image']) && isset($_POST['action']) && $_POST['action'] == 'delete'){
    include 'product_delete.php';
  }
  include 'footer.php';
?>





  