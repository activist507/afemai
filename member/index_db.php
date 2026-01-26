<?php 
  include('../admin/config/db_connect.php');
  $result = array();

  // paginate member 
  if(isset($_POST['type']) && $_POST['type'] == 'paginateMember'){
    $html = '';
    $page = $_POST['page']; 
    $limit = $_POST['limit']; 
    $search = $_POST['search']; 
    $offset = ($page - 1) * $limit;

    $resultSales = $conn->query("SELECT COUNT(*) AS total FROM idea_member WHERE mem_id LIKE '%$search%' OR Fullname LIKE '%$search%' OR contact LIKE '%$search%'")->fetch_assoc();
    $totalRecords = $resultSales['total'];
    $totalPages = ceil($totalRecords / $limit);

    $idea_member = $conn->query("SELECT * FROM idea_member WHERE mem_id LIKE '%$search%' OR Fullname LIKE '%$search%' OR contact LIKE '%$search%' ORDER BY id DESC LIMIT $limit OFFSET $offset")->fetch_all(MYSQLI_ASSOC);
    if(count($idea_member)>0){
      foreach($idea_member as $member){
        $html .= '
        <tr class="tr_qst" data-id_qst="'.$member["mem_id"].'" data-bs-toggle="tooltip"
        data-bs-placement="top" title="Double click this row to copy Member ID">
        <th scope="row" nowrap="nowrap">'.$member["mem_id"].'</th>
        <td class="text-nowrap">'.$member["Fullname"].'</td>
        <td class="text-nowrap text-center">'.$member["contact"].'</td>
        
        <td class="text-nowrap text-center">'.$member["bank_account"].'</td>
        <td class="text-nowrap text-center">'.$member["bank_name"].'</td>
        <td class="text-nowrap text-center">'.number_format($member["month_due"]).'</td>
        <td class="text-nowrap text-center">'.number_format($member["total_paid"]).'</td>
        <td class="text-nowrap text-center">'.$member["L_month"].'</td>
        <td class="text-nowrap text-center">'.$member["L_year"].'</td>
        <td class="text-nowrap text-center">'.number_format($member["shares"]).'</td>
        </tr>';
      }
    } else {
    $html = '<tr>
      <td colspan="9" class="no-data">No records found.</td>
    </tr>';
    }
    $result['html'] = $html;
    $result['totalPages'] = $totalPages;
    $result['currentPage'] = $page;
    echo json_encode($result);
  }