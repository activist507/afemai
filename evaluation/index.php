<?php 
    include('../admin/config/db_connect.php');

    // section validation
    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    if(!isset($_SESSION['authentication']))
    {
        echo "<script>
        window.location = '../'
        </script>";
    }
	$inv_code = $_SESSION['invCode'];
	$subjects = $conn->query("SELECT * FROM cbt_staff_subject")->fetch_all(MYSQLI_ASSOC);
	$d = $conn->query("SELECT * FROM cbt_staff_eval WHERE inv_code = '$inv_code'")->fetch_object();
	$fullname = $d->fullnames ?? '';
	$gender = $d->gender ?? '';
	$dob = $d->d_o_b ?? '';
	$qual = $d->qualification ?? '';
	$area_spec = $d->area_spec ?? '';
	$phone = $d->phone ?? '';
	$email = $d->email ?? '';
	$add = $d->address ?? '';
	$religion = $d->religion ?? '';
	$comm = $d->comment ?? '';
	$skill = $d->s_skills ?? '';
	


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Employee-Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="assets/css/jquery-confirm.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="./" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">IDEA-CBT</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item pe-5 align-items-left">
                    <h6 class="mb-0">Obj | ID:<span class="fw-bold"><?= $Questions->question_id ?? ''?> </span>
                    </h6>
                </li>

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="data:<?php echo $mimeType2; ?>;base64,<?php echo $imageData1; ?>"
                            class="rounded-circle" alt="" />
                        <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>No Name</h6>
                            <span><strong>Current Class: </strong>Staff Evaluation</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#" id="logout1">
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

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="./">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <!-- End Dashboard Nav -->



            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link collapsed" id="checkPage">
                    <i class="bi bi-pencil-square"></i>
                    <span>Take Exam</span>
                </a>
            </li>
            <!-- End take exam Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" id="logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>
            <!-- End logout  Nav -->

        </ul>

    </aside>
    <!-- End Sidebar-->

    <?php 
    if(isset($_GET['take_exam'])){
        require_once ('take_exam.php');
    } 
    elseif(isset($_GET['write_exam_original']))
    {
        require_once('write_exam_original.php');
    }
    // elseif(isset($_GET['check_result'])){
    //     require_once('check_result.php');
    // }
    elseif(isset($_GET['logout'])){
        require_once('logout.php');
    }
    else 
    {

?>
    <main class="main" id="main">
        <section class="section">
            <div class="card pb-2">
                <div class="card-body pb-2">

                    <div class="row pt-2">
                        <div class="col-lg-12">
                            <h5 class="card-title text-center pt-1">STAFF EVALUATION REGISTRATION</h5>
                        </div>
                    </div>

                    <div class="row pt-0">
                        <div class="col-lg-4">
                        </div>
                        <div class="col-lg-4 text-center mb-2">
                            <img src="../storege/students/no_image.jpg" id="img_of_stud" class="rounded-circle mx-4"
                                alt="" style="width: 5rem; height: 5rem;" />
                        </div>
                        <div class="col-lg-4">
                        </div>
                    </div>

                    <form action="" class="g-3 pt-2" id="stdRegForm" method="POST" enctype="multipart/form-data">
                        <!-- staff details -->
                        <div class="row pb-2 gy-2">
                            <div class="col-lg-2 col-sm-12">
                                <input type="text" class="form-control text-center pt-0" id="inv_ID" name="inv_ID"
                                    maxlength="8" value="<?= $inv_code?>" placeholder="ID" disabled />
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <input type="text" class="form-control pt-0" id="Fullnames" name="Fullnames" required
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Staff Fullnames"
                                    placeholder="Fullnames" value="<?= $fullname?>" />
                            </div>

                            <div class="col-lg-2 col-sm-12">
                                <select name="staff_gender" id="staff_gender" class="form-control pt-0"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Staff Gender" required>
                                    <option>Select Gender</option>
                                    <option value="Male" <?php if($gender == 'Male'){ echo "selected";}?>>Male</option>
                                    <option value="Female" <?php if($gender == 'Female'){ echo "selected";}?>>Female
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-sm-12">
                                <input type="date" class="form-control pt-0" id="staff_dob" value="<?= $dob?>"
                                    name="staff_dob" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Date Of Birth" required />
                            </div>
                        </div>

                        <!-- Select Status -->
                        <div class="row pb-2 gy-2">
                            <div class="col-lg-2 col-sm-12">
                                <select name="staff_qualification" id="staff_qualification" class="form-control pt-0"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Staff Qualification"
                                    required>
                                    <option value="0">Select Qualification</option>
                                    <option value="O Level" <?php if($qual == 'O Level'){ echo "selected";}?>>O Level
                                    </option>
                                    <option value="NCE" <?php if($qual == 'NCE'){ echo "selected";}?>>NCE</option>
                                    <option value="Diploma" <?php if($qual == 'Diploma'){ echo "selected";}?>>Diploma
                                    </option>
                                    <option value="HND" <?php if($qual == 'HND'){ echo "selected";}?>>HND</option>
                                    <option value="PGD" <?php if($qual == 'PGD'){ echo "selected";}?>>PGD</option>
                                    <option value="BSc" <?php if($qual == 'BSc'){ echo "selected";}?>>BSc</option>
                                    <option value="Masters" <?php if($qual == 'Masters'){ echo "selected";}?>>Masters
                                    </option>
                                    <option value="Phd" <?php if($qual == 'Phd'){ echo "selected";}?>>Phd</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <input type="text" class="form-control pt-0" id="area_spec" value="<?= $area_spec?>"
                                    name="area_spec" placeholder="Area Of Specialisation" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Area Of Specialisation" />
                            </div>
                            <div class="col-lg-2 col-sm-12">
                                <input type="text" class="form-control pt-0" id="staff_phone" value="<?= $phone?>"
                                    name="staff_phone" placeholder="Whatsapp Phone Number" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Whatsapp Phone Number" required />
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <input type="text" class="form-control pt-0" id="staff_email" value="<?= $email?>"
                                    name="staff_email" placeholder="Email" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Staff Email" />
                            </div>
                        </div>
                        <!-- End staff details -->

                        <!-- n info -->

                        <div class="row pb-2 gy-2">
                            <div class="col-lg-6 col-sm-12">
                                <input type="text" class="form-control pt-0" value="<?= $add?>" id="staff_address"
                                    name="staff_address" placeholder="Address" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Staff Address" required />
                            </div>
                            <div class="col-lg-2 col-sm-12">
                                <select name="religion" id="religion" class="form-control pt-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Religion" required>
                                    <option>Select Religion</option>
                                    <option value="Islam" <?php if($religion == 'Islam'){ echo "selected";}?>>Islam
                                    </option>
                                    <option value="Christianity"
                                        <?php if($religion == 'Christianity'){ echo "selected";}?>>Christianity
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <input type="text" class="form-control pt-0" value="<?= $comm?>" id="staff_comment"
                                    name="staff_comment" placeholder="Comment" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Staff Comment" />
                            </div>
                        </div>
                        <div class="row pb-2 gy-2">
                            <?php foreach($subjects as $sub):?>
                            <?php if($sub['subject'] !== ''):?>
                            <div class="col-3 form-check">
                                <input type="checkbox" name="subjects[]" class="form-check-input subjects"
                                    value="<?= $sub['subject']?>">
                                <label class="form-check-label" for="option1"><?= $sub['subject']?></label>
                            </div>
                            <?php endif;?>
                            <?php endforeach;?>
                        </div>
                        <div class="row pb-2 gy-2">
                            <div class="col-lg-10 col-sm-12">
                                <input type="text" class="form-control pt-0" value="<?= $skill?>" id="s_skills"
                                    name="s_skills" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Special Skills" placeholder="Special skills" />
                            </div>
                            <div class="col-lg-2">
                                <div class="d-flex pt-0">
                                    <button type="submit" class="btn btn-success" style="width: 120px;"
                                        id="submitEvaluation">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </section>
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>IDEA-CBT</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by Idea Code Solution
        </div>
    </footer><!-- End Footer -->
    <?php     }?>
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
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/jquery-confirm.min.js"></script>
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <!-- using jQuery -->
    <script type="text/javascript">
    $(document).ready(function() {
        $('#logout').click(function() {
            localStorage.removeItem('countdownTime');
            localStorage.removeItem('endTime');
            window.location.href = './?logout';
        })
        $('#logout1').click(function() {
            localStorage.removeItem('countdownTime');
            localStorage.removeItem('endTime');
            window.location.href = './?logout';
        })
        $('#submitEvaluation').click(function(e) {
            e.preventDefault();
            var subj = $('.subjects').serializeArray();
            var InvCode = $('#inv_ID').val().trim();
            var Fullnames = $('#Fullnames').val().trim();
            var staff_gender = $('#staff_gender').val().trim();
            var staff_dob = $('#staff_dob').val().trim();
            var staff_qualification = $('#staff_qualification').val().trim();
            var staff_email = $('#staff_email').val().trim();
            var staff_phone = $('#staff_phone').val().trim();
            var area_spec = $('#area_spec').val().trim();
            var staff_address = $('#staff_address').val().trim();
            var religion = $('#religion').val().trim();
            var staff_comment = $('#staff_comment').val().trim();
            var s_skills = $('#s_skills').val().trim();
            if (Fullnames == '' || staff_gender == '' || staff_dob == '' ||
                staff_qualification == '' || staff_email == '' || staff_phone == '' || area_spec ==
                '' ||
                staff_address ==
                '' || subj == '' || religion == '') {
                $.confirm({
                    icon: 'bi bi-patch-question',
                    theme: 'bootstrap',
                    title: 'Message',
                    content: 'One or more important field are empty',
                    animation: 'scale',
                    type: 'orange'
                })
            } else {
                $.ajax({
                    url: 'index_db.php',
                    type: 'POST',
                    dataType: 'JSON',
                    cache: false,
                    data: {
                        "subj": subj,
                        "InvCode": InvCode,
                        "Fullnames": Fullnames,
                        "staff_gender": staff_gender,
                        "staff_dob": staff_dob,
                        "staff_qualification": staff_qualification,
                        "staff_email": staff_email,
                        "staff_phone": staff_phone,
                        "area_spec": area_spec,
                        "staff_address": staff_address,
                        "religion": religion,
                        "staff_comment": staff_comment,
                        "s_skills": s_skills,
                        "type": "updateDetails"
                    },
                    success: function(response) {
                        $.alert({
                            icon: 'bi bi-patch-question',
                            theme: 'bootstrap',
                            title: 'Message',
                            content: response.msg,
                            animation: 'scale',
                            type: 'orange'
                        })
                        setTimeout(() => {
                            // location.reload(true);
                            window.location.href = './?take_exam';
                        }, 3000);
                    },
                    error: function(err) {
                        console.log(err)
                    }
                })
            }
        })
        $('#checkPage').click(function() {
            var invID = '<?= $inv_code?>';
            $.ajax({
                url: 'index_db.php',
                type: 'POST',
                dataType: 'JSON',
                cache: false,
                data: {
                    "invID": invID,
                    "type": "checkSubject"
                },
                success: function(data) {
                    if (data.status == 'false') {
                        $.confirm({
                            icon: 'bi bi-patch-question',
                            theme: 'bootstrap',
                            title: 'Message',
                            content: 'There is no exam to write',
                            animation: 'scale',
                            type: 'orange'
                        })
                    } else {
                        window.location.href = './?take_exam';
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            })
        })
    })
    </script>

</body>

</html>