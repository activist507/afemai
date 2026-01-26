<?php


    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    include('config/db_connect.php');
    if(!isset($_SESSION['authentication']))
    {
        echo "<script>
        window.location = '../'
        </script>";
    }

    if( $_SESSION['authentication'] != 'admin')
    {
        echo "<script>
        window.location = '../'
        </script>";
    }
    if(isset($_SESSION['id'])){
        $id = $_SESSION['id'];
        $staff_records =  $conn->query("SELECT * FROM staff_records WHERE ID='$id'");
        $staffDet = $staff_records->fetch_object();
        $name = $staffDet->Fullname;
        $role = $staffDet->role;
        $staff_branch = $staffDet->Branch;

        //image of staff
        $imageData1 = base64_encode($staffDet->Image);
        $finfo = finfo_open();
        $mimeType2 = finfo_buffer($finfo, $imageData1, FILEINFO_MIME_TYPE);
        finfo_close($finfo);
    }

    $setupsSQL = $conn->query("SELECT * FROM cbt_calendar");
    if($setupsSQL->num_rows > 0){
        $setup = $setupsSQL->fetch_object();
        $id = $setup->id;
        $title = $setup->title;
        $stat = $setup->status;
        $date = $setup->date;
        $linkPdf = '../storege/setup_pdf/'.$setup->homepage_pdf;
    } else {
        $id = 0;
        $title = '';
        $stat = 'No status';
        $date = '2024-10-10';
        $linkPdf = ''; //put the link of the dummy pdf to create
    }

    $today = date('Y-m-d');$debtors = 0;
    $result = $conn->query("SELECT Next_Date FROM raaid_rentage");
    $raaid_rentage = fetch_all_assoc($result);
    foreach($raaid_rentage as $tenant){
        $twoWeeksBefore = date('Y-m-d', strtotime($tenant['Next_Date'] . ' -2 weeks'));
        if($today >= $twoWeeksBefore ){
          $debtors++;
        } 
        
    }
    
    
    $result = $conn->query("SELECT * FROM branches");
    $branches_rows = fetch_all_assoc($result);

    $studentss = $conn->query("SELECT Student_ID,Fullnames,Student_Class,plain_password,Branch,Phone_Number,Amount_Payable,Gen_Discount,Amount_Paid,Current_Balance, new_plain_pass FROM student_records WHERE Current_Status = 'Active'");
    $fetchings = fetch_all_assoc($studentss);
    $stud_total_all = count($fetchings);

    $stafff = $conn->query("SELECT * FROM staff_records WHERE Staff_Status = 'Active'");
    $fetchingss = fetch_all_assoc($stafff);
    $staff_total_all = count($fetchingss);

    
    $sqlSession = $conn->query("SELECT * FROM tblsession");
    $sqlTerm = $conn->query("SELECT * FROM cbt_term");
    $sqlbranchdetails = $conn->query("SELECT * FROM current_term WHERE ID = 1");
    $branchdetails = $sqlbranchdetails->fetch_object();
    $gen_term = $branchdetails->Current_Term;
    $gen_branch = $branchdetails-> Branch;
    $gen_session = $branchdetails->Current_Session;
    $gen_ann = $branchdetails->announcement;
    $gen_msg = $branchdetails->gen_msg;

	function staff_class_student(string $class,$conn,$gen_branch): array
	{
		$tot = $conn->query("SELECT Student_ID,Fullnames,Current_Balance  FROM student_records WHERE Current_Status = 'Active' AND Student_Class = '$class'  AND Branch ='$gen_branch'")->fetch_all(MYSQLI_ASSOC);
		return $tot;
	}

    function staff_list($conn,$gen_branch): array
    {
        $result = $conn->query("SELECT Staff_ID, Fullname FROM staff_records WHERE Staff_Status = 'Active' AND Branch ='$gen_branch' ORDER BY Branch DESC, Staff_ID ASC
        ");

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="../assets/css/daterangepicker.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/toastr.min.css" rel="stylesheet">
    <link href="assets/css/jquery-confirm.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/moment.min.js"></script>
    <script src="../assets/js/daterangepicker.js"></script>
    <style>
    .header .search-bar {
        min-width: 200px;
        padding: 0 20px;
    }
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="./" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">ADMIN</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <!-- End Search Bar -->

        <!-- TO CONTROL DELETE BUTTON -->
        <input type="hidden" id="allowdel" value="<?= $_SESSION['delete_intake']?>">

        <div class="search-bar">
            <select name="gen_Term" id="gen_Term" class="form-control">
                <option value="<?= $gen_term?>"><?= $gen_term?></option>
                <?php while($term = $sqlTerm->fetch_object()){?>
                <option value="<?= $term->term?>"><?= $term->term?>
                </option>
                <?php }?>
            </select>
        </div>

        <div class="search-bar">
            <select name="gen_branch" id="gen_branch" class="form-control">
                <option value="<?= $gen_branch?>"><?= $gen_branch?></option>
                <?php foreach($branches_rows as $branc){?>
                <option value="<?= $branc['Branch_Name']?>"><?= $branc['Branch_Name']?></option>
                <?php }?>
            </select>
        </div>

        <div class="search-bar">
            <select name="gen_Session" id="gen_Session" class="form-control">
                <option value="<?= $gen_session?>"><?= $gen_session?></option>
                <?php while($session = $sqlSession->fetch_object()){?>
                <option value="<?= $session->csession?>">
                    <?= $session->csession?></option>
                <?php }?>
            </select>
        </div>


        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li>
                <!-- End Search Icon-->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="data:<?php echo $mimeType2; ?>;base64,<?php echo $imageData1; ?>"
                            class="rounded-circle" alt="" />
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $name?></span>
                    </a>
                    <!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= $name?></h6>
                            <span><?= $role?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                <i class="bi bi-question-circle"></i>
                                <span>Need Help?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header>
    <!-- End Header -->

    <!-- 1- Sidebar admin addressbar links -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="./">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <!-- End Dashboard Nav -->

            <?php if($role == 'admin'):?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="./?rentage">
                        <i class="bi bi-file-earmark"></i>
                        <span>Rentage</span><i class="ms-auto text-danger"><?= $debtors?></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="./?idea">
                        <i class="bi bi-bar-chart-line"></i></i><span>Idea Reg</span>
                    </a>
                </li>
            <?php endif;?>

            <li class="nav-item">
                <a class="nav-link collapsed" href="./?statistics">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Statistics</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#charts-register" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-pencil-square"></i><span>Register</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="charts-register" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <?php if($_SESSION['mark_register'] == 1):?>
                    <li>
                        <a href="./?markRegister">
                            <i class="bi bi-circle"></i><span>Mark Stud Register</span>
                        </a>
                    </li>
                    <li>
                        <a href="./?checkRegister">
                            <i class="bi bi-circle"></i><span>Check Stud Register</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['staff_register'] == 1):?>
                    <li>
                        <a href="./?staff_register">
                            <i class="bi bi-circle"></i><span>Mark Staff Register</span>
                        </a>
                    </li>
                    <li>
                        <a href="./?check_staff_register">
                            <i class="bi bi-circle"></i><span>Check Staff Register</span>
                        </a>
                    </li>
                    <?php endif;?>
                </ul>
            </li>
            <!-- Statistics -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Staff</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <?php if($_SESSION['all_staff'] == 1):?>
                    <li>
                        <a href="./?all_staff">
                            <i class="bi bi-circle"></i><span>All Staff</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['act_staff'] == 1):?>
                    <li>
                        <a href="./?a_staff">
                            <i class="bi bi-circle"></i><span>Active Staff</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['staff_pass'] == 1):?>
                    <li>
                        <a href="./?staff_pass">
                            <i class="bi bi-circle"></i><span>Timetable</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['staff_reg'] == 1):?>
                    <li>
                        <a href="./?staff_reg">
                            <i class="bi bi-circle"></i><span>Staff Registration</span>
                        </a>
                    </li>
                    <li>
                        <a href="./?staff_eval">
                            <i class="bi bi-circle"></i><span>Staff Evaluation</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <!-- End of codes -->
                </ul>
            </li>
            <!-- End staff Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Student</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <?php if($_SESSION['all_stud'] == 1):?>
                    <li>
                        <a href="./?all_students">
                            <i class="bi bi-circle"></i><span>All Students</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['act_stud'] == 1):?>
                    <li>
                        <a href="./?a_student">
                            <i class="bi bi-circle"></i><span>Active Students</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['sch_fee'] == 1):?>
                    <li>
                        <a href="./?stud_sch_fees">
                            <i class="bi bi-circle"></i><span>Daily School Fees</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['stud_reg'] == 1):?>
                    <li>
                        <a href="./?stud_reg">
                            <i class="bi bi-circle"></i><span>Student Registration</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['new_intake'] == 1):?>
                    <li>
                        <a href="./?new_intake">
                            <i class="bi bi-circle"></i><span>New Intake</span>
                        </a>
                    </li>
                    <?php endif;?>
                </ul>
            </li>
            <!-- End Student Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span>Academic Tools</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <?php if($_SESSION['class_vid_bk'] == 1):?>
                    <li>
                        <a href="./?c_vid_bk">
                            <i class="bi bi-circle"></i><span>Class Video & Book</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['clas_note'] == 1):?>
                    <li>
                        <a href="./?c_notes">
                            <i class="bi bi-circle"></i><span>Class Notes</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['class_bk'] == 1):?>
                    <li>
                        <a href="./?c_books">
                            <i class="bi bi-circle"></i><span>Class Books</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['clas_vid'] == 1):?>
                    <li>
                        <a href="./?c_videos">
                            <i class="bi bi-circle"></i><span>Class Videos</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['lib_bk'] == 1):?>
                    <li>
                        <a href="./?l_books">
                            <i class="bi bi-circle"></i><span>Library Books</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['lib_vid'] == 1):?>
                    <li>
                        <a href="./?l_videos">
                            <i class="bi bi-circle"></i><span>Library Videos</span>
                        </a>
                    </li>
                    <?php endif;?>
                </ul>
            </li>
            <!-- End Academic Tools Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-bar-chart"></i><span>Exams & Records</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="charts-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="./?set_exam_code">
                            <i class="bi bi-circle"></i><span>Set Exam Codes</span>
                        </a>
                    </li>
                    <?php if($_SESSION['set_quest'] == 1):?>
                    <li>
                        <a href="./?set_question">
                            <i class="bi bi-circle"></i><span>Set PDF Question</span>
                        </a>
                    </li>
                    <li>
                        <a href="exam/exam.php">
                            <i class="bi bi-circle"></i><span>Set DOC Questions</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['set_exam_code'] == 1):?>
                    <?php endif;?>
                </ul>
            </li>
            <!-- End Exam & records Nav -->

            <?php if($_SESSION['send_sms'] == 1):?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="./?sms">
                        <i class="bi bi-bar-chart-line"></i></i><span>Send SMS</span>
                    </a>
                </li>
            <?php endif;?>
            <!-- End SMS Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#charts-nav2" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-bar-chart"></i><span>Manage Results</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="charts-nav2" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="./?res_set">
                            <i class="bi bi-circle"></i><span>Result Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="./?res_set_memo">
                            <i class="bi bi-circle"></i><span>Memorization Result Settings</span>
                        </a>
                    </li>
                    <?php if($_SESSION['print_cbt_res'] == 1):?>
                    <li>
                        <a href="./?p_cbt_res">
                            <i class="bi bi-circle"></i><span>Print CBT Result</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['disp_cbt_res'] == 1):?>
                    <li>
                        <a href="./?d_cbt_res">
                            <i class="bi bi-circle"></i><span>Display CBT Result</span>
                        </a>
                    </li>
                    <?php endif;?>
                </ul>
            </li>
            <!-- End Manage Results Nav -->
            <?php if($_SESSION['user_sett'] == 1):?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="./?user_settings">
                    <i class="bi bi-gear"></i>
                    <span>Users Settings</span>
                </a>
            </li>
            <?php endif;?>
            <!-- Print fees nav -->
            <!-- End Send SMS Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav3" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span>Settings</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav3" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <?php if($_SESSION['curr_term'] == 1):?>
                    <li>
                        <a href="./?curr_term">
                            <i class="bi bi-circle"></i><span>Current Term</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['curr_bulletin'] == 1):?>
                    <li>
                        <a href="./?bull_sett">
                            <i class="bi bi-circle"></i><span>Current Bulletin</span>
                        </a>
                    </li>
                    <li>
                        <a href="./?sch_calendar">
                            <i class="bi bi-circle"></i><span>Sch Calendar</span>
                        </a>
                    </li>
                    <?php endif;?>
                </ul>
            </li>
            <!-- End Settings Nav -->
            
            <li class="nav-item">
                <a class="nav-link collapsed" href="./?logout">
                    <i class="bi bi-file-earmark"></i>
                    <span>Logout</span>
                </a>
            </li>
            <!-- End Blank Page Nav -->
        </ul>

    </aside>
    <!-- End Sidebar-->

    <!-- 2- admin php file links -->
    <?php 
    if(isset($_GET['l_videos']))
    {
        require_once 'videos_books/library_vidoes.php';
    } 
    elseif(isset($_GET['statistics'])){
        require_once 'statistics.php';
    }
	elseif(isset($_GET['markRegister'])){
        require_once 'markRegister.php';
    }
	elseif(isset($_GET['checkRegister'])){
        require_once 'checkRegister.php';
    }
    elseif(isset($_GET['all_students'])){
        require_once 'adm_student/allStudents.php';
    }
	elseif(isset($_GET['new_intake'])){
        require_once 'adm_student/new_intake.php';
    }
    elseif(isset($_GET['a_student'])){
        require_once 'adm_student/act_students.php';
    }
	elseif(isset($_GET['a_staff'])){
        require_once 'adm_staff/act_staff.php';
    }
    
    elseif(isset($_GET['stud_sch_fees'])){
        require_once 'adm_student/stud_sch_fees.php';
    }
    
    elseif(isset($_GET['staff_reg'])){
        require_once 'adm_staff/staff_reg.php';
    }
	elseif(isset($_GET['staff_eval'])){
        require_once 'adm_staff/staff_eval.php';
    }
	elseif(isset($_GET['staff_register'])){
        require_once 'adm_staff/markRegister.php';
    }
	elseif(isset($_GET['check_staff_register'])){
        require_once 'adm_staff/checkRegister.php';
    }
    elseif(isset($_GET['stud_reg'])){
        require_once 'adm_student/student_reg.php';
    }
    elseif(isset($_GET['set_question'])){
        require_once 'set_question/question.php';
    }
    elseif(isset($_GET['set_exam_code'])){
        require_once 'set_question/question_code.php';
    }
    elseif(isset($_GET['result_page'])){
        require_once 'set_question/result_page.php';
    }
    elseif(isset($_GET['curr_term'])){
        require_once 'settings/current_term.php';
    }
    elseif(isset($_GET['bull_sett'])){
        require_once 'settings/bulletin.php';
    } 
    elseif(isset($_GET['user_settings'])){
        require_once 'settings/user_settings.php';
    } 
    elseif(isset($_GET['sch_calendar'])){
        require_once 'settings/sch_calender.php';
    }  

    elseif(isset($_GET['res_set'])){
        require_once 'manage_result/result_settings.php';
    }
    elseif(isset($_GET['ent_res'])){
        require_once 'manage_result/enter_result.php';
    }
    elseif(isset($_GET['dis_res'])){
        require_once 'manage_result/display_result.php';
    }
    elseif(isset($_GET['dis_tot_sco'])){
        require_once 'manage_result/display_total_score.php';
    }

    elseif(isset($_GET['res_set_memo'])){
        require_once 'manage_result_memo/result_settings.php';
    }
    elseif(isset($_GET['ent_res_memo'])){
        require_once 'manage_result_memo/enter_result.php';
    }
    elseif(isset($_GET['dis_res_memo'])){
        require_once 'manage_result_memo/display_result.php';
    }
    elseif(isset($_GET['dis_tot_sco_memo'])){
        require_once 'manage_result_memo/display_total_score.php';
    }

    elseif(isset($_GET['logout'])){
        require_once 'logout.php';
    }
    elseif(isset($_GET['rentage'])){
        require_once 'rentage.php';
    }
    elseif(isset($_GET['codes'])){
        require_once 'code.php';
    }

    elseif(isset($_GET['l_books'])){
        require_once 'videos_books/library_books.php';
    }
    elseif(isset($_GET['l_videos'])){
        require_once 'videos_books/library_vidoes.php';
    }

    elseif(isset($_GET['c_videos'])){
        require_once 'videos_books/class_vidoes.php';
    }
    elseif(isset($_GET['c_books'])){
        require_once 'videos_books/class_books.php';
    }
    elseif(isset($_GET['c_vid_bk'])){
        require_once 'videos_books/class_vid_bk.php';
    }
    elseif(isset($_GET['c_notes'])){
        require_once 'videos_books/class_notes.php';
    }
    elseif(isset($_GET['sms'])){
        require_once 'sms/sms.php';
    }
    elseif(isset($_GET['idea'])){
        require_once 'idea_member/registration.php';
    }
    
  
    else 
    {

?>
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">SCHOOL CALENDAR</h5>
                    <div class="card position-relative rounded-4">
                        <embed src="<?=$linkPdf?>" type="application/pdf" width="100%" height="550px">
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- End #main -->
    <?php     }?>

    <!-- ======= Footer ======= -->
    <!-- <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer> -->
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/js/toastr.min.js"></script>
    <script src="assets/js/jquery-confirm.min.js"></script>


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <!-- using jQuery -->
    <script type="text/javascript">
    $(document).ready(function() {})
    </script>

</body>

</html>