<main id="main" class="main">
	<div class="container">

		<div class="card mt-3">
			<div class="card-header d-flex flex-center bg-secondary">
				<h4 class="mb-0 text-center text-warning text-light my-2"><strong>CBT STUDENT LOGIN DETAILS</strong>
				</h4>
			</div>
			<div class="card-footer bg-body-tertiary py-2 text-center">
				<form action="" method="post">
					<div class="row gy-3">
						<input type="hidden" value="<?= strpos($Questions->question_id,"-")?>" id="format">
						<div class="col-sm-4 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<label for="Student_ID" class="form-label text-left">Student ID</label>
								<input type="text" class="form-control text-center" name="Student_ID"
									value="<?= $Student_records->Student_ID?>" id="Student_ID" readonly>
							</div>
						</div>
						<div class="col-sm-4 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<label for="Student_ID" class="form-label text-left">Name</label>
								<input type="text" class="form-control text-center" name="Student_ID"
									value="<?= $Student_records->Fullnames?>" id="Fullnames" readonly>
							</div>
						</div>
						<div class="col-sm-4 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<label for="Student_ID" class="form-label text-left">Class</label>
								<input type="text" class="form-control text-center" name="Student_ID"
									value="<?= $Student_records->Student_Class?>" id="Student_Class" readonly>
							</div>
						</div>
						<div class="col-sm-4 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<label for="Student_ID" class="form-label text-left">Status</label>
								<input type="text" class="form-control text-center" name="Student_ID"
									value="<?= $Student_records->Current_Status?>" id="Current_Status" readonly>
							</div>
						</div>
						<div class="col-sm-4 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<label for="Student_ID" class="form-label text-left">Branch</label>
								<input type="text" class="form-control text-center" name="Student_ID"
									value="<?= $Student_records->Branch?>" id="Branch" readonly>
							</div>
						</div>
						<div class="col-sm-4 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<label for="Student_ID" class="form-label text-left">Phone Number</label>
								<input type="text" class="form-control text-center" name="Student_ID"
									value="<?= $Student_records->Phone_Number?>" id="Phone_Number" readonly>
							</div>
						</div>

					
						<div class="col-sm-4 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<label for="Student_ID" class="form-label text-left">Exam ID</label>
								<input type="text" class="form-control text-center" name="Student_ID"
									value="<?= $Questions->question_id ?>" id="question_id" readonly>
							</div>
						</div>
						<div class="col-sm-4 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<label for="Student_ID" class="form-label text-left">Question Type</label>
								<input type="text" class="form-control text-center" name="Student_ID"
									value="<?= $Questions->question_type ?>" id="question_type" readonly>
							</div>
						</div>
						<div class="col-sm-4 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<label for="Student_ID" class="form-label text-left">Exam Type</label>
								<input type="text" class="form-control text-center" name="Student_ID"
									value="<?= $Questions->exam_type ?>" id="exam_type" readonly>
							</div>
						</div>
						<div class="col-sm-4 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<label for="Student_ID" class="form-label text-left">Subject</label>
								<input type="text" class="form-control text-center" name="Student_ID"
									value="<?= $Questions->subject ?>" id="subject" readonly>
							</div>
						</div>
						<div class="col-sm-4 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<label for="Student_ID" class="form-label text-left">Term</label>
								<input type="text" class="form-control text-center" name="Student_ID"
									value="<?= $Questions->term  ?>" id="term" readonly>
							</div>
						</div>
						<div class="col-sm-4 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<label for="Student_ID" class="form-label text-left">Session</label>
								<input type="text" class="form-control text-center" name="Student_ID"
									value="<?= $Questions->session ?? date('Y') ?>" id="session" readonly>
							</div>
						</div>

					<div class="row my-3">
						<div class="col-md-6 d-flex flex-start">
							<a href="#" class="btn btn-success" id="enter_exam_btn">Enter Exam</a>
						</div>
					</div>
				</form>
			</div>
		</div>

	</div>
</main>

<script type="text/javascript">
$(document).ready(function() {
	$('#enter_exam_btn').click(function(e) {
		e.preventDefault();
		var format = $('#format').val();
		var Student_ID = $('#Student_ID').val();
		var Fullnames = $('#Fullnames').val();
		var Student_Class = $('#Student_Class').val();
		var Branch = $('#Branch').val();
		var term = $('#term').val();
		var session = $('#session').val()
		var question_id = $('#question_id').val();
		var subject = $('#subject').val();
		var question_type = $('#question_type').val();
		var exam_type = $('#exam_type').val();

		$.ajax({
			url: '../Functions.php',
			type: 'POST',
			dataType: 'JSON',
			cache: false,
			data: {
				"format":format,
				"Student_ID": Student_ID,
				"Fullnames": Fullnames,
				"Student_Class": Student_Class,
				"Branch": Branch,
				"term": term,
				"session": session,
				"question_id": question_id,
				"subject": subject,
				"question_type": question_type,
				"exam_type": exam_type,
				"type": "submitToAnswerTable"
			},
			success: function(response) {
				if (response.link == 'no-link') {
					$.confirm({
						icon: 'bi bi-patch-question',
						theme: 'bootstrap',
						title: 'Message',
						content: response.message,
						animation: 'scale',
						type: 'orange'
					})
				} else {
					let storedTime = localStorage.getItem('countdownTime');
					if (storedTime) {
						localStorage.removeItem('countdownTime');
					}
					window.location.href = response.link;
				}

			},
			error: function(err) {
				console.log(err)
			}
		})

	})
})
</script>