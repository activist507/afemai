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
                <h5 class="mb-0 text-white mb-4 mt-2 text-uppercase text-center"><strong> Check Your ISLAMIYYAH Result</strong>
                </h5>
            </div>
            <div class="card-footer bg-body-tertiary py-2 text-center">
                <form id="check_result_form">
                    <div class="row gx-2 mx-auto">
                        <div class="col-md-4 mb-sm-0">
                            <div class="tom-select-custom">
                                <label for="branch" class="form-label fw-bold">Select Branch</label>
                                <select class="js-select form-select " name="branch" id="branch_">
                                    <?php while($branch = $branches->fetch_object()):?>
                                    <option value="<?= $branch->Branch_Name ?>"><?= $branch->Branch_Name ?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-sm-0">
                            <div class="tom-select-custom">
                                <label for="subject" class="form-label fw-bold"> Select Class</label>
                                <select class="js-select form-select" name="class" id="class_">
                                    <option value="none">Select Class</option>
                                    <?php while($class = $memorization_class->fetch_object()):?>
                                    <option value="<?=$class->id?>"><?=$class->class_name?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold" for="pin">Result PIN</label>
                            <input name="resultPin" placeholder="Enter Your PIN" class="form-control" type="number"
                                autocomplete="on" id="pin" />
                        </div>
                        <div class="col-md-4 mb-sm-0 pt-3">
                            <div class="tom-select-custom">
                                <label class="form-label fw-bold" for="term">Select term</label>
                                <select class="js-select form-select" name="term" id="term">
                                    <option value="none">Select Term</option>
                                    <option value="1">1st Term</option>
                                    <option value="2">2nd Term</option>
                                    <option value="3">3rd Term</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-sm-0 pt-3">
                            <div class="tom-select-custom">
                                <label class="form-label fw-bold" for="session">Select Session</label>
                                <select class="js-select form-select" name="session" id="session">
                                    <option value="none">Select session</option>
                                    <?php while($sess = $session->fetch_object()):?>
                                    <option value="<?=$sess->csession?>"><?=$sess->csession?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-sm-0 pt-5">
                            <div class="tom-select-custom">
                                <button href="#" class="btn btn-success" id="check_result">Check Result</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
</main>

<script type="text/javascript">
$(document).ready(function() {
    $('#check_result_form').submit(function(e) {
        e.preventDefault();
        var branch_ = $('#branch_').val();
        var class_ = $('#class_').val();
        var term = $('#term').val();
        var session = $('#session').val();
        var pin = $('#pin').val();
        var stud_id = '<?= $Student_ID ?>';

        if (term == 'none' || session == 'none' || class_ == 'none') {
            $.alert('Please select a term',"Message")
        } else {
            // console.log(branch_,class_,term,session,stud_id)
            $.ajax({
                url: 'check_memorization_db.php',
                type: 'POST',
                dataType: 'JSON',
                cache: false,
                data: {
                    "stud_id": stud_id,
                    "branch": branch_,
                    "class": class_,
                    "term": term,
                    "session": session,
                    "pin": pin,
                    "type": "checkresult"
                },
                success: function(response) {
                    if (response.status == 'failed') {
                        $.alert(response.msg,"Error")
                    } else if (response.status == 'success') {
                        // $.alert("Result Available","Success")
                        window.location.href = 'memorization_result.php?ID=' + stud_id +
                             '&branch=' + branch_ +
                            '&class=' + class_ + '&name=' + response.Fullnames +
                            '&term_tbl=' + term + '&session=' + session;
                    }

                },
                error: function(err) {
                    console.log(err)
                }
            })
        }

    })
})
</script>