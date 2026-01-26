<?php 
$students = staff_class_student($staff_class,$conn,$gen_branch);

?>
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Check Register </h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="./">Home</a></li>
				<li class="breadcrumb-item active">Check Register</li>
			</ol>
		</nav>
	</div>
	<!-- End Page Title -->
	<section class="section">
		<div class="row">

			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Select the Date Range</h5>

						<div class="row g-3">
							<div class="input-group">
								<span class="input-group-append">
									<button class="btn btn-primary dropdown-toggle" type="button" name="btnPersonalDate"
										id="date-btn">
										<i class="fa fa-calendar"></i> Click here to select date
									</button>
								</span>
								<input type="hidden" name="sdate" id="ssdatee">
							</div>


							<div class="text-center">
								<button type="submit" id="chk_reg_btn" class="btn btn-primary rounded-pill">View
									Register <i class="bi bi-forward"></i></button>
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="col-lg-12 d-none" id="shwDiv">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive" id="tbl_res">

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<script type="text/javascript">
$(document).ready(function() {

	$('#date-btn').daterangepicker({
			drops: 'auto',
			opens: 'left',
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
					.endOf('month')
				]
			},
			startDate: moment().startOf('today'),
			endDate: moment().endOf('today')
		},
		function(start, end, ranges) {
			if (ranges === 'Today' || ranges === 'Yesterday') {
				$('#ssdatee').val(start.format('YYYY-MM-DD') + ';' + ranges);
			} else {
				$('#ssdatee').val(start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD') + ';' +
					ranges);
			}
		}
	);

	$('#chk_reg_btn').click(function() {
		var date_range = $('#ssdatee').val();
		var std_list = <?php echo json_encode($students); ?>;
		var class_id = '<?= $staff_class ?>';
		var branch = '<?= $gen_branch?>';
		// console.log(std_list);
		$.ajax({
			url: 'checkRegister_db.php',
			type: 'POST',
			dataType: 'json',
			cache: false,
			data: {
				"type": "checkRegister",
				"date_range": date_range,
				"stdList": std_list,
				"class_id": class_id,
				"branch": branch
			},
			success: function(data) {
				// console.log(data);
				$('#shwDiv').removeClass('d-none');
				$('#tbl_res').html(data.html);
			},
			error: function(error) {
				console.log(error);
			}
		})
	});
})
</script>