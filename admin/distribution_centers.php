<?php 
  include 'header.php';
  include 'navbar.php';
  include 'sidebar_menu.php';

  $act = (isset($_GET['act']) ? $_GET['act'] : '');

  //สร้างเงื่อนไขในการเรียกใช้ไฟล์
  if($act == 'add'){
      include 'distribution_centers_form_add.php';
  }else if($act == 'delete'){
      include 'distribution_centers_delete.php';
  }else if($act == 'edit'){
        include 'distribution_centers_form_edit.php';
  }else{
      include 'distribution_centers_list.php';
  }

  include 'footer.php';
?>





  