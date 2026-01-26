<?php 
    include('../admin/config/db_connect.php');
    if(isset($_GET['ID'])){
        $stud_id = $_GET['ID'];
        $branch = $_GET['branch'];
        $class = $_GET['class'];
        $name = $_GET['name'].' Result';
        $term_tbl = $_GET['term_tbl'];
        $session = $_GET['session'];

        ///////////get some students details that is important $subjects
        $students_record =  $conn->query("SELECT Student_Image FROM student_records WHERE Student_ID='$stud_id' ");
        $student_details = $students_record->fetch_object();

        ///////////get some students details that is important $subjects
        $subjects_record =  $conn->query("SELECT * FROM subjects WHERE C_Session='$session'");
        $subjects = $subjects_record->fetch_object();



        // the result
        $result_table = $conn->query("SELECT * FROM {$term_tbl} WHERE Student_ID = '$stud_id' AND Class = '$class' AND Branch = '$branch' AND C_Session ='$session'");
        $result = $result_table->fetch_object();

        // total students
        $total_count = $conn->query("SELECT count(ID) as total FROM {$term_tbl} WHERE Class = '$class' AND Branch = '$branch' AND C_Session ='$session'");
        $result_count = $total_count->fetch_assoc();
        $total_students = $result_count['total'];

        //branch
        $branches =  $conn->query("SELECT * FROM branches WHERE Branch_Name='$branch' ");
        $branches_row = $branches->fetch_object();

        //this got the image of branches from longblob type 
        $imageData = base64_encode($branches_row->Header_Logo);
        $finfo = finfo_open();
        $mimeType1 = finfo_buffer($finfo, $imageData, FILEINFO_MIME_TYPE);
        finfo_close($finfo);

        //this got the image of student from longblob type 
        $imageData1 = base64_encode($student_details->Student_Image);
        $finfo = finfo_open();
        $mimeType2 = finfo_buffer($finfo, $imageData1, FILEINFO_MIME_TYPE);
        finfo_close($finfo);

        //this got the stamp of branches from longblob type 
        $imageData2 = base64_encode($branches_row->Branch_Sign);
        $finfo = finfo_open();
        $mimeType3 = finfo_buffer($finfo, $imageData2, FILEINFO_MIME_TYPE);
        finfo_close($finfo);
    } else {
        echo "<script>
        window.location = '../'
        </script>";
    }
    header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>

<head>
    <title> <?= $name ?></title>
    <meta name="description"
        content="As an international school we are proud to provide the highest possible standard of education to our students, enabling them to compete in an increasingly competitive global environment.">
    <meta name="viewport" content="width=device-width, initial-scale=0">
    <meta charset="UTF-8">
    <link href="assets/css/main.css" rel='stylesheet' type='text/css'>
    <style>
    .button {
        padding: 10px 10px;
        border-radius: 5px;
        color: #fff;
    }

    body {
        font-family: Arial Unicode MS, Tahoma, sans-serif;
    }

    @media print {

        /* Hide the buttons when printing */
        .print-only {
            display: none;
        }
    }
    </style>
</head>

<body>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <div
                            class="border border-solid border-slate-60 max-w-6xl container mx-auto my-20 verflow-x-auto">
                            <div class="border border-slate-900 flex items-center justify-between p-2">
                                <img src="data:<?php echo $mimeType; ?>;base64,<?php echo $imageData; ?>"
                                    class="w-full h-32" alt="" />
                            </div>

                            <div class="border border-slate-900 flex items-center justify-center text-bold">
                                <p class="text-center p-1">
                                    <?= $branches_row->Additional_Title ?>
                                </p>
                            </div>

                            <div class="border border-slate-900 flex items-center">
                                <p class="text-center p-1 flex-1 border border-slate-900">
                                    Date:
                                    <?= $currentDate = date('d-m-Y') ?>
                                </p>
                                <p class="text-center p-1 flex-1 border border-slate-900 font-bold uppercase">
                                    <?= $branches_row->Result_Title ?>
                                </p>
                                <p class="text-center p-1 flex-1 border border-slate-900">
                                    Term:
                                    <?= $result->Term ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-center p-1 flex-1 border h-max border-r-slate-900">
                                    ID:
                                    <?= $stud_id ?>
                                </p>
                                <p class="text-center p-1 flex-1 border h-max border-r-slate-900 font-bold uppercase">
                                    SECTION:
                                    <?= $result->Section1 ?>
                                </p>
                                <p class="text-center p-1 flex-1 border h-max border-r-slate-900">
                                    CLASS:
                                    <?= $result->Class ?>
                                </p>
                                <p class="text-center p-1 flex-1 border h-max border-r-slate-900">
                                    POSITION:
                                    <?= $result->Position_ ?>
                                </p>
                                <p class="text-center p-1 flex-1 border h-max border-r-slate-900">
                                    OUT OF:
                                    <?= $total_students ?>
                                </p>
                                <p class='text-center p-1 flex-1 border h-max border-r-slate-900'>
                                    <img src="data:<?php echo $mimeType2; ?>;base64,<?php echo $imageData1; ?>"
                                        class="h-12 mx-auto" alt="" />
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-center p-1 flex-1 border h-max border-r-slate-900 rounded">
                                    Fullname:
                                    <?= $result->Fullname ?>
                                </p>
                                <p class="text-center p-1 flex-1 border h-max border-r-slate-900 font-bold uppercase">
                                    Session:
                                    <?= $result->C_Session ?>
                                </p>
                                <p class="text-center p-1 flex-1 border h-max border-r-slate-900" dir="rtl">
                                    <strong><?= htmlspecialchars($result->Fullname_A) ?></strong>
                                    <!-- رشيدة أمين عباس -->
                                </p>
                            </div>

                            <div class="border border-slate-900 flex items-center">
                                <p
                                    class="text-center p-1 flex-1 border h-max border-r-slate-900 font-bold bg-slate-900 text-slate-50">
                                    RESULT BREAKDOWN
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-center p-1 w-3/12 border h-max border-r-slate-900 font-bold">
                                    Subjects
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    Test1
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    Test2
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    Exam
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    Total
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    Grade
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    A.Total
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    G.Grade
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    Remark
                                </p>
                                <p class="text-center p-1 w-3/12 border h-max border-r-slate-900">
                                    Arabic Subjects
                                </p>
                            </div>

                            <!-- result section -->
                            <?php if ($result->Class == 'Pre KG' || $result->Class == 'KG1' || $result->Class == 'KG2' || $result->Class == 'KG3'){?>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ne1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T21 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At1)){
                                            echo $result->At1; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg1 )){
                                            echo $result->Tg1 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re1 )){
                                            echo $result->Re1 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Na1 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ne2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T22 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At2)){
                                            echo $result->At2; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg2 )){
                                            echo $result->Tg2 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re2 )){
                                            echo $result->Re2 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Na2 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ne3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T23 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At3)){
                                            echo $result->At3; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg3 )){
                                            echo $result->Tg3 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re3 )){
                                            echo $result->Re3 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Na3 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ne4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T14 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T24 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At4)){
                                            echo $result->At4; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg4 )){
                                            echo $result->Tg4 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re4 )){
                                            echo $result->Re4 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Na4 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ne5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T15 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T25 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At5)){
                                            echo $result->At5; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg5 )){
                                            echo $result->Tg5 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re5 )){
                                            echo $result->Re5 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Na5 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ne6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T16 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T26 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At6)){
                                            echo $result->At6; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg6 )){
                                            echo $result->Tg6 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re6 )){
                                            echo $result->Re6 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Na6 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ne7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T17 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T27 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At7)){
                                            echo $result->At7; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg7 )){
                                            echo $result->Tg7 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re7 )){
                                            echo $result->Re7 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Na7 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ne8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T18 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T28 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At8)){
                                            echo $result->At8; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg8 )){
                                            echo $result->Tg8 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re8 )){
                                            echo $result->Re8 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Na8 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ne9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T19 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T29 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At9)){
                                            echo $result->At9; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg9 )){
                                            echo $result->Tg9 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re9 )){
                                            echo $result->Re9 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Na9 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ne10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T110 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T210 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At10)){
                                            echo $result->At10; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg10 )){
                                            echo $result->Tg10 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re10 )){
                                            echo $result->Re10 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Na10 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ne11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T111 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T211 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At11)){
                                            echo $result->At11; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg11 )){
                                            echo $result->Tg11 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re11 )){
                                            echo $result->Re11 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Na11 ?>
                                </p>
                            </div>
                            <?php } elseif ($result->Class == 'Pry1' || $result->Class == 'Pry2' || $result->Class == 'Pry3') {?>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Le1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T21 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At1)){
                                            echo $result->At1; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg1 )){
                                            echo $result->Tg1 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re1 )){
                                            echo $result->Re1 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->La1 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Le2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T22 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At2)){
                                            echo $result->At2; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg2 )){
                                            echo $result->Tg2 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re2 )){
                                            echo $result->Re2 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->La2 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Le3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T23 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At3)){
                                            echo $result->At3; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg3 )){
                                            echo $result->Tg3 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re3 )){
                                            echo $result->Re3 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->La3 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Le4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T14 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T24 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At4)){
                                            echo $result->At4; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg4 )){
                                            echo $result->Tg4 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re4 )){
                                            echo $result->Re4 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->La4 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Le5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T15 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T25 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At5)){
                                            echo $result->At5; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg5 )){
                                            echo $result->Tg5 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re5 )){
                                            echo $result->Re5 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->La5 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Le6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T16 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T26 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At6)){
                                            echo $result->At6; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg6 )){
                                            echo $result->Tg6 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re6 )){
                                            echo $result->Re6 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->La6 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Le7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T17 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T27 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At7)){
                                            echo $result->At7; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg7 )){
                                            echo $result->Tg7 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re7 )){
                                            echo $result->Re7 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->La7 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Le8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T18 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T28 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At8)){
                                            echo $result->At8; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg8 )){
                                            echo $result->Tg8 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re8 )){
                                            echo $result->Re8 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->La8 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Le9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T19 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T29 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At9)){
                                            echo $result->At9; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg9 )){
                                            echo $result->Tg9 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re9 )){
                                            echo $result->Re9 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->La9 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Le10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T110 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T210 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At10)){
                                            echo $result->At10; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg10 )){
                                            echo $result->Tg10 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re10 )){
                                            echo $result->Re10 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->La10 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Le11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T111 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T211 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At11)){
                                            echo $result->At11; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg11 )){
                                            echo $result->Tg11 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re11 )){
                                            echo $result->Re11 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->La11 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Le12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T112 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T212 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At12)){
                                            echo $result->At12; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg12 )){
                                            echo $result->Tg12 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re12 )){
                                            echo $result->Re12 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->La12 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Le13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T113 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T213 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At13)){
                                            echo $result->At13; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg13 )){
                                            echo $result->Tg13 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re13 )){
                                            echo $result->Re13 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->La13 ?>
                                </p>
                            </div>
                            <?php } elseif ($result->Class == 'Pry4' || $result->Class == 'Pry5' || $result->Class == 'Pry6'){?>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ue1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T21 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At1)){
                                            echo $result->At1; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg1 )){
                                            echo $result->Tg1 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re1 )){
                                            echo $result->Re1 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ua1 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ue2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T22 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At2)){
                                            echo $result->At2; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg2 )){
                                            echo $result->Tg2 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re2 )){
                                            echo $result->Re2 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ua2 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ue3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T23 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At3)){
                                            echo $result->At3; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg3 )){
                                            echo $result->Tg3 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re3 )){
                                            echo $result->Re3 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ua3 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ue4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T14 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T24 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At4)){
                                            echo $result->At4; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg4 )){
                                            echo $result->Tg4 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re4 )){
                                            echo $result->Re4 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ua4 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ue5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T15 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T25 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At5)){
                                            echo $result->At5; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg5 )){
                                            echo $result->Tg5 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re5 )){
                                            echo $result->Re5 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ua5 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ue6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T16 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T26 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At6)){
                                            echo $result->At6; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg6 )){
                                            echo $result->Tg6 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re6 )){
                                            echo $result->Re6 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ua6 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ue7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T17 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T27 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At7)){
                                            echo $result->At7; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg7 )){
                                            echo $result->Tg7 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re7 )){
                                            echo $result->Re7 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ua7 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ue8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T18 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T28 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At8)){
                                            echo $result->At8; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg8 )){
                                            echo $result->Tg8 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re8 )){
                                            echo $result->Re8 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ua8 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ue9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T19 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T29 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At9)){
                                            echo $result->At9; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg9 )){
                                            echo $result->Tg9 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re9 )){
                                            echo $result->Re9 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ua9 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ue10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T110 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T210 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At10)){
                                            echo $result->At10; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg10 )){
                                            echo $result->Tg10 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re10 )){
                                            echo $result->Re10 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ua10 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ue11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T111 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T211 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At11)){
                                            echo $result->At11; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg11 )){
                                            echo $result->Tg11 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re11 )){
                                            echo $result->Re11 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ua11 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ue12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T112 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T212 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At12)){
                                            echo $result->At12; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg12 )){
                                            echo $result->Tg12 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re12 )){
                                            echo $result->Re12 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ua12 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ue13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T113 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T213 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At13)){
                                            echo $result->At13; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg13 )){
                                            echo $result->Tg13 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re13 )){
                                            echo $result->Re13 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ua13 ?>
                                </p>
                            </div>
                            <?php } elseif ($result->Class == 'JSS1' || $result->Class == 'JSS2' || $result->Class == 'JSS3') {?>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T21 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At1)){
                                            echo $result->At1; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg1 )){
                                            echo $result->Tg1 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re1 )){
                                            echo $result->Re1 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja1 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T22 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At2)){
                                            echo $result->At2; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg2 )){
                                            echo $result->Tg2 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re2 )){
                                            echo $result->Re2 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja2 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T23 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At3)){
                                            echo $result->At3; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg3 )){
                                            echo $result->Tg3 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re3 )){
                                            echo $result->Re3 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja3 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T14 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T24 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At4)){
                                            echo $result->At4; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg4 )){
                                            echo $result->Tg4 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re4 )){
                                            echo $result->Re4 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja4 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T15 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T25 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At5)){
                                            echo $result->At5; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg5 )){
                                            echo $result->Tg5 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re5 )){
                                            echo $result->Re5 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja5 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T16 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T26 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At6)){
                                            echo $result->At6; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg6 )){
                                            echo $result->Tg6 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re6 )){
                                            echo $result->Re6 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja6 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T17 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T27 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At7)){
                                            echo $result->At7; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg7 )){
                                            echo $result->Tg7 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re7 )){
                                            echo $result->Re7 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja7 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T18 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T28 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At8)){
                                            echo $result->At8; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg8 )){
                                            echo $result->Tg8 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re8 )){
                                            echo $result->Re8 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja8 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T19 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T29 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At9)){
                                            echo $result->At9; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg9 )){
                                            echo $result->Tg9 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re9 )){
                                            echo $result->Re9 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja9 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T110 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T210 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At10)){
                                            echo $result->At10; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg10 )){
                                            echo $result->Tg10 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re10 )){
                                            echo $result->Re10 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja10 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T111 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T211 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At11)){
                                            echo $result->At11; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg11 )){
                                            echo $result->Tg11 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re11 )){
                                            echo $result->Re11 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja11 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T112 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T212 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At12)){
                                            echo $result->At12; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg12 )){
                                            echo $result->Tg12 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re12 )){
                                            echo $result->Re12 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja12 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T113 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T213 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At13)){
                                            echo $result->At13; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg13 )){
                                            echo $result->Tg13 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re13 )){
                                            echo $result->Re13 ; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja13 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je14 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T114 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T214 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E14 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To14 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G14 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At14)){
                                            echo $result->At14; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg14)){
                                            echo $result->Tg14; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re14)){
                                            echo $result->Re14; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja14 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je15 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T115 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T215 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E15 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To15 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G15 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At15)){
                                            echo $result->At15; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg15)){
                                            echo $result->Tg15; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re15)){
                                            echo $result->Re15; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja15 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je16 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T116 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T216 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E16 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To16 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G16 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At16)){
                                            echo $result->At16; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg16)){
                                            echo $result->Tg16; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re16)){
                                            echo $result->Re16; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja16 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je17 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T117 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T217 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E17 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To17 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G17 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At17)){
                                            echo $result->At17; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg17)){
                                            echo $result->Tg17; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re17)){
                                            echo $result->Re17; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja17 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je18 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T118 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T218 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E18 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To18 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G18 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At18)){
                                            echo $result->At18; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg18)){
                                            echo $result->Tg18; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re18)){
                                            echo $result->Re18; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja18 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Je19 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T119 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T219 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E19 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To19 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G19 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At19)){
                                            echo $result->At19; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg19)){
                                            echo $result->Tg19; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re19)){
                                            echo $result->Re19; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Ja19 ?>
                                </p>
                            </div>
                            <?php } elseif ($result->Class == 'SS1' || $result->Class == 'SS2' || $result->Class == 'SS3'){?>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T21 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G1 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At1)){
                                            echo $result->At1; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg1)){
                                            echo $result->Tg1; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re1)){
                                            echo $result->Re1; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <strong><?= $subjects->Sa1 ?></strong>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T22 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G2 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At2)){
                                            echo $result->At2; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg2)){
                                            echo $result->Tg2; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re2)){
                                            echo $result->Re2; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa2 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T23 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G3 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At3)){
                                            echo $result->At3; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg3)){
                                            echo $result->Tg3; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re3)){
                                            echo $result->Re3; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa3 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T14 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T24 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G4 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At4)){
                                            echo $result->At4; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg4)){
                                            echo $result->Tg4; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re4)){
                                            echo $result->Re4; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa4 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T15 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T25 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G5 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At5)){
                                            echo $result->At5; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg5)){
                                            echo $result->Tg5; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re5)){
                                            echo $result->Re5; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa5 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T16 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T26 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G6 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At6)){
                                            echo $result->At6; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg6)){
                                            echo $result->Tg6; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re6)){
                                            echo $result->Re6; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa6 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T17 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T27 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G7 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At7)){
                                            echo $result->At7; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg7)){
                                            echo $result->Tg7; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re7)){
                                            echo $result->Re7; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa7 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T18 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T28 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G8 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At8)){
                                            echo $result->At8; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg8)){
                                            echo $result->Tg8; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re8)){
                                            echo $result->Re8; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa8 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T19 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T29 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G9 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At9)){
                                            echo $result->At9; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg9)){
                                            echo $result->Tg9; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re9)){
                                            echo $result->Re9; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa9 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T110 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T210 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G10 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At10)){
                                            echo $result->At10; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg10)){
                                            echo $result->Tg10; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re10)){
                                            echo $result->Re10; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa10 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T111 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T211 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G11 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At11)){
                                            echo $result->At11; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg11)){
                                            echo $result->Tg11; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re11)){
                                            echo $result->Re11; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa11 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T112 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T212 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G12 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At12)){
                                            echo $result->At12; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg12)){
                                            echo $result->Tg12; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re12)){
                                            echo $result->Re12; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa12 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T113 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T213 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G13 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At13)){
                                            echo $result->At13; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg13)){
                                            echo $result->Tg13; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re13)){
                                            echo $result->Re13; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa13 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se14 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T114 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T214 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E14 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To14 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G14 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At14)){
                                            echo $result->At14; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg14)){
                                            echo $result->Tg14; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re14)){
                                            echo $result->Re14; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa14 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se15 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T115 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T215 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E15 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To15 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G15 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At15)){
                                            echo $result->At15; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg15)){
                                            echo $result->Tg15; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re15)){
                                            echo $result->Re15; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa15 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se16 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T116 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T216 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E16 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To16 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G16 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At16)){
                                            echo $result->At16; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg16)){
                                            echo $result->Tg16; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re16)){
                                            echo $result->Re16; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa16 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se17 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T117 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T217 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E17 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To17 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G17 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At17)){
                                            echo $result->At17; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg17)){
                                            echo $result->Tg17; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re17)){
                                            echo $result->Re17; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa17 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se18 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T118 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T218 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E18 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To18 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G18 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At18)){
                                            echo $result->At18; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg18)){
                                            echo $result->Tg18; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re18)){
                                            echo $result->Re18; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa18 ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Se19 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T119 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->T219 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?= $result->E19 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-red-100">
                                    <?= $result->To19 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-100">
                                    <?= $result->G19 ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->At19)){
                                            echo $result->At19; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-1/12 border h-max border-r-slate-900 bg-yellow-200">
                                    <?php 
                                        if(isset($result->Tg19)){
                                            echo $result->Tg19; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    <?php 
                                        if(isset($result->Re19)){
                                            echo $result->Re19; 
                                        } 
                                    ?>
                                </p>
                                <p class="text-right p-1 w-3/12 border h-max border-r-slate-900">
                                    <?= $subjects->Sa19 ?>
                                </p>
                            </div>
                            <?php }?>
                            <!-- resultBreakdown end -->

                            <!-- @include('partials._resultSummary') -->
                            <div class="border border-slate-900 flex items-center">
                                <p
                                    class="text-center p-1 flex-1 border h-max border-r-slate-900 font-bold bg-slate-900 text-slate-50">
                                    RESULT SUMMARY
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center uppercase">
                                <p class="text-center p-1 flex-1 border-r-2 h-max text-xs">
                                    total score:
                                </p>
                                <p class="text-center p-1 w-1/12 border-r-2 h-max text-xs font-bold">
                                    <?= $result->T_Score ?>
                                </p>

                                <?php if ($result->Term == '3rd Term') { ?>
                                <p class="text-center p-1 flex-1 border-r-2 h-max text-xs">
                                    Average total:
                                </p>
                                <p class="text-center p-1 w-1/12 border-r-2 h-max text-xs font-bold">
                                    <?= $result->Third_Result ?>
                                </p>
                                <?php }?>

                                <p class="text-center p-1 flex-1 border-r-2 h-max text-xs">
                                    percentage score:
                                </p>
                                <p class="text-center p-1 w-1/12 border-r-2 h-max text-xs font-bold">
                                    <?= $result->Percent_Score ?>%
                                </p>
                                <p class="text-center p-1 flex-1 border-r-2 h-max text-xs">
                                    subject failed:
                                </p>
                                <p class="text-center p-1 w-1/12 border-r-2 h-max text-xs font-bold">
                                    <?= $result->Subjects_Failed ?>
                                </p>
                                <p class="text-center p-1 flex-1 border-r-2 h-max text-xs">
                                    core subject failed:
                                </p>
                                <p class="text-center p-1 w-1/12 border-r-2 h-max text-xs font-bold">
                                    <?= $result->Core_Subjects ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center uppercase">
                                <p class="text-center p-1 flex-1 border-r-2 h-max text-xs">
                                    termly grade:
                                </p>
                                <p class="text-center p-1 flex-1 border-r-2 h-max text-xs font-bold">
                                    <?= $result->Termly_Grade ?>
                                </p>
                                <p class="text-center p-1 flex-1 border-r-2 h-max text-xs">
                                    termly remarks:
                                </p>
                                <p class="text-center p-1 flex-1 border-r-2 h-max text-xs font-bold">
                                    <?= $result->Termly_Rem ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-justify p-2 pl-4 w-4/12 border-r-2 h-max text-xs">
                                    TEACHER'S COMMENT:
                                </p>
                                <p class="text-justify p-2 pl-4 w-8/12 border-r-2 h-max text-xs font-bold">
                                    <?= $result->Teachers_Comment ?>
                                </p>
                            </div>

                            <div class="border border-slate-900 flex items-center">
                                <p class="p-2 pl-4 w-full border-r-2 h-max text-md text-justify">
                                    Mamagement Comment
                                </p>
                                <p class="text-justify p-2 pl-4 w-8/12 border-r-2 h-max text-xs font-bold">
                                    <?= $result->Mgt_Comment ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="p-2 pl-4 w-full border-r-2 h-max text-md text-justify">
                                    <?= $branches_row->NextTerm ?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="p-2 pl-4 flex-1 border-r-2 h-max text-md text-center">
                                    Phone: <?= $branches_row->Branch_Phone ?>
                                </p>
                                <p class="p-2 pl-4 flex-1 border-r-2 h-max text-md text-center">
                                    Email:
                                    <?= $branches_row->Branch_Email . ' || Website:  ' . $branches_row->Branch_Website ?>
                                </p>
                                <p class="p-2 pl-4 border-r-2 h-max text-md text-right">
                                    <img src="data:<?php echo $mimeType3; ?>;base64,<?php echo $imageData2; ?>"
                                        class="w-20 h-20" alt="" />
                                </p>
                            </div>
                            <!-- summary end -->

                            <div style="margin-top: 1rem;  padding: 1rem; display: flex; gap: 10px;" class="print-only">
                                <a href="./" class="button" style="background: #9a031e;">Go Back</a>
                                <button class="button" style="background: #0f4c5c;" onclick="printPage()">Print
                                    Result</button>
                            </div>
                        </div>

                    </table>
                </div>
            </div>

        </div>


    </div>


</body>

</html>
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<script>
function printPage() {
    // Exclude the button section from print
    document.querySelector('.print-only').style.display = 'none';
    window.print();
    // Restore the button section after printing
    document.querySelector('.print-only').style.display = 'flex';
}
</script>