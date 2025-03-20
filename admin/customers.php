<?php
include 'header.php';
include 'navbar.php';
include 'sidebar_menu.php';

$act = (isset($_GET['act']) ? $_GET['act'] : '');
//สร้างเงื่อนไขในการเรียกใช้ไฟล์
if ($act == 'add') {
    include 'customers_form_add.php';
}elseif($act == 'delete'){
    include 'customers_delete.php';
    // echo 'ระบบลบข้อมูล';
}elseif($act == 'edit'){
    include 'customers_form_edit.php';
    // echo 'ระบบแก้ไขข้อมูล';
}else{
    include 'customers_list.php';
}

include 'footer.php';
?>
