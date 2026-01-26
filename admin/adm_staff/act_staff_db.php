<?php 
include('../../admin/config/db_connect.php');
$result = array();

if(isset($_POST['type']) && $_POST['type'] == 'paginateStud'){
    $html = '';
    $page = $_POST['page']; //page if clicked
    $limit = $_POST['limit']; //records per page
    $search = $_POST['search']; //if search was included
    $offset = ($page - 1) * $limit;

    $resultSales = $conn->query("SELECT COUNT(*) AS total FROM staff_records WHERE (Staff_ID LIKE '%$search%' OR Fullname LIKE '%$search%' OR Branch LIKE '%$search%' ) AND Staff_Status = 'Active'")->fetch_assoc();
    $totalRecords = $resultSales['total'];
    $totalPages = ceil($totalRecords / $limit);

    $staffs = $conn->query("SELECT * FROM staff_records WHERE (Staff_ID LIKE '%$search%' OR Fullname LIKE '%$search%' OR Branch LIKE '%$search%') AND Staff_Status = 'Active' ORDER BY Staff_ID ASC LIMIT $limit OFFSET $offset");
    $staff_records = fetch_all_assoc($staffs);
    if(count($staff_records)>0){
      foreach($staff_records as $staff_rec){
        $html .= '
        <tr>
										<td scope="col" nowrap="nowrap">'.$staff_rec["Staff_ID"].'</td>
										<td scope="col" nowrap="nowrap">'. $staff_rec["Fullname"].'</td>
										<td scope="col" nowrap="nowrap">'. $staff_rec["Branch"].'</td>
<td scope="col" nowrap="nowrap">'. number_format($staff_rec["Total_Salary"]).'</td>
<td scope="col" nowrap="nowrap">'. number_format($staff_rec["G_Bal"]).'</td>
<td scope="col" nowrap="nowrap">'. number_format($staff_rec["S_Bal"]).'</td>
<td scope="col" nowrap="nowrap">'.number_format($staff_rec['Loan_Bal']).'</td>
<td scope="col" nowrap="nowrap">'.($staff_rec['Acc_Number']).'
</td>
<td scope="col" nowrap="nowrap">'.($staff_rec['Bank_Name']).'
</td>
<td scope="col" nowrap="nowrap">'.number_format($staff_rec['Amt_Paid']).'
</td>
<td scope="col" nowrap="nowrap">
	'. number_format($staff_rec['Balance']).'</td>
<td>
	<div style="display: flex; align-items:center;">
		<a href="./?editStaff&ID='.$staff_rec["Staff_ID"].'" class="btn btn-link p-0">
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