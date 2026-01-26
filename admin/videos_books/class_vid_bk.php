<?php 
    $qstTerm = $conn->query("SELECT * FROM cbt_term");
    $qstClass = $conn->query("SELECT * FROM cbt_class");
    $qstSubjects = $conn->query("SELECT * FROM cbt_subjects");
    $video_book = $conn->query("SELECT * FROM video_book WHERE book_path='' ORDER BY id DESC ");
    $video_book2 = $conn->query("SELECT * FROM video_book WHERE video_path='' ORDER BY id DESC ");

?>
<main id="main" class="main">
	<div class="container">

		<div class="card mt-0">
			<div class="card-footer bg-body-tertiary py-2 text-center">
				<form action="" method="post" id="book_form" enctype="multipart/form-data">
					<div class="row gy-2">
						<input type="hidden" name="vid_bk_id" id="vid_bk_id">
						<div class="col-sm-2 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<select name="subject" id="subject" class="form-select text-center"
									data-bs-toggle="tooltip" data-bs-placement="top" title="Subject" required>
									<option value="">Select Subject</option>
									<?php while($subject = $qstSubjects->fetch_object()){ ?>
									<option value="<?= $subject->subject?>"><?= $subject->subject?></option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="col-lg-4 col-sm-12">
							<div class="tom-select-custom">
								<input type="text" class="form-control text-center" id="topic" name="topic"
									data-bs-toggle="tooltip" data-bs-placement="top" title="Topic" required
									placeholder="Type Topic" />
							</div>
						</div>
						<div class="col-sm-2 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<select name="_class" id="_class" class="form-select text-center"
									data-bs-toggle="tooltip" data-bs-placement="top" title="Class" required>
									<option value="">Select Class</option>
									<?php while($class = $qstClass->fetch_object()){ ?>
									<option value="<?= $class->class?>"><?= $class->class?></option>
									<?php }?>
								</select>
							</div>
						</div>

						<div class="col-sm-2 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<select name="term" id="term" class="form-select text-center" data-bs-toggle="tooltip"
									data-bs-placement="top" title="Term" required>
									<option value="">Select Term</option>
									<?php while($term = $qstTerm->fetch_object()){ ?>
									<option value="<?= $term->term?>"><?= $term->term?></option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="col-lg-2 col-sm-12">
							<div class="tom-select-custom">
								<select id="week_" name="week_" class="form-select text-center" data-bs-toggle="tooltip"
									data-bs-placement="top" title="Select Week" required>
									<option value="">Select Week</option>
									<option value="Week 1">Week 1</option>
									<option value="Week 2">Week 2</option>
									<option value="Week 3">Week 3</option>
									<option value="Week 4">Week 4</option>
									<option value="Week 5">Week 5</option>
									<option value="Week 6">Week 6</option>
									<option value="Week 7">Week 7</option>
									<option value="Week 8">Week 8</option>
									<option value="Week 9">Week 9</option>
									<option value="Week 10">Week 10</option>
									<option value="Week 11">Week 11</option>
								</select>
							</div>
						</div>
					</div>

					<div class="row gy-2">
						<div class="col-md-6 col-lg-12 pt-2">
							<div class="row gy-6">
								<div class="col-lg-4"><video id="video_display" width="100%" height="310px"
										controls></video></div>
								<div class="col-lg-8"><embed src="" type="application/pdf" id="pdf_display" width="100%"
										height="310px"></div>
							</div>
						</div>

						<div class="row gy-1">
							<div class="col-lg-4 col-sm-10">
								<input type="file" class="form-control" id="book_pdf_file" name="pdf_file"
									accept="application/pdf" data-bs-toggle="tooltip" data-bs-placement="top"
									title="Select Book File" />
							</div>

							<div class="col-lg-2 col-sm-2">
								<button type="submit" style="width: 8.5rem;" class="btn btn-primary" name="submitBook"
									id="submit_form_btn_bk" value="btn_bk">
									Submit Book
								</button>
							</div>

							<div class="col-lg-4 col-sm-10">
								<input type="file" class="form-control" id="video_file" name="video_file"
									accept="video/*" data-bs-toggle="tooltip" data-bs-placement="top"
									title="Select Video file" />
							</div>
							<div class="col-lg-2 col-sm-2">
								<button type="submit" style="width: 8.5rem;" class="btn btn-primary" name="submitVideo"
									id="submit_form_btn_vid" value="btn_vid">
									Submit Video
								</button>
							</div>
						</div>
						<div id="uploadStatus"></div>
				</form>

				<!--  -->

				<div class="table-responsive pt-0">
					<h4 class="text-center fw-bold">Videos List</h4>
					<table class="table table-bordered border-primary table-striped">
						<thead>
							<tr>
								<th scope="col" nowrap="nowrap">VB-ID</th>
								<th scope="col" nowrap="nowrap">Subject</th>
								<th scope="col" nowrap="nowrap">Topic</th>
								<th scope="col" nowrap="nowrap">Class</th>
								<th scope="col" nowrap="nowrap">Term</th>
								<th scope="col" nowrap="nowrap">Week</th>
								<th scope="col" nowrap="nowrap">Video Path</th>
								<th scope="col" nowrap="nowrap">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php while($vid_bk = $video_book->fetch_object()){?>
							<tr>
								<th scope="row" nowrap="nowrap"><?= $vid_bk->vid_bk_id?></th>
								<td nowrap="nowrap"><?= $vid_bk->subject?></td>
								<td nowrap="nowrap"><?= $vid_bk->topic?></td>
								<td nowrap="nowrap"><?= $vid_bk->class?></td>
								<td nowrap="nowrap"><?= $vid_bk->term?></td>
								<td nowrap="nowrap"><?= $vid_bk->week?></td>
								<td nowrap="nowrap"><?= $vid_bk->video_path?></td>
								<td nowrap="nowrap">
									<div class="text-center">
										<a href="#" class="btn btn-link p-0 viewBook2" data-bid="<?= $vid_bk->id?>">
											<span class="text-500 text-success bi bi-camera"></span>
										</a>
										&nbsp;&nbsp;
										<a href="#" class="btn btn-link p-0 deleteBook2" data-bid="<?= $vid_bk->id?>">
											<span class="text-500 text-danger bi bi-trash"></span>
										</a>
									</div>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
				</div>

				<!--  -->

				<div class="table-responsive pt-4">
					<h4 class="text-center fw-bold">Books List</h4>
					<table class="table table-bordered border-primary table-striped">
						<thead>
							<tr>
								<th scope="col" nowrap="nowrap">VB-ID</th>
								<th scope="col" nowrap="nowrap">Subject</th>
								<th scope="col" nowrap="nowrap">Topic</th>
								<th scope="col" nowrap="nowrap">Class</th>
								<th scope="col" nowrap="nowrap">Term</th>
								<th scope="col" nowrap="nowrap">Week</th>
								<th scope="col" nowrap="nowrap">Book Path</th>
								<th scope="col" nowrap="nowrap">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php while($vid_bk = $video_book2->fetch_object()){?>
							<tr>
								<th scope="row" nowrap="nowrap"><?= $vid_bk->vid_bk_id?></th>
								<td nowrap="nowrap"><?= $vid_bk->subject?></td>
								<td nowrap="nowrap"><?= $vid_bk->topic?></td>
								<td nowrap="nowrap"><?= $vid_bk->class?></td>
								<td nowrap="nowrap"><?= $vid_bk->term?></td>
								<td nowrap="nowrap"><?= $vid_bk->week?></td>
								<td nowrap="nowrap"><?= $vid_bk->book_path?></td>
								<td nowrap="nowrap">
									<div class="text-center">
										<a href="#" class="btn btn-link p-0 viewBook" data-bid="<?= $vid_bk->id?>">
											<span class="text-500 text-success bi bi-camera"></span>
										</a>
										&nbsp;&nbsp;
										<a href="#" class="btn btn-link p-0 deleteBook" data-bid="<?= $vid_bk->id?>">
											<span class="text-500 text-danger bi bi-trash"></span>
										</a>
									</div>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
				</div>
				<!-- End of Book List -->

				<!--  -->

			</div>
		</div>

	</div>
</main>
<script type="text/javascript">
$(document).ready(function() {

	// for book submit
	$('#submit_form_btn_bk').on('click', function(e) {
		e.preventDefault();

		var vid_bk_id = $('#vid_bk_id').val();
		var subject = $('#subject').val();
		var topic = $('#topic').val();
		var _class = $('#_class').val();
		var term = $('#term').val();
		var week_ = $('#week_').val();
		var book_pdf_file = $('#book_pdf_file').prop('files')[0];

		var sdata = new FormData();

		sdata.append("vid_bk_id", vid_bk_id);
		sdata.append("subject", subject);
		sdata.append("topic", topic);
		sdata.append("_class", _class);
		sdata.append("term", term);
		sdata.append("week_", week_);
		sdata.append("book", book_pdf_file);
		sdata.append("type", "SubmitVidBk");

		$.ajax({
			url: '../admin/videos_books/class_vid_bk_db.php',
			type: "POST",
			dataType: 'json',
			processData: false,
			contentType: false,
			data: sdata,
			xhr: function() {
				const xhr = $.ajaxSettings.xhr();
				xhr.upload.addEventListener('progress', function(e) {
					const percent = Math.round((e.loaded / e.total) * 100);
					$('#uploadStatus').html(`Uploading... ${percent}%`);
				});
				return xhr;
			},
			success: function(response) {
				$.alert({
					title: 'Message',
					content: response.msg,
					buttons: {
						ok: function() {
							// work here
							$('#book_form').trigger('reset');
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

	// for video submit
	$('#submit_form_btn_vid').on('click', function(e) {
		e.preventDefault();

		var vid_bk_id = $('#vid_bk_id').val();
		var subject = $('#subject').val();
		var topic = $('#topic').val();
		var _class = $('#_class').val();
		var term = $('#term').val();
		var week_ = $('#week_').val();
		var video_file = $('#video_file').prop('files')[0];

		var sdata = new FormData();

		sdata.append("vid_bk_id", vid_bk_id);
		sdata.append("subject", subject);
		sdata.append("topic", topic);
		sdata.append("_class", _class);
		sdata.append("term", term);
		sdata.append("week_", week_);
		sdata.append("video", video_file);
		sdata.append("type", "SubmitVidBk2");

		$.ajax({
			url: '../admin/videos_books/class_vid_bk_db.php',
			type: "POST",
			dataType: 'json',
			processData: false,
			contentType: false,
			data: sdata,
			xhr: function() {
				const xhr = $.ajaxSettings.xhr();
				xhr.upload.addEventListener('progress', function(e) {
					const percent = Math.round((e.loaded / e.total) * 100);
					$('#uploadStatus').html(`Uploading... ${percent}%`);
				});
				return xhr;
			},
			success: function(response) {
				$.alert({
					title: 'Message',
					content: response.msg,
					buttons: {
						ok: function() {
							// work here
							$('#book_form').trigger('reset');
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

	// for book delete
	$('.deleteBook').click(function() {
		var vid_book_id = $(this).attr("data-bid");
		$.confirm({
			title: 'CONFIRM',
			content: 'Are you sure you want to delete this note?',
			autoClose: 'cancelAction|10000',
			escapeKey: 'cancelAction',
			buttons: {
				confirm: {
					btnClass: 'btn-green',
					text: 'Yes',
					action: function() {
						$.ajax({
							url: '../admin/videos_books/class_vid_bk_db.php',
							type: "POST",
							dataType: 'json',
							data: {
								"vid_book_id": vid_book_id,
								"type": "delete_vid_book"
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

	// for video delete
	$('.deleteBook2').click(function() {
		var vid_book_id = $(this).attr("data-bid");
		$.confirm({
			title: 'CONFIRM',
			content: 'Are you sure you want to delete this note?',
			autoClose: 'cancelAction|10000',
			escapeKey: 'cancelAction',
			buttons: {
				confirm: {
					btnClass: 'btn-green',
					text: 'Yes',
					action: function() {
						$.ajax({
							url: '../admin/videos_books/class_vid_bk_db.php',
							type: "POST",
							dataType: 'json',
							data: {
								"vid_book_id": vid_book_id,
								"type": "delete_vid_book2"
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

	// for book view
	$('.viewBook').click(function() {
		var nid = $(this).attr("data-bid");
		$.ajax({
			url: '../admin/videos_books/class_vid_bk_db.php',
			type: "POST",
			dataType: 'json',
			data: {
				"video_book_id": nid,
				"type": "get_video_book"
			},
			success: function(response) {
				$('#vid_bk_id').val(response.video_book_id);
				$('#subject').val(response.subject);
				$('#topic').val(response.topic);
				$('#_class').val(response.class);
				$('#term').val(response.term);
				$('#week_').val(response.week);
				$('#pdf_display').attr("src", response.pdf_path);
				// $('#video_display').attr("src", response.video_path);
			},
			error: function(err) {
				console.log(err);
			}
		})
	})

	// for video view
	$('.viewBook2').click(function() {
		var nid = $(this).attr("data-bid");
		$.ajax({
			url: '../admin/videos_books/class_vid_bk_db.php',
			type: "POST",
			dataType: 'json',
			data: {
				"video_book_id": nid,
				"type": "get_video_book"
			},
			success: function(response) {
				$('#vid_bk_id').val(response.video_book_id);
				$('#subject').val(response.subject);
				$('#topic').val(response.topic);
				$('#_class').val(response.class);
				$('#term').val(response.term);
				$('#week_').val(response.week);
				// $('#pdf_display').attr("src", response.pdf_path);
				$('#video_display').attr("src", response.video_path);
			},
			error: function(err) {
				console.log(err);
			}
		})
	})

})
</script>