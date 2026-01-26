<?php 
include('../../admin/config/db_connect.php');
$result = array();

  //submitting member registration form 
  if(isset($_POST['type']) && $_POST['type'] == 'completeReg'){

    //--------------------//
    $membership_id = $_POST['membership_id'];
    $member_name = $_POST['member_name'];
    $member_contact = $_POST['member_contact'];
    $member_comment = $_POST['member_comment'];
    $member_monthly_due = $_POST['member_monthly_due'];
    $member_payment = $_POST['member_payment'];
    $total_paid = $_POST['total_paid'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $role = $_POST['Role'];
    $bank_account = $_POST['bank_account'];
    $bank_name = $_POST['bank_name'];

    // ------------------creating digit for code ----------DESC----------------//
    $lastquestsql = $conn->query("SELECT mem_id FROM idea_member ORDER BY mem_id ASC LIMIT 1");
    if($lastquestsql->num_rows > 0){
      $lastquest = $lastquestsql->fetch_object();
      $lastID = $lastquest->mem_id;
      $digi = substr($lastID, 0, 4);
      $digit = (int)$digi + 1;
      $mem_id = $digit;
    } else {
      $mem_id = '1001';
    }

    // ------------------Uploading image to folder --------------------------//
    if(isset($_FILES['file'])){
      $file = $_FILES['file'];
      $pdf = $file["name"];
      $tempname = $file["tmp_name"];
      $ext = substr($pdf, strrpos($pdf, '.', -1), strlen($pdf));
      $nam = $mem_id.$ext;
      $folder = "image/".$nam;
      move_uploaded_file($tempname, $folder);   
    }
    
    if($membership_id == 0){
      $sqlins = $conn->prepare("INSERT INTO idea_member SET mem_id=?,Fullname=?,contact=?,comment=?,month_due=?,total_paid=?,L_month=?,L_year=?,img=?,role=?,bank_account=?,bank_name=?");
      $sqlins->bind_param("isssiisissis",$mem_id,$member_name,$member_contact,$member_comment,$member_monthly_due,$member_payment,$month,$year,$nam,$role,$bank_account,$bank_name);
      $sqlins->execute();
      $last_id = $mem_id;
      $msg = 'Member registered successfully';
    } else {
      $sql = "UPDATE idea_member SET Fullname=?,contact=?,comment=?,month_due=?,total_paid=total_paid+?,L_month=?,L_year=?,role=?,bank_account=?,bank_name=?";
      $params = [$member_name,$member_contact,$member_comment,$member_monthly_due,$member_payment,$month,$year,$role,$bank_account,$bank_name];
      $types = "sssiisisis";
      if(!empty($tempname)) {
        $sql .= ", img=?";
        $params[] = $nam;
        $types .= "s";
      }
      $sql .= " WHERE mem_id=?"; 
      $params[] = $membership_id; 
      $types .= "i";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param($types, ...$params);
      $stmt->execute();
      $last_id = $membership_id;

      $msg = 'Member updated successfully';
    }

    // ======================Inserting into idea_mem_pay 
    if($member_payment > 0){
      $sqlins = $conn->prepare("INSERT INTO idea_mem_pay SET mem_id=?,month_due=?,total_paid=?,month=?,year=?");
      $sqlins->bind_param("iiisi",$last_id,$member_monthly_due,$member_payment,$month,$year);
      $sqlins->execute();
    }
    // =====================================
    $result['msg'] = $msg;
    echo json_encode($result);
  }

  //getting member details 
  if(isset($_POST['type']) && $_POST['type'] == 'getMember'){
    $membership_id = $_POST['membership_id'];
    $idea_member = $conn->query("SELECT * FROM idea_member WHERE mem_id ='$membership_id'");
    if($idea_member->num_rows == 0){
      $result['msg'] = 'No Member with such CODE-'.$membership_id;
      $result['query'] = 'false';
    } else {
      $member = $idea_member->fetch_object();

      $result['membership_id'] = $member->mem_id;
      $result['member_name'] = $member->Fullname;
      $result['member_contact'] = $member->contact;
      $result['member_comment'] = $member->comment;
      $result['member_monthly_due'] = $member->month_due;
      $result['role'] = $member->role;
      $result['bank_account'] = $member->bank_account;
      $result['bank_name'] = $member->bank_name;
      $result['total_paid'] = $member->total_paid;
      $result['month'] = $member->L_month;
      $result['year'] = $member->L_year;
      $result['img'] = 'idea_member/image/'.$member->img;
      $result['query'] = 'true';
    }
    
    echo json_encode($result);
  }

  //deleting a member
  if(isset($_POST['type']) && $_POST['type'] == 'delete_member'){
    $mID = $_POST['mID'];
    $idea_member = $conn->query("SELECT img FROM idea_member WHERE id ='$mID'");
    $member = $idea_member->fetch_object();

    $file = 'image/'.$member->img;;
    if(file_exists($file)){
      if(unlink($file)){
        clearstatcache();
        $sqlins = $conn->query("DELETE FROM idea_member WHERE id='$mID'");
        $result['msg'] = 'member deleted Successfully along with its image';
        $result['status'] = 'success';
      }
    } elseif(!file_exists($file)){
      $sqlins = $conn->query("DELETE FROM idea_member WHERE id='$mID'");
      $result['msg'] = 'Member deleted Successfully';
      $result['status'] = 'success';
    }
    else{
      $result['msg'] = 'There was an error deleting the member';
      $result['status'] = 'failed';
    }

    echo json_encode($result);
  }

  //reset_password
  if(isset($_POST['type']) && $_POST['type'] == 'reset_password'){
    $mID = $_POST['mID'];
    $idea_member = $conn->query("UPDATE idea_member SET password ='@@@aimonomie&&&&&' WHERE id ='$mID'");

    $result['msg'] = 'Member Password Reset Successfully';
    $result['status'] = 'success';
    echo json_encode($result);
  }

  //not working yet
  // if(isset($_POST['type']) && $_POST['type'] == 'delete_all_exam'){
  //   $session = $_POST['session'];
  //   $term = $_POST['term'];
  //   $questions = $conn->query("SELECT id,question_pdf FROM questions WHERE exam_type ='Exam' OR exam_type ='Theory' AND session = '$session' AND term='$term'")->fetch_all(MYSQLI_ASSOC);
  //   if(count($questions) > 0){
  //     foreach($questions as $question){
  //       $id = $question["id"];
  //       $pdf = $question["question_pdf"];
  //       $file = '../../storege/'.$pdf;
  //       if(file_exists($file)){
  //         if(unlink($file)){
  //           clearstatcache();
  //           $sqlins = $conn->query("DELETE FROM questions WHERE id='$id'");
  //         }
  //       } elseif(!file_exists($file)){
  //         $sqlins = $conn->query("DELETE FROM questions WHERE id='$id'");
  //       }
  //     }

  //     $result['msg'] = count($questions).' Exam questions has been deleted';
  //     $result['status'] = 'success';
  //   } else {
  //     $result['msg'] = 'The session or term selected does not exist';
  //     $result['status'] = 'success';
  //   }
  //   echo json_encode($result);
  // }

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

    $idea_member = $conn->query("SELECT * FROM idea_member WHERE mem_id LIKE '%$search%' OR Fullname LIKE '%$search%' OR contact LIKE '%$search%' ORDER BY id ASC LIMIT $limit OFFSET $offset")->fetch_all(MYSQLI_ASSOC);
    if(count($idea_member)>0){
      foreach($idea_member as $member){
        $html .= '
        <tr class="tr_qst" data-id_qst="'.$member["mem_id"].'" data-bs-toggle="tooltip"
        data-bs-placement="top" title="Double click this row to copy Member ID">
        <th scope="row" nowrap="nowrap">'.$member["mem_id"].'</th>
        <td nowrap="nowrap">'.$member["Fullname"].'</td>
        <td nowrap="nowrap">'.$member["contact"].'</td>
        <td nowrap="nowrap">'.$member["role"].'</td>
        <td nowrap="nowrap">'.$member["bank_account"].'</td>
        <td nowrap="nowrap">'.$member["bank_name"].'</td>
        <td nowrap="nowrap">'.number_format($member["month_due"]).'</td>
        <td nowrap="nowrap">'.number_format($member["total_paid"]).'</td>
        <td nowrap="nowrap">'.$member["L_month"].'</td>
        <td nowrap="nowrap">'.$member["L_year"].'</td>
        <td nowrap="nowrap">'.number_format($member["shares"]).'</td>
        <td nowrap="nowrap">
          <div class="text-center">
            &nbsp;&nbsp;
            <a href="#" class="btn btn-link p-0 clearPass" data-qid="'.$member['id'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Password">
              <span class="text-500 text-primary bi bi-pencil-square"></span>
            </a>
            &nbsp;&nbsp;
            <a href="#" class="btn btn-link p-0 deleteQst" data-qid="'.$member['id'].'">
              <span class="text-500 text-danger bi bi-trash"></span>
            </a>
          </div>
        </td>
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

  if(isset($_POST['type']) && $_POST['type'] == 'calculateShares'){
    $profit = $_POST['profit'];
    $total_revenue = $conn->query("SELECT SUM(total_paid) AS overall FROM idea_member")->fetch_assoc()['overall'];
    $allmembers = $conn->query("SELECT mem_id,total_paid FROM idea_member")->fetch_all(MYSQLI_ASSOC);
    foreach($allmembers as $member){
      $mem_id = $member['mem_id'];
      $rate = round($member['total_paid']/$total_revenue,2);
      $share = ceil($rate * $profit);
      $sql = $conn->query("UPDATE idea_member SET shares='$share' WHERE mem_id='$mem_id'");
    }
    echo json_encode(["msg"=>"Shares Calculated successfully"]);
  }
?>