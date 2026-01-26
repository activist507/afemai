<?php 
$question_id=$_GET['question_id'];
$Questions =  $conn->query("SELECT * FROM questions WHERE question_id='$question_id'")->fetch_object();
$dur = $Questions->time_minutes*60;

?>
<main id="main" class="main">
    <div class="content">
        <div class="row g-3 mb-3">
            <div class="col-lg-12 col-md-12 order-md-first order-sm-last">
                <div class="card h-100">
                    <div class="card-header bg-body-tertiary d-flex flex-between-center py-2 ">
                        <div class="col-6">
                            <h6 class="mb-0">Obj | ID:<span class="fw-bold"><?= $Questions->question_id?> </span></h6>
                        </div>
                        <div class="col-6">
                            <div class="d-flex flex-between-center gap-1">
                                <!-- @if ($Questions->end_time) -->
                                <small>Stop-Time: </small>
                                <small id="timerB" class="text-center fw-bold">
                                    <!-- {{ ' ' . $Questions->end_time }} -->
                                    <!-- 23:12:00 -->
                                </small>
                                <small class="fw-bold">Not Set</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-1 h-100">
                            <!-- script to render PDF to the viewer  -->
                            <div class="col-md-12 col-lg-12">
                                <div class="card position-relative rounded-4">

                                    <embed src="../storege/<?=$Questions->question_pdf?>" type="application/pdf"
                                        width="100%" height="370px">
                                </div>
                            </div>
                            <!-- end of pdf  -->
                            <div class="col-md-12 col-lg-12">
                                <form id="quizForm">
                                    <div id="optionContainer" class="row">
                                        <div class="col-md-12 ms-4 pb-3" id="optionsContainer"
                                            data-questionCounter="<?= $Questions->total_question+1?>">
                                            <?php for($i = 1; $i < $Questions->total_question+1; $i++){?>

                                            <div class="row justify-content-between align-items-center d-flex d-none"
                                                id="group<?=$i?>">
                                                <!-- Options will be dynamically populated here -->
                                                <div class="col-3 form-check"><input type="radio" id="option1"
                                                        name="ans<?=$i?>" class="form-check-input group<?=$i?>"
                                                        value="A"><label class="form-check-label" for="option1">
                                                        A</label>
                                                </div>
                                                <div class="col-3 form-check"><input type="radio" id="option2"
                                                        name="ans<?=$i?>" class="form-check-input" value="B"><label
                                                        class="form-check-label" for="option2">
                                                        B</label>
                                                </div>
                                                <div class="col-3 form-check "><input type="radio" id="option3"
                                                        name="ans<?=$i?>" class="form-check-input" value="C"><label
                                                        class="form-check-label" for="option3">
                                                        C</label>
                                                </div>
                                                <div class="col-3 form-check "><input type="radio" id="option4"
                                                        name="ans<?=$i?>" class="form-check-input" value="D"><label
                                                        class="form-check-label" for="option4">
                                                        D</label>
                                                </div>
                                            </div>
                                            <?php  }?>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <button class="btn btn-primary" style="width: 90px;"
                                                    id="prevBtn">Prev</button>
                                            </div>
                                            <div>
                                                <input type="text" class="form-control text-center fw-bold"
                                                    id="questionNumber" readonly>
                                            </div>
                                            <div>
                                                <button class="btn btn-primary" style="width: 90px;"
                                                    id="nextBtn">Next</button>
                                            </div>
                                        </div>
                                    </div>


                                    <input type="hidden" name="selectedOptions" id="selectedOptionsInput">
                                    <input type="hidden" name="answersObj" id="answersInput">

                                    <input type="hidden" name="allottedMark" value="<?=$Questions->alloted_mark ?>">
                                    <input type="hidden" id="endTime" name="end_time"
                                        value="<?=$Questions->end_time ?>">

                                    <input type="hidden" name="exam_type" value="<?=$Questions->exam_type ?>">

                                    <input type="hidden" name="subject" value="<?=$Questions->subject ?>"
                                        id="write_subject">



                                    <div class="d-flex justify-content-between pt-3 align-items-center">
                                        <button type="submit" class="btn btn-success" style="width: 90px;"
                                            id="submitButton">
                                            Submit
                                        </button>
                                        <!-- {{-- @if (!empty($Questions->end_time)) --}} -->
                                        <div class="d-flex flex-between-center gap-1">
                                            <!-- {{-- <h5>Stop-Time: </h5>
                                                    <h5 id="timerB" class="text-center fw-bold">
                                                        {{ $Questions->end_time }}
                                            </h5> --}} -->

                                            <h5>Time Left: <span id="countdown"
                                                    class="text-center fw-bold "><?= $dur?>:00</span>
                                            </h5>

                                        </div>
                                        <!-- {{-- @endif --}} -->
                                    </div>
                                    <div id="answerContainer">
                                        <input type="hidden" value="<?= $Questions->alloted_mark ?>" id="mark">
                                        <input type="hidden" value="<?= $Questions->q1 ?>" id="ans1">
                                        <input type="hidden" value="<?= $Questions->q2 ?>" id="ans2">
                                        <input type="hidden" value="<?= $Questions->q3 ?>" id="ans3">
                                        <input type="hidden" value="<?= $Questions->q4 ?>" id="ans4">
                                        <input type="hidden" value="<?= $Questions->q5 ?>" id="ans5">
                                        <input type="hidden" value="<?= $Questions->q6 ?>" id="ans6">
                                        <input type="hidden" value="<?= $Questions->q7 ?>" id="ans7">
                                        <input type="hidden" value="<?= $Questions->q8 ?>" id="ans8">
                                        <input type="hidden" value="<?= $Questions->q9 ?>" id="ans9">
                                        <input type="hidden" value="<?= $Questions->q10 ?>" id="ans10">

                                        <input type="hidden" value="<?= $Questions->q11 ?>" id="ans11">
                                        <input type="hidden" value="<?= $Questions->q12 ?>" id="ans12">
                                        <input type="hidden" value="<?= $Questions->q13 ?>" id="ans13">
                                        <input type="hidden" value="<?= $Questions->q14 ?>" id="ans14">
                                        <input type="hidden" value="<?= $Questions->q15 ?>" id="ans15">
                                        <input type="hidden" value="<?= $Questions->q16 ?>" id="ans16">
                                        <input type="hidden" value="<?= $Questions->q17 ?>" id="ans17">
                                        <input type="hidden" value="<?= $Questions->q18 ?>" id="ans18">
                                        <input type="hidden" value="<?= $Questions->q19 ?>" id="ans19">
                                        <input type="hidden" value="<?= $Questions->q20 ?>" id="ans20">

                                        <input type="hidden" value="<?= $Questions->q21 ?>" id="ans21">
                                        <input type="hidden" value="<?= $Questions->q22 ?>" id="ans22">
                                        <input type="hidden" value="<?= $Questions->q23 ?>" id="ans23">
                                        <input type="hidden" value="<?= $Questions->q24 ?>" id="ans24">
                                        <input type="hidden" value="<?= $Questions->q25 ?>" id="ans25">
                                        <input type="hidden" value="<?= $Questions->q26 ?>" id="ans26">
                                        <input type="hidden" value="<?= $Questions->q27 ?>" id="ans27">
                                        <input type="hidden" value="<?= $Questions->q28 ?>" id="ans28">
                                        <input type="hidden" value="<?= $Questions->q29 ?>" id="ans29">
                                        <input type="hidden" value="<?= $Questions->q30 ?>" id="ans30">

                                        <input type="hidden" value="<?= $Questions->q31 ?>" id="ans31">
                                        <input type="hidden" value="<?= $Questions->q32 ?>" id="ans32">
                                        <input type="hidden" value="<?= $Questions->q33 ?>" id="ans33">
                                        <input type="hidden" value="<?= $Questions->q34 ?>" id="ans34">
                                        <input type="hidden" value="<?= $Questions->q35 ?>" id="ans35">
                                        <input type="hidden" value="<?= $Questions->q36 ?>" id="ans36">
                                        <input type="hidden" value="<?= $Questions->q37 ?>" id="ans37">
                                        <input type="hidden" value="<?= $Questions->q38 ?>" id="ans38">
                                        <input type="hidden" value="<?= $Questions->q39 ?>" id="ans39">
                                        <input type="hidden" value="<?= $Questions->q40 ?>" id="ans40">

                                        <input type="hidden" value="<?= $Questions->q41 ?>" id="ans41">
                                        <input type="hidden" value="<?= $Questions->q42 ?>" id="ans42">
                                        <input type="hidden" value="<?= $Questions->q43 ?>" id="ans43">
                                        <input type="hidden" value="<?= $Questions->q44 ?>" id="ans44">
                                        <input type="hidden" value="<?= $Questions->q45 ?>" id="ans45">
                                        <input type="hidden" value="<?= $Questions->q46 ?>" id="ans46">
                                        <input type="hidden" value="<?= $Questions->q47 ?>" id="ans47">
                                        <input type="hidden" value="<?= $Questions->q48 ?>" id="ans48">
                                        <input type="hidden" value="<?= $Questions->q49 ?>" id="ans49">
                                        <input type="hidden" value="<?= $Questions->q50 ?>" id="ans50">


                                        <input type="hidden" value="0" id="answerCount">

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sound generator -->
        <audio id="myAudio">
            <source src="../alarm.wav" type="audio/wav">
        </audio>
        <!-- Sound generator -->
    </div>
</main>
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#questionNumber').val('0');

    var qestionNumber = $('#questionNumber').val();
    if (qestionNumber == 0) {
        $('#prevBtn').addClass('disabled');
    }


    $('#nextBtn').click(function(e) {
        e.preventDefault();
        var maxQuestion = $('#optionsContainer').attr('data-questionCounter');
        const qst = parseInt($('#questionNumber').val());
        const newVal = qst + 1;
        $('#prevBtn').removeClass('disabled');
        if (newVal == maxQuestion) {
            $('#nextBtn').addClass('disabled');
            $('#questionNumber').val(qst);
        } else {
            $('#questionNumber').val(newVal);

            $('#group' + qst).addClass('d-none');
            $('#group' + newVal).removeClass('d-none');
        }

    })

    $('#prevBtn').click(function(e) {
        e.preventDefault();
        const qst = parseInt($('#questionNumber').val());
        const newVal = qst - 1;
        if (newVal == 0) {
            $('#prevBtn').addClass('disabled');
            $('#questionNumber').val(qst);
        } else {
            $('#questionNumber').val(newVal);
            $('#group' + qst).addClass('d-none');
            $('#group' + newVal).removeClass('d-none');

            if ($('#nextBtn').hasClass('disabled')) {
                $('#nextBtn').removeClass('disabled');
            }
        }

    })

    function submitAnswers() {
        var correct_ans = parseInt($('#answerCount').val());
        var allotedmark = parseInt($('#mark').val());
        var allquestion = '<?= $Questions->total_question?>';
        // getting the answers after submission
        var answer = $('.form-check-input').serializeArray();
        $('input[type="radio"]:checked').each(function(index, element) {
            var id_stud_ans = element.name;
            var stud_ans = element.value;
            var qst_ans = $('#answerContainer').find('#' +
                id_stud_ans).val().toUpperCase();

            //qst_ans and stud_ans comparison
            if (qst_ans == stud_ans) {
                correct_ans++;
            }
        });
        var stud_score = correct_ans * allotedmark;
        var overall_score = allquestion * allotedmark;
        //submitting to database
        var subject = $('#write_subject').val();
        var intakeCode = '<?=$intakeCode?>';
        var question_id = '<?=$question_id?>';

        $.ajax({
            url: 'index_db.php',
            type: 'POST',
            dataType: 'JSON',
            cache: false,
            data: {
                "intakeCode": intakeCode,
                "subject": subject,
                "question_id": question_id,
                "invitee_score": stud_score,
                "type": "updateScore"
            },
            success: function(response) {
                // Sound script
                let audio = document.getElementById("myAudio");
                audio.play().catch(error => {
                    console.log("Autoplay blocked, waiting for user interaction");
                });
                // END sound script
                $.confirm({
                    icon: 'bi bi-patch-question',
                    theme: 'bootstrap',
                    title: 'Congratulation',
                    content: 'You have successfully submitted your exam. You Scored ' +
                        stud_score + ' out of ' + overall_score,
                    animation: 'scale',
                    type: 'orange',
                    buttons: {
                        ok: {
                            btnClass: 'btn-green',
                            text: "Ok",
                            action: function() {
                                localStorage.removeItem('countdownTime');
                                window.location.href = "./";
                            }
                        }
                    }
                })
            },
            error: function(err) {
                console.log(err)
            }
        })


    }

    $('#quizForm').on('click', '.btn-success', function(e) {
        e.preventDefault();
        // confirmation from the students
        $.confirm({
            title: 'CONFIRM',
            content: 'Are you sure you want to submit?',
            animation: 'zoom',
            animationBounce: 2.5,
            closeAnimation: 'scale',
            theme: 'supervan',
            buttons: {
                confirm: {
                    btnClass: 'btn-green',
                    text: 'Yes',
                    action: function() {
                        submitAnswers();
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

    // New Timer
    let countdownTime = <?= $dur?>; // 16 minutes in seconds
    let timerInterval;
    let storedTime = localStorage.getItem('countdownTime');
    if (storedTime) {
        // Timer was already started, resume it
        countdownTime = storedTime;
        timerInterval = setInterval(updateTimer, 1000);
        updateTimer();
    } else {
        // Start a new timer
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
            // alert("Time's up!");
            submitAnswers();
        }
    }

    function resumeTimer() {
        timerInterval = setInterval(updateTimer, 1000);
    }

    // preventing back button 
    window.history.pushState(null, null, window.location.href);
    window.onpopstate = function() {
        window.history.pushState(null, null, window.location.href);
    };

})
</script>