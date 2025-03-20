
<?php
include 'header.php';
?>
<body class="index-login">
<?php
include 'navbar.php';
include 'login_PageTitle.php';

$GetAct = (isset($_GET['act']) ? $_GET['act'] : '');

if ($GetAct == 'ลงทะเบียน') {
    include 'register_section.php';
}else{
    include 'login_section.php';
}
include 'footer.php';
?>


