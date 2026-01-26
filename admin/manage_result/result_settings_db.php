<?php 
	include('../../admin/config/db_connect.php');
    $result = array();

	if(isset($_POST['type']) && $_POST['type'] == 'findMissing'){   
		$branch = $_POST['branch'];
		$className = $_POST['className'];
		$session = $_POST['session'];
		$table = $_POST['term'];
		$allEntry = $conn->query("SELECT Student_ID FROM {$table} WHERE Class='$className' AND C_Session='$session' AND Branch='$branch'")->fetch_all(MYSQLI_ASSOC);
		$enteredIds = array_column($allEntry, 'Student_ID');

		$activeStudent = $conn->query("SELECT Student_ID FROM student_records WHERE Student_Class='$className' AND Current_Status='Active' AND Branch='$branch'")->fetch_all(MYSQLI_ASSOC);
		$activeIds = array_column($activeStudent, 'Student_ID');

		$notEntered = array_diff($activeIds,$enteredIds);
		$html = '<table class="table small table-bordered">
			<thead>
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Name</th>
				</tr>
			</thead>
			<tbody>';
		if(count($notEntered) == 0){
			$html .= '<tr>
					<td scope="col" colspan="2" class="text-nowrap">All Students Results Has Been Entered</td>
				</tr>';
		} else {
			foreach($notEntered as $student_Id){
				$row = $conn->query("SELECT Fullnames FROM student_records WHERE Student_ID='$student_Id'")->fetch_object();
				$fullname = $row->Fullnames;
				$html .= '<tr>
					<td scope="col" class="text-nowrap">'.$student_Id.'</td>
					<td scope="col" class="text-nowrap">'.$fullname.'</td>
				</tr>';
			}
			$html .= '</tbody></table>';
		}

		$result['html'] = $html;
		echo json_encode($result);
    }

?>