<?php 
include('../admin/config/db_connect.php');
if(isset($_POST['type']) && $_POST['type'] == 'markRegister'){
	$result = array();
	$ids = $_POST['ids'];
	$class_name = $_POST['class_name'];
	$class_branch = $_POST['class_branch'];
	$date = date('Y-m-d');
	foreach($ids as $idd){
        $id = $idd['value'];
        $qy = "INSERT INTO attendance_students (studentID,class,branch,date,status) VALUES ('$id','$class_name','$class_branch','$date',1)";
        $res = $conn->query($qy);
    }
    $result['status'] = 'success';
    $result['message'] = 'You have successfully Marked '.$class_name.' Register';

	echo json_encode($result);
} 

if(isset($_POST['type']) && $_POST['type'] == 'markRegister2'){
	$result = array();
	$class_name = $_POST['class_name'];
	$class_branch = $_POST['class_branch'];
	$date = date('Y-m-d');
	$ids = $_POST['ids'] ?? [];
	$ids_values = array_column($ids, 'value');
	$mIDs = $_POST['mIDs'] ?? [];
	$zeroArray = array_diff($mIDs, $ids_values);
	$onesArray = array_diff($ids_values, $mIDs);
	if(count($zeroArray) > 0){
		foreach($zeroArray as $id){
			// $qy = "UPDATE attendance_students SET status = 0 WHERE studentID = '$id' AND class ='$class_name' AND branch='$class_branch' AND date='$date'";
			$qy = "DELETE FROM attendance_students WHERE studentID = '$id' AND class ='$class_name' AND branch='$class_branch' AND date='$date'";
			$res = $conn->query($qy);
		}
	} 
	elseif(count($onesArray) > 0){
		foreach($onesArray as $id){
			$qy = "INSERT INTO attendance_students SET studentID = '$id',class ='$class_name',branch='$class_branch',date='$date' ,status = 1";
			$res = $conn->query($qy);
		}
	} elseif(count($ids)==0 && count($mIDs )>0){
		foreach($mIDs as $id){
			// $qy = "UPDATE attendance_students SET status = 0 WHERE studentID = '$id' AND class ='$class_name' AND branch='$class_branch' AND date='$date'";
			$qy = "DELETE FROM attendance_students WHERE studentID = '$id' AND class ='$class_name' AND branch='$class_branch' AND date='$date'";
			$res = $conn->query($qy);
		}
	}
    $result['status'] = 'success';
    $result['updateToZero'] = $zeroArray;
    $result['setToOne'] = $onesArray;
    $result['message'] = 'You have successfully Updated '.$class_name.' Register';

	echo json_encode($result);
} 
?>