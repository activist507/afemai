<?php 
if(!isset($_GET['branch']) || !isset($_GET['clas']) || !isset($_GET['term']) || !isset($_GET['session'])){
	echo "<script>
	window.location = './?res_set_memo'
	</script>";
}
$starting_surah = $conn->query("SELECT * FROM memorization_surah");
$ending_surah = $conn->query("SELECT * FROM memorization_surah");

?>				
<main id="main" class="main">
	<div class="container" id="auto_focus">
		
		<form id="resultForm">
			<div class="row g-1" id="firstRow">
				<div class="col-3">
					<input type="text" name="studentId" placeholder="Insert" id="studentId" class="form-control text-center" maxlength="4" inputmode="numeric" data-bs-toggle="tooltip" data-bs-placement="top" title="Student ID">
				</div>
				<div class="col-9">
					<input type="text" name="studentName" id="studentName" class="form-control" data-bs-toggle="tooltip" data-bs-placement="top" readonly>
				</div>
				<div class="col-12">
					<input type="text" name="subjectName" id="subjectName" class="form-control text-center" disabled>
				</div>
				<input type="hidden" name="studentSection" id="studentSection">
			</div>
		</form>
			<div class="row g-1 pt-2">
				<div class="col-12">
					<div class="input-group">
						<span class="input-group-text">Started From</span>
						<select name="startingSurah" id="startingSurah" class="form-control surah">
							<option value="">Starting Surah</option>
							<?php while($surah = $starting_surah->fetch_object()):?>
								<option value="<?= $surah->surah ?>"><?= $surah->surah ?></option>
							<?php endwhile ?>
						</select>
					</div>
					
				</div>
				<div class="col-12">
					<div class="input-group">
						<span class="input-group-text">Stopped At</span>
						<select name="endingSurah" id="endingSurah" class="form-control surah">
							<option value="">Ending Surah</option>
							<?php while($surah = $ending_surah->fetch_object()):?>
								<option value="<?= $surah->surah ?>"><?= $surah->surah ?></option>
							<?php endwhile ?>
						</select>
					</div>
					
				</div>
				<div class="col-12">
					<input type="text" id="daily_submission" placeholder="Daily submission" class="form-control">
				</div>
				<div class="col-6"></div>
				<div class="col-6">
					<button id="submitBtn" class="btn btn-primary w-100" disabled>Submit</button>
				</div>
			</div>
		
	</div>
</main>

<script type="text/javascript">
$(document).ready(function() {
	const selector = '.auto';
	const container = '#auto_focus';

	//To move next
	$(document).on('input',selector,function(e){
		if(e.originalEvent && e.originalEvent.isComposing) return;

		const $all = $(container).find(selector);
		const idx = $all.index(this);

		setTimeout(()=>{
			const max = this.maxLength || 0;
			if(max > 0 && this.value.length >= max){
				const $next = $all.eq(idx + 1);
				if($next.length){
					$next.focus();
					$next.select();
					// autoCal();
				}
			}
		},0);
	});

	//To move prev
	$(document).on('keydown',selector,function(e){
		if(e.originalEvent && e.originalEvent.isComposing) return;
		if(e.key === 'Backspace'){
			const $all = $(container).find(selector);
			const idx = $all.index(this);
			if(this.value.length === 0){
				const $prev = $all.eq(idx - 1);
				if($prev.length){
					e.preventDefault();
					$prev.focus();
					// autoCal();
				}
			}
		}
	})

	//auto sum
	$(document).on('input', '.field1, .field2, .field3, .field4', function () {
		const row = $(this).closest('.sum-row');
		const a = Number(row.find('.field1').val()) || 0;
		const b = Number(row.find('.field2').val()) || 0;
		const c = Number(row.find('.field3').val()) || 0;
		const d = Number(row.find('.field4').val()) || 0;
		const total = a + b + c + d;
		row.find('.total').val(total);
		if (total > 100) {
			row.find('.field1, .field2, .field3,.field4, .total').addClass('is-invalid');
			$('#submitBtn').prop('disabled', true);
		} else {
			row.find('.field1, .field2, .field3,.field4, .total').removeClass('is-invalid');
		}

		
		const subjectInput = $('#firstRow').find('#subjectName');
		const subjectName = row.find('.field1').parent().parent().attr("data-sub");
		subjectInput.val(subjectName)
		// console.log(subjectName)
	});


	////// get student from ID
	$('#studentId').keyup(function(e){
		var studentID = $(this).val();
		var branch = '<?= $_GET['branch'] ?>';
		var className = '<?= $_GET['clas'] ?>';
		var session = '<?= $_GET['session'] ?>';
		var term = '<?= $_GET['term'] ?>';
		data = {"type":"getStudent","studentID":studentID,"branch":branch,"className":className,"session":session,"term":term};
		if(studentID.length == 4){
			$.post("../admin/manage_result_memo/enter_result_db.php",data,null,"json")
			.done(function(response){
				if(response.query == 'fair'){
					$.alert(response.msg,"Message")
				}
				if(response.query == 'true'){
					$('#studentName').val(response.Fullnames);
					$('#studentName').attr('title','Class: '+ response.Student_Class)
					$('.sum-row').remove(); 
					$('#firstRow').after(response.html)
					$('[data-bs-toggle="tooltip"]').tooltip('dispose').tooltip();
					$('#submitBtn').text('Submit');
					$('#startingSurah').val(response.startingSurah);
					$('#endingSurah').val(response.endingSurah);
					$('#daily_submission').val(response.daily_submission);
				}
			})
			.fail(function(err){
				console.log(err)
			})
		} else if(studentID == 0){
			$('#studentId').val('');
			$('#studentName').val('');
			$('.sum-row').remove(); 
		}
	})

	$(document).on('change', '.surah', function () {
		var check = $(this).val();
		var anyFilled = false;   // <-- key change
		$('.sum-row').each(function () {
			let f1 = $(this).find('.field1').val().trim();
			let f2 = $(this).find('.field2').val().trim();
			let f3 = $(this).find('.field3').val().trim();
			let f4 = $(this).find('.field4').val().trim();
			// If at least one field in ANY row is filled
			if (f1 !== '' || f2 !== '' || f3 !== '' || f4 !== '') {
				anyFilled = true;
				return false; // stop loop early
			}
		});
		// Final logic
		if (check !== '' && anyFilled && $('.is-invalid').length === 0) {
			$('#submitBtn').prop('disabled', false);
		} else {
			$('#submitBtn').prop('disabled', true);
		}
	});

	//submitting
	$('#submitBtn').click(function(e){
		e.preventDefault();
		var form = $('#resultForm').serializeArray();
		var branch = '<?= $_GET['branch'] ?>';
		var className = '<?= $_GET['clas'] ?>';
		var session = '<?= $_GET['session'] ?>';
		var term = '<?= $_GET['term'] ?>';
		var startingSurah = $('#startingSurah').val();
		var endingSurah = $('#endingSurah').val();
		var daily_submission = $('#daily_submission').val();
		
		data = {
			"type":"submitResult",
			"form":form,
			"branch":branch,
			"className":className,
			"session":session,
			"term":term,
			"startingSurah":startingSurah,
			"endingSurah":endingSurah,
			"daily_submission":daily_submission
		};
		// console.log(startingSurah,endingSurah)
		$.post("../admin/manage_result_memo/enter_result_db.php",data,null,"json")
		.done(function(response){
			if(response.success == 'true'){
				$.alert(response.msg,"Message");
				$('#studentId').val('');
				$('#studentName').val('');
				$('.sum-row').remove(); 
				$('#startingSurah').val('');
				$('#endingSurah').val('');
				$('#daily_submission').val('');
				// console.log(response)
			} else {
				$.alert("Could not submit result","Message");
			}
			$('#studentId').attr("readonly",false);
		})
		.fail(function(err){
			console.log(err)
		})
		.always(function(){
			$('#submitBtn').attr("disabled",true);
		})

	})

})
</script>