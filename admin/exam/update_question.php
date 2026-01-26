<?php
  if(session_status() === PHP_SESSION_NONE)
    {
      session_start();
    }
  include '../config/db_connect.php';

  $examID = $_POST['examHiddenId'] ?? 0 ;
  $class_id = $_POST['class_id'] ?? 'No Class';
  $subject_id = $_POST['subject_id'] ?? 'No subject';
  $term_id = $_POST['term_id'] ?? 0;
  $assessment_type = $_POST['assessment_type'] ?? 'Not Identified';
  $no_of_question = $_POST['no_of_question'] ?? 0;
  $alloted_mark = $_POST['alloted_mark'] ?? 0;
  $total_mark = $_POST['total_mark'] ?? 0;
  $duration = $_POST['duration'] ?? 0;
  $examTitle = examTitle($subject_id,$class_id,$assessment_type,$term_id);

  $questions = fetch_all_assoc($conn->query("SELECT * FROM questionns WHERE exam_id = '$examID' ORDER BY id ASC"));
  function getqOpt($qid){
    global $conn;
    $options = fetch_all_assoc($conn->query("SELECT * FROM options WHERE question_id = '$qid'"));
    return $options;
  }

?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Edit Question</title>
    <link rel="stylesheet" href="../../admin/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../admin/assets/css/jquery-confirm.min.css">
    <script src="../../admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
      label{display:block;margin-top:8px} textarea{width:100%;min-height:60px}
    </style>
  </head>
<body class="bg-light">
  <div class="container mt-5 mb-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="card-title mb-3 text-center"> <?=htmlspecialchars($examTitle)?> </h2>
        <form action="update_question_db.php" method="post">
          <input type="hidden" name="exam_id" value="<?=$examID?>">
          <input type="hidden" name="class_id" value="<?=$class_id?>">
          <input type="hidden" name="subject_id" value="<?=$subject_id?>">
          <input type="hidden" name="term_id" value="<?=$term_id?>">
          <input type="hidden" name="assessment_type" value="<?=$assessment_type?>">
          <input type="hidden" name="no_of_question" value="<?=$no_of_question?>">
          <input type="hidden" name="alloted_mark" value="<?=$alloted_mark?>">
          <input type="hidden" name="total_mark" value="<?=$total_mark?>">
          <input type="hidden" name="duration" value="<?=$duration?>">
          <input type="hidden" name="exam_title" value="<?=htmlspecialchars($examTitle)?>">
          <input type="hidden" name="payload_json" id="payload_json">
          <div id="preview">
            <?php $idx=0; foreach ($questions as $pq): ?>
              <div class="container py-2">
                <div class="card shadow-sm container">
                  <h3 class="text-center">Question <?=($idx+1)?></h3>
                  <label>Question text:</label>
                  <textarea data-idx="<?=$idx?>" dir="auto" class="qtext form-control" style="height: 100px;"><?=htmlspecialchars($pq['question_text'])?>
                  </textarea>
                  <?php if ($pq['question_image']): ?>
                    <label>Image (preview):</label>
                    <img src="<?=htmlspecialchars($pq['question_image'])?>" style="max-width:150px;display:block;margin-bottom:5px">
                    <label class="d-none">Image path (leave as-is or replace server path):</label>
                    <input type="hidden" class="qimage" value="<?=htmlspecialchars($pq['question_image'])?>">
                  <?php endif; ?>
                  <input type="hidden" class="qID" value="<?=$pq['id']?>">
                  <div class="opts">
                    <?php $opts = getqOpt($pq['id']); foreach ($opts as $op): ?>
                      <div class="row ">
                        <div class="col-lg-1 col-sm-2 py-1">
                          <input type="hidden" class="optID" value="<?=$op['id']?>">
                          <input type="text" disabled class="optkey form-control" value="<?=$op['option_key']?>">
                        </div>
                        <div class="col-lg-1 col-sm-2 py-1">
                          <input type="checkbox" class="optcorrect form-check-input" <?=($op['is_correct'] == 1) ? 'checked':''?>>
                        </div>
                        <div class="col-lg-10 col-sm-8 py-1">
                          <input type="text" dir="auto" class="opttext form-control" value="<?=htmlspecialchars($op['option_text'])?>">
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            <?php $idx++; endforeach; ?>
          </div>
          <div class="row">
            <div class="col-4"></div>
            <div class="col-4"></div>
            <div class="col-4">
              <button type="button" id="saveBtn" class="btn btn-success w-100" onclick="collectAndSubmit()">
                <span class="btn-text">Update Questions</span>
                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
              </button>
            </div>
          </div>
          
        </form>

        <div class="progress my-3 d-none" id="uploadProgressWrapper">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" id="uploadProgress"></div>
        </div>
        <div id="responseMessage" class="mt-2"></div>

      </div>
    </div>
  </div>

  <script src="../../admin/assets/js/jquery-3.7.1.min.js"></script>
  <script src="../../admin/assets/js/jquery-confirm.min.js"></script>
  <script>
    function collectAndSubmit(){
      const qs = document.querySelectorAll('.qtext');
      const payload = [];
      qs.forEach((el,idx)=>{
        const qtext = el.value.trim();
        const qblock = el.closest('.card'); // better than generic div
        const opts = [];
        const optKeys = qblock.querySelectorAll('.optkey');
        const optTexts = qblock.querySelectorAll('.opttext');
        const optCorrects = qblock.querySelectorAll('.optcorrect');
        const optID = qblock.querySelectorAll('.optID');
        for(let i=0;i<optKeys.length;i++){
          opts.push({
            key: optKeys[i].value.trim(),
            text: optTexts[i].value.trim(),
            correct: optCorrects[i].checked ? 1 : 0,
            opt_id: optID[i].value.trim(),
          });
        }
        const imgEl = qblock.querySelector('.qimage');
        const qID = qblock.querySelector('.qID').value.trim();
        payload.push({
          qid: qID,
          question: qtext,
          options: opts,
          image: imgEl ? imgEl.value : null
        });
      });

      // Prepare form data
      let formData = new FormData();
      formData.append("exam_id", document.querySelector("input[name=exam_id]").value);
      formData.append("class_id", document.querySelector("input[name=class_id]").value);
      formData.append("subject_id", document.querySelector("input[name=subject_id]").value);
      formData.append("term_id", document.querySelector("input[name=term_id]").value);
      formData.append("assessment_type", document.querySelector("input[name=assessment_type]").value);
      formData.append("no_of_question", document.querySelector("input[name=no_of_question]").value);
      formData.append("alloted_mark", document.querySelector("input[name=alloted_mark]").value);
      formData.append("total_mark", document.querySelector("input[name=total_mark]").value);
      formData.append("duration", document.querySelector("input[name=duration]").value);
      formData.append("exam_title", document.querySelector("input[name=exam_title]").value);
      formData.append("payload_json", JSON.stringify(payload));

      // Button + spinner handling
      let $btn = $("#saveBtn");
      $btn.prop("disabled", true);
      $btn.find(".btn-text").text("Saving...");
      $btn.find(".spinner-border").removeClass("d-none");

      // Show progress bar
      $("#uploadProgressWrapper").removeClass("d-none");
      $("#uploadProgress").css("width", "0%").text("0%");

      // Do AJAX POST with progress
      $.ajax({
        xhr: function() {
          let xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
              let percentComplete = Math.round((evt.loaded / evt.total) * 100);
              $("#uploadProgress").css("width", percentComplete + "%").text(percentComplete + "%");
            }
          }, false);
          return xhr;
        },
        url: "update_question_db.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $("#responseMessage").html("<span class='text-info'>Uploading...</span>");
        },
        success: function(res){
          $("#responseMessage").html("<span class='text-success'>" + res + "</span>");
          $.alert({
            title: 'Message',
            content: res,
            buttons: {
              ok: function() {
                window.location.href = 'exam.php';
              }
            }
          });
        },
        error: function(xhr){
          $("#responseMessage").html("<span class='text-danger'>Error: " + xhr.responseText + "</span>");
        },
        complete: function(){
          $btn.prop("disabled", false);
          $btn.find(".btn-text").text("Save to DB");
          $btn.find(".spinner-border").addClass("d-none");
          $("#uploadProgress").removeClass("progress-bar-animated");
          
        }
      });
    }
  </script>


</body>
</html>
