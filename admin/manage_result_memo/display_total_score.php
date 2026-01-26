<?php 
    // branch
    $branches = $conn->query("SELECT * FROM branches");
    // class 
    $memorization_class = $conn->query("SELECT * FROM memorization_class");
    //session
    $session = $conn->query("SELECT * FROM tblsession");
?>

<main id="main" class="main">
    <section class="section">

	<div class="card mt-3">
            <div class="card-header py-0 d-flex flex-center bg-secondary justify-content-center">
                <h5 class="mb-0 text-white mt-2 text-uppercase text-center"><strong> Display Memorization Total Scores</strong>
                </h5>
            </div>
            <div class="card-footer bg-body-tertiary text-center">
                <form id="check_result_form">
                    <div class="row gx-2 mx-auto">
                        <div class="col-md-3 mb-sm-0 col-sm-6">
                            <div class="tom-select-custom">
                                <select class="js-select form-select " name="branch" id="branch_">
                                    <option value="none">Select Branch</option>
                                    <?php while($branch = $branches->fetch_object()):?>
                                    <option value="<?= $branch->Branch_Name ?>"><?= $branch->Branch_Name ?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-sm-0 col-sm-6">
                            <div class="tom-select-custom">
                                <select class="js-select form-select" name="class" id="class_">
                                    <option value="none">Select Class</option>
                                    <?php while($class = $memorization_class->fetch_object()):?>
                                    <option value="<?=$class->id?>"><?=$class->class_name?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-sm-0 col-sm-6">
                            <div class="tom-select-custom">
                                <select class="js-select form-select" name="term" id="term">
                                    <option value="none">Select Term</option>
                                    <option value="1">1st Term</option>
                                    <option value="2">2nd Term</option>
                                    <option value="3">3rd Term</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-sm-0 col-sm-6">
                            <div class="tom-select-custom">
                                <select class="js-select form-select" name="session" id="session">
                                     <option value="none">Select Session</option>
                                    <?php while($sess = $session->fetch_object()):?>
                                    <option value="<?=$sess->csession?>"><?=$sess->csession?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-sm-0 col-sm-6"></div>
                        <div class="col-md-3 mb-sm-0 col-sm-6"></div>
                        <div class="col-md-3 mb-sm-0 col-sm-6"></div>
                        <div class="col-md-3 mb-sm-0 col-sm-6 pt-2">
                            <div class="tom-select-custom">
                                <button href="#" class="btn btn-primary w-100" id="continue">Continue</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card pt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
</main>
<script type="text/javascript">
$(document).ready(function() {
    $('#continue').click(function(e){
        e.preventDefault();
        var branch_ = $('#branch_').val();
        var class_ = $('#class_').val();
        var term = $('#term').val();
        var session = $('#session').val();
        if(term == 'none' || session == 'none' || class_ == 'none' || branch_ == 'none'){
            $.alert("Please make proper selection","Message")
        } else {
            var data = {"branch_":branch_,"class_":class_,"term":term,"session":session,"type":"showTable"};
            $.post("../admin/manage_result_memo/display_total_score_db.php",data,null,"json")
            .done(function(response){
                $('.table-responsive').html(response.html);
                $('[data-bs-toggle="tooltip"]').tooltip('dispose').tooltip();
            })
            .fail(function(err){
                console.log(err);
            });
        }
        
    })
});
</script>