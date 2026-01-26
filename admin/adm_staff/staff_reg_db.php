<?php 
    include('../../admin/config/db_connect.php');
    $result = array();
    
  
    // student registration to DB
    if(isset($_POST['type']) && $_POST['type'] == 'submitStaffReg'){
          $ress = array();
  
          // <!-- student details -->
          $staff_ID = $_POST['staff_ID'];
          $Fullname = htmlspecialchars($_POST['Fullnames']);
          $staff_gender = htmlspecialchars($_POST['staff_gender']);
          $staff_branch = htmlspecialchars($_POST['staff_branch']);
          $staff_dob = htmlspecialchars($_POST['staff_dob']);

          $date_emp = htmlspecialchars($_POST['date_emp']);
          $staff_term = htmlspecialchars($_POST['staff_term']);
          $staff_session = htmlspecialchars($_POST['staff_session']);
          $staff_qualification = htmlspecialchars($_POST['staff_qualification']);

          $work_Area = htmlspecialchars($_POST['work_Area']);        
          $staff_section = htmlspecialchars($_POST['staff_section']);
          $staff_phone = htmlspecialchars($_POST['staff_phone']);
          $staff_email = htmlspecialchars($_POST['staff_email']);  
  
          $staff_status = htmlspecialchars($_POST['staff_status']);
          $date_resigned = htmlspecialchars($_POST['date_resigned']);
          $staff_address = htmlspecialchars($_POST['staff_address']);
          $staff_comment = htmlspecialchars($_POST['staff_comment']);
          $staff_pass = htmlspecialchars($_POST['staff_pass']);
          $staff_pass_hash = md5($staff_pass);

          $emp_type = htmlspecialchars($_POST['emp_type']);
          $staff_bank_name = htmlspecialchars($_POST['staff_bank_name']);
          $account_name = htmlspecialchars($_POST['account_name']);
          $account_number = htmlspecialchars($_POST['account_number']);
          $staff_role = htmlspecialchars($_POST['staff_role']);
  
          $method = htmlspecialchars($_POST['method']);
  
  
          $staff_email = date('Y-m-d h:i:s');
          $date_left = date('Y-m-d');
         
          //ID determination
          $res = $conn->query("SELECT * FROM staff_records ORDER BY Staff_ID DESC LIMIT 1");
          if($res->num_rows > 0){
            $row = $res->fetch_object();
            $exist = $row->Staff_ID;
            $stf_id = (int)$exist+1;
          } else {
            $stf_id = '1001';
          }
  
          // ------------------Uploading image to the database ------Image='$imageData',--------Image='$imageData',------------//
          
  
          if($method == 'Submit'){
            // student registered with image
            if(isset($_FILES['image'])){
              $sqx=$conn->query("INSERT INTO staff_records SET staff_ID='$stf_id', Fullname='$Fullname', 
              Gender='$staff_gender', DOB='$staff_dob',Phone_No='$staff_phone', Email='$staff_email', Address='$staff_address',
              Date_Emp='$date_emp',Term_Emp='$staff_term',Year_='$staff_session',Staff_Status='$staff_status', Date_Resigned='$date_resigned',Qualifications='$staff_qualification',
              Emp_Type='$emp_type',Branch='$staff_branch',Acc_Name='$account_name',Acc_Number='$account_number',Bank_Name='$staff_bank_name',role='$staff_role', 
              new_pass='$staff_pass_hash',new_plain_pass='$staff_pass',Mgt_Comment='$staff_comment',Responsibility='$work_Area',Designation='$staff_section'");
  
  
              if(isset($_FILES['image'])){
                $imageData = file_get_contents($_FILES['image']['tmp_name']);
                
                $file = $_FILES['image'];
                $img = $file["name"];
                $tempname = $file["tmp_name"];
                $ext = substr($img, strrpos($img, '.', -1), strlen($img));
                $nam = $stf_id.$ext;
                $folder = "../../storege/staff/".$nam;
                move_uploaded_file($tempname, $folder); 
              }
  
              if($sqx){
                $stmt = $conn->prepare("UPDATE staff_records SET Image = ? WHERE staff_ID = ?");
                $stmt->bind_param("ss",$imageData,$stf_id);
                $stmt->execute();
  
                $ress['msg'] = 'Staff Registered Successfully with image.';
                $ress['lastID'] = $stf_id;
              } else {
                $ress['msg'] = 'Registration Error.';
                $ress['lastID'] = $stf_id;
              }
            } else {
              // student registered without image
              $sqx=$conn->query("INSERT INTO staff_records SET staff_ID='$stf_id', Fullname='$Fullname', 
              Gender='$staff_gender', DOB='$staff_dob',Phone_No='$staff_phone', Email='$staff_email', Address='$staff_address',
              Date_Emp='$date_emp', Term_Emp='$staff_term',Year_='$staff_session',Staff_Status='$staff_status', Date_Resigned='$date_resigned',
              Qualifications='$staff_qualification',Emp_Type='$emp_type',Branch='$staff_branch',Acc_Name='$account_name',Acc_Number='$account_number',
              Bank_Name='$staff_bank_name',role='$staff_role', new_pass='$staff_pass_hash',new_plain_pass='$staff_pass',Mgt_Comment='$staff_comment',Responsibility='$work_Area',Designation='$staff_section'");
  
              if($sqx){
                $ress['msg'] = 'Staff Registered Successfully without image.';
                $ress['lastID'] = $stf_id;
              } else {
                $ress['msg'] = 'Registration Error.';
                $ress['lastID'] = $stf_id;
              }
            }
          }  
          elseif($method == 'Update'){
            // student updated with image
            if(isset($_FILES['image'])){
              $sqx=$conn->query("UPDATE staff_records SET Fullname='$Fullname',Gender='$staff_gender', DOB='$staff_dob', 
              Phone_No='$staff_phone', Email='$staff_email', Address='$staff_address', Date_Emp='$date_emp',
              Term_Emp='$staff_term',Year_='$staff_session',Staff_Status='$staff_status', Date_Resigned='$date_resigned',Qualifications='$staff_qualification',Emp_Type='$emp_type',
              Branch='$staff_branch',Acc_Name='$account_name',Acc_Number='$account_number',Bank_Name='$staff_bank_name',role='$staff_role', 
              new_pass='$staff_pass_hash',new_plain_pass='$staff_pass',Mgt_Comment='$staff_comment',Responsibility='$work_Area',Designation='$staff_section' WHERE staff_ID='$staff_ID'");
  
  
              if(isset($_FILES['image'])){
                $imageData = file_get_contents($_FILES['image']['tmp_name']);
                
                $file = $_FILES['image'];
                $img = $file["name"];
                $tempname = $file["tmp_name"];
                $ext = substr($img, strrpos($img, '.', -1), strlen($img));
                $nam = $staff_ID.$ext;
                $folder = "../../storege/staff/".$nam;
                move_uploaded_file($tempname, $folder); 
              }
  
              if($sqx){
                $stmt = $conn->prepare("UPDATE staff_records SET Image = ? WHERE staff_ID = ?");
                $stmt->bind_param("ss",$imageData,$staff_ID);
                $stmt->execute();
  
                $ress['msg'] = 'Staff Details And Image Updated Successfully.';
                $ress['lastID'] = $staff_ID;
              } else {
                $ress['msg'] = 'Update Error for file.';
                $ress['lastID'] = $staff_ID;
              }
  
            } else {
              // student updated without image
              $sqx=$conn->query("UPDATE staff_records SET Fullname='$Fullname',Gender='$staff_gender', DOB='$staff_dob', 
              Phone_No='$staff_phone', Email='$staff_email', Address='$staff_address', Date_Emp='$date_emp', 
              Term_Emp='$staff_term',Year_='$staff_session',Staff_Status='$staff_status', Date_Resigned='$date_resigned',Qualifications='$staff_qualification',Emp_Type='$emp_type',
              Branch='$staff_branch',Acc_Name='$account_name',Acc_Number='$account_number',Bank_Name='$staff_bank_name',role='$staff_role', 
              new_pass='$staff_pass_hash',new_plain_pass='$staff_pass',Mgt_Comment='$staff_comment',Responsibility='$work_Area',Designation='$staff_section' WHERE staff_ID='$staff_ID'");
  
              if($sqx){
                $ress['msg'] = 'Staff Details Updated Successfully.';
                $ress['lastID'] = $staff_ID;
              } else {
                $ress['msg'] = 'Update Error without file.';
                $ress['lastID'] = $staff_ID;
              }
            } 
          }
  
          echo json_encode($ress);
    }
      
    //get staff details from database
    if(isset($_POST['type']) && $_POST['type'] == 'getStaffDetails'){
      $html = ''; $html2 = ''; $html3 = ''; $html4 = ''; $html5 = '';
      $staff_ID = $_POST['staff_ID'];
      $sql = $conn->query("SELECT * FROM staff_records WHERE staff_ID = '$staff_ID'");
      
      if($sql->num_rows == 0){
        $result['msg'] = 'No staff with such ID';
        $result['query'] = 'false';
      } else {
        $staff = $sql->fetch_object();

        $result['Fullname'] = $staff->Fullname;
        $result['Gender'] = $staff->Gender;
        $result['Branch'] = $staff->Branch;
        $result['D_O_B'] = $staff->DOB;

        $result['Date_Emp'] = $staff->Date_Emp;
        $result['Term_Emp'] = $staff->Term_Emp;
        $result['Session'] = $staff->Year_;
        $result['Qualifications'] = $staff->Qualifications;

        $result['Work_area'] = $staff->Responsibility;
        $result['Staff_section'] = $staff->Designation;
        $result['Phone_No'] = $staff->Phone_No;
        $result['Email'] = $staff->Email;
        
        $result['Staff_Status'] = $staff->Staff_Status;
        $result['Date_Resigned'] = $staff->Date_Resigned;
        $result['Address'] = $staff->Address;
        $result['Comment'] = $staff->Mgt_Comment;
        $result['Staff_pass'] = $staff->new_plain_pass;
        
        $result['Emp_Type'] = $staff->Emp_Type;
        $result['Staff_bank'] = $staff->Bank_Name;
        $result['Account_name'] = $staff->Acc_Name;
        $result['Account_number'] = $staff->Acc_Number;
        $result['Staff_role'] = $staff->role;
        
        $result['Basic_Salary'] = $staff->Basic_Salary;
        $result['Sal_Nego'] = $staff->Sal_Nego;  
        $result['Increment'] = $staff->Increment;
        $result['Transport'] = $staff->Transport;
        $result['Feeding_All'] = $staff->Feeding_All;
        $result['Add_Resp_Fee'] = $staff->Add_Resp_Fee;
        
        $result['Incentive'] = $staff->Incentive;  
        $result['House_All'] = $staff->House_All;  
        $result['Emissary_All'] = $staff->Emissary_All;  
        $result['Total_Salary'] = $staff->Total_Salary;  
        $result['M_Gratuity'] = $staff->M_Gratuity;  
        $result['Loan_paid'] = $staff->Monthly_Loan;  

        $result['Gov_M_Tax'] = $staff->Gov_M_Tax;
        $result['Gov_A_Tax'] = $staff->Gov_A_Tax;
        $result['Monthly_Savings'] = $staff->Monthly_Savings;
        $result['Deductions'] = $staff->Deductions;
        $result['Ded'] = $staff->Ded;
        $result['Amt_Payable'] = $staff->Amt_Payable;

        $result['Amt_Paid'] = $staff->Amt_Paid;
        $result['Balance'] = $staff->Balance;
        $result['Loan_Bal'] = $staff->Loan_Bal;
        $result['T_Savings'] = $staff->T_Savings;
        $result['T_Gratuity'] = $staff->Gratuity;

        $result['query'] = 'true';

        if($staff->Image != NULL){
          $imageData1 = base64_encode($staff->Image);
          $finfo = finfo_open();
          $mimeType2 = finfo_buffer($finfo, $imageData1, FILEINFO_MIME_TYPE);
          finfo_close($finfo);
          $result['imgSrc'] = 'data:'.$mimeType2.';base64,'.$imageData1;
        } else {
          $result['imgSrc'] = '../storege/staff/no_image.jpg';
          // $result['imgSrc'] = '../../storege/staff/no_image.jpg';
        }
        
      }

      echo json_encode($result);
    }

    // DONE
    if(isset($_POST['type']) && $_POST['type'] == 'auto_id_rec'){   
        $res = $conn->query("SELECT * FROM staff_records ORDER BY Staff_ID DESC LIMIT 1");
        $staff = $res->fetch_object();
        $last_id = $staff->Staff_ID;
  
        $res1 = $conn->query("SELECT * FROM student_payment ORDER BY Pay_Ref DESC LIMIT 1");
        $students_pay = $res1->fetch_object();
        $last_pay_id = $students_pay->Pay_Ref;
  
        $result['last_id'] = $last_id;
        $result['pay_id'] = $last_pay_id;
  
  
  
        echo json_encode($result);
    }

?>