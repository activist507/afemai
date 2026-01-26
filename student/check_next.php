<?php 
  if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
	include '../admin/config/db_connect.php';
	$result = array();
	// 
	if(!isset($_SESSION['q_arr'])) {
		$_SESSION['q_arr'] = [];	
	} 
	$q_sess_arr = $_SESSION['q_arr'];
    if(isset($_POST['type']) && $_POST['type'] =='checkNext'){
		$exam_id = $_POST['exam_id'];
		$typ = $_POST['typ'];
		$student_ID = $_POST['student_id'];
		$class_id = $_POST['class_id'];
		$Branch = htmlspecialchars($_POST['Branch']);
        $Fullnames = htmlspecialchars($_POST['Fullnames']);
		$codes =  $conn->query("SELECT * FROM question_codes WHERE class='$class_id' ")->fetch_object();
		$db_q_arr = [$codes->question_code,$codes->theory_code];
		array_push($_SESSION['q_arr'],$exam_id);
		$q_sess_arr = $_SESSION['q_arr'];
		$rem = array_values(array_diff($db_q_arr,$q_sess_arr));


		if(count($rem) > 0 && $rem[0] != ""){
			$newId = $rem[0];
		} else {
			$newId = '';
		}
		$format = strpos($newId,"-");
		$length = strlen($newId);
		if($newId != ''){
			if($format > 2){
				$q = $conn->query("SELECT * FROM questions WHERE question_id = '$newId'")->fetch_object();
			} else {
				$q = $conn->query("SELECT id AS question_id, assessment_type AS question_type, assessment_type AS exam_type,subject_id AS subject,term_id AS term FROM exams WHERE id = '$newId'")->fetch_object();
			}
			$term = $q->term;
			$session = $q->session ?? date('Y');
			$subject = $q->subject;
			$question_type = $q->question_type;
			$exam_type = $q->exam_type;
			$student =  $conn->query("INSERT INTO answers(student_id,name,class,branch,term,session,exam_id,subject,question_type,exam_type) 
        		VALUES ('$student_ID','$Fullnames','$class_id','$Branch','$term','$session','$newId','$subject','$question_type','$exam_type')");
			
			if($student){
				if($format > 2){
                    $result['link'] = './?write_exam_original_Theo&exam_id='.$newId;
                } else {
                    if($exam_type == 'Theory'){
                        $result['link'] = "../write_examNewTheo.php/?exam_id=".$newId;
                    } 
                    else {
                        $result['link'] = "../write_examNew.php/?exam_id=".$newId;
                    }
                }
			}
		} else {
			unset($_SESSION['q_arr']);
			if($typ == "pdf"){
				$result['link'] = '../?studentlogin'; 
			} 
			if($typ == "doc"){
				$result['link'] = '../../?studentlogin';
			}
		}
		echo json_encode($result);
	}