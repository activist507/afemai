<?php 

	$classes = fetch_all_assoc($conn->query("SELECT * FROM cbt_class"));
    $allquestions = $conn->query("SELECT * FROM questions ORDER BY id DESC");
    $sqlStudStat = $conn->query("SELECT * FROM cbt_stud_status");
?>

<main id="main" class="main">
	<section class="section">
		<div class="card">
			<div class="card-body">

				<!-- PAGE TITLE -->
				<div class="col-lg-12 pt-2">
					<div class="tom-select-custom">
						<input type="text" class="form-control text-center" value="SEND SMS" name=""
							style="background:rgba(233, 240, 239, 0.93);" disabled>
					</div>
				</div>

				<div class="row gy-3">
					<div class="col-lg-3 pt-1">
						<div class="tom-select-custom">
							<input type="text" name="exam_id_ans" id="student_id" class="form-control text-center"
								data-bs-toggle="tooltip" data-bs-placement="top" title="ID" placeholder="Enter ID">
							</input>
						</div>
					</div>

					<div class="col-lg-3 pt-1">
						<div class="tom-select-custom">
							<select name="tbl_class" id="tbl_class" class="form-control" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Select Class">
								<option value="">Select Class</option>
								<?php foreach($classes as $class){ ?>
								<option value="<?= $class['class']?>"><?= $class['class']?></option>
								<?php }?>
							</select>
						</div>
					</div>

					<div class="col-lg-3 pt-1">
						<div class="tom-select-custom">
							<select name="sms_branch" id="sms_branch" class="form-control" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Select Branch">
								<option value="0">Select Branch</option>
								<?php foreach($branches_rows as $branc){?>
								<option value="<?= $branc['Branch_Name']?>"><?= $branc['Branch_Name']?>
								</option>
								<?php }?>
							</select>
						</div>
					</div>

					<div class="col-lg-3 pt-1">
						<div class="tom-select-custom">
							<select name="sms_status" id="sms_status" class="form-control" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Select Status">
								<option value="0">Select Status</option>
								<?php while($status = $sqlStudStat->fetch_object()){?>
								<option value="<?= $status->status?>"><?= $status->status?></option>
								<?php }?>
							</select>
						</div>
					</div>

					<!-- <div class="col-lg-2 pt-3">
                        <div class="tom-select-custom">
                            <input type="text text-center" name="curr_bal" id="curr_bal"
                                class="form-control text-center" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Curr Bal" placeholder="Curr Bal">
                            </input>
                        </div>
                    </div>

                    <div class="col-lg-2 pt-3">
                        <div class="tom-select-custom">
                            <input type="text text-center" name="phone_stud" id="phone_stud"
                                class="form-control text-center" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Student Phone" placeholder="Student Phone" readonly>
                            </input>
                        </div>
                    </div> -->

					<div class="col-lg-6">
						<label for="msg_text">General Messages</label>
						<textarea name="msg_text" id="msg_text" class="form-control mb-2" style="height: 5rem;"
							required><?= $gen_msg?></textarea>
					</div>
					<div class="col-lg-6">
						<label for="msg_concat">School Fees Messages</label>
						<textarea name="msg_concat" id="msg_concat" class="form-control mb-2" style="height: 5rem;"
							required></textarea>
					</div>
				</div>

				<div class="row gy-1 ">
					<div class="col-lg-4 col-sm-4">
						<button type="btn" style="width: 8.7rem;" class="btn btn-primary w-100 mx-0 mt-2"
							id="Stud_Msg_sms">
							Student_Msg_sms
						</button>
					</div>

					<div class="col-lg-4 col-sm-4">
						<button type="btn" style="width: 8.7rem;" class="btn btn-primary w-100 mx-0 mt-2"
							id="Class_Msg_sms">
							Class_Msg_sms
						</button>
					</div>

					<div class="col-lg-4 col-sm-4">
						<button type="btn" style="width: 8.7rem;" class="btn btn-primary w-100 mx-0 mt-2"
							id="Branch_Msg_sms">
							Branch_Msg_sms
						</button>
					</div>
					<!--  -->
					<div class="col-lg-4 col-sm-4">
						<button type="btn" style="width: 8.7rem;" class="btn btn-danger w-100 mx-0 mt-2"
							id="Stud_Fees_sms">
							Student_Fees_Debtors
						</button>
					</div>

					<div class="col-lg-4 col-sm-4">
						<button type="btn" style="width: 8.7rem;" class="btn btn-danger w-100 mx-0 mt-2"
							id="Class_Fees_sms">
							Class_Fees_Debtors
						</button>
					</div>

					
					<div class="col-lg-4 col-sm-4">
						<button type="btn" style="width: 8.7rem;" class="btn btn-danger w-100 mx-0 mt-2"
							id="Branch_Fees_sms">
							Branch_Fees_Debtors
						</button>
					</div>

					<!--  -->

					<div class="col-lg-4 col-sm-4">
						<button type="btn" style="width: 8.7rem;" class="btn btn-success w-100 mx-0 mt-2"
							id="">
							Message to Active Hos Stud
						</button>
					</div>


					<div class="col-lg-4 col-sm-4">
						<button type="btn" style="width: 8.7rem;" class="btn btn-success w-100 mx-0 mt-2"
							id="">
							Message+Sch Fees to Act Hos Stud
						</button>
					</div>

					<div class="col-lg-4 col-sm-4">
						<button type="btn" style="width: 8.7rem;" class="btn btn-success w-100 mx-0 mt-2"
							id="Branch2_Fees2_sms2">
							Message+Sch Fees to All Active Stud
						</button>
					</div>

					<!--  -->

					<div class="col-lg-4 col-sm-4">
						<div class="tom-select-custom pt-2">
							<input type="text" name="exam_id_ans" id="staff_id_sms" class="form-control text-center"
								data-bs-toggle="tooltip" data-bs-placement="top" title="ID"
								placeholder="Enter Staff ID">
							</input>
						</div>

					</div>
					<div class="col-lg-4 col-sm-4">
						<button type="btn" style="width: 8.7rem;" class="btn btn-primary w-100 mx-0 mt-2"
							id="Staff_ind_sms">
							Staff_ind_Salaries_sms
						</button>
					</div>
					<div class="col-lg-4 col-sm-4">
						<button type="btn" style="width: 8.7rem;" class="btn btn-primary w-100 mx-0 mt-2"
							id="Staff_Salaries_sms">
							All Staff_Salaries_sms
						</button>
					</div>
					<!--  -->
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-body">
				<div class="col-lg-12 pt-2">

					<div class="row">
						<div class="col-lg-12 col-sm-6 pt-0">
							<input type="text" class="form-control text-center" value="TITLE" id="title"
								style="background:rgba(233, 240, 239, 0.93);" disabled>
						</div>
					</div>
				</div>

				<div class="row gy-3">
					<form method="post">
						<div class="row">
							<div class="col-lg-4 col-sm-6 pt-0">
								<div class="input-group pt-2">
									<span class="input-group-append">
										<button class="btn btn-primary dropdown-toggle" type="button"
											name="btnPaymentSms" id="btnPaymentSms" style="width: 17.5rem;">
											<i class="fa fa-calendar"></i> Click here to
											select date
										</button>
									</span>
									<input type="hidden" name="sdate" id="ssdatee" value="<?=date('Y-m-d')?>;Today">
								</div>
							</div>
							<!-- <div class="col-lg-8 col-sm-6 pt-2">
									<input type="text" class="form-control text-center" value="TITLE" id="title"
										style="background:rgba(233, 240, 239, 0.93);" disabled>
								</div> -->
							<div class="col-lg-4 col-sm-12">
								<button type="btn" style="width: 8.7rem;" class="btn btn-primary w-100 mx-0 mt-2"
									id="Payment_SMS">
									Send_Payment_Receipt_SMS
								</button>
							</div>
							<div class="col-lg-4 col-sm-12">
								<button type="btn" style="width: 8.7rem;" class="btn btn-danger w-100 mx-0 mt-2"
									id="Clear_sms">
									Clear_Payment_Receipt_SMS
								</button>
							</div>
						</div>

					</form>
					<table class="table small pt-4">
						<thead>
							<tr>
								<th scope="col" nowrap="nowrap">ID</th>
								<th scope="col" nowrap="nowrap">Name</th>
								<th scope="col" nowrap="nowrap">Class</th>
								<th scope="col" nowrap="nowrap">Phone</th>
								<th scope="col" nowrap="nowrap">A_payable</th>
								<th scope="col" nowrap="nowrap">A_Paid</th>
								<th scope="col" nowrap="nowrap">Balance</th>
								<th scope="col" nowrap="nowrap">Sms Status</th>
							</tr>
						</thead>
						<tbody id="paymentList">

						</tbody>
					</table>
				</div>
			</div>
		</div>
		</div>
	</section>
</main>


<script type="text/javascript">
$(document).ready(function() {

	function getDet() {
		var id = $('#student_id').val();
		if (id.length == 4) {
			$.ajax({
				url: '../admin/sms/sms_db.php',
				type: 'POST',
				dataType: 'json',
				data: {
					"student_ID": id,
					"type": "getStudentDetails"
				},
				success: function(response) {
					if (response.query == 'false') {
						$.alert({
							icon: 'bi bi-patch-question',
							theme: 'bootstrap',
							title: 'Message',
							content: response.msg,
							animation: 'scale',
							type: 'orange'
						})
					} else if (response.query == 'true') {
						var concat = 'ID-' + response.student_ID + ' ' + response.Fullnames +
							' CurrBal= ' + response.Balance + '.';
						$('#msg_concat').val(concat);
					}
				},
				error: function(err) {
					console.log(err);
				}
			})
		} else {
			$('#msg_concat').val('');
		}
	}

	function getStaffDet() {
		var id = $('#staff_id_sms').val();
		if (id.length == 4) {
			$.ajax({
				url: '../admin/sms/sms_db.php',
				type: 'POST',
				dataType: 'json',
				data: {
					"staff_ID": id,
					"type": "getStaffDetails"
				},
				success: function(response) {
					if (response.query == 'false') {
						$.alert({
							icon: 'bi bi-patch-question',
							theme: 'bootstrap',
							title: 'Message',
							content: response.msg,
							animation: 'scale',
							type: 'orange'
						})
					} else if (response.query == 'true') {
						var concat = 'ID-' + response.Staff_ID + ', ' + response.Fullname +
							', T_Sal= ' + response.Total_Salary +
							', Grat= ' + response.M_Gratuity +
							', Savs= ' + response.Monthly_Savings +
							', Loan= ' + response.Monthly_Loan +
							', Ded= ' + response.Deductions +
							', Payable= ' + response.Amt_Payable +
							', A_Paid= ' + response.Amt_Paid + '.'
						$('#msg_concat').val(concat);
					}
				},
				error: function(err) {
					console.log(err);
				}
			})
		} else {
			$('#msg_concat').val('');
		}
	}

	function getDetAndSendFeesSms(phone, ret = false) {
		return new Promise((resolve, reject) => {
			var id = $('#student_id').val();
			var msg_text = $('#msg_text').val();
			if (id.length == 4) {
				$.ajax({
					url: '../admin/sms/sms_db.php',
					type: 'POST',
					dataType: 'json',
					data: {
						"student_ID": id,
						"type": "getStudentDetails"
					},
					success: function(response) {
						if (response.query == 'false') {
							$.alert({
								icon: 'bi bi-patch-question',
								theme: 'bootstrap',
								title: 'Message',
								content: response.msg,
								animation: 'scale',
								type: 'orange'
							})
							if (ret) resolve(null);
						} else if (response.query == 'true') {
							var concat = 'ID-' + response.student_ID + ' ' + response
								.Fullnames +
								' CurrBal= ' + response.Balance + '. ' + msg_text;
							$('#msg_concat').val(concat);
							$.ajax({
								url: '../admin/sms/sms_db.php',
								type: 'POST',
								dataType: 'json',
								data: {
									"phone": phone,
									"msg": concat,
									"type": "sendStdFeesSms"
								},
								success: function(response) {
									if (response.status != 'error') {
										var mssg = 'The Message sent cost ' +
											response.cost +
											' and your balance is: ' + response
											.balance;
										var cnt = 1;
									}
									if (ret) {
										resolve({
											message: mssg,
											cnt: 1
										});
									} else {
										resolve(cnt);
									}
								},
								error: function(err) {
									console.log(err);
									reject(err);
								}
							})
							// console.log(concat)
						}
					},
					error: function(err) {
						console.log(err);
						reject(err);
					}
				})
			} else {
				$('#msg_concat').val('');
				resolve(null);
			}
		});
	}

	function getDetAndSendGenSms(phone, ret = false) {
		return new Promise((resolve, reject) => {
			var id = $('#student_id').val();
			var msg_text = $('#msg_text').val();
			if (id.length == 4) {
				$.ajax({
					url: '../admin/sms/sms_db.php',
					type: 'POST',
					dataType: 'json',
					data: {
						"student_ID": id,
						"type": "getStudentDetails"
					},
					success: function(response) {
						if (response.query == 'false') {
							$.alert({
								icon: 'bi bi-patch-question',
								theme: 'bootstrap',
								title: 'Message',
								content: response.msg,
								animation: 'scale',
								type: 'orange'
							})
							if (ret) resolve(null);
						} else if (response.query == 'true') {
							$.ajax({
								url: '../admin/sms/sms_db.php',
								type: 'POST',
								dataType: 'json',
								data: {
									"phone": phone,
									"msg": msg_text,
									"type": "sendStdFeesSms"
								},
								success: function(response) {
									if (response.status != 'error') {
										var mssg = 'The Message sent cost ' +
											response.cost +
											' and your balance is: ' + response
											.balance;
										var cnt = 1;
									}
									if (ret) {
										resolve({
											message: mssg,
											cnt: 1
										});
									} else {
										resolve(cnt);
									}
								},
								error: function(err) {
									console.log(err);
								}
							})
						}
					},
					error: function(err) {
						console.log(err);
						reject(err);
					}
				})
			} else {
				$('#msg_concat').val('');
				resolve(null);
			}
		});
	}
	// function sending staff salaries sms
	function getDetSendSal(phone, ret = false) {
		return new Promise((resolve, reject) => {
			var id = $('#staff_id_sms').val();
			var msg_text = $('#msg_text').val();

			if (id.length === 4) {
				$.ajax({
					url: '../admin/sms/sms_db.php',
					type: 'POST',
					dataType: 'json',
					data: {
						"staff_ID": id,
						"type": "getStaffDetails"
					},
					success: function(response) {
						if (response.query === 'false') {
							$.alert({
								icon: 'bi bi-patch-question',
								theme: 'bootstrap',
								title: 'Message',
								content: response.msg,
								animation: 'scale',
								type: 'orange'
							});
							if (ret) resolve(null);
						} else if (response.query === 'true') {
							var concat = 'ID-' + response.Staff_ID + ', Name: ' + response
								.Fullname +
								', T_Sal= ' + response.Total_Salary +
								', Grat= ' + response.M_Gratuity +
								', Savs= ' + response.Monthly_Savings +
								', Loan= ' + response.Monthly_Loan +
								', Ded= ' + response.Deductions +
								', Payable= ' + response.Amt_Payable +
								', A_Paid= ' + response.Amt_Paid +
								'. ' + msg_text;

							$('#msg_concat').val(concat);

							$.ajax({
								url: '../admin/sms/sms_db.php',
								type: 'POST',
								dataType: 'json',
								data: {
									"phone": phone,
									"msg": concat,
									"type": "sendStaffSalSms"
								},
								success: function(response) {
									if (response.status != 'error') {
										var mssg = 'The Message sent cost ' +
											response.cost +
											' and your balance is: ' + response
											.balance;
										var cnt = 1;
									}
									if (ret) {
										resolve({
											message: mssg,
											cnt: 1
										});
									} else {
										resolve(cnt);
									}
								},
								error: function(err) {
									console.log(err);
									reject(err);
								}
							});
						}
					},
					error: function(err) {
						console.log(err);
						reject(err);
					}
				});
			} else {
				$('#msg_concat').val('');
				resolve(null);
			}
		});
	}

	// 


	//<!-------------------- getting student details from id -------------------->
	$('#student_id').keyup(function() {
		getDet()
	})
	//<!--------------------END getting student details from id -------------------->

	//<!-------------------- Sending general message to a student -------------------->
	$('#Stud_Msg_sms').click(function(e) {
		e.preventDefault();
		var msg_text = $('#msg_text').val();
		var std_id = $('#student_id').val();
		$.ajax({
			url: '../admin/sms/sms_db.php',
			type: "POST",
			dataType: 'json',
			data: {
				"std_id": std_id,
				"msg_text": msg_text,
				"type": "send_std_Msg_sms"
			},
			success: function(response) {
				if (response.status == 'error') {
					console.log(response.msg)
				} else {
					$.alert({
						icon: 'bi bi-patch-question',
						theme: 'bootstrap',
						title: 'Message',
						content: 'The Message sent cost ' + response.cost +
							' and your balance is: ' +
							response.balance,
						animation: 'scale',
						type: 'orange'
					})
				}
			},
			error: function(err) {
				console.log(err);
			}
		})
	})
	//<!-------------------- END Sending general message to a student -------------------->

	//<!-------------------- Sending fees message to a student -------------------->
	$('#Stud_Fees_sms').click(function(e) {
		e.preventDefault();
		var msg_concat = $('#msg_concat').val();
		var msg_text = $('#msg_text').val();
		var std_id = $('#student_id').val();
		$.ajax({
			url: '../admin/sms/sms_db.php',
			type: "POST",
			dataType: 'json',
			data: {
				"std_id": std_id,
				"msg_concat": msg_concat,
				"msg_text": msg_text,
				"type": "send_std_fees_sms"
			},
			success: function(response) {
				if (response.status == 'error') {
					// console.log(response.msg)
					$.alert({
						icon: 'bi bi-patch-question',
						theme: 'bootstrap',
						title: 'Message',
						content: response.msg,
						animation: 'scale',
						type: 'orange'
					})
				} else {
					$.alert({
						icon: 'bi bi-patch-question',
						theme: 'bootstrap',
						title: 'Message',
						content: 'The Message sent cost ' + response.cost +
							' and your balance is: ' +
							response.balance,
						animation: 'scale',
						type: 'orange'
					})
				}
			},
			error: function(err) {
				console.log(err);
			}
		})
	})
	//<!--------------------END Sending fees message to a student -------------------->

	//<!-------------------- Sending fees message to a class -------------------->
		$('#Class_Fees_sms').click(function(e) {
			var clas = $('#tbl_class').val();
			var sms_branch = $('#sms_branch').val();
			var sms_status = $('#sms_status').val();
			if (clas == 0 || sms_branch == 0 || sms_status == 0) {
				$.alert({
					icon: 'bi bi-patch-question',
					theme: 'bootstrap',
					title: 'Message',
					content: 'One of the field is empty',
					animation: 'scale',
					type: 'orange'
				})
			} else {
				$.ajax({
					url: '../admin/sms/sms_db.php',
					type: 'POST',
					dataType: 'json',
					data: {
						"clas": clas,
						"sms_branch": sms_branch,
						"sms_status": sms_status,
						"type": "getClassListDebtors"
					},
					success: function(response) {
						if (response.query == 'false') {
							$.alert({
								icon: 'bi bi-patch-question',
								theme: 'bootstrap',
								title: 'Message',
								content: 'No student with such selections you made',
								animation: 'scale',
								type: 'orange'
							})
						} else {
							// console.log(response);
							var lists = response.studentsList;
							var succCount = 0;
							$.each(lists, function(index, value) {
								setTimeout(async function() {
									if (index == lists.length - 1) {
										$('#student_id').val(value.student_ID)
										const {message,cnt} = await getDetAndSendFeesSms(value.Phone_Number, true);
										succCount += parseInt(cnt);
										// console.log(msgg)
										$.alert({
											icon: 'bi bi-patch-question',
											theme: 'bootstrap',
											title: 'Message',
											content: message + ' total messages sent is: ' + succCount,
											animation: 'scale',
											type: 'orange'
										})
									} else {
										$('#student_id').val(value.student_ID)
										var successCount = await getDetAndSendFeesSms(value.Phone_Number);
										succCount += parseInt(successCount);
									}
								}, index * 3000);
							})
						}
					},
					error: function(err) {
						console.log(err);
					}
				})
			}
		})
	//<!--------------------END Sending fees message to a class -------------------->

	//<!-------------------- Sending General message to a class -------------------->
	$('#Class_Msg_sms').click(function(e) {
		var clas = $('#tbl_class').val();
		var sms_branch = $('#sms_branch').val();
		var sms_status = $('#sms_status').val();
		if (clas == 0 || sms_branch == 0 || sms_status == 0) {
			$.alert({
				icon: 'bi bi-patch-question',
				theme: 'bootstrap',
				title: 'Message',
				content: 'One of the field is empty',
				animation: 'scale',
				type: 'orange'
			})
		} else {
			$.ajax({
				url: '../admin/sms/sms_db.php',
				type: 'POST',
				dataType: 'json',
				data: {
					"clas": clas,
					"sms_branch": sms_branch,
					"sms_status": sms_status,
					"type": "getClassList"
				},
				success: function(response) {
					if (response.query == 'false') {
						$.alert({
							icon: 'bi bi-patch-question',
							theme: 'bootstrap',
							title: 'Message',
							content: 'No student with such selections you made',
							animation: 'scale',
							type: 'orange'
						})
					} else {
						// console.log(response);
						var lists = response.studentsList;
						var succCount = 0;
						$.each(lists, function(index, value) {
							setTimeout(async function() {
								if (index == lists.length - 1) {
									$('#student_id').val(value.Staff_ID)
									const {
										message,
										cnt
									} = await getDetAndSendGenSms(value
										.Phone_No,
										true);
									succCount += parseInt(cnt);
									// console.log(msgg)
									$.alert({
										icon: 'bi bi-patch-question',
										theme: 'bootstrap',
										title: 'Message',
										content: message +
											' total messages sent is: ' +
											succCount,
										animation: 'scale',
										type: 'orange'
									})
								} else {
									$('#student_id').val(value.Staff_ID)
									var successCount =
										await getDetAndSendGenSms(value
											.Phone_No);
									succCount += parseInt(successCount);
								}
							}, index * 3000);
						})
					}
				},
				error: function(err) {
					console.log(err);
				}
			})
		}
	})
	//<!--------------------END Sending General message to a class -------------------->

	//<!-------------------- Sending General message to a branch -------------------->
	$('#Branch_Msg_sms').click(function(e) {
		var sms_branch = $('#sms_branch').val();
		var sms_status = $('#sms_status').val();
		if (sms_branch == 0 || sms_status == 0) {
			$.alert({
				icon: 'bi bi-patch-question',
				theme: 'bootstrap',
				title: 'Message',
				content: 'One of the field is empty',
				animation: 'scale',
				type: 'orange'
			})
		} else {
			$.ajax({
				url: '../admin/sms/sms_db.php',
				type: 'POST',
				dataType: 'json',
				data: {
					"sms_branch": sms_branch,
					"sms_status": sms_status,
					"type": "getBranchList"
				},
				success: function(response) {
					if (response.query == 'false') {
						$.alert({
							icon: 'bi bi-patch-question',
							theme: 'bootstrap',
							title: 'Message',
							content: 'No student with such selections you made',
							animation: 'scale',
							type: 'orange'
						})
					} else {
						// console.log(response);
						var lists = response.studentsList;
						var succCount = 0;
						$.each(lists, function(index, value) {
							setTimeout(async function() {
								if (index == lists.length - 1) {
									$('#student_id').val(value.Staff_ID)
									const {
										message,
										cnt
									} = await getDetAndSendGenSms(value
										.Phone_No,
										true);
									succCount += parseInt(cnt);
									// console.log(msgg)
									$.alert({
										icon: 'bi bi-patch-question',
										theme: 'bootstrap',
										title: 'Message',
										content: message +
											' total messages sent is: ' +
											succCount,
										animation: 'scale',
										type: 'orange'
									})
								} else {
									$('#student_id').val(value.Staff_ID)
									var successCount =
										await getDetAndSendGenSms(value
											.Phone_No);
									succCount += parseInt(successCount);
								}
							}, index * 3000);
						})
					}
				},
				error: function(err) {
					console.log(err);
				}
			})
		}
	})
	//<!--------------------END Sending General message to a branch -------------------->

	//<!-------------------- Sending fees message to a branch -------------------->
	$('#Branch_Fees_sms').click(function(e) {
		var sms_branch = $('#sms_branch').val();
		var sms_status = $('#sms_status').val();
		if (sms_branch == 0 || sms_status == 0) {
			$.alert({
				icon: 'bi bi-patch-question',
				theme: 'bootstrap',
				title: 'Message',
				content: 'One of the field is empty',
				animation: 'scale',
				type: 'orange'
			})
		} else {
			$.ajax({
				url: '../admin/sms/sms_db.php',
				type: 'POST',
				dataType: 'json',
				data: {
					"sms_branch": sms_branch,
					"sms_status": sms_status,
					"type": "getBranchListDebtors"
				},
				success: function(response) {
					if (response.query == 'false') {
						$.alert({
							icon: 'bi bi-patch-question',
							theme: 'bootstrap',
							title: 'Message',
							content: 'No student with such selections you made',
							animation: 'scale',
							type: 'orange'
						})
					} else {
						// console.log(response);
						var lists = response.studentsList;
						var succCount = 0;
						$.each(lists, function(index, value) {
							setTimeout(async function() {
								if (index == lists.length - 1) {
									$('#student_id').val(value.student_ID)
									const {message,cnt} = await getDetAndSendFeesSms(value.Phone_Number, true);
									succCount += parseInt(cnt);
									$.alert({
										icon: 'bi bi-patch-question',
										theme: 'bootstrap',
										title: 'Message',
										content: message + ' total messages sent is: ' + succCount,
										animation: 'scale',
										type: 'orange'
									})
								} else {
									$('#student_id').val(value.student_ID)
									var successCount =await getDetAndSendFeesSms(value.Phone_Number);
									succCount += parseInt(successCount);
								}
							}, index * 3000);
						})
					}
				},
				error: function(err) {
					console.log(err);
				}
			})
		}
	})
	//<!--------------------END Sending fees message to a branch -------------------->

	//<!-------------------- Sending fees message to a branch -------------------->
	$('#Branch2_Fees2_sms2').click(function(e) {
		var sms_branch = $('#sms_branch').val();
		var sms_status = $('#sms_status').val();
		if (sms_branch == 0 || sms_status == 0) {
			$.alert({
				icon: 'bi bi-patch-question',
				theme: 'bootstrap',
				title: 'Message',
				content: 'One of the field is empty',
				animation: 'scale',
				type: 'orange'
			})
		} else {
			$.ajax({
				url: '../admin/sms/sms_db.php',
				type: 'POST',
				dataType: 'json',
				data: {
					"sms_branch": sms_branch,
					"sms_status": sms_status,
					"type": "getBranchAllList"
				},
				success: function(response) {
					if (response.query == 'false') {
						$.alert({
							icon: 'bi bi-patch-question',
							theme: 'bootstrap',
							title: 'Message',
							content: 'No student with such selections you made',
							animation: 'scale',
							type: 'orange'
						})
					} else {
						// console.log(response);
						var lists = response.studentsList;
						var succCount = 0;
						$.each(lists, function(index, value) {
							setTimeout(async function() {
								if (index == lists.length - 1) {
									$('#student_id').val(value.student_ID)
									const {message,cnt} = await getDetAndSendFeesSms(value.Phone_Number, true);
									succCount += parseInt(cnt);
									$.alert({
										icon: 'bi bi-patch-question',
										theme: 'bootstrap',
										title: 'Message',
										content: message + ' total messages sent is: ' + succCount,
										animation: 'scale',
										type: 'orange'
									})
								} else {
									$('#student_id').val(value.student_ID)
									var successCount =await getDetAndSendFeesSms(value.Phone_Number);
									succCount += parseInt(successCount);
								}
							}, index * 3000);
						})
					}
				},
				error: function(err) {
					console.log(err);
				}
			})
		}
	})
	//<!--------------------END Sending fees message to a branch -------------------->

	//<!-------------------- Sending all staff salaries msg to branch -------------------->
	$('#Staff_Salaries_sms').click(function(e) {
		var sms_branch = $('#sms_branch').val();
		var sms_status = $('#sms_status').val();
		if (sms_branch == 0 || sms_status == 0) {
			$.alert({
				icon: 'bi bi-patch-question',
				theme: 'bootstrap',
				title: 'Message',
				content: 'One of the field is empty',
				animation: 'scale',
				type: 'orange'
			})
		} else {
			$.ajax({
				url: '../admin/sms/sms_db.php',
				type: 'POST',
				dataType: 'json',
				data: {
					"sms_branch": sms_branch,
					"sms_status": sms_status,
					"type": "getStaffBranchList"
				},
				success: function(response) {
					if (response.query == 'false') {
						$.alert({
							icon: 'bi bi-patch-question',
							theme: 'bootstrap',
							title: 'Message',
							content: 'No staff with such selections you made',
							animation: 'scale',
							type: 'orange'
						})
					} else {
						// console.log(response);
						var lists = response.staffList;
						var succCount = 0;
						$.each(lists, function(index, value) {
							setTimeout(async function() {
								if (index == lists.length - 1) {
									$('#staff_id_sms').val(value
										.Staff_ID)
									const {
										message,
										cnt
									} = await getDetSendSal(value
										.Phone_No, true) ?? {};
									succCount += parseInt(cnt);
									// console.log(msgg)
									$.alert({
										icon: 'bi bi-patch-question',
										theme: 'bootstrap',
										title: 'Message',
										content: message +
											' total messages sent is: ' +
											succCount,
										animation: 'scale',
										type: 'orange'
									})
								} else {
									$('#staff_id_sms').val(value
										.Staff_ID)
									var successCount =
										await getDetSendSal(value
											.Phone_No);
									succCount += parseInt(successCount);
								}
							}, index * 3000);
						})
					}
				},
				error: function(err) {
					console.log(err);
				}
			})
		}
	})
	//<!--------------------END Sending all staff salaries msg to branch  -------------------->

	//<!-------------------- Sending individual staff salary sms -------------------->
	$('#Staff_ind_sms').click(function(e) {
		e.preventDefault();
		var msg_concat = $('#msg_concat').val();
		var msg_text = $('#msg_text').val();
		var staff_id = $('#staff_id_sms').val();
		$.ajax({
			url: '../admin/sms/sms_db.php',
			type: "POST",
			dataType: 'json',
			data: {
				"staff_id": staff_id,
				"msg_concat": msg_concat,
				"msg_text": msg_text,
				"type": "send_staff_sal_sms"
			},
			success: function(response) {
				if (response.status == 'error') {
					console.log(response.msg)
				} else {
					$.alert({
						icon: 'bi bi-patch-question',
						theme: 'bootstrap',
						title: 'Message',
						content: 'The Message sent cost ' + response.cost +
							' and your balance is: ' +
							response.balance,
						animation: 'scale',
						type: 'orange'
					})
				}
			},
			error: function(err) {
				console.log(err);
			}
		})
	})
	//<!--------------------END Sending individual staff salary sms -------------------->

	//<!-------------------- getting student details from id -------------------->
	$('#staff_id_sms').keyup(function() {
		getStaffDet()
	})
	//<!--------------------END getting student details from id -------------------->


	//<!--------------------Date range as a button -------------------->
	$('#btnPaymentSms').daterangepicker({
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

			console.log($('#ssdatee').val());
			getPaymentList()
		});
	//<!--------------------END Date range as a button -------------------->

	// function to call the list
	function getPaymentList() {
		var ssdatee = $('#ssdatee').val();
		$.ajax({
			url: '../admin/sms/sms_db.php',
			type: 'POST',
			dataType: 'json',
			cache: false,
			data: {
				"ssdatee": ssdatee,
				'type': 'getPaymentList'
			},
			success: function(response) {
				$('#title').val(response.title);
				$('#paymentList').html(response.html);
			},
			error: function(err) {
				console.log(err)
			}
		})
	}
	setInterval(getPaymentList, 1500);

	//function to send sms to payment list
	$('#Payment_SMS').click(function(e) {
		e.preventDefault();
		var ssdatee = $('#ssdatee').val();
		$.ajax({
			url: '../admin/sms/sms_db.php',
			type: 'POST',
			dataType: 'json',
			cache: false,
			data: {
				"ssdatee": ssdatee,
				'type': 'sendSMSToPaymentList'
			},
			success: function(response) {
				// console.log(response);
				$.alert({
					icon: 'bi bi-patch-question',
					theme: 'bootstrap',
					title: 'Message',
					content: response.msg,
					animation: 'scale',
					type: 'orange'
				})
			},
			error: function(err) {
				console.log(err)
			}
		})
	})

	// clear sent function
	$('#Clear_sms').click(function(e) {
		e.preventDefault();
		var ssdatee = $('#ssdatee').val();
		$.ajax({
			url: '../admin/sms/sms_db.php',
			type: 'POST',
			dataType: 'json',
			cache: false,
			data: {
				"ssdatee": ssdatee,
				'type': 'clearSMSOfPaymentList'
			},
			success: function(response) {
				// console.log(response);
				$.alert({
					icon: 'bi bi-patch-question',
					theme: 'bootstrap',
					title: 'Message',
					content: response.msg,
					animation: 'scale',
					type: 'orange'
				})
			},
			error: function(err) {
				console.log(err)
			}
		})
	})
})
</script>