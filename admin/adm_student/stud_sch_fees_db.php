<?php 
  include('../../admin/config/db_connect.php');
  $result = array();

if(isset($_POST['type']) && $_POST['type'] == 'paginateStud'){
  $html = '';
  $page = $_POST['page']; 
  $limit = $_POST['limit']; 
  $branch_ = $_POST['branch_']; 
  $term = $_POST['term']; 
  $session = $_POST['session']; 
  $search = $_POST['search']; 
  $Date_ = $_POST['Date_'];
  $offset = ($page - 1) * $limit;
  

  $resultSales = $conn->query("SELECT COUNT(ID) AS total FROM student_payment WHERE (Student_ID LIKE '%$search%' OR Fullnames LIKE '%$search%' OR Student_Class LIKE '%$search%') AND Session='$session' AND Branch='$branch_' AND Term='$term' AND Date_='$Date_'")->fetch_assoc();
  $totalRecords = $resultSales['total'];
  $totalPages = ceil($totalRecords / $limit);
  $cash = 0;
  $bank = 0;

  $student_records = $conn->query("SELECT ID,Student_ID,Fullnames,Student_Class,Phone_Number,Pay_Option,Total_Fees,Gen_Discount,Scholarship_Fee,Amt_Payable,Amt_Paid,Balance,Bank_Ref,SmsStatus FROM student_payment WHERE (Student_ID LIKE '%$search%' OR Fullnames LIKE '%$search%' OR Student_Class LIKE '%$search%' ) AND Session='$session' AND Branch='$branch_' AND Term='$term' AND Date_='$Date_' ORDER BY ID DESC LIMIT $limit OFFSET $offset")->fetch_all(MYSQLI_ASSOC);
  if(count($student_records)>0){
    foreach($student_records as $stud_rec){
      if($stud_rec["Pay_Option"] == 'CASH'){
        $cash += $stud_rec["Amt_Paid"];
      }

      if($stud_rec["Pay_Option"] == 'TELLER'){
        $bank += $stud_rec["Amt_Paid"];
      }
      $html .= '
      <tr>
        <td scope="col" class="text-nowrap">'.$stud_rec["Student_ID"].'</td>
        <td scope="col" class="text-nowrap">'. $stud_rec["Fullnames"].'</td>
		    <td scope="col" class="text-nowrap text-center">'. $stud_rec["Student_Class"].'</td>
		    <td scope="col" class="text-nowrap">'. $stud_rec["Phone_Number"].'</td>
        <td scope="col" class="text-nowrap text-center">'. $stud_rec["Pay_Option"].'</td>
        <td scope="col" class="text-nowrap text-center">'. number_format($stud_rec["Total_Fees"]).'</td>
        <td scope="col" class="text-nowrap text-center">'. number_format($stud_rec["Gen_Discount"] + $stud_rec['Scholarship_Fee']).'</td>
        <td scope="col" class="text-nowrap text-center">'. number_format($stud_rec["Amt_Payable"]).'</td>
        <td scope="col" class="text-nowrap text-center">'. number_format($stud_rec["Amt_Paid"]).'</td>
        <td scope="col" class="text-nowrap text-center">'. number_format($stud_rec["Balance"]).'</td>
        <td scope="col" class="text-nowrap text-center">'. ($stud_rec["Bank_Ref"]).'</td>
        <td scope="col" class="text-nowrap text-center">'. ($stud_rec["SmsStatus"]).'</td>
        <td class="text-center">
          <a class="btn text-danger deletePayment" data-deleteID="'.$stud_rec["ID"].'"> <i class="bi bi-trash"></i></a>
        </td>
      </tr>';
    }
  } else {
    $html = '<tr>
    <td colspan="13" class="no-data">No records found.</td>
    </tr>';
  }
  $result['html'] = $html;
  $result['totalPages'] = $totalPages;
  $result['currentPage'] = $page;
  $result['bank'] = number_format($bank);
  $result['cash'] = number_format($cash);
  $result['total'] = number_format($cash + $bank);
  echo json_encode($result);
}
// 
if(isset($_POST['type']) && $_POST['type'] == 'delete_from_payment'){
  $id = $_POST['deleteID'];
  $sql = $conn->query("DELETE FROM student_payment WHERE ID='$id'");
  if($sql){
    $msg = "Payment Deleted Successfully";
  } else {
    $msg = "Payment could not be deleted";
  }
  echo json_encode(["msg"=>$msg]);
}

  // get class list to send school fees sms: 
  if(isset($_POST['type']) && $_POST['type'] == 'getListToSendReceipt'){
    $branch_ = $_POST['branch_'];
    $term = $_POST['term'];
    $session = $_POST['session'];
    $Date_ = $_POST['Date_'];
    $sql = $conn->query("SELECT ID,Student_ID,Fullnames,Total_Fees,Gen_Discount,Scholarship_Fee,Amt_Payable,Amt_Paid,Balance,Phone_Number,Date_ FROM student_payment WHERE Branch='$branch_' AND Term='$term' AND Session='$session' AND Date_='$Date_' AND SmsStatus != 'Sent'");
    if($sql->num_rows == 0){
      $result['query'] = 'false';
    } else {
      $list = $sql->fetch_all(MYSQLI_ASSOC);
      $result['studentsList'] = $list;
      $result['query'] = 'true';
    }
    echo json_encode($result);
  }

  if(isset($_POST['type']) && $_POST['type'] == 'sendStdFeesSms'){
    $receivers = $_POST['phone'];
    $msg = $_POST['msg'];
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://my.kudisms.net/api/sms',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        // CURLOPT_POSTFIELDS => array('token' => 'D3VjP0MwWFQqZRp5A9erdEXk16TJH2zlU7sbfYSiuBLtcxNahnmCIOo48GvKgy','senderID' => 'HiraInfo','recipients' => $receivers,'message' => $msg,'gateway' => '2'),
        CURLOPT_POSTFIELDS => array('token' => 'MLY9FhORcf2BzkU5ZKe6mnTXIudWsAHqCEVNglDSGtwoxa0p3J4iQjy8v7P1br','senderID' => 'AfemaiInfo','recipients' => $receivers,'message' => $msg,'gateway' => '2'),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    echo $response;
    // echo json_encode(["msg"=>$receivers]);
  }

  // 
  if(isset($_POST['type']) && $_POST['type'] == 'updateStatus'){
    $id = $_POST['id'];
    $sql = $conn->query("UPDATE student_payment SET SmsStatus='Sent' WHERE ID='$id'");
    echo json_encode(["msg"=>"Status Updated successfully"]);
  }

  //Clear Recipt
  if(isset($_POST['type']) && $_POST['type'] == 'clearReceipt'){
    $branch_ = $_POST['branch_'];
    $term = $_POST['term'];
    $session = $_POST['session'];
    $Date_ = $_POST['Date_'];
    $sql = $conn->query("UPDATE student_payment SET SmsStatus='' WHERE Branch='$branch_' AND Term='$term' AND Session='$session' AND Date_='$Date_' AND SmsStatus = 'Sent'");
    echo json_encode(["msg"=>"Receipt Cleared successfully"]);
  }
