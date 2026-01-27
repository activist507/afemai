<?php 
    include('../admin/config/db_connect.php');

        $result = array();

    if(isset($_POST['type']) && $_POST['type'] == 'checkresult'){

        $stud_id = $_POST['stud_id'];
        $pin = $_POST['pin'];
        $branch = $_POST['branch'];
        $class = $_POST['class'];
        $term = $_POST['term'];
        $session = $_POST['session'];
        
        $student_records = $conn->query("SELECT Student_ID,OnlineImage,Fullnames FROM student_records WHERE Student_ID = '$stud_id' AND Student_Pin != '' AND Student_Pin != 0 AND Student_Pin ='$pin'");
        if($student_records->num_rows < 1){
            $result['msg'] = 'Invalid Pin';
            $result['status'] = 'failed';
        } elseif($student_records->num_rows > 0) {
            $student = $student_records->fetch_object();

            $result_table = $conn->query("SELECT id FROM memorization_scores_total WHERE student_id = '$stud_id' AND branch = '$branch' AND class_id = '$class' AND term='$term' AND year ='$session'");
            if($result_table->num_rows > 0){
                $result['status'] = 'success';
                $result['Fullnames'] = $student->Fullnames;
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