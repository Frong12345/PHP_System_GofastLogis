<?php
session_start();
//แสดงตัวแปร session ทั้งหมด
// print_r($_SESSION);

echo '<!-- sweet alert -->
  <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

//สร้างเงื่อนไขตรวจสอบสิทธ์ user role, authentication = admin
//check ว่ามี session ที่จะใช้หรือไม่ admin_id, admin_name, admin_level
if (empty($_SESSION['admin_id']) && empty($_SESSION['admin_name']) && empty($_SESSION['admin_level'])){
  echo '<script>
            setTimeout(function() {
            swal({
                title: "คุณไม่มีสิทธิ์เข้าใช้งานหน้านี้",
                type: "warning"
            }, function() {
                window.location = "../logout.php"; //หน้าที่ต้องการให้กระโดดไป
            });
            }, 1000);
          </script>';
  // header('Location: ../logout.php');
  exit;
}

// Check เป็น admin หรือไม่
if (isset($_SESSION['admin_level']) && $_SESSION['admin_level'] != 'admin'){
  echo '<script>
            setTimeout(function() {
            swal({
                title: "คุณไม่มีสิทธิ์เข้าใช้งานหน้านี้",
                type: "warning"
            }, function() {
                window.location = "../logout.php"; //หน้าที่ต้องการให้กระโดดไป
            });
            }, 1000);
          </script>';
  // header('Location: ../logout.php');
  exit;
}



//ไฟล์เชื่อมต่อฐานข้อมูล
require_once '../config/condb.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Dashboard | by devbanban.com @2025</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assetsBackend/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assetsBackend/dist/css/adminlte.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../assetsBackend/plugins/summernote/summernote-bs4.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="../assetsBackend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../assetsBackend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../assetsBackend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- sweet alert
  <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css"> -->

</head>

<body class="hold-transition sidebar-mini layout-fixed ">
  <div class="wrapper">