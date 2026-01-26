<?php 
 include('config/db_connect.php');

    $result = array();
    if(isset($_POST['type']) && $_POST['type'] == 'dashboard'){
        $html = '';
        $branches = $conn->query("SELECT * FROM branches");
        $branches_rows = $branches->fetch_all(MYSQLI_ASSOC);
        $studentss = $conn->query("SELECT * FROM student_records WHERE Current_Status = 'Active'");
        $fetchings = $studentss->fetch_all();
        $stud_total_all = count($fetchings);
        $stafff = $conn->query("SELECT * FROM staff_records WHERE Staff_Status = 'Active'");
        $fetchingss = $stafff->fetch_all();
        $staff_total_all = count($fetchingss);

        $html .= '<div class="pagetitle"><h5 class="text-success fw-bold">ACTIVE STUDENTS</h5></div><section class="section dashboard"><div class="row"><div class="col-lg-12"><div class="row">';
        foreach($branches_rows as $branch ){
            $b_name = $branch['Branch_Name'];
            $students = $conn->query("SELECT * FROM student_records WHERE Branch = '$b_name' AND Current_Status = 'Active'");
            $fetching = $students->fetch_all();
            $stud_total = count($fetching);
            $html .= ' <div class="col-xxl-3 col-md-3 col-lg-3 col-sm-2"><div class="card " style="height: 4rem;"><div class="card-body text-center">
                    <h5 class="card-title">'.$branch["Branch_Name"].'</span> = <i>'.$stud_total.'</i></h5></div></div></div>';
        }
        $html .= '<div class="col-xxl-4 col-xl-12"><div class="card info-card customers-card"><div class="card-body">
                <h5 class="card-title text-center">Total Number of Students </h5><div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-people"></i></div>
                <div class="ps-3"><h6>'.$stud_total_all.'</h6></div></div></div></div></div>';
        $html .= '<div class="col-12"><div class="card text-success" style="height: 4rem; background: #03a439;">
                <div class="card-body text-center"><h5 class="card-title fw-bold text-white">ACTIVE STAFF STATISTICS </h5></div></div></div>';

        foreach($branches_rows as $branch ){
            $b_name = $branch['Branch_Name'];
            $staff = $conn->query("SELECT * FROM staff_records WHERE Branch = '$b_name' AND Staff_Status = 'Active'");
            $fetching = $staff->fetch_all();
            $staff_total = count($fetching);
            $html .= '<div class="col-xxl-3 col-md-3 col-lg-3 col-sm-2"><div class="card " style="height: 4rem;"><div class="card-body             text-center"><h5 class="card-title">'.$branch['Branch_Name'].'</span> = <i>'.$staff_total.'</i></h5></div></div></div>';
        }

        $html .= '<div class="col-xxl-4 col-xl-12"><div class="card info-card customers-card"><div class="card-body"><h5 class="card-title text-center">Total Number of Staff </h5><div class="d-flex align-items-center"><div class="card-icon rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-people"></i></div><div class="ps-3"><h6>'.$staff_total_all.'</h6></div></div></div></div></div></div></div></div></section>';

        $result['html'] = $html;
        echo json_encode($result);
    }

    if(isset($_POST['type']) && $_POST['type'] == 'getClassFromSection'){
      $html = '<option value="0"></option>';
      $sect = $_POST['section'];
      $term = $_POST['term'];
      $branch = $_POST['branch'];
      $sqlclass = $conn->query("SELECT * FROM cbt_class WHERE section = '$sect'");
      while($class = $sqlclass->fetch_object()){
        $html .= '<option value="'.$class->class.'">'.$class->class.'</option>';
      }
      $sqlfeesDeter = $conn->query("SELECT * FROM fees_determination WHERE Term = '$term' AND Branch ='$branch'");
      $feesDeter = $sqlfeesDeter->fetch_object();
      if($sect == 'Nursery'){
        $result['tution_fee'] = $feesDeter->Nur1;
      } elseif($sect == 'Primary'){
        $result['tution_fee'] = $feesDeter->Pry1;
      } elseif($sect == 'Junior Sec'){
        $result['tution_fee'] = $feesDeter->Jss1;
      } elseif($sect == 'Senior Sec') {
        $result['tution_fee'] = $feesDeter->Ss1;
      } else {
        $result['tution_fee'] = 0;
      }
      $result['html'] = $html;
      echo json_encode($result);
    }

    //updating curr_term table
    if(isset($_POST['type']) && $_POST['type'] == 'updateCurrentTerm'){
      $term = $_POST['term'];
      $branch = $_POST['branch'];
      $session = $_POST['session'];
      $ann = $_POST['announcement'];
      $gen_msg = $_POST['gen_msg'];
      $sqlins = $conn->query("UPDATE current_term SET Current_Term='$term',Current_Session='$session',Branch='$branch',announcement='$ann',gen_msg='$gen_msg' WHERE ID='1'");
      
      if($sqlins){
        $result['msg'] = 'Current Term Updated Successfully';
      } else {
        $result['msg'] = 'An error was encountered';
      }
      
      echo json_encode($result);
    }

    //updating setup table(for bulletin)
    if(isset($_POST['type']) && $_POST['type'] == 'updateBulletin'){
      $bulletin_id = $_POST['bulletin_id'];
      $bulletin_title = $_POST['bulletin_title'];
      $status_ = $_POST['status_'];
      $bulletin_date = $_POST['bulletin_date'];
      function random($length){
        $str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($str),0,$length);
      }
      $imageReal = random(10);

      /////<!--------- pdf bulletin-----------!>/////////////
      if(isset($_FILES['file'])){
        $file = $_FILES['file'];
        $pdf = $file["name"];
        $tempname = $file["tmp_name"];
        $ext = substr($pdf, strrpos($pdf, '.', -1), strlen($pdf));
        $finalName = $imageReal.$ext;
        $folder = "../storege/setup_pdf/".$finalName;
        move_uploaded_file($tempname, $folder);   
      }
      /////<!--------- -----------!>/////////////


      /////<!--------- image bulletin-----------!>/////////////
      if(isset($_FILES['bullet_img'])){
        $file_img = $_FILES['bullet_img'];
        $img = $file_img["name"];
        $tempname1 = $file_img["tmp_name"];
        $ext = substr($img, strrpos($img, '.', -1), strlen($img));
        $imageName = $imageReal.$ext;
        $folder1 = "../storege/setup_pdf/".$imageName;
        move_uploaded_file($tempname1, $folder1);  
      }
      /////<!--------- -----------!>/////////////

      if($bulletin_id == 0){
        if(isset($_FILES['file']) && isset($_FILES['bullet_img'])){
          $sqlins = $conn->query("INSERT INTO setups SET title='$bulletin_title',status='$status_',date='$bulletin_date',homepage_pdf='$finalName',homepage_img='$imageName'");
        } 
        elseif(isset($_FILES['file']) && !isset($_FILES['bullet_img'])) {
          $sqlins = $conn->query("INSERT INTO setups SET title='$bulletin_title',status='$status_',date='$bulletin_date',homepage_pdf='$finalName'");
        } 
        elseif(!isset($_FILES['file']) && isset($_FILES['bullet_img'])){
          $sqlins = $conn->query("INSERT INTO setups SET title='$bulletin_title',status='$status_',date='$bulletin_date',homepage_img='$imageName'");
        } 
        else {
          $sqlins = $conn->query("INSERT INTO setups SET title='$bulletin_title',status='$status_',date='$bulletin_date'");
        }
      } else {
        if(isset($_FILES['file']) && isset($_FILES['bullet_img'])){
          $sqlins = $conn->query("UPDATE setups SET title='$bulletin_title',status='$status_',date='$bulletin_date',homepage_pdf='$finalName',homepage_img='$imageName' WHERE id='$bulletin_id'");
        }
        elseif(isset($_FILES['file']) && !isset($_FILES['bullet_img'])){
          $sqlins = $conn->query("UPDATE setups SET title='$bulletin_title',status='$status_',date='$bulletin_date',homepage_pdf='$finalName' WHERE id='$bulletin_id'");
        }
        elseif(!isset($_FILES['file']) && isset($_FILES['bullet_img'])){
          $sqlins = $conn->query("UPDATE setups SET title='$bulletin_title',status='$status_',date='$bulletin_date',homepage_img='$imageName' WHERE id='$bulletin_id'");
        
        }
        else{
          $sqlins = $conn->query("UPDATE setups SET title='$bulletin_title',status='$status_',date='$bulletin_date' WHERE id='$bulletin_id'");
        }
      }

      if($sqlins){
        $result['msg'] = 'Bulletin Saved Successfully';
      } else {
        $result['msg'] = 'An error was encountered';
      }
      
      echo json_encode($result);
    }

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
        $fornow = "question_pdf/".$nam;
        $folder = "../storege/question_pdf/".$nam;
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
      $result['quest_pdf'] = "../storege/".$qstreal->question_pdf;
      $result['html'] = $html;
      $result['msg'] = $msg;
      echo json_encode($result);
    }

    // dynamic_payment_entry   
    if(isset($_POST['type']) && $_POST['type'] == 'dynamic_payment_entry'){
      $html = '';
      $student_payment = $conn->query("SELECT * FROM student_payment ORDER BY ID DESC LIMIT 7");
      while($quest = $student_payment->fetch_object()){
        $html .= '<tr>
        <th scope="row" nowrap="nowrap">'.$quest->Student_ID.'</th>
        <td nowrap="nowrap">'.$quest->Fullnames.'</td>
        <td nowrap="nowrap">'.$quest->Student_Class.'</td>
        <td nowrap="nowrap">'.$quest->Phone_Number.'</td>
        <td nowrap="nowrap">'.$quest->Pay_Option.'</td>
        <td nowrap="nowrap">'.$quest->Total_Fees.'</td>
        <td nowrap="nowrap">'.$quest->Gen_Discount.'</td>
        <td nowrap="nowrap">'.$quest->Amt_Payable.'</td>
        <td nowrap="nowrap">'.$quest->Amt_Paid.'</td>
        <td nowrap="nowrap">'.$quest->Balance.'</td>
        </tr>';
      }
                            // <td nowrap="nowrap">'.$quest->SmsStatus.'</td>
      $result['html'] = $html;
      echo json_encode($result);
    }
?>