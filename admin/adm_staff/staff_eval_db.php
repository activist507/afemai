<?php 
include('../../admin/config/db_connect.php');
$result = array();

if(isset($_POST['type']) && $_POST['type'] == 'generateInvCode'){
	$numbGen = intval($_POST['numbGen']);
	$success = 0;
	for ($i=0; $i < $numbGen; $i++) { 
		$inv_code = mt_rand(100000000,999999999);
		$insert = $conn->query("INSERT INTO cbt_staff_eval SET inv_code = '$inv_code'");
		$success++;
	}
	$result['msg'] = $success.' codes generated successfully';
	echo json_encode($result);
}

if(isset($_POST['type']) && $_POST['type'] == 'paginateScore'){
	$html = '';
    $page = $_POST['page']; //page if clicked
    $limit = $_POST['limit']; //records per page
    $search = $_POST['search']; //if search was included
    $offset = ($page - 1) * $limit;

    $resultSales = $conn->query("SELECT COUNT(*) AS total FROM cbt_staff_eval WHERE inv_code LIKE '%$search%' OR fullnames LIKE '%$search%' OR qualification LIKE '%$search%' OR subject LIKE '%$search%'")->fetch_assoc();
    $totalRecords = $resultSales['total'];
    $totalPages = ceil($totalRecords / $limit);

    $answers = $conn->query("SELECT * FROM cbt_staff_eval WHERE inv_code LIKE '%$search%' OR fullnames LIKE '%$search%' OR qualification LIKE '%$search%' OR subject LIKE '%$search%' ORDER BY id ASC LIMIT $limit OFFSET $offset")->fetch_all(MYSQLI_ASSOC);
    if(count($answers)>0){
      	foreach($answers as $ans){
			$html .= '
			<tr class="tr_qst" data-id="'.$ans["inv_code"].'">
			<th scope="row" nowrap="nowrap">'.$ans["id"].'</th>
			<td scope="row" nowrap="nowrap">'.$ans["inv_code"].'</td>
			<td scope="row" nowrap="nowrap">'.strtoupper($ans["fullnames"]).'</td>
			<td nowrap="nowrap">'.$ans["score"].'</td>
			<td nowrap="nowrap">
				<div class="text-center">
					&nbsp;&nbsp;
					<a href="#" class="btn btn-link p-0 deleteQst" data-qid="'.$ans['inv_code'].'">
						<span class="text-500 text-danger bi bi-trash"></span>
					</a>
				</div>
			</td>
			</tr>';
		}
		// <td nowrap="nowrap">'.$ans["fullnames"].'</td>
	} else {
		$html = '<tr>
			<td colspan="5" class="no-data">No records found.</td>
		</tr>';
	}
	$result['html'] = $html;
	$result['totalPages'] = $totalPages;
	$result['currentPage'] = $page;
	echo json_encode($result);
}

if(isset($_POST['type']) && $_POST['type'] == 'deleteInvCode'){
	$invID = $_POST['invID'];
	$sql = $conn->query("DELETE FROM cbt_staff_eval WHERE inv_code = '$invID'");
	$sql1 = $conn->query("DELETE FROM cbt_answers WHERE inv_code = '$invID'");
	$result['msg'] = 'Code deleted successfully';

	echo json_encode($result);
}


if(isset($_POST['type']) && $_POST['type'] == 'deleteAllCode'){
	$sql = $conn->query("DELETE FROM cbt_staff_eval ");
	$sql1 = $conn->query("DELETE FROM cbt_answers ");
	$result['msg'] = 'All Codes are deleted successfully';

	echo json_encode($result);
}

if(isset($_POST['type']) && $_POST['type'] == 'getEvalStaffDet'){
	$invCode = $_POST['invCode'];
	$eval = $conn->query("SELECT * FROM cbt_staff_eval WHERE inv_code='$invCode'")->fetch_object();
	$result['inv_ID'] = $invCode ?? '000000000';
	$result['fullname'] = $eval->fullnames ?? '';
	$result['gender'] = $eval->gender ?? '';
	$result['dob'] = $eval->d_o_b ?? '';
	$result['qual'] = $eval->qualification ?? '';
	$result['area_spec'] = $eval->area_spec ?? '';
	$result['phone'] = $eval->phone ?? '';
	$result['email'] = $eval->email ?? '';
	$result['add'] = $eval->address ?? '';
	$result['religion'] = $eval->religion ?? '';
	$result['comm'] = $eval->comment ?? '';
	$result['skill'] = $eval->s_skills ?? '';
	$subjs = $eval->subject ?? '';
	$subjects = $conn->query("SELECT * FROM cbt_staff_subject")->fetch_all(MYSQLI_ASSOC);
	// $html = '';
	// foreach($subjects as $sub):
	// 	if(strpos($subjs,$sub['subject']) != FALSE){
	// 		$html .= '<div class="col-3 form-check">
	// 			<input type="checkbox" checked name="subjects[]" class="form-check-input subjects">
	// 			<label class="form-check-label" for="option1">'.$sub['subject'].'</label>
	// 		</div>';
	// 	} else {
	// 		$html .= '<div class="col-3 form-check">
	// 			<input type="checkbox" name="subjects[]" class="form-check-input subjects">
	// 			<label class="form-check-label" for="option1">'.$sub['subject'].'</label>
	// 		</div>';
	// 	}
	// endforeach;
	// $result['subHtml'] = $html;

	echo json_encode($result);
}

?>