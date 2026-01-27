<?php 
// <!-- Database connection -->
    define ('DB_HOST', 'localhost');
    define ('DB_USER', 'root');
    define ('DB_PASS', '');
    define ('DB_NAME', 'afemai');

    $conn = new MYSQLi(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    if($conn->connect_errno)
    {
        printf("Connection Failed:%s\n", $conn->connect_error);
        exit();
    }
    mysqli_set_charset($conn,"utf8mb4");

    function examTitle($subject_id,$class_id,$assessment_type,$term_id){
        return $subject_id.'-'.$class_id.'-'.$assessment_type.'-'.$term_id;
    }
    function fetch_all_assoc(mysqli_result $result): array
    {
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    function showSubjectName($sub_id){
        global $conn;
        $memorization_subject = $conn->query("SELECT * FROM memorization_subject WHERE id='$sub_id' ")->fetch_object();
        return $memorization_subject->subject;
    }
    function showClassName($class_id){
        global $conn;
        $memorization_class = $conn->query("SELECT * FROM memorization_class WHERE id='$class_id' ")->fetch_object();
        return $memorization_class->class_name;
    }

?>