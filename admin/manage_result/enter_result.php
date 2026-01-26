<?php 
if(!isset($_GET['branch']) || !isset($_GET['clas']) || !isset($_GET['term']) || !isset($_GET['session'])){
	echo "<script>
	window.location = './?res_set'
	</script>";
}


?>				
<main id="main" class="main">
	<div class="container" id="auto_focus">
		<form id="resultForm">
			<div class="row g-1" id="firstRow">
				<div class="col-3">
					<input type="text" name="studentId" placeholder="Insert" id="studentId" class="form-control text-center" maxlength="4" inputmode="numeric" data-bs-toggle="tooltip" data-bs-placement="top" title="Student ID">
				</div>
				<div class="col-6">
					<input type="text" name="studentName" id="studentName" class="form-control" data-bs-toggle="tooltip" data-bs-placement="top" >
				</div>
				<div class="col-3">
					<input type="text" name="updateID" placeholder="Search" id="updateID" class="form-control text-center" maxlength="4" inputmode="numeric" data-bs-toggle="tooltip" data-bs-placement="top" title="Call Student">
				</div>
				<input type="hidden" name="studentSection" id="studentSection">
			</div>
		</form>
			<div class="row g-1 pt-3">
				<div class="col-5">
					<select name="resultStatus" id="resultStatus" class="form-select">
						<option value="">Result Status</option>
						<option value="Finished">Finished</option>
						<option value="Pending">Pending</option>
					</select>
				</div>
				<div class="col-2">
					<input type="text" name="outOf" id="outOf" class="form-control text-center" value="0" disabled>
				</div>
				<div class="col-5">
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
	$(document).on('input', '.field1, .field2, .field3', function () {
		const row = $(this).closest('.sum-row');
		const a = Number(row.find('.field1').val()) || 0;
		const b = Number(row.find('.field2').val()) || 0;
		const c = Number(row.find('.field3').val()) || 0;
		const total = a + b + c;
		row.find('.total').val(total);
		if (total > 100) {
			row.find('.field1, .field2, .field3, .total').addClass('is-invalid');
			$('#submitBtn').prop('disabled', true);
		} else {
			row.find('.field1, .field2, .field3, .total').removeClass('is-invalid');
			// if ($('.is-invalid').length === 0) {
			// 	$('#submitBtn').prop('disabled', false);
			// }
		}
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
			$('#updateID').attr("readonly",true);
			$.post("../admin/manage_result/enter_result_db.php",data,null,"json")
			.done(function(response){
				if(response.query == 'fair'){
					$.alert(response.msg,"Message")
				}
				if(response.query == 'true'){
					$('#studentName').val(response.Fullnames);
					$('#studentName').attr('title','Class: '+ response.Student_Class)
					$('#studentSection').val(response.Student_Section);
					$('.sum-row').remove(); 
					$('#firstRow').after(response.html)
					$('[data-bs-toggle="tooltip"]').tooltip('dispose').tooltip();
					$('#submitBtn').text('Submit');
				}
			})
			.fail(function(err){
				console.log(err)
			})
		} else if(studentID == 0){
			$('#updateID').attr("readonly",false);
			$('#studentId').val('');
			$('#studentName').val('');
			$('.sum-row').remove(); 
		}
	})

	$(document).on('change', '#resultStatus', function () {
		var check = $(this).val();
		var anyFilled = false;   // <-- key change
		$('.sum-row').each(function () {
			let f1 = $(this).find('.field1').val().trim();
			let f2 = $(this).find('.field2').val().trim();
			let f3 = $(this).find('.field3').val().trim();
			// If at least one field in ANY row is filled
			if (f1 !== '' || f2 !== '' || f3 !== '') {
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
		var resultStatus = $('#resultStatus').val();
		data = {"type":"submitResult","form":form,"branch":branch,"className":className,"session":session,"term":term,"resultStatus":resultStatus};
		$.post("../admin/manage_result/enter_result_db.php",data,null,"json")
		.done(function(response){
			if(response.success == 'true'){
				$.alert(response.msg,"Message");
				$('#studentId').val('');
				$('#studentName').val('');
				$('.sum-row').remove(); 
				$('#resultStatus').val('');
				$('#updateID').val('');
			} else {
				$.alert("Could not submit result","Message");
			}
			$('#updateID').attr("readonly",false);
			$('#studentId').attr("readonly",false);
		})
		.fail(function(err){
			console.log(err)
		})
		.always(function(){
			$('#submitBtn').attr("disabled",true);
		})

	})

	//updating
	$('#updateID').keyup(function(e){
		var studentID = $(this).val();
		var branch = '<?= $_GET['branch'] ?>';
		var session = '<?= $_GET['session'] ?>';
		var className = '<?= $_GET['clas'] ?>';
		var term = '<?= $_GET['term'] ?>';
		data = {"type":"getUpdate","studentID":studentID,"branch":branch,"className":className,"session":session,"term":term};
		if(studentID.length == 4){
			$('#studentId').attr("readonly",true);
			$.post("../admin/manage_result/enter_result_db.php",data,null,"json")
			.done(function(response){
				if(response.query == 'true'){
					$('#studentName').val(response.Fullnames);
					$('#studentName').attr('title','Class: '+ response.Student_Class)
					$('#studentSection').val(response.Student_Section);
					$('.sum-row').remove(); 
					$('#firstRow').after(response.html)
					$('[data-bs-toggle="tooltip"]').tooltip('dispose').tooltip();
					$('#submitBtn').text('Update');
					$('#resultStatus').val(response.resultStatus);
					$('#submitBtn').attr('disabled',false);
				}
			})
			.fail(function(err){
				console.log(err)
			})
		} else if(studentID == 0){
			$('#studentId').attr("readonly",false);
			$('#updateID').val('');
			$('#studentName').val('');
			$('.sum-row').remove(); 
		}
	})

	setInterval(() => {
		var branch = '<?= $_GET['branch'] ?>';
		var className = '<?= $_GET['clas'] ?>';
		var session = '<?= $_GET['session'] ?>';
		var term = '<?= $_GET['term'] ?>';
        $.ajax({
            url: '../admin/manage_result/enter_result_db.php',
            type: 'POST',
            dataType: 'json',
            data: {"type": "auto_id_rec","branch":branch,"className":className,"session":session,"term":term},
            success: function(response) {
                $('#outOf').val(response.total);
            },
            error: function(err) {
                console.log(err)
            }
        });
    }, 2000);

})
</script>