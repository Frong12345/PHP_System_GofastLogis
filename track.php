<?php
//ไฟล์เชื่อมต่อฐานข้อมูล
require_once './config/condb.php';

$order = null;
$rsstatus = [];

if (isset($_POST['tracking_number']) && !empty($_POST['tracking_number'])) {

    $trackingNumber = trim($_POST['tracking_number']);

    //single row query แสดงแค่ 1 รายการ   
    $stmtOrderDetail = $condb->prepare("SELECT 
    c.name, o.tracking_number, o.shipping_type, o.receiver_name, o.order_address, o.order_province, o.current_status, d.center_name
    FROM orders AS o
    INNER JOIN tbl_customers AS c ON o.customer_id_ref = c.customer_id
    LEFT JOIN delivery_centers AS d ON o.ref_center_id = d.center_id
    WHERE o.tracking_number = ?");

    $stmtOrderDetail->execute([$trackingNumber]);
    // ถ้าพบข้อมูลให้นำไปเก็บในตัวแปร
    $order = $stmtOrderDetail->fetch(PDO::FETCH_ASSOC);

    // echo '<pre>';
    // print_r($order);    
    // exit;
    // echo $stmtOrderDetail->rowCount();
    // exit;

    if ($order) {
        $stmtStatusDetail = $condb->prepare("SELECT ol.status , ol.updated_at , d.center_name , o.order_province
        FROM order_logs ol
        JOIN orders o ON ol.order_id = o.order_id
        LEFT JOIN delivery_centers AS d ON o.ref_center_id = d.center_id
        WHERE o.tracking_number = ?
        ORDER BY ol.updated_at DESC;");
        $stmtStatusDetail->execute([$trackingNumber]);
        $rsstatus = $stmtStatusDetail->fetchAll();
    }
}


?>
<?php
include 'header.php';
?>

<body class="index-track">
    <?php
    include 'navbar.php';
    include 'track_PageTitle.php';
    include 'track_search_section.php';
    include 'track_detail_section.php';
    include 'footer.php';
    ?>