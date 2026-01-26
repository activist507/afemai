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

    if( $_SESSION['authentication'] != 'member')
    {
        echo "<script>
        window.location = '../'
        </script>";
    }
    if(isset($_SESSION['mem_id'])){
        $mem_id = $_SESSION['mem_id'];
        $member =  $conn->query("SELECT * FROM idea_member WHERE mem_id='$mem_id'")->fetch_object();
        $name = $member->Fullname;
		$role = $member->role;
		$img = $member->img;

        //image of staff 
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
						<img src="../admin/idea_member/image/<?=$img?>" class="rounded-circle" alt="" />
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
							<a class="dropdown-item d-flex align-items-center" href="#">
								<i class="bi bi-gear"></i>
								<span>Account Settings</span>
							</a>
						</li>
						<li>
							<hr class="dropdown-divider">
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

					</ul>
				</li>

			</ul>
		</nav>

	</header>

	<aside id="sidebar" class="sidebar">

		<ul class="sidebar-nav" id="sidebar-nav">

			<li class="nav-item">
				<a class="nav-link " href="./">
					<i class="bi bi-grid"></i>
					<span>Dashboard</span>
				</a>
			</li>
			<!-- End Dashboard Nav -->

			<!-- <li class="nav-item">
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
				<a class="nav-link collapsed" href="./?Debtors">
					<i class="bi bi-bar-chart-line"></i>
					<span>Fees Payment</span>
				</a>
			</li> -->
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
    elseif(isset($_GET['logout'])){
        require_once 'logout.php';
    }
  
    else 
    {

?>
	<main id="main" class="main">
    <input type="hidden" value="mainPage" id="checkPage">
		<section class="section">
			<div class="row">
				<div class="col-lg-12 pt-2">
					<div class="tom-select-custom">
						<input type="text" class="form-control text-center text-white fw-bold" value="IDEA CONTRIBUTION LIST"
							style="background:rgba(18, 115, 100, 0.93);" disabled>
					</div>
				</div>
				<div class="col-lg-12 justify-content-center">
					<div class="col-12">
						<div class="card info-card sales-card">
							<div class="card-body">
								<div class="table-responsive pt-0">
								<div class="row py-2">
									<div class="col-lg-2 col-sm-12 pt-2">
									<select class="form-select" id="limit" data-bs-toggle="tooltip" data-bs-placement="top"
										title="Entries Per Page">
										<option selected value="10">10</option>
										<option value="20">20</option>
										<option value="50">50</option>
										<option value="100">100</option>
									</select>
									</div>
									<div class="col-6"></div>
									<div class="col-lg-4 col-sm-12 pt-2">
									<div class="input-group">
										<input type="text" placeholder="search" class="form-control" id="search">
										<span class="input-group-text"><i class="bi bi-search"></i></span>
									</div>
									</div>
								</div>
								<table class="table table-bordered border-primary table-striped">
									<thead>
									<tr>
										<th scope="col" class="text-nowrap">M-ID</th>
										<th scope="col" class="text-nowrap text-center">Name</th>
										<th scope="col" class="text-nowrap text-center">Contact</th>
										<!-- <th scope="col" class="text-nowrap text-center">Role</th> -->
										<th scope="col" class="text-nowrap text-center">Bank_Acct</th>
										<th scope="col" class="text-nowrap text-center">Bank_Name</th>
										<th scope="col" class="text-nowrap text-center">M_Due</th>
										<th scope="col" class="text-nowrap text-center">Total Paid</th>
										<th scope="col" class="text-nowrap text-center">L_Month</th>
										<th scope="col" class="text-nowrap text-center">L_Year</th>
										<th scope="col" class="text-nowrap text-center">Shares</th>
									</tr>
									</thead>
									<tbody id="allMember">

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
	$(document).ready(function() {
    let checkPage = $('#checkPage').val();
    if(checkPage == 'mainPage'){
      function loadData(page = 1, search = '') {
        const limit = $('#limit').val();
        $.ajax({
            url: 'index_db.php',
            type: 'POST',
            data: {
                "page": page,
                "limit": limit,
                "search": search,
                "type": "paginateMember"
            },
            dataType: 'json',
            success: function(response) {
                $('#allMember').html(response.html);
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
      loadData();
      $('#pagination').on('click', '.page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        const search = $('#search').val();
        if (page) {
            loadData(page, search);
        }
      });
      let typingTimer;
      $('#search').on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function() {
            loadData(1, $('#search').val());
        }, 500); 
      });
      setInterval(() => {
          var activePge = parseInt($('#pagination li.active .page-link').text());
          if (isNaN(activePge)) {
              activePge = 1;
          }
          var serch = $('#search').val()
          loadData(activePge, serch);
      }, 3000);
    }
  })
	</script>

</body>

</html>