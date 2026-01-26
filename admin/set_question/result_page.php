<?php 

    $question_codes = $conn->query("SELECT * FROM question_codes WHERE question_code != ''")->fetch_all(MYSQLI_ASSOC);
?>

<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <div class="row">
                            <div class="col-lg-6 pt-3">
                                <div class="tom-select-custom">
                                    <select name="ans_code_1" id="ans_code_1" class="form-control"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Select Code">
                                        <option value="0">Select Code</option>
                                        <?php foreach($question_codes as $codes){ ?>
                                        <option value="<?= $codes['question_code']?>"><?= $codes['question_code']?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 pt-3">
                                <div class="tom-select-custom">
                                    <input type="text text-center" id="Subjects1" name="Subjects1"
                                        class="form-control text-center" readonly>
                                    </input>
                                </div>
                            </div>
                        </div>
                        <!-- Answers table display -->
                        <div class="table-responsive pt-2">
                            <table class="table table-striped small">
                                <thead>
                                    <tr>
                                        <!-- <th scope="col" nowrap="nowrap">Stud ID</th> -->
                                        <th scope="col" nowrap="nowrap">Name</th>
                                        <th scope="col" nowrap="nowrap">Score</th>
                                    </tr>
                                </thead>
                                <tbody id="ans_entry">
                                    <tr>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="row">
                            <div class="col-lg-6 pt-3">
                                <div class="tom-select-custom">
                                    <select name="ans_code_2" id="ans_code_2" class="form-control"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Select Code">
                                        <option value="0">Select Code</option>
                                        <?php foreach($question_codes as $codes){ ?>
                                        <option value="<?= $codes['question_code']?>"><?= $codes['question_code']?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 pt-3">
                                <div class="tom-select-custom">
                                    <input type="text text-center" id="Subjects2" class="form-control text-center"
                                        readonly>
                                    </input>
                                </div>
                            </div>
                        </div>
                        <!-- Answers table display -->
                        <div class="table-responsive pt-2">
                            <table class="table table-striped small">
                                <thead>
                                    <tr>
                                        <!-- <th scope="col" nowrap="nowrap">Stud ID</th> -->
                                        <th scope="col" nowrap="nowrap">Name</th>
                                        <th scope="col" nowrap="nowrap">Score</th>
                                    </tr>
                                </thead>
                                <tbody id="ans_entry_2">
                                    <tr>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="row">
                            <div class="col-lg-6 pt-3">
                                <div class="tom-select-custom">
                                    <select name="ans_code_3" id="ans_code_3" class="form-control"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Select Code">
                                        <option value="0">Select Code</option>
                                        <?php foreach($question_codes as $codes){ ?>
                                        <option value="<?= $codes['question_code']?>"><?= $codes['question_code']?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 pt-3">
                                <div class="tom-select-custom">
                                    <input type="text text-center" name="Subjects3" class="form-control text-center"
                                        readonly>
                                    </input>
                                </div>
                            </div>
                        </div>
                        <!-- Answers table display -->
                        <div class="table-responsive pt-2">
                            <table class="table table-striped small">
                                <thead>
                                    <tr>
                                        <!-- <th scope="col" nowrap="nowrap">Stud ID</th> -->
                                        <th scope="col" nowrap="nowrap">Name</th>
                                        <th scope="col" nowrap="nowrap">Score</th>
                                    </tr>
                                </thead>
                                <tbody id="ans_entry_3">
                                    <tr>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>


<script type="text/javascript">
$(document).ready(function() {

    // <!-- table 1 -->
    $('#ans_code_1').change(function() {
        var exam_id = $(this).val();
        var elem1 = $('#ans_entry_1').children().length;
        if (exam_id != 0) {
            $.ajax({
                url: '../admin/set_question/result_page_db.php',
                type: "POST",
                dataType: 'json',
                data: {
                    "exam_id": exam_id,
                    "type": "dynamic_ans_entry"
                },
                success: function(response) {
                    if (elem1 > 0) {
                        $('#ans_entry').find('.rem').remove();
                        $('#ans_entry').html(response.html);
                        $('#Subjects1').val(response.subject);
                    } else {
                        $('#ans_entry').html(response.html);
                        $('#Subjects1').val(response.subject);
                    }

                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
    })

    // <!-- table 2 -->
    $('#ans_code_2').change(function() {
        var exam_id = $(this).val();
        var elem2 = $('#ans_entry_2').children().length;
        if (exam_id != 0) {
            $.ajax({
                url: '../admin/set_question/result_page_db.php',
                type: "POST",
                dataType: 'json',
                data: {
                    "exam_id": exam_id,
                    "type": "dynamic_ans_entry2"
                },
                success: function(response) {
                    if (elem2 > 0) {
                        $('#ans_entry_2').find('.rem').remove();
                        $('#ans_entry_2').html(response.html);
                        $('#Subjects2').val(response.subject);
                    } else {
                        $('#ans_entry_2').html(response.html);
                        $('#Subjects2').val(response.subject);
                    }

                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
    })

    // <!-- table 3 -->
    $('#ans_code_3').change(function() {
        var exam_id = $(this).val();
        var elem3 = $('#ans_entry_3').children().length;
        if (exam_id != 0) {
            $.ajax({
                url: '../admin/set_question/result_page_db.php',
                type: "POST",
                dataType: 'json',
                data: {
                    "exam_id": exam_id,
                    "type": "dynamic_ans_entry3"
                },
                success: function(response) {
                    if (elem3 > 0) {
                        $('#ans_entry_3').find('.rem').remove();
                        $('#ans_entry_3').html(response.html);
                        $('#Subjects3').val(response.subject);
                    } else {
                        $('#ans_entry_3').html(response.html);
                        $('#Subjects3').val(response.subject);
                    }

                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
    })

    //<!-- auto update answer entry -->
    setInterval(() => {
        var exam_id1 = $('#ans_code_1').val();
        var exam_id2 = $('#ans_code_2').val();
        var exam_id3 = $('#ans_code_3').val();
        var elem1 = $('#ans_entry_1').children().length;
        var elem2 = $('#ans_entry_2').children().length;
        var elem3 = $('#ans_entry_3').children().length;

        $.ajax({
            url: '../admin/set_question/result_page_db.php',
            type: "POST",
            dataType: 'json',
            data: {
                "exam_id1": exam_id1,
                "exam_id2": exam_id2,
                "exam_id3": exam_id3,
                "type": "dynamic_ans_all"
            },
            success: function(response) {
                if (elem1 > 0) {
                    $('#ans_entry_1').find('.rem').remove();
                    $('#ans_entry_1').html(response.html1);
                    $('#Subjects1').val(response.subject1);
                } else {
                    $('#ans_entry_1').html(response.html1);
                    $('#Subjects1').val(response.subject1);
                }

                if (elem2 > 0) {
                    $('#ans_entry_2').find('.rem').remove();
                    $('#ans_entry_2').html(response.html2);
                    $('#Subjects2').val(response.subject2);
                } else {
                    $('#ans_entry_2').html(response.html2);
                    $('#Subjects2').val(response.subject2);
                }

                if (elem3 > 0) {
                    $('#ans_entry_3').find('.rem').remove();
                    $('#ans_entry_3').html(response.html3);
                    $('#Subjects3').val(response.subject3);
                } else {
                    $('#ans_entry_3').html(response.html3);
                    $('#Subjects3').val(response.subject3);
                }

            },
            error: function(err) {
                console.log(err);
            }
        })
    }, 3000);
})
</script>