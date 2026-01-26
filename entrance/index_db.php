<?php 
include('../admin/config/db_connect.php');

$result = array();
if(isset($_POST['type']) && $_POST['type'] == "submitToAnswerTable")
{
	$intakeCode = htmlspecialchars($_POST['intakeCode']);
	$question_id = htmlspecialchars($_POST['question_id']);

	$check = $conn->query("SELECT * FROM cbt_answers WHERE inv_code='$intakeCode' AND subject = '$question_id'");
	$checkAvailable = $conn->query("SELECT id FROM questions WHERE question_id='$question_id'");
	if($checkAvailable->num_rows == 0){
		$result['message'] = 'There are no questions to answer for the subject '.$subject.' that you selected';
		$result['link'] = 'no-link';
	}
	elseif($check->num_rows > 0){
		$result['message'] = 'You Have Written This Exam';
		$result['link'] = 'no-link';
	} 
	else {
	$student =  $conn->query("INSERT INTO cbt_answers(inv_code,subject) VALUES ('$intakeCode','$question_id')");
		if($student){
			$result['link'] = './?write_exam_original&question_id='.$question_id;
		}
	}

	echo json_encode($result);
}

if(isset($_POST['type']) && $_POST['type'] == "updateScore"){
	$intakeCode = $_POST['intakeCode'];
	$subject = $_POST['subject'];
	$question_id = $_POST['question_id'];
	$score = $_POST['invitee_score'];
	$check = $conn->query("UPDATE cbt_answers SET score = '$score' WHERE inv_code='$intakeCode' AND subject = '$question_id'");

	$eval_score = $conn->query("SELECT score FROM cbt_new_intake WHERE intake_id='$intakeCode'")->fetch_object();
	if($eval_score->score == NULL){
		$newScore = $subject.'~'.$score;
	} else {
		$newScore = $eval_score->score.':'.$subject.'~'.$score;
	}
	$update = $conn->query("UPDATE cbt_new_intake SET score = '$newScore' WHERE intake_id='$intakeCode'");
	$result['status'] = 'Success';
	echo json_encode($result);
}

?>