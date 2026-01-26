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
				<li class="breadcrumb-item active">Debtors List</li>
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
							<table class="table table-bordered">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col">ID</th>
										<th scope="col">Students</th>
										<th scope="col">Debtors</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 1; foreach($all_stud as $std):?>
									<tr class="<?php if ($std['Current_Balance'] > 0){ echo 'table-danger';}?>">
										<th scope="row"><?= $no?></th>
										<th scope="row"><?= $std['Student_ID']?></th>
										<td class="text-uppercase"><?= $std['Fullnames']?></td>
										<td>
											<strong><?= number_format($std['Current_Balance'])?></strong>
										</td>
									</tr>
									<?php $no++; endforeach;?>
								</tbody>
							</table>

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
	// $('.clRegForm').on('click', '#allM', function() {
	// 	if ($(this).prop('checked') == true) {
	// 		$('.chkM').prop('checked', true);
	// 		$('.chkM').parent().parent().parent().addClass('table-success');
	// 	} else {
	// 		$('.chkM').prop('checked', false);
	// 		$('.chkM').parent().parent().parent().removeClass('table-success');
	// 	}
	// });

	// $('.clRegForm').on('click', '.chkM', function() {
	// 	if ($(this).prop('checked') == true) {
	// 		$(this).prop('checked', true);
	// 		$(this).parent().parent().parent().addClass('table-success');
	// 	} else {
	// 		$(this).prop('checked', false);
	// 		$(this).parent().parent().parent().removeClass('table-success');
	// 	}
	// });


	// function markRegister(ids) {
	// 	var clas_reg_name = $('#class_id_reg').val();
	// 	var class_branch = $('#class_branch').val();
	// 	$.ajax({
	// 		url: 'markRegister_db.php',
	// 		type: 'POST',
	// 		dataType: 'json',
	// 		cache: false,
	// 		data: {
	// 			"ids": ids,
	// 			"type": "markRegister",
	// 			"class_name": clas_reg_name,
	// 			"class_branch": class_branch
	// 		},
	// 		success: function(data) {
	// 			if (data.status == 'success') {
	// 				// toastr.success(data.message);
	// 				$.alert({
	// 					icon: 'bi bi-patch-question',
	// 					theme: 'bootstrap',
	// 					title: 'Message',
	// 					content: data.message,
	// 					animation: 'scale',
	// 					type: 'orange'
	// 				})
	// 				setTimeout(function() {
	// 					location.reload(true)
	// 				}, 2500);
	// 			}
	// 		},
	// 		error: function(err) {
	// 			console.log(err);
	// 		}
	// 	})
	// }

	// function markRegister2(ids, mIDs) {
	// 	var clas_reg_name = $('#class_id_reg').val();
	// 	var class_branch = $('#class_branch').val();
	// 	$.ajax({
	// 		url: 'markRegister_db.php',
	// 		type: 'POST',
	// 		dataType: 'json',
	// 		cache: false,
	// 		data: {
	// 			"ids": ids,
	// 			"mIDs": mIDs,
	// 			"type": "markRegister2",
	// 			"class_name": clas_reg_name,
	// 			"class_branch": class_branch
	// 		},
	// 		success: function(data) {
	// 			if (data.status == 'success') {
	// 				// toastr.success(data.message);
	// 				$.alert({
	// 					icon: 'bi bi-patch-question',
	// 					theme: 'bootstrap',
	// 					title: 'Message',
	// 					content: data.message,
	// 					animation: 'scale',
	// 					type: 'orange'
	// 				})
	// 				setTimeout(function() {
	// 					location.reload(true)
	// 				}, 2500);
	// 			}
	// 			// console.log(data);
	// 		},
	// 		error: function(err) {
	// 			console.log(err);
	// 		}
	// 	})
	// }

	// var ids;
	// var mIDs;
	// $('.mrkReg').click(function(e) {
	// 	e.preventDefault();
	// 	var checked = $('.chkM:checkbox:checked').length;
	// 	var listsss = $('.chkM:checkbox:checked').serializeArray();
	// 	mIDs = <?php echo json_encode($todayAtt); ?>;
	// 	if (checked < 1 && mIDs == '') {
	// 		toastr.warning('Please Select At Least One Student To Mark Present.');
	// 	} else {
	// 		ids = listsss;
	// 		<?php if($todayAttCount > 0){ ?>
	// 		// console.log(mIDs);
	// 		markRegister2(ids, mIDs);
	// 		<?php } else {?>
	// 		markRegister(ids);
	// 		<?php }?>
	// 	}
	// })

})
</script>