<?php 
    $qstTerm = $conn->query("SELECT * FROM cbt_term");
    $qstClass = $conn->query("SELECT * FROM cbt_class");
    $qstSubjects = $conn->query("SELECT * FROM cbt_subjects");
    $notes = $conn->query("SELECT * FROM notes ORDER BY id DESC LIMIT 30");

?>
<main id="main" class="main">
    <div class="container">

        <div class="card mt-0">
            <div class="card-footer bg-body-tertiary py-2 text-center">
                <form action="" method="post" id="book_form" enctype="multipart/form-data">
                    <div class="row gy-2">
                        <div class="col-sm-2 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <input type="text" class="form-control text-center text-uppercase" disabled
                                    value="Class notes" style="background:rgba(214, 226, 214, 0.93);">
                                <input type="hidden" name="notes_id" id="notes_id">
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
                    <div class="col-md-12 col-lg-12 pt-2">
                        <div class="card position-relative rounded-4">
                            <embed src="" type="application/pdf" id="pdf_display" width="100%" height="375px">
                        </div>
                    </div>

                    <div class="row gy-3">
                        <div class="col-lg-10 col-sm-10">
                            <input type="file" class="form-control" id="book_pdf_file" name="pdf_file"
                                accept="application/pdf" />
                        </div>
                        <div class="col-lg-2 col-sm-2">
                            <button type="submit" style="width: 8.5rem;" class="btn btn-primary" name="submitBook"
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
                                <th scope="col" nowrap="nowrap">N-ID</th>
                                <th scope="col" nowrap="nowrap">Subject</th>
                                <th scope="col" nowrap="nowrap">Topic</th>
                                <th scope="col" nowrap="nowrap">Class</th>
                                <th scope="col" nowrap="nowrap">Term</th>
                                <th scope="col" nowrap="nowrap">Week</th>
                                <th scope="col" nowrap="nowrap">File Path</th>
                                <th scope="col" nowrap="nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($note = $notes->fetch_object()){?>
                            <tr>
                                <th scope="row" nowrap="nowrap"><?= $note->note_id?></th>
                                <td nowrap="nowrap"><?= $note->subject?></td>
                                <td nowrap="nowrap"><?= $note->topic?></td>
                                <td nowrap="nowrap"><?= $note->class?></td>
                                <td nowrap="nowrap"><?= $note->term?></td>
                                <td nowrap="nowrap"><?= $note->week?></td>
                                <td nowrap="nowrap"><?= $note->note_pdf?></td>
                                <td nowrap="nowrap">
                                    <div class="text-center">
                                        <a href="#" class="btn btn-link p-0 viewBook" data-bid="<?= $note->id?>">
                                            <span class="text-500 text-success bi bi-camera"></span>
                                        </a>
                                        &nbsp;&nbsp;
                                        <a href="#" class="btn btn-link p-0 deleteBook" data-bid="<?= $note->id?>">
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

    $('#book_form').on('submit', function(e) {
        e.preventDefault();

        var notes_id = $('#notes_id').val();
        var subject = $('#subject').val();
        var topic = $('#topic').val();
        var _class = $('#_class').val();
        var term = $('#term').val();
        var week_ = $('#week_').val();
        var book_pdf_file = $('#book_pdf_file').prop('files')[0];

        var sdata = new FormData();

        sdata.append("notes_id", notes_id);
        sdata.append("subject", subject);
        sdata.append("topic", topic);
        sdata.append("_class", _class);
        sdata.append("term", term);
        sdata.append("week_", week_);
        sdata.append("file", book_pdf_file);
        sdata.append("type", "submitNotes");

        $.ajax({
            url: '../admin/videos_books/class_notes_db.php',
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

    $('.deleteBook').click(function() {
        var note_id = $(this).attr("data-bid");
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
                            url: '../admin/videos_books/class_notes_db.php',
                            type: "POST",
                            dataType: 'json',
                            data: {
                                "note_id": note_id,
                                "type": "delete_book"
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

    $('.viewBook').click(function() {
        var nid = $(this).attr("data-bid");
        $.ajax({
            url: '../admin/videos_books/class_notes_db.php',
            type: "POST",
            dataType: 'json',
            data: {
                "note_id": nid,
                "type": "getNotes"
            },
            success: function(response) {
                $('#book_ID').val(response.book_id);
                $('#subject').val(response.subject);
                $('#topic').val(response.topic);
                $('#_class').val(response.class);
                $('#term').val(response.term);
                $('#week_').val(response.week);
                $('#pdf_display').attr("src", response.pdf_path);
            },
            error: function(err) {
                console.log(err);
            }
        })
    })

})
</script>