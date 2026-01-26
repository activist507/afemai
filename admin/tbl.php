<?php 
  include('../config/auth.php');
  include('../config/app.php');
  include('../config/license.php');


  // <!-- Items to sell  -->
    if($userCate == 'General'){
      $items = $conq->query("SELECT * FROM items")->fetch_all(MYSQLI_ASSOC);
    } else {
      $items = $conq->query("SELECT * FROM items WHERE category ='$userCate'")->fetch_all(MYSQLI_ASSOC);
    }
  // <!-- End Items to sell -->
  
  $payment_methods = $conq->query("SELECT * FROM payment_method WHERE status=1")->fetch_all(MYSQLI_ASSOC);
  $alarm = $conq->query("SELECT COUNT(*) AS alarm FROM items WHERE qty<=minimum")->fetch_object();
    
  // <!-- sales list  -->
    $date = date('Y-m-d');
    if($role == 'Superadmin' || $role == 'admin'){
      $qry = "SELECT * FROM sales WHERE date='$date'";
      $qry2 = "SELECT SUM(total_sale) AS tot FROM sales WHERE date='$date'";
    } else {
      $qry = "SELECT * FROM sales WHERE processed_by = '$userName' AND date='$date'";
      $qry2 = "SELECT SUM(total_sale) AS tot FROM sales WHERE processed_by = '$userName' AND date='$date'";
    }
    $sales = $conq->query($qry)->fetch_all(MYSQLI_ASSOC);
    $saleCount = count($sales);
    $total_sale = $conq->query($qry2)->fetch_object();
    $total_rev = number_format($total_sale->tot);

  // <!-- END sales list  -->

  // <!-- receipt list  -->
    if($role == 'Superadmin' || $role == 'admin'){
      $qry = "SELECT * FROM unprinted_receipt WHERE printed = 0";
    } else {
      $qry = "SELECT * FROM unprinted_receipt WHERE printed = 0 AND processed_by = '$userName'";
    }
    $sql1 = $conq->query($qry);
  // <!-- END receipt list  -->

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - <?= $role?> </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../<?= $logo?>" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <!-- bootstrap 5 -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../assets/css/daterangepicker.css">
    <link rel="stylesheet" href="../assets/css/toastr.min.css">
    <link rel="stylesheet" href="../assets/css/jquery-confirm.min.css">
    <link rel="stylesheet" href="../assets/css/select2.min.css">
    <style type="text/css">
    .select2-container .select2-selection--single {
        height: 45px !important;
        border-radius: 0px !important;
        padding: 14px 15px;
        font-size: 16px;
    }

    .no-data {
        text-align: center;
        color: gray;
        font-style: italic;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        width: 300px;
        height: 400px;
        background: white;
        border-radius: 5px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .modal-content iframe {
        width: 100%;
        height: 100%;
    }

    .close-btn {
        position: absolute;
        top: 5px;
        right: 10px;
        font-size: 24px;
        cursor: pointer;
        color: red;
        z-index: 1000;
    }

    .print-btn {
        display: block;
        width: 80%;
        margin: 20px auto 0 auto;
        /* Auto centers the button & puts space at bottom */
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 25px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .print-btn:hover {
        background-color: #45a049;
        transform: scale(1.05);
    }

    .print-btn:active {
        transform: scale(0.95);
    }
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="./" class="logo d-flex align-items-center">
                <img src="../<?= $logo?>" alt="">
                <span class="d-none d-lg-block"><?= $companyName?></span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <span class="d-none d-md-block dropdown-toggle ps-2">
                            <?= $role?>
                        </span>
                    </a>
                    <!-- End Profile Image Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= $fullname?></h6>
                            <span><?= $role?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="./?others&type=changePass">
                                <i class="bi bi-brush"></i>
                                <span>Change Password</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#" id="signOut">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

    </header>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav " id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link <?php if(isset($_GET['users']) || isset($_GET['items']) || isset($_GET['refund'])){ echo "collapsed"; }?>"
                    href="./">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="./?items" id="items_in_store" style="display: none;"
                    class="nav-link  <?php if(!isset($_GET['items'])){ echo "collapsed"; } if(isset($_GET['items'])){ echo "active"; }?>">
                    <i class="bi bi-stack"></i><span>Stock Item</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="./?refund" id="refund" style="display: none;"
                    class="nav-link  <?php if(!isset($_GET['refund'])){ echo "collapsed"; } if(isset($_GET['refund'])){ echo "active"; }?>">
                    <i class="bi bi-arrow-counterclockwise"></i><span>Refund</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="./?report" id="report" style="display: none;"
                    class="nav-link  <?php if(!isset($_GET['report'])){ echo "collapsed"; } if(isset($_GET['report'])){ echo "active"; }?>">
                    <i class="bi bi-file-earmark-text"></i><span>Report</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#"
                    class="nav-link alarming <?php if(!isset($_GET['alarming'])){ echo "collapsed"; } if(isset($_GET['alarming'])){ echo "active"; }?>">
                    <i class="bi bi-bell me-2"></i>
                    <span>Alarming Item</span>
                    <span class="right badge bg-danger badge-number ms-auto"><?= $alarm->alarm?></span>
                </a>
            </li>
            <!-- Sales Nav -->
            <li class="nav-item">
                <a href="./?createUser" id="create_user" style="display: none;"
                    class="nav-link  <?php if(!isset($_GET['createUser'])){ echo "collapsed"; } if(isset($_GET['createUser'])){ echo "active"; }?>">
                    <i class="bi bi-person-plus"></i><span>Create User</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="./?permission" id="user_permission" style="display: none;"
                    class="nav-link  <?php if(!isset($_GET['permission'])){ echo "collapsed"; } if(isset($_GET['permission'])){ echo "active"; }?>">
                    <i class="bi bi-person-gear"></i><span>User Permission</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="./?userOnline" id="userOnline" style="display: none;"
                    class="nav-link  <?php if(!isset($_GET['userOnline'])){ echo "collapsed"; } if(isset($_GET['userOnline'])){ echo "active"; }?>">
                    <i class="bi bi-person-lines-fill me-2"></i>
                    <span>Sales Personnel</span>
                    <span class="right badge bg-success badge-number ms-auto" id="pcount">0</span>
                </a>
            </li>
            <!-- users setting Nav -->
            <li class="nav-item">
                <a href="./?changePass" id="changePass"
                    class="nav-link  <?php if(!isset($_GET['changePass'])){ echo "collapsed"; } if(isset($_GET['changePass'])){ echo "active"; }?>">
                    <i class="bi bi-shield-lock"></i><span>Change Password</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="./?lock" id="lock"
                    class="nav-link  <?php if(!isset($_GET['lock'])){ echo "collapsed"; } if(isset($_GET['lock'])){ echo "active"; }?>">
                    <i class="bi bi-lock"></i><span>Lock Screen</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="./?logout" id="lock"
                    class="nav-link signOut <?php if(!isset($_GET['logout'])){ echo "collapsed"; } if(isset($_GET['lock'])){ echo "active"; }?>">
                    <i class="bi bi-door-open"></i><span>Logout</span>
                </a>
            </li>
            <input type="hidden" data-role="<?=$role?>" id="whoo" value="<?=$userName?>">
            <input type="hidden" id="sDate" value="<?=date('Y-m-d')?>;Today" />
            <!-- others setting Nav -->

        </ul>

    </aside>

    <main id="main" class="main">

        <?php 
    if(isset($_GET['items'])) {
      require_once 'sales/items.php';
    } 
    else if(isset($_GET['report'])) {
      require_once 'sales/report.php';
    } 
    else if(isset($_GET['refund'])) {
      require_once 'sales/refund.php';
    } 
    else if(isset($_GET['createUser'])) {
      require_once 'userSettings/createUser.php';
    } 
    else if(isset($_GET['userOnline'])){
      require_once 'userSettings/userOnline.php';
    }
    else if(isset($_GET['permission'])) {
      require_once 'userSettings/permission.php';
    } 
    else if(isset($_GET['changePass'])) {
      require_once 'others/changePass.php';
    } 
    else if(isset($_GET['lock'])) {
      require_once 'others/lock.php';
    } 
    else if(isset($_GET['logout'])) {
      require_once 'logout.php';
    } 
    else {?>
        <!-- SPA-->

        <div class="pagetitle">

            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <input type="hidden" data-role="<?=$role?>" id="who" value="<?=$userName?>">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item salesFilter" id="salesToday" href="#">Today</a></li>
                                <li><a class="dropdown-item salesFilter" id="salesMonth" href="#">This Month</a></li>
                                <li><a class="dropdown-item salesFilter" id="salesYear" href="#">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Sales <span id="saleSpan">| Today</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="saleCount"><?= $saleCount?></h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item revenueFilter" href="#">Today</a></li>
                                <li><a class="dropdown-item revenueFilter" href="#">This Month</a></li>
                                <li><a class="dropdown-item revenueFilter" href="#">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Revenue <span id="revSpan">| Today</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-coin"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>₦ <span id="rev_total"><?=$total_rev?></span></h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Revenue Card -->

                <?php if($role == 'Superadmin' || $role == 'admin'){?>
                <!-- sales graph -->
                <div class="col-md-12">
                    <div class="card text-sm">
                        <div class="card-header">
                            <h5 class="card-title font-weight-bold">Sales (<span id="ctitle">This Month</span>)</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" id="btnRefreshChart">
                                    <i class="fa fa-refresh"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-tool dropdown-toggle" id="daterange-btn">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="card-body">
                            <div class="btn-group text-right pb-3">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="plotLineChart">
                                    Lines
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="plotBarChart">
                                    Bars
                                </button>
                            </div>
                            <div id="lineChart"></div>
                            <div id="barChart"></div>
                        </div>
                    </div>
                </div>
                <!-- END sales graph -->

                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title text-center fw-bold">Recent Sales </h5>
                            <div class="row py-2">
                                <div class="col-2">
                                    <select class="form-select" id="limit">
                                        <option selected value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <p class="small pt-2">Entries Per Page</p>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <div class="input-group">
                                        <input type="text" placeholder="search" class="form-control" id="search"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Search By item name or seller username">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-borderless ">
                                <thead>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Seller</th>
                                    </tr>
                                </thead>
                                <tbody id="todaySales">



                                </tbody>
                            </table>

                            <nav>
                                <ul class="pagination pagination-sm" id="pagination">
                                    <!-- Pagination buttons -->
                                </ul>
                            </nav>

                        </div>

                    </div>
                </div>
                <!-- End Recent Sales -->
                <?php }?>

            </div>

            <?php if($role != 'Superadmin' && $role != 'admin'){?>
            <!-- Make sales section -->
            <div class="row">
                <div class="col-5">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Make Sales</h5>
                            <select id="itemid" class="form-control select2" data-placeholder="Search Item"
                                style="width: 100%;">
                                <option value="0">Select Item</option>
                                <?php foreach($items as $item){?>
                                <option value="<?= $item['id']?>"><?= strtoupper($item['item_name'])?></option>
                                <?php }?>
                            </select>
                            <div class="col-12 col-md-12 pt-3 d-none" id="listing">
                                <div class="form-group bg-light pt-2 pr-3 pl-3 rounded border">
                                    <table class="table table-sm table-borderless w-100 mb-0 pb-0">
                                        <tr>
                                            <td colspan="2" class="border-bottom">
                                                <div class="lblitem h4" id="lblitem"></div>
                                            </td>
                                        </tr>
                                        <tr class="pricing" id="pricing-1">
                                            <td nowrap="nowrap" width="50%" class="text-right pr-md-4 pb-3">
                                                <div class="text-left">
                                                    <label class="font-weight-bold h6">AMOUNT (<span
                                                            class="font-18">&#8358;</span>)</label>
                                                    <input type="text" id="price"
                                                        class="form-control form-control-lg font-24 rounded-0 text-right disabled"
                                                        placeholder="0.00">
                                                </div>
                                                <input type="hidden" name="" id="cost_price_of_item">
                                                <input type="hidden" name="" id="category_of_item">
                                                <input type="hidden" name="" id="maxQty">
                                            </td>
                                            <td class="text-right pl-md-4 pb-3" width="50%" nowrap="nowrap">
                                                <div class="text-right">
                                                    <label for="iqty" class="font-weight-bold h6">QTY</label>
                                                    <input type="number" id="iqty"
                                                        class="form-control form-control-lg font-24 rounded-0 text-right"
                                                        min="1" value="1" placeholder="1">
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" class="border-top">
                                                <div class="form-group pt-2 pb-0 align-items-center">
                                                    <div class="instock font-16">
                                                        <strong>In-stock: </strong><i id="instock"></i>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="itemtype" value="">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="pt-3 col-12 col-md-12 text-right">
                                <button type="button" id="btnAddItem"
                                    class="btn btn-primary w-100 h-45 rounded-0 disabled">
                                    Add to <i class="bi bi-cart"> Cart</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-7">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-cart"> Cart</i> </h5>
                            <div class="card-body cart h-300 overflow-auto">
                                <table class="table table-sm table-striped" id="table-cart">
                                    <tr id="table-cart-th">
                                        <th class="font-weight-bold">ITEM(S)</th>
                                        <th width="10%" class="font-weight-bold">RATE</th>
                                        <th width="7%" class="font-weight-bold">QTY</th>
                                        <th width="15%" class="font-weight-bold">AMOUNT</th>
                                        <th width="7%" class="font-weight-bold">ACTION</th>
                                    </tr>
                                </table>
                            </div>
                            <div class="card-footer text-left border-top">
                                <div class="row">
                                    <div class="col-12 col-md-6 text-left order-md-last">
                                        <label>TOTAL: </label>
                                        <input type="text" id="total" value="0.00"
                                            class="form-control h-45 rounded-0 text-right font-weight-bold bg-info pt-0 pb-0"
                                            readonly="readonly" style="font-size: 36px;">
                                    </div>
                                </div>
                                <!-- Selecting payment method -->
                                <div class="row mt-4 p-2 bg-white" id="scan-customer">
                                    <div class="col-12 col-md-12 bg-white p-0">
                                        <label>SELECT PAYMENT METHOD</label>
                                        <div class="input-group">
                                            <select id="payType" class="form-control"
                                                data-placeholder="Select Payment Method" style="width: 100%;">
                                                <option value="0" selected>Select Method</option>
                                                <?php foreach($payment_methods as $pay){?>
                                                <option value="<?= $pay['method']?>"><?= strtoupper($pay['method'])?>
                                                </option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <input type="hidden" name="seller" id="seller" value="<?=$userName?>">
                                <input type="hidden" name="sellerCate" id="sellerCate" value="<?=$userCate?>">
                                <!-- Buyers name -->
                                <div class="row mt-4 p-2 bg-white" id="scan-customer">
                                    <div class="col-12 col-md-12 bg-white p-0">
                                        <label>ENTER BUYER'S NAME</label>
                                        <div class="input-group py-2">
                                            <input type="text" name="custName" id="custName"
                                                class="form-control h-45 rounded-0"
                                                placeholder="Type Customers Name here...">
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary h-45 rounded-0 disabled"
                                                    id="btnPayment">
                                                    PROCEED TO PAYMENT <i class="bi bi-credit-card"></i>
                                                </button>
                                            </span>
                                        </div>
                                        <input class="form-check-input chkPrint" type="checkbox" checked name="hidID">
                                        <p class="fw-bold">Print Receipt</p>
                                    </div>
                                </div>
                                <!--  -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--END Make sales section -->
            <?php } ?>

            <!-- Receipt section -->
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title text-center"><strong><i>List of unprinted sales
                                            receipt</i></strong></h5>

                                <div class="row py-2">
                                    <div class="col-2">
                                        <select class="form-select" id="limit2">
                                            <option selected value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <p class="small pt-2">Entries Per Page</p>
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <input type="text" placeholder="search" class="form-control" id="search2"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Search By trx_id or seller username">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Customer Name</th>
                                            <th scope="col">Trx_id</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="unprinted">

                                    </tbody>
                                </table>

                                <nav>
                                    <ul class="pagination pagination-sm" id="pagination2">
                                        <!-- Pagination buttons -->
                                    </ul>
                                </nav>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--END Receipt section -->

            <div id="printModal" class="modal d-none">
                <div class="modal-content py-1">
                    <span class="close-btn">&times;</span>
                    <iframe id="printFrame" src="" frameborder="0"></iframe>
                    <button class="print-btn">Print</button>
                </div>
            </div>

        </section>
        <!-- SPA -->
        <?php }?>

    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span><?= $companyName?></span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="#">Jisnaay Tech</a>
        </div>
    </footer>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>

    <!-- Bootstrap 5 -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.min.js"></script>
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/jquery-confirm.min.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>
    <script src="../assets/js/toastr.min.js"></script>
    <!-- date-range-picker -->
    <script src="../assets/js/moment.min.js"></script>
    <script src="../assets/js/jquery.inputmask.bundle.min.js"></script>
    <script src="../assets/js/daterangepicker.js"></script>
    <script src="../assets/js/select2.full.min.js"></script>
    <!-- Template Main JS File -->
    <script src="../assets/js/main.js">
    </script>
    <!-- <script>
    document.addEventListener("DOMContentLoaded", () => {
      
    });
  </script> -->
    <script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();

        $('.signOut').click(function() {
            let newUrl = './?logout';
            window.history.replaceState({}, '', newUrl);
        })

        function viewOnline() {
            var role = $('#whoo').attr('data-role');
            var ssdatee = $('#sDate').val();
            if (role == 'Superadmin' || role == 'admin') {
                $.ajax({
                    url: '../user/userSettings/userOnline_db.php',
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    data: {
                        "ssdatee": ssdatee,
                        'type': 'viewOnline'
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#pcount').text(response.number);
                        }
                    },
                    error: function(err) {
                        console.log(err)
                    }
                })
            }
        }
        setInterval(viewOnline, 3000);

        // //////
        function updPermit() {
            var role = $('#whoo').attr('data-role');
            $.ajax({
                url: 'index_db.php',
                type: 'POST',
                data: {
                    "role": role,
                    "type": "updatePermit"
                },
                dataType: 'json',
                success: function(response) {
                    if (response.items_in_store == 1) {
                        $('#items_in_store').show();
                    } else {
                        $('#items_in_store').hide();
                    }
                    if (response.refund == 1) {
                        $('#refund').show();
                    } else {
                        $('#refund').hide();
                    }
                    if (response.report == 1) {
                        $('#report').show();
                    } else {
                        $('#report').hide();
                    }
                    if (response.create_user == 1) {
                        $('#create_user').show();
                    } else {
                        $('#create_user').hide();
                    }
                    if (response.user_permission == 1) {
                        $('#user_permission').show();
                    } else {
                        $('#user_permission').hide();
                    }
                    if (response.userOnline == 1) {
                        $('#userOnline').show();
                    } else {
                        $('#userOnline').hide();
                    }
                }
            });
        }
        ////////
        updPermit();
        setInterval(updPermit, 3000);

        //<!-- Selecting item to add to cart -->
        $('#itemid').change(function() {
            var itemId = $(this).val();
            if (itemId == 0) {
                toastr.error('Please Select an Item');
            } else if (itemId != '') {
                $.ajax({
                    url: 'index_db.php',
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    data: {
                        'item_id': itemId,
                        'type': 'getItem'
                    },
                    success: function(data) {
                        if (data.left > 0) {
                            $("#lblitem").text(data.item_name);
                            $("#price").val(data.price);
                            $("#cost_price_of_item").val(data.cost_price);
                            $('#category_of_item').val(data.category)
                            $("#instock").text(data.left + ' left');
                            $("#iqty").attr('max', data.left);
                            $('#maxQty').val(data.left);
                            $("#itemtype").val(data.id);
                            $("#listing").removeClass('d-none');
                            $('#btnAddItem').removeClass('disabled');
                        } else {
                            // console.log(data)
                            toastr.warning("The selected item is out of stock");
                            $("#iqty").val('1');
                            $("#listing").addClass('d-none');
                            $('#btnAddItem').addClass('disabled');
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                })
            }
        })
        //<!--END Selecting item to add to cart -->

        // <!--adding item to cart -->
        $('#btnAddItem').click(function() {
            var total = $("#total").val();
            var iName = $("#lblitem").text();
            var icost_price = $("#cost_price_of_item").val();
            var iCategory = $("#category_of_item").val();
            var iprice = $("#price").val();
            var iqty = parseInt($("#iqty").val());
            var maxQty = parseInt($('#maxQty').val());
            var tot = parseFloat(iprice * iqty);
            var value = tot.toLocaleString(undefined);
            var iID = $("#itemtype").val();
            // console.log(maxQty+'  '+iqty)
            if (iqty > maxQty) {
                toastr.error('The selected quantity ' + iqty + ' is more than the stock ' + maxQty +
                    ' available');
            } else {
                var html = `<tr class="addeditem" data-amt="${tot}">
              <input type="hidden" class="itemdetails" 
              name="itemdetails" value="${iID}/${tot}/${iName}/${iprice}/${iqty}/${icost_price}/${iCategory}">
              <td>${iName}</td><td>${iprice}</td><td>${iqty}</td><td>${value}</td>
              <td class="remItem text-danger"><a><i class="bi bi-x-lg"></i></a></td>
              </tr>`;
                var newTot = parseFloat(total) + parseFloat(tot);
                $("#total").val(newTot);
                $(html).insertAfter('tr#table-cart-th');
                $("#iqty").val('1');
                $("#listing").addClass('d-none');
            }

        })
        // <!--END adding item to cart -->

        // <!-- removing item from cart -->
        $("#table-cart").on('click', '.remItem', function() {
            var cost = $(this).parent().attr('data-amt');
            var total = $("#total").val();
            var newCost = total - cost;
            $("#total").val(newCost);
            $(this).parent().remove();
            // console.log(cost);
        })
        // <!--END removing item from cart -->


        // <!-- putting customer name -->
        $("#custName").keyup(function(e) {
            lent = e.target.value.length;
            var payType = $('#payType').val();
            if (lent > 2 && payType != 0) {
                $("#btnPayment").removeClass("disabled");
            } else {
                $("#btnPayment").addClass("disabled");
            }
        });
        // <!-- putting customer name -->

        // <!-- processing payment -->
        $("#btnPayment").click(function() {
            itemNo = $("#table-cart").find(".addeditem").length;
            var payType = $('#payType').val();
            var seller = $('#seller').val();
            var sellerCate = $('#sellerCate').val();
            var chkPrint = $('.chkPrint:checkbox:checked').length;
            // console.log(chkPrint)
            if (itemNo == 0) {
                toastr.warning("No items in cart");
            } else if (payType == 0) {
                toastr.warning("Please select a pay method");
            } else {
                itemss = $("#table-cart").find(".itemdetails").serializeArray();
                var total = $("#total").val();
                var value = total.toLocaleString(undefined);
                var cname = $("#custName").val();
                $.confirm({
                    title: 'Confirm Sales of &#8358;' + value,
                    theme: 'supervan',
                    animation: 'scale',
                    type: 'orange',
                    autoClose: 'cancelAction|10000',
                    escapeKey: 'cancelAction',
                    buttons: {
                        confirm: {
                            text: 'Confirm',
                            btnClass: 'btn-green',
                            action: function() {
                                $.ajax({
                                    url: 'index_db.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    cache: false,
                                    data: {
                                        'itemss': itemss,
                                        "sellerCate": sellerCate,
                                        "seller": seller,
                                        'total': total,
                                        "payType": payType,
                                        'cname': cname,
                                        'type': 'submitSale'
                                    },
                                    success: function(data) {
                                        if (data.status == 'succeeded') {
                                            if (chkPrint == 1) {
                                                // console.log('Print receipt')
                                                var iframeSrc =
                                                    'receipt.php?trx_id=' + data
                                                    .trx_id + '&cname=' +
                                                    cname; // Append GET variable
                                                $('#printFrame').attr('src',
                                                    iframeSrc
                                                    ); // Set iframe src dynamically
                                                $('#printModal').removeClass(
                                                    'd-none');
                                                $('#printModal').fadeIn();

                                                // resetting the payment
                                                $("#table-cart").find(
                                                    ".addeditem").remove();
                                                $("#total").val('0.00');
                                                $('#payType').val('0');
                                                $("#custName").val('');
                                                // resetting the payment
                                            } else if (chkPrint == 0) {
                                                $.ajax({
                                                    url: 'index_db.php',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    cache: false,
                                                    data: {
                                                        'trx_id': data
                                                            .trx_id,
                                                        'cname': cname,
                                                        "seller": seller,
                                                        'type': 'submitUnprinted'
                                                    },
                                                    success: function(
                                                        data) {
                                                        toastr
                                                            .success(
                                                                "Sales Completed"
                                                                );
                                                        setTimeout(
                                                            function() {
                                                                location
                                                                    .reload(
                                                                        true
                                                                        )
                                                            },
                                                            2000
                                                            );
                                                    },
                                                    error: function(
                                                        data) {
                                                        console.log(
                                                            data
                                                            );
                                                    }
                                                })
                                            }
                                        } else {
                                            toastr.success(data.msg);
                                        }
                                    },
                                    error: function(data) {
                                        console.log(data);
                                    }
                                })
                            }
                        },
                        cancelAction: {
                            btnClass: 'btn btn-red',
                            text: 'Close',
                            action: function() {

                            }
                        }
                    }
                });
            }
        })
        // <!-- processing payment -->

        // <!-- unprinted receipt -->
        // <!-- getting unprinted receipt  -->
        function loadData2(page = 1, search = '') {
            const limit = $('#limit2').val();
            var who = $('#who').val();
            var role = $('#who').attr('data-role');
            $.ajax({
                url: 'index_db.php',
                type: 'POST',
                data: {
                    "page2": page,
                    "limit2": limit,
                    "search2": search,
                    "who": who,
                    "role": role,
                    "type": "paginateReceipt"
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response)
                    $('#unprinted').html(response.html);
                    let pagination = '';
                    // Previous Button
                    pagination += `<li class="page-item ${response.currentPage == 1 ? 'disabled' : ''}">
                              <a class="page-link" href="#" data-page="${response.currentPage - 1}">&laquo;</a>
                            </li>`;
                    // Pages
                    for (let i = 1; i <= response.totalPages; i++) {
                        pagination += `<li class="page-item ${response.currentPage == i ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                              </li>`;
                    }
                    // Next Button
                    pagination += `<li class="page-item ${response.currentPage == response.totalPages ? 'disabled' : ''}">
                              <a class="page-link" href="#" data-page="${response.currentPage + 1}">&raquo;</a>
                            </li>`;
                    $('#pagination2').html(pagination);
                }
            });
        }
        // Initial load
        loadData2();
        // <!-- Pagination Click Event  -->
        $('#pagination2').on('click', '.page-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            const search = $('#search2').val();
            if (page) {
                loadData2(page, search);
            }
        });
        // <!-- END Pagination Click Event  -->

        // <!-- Search Keyup Event (debounced)  -->
        let typingTimer2;
        $('#search2').on('keyup', function() {
            clearTimeout(typingTimer2);
            typingTimer2 = setTimeout(function() {
                loadData2(1, $('#search2').val());
            }, 500); // delay to avoid too many requests
        });
        // <!--END Search Keyup Event (debounced)  -->

        // <!-- 3 seconds calling  -->
        setInterval(() => {
            var activePge = parseInt($('#pagination2 li.active .page-link').text());
            if (isNaN(activePge)) {
                activePge = 1;
            }
            // console.log(activePge)
            var serch = $('#search2').val()
            loadData2(activePge, serch);
        }, 3000);
        // <!-- 3 seconds calling  -->


        // <!-- opening the modal -->
        $("#unprinted").on("click", '.openPrint', function() {
            var trx_id = $(this).data("trx_id");
            var cname = $(this).data("cname");
            var iframeSrc = 'receipt.php?trx_id=' + trx_id + '&cname=' + cname; // Append GET variable
            $('#printFrame').attr('src', iframeSrc); // Set iframe src dynamically
            $('#printModal').removeClass('d-none');
            $('#printModal').fadeIn();
        });
        // Close Modal
        $('.close-btn').click(function() {
            $('#printModal').fadeOut();
        });

        // Print Iframe Content
        $('.print-btn').click(function() {
            var iframe = $('#printFrame')[0];
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        });
        // <!--END opening the modal -->


        // <!-- END unprinted receipt -->

        <?php if($role == 'Superadmin' || $role == 'admin'){?>
        // <!-- getting sales  -->
        function loadData(page = 1, search = '') {
            const limit = $('#limit').val();
            $.ajax({
                url: 'index_db.php',
                type: 'POST',
                data: {
                    "page": page,
                    "limit": limit,
                    "search": search,
                    "type": "paginateSales"
                },
                dataType: 'json',
                success: function(response) {
                    $('#todaySales').html(response.html);
                    let pagination = '';
                    // Previous Button
                    pagination += `<li class="page-item ${response.currentPage == 1 ? 'disabled' : ''}">
                                <a class="page-link" href="#" data-page="${response.currentPage - 1}">&laquo;</a>
                              </li>`;
                    // Pages
                    for (let i = 1; i <= response.totalPages; i++) {
                        pagination += `<li class="page-item ${response.currentPage == i ? 'active' : ''}">
                                  <a class="page-link" href="#" data-page="${i}">${i}</a>
                                </li>`;
                    }
                    // Next Button
                    pagination += `<li class="page-item ${response.currentPage == response.totalPages ? 'disabled' : ''}">
                                <a class="page-link" href="#" data-page="${response.currentPage + 1}">&raquo;</a>
                              </li>`;
                    $('#pagination').html(pagination);
                }
            });
        }
        // Initial load
        loadData();

        // <!-- Pagination Click Event  -->
        $('#pagination').on('click', '.page-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            const search = $('#search').val();
            if (page) {
                loadData(page, search);
            }
        });
        // <!-- END Pagination Click Event  -->

        // <!-- Search Keyup Event (debounced)  -->
        let typingTimer;
        $('#search').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                loadData(1, $('#search').val());
            }, 500); // delay to avoid too many requests
        });
        // <!--END Search Keyup Event (debounced)  -->

        // <!-- 3 seconds calling  -->
        setInterval(() => {
            var activePge = parseInt($('#pagination li.active .page-link').text());
            if (isNaN(activePge)) {
                activePge = 1;
            }
            var serch = $('#search').val()
            loadData(activePge, serch);
        }, 3000);
        // <!-- END 3 seconds calling  -->

        // <!-- END getting sales  -->

        <?php if(!isset($_GET['report']) && !isset($_GET['createUser']) && !isset($_GET['refund']) && !isset($_GET['items']) && !isset($_GET['userOnline']) && !isset($_GET['permission']) && !isset($_GET['changePass']) && !isset($_GET['lock'])){?>
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                startDate: moment().startOf('month'),
                endDate: moment().endOf('month')
            },
            function(start, end, ranges) {
                if (ranges === 'Today' || ranges === 'Yesterday') {
                    $('#sDate').val(start.format('YYYY-MM-DD') + ';' + ranges);
                } else {
                    $('#sDate').val(start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD') + ';' +
                        ranges);
                }

                // plotLineChart();
                setTimeout(function() {
                    plotLineChart();
                }, 100);

            }
        );

        // Declare chart variable globally
        var lineChartInstance = null;
        var barChartInstance = null;

        function plotLineChart() {
            $('#barChart').addClass('d-none');
            $('#lineChart').removeClass('d-none');
            var sDate = $('#sDate').val();
            var chart = 'Line';
            $.ajax({
                url: 'index_db.php',
                type: 'POST',
                data: {
                    "sDate": sDate,
                    "chart": chart,
                    "type": "plotChart"
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success == 'false') {
                        toastr.error(response.error);
                    } else {
                        $('#ctitle').text(response.title);
                        // Check if chart already exists
                        if (lineChartInstance !== null) {
                            lineChartInstance.destroy();
                        }
                        // Create a new chart instance
                        lineChartInstance = new ApexCharts(document.querySelector("#lineChart"), {
                            series: [{
                                name: "Sales",
                                data: response.data
                            }],
                            chart: {
                                height: 350,
                                type: 'line',
                                zoom: {
                                    enabled: false
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                curve: 'straight'
                            },
                            grid: {
                                row: {
                                    colors: ['#f3f3f3', 'transparent'],
                                    opacity: 0.5
                                }
                            },
                            xaxis: {
                                categories: response.sales
                            }
                        });
                        // Render the chart
                        lineChartInstance.render();
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        function plotBarChart() {
            $('#lineChart').addClass('d-none');
            $('#barChart').removeClass('d-none');
            var sDate = $('#sDate').val();
            var chart = 'Bar';
            $.ajax({
                url: 'index_db.php',
                type: 'POST',
                data: {
                    "sDate": sDate,
                    "chart": chart,
                    "type": "plotChart"
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success == 'false') {
                        toastr.error(response.error)
                    } else {
                        $('#ctitle').text(response.title);
                        // Check if chart already exists
                        if (barChartInstance !== null) {
                            barChartInstance.destroy();
                        }
                        barChartInstance = new ApexCharts(document.querySelector("#barChart"), {
                            series: [{
                                data: response.data
                            }],
                            chart: {
                                type: 'bar',
                                height: 350
                            },
                            plotOptions: {
                                bar: {
                                    borderRadius: 3,
                                    horizontal: true,
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            xaxis: {
                                categories: response.sales,
                            }
                        });

                        barChartInstance.render();
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }

        $('#plotLineChart').click(function() {
            plotLineChart();
        });

        $('#plotBarChart').click(function() {
            plotBarChart();
        })


        plotLineChart();
        //Date range as a button
        <?php }?>
        <?php }?>

        // <!-- Sales and revenue filter -->
        function filterShw(filter, filterType, filterupdate, spanFilter) {
            var who = $('#who').val();
            var role = $('#who').attr('data-role');
            // console.log(who+' -- '+role)
            $.ajax({
                url: 'index_db.php',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    "who": who,
                    "role": role,
                    "filter": filter,
                    "filterType": filterType,
                    "type": "showFilter"
                },
                success: function(response) {
                    filterupdate.text(response.total);
                    spanFilter.text(' | ' + filter);
                },
                error: function(err) {
                    console.log(err)
                }
            })
        }
        $('.salesFilter').click(function() {
            var filter = $(this).text();
            var filterTyp = 'sales';
            var filterupd = $('#saleCount');
            var saleSpan = $('#saleSpan');
            filterShw(filter, filterTyp, filterupd, saleSpan);
        })

        $('.revenueFilter').click(function() {
            var filter = $(this).text();
            var filterTyp = 'revenue';
            var filterupd = $('#rev_total');
            var revSpan = $('#revSpan');
            filterShw(filter, filterTyp, filterupd, revSpan);
        })
        // <!--END Sales and revenue filter -->
        $('.alarming').click(function() {
            window.open('sales/alarming-items.php', 'Alarming Items', 'width=500;height=500');
        });

    })
    </script>
</body>

</html>