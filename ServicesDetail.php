<?php
// echo '<pre>';
// print_r($PrdData);

$stmtPrdDetail = $condb->prepare("SELECT service_id, service_names, service_img, service_caption, service_details
            FROM tbl_service
            WHERE service_id=?");
$stmtPrdDetail->execute([$_GET['id']]);
$PrdData = $stmtPrdDetail->fetch(PDO::FETCH_ASSOC);
// echo '<pre>';
// print_r($PrdData);
?>
<!-- Service Details Section -->
<section id="service-details" class="service-details section">

    <div class="container">

        <div class="row gy-4">

            <div class="col-12 col-sm-4 col-md-4">
                <!-- Show image -->
                <a href="./assetsBackend/product_img/<?= $PrdData['service_img']; ?>" width="100%" target="_blank">
                    <img src="./assetsBackend/product_img/<?= $PrdData['service_img']; ?>" class="card-img-top">
                </a>
            </div>

            <div class="col-12 col-sm-8 col-md-8">
                <!-- Show detail -->
                <h3><?= $PrdData['service_names']; ?></h3>

                <b> Captions : <?= $PrdData['service_caption']; ?></b>

                <p>
                    <b> Details: </b> <br>
                    <?= $PrdData['service_details']; ?>

                </p>

            </div>

        </div>

    </div>

</section><!-- /Service Details Section -->

