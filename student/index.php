 <?php 
    include('../admin/config/db_connect.php');

    // section validation
    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    if(!isset($_SESSION['authentication']))
    {
        echo "<script>
        window.location = '../'
        </script>";
    }

    if($_SESSION['authentication'] != 'student')
    {
        echo "<script>
        window.location = '../'
        </script>";
    }

    $id = $_SESSION['std_id'];
    $student_records =  $conn->query("SELECT * FROM student_records WHERE Student_ID='$id' ");
    $Student_records = $student_records->fetch_object();
    $Branch = $Student_records->Branch;
    $Student_Class = $Student_records->Student_Class;
    $Student_ID = $Student_records->Student_ID;


    //image of student
    $imageData1 = base64_encode($Student_records->Student_Image);
    $finfo = finfo_open();
    $mimeType2 = finfo_buffer($finfo, $imageData1, FILEINFO_MIME_TYPE);
    finfo_close($finfo);

    // question_codes Table
    $question_codes =  $conn->query("SELECT * FROM question_codes WHERE class='$Student_Class' ");
    $Question_codes = $question_codes->fetch_object();
	if($Question_codes->question_code != ''){
		$Question_code = $Question_codes->question_code;
	} else {
		$Question_code = $Question_codes->theory_code;
	}
    


	//<===============Logic
		$Q2 = $conn->query("SELECT id AS question_id, assessment_type AS question_type, assessment_type AS exam_type,subject_id AS subject,term_id AS term FROM exams WHERE id = '$Question_code'")->fetch_object();
		if (isset($Q2->question_id)) {
			$Questions = $Q2;
		} else {
			$Q1 = $conn->query("SELECT * FROM questions WHERE question_id = '$Question_code'")->fetch_object();
			if ($Q1) {
				$Questions = $Q1;
			} else {
				$Questions = null;
			}
		}
	//<===============Logic


    // branches
    $branches =  $conn->query("SELECT * FROM branches WHERE Branch_Name='$Branch' ");
    $branchesDet = $branches->fetch_object();
?>


 <!DOCTYPE html>
 <html lang="en">

 <head>
 	<meta charset="utf-8">
 	<meta content="width=device-width, initial-scale=1.0" name="viewport">

 	<title>Student-Dashboard</title>
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
 	<link href="../admin/assets/css/jquery-confirm.min.css" rel="stylesheet">

 	<!-- Template Main CSS File -->
 	<link href="assets/css/style.css" rel="stylesheet">

 	<!-- jquery links -->
 	<script src="../admin/assets/js/jquery-3.7.1.min.js"></script>
 	<script src="../admin/assets/js/jquery-confirm.min.js"></script>

 </head>

 <body>

 	<!-- ======= Header ======= -->
 	<header id="header" class="header fixed-top d-flex align-items-center">

 		<div class="d-flex align-items-center justify-content-between">
 			<a href="./" class="logo d-flex align-items-center">
 				<img src="assets/img/logo.png" alt="">
 				<span class="d-none d-lg-block">IDEA-CBT</span>
 			</a>
 			<i class="bi bi-list toggle-sidebar-btn"></i>
 		</div><!-- End Logo -->

 		<nav class="header-nav ms-auto">
 			<ul class="d-flex align-items-center">

 				<li class="nav-item pe-5 align-items-left">
 					<h6 class="mb-0">Obj | ID:<span class="fw-bold"><?= $Question_code?> </span>
 					</h6>
 				</li>

 				<li class="nav-item dropdown pe-3">

 					<a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
 						<img src="data:<?php echo $mimeType2; ?>;base64,<?php echo $imageData1; ?>"
 							class="rounded-circle" alt="" />
 						<span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
 					</a><!-- End Profile Iamge Icon -->

 					<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
 						<li class="dropdown-header">
 							<h6><?= $Student_records->Fullnames?></h6>
 							<span><strong>Current Class: </strong><?= $Student_records->Student_Class?></span>
 						</li>
 						<li>
 							<hr class="dropdown-divider">
 						</li>

 						<li>
 							<a class="dropdown-item d-flex align-items-center" href="#">
 								<i class="bi bi-person"></i>
 								<span>My Profile</span>
 							</a>
 						</li>
 						<li>
 							<hr class="dropdown-divider">
 						</li>

 						<li>
 							<a class="dropdown-item d-flex align-items-center" href="#">
 								<i class="bi bi-gear"></i>
 								<span>Account Settings</span>
 							</a>
 						</li>

 						<li>
 							<hr class="dropdown-divider">
 						</li>

 						<li>
 							<a class="dropdown-item d-flex align-items-center" href="#" id="logout1">
 								<i class="bi bi-box-arrow-right"></i>
 								<span>Sign Out</span>
 							</a>
 						</li>

 					</ul><!-- End Profile Dropdown Items -->
 				</li><!-- End Profile Nav -->

 			</ul>
 		</nav><!-- End Icons Navigation -->

 	</header>
 	<!-- End Header -->

 	<!-- ======= Sidebar ======= -->
 	<aside id="sidebar" class="sidebar">

 		<ul class="sidebar-nav" id="sidebar-nav">

 			<li class="nav-item">
 				<a class="nav-link collapsed" href="./">
 					<i class="bi bi-grid"></i>
 					<span>Dashboard</span>
 				</a>
 			</li>
 			<!-- End Dashboard Nav -->

 			<li class="nav-item">
 				<a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
 					<i class="bi bi-collection-play"></i><span>Class Resources</span><i
 						class="bi bi-chevron-down ms-auto"></i>
 				</a>
 				<ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
 					<li>
 						<a href="./?C_Notes">
 							<i class="bi bi-circle"></i><span>Notes</span>
 						</a>
 					</li>
 					<li>
 						<a href="./?C_Books">
 							<i class="bi bi-circle"></i><span>Books</span>
 						</a>
 					</li>
 					<li>
 						<a href="./?C_Videos">
 							<i class="bi bi-circle"></i><span>Videos</span>
 						</a>
 					</li>
 					<li>
 						<a href="./?C_vid_book">
 							<i class="bi bi-circle"></i><span>Video_Books</span>
 						</a>
 					</li>
 				</ul>
 			</li>
 			<!-- End Resources Nav -->

 			<li class="nav-item">
 				<a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
 					<i class="bi bi-book"></i><span>Library</span><i class="bi bi-chevron-down ms-auto"></i>
 				</a>
 				<ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
 					<li>
 						<a href="./?L_Books">
 							<i class="bi bi-circle"></i><span>Books </span>
 						</a>
 					</li>
 					<li>
 						<a href="./?L_Videos">
 							<i class="bi bi-circle"></i><span>Videos</span>
 						</a>
 					</li>
 				</ul>
 			</li>
 			<!-- End Library Nav -->


 			<li class="nav-heading">Pages</li>

 			<li class="nav-item">
 				<a class="nav-link collapsed" href="./?check_exam">
 					<i class="bi bi-pencil-square"></i>
 					<span>Take Exam</span>
 				</a>
 			</li>
 			<!-- End take exam Nav -->

 			<li class="nav-item">
 				<a class="nav-link collapsed" href="./?check_result">
 					<i class="bi bi-eye"></i>
 					<span>Check Result</span>
 				</a>
 			</li>
 			<!-- End check result Nav -->

 			<li class="nav-item">
 				<a class="nav-link collapsed" href="./?update_password">
 					<i class="bi bi-key"></i>
 					<span>Update Password</span>
 				</a>
 			</li>
 			<!-- End Update password Nav -->

 			<li class="nav-item">
 				<a class="nav-link collapsed" id="logout">
 					<i class="bi bi-box-arrow-right"></i>
 					<span>Logout</span>
 				</a>
 			</li>
 			<!-- End logout  Nav -->

 		</ul>

 	</aside>
 	<!-- End Sidebar-->

 	<?php 
    if(isset($_GET['take_exam'])){
        require_once ('take_exam.php');
    } 
    elseif(isset($_GET['write_exam']))
    {
        require_once('write_exam.php');
    }
	elseif(isset($_GET['write_exam_original']))
    {
        require_once('write_exam_original.php');
    }
	elseif(isset($_GET['write_exam_original_Theo']))
    {
        require_once('write_exam_original_Theo.php');
    }
    elseif(isset($_GET['C_Notes'])){
        require_once('notes.php');
    }
    elseif(isset($_GET['C_Videos'])){
        require_once('videos.php');
    }
    elseif(isset($_GET['C_vid_book'])){
        require_once('video_book.php');
    }
    elseif(isset($_GET['C_Books'])){
        require_once('books.php');
    }
    elseif(isset($_GET['L_Videos'])){
        require_once('library_videos.php');
    }
    elseif(isset($_GET['L_Books'])){
        require_once('library_books.php');
    }
    elseif(isset($_GET['check_result'])){
        require_once('check_result.php');
    }
    elseif(isset($_GET['logout'])){
        require_once('logout.php');
    }
    else 
    {

?>
 	<main id="main" class="main">

 		<section class="section profile">
 			<div class="row">
 				<div class="col-xl-12">

 					<div class="card">
 						<div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

 							<img src="data:<?php echo $mimeType2; ?>;base64,<?php echo $imageData1; ?>"
 								class="rounded-circle" alt="" />
 							<h3><strong><?= $Student_records->Fullnames?></strong></h3>
 							<h3><strong>Current Class: </strong><?= $Student_records->Student_Class?></h3>
 							<div class="social-links mt-2">
 								<a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
 								<a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
 								<a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
 								<a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
 							</div>
 						</div>
 					</div>

 				</div>

 				<!-- <div class="row"> -->
 				<div class="col-md-6">
 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded ">
 						<h6>Entrance Fee:</h6>
 						<!-- <h6><?= number_format($Student_records->Entry_Fee,0)?></h6> -->
 					</div>
 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded ">
 						<h6>Previous Debt:</h6>
 						<!-- <h6><?= number_format($Student_records->Previous_Debt_Fee,0)?></h6> -->
 					</div>
 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded ">
 						<h6>Tuition Fees:</h6>
 						<!-- <h6><?= number_format($Student_records->Tuition_Fee,0)?></h6> -->
 					</div>

 					<!--  -->
 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded ">
 						<h6>Development Fees:</h6>
 						<!-- <h6><?= number_format($Student_records->Dev_Fee,0)?></h6> -->
 					</div>
 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded ">
 						<h6>Utilities Fees:</h6>
 						<!-- <h6><?= number_format($Student_records->Utilities_Fee,0)?></h6> -->
 					</div>
 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded ">
 						<h6>Skill/Entrepreneurship:</h6>
 						<!-- <h6><?= number_format($Student_records->Skill_Fee,0)?></h6> -->
 					</div>

 					<!-- <div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded ">
 						<h6>Skill/Entrepreneurship:</h6>
 						<h6><?= number_format($Student_records->Termly_Fee,0)?></h6>
 					</div> -->
 					<!--  -->

 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded ">
 						<h6>(PTA) Parent/Teachers Ass.:</h6>
 						<!-- <h6><?= number_format($Student_records->PTA_Fee,0)?></h6> -->
 					</div>
 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded ">
 						<h6>Transportation Fee:</h6>
 						<!-- <h6><?= number_format($Student_records->Transport_Fee,0)?></h6> -->
 					</div>
 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded ">
 						<h6>Enrollment Fee:</h6>
 						<!-- <h6><?= number_format($Student_records->Ext_Exam_Fee,0)?></h6> -->
 					</div>
 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded ">
 						<h6>Hostel/Feeding Fee:</h6>
 						<!-- <h6><?= number_format($Student_records->Boarding_Fee,0)?></h6> -->
 					</div>
 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded ">
 						<h6>Grad/Cert/Misc/Exam:</h6>
 						<!-- <h6><?= number_format($Student_records->Misc_Fee,0)?></h6> -->
 					</div>
 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded ">
 						<h6>Caution/Lesson Fee:</h6>
 						<!-- <h6><?= number_format($Student_records->Others_Fee,0)?></h6> -->
 					</div>
 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded ">
 						<h6>Textbooks/Visual/CBT:</h6>
 						<!-- <h6><?= number_format($Student_records->Book_Fee,0)?></h6> -->
 					</div>
 				</div>
 				<!-- </div> -->


 				<div class="col-md-6">
 					<div style="background: #003049;"
 						class="d-flex flex-row justify-content-between border px-2 py-1 my-1 rounded">
 						<h6 class="text-white fw-bold">TOTAL SCHOOL FEES:</h6>
 						<!-- <h6 class="text-white fw-bold"><?= number_format($Student_records->Total_Sch_Fee,0)?></h6> -->
 					</div>
 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded">
 						<h6>Scholarship Fees:</h6>
 						<!-- <h6><?= number_format($Student_records->Scholarship_Fee,0)?></h6> -->
 					</div>
 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded">
 						<h6>General Discount:</h6>
 						<!-- <h6><?= number_format($Student_records->Gen_Discount,0)?></h6> -->
 					</div>
 					<div style="background: #003049;"
 						class="d-flex flex-row justify-content-between border px-2 py-1 my-1 rounded">
 						<h6 class="text-white fw-bold">AMOUNT PAYABLE:</h6>
 						<!-- <h6 class="text-white fw-bold"> <?= number_format($Student_records->Amount_Payable,0)?> -->
 						</h6>
 					</div>
 					<div class="d-flex flex-row justify-content-between border px-2 py-1 my-1 bg-white rounded">
 						<h6>Amount Paid:</h6>
 						<!-- <h6><?= number_format($Student_records->Amount_Paid,0)?></h6> -->
 					</div>
 					<div style="background: #0353a4;"
 						class="d-flex flex-row justify-content-between border px-2 py-1 my-1 rounded">
 						<h6 class="text-white fw-bold">TOTAL BALANCE:</h6>
 						<!-- <h6 class="text-white fw-bold"><?= number_format($Student_records->Current_Balance,0)?> -->
 						</h6>
 					</div>
 					<div style="background: #03a439;"
 						class="d-flex flex-row justify-content-between border px-2 py-1 my-1 rounded">
 						<h6 class="text-white fw-bold">Student Result PIN:</h6>
 						<h6 class="text-white fw-bold">
 							<?php if($Student_records->Student_Pin != 0){ echo $Student_records->Student_Pin ;}?>
 						</h6>
 					</div>
 					<div style="background: #fff;"
 						class="d-flex flex-row justify-content-between px-1 py-1 my-1 rounded">
 						<textarea class="form-control text-justify" id="" readonly cols="30"
 							rows="9"><?= $branchesDet->GenInfo ?></textarea>
 					</div>
 				</div>



 			</div>
 		</section>

 	</main>
 	<!-- End #main -->

 	<!-- ======= Footer ======= -->
 	<footer id="footer" class="footer">
 		<div class="copyright">
 			&copy; Copyright <strong><span>IDEA-CBT</span></strong>. All Rights Reserved
 		</div>
 		<div class="credits">
 			Designed by Idea Code Solution
 		</div>
 	</footer><!-- End Footer -->
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
 	<!-- Template Main JS File -->
 	<script src="assets/js/main.js"></script>

 	<!-- using jQuery -->
 	<script type="text/javascript">
 	$(document).ready(function() {
 		$('#logout').click(function() {
 			localStorage.removeItem('countdownTime');
 			localStorage.removeItem('endTime');
 			window.location.href = './?logout';
 		})
 		$('#logout1').click(function() {
 			localStorage.removeItem('countdownTime');
 			localStorage.removeItem('endTime');
 			window.location.href = './?logout';
 		})
 		<?php if(isset($_GET['check_exam'])){?>
 		var check_exam = '<?=$Question_code?>';
 		if (check_exam == '') {
 			$.confirm({
 				icon: 'bi bi-patch-question',
 				theme: 'bootstrap',
 				title: 'Message',
 				content: 'There is no exam to write',
 				animation: 'scale',
 				type: 'orange'
 			})
 		} else {
 			window.location.href = './?take_exam';
 		}
 		<?php }?>
 	})
 	</script>

 </body>

 </html>