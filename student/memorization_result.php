<?php 
    include('../admin/config/db_connect.php');
    if(isset($_GET['ID'])){
        $stud_id = $_GET['ID'];
        $branch = $_GET['branch'];
        $class = $_GET['class'];
        $name = $_GET['name'];
        $term = $_GET['term_tbl'];
        $session = $_GET['session'];

        //term name
        $term_text = $conn->query("SELECT term FROM cbt_term WHERE id = '$term'")->fetch_assoc()['term'];

        ///////////get some students details that is important $subjects
        $student_details =  $conn->query("SELECT Student_Image FROM student_records WHERE Student_ID='$stud_id'")->fetch_object();

        // the breakdown
        $sql = $conn->query("SELECT * FROM memorization_scores 
            WHERE student_id = '$stud_id' AND branch = '$branch' AND class_id = '$class' AND term='$term' AND year ='$session'");
        $result_breakdown = fetch_all_assoc($sql);

        // the summary
        $result_summary = $conn->query("SELECT * FROM memorization_scores_total 
            WHERE student_id = '$stud_id' AND branch = '$branch' AND class_id = '$class' AND term='$term' AND year ='$session'")
            ->fetch_object();

        // total students
        $total_students = $conn->query("SELECT count(id) as total FROM memorization_scores_total 
            WHERE branch = '$branch' AND class_id = '$class' AND term='$term' AND year ='$session'")
            ->fetch_assoc()['total'];

        //branch
        $branches_row =  $conn->query("SELECT * FROM branches WHERE Branch_Name='$branch' ")->fetch_object();

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
    <title> <?= $name.' Result' ?></title>
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
                                    <strong><?= $term_text ?></strong>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-center p-1 flex-1 border h-max border-r-slate-900">
                                    ID:
                                    <strong><?= $stud_id ?></strong>
                                </p>
                                <p class="text-center p-1 flex-1 border h-max border-r-slate-900">
                                    CLASS:
                                   <strong> <?= showClassName($class) ?> </strong>
                                </p>
                                <p class="text-center p-1 flex-1 border h-max border-r-slate-900">
                                    POSITION:
                                    <strong><?= $result_summary->class_pos  ?></strong>
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
                                    <?= $name ?>
                                </p>
                                <p class="text-center p-1 flex-1 border h-max border-r-slate-900 font-bold uppercase">
                                    Session:
                                    <?= $result_summary->year ?>
                                </p>
                                <p class="text-center p-1 flex-1 border h-max border-r-slate-900" dir="rtl">
                                    
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
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    Class Submission (20)
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    Home Practice (20)
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    Project Presentation (20)
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    Examination (40)
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    Total (100)
                                </p>
                                <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                    Grade
                                </p>
                            </div>

                            <!-- result section -->
                            <?php foreach($result_breakdown as $breakdown):?>
                                <div class="border border-slate-900 flex items-center">
                                    <p class="text-left p-1 w-3/12 border h-max border-r-slate-900">
                                        <?= showSubjectName($breakdown['subject_id']) ?>
                                    </p>
                                    <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                        <?= $breakdown['test1'] ?>
                                    </p>
                                    <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                        <?= $breakdown['test2'] ?>
                                    </p>
                                    <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                        <?= $breakdown['obj'] ?>
                                    </p>
                                    <p class="text-center p-1 w-2/12 border h-max border-r-slate-900 bg-red-100">
                                        <?= $breakdown['theory'] ?>
                                    </p>
                                    <p class="text-center p-1 w-2/12 border h-max border-r-slate-900 bg-yellow-100">
                                        <?= $breakdown['total_score'] ?>
                                    </p>
                                    <p class="text-center p-1 w-2/12 border h-max border-r-slate-900">
                                        <?= $breakdown['sub_grade'] ?>
                                    </p>
                                </div>
                            <?php endforeach;?>
                            
                            <!-- @include('partials._resultSummary') -->
                            <div class="border border-slate-900 flex items-center">
                                <p
                                    class="text-center p-1 flex-1 border h-max border-r-slate-900 font-bold bg-slate-900 text-slate-50">
                                    RESULT SUMMARY
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center uppercase">
                                <p class="text-center p-1 w-3/12 flex-1 border-r-2 h-max text-xs font-bold">
                                    Starting Surah:
                                </p>
                                <p class="text-center p-1 w-3/12 border-r-2 h-max text-xs font-bold">
                                    <?= $result_summary->starting_surah ?>
                                </p>

                                <p class="text-center p-1 w-3/12 flex-1 border-r-2 h-max text-xs font-bold">
                                    Ending Surah:
                                </p>
                                <p class="text-center p-1 w-3/12 border-r-2 h-max text-xs font-bold">
                                    <?= $result_summary->ending_surah?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center uppercase">
                                <p class="text-center p-1 w-3/12 flex-1 border-r-2 h-max text-xs font-bold">
                                    DAILY SUBMISSION:
                                </p>
                                <p class="text-center p-1 w-3/12 border-r-2 h-max text-xs font-bold">
                                    <?= $result_summary->daily_submission ?>
                                </p>

                                <p class="text-center p-1 w-3/12 flex-1 border-r-2 h-max text-xs font-bold">
                                    ATTENDANCE:
                                </p>
                                <p class="text-center p-1 w-3/12 border-r-2 h-max text-xs font-bold">
                                    <?= $result_summary->attendance?>
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center uppercase">
                                <p class="text-center p-1 flex-1 border-r-2 h-max text-xs">
                                    total score:
                                </p>
                                <p class="text-center p-1 w-1/12 border-r-2 h-max text-xs font-bold">
                                    <?= $result_summary->total_score ?>
                                </p>

                                <p class="text-center p-1 flex-1 border-r-2 h-max text-xs">
                                    percentage score:
                                </p>
                                <p class="text-center p-1 w-1/12 border-r-2 h-max text-xs font-bold">
                                    <?= $result_summary->average?>%
                                </p>
                            </div>
                            <div class="border border-slate-900 flex items-center">
                                <p class="text-justify p-2 pl-4 w-4/12 border-r-2 h-max text-xs">
                                    TEACHER'S COMMENT:
                                </p>
                                <p class="text-justify p-2 pl-4 w-8/12 border-r-2 h-max text-xs font-bold">
                                    <?= $result_summary->TeacherComment ?>
                                </p>
                            </div>

                            <div class="border border-slate-900 flex items-center">
                                <p class="p-2 pl-4 w-full border-r-2 h-max text-md text-justify">
                                    Mamagement Comment
                                </p>
                                <p class="text-justify p-2 pl-4 w-8/12 border-r-2 h-max text-xs font-bold">
                                    <?=  $result_summary->MgtComment ?>
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