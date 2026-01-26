<?php 
    $qstTerm = $conn->query("SELECT * FROM cbt_term");
    $qstClass = $conn->query("SELECT * FROM cbt_class");
    $qstSubjects = $conn->query("SELECT * FROM cbt_subjects");
    $books = $conn->query("SELECT * FROM books ORDER BY id DESC LIMIT 30");

?>
<main id="main" class="main">
    <div class="container">

        <div class="card mt-0">
            <div class="card-footer bg-body-tertiary py-2 text-center">
                <form action="" method="post" id="book_form" enctype="multipart/form-data">
                    <div class="row gy-2">
                        <div class="col-sm-4 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <input type="text" class="form-control text-center text-uppercase" disabled
                                    value="Class Books" style="background:rgba(214, 226, 214, 0.93);">
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <div class="tom-select-custom">
                                <input type="text" class="form-control text-center" id="book_ID" name="book_ID"
                                    placeholder="Search ID" disabled />
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
                                <th scope="col" nowrap="nowrap">B-ID</th>
                                <th scope="col" nowrap="nowrap">Subject</th>
                                <th scope="col" nowrap="nowrap">Topic</th>
                                <th scope="col" nowrap="nowrap">Class</th>
                                <th scope="col" nowrap="nowrap">Term</th>
                                <th scope="col" nowrap="nowrap">File Path</th>
                                <th scope="col" nowrap="nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($book = $books->fetch_object()){?>
                            <tr>
                                <th scope="row" nowrap="nowrap"><?= $book->book_id?></th>
                                <td nowrap="nowrap"><?= $book->subject?></td>
                                <td nowrap="nowrap"><?= $book->topic?></td>
                                <td nowrap="nowrap"><?= $book->class?></td>
                                <td nowrap="nowrap"><?= $book->term?></td>
                                <td nowrap="nowrap"><?= $book->book_pdf?></td>
                                <td nowrap="nowrap">
                                    <div class="text-center">
                                        <a href="#" class="btn btn-link p-0 viewBook" data-bid="<?= $book->id?>">
                                            <span class="text-500 text-success bi bi-camera"></span>
                                        </a>
                                        &nbsp;&nbsp;
                                        <a href="#" class="btn btn-link p-0 deleteBook" data-bid="<?= $book->id?>">
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

        var book_ID = $('#book_ID').val();
        var subject = $('#subject').val();
        var topic = $('#topic').val();
        var _class = $('#_class').val();
        var term = $('#term').val();
        var book_pdf_file = $('#book_pdf_file').prop('files')[0];

        var sdata = new FormData();

        sdata.append("book_ID", book_ID);
        sdata.append("subject", subject);
        sdata.append("topic", topic);
        sdata.append("_class", _class);
        sdata.append("term", term);
        sdata.append("file", book_pdf_file);
        sdata.append("type", "submitBook");

        $.ajax({
            url: '../admin/videos_books/class_books_db.php',
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
        var book_id = $(this).attr("data-bid");
        $.confirm({
            title: 'CONFIRM',
            content: 'Are you sure you want to delete this book?',
            autoClose: 'cancelAction|10000',
            escapeKey: 'cancelAction',
            buttons: {
                confirm: {
                    btnClass: 'btn-green',
                    text: 'Yes',
                    action: function() {
                        $.ajax({
                            url: '../admin/videos_books/class_books_db.php',
                            type: "POST",
                            dataType: 'json',
                            data: {
                                "book_id": book_id,
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
        var bid = $(this).attr("data-bid");
        $.ajax({
            url: '../admin/videos_books/class_books_db.php',
            type: "POST",
            dataType: 'json',
            data: {
                "book_id": bid,
                "type": "getBook"
            },
            success: function(response) {
                $('#book_ID').val(response.book_id);
                $('#subject').val(response.subject);
                $('#topic').val(response.topic);
                $('#_class').val(response.class);
                $('#term').val(response.term);
                $('#pdf_display').attr("src", response.pdf_path);
            },
            error: function(err) {
                console.log(err);
            }
        })
    })

})
</script>