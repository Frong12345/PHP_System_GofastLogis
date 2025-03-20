<?php
ob_start();
include 'header.php';
include 'navbar.php';
include 'sidebar_menu.php';

$act = (isset($_GET['act']) ? $_GET['act'] : '');
$status = (isset($_GET['status']) ? $_GET['status'] : '');

//สร้างเงื่อนไขในการเรียกใช้ไฟล์
if ($act == 'orders_list') {
  include 'orders_list.php';
} else if ($act == 'update_status') {
  include 'update_status_list.php';
} else if ($act == 'check_add'){
  include 'orders_check_form_add.php';
} else if ($act == 'add'){
  include 'orders_form_add.php';
} else if ($act == 'edit'){
  include 'orders_form_edit.php';
} else if ($act == 'delete'){
  include 'orders_delete.php';
} else if ($status != '') {
  include 'update_status_list.php';
} else if ($status == '' && isset($_GET['status'])) {
  include 'update_status_list.php';
} else {
  include 'orders_list.php';
}
include 'order_footer.php';
