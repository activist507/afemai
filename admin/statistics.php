<!-- 2- admin php file links -->
<main id="main" class="main">

    <div class="pagetitle">
        <h5 class="text-success fw-bold">ACTIVE STUDENTS</h5>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <?php foreach($branches_rows as $branch ){
                        $b_name = $branch['Branch_Name'];
                        $students = $conn->query("SELECT COUNT(ID) AS tot FROM student_records WHERE Branch = '$b_name' AND Current_Status = 'Active'");
                        $fetching = $students->fetch_object();
                        $stud_total = $fetching->tot;
                    ?>
                    <div class="col-xxl-3 col-md-3 col-lg-3 col-sm-2">
                        <div class="card " style="height: 4rem;">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= $branch['Branch_Name']?></span> =
                                    <i><?= $stud_total?></i>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                    <div class="col-xxl-4 col-xl-12">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title text-center">Total Number of Students </h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $stud_total_all?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card text-success" style="height: 4rem; background: #03a439;">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold text-white">ACTIVE STAFF STATISTICS </h5>
                            </div>
                        </div>
                    </div>

                    <?php foreach($branches_rows as $branch ){
                        $b_name = $branch['Branch_Name'];
                        $staff = $conn->query("SELECT COUNT(ID) AS tot FROM staff_records WHERE Branch = '$b_name' AND Staff_Status = 'Active'");
                        $fetching = $staff->fetch_object();
                        $staff_total = $fetching->tot;
                    ?>
                    <div class="col-xxl-3 col-md-3 col-lg-3 col-sm-2">
                        <div class="card " style="height: 4rem;">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= $branch['Branch_Name']?></span> =
                                    <i><?= $staff_total?></i>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                    <div class="col-xxl-4 col-xl-12">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title text-center">Total Number of Staff </h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $staff_total_all?></h6>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
<!-- End #main -->