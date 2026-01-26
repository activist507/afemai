<?php 
include '../config/db.php';
include '../config/session.php';
include ('auth.php');
  
  $class = $_SESSION['class'];
  $disabled = '';
  $question_codes = $conq->query("SELECT qc.question_code,qc.sub_name,e.assessment_type FROM question_codes qc JOIN exams e ON qc.question_code = e.id WHERE qc.class_id ='$class'")->fetch_object();
  $sub_write = $question_codes->sub_name ?? 'No Subject';
  $q_code = $question_codes->question_code ?? 'XXX-XX';
  $eval_type = $question_codes->assessment_type ?? 'No Exam';

  if($q_code == 'XXX-XX'){
    $disabled = 'disabled';
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - <?= $_SESSION['surname'].' '.$_SESSION['othernames']?> </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= $dro['report_logo']?>" rel="icon">
  <link href="../admin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Vendor CSS Files -->
  <link href="../admin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../admin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../admin/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../admin/assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="../admin/assets/css/toastr.min.css">
  <link rel="stylesheet" href="../admin/assets/css/jquery-confirm.min.css">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="./" class="logo d-flex align-items-center">
        <img src="<?= $dro['report_logo']?>" alt=""> 
        <span class="d-none d-lg-block"><?= $companyName?></span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
       <li class="nav-item dropdown pe-3">
        
      </li>
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../admin/assets/stdImg/<?= $_SESSION['img']?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= $_SESSION['surname'].' '.$_SESSION['othernames']?></span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= $_SESSION['surname'].' '.$_SESSION['othernames']?></h6>
              <span><?= showLevelName($_SESSION['class']).' : '.showArmName($_SESSION['arm'])?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="nav-item">
              <a class="dropdown-item d-flex align-items-center" href="./">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
              </a>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <!-- <li class="nav-item">
              <a class="dropdown-item d-flex align-items-center" href="./?library">
                <i class="bi bi-book"></i>
                <span>Library</span>
              </a>
            </li> -->
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="./?change_password">
                <i class="bi bi-brush"></i>
                <span>Change Password</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#" id="signOut">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul>
        </li>

      </ul>
    </nav>
  </header>

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

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-collection-play"></i><span>Class Resources</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="./?C_Notes">
                        <i class="bi bi-circle"></i><span>Notes</span>
                    </a>
                </li>
                <li>
                    <a href="./?C_Books">
                        <i class="bi bi-circle"></i><span>Books</span>
                    </a>
                </li>
                <li>
                    <a href="./?C_Videos">
                        <i class="bi bi-circle"></i><span>Videos</span>
                    </a>
                </li>
                <li>
                    <a href="./?C_vid_book">
                        <i class="bi bi-circle"></i><span>Video_Books</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End Resources Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-book"></i><span>Library</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="./?L_Books">
                        <i class="bi bi-circle"></i><span>Books </span>
                    </a>
                </li>
                <li>
                    <a href="./?L_Videos">
                        <i class="bi bi-circle"></i><span>Videos</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End Library Nav -->


        <li class="nav-heading">Pages</li>

        <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="./?check">
                <i class="bi bi-eye"></i>
                <span>Check Result</span>
            </a>
        </li> -->
        <!-- End check result Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="./?change_password">
                <i class="bi bi-key"></i>
                <span>Change Password</span>
            </a>
        </li>
        <!-- End Update password Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" id="signOut2">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </li>
        <!-- End logout  Nav -->

    </ul>
  </aside>
<!-- End Sidebar-->

  <main id="main" class="main">

    <?php 
    if(isset($_GET['check'])){
      require_once 'result.php';
    } 
    else if(isset($_GET['test'])){
      require_once 'question.php';
    } 
    else if(isset($_GET['write_exam'])){
      require_once 'write_exam.php';
    }
    else if(isset($_GET['change_password'])){
      require_once 'updatePassword.php';
    }
    else if(isset($_GET['library'])){
      require_once 'library.php'; 
    }
    elseif(isset($_GET['C_Notes'])){
        require_once('notes.php');
    }
    elseif(isset($_GET['C_Videos'])){
        require_once('videos.php');
    }
    elseif(isset($_GET['C_vid_book'])){
        require_once('video_book.php');
    }
    elseif(isset($_GET['C_Books'])){
        require_once('books.php');
    }
    elseif(isset($_GET['L_Videos'])){
        require_once('library_videos.php');
    }
    elseif(isset($_GET['L_Books'])){
        require_once('library_books.php');
    }
    else if(isset($_GET['logout'])){
      require_once 'logout.php';
    } else {?>
      <!-- SPA-->

      <div class="pagetitle pt-4">
        <h1>Welcome <?= $_SESSION['surname'].' '.$_SESSION['othernames']?></h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </nav>
      </div>
      <!-- End Pag5e Title -->

        <section class="pt-4 section dashboard">
          <div class="row">

                <div class="col-xl-12">
                  <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="../admin/assets/stdImg/<?= $_SESSION['img']?>"
                            class="rounded-circle" alt="" style="max-height: 150px; width:auto;"/>
                        <h3><strong><?= $_SESSION['surname'].' '.$_SESSION['othernames']?></strong></h3>
                        <h3><strong>Current Class: </strong><?= showLevelName($_SESSION['class']).' : '.showArmName($_SESSION['arm'])?></h3>
                        <div class="social-links mt-2">
                          <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                          <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                  </div>
                </div>
            <!-- Left side columns -->
            <div class="col-12 justify-content-center">
              <div class="row">

                <!-- subject table  -->
                <div class="col-12">
                  <div class="card recent-sales overflow-auto">

                    <div class="card-body">
                      <h5 class="card-title">Write Test / Exam</h5>

                      <table class="table table-borderless ">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody id="qstLinks">
                          <?php $subno = 1;?>
                            <tr>
                              <th scope="row"><a href="#"><?= $subno?></a></th>
                              <td><?=$sub_write?></td>
                              <td> 
                                <button type="button" 
                                  data-questionCode="<?= $q_code?>"
                                  class="btn btn-primary Click <?= $disabled?>">
                                  <i class="bi bi-pencil-square"></i> 
                                  <?= $eval_type ?>
                                </button>
                              </td>
                            </tr>
                        </tbody>
                      </table>

                    </div>

                  </div>
                </div>


              </div>
            </div>

          </div>
        </section>
      <!-- SPA -->
    <?php }?>

  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span><?= $companyName?></span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed by <a href="#">Jisnaay Tech</a>
    </div>
  </footer>
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <!-- Vendor JS Files -->
  <script src="../admin/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../admin/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../admin/assets/vendor/echarts/echarts.min.js"></script>
  <script src="../admin/assets/vendor/quill/quill.min.js"></script>
  <script src="../admin/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../admin/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../admin/assets/vendor/php-email-form/validate.js"></script>
  <script src="../admin/assets/js/jquery.min.js"></script>
  <script src="../admin/assets/js/toastr.min.js"></script>
  <script src="../admin/assets/js/jquery-confirm.min.js"></script>

  <!-- Template Main JS File -->
  <script src="../admin/assets/js/main.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      localStorage.removeItem('countdownTime');
      $('#qstLinks').on('click','.Click',function(e){
        e.preventDefault();
        var qCode = $(this).attr('data-questionCode');
        var classID = $(this).attr('data-classID');
        var arm = $(this).attr('data-arm');
        window.location.href = "write_exam.php/?exam_id="+qCode;
      })

      $('#signOut').click(function(){
        localStorage.removeItem('countdownTime');
        localStorage.removeItem('updateQst');
        localStorage.removeItem('uniqueQst');
        window.location.href = "./?logout";
      })

      $('#signOut2').click(function(){
        localStorage.removeItem('countdownTime');
        localStorage.removeItem('updateQst');
        localStorage.removeItem('uniqueQst');
        window.location.href = "./?logout";
      })
    })
  </script>
</body>
</html>
