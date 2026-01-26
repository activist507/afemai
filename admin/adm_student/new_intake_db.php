<?php 
  include('../../admin/config/db_connect.php');
  $result = array();
    
  //valid
  if(isset($_POST['type']) && $_POST['type'] == 'getClassFromSection'){
      $html = '<option value="0"></option>';
      $sect = $_POST['section'];
      $term = $_POST['term'];
      $branch = $_POST['branch'];
      $sqlclass = $conn->query("SELECT * FROM cbt_class WHERE section = '$sect'");
      while($class = $sqlclass->fetch_object()){
        $html .= '<option value="'.$class->class.'">'.$class->class.'</option>';
      }
      $sqlfeesDeter = $conn->query("SELECT * FROM fees_determination WHERE Term = '$term' AND Branch ='$branch'");
      $feesDeter = $sqlfeesDeter->fetch_object();
      if($sect == 'Nursery'){
        $result['tution_fee'] = $feesDeter->Nur1;
      } elseif($sect == 'Primary'){
        $result['tution_fee'] = $feesDeter->Pry1;
      } elseif($sect == 'Junior Sec'){
        $result['tution_fee'] = $feesDeter->Jss1;
      } elseif($sect == 'Senior Sec') {
        $result['tution_fee'] = $feesDeter->Ss1;
      } else {
        $result['tution_fee'] = 0;
      }
      $result['html'] = $html;
      echo json_encode($result);
  }

  // student registration to DB 
  if(isset($_POST['type']) && $_POST['type'] == 'submitStdReg'){
    $ress = array();
    // <!-- student details -->
    $Student_ID = $_POST['Student_ID'];
    $Fullnames = $_POST['Fullnames'];
    $std_gender = $_POST['std_gender'];
    $std_dob = $_POST['std_dob'];
    $std_Session = $_POST['std_Session'];
    $Std_Term = $_POST['Std_Term'];
    $std_section = $_POST['std_section'];
    $std_class = $_POST['std_class'];
    $std_branch = $_POST['std_branch'];
    $Std_parent = $_POST['Std_parent'];        
    $std_phone = $_POST['std_phone'];
    $Std_address = $_POST['Std_address'];
    $std_comment = $_POST['std_comment'];
    $total_fee = $_POST['total_fee'];
    $discount = intVal($_POST['discount']) ?? 0;
    $paid = intVal($_POST['paid']) ?? 0;
    // $payable = $_POST['Balance'];
    $pay_option = $_POST['pay_option'];
    $bank_name = $_POST['bank_name'];
    $date_paid = $_POST['date_paid'];
    $method = $_POST['method'];
    $created_by = $_POST['created_by'];
    $date_adm = date('Y-m-d h:i:s');
    
    //ID determination
    $res = $conn->query("SELECT * FROM cbt_new_intake ORDER BY intake_id DESC LIMIT 1");
    if($res->num_rows > 0){
      $row = $res->fetch_object();
      $exist = $row->intake_id;
      $std_id = (int)$exist+1;
    } else {
      $std_id = '101';
    }
    // ------------------Uploading image to the database ------Student_Image='$imageData',--------Student_Image='$imageData',------------//
    
    if($method == 'Submit'){
      $Balance = $total_fee - $discount - $paid;
      $payable = $total_fee - $discount;
      // student registered with image
      if(isset($_FILES['image'])){
        $sqx=$conn->query("INSERT INTO cbt_new_intake SET intake_id='$std_id',Fullnames='$Fullnames',sex='$std_gender',dob='$std_dob',created_by='$created_by',
        date_adm='$date_adm',term='$Std_Term',section_adm='$std_section', class_adm='$std_class', parent_name='$Std_parent',phone='$std_phone',
        address='$Std_address',comment='$std_comment',total_fee='$total_fee',payable='$payable',discount='$discount', balance='$Balance',pay_option='$pay_option',bank_name='$bank_name',date_paid='$date_paid',paid='$paid',Branch='$std_branch',session='$std_Session'");


        if(isset($_FILES['image'])){
          $imageData = file_get_contents($_FILES['image']['tmp_name']);
          $file = $_FILES['image'];
          $img = $file["name"];
          $tempname = $file["tmp_name"];
          $ext = substr($img, strrpos($img, '.', -1), strlen($img));
          $nam = $std_id.$ext;
          $folder = "../../storege/intake/".$nam;
          move_uploaded_file($tempname, $folder); 
        }

        if($sqx){
          $stmt = $conn->prepare("UPDATE cbt_new_intake SET image = ?,folder='$folder' WHERE intake_id = ?");
          $stmt->bind_param("ss",$imageData,$std_id);
          $stmt->execute();

          $ress['msg'] = 'Registered Successfully';
          $ress['lastID'] = $std_id;
        } else {
          $ress['msg'] = 'Error. '.$conn->error;
          $ress['lastID'] = $std_id;
        }
      } else {
        // student registered without image
        $sqx=$conn->query("INSERT INTO cbt_new_intake SET intake_id='$std_id', Fullnames='$Fullnames',sex='$std_gender', dob='$std_dob',created_by='$created_by',
        date_adm='$date_adm', term='$Std_Term',section_adm='$std_section', class_adm='$std_class', parent_name='$Std_parent',
        phone='$std_phone',address='$Std_address',comment='$std_comment',total_fee='$total_fee',payable='$payable',discount='$discount', balance='$Balance',paid='$paid',
        Branch='$std_branch',session='$std_Session'");

        if($sqx){
          $ress['msg'] = 'Registered Successfully';
          $ress['lastID'] = $std_id;
        } else {
          $ress['msg'] = 'Registration Error.';
          $ress['lastID'] = $std_id;
        }
      }
    }  
    elseif($method == 'Update'){
      $history = $conn->query("SELECT total_fee,payable,discount,paid FROM cbt_new_intake WHERE intake_id='$Student_ID'")->fetch_object();
      $updDis = $history->discount + $discount;
      $updPaid = $history->paid + $paid;
      $updPayable = $total_fee - $updDis;
      $updBal = $updPayable - $updPaid;
      // student updated with image
      if(isset($_FILES['image'])){

        $sqx=$conn->query("UPDATE cbt_new_intake SET Fullnames='$Fullnames',sex='$std_gender', dob='$std_dob',
        date_adm='$date_adm', term='$Std_Term',section_adm='$std_section', class_adm='$std_class', parent_name='$Std_parent',
        phone='$std_phone',address='$Std_address',comment='$std_comment',created_by='$created_by',
        payable='$updPayable',discount='$updDis',balance='$updBal',pay_option='$pay_option',bank_name='$bank_name',
        date_paid='$date_paid',paid='$updPaid',Branch='$std_branch',session='$std_Session' WHERE intake_id='$Student_ID'");


        if(isset($_FILES['image'])){
          $imageData = file_get_contents($_FILES['image']['tmp_name']);
          
          $file = $_FILES['image'];
          $img = $file["name"];
          $tempname = $file["tmp_name"];
          $ext = substr($img, strrpos($img, '.', -1), strlen($img));
          $nam = $Student_ID.$ext;
          $folder = "../../storege/intake/".$nam;
          move_uploaded_file($tempname, $folder); 
        }

        if($sqx){
          $stmt = $conn->prepare("UPDATE cbt_new_intake SET image = ?,folder='$folder' WHERE intake_id = ?");
          $stmt->bind_param("ss",$imageData,$Student_ID);
          $stmt->execute();

          $ress['msg'] = 'Details Updated Successfully.';
          $ress['lastID'] = $Student_ID;
        } else {
          $ress['msg'] = 'Update Error for file.';
          $ress['lastID'] = $Student_ID;
        }

      } else {
        // student updated without image
        $sqx=$conn->query("UPDATE cbt_new_intake SET Fullnames='$Fullnames',sex='$std_gender', dob='$std_dob',created_by='$created_by',
        date_adm='$date_adm', term='$Std_Term',section_adm='$std_section', class_adm='$std_class', parent_name='$Std_parent',
        phone='$std_phone',address='$Std_address',comment='$std_comment',payable='$updPayable',
        discount='$updDis',balance='$updBal',pay_option='$pay_option',bank_name='$bank_name',
        date_paid='$date_paid',paid='$updPaid',Branch='$std_branch',session='$std_Session' WHERE intake_id='$Student_ID'");

        if($sqx){
          $ress['msg'] = 'Details Updated Successfully.';
          $ress['lastID'] = $std_id;
        } else {
          $ress['msg'] = 'Update Error without file.';
          $ress['lastID'] = $std_id;
        }
      } 
    }
    echo json_encode($ress);
  }

  //submit pay history and update students_records
  if(isset($_POST['type']) && $_POST['type'] == 'submitPayHistory'){
    $Student_ID = $_POST['Student_ID'];
    $Fullnames = $_POST['Fullnames'];
    $std_class = $_POST['std_class'];
    $std_branch = $_POST['std_branch'];
    $std_comment = $_POST['std_comment'];

    $total_fee = $_POST['total_fee'];
    $scholarship = $_POST['scholarship'];
    $discount = $_POST['discount'];
    $amt_payable = $_POST['amt_payable'];
    $amt_paid = $_POST['amt_paid'];
    $Balance = $_POST['Balance'];

    $pay_option = $_POST['pay_option'];
    $bank_name = $_POST['bank_name'];
    $date_paid = $_POST['date_paid'];
    $created_by = $_POST['created_by'];

    $update=$conn->query("UPDATE student_records SET Total_Sch_Fee ='$total_fee',Scholarship_Fee ='$scholarship',
    Gen_Discount ='$discount',Amount_Payable ='$amt_payable',Amount_Paid='$amt_paid',Current_Balance='$Balance',General_Comments='$std_comment'
    WHERE Student_ID = '$Student_ID'");

    $result['msg'] = 'Student record updated Successfully';
    // $result['msg'] = $conn->error;
    $result['status'] = 'success';

    echo json_encode($result);
  }

  if(isset($_POST['type']) && $_POST['type'] == 'submitStudHistory'){
    $Student_ID = $_POST['studentID'];
    $Fullnames = $_POST['Fullnames'];
    $std_class = $_POST['std_class'];
    $std_branch = $_POST['std_branch'];
    $std_comment = $_POST['std_comment'];

    $total_fee = $_POST['total_fee'];
    $scholarship = $_POST['scholarship'];
    $discount = $_POST['discount'];
    $amt_payable = $_POST['amt_payable'];
    $amt_paid = $_POST['amt_paid'];
    $Balance = $_POST['Balance'];

    $pay_option = $_POST['pay_option'];
    $bank_name = $_POST['bank_name'];
    $date_paid = $_POST['date_paid'];
    $created_by = $_POST['created_by'];

    $sql=$conn->query("INSERT INTO cbt_stud_history SET studentID='$Student_ID',fullnames='$Fullnames',class='$std_class',branch='$std_branch',
      total_fee='$total_fee',scholarship='$scholarship',discount='$discount', amt_payable='$amt_payable',amt_paid='$amt_paid',Balance='$Balance',
    comment='$std_comment',pay_option='$pay_option',bank_name='$bank_name',date='$date_paid',created_by='$created_by'");

    $result['msg'] = 'Payment Made Successfully';
    // $result['msg'] = (isset($conn->error)) ?? $conn->error.' error' : 'Payment Made Successfully';
    $result['status'] = 'success';

    echo json_encode($result);
  }
    
  //get students details from database
  if(isset($_POST['type']) && $_POST['type'] == 'getStudentDetails'){
    $html = '<option value="0"></option>'; $html2 = '<option value="0"></option>'; $html3 = '<option value="0"></option>';
    $student_ID = $_POST['student_ID'];
    $sql = $conn->query("SELECT * FROM cbt_new_intake WHERE intake_id = '$student_ID'");
    
    if($sql->num_rows == 0){
      $result['msg'] = 'No student with such ID';
      $result['query'] = 'false';
    } else {
      $student = $sql->fetch_object();
      $result['Fullnames'] = $student->Fullnames;
      $result['dob'] = $student->dob;
      $result['sex'] = $student->sex;
      $result['parent_name'] = $student->parent_name;
      $result['phone'] = $student->phone;
      $result['session'] = $student->session;
      $result['term'] = $student->term;
      $result['Section'] = $student->section_adm;
      $result['Class'] = $student->class_adm;
      $clas_sect = $student->class_adm;
      $sect = $student->section_adm;

      // getting class html
      $sqlclass = $conn->query("SELECT * FROM cbt_class WHERE section = '$sect'");
      while($class = $sqlclass->fetch_object()){
        if($class->class ==  $clas_sect ){
          $html .= '<option value="'.$class->class.'" selected>'.$class->class.'</option>';
        } else {
          $html .= '<option value="'.$class->class.'">'.$class->class.'</option>';
        }    
      }  
      $result['Class_html'] = $html;
      // getting current section html
      $sqlSection = $conn->query("SELECT * FROM cbt_section");
      while($section = $sqlSection->fetch_object()){
        if($section->section ==  $student->section_adm ){
          $html3 .= '<option value="'.$section->section.'" selected>'.$section->section.'</option>';
        } else {
          $html3 .= '<option value="'.$section->section.'">'.$section->section.'</option>';
        } 
        }
      $result['curr_sect_html'] = $html3;
      // getting current section html
      $result['address'] = $student->address;
      $result['comment'] = $student->comment;
      $result['total_fee'] = $student->total_fee;
      $result['payable'] = $student->payable;
      $result['paid'] = $student->paid;
      $result['balance'] = $student->balance;
      $result['discount'] = $student->discount;
      $result['pay_option'] = $student->pay_option;
      $result['bank_name'] = $student->bank_name;
      $result['date_paid'] = $student->date_paid;
      $result['Branch'] = $student->Branch;
      $result['created_by'] = $student->created_by;
      $result['query'] = 'true';

      if($student->image != NULL){
        $imageData1 = base64_encode($student->image);
        $finfo = finfo_open();
        $mimeType2 = finfo_buffer($finfo, $imageData1, FILEINFO_MIME_TYPE);
        finfo_close($finfo);
        $result['imgSrc'] = 'data:'.$mimeType2.';base64,'.$imageData1;
      } else {
        $result['imgSrc'] = '../../storege/students/no_image.jpg';
      }
    }
    echo json_encode($result);
  }

  //get students details from database
  if(isset($_POST['type']) && $_POST['type'] == 'getStudentDetailsExist'){
    $html = ''; $html2 = ''; $html3 = ''; $html4 = ''; $html5 = '';
    $student_ID = $_POST['student_ID'];
    $pay_id = $_POST['pay_id'];
    $sql = $conn->query("SELECT * FROM student_records WHERE Student_ID = '$student_ID'");
    
    if($sql->num_rows == 0){
      $result['msg'] = 'No student with such ID';
      $result['query'] = 'false';
    } else {
      $student = $sql->fetch_object();
      $result['Fullnames'] = $student->Fullnames;
      $result['dob'] = $student->DOB;
      $result['sex'] = $student->Gender;
      $result['parent_name'] = $student->Parent_Name;
      $result['phone'] = $student->Phone_Number;
      $result['session'] = $student->Session_;
      $result['term'] = $student->Term_Adm;
      $result['Section'] = $student->Student_Section;
      $result['Class'] = $student->Student_Class;
      $clas_sect = $student->Student_Class;
      $sect = $student->Student_Section;

      // getting class html
      $sqlclass = $conn->query("SELECT * FROM cbt_class WHERE section = '$sect'");
      while($class = $sqlclass->fetch_object()){
        if($class->class ==  $clas_sect ){
          $html .= '<option value="'.$class->class.'" selected>'.$class->class.'</option>';
        } else {
          $html .= '<option value="'.$class->class.'">'.$class->class.'</option>';
        }    
      }  
      $result['Class_html'] = $html;
      // getting current section html
      $sqlSection = $conn->query("SELECT * FROM cbt_section");
      while($section = $sqlSection->fetch_object()){
        if($section->section ==  $student->Student_Section ){
          $html3 .= '<option value="'.$section->section.'" selected>'.$section->section.'</option>';
        } else {
          $html3 .= '<option value="'.$section->section.'">'.$section->section.'</option>';
        } 
        }
      $result['curr_sect_html'] = $html3;
      // getting current section html
      $result['address'] = $student->Address;
      $result['comment'] = $student->General_Comments;
      $result['Branch'] = $student->Branch;
      
      $result['total_fee'] = $student->Total_Sch_Fee ?? 0;
      $result['scholarship'] = $student->Scholarship_Fee ?? 0;
      $result['discount'] = $student->Gen_Discount ?? 0;
      $result['amt_payable'] = $student->Amount_Payable ?? 0;
      $result['amt_paid'] = $student->Amount_Paid ?? 0;
      $result['Balance'] = $student->Current_Balance ?? 0;

      // $pay_id = $_POST['pay_id'];
      $pay_details = $conn->query("SELECT * FROM cbt_stud_history WHERE studentID = '$student_ID' ORDER BY id DESC LIMIT 1")->fetch_object();
      $result['pay_option'] = $pay_details->pay_option ?? 0;
      $result['bank_name'] = $pay_details->bank_name ?? 'None';
      $result['date_paid'] = $pay_details->date ?? date('Y-m-d');
      $result['created_by'] = $pay_details->created_by ?? 'Empty';

      $result['query'] = 'true';

      if($student->Student_Image != NULL){
        $imageData1 = base64_encode($student->Student_Image);
        $finfo = finfo_open();
        $mimeType2 = finfo_buffer($finfo, $imageData1, FILEINFO_MIME_TYPE);
        finfo_close($finfo);
        $result['imgSrc'] = 'data:'.$mimeType2.';base64,'.$imageData1;
      } else {
        $result['imgSrc'] = '../../storege/students/no_image.jpg';
      }
    }
    echo json_encode($result);
  }

  //
  if(isset($_POST['type']) && $_POST['type'] == 'paginateNewIntake'){
    $html = '';
    $page = $_POST['page2']; //page if clicked
    $limit = $_POST['limit2']; //records per page
    $search = $_POST['search2']; //if search was included
    $offset = ($page - 1) * $limit;

    $resultUnprinted = $conn->query("SELECT COUNT(*) AS total FROM cbt_new_intake WHERE (Fullnames LIKE '%$search%' OR Branch LIKE '%$search%')")->fetch_assoc();
    $totalRecords = $resultUnprinted['total'];
    $totalPages = ceil($totalRecords / $limit);

    $cbt_new_intake = $conn->query("SELECT * FROM cbt_new_intake WHERE (Fullnames LIKE '%$search%' OR Branch LIKE '%$search%') LIMIT $limit OFFSET $offset")->fetch_all(MYSQLI_ASSOC);
    if(count($cbt_new_intake)>0){
      foreach($cbt_new_intake as $intake){
        $html .= '<tr class="intake small" data-id="'.$intake['intake_id'].'">
          <th scope="row">'.$intake['intake_id'].'</th>
          <td>'.($intake['Fullnames']).'</td>
          <td>'.($intake['Branch']).'</td>
          <td>'.number_format($intake['paid']).'</td>
          <td>'.number_format($intake['balance']).'</td>
          <td>'.$intake['pay_option'].'</td>
          <td class="deleteIntake" data-Nid="'.$intake['id'].'">
            <i class="bi bi-trash" style="color: red;"></i>
          </td>
        </tr>';
      }
    } else {
      $html = '<tr><td colspan="7" class="no-data">No records found.</td></tr>';
    }
    $result['html'] = $html;
    $result['totalPages'] = $totalPages;
    $result['currentPage'] = $page;
    echo json_encode($result);
  }

  //
  if(isset($_POST['type']) && $_POST['type'] == 'paginateStudHistory'){
    $html = '';
    $page = $_POST['page2']; //page if clicked
    $limit = $_POST['limit2']; //records per page
    $search = $_POST['search2']; //if search was included
    $offset = ($page - 1) * $limit;

    $resultUnprinted = $conn->query("SELECT COUNT(*) AS total FROM cbt_stud_history WHERE (fullnames LIKE '%$search%' OR Branch LIKE '%$search%')")->fetch_assoc();
    $totalRecords = $resultUnprinted['total'];
    $totalPages = ceil($totalRecords / $limit);

    $cbt_stud_history = $conn->query("SELECT * FROM cbt_stud_history WHERE (fullnames LIKE '%$search%' OR Branch LIKE '%$search%') LIMIT $limit OFFSET $offset")->fetch_all(MYSQLI_ASSOC);
    if(count($cbt_stud_history)>0){
      foreach($cbt_stud_history as $stud_history){
        $html .= '<tr class="studHistory small" data-id="'.$stud_history['studentID'].'" data-dBid="'.$stud_history['id'].'">
          <th scope="row">'.$stud_history['studentID'].'</th>
          <td>'.($stud_history['fullnames']).'</td>
          <td>'.($stud_history['branch']).'</td>
          <td>'.number_format($stud_history['amt_paid']).'</td>
          <td>'.number_format($stud_history['Balance']).'</td>
          <td>'.$stud_history['pay_option'].'</td>
          <td class="deletestudHistory" data-Nid="'.$stud_history['id'].'">
            <i class="bi bi-trash" style="color: red;"></i>
          </td>
        </tr>';
      }
    } else {
      $html = '<tr><td colspan="7" class="no-data">No records found.</td></tr>';
    }
    $result['html'] = $html;
    $result['totalPages'] = $totalPages;
    $result['currentPage'] = $page;
    echo json_encode($result);
  }

  //deleting a question   
  if(isset($_POST['type']) && $_POST['type'] == 'delete_intake'){
    $qid = $_POST['ID'];
    $cbt_new_intake = $conn->query("SELECT * FROM cbt_new_intake WHERE id ='$qid'");
    $intake = $cbt_new_intake->fetch_object();

      if(file_exists($intake->folder)){
        if(unlink($intake->folder)){
          clearstatcache();
          $sqlins = $conn->query("DELETE FROM cbt_new_intake WHERE id='$qid'");
          $result['msg'] = 'New Intake deleted Successfully along with its file';
          $result['status'] = 'success';
        }
      } elseif(!file_exists($intake->folder)){
        $sqlins = $conn->query("DELETE FROM cbt_new_intake WHERE id='$qid'");
        $result['msg'] = 'New Intake deleted Successfully';
        $result['status'] = 'success';
      }
      else{
        $result['msg'] = 'There is an error deleting the image';
        $result['status'] = 'failed';
      }

    echo json_encode($result);
  }

  //////
  if(isset($_POST['type']) && $_POST['type'] == 'delete_history'){
    $qid = $_POST['ID'];
    $sqlins = $conn->query("DELETE FROM cbt_stud_history WHERE id='$qid'");
    $result['msg'] = 'Pay History deleted Successfully';
    $result['status'] = 'success';

    echo json_encode($result);
  }

?>