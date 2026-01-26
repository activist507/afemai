<?php 
  $pres = 1; 
  $dateTop = date('Y-m-d');
  $all_stud = staff_class_student($staff_class,$conn,$gen_branch);

  $tot_todayAtt = $conn->query("SELECT studentID FROM attendance_students 
    WHERE class = '$staff_class' AND branch ='$gen_branch' AND date='$dateTop' AND status=1");
  $todayAtt = array_column($tot_todayAtt->fetch_all(MYSQLI_ASSOC), 'studentID');
  $todayAttCount = count($todayAtt);
?>
<main id="main" class="main">
	<div class="pagetitle">
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="./">Home</a></li>
				<li class="breadcrumb-item active">Mark Register</li>
			</ol>
		</nav>
	</div>
	<section class="section dashboard">
		<div class="row">

			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title"></h5>
						<!-- Table with stripped rows -->
						<form class="row g-3 clRegForm">
							<input type="hidden" name="clas_id" id="class_id_reg" value="<?= $staff_class?>">
							<input type="hidden" name="clas_branch" id="class_branch" value="<?= $gen_branch?>">
							<table class="table">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col">Names of Students</th>
										<th scope="col"><input class="form-check-input" type="checkbox" id="allM">Select
											All</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 1; foreach($all_stud as $std):?>
									<tr
										class="<?php if (in_array($std['Student_ID'], $todayAtt)){ echo 'table-success';}?>">
										<th scope="row"><?= $no?></th>
										<td class="text-uppercase"><?= $std['Fullnames']?></td>
										<td>
											<div class="form-check form-check-inline">
												<input class="form-check-input chkM" type="checkbox"
													value="<?=$std['Student_ID']?>" name="morningNAme"
													<?php if (in_array($std['Student_ID'], $todayAtt)){ echo 'checked';}?>>
												<label class="form-check-label" for="inlineRadio1">Present</label>
											</div>
										</td>
									</tr>
									<?php $no++; endforeach;?>
								</tbody>
							</table>

							<div class="row justify-content-center">
								<div class="col-6 ">
									<div class="d-grid gap-2 mt-3">
										<button class="btn btn-primary rounded-pill mrkReg" type="button">
											<i class="bi-check2-square"></i> Mark Register
										</button>
									</div>
								</div>
							</div>

						</form>
						<!-- End Table with stripped rows -->
					</div>
				</div>
			</div>

		</div>
	</section>
</main>
<script type="text/javascript">
$(document).ready(function() {
	// alert('mark register page');
	$('.clRegForm').on('click', '#allM', function() {
		if ($(this).prop('checked') == true) {
			$('.chkM').prop('checked', true);
			$('.chkM').parent().parent().parent().addClass('table-success');
		} else {
			$('.chkM').prop('checked', false);
			$('.chkM').parent().parent().parent().removeClass('table-success');
		}
	});

	$('.clRegForm').on('click', '.chkM', function() {
		if ($(this).prop('checked') == true) {
			$(this).prop('checked', true);
			$(this).parent().parent().parent().addClass('table-success');
		} else {
			$(this).prop('checked', false);
			$(this).parent().parent().parent().removeClass('table-success');
		}
	});


	function markRegister(ids) {
		var clas_reg_name = $('#class_id_reg').val();
		var class_branch = $('#class_branch').val();
		$.ajax({
			url: 'markRegister_db.php',
			type: 'POST',
			dataType: 'json',
			cache: false,
			data: {
				"ids": ids,
				"type": "markRegister",
				"class_name": clas_reg_name,
				"class_branch": class_branch
			},
			success: function(data) {
				if (data.status == 'success') {
					// toastr.success(data.message);
					$.alert({
						icon: 'bi bi-patch-question',
						theme: 'bootstrap',
						title: 'Message',
						content: data.message,
						animation: 'scale',
						type: 'orange'
					})
					setTimeout(function() {
						location.reload(true)
					}, 2500);
				}
			},
			error: function(err) {
				console.log(err);
			}
		})
	}

	function markRegister2(ids, mIDs) {
		var clas_reg_name = $('#class_id_reg').val();
		var class_branch = $('#class_branch').val();
		$.ajax({
			url: 'markRegister_db.php',
			type: 'POST',
			dataType: 'json',
			cache: false,
			data: {
				"ids": ids,
				"mIDs": mIDs,
				"type": "markRegister2",
				"class_name": clas_reg_name,
				"class_branch": class_branch
			},
			success: function(data) {
				if (data.status == 'success') {
					// toastr.success(data.message);
					$.alert({
						icon: 'bi bi-patch-question',
						theme: 'bootstrap',
						title: 'Message',
						content: data.message,
						animation: 'scale',
						type: 'orange'
					})
					setTimeout(function() {
						location.reload(true)
					}, 2500);
				}
				// console.log(data);
			},
			error: function(err) {
				console.log(err);
			}
		})
	}

	var ids;
	var mIDs;
	$('.mrkReg').click(function(e) {
		e.preventDefault();
		var checked = $('.chkM:checkbox:checked').length;
		var listsss = $('.chkM:checkbox:checked').serializeArray();
		mIDs = <?php echo json_encode($todayAtt); ?>;
		if (checked < 1 && mIDs == '') {
			toastr.warning('Please Select At Least One Student To Mark Present.');
		} else {
			ids = listsss;
			<?php if($todayAttCount > 0){ ?>
			// console.log(mIDs);
			markRegister2(ids, mIDs);
			<?php } else {?>
			markRegister(ids);
			<?php }?>
		}
	})

})
</script>