<?php

//single row query แสดงแค่ 1 รายการ  สำหรับ Small Box
// Visitor = $rowOrderCount
$stmtOrders = $condb->prepare("SELECT COUNT(*) as totalOrders FROM orders");
$stmtOrders->execute();
$rowOrderCount = $stmtOrders->fetch(PDO::FETCH_ASSOC);

// Member = $rowStaffCount
$stmtCustomers = $condb->prepare("SELECT COUNT(*) as totalCustomers FROM tbl_customers");
$stmtCustomers->execute();
$rowCustomersCount = $stmtCustomers->fetch(PDO::FETCH_ASSOC);

// Admin = $rowAdminCount
$stmtAdmins = $condb->prepare("SELECT COUNT(*) as totalAdmins FROM tbl_admin WHERE admin_level='admin'");
$stmtAdmins->execute();
$rowAdminCount = $stmtAdmins->fetch(PDO::FETCH_ASSOC);

// Product = $rowCenterCount
$stmtCenterCount = $condb->prepare("SELECT COUNT(*) as totalCenters FROM delivery_centers");
$stmtCenterCount->execute();
$rowCenterCount = $stmtCenterCount->fetch(PDO::FETCH_ASSOC);
// End Single row query สำหรับ Small Box



// Bring data to array for chart plot
// https://devbanban.com/?p=5094 : 5.หน้าแสดงรายงาน (Report) แสดงกราฟแท่งแสดงการประเมินแยกตามวัน และการแปลผลคะแนนประเมินโดยการใช้ค่าเฉลี่ย
// Query Visitor by Date
$queryViewByDay = $condb->prepare(
    "SELECT DATE_FORMAT(created_at,'%d/%m/%Y') as datesave, count(*)/7 as total 
            FROM orders
            GROUP BY DATE_FORMAT(created_at,'%Y-%m-%d') 
            ORDER BY DATE_FORMAT(created_at,'%Y-%m-%d') DESC"
);
$queryViewByDay->execute();
$rwViewByDay = $queryViewByDay->fetchAll();
$report_data = array();

//printf(count($rwViewByDay));
// echo '<pre>';
// print_r($rwViewByDay);

        /* Data for chart's structure
                {
                name: "Example", y: 50.55, drilldown: "Example"},
                Reference : https://www.highcharts.com/demo/ios/column-drilldown
        */

foreach ($rwViewByDay as $rs) {
    $report_data[] = '
        {name: ' . '"' . $rs['datesave'] . '"' . ',' . 'y: ' . $rs['total'] . ',' . 'drilldown: ' . '"' . $rs['datesave'] . '"' . ',' . '}';
}
$report_data = implode(",", $report_data);

// echo '<pre>';
// print_r($report_data);

// Query Visitor by Month
$queryViewByMonth = $condb->prepare(
    "SELECT MONTHNAME(created_at) as monthName, COUNT(*) as totalByMonth
    FROM orders
    GROUP BY MONTH(created_at)
    ORDER BY DATE_FORMAT(created_at, '%Y-%m') DESC"
);
$queryViewByMonth->execute();
$rwViewByMonth = $queryViewByMonth->fetchAll();
$report_data_month = array();
foreach ($rwViewByMonth as $rs) {
    $report_data_month[] = '
        {name: ' . '"' . $rs['monthName'] . '"' . ',' . 'y: ' . $rs['totalByMonth'] . ',' . 'drilldown: ' . '"' . $rs['monthName'] . '"' . ',' . '}';
}
$report_data_month = implode(",", $report_data_month);

// echo '<pre>';
// print_r($report_data_month);

// Query Visitor by Year
$queryViewByYear = $condb->prepare(
    "SELECT YEAR(created_at) as years, COUNT(*) as totalByYear
    FROM orders
    GROUP BY YEAR(created_at)
    ORDER BY YEAR(created_at) DESC"
);
$queryViewByYear->execute();
$rwViewByYear = $queryViewByYear->fetchAll();
$report_data_year = array();
foreach ($rwViewByYear as $rs) {
    $report_data_year[] = '
        {name: ' . '"' . $rs['years'] . '"' . ',' . 'y: ' . $rs['totalByYear'] . ',' . 'drilldown: ' . '"' . $rs['years'] . '"' . ',' . '}';
}
$report_data_year = implode(",", $report_data_year);
// echo '<pre>';
// print_r($report_data_year);

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard/รายงานภาพรวม</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- small Box Start -->
                            <div class="row">

                                <!-- small box Orders -->
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3> <?= $rowOrderCount['totalOrders']; ?> </h3>
                                            <p>Orders</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-connection-bars"></i>
                                        </div>
                                        <a href="orders.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <!-- small box Staffs -->
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3> <?= $rowCustomersCount['totalCustomers']; ?> </h3>
                                            <p>Customers</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-person-stalker"></i>
                                        </div>
                                        <a href="admin.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <!-- small box Admin -->
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3> <?= $rowAdminCount['totalAdmins']; ?> </h3>
                                            <p>Admin</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-person"></i>
                                        </div>
                                        <a href="admin.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <!-- small box Distribute Centers -->
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3> <?= $rowCenterCount['totalCenters']; ?> </h3>
                                            <p>Distribute Centers</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="distribution_centers.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div> <!-- small Box End -->


                            <!-- High Chart Start -->
                            <div class="row">
                                <div class="col-sm-12"> 
                                    <!-- Chart by Day start -->
                                    <figure class="highcharts-figure">
                                        <div id="container"></div>
                                        <p class="highcharts-description">.</p>
                                    </figure>
                                    <script>
                                        Highcharts.chart('container', {
                                            chart: {
                                                type: 'line'
                                            },
                                            title: {
                                                text: 'จำนวนการใช้บริการตามรายวัน'
                                            },
                                            subtitle: {
                                                text: 'รวมทั้งสิ้น <?= $rowOrderCount['totalOrders']; ?> ครั้ง '
                                            },
                                            accessibility: {
                                                announceNewData: {
                                                    enabled: true
                                                }
                                            },
                                            xAxis: {
                                                type: 'category'
                                            },
                                            yAxis: {
                                                title: {
                                                    text: 'จำนวนการใช้บริการ'
                                                }
                                            },
                                            legend: {
                                                enabled: false
                                            },
                                            plotOptions: {
                                                series: {
                                                    borderWidth: 0,
                                                    dataLabels: {
                                                        enabled: true,
                                                        format: '{point.y:.0f} ครั้ง'
                                                    }
                                                }
                                            },
                                            tooltip: {
                                                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f} ครั้ง</b> of total<br/>'
                                            },
                                            series: [{
                                                name: "จำนวนการใช้บริการ",
                                                colorByPoint: true,
                                                //เอาข้อมูลมา echo ตรงนี้
                                                data: [<?= $report_data; ?>]
                                            }]
                                        });
                                    </script> <!-- Chart by Day End -->
                                </div>

                                <div class="col-sm-8">
                                    <!-- Chart by Month start -->
                                    <figure class="highcharts-figure">
                                        <div id="container2"></div>
                                        <p class="highcharts-description">.</p>
                                    </figure>
                                    <script>
                                        Highcharts.chart('container2', {
                                            chart: {
                                                type: 'column'
                                            },
                                            title: {
                                                text: 'จำนวนพัสดุแยกตามเดือน'
                                            },
                                            subtitle: {
                                                text: 'รวมทั้งสิ้น <?= $rowOrderCount['totalOrders']; ?> ครั้ง '
                                            },
                                            accessibility: {
                                                announceNewData: {
                                                    enabled: true
                                                }
                                            },
                                            xAxis: {
                                                type: 'category'
                                            },
                                            yAxis: {
                                                title: {
                                                    text: 'จำนวนการใช้บริการ'
                                                }
                                            },
                                            legend: {
                                                enabled: false
                                            },
                                            plotOptions: {
                                                series: {
                                                    borderWidth: 0,
                                                    dataLabels: {
                                                        enabled: true,
                                                        format: '{point.y:.0f} ครั้ง'
                                                    }
                                                }
                                            },
                                            tooltip: {
                                                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f} ครั้ง</b> of total<br/>'
                                            },
                                            series: [{
                                                name: "จำนวนการใช้บริการ",
                                                colorByPoint: true,
                                                //เอาข้อมูลมา echo ตรงนี้
                                                data: [<?= $report_data_month; ?>]
                                            }]
                                        });
                                    </script> <!-- Chart by Month End -->
                                </div>

                                <div class="col-sm-4">
                                    <!-- Chart by Year start -->
                                    <figure class="highcharts-figure">
                                        <div id="container-"></div>
                                        <p class="highcharts-description">.</p>
                                    </figure>
                                    <script>
                                        Highcharts.chart('container-', {
                                            chart: {
                                                type: 'column'
                                            },
                                            title: {
                                                text: 'จำนวนพัสดุแยกตามปี'
                                            },
                                            subtitle: {
                                                text: 'รวมทั้งสิ้น <?= $rowOrderCount['totalOrders']; ?> ครั้ง '
                                            },
                                            accessibility: {
                                                announceNewData: {
                                                    enabled: true
                                                }
                                            },
                                            xAxis: {
                                                type: 'category'
                                            },
                                            yAxis: {
                                                title: {
                                                    text: 'จำนวนการใช้บริการ'
                                                }
                                            },
                                            legend: {
                                                enabled: false
                                            },
                                            plotOptions: {
                                                series: {
                                                    borderWidth: 0,
                                                    dataLabels: {
                                                        enabled: true,
                                                        format: '{point.y:.0f} ครั้ง'
                                                    }
                                                }
                                            },
                                            tooltip: {
                                                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f} ครั้ง</b> of total<br/>'
                                            },
                                            series: [{
                                                name: "จำนวนการใช้บริการ",
                                                colorByPoint: true,
                                                //เอาข้อมูลมา echo ตรงนี้
                                                data: [<?= $report_data_year; ?>]
                                            }]
                                        });
                                    </script> <!-- Chart by Year End -->
                                </div>



                            </div> <!-- High Chart End -->

                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div> <!-- /.row -->
        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->