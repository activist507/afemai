<?php


    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    include('../admin/config/db_connect.php');
    if(!isset($_SESSION['authentication']))
    {
        echo "<script>
        window.location = '../'
        </script>";
    }

    if( $_SESSION['authentication'] != 'admin')
    {
        echo "<script>
        window.location = '../'
        </script>";
    }
    if(isset($_SESSION['id'])){
        $id = $_SESSION['id'];
        $staff_records =  $conn->query("SELECT * FROM staff_records WHERE ID='$id'");
        $staffDet = $staff_records->fetch_object();
        $name = $staffDet->Fullname;
        $role = $staffDet->role;
		$staff_branch = $staffDet->Branch;
        $staff_class = $staffDet->staff_class;

        //image of staff
        $imageData1 = base64_encode($staffDet->Image);
        $finfo = finfo_open();
        $mimeType2 = finfo_buffer($finfo, $imageData1, FILEINFO_MIME_TYPE);
        finfo_close($finfo);
    }

    $setupsSQL = $conn->query("SELECT * FROM cbt_calendar");
    if($setupsSQL->num_rows > 0){
        $setup = $setupsSQL->fetch_object();
        $id = $setup->id;
        $title = $setup->title;
        $stat = $setup->status;
        $date = $setup->date;
        $linkPdf = '../storege/setup_pdf/'.$setup->homepage_pdf;
    } else {
        $id = 0;
        $title = '';
        $stat = 'No status';
        $date = '2024-10-10';
        $linkPdf = ''; //put the link of the dummy pdf to create
    }
    
	$sqlSession = $conn->query("SELECT * FROM tblsession");
    $sqlTerm = $conn->query("SELECT * FROM cbt_term");
    $sqlbranchdetails = $conn->query("SELECT * FROM current_term WHERE ID = 1");
    $branchdetails = $sqlbranchdetails->fetch_object();
    $gen_term = $branchdetails->Current_Term;
    $gen_branch = $branchdetails-> Branch;
    $gen_session = $branchdetails->Current_Session;
    $gen_ann = $branchdetails->announcement;
    
    $branches = $conn->query("SELECT * FROM branches");
    $branches_rows = $branches->fetch_all(MYSQLI_ASSOC);

    $studentss = $conn->query("SELECT Student_ID,Fullnames,Student_Class,plain_password,Branch,Phone_Number,Amount_Payable,Gen_Discount,Amount_Paid,Current_Balance, new_plain_pass FROM student_records WHERE Current_Status = 'Active' AND Branch ='$gen_branch'");
    $fetchings = $studentss->fetch_all(MYSQLI_ASSOC);
    $stud_total_all = count($fetchings);

    $stafff = $conn->query("SELECT * FROM staff_records WHERE Staff_Status = 'Active'");
    $fetchingss = $stafff->fetch_all();
    $staff_total_all = count($fetchingss);

// staff_class
	$all_class = $conn->query("SELECT class FROM cbt_class")->fetch_all(MYSQLI_ASSOC);
	function totStud(string $class, $conn,$gen_branch): int 
	{
		$tot = $conn->query("SELECT count(Student_ID) AS studTot FROM student_records WHERE Current_Status = 'Active' AND Student_Class = '$class' AND Branch ='$gen_branch'")->fetch_object();
		return intval($tot->studTot);
	}

	function staff_class_student(string $class,$conn,$gen_branch): array
	{
		$tot = $conn->query("SELECT Student_ID,Fullnames,Current_Balance  FROM student_records WHERE Current_Status = 'Active' AND Student_Class = '$class'  AND Branch ='$gen_branch'")->fetch_all(MYSQLI_ASSOC);
		return $tot;
	}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Dashboard</title>
	<meta content="" name="description">
	<meta content="" name="keywords">

	<!-- Favicons -->
	<link href="assets/img/favicon.png" rel="icon">
	<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

	<!-- Google Fonts -->
	<link href="https://fonts.gstatic.com" rel="preconnect">
	<link
		href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
		rel="stylesheet">

	<!-- Vendor CSS Files -->
	<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
	<link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
	<link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
	<link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
	<link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
	<link href="../assets/css/daterangepicker.css" rel="stylesheet">

	<!-- Template Main CSS File -->
	<link href="assets/css/toastr.min.css" rel="stylesheet">
	<link href="assets/css/jquery-confirm.min.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet">

	<script src="assets/js/jquery-3.7.1.min.js"></script>
	<script src="../assets/js/moment.min.js"></script>
	<script src="../assets/js/daterangepicker.js"></script>
	<style>
	.header .search-bar {
		min-width: 200px;
		padding: 0 20px;
	}
	</style>
</head>

<body>

	<!-- ======= Header ======= -->
	<header id="header" class="header fixed-top d-flex align-items-center">

		<div class="d-flex align-items-center justify-content-between">
			<a href="./" class="logo d-flex align-items-center">
				<img src="assets/img/logo.png" alt="">
				<span class="d-none d-lg-block"><?php strtoupper($role)?></span>
			</a>
			<i class="bi bi-list toggle-sidebar-btn"></i>
		</div><!-- End Logo -->

		<div class="search-bar">
			<form class="search-form d-flex align-items-center" method="POST" action="#">
				<input type="text" name="query" placeholder="Search" title="Enter search keyword">
				<button type="submit" title="Search"><i class="bi bi-search"></i></button>
			</form>
		</div>
		<!-- End Search Bar -->

		<div class="search-bar">
			<select name="gen_Term" id="gen_Term" class="form-control">
				<option value="<?= $gen_term?>"><?= $gen_term?></option>
				<?php while($term = $sqlTerm->fetch_object()){?>
				<option value="<?= $term->term?>"><?= $term->term?>
				</option>
				<?php }?>
			</select>
		</div>

		<div class="search-bar">
			<select name="gen_branch" id="gen_branch" class="form-control">
				<option value="<?= $gen_branch?>"><?= $gen_branch?></option>
				<?php foreach($branches_rows as $branc){?>
				<option value="<?= $branc['Branch_Name']?>"><?= $branc['Branch_Name']?></option>
				<?php }?>
			</select>
		</div>

		<div class="search-bar">
			<select name="gen_Session" id="gen_Session" class="form-control">
				<option value="<?= $gen_session?>"><?= $gen_session?></option>
				<?php while($session = $sqlSession->fetch_object()){?>
				<option value="<?= $session->csession?>">
					<?= $session->csession?></option>
				<?php }?>
			</select>
		</div>


		<nav class="header-nav ms-auto">
			<ul class="d-flex align-items-center">

				<li class="nav-item d-block d-lg-none">
					<a class="nav-link nav-icon search-bar-toggle " href="#">
						<i class="bi bi-search"></i>
					</a>
				</li>
				<!-- End Search Icon-->

				<li class="nav-item dropdown pe-3">

					<a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
						<img src="data:<?php echo $mimeType2; ?>;base64,<?php echo $imageData1; ?>"
							class="rounded-circle" alt="" />
						<span class="d-none d-md-block dropdown-toggle ps-2"><?= $name?></span>
					</a>
					<!-- End Profile Iamge Icon -->

					<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
						<li class="dropdown-header">
							<h6><?= $name?></h6>
							<span><?= $role?></span>
						</li>
						<li>
							<hr class="dropdown-divider">
						</li>

						<li>
							<a class="dropdown-item d-flex align-items-center" href="users-profile.html">
								<i class="bi bi-person"></i>
								<span>My Profile</span>
							</a>
						</li>
						<li>
							<hr class="dropdown-divider">
						</li>

						<li>
							<a class="dropdown-item d-flex align-items-center" href="users-profile.html">
								<i class="bi bi-gear"></i>
								<span>Account Settings</span>
							</a>
						</li>
						<li>
							<hr class="dropdown-divider">
						</li>

						<li>
							<a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
								<i class="bi bi-question-circle"></i>
								<span>Need Help?</span>
							</a>
						</li>
						<li>
							<hr class="dropdown-divider">
						</li>

						<li>
							<a class="dropdown-item d-flex align-items-center" href="#">
								<i class="bi bi-box-arrow-right"></i>
								<span>Sign Out</span>
							</a>
						</li>

					</ul><!-- End Profile Dropdown Items -->
				</li><!-- End Profile Nav -->

			</ul>
		</nav>
		<!-- End Icons Navigation -->

	</header>
	<!-- End Header -->

	<!-- 1- Sidebar admin addressbar links -->
	<aside id="sidebar" class="sidebar">

		<ul class="sidebar-nav" id="sidebar-nav">

			<li class="nav-item">
				<a class="nav-link " href="./">
					<i class="bi bi-grid"></i>
					<span>Dashboard</span>
				</a>
			</li>
			<!-- End Dashboard Nav -->

			<li class="nav-item">
				<a class="nav-link collapsed" href="./?res_set">
					<i class="bi bi-person-check"></i>
					<span>Result Settings</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link collapsed" href="./?markRegister">
					<i class="bi bi-person-check"></i>
					<span>Mark Register</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link collapsed" href="./?checkRegister">
					<i class="bi bi-eye"></i>
					<span>Check Register</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link collapsed" href="./?res_set_memo">
					<i class="bi bi-pencil-square"></i>
					<span>Memorization Result Settings</span>
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link collapsed" href="./?Debtors">
					<i class="bi bi-bar-chart-line"></i>
					<span>Fees Payment</span>
				</a>
			</li>
			<!-- Statistics -->


			<li class="nav-item">
				<a class="nav-link collapsed" href="./?logout">
					<i class="bi bi-file-earmark"></i>
					<span>Logout</span>
				</a>
			</li>
			<!-- End Blank Page Nav -->
		</ul>

	</aside>
	<!-- End Sidebar-->

	<!-- 2- admin php file links -->
	<?php 
    if(isset($_GET['l_videos']))
    {
        require_once 'videos_books/library_vidoes.php';
    } 
    elseif(isset($_GET['markRegister'])){
        require_once 'markRegister.php';
    }
	elseif(isset($_GET['checkRegister'])){
        require_once 'checkRegister.php';
    }
    elseif(isset($_GET['Debtors'])){
        require_once 'Debtors.php';
    }
    elseif(isset($_GET['all_students'])){
        require_once 'adm_student/allStudents.php';
    }
    elseif(isset($_GET['a_student'])){
        require_once 'adm_student/act_students.php';
    }
	elseif(isset($_GET['a_staff'])){
        require_once 'adm_staff/act_staff.php';
    }
    
    elseif(isset($_GET['stud_sch_fees'])){
        require_once 'adm_student/stud_sch_fees.php';
    }

	elseif(isset($_GET['res_set_memo'])){
        require_once '../admin/manage_result_memo/result_settings.php';
    }
	elseif(isset($_GET['ent_res_memo'])){
        require_once '../admin/manage_result_memo/enter_result.php';
    }
    elseif(isset($_GET['dis_res_memo'])){
        require_once '../admin/manage_result_memo/display_result.php';
    }
    
    elseif(isset($_GET['staff_reg'])){
        require_once 'adm_staff/staff_reg.php';
    }
    elseif(isset($_GET['stud_reg'])){
        require_once 'adm_student/student_reg.php';
    }
    elseif(isset($_GET['set_question'])){
        require_once 'set_question/question.php';
    }
    elseif(isset($_GET['set_exam_code'])){
        require_once 'set_question/question_code.php';
    }
    elseif(isset($_GET['result_page'])){
        require_once 'set_question/result_page.php';
    }
    elseif(isset($_GET['curr_term'])){
        require_once 'settings/current_term.php';
    }
    elseif(isset($_GET['bull_sett'])){
        require_once 'settings/bulletin.php';
    } 
    elseif(isset($_GET['user_settings'])){
        require_once 'settings/user_settings.php';
    } 
    elseif(isset($_GET['sch_calendar'])){
        require_once 'settings/sch_calender.php';
    } 
    elseif(isset($_GET['logout'])){
        require_once 'logout.php';
    }

    elseif(isset($_GET['codes'])){
        require_once 'code.php';
    }

    elseif(isset($_GET['l_books'])){
        require_once 'videos_books/library_books.php';
    }
    elseif(isset($_GET['l_videos'])){
        require_once 'videos_books/library_vidoes.php';
    }

    elseif(isset($_GET['c_videos'])){
        require_once 'videos_books/class_vidoes.php';
    }
    elseif(isset($_GET['c_books'])){
        require_once 'videos_books/class_books.php';
    }
    elseif(isset($_GET['c_vid_bk'])){
        require_once 'videos_books/class_vid_bk.php';
    }
    elseif(isset($_GET['c_notes'])){
        require_once 'videos_books/class_notes.php';
    }
    elseif(isset($_GET['sms'])){
        require_once 'sms/sms.php';
    }

	elseif(isset($_GET['res_set'])){
        require_once '../admin/manage_result/result_settings.php';
    }
    elseif(isset($_GET['ent_res'])){
        require_once '../admin/manage_result/enter_result.php';
    }
	elseif(isset($_GET['dis_res'])){
        require_once '../admin/manage_result/display_result.php';
    }
  
    else 
    {

?>
	<main id="main" class="main">
		<section class="section">
			<div class="row">
				<div class="col-lg-12 justify-content-center">
					<div class="row">

						<div class="col-12">
							<div class="card info-card sales-card">

								<div class="card-body">
									<div class="d-flex align-items-center">
										<table class="table table-bordered">
											<?php foreach($all_class as $class):?>
												<tr>
													<td><strong><?= $class['class']?></strong></td>
													<td class="text-center"><?php echo totStud($class['class'], $conn,$gen_branch)?></td>
												</tr>
											<?php endforeach; ?>
										</table>
									</div>
								</div>

							</div>
						</div>

						<!-- offenses Card -->
						<div class="col-12">
							<div class="card info-card sales-card">

								<div class="card-body">
									<h5 class="card-title">Penalties <span>| This Month</span></h5>

									<div class="row" id="sign_det">
										<div class="col-6" id="late_tbl">LATENESS</div>
										<div class="col-6" id="absent_tbl">ABSENTEEISM</div>

										<div class="col-12" id="total_html">
											<div class="d-flex justify-content-between border rounded container"
												style="background:rgb(5, 20, 233);">
												<p class="text-white fw-bold pt-2">Total :</p>
												<p class="text-white fw-bold pt-2">0</p>
											</div>
										</div>
									</div>

								</div>

							</div>
						</div>
						<!-- End offenses Card -->

					</div>
				</div>
			</div>
		</section>
	</main>
	<!-- End #main -->
	<?php     }?>

	<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
			class="bi bi-arrow-up-short"></i></a>

	<!-- Vendor JS Files -->
	<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/chart.js/chart.umd.js"></script>
	<script src="assets/vendor/echarts/echarts.min.js"></script>
	<script src="assets/vendor/quill/quill.min.js"></script>
	<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
	<script src="assets/vendor/tinymce/tinymce.min.js"></script>
	<script src="assets/vendor/php-email-form/validate.js"></script>
	<script src="assets/vendor/php-email-form/validate.js"></script>
	<script src="assets/js/toastr.min.js"></script>
	<script src="assets/js/jquery-confirm.min.js"></script>


	<!-- Template Main JS File -->
	<script src="assets/js/main.js"></script>

	<!-- using jQuery -->
	<script type="text/javascript">
	$(document).ready(function() {})
	</script>

</body>

</html>