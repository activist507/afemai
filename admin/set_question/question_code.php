<?php 

    $qstClass = $conn->query("SELECT * FROM cbt_class");
	$classes = fetch_all_assoc($qstClass);
    $sqlqstcode = $conn->query("SELECT * FROM question_codes ORDER BY id ASC");
	$sqlInter = $conn->query("SELECT * FROM cbt_staff_subject ORDER BY id ASC");
    $allquestions = $conn->query("SELECT * FROM questions ORDER BY id DESC");

	$sqlformats = $conn->query("SELECT * FROM cbt_exam_format");
	$formats = fetch_all_assoc($sqlformats);
?>

<main id="main" class="main">
	<section class="section">
		<div class="card">
			<div class="card-body">

				<!-- create class -->
				<div class="row gy-3 py-3 pt-1">
					<div class="col-lg-4">
						<div class="tom-select-custom">
							<input type="text" class="form-control text-center" value="CREATE CLASSES" name=""
								style="background:rgba(233, 240, 239, 0.93);" disabled>
						</div>
					</div>

					<div class="col-lg-2">
						<div class="tom-select-custom">
							<select name="cre_class" id="cre_class" class="form-control" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Class">
								<option>Select Class</option>
								<?php foreach($classes as $class){ ?>
								<option value="<?= $class['class']?>"><?= $class['class']?></option>
								<?php }?>
							</select>
						</div>
					</div>

					<!-- <div class="col-lg-2"></div>
                    <div class="col-lg-2"></div> -->

					<div class="col-lg-2">
						<button type="btn" id="create_class" style="width: 8.7rem;" class="btn btn-info w-100">
							Create Class
						</button>
					</div>

					<div class="col-lg-4">
						<div class="tom-select-custom">
							<input type="text" class="form-control text-center" value="SET EXAMINATION CODES" name=""
								style="background:rgba(233, 240, 239, 0.93);" disabled>
						</div>
					</div>
				</div>

				<!-- SET EXAM CODES  -->


				<div class="row gy-2">
					<?php while($q_code = $sqlqstcode->fetch_object()){?>
					<div class="col-lg-2 pt-0">
						<div class="tom-select-custom">
							<input type="text" class="form-control text-center class_code" value="<?= $q_code->class?>"
								name="class_code" style="background:rgba(233, 240, 239, 0.93);" readonly>
						</div>
					</div>
					<div class="col-lg-1 pt-0">
						<div class="tom-select-custom">
							<input type="text" class="form-control text-center exam_code" placeholder="Obj"
								value="<?=  $q_code->question_code?>" name="exam_code">
						</div>
					</div>
					<div class="col-lg-1 pt-0">
						<div class="tom-select-custom">
							<input type="text" class="form-control text-center exam_code_theo" placeholder="Theo"
								value="<?=  $q_code->theory_code?>" name="exam_code_theo">
						</div>
					</div>
					<?php }?>
					
					<div class="col-lg-4 pt-0">
						<div class="tom-select-custom">
							<select name="format_type" id="format_type" class="form-control" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Format">
								<?php foreach($formats as $format){?>
								<option value="<?= $format['id']?>"><?= $format['name']?></option>
								<?php }?>
							</select>
						</div>
					</div>

					<div class="col-lg-2 pt-0">
						<button type="btn" style="width: 8.7rem;" class="btn btn-primary w-100" id="set_format">
							Set Format
						</button>
					</div>

					<div class="col-lg-2 pt-0">
					</div>
					<div class="col-lg-2 pt-0">
					</div>

					<div class="col-lg-2 pt-0">
						<button type="btn" id="set_exam_code_btn" style="width: 8.7rem;"
							class="btn btn-primary w-100">
							Submit Code
						</button>
					</div>
				</div>

				<!-- SET INTERVIEW SUBJECTS -->
				<div class="col-lg-12 pt-2">
					<div class="tom-select-custom">
						<input type="text" class="form-control text-center" value="SET INTERVIEW SUBJECT" name=""
							style="background:rgba(233, 240, 239, 0.93);" disabled>
					</div>
				</div>
				<div class="row gy-2">
					<?php while($inter = $sqlInter->fetch_object()){?>
					<div class="col-lg-2 pt-1">
						<div class="tom-select-custom">
							<input type="text" class="form-control text-center inter_id" value="<?=$inter->id?>"
								name="class_code" style="background:rgba(233, 240, 239, 0.93);" readonly>
						</div>
					</div>
					<div class="col-lg-2 pt-1">
						<div class="tom-select-custom">
							<input type="text" class="form-control text-center inter_subject"
								value="<?=$inter->subject?>" name="inter_subject">
						</div>
					</div>
					<?php }?>
					<div class="col-lg-2 pt-0">
					</div>

					<div class="col-lg-2 text-end">
						<button type="btn" id="set_inter_qst_btn" style="width: 8.7rem;"
							class="btn btn-primary w-100 pt-0">
							Submit Inter
						</button>
					</div>
				</div>

				<!-- SET STUDENT PASSWORD -->
				<div class="col-lg-12 pt-2">
					<div class="tom-select-custom">
						<input type="text" class="form-control text-center" value="SET STUDENT'S PASSWORD" name=""
							style="background:rgba(233, 240, 239, 0.93);" disabled>
					</div>
				</div>

				<div class="row gy-3 pt-2">
					<div class="col-lg-2">
						<div class="tom-select-custom">
							<select name="act_inact" id="act_inact" class="form-control" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Status">
								<option>Active</option>
								<option>Inactive</option>
							</select>
						</div>
					</div>

					<div class="col-lg-2 pt-0">
						<div class="tom-select-custom">
							<select name="pass_act_class" id="pass_act_class" class="form-control"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Select Class">
								<option value="">Select Class</option>
								<?php foreach($classes as $class){ ?>
								<option value="<?= $class['class']?>"><?= $class['class']?></option>
								<?php }?>
							</select>
						</div>
					</div>

					<div class="col-lg-2">
						<button type="btn" style="width: 8.7rem;" class="btn btn-primary w-100 clicked_btn"
							value="Activate">
							Activate
						</button>
					</div>

					<div class="col-lg-2 pt-0">
						<div class="tom-select-custom">
							<input type="text text-center" name="typ_pass" id="typ_pass"
								class="form-control text-center" placeholder="Password" data-bs-toggle="tooltip" data-bs-placement="top"
								title="Type Password">
							</input>
						</div>
					</div>

					<div class="col-lg-2 pt-0">
						<div class="tom-select-custom">
							<input type="text text-center" name="stud_id_act" id="stud_id_act"
								class="form-control text-center" placeholder="student ID" data-bs-toggle="tooltip" data-bs-placement="top"
								title=" student ID">
							</input>
						</div>
					</div>

					<div class="col-lg-2 pt-0">
						<button type="btn" style="width: 8.7rem;" class="btn btn-primary w-100 clicked_btn"
							value="set_password">
							Set Password
						</button>
					</div>
				</div>

				<!-- DELETE STUDENTS' ANSWERS -->
				<div class="col-lg-12 pt-3">
					<div class="tom-select-custom">
						<input type="text" class="form-control text-center" value="DELETE STUDENT_CLASS_ALL ANSWERS"
							name="" style="background:rgba(233, 240, 239, 0.93);" disabled>
					</div>
				</div>

				<div class="row gy-3">
					<div class="col-lg-2 pt-3">
						<div class="tom-select-custom">
							<input type="text" name="exam_id_ans" id="exam_id_ans" class="form-control text-center"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Exam_ID"
								placeholder="Enter Exam_ID">
							</input>
						</div>
					</div>

					<div class="col-lg-2 pt-3">
						<div class="tom-select-custom">
							<input type="text text-center" name="Subjects" id="subject" class="form-control text-center"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Subject" placeholder="Subject"
								readonly>
							</input>
						</div>
					</div>

					<div class="col-lg-2 pt-3">
						<div class="tom-select-custom">
							<select name="ans_tbl_class" id="ans_tbl_class" class="form-control"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Select Class">
								<option value="">Select Class</option>
								<?php foreach($classes as $class){ ?>
								<option value="<?= $class['class']?>"><?= $class['class']?></option>
								<?php }?>
							</select>
						</div>
					</div>

					<div class="col-lg-2 pt-3">
						<div class="tom-select-custom">
							<input type="text text-center" name="del_stud_ans" id="del_stud_ans"
								class="form-control text-center" data-bs-toggle="tooltip" data-bs-placement="top"
								title="Stud_ID" placeholder="Student_ID">
							</input>
						</div>
					</div>

					<div class="col-lg-4 pt-3">
						<div class="tom-select-custom">
							<input type="text text-center" name="Stud_Name" id="Stud_Name"
								class="form-control text-center" data-bs-toggle="tooltip" data-bs-placement="top"
								title="Student Name" placeholder="Student Name" readonly>
							</input>
						</div>
					</div>

					<div class="row gy-2">
						<!-- <div class="col-lg-2"></div>
						<div class="col-lg-2"></div>
						<div class="col-lg-2"></div> -->

						<div class="col-lg-4 pt-1">
							<button type="btn" style="width: 8.7rem;" class="btn btn-danger w-100 del_ans_btn mx-1"
								value="del_stud">
								Del_Student
							</button>
						</div>

						<div class="col-lg-4 pt-1">
							<button type="btn" style="width: 8.7rem;" class="btn btn-info w-100 del_ans_btn mx-2 "
								value="del_class">
								Del_Class
							</button>
						</div>

						<div class="col-lg-4 pt-1">
							<button type="btn" style="width: 8.7rem;" class="btn btn-danger w-100 mx-3" id="del_all">
								Delete_All
							</button>
						</div>
					</div>
				</div>

				<!-- VIEW STUDENTS' SCORES -->
				<div class="col-lg-12 pt-2">
					<div class="tom-select-custom">
						<input type="text" class="form-control text-center" value="VIEW STUDENTS' SCORES" name=""
							style="background:rgba(233, 240, 239, 0.93);" disabled>
					</div>
				</div>

				<!-- <div class="row gy-3 pt-2">
					<div class="col-lg-6">
						<div class="tom-select-custom">
							<select name="format_type" id="format_type" class="form-control" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Format">
								<?php foreach($formats as $format){?>
								<option value="<?= $format['id']?>"><?= $format['name']?></option>
								<?php }?>
							</select>
						</div>
					</div>

					<div class="col-lg-2 pt-0">
						<button type="btn" style="width: 8.7rem;" class="btn btn-primary w-100" id="set_format">
							Set Format
						</button>
					</div>
				</div> -->

				<!-- Answers table display -->
				<div class="table-responsive pt-0">
					<div class="row py-2">				
						<div class="col-lg-2 col-sm-12">
							<select class="form-select" id="limit2" data-bs-toggle="tooltip" data-bs-placement="top"
								title="Entries Per Page">
								<option selected value="10">10</option>
								<option value="20">20</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</div>
						<div class="col-6"></div>
						<div class="col-lg-4 col-sm-12 pt-0">
							<div class="input-group">
								<input type="text" placeholder="search" class="form-control" id="search2">
								<span class="input-group-text"><i class="bi bi-search"></i></span>
							</div>
						</div>
					</div>
					<table class="table table-striped small">
						<thead>
							<tr>
								<th scope="col" nowrap="nowrap">Q-ID</th>
								<th scope="col" nowrap="nowrap">Stud ID</th>
								<th scope="col" nowrap="nowrap">Subject</th>
								<th scope="col" nowrap="nowrap">Score</th>
								<th scope="col" nowrap="nowrap">Name</th>
							</tr>
						</thead>
						<tbody id="ans_entry">

						</tbody>
					</table>
					<nav>
						<ul class="pagination pagination-sm" id="pagination2">
							<!-- Pagination buttons -->
						</ul>
					</nav>
				</div>

				<!-- exam code display -->
				<div class="row">
					<div class="col-lg-6 col-sm-12">
						<div class="table-responsive pt-2">
							<div class="row py-2">
								<div class="col-lg-6 col-sm-12 pt-1">
									<select class="form-select" id="limit1" data-bs-toggle="tooltip" data-bs-placement="top"
										title="Entries Per Page">
										<option selected value="10">10</option>
										<option value="20">20</option>
										<option value="50">50</option>
										<option value="100">100</option>
									</select>
								</div>
								<div class="col-lg-6 col-sm-12 pt-1">
									<div class="input-group">
										<input type="text" placeholder="search" class="form-control" id="search1">
										<span class="input-group-text"><i class="bi bi-search"></i></span>
									</div>
								</div>
							</div>
							<table class="table table-striped small">
								<thead>
									<tr>
										<th scope="col" nowrap="nowrap">Q-ID</th>
										<th scope="col" nowrap="nowrap">Subject</th>
										<th scope="col" nowrap="nowrap">Class</th>
										<th scope="col" nowrap="nowrap">Test</th>
										<th scope="col" nowrap="nowrap">Term</th>
										<th scope="col" nowrap="nowrap">T - Q</th>
										<th scope="col" nowrap="nowrap">A.Mark</th>
										<th scope="col" nowrap="nowrap">T.Mark</th>
										<th scope="col" nowrap="nowrap">Time</th>
										<th scope="col" nowrap="nowrap">E.Time</th>
									</tr>
								</thead>
								<tbody id="allQuest1">

								</tbody>
							</table>
							<nav>
								<ul class="pagination pagination-sm" id="pagination1">
									<!-- Pagination buttons -->
								</ul>
							</nav>
						</div>
					</div>
					<div class="col-lg-6 col-sm-12">
						<div class="table-responsive pt-2">
							<div class="row py-2">
								<div class="col-lg-6 col-sm-12 pt-1">
									<select class="form-select" id="limit3" data-bs-toggle="tooltip" data-bs-placement="top"
										title="Entries Per Page">
										<option selected value="10">10</option>
										<option value="20">20</option>
										<option value="50">50</option>
										<option value="100">100</option>
									</select>
								</div>
								<div class="col-lg-6 col-sm-12 pt-1">
									<div class="input-group">
										<input type="text" placeholder="search" class="form-control" id="search3">
										<span class="input-group-text"><i class="bi bi-search"></i></span>
									</div>
								</div>
							</div>
							<table class="table table-striped small">
								<thead>
									<tr>
										<th scope="col" nowrap="nowrap">Q-ID</th>
										<th scope="col" nowrap="nowrap">Subject</th>
										<th scope="col" nowrap="nowrap">Class</th>
										<th scope="col" nowrap="nowrap">Test</th>
										<th scope="col" nowrap="nowrap">Term</th>
										<th scope="col" nowrap="nowrap">T - Q</th>
										<th scope="col" nowrap="nowrap">A.Mark</th>
										<th scope="col" nowrap="nowrap">T.Mark</th>
										<th scope="col" nowrap="nowrap">Time</th>
										<th scope="col" nowrap="nowrap">E.Time</th>
									</tr>
								</thead>
								<tbody id="allQuest3">

								</tbody>
							</table>
							<nav>
								<ul class="pagination pagination-sm" id="pagination3">
									<!-- Pagination buttons -->
								</ul>
							</nav>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</section>
</main>


<script type="text/javascript">
$(document).ready(function() {
	// <!-- create class -->
	$('#create_class').click(function(e) {
		e.preventDefault();

		var cre_class = $('#cre_class').val();
		$.ajax({
			// url: './admFunctions.php',
			url: '../admin/set_question/question_code_db.php',
			type: "POST",
			dataType: 'json',
			data: {
				"cre_class": cre_class,
				"type": "createClass"
			},
			success: function(response) {
				$.alert({
					title: 'Message',
					content: response.msg,
					buttons: {
						ok: function() {
							$('#cre_class').val('');
						}
					}
				});
			},
			error: function(err) {
				console.log(err);
			}
		})
	})

	// <!-- SET EXAM CODES  -->
	$('#set_exam_code_btn').click(function(e) {
		e.preventDefault();

		var class_codes = $('.class_code').serializeArray();
		var exam_codes = $('.exam_code').serializeArray();
		var exam_codes_theo = $('.exam_code_theo').serializeArray();

		var arr_class_codes = $.map(class_codes, function(item) {return item.value});
		var arr_exam_codes = $.map(exam_codes, function(item) {return item.value});
		var arr_exam_codes_theo = $.map(exam_codes_theo, function(item) { return item.value});

		$.ajax({
			// url: './admFunctions.php',
			url: '../admin/set_question/question_code_db.php',
			type: "POST",
			dataType: 'json',
			data: {
				"arr_exam_codes": arr_exam_codes,
				"arr_class_codes": arr_class_codes,
				"arr_exam_codes_theo": arr_exam_codes_theo,
				"type": "updateQuestionCode"
			},
			success: function(response) {
				// console.log(response.codes);
				$.alert({
					title: 'Message',
					content: response.msg,
					buttons: {
						ok: function() {
							location.reload(true);
						}
					}
				});
			},
			error: function(err) {
				console.log(err);
			}
		})
		// console.log(arr)
	})

	// <!-- SET INTERVIEW SUBJECT -->
	$('#set_inter_qst_btn').click(function(e) {
		e.preventDefault();

		var inter_id = $('.inter_id').serializeArray();
		var inter_subject = $('.inter_subject').serializeArray();

		var arr_inter_id = $.map(inter_id, function(item) {
			return item.value;
		});
		var arr_inter_subject = $.map(inter_subject, function(item) {
			return item.value;
		});

		$.ajax({
			// url: './admFunctions.php',
			url: '../admin/set_question/question_code_db.php',
			type: "POST",
			dataType: 'json',
			data: {
				"arr_inter_id": arr_inter_id,
				"arr_inter_subject": arr_inter_subject,
				"type": "updateInterviewQst"
			},
			success: function(response) {
				// console.log(response.codes);
				$.alert({
					title: 'Message',
					content: response.msg,
					buttons: {
						ok: function() {
							location.reload(true);
						}
					}
				});
			},
			error: function(err) {
				console.log(err);
			}
		})
		// console.log(arr)
	})

	//<!-- SET STUDENT PASSWORD -->
	$('.clicked_btn').click(function(e) {
		var check = $(this).val();
		var selected_class = $('#pass_act_class').val();
		var stat = $('#act_inact').val();
		var typ_pass = $('#typ_pass').val();
		var stud_id = $('#stud_id_act').val();
		var gen_branch = $('#gen_branch').val();
		if (check == 'Activate') {
			$.ajax({
				url: '../admin/set_question/question_code_db.php',
				// url: './admFunctions.php',
				type: "POST",
				dataType: 'json',
				data: {
					"selected_class": selected_class,
					"stat": stat,
					"stud_id": stud_id,
					"gen_branch": gen_branch,
					"type": "updating_status"
				},
				success: function(response) {
					$.alert({
						title: 'Message',
						content: response.msg,
						buttons: {
							ok: function() {
								$('#pass_act_class').val('');
								$('#stud_id_act').val('');
								$('#typ_pass').val('');
								// location.reload(true);
							}
						}
					});
					// console.log(response.msg);
				},
				error: function(err) {
					console.log(err);
				}
			})
		} else if (check == 'set_password') {
			$.ajax({
				// url: './admFunctions.php',
				url: '../admin/set_question/question_code_db.php',
				type: "POST",
				dataType: 'json',
				data: {
					"selected_class": selected_class,
					"typ_pass": typ_pass,
					"stud_id": stud_id,
					"gen_branch": gen_branch,
					"type": "updating_password"
				},
				success: function(response) {
					$.alert({
						title: 'Message',
						content: response.msg,
						buttons: {
							ok: function() {
								$('#pass_act_class').val('');
								$('#stud_id_act').val('');
								$('#typ_pass').val('');
							}
						}
					});
				},
				error: function(err) {
					console.log(err);
				}
			})
		}
	})

	//<!-- DELETE STUDENT ENTRY IN ANSWER_TBL -->
	$('.del_ans_btn').click(function(e) {
		var check = $(this).val();
		var exam_code = $('#exam_id_ans').val();
		var stud_id = $('#del_stud_ans').val();
		var tbl_class = $('#ans_tbl_class').val();
		if (exam_code == '') {
			$.alert({
				title: 'Message',
				content: 'No exam code is entered',
				buttons: {
					close: function() {}
				}
			});
		} else if (stud_id == '' && tbl_class == '') {
			$.alert({
				title: 'Message',
				content: 'Please select a class or type a student ID',
				buttons: {
					close: function() {

					}
				}
			});
		} else if (stud_id == '' && check == 'del_stud') {
			$.alert({
				title: 'Message',
				content: 'Student ID field is empty',
				buttons: {
					close: function() {

					}
				}
			});
		} else if (tbl_class == '' && check == 'del_class') {
			$.alert({
				title: 'Message',
				content: 'No class has been selected yet',
				buttons: {
					close: function() {

					}
				}
			});
		} else {
			$.confirm({
				title: 'CONFIRM',
				content: 'Are you sure you want to delete these records?',
				buttons: {
					confirm: {
						btnClass: 'btn-green',
						text: 'Yes',
						action: function() {
							$.ajax({
								// url: './admFunctions.php',
								url: '../admin/set_question/question_code_db.php',
								type: "POST",
								dataType: 'json',
								data: {
									"exam_code": exam_code,
									"stud_id": stud_id,
									"tbl_class": tbl_class,
									"btn_clicked": check,
									"type": "delete_frm_answer"
								},
								success: function(response) {
									$.alert({
										title: 'Message',
										content: response.msg,
										buttons: {
											ok: function() {
												$('#exam_id_ans')
													.val('');
												$('#del_stud_ans')
													.val(
														'');
												$('#ans_tbl_class')
													.val('');
												$('#Stud_Name').val(
													'');
											}
										}
									});
								},
								error: function(err) {
									console.log(err);
								}
							})
						}
					},
					cancelAction: {
						btnClass: 'btn-red',
						text: 'No',
						close: function() {

						}
					},
				}
			});

		}

	})

	//<!-- EMPTY ALL ENTRIES IN ANSWER_TBL -->
	$('#del_all').click(function(e) {
		$.confirm({
			title: 'CONFIRM',
			content: 'Are you sure you want to delete these records?',
			buttons: {
				confirm: {
					btnClass: 'btn-green',
					text: 'Yes',
					action: function() {
						$.ajax({
							url: '../admin/set_question/question_code_db.php',
							type: "POST",
							dataType: 'json',
							data: {
								"type": "delete_all_frm_answer"
							},
							success: function(response) {
								$.alert({
									title: 'Message',
									content: response.msg,
									buttons: {
										ok: function() {
											$('#exam_id_ans')
												.val('');
											$('#del_stud_ans').val(
												'');
											$('#ans_tbl_class').val(
												'');
										}
									}
								});
							},
							error: function(err) {
								console.log(err);
							}
						})
					}
				},
				cancelAction: {
					btnClass: 'btn-red',
					text: 'No',
					close: function() {

					}
				},
			}
		});
	})

	// set format 
	$('#set_format').click(function(e) {
		var formatID = $('#format_type').val();
		// console.log(formatID);
		$.ajax({
			url: '../admin/set_question/question_code_db.php',
			type: "POST",
			dataType: 'json',
			data: {
				"formatID": formatID,
				"type": "set_format"
			},
			success: function(response) {
				$.alert({
					title: 'Message',
					content: response.msg,
					buttons: {
						ok: function() {
							location.reload(true);
						}
					}
				});
			},
			error: function(err) {
				console.log(err);
			}
		})
	})

	//<!-- auto update answer entry -->
	// setInterval(() => {
	// $.ajax({
	// 	url: '../admin/set_question/question_code_db.php',
	// 	type: "POST",
	// 	dataType: 'json',
	// 	data: {
	// 		"type": "dynamic_ans_entry"
	// 	},
	// 	success: function(response) {
	// 		// console.log(response.codes);
	// 		$('#ans_entry').html(response.html);
	// 	},
	// 	error: function(err) {
	// 		console.log(err);
	// 	}
	// })
	// }, 3000);

	// <!--  -->
	$('#exam_id_ans').keyup(function(e) {
		var exam_code = $(this).val();
		if (exam_code.length > 6) {
			// console.log(id);
			$.ajax({
				url: '../admin/set_question/question_code_db.php',
				type: "POST",
				dataType: 'json',
				data: {
					"exam_code": exam_code,
					"type": "getSubjectFromCode"
				},
				success: function(response) {
					if (response.query == 'true') {
						$('#subject').val(response.subject);
					}
				},
				error: function(err) {
					console.log(err);
				}
			})
		} else if (exam_code.length < 7) {
			$('#subject').val('');
		}
	})

	// <!--  del_stud_ans-->
	$('#del_stud_ans').keyup(function(e) {
		var stud_id = $(this).val();
		if (stud_id.length == 4) {
			$.ajax({
				url: '../admin/set_question/question_code_db.php',
				type: "POST",
				dataType: 'json',
				data: {
					"stud_id": stud_id,
					"type": "getStudentName"
				},
				success: function(response) {
					if (response.query == 'true') {
						$('#Stud_Name').val(response.stud_name);
					}
				},
				error: function(err) {
					console.log(err);
				}
			})
		} else if (stud_id.length < 4) {
			$('#Stud_Name').val('');
		}
	})

	// $(document).on('dblclick', ".tr_qst", function() {
	$(".tr_qst").dblclick(function() {
		var id = $(this).attr("data-id_qst");
		navigator.clipboard.writeText(id).then(function() {
			toastr.success(id + " Copied to clipboard");
		}).catch(function(err) {
			toastr.danger("Failed to copy: " + err);
		});
	})

	// <!-- getting question -->
		function loadData1(page = 1, search = '') {
			const limit = $('#limit1').val();
			$.ajax({
				url: '../admin/set_question/question_code_db.php',
				type: 'POST',
				data: {
					"page": page,
					"limit": limit,
					"search": search,
					"type": "paginateQst"
				},
				dataType: 'json',
				success: function(response) {
					$('#allQuest1').html(response.html);
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
					$('#pagination1').html(pagination);
				}
			});
		}
		// Initial load
		loadData1();

		// <!-- Pagination Click Event  -->
			$('#pagination1').on('click', '.page-link', function(e) {
				e.preventDefault();
				const page = $(this).data('page');
				const search = $('#search1').val();
				if (page) {
					loadData1(page, search);
				}
			});
		// <!-- END Pagination Click Event  -->

		// <!-- Search Keyup Event (debounced)  -->
			let typingTimer;
			$('#search1').on('keyup', function() {
				clearTimeout(typingTimer);
				typingTimer = setTimeout(function() {
					loadData1(1, $('#search1').val());
				}, 500); // delay to avoid too many requests
			});
		// <!--END Search Keyup Event (debounced)  -->

		// <!-- 3 seconds calling  -->
			setInterval(() => {
				var activePge = parseInt($('#pagination1 li.active .page-link').text());
				if (isNaN(activePge)) {
					activePge = 1;
				}
				var serch = $('#search1').val()
				loadData1(activePge, serch);
			}, 3000);
		// <!-- END 3 seconds calling  -->
	// <!-- END getting question  -->

	// <!-- getting question  -->
		function loadData3(page = 1, search = '') {
			const limit = $('#limit3').val();
			$.ajax({
				url: '../admin/set_question/question_code_db.php',
				type: 'POST',
				data: {
					"page": page,
					"limit": limit,
					"search": search,
					"type": "paginateQst3"
				},
				dataType: 'json',
				success: function(response) {
					$('#allQuest3').html(response.html);
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
					$('#pagination3').html(pagination);
				}
			});
		}
		// Initial load
		loadData3();

		// <!-- Pagination Click Event  -->
			$('#pagination3').on('click', '.page-link', function(e) {
				e.preventDefault();
				const page = $(this).data('page');
				const search = $('#search3').val();
				if (page) {
					loadData3(page, search);
				}
			});
		// <!-- END Pagination Click Event  -->

		// <!-- Search Keyup Event (debounced)  -->
			let typingTimer3;
			$('#search3').on('keyup', function() {
				clearTimeout(typingTimer3);
				typingTimer3 = setTimeout(function() {
					loadData3(1, $('#search3').val());
				}, 500); // delay to avoid too many requests
			});
		// <!--END Search Keyup Event (debounced)  -->

		// <!-- 3 seconds calling  -->
			setInterval(() => {
				var activePge = parseInt($('#pagination3 li.active .page-link').text());
				if (isNaN(activePge)) {
					activePge = 1;
				}
				var serch = $('#search3').val()
				loadData3(activePge, serch);
			}, 3000);
		// <!-- END 3 seconds calling  -->
	// <!-- END getting question  -->

	// <!-- getting answer entry  -->
		function loadData2(page = 1, search = '') {
			const limit = $('#limit2').val();
			$.ajax({
				url: '../admin/set_question/question_code_db.php',
				type: 'POST',
				data: {
					"page": page,
					"limit": limit,
					"search": search,
					"type": "paginateAns"
				},
				dataType: 'json',
				success: function(response) {
					$('#ans_entry').html(response.html);
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
			var serch = $('#search2').val()
			loadData2(activePge, serch);
		}, 3000);
		// <!-- END 3 seconds calling  -->
	// <!-- END answer entry  -->
})
</script>