<?php 
    $qstTerm = $conn->query("SELECT * FROM cbt_term");
    $qstClass = $conn->query("SELECT * FROM cbt_class");
    $qstSubjects = $conn->query("SELECT * FROM cbt_subjects");
    $video_play_backs = $conn->query("SELECT * FROM video_play_backs ORDER BY id DESC LIMIT 30");

?>
<main id="main" class="main">
	<div class="container">

		<div class="card mt-0">
			<div class="card-footer bg-body-tertiary py-2 text-center">
				<form action="" method="post" id="video_form" enctype="multipart/form-data">
					<div class="row gy-2">
						<div class="col-sm-2 mb-2 mb-sm-0">
							<div class="tom-select-custom">
								<input type="text" class="form-control text-center text-uppercase" disabled
									value="Class Videos" style="background:rgba(214, 226, 214, 0.93);">
							</div>
						</div>
						<div class="col-lg-2 col-sm-12">
							<div class="tom-select-custom">
								<input type="text" class="form-control text-center" disabled id="video_ID"
									name="video_ID" placeholder="Search ID" />
							</div>
						</div>
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
						<div class="col-lg-2 col-sm-12">
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


					</div>
					<div class="col-md-12 col-lg-12 pt-2">
						<div class="card position-relative rounded-4">
							<video id="video_display" width="100%" height="375px" controls></video>
						</div>
					</div>

					<div class="row gy-3">
						<div class="col-lg-10 col-sm-10">
							<input type="file" class="form-control" id="video_file" name="video_file"
								accept="video/*" />
						</div>
						<div class="col-lg-2 col-sm-2">
							<button type="submit" style="width: 8.5rem;" class="btn btn-primary" name="submitVideo"
								id="submit_form_btn">
								Submit
							</button>
						</div>
					</div>
					<div id="uploadStatus"></div>
				</form>

				<div class="table-responsive pt-4">
					<table class="table table-bordered border-primary table-striped">
						<thead>
							<tr>
								<th scope="col" nowrap="nowrap">V-ID</th>
								<th scope="col" nowrap="nowrap">Subject</th>
								<th scope="col" nowrap="nowrap">Topic</th>
								<th scope="col" nowrap="nowrap">Class</th>
								<th scope="col" nowrap="nowrap">Term</th>
								<th scope="col" nowrap="nowrap">File Path</th>
								<th scope="col" nowrap="nowrap">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php while($video = $video_play_backs->fetch_object()){?>
							<tr>
								<th scope="row" nowrap="nowrap"><?= $video->vid_id?></th>
								<td nowrap="nowrap"><?= $video->subject?></td>
								<td nowrap="nowrap"><?= $video->topic?></td>
								<td nowrap="nowrap"><?= $video->class?></td>
								<td nowrap="nowrap"><?= $video->term?></td>
								<td nowrap="nowrap"><?= $video->file_path?></td>
								<td nowrap="nowrap">
									<div class="text-center">
										<a href="#" class="btn btn-link p-0 viewVid" data-vid="<?= $video->id?>">
											<span class="text-500 text-success bi bi-camera"></span>
										</a>
										&nbsp;&nbsp;
										<a href="#" class="btn btn-link p-0 deleteVid" data-vid="<?= $video->id?>">
											<span class="text-500 text-danger bi bi-trash"></span>
										</a>
									</div>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
				</div>

			</div>
		</div>

	</div>
</main>
<script type="text/javascript">
$(document).ready(function() {

	$('#video_form').on('submit', function(e) {
		e.preventDefault();

		var video_ID = $('#video_ID').val();
		var subject = $('#subject').val();
		var topic = $('#topic').val();
		var _class = $('#_class').val();
		var term = $('#term').val();
		var video_file = $('#video_file').prop('files')[0];

		var sdata = new FormData();

		sdata.append("video_ID", video_ID);
		sdata.append("subject", subject);
		sdata.append("topic", topic);
		sdata.append("_class", _class);
		sdata.append("term", term);
		sdata.append("file", video_file);
		sdata.append("type", "submitVideo");

		$.ajax({
			url: '../admin/videos_books/class_video_db.php',
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
							$('#video_form').trigger('reset');
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

	$('.deleteVid').click(function() {
		var vid = $(this).attr("data-vid");
		$.confirm({
			title: 'CONFIRM',
			content: 'Are you sure you want to delete this video?',
			autoClose: 'cancelAction|10000',
			escapeKey: 'cancelAction',
			buttons: {
				confirm: {
					btnClass: 'btn-green',
					text: 'Yes',
					action: function() {
						$.ajax({
							url: '../admin/videos_books/class_video_db.php',
							type: "POST",
							dataType: 'json',
							data: {
								"video_id": vid,
								"type": "delete_vid"
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

	$('.viewVid').click(function() {
		var vId = $(this).attr("data-vid");
		$.ajax({
			url: '../admin/videos_books/class_video_db.php',
			type: "POST",
			dataType: 'json',
			data: {
				"video_id": vId,
				"type": "getVideo"
			},
			success: function(response) {
				$('#video_ID').val(response.vid_id);
				$('#subject').val(response.subject);
				$('#topic').val(response.topic);
				$('#_class').val(response.class);
				$('#term').val(response.term);
				$('#video_display').attr("src", response.video_path);
			},
			error: function(err) {
				console.log(err);
			}
		})
	})

})
</script>