<?php 
    include('../../admin/config/db_connect.php');
    $result = array();
    
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
      $Fullnames = htmlspecialchars($_POST['Fullnames']);
      $ArabicName = htmlspecialchars($_POST['ArabicName']);
      $std_gender = htmlspecialchars($_POST['std_gender']);
      $std_dob = htmlspecialchars($_POST['std_dob']);
      $std_status = htmlspecialchars($_POST['std_status']);
      $std_Session = htmlspecialchars($_POST['std_Session']);
      $Std_Term = htmlspecialchars($_POST['Std_Term']);
      $std_section = htmlspecialchars($_POST['std_section']);
      $std_class = htmlspecialchars($_POST['std_class']);
      $std_branch = htmlspecialchars($_POST['std_branch']);
      $std_pin = htmlspecialchars($_POST['std_pin']);
      $year_graduated = htmlspecialchars($_POST['year_graduated']);
      $date_adm = htmlspecialchars($_POST['date_admitted']);

      // <!-- Parent/Guardian info --> // $file = $_FILES['file'];
      $Std_parent = htmlspecialchars($_POST['Std_parent']);        
      $std_phone = htmlspecialchars($_POST['std_phone']);
      $Std_email = htmlspecialchars($_POST['Std_email']);
      $Std_address = htmlspecialchars($_POST['Std_address']);
      $std_comment = htmlspecialchars($_POST['std_comment']);

      //<!-- school fees determination -->
      $entry_type = htmlspecialchars($_POST['entry_type']);
      $std_trans = htmlspecialchars($_POST['std_trans']);
      $sqlfeesDeter = $conn->query("SELECT * FROM fees_determination WHERE Term = '$Std_Term' AND Branch ='$std_branch'");
      $feesDeter = $sqlfeesDeter->fetch_object();
      $trans_area = $feesDeter->{$std_trans};
      $tax_option = htmlspecialchars($_POST['tax_option']);
      $scholarship_determination = htmlspecialchars($_POST['scholarship_determination']);
      

      
      $std_cur_section = htmlspecialchars($_POST['std_cur_section']);
      $firstThree = substr($std_cur_section, 0, 3);
      if($firstThree == 'Jun'){
        $column = 'TotJss';
        $column2 = 'JssPTA';
      } 
      elseif($firstThree == 'Sen') {
        $column = 'TotSs';
        $column2 = 'SsPTA';
      } 
      elseif($firstThree == 'Pri') {
        $column = 'TotPry';
        $column2 = 'PryPTA';
      } 
      elseif($firstThree == 'Dip') {
        $column = 'Diploma1';
        $column2 = 'Diploma2';
      } 
      else {
        $column = 'Tot'.$firstThree;
        $column2 = $firstThree.'PTA';
      }
      
      $_sch_fee = $feesDeter->{$column};
      $value2_pta_fee = $feesDeter->{$column2};

      $std_cur_class = htmlspecialchars($_POST['std_cur_class']);
      $ext_exam = htmlspecialchars($_POST['ext_exam']);
      $Std_adm_type = htmlspecialchars($_POST['Std_adm_type']);
      if($Std_adm_type == 'Day'){
        $adm = $Std_adm_type;
      } else {
        $adm = 'Boarding';
      }

      //<!-- School fees details -->
      $entry_type_amt = htmlspecialchars($_POST['entry_type_amt']);
      $std_trans_amt = htmlspecialchars($_POST['std_trans_amt']);
      $std_cur_section_amt = htmlspecialchars($_POST['std_cur_section_amt']);
      $value1_sch_fee = $std_cur_section_amt - $value2_pta_fee;
      $std_cur_class_amt = htmlspecialchars($_POST['std_cur_class_amt']);
      $prev_debt_amt = htmlspecialchars($_POST['prev_debt_amt']);
      $ext_exam_amt = htmlspecialchars($_POST['ext_exam_amt']);
      $Std_adm_type_amt = htmlspecialchars($_POST['Std_adm_type_amt']);
      $std_cbt_les = htmlspecialchars($_POST['std_cbt_les']);
      $Std_misc_cert = htmlspecialchars($_POST['Std_misc_cert']);

      //<!-- payment info --> 
      $std_tot_fees = htmlspecialchars($_POST['std_tot_fees']);
      $std_scholar = htmlspecialchars($_POST['std_scholar']);
      $std_dis_fees = htmlspecialchars($_POST['std_dis_fees']);
      $std_amt_pay = htmlspecialchars($_POST['std_amt_pay']);
      $Tuition_Fee = htmlspecialchars($_POST['tution_fee']);
      $std_amt_paid = htmlspecialchars($_POST['std_amt_paid']);
      $std_bal = htmlspecialchars($_POST['std_bal']);
      $method = htmlspecialchars($_POST['method']);

      //<!-- extra info -->
      $pay_option = htmlspecialchars($_POST['Pay_Option']);
      $bank = htmlspecialchars($_POST['Bank']);
      // $bank_ref = htmlspecialchars($_POST['bank_ref']);
      $pay_ref = htmlspecialchars($_POST['Pay_Ref']);
      $gen_Term = htmlspecialchars($_POST['gen_Term']);
      $gen_branch = htmlspecialchars($_POST['gen_branch']);
      $gen_Session = htmlspecialchars($_POST['gen_Session']);


      // $date_adm = date('Y-m-d h:i:s');
      $date_left = date('Y-m-d');
      
      //ID determination
      $res = $conn->query("SELECT * FROM student_records ORDER BY Student_ID DESC LIMIT 1");
      if($res->num_rows > 0){
        $row = $res->fetch_object();
        $exist = $row->Student_ID;
        $std_id = (int)$exist+1;
      } else {
        $std_id = '1001';
      }

      // ------------------Uploading image to the database ------Student_Image='$imageData',--------Student_Image='$imageData',-------Student_Pin='$std_pin',-----//
      

      if($method == 'Submit'){
        // student registered with image 
        if(isset($_FILES['image'])){
          $sqx=$conn->query("INSERT INTO student_records SET Student_ID='$std_id', Fullnames='$Fullnames', ArabicName='$ArabicName', 
          Gender='$std_gender', DOB='$std_dob',Current_Status='$std_status', Date_Adm='$date_adm', Term_Adm='$Std_Term',
          Section_Adm='$std_section', Class_Adm='$std_class', Parent_Name='$Std_parent',Phone_Number='$std_phone', Email='$Std_email',Address='$Std_address',General_Comments='$std_comment',Entry_Section='Old',Transport_Area='$trans_area',
          Student_Section='$std_cur_section',Student_Class='$std_cur_class',External_Exam='$ext_exam', Adm_Type='$adm',Scholarship='$scholarship_determination',
          Previous_Debt_Fee ='$prev_debt_amt',Entry_Fee='$entry_type_amt',Transport_Fee='$std_trans_amt',Termly_Fee='$value1_sch_fee',Student_Pin='$std_pin',
          Book_Fee='$std_cur_class_amt',Ext_Exam_Fee='$ext_exam_amt', Boarding_Fee='$Std_adm_type_amt',Scholarship_Fee='$std_scholar',
          Others_Fee='$std_cbt_les',Misc_Fee='$Std_misc_cert', Total_Sch_Fee='$std_tot_fees',Gen_Discount='$std_dis_fees',S_Amount='$tax_option',
          Amount_Payable='$std_amt_pay',Amount_Paid='$std_amt_paid', Current_Balance='$std_bal',Year_Graduated='$year_graduated', 
          Branch='$std_branch',PTA_Fee='$value2_pta_fee',Tuition_Fee='$Tuition_Fee', Session_='$std_Session',Date_Left = '$date_left'");


          if(isset($_FILES['image'])){
            $imageData = file_get_contents($_FILES['image']['tmp_name']);
            
            $file = $_FILES['image'];
            $img = $file["name"];
            $tempname = $file["tmp_name"];
            $ext = substr($img, strrpos($img, '.', -1), strlen($img));
            $nam = $std_id.$ext;
            $folder = "../../storege/students/".$nam;
            move_uploaded_file($tempname, $folder); 
          }

          if($sqx){
            $stmt = $conn->prepare("UPDATE student_records SET Student_Image = ? WHERE Student_ID = ?");
            $stmt->bind_param("ss",$imageData,$std_id);
            $stmt->execute();

            $ress['msg'] = 'Student Registered Successfully with image.';
            $ress['lastID'] = $std_id;
          } else {
            $ress['msg'] = 'Registration Error.';
            $ress['lastID'] = $std_id;
          }
        } else {
          // student registered without image
          $sqx=$conn->query("INSERT INTO student_records SET Student_ID='$std_id', Fullnames='$Fullnames', ArabicName='$ArabicName', 
          Gender='$std_gender', DOB='$std_dob',Current_Status='$std_status', Date_Adm='$date_adm', Term_Adm='$Std_Term',
          Section_Adm='$std_section', Class_Adm='$std_class', Parent_Name='$Std_parent',Phone_Number='$std_phone', Email='$Std_email',Address='$Std_address',General_Comments='$std_comment',Entry_Section='Old',Transport_Area='$trans_area',
          Student_Section='$std_cur_section',Student_Class='$std_cur_class',External_Exam='$ext_exam', Adm_Type='$adm',Scholarship='$scholarship_determination',
          Previous_Debt_Fee ='$prev_debt_amt',Entry_Fee='$entry_type_amt',Transport_Fee='$std_trans_amt',Termly_Fee='$value1_sch_fee',
          Book_Fee='$std_cur_class_amt',Ext_Exam_Fee='$ext_exam_amt', Boarding_Fee='$Std_adm_type_amt',Scholarship_Fee='$std_scholar',Student_Pin='$std_pin',
          Others_Fee='$std_cbt_les',Misc_Fee='$Std_misc_cert', Total_Sch_Fee='$std_tot_fees',Gen_Discount='$std_dis_fees',S_Amount='$tax_option',
          Amount_Payable='$std_amt_pay',Amount_Paid='$std_amt_paid', Current_Balance='$std_bal',Year_Graduated='$year_graduated', 
          Branch='$std_branch',PTA_Fee='$value2_pta_fee',Tuition_Fee='$Tuition_Fee', Session_='$std_Session',Date_Left = '$date_left'");

          if($sqx){
            $ress['msg'] = 'Student Registered Successfully without image.';
            $ress['lastID'] = $std_id;
          } else {
            $ress['msg'] = 'Registration Error.';
            $ress['lastID'] = $std_id;
          }
        }
      }  
      elseif($method == 'Update'){
        // student updated with image
        if(isset($_FILES['image'])){
          $sqx=$conn->query("UPDATE student_records SET Fullnames='$Fullnames', ArabicName='$ArabicName',Gender='$std_gender', DOB='$std_dob', 
          Current_Status='$std_status', Date_Adm='$date_adm', Term_Adm='$Std_Term',Section_Adm='$std_section', Class_Adm='$std_class',
          Parent_Name='$Std_parent',Phone_Number='$std_phone', Email='$Std_email',Address='$Std_address',General_Comments='$std_comment',
          Entry_Section='Old',Transport_Area='$trans_area',Student_Section='$std_cur_section',Student_Class='$std_cur_class',Student_Pin='$std_pin',
          External_Exam='$ext_exam', Adm_Type='$adm',Scholarship='$scholarship_determination', Previous_Debt_Fee ='$prev_debt_amt',Entry_Fee='$entry_type_amt',
          Transport_Fee='$std_trans_amt',Termly_Fee='$value1_sch_fee',Book_Fee='$std_cur_class_amt',Ext_Exam_Fee='$ext_exam_amt', 
          Boarding_Fee='$Std_adm_type_amt',Scholarship_Fee='$std_scholar',Others_Fee='$std_cbt_les',Misc_Fee='$Std_misc_cert', S_Amount='$tax_option',
          Total_Sch_Fee='$std_tot_fees',Gen_Discount='$std_dis_fees', Amount_Payable='$std_amt_pay',Amount_Paid='$std_amt_paid',
          Current_Balance='$std_bal',Year_Graduated='$year_graduated', Branch='$std_branch',PTA_Fee='$value2_pta_fee',Tuition_Fee='$Tuition_Fee', 
          Session_='$std_Session',Date_Left = '$date_left' WHERE Student_ID='$Student_ID'");


          if(isset($_FILES['image'])){
            $imageData = file_get_contents($_FILES['image']['tmp_name']);
            
            $file = $_FILES['image'];
            $img = $file["name"];
            $tempname = $file["tmp_name"];
            $ext = substr($img, strrpos($img, '.', -1), strlen($img));
            $nam = $Student_ID.$ext;
            $folder = "../../storege/students/".$nam;
            move_uploaded_file($tempname, $folder); 
          }

          if($sqx){
            $stmt = $conn->prepare("UPDATE student_records SET Student_Image = ? WHERE Student_ID = ?");
            $stmt->bind_param("ss",$imageData,$Student_ID);
            $stmt->execute();

            $ress['msg'] = 'Student Details And Image Updated Successfully.';
            $ress['lastID'] = $Student_ID;
          } else {
            $ress['msg'] = 'Update Error for file.';
            $ress['lastID'] = $Student_ID;
          }

        } else {
          // student updated without image
          $sqx=$conn->query("UPDATE student_records SET Fullnames='$Fullnames', ArabicName='$ArabicName',Gender='$std_gender', DOB='$std_dob', 
          Current_Status='$std_status', Date_Adm='$date_adm', Term_Adm='$Std_Term',Section_Adm='$std_section', Class_Adm='$std_class', 
          Parent_Name='$Std_parent',Phone_Number='$std_phone', Email='$Std_email',Address='$Std_address',General_Comments='$std_comment',
          Entry_Section='Old',Transport_Area='$trans_area',Student_Section='$std_cur_section',Student_Class='$std_cur_class',S_Amount='$tax_option',
          External_Exam='$ext_exam', Adm_Type='$adm',Scholarship='$scholarship_determination', Previous_Debt_Fee ='$prev_debt_amt',Entry_Fee='$entry_type_amt',
          Transport_Fee='$std_trans_amt',Termly_Fee='$value1_sch_fee',Book_Fee='$std_cur_class_amt',Ext_Exam_Fee='$ext_exam_amt', 
          Boarding_Fee='$Std_adm_type_amt',Scholarship_Fee='$std_scholar',Others_Fee='$std_cbt_les',Misc_Fee='$Std_misc_cert', Student_Pin='$std_pin',
          Total_Sch_Fee='$std_tot_fees',Gen_Discount='$std_dis_fees', Amount_Payable='$std_amt_pay',Amount_Paid='$std_amt_paid', 
          Current_Balance='$std_bal',Year_Graduated='$year_graduated', Branch='$std_branch',PTA_Fee='$value2_pta_fee',Tuition_Fee='$Tuition_Fee', 
          Session_='$std_Session',Date_Left = '$date_left' WHERE Student_ID='$Student_ID'");

          if($sqx){
            $ress['msg'] = 'Student Details Updated Successfully.';
            $ress['lastID'] = $std_id;
          } else {
            $ress['msg'] = 'Update Error without file.';
            $ress['lastID'] = $std_id;
          }
        } 
      }

      echo json_encode($ress);
    }
  
    //submit payment into student_payment 
    if(isset($_POST['type']) && $_POST['type'] == 'submit_payment'){
        $Student_ID = $_POST['Student_ID'];
        $Fullnames = htmlspecialchars($_POST['Fullnames']);
        $gen_Term = htmlspecialchars($_POST['gen_Term']);
        $gen_branch = htmlspecialchars($_POST['gen_branch']);
        $std_phone = htmlspecialchars($_POST['std_phone']);
        $gen_Session = htmlspecialchars($_POST['gen_Session']);
        $sqlfeesDeter = $conn->query("SELECT * FROM fees_determination WHERE Term = '$gen_Term' AND Branch ='$gen_branch'");
        $feesDeter = $sqlfeesDeter->fetch_object();
        $std_cur_section = htmlspecialchars($_POST['std_cur_section']);
          $firstThree = substr($std_cur_section, 0, 3);
          if($firstThree == 'Jun'){
            $column = 'TotJss';
            $column2 = 'JssPTA';
          } 
          elseif($firstThree == 'Sen') {
            $column = 'TotSs';
            $column2 = 'SsPTA';
          } 
          elseif($firstThree == 'Pri') {
            $column = 'TotPry';
            $column2 = 'PryPTA';
          } 
          elseif($firstThree == 'Dip') {
            $column = 'Diploma1';
            $column2 = 'Diploma2';
          } 
          else {
            $column = 'Tot'.$firstThree;
            $column2 = $firstThree.'PTA';
          }
          
        $value1_sch_fee = $feesDeter->{$column};
        $value2_pta_fee = $feesDeter->{$column2};
        $std_cur_class = htmlspecialchars($_POST['std_cur_class']);
  
        //<!-- School fees details -->
        $entry_type_amt = htmlspecialchars($_POST['entry_type_amt']);
        $std_trans_amt = htmlspecialchars($_POST['std_trans_amt']);
        $std_cur_section_amt = htmlspecialchars($_POST['std_cur_section_amt']);
        $std_cur_class_amt = htmlspecialchars($_POST['std_cur_class_amt']);
        $prev_debt_amt = htmlspecialchars($_POST['prev_debt_amt']);
        $ext_exam_amt = htmlspecialchars($_POST['ext_exam_amt']);
        $Std_adm_type_amt = htmlspecialchars($_POST['Std_adm_type_amt']);
        $std_cbt_les = htmlspecialchars($_POST['std_cbt_les']);
        $Std_misc_cert = htmlspecialchars($_POST['Std_misc_cert']);
  
        //<!-- payment info -->
        $std_tot_fees = htmlspecialchars($_POST['std_tot_fees']);
        $std_scholar = htmlspecialchars($_POST['std_scholar']);
        $std_dis_fees = htmlspecialchars($_POST['std_dis_fees']);
        $std_amt_pay = htmlspecialchars($_POST['std_amt_pay']);
        $std_amt_paid = htmlspecialchars($_POST['std_amt_paid']);
        $std_bal = htmlspecialchars($_POST['std_bal']);
        $reference = htmlspecialchars($_POST['reference']);
  
        //<!-- extra info -->
        $pay_option = htmlspecialchars($_POST['pay_option']);
        $bank = htmlspecialchars($_POST['bank']);
        $bank_ref = 0;
        // $bank_ref = htmlspecialchars($_POST['bank_ref']);
        $pay_re = (int)($_POST['pay_ref']);
        $pay_ref = $pay_re + 1;
        $date_adm = date('Y-m-d');
  
        //payment sql
        $sqq=$conn->query("INSERT INTO student_payment SET Student_ID='$Student_ID', Fullnames='$Fullnames', Student_Class='$std_cur_class', 
        Student_Section='$std_cur_section', Session='$gen_Session', Term='$gen_Term', Pay_Option='$pay_option',Bank='$bank', Date_='$date_adm',
        P_Debt='$prev_debt_amt',Ent_Fee='$entry_type_amt', Trans='$std_trans_amt',Term_Fee='$value1_sch_fee',Book_Fee='$std_cur_class_amt',
        Ext_Exam='$ext_exam_amt',Board_Fee='$Std_adm_type_amt',Others_Fee='$std_cbt_les',Scholarship_Fee='$std_scholar',Misc_Fee='$Std_misc_cert',
        Total_Fees='$std_tot_fees',Gen_Discount='$std_dis_fees', Amt_Payable ='$std_amt_pay',Amt_Paid='$std_amt_paid',Balance='$std_bal',Bank_Ref='$reference',
        Branch='$gen_branch',Pay_Ref='$pay_ref', PTA_Fee='$value2_pta_fee',Phone_Number='$std_phone'");
  
        if($sqq){
          $result['status'] = 'true';
          $result['msg'] = 'Payment Done';
        } else {
          $result['status'] = 'false';
          $result['msg'] = 'Payment failed';
        }
  
        echo json_encode($result);
    }
      
    //get students details from database
    if(isset($_POST['type']) && $_POST['type'] == 'getStudentDetails'){
          $html = ''; $html2 = ''; $html3 = ''; $html4 = ''; $html5 = '';
          $student_ID = $_POST['student_ID'];
          $role_db = $_POST['role_db'];
          $branch_db = $_POST['branch_db'];
          $sq = "SELECT * FROM student_records WHERE Student_ID = '$student_ID' ";
          if($role_db != 'admin'){
            $sq .= "AND Branch ='$branch_db'";
          }
          // if($role_db != 'admin'){
          //   $sq = "SELECT * FROM student_records WHERE Student_ID = '$student_ID' AND Branch ='$branch_db'";
          // } else {
          //   $sq = "SELECT * FROM student_records WHERE Student_ID = '$student_ID' ";
          // }
          $sql = $conn->query($sq);
          
          if($sql->num_rows == 0){
            $result['msg'] = 'No student with such ID';
            $result['query'] = 'false';
          } else {
            $student = $sql->fetch_object();
            $result['Fullnames'] = $student->Fullnames;
            $result['ArabicName'] = $student->ArabicName;
            $result['Gender'] = $student->Gender;
            $result['D_O_B'] = $student->DOB;
            $result['Branch'] = $student->Branch;
            $result['Term'] = $student->Term_Adm;
            $result['Session'] = $student->Session_;
            $result['Section'] = $student->Section_Adm;
            $result['Class'] = $student->Class_Adm;
            $clas_sect = $student->Class_Adm;
            $sect = $student->Section_Adm;
            $result['Transport_Area'] = $student->Transport_Area;
            $result['tax_option'] = $student->S_Amount;
            $result['std_pin'] = $student->Student_Pin;
            $result['Date_Adm'] = $student->Date_Adm;
            $result['Year_Graduated'] = $student->Year_Graduated;
  
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
            // getting class html
  
            // getting trans. Area html

            $sqlins = $conn->query("SELECT current_term,Branch FROM current_term WHERE ID='1'")->fetch_object();
            $gen_term = $sqlins->current_term;
            $gen_branch = $sqlins->Branch;
            for($i = 1;$i<11;$i++){
              $column = 'Location'.$i;
              $column1 = 'Cat'.$i;
              $column2 = 'Amount'.$i;
              $sql = $conn->query("SELECT {$column},{$column1},{$column2} FROM fees_determination WHERE Term='$gen_term' AND Branch='$gen_branch'")->fetch_object();
              $TransArea[$column] = $sql->{$column};
              $sholarshipType[$column2] = $sql->{$column1};
            }
            foreach($TransArea as $key=>$value){
              if($value ==  $student->Transport_Area ){
                $html2 .= '<option value="'.$key.'" selected>'.$value.'</option>';
              } else {
                $html2 .= '<option value="'.$key.'">'.$value.'</option>';
              } 
            }
            $result['trans_area_html'] = $html2;

            foreach($sholarshipType as $key=>$value){
              $studentOwn = substr($student->Scholarship,-1);
              $dbOwn = substr($value,-1);
              if($dbOwn ==  $studentOwn ){
                $html5 .= '<option value="'.$key.'" selected>'.$value.'</option>';
              } else {
                $html5 .= '<option value="'.$key.'">'.$value.'</option>';
              } 
            }
            $result['scholar_html'] = $html5;
            // getting trans. Area html
  
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
  
            // getting current class html
            $sect1= $student->Student_Section;
            $sqlclass = $conn->query("SELECT * FROM cbt_class WHERE section = '$sect1'");
            while($class = $sqlclass->fetch_object()){
              if($class->class ==  $student->Student_Class ){
                $html4 .= '<option value="'.$class->class.'" selected>'.$class->class.'</option>';
              } else {
                $html4 .= '<option value="'.$class->class.'">'.$class->class.'</option>';
              }    
            }  
            $result['Curr_Class_html'] = $html4;
            // getting current class html
            
            $result['External_Exam'] = $student->External_Exam;
            $result['Status'] = $student->Current_Status;
            // $result['Admission_Type'] = $student->Adm_Type;
            if($student->Adm_Type == 'Day'){
              $result['Admission_Type'] = 'Day';
            } else {
              if($student->Student_Section == 'Nursery'){
                $result['Admission_Type'] = 'NurSec';
              } elseif($student->Student_Section == 'Primary'){
                $result['Admission_Type'] = 'PrySec';
              } elseif($student->Student_Section == 'Junior Sec'){
                $result['Admission_Type'] = 'JssSec';
              } elseif($student->Student_Section == 'Senior Sec') {
                $result['Admission_Type'] = 'SsSec';
              } else {
                $result['Admission_Type'] = 'Day';
              }
              
            }
            $result['Parent_Name'] = $student->Parent_Name;
            $result['Address'] = $student->Address;
            $result['Phone_Number'] = $student->Phone_Number;
            $result['Email'] = $student->Email;
            
            $result['Transport_Fee'] = $student->Transport_Fee;
            $result['Scholarship_Type'] = $student->Scholarship;
            $result['Comment'] = $student->General_Comments;
            $result['Entry_Fee'] = $student->Entry_Fee;
            $result['entry_type'] = $student->Entry_Section;
            $result['std_cur_section_amt'] = $student->Termly_Fee + $student->PTA_Fee;
            $result['Book_Fee'] = $student->Book_Fee;  
            $result['Previous_Debt_Fee'] = $student->Previous_Debt_Fee;  
            $result['Ext_Exam_Fee'] = $student->Ext_Exam_Fee;  
            $result['Boarding_Fee'] = $student->Boarding_Fee;  
            $result['Others_Fee'] = $student->Others_Fee;  
            $result['Misc_Fee'] = $student->Misc_Fee;  
            $result['Total_Fees'] = $student->Total_Sch_Fee;  
            $result['Scholarship_Fees'] = $student->Scholarship_Fee;
            $result['Discount'] = $student->Gen_Discount;
            $result['Amount_Payable'] = $student->Amount_Payable;
            $result['Tuition_Fee'] = $student->Tuition_Fee;
            $result['Amount_Paid'] = $student->Amount_Paid;
            $result['Balance'] = $student->Current_Balance;
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
  
    //fees_determination from database  
    if(isset($_POST['type']) && $_POST['type'] == 'fee_deter'){
        $selection_made = $_POST['selection_made'];
        $select_val = $_POST['select_val'];
        $term = $_POST['term'];
        $branch = $_POST['branch'];
        $sqlfeesDeter = $conn->query("SELECT * FROM fees_determination WHERE Term = '$term' AND Branch ='$branch'");
        $feesDeter = $sqlfeesDeter->fetch_object();
  
        if($selection_made == 'entry_type'){
          $firstThree = substr($select_val, 0, 3);
          if($firstThree == 'Dip' || $firstThree == 'Old'){
            $value = 0;
          } else {
            $column = $firstThree.'_Entrance';
            $valu = $feesDeter->{$column};
            $value = $valu;
          }
        }
        elseif($selection_made == 'std_trans'){
          $lastChar = substr($select_val, -1);
          $column = 'Fee'.$lastChar;
          $value = $feesDeter->{$column};
        }
        elseif($selection_made == 'std_cur_section'){
          $firstThree = substr($select_val, 0, 3);
          if($firstThree == 'Jun'){
            $column = 'TotJss';
            $column2 = 'JssPTA';
          } 
          elseif($firstThree == 'Sen') {
            $column = 'TotSs';
            $column2 = 'SsPTA';
          } 
          elseif($firstThree == 'Pri') {
            $column = 'TotPry';
            $column2 = 'PryPTA';
          } 
          elseif($firstThree == 'Dip') {
            $column = 'Diploma1';
            $column2 = 'Diploma2';
          } 
          else {
            $column = 'Tot'.$firstThree;
            $column2 = $firstThree.'PTA';
          }
          
          $value1 = $feesDeter->{$column};
          $value2 = $feesDeter->{$column2};
          $value = $value1+$value2;
        }
        elseif( $selection_made == 'std_cur_class'){
          $extra = '_Book';
          
          $firstfive = substr($select_val, 0, 5);
          if($firstfive == 'Pre K'){
            $column = 'Pre_KG'.$extra;
            $valu = $feesDeter->{$column};
            
          } elseif($firstfive == 'Pre J'){
            $column = 'PreJss'.$extra;
            $valu = $feesDeter->{$column};
  
          } elseif($firstfive == 'Crech'){
            $valu = 0;
          }
  
          $firstThree = substr($select_val, 0, 3);
          if($firstThree == 'KG1' || $firstThree == 'KG2' || $firstThree == 'KG3'){
            $column = $firstThree.$extra;
            $valu = $feesDeter->{$column};
  
          } elseif($firstThree == 'Pry'){
            $firstFour = substr($select_val, 0, 4);
            $column = $firstFour.$extra;
            $valu = $feesDeter->{$column};
  
          } elseif($firstThree == 'JSS'){
            $lastdigit = substr($select_val, -1);
            $na = 'Jss'.$lastdigit.$extra;
            $column = $na;
             $valu = $feesDeter->{$column};
  
          } elseif($firstThree == 'SS1' || $firstThree == 'SS2' || $firstThree == 'SS3'){
            $column = $firstThree.$extra;
             $valu = $feesDeter->{$column};
          } 
  
            $value = $valu;
        }
        elseif( $selection_made == 'ext_exam'){
          if($select_val == 'Pry6 Exam'){
            $column = 'Com_Entrance';
            $value = $feesDeter->{$column};
          } elseif($select_val == 'Junior WAEC'){
            $column = 'Junior_Waec';
            $value = $feesDeter->{$column};
          } elseif($select_val == 'Senior WAEC'){
            $column = 'Waec_SSCE';
            $value = $feesDeter->{$column};
          } elseif($select_val == 'Senior NECO'){
            $column = 'Neco_Exam';
            $value = $feesDeter->{$column};
          } elseif($select_val == 'WAEC & NECO'){
            $column = 'Napteb_Exam';
            $value = $feesDeter->{$column};
          } else {
            $value = 0;
          }
          
        }
        elseif($selection_made == 'Std_adm_type'){
          if($select_val == 'Day'){
            $value = 0;
          } else {
            $value = $feesDeter->{$select_val};
          }
        }
        
  
        $result['fee'] = $value;
        echo json_encode($result);
    }

    // 
    if(isset($_POST['type']) && $_POST['type'] == 'auto_id_rec'){   
      $res = $conn->query("SELECT * FROM student_records ORDER BY Student_ID DESC LIMIT 1");
      $students = $res->fetch_object();
      $last_id = $students->Student_ID;

      $res1 = $conn->query("SELECT * FROM student_payment ORDER BY Pay_Ref DESC LIMIT 1");
      $students_pay = $res1->fetch_object();
      $last_pay_id = $students_pay->Pay_Ref;

      $result['last_id'] = $last_id;
      $result['pay_id'] = $last_pay_id;
      echo json_encode($result);
    }

    if(isset($_POST['type']) && $_POST['type'] == 'getAmount'){   
      $column = $_POST['column'];
      $sqlins = $conn->query("SELECT current_term,Branch FROM current_term WHERE ID='1'")->fetch_object();
      $gen_term = $sqlins->current_term;
      $gen_branch = $sqlins->Branch;
      $sql = $conn->query("SELECT {$column} FROM fees_determination WHERE Term='$gen_term' AND Branch='$gen_branch'")->fetch_object();

      $result['amount'] = $sql->{$column};
      echo json_encode($result);
    }

?>