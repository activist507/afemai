<?php 
include('../../admin/config/db_connect.php');
$result = array();

if(isset($_POST['type']) && $_POST['type'] == 'paginateStud'){
  $html = '';
  $page = $_POST['page']; 
  $limit = $_POST['limit']; 
  $branch_ = $_POST['branch_']; 
  $class_ = $_POST['class_']; 
  $table = $_POST['term']; 
  $session = $_POST['session']; 
  $search = $_POST['search']; 
  $offset = ($page - 1) * $limit;
  

  $resultSales = $conn->query("SELECT COUNT(ID) AS total FROM {$table} WHERE (Student_ID LIKE '%$search%' OR Fullname LIKE '%$search%') AND Class = '$class_' AND C_Session='$session' AND Branch='$branch_'")->fetch_assoc();
  $totalRecords = $resultSales['total'];
  $totalPages = ceil($totalRecords / $limit);

  $student_records = $conn->query("SELECT ID,Student_ID,Fullname,T_Score,Termly_Grade,Position_,Core_Subjects FROM {$table} WHERE (Student_ID LIKE '%$search%' OR Fullname LIKE '%$search%') AND Class = '$class_' AND C_Session='$session' AND Branch='$branch_' ORDER BY T_Score DESC LIMIT $limit OFFSET $offset")->fetch_all(MYSQLI_ASSOC);
  if(count($student_records)>0){
    foreach($student_records as $stud_rec){
      $html .= '
      <tr>
        <td scope="col" class="text-nowrap">'.$stud_rec["Student_ID"].'</td>
        <td scope="col" class="text-nowrap">'. $stud_rec["Fullname"].'</td>
		<td scope="col" class="text-nowrap text-center">'. $stud_rec["Position_"].'</td>
		<td scope="col" class="text-nowrap">'. $stud_rec["Termly_Grade"].'</td>
        <td scope="col" class="text-nowrap text-center">'. $stud_rec["T_Score"].'</td>
        <td scope="col" class="text-nowrap text-center">'. $stud_rec["Core_Subjects"].'</td>
      </tr>';
//   <td>
//       <div style="display: flex; align-items:center;">
//         <a href="./?editStudent&ID='.$stud_rec["Student_ID"].'" class="btn btn-link p-0">
//         </a>
//       </div>
//     </td>
    }
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

?>