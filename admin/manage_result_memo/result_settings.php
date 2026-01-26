<?php 
    // branch
    $branches = $conn->query("SELECT * FROM branches");
    // class 
    $memorization_class = $conn->query("SELECT * FROM memorization_class");
    //session
    $session = $conn->query("SELECT * FROM tblsession");
?>

<main id="main" class="main">
    <div class="container">

        <div class="card mt-3">
            <div class="card-header py-0 d-flex flex-center bg-secondary justify-content-center">
                <h5 class="mb-0 text-white mt-2 text-uppercase text-center"><strong> Confirm Memorization Result Settings</strong>
                </h5>
            </div>
            <div class="card-footer bg-body-tertiary">
                <form id="check_result_form" class="text-center">
                    <div class="row gx-2 mx-auto">
                        <div class="col-md-3 mb-0 col-sm-6 pt-2">
                            <div class="tom-select-custom">
                                <select class="js-select form-select " name="branch" id="branch_">
                                    <option value="none">Select Branch</option>
                                    <?php while($branch = $branches->fetch_object()):?>
                                    <option value="<?= $branch->Branch_Name ?>"><?= $branch->Branch_Name ?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-sm-0 col-sm-6 pt-2">
                            <div class="tom-select-custom">
                                <select class="js-select form-select" name="class" id="class_">
                                    <option value="none">Select Class</option>
                                    <?php while($class = $memorization_class->fetch_object()):?>
                                    <option value="<?=$class->id?>"><?=$class->class_name?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-sm-0 col-sm-6 pt-2">
                            <div class="tom-select-custom">
                                <select class="js-select form-select" name="term" id="term">
                                    <option value="none">Select Term</option>
                                    <option value="1">1st Term</option>
                                    <option value="2">2nd Term</option>
                                    <option value="3">3rd Term</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-sm-0 col-sm-6 pt-2">
                            <div class="tom-select-custom">
                                <select class="js-select form-select" name="session" id="session">
                                    <option value="none">Select session</option>
                                    <?php while($sess = $session->fetch_object()):?>
                                    <option value="<?=$sess->csession?>"><?=$sess->csession?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        </div>
						<div class="col-md-3 mb-sm-0 col-sm-6 pt-3">
                            <div class="tom-select-custom">
                                <button href="#" class="btn btn-success w-100" id="check_result">Enter Student Result</button>
                            </div>
                        </div>
						<!-- <div class="col-md-3 mb-sm-0 col-sm-6 pt-3">
                            <div class="tom-select-custom">
                                <button href="#" class="btn btn-danger w-100" id="display_total_score">Display Total Score</button>
                            </div>
                        </div> -->
						<div class="col-md-3 mb-sm-0 col-sm-6 pt-3">
                            <div class="tom-select-custom">
                                <button href="#" class="btn btn-primary w-100" id="display_result">Display Class Position</button>
                            </div>
                        </div>
                        <div class="col-md-3 mb-sm-0 col-sm-6 pt-3">
                            <div class="tom-select-custom">
                                <button href="#" class="btn btn-secondary w-100" id="findMissing">Find Missing Students</button>
                            </div>
                        </div>

                    </div>
                </form>
                <div id="notEntered" class="pt-3"></div>
            </div>
        </div>

    </div>
</main>

<script type="text/javascript">
$(document).ready(function() {

	$('#check_result').click(function(e){
		e.preventDefault();
		var branch_ = $('#branch_').val();
        var class_ = $('#class_').val();
        var term = $('#term').val();
        var session = $('#session').val();
        if(term == 'none' || session == 'none' || class_ == 'none' || branch_ == 'none'){
            $.alert("Please make proper selection","Message")
        } else {
            window.location.href = `./?ent_res_memo&branch=${branch_}&clas=${class_}&term=${term}&session=${session}`;
        }
		
	})

    $('#display_result').click(function(e){
        e.preventDefault();
        window.location.href = `./?dis_res_memo`;
    })

    $('#display_total_score').click(function(e){
        e.preventDefault();
        window.location.href = `./?dis_tot_sco_memo`;
    })

    $('#findMissing').click(function(e){
        e.preventDefault();
        var branch = $('#branch_').val();
        var className = $('#class_').val();
        var term = $('#term').val();
        var session = $('#session').val();
        if( term == 'none'){
            $.alert("Please select a term","Message");
        } else {
            data = {"type":"findMissing","branch":branch,"className":className,"session":session,"term":term};
            $.post("../admin/manage_result_memo/result_settings_db.php",data,null,"json")
            .done(function(response){
                $('#notEntered').html(response.html);
            })
            .fail(function(err){
                console.log(err);
            });
        } 
    })
})
</script>