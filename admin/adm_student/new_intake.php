<?php 
    $sqlSection = $conn->query("SELECT * FROM cbt_section");
    $allsection = $sqlSection->fetch_all(MYSQLI_ASSOC);
    $sqlSessionn = $conn->query("SELECT * FROM tblsession");
    $sqlTermm = $conn->query("SELECT * FROM cbt_term");
    $banks = $conn->query("SELECT * FROM cbt_bank");
    
    // $sqlStudStat = $conn->query("SELECT * FROM cbt_stud_status");
    $sqlTransArea = $conn->query("SELECT * FROM cbt_trans_area");
?>

<main class="main" id="main">
    <section class="section">
        <div class="card pb-2">
            <div class="card-body pb-2">

                <div class="row pt-2">
                    <div class="col-lg-12">
                        <h5 class="card-title text-center pt-1" id="formTitle">NEW INTAKE REGISTRATION</h5>
                    </div>
                </div>

                <div class="row pt-0">
                    <div class="col-lg-4">
                    </div>
                    <div class="col-lg-4 text-center mb-2">
                        <img src="../storege/students/no_image.jpg" id="img_of_stud" class="rounded-circle mx-4" alt=""
                            style="width: 5rem; height: 5rem;" />
                    </div>
                    <div class="col-lg-4">
                    </div>
                </div>

                <form action="" class="g-3 pt-2" id="stdRegForm" method="POST" enctype="multipart/form-data">
                    <!-- student details -->
                    <div class="row pb-2 gy-2">
                        <input type="hidden" id="created_by" value="<?= $name?>">
                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0" id="old_stud_ID" name="OLD_STUD_ID"
                                maxlength="4" placeholder="Old Stud ID" />
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0" id="Student_ID" name="Student_ID"
                                maxlength="3" placeholder="New Stud ID" />
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <input type="text" class="form-control pt-0" id="Fullnames" name="Fullnames" required
                                placeholder="Fullnames" />
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <select name="std_gender" id="std_gender" class="form-select pt-0" required>
                                <option>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <input type="date" class="form-control pt-0" id="std_dob" name="std_dob" required />
                        </div>
                    </div>

                    <!-- Select Status -->
                    <div class="row pb-2 gy-2">

                        <div class="col-lg-2 col-sm-12">
                            <select name="Std_Term" id="Std_Term" class="form-select pt-0" required>
                                <option value="0">Term Admitted</option>
                                <?php while($term = $sqlTermm->fetch_object()){?>
                                <option value="<?= $term->term?>"><?= $term->term?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <select name="Std_section" id="std_section" class="form-select pt-0" required>
                                <option value="0">Section Admitted</option>
                                <?php foreach($allsection as $section){?>
                                <option value="<?= $section['section']?>"><?= $section['section']?>
                                </option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <select name="std_Class" id="std_class" class="form-select pt-0" required>
                                <option value="0">Select Class</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <select name="std_branch" id="std_branch" class="form-select pt-0" required>
                                <option value="0">Select Branch</option>
                                <?php foreach($branches_rows as $branc){?>
                                <option value="<?= $branc['Branch_Name']?>"><?= $branc['Branch_Name']?>
                                </option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <input type="file" class="form-control pt-0" id="std_img" name="std_img" accept="image/*"
                                capture="environment" />
                        </div>
                    </div>
                    <!-- End student details -->

                    <!-- Parent/Guardian info -->
                    <div class="row pb-2 gy-2">

                        <div class="col-lg-4 col-sm-12">
                            <input type="text" class="form-control pt-0" id="Std_parent" name="Std_parent"
                                placeholder="Parent Name" required />
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <input type="text" class="form-control pt-0" id="std_phone" name="std_phone"
                                placeholder="Phone Number" required />
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <input type="text" class="form-control pt-0" id="Std_address" name="Std_address"
                                placeholder="Address" required />
                        </div>
                    </div>

                    <div class="row pb-2 gy-2">
                        <div class="col-lg-2 col-sm-12">
                            <select name="std_Session" id="std_Session" class="form-select pt-0" required>
                                <option value="0">Select Session</option>
                                <?php while($session = $sqlSessionn->fetch_object()){?>
                                <option value="<?= $session->csession?>"><?= $session->csession?>
                                </option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-lg-10 col-sm-12">
                            <input type="text" class="form-control pt-0" id="std_comment" name="std_comment"
                                placeholder="Comment" />
                        </div>
                    </div>

                    <div class="row pb-3 gy-3">
                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0" name="" value="Total Fee" disabled
                                readonly style="background:rgba(233, 240, 239, 0.93);" />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 fw-bold" id="total_fee"
                                name="paymentmade" data-bs-toggle="tooltip" data-bs-placement="top" title="Total Fee"
                                value="0" style="background:rgba(163, 235, 168, 0.93);" />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0" name="" value="Scholarship"
                                disabled readonly style="background:rgba(233, 240, 239, 0.93);" />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 fw-bold" id="scholarship"
                                name="paymentmade" data-bs-toggle="tooltip" data-bs-placement="top" title="Scholarship"
                                value="0" style="background:rgba(163, 235, 168, 0.93);" disabled />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 " name="paymentmade" value="Gen Dis"
                                disabled style="background:rgba(233, 240, 239, 0.93);" />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 fw-bold" id="discount"
                                name="discount" data-bs-toggle="tooltip" data-bs-placement="top" title="Discount"
                                value="0" style="background:rgba(163, 235, 168, 0.93);" disabled />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 " name="paymentmade"
                                value="Amt Payable" disabled style="background:rgba(233, 240, 239, 0.93);" />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 fw-bold" id="amt_payable"
                                name="amt_payable" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Amount Payable" value="0" style="background:rgba(163, 235, 168, 0.93);"
                                disabled />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 " name="paymentmade"
                                value="Amount Paid" disabled style="background:rgba(233, 240, 239, 0.93);" />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 fw-bold" id="amt_paid"
                                name="amt_paid" data-bs-toggle="tooltip" data-bs-placement="top" title="Amount Paid"
                                value="0" style="background:rgba(163, 235, 168, 0.93);" disabled />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 " name="Balance" value="Balance"
                                style="background:rgba(233, 240, 239, 0.93);" disabled />
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0  fw-bold" id="Balance"
                                name="Balance" data-bs-toggle="tooltip" data-bs-placement="top" title="Balance"
                                value="0" style="background:rgba(157, 197, 239, 0.93);" disabled />
                        </div>

                        <!-- Existing student -->
                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 " name="paymentmade"
                                value="Discount" disabled style="background:rgba(233, 240, 239, 0.93);" />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 fw-bold lock" id="discountExist"
                                name="discount" data-bs-toggle="tooltip" data-bs-placement="top" title="Discount"
                                value="" />
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 " name="paymentmade"
                                value="Amount Paid" disabled style="background:rgba(233, 240, 239, 0.93);" />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 fw-bold lock" id="paidExist"
                                name="paid" data-bs-toggle="tooltip" data-bs-placement="top" title="Paid" value="" />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <button type="button" style="width: 8.7rem;" class="btn btn-success w-100 mb-0"
                                id="add_payment" disabled>
                                Add Payment
                            </button>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <button type="submit" style="width: 8.7rem;" class="btn btn-success w-100 mb-0"
                                id="pay_exist_btn" value="Submit" disabled>
                                Update Recs
                            </button>
                        </div>


                        <div class="col-lg-2 col-sm-12">
                            <select name="pay_option" id="pay_option" class="form-select pt-0" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Payment Method" required>
                                <option value="0"> Pay Option</option>
                                <option value="Cash">Cash</option>
                                <option value="Bank">Bank</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <select id="bank_name" name="bank_name" class="form-select pt-0" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Staff Bank">
                                <option value="None">Select Bank</option>
                                <?php while($bank = $banks->fetch_object()){?>
                                <option value="<?= $bank->Bank_Name?>"><?= $bank->Bank_Name?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <input type="date" class="form-control pt-0" id="date_paid" name="date_paid" required />
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 fw-bold" id="sent_by" value="Empty"
                                disabled />
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <button type="submit" style="width: 8.7rem;" class="btn btn-primary w-100 mb-4"
                                id="stud_reg_btn" value="Submit">
                                Pay New
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- Receipt section -->
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title text-center"><strong><i>New Intake List</i></strong></h5>

                        <div class="row py-2">
                            <div class="col-lg-3 col-sm-12">
                                <select class="form-select" id="limit2">
                                    <option selected value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <p class="small pt-2">Per Page</p>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="input-group">
                                    <input type="text" placeholder="search" class="form-control" id="search2"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Search ID or Name">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                </div>
                            </div>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Branch</th>

                                    <th scope="col">Paid</th>
                                    <th scope="col">Bal</th>
                                    <th scope="col">Opt</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="unprinted">

                            </tbody>
                        </table>

                        <nav>
                            <ul class="pagination pagination-sm" id="pagination2">
                                <!-- Pagination buttons -->
                            </ul>
                        </nav>

                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-12">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title text-center"><strong><i>Pay History</i></strong></h5>

                        <div class="row py-2">
                            <div class="col-lg-3 col-sm-12">
                                <select class="form-select" id="limit2online">
                                    <option selected value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <p class="small pt-2">Per Page</p>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="input-group">
                                    <input type="text" placeholder="search" class="form-control" id="search2online"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Search ID or Name">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                </div>
                            </div>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">Paid</th>
                                    <th scope="col">Bal</th>
                                    <th scope="col">Opt</th>
                                    <th scope="col">Del</th>
                                </tr>
                            </thead>
                            <tbody id="unprintedonline">

                            </tbody>
                        </table>

                        <nav>
                            <ul class="pagination pagination-sm" id="pagination2online">
                                <!-- Pagination buttons -->
                            </ul>
                        </nav>

                    </div>
                </div>
            </div>

        </div>
        <!--END Receipt section -->
    </section>
</main>


<!-- jQuery functions -->
<script type="text/javascript">
$(document).ready(function() {

    $('#std_section').change(function() {
        var sect = $('#std_section').val();
        var gen_Term = $('#gen_Term').val();
        var gen_branch = $('#gen_branch').val();
        if (sect == 0) {
            $("#std_class").attr("disabled", true);
        } else {
            $("#std_class").removeAttr("disabled");
            $.ajax({
                // url: './admFunctions.php',
                url: '../admin/adm_student/new_intake_db.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    "type": "getClassFromSection",
                    "term": gen_Term,
                    "branch": gen_branch,
                    "section": sect
                },
                success: function(response) {
                    $('#std_class').html(response.html);
                    // $('#main').html(response.html);
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
    })

    $('#stdRegForm').on('submit', function(e) {
        e.preventDefault(); //

        //<!--New Intake details -->
        var Student_ID = $('#Student_ID').val();
        var old_stud_ID = $('#old_stud_ID').val();
        var Fullnames = $('#Fullnames').val();
        var std_gender = $('#std_gender').val();
        var std_dob = $('#std_dob').val();
        var std_Session = $('#std_Session').val();
        var Std_Term = $('#Std_Term').val();
        var std_section = $('#std_section').val();
        var std_class = $('#std_class').val();
        var std_branch = $('#std_branch').val();
        var std_img = $('#std_img')[0].files[0];
        var Std_parent = $('#Std_parent').val();
        var std_phone = $('#std_phone').val();
        var Std_address = $('#Std_address').val();
        var std_comment = $('#std_comment').val();
        var total_fee = $('#total_fee').val();
        var amt_payable = $('#amt_payable').val();
        var discount = $('#discountExist').val();
        var paid = $('#paidExist').val();
        // var Balance = $('#Balance').val();
        var method = $('#stud_reg_btn').val();
        var pay_option = $('#pay_option').val();
        var bank_name = $('#bank_name').val();
        var date_paid = $('#date_paid').val();
        var created_by = $('#created_by').val();


        var sdata = new FormData();
        // <!-- New Intake  details -->
        sdata.append("Student_ID", Student_ID);
        sdata.append("Fullnames", Fullnames);
        sdata.append("std_gender", std_gender);
        sdata.append("std_dob", std_dob);
        sdata.append("std_Session", std_Session);
        sdata.append("Std_Term", Std_Term);
        sdata.append("std_section", std_section);
        sdata.append("std_class", std_class);
        sdata.append("std_branch", std_branch);
        sdata.append("image", std_img);
        sdata.append("Std_parent", Std_parent);
        sdata.append("std_phone", std_phone);
        sdata.append("Std_address", Std_address);
        sdata.append("std_comment", std_comment);
        sdata.append("total_fee", total_fee);
        sdata.append("amt_payable", amt_payable);
        sdata.append("discount", discount);
        sdata.append("paid", paid);
        // sdata.append("Balance", Balance);
        sdata.append("method", method);
        sdata.append("pay_option", pay_option);
        sdata.append("bank_name", bank_name);
        sdata.append("date_paid", date_paid);
        sdata.append("created_by", created_by);
        sdata.append("type", "submitStdReg");


        if (std_branch == '0' || std_section == '0' || std_phone == '' || std_phone.length < 11 ||
            paid == '' || pay_option == '0' || date_paid == '') {
            $.confirm({
                icon: 'bi bi-patch-question',
                theme: 'bootstrap',
                title: 'Message',
                content: 'An important field is missing',
                animation: 'scale',
                type: 'orange'
            })
        } else {
            $.ajax({
                url: '../admin/adm_student/new_intake_db.php',
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                data: sdata,
                success: function(result) {
                    $.confirm({
                        icon: 'bi bi-patch-question',
                        theme: 'bootstrap',
                        title: 'Message',
                        content: result.msg,
                        animation: 'scale',
                        type: 'orange'
                    })
                    $('#hidID').val(result.lastID);
                    var lasid = result.lastID;
                },
                error: function(result) {
                    console.log(result);
                }
            })
            // Reset the form
            $('#stdRegForm').trigger('reset');
            $('#old_stud_ID').attr('disabled', false);
            $('#img_of_stud').attr("src", '../storege/students/no_image.jpg');
            $('#std_class').html('<option value="0">Select Class</option>');
        }
    })

    $('#pay_exist_btn').click(function(e) {
        e.preventDefault(); //

        //<!--New Intake details -->
        var Student_ID = $('#old_stud_ID').val();
        var Fullnames = $('#Fullnames').val();
        var std_class = $('#std_class').val();
        var std_branch = $('#std_branch').val();
        var std_comment = $('#std_comment').val();

        var total_fee = $('#total_fee').val();
        var scholarship = $('#scholarship').val();
        var discount = $('#discount').val();
        var amt_payable = $('#amt_payable').val();
        var amt_paid = $('#amt_paid').val();
        var Balance = $('#Balance').val();

        var pay_option = $('#pay_option').val();
        var bank_name = $('#bank_name').val();
        var date_paid = $('#date_paid').val();
        var created_by = $('#created_by').val();


        var sdata = new FormData();
        // <!-- New Intake  details -->
        sdata.append("Student_ID", Student_ID);
        sdata.append("Fullnames", Fullnames);
        sdata.append("std_class", std_class);
        sdata.append("std_branch", std_branch);
        sdata.append("std_comment", std_comment);

        sdata.append("total_fee", total_fee);
        sdata.append("scholarship", scholarship);
        sdata.append("discount", discount);
        sdata.append("amt_payable", amt_payable);
        sdata.append("amt_paid", amt_paid);
        sdata.append("Balance", Balance);

        sdata.append("pay_option", pay_option);
        sdata.append("bank_name", bank_name);
        sdata.append("date_paid", date_paid);
        sdata.append("created_by", created_by);
        sdata.append("type", "submitPayHistory");

        $.ajax({
            url: '../admin/adm_student/new_intake_db.php',
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: sdata,
            success: function(result) {
                $.confirm({
                    icon: 'bi bi-patch-question',
                    theme: 'bootstrap',
                    title: 'Message',
                    content: result.msg,
                    animation: 'scale',
                    type: 'orange'
                })
                $('#hidID').val(result.lastID);
                var lasid = result.lastID;
            },
            error: function(result) {
                console.log(result);
            }
        })
        // Reset the form
        $('#stdRegForm').trigger('reset');
        $('#img_of_stud').attr("src", '../storege/students/no_image.jpg');
        $('#Student_ID').attr('disabled', false);
        // }
    })

    function getDet(id) {
        $.ajax({
            url: '../admin/adm_student/new_intake_db.php',
            type: 'POST',
            dataType: 'json',
            data: {
                "student_ID": id,
                "type": "getStudentDetails"
            },
            success: function(response) {
                if (response.query == 'true') {
                    $('#Fullnames').val(response.Fullnames);
                    $('#std_dob').val(response.dob);
                    $('#std_gender').val(response.sex);
                    $('#Std_parent').val(response.parent_name);
                    $('#std_phone').val(response.phone);
                    $('#std_Session').val(response.session);
                    $('#Std_Term').val(response.term);
                    $('#std_section').val(response.Section);
                    $('#Std_address').val(response.address);
                    $('#std_comment').val(response.comment);
                    $('#std_branch').val(response.Branch);
                    $('#img_of_stud').attr("src", response.imgSrc);
                    $('#std_class').html(response.Class_html);

                    $('#total_fee').val(response.total_fee);
                    $('#amt_payable').val(response.payable);
                    $('#amt_paid').val(response.paid);
                    $('#Balance').val(response.balance);
                    $('#discount').val(response.discount);

                    $('#pay_option').val(response.pay_option);
                    $('#bank_name').val(response.bank_name);
                    $('#date_paid').val(response.date_paid);
                    $('#sent_by').val(response.created_by);
                    // $('#discountExist').attr('disabled', true);
                    $('#old_stud_ID').attr('disabled', true);
                    $('#formTitle').text('NEW INTAKE REGISTRATION');
                }
            },
            error: function(err) {
                console.log(err);
            }
        })
    }

    function getDetExist(id, pid) {
        $.ajax({
            url: '../admin/adm_student/new_intake_db.php',
            type: 'POST',
            dataType: 'json',
            data: {
                "student_ID": id,
                "pay_id": pid,
                "type": "getStudentDetailsExist"
            },
            success: function(response) {
                if (response.query == 'true') {
                    $('#Fullnames').val(response.Fullnames);
                    $('#std_dob').val(response.dob);
                    $('#std_gender').val(response.sex);
                    $('#Std_parent').val(response.parent_name);
                    $('#std_phone').val(response.phone);
                    $('#std_Session').val(response.session);
                    $('#Std_Term').val(response.term);
                    $('#std_section').val(response.Section);
                    $('#Std_address').val(response.address);
                    $('#std_comment').val(response.comment);
                    $('#std_branch').val(response.Branch);
                    $('#img_of_stud').attr("src", response.imgSrc);
                    $('#std_class').html(response.Class_html);

                    $('#total_fee').val(response.total_fee);
                    $('#scholarship').val(response.scholarship);
                    $('#discount').val(response.discount);
                    $('#amt_payable').val(response.amt_payable);
                    $('#amt_paid').val(response.amt_paid);
                    $('#Balance').val(response.Balance);

                    $('#pay_option').val(response.pay_option);
                    $('#bank_name').val(response.bank_name);
                    $('#date_paid').val(response.date_paid);
                    $('#sent_by').val(response.created_by);
                    // $('#payable').attr('disabled', true);
                    $('#paid').attr('disabled', true);
                    $('#formTitle').text('OLD STUDENT INFORMATION');
                    $('#add_payment').attr('disabled', true);
                }
            },
            error: function(err) {
                console.log(err);
            }
        })
    }

    //cleear form
    function clearForm() {
        $('#stdRegForm').trigger('reset');
        $('#stud_reg_btn').val('Submit');
        $('#stud_reg_btn').text('Pay New');
        $('#img_of_stud').attr("src", '../storege/students/no_image.jpg');
        $('#discountExist').attr('disabled', false);
        $('#paidExist').attr('disabled', false);
        $('#pay_exist_btn').attr('disabled', false);
        $('#payable').attr('disabled', false);
        $('#stud_reg_btn').attr('disabled', false);
        $('#pay_exist_btn').attr('disabled', true);
        $('#add_payment').attr('disabled', true);
        $('#formTitle').text('NEW INTAKE REGISTRATION');
        $('#std_class').html('<option value="0">Select Class</option>');
    }

    // Search / Update button
    $('#Student_ID').keyup(function(e) {
        var id = $(this).val();
        if (id.length == 3) {
            if (!isNaN(id) && id.trim() !== "") {
                $('#stud_reg_btn').val('Update');
                $('#stud_reg_btn').text('Update New');
                getDet(id);
                $('#payable').attr('disabled', false);
                $('#pay_exist_btn').attr('disabled', true);
                $('#stud_reg_btn').attr('disabled', false);
            }
        } else if (id.length == 0 || id == '') {
            clearForm();
            $('#std_class').html('<option value="0">Select Class</option>');
        }
    })

    $('#Student_ID').focus(function(e) {
        clearForm();
    })
    $('#old_stud_ID').focus(function(e) {
        clearForm();
    })

    $('.lock').keyup(function(e) {
        var lent = $(this).val();
        var olchk = $('#old_stud_ID').val();
        if (lent.length > 0 && olchk.length == 4) {
            $('#pay_exist_btn').attr('disabled', true);
            $('#add_payment').attr('disabled', false);
        }
        var disunlock = $('#discountExist').val();
        var paidunlock = $('#paidExist').val();
        if (disunlock.length == 0 && paidunlock == 0) {
            $('#add_payment').attr('disabled', true);
        }
        if (disunlock.length == 0 && paidunlock == 0 && olchk.length == 4) {
            $('#pay_exist_btn').attr('disabled', false);
        }
    })

    $('#discountExist').keyup(function(e) {
        var olchk = $('#old_stud_ID').val();
        var lent = $(this).val();
        if (lent.length > 0 && olchk.length == 4) {
            $('#pay_exist_btn').attr('disabled', true);
            $('#add_payment').attr('disabled', false);
        }
    })
    $('#paidExist').keyup(function(e) {
        var olchk = $('#old_stud_ID').val();
        var lent = $(this).val();
        if (lent.length > 0 && olchk.length == 4) {
            $('#pay_exist_btn').attr('disabled', true);
            $('#add_payment').attr('disabled', false);
        }
    })



    //Updating old student
    $('#old_stud_ID').keyup(function(e) {
        var id = $(this).val();
        if (id.length == 4) {
            if (!isNaN(id) && id.trim() !== "") {
                $('#pay_exist_btn').val('Update');
                $('#pay_exist_btn').text('Update Recs');
                getDetExist(id, 1);
                $('#payable').attr('disabled', true);
                $('#pay_exist_btn').attr('disabled', false);
                $('#stud_reg_btn').attr('disabled', true);
            }
        } else if (id.length == 0 || id == '') {
            clearForm();
            $('#std_class').html('<option value="0">Select Class</option>');
        }
    })


    // calculation
    $('#add_payment').click(function() {
        var checkoldID = $('#old_stud_ID').val();
        var discountExist = $('#discountExist').val();
        var paidExist = $('#paidExist').val();

        var Fullnames = $('#Fullnames').val();
        var pay_option = $('#pay_option').val();
        if (checkoldID.length < 4 && Fullnames == '') {
            $.confirm({
                icon: 'bi bi-patch-question',
                theme: 'bootstrap',
                title: 'Message',
                content: 'Please insert student ID',
                animation: 'scale',
                type: 'orange'
            })
        } else if (pay_option == '0') {
            $.confirm({
                icon: 'bi bi-patch-question',
                theme: 'bootstrap',
                title: 'Message',
                content: 'Please Select a payment option',
                animation: 'scale',
                type: 'orange'
            })
        } else {
            //calculating discount and amount paid
            var discountExist = parseInt($('#discountExist').val()) || 0;
            var paidExist = parseInt($('#paidExist').val()) || 0;
            var discount = parseInt($('#discount').val());
            var amt_paid = parseInt($('#amt_paid').val());
            $('#discount').val(discount + discountExist);
            $('#amt_paid').val(amt_paid + paidExist);

            // calculating amount payable
            var total_fee = parseInt($('#total_fee').val());
            var scholarship = parseInt($('#scholarship').val());
            var discount = parseInt($('#discount').val());
            var amt_paid = parseInt($('#amt_paid').val());
            $('#amt_payable').val(total_fee - scholarship - discount);

            // calculating balance
            var amt_payable = parseInt($('#amt_payable').val());
            var amt_paid = parseInt($('#amt_paid').val());
            $('#Balance').val(amt_payable - amt_paid);

            var studentID = $('#old_stud_ID').val();
            var Fullnames = $('#Fullnames').val();
            var std_class = $('#std_class').val();
            var std_branch = $('#std_branch').val();
            var std_comment = $('#std_comment').val();
            var upBal = $('#Balance').val();
            var pay_option = $('#pay_option').val();
            var bank_name = $('#bank_name').val();
            var date_paid = $('#date_paid').val();
            var created_by = $('#created_by').val();
            $.ajax({
                url: '../admin/adm_student/new_intake_db.php',
                type: 'POST',
                dataType: 'json',
                // processData: false,
                // contentType: false,
                data: {
                    "studentID": studentID,
                    "Fullnames": Fullnames,
                    "std_class": std_class,
                    "std_branch": std_branch,
                    "std_comment": std_comment,

                    "total_fee": total_fee,
                    "scholarship": scholarship,
                    "discount": discountExist,
                    "amt_payable": amt_payable,
                    "amt_paid": paidExist,
                    "Balance": upBal,

                    "pay_option": pay_option,
                    "bank_name": bank_name,
                    "date_paid": date_paid,
                    "created_by": created_by,

                    "type": "submitStudHistory"
                },
                success: function(result) {
                    $.confirm({
                        icon: 'bi bi-patch-question',
                        theme: 'bootstrap',
                        title: 'Message',
                        content: result.msg,
                        animation: 'scale',
                        type: 'orange'
                    })
                    $('#pay_exist_btn').attr('disabled', false);
                },
                error: function(result) {
                    console.log(result);
                }
            })

            //clearing 
            $('#discountExist').val('');
            $('#paidExist').val('');
            $('#add_payment').attr('disabled', true);
        }
        $('#Student_ID').attr('disabled', true);
    })



    /////
    $('#unprinted').on('click', '.intake', function(e) {
        var checkID = $('#Student_ID').val();
        var Fullnames = $('#Fullnames').val();
        if (checkID.length > 1 || Fullnames != '') {
            $.confirm({
                icon: 'bi bi-patch-question',
                theme: 'bootstrap',
                title: 'Message',
                content: 'There is work in progress...please complete',
                animation: 'scale',
                type: 'orange'
            })
        } else {
            var id = $(this).attr('data-id');
            $('#Student_ID').val(id);
            getDet(id);
            $('html,body').animate({scrollTop: 0}, 'fast');
        }
    })

    /////
    $('#unprinted').on('click', '.deleteIntake', function() {
        var qId = $(this).attr("data-Nid");
        var allowDel = $('#allowdel').val();
        if (allowDel == 1) {
            $.confirm({
                title: 'CONFIRM',
                content: 'Are you sure you want to delete these Intake?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-green',
                        text: 'Yes',
                        action: function() {
                            $.ajax({
                                url: '../admin/adm_student/new_intake_db.php',
                                type: "POST",
                                dataType: 'json',
                                data: {
                                    "ID": qId,
                                    "type": "delete_intake"
                                },
                                success: function(response) {
                                    $.alert({
                                        title: 'Message',
                                        content: response.msg,
                                        buttons: {
                                            ok: function() {
                                                location.reload(
                                                    true);
                                            }
                                        }
                                    });
                                },
                                error: function(err) {
                                    console.log(err);
                                }
                            })
                        }
                    },
                    cancelAction: {
                        btnClass: 'btn-red',
                        text: 'No',
                        close: function() {

                        }
                    },
                }
            });
        }
    })


    /////
    $('#unprintedonline').on('click', '.studHistory', function(e) {
        var checkoldID = $('#old_stud_ID').val();
        var Fullnames = $('#Fullnames').val();
        if (checkoldID.length > 1 || Fullnames != '') {
            $.confirm({
                icon: 'bi bi-patch-question',
                theme: 'bootstrap',
                title: 'Message',
                content: 'There is work in progress...please complete',
                animation: 'scale',
                type: 'orange'
            })
        } else {
            var id = $(this).attr('data-id');
            var pid = $(this).attr('data-dBid');
            $('#old_stud_ID').val(id);
            getDetExist(id, pid);
            $('html,body').animate({
                scrollTop: 0
            }, 'fast');
        }
    })
    /////
    $('#unprintedonline').on('click', '.deletestudHistory', function() {
        var qId = $(this).attr("data-Nid");
        var allowDel = $('#allowdel').val();
        if (allowDel == 1) {
            $.confirm({
                title: 'CONFIRM',
                content: 'Are you sure you want to delete these payment History?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-green',
                        text: 'Yes',
                        action: function() {
                            $.ajax({
                                url: '../admin/adm_student/new_intake_db.php',
                                type: "POST",
                                dataType: 'json',
                                data: {
                                    "ID": qId,
                                    "type": "delete_history"
                                },
                                success: function(response) {
                                    $.alert({
                                        title: 'Message',
                                        content: response.msg,
                                        buttons: {
                                            ok: function() {
                                                location.reload(
                                                    true);
                                            }
                                        }
                                    });
                                },
                                error: function(err) {
                                    console.log(err);
                                }
                            })
                        }
                    },
                    cancelAction: {
                        btnClass: 'btn-red',
                        text: 'No',
                        close: function() {

                        }
                    },
                }
            });
        }
    })
    /////


    ///////////////////////////
    function loadData2(page = 1, search = '') {
        const limit = $('#limit2').val();
        $.ajax({
            url: '../admin/adm_student/new_intake_db.php',
            type: 'POST',
            data: {
                "page2": page,
                "limit2": limit,
                "search2": search,
                "type": "paginateNewIntake"
            },
            dataType: 'json',
            success: function(response) {
                $('#unprinted').html(response.html);
                let pagination = '';
                // Previous Button
                pagination += `<li class="page-item ${response.currentPage == 1 ? 'disabled' : ''}">
                                <a class="page-link" href="#" data-page="${response.currentPage - 1}">&laquo;</a>
                              </li>`;
                // ===== Limit Page Numbers to Max 10 ===== //
                let start = response.currentPage - 4;
                let end = response.currentPage + 5;

                // Adjust if start or end goes out of bounds
                if (start < 1) {
                    end += 1 - start;
                    start = 1;
                }
                if (end > response.totalPages) {
                    start -= end - response.totalPages;
                    end = response.totalPages;
                }
                if (start < 1) start = 1;

                // Add page numbers from start to end
                for (let i = start; i <= end; i++) {
                    pagination += `<li class="page-item ${response.currentPage == i ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                      </li>`;
                }
                // Next Button
                pagination += `<li class="page-item ${response.currentPage == response.totalPages ? 'disabled' : ''}">
                                <a class="page-link" href="#" data-page="${response.currentPage + 1}">&raquo;</a>
                              </li>`;
                $('#pagination2').html(pagination);
            },
            error: function(err) {
                console.log(err);
            }
        });
    }
    // Initial load
    loadData2();
    // <!-- Pagination Click Event  -->
    $('#pagination2').on('click', '.page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        const search = $('#search2').val();
        if (page) {
            loadData2(page, search);
        }
    });
    // <!-- END Pagination Click Event  -->

    // <!-- Search Keyup Event (debounced)  -->
    let typingTimer2;
    $('#search2').on('keyup', function() {
        clearTimeout(typingTimer2);
        typingTimer2 = setTimeout(function() {
            loadData2(1, $('#search2').val());
        }, 500); // delay to avoid too many requests
    });
    // <!--END Search Keyup Event (debounced)  -->

    // <!-- 3 seconds calling  -->
    setInterval(() => {
        var activePge = parseInt($('#pagination2 li.active .page-link').text());
        if (isNaN(activePge)) {
            activePge = 1;
        }
        // console.log(activePge)
        var serch = $('#search2').val()
        loadData2(activePge, serch);
    }, 3000);
    // <!-- 3 seconds calling  -->


    ///////////////////////////
    function loadData2online(page = 1, search = '') {
        const limit = $('#limit2online').val();
        $.ajax({
            url: '../admin/adm_student/new_intake_db.php',
            type: 'POST',
            data: {
                "page2": page,
                "limit2": limit,
                "search2": search,
                "type": "paginateStudHistory"
            },
            dataType: 'json',
            success: function(response) {
                $('#unprintedonline').html(response.html);
                let pagination = '';
                // Previous Button
                pagination += `<li class="page-item ${response.currentPage == 1 ? 'disabled' : ''}">
                                <a class="page-link" href="#" data-page="${response.currentPage - 1}">&laquo;</a>
                              </li>`;
                // ===== Limit Page Numbers to Max 10 ===== //
                let start = response.currentPage - 4;
                let end = response.currentPage + 5;

                // Adjust if start or end goes out of bounds
                if (start < 1) {
                    end += 1 - start;
                    start = 1;
                }
                if (end > response.totalPages) {
                    start -= end - response.totalPages;
                    end = response.totalPages;
                }
                if (start < 1) start = 1;

                // Add page numbers from start to end
                for (let i = start; i <= end; i++) {
                    pagination += `<li class="page-item ${response.currentPage == i ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                      </li>`;
                }
                // Next Button
                pagination += `<li class="page-item ${response.currentPage == response.totalPages ? 'disabled' : ''}">
                                <a class="page-link" href="#" data-page="${response.currentPage + 1}">&raquo;</a>
                              </li>`;
                $('#pagination2online').html(pagination);
            },
            error: function(err) {
                console.log(err);
            }
        });
    }
    // Initial load
    loadData2online();
    // <!-- Pagination Click Event  -->
    $('#pagination2online').on('click', '.page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        const search = $('#search2online').val();
        if (page) {
            loadData2online(page, search);
        }
    });
    // <!-- END Pagination Click Event  -->

    // <!-- Search Keyup Event (debounced)  -->
    let typingTimer2online;
    $('#search2online').on('keyup', function() {
        clearTimeout(typingTimer2online);
        typingTimer2online = setTimeout(function() {
            loadData2online(1, $('#search2online').val());
        }, 500); // delay to avoid too many requests
    });
    // <!--END Search Keyup Event (debounced)  -->

    // <!-- 3 seconds calling  -->
    setInterval(() => {
        var activePge = parseInt($('#pagination2online li.active .page-link').text());
        if (isNaN(activePge)) {
            activePge = 1;
        }
        // console.log(activePge)
        var serch = $('#search2online').val()
        loadData2online(activePge, serch);
    }, 3000);
    // <!-- 3 seconds calling  -->

})
</script>