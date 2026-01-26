<?php 
 if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    include('admin/config/db_connect.php');

	if(isset($_POST['type']) && $_POST['type'] == 'checkCode'){
		$invCode = htmlspecialchars($_POST['invCode']);
		$check = $conn->query("SELECT inv_code FROM cbt_staff_eval WHERE inv_code = '$invCode'")->fetch_object();
		if(isset($check->inv_code)){
			$_SESSION['authentication'] = 'true';
			$_SESSION['invCode'] = $invCode;
			$result['status'] = 'true';
			$result['link'] = './evaluation';
		} else {
			$result['status'] = 'false';
		}

		echo json_encode($result);
	}
	if(isset($_POST['type']) && $_POST['type'] == 'checkCodeEntrance'){
		$intakeCode = htmlspecialchars($_POST['intakeCode']);
		$check = $conn->query("SELECT intake_id,class_adm FROM cbt_new_intake WHERE intake_id = '$intakeCode'")->fetch_object();
		if(isset($check->intake_id)){
			$_SESSION['authentication'] = 'true';
			$_SESSION['intakeCode'] = $intakeCode;
			$_SESSION['class'] = $check->class_adm;
			$result['status'] = 'true';
			$result['link'] = './entrance';
		} else {
			$result['status'] = 'false';
		}

		echo json_encode($result);
	}
?>