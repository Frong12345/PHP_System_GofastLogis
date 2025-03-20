<?php
include 'header.php';
include 'navbar.php';
include 'sidebar_menu.php';

$act = (isset($_GET['act']) ? $_GET['act'] : '');
//สร้างเงื่อนไขในการเรียกใช้ไฟล์
if ($act == 'add') {
    include 'member_form_add.php';
}elseif (isset($_POST['id']) && isset($_POST['student_image']) && isset($_POST['act']) && $_POST['act'] == 'delete') {
    include 'member_delete.php';
}elseif ($act == 'edit') {
    include 'member_edit.php';
}else {
    include 'member_list.php';
}

//สร้างเงื่อนไขลบข้อมูล
// if (isset($_POST['id']) && isset($_POST['student_image']) && isset($_POST['action']) && $_POST['action'] == 'delete') {
//     include 'member_delete.php';
// }




include 'footer.php';
