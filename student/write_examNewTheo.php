<?php
  if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
  include '../admin/config/db_connect.php';

  //<=============exam details ===============>
    $std_id = $_SESSION['std_id'];
    if(isset($_GET['exam_id'])){
      $exam_id = intval($_GET['exam_id'] ?? 0);
      $exam = $conn->query("SELECT * FROM exams WHERE id='$exam_id'")->fetch_assoc();
      $subject_id = $exam['subject_id'] ?? '';
      $term_id = $exam['term_id'] ?? '';
      $question_type = $exam['assessment_type'] ?? '';
      $exam_type = $exam['assessment_type'] ?? '';
      $no_of_question = $exam['no_of_question'] ?? 0;
      $duration = $exam['duration']*60;
      $session = date('Y');
      $student_record = $conn->query("SELECT Fullnames,Branch,Student_Class FROM student_records WHERE Student_ID='$std_id' ")->fetch_assoc();
      $class_id = $student_record['Student_Class'] ?? '';
      $Fullnames = $student_record['Fullnames'] ?? '';
      $Branch = $student_record['Branch'] ?? '';
    } else {
      echo "<script>
        window.location = './student'
      </script>";
    }
  //<=============exam details ===============>

  //<===============Get the questions and options =================>
    $qres = $conn->query("SELECT * FROM questionns WHERE exam_id=$exam_id LIMIT $no_of_question");
    $questions = [];
    while ($q = $qres->fetch_assoc()) {
      $ores = $conn->query("SELECT * FROM options WHERE question_id=".(int)$q['id']);
      $opts = [];
      while ($o = $ores->fetch_assoc()) {
        $opts[] = $o;
      }
      $q['options'] = $opts;
      $questions[] = $q;
    }
    // shuffle($questions);
  //<===============Get the questions and options =================>
  
  $written =  0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($exam['title']) ?> - Exam</title>
  <link rel="stylesheet" href="../../admin/assets/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../admin/assets/css/jquery-confirm.min.css">
  <script src="../../admin/assets/js/jquery-3.7.1.min.js"></script>
  <script src="../../admin/assets/js/jquery-confirm.min.js"></script>
  <link href="../../admin/assets/css/style.css" rel="stylesheet">
  <style>
    /* ====== Enlarge and stretch jQuery Confirm box ====== */
    .jconfirm-box {
      width: 100% !important;
      max-width: 600px !important;
      height: 100% !important;         /* Makes dialog nearly full-screen */
      max-height: 100% !important;
      overflow-y: auto !important;    /* Allows scrolling if text overflows */
      font-size: 50px !important;     /* Larger font for content */
      line-height: 1.4;
    }

    .jconfirm-title {
      font-size: 55px !important;
      font-weight: bold;
    }

    .jconfirm-content {
      font-size: 50px !important;
      padding: 10px 0;
    }

    .jconfirm-buttons button {
      font-size: 36px !important;
      padding: 18px 30px !important;
      border-radius: 12px;
    }

    @media (min-width: 768px) {
      .jconfirm-box {
        width: 500px !important; /* slightly smaller on larger screens */
        height: auto !important;
      }
    }
  </style>

  <style>
    .question-card { display:none; }
    .question-card.active { display:block; }

    /* scrolling */
    .card.fixed-scroll {
      height: 1500px;         
      overflow-y: auto;       
      overflow-x: hidden;     
    }

    .card.fixed-scroll2 {
      height: 140px;         
      overflow-y: auto;       
      overflow-x: hidden;     
    }
    .card.fixed-scroll::-webkit-scrollbar {
      width: 6px;
    }

    .card.fixed-scroll::-webkit-scrollbar-thumb {
      background-color: rgba(0,0,0,0.2);
      border-radius: 10px;
    }

    .container {
      max-width: 90% !important;
      padding-left: 6px !important;
      padding-right: 6px !important;
    }

    .profile-card p {
      font-size: 40px;
      font-weight: bold;
      text-align: justify;
      word-wrap: break-word;
      overflow-wrap: break-word;
      white-space: normal;
      width: 100%;
    }
    /* scrolling */
  </style>
  <script type="text/javascript">
    MathJax = {
      loader: {load: ["input/asciimath", "output/chtml", "ui/menu"]},
      output: {
        font: "mathjax-newcm",
        fontPath: '../../admin/exam/mathjax',
      }
    }
  </script>
  <script defer src="../../admin/exam/mathjax/tex-chtml.js"></script>
</head>
<body class="bg-light">
<?php if($written < 1){?>
  <section class="section profile">
    <input type="hidden" value="<?= $class_id?>" id="class_id">
    <input type="hidden" value="<?= $std_id?>" id="std_id">
    <input type="hidden" value="<?= $Fullnames?>" id="Fullnames">
    <input type="hidden" value="<?= $Branch?>" id="Branch">
    <div class="container">
      <div class="row py-2">
        <div class="col-7"><p class="mb-4" style="font-size: 28px;"><strong><?= htmlspecialchars($exam['title']) ?></strong></p></div>
        <div class="col-2">
          <input type="text" class="form-control text-center fw-bold" style="font-size: 35px;" value="1" disabled id="questCount">
        </div>
        <div class="col-3">
          <input type="text" class="form-control text-center fw-bold" style="font-size: 35px;" value="Out Of <?=$no_of_question?>" disabled>
        </div>
      </div>
    </div>

    <div class="row">
      <?php foreach ($questions as $idx=>$q): ?>
        <div class="col-xl-12 question-card <?= $idx==0?'active':'' ?>" data-index="<?= $idx ?>" data-qid="<?= $q['id'] ?>">
          <div class="card container fixed-scroll">
            <div class="card-body profile-card pt-3 d-flex flex-column align-items-center">
              <p style="font-size:40px" dir="auto"><strong><?= nl2br(htmlspecialchars($q['question_text'])) ?></strong></p>
              <?php if ($q['question_image']): ?>
                <img src="../../admin/exam/<?=htmlspecialchars($q['question_image'])?>" style="max-width:200px;display:block;margin-bottom:5px;height: 150px;">
              <?php endif; ?>
            </div>
          </div>

        </div>
      <?php endforeach;?>
      <div class="container">
        <div class="row py-3">
          <div class="col-6"><button id="prevBtn" class="btn btn-secondary w-100" style="font-size: 40px;">Prev</button></div>
          <div class="col-6"><button id="nextBtn" class="btn btn-primary w-100" style="font-size: 40px;">Next</button></div>
        </div>
        <div class="row py-3">
          <div class="col-6"><button id="submitExam" class="btn btn-success w-100" style="font-size: 40px;">Submit</button></div>
          <div class="col-6 pt-4"><h2 style="font-size: 40px;"><strong>Time Left: <span id="countdown" class="text-center fw-bold "><?= $duration?>:00</span></strong></h2></div>
        </div>
      </div>
    </div>
    <audio id="myAudio">
			<source src="../../alarm.wav" type="audio/wav">
		</audio>
  </section>

  <script>
    jconfirm.defaults = {
      theme: 'modern',
      boxWidth: '95%',
      useBootstrap: false,
      draggable: false,
      columnClass: 'col-12 col-offset-2',
      typeAnimated: true,
      animation: 'scale',
      titleClass: 'fw-bold fs-3',
      contentClass: 'fs-6',
    };
    let currentIndex = 0;
    let score = 0;
    let questCount = $('#questCount').val();
    const totalQuestions = $(".question-card").length;
    let answers = JSON.parse(localStorage.getItem("answers")) || {};
    $(document).ready(function () {
      for (const [qid, selectedOptionId] of Object.entries(answers)) {
        $(`.option-radio[name='q${qid}'][value='${selectedOptionId}']`).prop("checked", true);
      }
    });

    function showQuestion(idx) {
      $(".question-card").removeClass("active");
      $('.question-card[data-index="'+idx+'"]').addClass("active");
    }


    $("#nextBtn").click(function(){
      if (currentIndex < totalQuestions-1) {
        currentIndex++;
        questCount++;
        showQuestion(currentIndex);
        $('#questCount').val(questCount);
      }
    });
    $("#prevBtn").click(function(){
      if (currentIndex > 0) {
        currentIndex--;
        questCount--;
        showQuestion(currentIndex);
        $('#questCount').val(questCount);
      }
    });

    $(document).on("change", ".option-radio", function () {
      const parent = $(this).closest(".question-card");
      const qid = parent.data("qid");
      const optionId = $(this).val();
      const is_correct = $(this).data("is_correct");
      answers[qid] = optionId;
      localStorage.setItem("answers", JSON.stringify(answers));
    });

    function checkNext(exam_id,typ="doc"){
      var class_id = $('#class_id').val();
      var student_id = $('#std_id').val();
      var Fullnames = $('#Fullnames').val();
      var Branch = $('#Branch').val();
      $.post("../check_next.php",
        {
          "type":"checkNext","exam_id":exam_id,"student_id":student_id,"class_id":class_id,"Fullnames":Fullnames,"Branch":Branch,"typ":typ
        }
        ,null,"json")
      .done(function(response){
        window.location.href = response.link;
        // console.log(response)
      })
      .fail(function(error){
        console.log(error);
      })
    }


    function submitAnswer(){
      $.ajax({
        url: "../save_result.php",
        type: "POST",
        dataType: 'json',
        data: {"answers": JSON.stringify(answers),"score":score,"exam_id": <?= $exam_id ?>,"type":"save"},
        success: function(res){
          localStorage.removeItem("answers");
          localStorage.removeItem('countdownTime');
          clearInterval(timerInterval);
          $.confirm({
            title: 'Message!',
            content: res.msg,
            buttons: {
              ok: function () {
                // // window.location.href = '../../student'
                // window.location.href = '../../?studentlogin'
                checkNext(<?= $exam_id ?>);
              }
            }
          });
          let audio = document.getElementById("myAudio");
          audio.play().catch(error => {
            console.log("Autoplay blocked, waiting for user interaction");
          });
        },
        error: function(err){
          console.log(err);
        }
      })
    }
    $("#submitExam").click(function(){
      $.confirm({
        title: 'Confirm Action',
        content: 'Are You Sure You want to submit?',
        buttons: {
          confirm: function () {
            submitAnswer();
          },
          cancel: function () {}
        }
      });
    });

    let countdownTime = <?= $duration?>; 
    let timerInterval;
    let storedTime = localStorage.getItem('countdownTime');
    if (storedTime) {
      countdownTime = storedTime;
      timerInterval = setInterval(updateTimer, 1000);
      updateTimer();
    } else {
      localStorage.setItem('countdownTime', countdownTime);
      timerInterval = setInterval(updateTimer, 1000);
    }
    function updateTimer() {
      countdownTime--;
      localStorage.setItem('countdownTime', countdownTime);
      let minutes = Math.floor(countdownTime / 60);
      let seconds = countdownTime % 60;
      // Display the timer
      document.getElementById('countdown').innerHTML = `${ minutes}:${seconds.toString().padStart(2, '0')}`;

      if (countdownTime <= 0) {
        clearInterval(timerInterval);
        localStorage.removeItem('countdownTime');
        submitAnswer();
      }
    }
    function resumeTimer() {
      timerInterval = setInterval(updateTimer, 1000);
    }

  </script>
<?php }?>

<?php if($written > 0){?>
  <div class="container mt-5 ">
    <div class="card">
      <div class="card-body text-center">
        <h5>You have written this assessment already</h5>
        <div class="row">
          <div class="col-lg-4 col-sm-6"></div>
          <div class="col-lg-4 col-sm-6"></div>
          <div class="col-lg-4 col-sm-6">
            <a href="../../Student" class="btn btn-primary w-100">Dashboard</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php }?>

</body>
</html>
