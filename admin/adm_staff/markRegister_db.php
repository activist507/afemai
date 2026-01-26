<?php 
include('../config/db_connect.php');
if(isset($_POST['type']) && $_POST['type'] == 'markRegister'){
	$result = array();
	$ids = $_POST['ids'];
	$class_branch = $_POST['class_branch'];
	// $date = date('Y-m-d');
	$date = $_POST['date'];
	foreach($ids as $idd){
        $id = $idd['value'];
        $qy = "INSERT INTO attendance_staff (staffID,branch,date,status) VALUES ('$id','$class_branch','$date',1)";
        $res = $conn->query($qy);
    }
    $result['status'] = 'success';
    $result['message'] = 'You have successfully Marked Register';

	echo json_encode($result);
} 

if(isset($_POST['type']) && $_POST['type'] == 'markRegister2'){
	$result = array();
	$class_branch = $_POST['class_branch'];
	// $date = date('Y-m-d');
	$date = $_POST['date'];
	$ids = $_POST['ids'] ?? [];
	$ids_values = array_column($ids, 'value');
	$mIDs = $_POST['mIDs'] ?? [];
	$zeroArray = array_diff($mIDs, $ids_values);
	$onesArray = array_diff($ids_values, $mIDs);
	if(count($zeroArray) > 0){
		foreach($zeroArray as $id){
			$qy = "DELETE FROM attendance_staff WHERE staffID = '$id' AND branch='$class_branch' AND date='$date'";
			$res = $conn->query($qy);
		}
	} 
	elseif(count($onesArray) > 0){
		foreach($onesArray as $id){
			$qy = "INSERT INTO attendance_staff SET staffID = '$id',branch='$class_branch',date='$date' ,status = 1";
			$res = $conn->query($qy);
		}
	} elseif(count($ids)==0 && count($mIDs )>0){
		foreach($mIDs as $id){
			$qy = "DELETE FROM attendance_staff WHERE staffID = '$id' AND branch='$class_branch' AND date='$date'";
			$res = $conn->query($qy);
		}
	}
    $result['status'] = 'success';
    $result['updateToZero'] = $zeroArray;
    $result['setToOne'] = $onesArray;
    $result['message'] = 'You have successfully Updated Register';

	echo json_encode($result);
} 




if(isset($_POST['type']) && $_POST['type'] == 'markAbsRegister'){
	$result = array();
	$ids = $_POST['ids'];
	$class_branch = $_POST['class_branch'];
	// $date = date('Y-m-d');
	$date = $_POST['date'];
	foreach($ids as $idd){
        $id = $idd['value'];
        $qy = "INSERT INTO attendance_staff (staffID,branch,date,status_abs) VALUES ('$id','$class_branch','$date',1)";
        $res = $conn->query($qy);
    }
    $result['status'] = 'success';
    $result['message'] = 'You have successfully Marked Abscorned Register';

	echo json_encode($result);
} 

if(isset($_POST['type']) && $_POST['type'] == 'markAbsRegister2'){
	$result = array();
	$class_branch = $_POST['class_branch'];
	// $date = date('Y-m-d');
	$date = $_POST['date'];
	$ids = $_POST['ids'] ?? [];
	$ids_values = array_column($ids, 'value');
	$mIDs = $_POST['mIDs'] ?? [];
	$zeroArray = array_diff($mIDs, $ids_values);
	$onesArray = array_diff($ids_values, $mIDs);
	if(count($zeroArray) > 0){
		foreach($zeroArray as $id){
			// $qy = "DELETE FROM attendance_staff WHERE staffID = '$id' AND branch='$class_branch' AND date='$date'";
			$qy = "UPDATE attendance_staff SET status_abs=0 WHERE staffID = '$id' AND branch='$class_branch' AND date='$date'";
			$res = $conn->query($qy);
		}
	} 
	elseif(count($onesArray) > 0){
		foreach($onesArray as $id){
			$qy = "INSERT INTO attendance_staff SET staffID = '$id',branch='$class_branch',date='$date',status_abs = 1";
			$res = $conn->query($qy);
		}
	} elseif(count($ids)==0 && count($mIDs )>0){
		foreach($mIDs as $id){
			// $qy = "DELETE FROM attendance_staff WHERE staffID = '$id' AND branch='$class_branch' AND date='$date'";
			$qy = "UPDATE attendance_staff SET status_abs=0 WHERE staffID = '$id' AND branch='$class_branch' AND date='$date'";
			$res = $conn->query($qy);
		}
	}
    $result['status'] = 'success';
    $result['updateToZero'] = $zeroArray;
    $result['setToOne'] = $onesArray;
    $result['message'] = 'You have successfully Updated Abscorned Register';

	echo json_encode($result);
} 

?>