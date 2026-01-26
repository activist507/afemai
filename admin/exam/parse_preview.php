<?php
  if(session_status() === PHP_SESSION_NONE)
    {
      session_start();
    }
  include '../config/db_connect.php';
  require __DIR__ . '/vendor/autoload.php';
  use PhpOffice\PhpWord\IOFactory;

  $uploadDir = __DIR__ . '/uploads';
  $mediaDirBase = __DIR__ . '/uploads/exam_media';
  if (!is_dir($uploadDir)) mkdir($uploadDir,0755,true);
  if (!is_dir($mediaDirBase)) mkdir($mediaDirBase,0755,true);

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') die('Invalid request');
  if (!isset($_FILES['docfile']) || $_FILES['docfile']['error'] !== UPLOAD_ERR_OK) die('Upload failed');
  
  $class_id = $_POST['class_id'] ?? 'No Class';
  $subject_id = $_POST['subject_id'] ?? 'No subject';
  $term_id = $_POST['term_id'] ?? 0;
  $assessment_type = $_POST['assessment_type'] ?? 'Not Identified';
  $no_of_question = $_POST['no_of_question'] ?? 0;
  $alloted_mark = $_POST['alloted_mark'] ?? 0;
  $total_mark = $_POST['total_mark'] ?? 0;
  $duration = $_POST['duration'] ?? 0;
  $examTitle = examTitle($subject_id,$class_id,$assessment_type,$term_id);

  // save upload
  $tmp = $_FILES['docfile']['tmp_name'];
  $fn = basename($_FILES['docfile']['name']);
  $save = $uploadDir . '/' . time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/','_',$fn);
  move_uploaded_file($tmp,$save);
  $phpWord = IOFactory::load($save);
  $paras = [];
  $imagesFound = [];

  $filepath = ltrim(strstr($save, '/'), '/'); 

  foreach ($phpWord->getSections() as $section) {
      foreach ($section->getElements() as $el) {
          $type = get_class($el);
          if ($type === 'PhpOffice\\PhpWord\\Element\\TextRun') {
              $textRun = '';
              foreach ($el->getElements() as $r) {
                  $rt = get_class($r);
                  if ($rt === 'PhpOffice\\PhpWord\\Element\\Text') {
                      $textRun .= $r->getText();
                  } elseif ($rt === 'PhpOffice\\PhpWord\\Element\\Image') {
                      $source = $r->getSource();
                      $ext = pathinfo($source, PATHINFO_EXTENSION);
                      $destDir = __DIR__ . '/uploads/exam_media/' . date('Ymd');
                      if (!is_dir($destDir)) mkdir($destDir, 0755, true);
                      $destName = 'img_' . uniqid() . '.' . $ext;
                      $destPath = $destDir . '/' . $destName;
                      $publicPath = 'uploads/exam_media/' . date('Ymd') . '/' . $destName;
                      if (@copy($source, $destPath)) {
                          $textRun .= ' [[IMAGE:' . $publicPath . ']]';
                          $imagesFound[] = $publicPath;
                      } else {
                          error_log("Failed to copy from $source to $destPath");
                      }
                  } else {
                      if (method_exists($r,'getText')) $textRun .= $r->getText();
                  }
              }
              $textRun = trim($textRun);
              if ($textRun !== '') $paras[] = $textRun;
          } elseif ($type === 'PhpOffice\\PhpWord\\Element\\Text') {
              $t = trim($el->getText()); if ($t !== '') $paras[] = $t;
          } elseif ($type === 'PhpOffice\\PhpWord\\Element\\Image') {
              $source = $el->getSource(); $ext = pathinfo($source, PATHINFO_EXTENSION);
              $destDir = $mediaDirBase . '/' . date('Ymd'); if (!is_dir($destDir)) mkdir($destDir,0755,true);
              $destName = 'img_' . uniqid() . '.' . $ext; $destPath = $destDir . '/' . $destName; if (file_exists($source)) copy($source,$destPath);
              $publicPath = 'uploads/exam_media/' . date('Ymd') . '/' . $destName;
              $paras[] = '[[IMAGE:' . $publicPath . ']]';
              $imagesFound[] = $publicPath;
          } else {
            // skip other element types or implement if needed (tables, lists)
          }
      }
  }

  function groupParagraphsToBlocks($paras) {
      $blocks = [];
      $current = [];
      foreach ($paras as $p) {
          if (preg_match('/^\s*(Q|Question|Q\.)\s*\d+|^\s*\d+\./i', $p)) {
              if (!empty($current)) { $blocks[] = $current; $current = []; }
              $current[] = $p; continue;
          }
          if (stripos($p,'ANSWER:') !== false) {
              $current[] = $p; $blocks[] = $current; $current = []; continue;
          }
          $current[] = $p;
      }
      if (!empty($current)) $blocks[] = $current;
      return $blocks;
  }

  $blocks = groupParagraphsToBlocks($paras);

  $parsed = [];
  foreach ($blocks as $bidx => $block) {
      $blockText = implode("\n", $block);
      $optPos = preg_match('/\n?\s*(A\)|A\.|\(A\)|A\.)/i', $blockText, $m, PREG_OFFSET_CAPTURE) ? $m[0][1] : false;
      if ($optPos !== false) {
          $qtext = trim(substr($blockText,0,$optPos));
          $optText = trim(substr($blockText,$optPos));
      } else {
          $qtext = trim($blockText);
          $optText = '';
      }

      $options = [];
      if ($optText !== '') {
          $lines = preg_split('/\r\n|\r|\n/', $optText);
          foreach ($lines as $ln) {
              if (preg_match('/^\s*([A-Z])\s*[\)\.\-:]\s*(.+)$/i', $ln, $m)) {
                  $k = strtoupper($m[1]); $options[$k] = trim($m[2]);
              }
          }
      } else {
          $lines = preg_split('/\r\n|\r|\n/', $blockText);
          foreach ($lines as $ln) {
              if (preg_match('/^\s*([A-Z])\s*[\)\.\-:]\s*(.+)$/i', $ln, $m)) {
                  $k = strtoupper($m[1]); $options[$k] = trim($m[2]);
              }
          }
      }

      $answer = null;
      if (preg_match('/ANSWER\s*[:\-]\s*([A-Z])/i', $blockText, $am)) $answer = strtoupper($am[1]);

      $image = null;
      if (preg_match('/\[\[IMAGE:([^\]]+)\]\]/i', $blockText, $im)) $image = trim($im[1]);

      $parsed[] = [
          'question_raw' => $qtext,
          'options' => $options,
          'answer' => $answer,
          'image' => $image
      ];
  }
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Import Preview</title>
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
        <form action="commit_import.php" method="post">
          <input type="hidden" name="filepath" value="<?=$filepath?>">
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
            <?php foreach ($parsed as $idx => $pq): ?>
              <div class="container py-2">
                <div class="card shadow-sm container">
                  <h3 class="text-center">Question <?=($idx+1)?></h3>
                  <label>Question text:</label>
                  <?php 
                    // $cleaned = preg_replace('/\[\[IMAGE:[^\]]*\]\]/i', '', $pq['question_raw']);
                    $cleaned = preg_replace('/\[\[IMAGE:.*$/is', '', $pq['question_raw']);
                    $qtext = trim($cleaned);
                  ?>
                  <textarea data-idx="<?=$idx?>" dir="auto" class="qtext form-control d-none" style="height: 100px;"><?=htmlspecialchars($qtext)?>
                  </textarea>
                  <p data-idx="<?=$idx?>" dir="auto" ><?=nl2br(htmlspecialchars($qtext))?></p>
                  <?php if ($pq['image']): ?>
                    <img src="<?=htmlspecialchars($pq['image'])?>" style="max-width:150px;display:block;margin-bottom:5px">
                    <label class="d-none">Image path (leave as-is or replace server path):</label>
                    <input type="hidden" class="qimage" value="<?=htmlspecialchars($pq['image'])?>">
                  <?php endif; ?>
                  <div class="opts">
                    <?php foreach ($pq['options'] as $k => $v): ?>
                      <div class="row ">
                        <div class="col-lg-1 col-sm-2 py-1">
                          <input type="text" disabled class="optkey form-control" value="<?=$k?>">
                        </div>
                        <div class="col-lg-1 col-sm-2 py-1">
                          <input type="checkbox" class="optcorrect form-check-input" <?=($pq['answer'] && strtoupper($pq['answer'])===$k)?'checked':''?>>
                        </div>
                        <div class="col-lg-10 col-sm-8 py-1">
                          <p dir="auto"><?=htmlspecialchars($v)?></p>
                          <input type="text" dir="auto" class="opttext form-control d-none" value="<?=htmlspecialchars($v)?>">
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="row">
            <div class="col-4"></div>
            <div class="col-4"></div>
            <div class="col-4">
              <button type="button" id="saveBtn" class="btn btn-success w-100" onclick="collectAndSubmit()">
                <span class="btn-text">Insert Questions</span>
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
  
  <script type="text/javascript">
    MathJax = {
      loader: {load: ["input/asciimath", "output/chtml", "ui/menu"]},
      output: {
        font: "mathjax-newcm",
        fontPath: 'mathjax',
      }
    }
  </script>
  <script defer src="mathjax/tex-chtml.js"></script>
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
        for(let i=0;i<optKeys.length;i++){
          opts.push({
            key: optKeys[i].value.trim(),
            text: optTexts[i].value.trim(),
            correct: optCorrects[i].checked ? 1 : 0
          });
        }
        const imgEl = qblock.querySelector('.qimage');
        payload.push({
          question: qtext,
          options: opts,
          image: imgEl ? imgEl.value : null
        });
      });

      // Prepare form data
      let formData = new FormData();
      formData.append("filepath", document.querySelector("input[name=filepath]").value);
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
        url: "commit_import.php",
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
