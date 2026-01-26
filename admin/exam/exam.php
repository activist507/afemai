<?php 
  if(session_status() === PHP_SESSION_NONE)
    {
      session_start();
    }
  include '../config/db_connect.php';

  $Terms = fetch_all_assoc($conn->query("SELECT * FROM cbt_term"));
  $classes = fetch_all_assoc($conn->query("SELECT * FROM cbt_class"));
  $all_subject_tbl = fetch_all_assoc($conn->query("SELECT * FROM cbt_subjects"));
  $allQuestions = fetch_all_assoc($conn->query("SELECT * FROM exams"));

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Exam Upload</title>
  <link rel="stylesheet" href="../../admin/assets/vendor/bootstrap/css/bootstrap.min.css">
  <link href="../../admin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../../admin/assets/css/jquery-confirm.min.css">
  <script src="../../admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
</head>
<body class="bg-light">

<div class="container mt-2">
  <div class="card shadow-sm">
    <div class="card-body">
      <form method="post" enctype="multipart/form-data" action="parse_preview.php">
        <div class="row">
          <div class="col-lg-3 col-sm-12">
            <input type="text" class="form-control text-center" name="examHiddenId" id="examHiddenId" data-bs-toggle="tooltip" data-bs-placement="top" title="Exam ID" placeholder="Exam ID">
          </div>
          <div class="col-lg-9 col-sm-12"><h3 class="card-title mb-3">Upload Exam Questions (.docx)</h3></div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-sm-12 pt-2">
            <select name="class_id" id="class_id" required class="form-control" data-bs-toggle="tooltip" data-bs-placement="top" title="Class">
              <?php foreach($classes as $level){?>
                <option value="<?= $level['class']?>"><?= $level['class']?></option>
              <?php }?>
            </select>
          </div>
          <div class="col-lg-3 col-sm-12 pt-2">
            <select name="subject_id" id="subject_id" required class="form-control" data-bs-toggle="tooltip" data-bs-placement="top" title="Subject">
              <?php foreach($all_subject_tbl as $subject){?>
                <option value="<?= $subject['subject']?>"><?= $subject['subject']?></option>
              <?php }?>
            </select>
          </div>
          <div class="col-lg-3 col-sm-12 pt-2">
            <select name="term_id" id="term_id" required class="form-control" data-bs-toggle="tooltip" data-bs-placement="top" title="Term">
              <?php foreach($Terms as $term){?>
                <option value="<?= $term['term']?>"><?= $term['term']?></option>
              <?php }?>
            </select>
          </div>
          <div class="col-lg-3 col-sm-12 pt-2">
            <select name="assessment_type" id="assessment_type" required class="form-control" data-bs-toggle="tooltip" data-bs-placement="top" title="Assessment Type">
              <option value="Test1">Test1</option>
              <option value="Test2">Test2</option>
              <option value="Obj">Objectives</option>
              <option value="Theory">Theory</option>
            </select>
          </div>
          <div class="col-lg-3 col-sm-12 pt-2">
            <input type="number" required class="form-control text-center" name="no_of_question" id="no_of_question" data-bs-toggle="tooltip" data-bs-placement="top" title="No. Of Questions" placeholder="No. Of Questions">
          </div>
          <div class="col-lg-3 col-sm-12 pt-2">
            <input type="text" required class="form-control text-center" name="alloted_mark" id="alloted_mark" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark Per Question" placeholder="Mark Per Question">
          </div>
          <div class="col-lg-3 col-sm-12 pt-2">
            <input type="number" required class="form-control text-center" name="total_mark" id="total_mark" data-bs-toggle="tooltip" data-bs-placement="top" title="Total Mark" placeholder="Total Mark">
          </div>
          <div class="col-lg-3 col-sm-12 pt-2">
            <input type="number" required class="form-control text-center" name="duration" id="duration" data-bs-toggle="tooltip" data-bs-placement="top" title="Duration in Minutes" placeholder="Duration">
          </div>
          <div class="col-lg-6 col-sm-12 pt-2 pb-2">
            <input type="file" name="docfile" id="docfile" class="form-control" accept=".docx" required 
              data-bs-toggle="tooltip" data-bs-placement="top" title="Select The doc file" placeholder="Select The doc file">
          </div>
          <div class="col-lg-3 col-sm-12 pt-2 pb-2">
            <button type="submit" class="btn btn-success w-100 d-none" id="replaceQstBtn">Edit & Replace Question</button>
          </div>
          <div class="col-lg-3 col-sm-12 pt-2 pb-2">
            <button type="submit" class="btn btn-success w-100" id="previewBtn"> Preview</button>
            <button type="submit" class="btn btn-success w-100 d-none" id="editDescBtn"> Edit Existing Question</button>
          </div>
        </div>
        <div class="row py-3">
          <div class="col-3"></div>
          <div class="col-3"></div>
          <div class="col-3"></div>
          <div class="col-3">
            <a href="../../admin" class="btn btn-primary w-100">Go Back</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="card shadow-sm mt-2 mb-3">
    <div class="card-body">
      <h3 class="card-title mb-3 text-center">Assessment List</h3>
      <div class="table-responsive-sm">
        <div class="row py-2">
          <div class="col-lg-4 col-sm-12">
              <select class="form-select" id="limit3" data-bs-toggle="tooltip"
                  data-bs-placement="top" title="Entries Per Page">
                  <option selected value="20">20</option>
                  <option value="30">30</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
              </select>
          </div>
          <div class="col-lg-8 col-sm-12">
              <div class="input-group">
                  <input type="text" placeholder="search" class="form-control" id="search3">
                  <span class="input-group-text"><i class="bi bi-search"></i></span>
              </div>
          </div>
        </div>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Exam ID</th>
              <th scope="col" class="text-center">Class</th>
              <th scope="col" class="text-center">Subject</th>
              <th scope="col" class="text-center">Term</th>
              <th scope="col" class="text-center">Assessment Type</th>
              <th scope="col" class="text-center text-nowrap">No. Of Question</th>
              <th scope="col" class="text-center">Total Mark</th>
              <th scope="col" class="text-center">Duration</th>
              <th scope="col" class="text-center no-wrap">Action</th>
            </tr>
          </thead>
          <tbody id="questionList">
            
          </tbody>
        </table>
        <nav> <ul class="pagination pagination-sm" id="pagination3"></ul> </nav>
      </div>
    </div>
  </div>
</div>

<script src="../../admin/assets/js/jquery-3.7.1.min.js"></script>
<script src="../../admin/assets/js/jquery-confirm.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].forEach(el => new bootstrap.Tooltip(el));
  });

  function getExamDetails(examID){
    $.post("exam_db.php",{"type":"editDesc","examID":examID},null,"json")
      .done(function(res){
        if(res.id > 0){
          $('#class_id').val(res.class_id);
          $('#subject_id').val(res.subject_id);
          $('#term_id').val(res.term_id);
          $('#assessment_type').val(res.assessment_type);
          $('#no_of_question').val(res.no_of_question);
          $('#alloted_mark').val(res.alloted_mark);
          $('#total_mark').val(res.total_mark);
          $('#duration').val(res.duration);
          $('#examHiddenId').val(res.id);

          $('#previewBtn').addClass('d-none');
          $('#editDescBtn').removeClass('d-none');

          $('#docfile').attr("required", false);
          // $('#docfile').addClass("d-none");
          $('#replaceQstBtn').removeClass("d-none");
        } else {
          $('#editDescBtn').addClass('d-none');
          $('#previewBtn').removeClass('d-none');
          $('#docfile').attr("required", true);
          // $('#docfile').removeClass("d-none");
          $('#replaceQstBtn').addClass("d-none");
        }
      })
      .fail(function(err){
        console.log(err)
    })
  }

  $('#questionList').on('click','.editDesc',function(){
    const examID = $(this).data('id');
    getExamDetails(examID);
  })

  $('#examHiddenId').keyup(function(e){
    var examID = $(this).val()
    if(examID.length > 0){
      getExamDetails(examID);
    } 
    if(examID.length == 0) {
      $('#class_id').val('Creche');
      $('#subject_id').val('English');
      $('#term_id').val('1st Term');
      $('#assessment_type').val('Test1');
      $('#no_of_question').val('');
      $('#alloted_mark').val('');
      $('#total_mark').val('');
      $('#duration').val('');
    }
    
  })

  $('#editDescBtn').click(function(e){
    e.preventDefault();
    var form = $(this).closest('form');
    form.attr('action', 'update_question.php');
    form.trigger('submit');
  })

  $('#replaceQstBtn').click(function(e){
    e.preventDefault();
    var examID = parseInt($('#examHiddenId').val());
    if(examID > 0){
      var form = $(this).closest('form');
      form.attr('action', 'parse_preview2.php');
      form.trigger('submit');
    }
  })

  $('#questionList').on('click','.deleteQst',function(){
    const examID = $(this).data('id');
    const filepath = $(this).data('examfile');
    $.confirm({
      title: 'Confirm!',
      content: 'Are You sure you want to delete this Assessment?',
      buttons: {
        confirm: function () {
          $.post("exam_db.php",{"type":"deleteQst","examID":examID,"filepath":filepath},null,"json")
            .done(function(res){ 
              $.alert(res.msg,"Message");
              setTimeout(function(){location.reload(true)},3000); 
            })
            .fail(function(err){
              console.log(err)
          })
        },
        cancel: function () {
          
        }
      }
    });
    
  })

  function loadData3(page = 1, search = '') {
    const limit = $('#limit3').val();
    $.ajax({
      url: 'exam_db.php',
      type: 'POST',
      data: {
        "page": page,
        "limit": limit,
        "search": search,
        "type": "paginateQuestion"
      },
      dataType: 'json',
      success: function(response) {
        $('#questionList').html(response.html);
        let pagination = '';

        pagination += `<li class="page-item ${response.currentPage == 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${response.currentPage - 1}">&laquo;</a>
                    </li>`;

        let totalPages = response.totalPages;
        let currentPage = response.currentPage;

        if (totalPages <= 7) {
            // Show all pages if total pages are small
            for (let i = 1; i <= totalPages; i++) {
                pagination += `<li class="page-item ${currentPage == i ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                            </li>`;
            }
        } else {
            // Always show first page
            pagination += `<li class="page-item ${currentPage == 1 ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="1">1</a>
                        </li>`;

            if (currentPage > 4) {
                pagination +=
                    `<li class="page-item disabled"><a class="page-link">...</a></li>`;
            }

            // Show some middle pages dynamically
            let startPage = Math.max(2, currentPage - 2);
            let endPage = Math.min(totalPages - 1, currentPage + 2);

            for (let i = startPage; i <= endPage; i++) {
                pagination += `<li class="page-item ${currentPage == i ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                            </li>`;
            }

            if (currentPage < totalPages - 3) {
                pagination +=
                    `<li class="page-item disabled"><a class="page-link">...</a></li>`;
            }

            // Always show last page
            pagination += `<li class="page-item ${currentPage == totalPages ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>
                        </li>`;
        }
        pagination += `<li class="page-item ${currentPage == totalPages ? 'disabled' : ''}">
                            <a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a>
                        </li>`;

        $('#pagination3').html(pagination);

      },
      error: function(err) {
        console.log(err)
      }
    });
  }
  loadData3();
  $(document).on('click', '#pagination3 .page-link', function(e) {
    e.preventDefault();
    const page = $(this).data('page');
    const search = $('#search3').val(); 
    if (page) {
      loadData3(page, search);
    }
  });
  let typingTimer;
  $('#search3').on('keyup', function() {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(function() {
      loadData3(1, $('#search3').val());
    }, 500); 
  });
  setInterval(() => {
    var activePge = parseInt($('#pagination3 li.active .page-link').text());
    if (isNaN(activePge)) {
        activePge = 1;
    }
    var serch = $('#search3').val()
    loadData3(activePge, serch);
  }, 3000);
</script>

</body>
</html>

<!-- <?php $no=1; foreach($allQuestions as $question):?>
  <tr>
    <th scope="row"><?= $question['id']?></th>
    <td class="text-center text-nowrap"><?= ($question['class_id'])?></td>
    <td class="text-center text-nowrap"><?= ($question['subject_id'])?></td>
    <td class="text-center text-nowrap"><?= $question['term_id']?></td>
    <td class="text-center text-nowrap"><?= $question['assessment_type']?></td>
    <td class="text-center text-nowrap"><?= $question['no_of_question']?></td>
    <td class="text-center text-nowrap"><?= $question['total_mark']?></td>
    <td class="text-center text-nowrap"><?= $question['duration']?></td>
    <td class="text-center">
      <button class="btn btn-secondary editDesc" data-id="<?= $question['id']?>"
        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Description">
        <i class="bi bi-pencil-square"></i>
      </button>
      <button type="button" class="btn btn-danger deleteQst" 
        data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Assessment" data-examfile="<?= $question['filepath']?>"
        data-id="<?= $question['id']?>">
        <i class="bi bi-trash"></i>
      </button>
    </td>
  </tr>
<?php $no++; endforeach;?> -->