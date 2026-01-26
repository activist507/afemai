<?php 

    $sqlSessionn = $conn->query("SELECT * FROM tblsession");
    $sqlTermm = $conn->query("SELECT * FROM cbt_term");
    $terms = $sqlTermm->fetch_all(MYSQLI_ASSOC);
    $sesssion = $sqlSessionn->fetch_all(MYSQLI_ASSOC);

?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">


                <form action="" class="g-3" id="curr_term_form" method="POST" enctype="multipart/form-data">
                    <div class="col-12 pt-1">
                        <div class="card text-success" style="height: 4rem; background: #03a439;">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold text-white">Current Term </h5>
                            </div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <!-- <div class="col-lg-2 col-sm-12 pt-2">
                            <label for="gen_Term_sett" class="col-sm-2 col-form-label">Current Term</label>
                        </div> -->
                        <div class="col-lg-2 col-sm-12 pt-2">
                            Current Term
                        </div>
                        <div class="col-lg-2 col-sm-12 pt-2">
                            <select name="gen_Term" id="gen_Term_sett" class="form-control" required>
                                <option value="<?= $gen_term?>"><?= $gen_term?></option>
                                <?php foreach($terms as $term){?>
                                <option value="<?= $term['term']?>"><?= $term['term']?>
                                </option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-12 pt-2">
                            Current Branch
                        </div>
                        <div class="col-lg-2 col-sm-12 pt-2">
                            <select name="gen_branch" id="gen_branch_sett" class="form-control" required>
                                <option value="<?= $gen_branch?>"><?= $gen_branch?></option>
                                <?php foreach($branches_rows as $branc){?>
                                <option value="<?= $branc['Branch_Name']?>"><?= $branc['Branch_Name']?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-12 pt-2">
                            Current Session
                        </div>
                        <div class="col-lg-2 col-sm-12 pt-2">
                            <select name="gen_Session" id="gen_Session_sett" class="form-control" required>
                                <option value="<?= $gen_session?>"><?= $gen_session?></option>
                                <?php foreach($sesssion as $session){?>
                                <option value="<?= $session['csession']?>">
                                    <?= $session['csession']?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card text-success" style="height: 4rem; background: #03a439;">
                                <div class="card-body text-center">
                                    <h5 class="card-title fw-bold text-white">Announcement </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="card text-success" style="height: 4rem; background: #03a439;">
                                <div class="card-body text-center">
                                    <h5 class="card-title fw-bold text-white">General Message </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <textarea name="announcement" id="annonc_sett" class="form-control" style="height: 10rem;"
                                required><?= $gen_ann?></textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <textarea name="gen_msg" id="gen_msg" class="form-control" style="height: 10rem;"
                                required><?= $gen_msg?></textarea>
                        </div>
                    </div>
                    
                        <div class="text-end pt-4">
                            <button type="submit" style="width: 8.5rem;" class="btn btn-primary w-100">
                                Submit
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </section>
</main>
<script type="text/javascript">
$(document).ready(function() {
    $('#curr_term_form').submit(function(e) {
        e.preventDefault();

        var gen_Term_sett = $('#gen_Term_sett').val();
        var gen_branch_sett = $('#gen_branch_sett').val();
        var gen_Session_sett = $('#gen_Session_sett').val();
        var annonc_sett = $('#annonc_sett').val();
        var gen_msg = $('#gen_msg').val();

        $.ajax({
            url: './admFunctions.php',
            type: "POST",
            dataType: 'json',
            data: {
                "term": gen_Term_sett,
                "branch": gen_branch_sett,
                "session": gen_Session_sett,
                "announcement": annonc_sett,
                "gen_msg":gen_msg,
                "type": "updateCurrentTerm"
            },
            success: function(response) {
                $.alert({
                    title: 'Message',
                    content: response.msg,
                    buttons: {
                        ok: function() {
                            window.location = './?curr_term';
                        }
                    }
                });
            },
            error: function(err) {
                console.log(err);
            }
        })
    })
})
</script>