<?php 
include('../../admin/config/db_connect.php');
$result = array();

if(isset($_POST['type']) && $_POST['type'] == 'paginateStud'){
  $html = '';
  $page = $_POST['page']; //page if clicked
  $limit = $_POST['limit']; //records per page
  $search = $_POST['search']; //if search was included
  $offset = ($page - 1) * $limit;

  $resultSales = $conn->query("SELECT COUNT(*) AS total FROM student_records WHERE (Student_ID LIKE '%$search%' OR Fullnames LIKE '%$search%' OR Student_Class LIKE '%$search%' OR Branch LIKE '%$search%') AND Current_Status = 'Active'")->fetch_assoc();
  $totalRecords = $resultSales['total'];
  $totalPages = ceil($totalRecords / $limit);

  $resultRow = $conn->query("SELECT * FROM student_records WHERE (Student_ID LIKE '%$search%' OR Fullnames LIKE '%$search%' OR Student_Class LIKE '%$search%' OR Branch LIKE '%$search%') AND Current_Status = 'Active' ORDER BY id DESC LIMIT $limit OFFSET $offset");
  $student_records = fetch_all_assoc($resultRow);
  if(count($student_records)>0){
    foreach($student_records as $stud_rec){
      $html .= '
      <tr>
        <td scope="col" nowrap="nowrap">'.$stud_rec["Student_ID"].'</td>
        <td scope="col" nowrap="nowrap">'. $stud_rec["Fullnames"].'</td>
        <td scope="col" nowrap="nowrap">'. $stud_rec["Student_Class"].'</td>
        <td scope="col" nowrap="nowrap">'. $stud_rec["new_plain_pass"].'</td>
        <td scope="col" nowrap="nowrap">'. $stud_rec["Branch"].'</td>
        <td scope="col" nowrap="nowrap">'.$stud_rec['Phone_Number'].'</td>
        <td scope="col" nowrap="nowrap">'.number_format($stud_rec['Total_Sch_Fee']).'
        </td>
        <td scope="col" nowrap="nowrap">'.number_format($stud_rec['Gen_Discount']).'
        </td>
        <td scope="col" nowrap="nowrap">'.number_format($stud_rec['Amount_Payable']).'
        </td>
        <td scope="col" nowrap="nowrap">'.number_format($stud_rec['Amount_Paid']).'
        </td>
        <td scope="col" nowrap="nowrap">
          '. number_format($stud_rec['Current_Balance']).'</td>
        <td>
          <div style="display: flex; align-items:center;">
            <a href="./?editStudent&ID='.$stud_rec["Student_ID"].'" class="btn btn-link p-0">
            </a>
          </div>
        </td>
      </tr>';
    }
  } else {
    $html = '<tr>
    <td colspan="11" class="no-data">No records found.</td>
    </tr>';
  }
  $result['html'] = $html;
  $result['totalPages'] = $totalPages;
  $result['currentPage'] = $page;
  echo json_encode($result);
}

?>