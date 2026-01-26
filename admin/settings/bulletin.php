<?php 
    
    $setupsSQL = $conn->query("SELECT * FROM setups");
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

?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">News Letter</h5>
                <form class="g-3" id="curr_bulletin_form" enctype="multipart/form-data">
                    <div class="row pb-3">
                        <input type="hidden" name="bulletin_id" id="bulletin_id" value="<?= $id?>">
                        <div class="col-lg-6 col-sm-12">
                            <label for="bulletin_title" class="form-label">Title</label>
                            <input type="text" name="bulletin_title" id="bulletin_title" class="form-control"
                                value="<?= $title?>">
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <label for="status_" class="form-label">Status</label>
                            <select name="status_" id="status_" class="form-control">
                                <option value="<?= $stat?>"><?= $stat?></option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <label for="bulletin_date" class="form-label">Date</label>
                            <input type="date" name="bulletin_date" id="bulletin_date" class="form-control"
                                value="<?= $date?>">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <div class="card position-relative rounded-4">
                            <embed src="<?=$linkPdf?>" type="application/pdf" width="100%" height="310px">
                        </div>
                    </div>
                    <div class="row gy-3">
                        <div class="col-lg-5 col-sm-5">
                            <label for="">Pdf File</label>
                            <input type="file" class="form-control" id="bulletin_pdf_file" name="pdf_file"
                                accept="application/pdf" />
                        </div>
                        <div class="col-lg-5 col-sm-5">
                            <label for="">Image File</label>
                            <input type="file" class="form-control" id="bulletin_image" name="imageFile"
                                accept="image/*" />
                        </div>
                        <div class="col-lg-2 col-sm-2">
                            <button type="submit" style="width: 8.5rem;" class="btn btn-primary w-100 mt-4" name="updateBulletin">
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
<script type="text/javascript">
$(document).ready(function() {
    $('#curr_bulletin_form').on('submit', function(e) {
        e.preventDefault();

        var bulletin_title = $('#bulletin_title').val();
        var status_ = $('#status_').val();
        var bulletin_date = $('#bulletin_date').val();
        var bulletin_pdf_file = $('#bulletin_pdf_file').prop('files')[0];
        var bulletin_image = $('#bulletin_image').prop('files')[0];
        var bulletin_id = $('#bulletin_id').val();
        var sdata = new FormData();
        sdata.append("bulletin_id", bulletin_id);
        sdata.append("bulletin_title", bulletin_title);
        sdata.append("status_", status_);
        sdata.append("bulletin_date", bulletin_date);
        if (bulletin_pdf_file != undefined) {
            sdata.append("file", bulletin_pdf_file);
        }
        if (bulletin_image != undefined) {
            sdata.append("bullet_img", bulletin_image);
        }
        sdata.append("type", "updateBulletin");

        $.ajax({
            url: './admFunctions.php',
            type: "POST",
            dataType: 'json',
            processData: false,
            contentType: false,
            data: sdata,
            success: function(response) {
                $.alert({
                    title: 'Message',
                    content: response.msg,
                    buttons: {
                        ok: function() {
                            window.location = './?bull_sett';
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