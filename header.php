<?php
//เปิดใช้งาน session
session_start();

//ไฟล์เชื่อมต่อฐานข้อมูล
require_once 'config/condb.php';


//แสดงตัวแปร session ทั้งหมด
// print_r($_SESSION);

// echo '<pre>';
// print_r($_POST);
// exit();

//สร้างเงื่อนไขตรวจสอบค่าที่ส่องมาจากฟอร์ม
if (isset($_POST['admin_email']) && isset($_POST['admin_password']) && isset($_POST['act']) && $_POST['act'] == 'login') {

  // echo '<pre>';
  // print_r($_POST);
  // exit();

  //ประกาศตัวแปรรับค่าจากฟอร์ม
  $admin_email = $_POST['admin_email'];
  $admin_password = hash('sha512', $_POST['admin_password']);

  //เช็ค username & password ตรงกับตารางหรือไม่

  //single row query แสดงแค่ 1 รายการ   
  $stmtLogin = $condb->prepare("SELECT admin_id, admin_name, admin_level 
    FROM tbl_admin WHERE admin_email = :admin_email and admin_password = :admin_password");
  //bindParam
  $stmtLogin->bindParam('admin_email', $admin_email, PDO::PARAM_STR);
  $stmtLogin->bindParam('admin_password', $admin_password, PDO::PARAM_STR);
  $stmtLogin->execute();

  // // 0 คือ username & password ไม่ถูกต้อง, 1 คือ username & password ถูกต้อง
  //   echo $stmtLogin->rowCount();
  //   exit;

  //สร้างเงื่อนไข ถ้า username & password ถูกต้อง กระโดดไปโฟล์เดอร์ admin/
  //ถ้าไม่ใช่ sweet alert warning แจ้งเตือน
  if ($stmtLogin->rowCount() != 1) { //false
    // echo 'ใส่ไม่ถูกต้อง';
    echo '<script>
                    setTimeout(function() {
                    swal({
                        title: "เกิดข้อผิดพลาด",
                        text: "Username หรือ Password ไม่ถูกต้อง ลองใหม่อีกครั้ง",
                        type: "warning"
                    }, function() {
                        window.location = "login.php?act=เข้าสู่ระบบ"; //หน้าที่ต้องการให้กระโดดไป
                    });
                    }, 1000);
                </script>';
  } else { //true
    // echo 'ถูกต้อง';

    $row = $stmtLogin->fetch(PDO::FETCH_ASSOC);
    //ประกาศตัวแปร session
    $_SESSION['admin_id'] = $row['admin_id'];
    $_SESSION['admin_name'] = $row['admin_name'];
    $_SESSION['admin_level'] = $row['admin_level'];

    //สร้างเงื่อนไขตรวจสอบ level (admin , staff)
    if ($_SESSION['admin_level'] == 'admin') {
      echo    '<script>
          setTimeout(function() {
          swal({
              title: "ล็อกอินสำเร็จ",
              type: "success"
          }, function() {
              window.location = ' . header('Location: admin/') . '; //หน้าที่ต้องการให้กระโดดไป
          });
          }, 1000);
      </script>';
    } else {
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
    //else if ($_SESSION['admin_level'] == 'staff') { //staff
    //   header('Location: staff/'); //login ถูกต้องและกระโดดไปหน้าตามที่ต้องการ
    // } else if ($_SESSION['admin_level'] == ' ') { //member
    //   header('Location: member_form_edit.php'); //login ถูกต้องและกระโดดไปหน้าตามที่ต้องการ
    // }
  }
} //isset

require_once 'config/condb.php';

// echo '<pre>';
// print_r($_GET);
// exit;

//query product for index || query for loop
$queryproduct = $condb->prepare("SELECT service_id, service_names, service_img, service_caption, service_details
 FROM tbl_service
 ORDER BY service_id DESC
 LIMIT 8");
$queryproduct->execute();
$rsproduct = $queryproduct->fetchAll();









// Windows
$current_page = 'หน้าหลัก';

if (isset($_GET['act'])) {
  $current_page = $_GET['act'];
} else if (isset($_GET['tracking_number'])) {
  $current_page = 'ตรวจสอบสถานะพัสดุ';
}

// echo $current_page;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?= $current_page; ?> | GOFastLogis</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Favicons -->
  <link href="assetsFront/img/favicon.png" rel="icon">
  <link href="assetsFront/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assetsFront/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assetsFront/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assetsFront/vendor/aos/aos.css" rel="stylesheet">
  <link href="assetsFront/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assetsFront/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assetsFront/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assetsFront/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Logis
  * Template URL: https://bootstrapmade.com/logis-bootstrap-logistics-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>