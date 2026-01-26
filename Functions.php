<?php 
// <!-- functions -->
    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }

    // Database Connection
    include('admin/config/db_connect.php');

    // Staff login functions
    if(isset($_POST['type']) && $_POST['type'] == "stafflogin")
    {
        $staff_ID = htmlspecialchars($_POST['staff_ID']);
        $password = htmlspecialchars($_POST['password']);
        $result = array();

        $staff =  $conn->query("SELECT * FROM staff_records WHERE Staff_ID='$staff_ID' AND new_plain_pass = '$password'");
        $staffDet = $staff->fetch_object();

        if($staff->num_rows < 1)
        {
            $result['success'] = 'failed';
            $result['message'] = 'These credentials do not match our records';
        } 
        else 
        {
            $result['success'] = 'successful';
            $result['message'] = 'Login Successful';

            $role = $staffDet->role;
            $cbt_user_permit =  $conn->query("SELECT * FROM cbt_user_permit WHERE role='$role'");
            $user_permit = $cbt_user_permit->fetch_object();
            $_SESSION['id'] = $staffDet->ID;
            
            if($staffDet->role == 'admin')
            {
                $result['link'] = './admin';
                $_SESSION['authentication'] = 'admin';
            }
            elseif($staffDet->role == 'staff')
            {
                $result['link'] = './staff';
                $_SESSION['authentication'] = 'admin';
            } 
            elseif($staffDet->role == 'registrar') 
            {
                $result['link'] = './admin';
                $_SESSION['authentication'] = 'admin';
            }  
            elseif($staffDet->role == 'accountant') 
            {
                $result['link'] = './admin';
                $_SESSION['authentication'] = 'admin';
            } 
            elseif($staffDet->role == 'users') 
            {
                $result['link'] = './admin';
                $_SESSION['authentication'] = 'admin';
            }  
            // <!---------------------------permission ---------------------------!>
                $_SESSION['all_staff'] = $user_permit->all_staff;
                $_SESSION['act_staff'] = $user_permit->act_staff;
                $_SESSION['staff_pass'] = $user_permit->staff_pass;
                $_SESSION['staff_reg'] = $user_permit->staff_reg;
                $_SESSION['all_stud'] = $user_permit->all_stud;
                $_SESSION['act_stud'] = $user_permit->act_stud;
                $_SESSION['sch_fee'] = $user_permit->sch_fee;
                $_SESSION['stud_reg'] = $user_permit->stud_reg;
                $_SESSION['class_vid_bk'] = $user_permit->class_vid_bk;
                $_SESSION['clas_note'] = $user_permit->clas_note;
                $_SESSION['class_bk'] = $user_permit->class_bk;
                $_SESSION['clas_vid'] = $user_permit->clas_vid;
                $_SESSION['lib_bk'] = $user_permit->lib_bk;
                $_SESSION['lib_vid'] = $user_permit->lib_vid;
                $_SESSION['set_quest'] = $user_permit->set_quest;
                $_SESSION['set_exam_code'] = $user_permit->set_exam_code;
                $_SESSION['send_sms'] = $user_permit->send_sms;
                $_SESSION['print_cbt_res'] = $user_permit->print_cbt_res;
                $_SESSION['disp_cbt_res'] = $user_permit->disp_cbt_res;
                $_SESSION['user_sett'] = $user_permit->user_sett;
                $_SESSION['curr_term'] = $user_permit->curr_term;
                $_SESSION['curr_bulletin'] = $user_permit->curr_bulletin; 
                $_SESSION['mark_register'] = $user_permit->mark_register; 
                $_SESSION['staff_register'] = $user_permit->staff_register; 
                $_SESSION['new_intake'] = $user_permit->new_intake; 
                $_SESSION['delete_intake'] = $user_permit->delete_intake; 
            // <!---------------------------permission ---------------------------!>
        }
        echo json_encode($result);
    }


    // Student login functions
    if(isset($_POST['type']) && $_POST['type'] == "studentlogin")
    {
        $student_ID = htmlspecialchars($_POST['student_ID']);
        $password = htmlspecialchars($_POST['password']);
        $hash = md5($password);
        $result = array();

        $student =  $conn->query("SELECT * FROM student_records WHERE Student_ID='$student_ID' AND new_pass = '$hash'");
        $studentDet = $student->fetch_object();

        if($student->num_rows < 1)
        {
            $result['success'] = 'failed';
            $result['message'] = 'Please enter correct data';
        } 
        else 
        {
            $current_status = $studentDet->Current_Status;
            if($current_status == 'Active'){
                $result['success'] = 'successful';
                $result['link'] = './student';
                $_SESSION['authentication'] = 'student';
                $_SESSION['std_id'] = $studentDet->Student_ID;
            } else {
                $result['success'] = 'unpermitted';
                $result['message'] = 'Seek For administrative permission';
            }
            
                                
        }
        echo json_encode($result);
    }

    // Member login functions
    if(isset($_POST['type']) && $_POST['type'] == "memberLogin")
    {
        $Member_ID = htmlspecialchars($_POST['Member_ID']);
        $password = htmlspecialchars($_POST['password']);
        $result = array();

        $sql =  $conn->prepare("SELECT Current_Status,mem_id,role FROM idea_member WHERE mem_id=? AND password =?");
        $sql->bind_param("is",$Member_ID,$password);
        $sql->execute();
        $memb = $sql->get_result();
        $member = $memb->fetch_object();
        // 
        if(!isset($member->mem_id))
        {
            $result['success'] = 'failed';
            $result['message'] = 'Please enter correct data';
        } 
        else 
        {
            $current_status = $member->Current_Status;
            if($current_status == 'Active'){
                $result['success'] = 'successful';
                $result['link'] = ($member->role == 'Member') ? './member' : './executive';
                $_SESSION['authentication'] = 'member';
                $_SESSION['mem_id'] = $member->mem_id;
            } else {
                $result['success'] = 'unpermitted';
                $result['message'] = 'Seek For administrative permission';
            }
                             
        }
        echo json_encode($result);
    }

    // write Exam functions for submiting score
    if(isset($_POST['type']) && $_POST['type'] == "submitToAnswerTable")
    {
        $format = $conn->query("SELECT id FROM cbt_exam_format WHERE status = 1")->fetch_object();
        $format_id = $format->id;
        $result = array();
        $format = htmlspecialchars($_POST['format']) ?? 0;
        $student_ID = htmlspecialchars($_POST['Student_ID']);
        $Fullnames = htmlspecialchars($_POST['Fullnames']);
        $Student_Class = htmlspecialchars($_POST['Student_Class']);
        $Branch = htmlspecialchars($_POST['Branch']);
        $term = htmlspecialchars($_POST['term']);
        $session = htmlspecialchars($_POST['session']);
        $question_id = htmlspecialchars($_POST['question_id']);
        $subject = htmlspecialchars($_POST['subject']);
        $question_type = htmlspecialchars($_POST['question_type']);
        $exam_type = htmlspecialchars($_POST['exam_type']);

        // end time
            date_default_timezone_set("Africa/Lagos"); 
            // $qst = $conn->query("SELECT end_time FROM questions WHERE question_id = '$question_id'");
            $qst = $conn->query("SELECT end_time FROM exams WHERE id = '$question_id'");
            $qst_row = $qst->fetch_object();
            $currentTime = date("H:i:s"); // Or full timestamp depending on how you're storing end_time
        // 
        //first check if student has written the exam
        $check = $conn->query("SELECT * FROM answers WHERE student_id='$student_ID' AND exam_id = '$question_id'");
        if($check->num_rows > 0){
            $result['message'] = 'You Have Written This Exam';
            $result['link'] = 'no-link';
        } 
        // .$currentTime.'---'.$qst_row->end_time
        // elseif($currentTime > $qst_row->end_time??'00:00:00'){
        //     $result['message'] = 'Sorry, this exam has already ended.';
        //     $result['link'] = 'no-link';
        // }
        else {
        $student =  $conn->query("INSERT INTO answers(student_id,name,class,branch,term,session,exam_id,subject,question_type,exam_type) 
        VALUES ('$student_ID','$Fullnames','$Student_Class','$Branch','$term','$session','$question_id','$subject','$question_type','$exam_type')");
            if($student){
                // if($format_id == 1){
                //     $result['link'] = './?write_exam_original';
                // } 
                // if($format_id == 3){
                //     $result['link'] = "write_examNew.php/?exam_id=".$question_id;

                // } 
                // else {
                //     $result['link'] = './?write_exam';
                // }
                if($format > 2){
                    $result['link'] = './?write_exam_original';
                } else {
                    if($exam_type == 'Theory'){
                        $result['link'] = "write_examNewTheo.php/?exam_id=".$question_id;
                    } 
                    else {
                        $result['link'] = "write_examNew.php/?exam_id=".$question_id;
                    }
                }
                
                
            }
        }

        

        echo json_encode($result);
    }

    // write Exam functions for updating scores  
    if(isset($_POST['type']) && $_POST['type'] == "updateScore"){
        $result_arr = array();
        $student_ID = htmlspecialchars($_POST['Student_ID']);
        $Fullnames = htmlspecialchars($_POST['Fullnames']);
        $Student_Class = htmlspecialchars($_POST['Student_Class']);
        $Branch = htmlspecialchars($_POST['Branch']);
        $term = htmlspecialchars($_POST['term']);
        $session = htmlspecialchars($_POST['session']);
        $question_id = htmlspecialchars($_POST['question_id']);
        $subject = htmlspecialchars($_POST['subject']);
        $stud_score = (int)$_POST['stud_score'];
        $date = date('Y-m-d h:i:s');

        $update_ans =  $conn->query("UPDATE answers SET score = '$stud_score', updated_at='$date' WHERE student_id='$student_ID' AND exam_id = '$question_id'");

        //checking if the student has record in the result table
        $checking =  $conn->query("SELECT * FROM results WHERE student_id='$student_ID'");

        //if no result found
        if($checking->num_rows < 1){
            // insert into the result table     ,'$stud_score'
            $results =  $conn->query("INSERT INTO results(student_id,Name,session,Class,branch,Term,{$subject}) 
            VALUES ('$student_ID','$Fullnames','$session','$Student_Class','$Branch','$term','$stud_score')");
            $result_arr['message'] = 'Score submitted successfully';
        } 
        else { //if result is found
            //update the result table using the student_id
            $update_results =  $conn->query("UPDATE results SET {$subject} = '$stud_score' WHERE student_id='$student_ID' ");
            $result_arr['message'] = 'Score Updated successfully';
        }

        echo json_encode($result_arr);
    }

?>