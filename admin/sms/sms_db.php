<?php
    include('../../admin/config/db_connect.php');
    $result = array(); 
    if(isset($_POST['type']) && $_POST['type'] == 'send_sms'){
        // KUDISMS FORMAT
        $receivers='2348104498676,';
        $msg = 'Testing my method of concating ';
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
        CURLOPT_POSTFIELDS => array('token' => 'MLY9FhORcf2BzkU5ZKe6mnTXIudWsAHqCEVNglDSGtwoxa0p3J4iQjy8v7P1br','senderID' => 'AfemaiInfo','recipients' => $receivers,'message' => $msg,'gateway' => '2'),
        ));
//
        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    function send_payment_sms($conn,$payid,$std_id,$std_name,$phone,$amt_payable,$amt_paid){
        $bal = $amt_payable - $amt_paid;
        $msg = 'ID: '.$std_id.' Name: '.$std_name.' Amt_Paid= '.number_format($amt_paid).' Bal= '.number_format($bal).'. Thanks';
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
        CURLOPT_POSTFIELDS => array('token' => 'MLY9FhORcf2BzkU5ZKe6mnTXIudWsAHqCEVNglDSGtwoxa0p3J4iQjy8v7P1br','senderID' => 'AfemaiInfo','recipients' => $phone,'message' => $msg,'gateway' => '2'),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $responseData = json_decode($response, true);
        if($responseData["status"] != 'error'){
            $clean_balance = str_replace(',', '', $responseData['balance']);
            $student_payment = $conn->query("UPDATE student_payment SET SmsStatus = 'sent' WHERE ID='$payid'");
            return $responseData['cost'].'~1~'.$clean_balance;
        } else {
            return '0~0~0';
        }
    }

    // sending school fees message to a student
    if(isset($_POST['type']) && $_POST['type'] == 'send_std_fees_sms'){
        $student_id = $_POST['std_id'];
        $msg_concat = $_POST['msg_concat'];
        $msg_text = $_POST['msg_text'];
        $sql = $conn->query("SELECT Fullnames,Phone_Number,Current_Balance FROM student_records WHERE student_ID = '$student_id'");
        if($sql->num_rows == 0){
            $response = array();
            $response['msg'] = 'No student with such ID';
            $response['status'] = 'error';
            echo json_encode($response);
        } 
        else{
            $student = $sql->fetch_object();
            if($student->Current_Balance <= 0){
                $response = array();
                $response['msg'] = 'This Student is not owing any balance';
                $response['status'] = 'error';
                echo json_encode($response);
            } else {
                $result['Phone_Number'] = $student->Phone_Number;
                $result['Fullnames'] = $student->Fullnames;
                $receivers=$student->Phone_Number;

                $msg = $msg_concat.'    '.$msg_text;
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
                    CURLOPT_POSTFIELDS => array('token' => 'MLY9FhORcf2BzkU5ZKe6mnTXIudWsAHqCEVNglDSGtwoxa0p3J4iQjy8v7P1br','senderID' => 'AfemaiInfo','recipients' => $receivers,'message' => $msg,'gateway' => '2'),
                ));
        
                $response = curl_exec($curl);
        
                curl_close($curl);
                echo $response;
            }
        }
    }

    // sending general message to a student
    if(isset($_POST['type']) && $_POST['type'] == 'send_std_Msg_sms'){
        $student_id = $_POST['std_id'];
        $msg_text = $_POST['msg_text'];
        $sql = $conn->query("SELECT Fullnames,Phone_Number FROM student_records WHERE student_ID = '$student_id'");
        if($sql->num_rows == 0){
            $response = array();
            $response['msg'] = 'No student with such ID';
            $response['status'] = 'error';

            echo $response;
        } else{
            $student = $sql->fetch_object();
            $result['Phone_Number'] = $student->Phone_Number;
            $result['Fullnames'] = $student->Fullnames;
            $receivers=$student->Phone_Number;
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
                CURLOPT_POSTFIELDS => array('token' => 'MLY9FhORcf2BzkU5ZKe6mnTXIudWsAHqCEVNglDSGtwoxa0p3J4iQjy8v7P1br','senderID' => 'AfemaiInfo','recipients' => $receivers,'message' => $msg_text,'gateway' => '2'),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
            echo $response;
        }
    }

    // get class list to send sms: 
    if(isset($_POST['type']) && $_POST['type'] == 'getClassList'){
        $clas = $_POST['clas'];
        $sms_branch = $_POST['sms_branch'];
        $sms_status = $_POST['sms_status'];
        $sql = $conn->query("SELECT student_ID,Fullnames,Current_Balance,Phone_Number FROM student_records WHERE Current_Status = '$sms_status' AND Branch='$sms_branch' AND Student_Class='$clas' AND Current_Balance > 0");
        if($sql->num_rows == 0){
            $result['query'] = 'false';
        } else {
            $list = fetch_all_assoc($sql);
            $result['studentsList'] = $list;
            $result['query'] = 'true';
        }
        echo json_encode($result);
    }

    // get branch list to send sms:
    if(isset($_POST['type']) && $_POST['type'] == 'getBranchList'){
        $sms_branch = $_POST['sms_branch'];
        $sms_status = $_POST['sms_status'];
        $sql = $conn->query("SELECT student_ID,Fullnames,Current_Balance,Phone_Number FROM student_records WHERE Current_Status = '$sms_status' AND Branch='$sms_branch' AND Current_Balance > 0");
        if($sql->num_rows == 0){
            $result['query'] = 'false';
        } else {
            $list = fetch_all_assoc($sql);
            $result['studentsList'] = $list;
            $result['query'] = 'true';
        }
        echo json_encode($result);
    }

    // get branch list to send school fees sms:
    if(isset($_POST['type']) && $_POST['type'] == 'getBranchListDebtors'){
        $sms_branch = $_POST['sms_branch'];
        $sms_status = $_POST['sms_status'];
        $sql = $conn->query("SELECT student_ID,Fullnames,Current_Balance,Phone_Number FROM student_records WHERE Current_Status = '$sms_status' AND Branch='$sms_branch' AND Current_Balance > 0");
        if($sql->num_rows == 0){
            $result['query'] = 'false';
        } else {
            $list = fetch_all_assoc($sql);
            $result['studentsList'] = $list;
            $result['query'] = 'true';
        }
        echo json_encode($result);
    }

    // get branch list to send school fees sms:
    if(isset($_POST['type']) && $_POST['type'] == 'getBranchAllList'){
        $sms_branch = $_POST['sms_branch'];
        $sms_status = $_POST['sms_status'];
        $sql = $conn->query("SELECT student_ID,Fullnames,Current_Balance,Phone_Number FROM student_records WHERE Current_Status = '$sms_status' AND Branch='$sms_branch'");
        if($sql->num_rows == 0){
            $result['query'] = 'false';
        } else {
            $list = fetch_all_assoc($sql);
            $result['studentsList'] = $list;
            $result['query'] = 'true';
        }
        echo json_encode($result);
    }

    // get class list to send school fees sms: 
    if(isset($_POST['type']) && $_POST['type'] == 'getClassListDebtors'){
        $clas = $_POST['clas'];
        $sms_branch = $_POST['sms_branch'];
        $sms_status = $_POST['sms_status'];
        $sql = $conn->query("SELECT student_ID,Fullnames,Current_Balance,Phone_Number FROM student_records WHERE Current_Status = '$sms_status' AND Branch='$sms_branch' AND Student_Class='$clas' AND Current_Balance > 0");
        if($sql->num_rows == 0){
            $result['query'] = 'false';
        } else {
            $list = fetch_all_assoc($sql);
            $result['studentsList'] = $list;
            $result['query'] = 'true';
        }
        echo json_encode($result);
    }

    // get Staff branch list to send sms:
    if(isset($_POST['type']) && $_POST['type'] == 'getStaffBranchList'){
        $sms_branch = $_POST['sms_branch'];
        $sms_status = $_POST['sms_status'];
        $sql = $conn->query("SELECT Staff_ID,Phone_No FROM staff_records WHERE Staff_Status = '$sms_status' AND Branch='$sms_branch'");
        if($sql->num_rows == 0){
            $result['query'] = 'false';
        } else {
            $list = fetch_all_assoc($sql);
            $result['staffList'] = $list;
            $result['query'] = 'true';
        }
        echo json_encode($result);
    }

    // send individual msg to stud on fees: 
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
            CURLOPT_POSTFIELDS => array('token' => 'MLY9FhORcf2BzkU5ZKe6mnTXIudWsAHqCEVNglDSGtwoxa0p3J4iQjy8v7P1br','senderID' => 'AfemaiInfo','recipients' => $receivers,'message' => $msg,'gateway' => '2'),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }

    // get a student details 
    if(isset($_POST['type']) && $_POST['type'] == 'getStudentDetails'){
        $student_ID = $_POST['student_ID'];
        $sql = $conn->query("SELECT student_ID,Fullnames,Current_Balance FROM student_records WHERE student_ID = '$student_ID'");
        if($sql->num_rows == 0){
            $result['msg'] = 'No student with such ID';
            $result['query'] = 'false';
        } else {
            $student = $sql->fetch_object();
            $result['Fullnames'] = $student->Fullnames;
            $result['student_ID'] = $student->student_ID;
            $result['Balance'] = number_format($student->Current_Balance);
            $result['query'] = 'true';
        }
        echo json_encode($result);
    }

    // get a staff details   
    if(isset($_POST['type']) && $_POST['type'] == 'getStaffDetails'){
        $staff_ID = $_POST['staff_ID'];
        $sql = $conn->query("SELECT Staff_ID,Fullname,Phone_No,Total_Salary,M_Gratuity,Monthly_Savings,Monthly_Loan,Deductions,Amt_Payable,Amt_Paid,Balance FROM staff_records WHERE Staff_ID = '$staff_ID'");
        if($sql->num_rows == 0){
            $result['msg'] = 'No staff with such ID';
            $result['query'] = 'false';
        } else {
            $staff = $sql->fetch_object();
            $result['Fullname'] = $staff->Fullname;
            $result['Staff_ID'] = $staff->Staff_ID;
            $result['Total_Salary'] = number_format($staff->Total_Salary);
            $result['M_Gratuity'] = number_format($staff->M_Gratuity);
            $result['Monthly_Savings'] = number_format($staff->Monthly_Savings);
            $result['Monthly_Loan'] = number_format($staff->Monthly_Loan);
            $result['Deductions'] = number_format($staff->Deductions);
            $result['Amt_Payable'] = number_format($staff->Amt_Payable);
            $result['Amt_Paid'] = number_format($staff->Amt_Paid);
            $result['Balance'] = number_format($staff->Balance);
            $result['query'] = 'true';
        }
        echo json_encode($result);
    }

    // send individual msg to staff: 
    if(isset($_POST['type']) && $_POST['type'] == 'sendStaffSalSms'){
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
            CURLOPT_POSTFIELDS => array('token' => 'MLY9FhORcf2BzkU5ZKe6mnTXIudWsAHqCEVNglDSGtwoxa0p3J4iQjy8v7P1br','senderID' => 'AfemaiInfo','recipients' => $receivers,'message' => $msg,'gateway' => '2'),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }

    // sending individual staff sms
    if(isset($_POST['type']) && $_POST['type'] == 'send_staff_sal_sms'){
        $staff_id = $_POST['staff_id'];
        $msg_concat = $_POST['msg_concat'];
        $msg_text = $_POST['msg_text'];
        $sql = $conn->query("SELECT Fullname,Phone_No FROM staff_records WHERE Staff_ID = '$staff_id'");
        if($sql->num_rows == 0){
            $response = array();
            $response['msg'] = 'No Staff with such ID';
            $response['status'] = 'error';

            echo json_encode($response);
        } else{
            $staff = $sql->fetch_object();
            $result['Phone_No'] = $staff->Phone_No;
            $result['Fullname'] = $staff->Fullname;
            $receivers=$staff->Phone_No;

            $msg = $msg_concat.'    '.$msg_text;
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
                CURLOPT_POSTFIELDS => array('token' => 'MLY9FhORcf2BzkU5ZKe6mnTXIudWsAHqCEVNglDSGtwoxa0p3J4iQjy8v7P1br','senderID' => 'AfemaiInfo','recipients' => $receivers,'message' => $msg,'gateway' => '2'),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
            echo $response;
        }
    }

    // getPaymentList
    if(isset($_POST['type']) && $_POST['type'] == 'getPaymentList'){
        $html = '';

        $sdatee=explode(';', $_POST['ssdatee']);
        $title=$sdatee[1];
        $sdate=explode('~', $sdatee[0]);

        //<!-- Determining the title of the report -->
            if(($title) == 'custom range' || ($title) == 'last 7 days' || ($title) == 'last 30 days' || ($title) == 'this month' || ($title) == 'last month'){
                $dt=new DateTime($sdate[0]);
                $dt1=new DateTime($sdate[1]);
                $date1 = $dt->format('jS M, Y');
                $date2 = $dt1->format('jS M, Y');

                $title = $date1.' - '.$date2;
            }
            else{
                $dt=new DateTime($sdate[0]);
                $title .= ', '.$dt->format('jS M, Y');
            }
        //<!--END Determining the title of the report -->
        
        if(count($sdate) == 1){
            $paymentDate="Date_='".$sdate[0]."' ";
        } else {
            $paymentDate="(Date_ >= '".$sdate[0]."' AND Date_ <= '".$sdate[1]."') ";
        }
        
        $student_payment = fetch_all_assoc($conn->query("SELECT * FROM student_payment WHERE $paymentDate AND Amt_Paid > 0 ORDER BY ID DESC"));
        if(count($student_payment) > 0){
            foreach($student_payment as $std_pay){
                $html .=
                '<tr>
                    <td scope="col" nowrap="nowrap">'.$std_pay["Student_ID"].'</td>
                    <td scope="col" nowrap="nowrap">'. $std_pay["Fullnames"].'</td>
                    <td scope="col" nowrap="nowrap">'. $std_pay["Student_Class"].'</td>
                    <td scope="col" nowrap="nowrap">'. $std_pay["Phone_Number"].'</td>
                    <td scope="col" nowrap="nowrap">'.number_format($std_pay['Amt_Payable']).'
                    </td>
                    <td scope="col" nowrap="nowrap">'.number_format($std_pay['Amt_Paid']).'
                    </td>
                    <td scope="col" nowrap="nowrap">'.number_format($std_pay['Balance']).'
                    </td>
                    <td scope="col" nowrap="nowrap">'. ($std_pay['SmsStatus']).'</td>
                </tr>';
            }
            $result['number'] = count($student_payment);
            $result['status'] = 'success';
            $result['title'] = 'Payment List For '.$title.'' ;
            $result['html'] = $html;
        } else {
            $html .= '<tr>
                        <td colspan="8" class="no-data">No records found.</td>
                    </tr>';
            $result['html'] = $html;
            $result['title'] = 'Payment List For '.$title.'' ;
            $result['status'] = 'success';
        }

        echo json_encode($result);
    }

    //send sms to payment list that has not receive sms
    if(isset($_POST['type']) && $_POST['type'] == 'sendSMSToPaymentList'){
        $sdatee=explode(';', $_POST['ssdatee']);
        $title=$sdatee[1];
        $sdate=explode('~', $sdatee[0]);
        
        if(count($sdate) == 1){
            $paymentDate="Date_='".$sdate[0]."' ";
        } else {
            $paymentDate="(Date_ >= '".$sdate[0]."' AND Date_ <= '".$sdate[1]."') ";
        }
        $totCost = 0;
        $totSuccess = 0;
        $student_payment = fetch_all_assoc($conn->query("SELECT ID,Student_ID,Fullnames,Phone_Number,Amt_Payable,Amt_Paid FROM student_payment WHERE $paymentDate AND Amt_Paid > 0 AND SmsStatus != 'sent'"));
        if(count($student_payment) > 0){
            $count = count($student_payment);
            for ($i = 0; $i < $count; $i++) {
                $std_pay = $student_payment[$i];
                $payid = $std_pay['ID'];
                $std_id = $std_pay['Student_ID'];
                $std_name = $std_pay['Fullnames'];
                $phone = $std_pay['Phone_Number'];
                $amt_payable = $std_pay['Amt_Payable'];
                $amt_paid = $std_pay['Amt_Paid'];

                $return = send_payment_sms($conn, $payid, $std_id, $std_name, $phone, $amt_payable, $amt_paid);
                $arr = explode('~', $return);

                $totCost += (float)$arr[0];
                $totSuccess += (float)$arr[1];

                // Only update balance on the last iteration
                if ($i === $count - 1) {
                    $balance = (float)$arr[2];
                }
            }
            $result['msg'] = $totSuccess . ' messages sent and total cost = ' . $totCost . '. Your new balance = ' . number_format($balance,2);
        }
        else {
            $balance = 0;
            $result['msg'] = $totSuccess.' messages sent and total cost = '.$totCost.'. Your new balance = '.$balance;
        }
        $result['status'] = 'success';
        echo json_encode($result);
    }

    // clear sms of payment list clearSMSOfPaymentList
    if(isset($_POST['type']) && $_POST['type'] == 'clearSMSOfPaymentList'){
        $sdatee=explode(';', $_POST['ssdatee']);
        $title=$sdatee[1];
        $sdate=explode('~', $sdatee[0]);
        
        if(count($sdate) == 1){
            $paymentDate="Date_='".$sdate[0]."' ";
        } else {
            $paymentDate="(Date_ >= '".$sdate[0]."' AND Date_ <= '".$sdate[1]."') ";
        }
        $totCost = 0;
        $totSuccess = 0;
        $student_payment = $conn->query("UPDATE student_payment SET SmsStatus='' WHERE $paymentDate AND SmsStatus = 'sent'");
        $result['msg'] = 'The Sms List Cleared successfully';
        $result['status'] = 'success';
        echo json_encode($result);
    }
?>