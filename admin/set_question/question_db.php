<?php 
include('../../admin/config/db_connect.php');
$result = array();

  //submitting question 
  if(isset($_POST['type']) && $_POST['type'] == 'submitQuestion'){
    $no_of_ans_submitted = count(json_decode($_POST['qst_ans']));
    $qst_ans = json_decode($_POST['qst_ans']);
    //-----------$qst_ans[$i]['value'] == the answer itself;---------//
    $quest_auto_id = $_POST['quest_auto_id'];
    // $teachers_name = $_POST['teachers_name'];
    $question_type = $_POST['question_type'];
    $exam_type = $_POST['exam_type'];
    $_class = $_POST['_class'];
    $subject = $_POST['subject'];
    $term = $_POST['term'];
    $session = $_POST['session'];
    $question_Num = $_POST['question_Num'];
    $alloted_mark = $_POST['alloted_mark'];
    $total_mark = $_POST['total_mark'];
    $time_min = $_POST['time_min'];
    $end_time = $_POST['end_time'];

    // ------------------Uploading pdf to folder --------------------------//
    if(isset($_FILES['file'])){
      $file = $_FILES['file'];
      $pdf = $file["name"];
      $tempname = $file["tmp_name"];
      $ext = substr($pdf, strrpos($pdf, '.', -1), strlen($pdf));
      $nam = $subject.'-'.$_class.'-'.$exam_type.'-'.$term.$ext;
      if($exam_type == 'Test1'|| $exam_type == 'Test2' || $exam_type == 'Test3'){
        $fornow = "test_pdf/".$nam;
        $folder = "../../storege/test_pdf/".$nam;
      } else {
        $fornow = "question_pdf/".$nam;
        $folder = "../../storege/question_pdf/".$nam;
      }

      move_uploaded_file($tempname, $folder);   
    }
    
    


    // ------------------creating digit for code --------------------------//
    $lastquestsql = $conn->query("SELECT question_id FROM questions ORDER BY id DESC LIMIT 1");
    if($lastquestsql->num_rows > 0){
      $lastquest = $lastquestsql->fetch_object();
      $lastID = $lastquest->question_id;
      $digi = substr($lastID, 0, 3);
      $digit = (int)$digi + 1;
      $question_id = $digit.'-'.$_class;
    } else {
      $question_id = '101-'.$_class;
    }
    
    if($quest_auto_id == 0){
      $sqlins = $conn->query("INSERT INTO questions SET question_id='$question_id',total_question='$question_Num',question_type='$question_type',exam_type='$exam_type',session='$session',term='$term',class='$_class',subject='$subject',alloted_mark='$alloted_mark',total_mark='$total_mark',time_minutes='$time_min',end_time='$end_time',question_pdf='$fornow'");
      $last_id = $question_id;
      $msg = 'Questions submitted successfully';
    } else {
      if(!empty($tempname)){
          $sqlins = $conn->query("UPDATE questions SET total_question='$question_Num',question_type='$question_type',exam_type='$exam_type',session='$session',term='$term',class='$_class',subject='$subject',alloted_mark='$alloted_mark',total_mark='$total_mark',time_minutes='$time_min',end_time='$end_time',question_pdf='$fornow' WHERE question_id='$quest_auto_id'");
      $last_id = $quest_auto_id;
      } else {
        $sqlins = $conn->query("UPDATE questions SET total_question='$question_Num',question_type='$question_type',exam_type='$exam_type',session='$session',term='$term',class='$_class',subject='$subject',alloted_mark='$alloted_mark',total_mark='$total_mark',time_minutes='$time_min',end_time='$end_time' WHERE question_id='$quest_auto_id'");
                $last_id = $quest_auto_id;
      }
      $msg = 'Questions updated successfully';
    }

    if($no_of_ans_submitted > 0){
      // $result['msg'] = 'Bulletin Saved Successfully';
      for($i=0;$i < $no_of_ans_submitted; $i++){
        $qq = $i+1;
        $ine = json_encode($qst_ans[$i]);
        $inearray = explode(":",$ine);
        $anns = substr($inearray[2], 1, 1);
        $column = 'q'.$qq;
        $sqlins = $conn->query("UPDATE questions SET {$column}='$anns' WHERE question_id='$last_id'");
      }
    }

    $questions = $conn->query("SELECT * FROM questions WHERE question_id ='$last_id'");
    $qstreal = $questions->fetch_object();

    $result['quest_auto_id'] = $qstreal->question_id;
    $result['teachers_name'] = $qstreal->subject_teacher;
    $result['question_type'] = $qstreal->question_type;
    $result['exam_type'] = $qstreal->exam_type;
    $result['_class'] = $qstreal->class;
    $result['subject'] = $qstreal->subject;
    $result['term'] = $qstreal->term;
    $result['Session'] = $qstreal->session;

    $html = '';
    $result['question_Num'] = $qstreal->total_question;
    for($i=0;$i<$qstreal->total_question;$i++){
      $id = $i + 1;
      $column = 'q'.$id;
      $ans = $qstreal->{$column};
      $html .= '<div class="col-lg-1 col-md-2"><label for="Q1" class="form-label">Q'.$id.'</label><input type="text" value="'.$ans.'" class="form-control text-center qst_ans" id="Q'.$id.'" name="Q'.$id.'" style="text-transform:uppercase;"/></div>';
    }
    $result['alloted_mark'] = $qstreal->alloted_mark;
    $result['total_mark'] = $qstreal->total_mark;
    $result['time_min'] = $qstreal->time_minutes;
    $result['end_time'] = $qstreal->end_time;
    // $result['quest_pdf'] = "../storege/".$qstreal->question_pdf;
    $result['quest_pdf'] = "../storege/".$qstreal->question_pdf . '?v=' . time();
    $result['html'] = $html;
    $result['msg'] = $msg;
    echo json_encode($result);
  }

  //getting question details 
  if(isset($_POST['type']) && $_POST['type'] == 'getQuestionDetails'){
    $quest_id = $_POST['question_code'];
    $questions = $conn->query("SELECT * FROM questions WHERE question_id ='$quest_id'");
    if($questions->num_rows == 0){
      $result['msg'] = 'No Question with such CODE-'.$quest_id;
      $result['query'] = 'false';
    } else {
      $qstreal = $questions->fetch_object();

      $result['quest_auto_id'] = $qstreal->question_id;
      $result['teachers_name'] = $qstreal->subject_teacher;
      $result['question_type'] = $qstreal->question_type;
      $result['exam_type'] = $qstreal->exam_type;
      $result['_class'] = $qstreal->class;
      $result['subject'] = $qstreal->subject;
      $result['term'] = $qstreal->term;
      $result['Session'] = $qstreal->session;

      $html = '';
      $result['question_Num'] = $qstreal->total_question;
      for($i=0;$i<$qstreal->total_question;$i++){
        $id = $i + 1;
        $column = 'q'.$id;
        $ans = $qstreal->{$column};
        $html .= '<div class="col-lg-1 col-md-2"><label for="Q1" class="form-label">Q'.$id.'</label><input type="text" value="'.$ans.'" class="form-control text-center qst_ans" id="Q'.$id.'" name="Q'.$id.'" style="text-transform:uppercase;"/></div>';
      }
      $result['alloted_mark'] = $qstreal->alloted_mark;
      $result['total_mark'] = $qstreal->total_mark;
      $result['time_min'] = $qstreal->time_minutes;
      $result['end_time'] = $qstreal->end_time;
      $result['quest_pdf'] = "../storege/".$qstreal->question_pdf;
      $result['html'] = $html;
      $result['query'] = 'true';
      // $result['msg'] = $msg;
    }
    
    echo json_encode($result);
  }

  //deleting a question
  if(isset($_POST['type']) && $_POST['type'] == 'delete_qst'){
    $qid = $_POST['qst_ID'];
    $questions = $conn->query("SELECT * FROM questions WHERE id ='$qid'");
    $quest = $questions->fetch_object();

      $file = '../../storege/'.$quest->question_pdf;
      if(file_exists($file)){
        if(unlink($file)){
          clearstatcache();
          $sqlins = $conn->query("DELETE FROM questions WHERE id='$qid'");
          $result['msg'] = 'question deleted Successfully along with its file';
          $result['status'] = 'success';
        }
      } elseif(!file_exists($file)){
        $sqlins = $conn->query("DELETE FROM questions WHERE id='$qid'");
        $result['msg'] = 'question deleted Successfully';
        $result['status'] = 'success';
      }
      else{
        $result['msg'] = 'There is an error deleting the file';
        $result['status'] = 'failed';
      }

    echo json_encode($result);
  }

  //deleting all test questions
  if(isset($_POST['type']) && $_POST['type'] == 'delete_all_test'){
    $session = $_POST['session'];
    $term = $_POST['term'];
    $SQLquestions = $conn->query("SELECT id,question_pdf FROM questions WHERE exam_type !='Exam' AND exam_type !='Theory' AND session = '$session' AND term='$term'");
    $questions = fetch_all_assoc($SQLquestions);
    if(count($questions) > 0){
      foreach($questions as $question){
        $id = $question["id"];
        $pdf = $question["question_pdf"];
        $file = '../../storege/'.$pdf;
        if(file_exists($file)){
          if(unlink($file)){
            clearstatcache();
            $sqlins = $conn->query("DELETE FROM questions WHERE id='$id'");
          }
        } elseif(!file_exists($file)){
          $sqlins = $conn->query("DELETE FROM questions WHERE id='$id'");
        }
      }

      $result['msg'] = count($questions).' test questions has been deleted';
      $result['status'] = 'success';
    } else {
      $result['msg'] = 'The session or term selected does not exist';
      $result['status'] = 'success';
    }
    echo json_encode($result);
  }

  //deleting all exam questions
  if(isset($_POST['type']) && $_POST['type'] == 'delete_all_exam'){
    $session = $_POST['session'];
    $term = $_POST['term'];
    $SQLquestions = $conn->query("SELECT id,question_pdf FROM questions WHERE exam_type ='Exam' OR exam_type ='Theory' AND session = '$session' AND term='$term'");
    $questions = fetch_all_assoc($SQLquestions);
    if(count($questions) > 0){
      foreach($questions as $question){
        $id = $question["id"];
        $pdf = $question["question_pdf"];
        $file = '../../storege/'.$pdf;
        if(file_exists($file)){
          if(unlink($file)){
            clearstatcache();
            $sqlins = $conn->query("DELETE FROM questions WHERE id='$id'");
          }
        } elseif(!file_exists($file)){
          $sqlins = $conn->query("DELETE FROM questions WHERE id='$id'");
        }
      }

      $result['msg'] = count($questions).' Exam questions has been deleted';
      $result['status'] = 'success';
    } else {
      $result['msg'] = 'The session or term selected does not exist';
      $result['status'] = 'success';
    }
    echo json_encode($result);
  }

  // paginate questions
if(isset($_POST['type']) && $_POST['type'] == 'paginateQst'){
    $html = '';
    $page = $_POST['page']; //page if clicked
    $limit = $_POST['limit']; //records per page
    $search = $_POST['search']; //if search was included
    $offset = ($page - 1) * $limit;

    $resultSales = $conn->query("SELECT COUNT(*) AS total FROM questions WHERE question_id LIKE '%$search%' OR class LIKE '%$search%' OR subject LIKE '%$search%' OR exam_type LIKE '%$search%'")->fetch_assoc();
    $totalRecords = $resultSales['total'];
    $totalPages = ceil($totalRecords / $limit);

    $SQLquestions = $conn->query("SELECT * FROM questions WHERE question_id LIKE '%$search%' OR class LIKE '%$search%' OR subject LIKE '%$search%' OR exam_type LIKE '%$search%' ORDER BY id DESC LIMIT $limit OFFSET $offset");
    $questions = fetch_all_assoc($SQLquestions);
    if(count($questions)>0){
      foreach($questions as $quest){
        $html .= '
        <tr class="tr_qst" data-id_qst="<?= $quest->question_id?>" data-bs-toggle="tooltip"
data-bs-placement="top" title="Double click this row to copy question ID">
<th scope="row" nowrap="nowrap">'.$quest["question_id"].'</th>
<td nowrap="nowrap">'.$quest["subject"].'</td>
<td nowrap="nowrap">'.$quest["exam_type"].'</td>
<td nowrap="nowrap">'.$quest["term"].'</td>
<td nowrap="nowrap">'.$quest["question_pdf"].'</td>
<td nowrap="nowrap">'.$quest["total_question"].'</td>
<td nowrap="nowrap">'.$quest["alloted_mark"].'</td>
<td nowrap="nowrap">'.$quest["total_mark"].'</td>
<td nowrap="nowrap">'.$quest["time_minutes"].'</td>
<td nowrap="nowrap">
	<div class="text-center">
		&nbsp;&nbsp;
		<a href="#" class="btn btn-link p-0 deleteQst" data-qid="'.$quest['id'].'">
			<span class="text-500 text-danger bi bi-trash"></span>
		</a>
	</div>
</td>
</tr>';
}
} else {
$html = '<tr>
	<td colspan="10" class="no-data">No records found.</td>
</tr>';
}
$result['html'] = $html;
$result['totalPages'] = $totalPages;
$result['currentPage'] = $page;
echo json_encode($result);
}
?>