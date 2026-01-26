<?php 
  include('admin/config/db_connect.php');
  $pres = 1; 
  if(isset($_GET['dateTop']) && isset($_GET['att_branch'])){
	$dateTop = $_GET['dateTop'];
	$attBranch = $_GET['att_branch'];
	$dExp = explode("-",$dateTop);
  	$monthStart = date('Y-'.$dExp[1].'-01');
  	$monthEnd = date('Y-'.$dExp[1].'-31');
  } else {
	$dateTop = date('Y-m-d');
	$attBranch = 'Hira Iyakpi';
	$monthStart = date('Y-m-01');
  	$monthEnd = date('Y-m-31');
  }
	function staff_list($conn,$gen_branch): array {
		$tot = $conn->query("SELECT Staff_ID,Fullname  FROM staff_records WHERE Staff_Status = 'Active' AND Branch ='$gen_branch'")->fetch_all(MYSQLI_ASSOC);
		return $tot;
	}
	$branches = $conn->query("SELECT * FROM branches");
    $branches_rows = $branches->fetch_all(MYSQLI_ASSOC);

  
  $all_staff = staff_list($conn,$attBranch);
  $tot_todayAtt = $conn->query("SELECT staffID FROM attendance_staff WHERE branch ='$attBranch' AND date='$dateTop' AND status=1");
  $todayAtt = array_column($tot_todayAtt->fetch_all(MYSQLI_ASSOC), 'staffID');
  $todayAttCount = count($todayAtt);

  $tot_todayAtt2 = $conn->query("SELECT staffID FROM attendance_staff WHERE branch ='$attBranch' AND date='$dateTop' AND status_abs=1");
  $todayAtt2 = array_column($tot_todayAtt2->fetch_all(MYSQLI_ASSOC), 'staffID');
  $todayAttCount2 = count($todayAtt2);


  function countPres($conn,$staf_id,$start,$end):int
  {
	$cnt = $conn->query("SELECT SUM(status) AS total FROM attendance_staff WHERE staffID ='$staf_id' AND date >= '$start' AND date <= '$end'")->fetch_object();
	$total = intVal($cnt->total);
	return $total;
  }

  function countPresAbs($conn,$staf_id,$start,$end):int
  {
	$cnt = $conn->query("SELECT SUM(status_abs) AS total FROM attendance_staff WHERE staffID ='$staf_id' AND date >= '$start' AND date <= '$end'")->fetch_object();
	$total = intVal($cnt->total);
	return $total;
  }
  
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Attendance</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- ======= Header ======= -->
    <?php  include('header.php')?>
    <!-- End Header -->
    <main id="main" class="main pt-4">
        <section class="section dashboard">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="GET">
                            <div class="row pt-3 pb-2">

                                <div class="col-sm-12 col-lg-3">
                                    <h5 class="card-title text-center">Present / Abscorned</h5>
                                </div>
                                <div class="col-sm-12 col-lg-3 pt-2">
                                    <input type="hidden" name="staff_register" value="">
                                    <div class="search-bar">
                                        <input type="date" name="dateTop" id="dateTop" class="form-control"
                                            value="<?= $dateTop?>">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-3 pt-2">
                                    <div class="search-bar">
                                        <select name="att_branch" id="att_branch" class="form-select">
                                            <option value="<?= $attBranch?>"><?= $attBranch?></option>
                                            <?php foreach($branches_rows as $branc){?>
                                            <option value="<?= $branc['Branch_Name']?>"><?= $branc['Branch_Name']?>
                                            </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-3 pt-2">
                                    <button type="submit" style="width: 8.7rem;"
                                        class="btn btn-primary w-100">Proceed</button>
                                </div>

                            </div>
                        </form>

                        <form class="row g-3 clRegForm">

                            <input type="hidden" name="clas_branch" id="class_branch" value="<?= $attBranch?>">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="">Names of Staff</th>
                                        <th scope="col" class="text-center">M</th>
                                        <th scope="col" class="text-center">A</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($all_staff as $stf):?>
                                    <tr>
                                        <th scope="row" class="text-center"><?= $stf['Staff_ID']?></th>
                                        <td class="text-uppercase"><?= $stf['Fullname']?></td>
                                        <td class="text-center">
                                            <p><?= countPres($conn,$stf['Staff_ID'],$monthStart,$monthEnd);?></p>
                                        </td>
                                        <td class="text-center">
                                            <p><?= countPresAbs($conn,$stf['Staff_ID'],$monthStart,$monthEnd);?></p>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </form>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>IDEA-CBT</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                Designed by <a href="#"><strong>IDEA CODE SOLUTION</strong></a>
                <br /><a href="#"><strong>Call: +2348036398734</strong></a>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>