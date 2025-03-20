    <!-- Start track detail section -->
    <div class="container">
        <div class="row">
            <!-- รับค่าจาก Form Input แล้ว Check เงื่อนไข -->
            <?php if (isset($_POST['tracking_number']) && $_POST['tracking_number'] !== '') {
                // echo '<pre>';
                // print_r($_GET);
                // exit;
            ?>
                <?php if (!empty($order)) { ?>
                    <!-- พบหมายเลขติดตามพัสดุ -->
                    <h4 class="d-none d-md-block">หมายเลขติดตามพัสดุ: <?php echo htmlspecialchars($order['tracking_number']); ?></h4>
                    <h5 class="d-sm-block d-md-none">หมายเลขติดตามพัสดุ: <?php echo htmlspecialchars($order['tracking_number']); ?></h5>
                <?php } else { ?>
                    <!-- ไม่พบหมายเลขติดตามพัสดุ -->
                    <h3>หมายเลขติดตามพัสดุ: <?php echo htmlspecialchars($_POST['tracking_number']); ?></h3>
                    <div class="alert alert-danger col-12">❌ ไม่พบข้อมูลเลขพัสดุนี้</div>
                <?php } ?>
            <?php } ?>
        </div>

        <!-- echo '<pre>';
        print_r($_GET);
        exit; -->
    </div>


    <!-- แสดงผลข้อมูลพัสดุ -->
    <?php if (!empty($order)) { //check ว่า $order ไม่ใช่ค่าว่าง 
    ?>
        <div class="container mb-2">
            <div class="row">
                <?php
                $bg_header = "#0171b8";
                ?>
                <div class="container col-md-6 col-lg-6 col-xl-6 mb-2">
                    <div class="border border-1 rounded-3 p-0 ">
                        <div class="text-white px-2 rounded-top-3 w-100 d-flex align-items-center" style="height: 50px; background-color: <?= $bg_header ?>;">
                            <p class="mb-0 px-1" style="font-weight: 300;">
                                <i class="fa fa-user fs-4 mx-1"></i> ข้อมูลพัสดุ
                            </p>
                        </div>
                        <div class="row p-3">
                            <div>
                                <p><strong>ผู้ส่ง:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
                                <p><strong>ผู้รับ:</strong> <?php echo htmlspecialchars($order['receiver_name']); ?></p>
                                <p><strong>ต้นทาง:</strong> <?php echo htmlspecialchars($order['center_name']); ?></p>
                                <p><strong>ปลายทาง:</strong> <?php echo htmlspecialchars($order['order_province']); ?></p>
                                <p><strong>ประเภทบริการ:</strong> <?php echo htmlspecialchars($order['shipping_type']); ?></p>
                                <p><strong>สถานะพัสดุ:</strong> <?php echo htmlspecialchars($order['current_status']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Start สถานะพัสดุ ให้แสดง จอ xl ขึ้นไป -->
                <div class="container mb-2 col-xl-6 d-xl-block d-none">

                    <div class=" border border-1 rounded-3 p-0">
                        <div class="text-white p-2 rounded-top-3 w-100" style="background-color: <?= $bg_header ?>;">
                            <p class="mb-0 px-1"><i class="bi bi-archive-fill fs-4 mx-1"></i> สถานะพัสดุ</p>
                        </div>

                        <div>
                            <?php if (!empty($rsstatus)) { //check ว่า $rsstatus ไม่ใช่ค่าว่าง 
                            ?>
                                <?php foreach ($rsstatus as $row) { ?>
                                    <?php if (!empty($row['status'])) {  //check ว่า $row['status']) ไม่ใช่ค่าว่าง 
                                    ?>
                                        <div class="container mb-1">
                                            <div class="row pt-3 small">
                                                <div class="col-xl-1"></div>
                                                <div class="col-xl-2">
                                                    <p class="mb-0"><?= date('d/m/Y', strtotime($row['updated_at'])); ?> </p>
                                                    <p class="mt-1 text-end" style="font-size: 11px; font-weight: 400; color:rgb(163, 163, 163);"><?= date('H:i', strtotime($row['updated_at'])); ?></p>
                                                </div>
                                                <div class="col-xl-2 text-center">
                                                    <?php
                                                    $icon = "fas fa-warehouse";
                                                    $bgColor = "#805AD5";
                                                    $size = "11px 10px; font-size: 1.2rem";
                                                    $text = "Received at Origin Center";
                                                    $center = $row['center_name'];
                                                    $dropoff = htmlspecialchars($row['status']) . 'ต้นทาง';

                                                    switch ($row['status']) {
                                                        case "พัสดุกำลังเดินทาง":
                                                            $icon = "fa-truck-fast";
                                                            $bgColor = "#D69E2E";
                                                            $size = "11px 9px; font-size: 1.2rem";
                                                            $text = "Departed from Origin Center";
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุถึงปลายทาง":
                                                            $icon = "fa-truck-fast";
                                                            $bgColor = "#D69E2E";
                                                            $text = "Arrived at Destination Center";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุอยู่ระหว่างการนำส่ง":
                                                            $icon = "fa-truck-fast";
                                                            $bgColor = "#D69E2E";
                                                            $size = "11px 9px; font-size: 1.2rem";
                                                            $text = "Out for Delivery";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุจัดส่งสำเร็จ":
                                                            $icon = "fa-box";
                                                            $bgColor = "#38A169";
                                                            $size = "11px 13px; font-size: 1.2rem";
                                                            $text = "Delivered";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุจัดส่งไม่สำเร็จ":
                                                            $icon = "fa-box";
                                                            $bgColor = "orange";
                                                            $size = "11px 13px; font-size: 1.2rem";
                                                            $text = "Delivery Unsuccessful - Will Retry on the Next Business Day";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุถูกตีกลับ":
                                                            $icon = "fa- fa-rotate-left";
                                                            $bgColor = "red";
                                                            $size = "11px 11px; font-size: 1.2rem";
                                                            $text = "Returned to Sender";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                    }
                                                    ?>
                                                    <h6>
                                                        <i class="fa-solid <?= $icon ?> text-white"
                                                            style="background:<?= $bgColor ?>; line-height: 2.6rem; width: 2.6rem; height: 2.6rem; font-size: 1.1rem; border-radius: 50%;">
                                                        </i>
                                                    </h6>
                                                </div>
                                                <div class="col-xl-5">
                                                    <p class="mb-0"><?= $dropoff; ?> <?= (htmlspecialchars($row['status']) == 'พัสดุจัดส่งไม่สำเร็จ') ? ' - จะพยายามจัดส่งใหม่ในวันทำการถัดไป' : ''; ?> <br> <?= $text; ?></p>
                                                    <p class=" mb-0" style="font-size: 12px; font-weight: 300; color:rgb(163, 163, 163);"><?= ($row['status'] == 'รับพัสดุเข้าศูนย์') ? 'ศูนย์' . $center : (($row['status'] == 'พัสดุถึงปลายทาง' || $row['status'] == 'พัสดุอยู่ระหว่างการนำส่ง' || $row['status'] == 'พัสดุจัดส่งสำเร็จ' || $row['status'] == 'พัสดุจัดส่งไม่สำเร็จ' || $row['status'] == 'พัสดุถูกตีกลับ') ? 'ศูนย์' . $center : ''); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?> <!-- จบ if (!empty($row['status'])) -->
                                <?php } //end Foreach 
                                ?>
                            <?php }  // จบ if (!empty($rsstatus))
                            else { ?>
                                <p>ไม่มีข้อมูลสถานะพัสดุ</p>
                            <?php } ?> <!-- จบ else (!empty($rsstatus)) -->
                        </div>
                    </div>
                </div>
                <!-- End สถานะพัสดุ -->

                <!-- Start สถานะพัสดุ ให้แสดง จอ lg -->
                <div class="container mb-2 col-lg-6 d-none d-lg-block d-xl-none">

                    <div class="border border-1 rounded-3 p-0 pb-5">
                        <div class="text-white px-2 rounded-top-3 w-100 d-flex align-items-center" style="height: 50px; background-color: <?= $bg_header ?>;">
                            <p class="mb-0 px-1" style="font-weight: 300;">
                                <i class="bi bi-archive-fill fs-4 mx-1"></i> สถานะพัสดุ
                            </p>
                        </div>

                        <div>
                            <?php if (!empty($rsstatus)) { //check ว่า $rsstatus ไม่ใช่ค่าว่าง 
                            ?>
                                <?php foreach ($rsstatus as $row) { ?>
                                    <?php if (!empty($row['status'])) {  //check ว่า $row['status']) ไม่ใช่ค่าว่าง 
                                    ?>
                                        <div class="container mb-1 p-0">
                                            <div class="row pt-3 p-0">

                                                <div class="col-lg-2 text-center px-4">
                                                    <?php
                                                    $icon = "fas fa-warehouse";
                                                    $bgColor = "#805AD5";
                                                    $text = "Received at Origin Center";
                                                    $center = $row['center_name'];
                                                    $dropoff = htmlspecialchars($row['status']) . 'ต้นทาง';

                                                    switch ($row['status']) {
                                                        case "พัสดุกำลังเดินทาง":
                                                            $icon = "fa-truck-fast";
                                                            $bgColor = "#D69E2E";
                                                            $text = "Departed from Origin Center";
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุถึงปลายทาง":
                                                            $icon = "fa-truck-fast";
                                                            $bgColor = "#D69E2E";
                                                            $text = "Arrived at Destination Center";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุอยู่ระหว่างการนำส่ง":
                                                            $icon = "fa-truck-fast";
                                                            $bgColor = "#D69E2E";
                                                            $text = "Out for Delivery";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุจัดส่งสำเร็จ":
                                                            $icon = "fa-box";
                                                            $bgColor = "#38A169";
                                                            $text = "Delivered";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุจัดส่งไม่สำเร็จ":
                                                            $icon = "fa-box";
                                                            $bgColor = "orange";
                                                            $text = "Delivery Unsuccessful - Will Retry on the Next Business Day";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุถูกตีกลับ":
                                                            $icon = "fa- fa-rotate-left";
                                                            $bgColor = "red";
                                                            $text = "Returned to Sender";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                    }
                                                    ?>
                                                    <div>
                                                        <i class="fa-solid <?= $icon ?> text-white"
                                                            style="background:<?= $bgColor ?>; line-height: 2.6rem; width: 2.6rem; height: 2.6rem; font-size: 1.1rem; border-radius: 50%;">
                                                        </i>
                                                    </div>
                                                </div>

                                                <!-- <div class="col-1"></div> -->

                                                <div class="col-lg-9 p-0 ms-4">
                                                    <div class="col-lg-12">
                                                        <p class="mb-0"><?= date('d/m/Y', strtotime($row['updated_at'])); ?> </p>
                                                        <p class="mt-1" style="font-size: 11px; font-weight: 400; color:rgb(163, 163, 163);"><?= date('H:i', strtotime($row['updated_at'])); ?></p>
                                                    </div>

                                                    <div class="col-lg-12 rounded-2" style="background-color:rgb(244, 244, 244);">
                                                        <p class="mb-0"><?= $dropoff; ?> <?= (htmlspecialchars($row['status']) == 'พัสดุจัดส่งไม่สำเร็จ') ? ' - จะพยายามจัดส่งใหม่ในวันทำการถัดไป' : ''; ?> <br> <?= $text; ?></p>
                                                        <p class="mt-1 mb-0" style="font-size: 12px; font-weight: 300; color:rgb(163, 163, 163);"><?= ($row['status'] == 'รับพัสดุเข้าศูนย์') ? 'ศูนย์' . $center : (($row['status'] == 'พัสดุถึงปลายทาง' || $row['status'] == 'พัสดุอยู่ระหว่างการนำส่ง' || $row['status'] == 'พัสดุจัดส่งสำเร็จ' || $row['status'] == 'พัสดุจัดส่งไม่สำเร็จ' || $row['status'] == 'พัสดุถูกตีกลับ') ? 'ศูนย์' . $center : ''); ?></p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <?php } ?> <!-- จบ if (!empty($row['status'])) -->
                                <?php } //end Foreach 
                                ?>
                            <?php }  // จบ if (!empty($rsstatus))
                            else { ?>
                                <p>ไม่มีข้อมูลสถานะพัสดุ</p>
                            <?php } ?> <!-- จบ else (!empty($rsstatus)) -->
                        </div>
                    </div>
                </div>
                <!-- End สถานะพัสดุ -->

                <!-- Start สถานะพัสดุ ให้แสดง จอเล็กกว่า lg -->
                <div class="container mb-2 col-md-6 d-none d-md-block d-lg-none">

                    <div class="border border-1 rounded-3 p-0 pb-5">
                        <div class="text-white px-2 rounded-top-3 w-100 d-flex align-items-center" style="height: 50px; background-color: <?= $bg_header ?>;">
                            <p class="mb-0 px-1" style="font-weight: 300;">
                                <i class="bi bi-archive-fill fs-4 mx-1"></i> สถานะพัสดุ
                            </p>
                        </div>

                        <div>
                            <?php if (!empty($rsstatus)) { //check ว่า $rsstatus ไม่ใช่ค่าว่าง 
                            ?>
                                <?php foreach ($rsstatus as $row) { ?>
                                    <?php if (!empty($row['status'])) {  //check ว่า $row['status']) ไม่ใช่ค่าว่าง 
                                    ?>
                                        <div class="container mb-1 p-0">
                                            <div class="row pt-3 p-0">

                                                <div class="col-md-2 text-center px-4">
                                                    <?php
                                                    $icon = "fas fa-warehouse";
                                                    $bgColor = "#805AD5";
                                                    $text = "Received at Origin Center";
                                                    $center = $row['center_name'];
                                                    $dropoff = htmlspecialchars($row['status']) . 'ต้นทาง';

                                                    switch ($row['status']) {
                                                        case "พัสดุกำลังเดินทาง":
                                                            $icon = "fa-truck-fast";
                                                            $bgColor = "#D69E2E";
                                                            $text = "Departed from Origin Center";
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุถึงปลายทาง":
                                                            $icon = "fa-truck-fast";
                                                            $bgColor = "#D69E2E";
                                                            $text = "Arrived at Destination Center";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุอยู่ระหว่างการนำส่ง":
                                                            $icon = "fa-truck-fast";
                                                            $bgColor = "#D69E2E";
                                                            $text = "Out for Delivery";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุจัดส่งสำเร็จ":
                                                            $icon = "fa-box";
                                                            $bgColor = "#38A169";
                                                            $text = "Delivered";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุจัดส่งไม่สำเร็จ":
                                                            $icon = "fa-box";
                                                            $bgColor = "orange";
                                                            $text = "Delivery Unsuccessful - Will Retry on the Next Business Day";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุถูกตีกลับ":
                                                            $icon = "fa- fa-rotate-left";
                                                            $bgColor = "red";
                                                            $text = "Returned to Sender";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                    }
                                                    ?>
                                                    <div>
                                                        <i class="fa-solid <?= $icon ?> text-white"
                                                            style="background:<?= $bgColor ?>; line-height: 2.6rem; width: 2.6rem; height: 2.6rem; font-size: 1.1rem; border-radius: 50%;">
                                                        </i>
                                                    </div>
                                                </div>

                                                <!-- <div class="col-1"></div> -->

                                                <div class="col-md-9 p-0 ms-4">
                                                    <div class="col-md-12">
                                                        <p class="mb-0"><?= date('d/m/Y', strtotime($row['updated_at'])); ?> </p>
                                                        <p class="mt-1" style="font-size: 11px; font-weight: 400; color:rgb(163, 163, 163);"><?= date('H:i', strtotime($row['updated_at'])); ?></p>
                                                    </div>

                                                    <div class="col-md-11 rounded-2" style="background-color:rgb(244, 244, 244);">
                                                        <p class="mb-0"><?= $dropoff; ?> <?= (htmlspecialchars($row['status']) == 'พัสดุจัดส่งไม่สำเร็จ') ? ' - จะพยายามจัดส่งใหม่ในวันทำการถัดไป' : ''; ?> <br> <?= $text; ?></p>
                                                        <p class="mt-1 mb-0" style="font-size: 12px; font-weight: 300; color:rgb(163, 163, 163);"><?= ($row['status'] == 'รับพัสดุเข้าศูนย์') ? 'ศูนย์' . $center : (($row['status'] == 'พัสดุถึงปลายทาง' || $row['status'] == 'พัสดุอยู่ระหว่างการนำส่ง' || $row['status'] == 'พัสดุจัดส่งสำเร็จ' || $row['status'] == 'พัสดุจัดส่งไม่สำเร็จ' || $row['status'] == 'พัสดุถูกตีกลับ') ? 'ศูนย์' . $center : ''); ?></p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <?php } ?> <!-- จบ if (!empty($row['status'])) -->
                                <?php } //end Foreach 
                                ?>
                            <?php }  // จบ if (!empty($rsstatus))
                            else { ?>
                                <p>ไม่มีข้อมูลสถานะพัสดุ</p>
                            <?php } ?> <!-- จบ else (!empty($rsstatus)) -->
                        </div>
                    </div>
                </div>
                <!-- End สถานะพัสดุ -->

                <!-- Start สถานะพัสดุ ให้แสดง จอเล็กกว่า md -->
                <div class="container mb-2 d-block d-md-none">

                    <div class="border border-1 rounded-3 p-0 pb-5">
                        <div class="text-white px-2 rounded-top-3 w-100 d-flex align-items-center" style="height: 50px; background-color: <?= $bg_header ?>;">
                            <p class="mb-0 px-1" style="font-weight: 300;">
                                <i class="bi bi-archive-fill fs-4 mx-1"></i> สถานะพัสดุ
                            </p>
                        </div>

                        <div>
                            <?php if (!empty($rsstatus)) { //check ว่า $rsstatus ไม่ใช่ค่าว่าง 
                            ?>
                                <?php foreach ($rsstatus as $row) { ?>
                                    <?php if (!empty($row['status'])) {  //check ว่า $row['status']) ไม่ใช่ค่าว่าง 
                                    ?>
                                        <div class="container mb-1">
                                            <div class="row pt-3">

                                                <div class="col-2 text-center">
                                                    <?php
                                                    $icon = "fas fa-warehouse";
                                                    $bgColor = "#805AD5";
                                                    $text = "Received at Origin Center";
                                                    $center = $row['center_name'];
                                                    $dropoff = htmlspecialchars($row['status']) . 'ต้นทาง';

                                                    switch ($row['status']) {
                                                        case "พัสดุกำลังเดินทาง":
                                                            $icon = "fa-truck-fast";
                                                            $bgColor = "#D69E2E";
                                                            $text = "Departed from Origin Center";
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุถึงปลายทาง":
                                                            $icon = "fa-truck-fast";
                                                            $bgColor = "#D69E2E";
                                                            $text = "Arrived at Destination Center";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุอยู่ระหว่างการนำส่ง":
                                                            $icon = "fa-truck-fast";
                                                            $bgColor = "#D69E2E";
                                                            $text = "Out for Delivery";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุจัดส่งสำเร็จ":
                                                            $icon = "fa-box";
                                                            $bgColor = "#38A169";
                                                            $text = "Delivered";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุจัดส่งไม่สำเร็จ":
                                                            $icon = "fa-box";
                                                            $bgColor = "orange";
                                                            $text = "Delivery Unsuccessful - Will Retry on the Next Business Day";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                        case "พัสดุถูกตีกลับ":
                                                            $icon = "fa- fa-rotate-left";
                                                            $bgColor = "red";
                                                            $text = "Returned to Sender";
                                                            $center = $row['order_province'];
                                                            $dropoff = htmlspecialchars($row['status']);
                                                            break;
                                                    }
                                                    ?>
                                                    <div>
                                                        <i class="fa-solid <?= $icon ?> text-white"
                                                            style="background:<?= $bgColor ?>; line-height: 2.6rem; width: 2.6rem; height: 2.6rem; font-size: 1.1rem; border-radius: 50%;">
                                                        </i>
                                                    </div>
                                                </div>

                                                <div class="col-9 p-0 ms-4">
                                                    <div>
                                                        <p class="mb-0"><?= date('d/m/Y', strtotime($row['updated_at'])); ?> </p>
                                                        <p class="mt-1" style="font-size: 11px; font-weight: 400; color:rgb(163, 163, 163);"><?= date('H:i', strtotime($row['updated_at'])); ?></p>
                                                    </div>

                                                    <div class="rounded-2 px-1" style="background-color:rgb(244, 244, 244);">
                                                        <p class="mb-0"><?= $dropoff; ?> <?= (htmlspecialchars($row['status']) == 'พัสดุจัดส่งไม่สำเร็จ') ? ' - จะพยายามจัดส่งใหม่ในวันทำการถัดไป' : ''; ?> <br> <?= $text; ?></p>
                                                        <p class="mt-1 mb-0" style="font-size: 12px; font-weight: 300; color:rgb(163, 163, 163);"><?= ($row['status'] == 'รับพัสดุเข้าศูนย์') ? 'ศูนย์' . $center : (($row['status'] == 'พัสดุอยู่ระหว่างการนำส่ง' || $row['status'] == 'พัสดุจัดส่งสำเร็จ' || $row['status'] == 'พัสดุจัดส่งไม่สำเร็จ' || $row['status'] == 'พัสดุถูกตีกลับ') ? 'ศูนย์' . $center : ''); ?></p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <?php } ?> <!-- จบ if (!empty($row['status'])) -->
                                <?php } //end Foreach 
                                ?>
                            <?php }  // จบ if (!empty($rsstatus))
                            else { ?>
                                <p>ไม่มีข้อมูลสถานะพัสดุ</p>
                            <?php } ?> <!-- จบ else (!empty($rsstatus)) -->
                        </div>
                    </div>
                </div>
                <!-- End สถานะพัสดุ -->
            </div>
        </div>




    <?php } ?> <!-- จบ if (!empty($order)) -->
    <!-- End track detail section -->
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>