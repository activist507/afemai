<?php 
    $video_play_backs = $conn->query("SELECT * FROM video_play_backs WHERE class = '$Student_Class' ORDER BY subject ASC");

?>
<main id="main" class="main">

	<div class="card mt-0">
		<div class="card-footer bg-body-tertiary py-2 text-center">
			<form action="">
				<div class="row">
					<div class="col-sm-3"></div>
					<div class="col-sm-6 mb-2 mb-sm-0">
						<div class="tom-select-custom">
							<input type="text" class="form-control text-center text-uppercase fw-bold" id="topic"
								disabled value="Class Videos" style="background:rgba(214, 226, 214, 0.93);">
						</div>
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="col-md-12 col-lg-12 pt-1">
					<video id="video_display" width="100%" height="485px" controls></video>
				</div>

			</form>

			<div class="table-responsive pt-2">
				<table class="table table-bordered border-primary table-striped">
					<thead>
						<tr>
							<th scope="col" nowrap="nowrap">File Path</th>
							<th scope="col" nowrap="nowrap">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php while($video = $video_play_backs->fetch_object()){?>
						<tr>
							<td nowrap="nowrap"><?= $video->file_path?></td>

							<td nowrap="nowrap">
								<div class="text-center">
									<a href="#" class="btn btn-link p-0 viewVid" data-vid="<?= $video->id?>">
										<span class="text-500 text-success bi bi-camera"></span>
									</a>
									&nbsp;&nbsp;
								</div>
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</main>
<script type="text/javascript">
$(document).ready(function() {

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
				var topic = $('#topic').val(response.topic);
				$('#video_display').attr("src", response.video_path);
			},
			error: function(err) {
				console.log(err);
			}
		})
	})

})
</script>