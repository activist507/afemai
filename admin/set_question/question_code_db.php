<?php 
include('../../admin/config/db_connect.php');
$result = array();



//create class for question_codes 
if(isset($_POST['type']) && $_POST['type'] == 'createClass'){
  $cre_class = $_POST['cre_class'];
  $question_codes = $conn->query("SELECT * FROM question_codes WHERE class ='$cre_class'");
  if($question_codes->num_rows > 0){
    $result['msg'] = $cre_class.' already exists';
    $result['activity'] = 'No';
  } else {
    $sqlins = $conn->query("INSERT INTO question_codes SET class ='$cre_class'");
    $result['msg'] = $cre_class.' inserted successfully';
    $result['activity'] = 'Yes';
  }
  echo json_encode($result);
}

//update_question_codes 
if(isset($_POST['type']) && $_POST['type'] == 'updateQuestionCode'){
  $class = $_POST['arr_class_codes'];
  $codes = $_POST['arr_exam_codes'];
  $codes_theo = $_POST['arr_exam_codes_theo'];
  $number = count($class);
  $cnt =0;
  for($i=0;$i<$number;$i++){
    $ind_class = $class[$i];
    $ind_codes = $codes[$i];
    $ind_codes_theo = $codes_theo[$i];
    // if($ind_codes != ''){
      $sqlins = $conn->query("UPDATE question_codes SET question_code ='$ind_codes',theory_code='$ind_codes_theo' WHERE class ='$ind_class'");
    // }
  }
  $result['msg'] = ' exam codes updated successfully';
  // }
  echo json_encode($result);
}

// updateInterviewQst
if(isset($_POST['type']) && $_POST['type'] == 'updateInterviewQst'){
  $sub_id = $_POST['arr_inter_id'];
  $sub_name = $_POST['arr_inter_subject'];
  $number = count($sub_id);
  $cnt =0;
  for($i=0;$i<$number;$i++){
    $ind_sub_id = $sub_id[$i];
    $ind_sub_name = $sub_name[$i];
    $sqlins = $conn->query("UPDATE cbt_staff_subject SET subject ='$ind_sub_name' WHERE id ='$ind_sub_id'");
  }
  $result['msg'] = ' Interview Subjects updated successfully';
  echo json_encode($result);
}

//updating_status
if(isset($_POST['type']) && $_POST['type'] == 'updating_status'){
  $selected_class = $_POST['selected_class'];
  $status = $_POST['stat'];
  $stud_id  = $_POST['stud_id'];
  $gen_branch  = $_POST['gen_branch'];
  if($selected_class == ''){
    $sqlins = $conn->query("UPDATE student_records SET Current_Status ='$status' WHERE Student_ID ='$stud_id' AND Branch='$gen_branch' AND Current_Status != 'Graduated' AND Current_Status !='Left'");
    $result['msg'] = 'An Individual student status updated successfully';
  } else {
    $sqlins = $conn->query("UPDATE student_records SET Current_Status ='$status' WHERE Student_Class ='$selected_class' AND Branch='$gen_branch' AND Current_Status != 'Graduated' AND Current_Status !='Left'");
    $result['msg'] = $selected_class.' status Updated to '.$status.' successfully';
  }

  echo json_encode($result);
}

//updating_password
if(isset($_POST['type']) && $_POST['type'] == 'updating_password'){
  $selected_class = $_POST['selected_class'];
  $typ_pass = $_POST['typ_pass'];
  $hash = md5($typ_pass);
  $stud_id  = $_POST['stud_id'];
  $gen_branch  = $_POST['gen_branch'];
  if($selected_class == ''){
    $sqlins = $conn->query("UPDATE student_records SET new_plain_pass ='$typ_pass',new_pass='$hash' WHERE Student_ID ='$stud_id' AND Branch='$gen_branch' AND Current_Status != 'Graduated' AND Current_Status !='Left'");
    $result['msg'] = 'An Individual student password updated successfully';
  } else {
    $sqlins = $conn->query("UPDATE student_records SET new_plain_pass ='$typ_pass',new_pass='$hash' WHERE Student_Class ='$selected_class' AND Branch='$gen_branch' AND Current_Status != 'Graduated' AND Current_Status !='Left'");
    $result['msg'] = $selected_class.' password Updated successfully';
  }

  echo json_encode($result);
}

// get subject from exam code
if(isset($_POST['type']) && $_POST['type'] == 'getSubjectFromCode'){
    $exam_code = $_POST['exam_code'];
    $answers = $conn->query("SELECT subject FROM answers WHERE exam_id = '$exam_code'");
    if($answers->num_rows < 1){
        $result['query'] = 'false';
    } else {
        $ans = $answers->fetch_object();
        $result['subject'] = $ans->subject;
        $result['query'] = 'true';
    }
    echo json_encode($result);
}

//get student name
if(isset($_POST['type']) && $_POST['type'] == 'getStudentName'){
    $stud_id = $_POST['stud_id'];
    $answers = $conn->query("SELECT name FROM answers WHERE student_id = '$stud_id' LIMIT 1");
    // $answers = $conn->query("SELECT Fullnames FROM student_records WHERE Student_ID = '$stud_id' LIMIT 1");
    if($answers->num_rows < 1){
        $result['query'] = 'false';
    } else {
        $ans = $answers->fetch_object();
        $result['stud_name'] = $ans->name;
        $result['query'] = 'true';
    }
    echo json_encode($result);
}

// dynamic_ans_entry   
if(isset($_POST['type']) && $_POST['type'] == 'paginateAns'){
    $html = '';
    $page = $_POST['page']; //page if clicked
    $limit = $_POST['limit']; //records per page
    $search = $_POST['search']; //if search was included
    $offset = ($page - 1) * $limit;

    $resultSales = $conn->query("SELECT COUNT(*) AS total FROM answers WHERE student_id LIKE '%$search%' OR name LIKE '%$search%' OR class LIKE '%$search%' OR subject LIKE '%$search%' OR exam_id LIKE '%$search%'")->fetch_assoc();
    $totalRecords = $resultSales['total'];
    $totalPages = ceil($totalRecords / $limit);

    $sqlAnswers = $conn->query("SELECT * FROM answers WHERE student_id LIKE '%$search%' OR name LIKE '%$search%' OR class LIKE '%$search%' OR subject LIKE '%$search%' OR exam_id LIKE '%$search%' ORDER BY id DESC LIMIT $limit OFFSET $offset");
    $answers = fetch_all_assoc($sqlAnswers);
    if(count($answers)>0){
      foreach($answers as $ans){
        $html .= '
        <tr class="tr_qst" data-bs-toggle="tooltip"
  data-bs-placement="top" title="Double click this row to copy question ID">
  <th scope="row" nowrap="nowrap">'.$ans["exam_id"].'</th>
  <td scope="row" nowrap="nowrap">'.$ans["student_id"].'</td>
  <td scope="row" nowrap="nowrap">'.$ans["subject"].'</td>
  <td nowrap="nowrap">'.$ans["score"].'</td>
  <td nowrap="nowrap">'.$ans["name"].'</td>
  </tr>';
  }
} else {
$html = '<tr>
	<td colspan="5" class="no-data">No records found.</td>
</tr>';
}
$result['html'] = $html;
$result['totalPages'] = $totalPages;
$result['currentPage'] = $page;
echo json_encode($result);
}


////delete ALL entries from answer table 
if(isset($_POST['type']) && $_POST['type'] == 'delete_all_frm_answer'){
    $sqlins = $conn->query("DELETE FROM answers");
    $result['msg'] = 'All answers deleted Successfully ';
    echo json_encode($result);
}


//delete from answer table  by class and student id
if(isset($_POST['type']) && $_POST['type'] == 'delete_frm_answer'){
    $exam_code = $_POST['exam_code'];
    $tbl_class = $_POST['tbl_class'];
    $btn_clicked = $_POST['btn_clicked'];
    $stud_id  = $_POST['stud_id'];
    if($btn_clicked == 'del_stud'){
      $sqlchk = $conn->query("SELECT id FROM answers WHERE exam_id='$exam_code' AND student_id ='$stud_id'");
      if($sqlchk->num_rows < 1){
        $result['msg'] = 'No such records';
      } else {
        $sqlins = $conn->query("DELETE FROM answers WHERE exam_id='$exam_code' AND student_id ='$stud_id'");
        $result['msg'] = 'Success';
      }
    } elseif($btn_clicked == 'del_class') {
      $sqlchk = $conn->query("SELECT id FROM answers WHERE exam_id='$exam_code' AND class = '$tbl_class'");
      if($sqlchk->num_rows < 1){
        $result['msg'] = 'No student from '.$tbl_class.' has written this exam';
      } else{
        $sqlins = $conn->query("DELETE FROM answers WHERE exam_id='$exam_code' AND class = '$tbl_class'");
        $result['msg'] = $tbl_class.' answers entry deleted successfully ';
      }
    } else {
      $sqlins = $conn->query("DELETE FROM answers");
      $result['msg'] = 'All answers deleted Successfully ';
    }

    echo json_encode($result);
}


if(isset($_POST['type']) && $_POST['type'] == 'paginateQst'){
  $html = '';
  $page = $_POST['page'];
  $limit = $_POST['limit']; 
  $search = $_POST['search']; 
  $offset = ($page - 1) * $limit;

  $resultSales = $conn->query("SELECT COUNT(*) AS total FROM exams WHERE id LIKE '%$search%' OR class_id LIKE '%$search%' OR subject_id LIKE '%$search%' OR assessment_type LIKE '%$search%'")->fetch_assoc();
  $totalRecords = $resultSales['total'];
  $totalPages = ceil($totalRecords / $limit);

  $SQLquestions = $conn->query("SELECT * FROM exams WHERE id LIKE '%$search%' OR class_id LIKE '%$search%' OR subject_id LIKE '%$search%' OR assessment_type LIKE '%$search%' ORDER BY id DESC LIMIT $limit OFFSET $offset");
  $questions = fetch_all_assoc($SQLquestions);
  if(count($questions)>0){
    foreach($questions as $quest){
      $html .= '
      <tr class="tr_qst" data-id_qst="'.$quest["id"].'" data-bs-toggle="tooltip"
      data-bs-placement="top" title="Double click this row to copy question ID">
      <th scope="row" nowrap="nowrap">'.$quest["id"].'</th>
      <td nowrap="nowrap">'.$quest["subject_id"].'</td>
      <td nowrap="nowrap">'.$quest["class_id"].'</td>
      <td nowrap="nowrap">'.$quest["assessment_type"].'</td>
      <td nowrap="nowrap">'.$quest["term_id"].'</td>
      <td nowrap="nowrap">'.$quest["no_of_question"].'</td>
      <td nowrap="nowrap">'.$quest["alloted_mark"].'</td>
      <td nowrap="nowrap">'.$quest["total_mark"].'</td>
      <td nowrap="nowrap">'.$quest["duration"].'</td>
      <td nowrap="nowrap">'.$quest["created_at"].'</td>
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

if(isset($_POST['type']) && $_POST['type'] == 'paginateQst3'){
  $html = '';
  $page = $_POST['page'];
  $limit = $_POST['limit']; 
  $search = $_POST['search']; 
  $offset = ($page - 1) * $limit;

  $resultSales = $conn->query("SELECT COUNT(*) AS total FROM questions WHERE question_id LIKE '%$search%' OR class LIKE '%$search%' OR subject LIKE '%$search%' OR exam_type LIKE '%$search%'")->fetch_assoc();
  $totalRecords = $resultSales['total'];
  $totalPages = ceil($totalRecords / $limit);

  $SQLquestions = $conn->query("SELECT * FROM questions WHERE question_id LIKE '%$search%' OR class LIKE '%$search%' OR subject LIKE '%$search%' OR exam_type LIKE '%$search%' ORDER BY id DESC LIMIT $limit OFFSET $offset");
  $questions = fetch_all_assoc($SQLquestions);
  if(count($questions)>0){
    foreach($questions as $quest){
      $html .= '
      <tr class="tr_qst" data-id_qst="'.$quest["question_id"].'" data-bs-toggle="tooltip"
      data-bs-placement="top" title="Double click this row to copy question ID">
      <th scope="row" nowrap="nowrap">'.$quest["question_id"].'</th>
      <td nowrap="nowrap">'.$quest["subject"].'</td>
      <td nowrap="nowrap">'.$quest["class"].'</td>
      <td nowrap="nowrap">'.$quest["exam_type"].'</td>
      <td nowrap="nowrap">'.$quest["term"].'</td>
      <td nowrap="nowrap">'.$quest["total_question"].'</td>
      <td nowrap="nowrap">'.$quest["alloted_mark"].'</td>
      <td nowrap="nowrap">'.$quest["total_mark"].'</td>
      <td nowrap="nowrap">'.$quest["time_minutes"].'</td>
      <td nowrap="nowrap">'.$quest["created_at"].'</td>
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

// set format  
if(isset($_POST['type']) && $_POST['type'] == 'set_format'){
$format_id = $_POST['formatID'];

$reset = $conn->query("UPDATE cbt_exam_format SET status = 0");

$format = $conn->query("UPDATE cbt_exam_format SET status = 1 WHERE id ='$format_id'");
$result['msg'] = 'Exam Format Updated Successfully';
echo json_encode($result);
}

?>