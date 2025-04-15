<?php
include 'header.php';
?>
<body class="services-page">
<?php
include 'navbar.php';
include 'service_PageTitle.php';
// Check Query data for service cetalog
if (isset($_GET['act']) && $_GET['act']) {
    // Query product detail with single row
  
if ($_GET['act'] == 'บริการของเรา') {
    include 'service_FeaturedServicesSection.php';
    include 'ServicesSection.php';
}else{
    include 'ServicesDetail.php';
    
}
  }
include 'footer.php';
?>
