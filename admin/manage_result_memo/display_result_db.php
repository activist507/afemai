<?php 
include('../../admin/config/db_connect.php');
$result = array();

if(isset($_POST['type']) && $_POST['type'] == 'paginateStud'){
  $html = '';
  $page = $_POST['page']; 
  $limit = $_POST['limit']; 
  $branch_ = $_POST['branch_']; 
  $class_ = $_POST['class_']; 
  $term = $_POST['term']; 
  $session = $_POST['session']; 
  $search = $_POST['search']; 
  $offset = ($page - 1) * $limit;
  

  $resultSales = $conn->query("SELECT COUNT(id) AS total FROM memorization_scores_total WHERE (student_id LIKE '%$search%' OR fullname LIKE '%$search%') AND class_id = '$class_' AND year ='$session' AND branch='$branch_' AND term='$term'")->fetch_assoc();
  $totalRecords = $resultSales['total'];
  $totalPages = ceil($totalRecords / $limit);

  $student_records = $conn->query("SELECT id,student_id,fullname,total_score,class_pos FROM memorization_scores_total WHERE (student_id LIKE '%$search%' OR fullname LIKE '%$search%') AND class_id = '$class_' AND year ='$session' AND branch='$branch_' AND term='$term' ORDER BY total_score DESC LIMIT $limit OFFSET $offset")->fetch_all(MYSQLI_ASSOC);
  if(count($student_records)>0){
    foreach($student_records as $stud_rec){
      $html .= '
      <tr>
        <td scope="col" class="text-nowrap">'.$stud_rec["student_id"].'</td>
        <td scope="col" class="text-nowrap">'. $stud_rec["fullname"].'</td>
        <td scope="col" class="text-nowrap text-center">'. $stud_rec["total_score"].'</td>
		    <td scope="col" class="text-nowrap text-center">'. $stud_rec["class_pos"].'</td>
      </tr>';
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