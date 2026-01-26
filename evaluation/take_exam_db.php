<?php 
include('../admin/config/db_connect.php');

$result = array();
if(isset($_POST['type']) && $_POST['type'] == "submitToAnswerTable")
{
	$invCode = htmlspecialchars($_POST['invCode']);
	$subject = htmlspecialchars($_POST['subject']);

	$check = $conn->query("SELECT * FROM cbt_answers WHERE inv_code='$invCode' AND subject = '$subject'");
	$checkAvailable = $conn->query("SELECT id FROM questions WHERE class='Interview' AND subject='$subject'");
	if($checkAvailable->num_rows == 0){
		$result['message'] = 'There are no questions to answer for the subject '.$subject.' that you selected';
		$result['link'] = 'no-link';
	}
	elseif($check->num_rows > 0){
		$result['message'] = 'You Have Written This Exam';
		$result['link'] = 'no-link';
	} 
	else {
	$student =  $conn->query("INSERT INTO cbt_answers(inv_code,subject) VALUES ('$invCode','$subject')");
		if($student){
			$result['link'] = './?write_exam_original&subject='.$subject;
		}
	}

	

	echo json_encode($result);
}

if(isset($_POST['type']) && $_POST['type'] == "updateScore"){
	$invCode = $_POST['Inv_CODE'];
	$subject = $_POST['subject'];
	$score = $_POST['invitee_score'];
	$check = $conn->query("UPDATE cbt_answers SET score = '$score' WHERE inv_code='$invCode' AND subject = '$subject'");

	$eval_score = $conn->query("SELECT score FROM cbt_staff_eval WHERE inv_code='$invCode'")->fetch_object();
	if($eval_score->score == NULL){
		$newScore = $subject.'~'.$score;
	} else {
		$newScore = $eval_score->score.':'.$subject.'~'.$score;
	}
	$update = $conn->query("UPDATE cbt_staff_eval SET score = '$newScore' WHERE inv_code='$invCode'");
	$result['status'] = 'Success';
	echo json_encode($result);
}

?>