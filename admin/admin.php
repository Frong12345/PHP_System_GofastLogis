<?php 
  include 'header.php';
  include 'navbar.php';
  include 'sidebar_menu.php';

  $act = (isset($_GET['act']) ? $_GET['act'] : '');

  //สร้างเงื่อนไขในการเรียกใช้ไฟล์
  if($act == 'add'){
      include 'admin_form_add.php';
  }else if($act == 'delete'){
      include 'admin_delete.php';
  }else if($act == 'edit'){
        include 'admin_form_edit.php';
  }else if($act == 'editPwd'){
        include 'admin_form_edit_password.php'; 
  }else{
      include 'admin_list.php';
  }

  include 'footer.php';
?>





  