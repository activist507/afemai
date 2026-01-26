<?php
  include '../config/db_connect.php';
  $result = array();

  if(isset($_POST['type']) && $_POST['type']=="editDesc"){
    $examID = $_POST['examID'];
    $estmt = $conn->prepare("SELECT * FROM exams WHERE id = ?");
    $estmt->bind_param("i",$examID);
    $estmt->execute();
    $res = $estmt->get_result();
    $exam = $res->fetch_object();
    $result['class_id'] = $exam->class_id ?? '';
    $result['subject_id'] = $exam->subject_id ?? '';
    $result['term_id'] = $exam->term_id ?? '';
    $result['assessment_type'] = $exam->assessment_type ?? '';
    $result['no_of_question'] = $exam->no_of_question ?? '';
    $result['alloted_mark'] = $exam->alloted_mark ?? '';
    $result['total_mark'] = $exam->total_mark ?? '';
    $result['duration'] = $exam->duration ?? '';
    $result['id'] = $exam->id ?? 0;

    echo json_encode($result);
  }

  if(isset($_POST['type']) && $_POST['type']=="submitEditDesc"){
    $examID = $_POST['examID'];
    $class_id = $_POST['class_id'];
    $subject_id = $_POST['subject_id'];
    $term_id = $_POST['term_id'];
    $assessment_type = $_POST['assessment_type'];
    $no_of_question = $_POST['no_of_question'];
    $alloted_mark = $_POST['alloted_mark'];
    $total_mark = $_POST['total_mark'];
    $duration = $_POST['duration'];
    $examTitle = examTitle($subject_id,$class_id,$assessment_type,$term_id);

    $ustmt = $conn->prepare("UPDATE exams SET title=?,class_id=?,subject_id=?,term_id=?,assessment_type=?,no_of_question=?,alloted_mark=?,total_mark=?,duration=? WHERE id = ?");
    $ustmt->bind_param("sssssiiiii",$examTitle,$class_id,$subject_id,$term_id,$assessment_type,$no_of_question,$alloted_mark,$total_mark,$duration,$examID);
    if($ustmt->execute()){
      $result['msg'] = "$examTitle updated successfully";
    } else {
      $result['msg'] = "$examTitle could not be updated";
    }

    echo json_encode($result);
  }

  if(isset($_POST['type']) && $_POST['type']=="deleteQst"){
    $examID = $_POST['examID'];
    $filepath = $_POST['filepath'];
    $qL = $conn->query("SELECT id,question_image FROM questionns WHERE exam_id = '$examID'")->fetch_all(MYSQLI_ASSOC);
    foreach($qL as $q){
      $qst_id = $q['id'];
      $conn->query("DELETE FROM options WHERE question_id = '$qst_id'");

      $file = $q['question_image'];
      if(isset($file) && file_exists($file)){
        if(unlink($file)){
          clearstatcache();
          $conn->query("DELETE FROM questionns WHERE id = '$qst_id'");
        }
      } else {
        $conn->query("DELETE FROM questionns WHERE id = '$qst_id'");
      } 
    }
    if(file_exists($filepath)){
      if(unlink($filepath)){
        clearstatcache();
        $estmt = $conn->query("DELETE FROM exams WHERE id = '$examID'");
        $result['msg'] = 'Assessment Deleted Successfully';
      }
    } else {
      $result['msg'] = 'Assessment could not be deleted';
    }

    echo json_encode($result);
  }

  if(isset($_POST['type']) && $_POST['type'] == 'paginateQuestion'){
    $html = '';
    $page = $_POST['page']; //page if clicked
    $limit = $_POST['limit']; //records per page
    $search = $_POST['search']; //if search was included
    $offset = ($page - 1) * $limit;

    $resultSales = $conn->query("SELECT COUNT(*) AS total FROM exams WHERE (id LIKE '%$search%' OR class_id LIKE '%$search%' OR subject_id LIKE '%$search%')")->fetch_assoc();
    $totalRecords = $resultSales['total'];
    $totalPages = ceil($totalRecords / $limit);

    $exams = $conn->query("SELECT * FROM exams WHERE (id LIKE '%$search%' OR class_id LIKE '%$search%' OR subject_id LIKE '%$search%') ORDER BY id DESC LIMIT $limit OFFSET $offset")->fetch_all(MYSQLI_ASSOC);
    if(count($exams)>0){
      foreach($exams as $stud_rec){
        $html .= '
        <tr>
          <td scope="col" nowrap="nowrap">'.$stud_rec["id"].'</td>
          <td scope="col" nowrap="nowrap">'. $stud_rec["class_id"].'</td>
          <td scope="col" nowrap="nowrap">'. $stud_rec["subject_id"].'</td>
          <td scope="col" nowrap="nowrap">'. $stud_rec["term_id"].'</td>
          <td scope="col" nowrap="nowrap">'. $stud_rec["assessment_type"].'</td>
          <td scope="col" nowrap="nowrap">'.$stud_rec['no_of_question'].'</td>
          <td scope="col" nowrap="nowrap">'.($stud_rec['total_mark']).'</td>
          <td scope="col" nowrap="nowrap">'.($stud_rec['duration']).'</td>
          <td class="text-center">
            <button class="btn btn-secondary editDesc" data-id="'.$stud_rec['id'].'"
              data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Description">
              <i class="bi bi-pencil-square"></i>
            </button>
            <button type="button" class="btn btn-danger deleteQst" 
              data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Assessment" data-examfile="'.$stud_rec['filepath'].'"
              data-id="'.$stud_rec['id'].'">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>';
      }
    } else {
      $html = '<tr>
      <td colspan="11" class="no-data">No records found.</td>
      </tr>';
    }
    $result['html'] = $html;
    $result['totalPages'] = $totalPages;
    $result['currentPage'] = $page;
    echo json_encode($result);
  }