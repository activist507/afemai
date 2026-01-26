<?php 
  include('../admin/config/db_connect.php');
  $result = array();

  // student registration to DB 
  if(isset($_POST['type']) && $_POST['type'] == 'saveTenant'){
    $ress = array();
    // <!-- student details -->
    $T_ID = $_POST['T_ID'];
    $T_Name = $_POST['T_Name'];
    $Next_Date = $_POST['Next_Date'];
    $T_Status = $_POST['T_Status'];
    $Phone = $_POST['Phone'];
    $H_Address = $_POST['H_Address'];
    $Owned_By = $_POST['Owned_By'];
    $Comment = $_POST['Comment'];
    $A_Payable = $_POST['A_Payable'];
    $A_Paid = $_POST['A_Paid'];        
    $Balance = $_POST['Balance'];
    $hidden_T_ID = $_POST['hidden_T_ID'];
    
    //ID determination
    $res = $conn->query("SELECT T_ID FROM raaid_rentage ORDER BY T_ID DESC LIMIT 1");
    if($res->num_rows > 0){
      $row = $res->fetch_object();
      $exist = $row->T_ID;
      $T_ID_GEN = (int)$exist+1;
    } else {
      $T_ID_GEN = '1001';
    }
    // ------------------Uploading image to the database ------Student_Image='$imageData',--------Student_Image='$imageData',------------//
    
    if($hidden_T_ID == '0'){
      $stmt=$conn->prepare("INSERT INTO raaid_rentage SET T_ID=?,T_Name=?,Next_Date=?,T_Status=?,Phone=?,H_Address=?,Owned_By=?,Comment=?, A_Payable=?, A_Paid=?,Balance=?");
      $stmt->bind_param("issssssssss",$T_ID_GEN,$T_Name,$Next_Date,$T_Status,$Phone,$H_Address,$Owned_By,$Comment,$A_Payable,$A_Paid,$Balance);
      $stmt->execute();
      $ress['msg'] = "$T_Name added as a tenant of $Owned_By";
    }  
    elseif($hidden_T_ID > 0){
      $stmt=$conn->prepare("UPDATE raaid_rentage SET T_Name=?,Next_Date=?,T_Status=?,Phone=?,H_Address=?,Owned_By=?,Comment=?, A_Payable=?, A_Paid=?,Balance=? WHERE T_ID=?");
      $stmt->bind_param("ssssssssssi",$T_Name,$Next_Date,$T_Status,$Phone,$H_Address,$Owned_By,$Comment,$A_Payable,$A_Paid,$Balance,$hidden_T_ID);
      $stmt->execute();
      $ress['msg'] = "$T_Name details updated successfully as a tenant of $Owned_By";
    }
    echo json_encode($ress);
  }

  if(isset($_POST['type']) && $_POST['type'] == 'getTenantDetails'){
    $T_ID = $_POST['T_ID'];
    $sql = $conn->query("SELECT * FROM raaid_rentage WHERE T_ID = '$T_ID'");
    
    if($sql->num_rows == 0){
      $result['msg'] = 'No Tenant with such ID';
      $result['query'] = 'false';
    } else {
      $tenant = $sql->fetch_object();
      $result['T_ID'] = $tenant->T_ID;
      $result['T_Name'] = $tenant->T_Name;
      $result['Next_Date'] = $tenant->Next_Date;
      $result['T_Status'] = $tenant->T_Status;
      $result['Phone'] = $tenant->Phone;
      $result['H_Address'] = $tenant->H_Address;
      $result['Owned_By'] = $tenant->Owned_By;
      $result['Comment'] = $tenant->Comment;
      $result['A_Payable'] = $tenant->A_Payable;
      $result['A_Paid'] = $tenant->A_Paid;
      $result['Balance'] = $tenant->Balance;
      $result['query'] = 'true';
    }
    echo json_encode($result);
  }


  //
  if(isset($_POST['type']) && $_POST['type'] == 'paginateTenant'){
    $html = '';
    $page = $_POST['page2']; //page if clicked
    $limit = $_POST['limit2']; //records per page
    $search = $_POST['search2']; //if search was included
    $offset = ($page - 1) * $limit;
    $today = date('Y-m-d');

    $resultUnprinted = $conn->query("SELECT COUNT(*) AS total FROM raaid_rentage WHERE (T_ID LIKE '%$search%' OR T_Name LIKE '%$search%' OR T_Status LIKE '%$search%' OR Owned_By LIKE '%$search%')")->fetch_assoc();
    $totalRecords = $resultUnprinted['total'];
    $totalPages = ceil($totalRecords / $limit);

    $raaid_rentage = $conn->query("SELECT * FROM raaid_rentage WHERE (T_ID LIKE '%$search%' OR T_Name LIKE '%$search%' OR T_Status LIKE '%$search%' OR Owned_By LIKE '%$search%') LIMIT $limit OFFSET $offset")->fetch_all(MYSQLI_ASSOC);
    if(count($raaid_rentage)>0){
      $totalPayable = 0;
      $totalPaid = 0;
      $totalBalance = 0;
      foreach($raaid_rentage as $tenant){
        $twoWeeksBefore = date('Y-m-d', strtotime($tenant['Next_Date'] . ' -2 weeks'));
        if($today >= $twoWeeksBefore ){
          $trClass = 'class="table-danger tenant small"';
        } else {
          $trClass = 'class="tenant small"';
        }
        $totalPayable += $tenant['A_Payable'];
        $totalPaid += $tenant['A_Paid'];
        $totalBalance += $tenant['Balance'];

        $html .= '<tr '.$trClass.' data-id="'.$tenant['T_ID'].'">
          <th scope="row">'.$tenant['T_ID'].'</th>
          <td class="text-nowrap">'.($tenant['T_Name']).'</td>
          <td class="text-center text-nowrap">'.($tenant['Next_Date']).'</td>
          <td class="text-center ">'.($tenant['T_Status']).'</td>
          <td class="text-center ">'.($tenant['Phone']).'</td>
          <td class="text-nowrap">'.$tenant['H_Address'].'</td>
          <td class="text-center">'.$tenant['Owned_By'].'</td>
          <td class="text-nowrap">'.$tenant['Comment'].'</td>
          <td class="text-center text-nowrap">'.number_format($tenant['A_Payable'] ?? 0).'</td>
          <td class="text-center text-nowrap">'.number_format($tenant['A_Paid'] ?? 0).'</td>
          <td class="text-center text-nowrap">'.number_format($tenant['Balance'] ?? 0).'</td>
          <td class="deleteTenant text-center" data-Nid="'.$tenant['T_ID'].'">
            <i class="bi bi-trash" style="color: red;"></i>
          </td>
        </tr>';
      }
      $html .= '<tr>
          <th scope="row"></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="fw-bold">'.number_format($totalPayable ?? 0).'</td>
          <td class="fw-bold">'.number_format($totalPaid ?? 0).'</td>
          <td class="fw-bold">'.number_format($totalBalance ?? 0).'</td>
          <td></td>
        </tr>';
    } else {
      $html = '<tr><td colspan="12" class="no-data">No records found.</td></tr>';
    }

    //Next ID determination
    $res = $conn->query("SELECT T_ID FROM raaid_rentage ORDER BY T_ID DESC LIMIT 1");
    if($res->num_rows > 0){
      $row = $res->fetch_object();
      $exist = $row->T_ID;
      $N_ID = (int)$exist+1;
    } else {
      $N_ID = '1001';
    }

    $result['html'] = $html;
    $result['N_ID'] = $N_ID;
    $result['totalPages'] = $totalPages;
    $result['currentPage'] = $page;
    echo json_encode($result);
  }

  //deleting a question   
  if(isset($_POST['type']) && $_POST['type'] == 'deleteTenant'){
    $qid = $_POST['ID'];
    $sqlins = $conn->query("DELETE FROM raaid_rentage WHERE T_ID='$qid'");
    $result['msg'] = 'Tenant deleted Successfully';
    $result['status'] = 'success';

    echo json_encode($result);
  }

?>