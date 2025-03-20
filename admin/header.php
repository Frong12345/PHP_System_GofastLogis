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
if (empty($_SESSION['admin_id']) && empty($_SESSION['admin_name']) && empty($_SESSION['admin_level'])) {
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
if (isset($_SESSION['admin_level']) && $_SESSION['admin_level'] != 'admin') {
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

  <!-- js check file type -->
  <script type="text/javascript">
    var _validFileExtensions = [".jpg", ".JPG", ".jpeg", ".png", ".PNG"]; //กำหนดนามสกุลไฟล์ที่สามรถอัพโหลดได้
    function ValidateTypeFile(oForm) {
      var arrInputs = oForm.getElementsByTagName("input");
      for (var i = 0; i < arrInputs.length; i++) {
        var oInput = arrInputs[i];
        if (oInput.type == "file") {
          var sFileName = oInput.value;
          if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
              var sCurExtension = _validFileExtensions[j];
              if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                blnValid = true;
                break;
              } // if (sFileName.substr(sFileName.length....
            } // for (var j = 0; j < _validFileExtensions.length; j++) {

            //ถ้าเลือกไฟล์ไม่ถุูกต้องจะมี Alert แจ้งเตือน   
            if (!blnValid) {
              // alert("คำเตือน , " + sFileName + "\n ระบบรองรับเฉพาะไฟล์นามสกุล   : " + _validFileExtensions.join(", "));
              setTimeout(function() {
                swal({
                  title: "อัพโหลดไฟล์ไม่ถูกต้อง ",
                  text: "รองรับ .jpg, .jpeg, .png เท่านั้น !!",
                  type: "error"
                }, function() {
                  //window.location.reload();
                  //window.location = "product.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                });
              }, 1000);
              return false;
            } //if (!blnValid) {
          } //if (sFileName.length > 0) {
        } // if (oInput.type == "file") {
      } //for

      return true;
    } //function ValidateTypeFile(oForm) {
  </script>

</head>

<body class="hold-transition sidebar-mini layout-fixed ">
  <div class="wrapper">