<?php 
  if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
  include '../admin/config/db_connect.php';
  $result = array();

  if(isset($_POST['type']) && $_POST['type'] =='save'){
    //<============= essentials ========>
      $id = $_SESSION['std_id'];
      $Student_records =  $conn->query("SELECT Student_ID,Fullnames,Student_Class,Branch FROM student_records WHERE Student_ID='$id' ")->fetch_object();
      $student_ID = $Student_records->Student_ID;
      $Fullnames = $Student_records->Fullnames;
      $Student_Class = $Student_records->Student_Class;
      $Branch = $Student_records->Branch;
      $answers = json_decode($_POST['answers'], true);
      $exam_id = $_POST['exam_id'];
      $exam = $conn->query("SELECT subject_id,assessment_type,alloted_mark,total_mark,no_of_question,term_id FROM exams WHERE id = '$exam_id'")->fetch_object();
      $subject = $exam->subject_id;
      $term = $exam->term_id; 
      $date = date('Y-m-d h:i:s');
      $yearr = date('Y');
      if($term == 1){
        $session = $yearr + 1;
      } else {
        $session = $yearr;
      }
      // $session = ; //from exams table
      $alloted_mark = $exam->alloted_mark;
      $total_mark = $exam->total_mark;
      $no_of_question = $exam->no_of_question;
      $column = strtolower($exam->assessment_type);
    //<============= essentials ========>

    //<============= calculating score ========>
      $correct = 0;
      $wrong = 0;
      $stmt = $conn->prepare("SELECT is_correct FROM options WHERE id=?");
      foreach ($answers as $ans=>$opt_id){
        $stmt->bind_param("i",$opt_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $val = $res->fetch_assoc()['is_correct'];
        if($val == 1){
          $correct++;
        } else {
          $wrong++;
        }
      }
      $score = (float)$alloted_mark*$correct;
      $stud_score = round($score);
    //<============= calculating score ========>
    
    //<!==============scores table method   ==========>
      $update_ans =  $conn->query("UPDATE answers SET score = '$stud_score', updated_at='$date' WHERE student_id='$student_ID' AND exam_id = '$exam_id'");

      //checking if the student has record in the result table
      $checking =  $conn->query("SELECT * FROM results WHERE student_id='$student_ID'");

      //if no result found
      if($checking->num_rows < 1){
        $results =  $conn->query("INSERT INTO results(student_id,Name,session,Class,branch,Term,{$subject}) 
        VALUES ('$student_ID','$Fullnames','$session','$Student_Class','$Branch','$term','$stud_score')");
        $result_arr['msg'] = "Score submitted successfully. You scored : $stud_score";
      } 
      else { //if result is found
        $update_results =  $conn->query("UPDATE results SET {$subject} = '$stud_score' WHERE student_id='$student_ID' ");
        $result_arr['msg'] = "Score Updated successfully. You scored : $stud_score";
      }
    //<!==============scores table method   ==========>
    echo json_encode($result_arr); 
  }

  // write Exam functions for updating scores  
  if(isset($_POST['type']) && $_POST['type'] == "updateScore"){
      $result_arr = array();
      $student_ID = htmlspecialchars($_POST['Student_ID']);
      $Fullnames = htmlspecialchars($_POST['Fullnames']);
      $Student_Class = htmlspecialchars($_POST['Student_Class']);
      $Branch = htmlspecialchars($_POST['Branch']);
      $term = htmlspecialchars($_POST['term']);
      $session = htmlspecialchars($_POST['session']);
      $question_id = htmlspecialchars($_POST['question_id']);
      $subject = htmlspecialchars($_POST['subject']);
      $stud_score = (int)$_POST['stud_score'];
      $date = date('Y-m-d h:i:s');

      $update_ans =  $conn->query("UPDATE answers SET score = '$stud_score', updated_at='$date' WHERE student_id='$student_ID' AND exam_id = '$question_id'");

      //checking if the student has record in the result table
      $checking =  $conn->query("SELECT * FROM results WHERE student_id='$student_ID'");

      //if no result found
      if($checking->num_rows < 1){
          // insert into the result table     ,'$stud_score'
          $results =  $conn->query("INSERT INTO results(student_id,Name,session,Class,branch,Term,{$subject}) 
          VALUES ('$student_ID','$Fullnames','$session','$Student_Class','$Branch','$term','$stud_score')");
          $result_arr['message'] = 'Score submitted successfully';
      } 
      else { //if result is found
          //update the result table using the student_id
          $update_results =  $conn->query("UPDATE results SET {$subject} = '$stud_score' WHERE student_id='$student_ID' ");
          $result_arr['message'] = 'Score Updated successfully';
      }

      echo json_encode($result_arr);
  }
?>