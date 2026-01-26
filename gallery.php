<?php 
    include('admin/config/db_connect.php');
    $setupsSQL = $conn->query("SELECT * FROM setups");
    if($setupsSQL->num_rows > 0){
        $setup = $setupsSQL->fetch_object();
        $id = $setup->id;
        $title = $setup->title;
        $stat = $setup->status;
        $date = $setup->date;
        $linkPdf = 'storege/setup_pdf/'.$setup->homepage_pdf;
        $linkImg = 'storege/setup_pdf/'.$setup->homepage_img;
    } else {
        $id = 0;
        $title = '';
        $stat = 'No status';
        $date = '2024-10-10';
        $linkPdf = ''; //put the link of the dummy pdf to create
        $linkImg = ''; //put the link of the dummy pdf to create
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Bulletin</title>
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
	<style>
	.blog .entry .entry-title {
		font-size: 14px;
		font-weight: bold;
		padding: 0;
		margin: 0 0 20px 0;
	}

	.blog {
		padding: 40px 0 -10px 0;
	}
	</style>

</head>

<body>

	<!-- ======= Header ======= -->
	<?php  include('header.php')?>
	<!-- End Header -->

	<main id="main">

		<!-- ======= Blog Section ======= -->
		<section id="blog" class="blog">
			<div class="container">

				<div class="row pt-4">

					<div class="col-lg-6 pt-4">
						<h3 class="entry-title fw-bold">
							<a href="#" style="color: #012970;">SCHOOL FEES INFO</a>
						</h3>
						<img src="<?= $linkImg?>" alt="" class="img-fluid">
					</div>

					<div class="col-lg-6 entries">

						<article class="entry">

							<h4 class="entry-title">
								<a href="#"><?= $title?></a>
							</h4>
							<div class="entry-img pt-2">
								<embed src="<?=$linkPdf?>" type="application/pdf" width="100%" height="450px">
							</div>

						</article>

					</div>

				</div>

			</div>
		</section>
		<!-- End Blog Section -->

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