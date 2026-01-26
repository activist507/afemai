<?php 
$dur = $Questions->time_minutes*60;
$file = '../storege/'.$Questions->question_pdf;

// 
$today = date('Y-m-d');

$end_time_from_db = $today . 'T' . $Questions->end_time;
?>
<main id="main" class="main">
	<div class="content">
		<div class="row g-3 mb-3">
			<div class="col-lg-12 col-md-12 order-md-first order-sm-last">
				<div class="card h-100">
					<div class="card-header bg-body-tertiary d-flex flex-between-center py-2 ">
						<div class="col-6">
							<h6 class="mb-0">Obj | ID:<span class="fw-bold"><?= $Questions->question_id?> </span></h6>
						</div>
						<div class="col-6">
							<div class="d-flex flex-between-center gap-1">
								<!-- @if ($Questions->end_time) -->
								<small>Stop-Time: </small>
								<small id="timerB" class="text-center fw-bold">
									<!-- {{ ' ' . $Questions->end_time }} -->
									<!-- 23:12:00 -->
								</small>
								<small class="fw-bold"><?= $Questions->end_time?></small>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row g-1 h-100">
							<!-- script to render PDF to the viewer  -->
							<div class="col-md-12 col-lg-12">
								<div class="card position-relative rounded-4">
									<canvas id="pdf-canvas" style="max-height:430px;"></canvas>
								</div>
							</div>
							<!-- end of pdf  -->
							<div class="col-md-12 col-lg-12">
								<form id="quizForm">
									<div id="optionContainer" class="row">
										<div class="col-md-12 ms-4 pb-3" id="optionsContainer"
											data-questionCounter="<?= $Questions->total_question+1?>">
											<?php for($i = 1; $i < $Questions->total_question+1; $i++){?>

											<div class="row justify-content-between align-items-center d-flex d-none"
												id="group<?=$i?>">
												<!-- Options will be dynamically populated here -->
												<div class="col-3 form-check"><input type="radio" id="option1"
														name="ans<?=$i?>" class="form-check-input group<?=$i?>"
														value="A"><label class="form-check-label" for="option1">
														A</label>
												</div>
												<div class="col-3 form-check"><input type="radio" id="option2"
														name="ans<?=$i?>" class="form-check-input" value="B"><label
														class="form-check-label" for="option2">
														B</label>
												</div>
												<div class="col-3 form-check "><input type="radio" id="option3"
														name="ans<?=$i?>" class="form-check-input" value="C"><label
														class="form-check-label" for="option3">
														C</label>
												</div>
												<div class="col-3 form-check "><input type="radio" id="option4"
														name="ans<?=$i?>" class="form-check-input" value="D"><label
														class="form-check-label" for="option4">
														D</label>
												</div>
											</div>
											<?php  }?>
										</div>
										<div class="d-flex justify-content-between align-items-center">
											<div>
												<button class="btn btn-primary" style="width: 90px;"
													id="prevBtn">Prev</button>
											</div>
											<div>
												<input type="text" class="form-control text-center fw-bold"
													id="questionNumber" readonly>
											</div>
											<div>
												<button class="btn btn-primary" style="width: 90px;"
													id="nextBtn">Next</button>
											</div>
										</div>
									</div>


									<input type="hidden" name="selectedOptions" id="selectedOptionsInput">
									<input type="hidden" name="answersObj" id="answersInput">

									<input type="hidden" name="allottedMark" value="<?=$Questions->alloted_mark ?>">
									<input type="hidden" id="endTime" name="end_time"
										value="<?=$Questions->end_time ?>">

									<input type="hidden" name="exam_type" value="<?=$Questions->exam_type ?>">

									<input type="hidden" name="subject" value="<?=$Questions->subject ?>"
										id="write_subject">
									<input type="hidden" name="session" value="<?=$Questions->session ?>"
										id="write_session">
									<input type="hidden" name="term" value="<?=$Questions->term ?>" id="write_term">
									<input type="hidden" name="class" value="<?=$Questions->class ?>" id="write_class">
									<input type="hidden" name="student__id" value="<?=$Student_records->Student_ID ?>"
										id="write_student_id">
									<input type="hidden" name="Fullnames__" value="<?=$Student_records->Fullnames?>"
										id="write_Fullnames">
									<input type="hidden" name="exam__id" value="<?=$Questions->question_id ?>"
										id="write_exam_id">
									<input type="hidden" name="branch__" value="<?=$Student_records->Branch ?>"
										id="write_branch">


									<div class="d-flex justify-content-between pt-3 align-items-center">
										<button type="submit" class="btn btn-success" style="width: 90px;"
											id="submitButton">
											Submit
										</button>
										<!-- {{-- @if (!empty($Questions->end_time)) --}} -->
										<div class="d-flex flex-between-center gap-1">
											<!-- {{-- <h5>Stop-Time: </h5>
                                                    <h5 id="timerB" class="text-center fw-bold">
                                                        {{ $Questions->end_time }}
                                            </h5> --}} -->

											<h5>Time Left: <span id="countdown"
													class="text-center fw-bold "><?= $Questions->time_minutes?>:00</span>
											</h5>

										</div>
										<!-- {{-- @endif --}} -->
									</div>
									<div id="answerContainer">
										<input type="hidden" value="<?= $Questions->alloted_mark ?>" id="mark">
										<input type="hidden" value="<?= $Questions->q1 ?>" id="ans1">
										<input type="hidden" value="<?= $Questions->q2 ?>" id="ans2">
										<input type="hidden" value="<?= $Questions->q3 ?>" id="ans3">
										<input type="hidden" value="<?= $Questions->q4 ?>" id="ans4">
										<input type="hidden" value="<?= $Questions->q5 ?>" id="ans5">
										<input type="hidden" value="<?= $Questions->q6 ?>" id="ans6">
										<input type="hidden" value="<?= $Questions->q7 ?>" id="ans7">
										<input type="hidden" value="<?= $Questions->q8 ?>" id="ans8">
										<input type="hidden" value="<?= $Questions->q9 ?>" id="ans9">
										<input type="hidden" value="<?= $Questions->q10 ?>" id="ans10">

										<input type="hidden" value="<?= $Questions->q11 ?>" id="ans11">
										<input type="hidden" value="<?= $Questions->q12 ?>" id="ans12">
										<input type="hidden" value="<?= $Questions->q13 ?>" id="ans13">
										<input type="hidden" value="<?= $Questions->q14 ?>" id="ans14">
										<input type="hidden" value="<?= $Questions->q15 ?>" id="ans15">
										<input type="hidden" value="<?= $Questions->q16 ?>" id="ans16">
										<input type="hidden" value="<?= $Questions->q17 ?>" id="ans17">
										<input type="hidden" value="<?= $Questions->q18 ?>" id="ans18">
										<input type="hidden" value="<?= $Questions->q19 ?>" id="ans19">
										<input type="hidden" value="<?= $Questions->q20 ?>" id="ans20">

										<input type="hidden" value="<?= $Questions->q21 ?>" id="ans21">
										<input type="hidden" value="<?= $Questions->q22 ?>" id="ans22">
										<input type="hidden" value="<?= $Questions->q23 ?>" id="ans23">
										<input type="hidden" value="<?= $Questions->q24 ?>" id="ans24">
										<input type="hidden" value="<?= $Questions->q25 ?>" id="ans25">
										<input type="hidden" value="<?= $Questions->q26 ?>" id="ans26">
										<input type="hidden" value="<?= $Questions->q27 ?>" id="ans27">
										<input type="hidden" value="<?= $Questions->q28 ?>" id="ans28">
										<input type="hidden" value="<?= $Questions->q29 ?>" id="ans29">
										<input type="hidden" value="<?= $Questions->q30 ?>" id="ans30">

										<input type="hidden" value="<?= $Questions->q31 ?>" id="ans31">
										<input type="hidden" value="<?= $Questions->q32 ?>" id="ans32">
										<input type="hidden" value="<?= $Questions->q33 ?>" id="ans33">
										<input type="hidden" value="<?= $Questions->q34 ?>" id="ans34">
										<input type="hidden" value="<?= $Questions->q35 ?>" id="ans35">
										<input type="hidden" value="<?= $Questions->q36 ?>" id="ans36">
										<input type="hidden" value="<?= $Questions->q37 ?>" id="ans37">
										<input type="hidden" value="<?= $Questions->q38 ?>" id="ans38">
										<input type="hidden" value="<?= $Questions->q39 ?>" id="ans39">
										<input type="hidden" value="<?= $Questions->q40 ?>" id="ans40">

										<input type="hidden" value="<?= $Questions->q41 ?>" id="ans41">
										<input type="hidden" value="<?= $Questions->q42 ?>" id="ans42">
										<input type="hidden" value="<?= $Questions->q43 ?>" id="ans43">
										<input type="hidden" value="<?= $Questions->q44 ?>" id="ans44">
										<input type="hidden" value="<?= $Questions->q45 ?>" id="ans45">
										<input type="hidden" value="<?= $Questions->q46 ?>" id="ans46">
										<input type="hidden" value="<?= $Questions->q47 ?>" id="ans47">
										<input type="hidden" value="<?= $Questions->q48 ?>" id="ans48">
										<input type="hidden" value="<?= $Questions->q49 ?>" id="ans49">
										<input type="hidden" value="<?= $Questions->q50 ?>" id="ans50">


										<input type="hidden" value="0" id="answerCount">

									</div>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Sound generator -->
		<audio id="myAudio">
			<source src="../alarm.wav" type="audio/wav">
		</audio>
		<!-- Sound generator -->
	</div>
</main>
<script src="assets/js/pdf.min.js"></script>
<script src="assets/js/pdf.worker.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#questionNumber').val('0');
	$('#group1').removeClass('d-none');
	const pdfUrl = '<?= $file?>';
	var qestionNumber = $('#questionNumber').val();
	let pdfDoc = null;
	let currentPage = 1;
	let totalPages = 0;
	let shuffledIndexes = []; // Contains [3,1,4,2,...] — used to show groupX and PDF page X
	const canvas = document.getElementById('pdf-canvas');
	const ctx = canvas.getContext('2d');

	// Load the PDF METHOD: 1
	pdfjsLib.getDocument(pdfUrl).promise.then(doc => {
		pdfDoc = doc;
		totalPages = doc.numPages;

		// Create a shuffled array from [1, 2, ..., totalPages]
		shuffledIndexes = shuffleArray(Array.from({
			length: totalPages
		}, (_, i) => i + 1));

		$('#questionNumber').val(currentPage);
		renderPage(currentPage);
	});


	function shuffleArray(array) {
		for (let i = array.length - 1; i > 0; i--) {
			const j = Math.floor(Math.random() * (i + 1));
			[array[i], array[j]] = [array[j], array[i]];
		}
		return array;
	}

	// Render page + show matching options
	function renderPage(pageNum) {
		const actualIndex = shuffledIndexes[pageNum - 1]; // the "X" in groupX
		const actualPageNum = actualIndex; // the page to show from PDF

		// Hide all option groups
		$('[id^=group]').addClass('d-none');

		// Show the current option group
		$('#group' + actualIndex).removeClass('d-none');

		pdfDoc.getPage(actualPageNum).then(page => {
			const scale = 2.0;
			const viewport = page.getViewport({
				scale
			});

			const offscreenCanvas = document.createElement('canvas');
			offscreenCanvas.width = viewport.width;
			offscreenCanvas.height = viewport.height;
			const offscreenCtx = offscreenCanvas.getContext('2d');

			const renderCtx = {
				canvasContext: offscreenCtx,
				viewport: viewport,
			};

			page.render(renderCtx).promise.then(() => {
				canvas.width = viewport.width;
				canvas.height = viewport.height;
				//canvas.height = viewport.height / 2.0;
				ctx.clearRect(0, 0, canvas.width, canvas.height);
				ctx.drawImage(
					offscreenCanvas,
					0, 0,
					viewport.width, viewport.height,
					// viewport.width, viewport.height / 2.0,
					0, 0,
					viewport.width, viewport.height
					// viewport.width, viewport.height / 2
				);

				$('#questionNumber').val(currentPage);
				$('#prevBtn').prop('disabled', currentPage === 1);
				$('#nextBtn').prop('disabled', currentPage === totalPages);
			});
		});
	}

	// Next button
	$('#nextBtn').click(function(e) {
		e.preventDefault();
		if (currentPage < totalPages) {
			currentPage++;
			renderPage(currentPage);
		}
	});

	$('#prevBtn').click(function(e) {
		e.preventDefault();
		if (currentPage > 1) {
			currentPage--; // First, reduce the page count
			renderPage(currentPage); // Then render the page, which updates button states
		}
	});

	function submitAnswers() {
		var correct_ans = parseInt($('#answerCount').val());
		var allotedmark = parseInt($('#mark').val());
		var allquestion = '<?= $Questions->total_question?>';
		// getting the answers after submission
		var answer = $('.form-check-input').serializeArray();
		$('input[type="radio"]:checked').each(function(index, element) {
			var id_stud_ans = element.name;
			var stud_ans = element.value;
			var qst_ans = $('#answerContainer').find('#' +
				id_stud_ans).val().toUpperCase();

			//qst_ans and stud_ans comparison
			if (qst_ans == stud_ans) {
				correct_ans++;
			}
		});
		var stud_score = correct_ans * allotedmark;
		var overall_score = allquestion * allotedmark;
		console.log(correct_ans);

		//submitting to database
		var Student_ID = $('#write_student_id').val();
		var Fullnames = $('#write_Fullnames').val();
		var Student_Class = $('#write_class').val();
		var Branch = $('#write_branch').val();
		var term = $('#write_term').val();
		var session = $('#write_session').val()
		var question_id = $('#write_exam_id').val();
		var subject = $('#write_subject').val();

		$.ajax({
			url: '../Functions.php',
			type: 'POST',
			dataType: 'JSON',
			cache: false,
			data: {
				"Student_ID": Student_ID,
				"Fullnames": Fullnames,
				"Student_Class": Student_Class,
				"Branch": Branch,
				"term": term,
				"session": session,
				"question_id": question_id,
				"subject": subject,
				"stud_score": stud_score,
				"type": "updateScore"
			},
			success: function(response) {
				// Sound script
				let audio = document.getElementById("myAudio");
				audio.play().catch(error => {
					console.log("Autoplay blocked, waiting for user interaction");
				});
				// END sound script
				$.confirm({
					icon: 'bi bi-patch-question',
					theme: 'bootstrap',
					title: 'Congratulation',
					content: 'You have successfully submitted your exam. You Scored ' +
						stud_score + ' out of ' + overall_score,
					animation: 'scale',
					type: 'orange',
					buttons: {
						ok: {
							btnClass: 'btn-green',
							text: "Ok",
							action: function() {
								localStorage.removeItem('countdownTime');
								window.location.href = "../?studentlogin";
							}
						}
					}
				})
			},
			error: function(err) {
				console.log(err)
			}
		})


	}

	$('#quizForm').on('click', '.btn-success', function(e) {
		e.preventDefault();

		// confirmation from the students
		$.confirm({
			title: 'CONFIRM',
			content: 'Are you sure you want to submit?',
			animation: 'zoom',
			animationBounce: 2.5,
			closeAnimation: 'scale',
			theme: 'supervan',
			buttons: {
				confirm: {
					btnClass: 'btn-green',
					text: 'Yes',
					action: function() {
						submitAnswers();
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


	// New 
	let duration = <?= $dur ?> * 1000; // Convert to milliseconds
	let endTime = localStorage.getItem('endTime');

	// Inject server-side deadline from PHP
	const serverEndTime = new Date("<?= $end_time_from_db ?>").getTime();

	if (!endTime) {
		endTime = Date.now() + duration;
		localStorage.setItem('endTime', endTime);
	} else {
		endTime = parseInt(endTime); // Ensure it's a number
	}

	updateTimer();
	checkServerTime();
	let timerInterval = setInterval(updateTimer, 1000);
	let serverCheckInterval = setInterval(checkServerTime, 3000); // every 30 seconds

	function updateTimer() {
		const now = Date.now();
		const remaining = endTime - now;
		const deadlineLeft = serverEndTime - now;

		if (deadlineLeft <= 0 || remaining <= 0) {
			clearInterval(timerInterval);
			clearInterval(serverCheckInterval);
			localStorage.removeItem('endTime');
			document.getElementById('countdown').innerText = "0:00";
			submitAnswers();
		} else {
			let minutes = Math.floor(remaining / 60000);
			let seconds = Math.floor((remaining % 60000) / 1000);
			document.getElementById('countdown').innerText =
				`${minutes}:${seconds.toString().padStart(2, '0')}`;
		}
	}

	function checkServerTime() {
		fetch('get_server_time.php')
			.then(res => res.json())
			.then(data => {
				const serverNow = new Date(data.server_time).getTime();

				if (serverNow >= serverEndTime) {
					clearInterval(timerInterval);
					clearInterval(serverCheckInterval);
					localStorage.removeItem('endTime');
					document.getElementById('countdown').innerText = "Time's up!";
					submitAnswers();
				}
			})
			.catch(err => {
				console.error("Failed to fetch server time:", err);
			});
	}

	function resumeTimer() {
		if (!timerInterval) {
			timerInterval = setInterval(updateTimer, 1000);
		}
	}
	//   new


	// preventing back button 
	window.history.pushState(null, null, window.location.href);
	window.onpopstate = function() {
		window.history.pushState(null, null, window.location.href);
	};

})
</script>