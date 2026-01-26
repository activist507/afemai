<?php 
    // video
    $video_book = $conn->query("SELECT * FROM video_book WHERE class = '$Student_Class' AND book_path='' ORDER BY subject ASC");
    // book
    $video_book2 = $conn->query("SELECT * FROM video_book WHERE class = '$Student_Class' AND video_path='' ORDER BY subject ASC");

?>
<main id="main" class="main">

	<div class="card mt-0">
		<div class="card-footer bg-body-tertiary py-2 text-center">
			<form action="">
				<div class="row">
					<div class="col-sm-3"></div>
					<div class="col-sm-6 mb-0 mb-sm-0">
						<div class="tom-select-custom">
							<input type="text" class="form-control text-center text-uppercase fw-bold" id="topic"
								disabled value="Class Video_Book" style="background:rgba(214, 226, 214, 0.93);">
						</div>
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="col-md-12 col-lg-12 pt-0">
					<div class="row">
						<div class="col-sm-12 col-lg-4 "><video id="video_display" width="100%" height="200px"
								controls></video></div>
						<div class="col-sm-12 col-lg-8 "><embed src="" type="application/pdf" id="pdf_display"
								width="100%" height="330px"></div>
					</div>
				</div>

			</form>

			<div class="table-responsive pt-2">
				<table class="table table-bordered border-primary table-striped">
					<thead>
						<tr>
							<!-- <th scope="col" nowrap="nowrap">Video Path</th> -->
							<th scope="col" nowrap="nowrap">Video Topic</th>

							<th scope="col" nowrap="nowrap">Action</th>
						</tr>
					</thead>
					<tbody>

						<?php while($vid_bk = $video_book->fetch_object()){?>

						<tr>
							<!-- <td nowrap="nowrap"><?= $vid_bk->video_path?></td> -->
							<td nowrap="nowrap"><?= $vid_bk->topic?></td>

							<td nowrap="nowrap">
								<div class="text-center">
									<a href="#" class="btn btn-link p-0 viewVid" data-vid="<?= $vid_bk->id?>">
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

			<div class="table-responsive pt-2">
				<table class="table table-bordered border-primary table-striped">
					<thead>
						<tr>
							<th scope="col" nowrap="nowrap">Book Path</th>
							<th scope="col" nowrap="nowrap">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php while($vid_bk = $video_book2->fetch_object()){?>
						<tr>
							<td nowrap="nowrap"><?= $vid_bk->book_path?></td>
							<td nowrap="nowrap">
								<div class="text-center">
									<a href="#" class="btn btn-link p-0 viewVid2" data-vid="<?= $vid_bk->id?>">
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
			url: '../admin/videos_books/class_vid_bk_db.php',
			type: "POST",
			dataType: 'json',
			data: {
				"video_book_id": vId,
				"type": "get_video_book"
			},
			success: function(response) {
				var topic = $('#topic').val(response.topic);
				$('#video_display').attr("src", response.video_path);
				// $('#pdf_display').attr("src", response.pdf_path);
			},
			error: function(err) {
				console.log(err);
			}
		})
	})

	$('.viewVid2').click(function() {
		var vId = $(this).attr("data-vid");
		$.ajax({
			url: '../admin/videos_books/class_vid_bk_db.php',
			type: "POST",
			dataType: 'json',
			data: {
				"video_book_id": vId,
				"type": "get_video_book"
			},
			success: function(response) {
				var topic = $('#topic').val(response.topic);
				// $('#video_display').attr("src", response.video_path);
				$('#pdf_display').attr("src", response.pdf_path);
			},
			error: function(err) {
				console.log(err);
			}
		})
	})

})
</script>