<?php 
$sub = $conn->query("SELECT subject FROM cbt_staff_eval WHERE inv_code = '$inv_code'")->fetch_object();
$subject = explode(",",$sub->subject);
?>
<main id="main" class="main">
	<div class="card mt-0">
		<div class="card-header d-flex flex-center bg-secondary">
			<h4 class="mb-0 text-center text-warning text-light my-2"><strong>YOUR SUBJECT QUESTIONS</strong>
			</h4>
		</div>
		<div class="card-footer bg-body-tertiary py-2 text-center">
			<div class="row gy-3">
				<div class="row my-3">
					<?php foreach($subject as $subj):?>
					<div class="col-lg-6 d-flex flex-start pt-3">
						<a href="#" class="btn btn-primary" data-subjName="<?= $subj?>"
							style="width: 200px;"><?= $subj?></a>
					</div>
					<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>
</main>
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.btn-primary').click(function(e) {
		e.preventDefault();
		var subject = $(this).attr("data-subjName").trim();
		var invCode = '<?= $inv_code?>';
		$.ajax({
			url: 'take_exam_db.php',
			type: 'POST',
			dataType: 'JSON',
			cache: false,
			data: {
				"invCode": invCode,
				"subject": subject,
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