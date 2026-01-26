<?php 
    $qstSession = $conn->query("SELECT * FROM tblsession");
    $qstTerm = $conn->query("SELECT * FROM cbt_term");
    $qstClass = $conn->query("SELECT * FROM cbt_class");
    $qstSubjects = $conn->query("SELECT * FROM cbt_subjects");
    // $allquestions = $conn->query("SELECT * FROM questions");

?>
<style>
.no-data {
    text-align: center;
    color: gray;
    font-style: italic;
}
</style>
<main id="main" class="main">
    <div class="container">

        <div class="card mt-0">
            <div class="card-footer bg-body-tertiary py-2 text-center">
                <form action="" method="post" id="question_sub_form" enctype="multipart/form-data">
                    <div class="row gy-3">
                        <div class="col-sm-2 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <input type="text" class="form-control text-center" name="teachers_name" value=""
                                    id="quest_auto_id" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Question Code" value="0">
                            </div>
                        </div>
                        <div class="col-sm-2 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <select name="question_type" id="question_type" class="form-control"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Question Type">
                                    <option value="Objective">Objective</option>
                                    <option value="Theory">Theory</option>
                                    <option value="Entrance">Entrance</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <select name="exam_type" id="exam_type" class="form-control" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Exam Type">
                                    <option value="Test1">Test1</option>
                                    <option value="Test2">Test2</option>
                                    <option value="Test3">Test3</option>
                                    <option value="Exam">Objectives</option>
                                    <option value="Theory">Theory</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <select name="_class" id="_class" class="form-control" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Class">
                                    <?php while($class = $qstClass->fetch_object()){ ?>
                                    <option value="<?= $class->class?>"><?= $class->class?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <select name="subject" id="subject" class="form-control" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Subject">
                                    <?php while($subject = $qstSubjects->fetch_object()){ ?>
                                    <option value="<?= $subject->subject?>"><?= $subject->subject?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <select name="term" id="term" class="form-control" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Term">
                                    <?php while($term = $qstTerm->fetch_object()){ ?>
                                    <option value="<?= $term->term?>"><?= $term->term?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <select name="session" id="session" class="form-control" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Session">
                                    <?php while($session = $qstSession->fetch_object()){ ?>
                                    <option value="<?= $session->csession?>"><?= $session->csession?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <input type="number" class="form-control text-center" name="question_Num" min="0"
                                    id="question_Num" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="No. Of Questions" max="50">
                            </div>
                        </div>
                        <div class="col-sm-2 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <input type="text" class="form-control text-center" name="alloted_mark" min="0"
                                    id="alloted_mark" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Alloted Mark">
                            </div>
                        </div>
                        <div class="col-sm-2 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <input type="text" class="form-control text-center" name="total_mark" min="0"
                                    id="total_mark" data-bs-toggle="tooltip" data-bs-placement="top" title="Total Mark">
                            </div>
                        </div>
                        <div class="col-sm-2 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <input type="text" class="form-control text-center" name="time_min" id="time_min"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Time (Minutes)" value="">
                            </div>
                        </div>
                        <div class="col-sm-2 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <input type="time" class="form-control text-center" name="end_time" id="end_time"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="End Time">
                            </div>
                        </div>
                    </div>

                    <!--  -->
                        <div class="row gy-1">
                        <div class="col-lg-6 col-sm-10 pt-3">
                            <input type="file" class="form-control" id="question_pdf_file" name="pdf_file"
                                accept="application/pdf" />
                        </div>
                        <div class="col-lg-6 col-sm-2 pt-3">
                            <button type="submit" style="width: 8.5rem;" class="btn btn-primary w-100"
                                name="submitQuestion" id="submit_form_btn">
                                Submit
                            </button>
                        </div>
                    </div>
                    <!--  -->

                    <div class="col-md-12 col-lg-12 pt-3">
                        <div class="card position-relative rounded-4">
                            <embed src="" type="application/pdf" id="shwpdf" width="100%" height="255px">
                        </div>
                    </div>

                    <div class="row pb-2" id="ans_grp">
                    </div>
                    
                </form>

                <div class="table-responsive pt-0">
                    <div class="row py-2">
                        <div class="col-lg-2 col-sm-12">
                            <select class="form-select" id="limit" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Entries Per Page">
                                <option selected value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-6"></div>
                        <div class="col-lg-4 col-sm-12 pt-0">
                            <div class="input-group">
                                <input type="text" placeholder="search" class="form-control" id="search">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered border-primary table-striped">
                        <thead>
                            <tr>
                                <th scope="col" nowrap="nowrap">Q-ID</th>
                                <th scope="col" nowrap="nowrap">Subject</th>
                                <!-- <th scope="col" nowrap="nowrap">Class</th> -->
                                <th scope="col" nowrap="nowrap">Test</th>
                                <th scope="col" nowrap="nowrap">Term</th>
                                <th scope="col" nowrap="nowrap">Preview</th>
                                <th scope="col" nowrap="nowrap">T - Q</th>
                                <th scope="col" nowrap="nowrap">A.Mark</th>
                                <th scope="col" nowrap="nowrap">T.Mark</th>
                                <th scope="col" nowrap="nowrap">Time</th>
                                <!-- <th scope="col" nowrap="nowrap">E.Time</th> -->
                                <th scope="col" nowrap="nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody id="allQuest">

                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination pagination-sm" id="pagination">
                            <!-- Pagination buttons -->
                        </ul>
                    </nav>
                </div>

                <!--  -->
                    <div class="row gy-3">                   
                        <div class="col-lg-6 col-sm-2 pt-2">
                            <button type="button" style="width: 8.5rem;" class="btn btn-danger w-100" name="del_test"
                                value="del_test" id="del_test">
                                Delete All Test
                            </button>
                        </div>
                        <div class="col-lg-6 col-sm-2 pt-2">
                            <button type="button" style="width: 9rem;" class="btn btn-danger w-100" name="del_exam"
                                value="del_exam" id="del_exam">
                                Delete All Exam
                            </button>
                        </div>
                    </div>
                <!--  -->

            </div>
        </div>

    </div>
</main>
<script type="text/javascript">
$(document).ready(function() {
    $('#question_Num').keyup(function() {
        var count = $(this).val();
        if (count > 0 && count < 51) {
            $('#ans_grp').html('');
            for (var i = 0; i < count; i++) {
                var id = i + 1;
                var htm = '<div class="col-lg-1 col-md-2"><label for="Q1" class="form-label">Q' + id +
                    '</label><input type="text" class="form-control text-center qst_ans" id="Q' + id +
                    '" name="Q' + id + '" style="text-transform:uppercase;"/></div>';
                $('#ans_grp').append(htm);
            }
        } else {
            $('#ans_grp').html('');
        }
    })

    $('#question_sub_form').on('submit', function(e) {
        e.preventDefault();

        var quest_auto_id = $('#quest_auto_id').val();
        // var teachers_name = $('#teachers_name').val();
        var question_type = $('#question_type').val();
        var exam_type = $('#exam_type').val();
        var _class = $('#_class').val();
        var subject = $('#subject').val();
        var term = $('#term').val();
        var session = $('#session').val();
        var question_Num = $('#question_Num').val();
        var alloted_mark = $('#alloted_mark').val();
        var total_mark = $('#total_mark').val();
        var time_min = $('#time_min').val();
        var end_time = $('#end_time').val();
        var question_pdf_file = $('#question_pdf_file').prop('files')[0];
        var qst_ans = $('.qst_ans').serializeArray();

        var sdata = new FormData();

        sdata.append("quest_auto_id", quest_auto_id);
        // sdata.append("teachers_name", teachers_name);
        sdata.append("question_type", question_type);
        sdata.append("exam_type", exam_type);
        sdata.append("_class", _class);
        sdata.append("subject", subject);
        sdata.append("term", term);
        sdata.append("session", session);
        sdata.append("question_Num", question_Num);
        sdata.append("alloted_mark", alloted_mark);
        sdata.append("total_mark", total_mark);
        sdata.append("time_min", time_min);
        sdata.append("end_time", end_time);
        sdata.append("file", question_pdf_file);
        sdata.append("qst_ans", JSON.stringify(qst_ans));
        sdata.append("type", "submitQuestion");

        $.ajax({
            // url: './admFunctions.php',
            url: '../admin/set_question/question_db.php',
            type: "POST",
            dataType: 'json',
            processData: false,
            contentType: false,
            data: sdata,
            success: function(response) {
                $.alert({
                    title: 'Message',
                    content: response.msg,
                    buttons: {
                        ok: function() {
                            // work here
                            // $('#question_sub_form').trigger('reset');
                            // location.reload(true);
                            $('#quest_auto_id').val(response.quest_auto_id);
                            $('#question_type').val(response.question_type);
                            $('#exam_type').val(response.exam_type);
                            $('#_class').val(response._class);
                            $('#subject').val(response.subject);
                            $('#term').val(response.term);
                            $('#session').val(response.Session);
                            $('#question_Num').val(response.question_Num);
                            $('#alloted_mark').val(response.alloted_mark);
                            $('#total_mark').val(response.total_mark);
                            $('#time_min').val(response.time_min);
                            $('#end_time').val(response.end_time);
                            $('#ans_grp').html(response.html);
                            $('#shwpdf').attr("src", response.quest_pdf);
                        }
                    }
                });
                // console.log(response);
            },
            error: function(err) {
                console.log(err);
            }
        })
    })

    $('#quest_auto_id').keyup(function(e) {
        var id = $(this).val();
        // var pattern = /^(?=.{6,})\d{3}-[a-zA-Z0-9]{3,4}$/;
        console.log(id)
        if (id.length > 6) {
            // if (pattern.test(id)) {
            $('#submit_form_btn').val('Update');
            $('#submit_form_btn').text('Update');
            $.ajax({
                // url: './admFunctions.php',
                url: '../admin/set_question/question_db.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    "question_code": id,
                    "type": "getQuestionDetails"
                },
                success: function(response) {
                    if (response.query == 'true') {
                        $('#quest_auto_id').val(response.quest_auto_id);
                        $('#question_type').val(response.question_type);
                        $('#exam_type').val(response.exam_type);
                        $('#_class').val(response._class);
                        $('#subject').val(response.subject);
                        $('#term').val(response.term);
                        $('#session').val(response.Session);
                        $('#question_Num').val(response.question_Num);
                        $('#alloted_mark').val(response.alloted_mark);
                        $('#total_mark').val(response.total_mark);
                        $('#time_min').val(response.time_min);
                        $('#end_time').val(response.end_time);
                        $('#ans_grp').html(response.html);
                        $('#shwpdf').attr("src", response.quest_pdf);
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            })
            // }
        } else if (id.length == 0) {
            $('#question_sub_form').trigger('reset');
            $('#shwpdf').attr("src", '');
            $('#ans_grp').html('');
            $('#submit_form_btn').val('Submit');
            $('#submit_form_btn').text('Submit');
        }
    })

    $('#allQuest').on('click', '.deleteQst', function() {
        var qId = $(this).attr("data-qid");
        // console.log(qId);#allQuest 
        $.confirm({
            title: 'CONFIRM',
            content: 'Are you sure you want to delete these question?',
            buttons: {
                confirm: {
                    btnClass: 'btn-green',
                    text: 'Yes',
                    action: function() {
                        $.ajax({
                            url: '../admin/set_question/question_db.php',
                            type: "POST",
                            dataType: 'json',
                            data: {
                                "qst_ID": qId,
                                "type": "delete_qst"
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

    $('#del_test').click(function() {
        var typ = $('#del_test').val();
        var session = $('#gen_Session').val();
        var term = $('#gen_Term').val();
        $.confirm({
            title: 'CONFIRM',
            content: 'Are you sure you want to delete all test questions?',
            buttons: {
                confirm: {
                    btnClass: 'btn-green',
                    text: 'Yes',
                    action: function() {
                        $.ajax({
                            url: '../admin/set_question/question_db.php',
                            type: "POST",
                            dataType: 'json',
                            data: {
                                "session": session,
                                "term": term,
                                "type": "delete_all_test"
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

    $('#del_exam').click(function() {
        var typ = $('#del_exam').val();
        var session = $('#gen_Session').val();
        var term = $('#gen_Term').val();
        $.confirm({
            title: 'CONFIRM',
            content: 'Are you sure you want to delete all exam questions?',
            buttons: {
                confirm: {
                    btnClass: 'btn-green',
                    text: 'Yes',
                    action: function() {
                        $.ajax({
                            url: '../admin/set_question/question_db.php',
                            type: "POST",
                            dataType: 'json',
                            data: {
                                "session": session,
                                "term": term,
                                "type": "delete_all_exam"
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

    $(".tr_qst").dblclick(function() {
        var id = $(this).attr("data-id_qst");
        navigator.clipboard.writeText(id).then(function() {
            toastr.success(id + " Copied to clipboard");
        }).catch(function(err) {
            toastr.danger("Failed to copy: " + err);
        });
    })

    // <!-- getting question  -->
    function loadData(page = 1, search = '') {
        const limit = $('#limit').val();
        $.ajax({
            url: '../admin/set_question/question_db.php',
            type: 'POST',
            data: {
                "page": page,
                "limit": limit,
                "search": search,
                "type": "paginateQst"
            },
            dataType: 'json',
            success: function(response) {
                $('#allQuest').html(response.html);
                let pagination = '';
                // Previous Button
                pagination += `<li class="page-item ${response.currentPage == 1 ? 'disabled' : ''}">
                                        <a class="page-link" href="#" data-page="${response.currentPage - 1}">&laquo;</a>
                                    </li>`;
                // Pages
                for (let i = 1; i <= response.totalPages; i++) {
                    pagination += `<li class="page-item ${response.currentPage == i ? 'active' : ''}">
                                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                                        </li>`;
                }
                // Next Button
                pagination += `<li class="page-item ${response.currentPage == response.totalPages ? 'disabled' : ''}">
                                        <a class="page-link" href="#" data-page="${response.currentPage + 1}">&raquo;</a>
                                    </li>`;
                $('#pagination').html(pagination);
            }
        });
    }
    // Initial load
    loadData();

    // <!-- Pagination Click Event  -->
    $('#pagination').on('click', '.page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        const search = $('#search').val();
        if (page) {
            loadData(page, search);
        }
    });
    // <!-- END Pagination Click Event  -->

    // <!-- Search Keyup Event (debounced)  -->
    let typingTimer;
    $('#search').on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function() {
            loadData(1, $('#search').val());
        }, 500); // delay to avoid too many requests
    });
    // <!--END Search Keyup Event (debounced)  -->

    // <!-- 3 seconds calling  -->
    setInterval(() => {
        var activePge = parseInt($('#pagination li.active .page-link').text());
        if (isNaN(activePge)) {
            activePge = 1;
        }
        var serch = $('#search').val()
        loadData(activePge, serch);
    }, 3000);
    // <!-- END 3 seconds calling  -->

    // <!-- END getting question  -->
})
</script>