<?php 
    $allstud_rec = $conn->query("SELECT * FROM student_records ORDER BY Student_ID");
    $all_recs = $allstud_rec->fetch_all(MYSQLI_ASSOC);
    $stud_all_tot = count($all_recs);
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <h5 class="card-title">All Student Total = <?= $stud_all_tot ?> </h5>
                            <!-- Table with stripped rows -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" nowrap="nowrap">ID</th>
                                        <th scope="col" nowrap="nowrap">Name</th>
                                        <th scope="col" nowrap="nowrap">Class</th>
                                        <th scope="col" nowrap="nowrap">Status</th>
                                        <th scope="col" nowrap="nowrap">Branch</th>
                                        <th scope="col" nowrap="nowrap">Phone Number</th>
                                        <th scope="col" nowrap="nowrap">Balance</th>
                                        <th scope="col" nowrap="nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($all_recs as $stud_rec){?>
                                    <tr>
                                        <td scope="col" nowrap="nowrap"><?= $stud_rec['Student_ID']?></td>
                                        <td scope="col" nowrap="nowrap"><?= $stud_rec['Fullnames']?></td>
                                        <td scope="col" nowrap="nowrap"><?= $stud_rec['Student_Class']?></td>
                                        <td scope="col" nowrap="nowrap"><?= $stud_rec['Current_Status']?></td>
                                        <td scope="col" nowrap="nowrap"><?= $stud_rec['Branch']?></td>
                                        <td scope="col" nowrap="nowrap"><?= $stud_rec['Phone_Number']?></td>
                                        <td scope="col" nowrap="nowrap"><?= $stud_rec['Current_Balance']?></td>
                                        <td>
                                            <div style="display: flex; align-items:center;">
                                                <a href="./?editStudent&ID=<?= $stud_rec['Student_ID']?>"
                                                    class="btn btn-link p-0" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit">
                                                    <span class="text-500 fas fa-edit"></span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
</main>