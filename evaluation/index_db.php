<?php 
	include('../admin/config/db_connect.php');

	if(isset($_POST['type']) && $_POST['type'] == 'updateDetails'){
		$InvCode = $_POST['InvCode'];
        $Fullnames = $_POST['Fullnames'];
        $gender = $_POST['staff_gender'];
        $dob = $_POST['staff_dob'];
        $qual = $_POST['staff_qualification'];
        $email = $_POST['staff_email'];
        $phone = $_POST['staff_phone'];
        $area_spec = $_POST['area_spec'];
        $address = $_POST['staff_address'];
        $religion = $_POST['religion'];
        $comment = $_POST['staff_comment'];
        $s_skills = $_POST['s_skills'];
		$subject = $_POST['subj'];
        $subj = [];
		foreach($subject as $sub){
			$subj[] = $sub['value'];
		}
		$subjs = implode($subj,",");

		// $qy = "UPDATE cbt_staff_eval SET fullnames='$Fullnames',gender='$gender',d_o_b='$dob',qualification='$qual',email='$email',
		// phone='$phone',area_spec='$area_spec',address='$address',religion='$religion',comment='$comment',subject='$subjs',s_skills='$s_skills' WHERE inv_code = '$InvCode' ";
        // $res = $conn->query($qy);
		$qy = "UPDATE cbt_staff_eval SET fullnames=?,gender=?,d_o_b=?,qualification=?,email=?,
		phone=?,area_spec=?,address=?,religion=?,comment=?,subject=?,s_skills=? WHERE inv_code = ? ";
        $stmt = $conn->prepare($qy);
		$stmt->bind_param("ssssssssssssi",$Fullnames,$gender,$dob,$qual,$email,$phone,$area_spec,$address,$religion,$comment,$subjs,$s_skills,$InvCode);
		$stmt->execute();
		$result['msg'] = 'Details Saved Successfully';

		echo json_encode($result);
	}

	if(isset($_POST['type']) && $_POST['type'] == 'checkSubject'){
		$invId = $_POST['invID'];
		$sub = $conn->query("SELECT subject FROM cbt_staff_eval WHERE inv_code = '$invId'")->fetch_object();
		if($sub->subject == ''){
			$result['status'] = 'false';
		} else {
			$result['status'] = 'true';
		}
		echo json_encode($result);
	}

?>