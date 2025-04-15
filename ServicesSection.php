        <!-- Services Section -->
        <section id="services" class="services section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <span>บริการของเรา<br></span>
                <h2>บริการของเรา</h2>
                <p>เราพร้อมมอบบริการที่มีคุณภาพ ด้วยมาตรฐานระดับมืออาชีพ เพื่อตอบสนองทุกความต้องการของคุณ</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">
                    <?php foreach ($rsproduct as $row) { ?>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="card">
                                <div class="card-img">
                                    <a href="Services.php?id=<?= $row['service_id']; ?>&act=service-detail" target="_blank">
                                        <img src="assetsBackend/product_img/<?= $row['service_img']; ?>" alt="" class="img-fluid">
                                    </a>
                                </div>
                                <h3><a href="Services.php?id=<?= $row['service_id']; ?>&act=service-detail" target="_blank">
                                        <?= $row['service_names']; ?>
                                    </a> </h3>
                                <p><?= $row['service_caption']; ?></p>
                            </div>
                        </div><!-- End Card Item -->
                    <?php } ?>
                </div>


            </div>

        </section><!-- /Services Section -->