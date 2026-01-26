<?php 

$subjects = $conn->query("SELECT * FROM cbt_staff_subject")->fetch_all(MYSQLI_ASSOC);

?>
<main id="main" class="main">
	<section class="section">
		<div class="card pb-2">
                <div class="card-body pb-2">

                    <div class="row pt-2">
                        <div class="col-lg-12">
                            <h5 class="card-title text-center pt-1">STAFF EVALUATION DETAILS</h5>
                        </div>
                    </div>

                    <div class="row pt-0">
                        <div class="col-lg-4">
                        </div>
                        <div class="col-lg-4 text-center mb-2">
                            <img src="../storege/students/no_image.jpg" id="img_of_stud" class="rounded-circle mx-4"
                                alt="" style="width: 5rem; height: 5rem;" />
                        </div>
                        <div class="col-lg-4">
                        </div>
                    </div>

                    <form action="" class="g-3 pt-2" id="stdRegForm" method="POST" enctype="multipart/form-data">
                        <div class="row pb-2 gy-2">
                            <div class="col-lg-2 col-sm-12">
                                <input type="text" class="form-control text-center pt-0" id="inv_ID" name="inv_ID"
                                    maxlength="9"  placeholder="ID" />
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <input type="text" class="form-control pt-0" id="Fullnames" name="Fullnames" disabled
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Staff Fullnames"
                                    placeholder="Fullnames"  />
                            </div>

                            <div class="col-lg-2 col-sm-12">
								<input type="text" class="form-control pt-0" id="staff_gender" name="Gender" disabled
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Staff Gender"
                                    placeholder="Gender"  />
                            </div>
                            <div class="col-lg-2 col-sm-12">
                                <input type="date" class="form-control pt-0" id="staff_dob" 
                                    name="staff_dob" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Date Of Birth" disabled />
                            </div>
                        </div>

                        <!-- Select Status -->
                        <div class="row pb-2 gy-2">
                            <div class="col-lg-2 col-sm-12">
								<input type="text" class="form-control pt-0" id="staff_qualification" name="staff_qualification" disabled
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Staff Qualification"
                                    placeholder="Qualification"  />
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <input type="text" class="form-control pt-0" id="area_spec"
                                    name="area_spec" placeholder="Area Of Specialisation" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Area Of Specialisation" disabled/>
                            </div>
                            <div class="col-lg-2 col-sm-12">
                                <input type="text" class="form-control pt-0" id="staff_phone" 
                                    name="staff_phone" placeholder="Whatsapp Phone Number" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Whatsapp Phone Number" disabled />
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <input type="text" class="form-control pt-0" id="staff_email" 
                                    name="staff_email" placeholder="Email" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Staff Email" disabled/>
                            </div>
                        </div>
                        <!-- End staff details -->

                        <!-- n info -->

                        <div class="row pb-2 gy-2">
                            <div class="col-lg-6 col-sm-12">
                                <input type="text" class="form-control pt-0"  id="staff_address"
                                    name="staff_address" placeholder="Address" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Staff Address" disabled />
                            </div>
                            <div class="col-lg-2 col-sm-12">
								<input type="text" class="form-control pt-0" id="religion" name="religion" disabled
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Staff religion"
                                    placeholder="religion"  />
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <input type="text" class="form-control pt-0"  id="staff_comment"
                                    name="staff_comment" placeholder="Comment" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Staff Comment" disabled/>
                            </div>
                        </div>
                        <!-- <div class="row pb-2 gy-2 mx-0" id="subjectsList">
                            
                        </div> -->
                        <div class="row pb-2 gy-2">
                            <div class="col-lg-12 col-sm-12">
                                <input type="text" class="form-control pt-0" id="s_skills"
                                    name="s_skills" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Special Skills" placeholder="Special skills" disabled/>
                            </div>
                        </div>

                    </form>

					<h5 class="card-title text-center">Generate Invitation Code</h5>
					<form class="g-3" id="genCodeForm">
						<div class="row gy-3">
							<div class="col-lg-6 col-sm-5">
								<label for="">Number To Generate</label>
								<input type="number" class="form-control text-center" id="numbGen" name="numbGen" min="1" />
							</div>
							<div class="col-lg-3 col-sm-2">
								<button type="submit" style="width: 8.5rem;" class="btn btn-primary w-100 mt-4"
									name="genInvCode">
									Generate
								</button>
							</div>
							<div class="col-lg-3 col-sm-2">
								<button type="button" style="width: 8.5rem;" class="btn btn-danger w-100 mt-4"
									id="deleteCode">
									Delete Code
								</button>
							</div>
						</div>
					</form>

                </div>
            </div>
		<div class="card">
			<div class="card-body">
				<div class="table-responsive pt-3">
					<h5 class="card-title text-center">Staff Score List</h5>
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
						<div class="col-lg-4 col-sm-12 pt-1">
							<div class="input-group">
								<input type="text" placeholder="search" class="form-control" id="search2">
								<span class="input-group-text"><i class="bi bi-search"></i></span>
							</div>
						</div>
					</div>
					<table class="table table-striped small">
						<thead>
							<tr>
								<th scope="col" nowrap="nowrap">ID</th>
								<th scope="col" nowrap="nowrap">Inv.Code</th>
								<th scope="col" nowrap="nowrap">Name</th>
								<th scope="col" nowrap="nowrap">Score</th>
								<th scope="col" nowrap="nowrap">Action</th>
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
			</div>
		</div>
	</section>
</main>
<script type="text/javascript">
$(document).ready(function() {
	$('#genCodeForm').on('submit', function(e) {
		e.preventDefault();
		var numbGen = $('#numbGen').val();
		if (numbGen < 1) {
			$.confirm({
				icon: 'bi bi-patch-question',
				theme: 'bootstrap',
				title: 'Message',
				content: 'Please enter a number greater than 0',
				animation: 'scale',
				type: 'orange'
			})
		} else {
			$.ajax({
				url: '../admin/adm_staff/staff_eval_db.php',
				type: "POST",
				dataType: 'json',
				data: {
					"numbGen": numbGen,
					"type": "generateInvCode"
				},
				success: function(response) {
					$.alert({
						title: 'Message',
						content: response.msg,
						buttons: {
							ok: function() {
								window.location = './?staff_eval';
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

	function getEvaluatedStaff(invcode){
		$.post('../admin/adm_staff/staff_eval_db.php',{"type":"getEvalStaffDet","invCode":invcode},null,"json")
			.done(function(data){
				$('#inv_ID').val(data.inv_ID);
				$('#Fullnames').val(data.fullname);
				$('#staff_gender').val(data.gender);
				$('#staff_dob').val(data.dob);
				$('#staff_qualification').val(data.qual);
				$('#area_spec').val(data.area_spec);
				$('#staff_phone').val(data.phone);
				$('#staff_email').val(data.email);
				$('#staff_address').val(data.add);
				$('#religion').val(data.religion);
				$('#staff_comment').val(data.comm);
				$('#s_skills').val(data.skill);
				$('html,body').animate({scrollTop: 0}, 'fast');
				// $('#subjectsList').html(data.subHtml)
			})
			.fail(function(err){console.log(err)});
	}

	$('#ans_entry').on('click','.tr_qst',function(e){
		var invCode = $(this).attr("data-id");
		getEvaluatedStaff(invCode);
	})

	$('#inv_ID').keyup(function(e){
		var invCode = $(this).val();
		if (invCode.length == 9) {
            if (!isNaN(invCode) && invCode.trim() !== "") {
               getEvaluatedStaff(invCode);
            }
        } else if (invCode.length == 0 || invCode == '') {
            $('#stdRegForm').trigger('reset');
        }
	})

	// <!-- getting answer entry  -->
	function loadData2(page = 1, search = '') {
		const limit = $('#limit2').val();
		$.ajax({
			url: '../admin/adm_staff/staff_eval_db.php',
			type: 'POST',
			data: {
				"page": page,
				"limit": limit,
				"search": search,
				"type": "paginateScore"
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

	$('#ans_entry').on('click', '.deleteQst', function() {
		var invID = $(this).attr('data-qid');
		// console.log(invCode);
		$.confirm({
			title: 'CONFIRM',
			content: 'Are you sure you want to delete this code?',
			autoClose: 'cancelAction|10000',
			escapeKey: 'cancelAction',
			buttons: {
				confirm: {
					btnClass: 'btn-green',
					text: 'Yes',
					action: function() {
						$.ajax({
							url: '../admin/adm_staff/staff_eval_db.php',
							type: "POST",
							dataType: 'json',
							data: {
								"invID": invID,
								"type": "deleteInvCode"
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

	$('#deleteCode').click(function() {
		$.confirm({
			title: 'CONFIRM',
			content: 'Are you sure you want to delete all codes?',
			autoClose: 'cancelAction|10000',
			escapeKey: 'cancelAction',
			buttons: {
				confirm: {
					btnClass: 'btn-green',
					text: 'Yes',
					action: function() {
						$.ajax({
							url: '../admin/adm_staff/staff_eval_db.php',
							type: "POST",
							dataType: 'json',
							data: {
								"type": "deleteAllCode"
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
})
</script>