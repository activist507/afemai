<?php 
    include('../admin/config/db_connect.php');

        $result = array();

    //getting book to view
    if(isset($_POST['type']) && $_POST['type'] == 'checkresult'){

        $id = $_POST['id'];
        $stud_id = $_POST['stud_id'];
        $pin = $_POST['pin'];
        $branch = $_POST['branch'];
        $class = $_POST['class'];
        $term_tbl = $_POST['term_tbl'];
        $session = $_POST['session'];
        
        $student_records = $conn->query("SELECT Student_ID,OnlineImage,Fullnames FROM student_records WHERE Student_ID = '$stud_id' AND Student_Pin != '' AND Student_Pin != 0 AND Student_Pin ='$pin'");
        if($student_records->num_rows < 1){
            $result['msg'] = 'Invalid Pin';
            $result['status'] = 'failed';
        } elseif($student_records->num_rows > 0) {
            $student = $student_records->fetch_object();

            $result_table = $conn->query("SELECT ID FROM {$term_tbl} WHERE Student_ID = '$stud_id' AND Class = '$class' AND Branch = '$branch' AND C_Session ='$session'");
            if($result_table->num_rows > 0){
                $result['Student_ID'] = $student->Student_ID;
                $result['OnlineImage'] = $student->OnlineImage;
                $result['Fullnames'] = $student->Fullnames;
                $result['status'] = 'success';
            } else {
                $result['msg'] = 'There is no result for the selected field';
                $result['status'] = 'failed';
            } 
        } else {
            $result['msg'] = 'Error';
            $result['status'] = 'failed';
        }
        echo json_encode($result);
    }
?>